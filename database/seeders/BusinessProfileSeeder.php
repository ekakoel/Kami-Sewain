<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BusinessProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('business_profiles')->insert([
            [
                'logo' => 'logo-kami-sewain-color.png',
                'logo_alt' => 'Logo Kami Sewain Color',
                'business_name' => 'Kami Sewain',
                'caption' => 'Bali Wedding & Event Rentals',
                'description' => "Kami Sewain - Bali Wedding & Event Rentals offers a wide range of premium rental items to create the perfect setting for your special day. From elegant tableware, vintage decor, and luxury seating to stunning lighting and unique event accessories, we have everything you need to bring your dream wedding or event to life. Whether you're planning an intimate gathering or a grand celebration, our high-quality rentals and professional service ensure a seamless and memorable experience. Serving clients across Bali, we specialize in weddings, private events, and corporate functions. Let us help you create unforgettable moments with our curated collection.",
                'vision' => "To become Bali's premier one-stop destination for wedding and event rentals, seamlessly blending innovative technology and personalized service to create unforgettable experiences for our customers.",
                'mission' => '<p><ol><li>Simplifying the rental process by implementing cutting-edge digital solutions that allow customers to select and customize items effortlessly, enhancing their shopping experience with real-time inventory and design consultations.</li><li>Providing exceptional service through on-site and online support, offering a complete range of rental items and additional services such as delivery, decoration, and technical teams, ensuring flawless execution of every event.</li><li>Transforming into a one-stop destination by continually expanding our range of rental products and event services, integrating technology that allows customers to select, pay, and manage their event needs in one seamless experience, from warehouse to event setup.</li><li>Building long-lasting relationships by focusing on customer satisfaction, ensuring that every event is tailor-made to the highest standard with our top-tier products and service teams.</li></ol></p>',
                'address' => 'Jl. Raya Sesetan Gg. Ikan Jangki 617e, Denpasar Selatan, Kota Denpasar, Bali 80222',
                'map' => 'https://maps.app.goo.gl/thtaotJcPxQMwNMt9',
                'phone_number' => '082266697879',
                'email' => 'kamisewain.bali@gmail.com',
                'website' => 'www.kamisewain.com',
            ],
        ]);
    }
}
