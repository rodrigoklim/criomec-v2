<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  use HasFactory;

  protected $fillable = [
      'id',
      'type',
      'tenant_id',
      'status',
  ];

  public function customerData(): \Illuminate\Database\Eloquent\Relations\HasOne
  {
    $customerPf = $this->hasOne(CustomerPf::class, 'id', 'id')->first();

    if ($customerPf) {
      return $this->hasOne(CustomerPf::class, 'id', 'id');
    }

    return $this->hasOne(CustomerPj::class, 'id', 'id');
  }
}
