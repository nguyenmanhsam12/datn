<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = ['order_id','product_variant_id','quantity','price','product_name','product_image','size'];
    public function productVariant()
    {
        return $this->belongsTo(ProductVariants::class, 'product_variant_id');
    }
    public function product()
{
    return $this->productVariant->product();  // Lấy sản phẩm từ productVariant
}
}
