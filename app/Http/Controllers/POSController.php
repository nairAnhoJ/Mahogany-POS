<?php

namespace App\Http\Controllers;

use App\Mail\MailNotify;
use App\Models\Ingredient;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Ordered;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;


class POSController extends Controller {
    public function index() {

        $this->updateCurrentQuantity();
        $tables = DB::table('tables')->orderBy('id', 'asc')->where('is_deleted', 0)->get();
        $orders = DB::table('orders')->where('cashier', auth()->id())->orderBy('id', 'desc')->get();
        $menus = DB::table('menus')->where('current_quantity', '>=', 1)->where('is_deleted', 0)->orderBy('name', 'asc')->get();

        $categories = DB::table('menu_categories')->where('is_hidden', 0)->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $subTotal = 0;
        $total = 0;
        $discountRow = DB::table('discounts')->where('id', 1)->first();
        $discount = 0;
        if ($orders->count() > 0) {
            foreach ($orders as $order) {
                $subTotal = $subTotal + $order->total_price;
            }
            if ($discountRow->total_customer > 0) {
                $x = $subTotal / $discountRow->total_customer;
                $y = 0.2 * $discountRow->customer_with_discount;
                $discount = $x * $y;
            }
            $total = round($subTotal - $discount);
        }

        return view('user.cashier.pos', compact('tables', 'orders', 'discountRow', 'menus', 'categories', 'subTotal', 'total', 'discount'));
    }

