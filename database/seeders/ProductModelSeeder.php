<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_models')->insert([
            [
                'name' => 'Classic',
                'slug' => 'classic',
            ],
            [
                'name' => 'Modern',
                'slug' => 'modern',
            ],
            [
                'name' => 'Minimalist',
                'slug' => 'minimalist',
            ],
            [
                'name' => 'Artistic',
                'slug' => 'artistic',
            ],
            [
                'name' => 'Vintage',
                'slug' => 'vintage',
            ],
            [
                'name' => 'Retro',
                'slug' => 'retro',
            ],
            [
                'name' => 'Industrial',
                'slug' => 'industrial',
            ],
            [
                'name' => 'Rustic',
                'slug' => 'rustic',
            ],
            [
                'name' => 'Bohemian',
                'slug' => 'bohemian',
            ],
            [
                'name' => 'Futuristic',
                'slug' => 'futuristic',
            ],
        ]);
    }
}
