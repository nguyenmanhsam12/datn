<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = ['user_id','status_id','payment_method_id','total_amount','coupon_id','discount_amount'];

    public function cartItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function orderAddress(){
        return $this->hasOne(OrderAddress::class);
    }
    
    public function payment(){
        return $this->belongsTo(Payment_Methods::class,'payment_method_id');
    }

    public function orderStatus(){
        return $this->belongsTo(OrderStatus::class,'status_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
