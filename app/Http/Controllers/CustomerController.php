<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionManager;
use App\Helpers\Response;
use App\Http\Services\GoogleMapsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
  private $googleMapsService;

  public function __construct(GoogleMapsService $googleMapsService)
  {
    $this->googleMapsService = $googleMapsService;
  }

  public function index(Request $request)
  {
    //
  }

  public function store(Request $request)
  {
  }

  public function predictAddress(Request $request): false|string
  {
    try {
      $response = $this->googleMapsService->searchPredict($request->search);

      return Response::getJsonResponse('success', $response, 200);
    } catch (\Exception $e) {
      return ExceptionManager::handleException($e, func_get_args());
    }
  }

  public function searchGeolocation(Request $request): false|string
  {
    try {
      $response = $this->googleMapsService->searchGeolocation($request->toArray());

      return Response::getJsonResponse('success', $response, 200);
    } catch (\Exception $e) {
      return ExceptionManager::handleException($e, func_get_args());
    }
  }
}
