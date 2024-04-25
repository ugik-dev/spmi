<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Dipa;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('budget_implementations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            // $table->foreignIdFor(Dipa::class)->onDelete('cascade');
            // $table->foreignIdFor(WorkUnit::class)
            //     ->nullable()
            //     ->constrained()
            //     ->onUpdate('cascade')
            //     ->onDelete('cascade');
            $table->integer('revision')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_implementations');
    }
};
