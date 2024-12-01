<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    protected $fillable = [ 'title', 'subtitle', 'slug', 'content', 'secondary_content', 'thumbnail', 'secondary_image', 'author_id'];
    use SoftDeletes;
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
