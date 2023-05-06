<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Blog;
use App\Models\Like;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        // Category::factory(10)->create();
        Blog::factory(10)->create();
        Like::factory(10)->create();
        Comment::factory(10)->create();
    }
}
