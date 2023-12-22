<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Convertion;
use App\Models\Inventory;
use App\Models\InventoryTransaction;
use App\Models\Waste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventoryController extends Controller {
    public function index() {
        $menu_cat = Category::where('slug', 'menu')->first();
        if ($menu_cat) {
            $menu_id = $menu_cat->id;
        } else {
            $menu_id = 0;
        }
        $inventories = DB::table('inventories')
            ->select('inventories.item_code', 'inventories.name', 'categories.name AS cat_name', 'inventories.category_id', 'inventories.quantity', 'inventories.reorder_point', 'inventories.unit', 'inventories.price', 'inventories.image', 'inventories.slug')
            ->join('categories', 'inventories.category_id', 'categories.id')
            ->where('inventories.is_deleted', 0)
            ->orderBy('name', 'asc')
            ->paginate(100);
        $invCount = $inventories->total();
        $page = 1;
        $search = "";

        return view('user.reciever.index', compact('inventories', 'invCount', 'page', 'search', 'menu_id'));
    }

    public function paginate($page) {
        $menu_cat = Category::where('slug', 'menu')->first();
        if ($menu_cat) {
            $menu_id = $menu_cat->id;
        } else {
            $menu_id = 0;
        }
        $inventories = DB::table('inventories')
            ->select('inventories.item_code', 'inventories.name', 'categories.name AS cat_name', 'inventories.category_id', 'inventories.quantity', 'inventories.reorder_point', 'inventories.unit', 'inventories.price', 'inventories.image', 'inventories.slug')
            ->join('categories', 'inventories.category_id', 'categories.id')
            ->where('inventories.is_deleted', 0)
            ->orderBy('name', 'asc')
            ->paginate(100, '*', 'page', $page);

        $invCount = $inventories->total();
        $search = "";


        return view('user.reciever.index', compact('inventories', 'invCount', 'page', 'search', 'menu_id'));
    }

    public function search($page, $search) {
        $menu_cat = Category::where('slug', 'menu')->first();
        if ($menu_cat) {
            $menu_id = $menu_cat->id;
        } else {
            $menu_id = 0;
        }
        $inventories = DB::table('inventories')
            ->select('inventories.item_code', 'inventories.name', 'categories.name AS cat_name', 'inventories.category_id', 'inventories.quantity', 'inventories.reorder_point', 'inventories.unit', 'inventories.price', 'inventories.image', 'inventories.slug')
            ->join('categories', 'inventories.category_id', 'categories.id')
            ->whereRaw("CONCAT_WS(' ', inventories.item_code, inventories.name, categories.name) LIKE '%{$search}%'")
            ->where('inventories.is_deleted', 0)
            ->orderBy('name', 'asc')
            ->paginate(100, '*', 'page', $page);

        $invCount = $inventories->total();

        return view('user.reciever.index', compact('inventories', 'invCount', 'page', 'search', 'menu_id'));
    }

    public function add() {
        $categories = DB::table('categories')->orderBy('name', 'asc')->where('slug', '!=', 'menu')->where('is_deleted', 0)->get();

        return view('user.reciever.add', compact('categories'));
    }

    public function store(Request $request) {
        $item_code = $request->item_code;
        $name = 'RW-' . $request->name;
        $category_id = $request->category_id;
        // $quantity = $request->quantity;
        $reorder_point = $request->reorder_point;
        $unit = $request->unit;
        $price = $request->price;
        $image = $request->image;

        $nameExist = Inventory::where('name', $name)->first();
        if ($nameExist) {
            return back()->withInput()->with('error', 'Item already exist!');
        }

        $slug = Str::slug($name, '-');
        $check_slug = DB::table('inventories')->where('slug', $slug)->get();
        $x = 1;
        $nslug = $slug;
        while (count($check_slug) > 0) {
            $nslug = $slug . '-' . $x;
            $check_slug = DB::table('inventories')->where('slug', $nslug)->get();
            $x++;
        }
        $slug = $nslug;

        $imagePath = null;
        if ($image != null) {
            $imagePath = $request->file('image')->storeAs('images/items/' . $slug . '.' . $request->file('image')->getClientOriginalExtension(), 'public');
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
        if ($image != null) {
            $item->image = $imagePath;
        }
        $item->slug = $slug;
        $item->save();

        return redirect()->route('inventory.index')->withInput()->with('message', 'Successfully Added');
    }

    public function edit($slug) {
        $item = DB::table('inventories')->where('slug', $slug)->first();
        $categories = DB::table('categories')->orderBy('name', 'asc')->where('slug', '!=', 'menu')->where('is_deleted', 0)->get();

        return view('user.reciever.edit', compact('item', 'categories'));
    }

    public function update(Request $request) {
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
        while (count($check_slug) > 0) {
            $nslug = $slug . '-' . $x;
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

        return redirect()->route('inventory.index')->withInput()->with('message', 'Successfully Updated');
    }

    public function delete($slug) {
        $invID = (DB::table('inventories')->where('slug', $slug)->first())->id;

        DB::table('inventories')->where('slug', $slug)
            ->update([
                'is_deleted' => 1,
            ]);

        DB::table('ingredients')->where('is_menu', 0)->where('inventory_id', $invID)
            ->update([
                'is_deleted' => 1,
            ]);

        return redirect()->route('inventory.index')->withInput()->with('message', 'Successfully Deleted');
    }

    public function dispose(Request $request) {
        $inv = DB::table('inventories')->where('slug', $request->disposeSlug)->first();
        $quantity = $request->quantity;
        $date = date('Y-m-d H:i:s', strtotime($request->disposeDate . ' ' . date('H:i:s')));
        $waste_remarks = $request->waste_remarks;

        if ($inv->quantity < $quantity) {
            return redirect()->route('inventory.index')->withInput()->with('error', 'Please Enter a valid Quantity.');
        }

        $inv_tran = DB::table('inventory_transactions')
            ->select('amount', 'quantity')
            ->where('type', 'INCOMING')
            ->where('inv_id', $inv->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($inv_tran != null) {
            $cost = ($inv_tran->amount * $quantity) / $inv_tran->quantity;
        } else {
            $cost = 0;
        }

        $waste = new Waste();
        $waste->on = 'INVENTORY';
        $waste->iid = $inv->id;
        $waste->quantity = $quantity;
        $waste->created_at = $date;
        $waste->cost = $cost;
        $waste->remarks = $waste_remarks;
        $waste->save();

        DB::table('inventories')->where('slug', $request->disposeSlug)->decrement('quantity', $quantity);

        return redirect()->route('inventory.index')->withInput()->with('message', 'Item Successfully Disposed');
    }

    public function addqty(Request $request) {
        $slug = $request->addSlug;
        $status = $request->status;
        $quantity = $request->quantity;
        $unit = $request->unit;
        if ($quantity < 1 || $quantity == '' || $quantity == null) {
            return redirect()->route('inventory.index')->withInput()->with('error', 'Please Enter a valid Quantity.');
        }
        $price = $request->price;
        $inv = DB::table('inventories')->where('slug', $slug)->first();
        $qb = $inv->quantity;

        if ($unit == $inv->unit) {
            $qf = $qb + $quantity;
        } else {
            $conv = Convertion::where('from', $unit)->where('to', $inv->unit)->first();
            $qf = $qb + ($quantity * $conv->value);
        }

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
        $it->is_paid = $status;
        $it->user_id = Auth::id();
        if (Auth::user()->role == 1) {
            $dateAdd = $request->dateAdd;
            $it->created_at = $dateAdd . ' ' . date('H:i:s');
        }
        $it->save();

        return redirect()->route('inventory.index')->withInput()->with('message', 'Quantity Successfully Increased');
    }

    public function minusqty(Request $request) {
        $slug = $request->minSlug;
        $quantity = $request->minQuantity;
        $unit = $request->unit;
        $remarks = $request->remarks;
        $dateMinus = $request->dateMinus;
        $inv = DB::table('inventories')->where('slug', $slug)->first();
        $qb = $inv->quantity;

        if ($unit == $inv->unit) {
            $qf = $qb + $quantity;
        } else {
            $conv = Convertion::where('from', $unit)->where('to', $inv->unit)->first();
            $qf = $qb - ($quantity * $conv->value);
        }

        if ($qf < 0) {
            return redirect()->route('inventory.index')->withInput()->with('error', 'Please Enter a valid Quantity.');
        } else {
            DB::table('inventories')->where('slug', $slug)->update([
                'quantity' => $qf,
            ]);

            $it = new InventoryTransaction();
            $it->inv_id = $inv->id;
            $it->type = 'OUTGOING';
            $it->quantity_before = $qb;
            $it->quantity = $quantity;
            $it->quantity_after = $qf;
            $it->remarks = $remarks;
            $it->user_id = Auth::id();
            if (Auth::user()->role == 1) {
                $dateMinus = $request->dateMinus;
                $it->created_at = $dateMinus . ' ' . date('H:i:s');
            }
            $it->save();

            return redirect()->route('inventory.index')->withInput()->with('message', 'Quantity Successfully Decreased');
        }
    }
}