    public function add(Request $request) {
        $this->updateCurrentQuantity();
        $slug = $request->slug;
        $menu = DB::table('menus')->where('slug', $slug)->first();
        $ord = DB::table('orders')->where('menu_id', $menu->id)->where('cashier', auth()->id())->first();
        $notif = '';

        $orderSlug = Str::random(60);
        $norderSlug = $orderSlug;
        $check_slug = DB::table('inventories')->where('slug', $norderSlug)->get();
        while (count($check_slug) > 0) {
            $norderSlug = Str::random(60);
            $check_slug = DB::table('inventories')->where('slug', $norderSlug)->get();
        }
        $orderSlug = $norderSlug;

        if ($menu->current_quantity > 0) {
            if ($ord != null) {
                if ($menu->current_quantity > 0) {
                    $quantity = $ord->quantity + 1;
                    $total_price = $menu->price * $quantity;
                    $current_quantity = $menu->current_quantity - 1;
                    DB::table('orders')->where('id', $ord->id)->delete();

                    $order = new Order();
                    $order->menu_id = $menu->id;
                    $order->name = $menu->name;
                    $order->quantity = $quantity;
                    $order->price = $menu->price;
                    $order->total_price = $total_price;
                    $order->current_stock = $current_quantity;
                    $order->cashier = auth()->id();
                    $order->slug = $orderSlug;
                    $order->save();

                    if ($menu->is_combo == 1) {
                        $ings = DB::table('ingredients')->where('menu_id', $menu->id)->get();
                        foreach ($ings as $ing) {
                            $decq = 1 * $ing->computed_quantity;
                            $curq = Menu::where('id', $ing->inventory_id)->first()->current_quantity;
                            $newq = $curq - $decq;

                            $updateMenu = Menu::where('id', $ing->inventory_id)->first();
                            $updateMenu->current_quantity = $newq;
                            $updateMenu->save();
                        }
                    } else {
                        DB::table('menus')->where('id', $menu->id)->update([
                            'current_quantity' => $current_quantity,
                        ]);
                    }
                } else {
                    $notif .= '
                    <div id="toast-danger" class="flex items-center w-full p-4 mb-4 text-gray-500 bg-red-200 border border-red-200 rounded-lg shadow-lg" role="alert">
                        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-200 rounded-lg">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">Error icon</span>
                        </div>
                        <div class="pr-10 ml-3 text-base font-medium">This menu is already out of stock.</div>
                        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8" data-dismiss-target="#toast-danger" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>';
                }
            } else {
                $quantity = 1;
                $total_price = $menu->price * $quantity;
                $current_quantity = $menu->current_quantity - 1;

                $order = new Order();
                $order->menu_id = $menu->id;
                $order->name = $menu->name;
                $order->quantity = $quantity;
                $order->price = $menu->price;
                $order->total_price = $total_price;
                $order->current_stock = $current_quantity;
                $order->cashier = auth()->id();
                $order->slug = $orderSlug;
                $order->save();

                if ($menu->is_combo == 1) {
                    $ings = DB::table('ingredients')->where('menu_id', $menu->id)->get();
                    foreach ($ings as $ing) {
                        $decq = $order->quantity * $ing->computed_quantity;
                        $curq = Menu::where('id', $ing->inventory_id)->first()->current_quantity;
                        $newq = $curq - $decq;

                        $updateMenu = Menu::where('id', $ing->inventory_id)->first();
                        $updateMenu->current_quantity = $newq;
                        $updateMenu->save();
                    }
                } else {
                    DB::table('menus')->where('id', $menu->id)->update([
                        'current_quantity' => $current_quantity,
                    ]);
                }
            }
        } else {
            $notif = '
            <div id="toast-danger" class="flex items-center w-full p-4 mb-4 text-gray-500 bg-red-200 border border-red-200 rounded-lg shadow-lg" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-200 rounded-lg">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Error icon</span>
                </div>
                <div class="pr-10 ml-3 text-base font-medium">This menu is already out of stock.</div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8" data-dismiss-target="#toast-danger" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>';
        }

        $orders = DB::table('orders')->where('cashier', auth()->id())->orderBy('id', 'desc')->get();
        $orderResult = '';
        $subTotal = 0;
        $total = 0;
        $discountRow = DB::table('discounts')->where('id', 1)->first();
        $discount = 0;
        if ($orders->count() > 0) {
            foreach ($orders as $order) {
                $orderResult .= '
                                    <div class="grid content-center w-full grid-cols-12 px-4 text-center h-14">
                                        <div class="flex items-center col-span-5 pr-2 text-xs font-semibold text-left">
                                            ' . $order->name . '
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <button data-slug="' . $order->slug . '" class="descQty aspect-square w-full max-w-[50px] bg-red-200 rounded-lg"><i class="text-xl text-red-900 uil uil-minus"></i></button>
                                        </div>
                                        <div class="flex items-center justify-center col-span-1">
                                            <p class="w-full text-sm font-semibold leading-7 text-center border-0 h-7">' . $order->quantity . '</p>
                                            <input type="hidden" value="' . $order->quantity . '">
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <button data-slug="' . $order->slug . '" class="incQty aspect-square w-full max-w-[50px] bg-emerald-200 rounded-lg"><i class="text-xl uil uil-plus text-emerald-900"></i></button>
                                        </div>
                                        <div class="flex items-center justify-center col-span-3 text-sm font-semibold">
                                            ' . number_format($order->total_price, 2, ".", ",") . '
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <button data-slug="' . $order->slug . '" data-name="' . $order->name . '" class="removeButton aspect-square w-full max-w-[50px] bg-red-600 rounded-lg"><i class="text-xl text-red-200 uil uil-times"></i></button>
                                        </div>
                                    </div>
                                ';
                $subTotal = $subTotal + $order->total_price;
            }
            if ($discountRow->total_customer > 0) {
                $x = $subTotal / $discountRow->total_customer;
                $y = 0.2 * $discountRow->customer_with_discount;
                $discount = $x * $y;
            }
            $total = round($subTotal - $discount);
        }

        $amount = $total;
        $this->updateCurrentQuantity();

        $response = array(
            'orders' => $orderResult,
            'subTotal' => number_format($subTotal, 2, '.', ','),
            'total' => number_format($total, 2, '.', ','),
            'thisNotif' => $notif,
            'amount' => $amount,
            'discount' => number_format($discount, 2, '.', ','),
            'ordersCount' => $orders->count()
        );

        echo json_encode($response);
    }

