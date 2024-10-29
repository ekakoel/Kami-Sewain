<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('blog_categories')->insert([
            [
                'name' => 'Wedding',
                'slug' => 'wedding',
            ],
            [
                'name' => 'Event',
                'slug' => 'event',
            ],
            [
                'name' => 'Business',
                'slug' => 'business',
            ],
            [
                'name' => 'Social',
                'slug' => 'social',
            ],
            [
                'name' => 'Entertainment',
                'slug' => 'entertainment',
            ],
            [
                'name' => 'Sport',
                'slug' => 'sport',
            ],
            [
                'name' => 'Education',
                'slug' => 'Education',
            ],
            [
                'name' => 'Religion',
                'slug' => 'religion',
            ],
            [
                'name' => 'Family',
                'slug' => 'family',
            ],
        ]);
    }
}
