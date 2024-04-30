<?php

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Activity::class)->onDelete('cascade');
            $table->foreignIdFor(User::class)->onDelete('cascade');
            $table->string('description');
            $table->unique(['activity_id', 'user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_note');
    }
};
