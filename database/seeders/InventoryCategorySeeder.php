<?php

namespace Database\Seeders;

use App\Models\Category;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventoryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for($i = 1; $i <= rand(10, 20); $i++){
            $name = $faker->text(10, 2);
            $slug = Str::slug($name, '-');
            $check_slug = DB::table('categories')->where('slug', $slug)->get();
            $x = 1;
            $nslug = $slug;
            while(count($check_slug) > 0){
                $nslug = $slug.'-'.$x;
                $check_slug = DB::table('categories')->where('slug', $nslug)->get();
                $x++;
            }
            $slug = $nslug;
            Category::create([
                'name' => $name,
                'slug' => $slug,
            ]);
        }
    }
}
