<?php

use App\Models\WorkUnit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->unsignedBigInteger('work_unit_id')->nullable();
            $table->foreign('work_unit_id')
                ->references('id')
                ->on('work_units')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        DB::table('receipts')
            ->join('users', 'users.id', '=', 'receipts.user_entry')
            ->join('employees', 'employees.user_id', '=', 'users.id')
            ->update([
                'receipts.work_unit_id' => DB::raw('employees.work_unit_id')
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
        });
    }
};
