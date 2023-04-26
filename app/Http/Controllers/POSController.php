<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Ordered;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class POSController extends Controller
{
    public function index(){
        $tables = DB::table('tables')->orderBy('name', 'asc')->get();
        $orders = DB::table('orders')->where('cashier', auth()->id())->orderBy('id', 'desc')->get();
        $menus = DB::table('menus')->where('current_quantity', '>', 0)->orderBy('name', 'asc')->get();
        $categories = DB::table('menu_categories')->orderBy('name', 'asc')->get();
        $subTotal = 0;
        $total = 0;
        foreach($orders as $order){
            $subTotal = $subTotal + $order->total_price;
            $total = $total + $order->total_price;
        }

        return view('user.cashier.pos', compact('tables', 'orders', 'menus', 'categories', 'subTotal', 'total'));
    }

    public function add(Request $request){
        $slug = $request->slug;
        $menu = DB::table('menus')->where('slug', $slug)->first();
        $ord = DB::table('orders')->where('menu_id', $menu->id)->first();
        $notif = '';

        $orderSlug = Str::random(60);
        $norderSlug = $orderSlug;
        $check_slug = DB::table('inventories')->where('slug', $norderSlug)->get();
        while(count($check_slug) > 0){
            $norderSlug = Str::random(60);
            $check_slug = DB::table('inventories')->where('slug', $norderSlug)->get();
        }
        $orderSlug = $norderSlug;

        if($menu->current_quantity > 0){
            if($ord != null){
                if($menu->current_quantity > 0){
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

                    DB::table('menus')->where('id', $menu->id)->update([
                        'current_quantity' => $current_quantity,
                    ]);
                }else{
                    $notif .= '
                    <div id="toast-danger" class="flex items-center w-full p-4 mb-4 text-gray-500 bg-red-200 rounded-lg shadow-lg border border-red-200" role="alert">
                        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-200 rounded-lg">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">Error icon</span>
                        </div>
                        <div class="ml-3 pr-10 text-base font-medium">This menu is already out of stock.</div>
                        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8" data-dismiss-target="#toast-danger" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>';
                }
            }else{
                $quantity = 1;
                $total_price = $menu->price * $quantity;
                $current_quantity = $menu->current_quantity - $quantity;
                    
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

                DB::table('menus')->where('id', $menu->id)->update([
                    'current_quantity' => $current_quantity,
                ]);
            }
        }else{
            $notif = '
            <div id="toast-danger" class="flex items-center w-full p-4 mb-4 text-gray-500 bg-red-200 rounded-lg shadow-lg border border-red-200" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-200 rounded-lg">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Error icon</span>
                </div>
                <div class="ml-3 pr-10 text-base font-medium">This menu is already out of stock.</div>
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
        foreach($orders as $order){
            $orderResult .= '
                                <div class="grid grid-cols-12 content-center h-14 w-full text-center px-4">
                                    <div class="col-span-5 text-xs font-semibold text-left flex items-center pr-2">
                                        '.$order->name.'
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="'.$order->slug.'" class="descQty aspect-square w-full bg-red-200 rounded-lg"><i class="uil uil-minus text-xl text-red-900"></i></button>
                                    </div>
                                    <div class="col-span-1 flex items-center justify-center">
                                        <p class="w-full text-center text-sm font-semibold border-0 h-7 leading-7">'.$order->quantity.'</p>
                                        <input type="hidden" value="'.$order->quantity.'">
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="'.$order->slug.'" class="incQty aspect-square w-full bg-emerald-200 rounded-lg"><i class="uil uil-plus text-xl text-emerald-900"></i></button>
                                    </div>
                                    <div class="col-span-3 flex items-center text-sm font-semibold justify-center">
                                        '.number_format($order->total_price, 2, ".", ",").'
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="'.$order->slug.'" data-name="'.$order->name.'" class="removeButton aspect-square w-full bg-red-600 rounded-lg"><i class="uil uil-times text-xl text-red-200"></i></button>
                                    </div>
                                </div>
                            ';
            
            $subTotal = $subTotal + $order->total_price;
            $total = $total + $order->total_price;
        }

        $amount = $total;

        $response = array(
            'orders' => $orderResult,
            'subTotal' => number_format($subTotal, 2, '.', ','),
            'total' => number_format($total, 2, '.', ','),
            'thisNotif' => $notif,
            'amount' => $amount
        );

        echo json_encode($response);
    }

    public function inc(Request $request){
        $slug = $request->slug;
        $corder = DB::table('orders')->where('slug', $slug)->first();
        $menu_qty = (DB::table('menus')->where('id', $corder->menu_id)->first())->current_quantity;
        $notif = '';

        if($menu_qty > 0){
            $quantity = $corder->quantity + 1;
        }else{
            $quantity = $corder->quantity;
            $notif = '<div id="toast-danger" class="flex items-center w-full p-4 mb-4 text-gray-500 bg-red-200 rounded-lg shadow-lg border border-red-200" role="alert">
                        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-200 rounded-lg">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">Error icon</span>
                        </div>
                        <div class="ml-3 pr-10 text-base font-medium">This menu is already out of stock.</div>
                        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8" data-dismiss-target="#toast-danger" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>';
        }
        $total_price = $corder->price * $quantity;
        $current_quantity = $corder->current_stock - 1;
        DB::table('orders')->where('slug', $slug)->update([
            'quantity' => $quantity,
            'total_price' => $total_price,
            'current_stock' => $current_quantity,
        ]);

        DB::table('menus')->where('id', $corder->menu_id)->update([
            'current_quantity' => $current_quantity,
        ]);

        $orders = DB::table('orders')->where('cashier', auth()->id())->orderBy('id', 'desc')->get();
        $orderResult = '';
        $subTotal = 0;
        $total = 0;
        foreach($orders as $order){
            $orderResult .= '
                                <div class="grid grid-cols-12 content-center h-14 w-full text-center px-4">
                                    <div class="col-span-5 text-xs font-semibold text-left flex items-center pr-2">
                                        '.$order->name.'
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="'.$order->slug.'" class="descQty aspect-square w-full bg-red-200 rounded-lg"><i class="uil uil-minus text-xl text-red-900"></i></button>
                                    </div>
                                    <div class="col-span-1 flex items-center justify-center">
                                        <p class="w-full text-center text-sm font-semibold border-0 h-7 leading-7">'.$order->quantity.'</p>
                                        <input type="hidden" value="'.$order->quantity.'">
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="'.$order->slug.'" class="incQty aspect-square w-full bg-emerald-200 rounded-lg"><i class="uil uil-plus text-xl text-emerald-900"></i></button>
                                    </div>
                                    <div class="col-span-3 flex items-center text-sm font-semibold justify-center">
                                        '.number_format($order->total_price, 2, ".", ",").'
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="'.$order->slug.'" data-name="'.$order->name.'" class="removeButton aspect-square w-full bg-red-600 rounded-lg"><i class="uil uil-times text-xl text-red-200"></i></button>
                                    </div>
                                </div>
                            ';
            
            $subTotal = $subTotal + $order->total_price;
            $total = $total + $order->total_price;
        }

        $amount = $total;

        $response = array(
            'thisNotif' => $notif,
            'orders' => $orderResult,
            'subTotal' => number_format($subTotal, 2, '.', ','),
            'total' => number_format($total, 2, '.', ','),
            'amount' => $amount
        );

        echo json_encode($response);
    }

    public function desc(Request $request){
        $slug = $request->slug;
        $corder = DB::table('orders')->where('slug', $slug)->first();

        if($corder->quantity > 1){
            $quantity = $corder->quantity - 1;
        }else{
            $quantity = $corder->quantity;
        }
        $total_price = $corder->price * $quantity;
        $current_quantity = $corder->current_stock + 1;
        DB::table('orders')->where('slug', $slug)->update([
            'quantity' => $quantity,
            'total_price' => $total_price,
            'current_stock' => $current_quantity,
        ]);

        DB::table('menus')->where('id', $corder->menu_id)->update([
            'current_quantity' => $current_quantity,
        ]);

        $orders = DB::table('orders')->where('cashier', auth()->id())->orderBy('id', 'desc')->get();
        $orderResult = '';
        $subTotal = 0;
        $total = 0;
        foreach($orders as $order){
            $orderResult .= '
                                <div class="grid grid-cols-12 content-center h-14 w-full text-center px-4">
                                    <div class="col-span-5 text-xs font-semibold text-left flex items-center pr-2">
                                        '.$order->name.'
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="'.$order->slug.'" class="descQty aspect-square w-full bg-red-200 rounded-lg"><i class="uil uil-minus text-xl text-red-900"></i></button>
                                    </div>
                                    <div class="col-span-1 flex items-center justify-center">
                                        <p class="w-full text-center text-sm font-semibold border-0 h-7 leading-7">'.$order->quantity.'</p>
                                        <input type="hidden" value="'.$order->quantity.'">
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="'.$order->slug.'" class="incQty aspect-square w-full bg-emerald-200 rounded-lg"><i class="uil uil-plus text-xl text-emerald-900"></i></button>
                                    </div>
                                    <div class="col-span-3 flex items-center text-sm font-semibold justify-center">
                                        '.number_format($order->total_price, 2, ".", ",").'
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="'.$order->slug.'" data-name="'.$order->name.'" class="removeButton aspect-square w-full bg-red-600 rounded-lg"><i class="uil uil-times text-xl text-red-200"></i></button>
                                    </div>
                                </div>
                            ';
            
            $subTotal = $subTotal + $order->total_price;
            $total = $total + $order->total_price;
        }

        $amount = $total;

        $response = array(
            'orders' => $orderResult,
            'subTotal' => number_format($subTotal, 2, '.', ','),
            'total' => number_format($total, 2, '.', ','),
            'amount' => $amount
        );

        echo json_encode($response);
    }

    public function remove(Request $request){
        $slug = $request->slug;
        $ord = DB::table('orders')->where('slug', $slug)->first();
        $mid = $ord->menu_id;
        $qty = $ord->quantity;
        $oqty = (DB::table('menus')->where('id', $mid)->first())->current_quantity;
        $nqty = $oqty + $qty;

        DB::table('menus')->where('id', $mid)->update([
            'current_quantity' => $nqty,
        ]);

        DB::table('orders')->where('slug', $slug)->delete();

        $orders = DB::table('orders')->where('cashier', auth()->id())->orderBy('id', 'desc')->get();
        $orderResult = '';
        $subTotal = 0;
        $total = 0;
        foreach($orders as $order){
            $orderResult .= '
                                <div class="grid grid-cols-12 content-center h-14 w-full text-center px-4">
                                    <div class="col-span-5 text-xs font-semibold text-left flex items-center pr-2">
                                        '.$order->name.'
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="'.$order->slug.'" class="descQty aspect-square w-full bg-red-200 rounded-lg"><i class="uil uil-minus text-xl text-red-900"></i></button>
                                    </div>
                                    <div class="col-span-1 flex items-center justify-center">
                                        <p class="w-full text-center text-sm font-semibold border-0 h-7 leading-7">'.$order->quantity.'</p>
                                        <input type="hidden" value="'.$order->quantity.'">
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="'.$order->slug.'" class="incQty aspect-square w-full bg-emerald-200 rounded-lg"><i class="uil uil-plus text-xl text-emerald-900"></i></button>
                                    </div>
                                    <div class="col-span-3 flex items-center text-sm font-semibold justify-center">
                                        '.number_format($order->total_price, 2, ".", ",").'
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="'.$order->slug.'" data-name="'.$order->name.'" class="removeButton aspect-square w-full bg-red-600 rounded-lg"><i class="uil uil-times text-xl text-red-200"></i></button>
                                    </div>
                                </div>
                            ';
            
            $subTotal = $subTotal + $order->total_price;
            $total = $total + $order->total_price;
            $amount = $total + $order->total_price;
        }

        $amount = $total;

        $response = array(
            'orders' => $orderResult,
            'subTotal' => number_format($subTotal, 2, '.', ','),
            'total' => number_format($total, 2, '.', ','),
            'amount' => $amount
        );

        echo json_encode($response);
    }

    public function pay(Request $request){
        $amount = $request->amount;
        $table = $request->table;

        if($table == 0){
            $type = 'TAKE OUT';
        }else{
            $type = 'DINE-IN';
        }

        $id = Transaction::latest()->pluck('id')->first();
        if($id == null){
            $id = 1;
        }else{
            $id++;
        }
        $nid =str_pad($id, 7, '0', STR_PAD_LEFT);

        $number = date('mdY').'-'.$nid;

        $tranSlug = Str::random(60);
        $ntranSlug = $tranSlug;
        $check_slug = DB::table('transactions')->where('slug', $ntranSlug)->get();
        while(count($check_slug) > 0){
            $ntranSlug = Str::random(60);
            $check_slug = DB::table('transactions')->where('slug', $ntranSlug)->get();
        }
        $tranSlug = $ntranSlug;

        $tran = new Transaction();
        $tran->number = $number;
        $tran->total = $amount;
        $tran->type = $type;
        $tran->table = $table;
        $tran->status = 'PAID';
        $tran->order_status = 'PREPARING';
        $tran->cashier = auth()->id();
        $tran->slug = $tranSlug;
        $tran->save();

        $orders = DB::table('orders')->where('cashier', auth()->id())->get();
        foreach($orders as $order){
            $orderSlug = Str::random(60);
            $norderSlug = $orderSlug;
            $check_slug = DB::table('ordered')->where('slug', $norderSlug)->get();
            while(count($check_slug) > 0){
                $norderSlug = Str::random(60);
                $check_slug = DB::table('ordered')->where('slug', $norderSlug)->get();
            }
            $orderSlug = $norderSlug;

            DB::table('ordered')->insert([
                'tran_id' => $tran->id,
                'menu_id' => $order->menu_id,
                'quantity' => $order->quantity,
                'price' => $order->total_price,
                'status' => 'PREPARING',
                'slug' => $orderSlug,
            ]);

            $oqty = (DB::table('menus')->where('id', $order->menu_id)->first())->quantity;
            $nqty = $oqty - $order->quantity;

            DB::table('menus')->where('id', $order->menu_id)->update([
                'quantity' => $nqty
            ]);

            DB::table('orders')->where('id', $order->id)->delete();
        }

        $orders = DB::table('orders')->where('cashier', auth()->id())->orderBy('id', 'desc')->get();
        $orderResult = '';
        $subTotal = 0;
        $total = 0;
        foreach($orders as $order){
            $orderResult .= '
                                <div class="grid grid-cols-12 content-center h-14 w-full text-center px-4">
                                    <div class="col-span-5 text-xs font-semibold text-left flex items-center pr-2">
                                        '.$order->name.'
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="'.$order->slug.'" class="descQty aspect-square w-full bg-red-200 rounded-lg"><i class="uil uil-minus text-xl text-red-900"></i></button>
                                    </div>
                                    <div class="col-span-1 flex items-center justify-center">
                                        <p class="w-full text-center text-sm font-semibold border-0 h-7 leading-7">'.$order->quantity.'</p>
                                        <input type="hidden" value="'.$order->quantity.'">
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="'.$order->slug.'" class="incQty aspect-square w-full bg-emerald-200 rounded-lg"><i class="uil uil-plus text-xl text-emerald-900"></i></button>
                                    </div>
                                    <div class="col-span-3 flex items-center text-sm font-semibold justify-center">
                                        '.number_format($order->total_price, 2, ".", ",").'
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <button data-slug="'.$order->slug.'" data-name="'.$order->name.'" class="removeButton aspect-square w-full bg-red-600 rounded-lg"><i class="uil uil-times text-xl text-red-200"></i></button>
                                    </div>
                                </div>
                            ';
            
            $subTotal = $subTotal + $order->total_price;
            $total = $total + $order->total_price;
            $amount = $total + $order->total_price;
        }

        $amount = $total;

        $response = array(
            'orders' => $orderResult,
            'subTotal' => number_format($subTotal, 2, '.', ','),
            'total' => number_format($total, 2, '.', ','),
            'amount' => $amount
        );

        echo json_encode($response);
    }
}
