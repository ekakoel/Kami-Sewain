<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sliders extends Model
{
    use HasFactory;
    protected $fillable = [
        'location',
        'section',
        'images',
        'alt',
        'title',
        'subtitle',
        'status',
    ];
}
