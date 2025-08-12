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
        Schema::create('themeparks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained('locations');
            $table->string('name');
            $table->text('description');
            $table->decimal('rating', 3, 2)->default(0);
            $table->enum('status', ['active', 'inactive', 'maintenance'])->default('active');
            $table->boolean('featured')->default(false);
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        Schema::create('themepark_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('themepark_id')->constrained('themeparks');
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('themepark_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('themepark_id')->constrained('themeparks');
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
            $table->foreignId('themepark_activities_id')->constrained('themepark_activities')->name('tp_activities_avail_activities_id_fk');
            $table->date('date');
            $table->integer('count');
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });

        Schema::create('themepark_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_booking_id')->constrained('hotel_bookings');
            $table->foreignId('themepark_activities_id')->constrained('themepark_activities')->name('tp_bookings_activities_id_fk');
            $table->foreignId('themepark_activities_availability_id')->constrained('themepark_activities_availability')->name('tp_bookings_avail_id_fk');
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
        Schema::dropIfExists('themeparks');
        Schema::dropIfExists('themepark_bookings');
        Schema::dropIfExists('themepark_activities');
        Schema::dropIfExists('themepark_activities_availability');
        Schema::dropIfExists('themepark_activities_images');
        Schema::dropIfExists('themepark_images');
    }
};
