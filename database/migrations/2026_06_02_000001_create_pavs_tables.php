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
        Schema::create('pavs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('nb_etage');
            $table->timestamps();
        });

        Schema::create('pavs_standard', function (Blueprint $table) {
            $table->foreignId('pavs_id')->primary()->constrained('pavs')->cascadeOnDelete();
            $table->string('nom', 100);
            $table->timestamps();
        });

        Schema::create('pavs_custom', function (Blueprint $table) {
            $table->foreignId('pavs_id')->primary()->constrained('pavs')->cascadeOnDelete();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pavs_custom');
        Schema::dropIfExists('pavs_standard');
        Schema::dropIfExists('pavs');
    }
};
