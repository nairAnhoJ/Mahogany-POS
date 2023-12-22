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

class MenuController extends Controller {
    public function index() {
        $comboMenus = Menu::where('is_combo', 1)->where('is_deleted', 0)->get();

        foreach ($comboMenus as $comboMenu) {
            $ingredients = Ingredient::where('menu_id', $comboMenu->id)->where('is_deleted', 0)->get();

            if ($ingredients->count() == 0) {
                $minQuantity = 0;
            } else {
                $minQuantity = PHP_INT_MAX;
            }

            foreach ($ingredients as $ingredient) {
                $inventoryQuantity = $ingredient->menu->quantity;
                $requiredQuantity = $ingredient->quantity;
                $availableCombos = floor($inventoryQuantity / $requiredQuantity);
                $minQuantity = min($minQuantity, $availableCombos);
            }

            $comboMenu->update([
                'quantity' => $minQuantity,
                'current_quantity' => $minQuantity,
            ]);
        }

        $menus = Menu::with('category')->where('is_deleted', 0)->orderBy('name', 'asc')->paginate(100);

        $items = DB::table('inventories')->where('is_deleted', 0)->get();
        $menuCount = $menus->total();
        $page = 1;
        $search = "";

        return view('user.cook.menu-preparation', compact('menus', 'menuCount', 'page', 'search', 'items'));
    }

    public function paginate($page) {
        $comboMenus = Menu::where('is_combo', 1)->where('is_deleted', 0)->get();

        foreach ($comboMenus as $comboMenu) {
            $ingredients = Ingredient::where('menu_id', $comboMenu->id)->where('is_deleted', 0)->get();

            if ($ingredients->count() == 0) {
                $minQuantity = 0;
            } else {
                $minQuantity = PHP_INT_MAX;
            }

            foreach ($ingredients as $ingredient) {
                $inventoryQuantity = $ingredient->menu->quantity;
                $requiredQuantity = $ingredient->quantity;
                $availableCombos = floor($inventoryQuantity / $requiredQuantity);
                $minQuantity = min($minQuantity, $availableCombos);
            }

            $comboMenu->update([
                'quantity' => $minQuantity,
                'current_quantity' => $minQuantity,
            ]);
        }

        $menus = Menu::with('category')->where('is_deleted', 0)->orderBy('name', 'asc')->paginate(100, '*', 'page', $page);

        $items = DB::table('inventories')->where('is_deleted', 0)->get();
        $menuCount = $menus->total();
        $page = $page;
        $search = "";

        return view('user.cook.menu-preparation', compact('menus', 'menuCount', 'page', 'search', 'items'));
    }

    public function search($page, $search) {
        $comboMenus = Menu::where('is_combo', 1)->where('is_deleted', 0)->get();

        foreach ($comboMenus as $comboMenu) {
            $ingredients = Ingredient::where('menu_id', $comboMenu->id)->where('is_deleted', 0)->get();

            if ($ingredients->count() == 0) {
                $minQuantity = 0;
            } else {
                $minQuantity = PHP_INT_MAX;
            }

            foreach ($ingredients as $ingredient) {
                $inventoryQuantity = $ingredient->menu->quantity;
                $requiredQuantity = $ingredient->quantity;
                $availableCombos = floor($inventoryQuantity / $requiredQuantity);
                $minQuantity = min($minQuantity, $availableCombos);
            }

            $comboMenu->update([
                'quantity' => $minQuantity,
                'current_quantity' => $minQuantity,
            ]);
        }

        $menus = Menu::with('category')->whereRaw("CONCAT_WS(' ', name) LIKE '%{$search}%'")->where('is_deleted', 0)->orderBy('name', 'asc')->paginate(100, '*', 'page', $page);

        $items = DB::table('inventories')->where('is_deleted', 0)->get();
        $menuCount = $menus->total();
        $page = $page;
        $search = $search;

        return view('user.cook.menu-preparation', compact('menus', 'menuCount', 'page', 'search', 'items'));
    }

