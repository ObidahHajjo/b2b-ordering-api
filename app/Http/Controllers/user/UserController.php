<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\RoleService;
use App\Services\StoreService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Vinkla\Hashids\Facades\Hashids;

class UserController extends Controller
{
    /**
     * Create the user controller.
     *
     * @param  UserService  $userService  User business service.
     * @return void
     */
    public function __construct(private readonly UserService $userService) {}

    /**
     * Display all users.
     *
     * @return JsonResponse Users response.
     */
    public function index(): JsonResponse
    {
        $users = $this->userService
            ->all()
            ->map(function (User $user): array {
                return [
                    'name' => $user->first_name.' '.$user->last_name,
                    'email' => $user->email,
                    'id' => $user->hashid,
                    'role_id' => $user->role_id,
                    'store_id' => $user->store_id,
                    'is_active' => $user->is_active,
                ];
            });

        return response()->json([
            'users' => $users,
        ]);
    }

    /**
     * Display all roles.
     *
     * @param  RoleService  $roleService  Role business service.
     * @return JsonResponse Roles response.
     */
    public function roles(RoleService $roleService): JsonResponse
    {
        $roles = $roleService->all()->map(function ($role): array {
            return [
                'id' => $role->id,
                'name' => $role->name,
            ];
        });

        return response()->json([
            'roles' => $roles,
        ]);
    }

    /**
     * Display all stores.
     *
     * @param  StoreService  $storeService  Store business service.
     * @return JsonResponse Stores response.
     */
    public function stores(StoreService $storeService): JsonResponse
    {
        $stores = $storeService->all()->map(function ($store): array {
            return [
                'name' => $store->name,
                'id' => $store->id,
            ];
        });

        return response()->json([
            'stores' => $stores,
        ]);
    }

    /**
     * Display one user.
     *
     * @param  string  $hashId  User hashed identifier.
     * @return JsonResponse User response.
     */
    public function show(string $hashId): JsonResponse
    {
        $user = $this->findByHashId($hashId);

        return response()->json([
            'user' => $this->serializeUser($user),
        ]);
    }

    /**
     * Store a new user.
     *
     * @param  StoreUserRequest  $request  Validated user creation request.
     * @return JsonResponse Created user response.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = $this->userService->create($data);

        return response()->json([
            'message' => 'User created.',
            'user' => $this->serializeUser($user),
        ], 201);
    }

    /**
     * Update an existing user.
     *
     * @param  string  $hashId  User hashed identifier.
     * @param  UpdateUserRequest  $request  Validated user update request.
     * @return JsonResponse Updated user response.
     */
    public function update(string $hashId, UpdateUserRequest $request): JsonResponse
    {
        $user = $this->findByHashId($hashId);
        Gate::authorize('update', $user);
        $data = $request->validated();
        if (array_key_exists('password', $data)) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json([
            'message' => 'User updated.',
            'user' => $this->serializeUser($user->refresh()),
        ]);
    }

    /**
     * Delete one user.
     *
     * @param  string  $hashId  User hashed identifier.
     * @return JsonResponse Deleted user response.
     */
    public function destroy(string $hashId): JsonResponse
    {
        $user = $this->findByHashId($hashId);
        Gate::authorize('delete', $user);
        $user->delete();

        return response()->json([
            'message' => 'User deleted.',
        ]);
    }

    /**
     * Approve one user.
     *
     * @param  string  $hashId  User hashed identifier.
     * @return JsonResponse Approved user response.
     */
    public function approve(string $hashId): JsonResponse
    {
        $user = $this->findByHashId($hashId);
        Gate::authorize('update', $user);

        $user->forceFill([
            'is_active' => now(),
        ])->save();

        $user->store?->forceFill([
            'validation_date' => now(),
        ])->save();

        return response()->json([
            'message' => 'User approved.',
            'user' => $this->serializeUser($user->refresh()),
        ]);
    }

    /**
     * Find a user from a hash id.
     *
     * @param  string  $hashId  User hashed identifier.
     * @return User Found user.
     */
    private function findByHashId(string $hashId): User
    {
        $decoded = Hashids::decode($hashId);
        $id = $decoded[0] ?? null;
        abort_if(! $id, 404);

        $user = $this->userService->getById($id);
        abort_if(! $user, 404);

        return $user;
    }

    /**
     * Serialize a user for API responses.
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
            'created_at' => $user->created_at?->toISOString(),
            'updated_at' => $user->updated_at?->toISOString(),
        ];
    }
}
