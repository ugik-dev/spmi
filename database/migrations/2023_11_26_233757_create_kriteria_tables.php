<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKriteriaTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kriteria', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');

            $table->unsignedBigInteger('level');
            $table->unsignedBigInteger('kriteria_id')->nullable();
            $table->foreign('kriteria_id')
                ->references('id')
                ->on('kriteria')
                ->onDelete('restrict');

            $table->unsignedBigInteger('institution_id')->nullable();
            $table->foreign('institution_id')
                ->references('id')
                ->on('institutions')
                ->onDelete('restrict');

            $table->unsignedBigInteger('degree_id')->nullable();
            $table->foreign('degree_id')
                ->references('id')
                ->on('degrees')
                ->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kriteria');
    }
}
