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

    public function get(Request $request){
        $id = $request->id;
        $trans = DB::table('transactions')
            ->select('transactions.id, transactions.number, transactions.total, transactions.type, transactions.table, transactions.status, transactions.order_status, transactions.cashier, transactions.slug, transactions.created_at, transactions.updated_at, ordered.tran_id, ordered.menu_id, menus.name, COUNT(menus.name), ordered.quantity, ordered.status')
            ->join('ordered', 'transactions.id', '=', 'ordered.tran_id')
            ->join('menus', 'ordered.menu_id', '=', 'menus.id')
            ->where('transactions.table', $id)
            ->groupBy('menus.name')
            ->get();

        $res = '';

        foreach($trans as $tran){
            $res .= '
                <div class="flex justify-between items-center p-2 text-xl font-semibold text-gray-500 tracking-wide">
                    <div>
                        <h1 class=" whitespace-nowrap max-w-xs overflow-hidden">&nbsp;&nbsp;'..'x&nbsp;&nbsp;&nbsp;<span>Bulalo Special sdfgsdg ergwe gsdgser gserg</span>&nbsp;&nbsp;</h1>
                    </div>
                    <div>
                        <button class="reduceButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50 mr-4"><i class="uil uil-minus text-xl text-red-500 hover:text-red-600 mr-2"></i>Reduce</button>
                        <button class="removeButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50"><i class="uil uil-multiply text-xl text-red-500 hover:text-red-600 mr-2"></i>Remove</button>
                    </div>
                </div>
            ';
        }
        
        
    }
}
