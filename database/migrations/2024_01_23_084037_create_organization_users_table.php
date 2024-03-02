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
        Schema::create('organization_users', function (Blueprint $table) {
            $table->id();

            $table->string('fname');
            $table->string('lname');

            $table->string('national_id')->unique();
            $table->string('organization_name');
            $table->string('organization_level');

            $table->string('national_card');
            $table->string('personnel_card');
            $table->string('introduction_letter');

            $table->string('province');
            $table->string('city');
            $table->string('address');
            $table->string('postal');

            $table->string('landline_number')->nullable();
            $table->string('phone_number');

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
        Schema::dropIfExists('organization_users');
    }
};
