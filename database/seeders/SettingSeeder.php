<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'name' => 'RESTAURANT NAME',
            'address' => 'RESTAURANT ADDRESS',
            'number' => '0912 345 6789',
            'logo' => 'images/ico/logo.png',
            'footer' => 'THANK YOU FOR DINING WITH US!!!',
        ]);
    }
}
