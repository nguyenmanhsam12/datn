<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Permission;
use App\Models\Product;
use App\Models\ProductVariants;
use App\Models\Role;
use App\Models\Size;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\CouponPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ProductPolicy;
use App\Policies\ProductVariantsPolicy;
use App\Policies\RolePolicy;
use App\Policies\SizePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Permission::class => PermissionPolicy::class, 
        Size::class => SizePolicy::class,
        Category::class => CategoryPolicy::class,
        Product::class => ProductPolicy::class,
        ProductVariants::class => ProductVariantsPolicy::class,
        Coupon::class => CouponPolicy::class,
        Role::class => RolePolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
