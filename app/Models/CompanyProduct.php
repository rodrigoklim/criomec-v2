<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProduct extends Model
{
  use HasFactory, UuidTrait;

  protected $fillable = [
      'customer_id',
      'product_id',
      'price',
      'units',
  ];
}
