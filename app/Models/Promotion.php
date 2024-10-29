<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promotion extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'promotion_code',
        'discount_percent',
        'discount_amount',
        'amount',
        'expired_date',
        'description',
        'status',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'promotion_holders')
                    ->withPivot('expired_date', 'status')
                    ->withTimestamps();
    }
   
    public function isClaimableByUser($userId)
    {
        // Hitung jumlah klaim yang telah dilakukan oleh user tertentu
        $claimedCount = $this->users()->wherePivot('user_id', $userId)->count();

        return $claimedCount < $this->amount;
    }
}
