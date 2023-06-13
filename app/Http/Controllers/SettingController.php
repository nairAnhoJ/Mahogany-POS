<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function settings(){
        $settings = DB::table('settings')->where('id', 1)->first();

        return view('admin.system-management.settings.index', compact('settings'));
    }

    public function store(Request $request){
        $name = $request->name;
        $address = $request->address;
        $number = $request->number;
        $logo = $request->logo;
        $footer = $request->footer;

        $imagePath = null;
        if($logo != null){
            $filename = 'logo.' . $request->file('logo')->getClientOriginalExtension();
            $path = "images/ico/";
            $imagePath = $path.$filename;
            $request->file('logo')->move(public_path('storage/'.$path), $filename);
            // $imagePath = $request->file('logo')->storeAs('images/ico',$filename , 'public');

            DB::table('settings')->where('id', 1)->update([
                'name' => $name,
                'address' => $address,
                'number' => $number,
                'logo' => $imagePath,
                'footer' => $footer
            ]);
        }else{
            DB::table('settings')->where('id', 1)->update([
                'name' => $name,
                'address' => $address,
                'number' => $number,
                'footer' => $footer
            ]);
        }

        return redirect()->route('settings.index');
    }
}
