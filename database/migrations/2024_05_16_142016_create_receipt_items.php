<?php

use App\Models\Receipt;
use App\Models\ReceiptData;
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
        Schema::create('receipt_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Receipt::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            // $table->foreignIdFor(User::class)
            //     ->constrained()
            //     ->onUpdate('cascade')
            //     ->onDelete('cascade');
            $table->unsignedBigInteger('rd_id')->nullable();
            $table->foreign('rd_id')
                ->references('id')
                ->on('receipt_data')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('bi_detail')->nullable();
            $table->foreign('bi_detail')
                ->references('id')
                ->on('budget_implementation_details')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('amount')->default(0);
            $table->string('rinc')->nullable();
            $table->string('desc')->nullable();
            $table->unique(['rd_id', 'receipt_id', 'bi_detail']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipt_items');
    }
};
