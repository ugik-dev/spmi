<?php

use App\Models\IKSK;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PerformanceIndicator;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->unsignedBigInteger('iksk_id')->nullable();
            $table->foreign('iksk_id')
                ->references('id')
                ->on('iksks')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedInteger('performance_indicator_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->unsignedInteger('performance_indicator_id')->nullable(false)->change();
        });
    }
};
