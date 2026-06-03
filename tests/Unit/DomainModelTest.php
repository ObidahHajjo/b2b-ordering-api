<?php

namespace Tests\Unit;

use App\Models\Applique;
use App\Models\Address;
use App\Models\Categorie;
use App\Models\Classifie;
use App\Models\Commande;
use App\Models\Compose;
use App\Models\Concerne;
use App\Models\Contient;
use App\Models\Effectue;
use App\Models\Etage;
use App\Models\Facture;
use App\Models\Inclut;
use App\Models\Ligne;
use App\Models\Localise;
use App\Models\Pav;
use App\Models\PavCustom;
use App\Models\PavStandard;
use App\Models\Produit;
use App\Models\Reduction;
use App\Models\ReductionGlobale;
use App\Models\ReductionPersonnel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tests\TestCase;

class DomainModelTest extends TestCase
{
    /**
     * Test models use expected table names.
     */
    public function test_models_use_expected_table_names(): void
    {
        $this->assertSame('pavs', (new Pav)->getTable());
        $this->assertSame('pavs_standard', (new PavStandard)->getTable());
        $this->assertSame('pavs_custom', (new PavCustom)->getTable());
        $this->assertSame('etages', (new Etage)->getTable());
        $this->assertSame('produits', (new Produit)->getTable());
        $this->assertSame('categories', (new Categorie)->getTable());
        $this->assertSame('commandes', (new Commande)->getTable());
        $this->assertSame('reductions', (new Reduction)->getTable());
        $this->assertSame('reductions_personnel', (new ReductionPersonnel)->getTable());
        $this->assertSame('reductions_globale', (new ReductionGlobale)->getTable());
        $this->assertSame('factures', (new Facture)->getTable());
        $this->assertSame('lignes', (new Ligne)->getTable());
        $this->assertSame('contient', (new Contient)->getTable());
        $this->assertSame('localise', (new Localise)->getTable());
        $this->assertSame('classifie', (new Classifie)->getTable());
        $this->assertSame('effectue', (new Effectue)->getTable());
        $this->assertSame('inclut', (new Inclut)->getTable());
        $this->assertSame('compose', (new Compose)->getTable());
        $this->assertSame('concerne', (new Concerne)->getTable());
        $this->assertSame('applique', (new Applique)->getTable());
    }

    /**
     * Test models use expected primary keys.
     */
    public function test_models_use_expected_primary_keys(): void
    {
        $this->assertSame('ref', (new Produit)->getKeyName());
        $this->assertFalse((new Produit)->getIncrementing());
        $this->assertSame('string', (new Produit)->getKeyType());

        $this->assertSame('numero', (new Commande)->getKeyName());
        $this->assertFalse((new Commande)->getIncrementing());

        $this->assertSame('pavs_id', (new PavStandard)->getKeyName());
        $this->assertSame('pavs_id', (new PavCustom)->getKeyName());
        $this->assertSame('reduction_id', (new ReductionPersonnel)->getKeyName());
        $this->assertSame('reduction_id', (new ReductionGlobale)->getKeyName());
    }

    /**
     * Test important relationship types.
     */
    public function test_models_expose_relationships(): void
    {
        $this->assertInstanceOf(HasOne::class, (new Pav)->standard());
        $this->assertInstanceOf(HasOne::class, (new Pav)->custom());
        $this->assertInstanceOf(HasMany::class, (new Pav)->contenus());

        $this->assertInstanceOf(HasMany::class, (new Address)->stores());
        $this->assertInstanceOf(BelongsTo::class, (new PavCustom)->store());
        $this->assertInstanceOf(HasMany::class, (new Produit)->lignes());
        $this->assertInstanceOf(HasMany::class, (new Commande)->lignes());
        $this->assertInstanceOf(HasOne::class, (new Commande)->facture());
        $this->assertInstanceOf(BelongsTo::class, (new Ligne)->produit());
        $this->assertInstanceOf(BelongsTo::class, (new Facture)->commande());
        $this->assertInstanceOf(BelongsTo::class, (new Applique)->reduction());
    }
}
