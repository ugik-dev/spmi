<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStudyProgramToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add a foreign key column
            $table->unsignedBigInteger('study_program_id')->nullable();

            // Add the foreign key constraint
            $table->foreign('study_program_id')->references('id')->on('study_programs')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['study_program_id']);

            // Drop the column
            $table->dropColumn('study_program_id');
        });
    }
}
