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
        Schema::create('ferries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained('locations');
            $table->string('name');
            $table->integer('capacity');
            $table->timestamps();
        });

        Schema::create('ferry_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ferry_id')->constrained('ferries');
            $table->date('date');
            $table->time('departure_time');
            $table->string('departure_location');
            $table->string('arrival_location');
            $table->decimal('price', 10, 2);
            $table->integer('remaining_seats');
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
        
        Schema::create('ferry_ticketing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_booking_id')->constrained('hotel_bookings');
            $table->foreignId('ferry_schedule_id')->constrained('ferry_schedule');
            $table->foreignId('user_id')->constrained('users');
            $table->date('date');
            $table->integer('number_of_guests');
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ferry_ticketing');
        Schema::dropIfExists('ferry_schedule');
        Schema::dropIfExists('ferries');
    }
};
