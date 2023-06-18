<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(TableSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(DiscountSeeder::class);
        // $this->call(InventorySeeder::class);
        // $this->call(MenuSeeder::class);
        // $this->call(InventoryCategorySeeder::class);
        // $this->call(MenuCategorySeeder::class);
    }
}
