<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\FoodCategory;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    public function run()
    {
        $categories = FoodCategory::pluck('id', 'name');

        $foods = [
            // Makanan
            [
                'name' => 'Nasi Goreng',
                'category_id' => $categories['Makanan'],
                'description' => 'Nasi goreng dengan telur dan sayuran',
                'calories' => 650,
                'protein' => 15.5,
                'carbs' => 85.2,
                'fat' => 22.3,
                'fiber' => 3.2,
                'serving_size' => '1 porsi',
                'cooking_time' => 15,
                'is_pregnancy_safe' => true,
                'is_active' => true,
                'allergens' => ['telur'],
                'diet_types' => ['normal'], // Tambahkan diet types
            ],
            [
                'name' => 'Smoothie Bayam',
                'category_id' => $categories['Minuman'],
                'description' => 'Smoothie bayam dengan susu dan madu',
                'calories' => 180,
                'protein' => 8.2,
                'carbs' => 25.3,
                'fat' => 6.1,
                'fiber' => 3.8,
                'serving_size' => '1 gelas',
                'cooking_time' => 5,
                'is_pregnancy_safe' => true,
                'is_active' => true,
                'allergens' => ['susu'],
                'diet_types' => ['normal', 'vegetarian'], // Multiple diet types
            ],
            [
                'name' => 'Salad Buah',
                'category_id' => $categories['Makanan'],
                'description' => 'Campuran buah-buahan segar',
                'calories' => 120,
                'protein' => 2.1,
                'carbs' => 30.5,
                'fat' => 0.8,
                'fiber' => 4.2,
                'serving_size' => '1 mangkuk',
                'cooking_time' => 10,
                'is_pregnancy_safe' => true,
                'is_active' => true,
                'allergens' => [],
                'diet_types' => ['normal', 'vegetarian', 'vegan'], // Vegan friendly
            ],
            [
                'name' => 'Kacang Almond',
                'category_id' => $categories['Camilan'],
                'description' => 'Kacang almond panggang',
                'calories' => 165,
                'protein' => 6.0,
                'carbs' => 6.0,
                'fat' => 14.0,
                'fiber' => 3.5,
                'serving_size' => '30 gram',
                'cooking_time' => 0,
                'is_pregnancy_safe' => true,
                'is_active' => true,
                'allergens' => ['kacang-kacangan'],
                'diet_types' => ['normal', 'vegetarian', 'vegan', 'keto'],
            ],
            [
                'name' => 'Roti Bakar',
                'category_id' => $categories['Makanan'],
                'description' => 'Roti bakar dengan selai kacang',
                'calories' => 300,
                'protein' => 10.0,
                'carbs' => 40.0,
                'fat' => 12.0,
                'fiber' => 4.0,
                'serving_size' => '2 potong',
                'cooking_time' => 5,
                'is_pregnancy_safe' => true,
                'is_active' => true,
                'allergens' => ['gluten', 'kacang-kacangan'],
                'diet_types' => ['normal'], // Tambahkan diet types
            ],

            [
                'name' => 'Sup Ayam',
                'category_id' => $categories['Makanan'],
                'description' => 'Sup ayam dengan sayuran segar',
                'calories' => 250,
                'protein' => 20.0,
                'carbs' => 15.0,
                'fat' => 10.0,
                'fiber' => 2.0,
                'serving_size' => '1 mangkuk',
                'cooking_time' => 25,
                'is_pregnancy_safe' => true,
                'is_active' => true,
                'allergens' => ['ayam'],
                'diet_types' => ['normal', 'vegetarian'], // Tambahkan alergen
            ]

        ];

        foreach ($foods as $food) {
            Food::create($food);
        }
    }
}
