<?php

namespace App\Listeners;

use App\Exceptions\ExceptionManager;
use App\Models\Subscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
  /**
   * Create the event listener.
   */
  public function __construct()
  {
    //
  }

  /**
   * Handle the event.
   */
  public function handle(WebhookReceived $event): void
  {
    try {
      if ($event->payload['type'] === "invoice.payment_succeeded") {
        $session = $event->payload['data']['object'];
        $user = User::whereEmail($session['customer_email'])->first();

        Subscription::create([
            'stripe_id' => $session['subscription'],
            'stripe_status' => $session['status'],
            'stripe_price' => $session['lines']['data'][0]['price']['id'],
            'quantity' => 1,
            'user_id' => $session['client_reference_id'],
        ]);
      }
    } catch (\Exception $e) {
      ExceptionManager::handleException($e, func_get_args(), 'handle');
    }
  }
}
