<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index(){
        $inventories = DB::table('inventories')->orderBy('name', 'asc')->paginate(20);
        $invCount = DB::table('inventories')->get()->count();
        $page = 1;
        return view('user.inventory.index', compact('inventories', 'invCount', 'page'));
    }

    public function paginate($page){
        $inventories = DB::table('inventories')->orderBy('name', 'asc')->paginate(20,'*','page',$page);
        $invCount = DB::table('inventories')->get()->count();
        return view('user.inventory.index', compact('inventories', 'invCount', 'page'));
    }
}
