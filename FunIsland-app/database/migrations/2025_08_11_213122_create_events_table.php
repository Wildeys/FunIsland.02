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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('type')->default('beach_event'); // beach_event, activity, entertainment
            $table->string('location');
            $table->decimal('price', 10, 2);
            $table->integer('capacity');
            $table->integer('available_spots');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('duration'); // e.g., "2 hours", "Full day"
            $table->text('requirements')->nullable(); // Age restrictions, equipment needed, etc.
            $table->json('features')->nullable(); // JSON array of features/amenities
            $table->string('difficulty_level')->nullable(); // Easy, Moderate, Challenging
            $table->string('status')->default('active'); // active, inactive, cancelled
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
