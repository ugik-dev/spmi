<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('study_program_id');
            $table->unsignedBigInteger('periode_id');
            $table->unsignedBigInteger('l1_id');
            $table->unsignedBigInteger('l2_id')->nullable();
            $table->unsignedBigInteger('l3_id')->nullable();
            $table->unsignedBigInteger('l4_id')->nullable();
            $table->unsignedBigInteger('indikator_id')->nullable();


            $table->decimal('bobot', 3, 2, true)->nullable();
            $table->decimal('score_berkas', 3, 2, true)->nullable();
            $table->decimal('score_hitung', 4, 2, true)->nullable();
            $table->bigInteger('count_berkas')->nullable();
            $table->decimal('min_akreditasi', 3, 2, true)->nullable()->default(0.00);
            $table->enum('status_akreditasi', ['F', 'Y', 'N'])->default('F')->nullable();
            $table->decimal('min_unggul', 3, 2, true)->nullable()->default(0.00);
            $table->enum('status_unggul', ['F', 'Y', 'N'])->default('F')->nullable();
            $table->decimal('min_baik', 3, 2, true)->nullable()->default(0.00);
            $table->enum('status_baik', ['F', 'Y', 'N'])->default('F')->nullable();
            $table->text('ket_auditor', 255)->nullable();
            $table->decimal('score_auditor', 3, 2, true)->nullable()->default(0.00);
            $table->timestamps();

            $table->foreign('study_program_id')->references('id')->on('study_programs')->onDelete('restrict');
            $table->foreign('periode_id')->references('id')->on('periodes')->onDelete('restrict');
            $table->foreign('l1_id')->references('id')->on('kriteria')->onDelete('restrict');
            $table->foreign('l2_id')->references('id')->on('kriteria')->onDelete('restrict');
            $table->foreign('l3_id')->references('id')->on('kriteria')->onDelete('restrict');
            $table->foreign('l4_id')->references('id')->on('kriteria')->onDelete('restrict');
            $table->foreign('indikator_id')->references('id')->on('indikators')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elements');
    }
}
