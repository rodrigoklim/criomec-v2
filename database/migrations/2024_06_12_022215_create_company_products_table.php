<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('company_products', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->timestamps();
      $table->string('customer_id');
      $table->string('product_id');
      $table->integer('price');
      $table->enum('unit', ['liters', 'cubic_meters', 'units', 'kilograms', 'recharge'])->default('liters');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('company_products');
  }
};
