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
        Schema::table('greenhouses', function (Blueprint $table) {
            // Add province and city foreign keys
            $table->foreignId('province_id')->nullable()->constrained('provinces')->onDelete('set null');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');

            $table->dropColumn('province');
            $table->dropColumn('city');

            $table->index(['province_id', 'city_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('greenhouses', function (Blueprint $table) {
            $table->string('province');
            $table->string('city');

            $table->dropForeign(['province_id']);
            $table->dropForeign(['city_id']);
            $table->dropIndex(['province_id', 'city_id']);
            $table->dropColumn(['province_id', 'city_id']);
        });
    }
};
