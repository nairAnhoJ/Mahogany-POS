<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class KitchenController extends Controller
{
    public function index(){
        $trans = DB::table('transactions')
            ->select('transactions.*', 'tables.name as table_name')
            ->join('tables', 'transactions.table', '=', 'tables.id')
            ->where('order_status', '!=', 'CANCELLED')
            ->where('order_status', '!=', 'COMPLETED')
            ->where('order_status', '!=', 'SERVED')
            ->distinct()
            ->get();

        $ordereds = DB::table('ordered')
            ->select('ordered.*', 'menus.name', 'menus.category_id', 'transactions.table')
            ->join('menus', 'ordered.menu_id', '=', 'menus.id')
            ->join('transactions', 'ordered.tran_id', '=', 'transactions.id')
            ->where('ordered.status', '!=', 'COMPLETED')
            ->where('ordered.status', '!=', 'SERVED')
            ->get();

        $cats = DB::table('ordered')
            ->select('menus.category_id', 'menu_categories.name')
            ->join('menus', 'ordered.menu_id', '=', 'menus.id')
            ->join('menu_categories', 'menus.category_id', '=', 'menu_categories.id')
            ->where('ordered.status', '!=', 'COMPLETED')
            ->where('ordered.status', '!=', 'SERVED')
            ->distinct()
            ->get();

        $sOrders = DB::table('ordered')
            ->select('menus.category_id', 'menus.name', DB::raw('SUM(ordered.quantity) as total_quantity'))
            ->join('menus', 'ordered.menu_id', '=', 'menus.id')
            ->where('ordered.status', '!=', 'COMPLETED')
            ->where('ordered.status', '!=', 'SERVED')
            ->groupBy('menus.id', 'menus.category_id', 'menus.name')
            ->orderBy('menus.name', 'asc')
            ->get();


        return view('user.cook.kitchen-display', compact('ordereds', 'cats', 'sOrders', 'trans'));
    }

    public function change(Request $request){
        $id = $request->id;

        $status = (DB::table('ordered')->where('id', $id)->first())->status;

        if($status == 'PREPARING'){
            DB::table('ordered')->where('id', $id)->update([ 'status' => 'PREPARED' ]);
        }else{
            DB::table('ordered')->where('id', $id)->update([ 'status' => 'PREPARING' ]);
        }
    }

    public function check(Request $request){
        $id = $request->id;

        $orders = DB::table('ordered')->where('tran_id', $id)->where('status', 'PREPARING')->get();

        if($orders->count() > 0){
            echo '0';
        }else{
            echo '1';
        }
    }

    public function serve(Request $request){
        $id = $request->id;

        DB::table('ordered')->where('tran_id', $id)->update([
            'status' => 'SERVED',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('transactions')->where('id', $id)->update([
            'order_status' => 'SERVED',
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

}