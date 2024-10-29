<?php

namespace App\Models;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogPostImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'blog_post_id',
        'image_url',
        'alt_text',
    ];
    public function post()
    {
        return $this->belongsTo(BlogPost::class,'blog_post_id');
    }
}