    public function inc(Request $request) {
        $this->updateCurrentQuantity();
        $slug = $request->slug;
        $corder = DB::table('orders')->where('slug', $slug)->first();

        $menu = DB::table('menus')->where('id', $corder->menu_id)->first();
        $notif = '';

        if ($menu->current_quantity > 0) {
            $quantity = $corder->quantity + 1;
            $total_price = $corder->price * $quantity;
            $current_stock = $menu->current_quantity - 1;
            DB::table('orders')->where('slug', $slug)->update([
                'quantity' => $quantity,
                'total_price' => $total_price,
                'current_stock' => $current_stock,
            ]);

            if ($menu->is_combo == 1) {
                $ings = DB::table('ingredients')->where('menu_id', $menu->id)->get();
                foreach ($ings as $ing) {
                    $decq = 1 * $ing->computed_quantity;
                    $curq = Menu::where('id', $ing->inventory_id)->first()->current_quantity;
                    $newq = $curq - $decq;

                    $updateMenu = Menu::where('id', $ing->inventory_id)->first();
                    $updateMenu->current_quantity = $newq;
                    $updateMenu->save();
                }
            } else {
                DB::table('menus')->where('id', $corder->menu_id)->update([
                    'current_quantity' => $current_stock,
                ]);
            }
        } else {
            $notif = '<div id="toast-danger" class="flex items-center w-full p-4 mb-4 text-gray-500 bg-red-200 border border-red-200 rounded-lg shadow-lg" role="alert">
                        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-200 rounded-lg">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">Error icon</span>
                        </div>
                        <div class="pr-10 ml-3 text-base font-medium">This menu is already out of stock.</div>
                        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8" data-dismiss-target="#toast-danger" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>';
        }

        $orders = DB::table('orders')->where('cashier', auth()->id())->orderBy('id', 'desc')->get();
        $orderResult = '';
        $subTotal = 0;
        $total = 0;
        $discountRow = DB::table('discounts')->where('id', 1)->first();
        $discount = 0;
        if ($orders->count() > 0) {
            foreach ($orders as $order) {
                $orderResult .= '
                                    <div class="grid content-center w-full grid-cols-12 px-4 text-center h-14">
                                        <div class="flex items-center col-span-5 pr-2 text-xs font-semibold text-left">
                                            ' . $order->name . '
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <button data-slug="' . $order->slug . '" class="descQty aspect-square w-full max-w-[50px] bg-red-200 rounded-lg"><i class="text-xl text-red-900 uil uil-minus"></i></button>
                                        </div>
                                        <div class="flex items-center justify-center col-span-1">
                                            <p class="w-full text-sm font-semibold leading-7 text-center border-0 h-7">' . $order->quantity . '</p>
                                            <input type="hidden" value="' . $order->quantity . '">
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <button data-slug="' . $order->slug . '" class="incQty aspect-square w-full max-w-[50px] bg-emerald-200 rounded-lg"><i class="text-xl uil uil-plus text-emerald-900"></i></button>
                                        </div>
                                        <div class="flex items-center justify-center col-span-3 text-sm font-semibold">
                                            ' . number_format($order->total_price, 2, ".", ",") . '
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <button data-slug="' . $order->slug . '" data-name="' . $order->name . '" class="removeButton aspect-square w-full max-w-[50px] bg-red-600 rounded-lg"><i class="text-xl text-red-200 uil uil-times"></i></button>
                                        </div>
                                    </div>
                                ';
                $subTotal = $subTotal + $order->total_price;
            }
            if ($discountRow->total_customer > 0) {
                $x = $subTotal / $discountRow->total_customer;
                $y = 0.2 * $discountRow->customer_with_discount;
                $discount = $x * $y;
            }
            $total = round($subTotal - $discount);
        }

        $amount = $total;

        $this->updateCurrentQuantity();

        $response = array(
            'thisNotif' => $notif,
            'orders' => $orderResult,
            'subTotal' => number_format($subTotal, 2, '.', ','),
            'total' => number_format($total, 2, '.', ','),
            'amount' => $amount,
            'discount' => number_format($discount, 2, '.', ','),
            'ordersCount' => $orders->count()
        );

        echo json_encode($response);
    }

