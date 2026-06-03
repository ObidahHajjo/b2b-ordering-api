<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\StoreContactMessageRequest;
use App\Models\Categorie;
use App\Services\ContactService;
use Illuminate\Http\JsonResponse;

class PublicController extends Controller
{
    /**
     * Create the public controller.
     *
     * @param  ContactService  $contactService  Contact business service.
     * @return void
     */
    public function __construct(private readonly ContactService $contactService) {}

    /**
     * Display public company information.
     *
     * @return JsonResponse Company response.
     */
    public function company(): JsonResponse
    {
        return response()->json([
            'company' => [
                'name' => config('company.name'),
                'location' => config('company.location'),
                'activity' => config('company.activity'),
                'phone' => config('company.phone'),
                'email' => config('company.email'),
                'suppliers' => config('company.suppliers', []),
            ],
        ]);
    }

    /**
     * Display public categories.
     *
     * @return JsonResponse Category response.
     */
    public function categories(): JsonResponse
    {
        return response()->json([
            'categories' => Categorie::query()->orderBy('libelle')->get(['id', 'libelle']),
        ]);
    }

    /**
     * Store a contact message.
     *
     * @param  StoreContactMessageRequest  $request  Validated contact request.
     * @return JsonResponse Contact response.
     */
    public function contact(StoreContactMessageRequest $request): JsonResponse
    {
        $this->contactService->create($request->validated());

        return response()->json([
            'message' => 'Contact message sent.',
        ], 201);
    }
}
