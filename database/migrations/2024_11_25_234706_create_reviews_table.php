<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); // Khóa chính tự động tăng
            $table->unsignedBigInteger('product_id')->nullable(); // ID sản phẩm
            $table->unsignedBigInteger('user_id'); // ID người dùng
            $table->unsignedBigInteger('order_id')->nullable(); // ID đơn hàng (nullable vì không phải lúc nào cũng có)
            $table->text('message')->nullable(); // Nội dung bình luận
            $table->tinyInteger('rating')->nullable()->default(0); // Số sao đánh giá (0 là chưa đánh giá)
            $table->string('image')->nullable(); // Hình ảnh đính kèm (nếu có)
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
