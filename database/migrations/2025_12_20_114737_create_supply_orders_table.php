<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\PurchaseStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
    {
        Schema::create('supply_order', function (Blueprint $table) {
    $table->id('supply_order_id');
    $table->foreignId('supplier_id')->constrained('suppliers','supplier_id');
    $table->timestamp('order_date')->nullable();
    $table->text('item_ordered')->nullable();
    $table->integer('order_quantity')->nullable();
    $table->decimal('item_price',10,2)->nullable();
    $table->decimal('total_cost',10,2)->nullable();
    $table->text('ordered_by')->nullable();
    $table->text('supply_order_notes')->nullable();
    
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supply_orders');
    }
};
