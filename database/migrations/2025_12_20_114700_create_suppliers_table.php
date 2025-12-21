<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\SupplierType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
              $table->id('supplier_id');
    $table->string('name')->nullable();
    $table->string('phone')->nullable();
    $table->string('address')->nullable();
    $table->string('shopname')->nullable();
    $table->string('photo')->nullable();
    $table->string('bank_name')->nullable();
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
