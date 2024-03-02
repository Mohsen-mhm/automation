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
        Schema::create('greenhouse_alerts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('greenhouse_id');
            $table->foreign('greenhouse_id')->references('id')->on('greenhouses')->onDelete('CASCADE');

            $table->boolean('lux_active')->default(0);
            $table->integer('min_lux')->nullable();
            $table->integer('max_lux')->nullable();

            $table->boolean('temp_active')->default(0);
            $table->integer('min_temp')->nullable();
            $table->integer('max_temp')->nullable();

            $table->boolean('wind_active')->default(0);
            $table->integer('min_wind')->nullable();
            $table->integer('max_wind')->nullable();

            $table->boolean('humidity_active')->default(0);
            $table->integer('min_humidity')->nullable();
            $table->integer('max_humidity')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('greenhouse_alerts');
    }
};
