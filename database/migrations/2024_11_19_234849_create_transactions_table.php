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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');  // Liên kết với bảng orders
            $table->string('transaction_id');  // Mã giao dịch (ví dụ VNPay hoặc MoMo)
            $table->enum('status', ['pending', 'success', 'failed', 'canceled']);  // Trạng thái giao dịch
            $table->timestamp('payment_date')->nullable();  // Ngày thanh toán (nếu có)
            $table->timestamps();
            
            // Khóa ngoại liên kết với bảng orders
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
