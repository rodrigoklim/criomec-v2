<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use App\Observers\CustomerPfObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([CustomerPfObserver::class])]
class CustomerPf extends Model
{
  use HasFactory, UuidTrait;

  protected $fillable = [
      'tenant_id',
      'name',
      'document',
      'email',
      'parent_id',
      'company_name',
      'main_activity',
      'withNF',
  ];

  protected $appends = [
      'type',
  ];

  public function tenant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(User::class, 'tenant_id', 'id');
  }

  public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(CustomerPj::class, 'parent_id');
  }

  public function customer()
  {
    return $this->belongsTo(Customer::class, 'id');
  }

  public function contacts()
  {
    return $this->hasMany(CustomerContact::class, 'customer_id');
  }

  public function address()
  {
    return $this->hasMany(CustomerAddress::class, 'customer_id');
  }

  public function payment()
  {
    return $this->hasOne(CustomerPayment::class, 'customer_id');
  }

  public function getTypeAttribute()
  {
    return 'pf';
  }
}
