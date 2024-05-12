<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\RenstraMission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('renstra_indicators', function (Blueprint $table) {
            $table->unsignedInteger('renstra_mission_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('renstra_indicators', function (Blueprint $table) {
            $table->unsignedInteger('renstra_mission_id')->nullable(false)->change();
        });
    }
};
