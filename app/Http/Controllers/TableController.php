<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class TableController extends Controller
{
    public function index(){
        $tables = DB::table('tables')->orderBy('id', 'asc')->paginate(100);
        $tableCount = DB::table('tables')->get()->count();
        $page = 1;
        $search = "";
        return view('admin.system-management.tables.index', compact('tables', 'tableCount', 'page', 'search'));
    }

    public function paginate($page){
        $tables = DB::table('tables')->orderBy('id', 'asc')->paginate(100,'*','page',$page);
        $tableCount = DB::table('tables')->get()->count();
        $search = "";
        return view('admin.system-management.tables.index', compact('tables', 'tableCount', 'page', 'search'));
    }

    public function search($page, $search){
        $tables = DB::table('tables')
            ->select('*')
            ->whereRaw("CONCAT_WS(' ', name, username) LIKE '%{$search}%'")
            ->orderBy('id', 'asc')
            ->paginate(100,'*','page',$page);

        $tableCount = DB::table('tables')
            ->select('*')
            ->whereRaw("CONCAT_WS(' ', name, username) LIKE '%{$search}%'")
            ->orderBy('id', 'asc')
            ->count();
        return view('admin.system-management.tables.index', compact('tables', 'tableCount', 'page', 'search'));
    }

    public function add(){
        return view('admin.system-management.tables.add');
    }

    public function store(Request $request){
        $name = strtoupper($request->name);

        $request->validate([
            'name' => ['required'],
        ]);

        $table = new Table();
        $table->name = $name;
        $table->slug = Str::random(60);
        $table->save();

        return redirect()->route('table.index')->withInput()->with('message', 'Successfully Added');
    }

    public function edit($slug){
        $table = DB::table('tables')->where('slug', $slug)->first();
        return view('admin.system-management.tables.edit', compact('table'));
    }

    public function update(Request $request){
        $name = strtoupper($request->name);
        $slug = $request->slug;

        $request->validate([
            'name' => ['required'],
        ]);

        DB::table('tables')->where('slug', $slug)
            ->update([
                'name' => $name,
            ]);

        return redirect()->route('table.index')->withInput()->with('message', 'Successfully Updated');
    }

    public function delete($slug){
        DB::table('tables')->where('slug', $slug)->delete();

        return redirect()->route('table.index')->withInput()->with('message', 'Successfully Deleted');
    }
}
