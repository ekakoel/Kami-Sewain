<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SocialLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('social_links')->insert([
            [
                'platform_name' => 'Facebook',
                'icon_class' => 'facebook.png',
                'url' => 'https://www.facebook.com/people/Kami-Sewain/100079760864856/?mibextid=ZbWKwL',
                'type' => 'Social Media',
            ],
            [
                'platform_name' => 'Instagram',
                'icon_class' => 'instagram.png',
                'url' => 'https://www.instagram.com/kamisewain/',
                'type' => 'Social Media',
            ],
            [
                'platform_name' => 'Wechat',
                'icon_class' => 'wechat.png',
                'url' => 'weixin://dl/chat?kamisewain',
                'type' => 'Chat',
            ],
            [
                'platform_name' => 'Xiaohongshu',
                'icon_class' => 'xiaohongshu.png',
                'url' => 'https://tinyurl.com/kamisewainxiaohongshu',
                'type' => 'Marketplace',
            ],
            [
                'platform_name' => 'Pinterest',
                'icon_class' => 'pinterest.png',
                'url' => 'https://id.pinterest.com/kamisewain/',
                'type' => 'Social Media',
            ],
            [
                'platform_name' => 'TikTok',
                'icon_class' => 'tiktok.png',
                'url' => 'https://www.tiktok.com/@kamisewain',
                'type' => 'Social Media',
            ],
            [
                'platform_name' => 'WhatsApp',
                'icon_class' => 'whatsapp.png',
                'url' => 'https://tinyurl.com/kamisewainwhatsapp',
                'type' => 'Chat',
            ],
            [
                'platform_name' => 'Youtube',
                'icon_class' => 'youtube.png',
                'url' => 'https://www.youtube.com/@KamiSewain',
                'type' => 'Social Media',
            ],
            [
                'platform_name' => 'Toko Pedia',
                'icon_class' => 'tokopedia.png',
                'url' => 'https://www.tokopedia.com/kamisewain',
                'type' => 'Marketplace',
            ],
            [
                'platform_name' => 'Shopee',
                'icon_class' => 'shopee.png',
                'url' => 'https://id.shp.ee/RxKcA6X',
                'type' => 'Marketplace',
            ],
            [
                'platform_name' => 'Bride Story',
                'icon_class' => 'bridestory.png',
                'url' => 'https://www.bridestory.com/id/kami-sewain',
                'type' => 'Marketplace',
            ],
        ]);
    }
}
