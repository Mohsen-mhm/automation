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
        Schema::create('chart_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('chart_key')->unique(); // e.g., 'users_count', 'company_per_province'
            $table->string('chart_name'); // Display name
            $table->string('chart_category')->default('general'); // Category for grouping
            $table->boolean('admin_visible')->default(true);
            $table->boolean('company_visible')->default(false);
            $table->boolean('greenhouse_visible')->default(false);
            $table->boolean('organization_visible')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chart_permissions');
    }
};
