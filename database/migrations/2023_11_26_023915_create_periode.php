<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('periode_start');
            $table->date('periode_end');
            $table->date('prodi_start')->nullable();
            $table->date('prodi_end')->nullable();
            $table->date('auditor_start')->nullable();
            $table->date('auditor_end')->nullable();
            $table->date('revisi_start')->nullable();
            $table->date('revisi_end')->nullable();
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
        Schema::dropIfExists('periode');
    }
}
