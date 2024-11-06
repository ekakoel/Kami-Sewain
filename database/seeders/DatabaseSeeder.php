<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Admin;
use App\Models\BlogPost;
use App\Models\Products;
use App\Models\Categories;
use Illuminate\Database\Seeder;
use Database\Seeders\BankAccountSeeder;
use Database\Seeders\ProductColorSeeder;
use Database\Seeders\ShippingTransportSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Eka Koel',
            'telephone' => '1234567890',
            'email' => 'e-admin@balikamitour.com',
            'password' => '$2y$10$E1vptrCL.JXjaJAqUFr8TeYUYJCY56u5r1pyi4t046hhRVofS9pDq',
            'status' => 'Active',
        ]);
        Admin::factory()->create([
            'username'=>'eka',
            'fullname'=>'Eka Koel',
            'email'=>'e-admin@balikamitour.com',
            'password'=> '$2y$10$E1vptrCL.JXjaJAqUFr8TeYUYJCY56u5r1pyi4t046hhRVofS9pDq',
        ]);
        Admin::factory()->create([
            'username'=>'andrew',
            'fullname'=>'Andrew',
            'email'=>'admin@kamisewain.com',
            'password'=> '$2y$10$E1vptrCL.JXjaJAqUFr8TeYUYJCY56u5r1pyi4t046hhRVofS9pDq',
        ]);
        $this->call(BlogCategorySeeder::class);
        $this->call(BusinessProfileSeeder::class);
        $this->call(SocialLinkSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(ProductModelSeeder::class);
        $this->call(ProductColorSeeder::class);
        $this->call(ProductMaterialSeeder::class);
        $this->call(BankAccountSeeder::class);
        Products::factory(50)->create();
        BlogPost::factory(6)->create();
        $this->call(ShippingTransportSeeder::class);
    }
}
