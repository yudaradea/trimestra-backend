<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->string('type'); // reminder, info, alert
            $table->boolean('is_read')->default(false);
            $table->json('data')->nullable(); // additional data
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('app_notifications');
    }
};
