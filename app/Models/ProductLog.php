<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLog extends Model
{
  use HasFactory;

  protected $fillable = [
      'product_id',
      'user_id',
      'action',
  ];

  protected function createdAt(): Attribute
  {
    return Attribute::make(
        get: fn(string $value) => Carbon::create($value)->format('d/m/Y')
    );
  }

  public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
