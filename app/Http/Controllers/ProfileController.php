<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Subscription;

class ProfileController extends Controller
{
  /**
   * Display the user's profile form.
   */
  public function edit(Request $request, $from = null): Response
  {
    $plans = Plan::all();

    // $account = Subscription::query()->active()->get();

    return Inertia::render('Profile/Edit', [
        'fullName' => $request->user()->name ? $request->user()->name . ' ' . $request->user()->last_name : null,
        'user' => $request->user(),
        'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
        'status' => session('status'),
        'from' => $from,
        'plans' => $from === 'edit-payment-info' ? $plans : null,
        'subscription' => $from === 'edit-payment-info' ? $request->user()->subscription('default') : null,
    ]);
  }

  /**
   * Update the user's profile information.
   */
  public function update(Request $request): RedirectResponse
  {
    $request->user()->fill($request->all());

    if ($request->user()->isDirty('email')) {
      $request->user()->email_verified_at = null;
    }

    $request->user()->save();

    return Redirect::route('profile.edit');
  }

  /**
   * Delete the user's account.
   */
  public function destroy(Request $request): RedirectResponse
  {
    $request->validate([
        'password' => ['required', 'current_password'],
    ]);

    $user = $request->user();

    Auth::logout();

    $user->delete();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return Redirect::to('/');
  }
}
