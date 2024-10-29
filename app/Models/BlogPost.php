<?php

namespace App\Models;

use App\Models\User;
use App\Models\Admin;
use App\Models\BlogTag;
use App\Models\BlogComment;
use App\Models\BlogCategory;
use App\Models\BlogPostImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogPost extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_description',
        'meta_keywords',
        'featured_image',
        'status',
        'published_at',
        'user_id',
        'category_id',
    ];
    public function categories()
    {
        return $this->belongsTo(BlogCategory::class,'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class,'blog_post_tags','blog_post_id','tag_id');
    }
    public function images()
    {
        return $this->hasMany(BlogPostImage::class,'blog_post_images');
    }
    public function author()
    {
        return $this->belongsTo(Admin::class,'user_id');
    }
    public function comments()
    {
        return $this->hasMany(BlogComment::class,'blog_post_id');
    }
}
