<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Blog;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
       return [
            'comments' => $this->faker->sentence(3),
            'user_id' => User::all()->random()->id,
            'blog_id' => Blog::all()->random()->id,
        ];
    }
}
