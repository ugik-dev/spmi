<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeForeignKeyToKriteriaInElements2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('elements', function (Blueprint $table) {

            $table->foreign('l1_id')
                ->references('id')
                ->on('kriteria')
                ->onDelete('restrict');

            $table->foreign('l2_id')
                ->references('id')
                ->on('kriteria')
                ->onDelete('restrict');

            $table->foreign('l3_id')
                ->references('id')
                ->on('kriteria')
                ->onDelete('restrict');

            $table->foreign('l4_id')
                ->references('id')
                ->on('kriteria')
                ->onDelete('restrict');

            $table->foreign('indikator_id')
                ->references('id')
                ->on('indikators_lam')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('elements', function (Blueprint $table) {
            //
        });
    }
}
