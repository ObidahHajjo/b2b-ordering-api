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
        Schema::create('effectue', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('commande_numero');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->foreign('commande_numero')->references('numero')->on('commandes')->cascadeOnDelete();
            $table->unique(['commande_numero', 'user_id']);
        });

        Schema::create('inclut', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('commande_numero');
            $table->foreignId('pavs_id')->constrained('pavs')->cascadeOnDelete();
            $table->timestamps();

            $table->foreign('commande_numero')->references('numero')->on('commandes')->cascadeOnDelete();
            $table->unique(['commande_numero', 'pavs_id']);
        });

        Schema::create('compose', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pavs_id')->constrained('pavs')->cascadeOnDelete();
            $table->foreignId('ligne_id')->constrained('lignes')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['pavs_id', 'ligne_id']);
        });

        Schema::create('concerne', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facture_id')->constrained('factures')->cascadeOnDelete();
            $table->foreignId('ligne_id')->constrained('lignes')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['facture_id', 'ligne_id']);
        });

        Schema::create('applique', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reduction_id')->constrained('reductions')->cascadeOnDelete();
            $table->foreignId('ligne_id')->nullable()->constrained('lignes')->cascadeOnDelete();
            $table->foreignId('pavs_id')->nullable()->constrained('pavs')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applique');
        Schema::dropIfExists('concerne');
        Schema::dropIfExists('compose');
        Schema::dropIfExists('inclut');
        Schema::dropIfExists('effectue');
    }
};
