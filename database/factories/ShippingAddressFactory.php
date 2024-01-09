<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ShippingAddress;

class ShippingAddressFactory extends Factory
{
    protected $model = ShippingAddress::class;

    public function definition()
    {
        return [
            'street_address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'lga' => "",
            'phone' => "",
            // Add foreign key relationships as needed
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
