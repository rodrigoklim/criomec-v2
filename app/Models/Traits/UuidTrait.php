<?php

namespace App\Models\Traits;

use Ramsey\Uuid\Uuid as Uuid;

trait UuidTrait
{
  protected static function boot(): void
  {
    parent::boot();
    static::creating(function ($model) {
      $model->{$model->getKeyName()} = (string) Uuid::uuid4();
    });
  }

  public function getIncrementing()
  {
    return false;
  }

  public function getKeyType()
  {
    return 'string';
  }
}
