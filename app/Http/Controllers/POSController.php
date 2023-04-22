<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class POSController extends Controller
{
    public function index(){
        $tables = DB::table('tables')->orderBy('name', 'asc')->get();
        $orders = DB::table('orders')->orderBy('id', 'desc')->get();
        $menus = DB::table('menus')->orderBy('name', 'asc')->get();
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

        if($ord != null){
            $quantity = $ord->quantity + 1;
            $total_price = $menu->price * $quantity;
            $current_quantity = $menu->current_quantity - $quantity;
            DB::table('orders')->where('id', $ord->id)->delete();
        }else{
            $quantity = 1;
            $total_price = $menu->price * $quantity;
            $current_quantity = $menu->current_quantity - $quantity;
        }

        $order = new Order();
        $order->menu_id = $menu->id;
        $order->name = $menu->name;
        $order->quantity = $quantity;
        $order->price = $menu->price;
        $order->total_price = $total_price;
        $order->current_stock = $current_quantity;
        $order->slug = Str::random(60);
        $order->save();

        $orders = DB::table('orders')->orderBy('id', 'desc')->get();
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
                                        <button data-slug="'.$order->slug.'" class="aspect-square w-full bg-red-600 rounded-lg"><i class="uil uil-times text-xl text-red-200"></i></button>
                                    </div>
                                </div>
                            ';
            
            $subTotal = $subTotal + $order->total_price;
            $total = $total + $order->total_price;
        }


        $response = array(
            'orders' => $orderResult,
            'subTotal' => number_format($subTotal, 2, '.', ','),
            'total' => number_format($subTotal, 2, '.', ',')
        );

        echo json_encode($response);
    }

    public function inc(Request $request){
        $slug = $request->slug;
        $corder = DB::table('orders')->where('slug', $slug)->first();

        $quantity = $corder->quantity + 1;
        $total_price = $corder->price * $quantity;
        $current_quantity = $corder->current_stock - 1;
        DB::table('orders')->where('slug', $slug)->update([
            'quantity' => $quantity,
            'total_price' => $total_price,
            'current_stock' => $current_quantity,
        ]);

        $orders = DB::table('orders')->orderBy('id', 'desc')->get();
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
                                        <button data-slug="'.$order->slug.'" class="aspect-square w-full bg-red-600 rounded-lg"><i class="uil uil-times text-xl text-red-200"></i></button>
                                    </div>
                                </div>
                            ';
            
            $subTotal = $subTotal + $order->total_price;
            $total = $total + $order->total_price;
        }


        $response = array(
            'orders' => $orderResult,
            'subTotal' => number_format($subTotal, 2, '.', ','),
            'total' => number_format($subTotal, 2, '.', ',')
        );

        echo json_encode($response);
    }

    public function desc(Request $request){
        $slug = $request->slug;
        $corder = DB::table('orders')->where('slug', $slug)->first();

        $quantity = $corder->quantity - 1;
        $total_price = $corder->price * $quantity;
        $current_quantity = $corder->current_stock + 1;
        DB::table('orders')->where('slug', $slug)->update([
            'quantity' => $quantity,
            'total_price' => $total_price,
            'current_stock' => $current_quantity,
        ]);

        $orders = DB::table('orders')->orderBy('id', 'desc')->get();
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
                                        <button data-slug="'.$order->slug.'" class="aspect-square w-full bg-red-600 rounded-lg"><i class="uil uil-times text-xl text-red-200"></i></button>
                                    </div>
                                </div>
                            ';
            
            $subTotal = $subTotal + $order->total_price;
            $total = $total + $order->total_price;
        }


        $response = array(
            'orders' => $orderResult,
            'subTotal' => number_format($subTotal, 2, '.', ','),
            'total' => number_format($subTotal, 2, '.', ',')
        );

        echo json_encode($response);
    }
}
