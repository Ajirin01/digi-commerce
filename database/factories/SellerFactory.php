<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Seller;

class SellerFactory extends Factory
{
    protected $model = Seller::class;

    public function definition()
    {
        return [
            'account_number' => $this->faker->bankAccountNumber,
            'bank_name' => $this->faker->word,
            // Add any additional fields or customization specific to Seller model
            // Add foreign key relationships as needed
            'user_id' => \App\Models\User::factory(),
        ];
    }
}

