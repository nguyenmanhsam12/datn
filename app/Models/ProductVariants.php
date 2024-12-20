<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariants extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'product_variants';

    protected $fillable = ['product_id','size_id','stock','selled','price','deleted_at','length',
        'width','height',
    ];

    public function product(){
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function size(){
        return $this->belongsTo(Size::class);
    }


}
