<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('greenhouses', function (Blueprint $table) {
            $table->string('postal')->nullable()->change();
            $table->string('operation_licence')->nullable()->change();
            $table->string('image')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('greenhouses', function (Blueprint $table) {
            $table->string('image')->nullable(false)->change();
            $table->string('operation_licence')->nullable(false)->change();
            $table->string('postal')->nullable(false)->change();
        });
    }
};
