<?php

namespace App\Models;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogTag extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug'
    ];
    public function posts()
    {
        return $this->belongsToMany(BlogPost::class,'blog_post_tags','tag_id','blog_post_id');
    }
}
