<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';

    protected $fillable = ['code','discount_type','discount_value','minimum_order_value','end_date','status'];

    // Hàm kiểm tra xem mã giảm giá có hết hạn không
    public function isExpired()
    {
        return $this->end_date && $this->end_date < now();
    }
}
