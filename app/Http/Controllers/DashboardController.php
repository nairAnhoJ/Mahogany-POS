<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $today = date('Y-m-d');

        $sales = number_format(DB::table('transactions')
            ->whereDate('created_at', $today)
            ->sum('amount'), 2, '.', ',');

        $expenses = number_format(DB::table('inventory_transactions')
            ->where('type', 'INCOMING')
            ->whereDate('created_at', $today)
            ->sum('amount'), 2, '.', ',');

        $profit = number_format(((float) str_replace([','], '', $sales) - (float) str_replace([','], '', $expenses)), 2, '.', ',');

        $table = DB::table('tables')->where('status', 1)->get();

        return view('admin.dashboard', compact('sales', 'expenses', 'profit', 'table'));
    }

    public function change(Request $request){
        $timeframe = $request->val;
        $today = date('Y-m-d');

        if($timeframe == '1'){
            $sales = number_format(DB::table('transactions')
                ->whereDate('created_at', $today)
                ->sum('amount'), 2, '.', ',');
    
            $expenses = number_format(DB::table('inventory_transactions')
                ->where('type', 'INCOMING')
                ->whereDate('created_at', $today)
                ->sum('amount'), 2, '.', ',');

            $daysArray = array();
            $salesArray = array();
            $expensesArray = array();
            $profitArray = array();

            for ($i = 0; $i < 7; $i++) {
                $dayTimestamp = strtotime("-$i days");
                $dayLabel = date('M d', $dayTimestamp);
                $seDate = date('Y-m-d', $dayTimestamp);
                
                $s = DB::table('transactions')
                        ->whereDate('created_at', $seDate)
                        ->sum('amount');
                
                $e = DB::table('inventory_transactions')
                        ->where('type', 'INCOMING')
                        ->whereDate('created_at', $seDate)
                        ->sum('amount');

                array_push($daysArray, $dayLabel);
                array_push($salesArray, $s);
                array_push($expensesArray, $e);
                array_push($profitArray, ($s - $e));
            }
            $labels = array_reverse($daysArray);
            $salesArray = array_reverse($salesArray);
            $expensesArray = array_reverse($expensesArray);
            $profitArray = array_reverse($profitArray);
        }elseif($timeframe == '2'){
            $sales = number_format(DB::table('transactions')
                ->whereRaw("WEEK(created_at) = WEEK(NOW()) AND YEAR(created_at) = YEAR(NOW())")
                ->sum('amount'), 2, '.', ',');

            $expenses = number_format(DB::table('inventory_transactions')
                ->whereRaw("WEEK(created_at) = WEEK(NOW()) AND YEAR(created_at) = YEAR(NOW())")
                ->sum('amount'), 2, '.', ',');

            $currentWeek = date('W');
            $currentYear = date('Y');

            $labels = array();
            $salesArray = array();
            $expensesArray = array();
            $profitArray = array();

            for ($i = 0; $i < 7; $i++) {
                $weekStart = strtotime($currentYear . "W" . str_pad($currentWeek - $i, 2, "0", STR_PAD_LEFT));
                $weekEnd = strtotime('+6 days', $weekStart);
                $weekLabel = date('M d', $weekStart);
                    
                $s = DB::table('transactions')
                        ->whereBetween('created_at', [date('Y-m-d H:i:s', $weekStart), date('Y-m-d H:i:s', $weekEnd)])
                        ->sum('amount');
                
                $e = DB::table('inventory_transactions')
                        ->where('type', 'INCOMING')
                        ->whereBetween('created_at', [date('Y-m-d H:i:s', $weekStart), date('Y-m-d H:i:s', $weekEnd)])
                        ->sum('amount');
    
                array_push($salesArray, $s);
                array_push($expensesArray, $e);
                array_push($profitArray, ($s - $e));

                array_push($labels, $weekLabel);
            }
            
            $labels = array_reverse($labels);
            $salesArray = array_reverse($salesArray);
            $expensesArray = array_reverse($expensesArray);
            $profitArray = array_reverse($profitArray);

        }elseif($timeframe == '3'){
            $sales = number_format(DB::table('transactions')
                ->whereRaw("MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())")
                ->sum('amount'), 2, '.', ',');

            $expenses = number_format(DB::table('inventory_transactions')
                ->whereRaw("MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())")
                ->sum('amount'), 2, '.', ',');

            $currentMonth = Carbon::now()->format('Y-m');

            $labels = array();
            $salesArray = array();
            $expensesArray = array();
            $profitArray = array();

            for ($i = 0; $i < 7; $i++) {
                $monthStart = Carbon::parse($currentMonth)->startOfMonth()->addMonths($i);
                $monthEnd = $monthStart->copy()->endOfMonth();
                $months[] = [$monthStart->format('Y-m-d'), $monthEnd->format('Y-m-d')];
                    
                $s = DB::table('transactions')
                        ->whereBetween('created_at', [$monthStart->format('Y-m-d'), $monthEnd->format('Y-m-d')])
                        ->sum('amount');
                
                $e = DB::table('inventory_transactions')
                        ->where('type', 'INCOMING')
                        ->whereBetween('created_at', [$monthStart->format('Y-m-d'), $monthEnd->format('Y-m-d')])
                        ->sum('amount');
    
                array_push($salesArray, $s);
                array_push($expensesArray, $e);
                array_push($profitArray, ($s - $e));

                array_push($labels, $monthStart->format('M'));
            }
            
            $labels = array_reverse($labels);
            $salesArray = array_reverse($salesArray);
            $expensesArray = array_reverse($expensesArray);
            $profitArray = array_reverse($profitArray);

        }

        $profit = number_format(((float) str_replace([','], '', $sales) - (float) str_replace([','], '', $expenses)), 2, '.', ',');


        $result = array(
            'sales' => $sales,
            'expenses' => $expenses,
            'profit' => $profit,
            'labels' => $labels,
            's' => $salesArray,
            'e' => $expensesArray,
            'p' => $profitArray
        );

        echo json_encode($result);
    }
}
