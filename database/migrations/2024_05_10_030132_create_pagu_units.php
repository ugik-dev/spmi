<?php

use App\Models\PaguLembaga;
use App\Models\WorkUnit;
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
        Schema::create('pagu_units', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PaguLembaga::class)->onDelete('cascade');
            $table->foreignIdFor(WorkUnit::class)->onDelete('cascade');
            $table->bigInteger('nominal')->default(0);
            $table->timestamps();
            $table->unique(['pagu_lembaga_id', 'work_unit_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagu_units');
    }
};
