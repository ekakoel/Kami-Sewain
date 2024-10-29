<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bank_accounts')->insert([
            [
                'icon' => 'bank_abc.png',
                'name' => 'BANK ABC',
                'account_name' => 'User Name',
                'account_number' => '1234567890',
                'phone' => '08888888888',
                'address' => 'Jl. Bank Address',
                'city' => 'Denpasar',
                'country' => 'Indonesia',
                'postcode' => '888888',
            ],
            [
                'icon' => 'bank_def.png',
                'name' => 'BANK DEF',
                'account_name' => 'User Name',
                'account_number' => '1234567890',
                'phone' => '08888888888',
                'address' => 'Jl. Bank Address',
                'city' => 'Denpasar',
                'country' => 'Indonesia',
                'postcode' => '888888',
            ],
        ]);
    }
}
