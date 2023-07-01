<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExpensesController extends Controller
{
    public function index(){
        $inventories = DB::table('inventories')
            ->select('inventories.item_code', 'inventories.name', 'categories.name AS cat_name', 'inventories.quantity', 'inventories.reorder_point', 'inventories.unit', 'inventories.price', 'inventories.image', 'inventories.slug')
            ->join('categories', 'inventories.category_id', 'categories.id')
            ->where('is_expenses', 1)
            ->orderBy('name', 'asc')
            ->paginate(100);
        $invCount = DB::table('inventories')->where('is_expenses', 1)->get()->count();
        $page = 1;
        $search = "";

        return view('user.inventory.expenses.index', compact('inventories', 'invCount', 'page', 'search'));
    }

    public function paginate($page){
        $inventories = DB::table('inventories')
            ->select('inventories.item_code', 'inventories.name', 'categories.name AS cat_name', 'inventories.quantity', 'inventories.reorder_point', 'inventories.unit', 'inventories.price', 'inventories.image', 'inventories.slug')
            ->join('categories', 'inventories.category_id', 'categories.id')
            ->where('is_expenses', 1)
            ->orderBy('name', 'asc')
            ->paginate(100,'*','page',$page);
        $invCount = DB::table('inventories')->where('is_expenses', 1)->get()->count();
        $search = "";

        return view('user.inventory.expenses.index', compact('inventories', 'invCount', 'page', 'search'));
    }

    public function search($page, $search){
        $inventories = DB::table('inventories')
            ->select('inventories.item_code', 'inventories.name', 'categories.name AS cat_name', 'inventories.quantity', 'inventories.reorder_point', 'inventories.unit', 'inventories.price', 'inventories.image', 'inventories.slug')
            ->join('categories', 'inventories.category_id', 'categories.id')
            ->where('is_expenses', 1)
            ->whereRaw("CONCAT_WS(' ', inventories.item_code, inventories.name, categories.name) LIKE '%{$search}%'")
            ->orderBy('name', 'asc')
            ->paginate(100,'*','page',$page);

        $invCount = DB::table('inventories')
            ->select('inventories.item_code', 'inventories.name', 'categories.name AS cat_name', 'inventories.quantity', 'inventories.reorder_point', 'inventories.unit', 'inventories.price', 'inventories.image', 'inventories.slug')
            ->join('categories', 'inventories.category_id', 'categories.id')
            ->where('is_expenses', 1)
            ->whereRaw("CONCAT_WS(' ', inventories.item_code, inventories.name, categories.name) LIKE '%{$search}%'")
            ->orderBy('name', 'asc')
            ->count();

        return view('user.inventory.expenses.index', compact('inventories', 'invCount', 'page', 'search'));
    }

    public function add(){
        $categories = DB::table('categories')->orderBy('name', 'asc')->get();

        return view('user.inventory.expenses.add', compact('categories'));
    }

    public function store(Request $request){
        $item_code = $request->item_code;
        $name = $request->name;
        $category_id = $request->category_id;
        // $quantity = $request->quantity;
        $reorder_point = $request->reorder_point;
        $unit = $request->unit;
        $price = $request->price;
        $image = $request->image;

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

        $imagePath = null;
        if($image != null){
            $imagePath = $request->file('image')->storeAs('images/items/'.$slug. '.' . $request->file('image')->getClientOriginalExtension(), 'public');
        }

        $request->validate([
            'name' => 'required',
            'reorder_point' => 'required'
        ]);

        $item = new Inventory();
        $item->item_code = $item_code;
        $item->name = $name;
        $item->category_id = $category_id;
        $item->quantity = 0;
        $item->reorder_point = $reorder_point;
        $item->unit = $unit;
        $item->price = $price;
        if($image != null){
            $item->image = $imagePath;
        }
        $item->slug = $slug;
        $item->is_expenses = 1;
        $item->save();

        return redirect()->route('expenses.index')->withInput()->with('message', 'Successfully Added');
    }

    public function edit($slug){
        $item = DB::table('inventories')->where('slug', $slug)->first();
        $categories = DB::table('categories')->orderBy('name', 'asc')->get();

        return view('user.inventory.expenses.edit', compact('item', 'categories'));
    }

    public function update(Request $request){
        $oldSlug = $request->slug;
        $item_code = $request->item_code;
        $name = $request->name;
        $category_id = $request->category_id;
        $reorder_point = $request->reorder_point;
        $unit = $request->unit;

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
            'reorder_point' => 'required'
        ]);

        DB::table('inventories')->where('slug', $oldSlug)
            ->update([
                'item_code' => $item_code,
                'name' => $name,
                'category_id' => $category_id,
                'reorder_point' => $reorder_point,
                'unit' => $unit,
                'slug' => $slug,
            ]);

        return redirect()->route('expenses.index')->withInput()->with('message', 'Successfully Updated');
    }

    public function delete($slug){
        DB::table('inventories')->where('slug', $slug)->delete();

        return redirect()->route('expenses.index')->withInput()->with('message', 'Successfully Deleted');
    }

    public function addqty(Request $request){
        $slug = $request->addSlug;
        $quantity = 1;
        $price = $request->price;
        $dateAdd = $request->dateAdd;
        $inv = DB::table('inventories')->where('slug', $slug)->first();
        $qb = $inv->quantity;
        $qf = $qb + $quantity;

        DB::table('inventories')->where('slug', $slug)->update([
            'quantity' => $qf,
            'price' => $price,
        ]);

        $it = new InventoryTransaction();
        $it->inv_id = $inv->id;
        $it->type = 'INCOMING';
        $it->quantity_before = $qb;
        $it->quantity = $quantity;
        $it->quantity_after = $qf;
        $it->amount = $price;
        $it->remarks = 'N/A';
        $it->user_id = Auth::id();
        $it->created_at = $dateAdd;
        $it->save();

        return redirect()->route('expenses.index')->withInput()->with('message', 'Quantity Successfully Increased');
    }

    // public function minusqty(Request $request){
    //     $slug = $request->minSlug;
    //     $quantity = $request->minQuantity;
    //     $remarks = $request->remarks;
    //     $dateMinus = $request->dateMinus;
    //     $inv = DB::table('inventories')->where('slug', $slug)->first();
    //     $qb = $inv->quantity;
    //     $qf = $qb - $quantity;

    //     if($qf < 0){
    //         return redirect()->route('inventory.index')->withInput()->with('error', 'Please Enter a valid Quantity.');
    //     }else{
    //         DB::table('inventories')->where('slug', $slug)->update([
    //             'quantity' => $qf,
    //         ]);
    
    //         $it = new InventoryTransaction();
    //         $it->inv_id = $inv->id;
    //         $it->type = 'OUTGOING';
    //         $it->quantity_before = $qb;
    //         $it->quantity = $quantity;
    //         $it->quantity_after = $qf;
    //         $it->remarks = $remarks;
    //         $it->user_id = Auth::id();
    //         $it->created_at = $dateMinus;
    //         $it->save();
    
    //         return redirect()->route('inventory.index')->withInput()->with('message', 'Quantity Successfully Decreased');
    //     }
    // }
}
