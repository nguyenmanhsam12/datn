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
        Schema::create('complainst', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');  // Khóa ngoại liên kết với đơn hàng
            $table->unsignedBigInteger('user_id');   // Khóa ngoại liên kết với người dùng
            $table->text('complaint_details');  // Chi tiết khiếu nại
            $table->enum('complaint_type', [
                'Hàng bị lỗi', 
                'Giao hàng muộn', 
                'Sản phẩm không đúng mô tả',
                'Thiếu hàng trong đơn', 
                'Hủy đơn hàng'
            ]);  // Loại khiếu nại
            $table->enum('status', ['Chờ xử lý', 'Giải quyết thành công']);  // Trạng thái khiếu nại
            $table->json('attachments')->nullable(); // Lưu danh sách ảnh dưới dạng JSON

            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');  // Liên kết với bảng đơn hàng
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');  // Liên kết với bảng người dùng
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complainst');
    }
};
