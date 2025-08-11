<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('birth_date');
            $table->decimal('height', 5, 2); // cm
            $table->decimal('weight', 5, 2); // kg
            $table->boolean('is_pregnant');
            $table->tinyInteger('pregnancy_weeks')->nullable();
            $table->boolean('is_first_pregnancy')->nullable();
            $table->enum('diet_preference', ['normal', 'vegetarian']);
            $table->json('health_goals'); // array goals
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
};
