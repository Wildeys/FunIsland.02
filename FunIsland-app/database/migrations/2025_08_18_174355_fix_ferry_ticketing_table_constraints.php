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
        // Drop and recreate the ferry_ticketing table with correct constraints
        Schema::dropIfExists('ferry_ticketing');
        
        Schema::create('ferry_ticketing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_booking_id')->nullable()->constrained('bookings')->onDelete('set null');
            $table->foreignId('ferry_schedule_id')->constrained('ferry_schedule')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('date');
            $table->integer('number_of_guests');
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending');
            $table->string('ticket_reference')->unique();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ferry_ticketing');
        
        // Recreate the original table structure
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
};
