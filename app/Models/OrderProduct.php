<?php

namespace App\Models;

use App\Models\Orders;
use App\Models\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'products_id',
        'orders_id',
        'quantity',
        'price',
        'total_price',
    ];
    public function order()
    {
        return $this->belongsTo(Orders::class,'orders_id');
    }
    public function product()
    {
        return $this->belongsTo(Products::class,'products_id');
    }
}
