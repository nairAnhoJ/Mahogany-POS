<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(){
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d');

        $settings = DB::table('settings')->where('id', 1)->first();


        $results = DB::table('transactions')
            ->select('transactions.id', 'transactions.number as nn', 'transactions.total as amount', 'transactions.mode_of_payment', 'transactions.type', 'transactions.created_at as date', 'tables.name as table')
            ->join('tables', 'transactions.table', '=', 'tables.id')
            ->whereBetween('transactions.created_at', [$startDate, $endDate])
            ->where('transactions.status', 'PAID')
            ->where('transactions.order_status', '!=', 'CANCELLED')
            ->orderBy('transactions.id', 'desc')
            ->get();

        $resultsCount = DB::table('transactions')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'PAID')
            ->where('order_status', '!=', 'CANCELLED')
            ->orderBy('id', 'desc')
            ->get()->count();

        return view('user.cashier.transactions', compact('results', 'settings', 'resultsCount', 'startDate', 'endDate'));
    }

    public function generate(Request $request){
        $startDate = date('Y-m-d', strtotime($request->startDate));
        $endDate = date('Y-m-d', strtotime($request->endDate));;

        $settings = DB::table('settings')->where('id', 1)->first();

        $results = DB::table('transactions')
            ->select('transactions.id', 'transactions.number as nn', 'transactions.total as amount', 'transactions.mode_of_payment', 'transactions.type', 'transactions.created_at as date', 'tables.name as table')
            ->join('tables', 'transactions.table', '=', 'tables.id')
            ->whereBetween('transactions.created_at', [$startDate, $endDate])
            ->where('transactions.status', 'PAID')
            ->where('transactions.order_status', '!=', 'CANCELLED')
            ->orderBy('transactions.id', 'desc')
            ->get();

        $resultsCount = DB::table('transactions')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'PAID')
            ->where('order_status', '!=', 'CANCELLED')
            ->orderBy('id', 'desc')
            ->get()->count();

        return view('user.cashier.transactions', compact('results', 'settings', 'resultsCount', 'startDate', 'endDate'));
    }

    public function view(Request $request){
        $id = $request->id;

        $orders = DB::table('ordered')
        ->join('menus', 'ordered.menu_id', '=', 'menus.id')
        ->select('ordered.tran_id', 'ordered.menu_id', 'menus.name', 'ordered.quantity', 'ordered.slug', 'ordered.status')
        ->where('ordered.tran_id', $id)
        ->get();

        $tran = DB::table('transactions')->where('id', $id)->first();

        $viewOrder = '';

        foreach($orders as $order){
            $viewOrder .= '<div class="">'.$order->quantity.'x</div><div class="col-span-4">'.$order->name.'</div>';
        }

        $printUrl = url('/transactions/print/'.$id);

        $response = array(
            'number' => $tran->number,
            'ordered' => $viewOrder,
            'url' => $printUrl,
        );

        echo json_encode($response);
    }

    public function print($id){
        $trans = DB::table('transactions')
                    ->select('transactions.*', 'tables.name as table_name')
                    ->join('tables', 'transactions.table', '=', 'tables.id')
                    ->where('transactions.id', $id)
                    ->first();

        $orders = DB::table('ordered')
                    ->select('ordered.*', 'menus.name')
                    ->join('menus', 'ordered.menu_id', '=', 'menus.id')
                    ->where('tran_id', $trans->id)
                    ->get();


        $settings = DB::table('settings')->where('id', 1)->first();


        return view('user.cashier.bill', compact('orders', 'trans', 'settings'));
    }
}
