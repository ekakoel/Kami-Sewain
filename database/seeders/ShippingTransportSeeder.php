<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShippingTransportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('shipping_transports')->insert([
            [
                'name' => 'Transport 1',
                'type' => 'Truck',
                'brand' => 'Mercedes',
                'capacity' => 5000,
                'no_polisi' => 'B1234ABC',
                'status' => 'available',
            ],
            [
                'name' => 'Transport 2',
                'type' => 'Van',
                'brand' => 'Toyota',
                'capacity' => 3000,
                'no_polisi' => 'D5678XYZ',
                'status' => 'available',
            ],
            [
                'name' => 'Transport 3',
                'type' => 'Pickup',
                'brand' => 'Daihatsu',
                'capacity' => 1700,
                'no_polisi' => 'F9101MNO',
                'status' => 'available',
            ],
            [
                'name' => 'Transport 4',
                'type' => 'Truck',
                'brand' => 'Hino',
                'capacity' => 6000,
                'no_polisi' => 'G2345PQR',
                'status' => 'available',
            ],
            [
                'name' => 'Transport 5',
                'type' => 'Pickup',
                'brand' => 'Ford',
                'capacity' => 1500,
                'no_polisi' => 'H6789STU',
                'status' => 'available',
            ],
        ]);

    }
}
