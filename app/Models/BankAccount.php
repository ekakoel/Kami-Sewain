<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'icon',
        'name',
        'account_name',
        'account_number',
        'address',
        'city',
        'country',
        'postcode',
        'phone',
    ];
    public function bank()
    {
        return $this->hasMany(BankAccount::class,'bank_id');
    }
}
