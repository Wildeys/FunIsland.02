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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('booking_type', ['hotel', 'ferry', 'event']);
            
            // Hotel booking fields
            $table->foreignId('hotel_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('hotel_room_id')->nullable()->constrained('hotel_rooms')->onDelete('cascade');
            
            // Ferry booking fields  
            $table->foreignId('ferry_id')->nullable()->constrained()->onDelete('cascade');
            
            // Event booking fields (reference existing event_bookings)
            $table->foreignId('event_id')->nullable()->constrained()->onDelete('cascade');
            
            $table->date('check_in_date')->nullable();
            $table->date('check_out_date')->nullable();
            $table->integer('guests')->default(1);
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'refunded'])->default('pending');
            $table->text('special_requests')->nullable();
            $table->timestamp('booked_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
