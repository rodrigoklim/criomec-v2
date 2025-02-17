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
    Schema::create('product_units', function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->uuid('product_id');
      $table->enum('unit', ['liters', 'cubic_meters', 'units', 'kilograms', 'recharge'])->default('liters');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('product_units');
  }
};
