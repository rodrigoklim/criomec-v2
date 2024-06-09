<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.export
   *
   * @return void
   */
  public function up(): void
  {
    Schema::create('customer_payments', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->timestamps();
      $table->string('customer_id');
      $table->enum('type', ['upfront', 'cash', 'installments']);
      $table->enum(
          'parameters', [
              'cash',
              'debit-card',
              'credit-card',
              'bank-slip',
              'check',
              'tender-payment',
              'bank-transfer',
              'monthly-closing',
          ]
      );
      $table->string('bank_account')->nullable();
      $table->string('contract_number')->nullable();
      $table->string('commitment_number')->nullable();
      $table->string('installments')->nullable();
      $table->date('due_date')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('customer_payments');
  }
};
