<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\User::create([
            'name'=> 'Olagoke Mubarak',
            'email'=> 'mubarakolagoke@gmail.com',
            'phone'=> '07036998003',
            'role'=> 'admin',
            'password'=> Hash::make('Ajirin01'),
        ]);
        \App\Models\User::factory(20)->create();
        
        \App\Models\Seller::factory(40)->create();

        \App\Models\Category::create([
            'name'=> 'Uncategorised'
        ]);

        \App\Models\Brand::create([
            'name'=> 'Generic'
        ]);

        \App\Models\Category::factory(20)->create();
        

        \App\Models\Brand::factory(20)->create();

        \App\Models\ProductVariation::factory(10)->create();
        \App\Models\Product::factory(100)->create();
        \App\Models\Shop::factory(50)->create();
        \App\Models\Order::factory(100)->create();
        \App\Models\Cart::factory(100)->create();
        \App\Models\Earning::factory(100)->create();
        \App\Models\Withdrawal::factory(30)->create();
        \App\Models\ShippingAddress::factory(100)->create();
        \App\Models\ProductReview::factory(100)->create();
        \App\Models\WishList::factory(50)->create();
    }
}
