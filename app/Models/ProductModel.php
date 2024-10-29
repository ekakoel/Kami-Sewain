<?php

namespace App\Models;

use App\Models\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
    ];
    public function products()
    {
        return $this->hasMany(Products::class,'model_id');
    }
}
