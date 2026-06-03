<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request  Incoming request.
     * @return array<string, mixed> Resource array.
     */
    public function toArray(Request $request): array
    {
        return [
            'ref' => $this->ref,
            'nom' => $this->nom,
            'prix' => $this->prix,
            'poids' => $this->poids,
            'liste_ingredient' => $this->liste_ingredient,
            'est_disponible' => $this->est_disponible,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
