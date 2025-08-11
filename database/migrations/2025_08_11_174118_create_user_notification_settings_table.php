<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_notification_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('enabled')->default(true);
            $table->boolean('sound_enabled')->default(true);
            $table->boolean('vibration_enabled')->default(true);
            $table->boolean('silent_mode')->default(false);
            $table->boolean('lock_screen')->default(true);
            $table->boolean('reminders_enabled')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_notification_settings');
    }
};
