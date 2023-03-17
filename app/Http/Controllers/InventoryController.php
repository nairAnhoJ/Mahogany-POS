<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index(){
        $inventories = DB::table('inventories')->orderBy('name', 'asc')->paginate(100);
        $invCount = DB::table('inventories')->get()->count();
        $page = 1;
        $search = "";
        return view('user.inventory.index', compact('inventories', 'invCount', 'page', 'search'));
    }

    public function paginate($page){
        $inventories = DB::table('inventories')->orderBy('name', 'asc')->paginate(100,'*','page',$page);
        $invCount = DB::table('inventories')->get()->count();
        $search = "";
        return view('user.inventory.index', compact('inventories', 'invCount', 'page', 'search'));
    }

    public function search($page, $search){
        // $inventories = (DB::select('SELECT * FROM inventories WHERE CONCAT(item_code,name) LIKE ?', ['%'.$search.'%']))->paginate(100,'*','page',$page);
        // $inventories = DB::table('inventories')->orderBy('name', 'asc')->paginate(100,'*','page',$page);
        $inventories = DB::table('inventories')
            ->select('*')
            ->whereRaw("CONCAT_WS(' ', item_code, name) LIKE '%{$search}%'")
            ->orderBy('name', 'asc')
            ->paginate(100,'*','page',$page);

        $invCount = DB::table('inventories')
            ->select('*')
            ->whereRaw("CONCAT_WS(' ', item_code, name) LIKE '%{$search}%'")
            ->orderBy('name', 'asc')
            ->count();
        return view('user.inventory.index', compact('inventories', 'invCount', 'page', 'search'));
    }

    public function add(){

    }

    public function store(){
        
    }

    public function edit(){
        
    }

    public function update(){
        
    }

    public function delete(){
        
    }
}
