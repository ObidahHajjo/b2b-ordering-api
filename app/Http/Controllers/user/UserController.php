<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;

class UserController extends Controller
{

    /**
     * Create a new user.
     *
     * Authorizes the action using the User policy and persists a new user
     * with validated input data.
     *
     * @param \App\Http\Requests\User\StoreUserRequest $request
     * @return \App\Models\User
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreUserRequest $request): User
    {
        $this->authorize('create', User::class);
        return User::create($request->validated());
    }

    /**
     * Update an existing user
     *
     * Authorizes the action using the User policy
     * with validated input data.
     *
     * @param \App\Models\User $user
     * @param \App\Http\Requests\user\UpdateUserRequest $request
     * @return bool
     *
     * @throws AuthorizationException
     */
    public function update(User $user, UpdateUserRequest $request): bool
    {
        $this->authorize('update', $user);
        $data = $request->validated();
        return $user->update($data);
    }

    /**
     * Delete the specified user.
     *
     * Authorizes the deletion using the User policy and removes the user
     * from persistent storage.
     *
     * @param \App\Models\User $user
     * @return bool|null
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user): bool|null
    {
        $this->authorize('delete', $user);

        return $user->delete();
    }

}
