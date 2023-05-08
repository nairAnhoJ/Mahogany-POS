<?php

namespace App\Http\Controllers;

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

        return view('admin.dashboard', compact('sales', 'expenses', 'profit'));
    }
}
