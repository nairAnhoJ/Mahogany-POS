<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WasteController extends Controller
{
    public function inventoryIndex(){
        $inventories = DB::table('wastes')
            ->select('wastes.*', 'inventories.name')
            ->join('inventories', 'wastes.iid', 'inventories.id')
            ->where('on', 'INVENTORY')
            ->orderBy('wastes.created_at', 'desc')
            ->paginate(100);
        $invCount = DB::table('wastes')->where('on', 'INVENTORY')->count();

        $page = 1;
        $search = "";

        return view('user.reciever.waste', compact('search', 'page', 'inventories', 'invCount'));
    }

    public function inventoryPaginate($page){
        $inventories = DB::table('wastes')
            ->select('wastes.*', 'inventories.name')
            ->join('inventories', 'wastes.iid', 'inventories.id')
            ->where('on', 'INVENTORY')
            ->orderBy('wastes.created_at', 'desc')
            ->paginate(100,'*','page',$page);
        $invCount = DB::table('wastes')->where('on', 'INVENTORY')->count();

        $search = "";

        return view('user.reciever.waste', compact('search', 'page', 'inventories', 'invCount'));
    }

    public function inventorySearch($page, $search){
        $inventories = DB::table('wastes')
            ->select('wastes.*', 'inventories.name')
            ->join('inventories', 'wastes.iid', 'inventories.id')
            ->where('on', 'INVENTORY')
            ->whereRaw("CONCAT_WS(' ', inventories.name) LIKE '%{$search}%'")
            ->orderBy('wastes.created_at', 'desc')
            ->paginate(100,'*','page',$page);
        $invCount = DB::table('wastes')
            ->select('wastes.*', 'inventories.name')
            ->join('inventories', 'wastes.iid', 'inventories.id')
            ->where('on', 'INVENTORY')
            ->whereRaw("CONCAT_WS(' ', inventories.name) LIKE '%{$search}%'")
            ->orderBy('wastes.created_at', 'desc')
            ->count();

        return view('user.reciever.waste', compact('search', 'page', 'inventories', 'invCount'));
    }

    public function inventoryRestore($id){
        $waste = DB::table('wastes')->where('id', $id)->first();
        $waste_quantity = $waste->quantity;

        DB::table('inventories')->where('id', $waste->iid)->increment('quantity', $waste_quantity);

        DB::table('wastes')->where('id', $id)->delete();

        return redirect()->route('waste.inventory.index')->withInput()->with('message', 'Successfully Restored');
    }













    public function menuIndex(){
        $inventories = DB::table('wastes')
            ->select('wastes.*', 'menus.name')
            ->join('menus', 'wastes.iid', 'menus.id')
            ->where('on', 'MENU')
            ->orderBy('wastes.created_at', 'desc')
            ->paginate(100);
        $invCount = DB::table('wastes')->where('on', 'MENU')->count();

        $page = 1;
        $search = "";

        return view('user.inventory.menu.waste', compact('search', 'page', 'inventories', 'invCount'));
    }

    public function menuPaginate($page){
        $inventories = DB::table('wastes')
            ->select('wastes.*', 'menus.name')
            ->join('menus', 'wastes.iid', 'menus.id')
            ->where('on', 'MENU')
            ->orderBy('wastes.created_at', 'desc')
            ->paginate(100,'*','page',$page);
        $invCount = DB::table('wastes')->where('on', 'MENU')->count();

        $search = "";

        return view('user.inventory.menu.waste', compact('search', 'page', 'inventories', 'invCount'));
    }

    public function menuSearch($page, $search){
        $inventories = DB::table('wastes')
            ->select('wastes.*', 'menus.name')
            ->join('menus', 'wastes.iid', 'menus.id')
            ->where('on', 'MENU')
            ->whereRaw("CONCAT_WS(' ', inventories.name) LIKE '%{$search}%'")
            ->orderBy('wastes.created_at', 'desc')
            ->paginate(100,'*','page',$page);
        $invCount = DB::table('wastes')
            ->select('wastes.*', 'menus.name')
            ->join('menus', 'wastes.iid', 'menus.id')
            ->where('on', 'MENU')
            ->whereRaw("CONCAT_WS(' ', inventories.name) LIKE '%{$search}%'")
            ->orderBy('wastes.created_at', 'desc')
            ->count();

        $search = "";

        return view('user.inventory.menu.waste', compact('search', 'page', 'inventories', 'invCount'));
    }

    public function menuRestore($id){
        $waste = DB::table('wastes')->where('id', $id)->first();
        $waste_quantity = $waste->quantity;

        DB::table('menus')->where('id', $waste->iid)->increment('quantity', $waste_quantity);
        DB::table('menus')->where('id', $waste->iid)->increment('current_quantity', $waste_quantity);

        DB::table('wastes')->where('id', $id)->delete();

        return redirect()->route('waste.menu.index')->withInput()->with('message', 'Successfully Restored');
    }
}
