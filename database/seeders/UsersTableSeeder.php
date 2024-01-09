<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        // Create a seller user
        User::factory()->create([
            'name' => 'Seller',
            'email' => 'seller@example.com',
            'role' => 'seller',
        ]);

        // Create a shopper user
        User::factory()->create([
            'name' => 'Shopper',
            'email' => 'shopper@example.com',
            'role' => 'shopper',
        ]);
    }
}
