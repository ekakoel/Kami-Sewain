<?php

namespace App\Models;

use App\Models\Orders;
use App\Models\ShippingTransport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shippings extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'courier_send',
        'courier_send_phone',
        'courier_take',
        'courier_take_phone',
        'recipient',
        'telephone',
        'address',
        'city',
        'postcode',
        'country',
        'delivery_date',
        'return_date',
        'product_location',
        'note_send',
        'note_take',
        'status',
    ];
    public function order()
    {
        return $this->belongsTo(Orders::class,'order_id');
    }
    public function shippingTransports()
    {
        return $this->belongsToMany(ShippingTransport::class, 'shipping_transport_shipping', 'shipping_id', 'shipping_transport_id');
    }
}
