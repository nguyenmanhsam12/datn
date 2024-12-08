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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable();

            // Thêm khóa ngoại với ON DELETE SET NULL
            $table->foreign('category_id')
                  ->references('id')
                  ->on('category')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
           // Xóa khóa ngoại và cột category_id
           $table->dropForeign(['category_id']);
           $table->dropColumn('category_id');
        });
    }
};
