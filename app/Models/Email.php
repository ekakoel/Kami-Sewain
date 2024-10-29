<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Email extends Model
{
    use HasFactory;
    protected  $fillable = [
        'name',
        'subject',
        'email',
        'message',
        'user_id',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
