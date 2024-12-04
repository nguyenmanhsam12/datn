<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $primaryKey = 'phuongid';
    protected $table = 'ward';
    protected $keyType = 'string';      // Khóa chính là kiểu chuỗi
    protected $fillable = ['name','type','macity'];
}
            