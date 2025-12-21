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
        Schema::create('supplying', function (Blueprint $table) {
    $table->foreignId('supplier_id')->constrained('suppliers','supplier_id');
    $table->foreignId('item_id')->constrained('item','item_id');
    // $table->integer('item_id');
    $table->primary(['supplier_id','item_id']);
 

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplyings');
    }
};
