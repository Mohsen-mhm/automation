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
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['national_id']);
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->dropUnique(['national_id']);
            $table->dropUnique(['registration_number']);
            $table->dropUnique(['website']);
            $table->dropUnique(['email']);
        });
        Schema::table('greenhouses', function (Blueprint $table) {
            $table->dropUnique(['licence_number']);
            $table->dropUnique(['location_link']);
        });
        Schema::table('organization_users', function (Blueprint $table) {
            $table->dropUnique(['national_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organization_users', function (Blueprint $table) {
            $table->dropUnique(['national_id']);
        });
        Schema::table('greenhouses', function (Blueprint $table) {
            $table->unique(['location_link']);
            $table->unique(['licence_number']);
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->unique(['email']);
            $table->unique(['website']);
            $table->unique(['registration_number']);
            $table->unique(['national_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->unique(['national_id']);
        });
    }
};
