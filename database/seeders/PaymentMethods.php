<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethods extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_methods')->insert([
            ['name' => 'Thanh toán khi nhận hàng'],
            ['name' => 'Chuyển khoản ngân hàng'],
            ['name' => 'Ví điện tử momo'],
        ]);
    }
}
