<?php

namespace App\Policies;

use App\Models\Complaints;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ComplaintsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.list-complaint'));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.edit-complaint'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Complaints $complaints)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.delete-complaint'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Complaints $complaints)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Complaints $complaints)
    {
        //
    }
}
