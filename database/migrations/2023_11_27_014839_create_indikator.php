<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndikator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indikators', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('degree_id');
            // $table->foreign('degree_id')
            //     ->references('id')
            //     ->on('degrees')
            //     ->onDelete('restrict');
            $table->text('dec');
            $table->decimal('bobot', 3, 2)->default(0.00);
            $table->unsignedBigInteger('l1_id');
            $table->unsignedBigInteger('l2_id')->nullable();
            $table->unsignedBigInteger('l3_id')->nullable();
            $table->unsignedBigInteger('l4_id')->nullable();
            $table->timestamps();

            $table->foreign('l1_id')->references('id')->on('kriteria')->onDelete('restrict');
            $table->foreign('l2_id')->references('id')->on('kriteria')->onDelete('restrict');
            $table->foreign('l3_id')->references('id')->on('kriteria')->onDelete('restrict');
            $table->foreign('l4_id')->references('id')->on('kriteria')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indikators');
    }
}
