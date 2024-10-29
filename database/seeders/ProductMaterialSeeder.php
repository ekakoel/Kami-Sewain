<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductMaterialSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_materials')->insert([
            [
                'name' => 'Cotton',
            ],
            [
                'name' => 'Plastic',
            ],
            [
                'name' => 'Metal',
            ],
            [
                'name' => 'Wood',
            ],
            [
                'name' => 'Acrylic',
            ],
            [
                'name' => 'Ceramic',
            ],
            [
                'name' => 'Rubber',
            ],
            [
                'name' => 'Paper',
            ],
            [
                'name' => 'Polyester',
            ],
            [
                'name' => 'Glass',
            ],
            [
                'name' => 'Resin',
            ],
        ]);
    }
}
