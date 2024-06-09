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
    Schema::create('customer_addresses', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->timestamps();
      $table->string('customer_id');
      $table->string('street');
      $table->string('number')->nullable();
      $table->string('complement')->nullable();
      $table->string('district')->nullable();
      $table->string('zip');
      $table->string('city');
      $table->string('state');
      $table->string('city_code')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('customer_addresses');
  }
};
