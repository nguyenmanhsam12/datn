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
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // ID bài viết
            $table->string('title'); // Tiêu đề chính
            $table->string('subtitle')->nullable(); // Tiêu đề phụ
            $table->string('slug')->unique(); // Đường dẫn thân thiện (slug)
            $table->text('content'); // Nội dung chính
            $table->text('secondary_content')->nullable(); // Nội dung phụ
            $table->string('thumbnail')->nullable(); // Ảnh đại diện
            $table->string('secondary_image')->nullable(); // Ảnh phụ
            $table->unsignedBigInteger('author_id'); // ID người đăng bài (liên kết tới bảng users)
            $table->timestamps(); // Thời gian tạo và cập nhật

            // Thiết lập khoá ngoại cho author_id
            // $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
