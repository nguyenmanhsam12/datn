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
        Schema::table('complainst', function (Blueprint $table) {
            $table->timestamp('order_date')->nullable();  // Có thể null nếu không bắt buộc
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complainst', function (Blueprint $table) {
            $table->dropColumn('order_date');
        });
    }
};
