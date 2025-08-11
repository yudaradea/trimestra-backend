<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_food_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('diet_type', ['vegetarian', 'keto', 'vegan', 'paleo', 'gluten-free', 'no_preference']);
            $table->json('allergies');
            $table->json('preferred_meal_times'); // breakfast, lunch, dinner, snack
            $table->enum('calorie_target', ['<1500', '1500-2000', '>2000', 'not_sure']);
            $table->enum('cooking_time_preference', ['<15', '15-30', '>30']);
            $table->enum('serving_preference', ['3', '4', '5', '>5']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_food_preferences');
    }
};
