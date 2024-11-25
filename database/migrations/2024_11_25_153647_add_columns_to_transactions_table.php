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
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('amount', 15, 2)->after('payment_date')->nullable(); // Số tiền giao dịch
            $table->string('bank_code', 50)->after('amount')->nullable(); // Mã ngân hàng
            $table->text('description')->after('bank_code')->nullable(); // Mô tả giao dịch
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['amount','bank_code','description']);
        });
    }
};
