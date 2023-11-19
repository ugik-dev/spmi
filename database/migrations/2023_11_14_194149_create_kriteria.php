<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKriteria extends Migration
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
            $table->string('kode');

            $table->unsignedBigInteger('level');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')
                ->references('id')
                ->on('kriteria')
                ->onDelete('cascade');

            $table->unsignedBigInteger('lembaga_id')->nullable();
            $table->foreign('lembaga_id')
                ->references('id')
                ->on('lembaga')
                ->onDelete('cascade');

            $table->unsignedBigInteger('jenjang_id')->nullable();
            $table->foreign('jenjang_id')
                ->references('id')
                ->on('jenjangs')
                ->onDelete('cascade');

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
        Schema::table('kriteria', function (Blueprint $table) {
            //
        });
    }
}
