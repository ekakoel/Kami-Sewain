<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageProperty extends Model
{
    use HasFactory;
    protected $fillable = [
        'page',
        'slider_title',
        'slider_caption',
    ];
}
