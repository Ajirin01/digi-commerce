<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'total_with_shipping' => $this->faker->randomFloat(2, 50, 500),
            'status' => $this->faker->randomElement(['pending', 'processing', 'shipped', 'delivered']),
            'shipping_address' => "",
            'order_details' => json_encode([]), // Add order details based on your structure
            // Add foreign key relationships as needed
            'payment_method' => $this->faker->randomElement(['Pay on delivery', 'Card', 'Transfer']),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}

