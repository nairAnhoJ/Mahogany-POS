<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index(){
        $menus = DB::table('menus')
            ->select('menus.name', 'menu_categories.name AS category', 'menus.current_quantity', 'menus.quantity', 'menus.price', 'menus.slug')
            ->join('menu_categories' , 'menus.category_id', '=', 'menu_categories.id')
            ->orderBy('name', 'asc')
            ->paginate(100);
        $menuCount = DB::table('menus')->get()->count();
        $page = 1;
        $search = "";

        if(auth()->user()->role == 1){
            return view('user.inventory.menu.index', compact('menus', 'menuCount', 'page', 'search'));
        }elseif(auth()->user()->role == 3){
            return view('user.cook.menu-preparation', compact('menus', 'menuCount', 'page', 'search'));
        }
    }

    public function paginate($page){
        $menus = DB::table('menus')
            ->select('menus.name', 'menu_categories.name AS category', 'menus.current_quantity', 'menus.quantity', 'menus.price', 'menus.slug')
            ->join('menu_categories' , 'menus.category_id', '=', 'menu_categories.id')
            ->orderBy('name', 'asc')
            ->paginate(100,'*','page',$page);
        $menuCount = DB::table('menus')->get()->count();
        $search = "";

        if(auth()->user()->role == 1){
            return view('user.inventory.menu.index', compact('menus', 'menuCount', 'page', 'search'));
        }elseif(auth()->user()->role == 3){
            return view('user.cook.menu-preparation', compact('menus', 'menuCount', 'page', 'search'));
        }
    }

    public function search($page, $search){
        $menus = DB::table('menus')
            ->select('menus.name', 'menu_categories.name AS category', 'menus.current_quantity', 'menus.quantity', 'menus.price', 'menus.slug')
            ->join('menu_categories' , 'menus.category_id', '=', 'menu_categories.id')
            ->whereRaw("CONCAT_WS(' ', menus.name, menu_categories.name) LIKE '%{$search}%'")
            ->orderBy('name', 'asc')
            ->paginate(100,'*','page',$page);

        $menuCount = DB::table('menus')
            ->select('menus.name', 'menu_categories.name AS category', 'menus.current_quantity', 'menus.quantity', 'menus.price', 'menus.slug')
            ->join('menu_categories' , 'menus.category_id', '=', 'menu_categories.id')
            ->whereRaw("CONCAT_WS(' ', menus.name, menu_categories.name) LIKE '%{$search}%'")
            ->orderBy('name', 'asc')
            ->count();
            

        if(auth()->user()->role == 1){
            return view('user.inventory.menu.index', compact('menus', 'menuCount', 'page', 'search'));
        }elseif(auth()->user()->role == 3){
            return view('user.cook.menu-preparation', compact('menus', 'menuCount', 'page', 'search'));
        }
    }

    public function add(){
        $categories = DB::table('menu_categories')->orderBy('name', 'asc')->get();
        $items = DB::table('inventories')->get();

        if(auth()->user()->role == 1){
            return view('user.inventory.menu.add', compact('categories', 'items'));
        }elseif(auth()->user()->role == 3){
            return view('user.cook.menu-preparation-add', compact('categories','items'));
        }
    }

    public function store(Request $request){
        $name = strtoupper($request->name);
        $category_id = $request->category_id;
        $price = $request->price;
        $image = $request->image;
        $Totalcounter = $request->counter;

        $slug = Str::slug($name, '-');
        $check_slug = DB::table('menus')->where('slug', $slug)->get();
        $x = 1;
        $nslug = $slug;
        while(count($check_slug) > 0){
            $nslug = $slug.'-'.$x;
            $check_slug = DB::table('menus')->where('slug', $nslug)->get();
            $x++;
        }
        $slug = $nslug;

        $imagePath = null;
        if($image != null){
            $filename = $slug. '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('images/menu',$filename , 'public');
        }

        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);

        $item = new Menu();
        $item->name = $name;
        $item->category_id = $category_id;
        $item->price = $price;
        $item->quantity = 0;
        $item->current_quantity = 0;
        if($image != null){
            $item->image = $imagePath;
        }
        $item->slug = $slug;
        $item->save();
        
        for($counter = 1; $counter <= $Totalcounter; $counter++){
            $iname = 'item'.$counter;
            $qname = 'quantity'.$counter;

            if($request->$iname != null){
                $invUnit = (DB::table('inventories')->where('id', $request->$iname)->first())->unit;
                $ingr = new Ingredient();
                $ingr->menu_id = $item->id;
                $ingr->inventory_id = $request->$iname;
                $ingr->quantity = $request->$qname;
                $ingr->unit = $invUnit;
                $ingr->save();
            }
        }

        return redirect()->route('menu.index')->withInput()->with('message', 'Successfully Added');
    }

    public function edit($slug){
        $item = DB::table('menus')->where('slug', $slug)->first();
        $ingredients = DB::table('ingredients')
            ->select('ingredients.id', 'ingredients.menu_id', 'ingredients.inventory_id', 'inventories.name AS name', 'ingredients.quantity', 'ingredients.unit')
            ->join('inventories', 'ingredients.inventory_id', 'inventories.id')
            ->where('ingredients.menu_id', $item->id)->get();
        $categories = DB::table('menu_categories')->orderBy('name', 'asc')->get();
        $items = DB::table('inventories')->get();
        
        if(auth()->user()->role == 1){
            return view('user.inventory.menu.edit', compact('item', 'ingredients', 'categories', 'items', 'slug'));
        }elseif(auth()->user()->role == 3){
            return view('user.cook.menu-preparation-edit', compact('item', 'ingredients', 'categories', 'items', 'slug'));
        }
    }

    public function update(Request $request){
        $oldSlug = $request->slug;
        $name = strtoupper($request->name);
        $category_id = $request->category_id;
        $price = $request->price;
        $image = $request->image;
        $Totalcounter = $request->counter;
        $menuID = (DB::table('menus')->where('slug', $oldSlug)->first())->id;

        $slug = Str::slug($name, '-');
        $check_slug = DB::table('menus')->where('slug', $slug)->get();
        $x = 1;
        $nslug = $slug;
        while(count($check_slug) > 0){
            $nslug = $slug.'-'.$x;
            $check_slug = DB::table('menus')->where('slug', $nslug)->get();
            $x++;
        }
        $slug = $nslug;

        $imagePath = null;
        if($image != null){
            $filename = $slug. '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('images/menu',$filename , 'public');
        }

        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);

        if($image != null){
            DB::table('menus')->where('slug', $oldSlug)
                ->update([
                    'name' => $name,
                    'category_id' => $category_id,
                    'price' => $price,
                    'image' => $imagePath,
                    'slug' => $slug,
                ]);
        }else{
            DB::table('menus')->where('slug', $oldSlug)
                ->update([
                    'name' => $name,
                    'category_id' => $category_id,
                    'price' => $price,
                    'slug' => $slug,
                ]);
        }
        
        DB::table('ingredients')->where('menu_id', $menuID)->delete();

        for($counter = 1; $counter <= $Totalcounter; $counter++){
            $iname = 'item'.$counter;
            $qname = 'quantity'.$counter;

            if($request->$iname != null){
                $invUnit = (DB::table('inventories')->where('id', $request->$iname)->first())->unit;

                $ingr = new Ingredient();
                $ingr->menu_id = $menuID;
                $ingr->inventory_id = $request->$iname;
                $ingr->quantity = $request->$qname;
                $ingr->unit = $invUnit;
                $ingr->save();
            }
        }

        return redirect()->route('menu.index')->withInput()->with('message', 'Successfully Updated');
    }

    public function changeqty(Request $request){
        $slug = $request->slug;
        $quantity = $request->quantity;
        $s = $request->s;
        $cur_quantity = (DB::table('menus')->where('slug', $slug)->first())->quantity;

        $menuID = (DB::table('menus')->where('slug', $slug)->first())->id;
        $ings = DB::table('ingredients')->where('menu_id', $menuID)->get();

        foreach($ings as $ing){

            $old_quantity = (DB::table('inventories')->where('id', $ing->inventory_id)->first())->quantity;
            if($s == 'add'){
                $new_quantity = $old_quantity - ($ing->quantity * $quantity);
                $uqty = $cur_quantity + $quantity;
            }else{
                $new_quantity = $old_quantity + ($ing->quantity * $quantity);
                $uqty = $cur_quantity - $quantity;
            }

            if($new_quantity < 0){
                return redirect()->route('menu.index')->withInput()->with('error', 'Insufficient Ingredients');
            }
            if($uqty < 0){
                return redirect()->route('menu.index')->withInput()->with('error', 'Error Changing Quantity');
            }

            DB::table('inventories')->where('id', $ing->inventory_id)->update([
                'quantity' => $new_quantity
            ]);
        }

        DB::table('menus')->where('slug', $slug)
            ->update([
                'current_quantity' => $uqty,
                'quantity' => $uqty,
            ]);

        return redirect()->route('menu.index')->withInput()->with('message', 'Quantity Successfully Changed');
    }

    public function delete($slug){
        $menuID = (DB::table('menus')->where('slug', $slug)->first())->id;
        
        DB::table('ingredients')->where('menu_id', $menuID)->delete();
        DB::table('menus')->where('slug', $slug)->delete();

        return redirect()->route('menu.index')->withInput()->with('message', 'Successfully Deleted');
    }
}
