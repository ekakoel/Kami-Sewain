<?php

namespace App\Models;

use App\Models\Products;
use App\Models\Galleries;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categories extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'icon',
    ];

    public function products()
    {
        return $this->hasMany(Products::class,'category_id');
    }
    public function galleries()
    {
        return $this->hasMany(Galleries::class, 'product_id');
    }
}
