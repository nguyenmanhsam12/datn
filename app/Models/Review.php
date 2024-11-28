<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    // Các cột có thể gán giá trị thông qua phương thức mass-assignment
    protected $fillable = [
        'product_id', // ID sản phẩm
        'user_id',    // ID người dùng
        'image',      // Hình ảnh đính kèm (nếu có)
        'message',    // Nội dung bình luận
        'rating',     // Số sao đánh giá
    ];

    /**
     * Mối quan hệ với model User
     * Một review thuộc về một user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mối quan hệ với model Product
     * Một review thuộc về một sản phẩm.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
