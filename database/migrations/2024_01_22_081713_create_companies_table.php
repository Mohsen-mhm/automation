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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('type');
            $table->string('national_id')->unique();

            $table->string('registration_number')->unique();
            $table->string('registration_place');
            $table->timestamp('registration_date');

            $table->boolean('climate_system')->default(0);
            $table->boolean('feeding_system')->default(0);

            $table->string('ceo_name');
            $table->string('ceo_phone');
            $table->string('ceo_national_id');
            $table->string('interface_name');
            $table->string('interface_phone');

            $table->string('company_logo');
            $table->string('brand');
            $table->string('brand_logo');
            $table->string('trademark_certificate');

            $table->string('province');
            $table->string('city');
            $table->string('address');
            $table->string('postal');

            $table->string('landline_number');
            $table->string('phone_number')->nullable();

            $table->string('location_link');
            $table->string('coordinates');
            $table->string('latitude');
            $table->string('longitude');

            $table->string('website')->unique();
            $table->string('email')->unique();

            $table->string('official_newspaper');
            $table->string('operation_licence');

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
        Schema::dropIfExists('companies');
    }
};
