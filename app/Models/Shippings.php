<?php

namespace App\Models;

use App\Models\Orders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shippings extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'recipient',
        'telephone',
        'address',
        'city',
        'postcode',
        'country',
        'delivery_date',
        'return_date',
        'status',
    ];
    public function order()
    {
        return $this->belongsTo(Orders::class,'order_id');
    }
}