    public function add() {
        $categories = DB::table('menu_categories')->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $items = DB::table('inventories')->select('id', 'name', 'unit', DB::raw('0 AS is_menu'))->where('is_deleted', 0)->get();
        $menus = DB::table('menus')->where('is_deleted', 0)->get();

        return view('user.cook.menu-preparation-add', compact('categories', 'items', 'menus'));
    }

    public function changeIng(Request $request) {
        if ($request->combo == 'true') {
            $items = DB::table('menus')->select('id', 'name', 'unit', DB::raw('1 AS is_menu'))->where('is_deleted', 0)->where('is_combo', 0)->get();
        } else {
            $items = DB::table('inventories')->select('id', 'name', 'unit', DB::raw('0 AS is_menu'))->where('is_deleted', 0)->get();
        }
        $li = '';


        foreach ($items as $item) {
            $itemName = $item->name;
            $li .= '<li data-id="' . $item->id . '" data-name="' . $item->name . '" data-unit="' . $item->unit . '" data-is_menu="' . $item->is_menu . '" data-idnum="1" class="flex items-center pl-3 leading-9 rounded-md cursor-pointer h-9 hover:bg-gray-300">' . $itemName . '</li>';
        }

        $result = '
            <div id="ing1" class="flex flex-row mb-5 gap-x-3">
                <div class="w-2/5">
                    <div class="relative w-full wrapper">
                        <div class="flex items-center justify-between p-2 bg-gray-100 border border-gray-300 rounded-md cursor-pointer select-btn h-9">
                            <span></span>
                            <i class="text-2xl transition-transform duration-300 uil uil-angle-down"></i>
                        </div>
                        <div class="absolute z-50 hidden w-full p-3 mt-1 bg-gray-100 rounded-md content">
                            <div class="relative search">
                                <i class="absolute leading-9 text-gray-500 uil uil-search left-3"></i> 
                                <input type="text" class="w-full leading-9 text-gray-700 rounded-md outline-none selectSearch pl-9 h-9" placeholder="Search">
                            </div>
                            <ul class="mt-2 overflow-y-auto listOption options max-h-52">
                                <li data-id="" data-name="" data-unit="" data-is_menu="" data-idnum="1" class="flex items-center pl-3 leading-9 rounded-md cursor-pointer h-9 hover:bg-gray-300">None</li>
                                ' . $li . '
                            </ul>
                        </div>
                        <input type="hidden" name="item1" value="">
                    </div>
                </div>
                <div class="w-2/5">
                    <input type="text" id="quantity1" name="quantity1" value="" class="block w-full px-2 text-center text-gray-900 border border-gray-300 rounded-lg inputNumber h-9 bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" autocomplete="off">
                </div>
                <div class="flex w-1/5">
                    <div id="unit1" class="w-1/2 text-lg leading-9"></div>
                    <button type="button" data-thisid="ing1" class="w-1/2 text-center removeButton"><i class="text-3xl text-red-500 uil uil-minus-circle"></i></button>
                </div>
            </div>
        ';

        echo $result;
    }

