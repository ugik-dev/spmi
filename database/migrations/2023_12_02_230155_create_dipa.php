<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\WorkUnit;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dipas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(WorkUnit::class)->onDelete('cascade');
            $table->string('year');
            $table->enum('status', [
                'draft',
                'wait-kp', 'reject-kp',
                'wait-ppk', 'reject-ppk',
                'wait-spi', 'reject-spi',
                'wait-perencanaan', 'reject-perencanaan',
                'accept', 'reject'
            ])->default('draft');
            $table->unsignedBigInteger('head_id')->nullable();
            $table->foreign('head_id')
                ->references('id')
                ->on('dipas')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignIdFor(User::class)
                ->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('spi_id')->nullable();
            $table->foreign('spi_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('ppk_id')->nullable();
            $table->foreign('ppk_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('revision')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dipas');
    }
};
