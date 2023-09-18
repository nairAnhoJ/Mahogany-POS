<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiverReportController extends Controller {
    public function invIndex() {
        $inventories = DB::table('inventories')
            ->select('inventories.item_code', 'inventories.name', 'categories.name AS cat_name', 'inventories.quantity', 'inventories.reorder_point', 'inventories.unit', 'inventories.price', 'inventories.image', 'inventories.slug')
            ->whereColumn('inventories.quantity', '<', 'inventories.reorder_point')
            ->join('categories', 'inventories.category_id', 'categories.id')
            ->where('inventories.quantity', '>', 0)
            ->orderBy('name', 'asc')
            ->paginate(100);
        $invCount = $inventories->total();
        $page = 1;
        $search = "";
        $rt = 'inv';

        // if(auth()->user()->role == 1){
        //     return view('user.inventory.inventory.index', compact('inventories', 'invCount', 'page', 'search'));
        // }elseif(auth()->user()->role == 4 || auth()->user()->role == 2){
        return view('user.reciever.report', compact('inventories', 'invCount', 'page', 'search', 'rt'));
        // }
    }

    public function invPaginate($page) {
        $inventories = DB::table('inventories')
            ->select('inventories.item_code', 'inventories.name', 'categories.name AS cat_name', 'inventories.quantity', 'inventories.reorder_point', 'inventories.unit', 'inventories.price', 'inventories.image', 'inventories.slug')
            ->whereColumn('inventories.quantity', '<', 'inventories.reorder_point')
            ->join('categories', 'inventories.category_id', 'categories.id')
            ->where('inventories.quantity', '>', 0)
            ->orderBy('name', 'asc')
            ->paginate(100, '*', 'page', $page);
        $invCount = $inventories->total();
        $search = "";
        $rt = 'inv';

        // if(auth()->user()->role == 1){
        //     return view('user.inventory.inventory.index', compact('inventories', 'invCount', 'page', 'search'));
        // }elseif(auth()->user()->role == 4 || auth()->user()->role == 2){
        return view('user.reciever.report', compact('inventories', 'invCount', 'page', 'search', 'rt'));
        // }
    }

    public function invSearch($page, $search) {
        $inventories = DB::table('inventories')
            ->select('inventories.item_code', 'inventories.name', 'categories.name AS cat_name', 'inventories.quantity', 'inventories.reorder_point', 'inventories.unit', 'inventories.price', 'inventories.image', 'inventories.slug')
            ->whereColumn('inventories.quantity', '<', 'inventories.reorder_point')
            ->join('categories', 'inventories.category_id', 'categories.id')
            ->whereRaw("CONCAT_WS(' ', inventories.item_code, inventories.name, categories.name) LIKE '%{$search}%'")
            ->where('inventories.quantity', '>', 0)
            ->orderBy('name', 'asc')
            ->paginate(100, '*', 'page', $page);

        $invCount = $inventories->total();

        $rt = 'inv';

        // if(auth()->user()->role == 1){
        //     return view('user.inventory.inventory.index', compact('inventories', 'invCount', 'page', 'search'));
        // }elseif(auth()->user()->role == 4 || auth()->user()->role == 2){
        return view('user.reciever.report', compact('inventories', 'invCount', 'page', 'search', 'rt'));
        // }
    }






    public function menuIndex() {
        $inventories = DB::table('menus')
            ->select('menus.*', 'menu_categories.name as cat_name')
            ->whereColumn('menus.quantity', '<', 'menus.reorder_point')
            ->join('menu_categories', 'menus.category_id', 'menu_categories.id')
            ->where('menus.quantity', '>', 0)
            ->orderBy('menus.quantity', 'desc')
            ->paginate(100);

        $invCount = $inventories->total();
        $page = 1;
        $search = "";
        $rt = 'menu';

        // if(auth()->user()->role == 1){
        //     return view('user.inventory.inventory.index', compact('inventories', 'invCount', 'page', 'search'));
        // }elseif(auth()->user()->role == 4 || auth()->user()->role == 2){
        return view('user.reciever.report', compact('inventories', 'invCount', 'page', 'search', 'rt'));
        // }
    }

    public function menuPaginate($page) {
        $inventories = DB::table('menus')
            ->select('menus.*', 'menu_categories.name as cat_name')
            ->whereColumn('menus.quantity', '<', 'menus.reorder_point')
            ->join('menu_categories', 'menus.category_id', 'menu_categories.id')
            ->where('menus.quantity', '>', 0)
            ->orderBy('menus.quantity', 'desc')
            ->paginate(100, '*', 'page', $page);

        $invCount = $inventories->total();
        $search = "";
        $rt = 'menu';

        // if(auth()->user()->role == 1){
        //     return view('user.inventory.inventory.index', compact('inventories', 'invCount', 'page', 'search'));
        // }elseif(auth()->user()->role == 4 || auth()->user()->role == 2){
        return view('user.reciever.report', compact('inventories', 'invCount', 'page', 'search', 'rt'));
        // }
    }

    public function menuSearch($page, $search) {
        $inventories = DB::table('menus')
            ->select('menus.*', 'menu_categories.name as cat_name')
            ->whereColumn('menus.quantity', '<', 'menus.reorder_point')
            ->join('menu_categories', 'menus.category_id', 'menu_categories.id')
            ->whereRaw("CONCAT_WS(' ', menus.name, menu_categories.name) LIKE '%{$search}%'")
            ->where('menus.quantity', '>', 0)
            ->orderBy('menus.quantity', 'desc')
            ->paginate(100, '*', 'page', $page);

        $invCount = $inventories->total();

        $rt = 'menu';

        // if(auth()->user()->role == 1){
        //     return view('user.inventory.inventory.index', compact('inventories', 'invCount', 'page', 'search'));
        // }elseif(auth()->user()->role == 4 || auth()->user()->role == 2){
        return view('user.reciever.report', compact('inventories', 'invCount', 'page', 'search', 'rt'));
        // }
    }






























    public function invPrint() {
        $inventories = DB::table('inventories')
            ->select('inventories.item_code', 'inventories.name', 'categories.name AS cat_name', 'inventories.quantity', 'inventories.reorder_point', 'inventories.unit', 'inventories.price', 'inventories.image', 'inventories.slug')
            ->whereColumn('inventories.quantity', '<', 'inventories.reorder_point')
            ->where('inventories.quantity', '>', 0)
            ->join('categories', 'inventories.category_id', 'categories.id')
            ->orderBy('name', 'asc')
            ->get();

        $settings = DB::table('settings')->where('id', 1)->first();

        $rt = 'inv';

        return view('user.reciever.print', compact('inventories', 'settings', 'rt'));
    }



    public function menuPrint() {
        $inventories = DB::table('menus')
            ->select('menus.*', 'menu_categories.name as cat_name', 'menus.reorder_point')
            ->whereColumn('menus.quantity', '<', 'menus.reorder_point')
            ->where('menus.quantity', '>', 0)
            ->join('menu_categories', 'menus.category_id', 'menu_categories.id')
            ->orderBy('menus.quantity', 'desc')
            ->get();

        $settings = DB::table('settings')->where('id', 1)->first();

        $rt = 'menu';

        return view('user.reciever.print', compact('inventories', 'settings', 'rt'));
    }
}
