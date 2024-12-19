<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.list-category'));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.edit-category'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.add-category'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user)
    {
        
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.delete-category'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.restore-category'));
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.fordelete-category'));
    }

    public function viewTrashed(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.listdeleted-category'));
    }

}
