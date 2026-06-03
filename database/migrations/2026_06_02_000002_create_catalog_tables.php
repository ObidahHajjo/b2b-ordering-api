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
        Schema::create('etages', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100);
            $table->timestamps();
        });

        Schema::create('produits', function (Blueprint $table) {
            $table->string('ref', 6)->primary();
            $table->string('nom', 50);
            $table->decimal('prix', 15, 2);
            $table->decimal('poids', 15, 2);
            $table->text('liste_ingredient')->nullable();
            $table->boolean('est_disponible')->default(true);
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('libelle', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('produits');
        Schema::dropIfExists('etages');
    }
};
