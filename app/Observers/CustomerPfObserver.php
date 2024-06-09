<?php

namespace App\Observers;

use App\Models\Customer;
use App\Models\CustomerPf;

class CustomerPfObserver
{
    /**
     * Handle the CustomerPf "created" event.
     */
    public function created(CustomerPf $customerPf): void
    {
        $data = array_merge(['status' => 'draft'], $customerPf->toArray());
        Customer::create($data);
    }

    /**
     * Handle the CustomerPf "updated" event.
     */
    public function updated(CustomerPf $customerPf): void
    {
        //
    }

    /**
     * Handle the CustomerPf "deleted" event.
     */
    public function deleted(CustomerPf $customerPf): void
    {
        //
    }

    /**
     * Handle the CustomerPf "restored" event.
     */
    public function restored(CustomerPf $customerPf): void
    {
        //
    }

    /**
     * Handle the CustomerPf "force deleted" event.
     */
    public function forceDeleted(CustomerPf $customerPf): void
    {
        //
    }
}
