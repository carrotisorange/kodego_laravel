<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'category' => 'Sports',
            'description' => 'This is a sports blog',
        ]);

        Category::create([
            'category' => 'Health',
            'description' => 'This is a health blog',
        ]);

        Category::create([
            'category' => 'Politics',
            'description' => 'This is a politics blog',
        ]);

        Category::create([
            'category' => 'Entertainment',
            'description' => 'This is a entertainment blog',
        ]);
    }
}
