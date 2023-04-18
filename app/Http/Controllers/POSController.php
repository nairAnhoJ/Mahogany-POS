<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class POSController extends Controller
{
    public function index(){
        $tables = DB::table('tables')->orderBy('name', 'asc')->get();

        return view('user.cashier.pos', compact('tables'));
    }
}
