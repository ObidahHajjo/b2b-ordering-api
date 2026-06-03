<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create the auth controller.
     *
     * @param  AuthService  $authService  Authentication business service.
     * @return void
     */
    public function __construct(private readonly AuthService $authService) {}

    /**
     * Register a user and issue a token.
     *
     * @param  RegisterRequest  $request  Registration request data.
     * @return JsonResponse Token and user response.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());
        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $this->serializeUser($user),
        ], 201);
    }

    /**
     * Login a user and issue a token.
     *
     * @param  LoginRequest  $request  Login request data.
     * @return JsonResponse Token and user response.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->authService->authenticate($request);

        if (! $user) {
            return response()->json([
                'message' => 'Invalid credentials.',
            ], 401);
        }

        if ($user->is_active === null) {
            return response()->json([
                'message' => 'Your account is awaiting admin approval.',
            ], 403);
        }

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $this->serializeUser($user),
        ]);
    }

    /**
     * Display the current user.
     *
     * @param  Request  $request  Authenticated request.
     * @return JsonResponse Current user response.
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $this->serializeUser($request->user()),
        ]);
    }

    /**
     * Logout the current token.
     *
     * @param  Request  $request  Authenticated request.
     * @return JsonResponse Logout response.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()?->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Logged out.',
        ]);
    }

    /**
     * Serialize a user for auth responses.
     *
     * @param  User  $user  User model.
     * @return array<string, mixed> User response data.
     */
    private function serializeUser(User $user): array
    {
        return [
            'id' => $user->hashid,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'role_id' => $user->role_id,
            'store_id' => $user->store_id,
            'is_active' => $user->is_active,
        ];
    }
}
