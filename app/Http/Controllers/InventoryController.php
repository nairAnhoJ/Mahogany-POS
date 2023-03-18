<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        return view('user.inventory.add');
    }

    public function store(Request $request){
        $item_code = $request->item_code;
        $name = $request->name;
        $category_id = $request->category_id;
        $quantity = $request->quantity;
        $price = $request->price;

        $slug = Str::slug($name, '-');
        $check_slug = DB::table('inventories')->where('slug', $slug)->get();
        $x = 1;
        $nslug = $slug;
        while(count($check_slug) > 0){
            $nslug = $slug.'-'.$x;
            $check_slug = DB::table('inventories')->where('slug', $nslug)->get();
            $x++;
        }
        $slug = $nslug;

        $request->validate([
            'name' => 'required',
            'quantity' => 'required'
        ]);

        $item = new Inventory();
        $item->item_code = $item_code;
        $item->name = $name;
        $item->category_id = $category_id;
        $item->quantity = $quantity;
        $item->price = $price;
        $item->slug = $slug;
        $item->save();

        return redirect()->route('inventory.index');
    }

    public function edit(){
        
    }

    public function update(){
        
    }

    public function delete(){
        
    }
}
