<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatus extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_status')->insert([
            ['name' => 'Đang chờ xử lý'],
            ['name' => 'Đang xác nhận'],
            ['name' => 'Đang giao hàng'],
            ['name' => 'Đã giao hàng'],
            ['name' => 'Đã hủy'],
            ['name' => 'Trả hàng'],
            ['name' => 'Đã hoàn tất'],
        ]);
    }
}
