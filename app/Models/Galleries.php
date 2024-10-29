<?php

namespace App\Models;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Galleries extends Model
{
    use HasFactory;

    protected $fillable = [
        'categories_id',
        'image',
        'alt',
        'status',
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Categories::class, 'categories_id');
    }

    // Optional: Accessor for image URL
    public function getImageUrlAttribute(): string
    {
        return asset('storage/images/galleries/' . $this->image);
    }
}
