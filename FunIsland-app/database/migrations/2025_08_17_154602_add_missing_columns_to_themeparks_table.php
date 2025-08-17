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
        Schema::table('themeparks', function (Blueprint $table) {
            $table->decimal('admission_price', 8, 2)->default(0)->after('description');
            $table->integer('capacity')->default(1000)->after('admission_price');
            $table->time('opening_time')->nullable()->after('capacity');
            $table->time('closing_time')->nullable()->after('opening_time');
            $table->text('features')->nullable()->after('image_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('themeparks', function (Blueprint $table) {
            $table->dropColumn(['admission_price', 'capacity', 'opening_time', 'closing_time', 'features']);
        });
    }
};
