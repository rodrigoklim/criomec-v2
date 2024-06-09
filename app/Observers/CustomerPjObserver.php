<?php

namespace App\Observers;

use App\Models\Customer;
use App\Models\CustomerPj;

class CustomerPjObserver
{
    /**
     * Handle the CustomerPj "created" event.
     */
    public function created(CustomerPj $customerPj): void
    {
        $data = array_merge(['status' => 'draft'], $customerPj->toArray());
        Customer::create($data);
    }

    /**
     * Handle the CustomerPj "updated" event.
     */
    public function updated(CustomerPj $customerPj): void
    {
        //
    }

    /**
     * Handle the CustomerPj "deleted" event.
     */
    public function deleted(CustomerPj $customerPj): void
    {
        //
    }

    /**
     * Handle the CustomerPj "restored" event.
     */
    public function restored(CustomerPj $customerPj): void
    {
        //
    }

    /**
     * Handle the CustomerPj "force deleted" event.
     */
    public function forceDeleted(CustomerPj $customerPj): void
    {
        //
    }
}
