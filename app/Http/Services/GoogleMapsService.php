<?php

namespace App\Http\Services;

use App\Exceptions\ExceptionManager;
use Illuminate\Support\Facades\Http;

class GoogleMapsService
{
  public function searchPredict($search)
  {
    try {
      $response = Http::get(
          config('services.google_maps.place_url') .
          '?input=' .
          $search .
          '&language=pt_BR&key=' .
          env('API_GOOGLE_MAPS_KEY')
      );
      $body = json_decode($response->getBody());

      return $body->predictions;
    } catch (\Exception $e) {
      return ExceptionManager::handleException($e, func_get_args(), $e->getMessage(), $e->getCode());
    }
  }

  public function searchGeolocation($address)
  {
    try {
      $placeId = null;
      if (isset($address['place_id'])) {
        $placeId = '&place_id=' . $address['place_id'];
      }

      $addressValue = isset($address['address']) ? 'address=' . $address['address'] : null;
      $params = $placeId ? $placeId . '&' . $addressValue : $addressValue;

      $response = Http::get(
          config('services.google_maps.geocode_url') . '?' . $params . '&key=' . config('services.google_maps.key')
      );

      $body = json_decode($response->getBody());

      return $body->results;
    } catch (\Exception $e) {
      return ExceptionManager::handleException($e, func_get_args(), $e->getMessage(), $e->getCode());
    }
  }
}
