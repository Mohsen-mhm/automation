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
        Schema::create('automations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('greenhouse_id');
            $table->foreign('greenhouse_id')->references('id')->on('greenhouses')->onDelete('CASCADE');

            $table->unsignedBigInteger('climate_company_id')->nullable();
            $table->foreign('climate_company_id')->references('id')->on('companies')->onDelete('CASCADE');
            $table->timestamp('climate_date')->nullable();

            $table->string('climate_api_link')->unique()->nullable();
            $table->timestamp('climate_linked_date')->nullable();

            $table->unsignedBigInteger('feeding_company_id')->nullable();
            $table->foreign('feeding_company_id')->references('id')->on('companies')->onDelete('CASCADE');
            $table->timestamp('feeding_date')->nullable();

            $table->string('feeding_api_link')->unique()->nullable();
            $table->timestamp('feeding_linked_date')->nullable();

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
        Schema::dropIfExists('automations');
    }
};
