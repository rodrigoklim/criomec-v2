<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\DocumentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('subscriptions/success', [SubscriptionsController::class, 'success'])->name('subscriptions.success');

Route::middleware('auth')->group(function () {
  // Account
  Route::prefix('/my-account')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::get('{url}', function ($url) {
      if (in_array($url, ['edit-personal-info', 'edit-contact-info', 'change-password', 'edit-payment-info'])) {
        return app(ProfileController::class)->edit(request(), $url);
      }

      return abort(404);
    });

    Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
  });

  //  Subscriptions
  Route::resource('subscriptions', SubscriptionsController::class);

  //  Customers
  Route::prefix('/customers')->group(function () {
    Route::get('/', function () {
      return Inertia::render('Customers/IndexPage');
    })->name('customers.index');

    Route::get('new', function () {
      return Inertia::render('Customers/Create/CreatePage');
    })->name('customers.create');

    Route::get('messages', function () {
      return Inertia::render('Customers/AutomaticMessages');
    });
  });

  Route::get('document-validation', [DocumentController::class, 'validateDocument'])->name(
      'document.validation'
  );
});

require __DIR__ . '/auth.php';
