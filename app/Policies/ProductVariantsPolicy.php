<?php

namespace App\Policies;

use App\Models\ProductVariants;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductVariantsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.list-variant'));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.edit-variant'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.add-variant'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProductVariants $productVariants)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.delete-variant'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProductVariants $productVariants)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProductVariants $productVariants)
    {
        //
    }
}
