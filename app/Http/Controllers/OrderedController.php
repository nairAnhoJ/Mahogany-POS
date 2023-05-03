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
        $trans = DB::table('transactions')->where('table', $id)->get();
        $res = '';

        
        foreach($trans as $tran){
            $m = '';
            $orders = DB::table('ordered')
                ->join('menus', 'ordered.menu_id', '=', 'menus.id')
                ->select('ordered.tran_id', 'ordered.menu_id', 'menus.name', 'ordered.quantity', 'ordered.slug')
                ->where('ordered.tran_id', $tran->id)
                ->get();

            // $menus = DB::table('ordered')
            //     ->select('ordered.tran_id, ordered.menu_id, menus.name as name, ordered.quantity, ordered.slug')
            //     ->join('menus', 'ordered.menu_id', '=', 'menus.id')
            //     ->where('ordered.tran_id', 4)
            //     ->get();

            foreach($orders as $order){
                $m .= '
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h1 class="whitespace-nowrap max-w-xs overflow-hidden">&nbsp;&nbsp;'.$order->quantity.'x&nbsp;&nbsp;&nbsp;<span>'.$order->name.'</span>&nbsp;&nbsp;</h1>
                        </div>
                        <div class="mr-5">
                            <button class="reduceButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50 mr-4"><i class="uil uil-minus text-xl text-red-500 hover:text-red-600 mr-2"></i>Reduce</button>
                            <button class="removeButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50"><i class="uil uil-multiply text-xl text-red-500 hover:text-red-600 mr-2"></i>Remove</button>
                        </div>
                    </div>
                ';
            }

            $res .= '
                <div class="relative h-auto">
                    <span class="relative text-gray-500 font-bold text-xl border border-gray-500 px-4 py-2 w-auto ml-10 bg-white z-50 rounded">'.$tran->number.'</span>
                    <div class="relative -top-[100px] border border-gray-500 z-10 w-full pt-6 pl-2 text-xl font-semibold text-gray-500 tracking-wide rounded-lg">'.$m.'</div>
                </div>
            ';
        }

        echo $res;
    }
}
