<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
  use HasFactory, UuidTrait;

  protected $fillable = [
      'customer_id',
      'street',
      'number',
      'complement',
      'district',
      'zip',
      'city',
      'state',
      'city_code',
  ];

  protected $appends = ['formatted_address'];

  public function customer()
  {
    return $this->belongsTo(Customer::class, 'id');
  }

  public function getFormattedAddressAttribute()
  {
    return "{$this->street}, {$this->number} - {$this->district}, {$this->city} - {$this->state}, {$this->zip}";
  }
}