    public function desc(Request $request) {
        $this->updateCurrentQuantity();
        $slug = $request->slug;
        $corder = DB::table('orders')->where('slug', $slug)->first();
        $menu = DB::table('menus')->where('id', $corder->menu_id)->first();

        if ($corder->quantity > 1) {
            $quantity = $corder->quantity - 1;
            $total_price = $corder->price * $quantity;
            $current_quantity = $corder->current_stock + 1;
            DB::table('orders')->where('slug', $slug)->update([
                'quantity' => $quantity,
                'total_price' => $total_price,
                'current_stock' => $current_quantity,
            ]);

            if ($menu->is_combo == 1) {
                $ings = DB::table('ingredients')->where('menu_id', $menu->id)->get();
                foreach ($ings as $ing) {
                    $decq = 1 * $ing->computed_quantity;
                    $curq = Menu::where('id', $ing->inventory_id)->first()->current_quantity;
                    $newq = $curq + $decq;

                    $updateMenu = Menu::where('id', $ing->inventory_id)->first();
                    $updateMenu->current_quantity = $newq;
                    $updateMenu->save();
                }
            } else {
                DB::table('menus')->where('id', $corder->menu_id)->update([
                    'current_quantity' => $current_quantity,
                ]);
            }
        }

        $orders = DB::table('orders')->where('cashier', auth()->id())->orderBy('id', 'desc')->get();
        $orderResult = '';
        $subTotal = 0;
        $total = 0;
        $discountRow = DB::table('discounts')->where('id', 1)->first();
        $discount = 0;
        if ($orders->count() > 0) {
            foreach ($orders as $order) {
                $orderResult .= '
                                    <div class="grid content-center w-full grid-cols-12 px-4 text-center h-14">
                                        <div class="flex items-center col-span-5 pr-2 text-xs font-semibold text-left">
                                            ' . $order->name . '
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <button data-slug="' . $order->slug . '" class="descQty aspect-square w-full max-w-[50px] bg-red-200 rounded-lg"><i class="text-xl text-red-900 uil uil-minus"></i></button>
                                        </div>
                                        <div class="flex items-center justify-center col-span-1">
                                            <p class="w-full text-sm font-semibold leading-7 text-center border-0 h-7">' . $order->quantity . '</p>
                                            <input type="hidden" value="' . $order->quantity . '">
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <button data-slug="' . $order->slug . '" class="incQty aspect-square w-full max-w-[50px] bg-emerald-200 rounded-lg"><i class="text-xl uil uil-plus text-emerald-900"></i></button>
                                        </div>
                                        <div class="flex items-center justify-center col-span-3 text-sm font-semibold">
                                            ' . number_format($order->total_price, 2, ".", ",") . '
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <button data-slug="' . $order->slug . '" data-name="' . $order->name . '" class="removeButton aspect-square w-full max-w-[50px] bg-red-600 rounded-lg"><i class="text-xl text-red-200 uil uil-times"></i></button>
                                        </div>
                                    </div>
                                ';
                $subTotal = $subTotal + $order->total_price;
            }
            if ($discountRow->total_customer > 0) {
                $x = $subTotal / $discountRow->total_customer;
                $y = 0.2 * $discountRow->customer_with_discount;
                $discount = $x * $y;
            }
            $total = round($subTotal - $discount);
        }

        $amount = $total;

        $this->updateCurrentQuantity();

        $response = array(
            'orders' => $orderResult,
            'subTotal' => number_format($subTotal, 2, '.', ','),
            'total' => number_format($total, 2, '.', ','),
            'amount' => $amount,
            'discount' => number_format($discount, 2, '.', ','),
            'ordersCount' => $orders->count()
        );

        echo json_encode($response);
    }

