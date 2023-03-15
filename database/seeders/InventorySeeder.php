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
        for($i = 1; $i <= 10; $i++){
            $name = $faker->sentence;
            $slug = Str::random(60);
            $check_slug = DB::table('inventories')->where('slug', $slug)->get();
            while(count($check_slug) > 0){
                $slug = Str::random(60);
                $check_slug = DB::table('inventories')->where('slug', $slug)->get();
            }
            Inventory::create([
                'item_code' => $faker->name,
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
