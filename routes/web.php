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
      return Inertia::render('Customers/Create/Partials/Components/DocumentValidation', ['step' => 'document']);
    })->name('customers.create');

    Route::get('{document}/{type}/company-data', [\App\Http\Controllers\CustomerController::class, 'show'])->name(
        'customers.company_data'
    );

    Route::get('{id}/contact', [\App\Http\Controllers\CustomerController::class, 'showContact'])->name(
        'customers.contact'
    );

    Route::get('{id}/address', [\App\Http\Controllers\CustomerController::class, 'showAddresses'])->name(
        'customers.address'
    );

    Route::get('{id}/payment', [\App\Http\Controllers\CustomerController::class, 'showPaymentInfo'])->name(
        'customers.payment'
    );

    Route::get('messages', function () {
      return Inertia::render('Customers/AutomaticMessages');
    });

    Route::get('address/search', [\App\Http\Controllers\CustomerController::class, 'predictAddress'])->name(
        'customers.address.search'
    );

    Route::get('address/geolocation', [\App\Http\Controllers\CustomerController::class, 'searchGeolocation'])->name(
        'customers.address.geolocation'
    );

    Route::post('document-validation', [\App\Http\Controllers\DocumentController::class, 'validateDocument'])->name(
        'document.validation'
    );

    Route::post('company-data', [\App\Http\Controllers\CustomerController::class, 'storeCompanyData'])->name(
        'company.data'
    );

    Route::post('/{id}/contact', [\App\Http\Controllers\CustomerController::class, 'storeContact'])->name(
        'customers.contact'
    );

    Route::delete('/{id}/contact/', [\App\Http\Controllers\CustomerController::class, 'deleteContact'])->name(
        'customers.contact'
    );

    Route::post('/{id}/address', [\App\Http\Controllers\CustomerController::class, 'storeAddress'])->name(
        'customers.address'
    );

    Route::delete('/{id}/address/', [\App\Http\Controllers\CustomerController::class, 'deleteAddress'])->name(
        'customers.address'
    );

    Route::post('/{id}/payment', [\App\Http\Controllers\CustomerController::class, 'storePayment'])->name(
        'customers.payment'
    );
  });

  Route::resource('products', \App\Http\Controllers\ProductController::class);
  Route::get('products/{ncm}/ncm', [\App\Http\Controllers\ProductController::class, 'getByNcm'])->name('products.ncm');
});

require __DIR__ . '/auth.php';