    public function remove(Request $request) {
        $this->updateCurrentQuantity();
        $slug = $request->slug;
        $ord = DB::table('orders')->where('slug', $slug)->first();
        $mid = $ord->menu_id;
        $menu = DB::table('menus')->where('id', $mid)->first();
        $qty = $ord->quantity;

        if ($menu->is_combo == 1) {
            $ings = DB::table('ingredients')->where('menu_id', $menu->id)->get();
            foreach ($ings as $ing) {
                $decq = $qty * $ing->computed_quantity;
                $curq = Menu::where('id', $ing->inventory_id)->first()->current_quantity;
                $newq = $curq + $decq;

                $updateMenu = Menu::where('id', $ing->inventory_id)->first();
                $updateMenu->current_quantity = $newq;
                $updateMenu->save();
            }
        } else {
            DB::table('menus')
                ->where('id', $mid)
                ->increment('current_quantity', $qty);
        }

        // $oqty = $menu->current_quantity;
        // $nqty = $oqty + $qty;

        // DB::table('menus')->where('id', $mid)->update([
        //     'current_quantity' => $nqty,
        // ]);

        DB::table('orders')->where('slug', $slug)->delete();

        $orders = DB::table('orders')->where('cashier', auth()->id())->orderBy('id', 'desc')->get();
        $orderResult = '';
        $subTotal = 0;
        $total = 0;
        $discountRow = DB::table('discounts')->where('id', 1)->first();
        $discount = 0;
        if ($orders->count() > 0) {
            foreach ($orders as $order) {
                $orderResult .= '
                                    <div class="grid content-center w-full grid-cols-12 px-4 text-center h-14">
                                        <div class="flex items-center col-span-5 pr-2 text-xs font-semibold text-left">
                                            ' . $order->name . '
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <button data-slug="' . $order->slug . '" class="w-full bg-red-200 rounded-lg descQty aspect-square"><i class="text-xl text-red-900 uil uil-minus"></i></button>
                                        </div>
                                        <div class="flex items-center justify-center col-span-1">
                                            <p class="w-full text-sm font-semibold leading-7 text-center border-0 h-7">' . $order->quantity . '</p>
                                            <input type="hidden" value="' . $order->quantity . '">
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <button data-slug="' . $order->slug . '" class="w-full rounded-lg incQty aspect-square bg-emerald-200"><i class="text-xl uil uil-plus text-emerald-900"></i></button>
                                        </div>
                                        <div class="flex items-center justify-center col-span-3 text-sm font-semibold">
                                            ' . number_format($order->total_price, 2, ".", ",") . '
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <button data-slug="' . $order->slug . '" data-name="' . $order->name . '" class="w-full bg-red-600 rounded-lg removeButton aspect-square"><i class="text-xl text-red-200 uil uil-times"></i></button>
                                        </div>
                                    </div>
                                ';
                $subTotal = $subTotal + $order->total_price;
            }
            if ($discountRow->total_customer > 0) {
                $x = $subTotal / $discountRow->total_customer;
                $y = 0.2 * $discountRow->customer_with_discount;
                $discount = $x * $y;
            }
            $total = round($subTotal - $discount);
        }

        $amount = $total;
        $this->updateCurrentQuantity();

        $response = array(
            'orders' => $orderResult,
            'subTotal' => number_format($subTotal, 2, '.', ','),
            'total' => number_format($total, 2, '.', ','),
            'amount' => $amount,
            'discount' => number_format($discount, 2, '.', ','),
            'ordersCount' => $orders->count()
        );

        echo json_encode($response);
    }

