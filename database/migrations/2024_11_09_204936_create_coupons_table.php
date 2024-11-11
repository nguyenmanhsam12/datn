<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Mã giảm giá
            $table->enum('discount_type', ['percentage', 'fixed']); // Loại giảm giá
            $table->decimal('discount_value', 10, 2); // Giá trị giảm giá
            $table->decimal('minimum_order_value', 10, 2); // Giá trị tối thiểu của đơn hàng
            $table->dateTime('end_date'); // Ngày hết hạn
            $table->enum('status', ['active', 'expired'])->default('active'); // Trạng thái
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
