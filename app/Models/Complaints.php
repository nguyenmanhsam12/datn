<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaints extends Model
{
    use HasFactory;

    protected $table = 'complainst';

    protected $fillable = ['order_id','user_id','complaint_details','complaint_type','status',
    'attachments','order_date'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
    

}
