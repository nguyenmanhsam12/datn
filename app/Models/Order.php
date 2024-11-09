<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = ['user_id','status_id','payment_method_id','total_amount'];

    public function cartItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function payment(){
        return $this->belongsTo(Payment_Methods::class,'payment_method_id');
    }
}
