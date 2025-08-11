<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('food_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('recipe_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('type', ['food', 'recipe', 'fruit', 'drink']);
            $table->timestamps();

            $table->unique(['user_id', 'food_id', 'recipe_id', 'type'], 'unique_user_favorite');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_favorites');
    }
};
