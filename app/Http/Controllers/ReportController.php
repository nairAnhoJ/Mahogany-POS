<?php

namespace App\Http\Controllers;

use App\Models\ActualMoney;
use App\Models\Ingredient;
use App\Models\Inventory;
use App\Models\InventoryTransaction;
use App\Models\Menu;
use App\Models\MenuIndex;
use App\Models\Ordered;
use App\Models\PricingReport;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\Waste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class ReportController extends Controller {
    public function index() {

        return view('admin.reports.index');
    }














    public function generate(Request $request) {
        $start = $request->start;
        $end = $request->end;
        $startDate = date('Y-m-d H:i:s', strtotime($start));
        $endDate = date('Y-m-d H:i:s', strtotime($end));

        $category = $request->category;
        $report = $request->report;

        $settings = DB::table('settings')->where('id', 1)->first();

        if ($category == 'sales') {
            $results = Transaction::with('thisCashier')
                ->where('transactions.created_at', '>=', $startDate)
                ->where('transactions.created_at', '<', $endDate)
                ->where('transactions.status', 'PAID')
                ->where('transactions.order_status', '!=', 'CANCELLED')
                ->orderBy('transactions.id', 'desc')
                ->get();

            // $results = DB::table('transactions')
            //     ->select('transactions.id', 'transactions.number as nn', 'transactions.total as amount', 'transactions.mode_of_payment', 'transactions.type', 'transactions.created_at as date', 'users.name as cashier')
            //     ->join('users', 'transactions.cashier', '=', 'users.id')
            //     // ->whereBetween('created_at', [$startDate, $endDate])
            //     ->where('transactions.created_at', '>=', $startDate)
            //     ->where('transactions.created_at', '<', $endDate)
            //     ->where('transactions.status', 'PAID')
            //     ->where('transactions.order_status', '!=', 'CANCELLED')
            //     ->orderBy('transactions.id', 'desc')
            //     ->get();

            $resultsCount = $results->count();


            if ($report == 'summary') {
                return view('admin.reports.summary_se', compact('results', 'settings', 'category', 'resultsCount', 'startDate', 'endDate', 'report'));
            }
        } else if ($category == 'expenses') {
            if ($report == 'unpaid') {
                $results = InventoryTransaction::with('user', 'inv')
                    ->where('created_at', '>=', $startDate)
                    ->where('created_at', '<', $endDate)
                    ->where('type', 'INCOMING')
                    ->where('is_paid', 0)
                    ->orderBy('created_at', 'desc')
                    ->get();

                // $results = DB::table('inventory_transactions')
                //     ->select('inventory_transactions.id as id','inventory_transactions.created_at as date', 'inventory_transactions.inv_id as inv_id', 'inventories.name as nn', 'inventory_transactions.amount as amount', 'inventory_transactions.quantity as quantity', 'inventory_transactions.remarks as remarks', 'users.name as cashier')
                //     ->leftJoin('inventories', 'inventory_transactions.inv_id', '=', 'inventories.id')
                //     ->join('users', 'inventory_transactions.user_id', '=', 'users.id')
                //     ->where('inventory_transactions.created_at', '>=', $startDate)
                //     ->where('inventory_transactions.created_at', '<', $endDate)
                //     ->where('inventory_transactions.type', 'INCOMING')
                //     ->where('inventory_transactions.is_paid', 0)
                //     ->orderBy('inventory_transactions.created_at', 'desc')
                //     ->get();
            } else {
                $results = InventoryTransaction::with('user', 'inv')
                    ->where('created_at', '>=', $startDate)
                    ->where('created_at', '<', $endDate)
                    ->where('type', 'INCOMING')
                    ->orderBy('created_at', 'desc')
                    ->get();



                // $results = DB::table('inventory_transactions')
                //     ->select('inventory_transactions.id as id','inventory_transactions.is_paid as is_paid','inventory_transactions.created_at as date', 'inventory_transactions.inv_id as inv_id', 'inventories.name as nn', 'inventory_transactions.amount as amount', 'inventory_transactions.quantity as quantity', 'inventory_transactions.remarks as remarks', 'users.name as cashier')
                //     ->leftJoin('inventories', 'inventory_transactions.inv_id', '=', 'inventories.id')
                //     ->join('users', 'inventory_transactions.user_id', '=', 'users.id')
                //     ->where('inventory_transactions.created_at', '>=', $startDate)
                //     ->where('inventory_transactions.created_at', '<', $endDate)
                //     ->where('inventory_transactions.type', 'INCOMING')
                //     ->orderBy('inventory_transactions.created_at', 'desc')
                //     ->get();
            }

            $resultsCount = $results->count();


            if ($report == 'summary') {
                return view('admin.reports.summary_se', compact('results', 'settings', 'category', 'resultsCount', 'startDate', 'endDate', 'report'));
            }
        } else if ($category == 'both') {
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

            if ($report == 'summary') {
                return view('admin.reports.summary_sec', compact('results', 'category', 'settings', 'startDate', 'endDate', 'report'));
            }
        } else if ($category == 'inventory') {
            if ($report == 'logs') {
                $results = InventoryTransaction::with('user', 'inv')
                    ->where('created_at', '>=', $startDate)
                    ->where('created_at', '<', $endDate)
                    ->where('type', 'OUTGOING')
                    ->orderBy('id', 'desc')
                    ->get();


                // $results = DB::table('inventory_transactions')
                //     ->select('inventory_transactions.created_at as date', 'inventories.name as nn', 'inventory_transactions.amount as amount', 'inventory_transactions.quantity as quantity', 'inventory_transactions.quantity_before as quantity_before', 'inventory_transactions.quantity_after as quantity_after', 'inventory_transactions.remarks as remarks')
                //     ->join('inventories', 'inventory_transactions.inv_id', '=', 'inventories.id')
                //     ->where('inventory_transactions.created_at', '>=', $startDate)
                //     ->where('inventory_transactions.created_at', '<', $endDate)
                //     ->where('inventory_transactions.type', 'OUTGOING')
                //     ->orderBy('inventory_transactions.id', 'desc')
                //     ->get();
            } else {
                $results = Inventory::with('category')
                    ->orderBy('name', 'asc')
                    ->get();

                // $results = DB::table('inventories')
                //     ->select('inventories.created_at as date', 'inventories.name as nn', 'categories.name as cn', 'inventories.quantity as quantity')
                //     ->join('categories', 'inventories.category_id', '=', 'categories.id')
                //     ->orderBy('inventories.name', 'asc')
                //     ->get();
            }

            $resultsCount = $results->count();
        } else if ($category == 'menu') {
            if ($report == 'rank') {
                $results = DB::table('ordered')
                    ->select('ordered.menu_id', 'menus.name', DB::raw('SUM(ordered.quantity) as quantity'))
                    ->join('menus', 'ordered.menu_id', '=', 'menus.id')
                    ->groupBy('ordered.menu_id', 'menus.name')
                    ->where('ordered.created_at', '>=', $startDate)
                    ->where('ordered.created_at', '<', $endDate)
                    ->orderBy('quantity', 'desc')
                    ->get();
            } else if ($report == 'stock') {
                $results = Menu::with('category')->orderBy('quantity', 'desc')->get();
            }

            $resultsCount = $results->count();
        } else if ($category == 'invmenu') {
            $results = [];
            $menus = Menu::with('category')->orderBy('quantity', 'desc')->get();
            $raws = Inventory::with('category')->orderBy('quantity', 'desc')->get();
            foreach ($menus as $menu) {
                $result = new stdClass();
                $result->name = $menu->name;
                $result->category = $menu->category->name;
                $result->quantity = $menu->quantity;
                $results[] = $result;
            }
            foreach ($raws as $raw) {
                $result = new stdClass();
                $result->name = $raw->name;
                $result->category = $raw->category->name;
                $result->quantity = $raw->quantity;
                $results[] = $result;
            }
            $resultsCount = count($results);
        } else if ($category == 'waste') {
            if ($report == 'raw') {
                $results = DB::table('wastes')
                    ->select('wastes.iid', 'wastes.created_at', 'wastes.quantity', 'inventories.name', 'wastes.cost')
                    ->join('inventories', 'wastes.iid', '=', 'inventories.id')
                    ->where('wastes.on', 'INVENTORY')
                    ->where('wastes.created_at', '>=', $startDate)
                    ->where('wastes.created_at', '<', $endDate)
                    ->orderBy('wastes.created_at', 'desc')
                    ->get();
            } else if ($report == 'menu') {
                $results = DB::table('wastes')
                    ->select('wastes.iid', 'wastes.created_at', 'wastes.quantity', 'menus.name', 'wastes.cost')
                    ->join('menus', 'wastes.iid', '=', 'menus.id')
                    ->where('wastes.on', 'MENU')
                    ->where('wastes.created_at', '>=', $startDate)
                    ->where('wastes.created_at', '<', $endDate)
                    ->orderBy('wastes.created_at', 'desc')
                    ->get();
            }

            $resultsCount = $results->count();
        } else if ($category == 'remit') {
            $sales = Transaction::select(DB::raw('SUM(total) as total'))
                ->where('created_at', '>=', $startDate)
                ->where('created_at', '<', $endDate)
                ->where('transactions.status', 'PAID')
                ->where('transactions.order_status', '!=', 'CANCELLED')
                ->where('mode_of_payment', 'CASH')
                ->get();

            $expenses = InventoryTransaction::select(DB::raw('SUM(amount) as amount'))
                ->where('created_at', '>=', $startDate)
                ->where('created_at', '<', $endDate)
                ->where('type', 'INCOMING')
                ->where('is_paid', 1)
                ->get();

            $results = [];

            $salesObj = new stdClass();
            $salesObj->name = 'Sales';
            $salesObj->amount = $sales[0]->total;
            $results[] = $salesObj;

            $expObj = new stdClass();
            $expObj->name = 'Expenses';
            $expObj->amount = $expenses[0]->amount;
            $results[] = $expObj;

            $totalObj = new stdClass();
            $totalObj->name = 'Total';
            $totalObj->amount = $sales[0]->total - $expenses[0]->amount;
            $results[] = $totalObj;

            $resultsCount = 1;
        }

        return view('admin.reports.list', compact('results', 'settings', 'category', 'resultsCount', 'startDate', 'endDate', 'report'));
    }














    public function print($start, $end, $category, $report) {
        $settings = DB::table('settings')->where('id', 1)->first();
        $startDate = date('Y-m-d H:i:s', strtotime($start));
        $endDate = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($end)));

        // $startDate = date('M j, Y', strtotime($start));
        // $endDate = date('M j, Y', strtotime($end));

        if ($category == 'sales') {

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

            if ($report == 'summary') {
                return view('admin.reports.print_summary_se', compact('results', 'settings', 'category', 'resultsCount', 'startDate', 'endDate', 'report'));
            }
        } else if ($category == 'expenses') {
            if ($report == 'unpaid') {
                $results = DB::table('inventory_transactions')
                    ->select('inventory_transactions.id as id', 'inventory_transactions.is_paid as is_paid', 'inventory_transactions.created_at as date', 'inventory_transactions.inv_id as inv_id', 'inventories.name as nn', 'inventory_transactions.amount as amount', 'inventory_transactions.quantity as quantity', 'inventory_transactions.remarks as remarks', 'users.name as cashier')
                    ->leftJoin('inventories', 'inventory_transactions.inv_id', '=', 'inventories.id')
                    ->join('users', 'inventory_transactions.user_id', '=', 'users.id')
                    // ->whereBetween('inventory_transactions.created_at', [$startDate, $endDate])
                    ->where('inventory_transactions.created_at', '>=', $startDate)
                    ->where('inventory_transactions.created_at', '<', $endDate)
                    ->where('inventory_transactions.type', 'INCOMING')
                    ->where('inventory_transactions.is_paid', 0)
                    ->orderBy('inventory_transactions.created_at', 'desc')
                    ->get();
            } else {
                $results = DB::table('inventory_transactions')
                    ->select('inventory_transactions.id as id', 'inventory_transactions.is_paid as is_paid', 'inventory_transactions.created_at as date', 'inventory_transactions.inv_id as inv_id', 'inventories.name as nn', 'inventory_transactions.amount as amount', 'inventory_transactions.quantity as quantity', 'inventory_transactions.remarks as remarks', 'users.name as cashier')
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

            if ($report == 'summary') {
                return view('admin.reports.print_summary_se', compact('results', 'settings', 'category', 'resultsCount', 'startDate', 'endDate', 'report'));
            }
        } else if ($category == 'both') {
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
        } else if ($category == 'inventory') {

            if ($report == 'logs') {
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
            } else {
                $results = DB::table('inventories')
                    ->select('inventories.created_at as date', 'inventories.name as nn', 'categories.name as cn', 'inventories.quantity as quantity')
                    ->join('categories', 'inventories.category_id', '=', 'categories.id')
                    ->orderBy('inventories.name', 'asc')
                    ->get();

                $resultsCount = $results->count();
            }
        } else if ($category == 'menu') {
            if ($report == 'rank') {
                $results = DB::table('ordered')
                    ->select('ordered.menu_id', 'menus.name', DB::raw('SUM(ordered.quantity) as quantity'))
                    ->join('menus', 'ordered.menu_id', '=', 'menus.id')
                    ->groupBy('ordered.menu_id', 'menus.name')
                    ->where('ordered.created_at', '>=', $startDate)
                    ->where('ordered.created_at', '<', $endDate)
                    ->orderBy('quantity', 'desc')
                    ->get();
            } else if ($report == 'stock') {
                $results = Menu::with('category')->orderBy('quantity', 'desc')->get();
            }

            $resultsCount = $results->count();
        } else if ($category == 'invmenu') {
            $results = Menu::with('category')->get();

            dd($results);


            $resultsCount = $results->count();
        } else if ($category == 'waste') {
            if ($report == 'raw') {
                $results = DB::table('wastes')
                    ->select('wastes.iid', 'wastes.created_at', 'wastes.quantity', 'inventories.name', 'wastes.cost')
                    ->join('inventories', 'wastes.iid', '=', 'inventories.id')
                    ->where('wastes.on', 'INVENTORY')
                    ->where('wastes.created_at', '>=', $startDate)
                    ->where('wastes.created_at', '<', $endDate)
                    ->orderBy('wastes.created_at', 'desc')
                    ->get();
            } else if ($report == 'menu') {
                $results = DB::table('wastes')
                    ->select('wastes.iid', 'wastes.created_at', 'wastes.quantity', 'menus.name', 'wastes.cost')
                    ->join('menus', 'wastes.iid', '=', 'menus.id')
                    ->where('wastes.on', 'MENU')
                    ->where('wastes.created_at', '>=', $startDate)
                    ->where('wastes.created_at', '<', $endDate)
                    ->orderBy('wastes.created_at', 'desc')
                    ->get();
            }

            $resultsCount = $results->count();
        }

        if ($report == 'list' || $report == 'logs' || $report == 'stock' || $report == 'rank' || $category == 'waste' || $report == 'unpaid') {
            return view('admin.reports.print_list', compact('results', 'settings', 'category', 'resultsCount', 'startDate', 'endDate', 'report'));
        } else if ($report == 'summary') {
            return view('admin.reports.print_summary_se', compact('results', 'settings'));
        }
    }















    public function payExpenses(Request $request) {
        DB::table('inventory_transactions')->where('id', $request->id)->update([
            'is_paid' => 1,
            'created_at' => date('Y-m-d', strtotime($request->date)) . ' ' . date('H:i:s')
        ]);

        echo 'Mard as Paid Successful';
    }











    public function updateExpenses(Request $request) {
        $it = DB::table('inventory_transactions')->where('id', $request->id)->first();
        if ($it->inv_id != 0) {
            $item = DB::table('inventories')->where('id', $it->inv_id)->first();
        }

        if ($request->quantity > $it->quantity) {
            if ($item->quantity < ($request->quantity - $it->quantity)) {
                echo 'Invalid Quantity';
            } else {
                if ($it->inv_id != 0) {
                    DB::table('inventories')->where('id', $item->id)->update([
                        'quantity' => $item->quantity - ($request->quantity - $it->quantity)
                    ]);
                }

                DB::table('inventory_transactions')->where('id', $request->id)->update([
                    'remarks' => $request->name,
                    'amount' => $request->amount,
                    'quantity' => $request->quantity,
                    'quantity_after' => $it->quantity_before + $request->quantity,
                    'created_at' => $request->date,
                ]);

                echo 'Update Successful';
            }
        } else {
            if ($it->inv_id != 0) {
                DB::table('inventories')->where('id', $item->id)->update([
                    'quantity' => $item->quantity + ($it->quantity - $request->quantity)
                ]);
            }

            DB::table('inventory_transactions')->where('id', $request->id)->update([
                'remarks' => $request->name,
                'amount' => $request->amount,
                'quantity' => $request->quantity,
                'quantity_after' => $it->quantity_before + $request->quantity,
                'created_at' => $request->date,
            ]);

            echo 'Update Successful';
        }
    }

    public function deleteExpenses(Request $request) {
        DB::table('inventory_transactions')->where('id', $request->id)->delete();

        echo 'Delete Successful';
    }









    public function updateSales(Request $request) {
        $tran = Transaction::where('id', $request->id)->first();
        $tran->total = $request->amount;
        $tran->created_at = $request->date;
        $tran->save();

        echo 'Update Successful';
    }

    public function deleteSales(Request $request) {
        Transaction::where('id', $request->id)->delete();

        echo 'Delete Successful';
    }






    public function financialReport(){
        $lastDay = date('t');
        $month = date('m');
        $year = date('Y');
        $startDate = $year.'-'.$month.'-01 00:00:01';
        $endDate = $year.'-'.$month.'-31 23:59:59';

        $sales = Transaction::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total_per_day'))
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<', $endDate)
            ->where('status', 'PAID')
            ->where('order_status', '!=', 'CANCELLED')
            ->groupBy('date')
            ->get();

        $expenses = InventoryTransaction::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total_per_day'))
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<', $endDate)
            ->where('type', 'INCOMING')
            ->where('is_paid', 1)
            ->groupBy('date')
            ->get();

        $actuals = ActualMoney::where('date', '>=', $startDate)
            ->where('date', '<', $endDate)
            ->get();

        $account_payables = InventoryTransaction::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total_per_day'))
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<', $endDate)
            ->where('type', 'INCOMING')
            ->where('is_paid', 0)
            ->groupBy('date')
            ->get();

        return view('admin.reports.financial-report', compact('sales', 'expenses', 'actuals', 'account_payables', 'month', 'year', 'lastDay'));
    }

    public function generateFinancialReport(Request $request){
        $lastDay = date('t');
        $month = $request->month;
        $year = $request->year;
        $startDate = $year.'-'.$month.'-01 00:00:01';
        $endDate = $year.'-'.$month.'-31 23:59:59';

        $sales = Transaction::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total_per_day'))
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<', $endDate)
            ->where('status', 'PAID')
            ->where('order_status', '!=', 'CANCELLED')
            ->groupBy('date')
            ->get();

        $expenses = InventoryTransaction::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total_per_day'))
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<', $endDate)
            ->where('type', 'INCOMING')
            ->where('is_paid', 1)
            ->groupBy('date')
            ->get();

        $actuals = ActualMoney::where('date', '>=', $startDate)
            ->where('date', '<', $endDate)
            ->get();

        $account_payables = InventoryTransaction::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total_per_day'))
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<', $endDate)
            ->where('type', 'INCOMING')
            ->where('is_paid', 0)
            ->groupBy('date')
            ->get();

        return view('admin.reports.financial-report', compact('sales', 'expenses', 'actuals', 'account_payables', 'month', 'year', 'lastDay'));
    }
    
    public function getActual(Request $request){
        $actual = ActualMoney::where('date', $request->date)->first();

        echo json_encode($actual);
    }
    
    public function updateActual(Request $request){
        $date = $request->date;
        $liquid_cash = $request->liquid_cash;
        $cash_on_hand = $request->cash_on_hand;
        $gcash = $request->gcash;
        $bank = $request->bank;
        $pending_remit = $request->pending_remit;

        $actual = ActualMoney::where('date', $date)->first();
        if($actual == null){
            $actual = new ActualMoney;
            $actual->date = $date;
        }
        $actual->liquid_cash = $liquid_cash;
        $actual->cash_on_hand = $cash_on_hand;
        $actual->gcash = $gcash;
        $actual->bank = $bank;
        $actual->pending_remit = $pending_remit;
        $actual->save();

        echo 'Financial Report has been updated successfully.';
    }









    public function pricingReport(){
        $setting = Setting::where('id', 1)->first();
        $menus = Menu::where('is_combo', 0)->where('is_deleted', 0)->where('is_hidden', 0)->get();

        if (date('j') == 1) {
            PricingReport::query()->update(['previous_price_per_serving_2' => DB::raw('previous_price_per_serving_1')]);
            PricingReport::query()->update(['previous_price_per_serving_1' => DB::raw('price_per_servings')]);
        }

        foreach($menus as $menu){
            $ingredient_expense = 0;
            $ingredients = Ingredient::where('menu_id', $menu->id)->where('is_deleted', 0)->get();

            foreach($ingredients as $ing){
                $inv_tran = InventoryTransaction::where('inv_id', $ing->inventory_id)->where('type', 'INCOMING')->orderBy('id','desc')->first();
                $price_per_unit = $inv_tran->amount / $inv_tran->quantity;
                $price = $ing->quantity * $price_per_unit;
                $ingredient_expense += $price;
            }

            $ingredient_expense_per_serving = $ingredient_expense / $menu->servings;

            $after_buffer_margin = $ingredient_expense + ($ingredient_expense * (float)$setting->buffer_margin);
            $after_markup = $after_buffer_margin + ($after_buffer_margin * (float)$setting->markup);
            $after_price_adjustment = $after_markup + ($after_markup * (float)$setting->price_adjustment);
            $after_staff_incentives = $after_price_adjustment + (float)$setting->staff_incentives;
            $after_manager_incentives = $after_staff_incentives + ($after_staff_incentives * (float)$setting->manager_incentives);
            $after_vat = $after_manager_incentives + ($after_manager_incentives * (float)$setting->vat);

            $total_expense = $after_vat;
            $price_per_serving = $total_expense / $menu->servings;

            $menuPricingReport = PricingReport::where('menu_id', $menu->id)->first();

            if($menuPricingReport == null){
                $menuPricingReport = new PricingReport();
            }
            $menuPricingReport->menu_id = $menu->id;
            $menuPricingReport->menu = $menu->name;
            $menuPricingReport->ingredient_expense = $ingredient_expense_per_serving;
            $menuPricingReport->number_of_servings = $menu->servings;
            $menuPricingReport->price_per_servings = $price_per_serving;
            $menuPricingReport->selling_price = $menu->price;
            $menuPricingReport->additional_income = $menu->price - $price_per_serving;
            $menuPricingReport->save();
        }

        
        $menus = Menu::where('is_combo', 1)->where('is_deleted', 0)->where('is_hidden', 0)->where('id', 6)->get();

        foreach($menus as $menu){
            $ingredient_expense = 0;
            $ingredients = Ingredient::where('menu_id', $menu->id)->where('is_deleted', 0)->get();

            foreach($ingredients as $ing){
                $pr = PricingReport::where('menu_id', $ing->inventory_id)->first();
                $price = $pr->ingredient_expense / $pr->number_of_servings;
                $totalPrice = $price * $ing->quantity;
                $ingredient_expense += $totalPrice;
            }

            $ingredient_expense_per_serving = $ingredient_expense / $menu->servings;

            $after_buffer_margin = $ingredient_expense + ($ingredient_expense * (float)$setting->buffer_margin);
            $after_markup = $after_buffer_margin + ($after_buffer_margin * (float)$setting->markup);
            $after_price_adjustment = $after_markup + ($after_markup * (float)$setting->price_adjustment);
            $after_staff_incentives = $after_price_adjustment + (float)$setting->staff_incentives;
            $after_manager_incentives = $after_staff_incentives + ($after_staff_incentives * (float)$setting->manager_incentives);
            $after_vat = $after_manager_incentives + ($after_manager_incentives * (float)$setting->vat);

            $total_expense = $after_vat;
            $price_per_serving = $total_expense / $menu->servings;

            $menuPricingReport = PricingReport::where('menu_id', $menu->id)->first();

            if($menuPricingReport == null){
                $menuPricingReport = new PricingReport();
            }
            $menuPricingReport->menu_id = $menu->id;
            $menuPricingReport->menu = $menu->name;
            $menuPricingReport->ingredient_expense = $ingredient_expense_per_serving;
            $menuPricingReport->number_of_servings = $menu->servings;
            $menuPricingReport->price_per_servings = $price_per_serving;
            $menuPricingReport->selling_price = $menu->price;
            $menuPricingReport->additional_income = $menu->price - $price_per_serving;
            $menuPricingReport->save();
        }

        $pricingReports = PricingReport::get();

        return view('admin.reports.pricing-report', compact('pricingReports'));
    }

    public function viewPricingReport(Request $request){
        $pricingReport = PricingReport::where('id', $request->id)->first();
        $menu = Menu::where('id', $pricingReport->menu_id)->first();
        $setting = Setting::where('id', 1)->first();
        $result = '';
        $ingrow = '';
        
        $buffer_percent = (float)$setting->buffer_margin * 100;
        $markup_percent = (float)$setting->markup * 100;
        $adjustment_percent = (float)$setting->price_adjustment * 100;
        $staff_incentive = (float)$setting->staff_incentives;
        $incentive_percent = (float)$setting->manager_incentives * 100;
        $vat_percent = (float)$setting->vat * 100;

        $ingredient_expense = 0;
        $ingredients = Ingredient::where('menu_id', $menu->id)->where('is_deleted', 0)->get();

        if($menu->is_combo == 1){
            foreach($ingredients as $ing){
                $inv = Menu::where('id', $ing->inventory_id)->first();
                $pr = PricingReport::where('menu_id', $ing->inventory_id)->first();
                $price = $pr->ingredient_expense / $pr->number_of_servings;
                $totalPrice = $price * $ing->quantity;
                $ingredient_expense += $totalPrice;

                $ingrow .= '
                    <tr class="border-b">
                        <td class="px-4 py-1 text-left border-r">
                            '.$inv->name.'
                        </td>
                        <td class="px-4 text-right border-r">
                            '.number_format($ing->quantity, 2, '.', ',').'
                        </td>
                        <td class="px-4 text-right border-r">
                            ₱ '.number_format($price, 2, '.', ',').'
                        </td>
                        <td class="px-4 text-right">
                            ₱ '.number_format($totalPrice, 2, '.', ',').'
                        </td>
                    </tr>
                ';
            }

            $ingredient_expense_per_serving = $ingredient_expense / $menu->servings;
            
            $buffer_margin = $ingredient_expense * (float)$setting->buffer_margin;
            $after_buffer_margin = $ingredient_expense + $buffer_margin;

            $markup = $after_buffer_margin * (float)$setting->markup;
            $after_markup = $after_buffer_margin + $markup;

            $price_adjustment = $after_markup * (float)$setting->price_adjustment;
            $after_price_adjustment = $after_markup + $price_adjustment;

            $staff_incentives = (float)$setting->staff_incentives;
            $after_staff_incentives = $after_price_adjustment + $staff_incentives;

            $manager_incentives = $after_staff_incentives * (float)$setting->manager_incentives;
            $after_manager_incentives = $after_staff_incentives + $manager_incentives;

            $vat = $after_manager_incentives * (float)$setting->vat;
            $after_vat = $after_manager_incentives + $vat;

            $total_expense = $after_vat;
            $price_per_serving = $total_expense / $menu->servings;
        }else{
            foreach($ingredients as $ing){
                $inv = Inventory::where('id', $ing->inventory_id)->first();
                $inv_tran = InventoryTransaction::where('inv_id', $ing->inventory_id)->where('type', 'INCOMING')->orderBy('id','desc')->first();
                $price_per_unit = $inv_tran->amount / $inv_tran->quantity;
                $price = $ing->quantity * $price_per_unit;
                $ingredient_expense += $price;

                $ingrow .= '
                    <tr class="border-b">
                        <td class="px-4 py-1 text-left border-r">
                            '.$inv->name.'
                        </td>
                        <td class="px-4 text-right border-r">
                            '.number_format($ing->quantity, 2, '.', ',').'
                        </td>
                        <td class="px-4 text-right border-r">
                            ₱ '.number_format($price_per_unit, 2, '.', ',').'
                        </td>
                        <td class="px-4 text-right">
                            ₱ '.number_format($price, 2, '.', ',').'
                        </td>
                    </tr>
                ';
            }
    
            $ingredient_expense_per_serving = $ingredient_expense / $menu->servings;
            
            $buffer_margin = $ingredient_expense * (float)$setting->buffer_margin;
            $after_buffer_margin = $ingredient_expense + $buffer_margin;

            $markup = $after_buffer_margin * (float)$setting->markup;
            $after_markup = $after_buffer_margin + $markup;

            $price_adjustment = $after_markup * (float)$setting->price_adjustment;
            $after_price_adjustment = $after_markup + $price_adjustment;

            $staff_incentives = (float)$setting->staff_incentives;
            $after_staff_incentives = $after_price_adjustment + $staff_incentives;

            $manager_incentives = $after_staff_incentives * (float)$setting->manager_incentives;
            $after_manager_incentives = $after_staff_incentives + $manager_incentives;

            $vat = $after_manager_incentives * (float)$setting->vat;
            $after_vat = $after_manager_incentives + $vat;
    
            $total_expense = $after_vat;
            $price_per_serving = $total_expense / $menu->servings;
        }

        $result .= '
            <div class="flex items-center mb-4">
                <p class="text-sm">Yield (# of pax):</p>
                <p class="ml-2 font-medium">'.$menu->servings.'</p>
            </div>
            <div class="w-full border">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="py-1 border-r">
                                Ingredients
                            </th>
                            <th class="border-r">
                                Quantity of Recipe Unit
                            </th>
                            <th class="border-r">
                                Price per Unit
                            </th>
                            <th>
                                Total Cost per Serving
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        '.$ingrow.'

                        <tr class="border-b">
                            <td colspan="3" class="px-4 py-1 text-right border-r">
                                Ingredients Expense
                            </td>
                            <td class="px-4 text-right">
                                ₱ '.number_format($ingredient_expense, 2, '.', ',').'
                            </td>
                        </tr>







                        <tr class="border-b">
                            <td colspan="3" class="px-4 py-1 text-right border-r">
                                '.$buffer_percent.'% Buffer Margin
                            </td>
                            <td class="px-4 text-right">
                                ₱ '.number_format($buffer_margin, 2, '.', ',').'
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td colspan="3" class="px-4 py-1 text-right border-r">
                                Total After Buffer Margin
                            </td>
                            <td class="px-4 font-bold text-right">
                                ₱ '.number_format($after_buffer_margin, 2, '.', ',').'
                            </td>
                        </tr>


                        <tr class="border-b">
                            <td colspan="3" class="px-4 py-1 text-right border-r">
                                '.$markup_percent.'% Markup
                            </td>
                            <td class="px-4 text-right">
                                ₱ '.number_format($markup, 2, '.', ',').'
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td colspan="3" class="px-4 py-1 text-right border-r">
                                Total After Markup
                            </td>
                            <td class="px-4 font-bold text-right">
                                ₱ '.number_format($after_markup, 2, '.', ',').'
                            </td>
                        </tr>


                        <tr class="border-b">
                            <td colspan="3" class="px-4 py-1 text-right border-r">
                                '.$adjustment_percent.'% Price Adjustment for Uncontrollable
                            </td>
                            <td class="px-4 text-right">
                                ₱ '.number_format($price_adjustment, 2, '.', ',').'
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td colspan="3" class="px-4 py-1 text-right border-r">
                                Total After Price Adjustment
                            </td>
                            <td class="px-4 font-bold text-right">
                                ₱ '.number_format($after_price_adjustment, 2, '.', ',').'
                            </td>
                        </tr>


                        <tr class="border-b">
                            <td colspan="3" class="px-4 py-1 text-right border-r">
                                Staff Incentives
                            </td>
                            <td class="px-4 text-right">
                                ₱ '.number_format($staff_incentive, 2, '.', ',').'
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td colspan="3" class="px-4 py-1 text-right border-r">
                                '.$incentive_percent.'% Manager Incentives
                            </td>
                            <td class="px-4 text-right">
                                ₱ '.number_format($manager_incentives, 2, '.', ',').'
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td colspan="3" class="px-4 py-1 text-right border-r">
                                Total After Staff Incen
                            </td>
                            <td class="px-4 font-bold text-right">
                                ₱ '.number_format($after_manager_incentives, 2, '.', ',').'
                            </td>
                        </tr>


                        <tr class="border-b">
                            <td colspan="3" class="px-4 py-1 text-right border-r">
                                '.$vat_percent.'% VAT 12%
                            </td>
                            <td class="px-4 text-right">
                                ₱ '.number_format($vat, 2, '.', ',').'
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td colspan="3" class="px-4 py-1 text-right border-r">
                                Total After VAT
                            </td>
                            <td class="px-4 font-bold text-right">
                                ₱ '.number_format($after_vat, 2, '.', ',').'
                            </td>
                        </tr>


                        <tr class="border-b">
                            <td colspan="3" class="px-4 py-1 text-right border-r">
                                # of Servings
                            </td>
                            <td class="px-4 font-bold text-right">
                                '.$menu->servings.'
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td colspan="3" class="px-4 py-1 text-right border-r">
                                Price Per Serving
                            </td>
                            <td class="px-4 font-bold text-right">
                                ₱ '.number_format($price_per_serving, 2, '.', ',').'
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td colspan="3" class="px-4 py-1 text-right border-r">
                                Final Selling Price
                            </td>
                            <td class="px-4 font-bold text-right">
                                ₱ '.number_format($pricingReport->selling_price, 2, '.', ',').'
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        ';

        echo $result;
    }
}
