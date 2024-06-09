<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use App\Observers\CustomerPjObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([CustomerPjObserver::class])]
class CustomerPj extends Model
{
  use HasFactory, UuidTrait;

  protected $fillable = [
      'tenant_id',
      'company_name',
      'email',
      'corporate_name',
      'document',
      'ie',
      'main_activity',
      'parent_id',
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

  public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(CustomerPj::class, 'parent_id');
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
    return 'pj';
  }
}
