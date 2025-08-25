<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Foods table indexes
        Schema::table('food', function (Blueprint $table) {
            $table->index(['is_active']);
            $table->index(['is_pregnancy_safe']);
            $table->index(['category_id']);
            $table->index(['calories']);
            $table->index(['cooking_time']);
        });

        // Diary entries table indexes
        Schema::table('diary_entries', function (Blueprint $table) {
            $table->index(['user_id']);
            $table->index(['date']);
            $table->index(['meal_type']);
            $table->index(['food_id']);
            $table->index(['recipe_id']);
            $table->index(['device_id']);
            $table->index(['user_id', 'date']);
            $table->index(['user_id', 'meal_type']);
        });

        // Daily nutrition summary indexes
        Schema::table('daily_nutrition_summary', function (Blueprint $table) {
            $table->index(['user_id']);
            $table->index(['date']);
            $table->index(['user_id', 'date']);
        });

        // User favorites indexes
        Schema::table('user_favorites', function (Blueprint $table) {
            $table->index(['user_id']);
            $table->index(['food_id']);
            $table->index(['recipe_id']);
            $table->index(['user_id', 'type']);
        });

        // Exercise records indexes
        Schema::table('exercise_records', function (Blueprint $table) {
            $table->index(['user_id']);
            $table->index(['device_id']);
            $table->index(['start_time']);
            $table->index(['user_id', 'start_time']);
        });

        // Devices indexes
        Schema::table('devices', function (Blueprint $table) {
            $table->index(['device_uuid']);
            $table->index(['is_connected']);
        });
    }

    public function down()
    {
        // Drop indexes
        Schema::table('food', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['is_pregnancy_safe']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['calories']);
            $table->dropIndex(['cooking_time']);
        });

        Schema::table('diary_entries', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['date']);
            $table->dropIndex(['meal_type']);
            $table->dropIndex(['food_id']);
            $table->dropIndex(['recipe_id']);
            $table->dropIndex(['device_id']);
            $table->dropIndex(['user_id', 'date']);
            $table->dropIndex(['user_id', 'meal_type']);
        });

        Schema::table('daily_nutrition_summary', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['date']);
            $table->dropIndex(['user_id', 'date']);
        });

        Schema::table('user_favorites', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['food_id']);
            $table->dropIndex(['recipe_id']);
            $table->dropIndex(['user_id', 'type']);
        });

        Schema::table('exercise_records', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['device_id']);
            $table->dropIndex(['start_time']);
            $table->dropIndex(['user_id', 'start_time']);
        });

        Schema::table('devices', function (Blueprint $table) {
            $table->dropIndex(['device_uuid']);
            $table->dropIndex(['is_connected']);
        });
    }
};
