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
        Schema::create('commandes', function (Blueprint $table) {
            $table->unsignedInteger('numero')->primary();
            $table->dateTime('date_creation');
            $table->dateTime('date_validation')->nullable();
            $table->enum('statut', ['en_attente', 'validee', 'annulee', 'facturee'])->default('en_attente');
            $table->timestamps();
        });

        Schema::create('reductions', function (Blueprint $table) {
            $table->id();
            $table->string('taux', 50);
            $table->timestamps();
        });

        Schema::create('reductions_personnel', function (Blueprint $table) {
            $table->foreignId('reduction_id')->primary()->constrained('reductions')->cascadeOnDelete();
            $table->dateTime('date_application');
            $table->timestamps();
        });

        Schema::create('reductions_globale', function (Blueprint $table) {
            $table->foreignId('reduction_id')->primary()->constrained('reductions')->cascadeOnDelete();
            $table->dateTime('date_debut');
            $table->dateTime('date_fin')->nullable();
            $table->string('code', 10)->nullable()->unique();
            $table->timestamps();
        });

        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_facturation');
            $table->enum('statut', ['brouillon', 'emise', 'payee', 'annulee'])->default('brouillon');
            $table->decimal('fdp', 15, 2)->default(0);
            $table->unsignedInteger('commande_numero')->unique();
            $table->foreignId('reduction_id')->nullable()->constrained('reductions')->nullOnDelete();
            $table->timestamps();

            $table->foreign('commande_numero')->references('numero')->on('commandes')->cascadeOnDelete();
        });

        Schema::create('lignes', function (Blueprint $table) {
            $table->id();
            $table->decimal('prix_unitaire', 15, 2);
            $table->unsignedInteger('qte');
            $table->string('produit_ref', 6);
            $table->unsignedInteger('commande_numero');
            $table->foreignId('reduction_id')->nullable()->constrained('reductions')->nullOnDelete();
            $table->timestamps();

            $table->foreign('produit_ref')->references('ref')->on('produits')->cascadeOnDelete();
            $table->foreign('commande_numero')->references('numero')->on('commandes')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lignes');
        Schema::dropIfExists('factures');
        Schema::dropIfExists('reductions_globale');
        Schema::dropIfExists('reductions_personnel');
        Schema::dropIfExists('reductions');
        Schema::dropIfExists('commandes');
    }
};
