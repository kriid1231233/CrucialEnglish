<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Material;
use App\Models\Role;

class MaterialPolicy
{
    /**
     * Determine if the user can view any materials.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([Role::ADMIN, Role::TEACHER, Role::STUDENT]);
    }

    /**
     * Determine if the user can view the material.
     */
    public function view(User $user, Material $material): bool
    {
        // Admin y docentes pueden ver todos
        if ($user->hasAnyRole([Role::ADMIN, Role::TEACHER])) {
            return true;
        }

        // Estudiantes solo pueden ver materiales aprobados con acceso habilitado
        if ($user->hasRole(Role::STUDENT) && $material->status === Material::STATUS_APPROVED) {
            return $user->accesses()
                ->where('product_id', $material->id)
                ->where('access_type', 'material')
                ->where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                        ->orWhere('expires_at', '>', now());
                })
                ->exists();
        }

        return false;
    }

    /**
     * Determine if the user can create materials.
     */
    public function create(User $user): bool
    {
        // Docentes y admin pueden crear materiales
        return $user->hasAnyRole([Role::ADMIN, Role::TEACHER]);
    }

    /**
     * Determine if the user can update the material.
     */
    public function update(User $user, Material $material): bool
    {
        // Admin puede editar todos
        if ($user->hasRole(Role::ADMIN)) {
            return true;
        }

        // Docente autor puede editar mientras esté pendiente
        if ($user->hasRole(Role::TEACHER) 
            && $material->author_id === $user->id 
            && $material->status === Material::STATUS_PENDING) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can delete the material.
     */
    public function delete(User $user, Material $material): bool
    {
        // Admin puede eliminar todos
        if ($user->hasRole(Role::ADMIN)) {
            return true;
        }

        // Docente autor puede eliminar mientras esté pendiente
        if ($user->hasRole(Role::TEACHER) 
            && $material->author_id === $user->id 
            && $material->status === Material::STATUS_PENDING) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can approve/reject materials.
     */
    public function review(User $user, Material $material): bool
    {
        // Solo admin puede aprobar/rechazar materiales
        return $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine if the user can download the material file.
     */
    public function download(User $user, Material $material): bool
    {
        return $this->view($user, $material);
    }
}
