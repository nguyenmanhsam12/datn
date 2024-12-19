<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.list-product'));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user,$id)
    {
        $product = Product::find($id);
        if($user->checkPermissionAccess(config('permission.access.edit-product'))){
            if($user->id === $product->user_id){
                return true;
            }
        }
        
        if($user->hasRole('admin')){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.add-product'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user,$id)
    {
        $product = Product::find($id);
        if($user->checkPermissionAccess(config('permission.access.delete-product'))){
            if($user->id === $product->user_id){
                return true;
            }
        }
        
        if($user->hasRole('admin')){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user,$id)
    {
        $product = Product::onlyTrashed()->find($id);
        if($user->checkPermissionAccess(config('permission.access.restore-product'))){
            if($user->id === $product->user_id){
                return true;
            }
        }
        
        if($user->hasRole('admin')){
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user,$id)
    {
        $product = Product::onlyTrashed()->find($id);
        if($user->checkPermissionAccess(config('permission.access.fordelete-product'))){
            if($user->id === $product->user_id){
                return true;
            }
        }
        
        if($user->hasRole('admin')){
            return true;
        }
    }

    public function viewTrashed(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.listdeleted-product'));
    }
}
