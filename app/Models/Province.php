<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'matinh';
    protected $keyType = 'string';     // Khóa chính là kiểu chuỗi
    protected $table = 'province';
    protected $fillable = ['name','type'];
}
