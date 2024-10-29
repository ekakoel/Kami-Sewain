<?php

namespace App\Models;

use App\Models\BlogTag;
use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogPostTag extends Model
{
    use HasFactory;
    protected $fillable = [
        'blog_post_id',
        'tag_id',
    ];
    public function posts()
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_tags');
    }
}
