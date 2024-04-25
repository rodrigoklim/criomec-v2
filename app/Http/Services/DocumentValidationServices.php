<?php

namespace App\Http\Services;

use App\Exceptions\ExceptionManager;
use App\Helpers\Response;
use Illuminate\Support\Facades\Http;

class DocumentValidationServices
{
  public static function validateCnpj($document)
  {
    try {
      $response = Http::withHeaders([
          'x-rapidapi-key' => config('services.cnpj.key'),
          'x-rapidapi-host' => config('services.cnpj.host'),
      ])->get(config('services.cnpj.url') . $document, [
          'simples' => true,
          'registrations' => 'BR',
      ]);

      return $response->json();
    } catch (\Exception $e) {
      return ExceptionManager::handleException($e, func_get_args());
    }
  }

  public static function validateCpf($document)
  {
    try {
      $response = Http::get(config('services.cpf.url'), [
          'cpf' => $document['cpf'],
          'data-nascimento' => $document['birthdate'],
          'token' => config('services.cpf.key'),
          'plugin' => 'CPF',
      ]);

      return json_decode($response->getBody());
    } catch (\Exception $e) {
      return ExceptionManager::handleException($e, func_get_args());
    }
  }
}
