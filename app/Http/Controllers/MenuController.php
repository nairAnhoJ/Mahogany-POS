<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Inventory;
use App\Models\InventoryTransaction;
use App\Models\Menu;
use App\Models\Waste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index(){
        // $menus = DB::table('menus')
        //     ->select('menus.name', 'menu_categories.name AS category', 'menus.current_quantity', 'menus.price', 'menus.is_combo', 'menus.slug')
        //     ->join('menu_categories' , 'menus.category_id', '=', 'menu_categories.id')
        //     ->orderBy('name', 'asc')
        //     ->paginate(100);

        $menus = DB::table('menus')
            ->select(
                'menus.name',
                'menu_categories.name AS category',
                'menus.price',
                'menus.is_combo',
                'menus.slug',
                DB::raw('
                    CASE
                        WHEN menus.is_combo = 1 THEN (
                            SELECT
                                MIN(
                                    CASE
                                        WHEN is_menu = 1 THEN (
                                            SELECT menus.quantity FROM menus WHERE menus.id = ingredients.inventory_id
                                        )
                                        ELSE (
                                            SELECT inventories.quantity FROM inventories WHERE inventories.id = ingredients.inventory_id
                                        )
                                    END
                                )
                            FROM ingredients
                            WHERE menu_id = menus.id
                        )
                        ELSE menus.quantity
                    END AS quantity
                ')
            )
            ->join('menu_categories', 'menus.category_id', '=', 'menu_categories.id')
            ->orderBy('name', 'asc')
            ->paginate(100);

        $items = DB::table('inventories')->get();
        $menuCount = DB::table('menus')->get()->count();
        $page = 1;
        $search = "";

        return view('user.cook.menu-preparation', compact('menus', 'menuCount', 'page', 'search', 'items'));
    }

    public function paginate($page){
        // $menus = DB::table('menus')
        //     ->select('menus.name', 'menu_categories.name AS category', 'menus.current_quantity', 'menus.quantity', 'menus.price', 'menus.slug')
        //     ->join('menu_categories' , 'menus.category_id', '=', 'menu_categories.id')
        //     ->orderBy('name', 'asc')
        //     ->paginate(100,'*','page',$page);

        $menus = DB::table('menus')
            ->select(
                'menus.name',
                'menu_categories.name AS category',
                'menus.price',
                'menus.is_combo',
                'menus.slug',
                DB::raw('
                    CASE
                        WHEN menus.is_combo = 1 THEN (
                            SELECT
                                MIN(
                                    CASE
                                        WHEN is_menu = 1 THEN (
                                            SELECT menus.quantity FROM menus WHERE menus.id = ingredients.inventory_id
                                        )
                                        ELSE (
                                            SELECT inventories.quantity FROM inventories WHERE inventories.id = ingredients.inventory_id
                                        )
                                    END
                                )
                            FROM ingredients
                            WHERE menu_id = menus.id
                        )
                        ELSE menus.quantity
                    END AS quantity
                ')
            )
            ->join('menu_categories', 'menus.category_id', '=', 'menu_categories.id')
            ->orderBy('name', 'asc')
            ->paginate(100,'*','page',$page);


        $menuCount = DB::table('menus')->get()->count();
        $items = DB::table('inventories')->get();
        $search = "";

        return view('user.cook.menu-preparation', compact('menus', 'menuCount', 'page', 'search', 'items'));
    }

    public function search($page, $search){
        // $menus = DB::table('menus')
        //     ->select('menus.name', 'menu_categories.name AS category', 'menus.current_quantity', 'menus.quantity', 'menus.price', 'menus.slug')
        //     ->join('menu_categories' , 'menus.category_id', '=', 'menu_categories.id')
        //     ->whereRaw("CONCAT_WS(' ', menus.name, menu_categories.name) LIKE '%{$search}%'")
        //     ->orderBy('name', 'asc')
        //     ->paginate(100,'*','page',$page);

        $menus = DB::table('menus')
            ->select(
                'menus.name',
                'menu_categories.name AS category',
                'menus.price',
                'menus.is_combo',
                'menus.slug',
                DB::raw('
                    CASE
                        WHEN menus.is_combo = 1 THEN (
                            SELECT
                                MIN(
                                    CASE
                                        WHEN is_menu = 1 THEN (
                                            SELECT menus.quantity FROM menus WHERE menus.id = ingredients.inventory_id
                                        )
                                        ELSE (
                                            SELECT inventories.quantity FROM inventories WHERE inventories.id = ingredients.inventory_id
                                        )
                                    END
                                )
                            FROM ingredients
                            WHERE menu_id = menus.id
                        )
                        ELSE menus.quantity
                    END AS quantity
                ')
            )
            ->join('menu_categories', 'menus.category_id', '=', 'menu_categories.id')
            ->whereRaw("CONCAT_WS(' ', menus.name, menu_categories.name) LIKE '%{$search}%'")
            ->orderBy('name', 'asc')
            ->paginate(100,'*','page',$page);

        $menuCount = DB::table('menus')
            ->select('menus.name', 'menu_categories.name AS category', 'menus.current_quantity', 'menus.quantity', 'menus.price', 'menus.slug')
            ->join('menu_categories' , 'menus.category_id', '=', 'menu_categories.id')
            ->whereRaw("CONCAT_WS(' ', menus.name, menu_categories.name) LIKE '%{$search}%'")
            ->orderBy('name', 'asc')
            ->count();
            $items = DB::table('inventories')->get();
            
        return view('user.cook.menu-preparation', compact('menus', 'menuCount', 'page', 'search', 'items'));
    }

    public function add(){
        $categories = DB::table('menu_categories')->orderBy('name', 'asc')->get();
        $items = DB::table('inventories')->select('id', 'name', 'unit', DB::raw('0 AS is_menu'))->get();
        $menus = DB::table('menus')->get();

        // $menuQuery = DB::table('menus')
        //     ->select('id', 'name', 'unit', DB::raw('1 AS is_menu'));
        
        // $inventoryQuery = DB::table('inventories')
        //     ->select('id', 'name', 'unit', DB::raw('0 AS is_menu'));
        
        // $items = $menuQuery->union($inventoryQuery)->get();

        // if(auth()->user()->role == 1){
            // return view('user.inventory.menu.add', compact('categories', 'items', 'menus'));
        // }elseif(auth()->user()->role == 3){
        return view('user.cook.menu-preparation-add', compact('categories','items', 'menus'));
        // }
    }

    public function changeIng(Request $request){
        if($request->combo == 'true'){
            $items = DB::table('menus')
                ->select('id', 'name', 'unit', DB::raw('1 AS is_menu'))->get();
            
            // $inventoryQuery = DB::table('inventories')
                // ->select('id', 'name', 'unit', DB::raw('0 AS is_menu'));
            
            // $items = $menuQuery->union($inventoryQuery)->get();
        }else{
            $items = DB::table('inventories')->select('id', 'name', 'unit', DB::raw('0 AS is_menu'))->get();
        }
        $li = '';


        foreach ($items as $item){
            // if($item->is_menu == 1){
            //     $itemName = 'MENU-'.$item->name;
            // }else{
            //     $itemName = $item->name;
            // }
                $itemName = $item->name;
            $li .= '<li data-id="'.$item->id.'" data-name="'.$item->name.'" data-unit="'.$item->unit.'" data-is_menu="'.$item->is_menu.'" data-idnum="1" class="h-9 cursor-pointer hover:bg-gray-300 rounded-md flex items-center pl-3 leading-9">'.$itemName.'</li>';
        }

        $result = '
            <div id="ing1" class="mb-5 flex flex-row gap-x-3">
                <div class="w-2/5">
                    <div class="wrapper w-full relative">
                        <div class="select-btn flex items-center justify-between rounded-md bg-gray-100 border border-gray-300 p-2 h-9 cursor-pointer">
                            <span></span>
                            <i class="uil uil-angle-down text-2xl transition-transform duration-300"></i>
                        </div>
                        <div class="content bg-gray-100 mt-1 rounded-md p-3 hidden absolute w-full z-50">
                            <div class="search relative">
                                <i class="uil uil-search absolute left-3 leading-9 text-gray-500"></i>
                                <input type="text" class="selectSearch w-full leading-9 text-gray-700 rounded-md pl-9 outline-none h-9" placeholder="Search">
                            </div>
                            <ul class="listOption options mt-2 max-h-52 overflow-y-auto">
                                <li data-id="" data-name="" data-unit="" data-is_menu="" data-idnum="1" class="h-9 cursor-pointer hover:bg-gray-300 rounded-md flex items-center pl-3 leading-9">None</li>
                                '.$li.'
                            </ul>
                        </div>
                        <input type="hidden" name="item1" value="">
                    </div>
                </div>
                <div class="w-2/5">
                    <input type="text" id="quantity1" name="quantity1" value="" class="inputNumber block w-full h-9 px-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base text-center" autocomplete="off">
                </div>
                <div class="w-1/5 flex">
                    <div id="unit1" class="w-1/2 text-lg leading-9"></div>
                    <button type="button" data-thisid="ing1" class="removeButton w-1/2 text-center"><i class="uil uil-minus-circle text-red-500 text-3xl"></i></button>
                </div>
            </div>
        ';

        echo $result;
    }

    public function addIng(Request $request){
        $counter = $request->counter;

        if($request->combo == 'true'){
            $menuQuery = DB::table('menus')
                ->select('id', 'name', 'unit', DB::raw('1 AS is_menu'));
            
            $inventoryQuery = DB::table('inventories')
                ->select('id', 'name', 'unit', DB::raw('0 AS is_menu'));
            
            $items = $menuQuery->union($inventoryQuery)->get();
        }else{
            $items = DB::table('inventories')->select('id', 'name', 'unit', DB::raw('0 AS is_menu'))->get();
        }
        $li = '';


        foreach ($items as $item){
            if($item->is_menu == 1){
                $itemName = 'MENU-'.$item->name;
            }else{
                $itemName = $item->name;
            }
            $li .= '<li data-id="'.$item->id.'" data-name="'.$item->name.'" data-unit="'.$item->unit.'" data-is_menu="'.$item->is_menu.'" data-idnum="'.$counter.'" class="h-9 cursor-pointer hover:bg-gray-300 rounded-md flex items-center pl-3 leading-9">'.$itemName.'</li>';
        }

        $result = '
            <div id="ing'.$counter.'" class="mb-5 flex flex-row gap-x-3">
                <div class="w-2/5">
                    <div class="wrapper w-full relative">
                        <div class="select-btn flex items-center justify-between rounded-md bg-gray-100 border border-gray-300 p-2 h-9 cursor-pointer">
                            <span></span>
                            <i class="uil uil-angle-down text-2xl transition-transform duration-300"></i>
                        </div>
                        <div class="content bg-gray-100 mt-1 rounded-md p-3 hidden absolute w-full z-50">
                            <div class="search relative">
                                <i class="uil uil-search absolute left-3 leading-9 text-gray-500"></i>
                                <input type="text" class="selectSearch w-full leading-9 text-gray-700 rounded-md pl-9 outline-none h-9" placeholder="Search">
                            </div>
                            <ul class="listOption options mt-2 max-h-52 overflow-y-auto">
                                <li data-id="" data-name="" data-unit="" data-is_menu="" data-idnum="1" class="h-9 cursor-pointer hover:bg-gray-300 rounded-md flex items-center pl-3 leading-9">None</li>
                                '.$li.'
                            </ul>
                        </div>
                        <input type="hidden" name="item'.$counter.'" value="">
                    </div>
                </div>
                <div class="w-2/5">
                    <input type="text" id="quantity'.$counter.'" name="quantity'.$counter.'" value="" class="inputNumber block w-full h-9 px-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base text-center" autocomplete="off">
                </div>
                <div class="w-1/5 flex">
                    <div id="unit'.$counter.'" class="w-1/2 text-lg leading-9"></div>
                    <button type="button" data-thisid="ing'.$counter.'" class="removeButton w-1/2 text-center"><i class="uil uil-minus-circle text-red-500 text-3xl"></i></button>
                </div>
            </div>
        ';

        echo $result;
    }

    public function store(Request $request){
        $name = $request->name;
        $category_id = $request->category_id;
        $price = $request->price;
        $image = $request->image;
        $servings = $request->servings;
        $Totalcounter = $request->counter;
        if($request->combo != null){
            $combo = 1;
        }else{
            $combo = 0;
        }

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
            $path = "images/menu/";
            $imagePath = $path.$filename;
            $request->file('image')->move(public_path('storage/'.$path), $filename);
            // $imagePath = $request->file('image')->storeAs('images/menu',$filename , 'public');
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
        $item->servings = $servings;
        $item->is_combo = $combo;
        if($image != null){
            $item->image = $imagePath;
        }
        $item->slug = $slug;
        $item->save();
        
        for($counter = 1; $counter <= $Totalcounter; $counter++){
            $iname = 'item'.$counter;
            $qname = 'quantity'.$counter;

            if($request->$iname != null){
                $itemsArray = explode(",", $request->$iname);
                $is_menu = $itemsArray[0];
                $item_id = $itemsArray[1];
                $invUnit = (DB::table('inventories')->where('id', $item_id)->first())->unit;
                $ingr = new Ingredient();
                $ingr->menu_id = $item->id;
                $ingr->inventory_id = $item_id;
                $ingr->quantity = $request->$qname;
                $ingr->computed_quantity = $request->$qname / $servings;
                $ingr->unit = $invUnit;
                $ingr->is_menu = $is_menu;
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

        $ingredients = DB::table('ingredients')
            ->select('ingredients.*', DB::raw('CASE WHEN ingredients.is_menu = 1 THEN menus.name WHEN ingredients.is_menu = 0 THEN inventories.name END AS name'))
            ->leftJoin('menus', function ($join) {
                $join->on('ingredients.inventory_id', '=', 'menus.id')
                    ->where('ingredients.is_menu', '=', 1);
            })
            ->leftJoin('inventories', function ($join) {
                $join->on('ingredients.inventory_id', '=', 'inventories.id')
                    ->where('ingredients.is_menu', '=', 0);
            })
            ->where('ingredients.menu_id', $item->id)
            ->get();

        $categories = DB::table('menu_categories')->orderBy('name', 'asc')->get();

        if($item->is_combo == 1){
            $items = DB::table('menus')
                ->select('id', 'name', 'unit', DB::raw('1 AS is_menu'))->get();
            
            // $inventoryQuery = DB::table('inventories')
            //     ->select('id', 'name', 'unit', DB::raw('0 AS is_menu'));
            
            // $items = $menuQuery->union($inventoryQuery)->get();
        }else{
            $items = DB::table('inventories')->select('id', 'name', 'unit', DB::raw('0 AS is_menu'))->get();
        }

        // dd($ingredients->count());

        
        // if(auth()->user()->role == 1){
        //     return view('user.inventory.menu.edit', compact('item', 'ingredients', 'categories', 'items', 'slug'));
        // }elseif(auth()->user()->role == 3){
        return view('user.cook.menu-preparation-edit', compact('item', 'ingredients', 'categories', 'items', 'slug'));
        // }
    }

    public function update(Request $request){
        $oldSlug = $request->slug;
        $name = $request->name;
        $category_id = $request->category_id;
        $price = $request->price;
        $image = $request->image;
        $servings = $request->servings;
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
            $path = "images/menu/";
            $imagePath = $path.$filename;
            $request->file('image')->move(public_path('storage/'.$path), $filename);
            // $imagePath = $request->file('image')->storeAs('images/menu',$filename , 'public');
        }

        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);
        
        DB::table('ingredients')->where('menu_id', $menuID)->delete();

        for($counter = 1; $counter <= $Totalcounter; $counter++){
            $iname = 'item'.$counter;
            $qname = 'quantity'.$counter;

            if($request->$iname != null){
                $itemsArray = explode(",", $request->$iname);
                $is_menu = $itemsArray[0];
                $item_id = $itemsArray[1];
                $invUnit = (DB::table('inventories')->where('id', $item_id)->first())->unit;

                $ingr = new Ingredient();
                $ingr->menu_id = $menuID;
                $ingr->inventory_id = $item_id;
                $ingr->quantity = $request->$qname;
                $ingr->computed_quantity = $request->$qname / $servings;
                $ingr->unit = $invUnit;
                $ingr->is_menu = $is_menu;
                $ingr->save();
            }
        }

        if($image != null){
            DB::table('menus')->where('slug', $oldSlug)
                ->update([
                    'name' => $name,
                    'category_id' => $category_id,
                    'price' => $price,
                    'image' => $imagePath,
                    'servings' => $servings,
                    'slug' => $slug,
                ]);
        }else{
            DB::table('menus')->where('slug', $oldSlug)
                ->update([
                    'name' => $name,
                    'category_id' => $category_id,
                    'price' => $price,
                    'servings' => $servings,
                    'slug' => $slug,
                ]);
        }

        return redirect()->route('menu.index')->withInput()->with('message', 'Successfully Updated');
    }

    public function move(Request $request){
        $slug = $request->moveSlug;
        $qty = $request->moveServings;

        $inv = DB::table('inventories')->where('slug', $slug)->first();
        $menu = DB::table('menus')->where('slug', $slug)->first();

        $nname = $menu->name;

        if(!$inv){
            $cat = DB::table('categories')->where('slug', 'menu')->first();

            if(!$cat){
                $ncat = new Category();
                $ncat->name = 'Menu';
                $ncat->slug = 'menu';
                $ncat->save();

                $catID = $ncat->id;
            }else{
                $catID = $cat->id;
            }

            $ninv = new Inventory();
            $ninv->name = $nname;
            $ninv->category_id = $catID;
            $ninv->quantity = $qty;
            $ninv->reorder_point = '0';
            $ninv->unit = 'pc';
            $ninv->slug = $slug;
            $ninv->save();
        }else{
            DB::table('inventories')->where('slug', $slug)->update([
                'quantity' => $inv->quantity + $qty
            ]);
        }

        DB::table('menus')->where('slug', $slug)->update([
            'current_quantity' => $menu->current_quantity - $qty,
            'quantity' => $menu->quantity - $qty
        ]);

        // if(auth()->user()->role == 1){
            // return redirect()->route('menu.index')->withInput()->with('message', 'Successfully Updated');
        // }elseif(auth()->user()->role == 3){
            return redirect()->route('menu.index')->withInput()->with('message', 'Successfully Moved');
        // }
    }

    public function view(Request $request){
        $slug = $request->slug;
        $menu = DB::table('menus')->where('slug', $slug)->first();
        $name = $menu->name;
        $id = $menu->id;
        $servings = $menu->servings;

        $ings = DB::table('ingredients')
            ->select('ingredients.menu_id', 'ingredients.inventory_id', 'inventories.name as name', 'ingredients.quantity', 'ingredients.computed_quantity', 'ingredients.unit')
            ->join('inventories', 'ingredients.inventory_id', '=', 'inventories.id')
            ->where('menu_id', $id)->orderBy('ingredients.id','asc')->get();

        $ingredients = '';
        $x = 1;

        foreach($ings as $ing){
            $availq = DB::table('inventories')->where('id', $ing->inventory_id)->first();

            $nq = 'ingq'.$x;
            $ingredients .= '
                <div class="px-4 text-xl font-semibold tracking-wide flex items-center">
                    <input type="text" name="'.$nq.'" value="'.round($ing->computed_quantity * $servings, 2).'" class="quantity block w-52 h-9 px-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base text-center" autocomplete="off">
                    <span style="margin-left: 10px;">'.$ing->unit.'</span>

                    <span style="margin-left: 30px;">/</span>

                    <span style="margin-left: 10px; width: 100px; text-align: right;">'.round($availq->quantity,2).'</span>
                    <span style="margin-left: 10px;">'.$availq->unit.'</span>
                    <span style="margin-left: 32px;">'.$ing->name.'</span>
                </div>
            ';
            $x++;
        }
        // <div class="px-4 text-xl font-semibold tracking-wide">
        //     <h1><span>'.$ing->quantity.'</span><span>'.$ing->unit.'</span><span style="margin-left: 32px;">'.$ing->name.'</span></h1>
        // </div>
        

        $result = array(
            'name' => $name,
            'ingredients' => $ingredients,
            'servings' => $servings,
        );
        
        echo json_encode($result);
    }

    public function computeqty(Request $request){
        $slug = $request->slug;
        $qty = $request->qty;

        $menu = DB::table('menus')->where('slug', $slug)->first();
        $name = $menu->name;
        $id = $menu->id;

        $ings = DB::table('ingredients')
            ->select('ingredients.menu_id', 'ingredients.inventory_id', 'inventories.name as name', 'ingredients.quantity', 'ingredients.computed_quantity', 'ingredients.unit')
            ->join('inventories', 'ingredients.inventory_id', '=', 'inventories.id')
            ->where('menu_id', $id)->orderBy('ingredients.id','asc')->get();

        $ingredients = '';
        $x = 1;

        foreach($ings as $ing){
            $availq = DB::table('inventories')->where('id', $ing->inventory_id)->first();
            $nq = 'ingq'.$x;
            $nqty = round($ing->computed_quantity * $qty, 2);

            $ingredients .= '
                <div class="px-4 text-xl font-semibold tracking-wide flex items-center">
                    <input type="text" name="'.$nq.'" value="'.$nqty.'" class="quantity block w-52 h-9 px-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base text-center" autocomplete="off">
                    <span style="margin-left: 10px;">'.$ing->unit.'</span>

                    <span style="margin-left: 30px;">/</span>

                    <span style="margin-left: 10px; width: 100px; text-align: right;">'.round($availq->quantity,2).'</span>
                    <span style="margin-left: 10px;">'.$availq->unit.'</span>
                    <span style="margin-left: 32px;">'.$ing->name.'</span>
                </div>
            ';
            $x++;
        }
        
        $result = array(
            'name' => $name,
            'ingredients' => $ingredients,
        );
        
        echo json_encode($result);
    }

    public function changeqty(Request $request){
        $slug = $request->slug;
        $quantity = $request->servings;
        $Totalcounter = $request->counter;
        $cur_quantity = (DB::table('menus')->where('slug', $slug)->first())->quantity;
        $uqty = $cur_quantity + $quantity;

        $menu = DB::table('menus')->where('slug', $slug)->first();
        $menuID = $menu->id;
        $menuName = $menu->name;
        $ings = DB::table('ingredients')->where('menu_id', $menuID)->orderBy('id','asc')->get();

        if($ings->count() > 0){
            $x = 1;
            foreach($ings as $ing){
                $nq = 'ingq'.$x;
                $old_quantity = (DB::table('inventories')->where('id', $ing->inventory_id)->first())->quantity;
                $tqty = $request->$nq;
                $new_quantity = $old_quantity - $tqty;

                if($new_quantity < 0){
                    return redirect()->route('menu.index')->withInput()->with('error', 'Insufficient Ingredients');
                }

                $x++;
            }
            $x = 1;
            foreach($ings as $ing){
                $nq = 'ingq'.$x;
                $old_quantity = (DB::table('inventories')->where('id', $ing->inventory_id)->first())->quantity;
                $tqty = $request->$nq;
                // $tqty = $ing->quantity * $quantity;
                $new_quantity = $old_quantity - $tqty;

                DB::table('inventories')->where('id', $ing->inventory_id)->update([
                    'quantity' => $new_quantity
                ]);

                $it = new InventoryTransaction();
                $it->inv_id = $ing->inventory_id;
                $it->type = 'OUTGOING';
                $it->quantity_before = round($old_quantity,2);
                $it->quantity = $tqty;
                $it->quantity_after = $new_quantity;
                $it->remarks = $menuName;
                $it->user_id = Auth::id();
                $it->save();

                $x++;
            }
        }
        
        for($counter = 1; $counter <= $Totalcounter; $counter++){
            $iname = 'item'.$counter;
            $qname = 'quantity'.$counter;
            $inv = DB::table('inventories')->where('id', $request->$iname)->first();

            if($request->$iname != null){
                $it = new InventoryTransaction();
                $it->inv_id = $request->$iname;
                $it->type = 'OUTGOING';
                $it->quantity_before = $inv->quantity;
                $it->quantity = $request->$qname;
                $it->quantity_after = $inv->quantity - $request->$qname;
                $it->remarks = $menuName;
                $it->user_id = Auth::id();
                $it->save();

                DB::table('inventories')->where('id', $request->$iname)->update([
                    'quantity' => $inv->quantity - $request->$qname
                ]);
            }
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

    public function dispose(Request $request){
        $menu = DB::table('menus')->where('slug', $request->disposeSlug)->first();
        $quantity = $request->quantity;
        $date = date('Y-m-d H:i:s', strtotime($request->disposeDate));

        if($menu->current_quantity < $quantity){
            return redirect()->route('menu.index')->withInput()->with('error', 'Please Enter a valid Quantity.');
        }

        $waste = new Waste();
        $waste->on = 'MENU';
        $waste->iid = $menu->id;
        $waste->quantity = $quantity;
        $waste->created_at = $date;
        $waste->save();

        DB::table('menus')->where('slug', $request->disposeSlug)->decrement('quantity', $quantity);
        DB::table('menus')->where('slug', $request->disposeSlug)->decrement('current_quantity', $quantity);

        return redirect()->route('menu.index')->withInput()->with('message', 'Menu Successfully Disposed');
    }
}
