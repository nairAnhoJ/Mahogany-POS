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
        $endDate = date('Y-m-d', strtotime('+1 day', strtotime($end)));
        $category = $request->category;
        $report = $request->report;

        $settings = DB::table('settings')->where('id', 1)->first();

        if($category == 'sales'){

            $results = DB::table('transactions')
                ->select('id', 'number as nn', 'total as amount', 'mode_of_payment', 'type', 'created_at as date')
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

            if($report == 'summary'){
                return view('admin.reports.summary_se', compact('results', 'settings', 'category', 'resultsCount', 'startDate', 'endDate', 'report'));
            }

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

            if($report == 'summary'){
                return view('admin.reports.summary_se', compact('results', 'settings', 'category', 'resultsCount', 'startDate', 'endDate', 'report'));
            }

        }else if($category == 'both'){
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

            $results = $salesQuery->union($expensesQuery)->orderBy('date')->get();

            if($report == 'summary'){
                return view('admin.reports.summary_sec', compact('results', 'category', 'settings', 'startDate', 'endDate', 'report'));
            }
        }else if($category == 'inventory'){

            $results = DB::table('inventory_transactions')
                ->select('inventory_transactions.created_at as date', 'inventories.name as nn', 'inventory_transactions.amount as amount', 'inventory_transactions.quantity as quantity', 'inventory_transactions.remarks as remarks')
                ->join('inventories', 'inventory_transactions.inv_id', '=', 'inventories.id')
                ->whereBetween('inventory_transactions.created_at', [$startDate, $endDate])
                ->where('inventory_transactions.type', 'OUTGOING')
                ->orderBy('inventory_transactions.id', 'desc')
                ->get();
            $resultsCount = DB::table('inventory_transactions')
                ->select('inventory_transactions.created_at as date', 'inventories.name as nn', 'inventory_transactions.amount as amount', 'inventory_transactions.quantity as quantity')
                ->join('inventories', 'inventory_transactions.inv_id', '=', 'inventories.id')
                ->whereBetween('inventory_transactions.created_at', [$startDate, $endDate])
                ->where('inventory_transactions.type', 'OUTGOING')
                ->orderBy('inventory_transactions.id', 'desc')
                ->get()->count();

            if($report == 'summary'){
                return view('admin.reports.summary_se', compact('results', 'settings', 'category', 'resultsCount', 'startDate', 'endDate', 'report'));
            }
        }

        return view('admin.reports.list', compact('results', 'settings', 'category', 'resultsCount', 'startDate', 'endDate', 'report'));
    }

    public function print($start, $end, $category, $report){
        $settings = DB::table('settings')->where('id', 1)->first();

        $startDate = date('M j, Y', strtotime($start));
        $endDate = date('M j, Y', strtotime($end));

        if($category == 'sales'){

            $results = DB::table('transactions')
                ->select('id', 'number as nn', 'total as amount', 'mode_of_payment', 'type', 'created_at as date')
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

            if($report == 'summary'){
                return view('admin.reports.print_summary_se', compact('results', 'settings', 'category', 'resultsCount', 'startDate', 'endDate', 'report'));
            }

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

                if($report == 'summary'){
                    return view('admin.reports.print_summary_se', compact('results', 'settings', 'category', 'resultsCount', 'startDate', 'endDate', 'report'));
                }

        }else if($category == 'both'){
            $salesQuery = DB::table('transactions')
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('SUM(total) as stotal'),
                    DB::raw('0 as etotal')
                )
                ->where('status', 'PAID')
                ->where('order_status', '!=', 'CANCELLED')
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('date');

            $expensesQuery = DB::table('inventory_transactions')
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('0 as stotal'),
                    DB::raw('SUM(amount) as etotal')
                )
                ->where('type', 'INCOMING')
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('date');

            $results = $salesQuery->union($expensesQuery)->orderBy('date')->get();

            return view('admin.reports.print_summary_sec', compact('results', 'category', 'settings', 'startDate', 'endDate', 'report'));
        }else if($category == 'inventory'){

            $results = DB::table('inventory_transactions')
                ->select('inventory_transactions.created_at as date', 'inventories.name as nn', 'inventory_transactions.amount as amount', 'inventory_transactions.quantity as quantity', 'inventory_transactions.remarks as remarks')
                ->join('inventories', 'inventory_transactions.inv_id', '=', 'inventories.id')
                ->whereBetween('inventory_transactions.created_at', [$start, $end])
                ->where('inventory_transactions.type', 'OUTGOING')
                ->orderBy('inventory_transactions.id', 'desc')
                ->get();
            $resultsCount = DB::table('inventory_transactions')
                ->select('inventory_transactions.created_at as date', 'inventories.name as nn', 'inventory_transactions.amount as amount', 'inventory_transactions.quantity as quantity')
                ->join('inventories', 'inventory_transactions.inv_id', '=', 'inventories.id')
                ->whereBetween('inventory_transactions.created_at', [$start, $end])
                ->where('inventory_transactions.type', 'OUTGOING')
                ->orderBy('inventory_transactions.id', 'desc')
                ->get()->count();
        }

        if($report == 'list' || $report == 'logs'){
            return view('admin.reports.print_list', compact('results', 'settings', 'category', 'resultsCount', 'startDate', 'endDate'));
        }else if($report == 'summary'){
            return view('admin.reports.print_summary_se', compact('results', 'settings'));
        }
    }
}
