<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->numberBetween(10, 100),
            'quantity' => $this->faker->numberBetween(1, 100),
            'sold' => 0,
            'status' => 'active',
            'sale_type' => $this->faker->randomElement(['featured', 'hot_sale', 'new_arrival', 'normal']),
            'variations' => json_encode([]),
            'photos' => json_encode([$this->faker->imageUrl(), $this->faker->imageUrl(),$this->faker->imageUrl(),$this->faker->imageUrl()]),
            'percent_off' => $this->faker->randomFloat(2, 0, 50), // Adjust the range as needed
            'sale_start' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'sale_end' => $this->faker->dateTimeBetween('now', '+1 month'),
            // Add foreign key relationships as needed
            // 'shop_id' => \App\Models\Shop::factory(),
            // 'category_id' => \App\Models\Category::factory(),
            // 'brand_id' => \App\Models\Brand::factory(),
            'shop_id' => random_int(1, 20),
            'category_id' => random_int(1, 20),
            'brand_id' => random_int(1, 20),
        ];
    }
}

