<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('daily_nutrition_summary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->decimal('total_calories_intake', 8, 2);
            $table->decimal('total_calories_burned', 8, 2);
            $table->decimal('total_protein', 6, 2);
            $table->decimal('total_carbs', 6, 2);
            $table->decimal('total_fat', 6, 2);
            $table->decimal('total_fiber', 6, 2);
            $table->decimal('target_calories', 8, 2);
            $table->timestamps();

            $table->unique(['user_id', 'date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('daily_nutrition_summary');
    }
};
