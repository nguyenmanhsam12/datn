<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.list-post'));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.edit-post'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.add-post'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.delete-post'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user)
    {
        //
    }
}