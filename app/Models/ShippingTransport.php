<?php

namespace App\Models;

use App\Models\Shippings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingTransport extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'brand',
        'capacity',
        'no_polisi',
        'status',
    ];
    public function shippings()
    {
        return $this->belongsToMany(Shippings::class, 'shipping_transport_shipping', 'shipping_transport_id', 'shipping_id');
    }

}
