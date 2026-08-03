<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use App\Models\Role;

class OrderPolicy
{
    /**
     * Determine if the user can view any orders.
     */
    public function viewAny(User $user): bool
    {
        // Admin ve todas, estudiantes ven solo las suyas
        return $user->hasAnyRole([Role::ADMIN, Role::STUDENT]);
    }

    /**
     * Determine if the user can view the order.
     */
    public function view(User $user, Order $order): bool
    {
        // Admin puede ver todas las órdenes
        if ($user->hasRole(Role::ADMIN)) {
            return true;
        }

        // Estudiante puede ver solo sus propias órdenes
        if ($user->hasRole(Role::STUDENT)) {
            return $order->student_id === $user->id;
        }

        return false;
    }

    /**
     * Determine if the user can create orders.
     */
    public function create(User $user): bool
    {
        // Solo estudiantes pueden crear órdenes (comprar)
        return $user->hasRole(Role::STUDENT);
    }

    /**
     * Determine if the user can update the order.
     */
    public function update(User $user, Order $order): bool
    {
        // Admin puede actualizar todas las órdenes
        if ($user->hasRole(Role::ADMIN)) {
            return true;
        }

        // Estudiante puede actualizar solo sus órdenes pendientes
        if ($user->hasRole(Role::STUDENT) 
            && $order->student_id === $user->id 
            && $order->status === Order::STATUS_PENDING) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can cancel the order.
     */
    public function cancel(User $user, Order $order): bool
    {
        // Admin puede cancelar cualquier orden
        if ($user->hasRole(Role::ADMIN)) {
            return true;
        }

        // Estudiante puede cancelar solo sus órdenes pendientes
        if ($user->hasRole(Role::STUDENT) 
            && $order->student_id === $user->id 
            && $order->status === Order::STATUS_PENDING) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can delete the order.
     */
    public function delete(User $user, Order $order): bool
    {
        // Solo admin puede eliminar órdenes
        return $user->hasRole(Role::ADMIN);
    }
}
