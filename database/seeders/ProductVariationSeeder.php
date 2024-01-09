<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariation;

class ProductVariationSeeder extends Seeder
{
    public function run()
    {
        // Assuming you have products in your database
        $products = Product::all();

        // Create variations for each product
        $products->each(function ($product) {
            ProductVariation::factory(50)->create();
        });
    }
}
