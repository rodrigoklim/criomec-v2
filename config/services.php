<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Third Party Services
  |--------------------------------------------------------------------------
  |
  | This file is for storing the credentials for third party services such
  | as Mailgun, Postmark, AWS and more. This file provides the de facto
  | location for this type of information, allowing packages to have
  | a conventional file to locate the various service credentials.
  |
  */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'stripe' => [
        'model' => App\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'cnpj' => [
        'key' => env('RAPID_API_KEY'),
        'host' => env('RAPID_API_HOST'),
        'url' => env('RAPID_API_URL'),
    ],

    'cpf' => [
        'key' => env('SINTEGRA_API_KEY'),
        'url' => env('SINTEGRA_API_URL'),
    ],

    'google_maps' => [
        'key' => env('API_GOOGLE_MAPS_KEY'),
        'place_url' => env('API_GOOGLE_MAPS_PLACE_ENDPOINT'),
        'geocode_url' => env('API_GOOGLE_MAPS_GEOCODE_ENDPOINT'),
    ],
];
