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
        Schema::create('pagu_lembagas', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->bigInteger('nominal')->default(0);
            $table->timestamps();
            $table->unique(['year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagu_lembagas');
    }
};
