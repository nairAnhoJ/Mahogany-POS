<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'username' => 'POS-admin',
            'password' => '$2y$10$q0cHOBT5KkT0gjmG06/SUeaYKpoGfdhnIeWUv5qtuHgROpXVLRRka',
            'role' => 0,
            'slug' => Str::random(60),
        ]);
    }
}
