<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductColorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_colors')->insert([
            [
                'name' => 'Black',
                'color_code' => '#000000',
            ],
            [
                'name' => 'White',
                'color_code' => '#ffffff',
            ],
            [
                'name' => 'Red',
                'color_code' => '#ff0000',
            ],
            [
                'name' => 'Green',
                'color_code' => '#008000',
            ],
            [
                'name' => 'Blue',
                'color_code' => '#0000ff',
            ],
            [
                'name' => 'Yellow',
                'color_code' => '#ffff00',
            ],
            [
                'name' => 'Purple',
                'color_code' => '#800080',
            ],
            [
                'name' => 'Orange',
                'color_code' => '#ffa500',
            ],
            [
                'name' => 'Pink',
                'color_code' => '#ffc0cb',
            ],
            [
                'name' => 'Brown',
                'color_code' => '#a52a2a',
            ],
            [
                'name' => 'Gray',
                'color_code' => '#808080',
            ],
            [
                'name' => 'Cyan',
                'color_code' => '#00ffff',
            ],
            [
                'name' => 'Magenta',
                'color_code' => '#ff00ff',
            ],
            [
                'name' => 'Lime',
                'color_code' => '#00ff00',
            ],
            [
                'name' => 'Olive',
                'color_code' => '#808000',
            ],
            [
                'name' => 'Navy',
                'color_code' => '#000080',
            ],
            [
                'name' => 'Teal',
                'color_code' => '#008080',
            ],
            [
                'name' => 'Maroon',
                'color_code' => '#800000',
            ],
            [
                'name' => 'Gold',
                'color_code' => '#ffd700',
            ],
            [
                'name' => 'Silver',
                'color_code' => '#c0c0c0',
            ],
            [
                'name' => 'Violet',
                'color_code' => '#ee82ee',
            ],
            [
                'name' => 'Indigo',
                'color_code' => '#4b0082',
            ],
            [
                'name' => 'Beige',
                'color_code' => '#f5f5dc',
            ],
            [
                'name' => 'Coral',
                'color_code' => '#ff7f50',
            ],
            [
                'name' => 'Khaki',
                'color_code' => '#f0e68c',
            ],
        ]);
    }
}
