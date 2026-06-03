<?php

namespace App\Http\Responses\Auth;

use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request): RedirectResponse
    {
        if ($request->user() !== null) {
            $this->authService->logout($request);
        }

        return redirect()
            ->route('login')
            ->with('status', 'Your account has been created and is awaiting admin approval.');
    }
}
