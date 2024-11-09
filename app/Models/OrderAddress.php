<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;

    protected $table = 'order_address';

    protected $fillable = ['order_id','recipient_name','recipient_email','address_order','city','province','ward','phone_number',
        'recipient_name','recipient_email',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province');
    }

    // Mối quan hệ với City
    public function city()
    {
        return $this->belongsTo(City::class, 'city');
    }

    // Mối quan hệ với Ward
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward');
    }
}
