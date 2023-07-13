<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ExpensesController extends Controller
{
    public function index(){
        $today = Carbon::today();
        $inventories = DB::table('inventory_transactions')->whereDate('created_at', $today)->where('inv_id', 0)->paginate(100);

        // $inventories = DB::table('inventories')
        //     ->select('inventories.item_code', 'inventories.name', 'categories.name AS cat_name', 'inventories.quantity', 'inventories.reorder_point', 'inventories.unit', 'inventories.price', 'inventories.image', 'inventories.slug')
        //     ->join('categories', 'inventories.category_id', 'categories.id')
        //     ->where('is_expenses', 1)
        //     ->orderBy('name', 'asc')
        //     ->paginate(100);
        $invCount = DB::table('inventory_transactions')->whereDate('created_at', $today)->where('inv_id', 0)->get()->count();
        // $invCount = DB::table('inventories')->where('is_expenses', 1)->get()->count();
        $page = 1;
        $search = "";

        return view('user.inventory.expenses.index', compact('inventories', 'invCount', 'page', 'search'));
    }

    public function paginate($page){
        $today = Carbon::today();
        $inventories = DB::table('inventory_transactions')->whereDate('created_at', $today)->where('inv_id', 0)->paginate(100,'*','page',$page);

        // $inventories = DB::table('inventories')
        //     ->select('inventories.item_code', 'inventories.name', 'categories.name AS cat_name', 'inventories.quantity', 'inventories.reorder_point', 'inventories.unit', 'inventories.price', 'inventories.image', 'inventories.slug')
        //     ->join('categories', 'inventories.category_id', 'categories.id')
        //     ->where('is_expenses', 1)
        //     ->orderBy('name', 'asc')
        //     ->paginate(100,'*','page',$page);

        $invCount = DB::table('inventory_transactions')->whereDate('created_at', $today)->where('inv_id', 0)->get()->count();
        // $invCount = DB::table('inventories')->where('is_expenses', 1)->get()->count();

        $search = "";

        return view('user.inventory.expenses.index', compact('inventories', 'invCount', 'page', 'search'));
    }

    public function search($page, $search){
        $today = Carbon::today();
        $inventories = DB::table('inventory_transactions')
            ->whereDate('created_at', $today)
            ->whereRaw("CONCAT_WS(' ', remarks) LIKE '%{$search}%'")
            ->where('inv_id', 0)
            ->paginate(100,'*','page',$page);

        $invCount = DB::table('inventory_transactions')
            ->whereDate('created_at', $today)
            ->whereRaw("CONCAT_WS(' ', remarks) LIKE '%{$search}%'")
            ->where('inv_id', 0)
            ->count();

        // $inventories = DB::table('inventories')
        //     ->select('inventories.item_code', 'inventories.name', 'categories.name AS cat_name', 'inventories.quantity', 'inventories.reorder_point', 'inventories.unit', 'inventories.price', 'inventories.image', 'inventories.slug')
        //     ->join('categories', 'inventories.category_id', 'categories.id')
        //     ->where('is_expenses', 1)
        //     ->whereRaw("CONCAT_WS(' ', inventories.item_code, inventories.name, categories.name) LIKE '%{$search}%'")
        //     ->orderBy('name', 'asc')
        //     ->paginate(100,'*','page',$page);

        // $invCount = DB::table('inventories')
        //     ->select('inventories.item_code', 'inventories.name', 'categories.name AS cat_name', 'inventories.quantity', 'inventories.reorder_point', 'inventories.unit', 'inventories.price', 'inventories.image', 'inventories.slug')
        //     ->join('categories', 'inventories.category_id', 'categories.id')
        //     ->where('is_expenses', 1)
        //     ->whereRaw("CONCAT_WS(' ', inventories.item_code, inventories.name, categories.name) LIKE '%{$search}%'")
        //     ->orderBy('name', 'asc')
        //     ->count();

        return view('user.inventory.expenses.index', compact('inventories', 'invCount', 'page', 'search'));
    }

    public function add(){
        return view('user.inventory.expenses.add');
    }

    public function store(Request $request){
        // $item_code = $request->item_code;
        $name = $request->name;
        // $category_id = $request->category_id;
        // $quantity = $request->quantity;
        // $reorder_point = $request->reorder_point;
        // $unit = $request->unit;
        $quantity = str_replace(',', '', $request->quantity);
        $price = str_replace(',', '', $request->price);
        // $image = $request->image;

        $request->validate([
            'name' => 'required',
            'quantity' => 'required',
            'price' => 'required'
        ]);

        $item = new InventoryTransaction();
        $item->inv_id = 0;
        $item->type = 'INCOMING';
        $item->quantity_before = 0;
        $item->quantity = $quantity;
        $item->quantity_after = 0;
        $item->amount = $price;
        $item->remarks = $name;
        $item->user_id = Auth::user()->id;
        $item->save();

        return redirect()->route('expenses.index')->withInput()->with('message', 'Successfully Added');
    }

    public function edit($id){
        $item = DB::table('inventory_transactions')->where('id', $id)->first();

        return view('user.inventory.expenses.edit', compact('item'));
    }

    public function update(Request $request){
        $id = $request->id;
        $name = $request->name;
        $quantity = str_replace(',', '', $request->quantity);
        $price = str_replace(',', '', $request->price);

        $request->validate([
            'name' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ]);

        DB::table('inventory_transactions')->where('id', $id)
            ->update([
                'remarks' => $name,
                'quantity' => $quantity,
                'amount' => $price,
            ]);

        return redirect()->route('expenses.index')->withInput()->with('message', 'Successfully Updated');
    }

    public function delete($id){
        DB::table('inventory_transactions')->where('id', $id)->delete();

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
