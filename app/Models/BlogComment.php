<?php

namespace App\Models;

use App\Models\User;
use App\Models\Admin;
use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogComment extends Model
{
    use HasFactory;
    protected $fillable = [
        'blog_post_id',
        'user_id',
        'admin_id',
        'comment',
        'status',
        'parent_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }
    // Relasi untuk balasan
    public function replies()
    {
        return $this->hasMany(BlogComment::class, 'parent_id');
    }
    public function posts()
    {
        return $this->belongsTo(BlogPost::class, 'blog_post_id');
    }
}
