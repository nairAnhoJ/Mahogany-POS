<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiverReportController extends Controller
{
    public function index(){
        $inventories = DB::table('inventories')
            ->select('inventories.item_code', 'inventories.name', 'categories.name AS cat_name', 'inventories.quantity', 'inventories.reorder_point', 'inventories.unit', 'inventories.price', 'inventories.image', 'inventories.slug')
            ->whereColumn('inventories.quantity', '<', 'inventories.reorder_point')
            ->join('categories', 'inventories.category_id', 'categories.id')
            ->orderBy('name', 'asc')
            ->paginate(100);
        $invCount = DB::table('inventories')->get()->count();
        $page = 1;
        $search = "";

        if(auth()->user()->role == 1){
            return view('user.inventory.inventory.index', compact('inventories', 'invCount', 'page', 'search'));
        }elseif(auth()->user()->role == 4 || auth()->user()->role == 2){
            return view('user.reciever.report', compact('inventories', 'invCount', 'page', 'search'));
        }
    }

    public function paginate($page){
        $inventories = DB::table('inventories')
            ->select('inventories.item_code', 'inventories.name', 'categories.name AS cat_name', 'inventories.quantity', 'inventories.reorder_point', 'inventories.unit', 'inventories.price', 'inventories.image', 'inventories.slug')
            ->whereColumn('inventories.quantity', '<', 'inventories.reorder_point')
            ->join('categories', 'inventories.category_id', 'categories.id')
            ->orderBy('name', 'asc')
            ->paginate(100,'*','page',$page);
        $invCount = DB::table('inventories')->get()->count();
        $search = "";



        if(auth()->user()->role == 1){
            return view('user.inventory.inventory.index', compact('inventories', 'invCount', 'page', 'search'));
        }elseif(auth()->user()->role == 4 || auth()->user()->role == 2){
            return view('user.reciever.report', compact('inventories', 'invCount', 'page', 'search'));
        }
    }

    public function search($page, $search){
        $inventories = DB::table('inventories')
            ->select('inventories.item_code', 'inventories.name', 'categories.name AS cat_name', 'inventories.quantity', 'inventories.reorder_point', 'inventories.unit', 'inventories.price', 'inventories.image', 'inventories.slug')
            ->whereColumn('inventories.quantity', '<', 'inventories.reorder_point')
            ->join('categories', 'inventories.category_id', 'categories.id')
            ->whereRaw("CONCAT_WS(' ', inventories.item_code, inventories.name, categories.name) LIKE '%{$search}%'")
            ->orderBy('name', 'asc')
            ->paginate(100,'*','page',$page);

        $invCount = DB::table('inventories')
            ->select('inventories.item_code', 'inventories.name', 'categories.name AS cat_name', 'inventories.quantity', 'inventories.reorder_point', 'inventories.unit', 'inventories.price', 'inventories.image', 'inventories.slug')
            ->whereColumn('inventories.quantity', '<', 'inventories.reorder_point')
            ->join('categories', 'inventories.category_id', 'categories.id')
            ->whereRaw("CONCAT_WS(' ', inventories.item_code, inventories.name, categories.name) LIKE '%{$search}%'")
            ->orderBy('name', 'asc')
            ->count();

        if(auth()->user()->role == 1){
            return view('user.inventory.inventory.index', compact('inventories', 'invCount', 'page', 'search'));
        }elseif(auth()->user()->role == 4 || auth()->user()->role == 2){
            return view('user.reciever.report', compact('inventories', 'invCount', 'page', 'search'));
        }
    }

    public function print(){
        $inventories = DB::table('inventories')
            ->select('inventories.item_code', 'inventories.name', 'categories.name AS cat_name', 'inventories.quantity', 'inventories.reorder_point', 'inventories.unit', 'inventories.price', 'inventories.image', 'inventories.slug')
            ->whereColumn('inventories.quantity', '<', 'inventories.reorder_point')
            ->join('categories', 'inventories.category_id', 'categories.id')
            ->orderBy('name', 'asc')
            ->get();

        $settings = DB::table('settings')->where('id', 1)->first();

        return view('user.reciever.print', compact('inventories', 'settings'));
    }
}
