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
    Schema::create('customer_products', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->timestamps();
      $table->uuid('customer_id');
      $table->uuid('product_id');
      $table->integer('price');
      $table->integer('interval');
      $table->string('exact_day');
      $table->enum('unity', ['lts', 'm3']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('customer_products');
  }
};
