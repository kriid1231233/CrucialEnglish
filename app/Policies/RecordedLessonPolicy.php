<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RecordedLesson;
use App\Models\Role;

class RecordedLessonPolicy
{
    /**
     * Determine if the user can view any recorded lessons.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([Role::ADMIN, Role::TEACHER, Role::STUDENT]);
    }

    /**
     * Determine if the user can view the recorded lesson.
     */
    public function view(User $user, RecordedLesson $recordedLesson): bool
    {
        // Admin y docentes pueden ver todas
        if ($user->hasAnyRole([Role::ADMIN, Role::TEACHER])) {
            return true;
        }

        // Estudiantes solo pueden ver clases aprobadas con acceso habilitado
        if ($user->hasRole(Role::STUDENT) && $recordedLesson->estado === RecordedLesson::STATUS_APPROVED) {
            return $user->accesses()
                ->where('producto_id', $recordedLesson->id)
                ->where('tipo_acceso', 'recorded_lesson')
                ->where('activo', true)
                ->where(function ($query) {
                    $query->whereNull('expira_en')
                        ->orWhere('expira_en', '>', now());
                })
                ->exists();
        }

        return false;
    }

    /**
     * Determine if the user can create recorded lessons.
     */
    public function create(User $user): bool
    {
        // Docentes y admin pueden crear clases pregrabadas
        return $user->hasAnyRole([Role::ADMIN, Role::TEACHER]);
    }

    /**
     * Determine if the user can update the recorded lesson.
     */
    public function update(User $user, RecordedLesson $recordedLesson): bool
    {
        // Admin puede editar todas
        if ($user->hasRole(Role::ADMIN)) {
            return true;
        }

        // Docente autor puede editar mientras esté pendiente
        if ($user->hasRole(Role::TEACHER) 
            && $recordedLesson->autor_id === $user->id 
            && $recordedLesson->estado === RecordedLesson::STATUS_PENDING) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can delete the recorded lesson.
     */
    public function delete(User $user, RecordedLesson $recordedLesson): bool
    {
        // Admin puede eliminar todas
        if ($user->hasRole(Role::ADMIN)) {
            return true;
        }

        // Docente autor puede eliminar mientras esté pendiente
        if ($user->hasRole(Role::TEACHER) 
            && $recordedLesson->autor_id === $user->id 
            && $recordedLesson->estado === RecordedLesson::STATUS_PENDING) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can approve/reject recorded lessons.
     */
    public function review(User $user, RecordedLesson $recordedLesson): bool
    {
        // Solo admin puede aprobar/rechazar clases
        return $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine if the user can watch the recorded lesson.
     */
    public function watch(User $user, RecordedLesson $recordedLesson): bool
    {
        return $this->view($user, $recordedLesson);
    }
}
