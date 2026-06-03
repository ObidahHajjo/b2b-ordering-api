<?php

namespace App\traits;

trait HasRole
{
    /**
     * Check if the user has a role.
     *
     * @param  string  $role  Role name.
     * @return bool True when the user has the role.
     */
    public function hasRole(string $role): bool
    {
        return $this->role?->name === $role;
    }

    /**
     * Check if the user is admin.
     *
     * @return bool True when the user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }
}
