<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Earning;

class EarningFactory extends Factory
{
    protected $model = Earning::class;

    public function definition()
    {
        return [
            'amount' => $this->faker->randomFloat(2, 50, 500),
            'paid' => $this->faker->boolean,
            // Add foreign key relationships as needed
            'seller_id' => \App\Models\Seller::factory(),
        ];
    }
}
