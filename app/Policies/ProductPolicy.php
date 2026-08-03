<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use App\Models\Role;

class ProductPolicy
{
    /**
     * Determine if the user can view any products.
     */
    public function viewAny(?User $user): bool
    {
        // Productos públicos visibles sin autenticación
        return true;
    }

    /**
     * Determine if the user can view the product.
     */
    public function view(?User $user, Product $product): bool
    {
        // Productos activos son públicos
        if ($product->is_active) {
            return true;
        }

        // Productos inactivos solo visibles para admin
        return $user && $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine if the user can create products.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine if the user can update the product.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine if the user can delete the product.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine if the user can restore the product.
     */
    public function restore(User $user, Product $product): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine if the user can permanently delete the product.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine if the user can manage product offers.
     */
    public function manageOffers(User $user, Product $product): bool
    {
        return $user->hasRole(Role::ADMIN);
    }
}
