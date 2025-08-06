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
        Schema::create('themepark_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_booking_id')->constrained('hotel_bookings');
            $table->foreignId('themepark_activities_id')->constrained('themepark_activities');
            $table->foreignId('themepark_activities_availability_id')->constrained('themepark_activities_availability');
            $table->foreignId('user_id')->constrained('users');
            $table->date('date');
            $table->integer('number_of_guests');
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
        
        Schema::create('themepark', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained('locations');
            $table->string('name');
            $table->string('description');
            $table->string('rating')->default(0);
            $table->timestamps();
        });

        Schema::create('themepark_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('themepark_id')->constrained('themepark');
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('themepark_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('themepark_id')->constrained('themepark');
            $table->string('name');
            $table->string('description');
            $table->decimal('price', 10, 2);
            $table->integer('capacity');
            $table->timestamps();
        });

        Schema::create('themepark_activities_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('themepark_activities_id')->constrained('themepark_activities');
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('themepark_activities_availability', function (Blueprint $table) {
            $table->id();
            $table->foreignId('themepark_activities_id')->constrained('themepark_activities');
            $table->date('date');
            $table->integer('count');
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themeparks');
        Schema::dropIfExists('themepark_bookings');
        Schema::dropIfExists('themepark_activities');
        Schema::dropIfExists('themepark_activities_availability');
        Schema::dropIfExists('themepark_activities_images');
        Schema::dropIfExists('themepark_images');
    }
};
