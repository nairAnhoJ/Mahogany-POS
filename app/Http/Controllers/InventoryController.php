<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index(){
        $inventories = DB::table('inventories')->get();
        return view('user.inventory.index', compact('inventories'));
    }
}
