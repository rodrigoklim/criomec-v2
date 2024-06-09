<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerContact extends Model
{
  use HasFactory, UuidTrait;

  protected $fillable = [
      'customer_id',
      'name',
      'email',
      'phone',
      'position',
  ];

  public function customer()
  {
    return $this->belongsTo(Customer::class);
  }

  public function customerPf()
  {
    return $this->belongsTo(CustomerPf::class);
  }

  public function customerPj()
  {
    return $this->belongsTo(CustomerPj::class);
  }
}
