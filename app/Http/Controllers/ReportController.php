<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(){

        return view('admin.reports.index');
    }

    public function generate(Request $request){
        $start = $request->start;
        $startDate = date('Y-m-d', strtotime($start));
        $end = $request->end;
        $endDate = date('Y-m-d', strtotime($end));
        $category = $request->category;
        $report = $request->report;

        $settings = DB::table('settings')->where('id', 1)->first();

        if($category == 'sales'){

            $results = DB::table('transactions')
                ->select('id', 'number as nn', 'total as amount', 'mode_of_payment', 'created_at as date')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'PAID')
                ->where('order_status', '!=', 'CANCELLED')
                ->orderBy('id', 'desc')
                ->get();
            $resultsCount = DB::table('transactions')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'PAID')
                ->where('order_status', '!=', 'CANCELLED')
                ->orderBy('id', 'desc')
                ->get()->count();

        }else if($category == 'expenses'){

            $results = DB::table('inventory_transactions')
                ->select('inventory_transactions.created_at as date', 'inventories.name as nn', 'inventory_transactions.amount as amount', 'inventory_transactions.quantity as quantity')
                ->join('inventories', 'inventory_transactions.inv_id', '=', 'inventories.id')
                ->whereBetween('inventory_transactions.created_at', [$startDate, $endDate])
                ->where('inventory_transactions.type', 'INCOMING')
                ->orderBy('inventory_transactions.id', 'desc')
                ->get();
            $resultsCount = DB::table('inventory_transactions')
                ->select('inventory_transactions.created_at as date', 'inventories.name as nn', 'inventory_transactions.amount as amount', 'inventory_transactions.quantity as quantity')
                ->join('inventories', 'inventory_transactions.inv_id', '=', 'inventories.id')
                ->whereBetween('inventory_transactions.created_at', [$startDate, $endDate])
                ->where('inventory_transactions.type', 'INCOMING')
                ->orderBy('inventory_transactions.id', 'desc')
                ->get()->count();

        }else if($category == 'both'){



        }
        // dd($results);
        if($report == 'list'){
            return view('admin.reports.list', compact('results', 'settings', 'category', 'resultsCount', 'startDate', 'endDate', 'report'));
        }else if($report == 'summary'){
            return view('admin.reports.summary', compact('results', 'settings'));
        }
    }

    public function print($start, $end, $category, $report){
        $settings = DB::table('settings')->where('id', 1)->first();

        if($category == 'sales'){

            $results = DB::table('transactions')
                ->select('id', 'number as nn', 'total as amount', 'mode_of_payment', 'created_at as date')
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'PAID')
                ->where('order_status', '!=', 'CANCELLED')
                ->orderBy('id', 'desc')
                ->get();
            $resultsCount = DB::table('transactions')
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'PAID')
                ->where('order_status', '!=', 'CANCELLED')
                ->orderBy('id', 'desc')
                ->get()->count();

        }else if($category == 'expenses'){

            $results = DB::table('inventory_transactions')
                ->select('inventory_transactions.created_at as date', 'inventories.name as nn', 'inventory_transactions.amount as amount', 'inventory_transactions.quantity as quantity')
                ->join('inventories', 'inventory_transactions.inv_id', '=', 'inventories.id')
                ->whereBetween('inventory_transactions.created_at', [$start, $end])
                ->where('inventory_transactions.type', 'INCOMING')
                ->orderBy('inventory_transactions.id', 'desc')
                ->get();
            $resultsCount = DB::table('inventory_transactions')
                ->select('inventory_transactions.created_at as date', 'inventories.name as nn', 'inventory_transactions.amount as amount', 'inventory_transactions.quantity as quantity')
                ->join('inventories', 'inventory_transactions.inv_id', '=', 'inventories.id')
                ->whereBetween('inventory_transactions.created_at', [$start, $end])
                ->where('inventory_transactions.type', 'INCOMING')
                ->orderBy('inventory_transactions.id', 'desc')
                ->get()->count();

        }else if($category == 'both'){



        }
        // dd($results);
        if($report == 'list'){
            return view('admin.reports.print_list', compact('results', 'settings', 'category', 'resultsCount'));
        }else if($report == 'summary'){
            return view('admin.reports.print_summary', compact('results', 'settings'));
        }
    }
}
