<?php

namespace App\Models;

use App\Models\Products;
use App\Models\Shippings;
use App\Models\BankAccount;
use App\Models\OrderProduct;
use App\Models\OrderReceipt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orders extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_no',
        'user_id',
        'bank_id',
        'rental_start_date',
        'rental_end_date',
        'rental_duration',
        'total',
        'total_price',
        'discount_percent',
        'discount_amount',
        'balance',
        'payment_duedate',
        'payment_status',
        'payment_method',
        'status',
    ];
    public function shipping()
    {
        return $this->hasOne(Shippings::class,'order_id');
    }
    public function bank()
    {
        return $this->belongsTo(BankAccount::class,'bank_id');
    }
    public function receipts()
    {
        return $this->hasMany(OrderReceipt::class,'order_id');
    }
    public function products()
    {
        return $this->belongsToMany(Products::class, 'order_products')
                    ->withPivot('quantity', 'price','total_price')
                    ->withTimestamps();
    }
}
