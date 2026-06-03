<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ProfessionalRegistrationRequest;
use App\Services\ProfessionalRegistrationService;
use Illuminate\Http\JsonResponse;

class ProfessionalRegistrationController extends Controller
{
    /**
     * Create the professional registration controller.
     *
     * @param  ProfessionalRegistrationService  $registrationService  Registration business service.
     * @return void
     */
    public function __construct(private readonly ProfessionalRegistrationService $registrationService) {}

    /**
     * Register a professional client.
     *
     * @param  ProfessionalRegistrationRequest  $request  Validated registration request.
     * @return JsonResponse Registration response.
     */
    public function store(ProfessionalRegistrationRequest $request): JsonResponse
    {
        $user = $this->registrationService->register($request->validated());

        return response()->json([
            'message' => 'Registration request submitted and awaiting approval.',
            'user' => [
                'id' => $user->hashid,
                'email' => $user->email,
                'store_id' => $user->store_id,
                'is_active' => $user->is_active,
            ],
        ], 201);
    }
}
