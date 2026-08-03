<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;

class UserPolicy
{
    /**
     * Determine if the user can view any users.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine if the user can view the user.
     */
    public function view(User $user, User $model): bool
    {
        // Admin puede ver todos, usuarios pueden ver su propio perfil
        return $user->hasRole(Role::ADMIN) || $user->id === $model->id;
    }

    /**
     * Determine if the user can create users.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine if the user can update the user.
     */
    public function update(User $user, User $model): bool
    {
        // Admin puede editar todos, usuarios pueden editar su propio perfil (excepto roles)
        return $user->hasRole(Role::ADMIN) || $user->id === $model->id;
    }

    /**
     * Determine if the user can delete the user.
     */
    public function delete(User $user, User $model): bool
    {
        // Solo admin puede eliminar usuarios, y no puede eliminarse a sí mismo
        return $user->hasRole(Role::ADMIN) && $user->id !== $model->id;
    }

    /**
     * Determine if the user can restore the user.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine if the user can permanently delete the user.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasRole(Role::ADMIN) && $user->id !== $model->id;
    }

    /**
     * Determine if the user can assign roles to users.
     */
    public function assignRoles(User $user): bool
    {
        return $user->hasRole(Role::ADMIN);
    }
}
