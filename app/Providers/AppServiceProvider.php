<?php

namespace App\Providers;

use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // định nghĩa gate
        Gate::define('brand_list',function($user){
            // truyền keycode lên
            return $user->checkPermissionAccess(config('permission.access.list-brand'));
        });
        Gate::define('brand_add',function($user){
            return $user->checkPermissionAccess(config('permission.access.add-brand'));
        });
        Gate::define('brand_edit',function($user){
            return $user->checkPermissionAccess(config('permission.access.edit-brand'));
        });
        Gate::define('brand_delete',function($user){  
            return $user->checkPermissionAccess(config('permission.access.delete-brand'));
        });
        Gate::define('brand_listdeleted',function($user){  
            return $user->checkPermissionAccess(config('permission.access.listdeleted-brand'));
        });
        Gate::define('brand_restore',function($user){  
            return $user->checkPermissionAccess(config('permission.access.restore-brand'));
        });
        Gate::define('brand_fordelete',function($user){  
            return $user->checkPermissionAccess(config('permission.access.fordelete-brand'));
        });

        Paginator::useBootstrap();

    }
}
