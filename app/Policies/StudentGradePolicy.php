<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StudentGrade;
use App\Models\Role;

class StudentGradePolicy
{
    /**
     * Determine if the user can view any student grades.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([Role::ADMIN, Role::TEACHER, Role::STUDENT]);
    }

    /**
     * Determine if the user can view the student grade.
     */
    public function view(User $user, StudentGrade $studentGrade): bool
    {
        // Admin puede ver todas las notas
        if ($user->hasRole(Role::ADMIN)) {
            return true;
        }

        // Docente del grupo puede ver las notas de su grupo
        if ($user->hasRole(Role::TEACHER) && $studentGrade->group) {
            return $studentGrade->group->teacher_id === $user->id;
        }

        // Estudiante puede ver sus propias notas
        if ($user->hasRole(Role::STUDENT)) {
            return $studentGrade->student_id === $user->id;
        }

        return false;
    }

    /**
     * Determine if the user can create student grades.
     */
    public function create(User $user): bool
    {
        // Admin y docentes pueden crear notas
        return $user->hasAnyRole([Role::ADMIN, Role::TEACHER]);
    }

    /**
     * Determine if the user can update the student grade.
     */
    public function update(User $user, StudentGrade $studentGrade): bool
    {
        // Admin puede editar todas las notas
        if ($user->hasRole(Role::ADMIN)) {
            return true;
        }

        // Docente del grupo puede editar las notas de su grupo
        if ($user->hasRole(Role::TEACHER) && $studentGrade->group) {
            return $studentGrade->group->teacher_id === $user->id;
        }

        return false;
    }

    /**
     * Determine if the user can delete the student grade.
     */
    public function delete(User $user, StudentGrade $studentGrade): bool
    {
        // Admin puede eliminar todas las notas
        if ($user->hasRole(Role::ADMIN)) {
            return true;
        }

        // Docente del grupo puede eliminar las notas de su grupo
        if ($user->hasRole(Role::TEACHER) && $studentGrade->group) {
            return $studentGrade->group->teacher_id === $user->id;
        }

        return false;
    }
}
