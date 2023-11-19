<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDegreeToStudyProgramTable extends Migration
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
            $table->unsignedBigInteger('degree_id')->nullable();

            // Add the foreign key constraint
            $table->foreign('degree_id')->references('id')->on('degrees')->onDelete('cascade');
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
            $table->dropForeign(['degree_id']);

            // Drop the column
            $table->dropColumn('degree_id');
        });
    }
}
