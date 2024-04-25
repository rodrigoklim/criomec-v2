<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionManager;
use App\Http\Requests\UpsertSubscriptionRequest;
use App\Models\Order;
use App\Models\Plan;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;

class SubscriptionsController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $plan = Plan::where('stripe_plan', $request->stripe_plan)->first();

    if (!$plan) {
      return;
    }
    $session = Session::create([
        'line_items' => [
            [
                'price_data' => [
                    'currency' => 'brl',
                    'product_data' => [
                        'name' => $plan->name,
                    ],
                    'unit_amount' => number_format($plan->price, 2, '', ''),
                ],
                'quantity' => 1,
            ],
        ],
        'mode' => 'payment',
        'success_url' => route('subscriptions.success') . '?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => route('profile.edit'),
    ]);

    \Illuminate\Support\Facades\Session::put('session_id', $session->id);
    $this->recordOrder($session->id, number_format($plan->price, 2, '', ''));

    return redirect($session->url);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(UpsertSubscriptionRequest $request)
  {
    $user = auth()->user();

    $user->createOrGetStripeCustomer();

    return $user->newSubscription($request->input('slug'), $request->input('stripe_plan'))->checkout()->redirect('/');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }

  public function success(Request $request)
  {
    $sessionId = $request->get('session_id');

    try {
      $session = \Stripe\Checkout\Session::retrieve($sessionId);

      if (!$session) {
        throw new \Exception('Session not found');
      }

      if ($session->customer) {
        $customer = \Stripe\Customer::retrieve($session->customer);
      }
      
      $order = Order::where('session_id', $session->id)->first();
      if (!$order) {
        throw new \Exception('Session not found');
      }

      if ($order->status === 'pending') {
        $order->status = 'paid';
        $order->save();
      }

      return redirect(route('profile.edit', ['from' => 'success']));
    } catch (\Exception $e) {
      return ExceptionManager::handleException($e, func_get_args(), 'subscription_error');
    }
  }

  private function recordOrder($session_id, $total_price, $status = 'pending')
  {
    Order::create([
        'session_id' => $session_id,
        'total_price' => $total_price,
        'status' => $status,
    ]);
  }
}
