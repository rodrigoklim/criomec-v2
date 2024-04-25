<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
  use HasFactory, UuidTrait;

  protected $fillable = [
      'name',
      'slug',
      'stripe_plan',
      'price',
      'description',
  ];

  protected function price(): Attribute
  {
    return Attribute::make(
        get: fn(string $value) => number_format(($value / 100), 2, '.', ''),
        set: fn(string $value) => $value,
    );
  }
}
