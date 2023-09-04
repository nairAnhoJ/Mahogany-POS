<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class CategoryController extends Controller
{
    public function index(){
        $categories = DB::table('categories')->where('is_deleted', 0)->orderBy('name', 'asc')->paginate(100);
        $categoryCount = $categories->total();
        $page = 1;
        $search = "";
        return view('admin.system-management.inventory-categories.index', compact('categories', 'categoryCount', 'page', 'search'));
    }

    public function paginate($page){
        $categories = DB::table('categories')->orderBy('name', 'asc')->where('is_deleted', 0)->paginate(100,'*','page',$page);
        $categoryCount = $categories->total();
        $search = "";
        return view('admin.system-management.inventory-categories.index', compact('categories', 'categoryCount', 'page', 'search'));
    }

    public function search($page, $search){
        $categories = DB::table('categories')
            ->select('*')
            ->where('is_deleted', 0)
            ->whereRaw("CONCAT_WS(' ', name) LIKE '%{$search}%'")
            ->orderBy('name', 'asc')
            ->paginate(100,'*','page',$page);

        $categoryCount = $categories->total();

        return view('admin.system-management.inventory-categories.index', compact('categories', 'categoryCount', 'page', 'search'));
    }

    public function add(){
        return view('admin.system-management.inventory-categories.add');
    }

    public function store(Request $request){
        $name = $request->name;

        $request->validate([
            'name' => ['required'],
        ]);

        $category = new Category();
        $category->name = $name;
        $category->slug = Str::random(60);
        $category->save();

        return redirect()->route('inventory.category.index')->withInput()->with('message', 'Successfully Added');
    }

    public function edit($slug){
        $category = DB::table('categories')->where('slug', $slug)->first();
        return view('admin.system-management.inventory-categories.edit', compact('category'));
    }

    public function update(Request $request){
        $name = $request->name;
        $slug = $request->slug;

        $request->validate([
            'name' => ['required'],
        ]);

        DB::table('categories')->where('slug', $slug)
            ->update([
                'name' => $name,
            ]);

        return redirect()->route('inventory.category.index')->withInput()->with('message', 'Successfully Updated');
    }

    public function delete($slug){
        DB::table('categories')->where('slug', $slug)
            ->update([
                'is_deleted' => 1,
            ]);

        return redirect()->route('inventory.category.index')->withInput()->with('message', 'Successfully Deleted');
    }
}