    public function pay(Request $request) {
        $amount = $request->amount;
        $table = $request->table;
        $amountInput = $request->amountInput;
        $mop = $request->mop;
        $payor_name = $request->payor_name;
        $payor_number = $request->payor_number;
        $settings = DB::table('settings')->where('id', 1)->first();

        if ($table == 1) {
            $type = 'TAKE OUT';
        } else {
            $type = 'DINE-IN';
        }

        $id = Transaction::latest()->pluck('id')->first();
        if ($id == null) {
            $id = 1;
        } else {
            $id++;
        }
        $nid = str_pad($id, 7, '0', STR_PAD_LEFT);

        $number = date('mdY') . '-' . $nid;

        $tranSlug = Str::random(60);
        $ntranSlug = $tranSlug;
        $check_slug = DB::table('transactions')->where('slug', $ntranSlug)->get();
        while (count($check_slug) > 0) {
            $ntranSlug = Str::random(60);
            $check_slug = DB::table('transactions')->where('slug', $ntranSlug)->get();
        }
        $tranSlug = $ntranSlug;

        $tran = new Transaction();
        $tran->number = $number;
        $tran->total = $amount + $settings->service_charge;
        $tran->service_charge = $settings->service_charge;
        $tran->mode_of_payment = $mop;
        $tran->amount = $amountInput;
        $tran->payor_name = ucfirst($payor_name);
        $tran->payor_number = $payor_number;
        $tran->type = $type;
        $tran->table = $table;
        $tran->status = 'PAID';
        $tran->order_status = 'PREPARING';
        $tran->cashier = auth()->id();
        $tran->slug = $tranSlug;
        $tran->save();

        $tran_id = $tran->id;

        $orders = DB::table('orders')->where('cashier', auth()->id())->get();
        foreach ($orders as $order) {
            $orderSlug = Str::random(60);
            $norderSlug = $orderSlug;
            $check_slug = DB::table('ordered')->where('slug', $norderSlug)->get();
            while (count($check_slug) > 0) {
                $norderSlug = Str::random(60);
                $check_slug = DB::table('ordered')->where('slug', $norderSlug)->get();
            }
            $orderSlug = $norderSlug;

            DB::table('ordered')->insert([
                'tran_id' => $tran_id,
                'menu_id' => $order->menu_id,
                'quantity' => $order->quantity,
                'amount' => $order->total_price,
                'status' => 'PREPARING',
                'slug' => $orderSlug,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ]);

            $menu = DB::table('menus')->where('id', $order->menu_id)->first();

            if ($menu->is_combo == 1) {
                $ings = DB::table('ingredients')->where('menu_id', $menu->id)->get();
                foreach ($ings as $ing) {
                    $decq = $order->quantity * $ing->computed_quantity;
                    $curq = Menu::where('id', $ing->inventory_id)->first()->quantity;
                    $newq = $curq - $decq;

                    $updateMenu = Menu::where('id', $ing->inventory_id)->first();
                    $updateMenu->quantity = $newq;
                    $updateMenu->save();
                }
            } else {
                DB::table('menus')
                    ->where('id', $order->menu_id)
                    ->decrement('quantity', $order->quantity);
            }

            DB::table('orders')->where('id', $order->id)->delete();
        }

        $orders = DB::table('orders')->where('cashier', auth()->id())->orderBy('id', 'desc')->get();
        $orderResult = '';
        $subTotal = 0;
        $total = 0;
        foreach ($orders as $order) {
            $orderResult .= '
                                <div class="grid content-center w-full grid-cols-12 px-4 text-center h-14">
                                    <div class="flex items-center col-span-5 pr-2 text-xs font-semibold text-left">
                                        ' . $order->name . '
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="' . $order->slug . '" class="w-full bg-red-200 rounded-lg descQty aspect-square"><i class="text-xl text-red-900 uil uil-minus"></i></button>
                                    </div>
                                    <div class="flex items-center justify-center col-span-1">
                                        <p class="w-full text-sm font-semibold leading-7 text-center border-0 h-7">' . $order->quantity . '</p>
                                        <input type="hidden" value="' . $order->quantity . '">
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="' . $order->slug . '" class="w-full rounded-lg incQty aspect-square bg-emerald-200"><i class="text-xl uil uil-plus text-emerald-900"></i></button>
                                    </div>
                                    <div class="flex items-center justify-center col-span-3 text-sm font-semibold">
                                        ' . number_format($order->total_price, 2, ".", ",") . '
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="' . $order->slug . '" data-name="' . $order->name . '" class="w-full bg-red-600 rounded-lg removeButton aspect-square"><i class="text-xl text-red-200 uil uil-times"></i></button>
                                    </div>
                                </div>
                            ';

            $subTotal = $subTotal + $order->total_price;
            $total = $total + $order->total_price;
            $amount = $total + $order->total_price;
        }

        if ($table > 1) {
            DB::table('tables')->where('id', $table)->update([
                'status' => 1
            ]);
        }

        $amount = $total;

        DB::table('discounts')->where('id', 1)->update([
            'customer_with_discount' => 0,
            'total_customer' => 0,
        ]);

        $response = array(
            'orders' => $orderResult,
            'subTotal' => number_format($subTotal, 2, '.', ','),
            'total' => number_format($total, 2, '.', ','),
            'amount' => $amount
        );

        echo json_encode($response);
    }

