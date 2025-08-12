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

        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->string('name');
            $table->string('description'); 
            $table->decimal('price_per_night', 10, 2)->nullable();
            $table->json('amenities')->nullable();
            $table->json('contact_info')->nullable();
            $table->string('image_url')->nullable();
            $table->enum('status', ['active', 'inactive', 'maintenance'])->default('active');
            $table->boolean('featured')->default(false);
            $table->decimal('rating', 3, 1)->default(0.0);
            $table->timestamps();
        });

        Schema::create('hotel_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels');
            $table->string('image');
            $table->timestamps();
        });


        Schema::create('hotel_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->string('room_number');
            $table->enum('room_type', ['standard', 'deluxe', 'suite', 'presidential'])->default('standard');
            $table->string('description');
            $table->decimal('price_per_night', 10, 2)->nullable();
            $table->integer('capacity');
            $table->json('amenities')->nullable();
            $table->enum('status', ['available', 'occupied', 'maintenance', 'out_of_order'])->default('available');
            $table->text('maintenance_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('hotel_room_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_room_id')->constrained('hotel_rooms');
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('hotel_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels');
            $table->foreignId('hotel_room_id')->constrained('hotel_rooms');
            $table->foreignId('user_id')->constrained('users');
            $table->date('check_in_date');
            $table->date('check_out_date');
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
        Schema::dropIfExists('hotel_bookings');
        Schema::dropIfExists('hotel_room_images');
        Schema::dropIfExists('hotel_images');
        Schema::dropIfExists('hotel_room');
        Schema::dropIfExists('hotels');
    }
};
