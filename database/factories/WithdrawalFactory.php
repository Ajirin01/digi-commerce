<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Withdrawal;

class WithdrawalFactory extends Factory
{
    protected $model = Withdrawal::class;

    public function definition()
    {
        return [
            'amount' => $this->faker->randomFloat(2, 50, 500),
            'status' => $this->faker->randomElement(['pending', 'completed']),
            'earnings_to_transfer' => json_encode([]), // Add earnings details based on your structure
            // Add foreign key relationships as needed
            'seller_id' => \App\Models\Seller::factory(),
        ];
    }
}

