<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cart;

class CartFactory extends Factory
{
    protected $model = Cart::class;

    public function definition()
    {
        return [
            'product_id' => \App\Models\Product::factory(),
            'quantity' => $this->faker->numberBetween(1, 5),
            'price'=> $this->faker->numberBetween(10, 100),
            'variations'=> json_encode([]),
            // Add foreign key relationships as needed
            'user_id' => \App\Models\User::factory(),
        ];
    }
}

