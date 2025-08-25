<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('diary_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack', 'exercise']);
            $table->foreignId('food_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('recipe_id')->nullable()->constrained()->onDelete('cascade');
            $table->decimal('quantity', 6, 2)->nullable(); // nullable untuk exercise
            $table->decimal('calories', 8, 2)->nullable(); // nullable
            $table->decimal('protein', 6, 2)->nullable(); // nullable
            $table->decimal('carbs', 6, 2)->nullable(); // nullable
            $table->decimal('fat', 6, 2)->nullable(); // nullable
            $table->decimal('fiber', 6, 2)->nullable(); // nullable
            $table->string('exercise_type')->nullable();
            $table->decimal('calories_burned', 8, 2)->nullable();
            $table->integer('exercise_duration')->nullable(); // minutes
            $table->foreignId('device_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('diary_entries');
    }
};
