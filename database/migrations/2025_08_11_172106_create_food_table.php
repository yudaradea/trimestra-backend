<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('food_categories')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->decimal('calories', 8, 2);
            $table->decimal('protein', 6, 2);
            $table->decimal('carbs', 6, 2);
            $table->decimal('fat', 6, 2);
            $table->decimal('fiber', 6, 2);
            $table->string('serving_size', 50);
            $table->integer('cooking_time')->nullable();
            $table->boolean('is_pregnancy_safe')->default(true);
            $table->json('allergens')->nullable();
            $table->json('diet_types')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food');
    }
};
