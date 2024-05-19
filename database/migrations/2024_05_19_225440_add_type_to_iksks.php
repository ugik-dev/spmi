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
        Schema::table('iksks', function (Blueprint $table) {
            $table->decimal('value_end', 7, 4)->nullable();
            $table->enum('type', [
                'decimal', 'range', 'persen'
            ])->default('decimal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iksks', function (Blueprint $table) {
            //
        });
    }
};
