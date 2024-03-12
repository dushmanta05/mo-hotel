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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id()->onDelete('cascade');
            $table->timestamps();
            $table->date('check_in');
            $table->date('check_out');
            $table->boolean('status');
            $table->unsignedBigInteger('hotel_id');
            $table->foreign('hotel_id')->references('id')->on("hotels");
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on("users");
            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