    public function addIng(Request $request) {
        $counter = $request->counter;

        if ($request->combo == 'true') {
            $items = DB::table('menus')->select('id', 'name', 'unit', DB::raw('1 AS is_menu'))->where('is_deleted', 0)->where('is_combo', 0)->get();
        } else {
            $items = DB::table('inventories')->select('id', 'name', 'unit', DB::raw('0 AS is_menu'))->where('is_deleted', 0)->get();
        }
        $li = '';

        foreach ($items as $item) {
            $li .= '<li data-id="' . $item->id . '" data-name="' . $item->name . '" data-unit="' . $item->unit . '" data-is_menu="' . $item->is_menu . '" data-idnum="' . $counter . '" class="flex items-center pl-3 leading-9 rounded-md cursor-pointer h-9 hover:bg-gray-300">' . $item->name . '</li>';
        }

        $result = '
            <div id="ing' . $counter . '" class="flex flex-row mb-5 gap-x-3">
                <div class="w-2/5">
                    <div class="relative w-full wrapper">
                        <div class="flex items-center justify-between p-2 bg-gray-100 border border-gray-300 rounded-md cursor-pointer select-btn h-9">
                            <span></span>
                            <i class="text-2xl transition-transform duration-300 uil uil-angle-down"></i>
                        </div>
                        <div class="absolute z-50 hidden w-full p-3 mt-1 bg-gray-100 rounded-md content">
                            <div class="relative search">
                                <i class="absolute leading-9 text-gray-500 uil uil-search left-3"></i>
                                <input type="text" class="w-full leading-9 text-gray-700 rounded-md outline-none selectSearch pl-9 h-9" placeholder="Search">
                            </div>
                            <ul class="mt-2 overflow-y-auto listOption options max-h-52">
                                <li data-id="" data-name="" data-unit="" data-is_menu="" data-idnum="1" class="flex items-center pl-3 leading-9 rounded-md cursor-pointer h-9 hover:bg-gray-300">None</li>
                                ' . $li . '
                            </ul>
                        </div>
                        <input type="hidden" name="item' . $counter . '" value="">
                    </div>
                </div>
                <div class="w-2/5">
                    <input type="text" id="quantity' . $counter . '" name="quantity' . $counter . '" value="" class="block w-full px-2 text-center text-gray-900 border border-gray-300 rounded-lg inputNumber h-9 bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" autocomplete="off">
                </div>
                <div class="flex w-1/5">
                    <div id="unit' . $counter . '" class="w-1/2 text-lg leading-9"></div>
                    <button type="button" data-thisid="ing' . $counter . '" class="w-1/2 text-center removeButton"><i class="text-3xl text-red-500 uil uil-minus-circle"></i></button>
                </div>
            </div>
        ';

        echo $result;
    }

