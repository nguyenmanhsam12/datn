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
        Schema::table('order_address', function (Blueprint $table) {
            $table->string('recipient_name')->nullable(); // Thêm cột tên người nhận
            $table->string('recipient_email')->nullable(); // Thêm cột email người nhận
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_address', function (Blueprint $table) {
            $table->dropColumn('recipient_name'); // Xóa cột tên người nhận
            $table->dropColumn('recipient_email'); // Xóa cột email người nhận
        });
    }
};
