<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'Chairs',
                'description' => 'Create a special atmosphere on your big day with our elegant wedding chairs. Designed with meticulous attention to detail, these chairs offer the perfect blend of comfort and style. Available in various colors and designs, from vintage-inspired pieces to modern minimalist styles, they are sure to complement your event theme.',
                'icon' => 'chair.png',
            ],
            [
                'name' => 'Arch',
                'description' => 'Transform your wedding venue into a romantic paradise with our stunning wedding arch. This beautifully crafted arch serves as the perfect backdrop for your vows, enhancing the aesthetic of your special day. Whether you prefer a classic, rustic, or modern design, our wedding arch can be customized to fit your theme.',
                'icon' => 'arch_pergola.png',
            ],
            [
                'name' => 'Tables',
                'description' => 'Elevate your wedding reception with our elegant wedding tables, designed to provide both style and functionality for your special day. Our tables are perfect for dining, decorating, or creating a stunning display for your cake and gifts. Available in various sizes and styles, they can be customized to suit any wedding theme.',
                'icon' => 'table.png',
            ],
            [
                'name' => 'Decoration',
                'description' => 'Transform your wedding venue into a breathtaking celebration with our exquisite wedding decorations. From enchanting centerpieces to stunning backdrops, our diverse range of decor options will help you create the perfect atmosphere for your special day. Whether your style is classic, modern, or bohemian, we have the perfect pieces to enhance your wedding theme.',
                'icon' => 'decoration.png',
            ],
            [
                'name' => 'lighting',
                'description' => "Illuminate your special day with our enchanting wedding lighting solutions. Designed to create the perfect ambiance, our lighting options enhance the beauty of your venue and add a touch of magic to your celebration. Whether you're planning an intimate gathering or a grand affair, we have the ideal lighting to suit your needs.",
                'icon' => 'lighting.png',
            ],
            [
                'name' => 'Plate',
                'description' => "Enhance your dining experience with our elegant wedding plates, designed to add a touch of sophistication to your special day. Available in a variety of styles and materials, our plates are perfect for serving your exquisite menu and complementing your overall wedding theme.",
                'icon' => 'plate.png',
            ],
            [
                'name' => 'Glasses',
                'description' => "Elevate your toast and dining experience with our stylish wedding glasses, designed to add elegance to your special day. Perfect for serving champagne, wine, or cocktails, our selection of glasses will complement your wedding theme and enhance the overall aesthetic of your table settings.",
                'icon' => 'glasses.png',
            ],
            [
                'name' => 'Cushion',
                'description' => "Enhance the comfort and style of your wedding seating with our elegant wedding cushions. Perfect for adding a pop of color and sophistication to your decor, our cushions provide both comfort for your guests and a beautiful touch to your venue.",
                'icon' => 'cushion.png',
            ],
        ]);
    }
}
