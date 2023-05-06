<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Blog;

class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'is_liked' => rand(0,1),
            'user_id' => User::all()->random()->id,
            'blog_id' => Blog::all()->random()->id,
        ];
    }
}
