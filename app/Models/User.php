<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'address',
        'city_id',
        'province_id',
        'ward_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class,'role_user', 'user_id', 'role_id');
    }

    // Optional: helper function to check if user has a specific role
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }
    
        public function isAdmin()
    {
        return $this->roles->contains('name', 'admin');  // Kiểm tra nếu user có vai trò 'admin'
    }
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'user_id');
    }

    public function province(){
        return $this->belongsTo(Province::class,'province_id');
    }
    public function city(){
        return $this->belongsTo(City::class,'city_id');
    }
    public function ward(){
        return $this->belongsTo(Ward::class,'ward_id');
    }
    
}
