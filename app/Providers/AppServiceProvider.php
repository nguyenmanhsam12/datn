<?php

namespace App\Providers;

use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
    }
}
