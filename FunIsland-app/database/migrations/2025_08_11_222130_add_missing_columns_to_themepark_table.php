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
        Schema::table('themepark', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive', 'maintenance'])->default('active')->after('rating');
            $table->boolean('featured')->default(false)->after('status');
            $table->string('image_url')->nullable()->after('featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('themepark', function (Blueprint $table) {
            $table->dropColumn(['status', 'featured', 'image_url']);
        });
    }
};