    public function paylater(Request $request) {
        $amount = $request->amount;
        $table = $request->table;
        $payor_name = $request->payor_name;
        $payor_number = $request->payor_number;
        $type = 'DINE-IN';


        $this_tran = DB::table('transactions')->where('table', $table)->where('status', 'UNPAID')->where('order_status', '!=', 'CANCELLED')->where('order_status', '!=', 'COMPLETED')->first();
        if ($this_tran) {
            $tran_id = $this_tran->id;

            DB::table('transactions')->where('id', $tran_id)->increment('total', $amount);
        } else {

            $id = Transaction::latest()->pluck('id')->first();
            if ($id == null) {
                $id = 1;
            } else {
                $id++;
            }
            $nid = str_pad($id, 7, '0', STR_PAD_LEFT);

            $number = date('mdY') . '-' . $nid;

            $tranSlug = Str::random(60);
            $ntranSlug = $tranSlug;
            $check_slug = DB::table('transactions')->where('slug', $ntranSlug)->get();
            while (count($check_slug) > 0) {
                $ntranSlug = Str::random(60);
                $check_slug = DB::table('transactions')->where('slug', $ntranSlug)->get();
            }
            $tranSlug = $ntranSlug;

            $tran = new Transaction();
            $tran->number = $number;
            $tran->total = $amount;
            $tran->payor_name = ucfirst($payor_name);
            $tran->payor_number = $payor_number;
            $tran->type = $type;
            $tran->table = $table;
            $tran->status = 'UNPAID';
            $tran->order_status = 'PREPARING';
            $tran->cashier = auth()->id();
            $tran->slug = $tranSlug;
            $tran->save();

            $tran_id = $tran->id;
        }

        $orders = DB::table('orders')->where('cashier', auth()->id())->get();
        foreach ($orders as $order) {
            $orderSlug = Str::random(60);
            $norderSlug = $orderSlug;
            $check_slug = DB::table('ordered')->where('slug', $norderSlug)->get();
            while (count($check_slug) > 0) {
                $norderSlug = Str::random(60);
                $check_slug = DB::table('ordered')->where('slug', $norderSlug)->get();
            }
            $orderSlug = $norderSlug;

            DB::table('ordered')->insert([
                'tran_id' => $tran_id,
                'menu_id' => $order->menu_id,
                'quantity' => $order->quantity,
                'amount' => $order->total_price,
                'status' => 'PREPARING',
                'slug' => $orderSlug,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ]);

            $menu = DB::table('menus')->where('id', $order->menu_id)->first();

            if ($menu->is_combo == 1) {
                $ings = DB::table('ingredients')->where('menu_id', $menu->id)->get();
                foreach ($ings as $ing) {
                    $decq = $order->quantity * $ing->computed_quantity;
                    $curq = Menu::where('id', $ing->inventory_id)->first()->quantity;
                    $newq = $curq - $decq;

                    $updateMenu = Menu::where('id', $ing->inventory_id)->first();
                    $updateMenu->quantity = $newq;
                    $updateMenu->save();
                }
            } else {
                DB::table('menus')
                    ->where('id', $order->menu_id)
                    ->decrement('quantity', $order->quantity);
            }

            DB::table('orders')->where('id', $order->id)->delete();
        }

        $orders = DB::table('orders')->where('cashier', auth()->id())->orderBy('id', 'desc')->get();
        $orderResult = '';
        $subTotal = 0;
        $total = 0;
        foreach ($orders as $order) {
            $orderResult .= '
                                <div class="grid content-center w-full grid-cols-12 px-4 text-center h-14">
                                    <div class="flex items-center col-span-5 pr-2 text-xs font-semibold text-left">
                                        ' . $order->name . '
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="' . $order->slug . '" class="w-full bg-red-200 rounded-lg descQty aspect-square"><i class="text-xl text-red-900 uil uil-minus"></i></button>
                                    </div>
                                    <div class="flex items-center justify-center col-span-1">
                                        <p class="w-full text-sm font-semibold leading-7 text-center border-0 h-7">' . $order->quantity . '</p>
                                        <input type="hidden" value="' . $order->quantity . '">
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="' . $order->slug . '" class="w-full rounded-lg incQty aspect-square bg-emerald-200"><i class="text-xl uil uil-plus text-emerald-900"></i></button>
                                    </div>
                                    <div class="flex items-center justify-center col-span-3 text-sm font-semibold">
                                        ' . number_format($order->total_price, 2, ".", ",") . '
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="' . $order->slug . '" data-name="' . $order->name . '" class="w-full bg-red-600 rounded-lg removeButton aspect-square"><i class="text-xl text-red-200 uil uil-times"></i></button>
                                    </div>
                                </div>
                            ';

            $subTotal = $subTotal + $order->total_price;
            $total = $total + $order->total_price;
            $amount = $total + $order->total_price;
        }

        DB::table('tables')->where('id', $table)->update([
            'status' => 1
        ]);

        $amount = $total;

        DB::table('discounts')->where('id', 1)->update([
            'customer_with_discount' => 0,
            'total_customer' => 0,
        ]);

        $response = array(
            'orders' => $orderResult,
            'subTotal' => number_format($subTotal, 2, '.', ','),
            'total' => number_format($total, 2, '.', ','),
            'amount' => $amount
        );

        echo json_encode($response);
    }

