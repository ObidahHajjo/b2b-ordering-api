<?php

namespace App\Services;

use App\Models\Produit;
use Illuminate\Database\Eloquent\Collection;

class CatalogService
{
    /**
     * Get available products with categories.
     *
     * @return Collection<int, Produit> Product collection.
     */
    public function availableProducts(): Collection
    {
        return Produit::with(['classifications.categorie'])
            ->where('est_disponible', true)
            ->orderBy('nom')
            ->get();
    }
}
