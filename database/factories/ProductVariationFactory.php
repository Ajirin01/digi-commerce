<?php

namespace Database\Factories;


use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariationFactory extends Factory
{
    protected $model = ProductVariation::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'quantity' => $this->faker->randomNumber(2),
            'variation' => json_encode([])
            // Add other variation-specific attributes here
        ];
    }
}