    public function store(Request $request) {
        $name = $request->name;
        $category_id = $request->category_id;
        $price = $request->price;
        $image = $request->image;
        $reorder_point = $request->reorder_point;
        $servings = $request->servings;
        $Totalcounter = $request->counter;
        if ($request->combo != null) {
            $combo = 1;
        } else {
            $combo = 0;
        }
        if ($request->hidden != null) {
            $hidden = 1;
        } else {
            $hidden = 0;
        }

        $slug = Str::slug($name, '-');
        $check_slug = DB::table('menus')->where('slug', $slug)->get();
        $x = 1;
        $nslug = $slug;
        while (count($check_slug) > 0) {
            $nslug = $slug . '-' . $x;
            $check_slug = DB::table('menus')->where('slug', $nslug)->get();
            $x++;
        }
        $slug = $nslug;

        $imagePath = null;
        if ($image != null) {
            $filename = $slug . '.' . $request->file('image')->getClientOriginalExtension();
            $path = "images/menu/";
            $imagePath = $path . $filename;
            $request->file('image')->move(public_path('storage/' . $path), $filename);
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
        $item->reorder_point = $reorder_point;
        $item->servings = $servings;
        $item->is_combo = $combo;
        $item->is_hidden = $hidden;
        if ($image != null) {
            $item->image = $imagePath;
        }
        $item->slug = $slug;
        $item->save();

        for ($counter = 1; $counter <= $Totalcounter; $counter++) {
            $iname = 'item' . $counter;
            $qname = 'quantity' . $counter;

            if ($request->$iname != null) {
                $itemsArray = explode(",", $request->$iname);
                $is_menu = $itemsArray[0];
                $item_id = $itemsArray[1];

                if ($request->combo != null) {
                    $invUnit = 'pc/s';
                } else {
                    $invUnit = (DB::table('inventories')->where('id', $item_id)->first())->unit;
                }

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

    public function edit($slug) {
        $item = DB::table('menus')->where('slug', $slug)->first();
        $categories = DB::table('menu_categories')->orderBy('name', 'asc')->where('is_deleted', 0)->get();

        if ($item->is_combo == 1) {
            $items = DB::table('menus')->select('id', 'name', 'unit', DB::raw('1 AS is_menu'))->where('is_deleted', 0)->where('is_combo', 0)->get();
            $ingredients = Ingredient::with('menu')->where('menu_id', $item->id)->where('is_deleted', 0)->get();
        } else {
            $items = DB::table('inventories')->select('id', 'name', 'unit', DB::raw('0 AS is_menu'))->where('is_deleted', 0)->get();
            $ingredients = Ingredient::with('inv')->where('menu_id', $item->id)->where('is_deleted', 0)->get();
        }

        return view('user.cook.menu-preparation-edit', compact('item', 'ingredients', 'categories', 'items', 'slug'));
    }

    public function update(Request $request) {
        $oldSlug = $request->slug;
        $name = $request->name;
        $category_id = $request->category_id;
        $price = $request->price;
        $image = $request->image;
        $reorder_point = $request->reorder_point;
        $servings = $request->servings;
        $Totalcounter = $request->counter;
        if ($request->combo != null) {
            $combo = 1;
        } else {
            $combo = 0;
        }
        if ($request->hidden != null) {
            $hidden = 1;
        } else {
            $hidden = 0;
        }
        $menuID = (DB::table('menus')->where('slug', $oldSlug)->first())->id;

        $slug = Str::slug($name, '-');
        $check_slug = DB::table('menus')->where('slug', $slug)->get();
        $x = 1;
        $nslug = $slug;
        while (count($check_slug) > 0) {
            $nslug = $slug . '-' . $x;
            $check_slug = DB::table('menus')->where('slug', $nslug)->get();
            $x++;
        }
        $slug = $nslug;

        $imagePath = null;
        if ($image != null) {
            $filename = $slug . '.' . $request->file('image')->getClientOriginalExtension();
            $path = "images/menu/";
            $imagePath = $path . $filename;
            $request->file('image')->move(public_path('storage/' . $path), $filename);
            // $imagePath = $request->file('image')->storeAs('images/menu',$filename , 'public');
        }

        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);

        DB::table('ingredients')->where('menu_id', $menuID)->delete();

        for ($counter = 1; $counter <= $Totalcounter; $counter++) {
            $iname = 'item' . $counter;
            $qname = 'quantity' . $counter;

            if ($request->$iname != null) {
                $itemsArray = explode(",", $request->$iname);
                $is_menu = $itemsArray[0];
                $item_id = $itemsArray[1];

                if ($request->combo != null) {
                    $invUnit = 'pc/s';
                } else {
                    $invUnit = (DB::table('inventories')->where('id', $item_id)->first())->unit;
                }

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

        if ($image != null) {
            DB::table('menus')->where('slug', $oldSlug)
                ->update([
                    'name' => $name,
                    'category_id' => $category_id,
                    'price' => $price,
                    'image' => $imagePath,
                    'reorder_point' => $reorder_point,
                    'servings' => $servings,
                    'is_combo' => $combo,
                    'is_hidden' => $hidden,
                    'slug' => $slug,
                ]);
        } else {
            DB::table('menus')->where('slug', $oldSlug)
                ->update([
                    'name' => $name,
                    'category_id' => $category_id,
                    'price' => $price,
                    'reorder_point' => $reorder_point,
                    'servings' => $servings,
                    'is_combo' => $combo,
                    'is_hidden' => $hidden,
                    'slug' => $slug,
                ]);
        }

        return redirect()->route('menu.index')->withInput()->with('message', 'Successfully Updated');
    }

    public function move(Request $request) {
        $slug = $request->moveSlug;
        $qty = $request->moveServings;

        $inv = DB::table('inventories')->where('slug', $slug)->first();
        $menu = DB::table('menus')->where('slug', $slug)->first();

        $nname = $menu->name;

        if (!$inv) {
            $cat = DB::table('categories')->where('slug', 'menu')->first();

            if (!$cat) {
                $ncat = new Category();
                $ncat->name = 'Menu';
                $ncat->slug = 'menu';
                $ncat->save();

                $catID = $ncat->id;
            } else {
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
        } else {
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

    public function view(Request $request) {
        $slug = $request->slug;
        $menu = DB::table('menus')->where('slug', $slug)->first();
        $name = $menu->name;
        $id = $menu->id;
        $servings = $menu->servings;

        $ings = DB::table('ingredients')
            ->select('ingredients.menu_id', 'ingredients.inventory_id', 'inventories.name as name', 'ingredients.quantity', 'ingredients.computed_quantity', 'ingredients.unit')
            ->join('inventories', 'ingredients.inventory_id', '=', 'inventories.id')
            ->where('menu_id', $id)->where('ingredients.is_deleted', 0)->orderBy('ingredients.id', 'asc')->get();

        $ingredients = '';
        $x = 1;

        foreach ($ings as $ing) {
            $availq = DB::table('inventories')->where('id', $ing->inventory_id)->first();

            $nq = 'ingq' . $x;
            $ingredients .= '
                <div class="flex items-center px-4 text-xl font-semibold tracking-wide">
                    <input type="text" name="' . $nq . '" value="' . round($ing->computed_quantity * $servings, 2) . '" class="block px-2 text-center text-gray-900 border border-gray-300 rounded-lg quantity w-52 h-9 bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" autocomplete="off">
                    <span style="margin-left: 10px;">' . $ing->unit . '</span>

                    <span style="margin-left: 30px;">/</span>

                    <span style="margin-left: 10px; width: 100px; text-align: right;">' . round($availq->quantity, 2) . '</span>
                    <span style="margin-left: 10px;">' . $availq->unit . '</span>
                    <span style="margin-left: 32px;">' . $ing->name . '</span>
                </div>
            ';
            $x++;
        }

        $result = array(
            'name' => $name,
            'ingredients' => $ingredients,
            'servings' => $servings,
        );

        echo json_encode($result);
    }

    public function computeqty(Request $request) {
        $slug = $request->slug;
        $qty = $request->qty;

        $menu = DB::table('menus')->where('slug', $slug)->first();
        $name = $menu->name;
        $id = $menu->id;

        $ings = DB::table('ingredients')
            ->select('ingredients.menu_id', 'ingredients.inventory_id', 'inventories.name as name', 'ingredients.quantity', 'ingredients.computed_quantity', 'ingredients.unit')
            ->join('inventories', 'ingredients.inventory_id', '=', 'inventories.id')
            ->where('menu_id', $id)->where('ingredients.is_deleted', 0)->orderBy('ingredients.id', 'asc')->get();

        $ingredients = '';
        $x = 1;

        foreach ($ings as $ing) {
            $availq = DB::table('inventories')->where('id', $ing->inventory_id)->first();
            $nq = 'ingq' . $x;
            $nqty = round($ing->computed_quantity * $qty, 2);

            $ingredients .= '
                <div class="flex items-center px-4 text-xl font-semibold tracking-wide">
                    <input type="text" name="' . $nq . '" value="' . $nqty . '" class="block px-2 text-center text-gray-900 border border-gray-300 rounded-lg quantity w-52 h-9 bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 lg:text-base" autocomplete="off">
                    <span style="margin-left: 10px;">' . $ing->unit . '</span>

                    <span style="margin-left: 30px;">/</span>

                    <span style="margin-left: 10px; width: 100px; text-align: right;">' . round($availq->quantity, 2) . '</span>
                    <span style="margin-left: 10px;">' . $availq->unit . '</span>
                    <span style="margin-left: 32px;">' . $ing->name . '</span>
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

    public function changeqty(Request $request) {
        $slug = $request->slug;
        $quantity = $request->servings;
        $Totalcounter = $request->counter;
        $cur_quantity = (DB::table('menus')->where('slug', $slug)->first())->quantity;
        $uqty = $cur_quantity + $quantity;

        $menu = DB::table('menus')->where('slug', $slug)->first();
        $menuID = $menu->id;
        $menuName = $menu->name;
        $ings = DB::table('ingredients')->where('menu_id', $menuID)->where('is_deleted', 0)->orderBy('id', 'asc')->get();

        if ($ings->count() > 0) {
            $x = 1;
            foreach ($ings as $ing) {
                $nq = 'ingq' . $x;
                $old_quantity = (DB::table('inventories')->where('id', $ing->inventory_id)->first())->quantity;
                $tqty = $request->$nq;
                $new_quantity = $old_quantity - $tqty;

                if ($new_quantity < 0) {
                    return redirect()->route('menu.index')->withInput()->with('error', 'Insufficient Ingredients');
                }

                $x++;
            }
            $x = 1;
            foreach ($ings as $ing) {
                $nq = 'ingq' . $x;
                $old_quantity = (DB::table('inventories')->where('id', $ing->inventory_id)->first())->quantity;
                $tqty = $request->$nq;
                $new_quantity = $old_quantity - $tqty;

                DB::table('inventories')->where('id', $ing->inventory_id)->update([
                    'quantity' => $new_quantity
                ]);

                $it = new InventoryTransaction();
                $it->inv_id = $ing->inventory_id;
                $it->type = 'OUTGOING';
                $it->quantity_before = round($old_quantity, 2);
                $it->quantity = $tqty;
                $it->quantity_after = $new_quantity;
                $it->remarks = $menuName;
                $it->user_id = Auth::id();
                $it->save();

                $x++;
            }
        }

        for ($counter = 1; $counter <= $Totalcounter; $counter++) {
            $iname = 'item' . $counter;
            $qname = 'quantity' . $counter;
            $inv = DB::table('inventories')->where('id', $request->$iname)->first();

            if ($request->$iname != null) {
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

    public function delete($slug) {
        $menuID = (DB::table('menus')->where('slug', $slug)->first())->id;

        DB::table('ingredients')->where('menu_id', $menuID)
            ->update([
                'is_deleted' => 1,
            ]);

        DB::table('ingredients')->where('is_menu', 1)->where('inventory_id', $menuID)
            ->update([
                'is_deleted' => 1,
            ]);

        DB::table('menus')->where('slug', $slug)
            ->update([
                'is_deleted' => 1,
            ]);

        return redirect()->route('menu.index')->withInput()->with('message', 'Successfully Deleted');
    }

    public function dispose(Request $request) {
        $menu = DB::table('menus')->where('slug', $request->disposeSlug)->first();
        $quantity = $request->quantity;
        $date = date('Y-m-d H:i:s', strtotime($request->disposeDate . ' ' . date('H:i:s')));
        $waste_remarks = $request->waste_remarks;

        if ($menu->current_quantity < $quantity) {
            return redirect()->route('menu.index')->withInput()->with('error', 'Please Enter a valid Quantity.');
        }

        $menuPrice = DB::table('menus')
            ->select('price')
            ->where('id', $menu->id)
            ->first();

        $cost = $menuPrice->price * $quantity;

        $waste = new Waste();
        $waste->on = 'MENU';
        $waste->iid = $menu->id;
        $waste->quantity = $quantity;
        $waste->cost = $cost;
        $waste->created_at = $date;
        $waste->remarks = $waste_remarks;
        $waste->save();

        DB::table('menus')->where('slug', $request->disposeSlug)->decrement('quantity', $quantity);
        DB::table('menus')->where('slug', $request->disposeSlug)->decrement('current_quantity', $quantity);

        return redirect()->route('menu.index')->withInput()->with('message', 'Menu Successfully Disposed');
    }
}