    public function updateDiscount(Request $request) {
        $customer_with_discount = ltrim($request->customer_with_discount, '0');
        $total_customer = ltrim($request->total_customer, '0');

        DB::table('discounts')->where('id', 1)->update([
            'customer_with_discount' => $customer_with_discount,
            'total_customer' => $total_customer,
        ]);

        return redirect()->route('pos.index');
    }

    public function deleteDiscount() {
        DB::table('discounts')->where('id', 1)->update([
            'customer_with_discount' => 0,
            'total_customer' => 0,
        ]);

        return redirect()->route('pos.index');
    }

    public function send() {
        $emailTo = (DB::table('settings')->where('id', 1)->first())->email;

        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime('+1 day'));

        $salesQuery = DB::table('transactions')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as stotal'),
                DB::raw('0 as etotal')
            )
            ->where('status', 'PAID')
            ->where('order_status', '!=', 'CANCELLED')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date');

        $expensesQuery = DB::table('inventory_transactions')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('0 as stotal'),
                DB::raw('SUM(amount) as etotal')
            )
            ->where('type', 'INCOMING')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date');

        $data = $salesQuery->union($expensesQuery)->orderBy('date')->get();

        Mail::to($emailTo)
            ->send(new MailNotify($data));

        return redirect()->route('pos.index');
    }

    public function print($id) {
        $trans = DB::table('transactions')
            ->select('transactions.*', 'tables.name as table_name')
            ->join('tables', 'transactions.table', '=', 'tables.id')
            ->where('transactions.table', $id)
            ->where('transactions.order_status', '!=', 'CANCELLED')
            ->where('transactions.order_status', '!=', 'COMPLETED')
            ->orderBy('id', 'desc')
            ->first();

        $orders = DB::table('ordered')
            ->select('ordered.*', 'menus.name')
            ->join('menus', 'ordered.menu_id', '=', 'menus.id')
            ->where('tran_id', $trans->id)
            ->get();


        $settings = DB::table('settings')->where('id', 1)->first();


        return view('user.cashier.bill', compact('orders', 'trans', 'settings'));
    }

    public function updateCurrentQuantity() {

        $comboMenus = Menu::where('is_combo', 1)->where('is_deleted', 0)->get();

        foreach ($comboMenus as $comboMenu) {
            $ingredients = Ingredient::where('menu_id', $comboMenu->id)->where('is_deleted', 0)->get();

            if ($ingredients->count() == 0) {
                $minQuantity = 0;
                $cminQuantity = 0;
            } else {
                $minQuantity = PHP_INT_MAX;
                $cminQuantity = PHP_INT_MAX;
            }

            foreach ($ingredients as $ingredient) {
                $inventoryQuantity = $ingredient->menu->quantity;
                $requiredQuantity = $ingredient->quantity;
                $availableCombos = floor($inventoryQuantity / $requiredQuantity);
                $minQuantity = min($minQuantity, $availableCombos);

                $cinventoryQuantity = $ingredient->menu->current_quantity;
                $crequiredQuantity = $ingredient->quantity;
                $cavailableCombos = floor($cinventoryQuantity / $crequiredQuantity);
                $cminQuantity = min($cminQuantity, $cavailableCombos);
            }

            $comboMenu->update([
                'quantity' => $minQuantity,
                'current_quantity' => $cminQuantity,
            ]);
        }
    }
}
