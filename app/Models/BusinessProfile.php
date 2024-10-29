<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'logo',
        'logo_alt',
        'business_name',
        'description',
        'vision',
        'mission',
        'caption',
        'address',
        'map',
        'phone_number',
        'email',
        'website',
    ];
}
