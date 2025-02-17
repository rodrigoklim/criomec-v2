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
    Schema::create('product_logs', function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->uuid('user_id');
      $table->uuid('product_id');
      $table->string('action');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('product_logs');
  }
};
