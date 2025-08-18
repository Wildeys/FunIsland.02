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
        Schema::table('ferry_ticketing', function (Blueprint $table) {
            // Add new columns
            $table->string('ticket_reference')->unique()->after('status');
            $table->text('notes')->nullable()->after('ticket_reference');
            
            // Modify existing columns if needed
            $table->string('status')->default('pending')->change(); // Set default value
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ferry_ticketing', function (Blueprint $table) {
            $table->dropColumn(['ticket_reference', 'notes']);
            $table->string('status')->change(); // Remove default value
        });
    }
}; 