<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *       1 - anticipated ->  / account needed
   *       2 - cashPay
   *               21 - money
   *               22 - check
   *               23 - debit card
   *               24 - credit card
   *       3 - termPayment
   *               31 - bankSlip       -> term needed
   *               32 - check          -> term needed
   *               33 - bankTransfer   -> term and account needed
   *               34 - monthlyPayment -> close date and pay date needed
   *               35 - governmentSell -> contract, term and account needed
   */
  public function up(): void
  {
    Schema::create('customer_accounts', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->timestamps();
      $table->uuid('customer_id');
      $table->boolean('is_active')->default(true);
      $table->integer('payment_method');
      $table->boolean('emit_nf')->default(false);
      $table->boolean('sales_commission')->default(false);
      $table->string('contract')->nullable();
      $table->string('bank_account')->nullable();
      $table->integer('close_date')->nullable();
      $table->integer('payment_date')->nullable();
      $table->string('term')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('customer_accounts');
  }
};
