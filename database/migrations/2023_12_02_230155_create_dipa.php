<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\WorkUnit;

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
