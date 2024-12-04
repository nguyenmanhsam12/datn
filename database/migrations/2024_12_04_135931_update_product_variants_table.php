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
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('weight');
            // Thêm các cột mới: chiều dài, chiều rộng, chiều cao
            $table->float('length');
            $table->float('width');
            $table->float('height');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            // Nếu rollback, ta cần thêm lại cột weight
            $table->float('weight');

            // Xóa các cột chiều dài, chiều rộng, chiều cao
            $table->dropColumn(['length', 'width', 'height']);
        });
    }
};
