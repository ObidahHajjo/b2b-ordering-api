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
            $table->renameColumn('name', 'first_name');
            $table->string('first_name', 100)->change();
            $table->string('last_name', 100);
            $table->string('phone', 16)->nullable();
            $table->foreignId('role_id')->nullable()->constrained('roles');
            $table->foreignId('store_id')->nullable()->constrained('stores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
