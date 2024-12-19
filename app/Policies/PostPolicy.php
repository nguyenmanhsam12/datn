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
    public function view(User $user,$id)
    {
        $post = Post::find($id);
        // Kiểm tra nếu người dùng có quyền xem bất kỳ bản ghi nào trong bảng User
        if ($user->checkPermissionAccess(config('permission.access.edit-post'))) {
            // Nếu người dùng có quyền, kiểm tra nếu người dùng đó đang truy cập bản ghi của chính mình
            if ($user->id === $post->author_id) {
                return true; // Người dùng có quyền xem bản ghi của chính mình
            }
        }

        // Kiểm tra nếu người dùng có vai trò admin
        if ($user->hasRole('admin')) {
            return true; // Admin không cần kiểm tra id, cho phép xem tất cả các bản ghi
        }

        // Nếu không thỏa mãn các điều kiện trên, từ chối quyền truy cập
        return false;
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
    public function delete(User $user , $id)
    {
        $post = Post::find($id);
        // Kiểm tra nếu người dùng có quyền xem bất kỳ bản ghi nào trong bảng User
        if ($user->checkPermissionAccess(config('permission.access.delete-post'))) {
            // Nếu người dùng có quyền, kiểm tra nếu người dùng đó đang truy cập bản ghi của chính mình
            if ($user->id === $post->author_id) {
                return true; // Người dùng có quyền xem bản ghi của chính mình
            }
        }

        // Kiểm tra nếu người dùng có vai trò admin
        if ($user->hasRole('admin')) {
            return true; // Admin không cần kiểm tra id, cho phép xem tất cả các bản ghi
        }

        // Nếu không thỏa mãn các điều kiện trên, từ chối quyền truy cập
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user , $id)
    {
        $post = Post::onlyTrashed()->find($id);
        // Kiểm tra nếu người dùng có quyền xem bất kỳ bản ghi nào trong bảng User
        if ($user->checkPermissionAccess(config('permission.access.restore-post'))) {
            // Nếu người dùng có quyền, kiểm tra nếu người dùng đó đang truy cập bản ghi của chính mình
            if ($user->id === $post->author_id) {
                return true; // Người dùng có quyền xem bản ghi của chính mình
            }
        }

        // Kiểm tra nếu người dùng có vai trò admin
        if ($user->hasRole('admin')) {
            return true; // Admin không cần kiểm tra id, cho phép xem tất cả các bản ghi
        }

        // Nếu không thỏa mãn các điều kiện trên, từ chối quyền truy cập
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user , $id)
    {
        $post = Post::onlyTrashed()->find($id);
        // Kiểm tra nếu người dùng có quyền xem bất kỳ bản ghi nào trong bảng User
        if ($user->checkPermissionAccess(config('permission.access.fordelete-post'))) {
            // Nếu người dùng có quyền, kiểm tra nếu người dùng đó đang truy cập bản ghi của chính mình
            if ($user->id === $post->author_id) {
                return true; // Người dùng có quyền xem bản ghi của chính mình
            }
        }

        // Kiểm tra nếu người dùng có vai trò admin
        if ($user->hasRole('admin')) {
            return true; // Admin không cần kiểm tra id, cho phép xem tất cả các bản ghi
        }

        // Nếu không thỏa mãn các điều kiện trên, từ chối quyền truy cập
        return false;
    }

    public function viewTrashed(User $user)
    {
        return $user->checkPermissionAccess(config('permission.access.listdeleted-post'));
    }
}
