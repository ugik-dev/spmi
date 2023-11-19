<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFacultyToStudyProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('study_programs', function (Blueprint $table) {
            // Add a foreign key column
            $table->unsignedBigInteger('faculty_id')->nullable();

            // Add the foreign key constraint
            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('study_programs', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['faculty_id']);

            // Drop the column
            $table->dropColumn('faculty_id');
        });
    }
}
