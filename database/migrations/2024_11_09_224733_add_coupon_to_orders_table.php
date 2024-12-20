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
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('coupon_id')->nullable()->after('payment_method_id');
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('set null');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('coupon_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['coupon_id']); // Xóa khóa ngoại
            $table->dropColumn(['coupon_id', 'discount_amount']);
        });
    }
};
