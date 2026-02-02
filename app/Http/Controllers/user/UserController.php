<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Interfaces\RoleInterface;
use App\Interfaces\StoreInterface;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a list of users.
     *
     * Each user is transformed into a lightweight DTO containing
     * only public-facing fields and a hashed identifier.
     *
     * @param RoleInterface $roleInterface
     * @param StoreInterface $storeInterface
     * @return Response
     */
    public function index(RoleInterface $roleInterface, StoreInterface $storeInterface): Response {
        $users = $this->userService
            ->all()
            ->map(function (User $user) {
                return [
                    'name'  => $user->first_name . ' ' . $user->last_name,
                    'email' => $user->email,
                    'id'    => $user->hashid,
                ];
            });

        $roles = $roleInterface->all()->map(function ($role) {
            return [
                'id' => $role->id,
                'name' => $role->name,
            ];
        });

        $stores = $storeInterface->all()->map(function ($store) {
            return [
                'name' => $store->name,
                'id' => $store->id,
            ];
        });

        return Inertia::render('users/index', [
            'users' => $users,
            'roles' => $roles,
            'stores' => $stores
        ]);
    }

    /**
     * Display a single user's details.
     *
     * The user is resolved from a hashed identifier to avoid
     * exposing internal database IDs.
     *
     * @param  string  $hashid  The hashed user identifier.
     * @return Response
     *
     * @throws NotFoundHttpException
     */
    public function show(string $hashid)
    {
        //TODO : use userService instead of model
        $id = Hashids::decode($hashid)[0] ?? null;

        abort_if(! $id, 404);

        $user = User::findOrFail($id);

        return Inertia::render('users/show', [
            'user' => [
                'id' => $user->hashid,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'created_at' => $user->created_at->toDateString(),
            ],
        ]);

    }


    /**
     * Create a new user.
     *
     * Authorizes the action using the User policy and persists a new user
     * with validated input data.
     *
     * @param StoreUserRequest $request
     * @return RedirectResponse
     *
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        //TODO : use userService instead of model
        $data = $request->validated();
        $data['password'] =  Hash::make($data['password']);
        User::create($data);

        return redirect()->route('users.index');
    }

    /**
     * Update an existing user
     *
     * Authorizes the action using the User policy
     * with validated input data.
     *
     * @param User $user
     * @param \App\Http\Requests\user\UpdateUserRequest $request
     * @return bool
     *
     */
    public function update(User $user, UpdateUserRequest $request): bool
    {
        //TODO : use userService instead of model
        Gate::authorize('update', $user);
        $data = $request->validated();
        return $user->update($data);
    }

    /**
     * Delete the specified user.
     *
     * Authorizes the deletion using the User policy and removes the user
     * from persistent storage.
     *
     * @param User $user
     * @return bool|null
     *
     */
    public function destroy(User $user): bool|null
    {
        //TODO : use userService instead of model
        Gate::authorize('delete', $user);
        return $user->delete();
    }

}
