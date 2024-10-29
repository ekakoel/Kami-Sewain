<?php

namespace App\Models;

use App\Models\Orders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderReceipt extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'receipt_image',
        'payment_date',
        'note',
        'amount',
        'status',
    ];
    public function order()
    {
        return $this->belongsTo(Orders::class,'order_id');
    }
}
