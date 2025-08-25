<?php

namespace Database\Seeders;

use App\Models\FoodCategory;
use Illuminate\Database\Seeder;

class FoodCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Makanan'],
            ['name' => 'Minuman'],
            ['name' => 'Buah'],
            ['name' => 'Camilan'],
        ];

        foreach ($categories as $category) {
            FoodCategory::create($category);
        }
    }
}
