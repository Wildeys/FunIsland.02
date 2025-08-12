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
        Schema::table('hotels', function (Blueprint $table) {
            $table->decimal('price_per_night', 10, 2)->default(100.00)->after('description');
            $table->json('amenities')->nullable()->after('price_per_night');
            $table->json('contact_info')->nullable()->after('amenities');
            $table->string('image_url')->nullable()->after('contact_info');
            $table->string('status')->default('active')->after('image_url');
            $table->boolean('featured')->default(false)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn(['price_per_night', 'amenities', 'contact_info', 'image_url', 'status', 'featured']);
        });
    }
};
