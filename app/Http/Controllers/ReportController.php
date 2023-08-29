<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Menu;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class ReportController extends Controller
{
    public function index(){

        return view('admin.reports.index');
    }

    public function generate(Request $request){
        $start = $request->start;
        $end = $request->end;
        $startDate = date('Y-m-d H:i:s', strtotime($start));
        $endDate = date('Y-m-d H:i:s', strtotime($end));

        $category = $request->category;
        $report = $request->report;

        $settings = DB::table('settings')->where('id', 1)->first();

        if($category == 'sales'){

            $results = DB::table('transactions')
                ->select('transactions.id', 'transactions.number as nn', 'transactions.total as amount', 'transactions.mode_of_payment', 'transactions.type', 'transactions.created_at as date', 'users.name as cashier')
                ->join('users', 'transactions.cashier', '=', 'users.id')
                // ->whereBetween('created_at', [$startDate, $endDate])
                ->where('transactions.created_at', '>=', $startDate)
                ->where('transactions.created_at', '<', $endDate)
                ->where('transactions.status', 'PAID')
                ->where('transactions.order_status', '!=', 'CANCELLED')
                ->orderBy('transactions.id', 'desc')
                ->get();
    
            $resultsCount = $results->count();


            if($report == 'summary'){
                return view('admin.reports.summary_se', compact('results', 'settings', 'category', 'resultsCount', 'startDate', 'endDate', 'report'));
            }

        }else if($category == 'expenses'){
            if($report == 'unpaid'){

                $results = DB::table('inventory_transactions')
                    ->select('inventory_transactions.id as id','inventory_transactions.created_at as date', 'inventory_transactions.inv_id as inv_id', 'inventories.name as nn', 'inventory_transactions.amount as amount', 'inventory_transactions.quantity as quantity', 'inventory_transactions.remarks as remarks', 'users.name as cashier')
                    ->leftJoin('inventories', 'inventory_transactions.inv_id', '=', 'inventories.id')
                    ->join('users', 'inventory_transactions.user_id', '=', 'users.id')
                    ->where('inventory_transactions.created_at', '>=', $startDate)
                    ->where('inventory_transactions.created_at', '<', $endDate)
                    ->where('inventory_transactions.type', 'INCOMING')
                    ->where('inventory_transactions.is_paid', 0)
                    ->orderBy('inventory_transactions.created_at', 'desc')
                    ->get();
    
                $resultsCount = $results->count();

            }else{
                $results = DB::table('inventory_transactions')
                    ->select('inventory_transactions.id as id','inventory_transactions.is_paid as is_paid','inventory_transactions.created_at as date', 'inventory_transactions.inv_id as inv_id', 'inventories.name as nn', 'inventory_transactions.amount as amount', 'inventory_transactions.quantity as quantity', 'inventory_transactions.remarks as remarks', 'users.name as cashier')
                    ->leftJoin('inventories', 'inventory_transactions.inv_id', '=', 'inventories.id')
                    ->join('users', 'inventory_transactions.user_id', '=', 'users.id')
                    ->where('inventory_transactions.created_at', '>=', $startDate)
                    ->where('inventory_transactions.created_at', '<', $endDate)
                    ->where('inventory_transactions.type', 'INCOMING')
                    ->orderBy('inventory_transactions.created_at', 'desc')
                    ->get();
    
                    $resultsCount = $results->count();
            }


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
                // ->whereBetween('created_at', [$startDate, $endDate])
                ->where('created_at', '>=', $startDate)
                ->where('created_at', '<', $endDate)
                ->groupBy('date');

            $expensesQuery = DB::table('inventory_transactions')
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('0 as stotal'),
                    DB::raw('SUM(amount) as etotal')
                )
                ->where('type', 'INCOMING')
                // ->whereBetween('created_at', [$startDate, $endDate])
                ->where('created_at', '>=', $startDate)
                ->where('created_at', '<', $endDate)
                ->groupBy('date');

            $results = $salesQuery->union($expensesQuery)->orderBy('date')->get();

            $results = $results->groupBy('date')->map(function ($item) {
                return [
                    'date' => $item[0]->date,
                    'stotal' => $item->sum('stotal'),
                    'etotal' => $item->sum('etotal'),
                ];
            })->values();

            if($report == 'summary'){
                return view('admin.reports.summary_sec', compact('results', 'category', 'settings', 'startDate', 'endDate', 'report'));
            }
        }else if($category == 'inventory'){

            if($report == 'logs'){
                $results = DB::table('inventory_transactions')
                    ->select('inventory_transactions.created_at as date', 'inventories.name as nn', 'inventory_transactions.amount as amount', 'inventory_transactions.quantity as quantity', 'inventory_transactions.quantity_before as quantity_before', 'inventory_transactions.quantity_after as quantity_after', 'inventory_transactions.remarks as remarks')
                    ->join('inventories', 'inventory_transactions.inv_id', '=', 'inventories.id')
                    // ->whereBetween('inventory_transactions.created_at', [$startDate, $endDate])
                    ->where('inventory_transactions.created_at', '>=', $startDate)
                    ->where('inventory_transactions.created_at', '<', $endDate)
                    ->where('inventory_transactions.type', 'OUTGOING')
                    ->orderBy('inventory_transactions.id', 'desc')
                    ->get();
    
                $resultsCount = $results->count();
            }else{
                $results = DB::table('inventories')
                    ->select('inventories.created_at as date', 'inventories.name as nn', 'categories.name as cn', 'inventories.quantity as quantity')
                    ->join('categories', 'inventories.category_id', '=', 'categories.id')
                    ->orderBy('inventories.name', 'asc')
                    ->get();
    
                $resultsCount = $results->count();
            }
        }else if($category == 'menu'){
            if($report == 'rank'){
                $results = DB::table('ordered')
                    ->select('ordered.menu_id', 'menus.name', DB::raw('SUM(ordered.quantity) as quantity'))
                    ->join('menus', 'ordered.menu_id', '=', 'menus.id')
                    ->groupBy('ordered.menu_id', 'menus.name')
                    ->where('ordered.created_at', '>=', $startDate)
                    ->where('ordered.created_at', '<', $endDate)
                    ->orderBy('quantity', 'desc')
                    ->get();
            }else if($report == 'stock'){
                $results = Menu::with('category')->orderBy('quantity', 'desc')->get();
            }

            $resultsCount = $results->count();
        }else if($category == 'invmenu'){
            $results = [];
            $menus = Menu::with('category')->orderBy('quantity', 'desc')->get();
            $raws = Inventory::with('category')->orderBy('quantity', 'desc')->get();
            foreach ($menus as $menu){ 
                $result = new stdClass();
                $result->name = $menu->name;
                $result->category = $menu->category->name;
                $result->quantity = $menu->quantity;
                $results[] = $result;
            }
            foreach ($raws as $raw){ 
                $result = new stdClass();
                $result->name = $raw->name;
                $result->category = $raw->category->name;
                $result->quantity = $raw->quantity;
                $results[] = $result;
            }

            $resultsCount = count($results);
        }else if($category == 'waste'){
            if($report == 'raw'){
                $results = DB::table('wastes')
                    ->select('wastes.iid', 'wastes.created_at','wastes.quantity', 'inventories.name', 'wastes.cost')
                    ->join('inventories', 'wastes.iid', '=', 'inventories.id')
                    ->where('wastes.on', 'INVENTORY')
                    ->where('wastes.created_at', '>=', $startDate)
                    ->where('wastes.created_at', '<', $endDate)
                    ->orderBy('wastes.created_at', 'desc')
                    ->get();
            }else if($report == 'menu'){
                $results = DB::table('wastes')
                    ->select('wastes.iid', 'wastes.created_at','wastes.quantity', 'menus.name', 'wastes.cost')
                    ->join('menus', 'wastes.iid', '=', 'menus.id')
                    ->where('wastes.on', 'MENU')
                    ->where('wastes.created_at', '>=', $startDate)
                    ->where('wastes.created_at', '<', $endDate)
                    ->orderBy('wastes.created_at', 'desc')
                    ->get();
            }

            $resultsCount = $results->count();
        }

        return view('admin.reports.list', compact('results', 'settings', 'category', 'resultsCount', 'startDate', 'endDate', 'report'));
    }














    public function print($start, $end, $category, $report){
        $settings = DB::table('settings')->where('id', 1)->first();
        $startDate = date('Y-m-d H:i:s', strtotime($start));
        $endDate = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($end)));

        // $startDate = date('M j, Y', strtotime($start));
        // $endDate = date('M j, Y', strtotime($end));

        if($category == 'sales'){

            $results = DB::table('transactions')
                ->select('transactions.id', 'transactions.number as nn', 'transactions.total as amount', 'transactions.mode_of_payment', 'transactions.type', 'transactions.created_at as date', 'users.name as cashier')
                ->join('users', 'transactions.cashier', '=', 'users.id')
                // ->whereBetween('created_at', [$start, $end])
                ->where('transactions.created_at', '>=', $startDate)
                ->where('transactions.created_at', '<', $endDate)
                ->where('transactions.status', 'PAID')
                ->where('transactions.order_status', '!=', 'CANCELLED')
                ->orderBy('transactions.id', 'desc')
                ->get();
            
            $resultsCount = $results->count();

            if($report == 'summary'){
                return view('admin.reports.print_summary_se', compact('results', 'settings', 'category', 'resultsCount', 'startDate', 'endDate', 'report'));
            }

        }else if($category == 'expenses'){
            if($report == 'unpaid'){
                $results = DB::table('inventory_transactions')
                    ->select('inventory_transactions.id as id','inventory_transactions.is_paid as is_paid','inventory_transactions.created_at as date', 'inventory_transactions.inv_id as inv_id', 'inventories.name as nn', 'inventory_transactions.amount as amount', 'inventory_transactions.quantity as quantity', 'inventory_transactions.remarks as remarks', 'users.name as cashier')
                    ->leftJoin('inventories', 'inventory_transactions.inv_id', '=', 'inventories.id')
                    ->join('users', 'inventory_transactions.user_id', '=', 'users.id')
                    // ->whereBetween('inventory_transactions.created_at', [$startDate, $endDate])
                    ->where('inventory_transactions.created_at', '>=', $startDate)
                    ->where('inventory_transactions.created_at', '<', $endDate)
                    ->where('inventory_transactions.type', 'INCOMING')
                    ->where('inventory_transactions.is_paid', 0)
                    ->orderBy('inventory_transactions.created_at', 'desc')
                    ->get();
            }else{
                $results = DB::table('inventory_transactions')
                    ->select('inventory_transactions.id as id','inventory_transactions.is_paid as is_paid','inventory_transactions.created_at as date', 'inventory_transactions.inv_id as inv_id', 'inventories.name as nn', 'inventory_transactions.amount as amount', 'inventory_transactions.quantity as quantity', 'inventory_transactions.remarks as remarks', 'users.name as cashier')
                    ->leftJoin('inventories', 'inventory_transactions.inv_id', '=', 'inventories.id')
                    ->join('users', 'inventory_transactions.user_id', '=', 'users.id')
                    // ->whereBetween('inventory_transactions.created_at', [$startDate, $endDate])
                    ->where('inventory_transactions.created_at', '>=', $startDate)
                    ->where('inventory_transactions.created_at', '<', $endDate)
                    ->where('inventory_transactions.type', 'INCOMING')
                    ->orderBy('inventory_transactions.created_at', 'desc')
                    ->get();
            }

            // $results = DB::table('inventory_transactions')
            //     ->select('inventory_transactions.created_at as date', 'inventories.name as nn', 'inventory_transactions.amount as amount', 'inventory_transactions.quantity as quantity', 'inventory_transactions.inv_id as inv_id', 'inventory_transactions.remarks as remarks')
            //     ->leftJoin('inventories', 'inventory_transactions.inv_id', '=', 'inventories.id')
            //     // ->whereBetween('inventory_transactions.created_at', [$start, $end])
            //     ->where('inventory_transactions.created_at', '>=', $startDate)
            //     ->where('inventory_transactions.created_at', '<', $endDate)
            //     ->where('inventory_transactions.type', 'INCOMING')
            //     ->orderBy('inventory_transactions.id', 'desc')
            //     ->get();
            
            $resultsCount = $results->count();

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
                // ->whereBetween('created_at', [$start, $end])
                ->where('created_at', '>=', $startDate)
                ->where('created_at', '<', $endDate)
                ->groupBy('date');

            $expensesQuery = DB::table('inventory_transactions')
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('0 as stotal'),
                    DB::raw('SUM(amount) as etotal')
                )
                ->where('type', 'INCOMING')
                // ->whereBetween('created_at', [$start, $end])
                ->where('created_at', '>=', $startDate)
                ->where('created_at', '<', $endDate)
                ->groupBy('date');

            $results = $salesQuery->union($expensesQuery)->orderBy('date')->get();

            return view('admin.reports.print_summary_sec', compact('results', 'category', 'settings', 'startDate', 'endDate', 'report'));
        }else if($category == 'inventory'){

            if($report == 'logs'){
                $results = DB::table('inventory_transactions')
                    ->select('inventory_transactions.created_at as date', 'inventories.name as nn', 'inventory_transactions.amount as amount', 'inventory_transactions.quantity as quantity', 'inventory_transactions.quantity_before as quantity_before', 'inventory_transactions.quantity_after as quantity_after', 'inventory_transactions.remarks as remarks')
                    ->join('inventories', 'inventory_transactions.inv_id', '=', 'inventories.id')
                    // ->whereBetween('inventory_transactions.created_at', [$startDate, $endDate])
                    ->where('inventory_transactions.created_at', '>=', $startDate)
                    ->where('inventory_transactions.created_at', '<', $endDate)
                    ->where('inventory_transactions.type', 'OUTGOING')
                    ->orderBy('inventory_transactions.id', 'desc')
                    ->get();
                
                $resultsCount = $results->count();
            }else{
                $results = DB::table('inventories')
                    ->select('inventories.created_at as date', 'inventories.name as nn', 'categories.name as cn', 'inventories.quantity as quantity')
                    ->join('categories', 'inventories.category_id', '=', 'categories.id')
                    ->orderBy('inventories.name', 'asc')
                    ->get();

                $resultsCount = $results->count();
            }
        }else if($category == 'menu'){
            if($report == 'rank'){
                $results = DB::table('ordered')
                    ->select('ordered.menu_id', 'menus.name', DB::raw('SUM(ordered.quantity) as quantity'))
                    ->join('menus', 'ordered.menu_id', '=', 'menus.id')
                    ->groupBy('ordered.menu_id', 'menus.name')
                    ->where('ordered.created_at', '>=', $startDate)
                    ->where('ordered.created_at', '<', $endDate)
                    ->orderBy('quantity', 'desc')
                    ->get();
            }else if($report == 'stock'){
                $results = Menu::with('category')->orderBy('quantity', 'desc')->get();
            }

            $resultsCount = $results->count();
        }else if($category == 'invmenu'){
            $results = Menu::with('category')->get();

            dd($results);
            

            $resultsCount = $results->count();
        }else if($category == 'waste'){
            if($report == 'raw'){
                $results = DB::table('wastes')
                    ->select('wastes.iid', 'wastes.created_at','wastes.quantity', 'inventories.name', 'wastes.cost')
                    ->join('inventories', 'wastes.iid', '=', 'inventories.id')
                    ->where('wastes.on', 'INVENTORY')
                    ->where('wastes.created_at', '>=', $startDate)
                    ->where('wastes.created_at', '<', $endDate)
                    ->orderBy('wastes.created_at', 'desc')
                    ->get();
            }else if($report == 'menu'){
                $results = DB::table('wastes')
                    ->select('wastes.iid', 'wastes.created_at','wastes.quantity', 'menus.name', 'wastes.cost')
                    ->join('menus', 'wastes.iid', '=', 'menus.id')
                    ->where('wastes.on', 'MENU')
                    ->where('wastes.created_at', '>=', $startDate)
                    ->where('wastes.created_at', '<', $endDate)
                    ->orderBy('wastes.created_at', 'desc')
                    ->get();
            }

            $resultsCount = $results->count();
        }

        if($report == 'list' || $report == 'logs' || $report == 'stock' || $report == 'rank' || $category == 'waste' || $report == 'unpaid'){
            return view('admin.reports.print_list', compact('results', 'settings', 'category', 'resultsCount', 'startDate', 'endDate', 'report'));
        }else if($report == 'summary'){
            return view('admin.reports.print_summary_se', compact('results', 'settings'));
        }
    }

    public function payExpenses(Request $request){
        DB::table('inventory_transactions')->where('id', $request->id)->update([
            'is_paid' => 1,
            'created_at' => date('Y-m-d', strtotime($request->date)).' '.date('H:i:s')
        ]);

        echo 'Mard as Paid Successful';
    }











    public function updateExpenses(Request $request){
        // dd($request->id);
        // dd(date('Y-m-d', strtotime($request->date)).' '.date('H:i:s'));
        $it = DB::table('inventory_transactions')->where('id', $request->id)->first();
        if($it->inv_id != 0){
            $item = DB::table('inventories')->where('id', $it->inv_id)->first();
        }

        if($request->quantity > $it->quantity){
            if($item->quantity < ($request->quantity - $it->quantity)){
                echo 'Invalid Quantity';
            }else{
                if($it->inv_id != 0){
                    DB::table('inventories')->where('id', $item->id)->update([
                        'quantity' => $item->quantity - ($request->quantity - $it->quantity)
                    ]);
                }

                DB::table('inventory_transactions')->where('id', $request->id)->update([
                    'remarks' => $request->name,
                    'amount' => $request->amount,
                    'quantity' => $request->quantity,
                    'quantity_after' => $it->quantity_before + $request->quantity,
                    'created_at' => date('Y-m-d', strtotime($request->date)).' '.date('H:i:s'),
                ]);

                echo 'Update Successful';
            }
        }else{
            if($it->inv_id != 0){
                DB::table('inventories')->where('id', $item->id)->update([
                    'quantity' => $item->quantity + ($it->quantity - $request->quantity)
                ]);
            }
            
            DB::table('inventory_transactions')->where('id', $request->id)->update([
                'remarks' => $request->name,
                'amount' => $request->amount,
                'quantity' => $request->quantity,
                'quantity_after' => $it->quantity_before + $request->quantity,
                'created_at' => date('Y-m-d', strtotime($request->date)).' '.date('H:i:s'),
            ]);

            echo 'Update Successful';
        }
    }

    public function deleteExpenses(Request $request){
        DB::table('inventory_transactions')->where('id', $request->id)->delete();

        echo 'Delete Successful';
    }









    public function updateSales(Request $request){
        $tran = Transaction::where('id', $request->id)->first();
        $tran->total = $request->amount;
        if(date('Y-m-d', strtotime($tran->created_at)) != date('Y-m-d', strtotime($request->date))){
            $tran->created_at = date('Y-m-d', strtotime($request->date)).' '.date('H:i:s');
        }
        $tran->save();

        echo 'Update Successful';
    }

    public function deleteSales(Request $request){
        Transaction::where('id', $request->id)->delete();

        echo 'Delete Successful';
    }












}
