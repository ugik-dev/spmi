<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriteriaTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('criteria', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('code')->unique();
      $table->unsignedBigInteger('level')->default(1);
      $table->unsignedBigInteger('parent_id')->nullable();
      $table->timestamps();

      // Define the foreign key constraint
      $table->foreign('parent_id')
        ->references('id')
        ->on('criteria')
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
    Schema::dropIfExists('criteria');
  }
}
