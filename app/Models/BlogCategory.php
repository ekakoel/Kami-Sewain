<?php

namespace App\Models;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogCategory extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
        'slug',
    ];
    public function posts()
    {
        return $this->hasMany(BlogPost::class,'category_id');
    }
}
