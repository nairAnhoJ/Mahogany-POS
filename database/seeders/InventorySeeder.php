<?php

namespace Database\Seeders;

use App\Models\Inventory;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for($i = 1; $i <= rand(10, 20); $i++){
            $name = $faker->realText(20, 3);
            // $slug = Str::random(60);
            $slug = Str::slug($name, '-');
            $check_slug = DB::table('inventories')->where('slug', $slug)->get();
            $x = 1;
            $nslug = $slug;
            while(count($check_slug) > 0){
                // $slug = Str::random(60);
                $nslug = $slug.'-'.$x;
                $check_slug = DB::table('inventories')->where('slug', $nslug)->get();
                $x++;
            }
            $slug = $nslug;
            Inventory::create([
                'item_code' => null,
                'name' => $name,
                'category_id' => rand(1,10),
                'quantity' => rand(10,100),
                'price' => rand(1000,100000),
                'image' => null,
                'slug' => $slug,
            ]);
        }
    }
}
