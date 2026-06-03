<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Deny listing by policy.
     *
     * @param  User  $user  Authenticated user.
     * @return bool Always false.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Deny viewing by policy.
     *
     * @param  User  $user  Authenticated user.
     * @param  User  $model  Target user.
     * @return bool Always false.
     */
    public function view(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Allow admins to create users.
     *
     * @param  User  $authUser  Authenticated user.
     * @return bool True when admin.
     */
    public function create(User $authUser): bool
    {
        return $authUser->isAdmin();
    }

    /**
     * Allow admins or self updates.
     *
     * @param  User  $authUser  Authenticated user.
     * @param  User  $targetUser  Target user.
     * @return bool True when allowed.
     */
    public function update(User $authUser, User $targetUser): bool
    {
        return $authUser->isAdmin() || $authUser->id === $targetUser->id;
    }

    /**
     * Allow admins or self deletes.
     *
     * @param  User  $authUser  Authenticated user.
     * @param  User  $targetUser  Target user.
     * @return bool True when allowed.
     */
    public function delete(User $authUser, User $targetUser): bool
    {
        return ($authUser->isAdmin() && ! $targetUser->isAdmin())
            || $authUser->id === $targetUser->id;
    }

    /**
     * Deny restoring users.
     *
     * @param  User  $user  Authenticated user.
     * @param  User  $model  Target user.
     * @return bool Always false.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Deny force deleting users.
     *
     * @param  User  $user  Authenticated user.
     * @param  User  $model  Target user.
     * @return bool Always false.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
