<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use App\Models\ProductVariants;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory , HasSlug , SoftDeletes ;

    protected $table = 'products';

    protected $fillable = ['name','slug','description','sku','image','gallary','brand_id','category_id','user_id',
        'deleted_at','description_text'
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name') // Tạo slug từ trường 'name'
            ->saveSlugsTo('slug'); // Lưu vào trường 'slug'
    }

    // lấy ra 1 sản phẩm chính của biến thể
    public function mainVariant(){
        return $this->hasOne(ProductVariants::class);
    }
 
    public function variants()
    {
        return $this->hasMany(ProductVariants::class);
    }
    
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'wishlists', 'product_id', 'user_id');
    }
}
