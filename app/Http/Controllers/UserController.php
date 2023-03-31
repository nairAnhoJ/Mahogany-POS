<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(){
        $users = DB::table('users')->orderBy('name', 'asc')->paginate(100);
        $userCount = DB::table('users')->get()->count();
        $page = 1;
        $search = "";
        return view('admin.system-management.users.index', compact('users', 'userCount', 'page', 'search'));
    }

    public function paginate($page){
        $users = DB::table('users')->orderBy('name', 'asc')->paginate(100,'*','page',$page);
        $userCount = DB::table('users')->get()->count();
        $search = "";
        return view('admin.system-management.users.index', compact('users', 'userCount', 'page', 'search'));
    }

    public function search($page, $search){
        $users = DB::table('users')
            ->select('*')
            ->whereRaw("CONCAT_WS(' ', name, username) LIKE '%{$search}%'")
            ->orderBy('name', 'asc')
            ->paginate(100,'*','page',$page);

        $userCount = DB::table('users')
            ->select('*')
            ->whereRaw("CONCAT_WS(' ', name, username) LIKE '%{$search}%'")
            ->orderBy('name', 'asc')
            ->count();
        return view('admin.system-management.users.index', compact('users', 'userCount', 'page', 'search'));
    }

    public function add(){
        return view('admin.system-management.users.add');
    }

    public function store(Request $request){
        $name = $request->name;
        $username = $request->username;
        $role = $request->role;
        $password = $request->password;

        $request->validate([
            'name' => ['required'],
            'username' => ['required'],
            'password' => ['required', 'min:8', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = new User();
        $user->name = strtoupper($name);
        $user->username = $username;
        $user->role = $role;
        $user->password = Hash::make($password);
        $user->slug = Str::random(60);
        $user->save();

        return redirect()->route('user.index')->withInput()->with('message', 'Successfully Added');
    }

    public function edit($slug){
        $user = DB::table('users')->where('slug', $slug)->first();
        return view('admin.system-management.users.edit', compact('user'));
    }

    public function update(Request $request){
        $name = $request->name;
        $username = $request->username;
        $role = $request->role;
        $password = $request->password;
        $slug = $request->slug;

        if($password != null){
            $request->validate([
                'name' => ['required'],
                'username' => ['required'],
                'password' => ['required', 'min:8', 'confirmed', Rules\Password::defaults()],
            ]);

            DB::table('users')->where('slug', $slug)
                ->update([
                    'name' => strtoupper($name),
                    'username' => $username,
                    'role' => $role,
                    'password' => $password
                ]);
        }else{
            $request->validate([
                'name' => ['required'],
                'username' => ['required'],
            ]);

            DB::table('users')->where('slug', $slug)
                ->update([
                    'name' => strtoupper($name),
                    'username' => $username,
                    'role' => $role,
                ]);
        }

        return redirect()->route('user.index')->withInput()->with('message', 'Successfully Updated');
    }

    public function delete($slug){
        DB::table('users')->where('slug', $slug)->delete();

        return redirect()->route('user.index')->withInput()->with('message', 'Successfully Deleted');
    }
}
