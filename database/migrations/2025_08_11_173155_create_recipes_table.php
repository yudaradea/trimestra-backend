<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('ingredients'); // JSON format
            $table->text('instructions'); // JSON format or TEXT
            $table->integer('prep_time'); // minutes
            $table->integer('cook_time'); // minutes
            $table->tinyInteger('servings'); // number of servings
            $table->enum('difficulty', ['easy', 'medium', 'hard']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipes');
    }
};
