<?php

namespace App\Models;

use App\Models\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductColor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'color_code',
    ];
    public function products()
    {
        return $this->hasMany(Products::class,'color_id');
    }
}
