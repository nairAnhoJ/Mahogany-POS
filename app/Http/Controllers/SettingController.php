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
        $email = $request->email;
        
        $buffer_margin = ($request->buffer_margin / 100);
        $markup = ($request->markup / 100);
        $price_adjustment = ($request->price_adjustment / 100);
        $staff_incentives = $request->staff_incentives;
        $manager_incentives = ($request->manager_incentives / 100);
        $vat = ($request->vat / 100);
        
        $service_charge = ($request->service_charge / 100);

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
                'footer' => $footer,
                'email' => $email,
                
                'buffer_margin' => $buffer_margin,
                'markup' => $markup,
                'price_adjustment' => $price_adjustment,
                'staff_incentives' => $staff_incentives,
                'manager_incentives' => $manager_incentives,
                'vat' => $vat,
                
                'service_charge' => $service_charge,
            ]);
        }else{
            DB::table('settings')->where('id', 1)->update([
                'name' => $name,
                'address' => $address,
                'number' => $number,
                'footer' => $footer,
                'email' => $email,
                
                'buffer_margin' => $buffer_margin,
                'markup' => $markup,
                'price_adjustment' => $price_adjustment,
                'staff_incentives' => $staff_incentives,
                'manager_incentives' => $manager_incentives,
                'vat' => $vat,
                
                'service_charge' => $service_charge,
            ]);
        }

        return redirect()->route('settings.index');
    }
}
