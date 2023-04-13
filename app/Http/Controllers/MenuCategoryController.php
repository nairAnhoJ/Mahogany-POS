<?php

namespace App\Http\Controllers;

use App\Models\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuCategoryController extends Controller
{
    public function index(){
        $categories = DB::table('menu_categories')->orderBy('name', 'asc')->paginate(100);
        $categoryCount = DB::table('menu_categories')->get()->count();
        $page = 1;
        $search = "";
        return view('admin.system-management.menu-categories.index', compact('categories', 'categoryCount', 'page', 'search'));
    }

    public function paginate($page){
        $categories = DB::table('menu_categories')->orderBy('name', 'asc')->paginate(100,'*','page',$page);
        $categoryCount = DB::table('menu_categories')->get()->count();
        $search = "";
        return view('admin.system-management.menu-categories.index', compact('categories', 'categoryCount', 'page', 'search'));
    }

    public function search($page, $search){
        $categories = DB::table('menu_categories')
            ->select('*')
            ->whereRaw("CONCAT_WS(' ', name) LIKE '%{$search}%'")
            ->orderBy('name', 'asc')
            ->paginate(100,'*','page',$page);

        $categoryCount = DB::table('menu_categories')
            ->select('*')
            ->whereRaw("CONCAT_WS(' ', name) LIKE '%{$search}%'")
            ->orderBy('name', 'asc')
            ->count();
        return view('admin.system-management.menu-categories.index', compact('categories', 'categoryCount', 'page', 'search'));
    }

    public function add(){
        return view('admin.system-management.menu-categories.add');
    }

    public function store(Request $request){
        $name = $request->name;

        $request->validate([
            'name' => ['required'],
        ]);

        $category = new MenuCategory();
        $category->name = $name;
        $category->slug = Str::random(60);
        $category->save();

        return redirect()->route('menu.category.index')->withInput()->with('message', 'Successfully Added');
    }

    public function edit($slug){
        $category = DB::table('menu_categories')->where('slug', $slug)->first();
        return view('admin.system-management.menu-categories.edit', compact('category'));
    }

    public function update(Request $request){
        $name = $request->name;
        $slug = $request->slug;

        $request->validate([
            'name' => ['required'],
        ]);

        DB::table('menu_categories')->where('slug', $slug)
            ->update([
                'name' => $name,
            ]);

        return redirect()->route('menu.category.index')->withInput()->with('message', 'Successfully Updated');
    }

    public function delete($slug){
        DB::table('menu_categories')->where('slug', $slug)->delete();

        return redirect()->route('menu.category.index')->withInput()->with('message', 'Successfully Deleted');
    }
}