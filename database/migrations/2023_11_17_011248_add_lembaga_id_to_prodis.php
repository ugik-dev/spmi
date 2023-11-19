<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLembagaIdToProdis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prodis', function (Blueprint $table) {
            $table->unsignedBigInteger('lembaga_id')->default('1');
            $table->foreign('lembaga_id')
                ->references('id')
                ->on('lembaga')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prodis', function (Blueprint $table) {
            //
        });
    }
}
