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
        Schema::table('receipt_items', function (Blueprint $table) {
            // $table->dropUnique(['rd_id', 'receipt_id', 'bi_detail']); // Hapus indeks unik yang berisi kolom year
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receipt_items', function (Blueprint $table) {
            // $table->unique(['rd_id', 'receipt_id', 'bi_detail']); // 
        });
    }
};
