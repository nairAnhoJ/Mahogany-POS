<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderedController extends Controller
{
    public function index(){
        $tables = DB::table('tables')->orderBy('name', 'asc')->get();

        return view('user.cashier.orders', compact('tables'));
    }

    public function getMenu(Request $request){
        $id = $request->id;
        $trans = DB::table('transactions')->where('table', $id)->where('order_status', '!=', 'CANCELLED')->where('order_status', '!=', 'COMPLETED')->get();
        $res = '';

        foreach($trans as $tran){
            $m = '';
            $orders = DB::table('ordered')
                ->join('menus', 'ordered.menu_id', '=', 'menus.id')
                ->select('ordered.tran_id', 'ordered.menu_id', 'menus.name', 'ordered.quantity', 'ordered.slug')
                ->where('ordered.tran_id', $tran->id)
                ->get();

            foreach($orders as $order){
                if($order->quantity > 1){
                    $m .= '
                        <div class="flex justify-between items-center mb-5">
                            <div>
                                <h1 class="whitespace-nowrap max-w-xs overflow-hidden">&nbsp;&nbsp;'.$order->quantity.'x&nbsp;&nbsp;&nbsp;<span>'.$order->name.'</span>&nbsp;&nbsp;</h1>
                            </div>
                            <div style="margin-right: 20px;" class="">
                                <button data-slug="'.$order->slug.'" data-table="'.$id.'" class="reduceButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50 mr-4"><i class="uil uil-minus text-xl text-red-500 hover:text-red-600 mr-2"></i>Reduce</button>
                                <button data-slug="'.$order->slug.'" data-table="'.$id.'" class="removeButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50"><i class="uil uil-multiply text-xl text-red-500 hover:text-red-600 mr-2"></i>Remove</button>
                            </div>
                        </div>
                    ';
                }else{
                    $m .= '
                        <div class="flex justify-between items-center mb-5">
                            <div>
                                <h1 class="whitespace-nowrap max-w-xs overflow-hidden">&nbsp;&nbsp;'.$order->quantity.'x&nbsp;&nbsp;&nbsp;<span>'.$order->name.'</span>&nbsp;&nbsp;</h1>
                            </div>
                            <div style="margin-right: 20px;" class="">
                                <button data-slug="'.$order->slug.'" data-table="'.$id.'" class="removeButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50"><i class="uil uil-multiply text-xl text-red-500 hover:text-red-600 mr-2"></i>Remove</button>
                            </div>
                        </div>
                    ';
                }
            }

            $res .= '
                <div class="relative h-auto mb-5">
                    <span style="border-color: rgb(209 213 219 / var(--tw-border-opacity)); margin-left: 20px;" class="relative text-gray-500 font-bold text-xl border px-4 py-2 w-auto bg-white z-50 rounded-lg">'.$tran->number.'</span>
                    <div style="top: -13px; border-color: rgb(209 213 219 / var(--tw-border-opacity));" class="relative border border-gray-500 z-10 w-full pt-6 pl-2 text-xl font-semibold text-gray-500 tracking-wide rounded-lg">'.$m.'</div>
                </div>
            ';
        }

        echo $res;
    }

    public function reduce(Request $request){
        $slug = $request->slug;

        DB::table('ordered')->where('slug', $slug)->decrement('quantity', 1);

        $menu_id = (DB::table('ordered')->where('slug', $slug)->first())->menu_id;
        DB::table('menus')->where('id', $menu_id)->increment('current_quantity', 1);
        DB::table('menus')->where('id', $menu_id)->increment('quantity', 1);

        $id = $request->table;
        $trans = DB::table('transactions')->where('table', $id)->where('order_status', '!=', 'CANCELLED')->where('order_status', '!=', 'COMPLETED')->get();
        $res = '';

        foreach($trans as $tran){
            $m = '';
            $orders = DB::table('ordered')
                ->join('menus', 'ordered.menu_id', '=', 'menus.id')
                ->select('ordered.tran_id', 'ordered.menu_id', 'menus.name', 'ordered.quantity', 'ordered.slug')
                ->where('ordered.tran_id', $tran->id)
                ->get();

            foreach($orders as $order){
                if($order->quantity > 1){
                    $m .= '
                        <div class="flex justify-between items-center mb-5">
                            <div>
                                <h1 class="whitespace-nowrap max-w-xs overflow-hidden">&nbsp;&nbsp;'.$order->quantity.'x&nbsp;&nbsp;&nbsp;<span>'.$order->name.'</span>&nbsp;&nbsp;</h1>
                            </div>
                            <div style="margin-right: 20px;" class="">
                                <button data-slug="'.$order->slug.'" data-table="'.$id.'" class="reduceButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50 mr-4"><i class="uil uil-minus text-xl text-red-500 hover:text-red-600 mr-2"></i>Reduce</button>
                                <button data-slug="'.$order->slug.'" data-table="'.$id.'" class="removeButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50"><i class="uil uil-multiply text-xl text-red-500 hover:text-red-600 mr-2"></i>Remove</button>
                            </div>
                        </div>
                    ';
                }else{
                    $m .= '
                        <div class="flex justify-between items-center mb-5">
                            <div>
                                <h1 class="whitespace-nowrap max-w-xs overflow-hidden">&nbsp;&nbsp;'.$order->quantity.'x&nbsp;&nbsp;&nbsp;<span>'.$order->name.'</span>&nbsp;&nbsp;</h1>
                            </div>
                            <div style="margin-right: 20px;" class="">
                                <button data-slug="'.$order->slug.'" data-table="'.$id.'" class="removeButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50"><i class="uil uil-multiply text-xl text-red-500 hover:text-red-600 mr-2"></i>Remove</button>
                            </div>
                        </div>
                    ';
                }
            }

            $res .= '
                <div class="relative h-auto mb-5">
                    <span style="border-color: rgb(209 213 219 / var(--tw-border-opacity)); margin-left: 20px;" class="relative text-gray-500 font-bold text-xl border px-4 py-2 w-auto bg-white z-50 rounded-lg">'.$tran->number.'</span>
                    <div style="top: -13px; border-color: rgb(209 213 219 / var(--tw-border-opacity));" class="relative border border-gray-500 z-10 w-full pt-6 pl-2 text-xl font-semibold text-gray-500 tracking-wide rounded-lg">'.$m.'</div>
                </div>
            ';
        }

        echo $res;
    }

    public function remove(Request $request){
        $slug = $request->slug;

        $ordered = DB::table('ordered')->where('slug', $slug)->first();
        DB::table('menus')->where('id', $ordered->menu_id)->increment('current_quantity', $ordered->quantity);
        DB::table('menus')->where('id', $ordered->menu_id)->increment('quantity', $ordered->quantity);

        DB::table('ordered')->where('slug', $slug)->delete();

        $id = $request->table;
        $trans = DB::table('transactions')->where('table', $id)->where('order_status', '!=', 'CANCELLED')->where('order_status', '!=', 'COMPLETED')->get();
        $res = '';

        foreach($trans as $tran){
            $m = '';
            $orders = DB::table('ordered')
                ->join('menus', 'ordered.menu_id', '=', 'menus.id')
                ->select('ordered.tran_id', 'ordered.menu_id', 'menus.name', 'ordered.quantity', 'ordered.slug')
                ->where('ordered.tran_id', $tran->id)
                ->get();

            if($orders->count() < 1){
                DB::table('transactions')->where('id', $tran->id)->update([
                    'order_status' => 'CANCELLED'
                ]);

                $curTrans = DB::table('transactions')->where('table', $id)->where('order_status', '!=', 'CANCELLED')->where('order_status', '!=', 'COMPLETED')->get();
                if($curTrans->count() == 0){
                    DB::table('tables')->where('id', $id)->update([
                        'status' => 0
                    ]);
                    $res = '1';
                }
            }else{
                foreach($orders as $order){
                    if($order->quantity > 1){
                        $m .= '
                            <div class="flex justify-between items-center mb-5">
                                <div>
                                    <h1 class="whitespace-nowrap max-w-xs overflow-hidden">&nbsp;&nbsp;'.$order->quantity.'x&nbsp;&nbsp;&nbsp;<span>'.$order->name.'</span>&nbsp;&nbsp;</h1>
                                </div>
                                <div style="margin-right: 20px;" class="">
                                    <button data-slug="'.$order->slug.'" data-table="'.$id.'" class="reduceButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50 mr-4"><i class="uil uil-minus text-xl text-red-500 hover:text-red-600 mr-2"></i>Reduce</button>
                                    <button data-slug="'.$order->slug.'" data-table="'.$id.'" class="removeButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50"><i class="uil uil-multiply text-xl text-red-500 hover:text-red-600 mr-2"></i>Remove</button>
                                </div>
                            </div>
                        ';
                    }else{
                        $m .= '
                            <div class="flex justify-between items-center mb-5">
                                <div>
                                    <h1 class="whitespace-nowrap max-w-xs overflow-hidden">&nbsp;&nbsp;'.$order->quantity.'x&nbsp;&nbsp;&nbsp;<span>'.$order->name.'</span>&nbsp;&nbsp;</h1>
                                </div>
                                <div style="margin-right: 20px;" class="">
                                    <button data-slug="'.$order->slug.'" data-table="'.$id.'" class="removeButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50"><i class="uil uil-multiply text-xl text-red-500 hover:text-red-600 mr-2"></i>Remove</button>
                                </div>
                            </div>
                        ';
                    }
                }

                $res .= '
                    <div class="relative h-auto mb-5">
                        <span style="border-color: rgb(209 213 219 / var(--tw-border-opacity)); margin-left: 20px;" class="relative text-gray-500 font-bold text-xl border px-4 py-2 w-auto bg-white z-50 rounded-lg">'.$tran->number.'</span>
                        <div style="top: -13px; border-color: rgb(209 213 219 / var(--tw-border-opacity));" class="relative border border-gray-500 z-10 w-full pt-6 pl-2 text-xl font-semibold text-gray-500 tracking-wide rounded-lg">'.$m.'</div>
                    </div>
                ';
            }


        }

        echo $res;
    }
}
