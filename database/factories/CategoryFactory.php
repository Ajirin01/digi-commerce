<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'parent_id'=> random_int(1, 20),
            'photo' => $this->faker->imageUrl()
            // Add any additional fields or customization specific to Category model
        ];
    }
}

