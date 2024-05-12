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
        Schema::table('withdrawal_plans', function (Blueprint $table) {
            // $table->dropColumn('year');
            $table->dropUnique(['year', 'month', 'activity_id']); // Hapus indeks unik yang berisi kolom year
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('withdrawal_plans', function (Blueprint $table) {
            // $table->year('year');
            $table->unique(['year', 'month', 'activity_id']); // 
        });
    }
};
