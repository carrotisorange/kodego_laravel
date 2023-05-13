<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Category;

class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'content' => $this->faker->sentence(100),
            'user_id' => User::all()->random()->id,
            'category_id' => Category::all()->random()->id,
            'thumbnail' => 'thumbnail.jpg'
        ];
    }
}
