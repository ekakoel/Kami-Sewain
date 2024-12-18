<?php

namespace App\Models;

use App\Models\User;
use App\Models\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Likes extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
    ];


    public function product()
    {
        return $this->belongsTo(Products::class,'product_id');
    }
}

