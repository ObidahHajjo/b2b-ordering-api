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
        Schema::create('contient', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pavs_id')->constrained('pavs')->cascadeOnDelete();
            $table->foreignId('etage_id')->constrained('etages')->cascadeOnDelete();
            $table->unsignedInteger('qte');
            $table->timestamps();

            $table->unique(['pavs_id', 'etage_id']);
        });

        Schema::create('localise', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etage_id')->constrained('etages')->cascadeOnDelete();
            $table->string('produit_ref', 6);
            $table->timestamps();

            $table->foreign('produit_ref')->references('ref')->on('produits')->cascadeOnDelete();
            $table->unique(['etage_id', 'produit_ref']);
        });

        Schema::create('classifie', function (Blueprint $table) {
            $table->id();
            $table->string('produit_ref', 6);
            $table->foreignId('categorie_id')->constrained('categories')->cascadeOnDelete();
            $table->timestamps();

            $table->foreign('produit_ref')->references('ref')->on('produits')->cascadeOnDelete();
            $table->unique(['produit_ref', 'categorie_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classifie');
        Schema::dropIfExists('localise');
        Schema::dropIfExists('contient');
    }
};
