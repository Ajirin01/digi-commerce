<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Shop;

class ShopFactory extends Factory
{
    protected $model = Shop::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->paragraph,
            'status' => 'active',
            'logo' => $this->faker->imageUrl(),
            // Add foreign key relationships as needed
            'seller_id' => \App\Models\Seller::factory(),
        ];
    }
}

