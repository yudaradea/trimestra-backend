<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\Food;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run()
    {
        $foods = Food::all();

        $recipes = [
            [
                'food_id' => $foods->firstWhere('name', 'Nasi Goreng')->id,
                'title' => 'Nasi Goreng Ibu Hamil Sehat',
                'ingredients' => json_encode([
                    '2 piring nasi putih',
                    '2 butir telur',
                    '100g ayam fillet',
                    '2 siung bawang putih',
                    '3 siung bawang merah',
                    '2 sdm kecap manis',
                    '1 sdm saus tiram',
                    'Sayuran (wortel, kacang panjang)'
                ]),
                'instructions' => json_encode([
                    'Potong kecil ayam dan tumis hingga matang',
                    'Orak-arik telur di wajan terpisah',
                    'Tumis bawang hingga harum',
                    'Masukkan nasi, aduk rata',
                    'Tambahkan kecap, saus tiram, dan bumbu',
                    'Masukkan sayuran dan telur',
                    'Aduk hingga rata dan matang'
                ]),
                'prep_time' => 10,
                'cook_time' => 15,
                'servings' => 2,
                'difficulty' => 'easy',
                'is_active' => true,
            ],
            [
                'food_id' => $foods->firstWhere('name', 'Salad Buah')->id,
                'title' => 'Salad Buah Segar untuk Ibu Hamil',
                'ingredients' => json_encode([
                    '1 buah apel merah',
                    '1 buah pir',
                    '100g anggur',
                    '1 buah jeruk',
                    '2 sdm madu',
                    '1 sdm yoghurt tawar',
                    'Sedikit perasan lemon'
                ]),
                'instructions' => json_encode([
                    'Cuci bersih semua buah',
                    'Potong buah dalam ukuran bite-size',
                    'Campur madu, yoghurt, dan lemon',
                    'Siram dressing di atas buah',
                    'Aduk perlahan dan sajikan dingin'
                ]),
                'prep_time' => 15,
                'cook_time' => 0,
                'servings' => 2,
                'difficulty' => 'easy',
                'is_active' => true,
            ],
            [
                'food_id' => $foods->firstWhere('name', 'Smoothie Bayam')->id,
                'title' => 'Smoothie Bayam untuk Energi Ibu Hamil',
                'ingredients' => json_encode([
                    '1 genggam bayam segar',
                    '1 buah pisang',
                    '200ml susu UHT',
                    '1 sdm madu',
                    '1/2 sdt vanila bubuk',
                    'Es batu secukupnya'
                ]),
                'instructions' => json_encode([
                    'Blender bayam dengan sedikit susu hingga halus',
                    'Tambahkan pisang, madu, dan vanila',
                    'Tuang sisa susu dan blender kembali',
                    'Tambahkan es batu dan blender sebentar',
                    'Saring jika diperlukan dan sajikan'
                ]),
                'prep_time' => 5,
                'cook_time' => 5,
                'servings' => 1,
                'difficulty' => 'easy',
                'is_active' => true,
            ],
        ];

        foreach ($recipes as $recipe) {
            Recipe::create($recipe);
        }
    }
}
