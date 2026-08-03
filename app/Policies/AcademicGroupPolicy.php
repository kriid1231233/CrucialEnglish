<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AcademicGroup;
use App\Models\Role;

class AcademicGroupPolicy
{
    /**
     * Determine if the user can view any academic groups.
     */
    public function viewAny(User $user): bool
    {
        // Admin y docentes pueden ver todos los grupos, estudiantes solo los suyos
        return $user->hasAnyRole([Role::ADMIN, Role::TEACHER, Role::STUDENT]);
    }

    /**
     * Determine if the user can view the academic group.
     */
    public function view(User $user, AcademicGroup $academicGroup): bool
    {
        // Admin puede ver todos
        if ($user->hasRole(Role::ADMIN)) {
            return true;
        }

        // Docente asignado puede ver su grupo
        if ($user->hasRole(Role::TEACHER) && $academicGroup->teacher_id === $user->id) {
            return true;
        }

        // Estudiante puede ver si está inscrito
        if ($user->hasRole(Role::STUDENT)) {
            return $academicGroup->students()->where('users.id', $user->id)->exists();
        }

        return false;
    }

    /**
     * Determine if the user can create academic groups.
     */
    public function create(User $user): bool
    {
        // Solo admin puede crear grupos
        return $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine if the user can update the academic group.
     */
    public function update(User $user, AcademicGroup $academicGroup): bool
    {
        // Admin puede editar todos los grupos
        if ($user->hasRole(Role::ADMIN)) {
            return true;
        }

        // Docente asignado puede editar su grupo (solo ciertos campos)
        if ($user->hasRole(Role::TEACHER) && $academicGroup->teacher_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can delete the academic group.
     */
    public function delete(User $user, AcademicGroup $academicGroup): bool
    {
        // Solo admin puede eliminar grupos
        return $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine if the user can restore the academic group.
     */
    public function restore(User $user, AcademicGroup $academicGroup): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine if the user can permanently delete the academic group.
     */
    public function forceDelete(User $user, AcademicGroup $academicGroup): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine if the user can manage students in the group.
     */
    public function manageStudents(User $user, AcademicGroup $academicGroup): bool
    {
        // Admin puede gestionar estudiantes de todos los grupos
        if ($user->hasRole(Role::ADMIN)) {
            return true;
        }

        // Docente asignado puede gestionar estudiantes de su grupo
        if ($user->hasRole(Role::TEACHER) && $academicGroup->teacher_id === $user->id) {
            return true;
        }

        return false;
    }
}
