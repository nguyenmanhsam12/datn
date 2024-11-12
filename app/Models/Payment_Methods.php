<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_Methods extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';

    protected $fillable = ['name'];
      // Quan hệ với đơn hàng
      public function orders()
      {
          return $this->hasMany(Order::class, 'payment_method_id');
      }
}
