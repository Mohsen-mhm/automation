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
        Schema::table('companies', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
        Schema::table('greenhouses', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
        Schema::table('organization_users', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organization_users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
        Schema::table('greenhouses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
