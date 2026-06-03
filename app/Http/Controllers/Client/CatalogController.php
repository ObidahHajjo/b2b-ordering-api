<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\CatalogService;
use Illuminate\Http\JsonResponse;

class CatalogController extends Controller
{
    /**
     * Create the catalog controller.
     *
     * @param  CatalogService  $catalogService  Catalog business service.
     * @return void
     */
    public function __construct(private readonly CatalogService $catalogService) {}

    /**
     * Display the available product catalog.
     *
     * @return JsonResponse Product catalog response.
     */
    public function index(): JsonResponse
    {
        $products = $this->catalogService->availableProducts()->map(function ($product): array {
            return [
                'ref' => $product->ref,
                'nom' => $product->nom,
                'prix' => (float) $product->prix,
                'poids' => (float) $product->poids,
                'liste_ingredient' => $product->liste_ingredient,
                'est_disponible' => (bool) $product->est_disponible,
                'categories' => $product->classifications
                    ->map(fn ($classification): array => [
                        'id' => $classification->categorie?->id,
                        'libelle' => $classification->categorie?->libelle,
                    ])
                    ->filter(fn (array $category): bool => $category['id'] !== null)
                    ->values(),
            ];
        })->values();

        return response()->json([
            'products' => $products,
        ]);
    }
}
