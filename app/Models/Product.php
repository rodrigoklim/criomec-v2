<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  use HasFactory, UuidTrait;

  protected $fillable = [
      'tenant_id',
      'name',
      'csosn',
      'cest',
      'ncm',
      'sku',
      'is_active',
      'operation',
  ];

  public function units()
  {
    return $this->hasMany(ProductUnit::class);
  }

  public function logs()
  {
    return $this->hasMany(ProductLog::class);
  }
}
