<?php

namespace App\Http\Controllers;

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
        return view('user.inventory.menu.index', compact('menus', 'menuCount', 'page', 'search'));
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
            
        return view('user.inventory.menu.index', compact('menus', 'menuCount', 'page', 'search'));
    }

    public function add(){
        $categories = DB::table('menu_categories')->orderBy('name', 'asc')->get();

        return view('user.inventory.menu.add', compact('categories'));
    }

    public function store(Request $request){
        $name = $request->name;
        $category_id = $request->category_id;
        $quantity = $request->quantity;
        $price = $request->price;
        $image = $request->image;

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
            $imagePath = $request->file('image')->storeAs('images/items/'.$slug. '.' . $request->file('image')->getClientOriginalExtension(), 'public');
        }

        $request->validate([
            'name' => 'required',
            'quantity' => 'required'
        ]);

        $item = new Menu();
        $item->name = $name;
        $item->category_id = $category_id;
        $item->quantity = $quantity;
        $item->price = $price;
        if($image != null){
            $item->image = $imagePath;
        }
        $item->slug = $slug;
        $item->save();

        return redirect()->route('menu.index')->withInput()->with('message', 'Successfully Added');
    }

    public function edit($slug){
        $item = DB::table('menus')->where('slug', $slug)->first();
        // dd($item);
        return view('user.inventory.menu.edit', compact('item'));
    }

    public function update(Request $request){
        $oldSlug = $request->slug;
        $item_code = $request->item_code;
        $name = $request->name;
        $category_id = $request->category_id;
        $quantity = $request->quantity;
        $price = $request->price;
        $image = $request->image;

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
            $imagePath = $request->file('image')->storeAs('public/images/items/'.$slug. '.' . $request->file('image')->getClientOriginalExtension());
        }

        $request->validate([
            'name' => 'required',
            'quantity' => 'required'
        ]);

        if($image != null){
            DB::table('menus')->where('slug', $oldSlug)
                ->update([
                    'item_code' => $item_code,
                    'name' => $name,
                    'category_id' => $category_id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'image' => $imagePath,
                    'slug' => $slug,
                ]);
        }else{
            DB::table('menus')->where('slug', $oldSlug)
                ->update([
                    'item_code' => $item_code,
                    'name' => $name,
                    'category_id' => $category_id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'slug' => $slug,
                ]);
        }

        return redirect()->route('menu.index')->withInput()->with('message', 'Successfully Updated');
    }

    public function delete($slug){
        DB::table('menus')->where('slug', $slug)->delete();

        return redirect()->route('menu.index')->withInput()->with('message', 'Successfully Deleted');
    }
}
