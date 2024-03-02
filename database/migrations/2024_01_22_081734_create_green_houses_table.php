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
        Schema::create('greenhouses', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->string('substrate_type');
            $table->string('product_type');

            $table->string('licence_number')->unique();
            $table->string('meterage');

            $table->timestamp('operation_date')->nullable();
            $table->timestamp('construction_date')->nullable();

            $table->string('greenhouse_status');

            $table->string('owner_name');
            $table->string('owner_phone');
            $table->string('owner_national_id');

            $table->boolean('climate_system');
            $table->boolean('feeding_system');

            $table->string('province');
            $table->string('city');
            $table->string('address');
            $table->string('postal');

            $table->string('location_link')->unique();
            $table->string('coordinates');
            $table->string('latitude');
            $table->string('longitude');

            $table->string('operation_licence');
            $table->string('image');

            $table->boolean('active')->default(0);
            $table->enum('status', ['pending', 'edited', 'confirmed', 'rejected', 'deactivate'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('greenhouses');
    }
};
