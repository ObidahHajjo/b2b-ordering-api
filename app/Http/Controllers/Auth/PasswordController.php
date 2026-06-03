<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use Illuminate\Http\JsonResponse;

class PasswordController extends Controller
{
    /**
     * Update the current user's password.
     *
     * @param  UpdatePasswordRequest  $request  Password update request.
     * @return JsonResponse Password update response.
     */
    public function update(UpdatePasswordRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $request->user()->update([
            'password' => $validated['password'],
        ]);

        return response()->json([
            'message' => 'Password updated.',
        ]);
    }
}
