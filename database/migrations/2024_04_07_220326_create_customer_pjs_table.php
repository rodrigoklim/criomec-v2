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
    Schema::create('customer_pjs', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->timestamps();
      $table->string('tenant_id');
      $table->uuid('parent_id')->nullable();
      $table->string('document');
      $table->string('ie')->nullable();
      $table->string('corporate_name');
      $table->string('company_name')->nullable();
      $table->string('main_activity');
      $table->string('email');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('customer_pjs');
  }
};
