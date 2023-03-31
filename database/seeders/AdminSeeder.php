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
            'name' => 'ADMINISTRATOR',
            'username' => 'POS-admin',
            'password' => '$2y$10$q0cHOBT5KkT0gjmG06/SUeaYKpoGfdhnIeWUv5qtuHgROpXVLRRka',
            'role' => 1,
            'slug' => Str::random(60),
        ]);
        User::create([
            'name' => 'COOK',
            'username' => 'pos-cook',
            'password' => '$2y$10$okt4/oFVmsAeFcmFCMdR2u4.GeHt9KWymtuqa8hgS7jHk.N7CegYK',
            'role' => 3,
            'slug' => Str::random(60),
        ]);
    }
}
