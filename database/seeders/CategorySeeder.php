<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories data from the file
        $categories = require database_path('seeders/data/categories.php');

         foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
