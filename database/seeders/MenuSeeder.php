<?php

namespace Database\Seeders;

use App\Models\Menu;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for($i = 1; $i <= rand(100, 200); $i++){
            $name = $faker->text(20, 3);
            $slug = Str::slug($name, '-');
            $check_slug = DB::table('menus')->where('slug', $slug)->get();
            $x = 1;
            $nslug = $slug;
            while(count($check_slug) > 0){
                $nslug = $slug.'-'.$x;
                $check_slug = DB::table('menus')->where('slug', $nslug)->get();
                $x++;
            }
            $slug = $nslug;
            Menu::create([
                'name' => $name,
                'category_id' => rand(1,10),
                'current_quantity' => rand(40,60),
                'quantity' => rand(60,70),
                'price' => rand(100,1000),
                'image' => null,
                'slug' => $slug,
            ]);
        }
    }
}
