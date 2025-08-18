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
        Schema::table('ferry_schedule', function (Blueprint $table) {
            // Add foreign key constraints to existing columns
            $table->foreign('departure_location_id')->references('id')->on('locations');
            $table->foreign('arrival_location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ferry_schedule', function (Blueprint $table) {
            $table->dropForeign(['departure_location_id']);
            $table->dropForeign(['arrival_location_id']);
        });
    }
};
