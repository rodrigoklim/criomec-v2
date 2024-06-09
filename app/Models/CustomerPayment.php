<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
  use HasFactory, UuidTrait;

  protected $fillable = [
      'type',
      'parameters',
      'bank_account',
      'contract_number',
      'commitment_number',
      'installments',
      'due_date',
      'customer_id',
  ];
}
