<?php

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
        Schema::create('stock_transaction', function (Blueprint $table) {
    $table->id('transaction_id');
    // $table->integer('item_id');
     $table->foreignId('item_id')->constrained('item','item_id');
    $table->foreignId('detailorder_id')
      ->nullable()
      ->constrained('order_detail', 'detailorder_id')->nullOnDelete();;
    $table->text('transaction_type')->nullable();
    $table->decimal('quantity',8,0)->nullable();
    $table->dateTime('transaction_date')->nullable();
    $table->text('stock_transaction_notes')->nullable();
    
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
    }
};
