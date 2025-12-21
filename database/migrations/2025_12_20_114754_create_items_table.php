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
        Schema::create('item', function (Blueprint $table) {
    $table->id('item_id');
    $table->foreignId('category_id')->constrained('categories','id');
    $table->foreignId('unit_id')->constrained('units', 'id');
    // $table->integer('detailorder_id');
    $table->foreignId('detailorder_id')->constrained('order_detail','detailorder_id');
    // $table->integer('location_id');
    $table->foreignId('location_id')->constrained('storage_location','location_id');
    // $table->integer('user_id');
     $table->foreignId('user_id')->constrained('users','id');
    $table->text('item_name')->nullable();
    $table->decimal('reorder_level',8,0)->nullable();
    $table->timestamp('exp_date')->nullable();
    $table->integer('item_quantity')->nullable();
    $table->timestamp('item_date_add')->nullable();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
