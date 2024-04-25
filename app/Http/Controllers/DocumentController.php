<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionManager;
use App\Helpers\Response;
use App\Http\Services\DocumentValidationServices;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DocumentController extends Controller
{
  public function validateDocument(Request $request)
  {
    try {
      $customer = [];
      $validatedDocument = preg_replace('/\D/', '', $request->document);

      if (strlen($validatedDocument) === 11 && $this->validateCpf($validatedDocument) && $request->birthdate) {
        $response = DocumentValidationServices::validateCpf([
            'cpf' => $validatedDocument,
            'birthdate' => $request->birthdate,
        ]);

        $customer = [
            'name' => $response->nome,
            'document' => $validatedDocument,
            'birthdate' => $response->data_nascimento,
            'status' => $response->situacao_cadastral,
            'type' => 'pf',
        ];

        return Response::getJsonResponse('Documento válido', $customer, 200);
      }

      if (strlen($validatedDocument) === 14 && $this->validateCnpj($validatedDocument)) {
        $response = DocumentValidationServices::validateCnpj($validatedDocument);
        $customer = [
            'corporateName' => $response['company']['name'],
            'document' => $response['taxId'],
            'ie' => $response['registrations'][0]['number'],
            'address' => $response['address'],
            'status' => $response['status']['text'],
            'mainActivity' => $response['mainActivity']['text'],
            'type' => 'pj',
        ];

        return Response::getJsonResponse('Documento válido', $customer, 200);
      }

      return Response::getJsonResponse('Documento inválido', [], 400);
    } catch (\Exception $e) {
      return ExceptionManager::handleException($e, func_get_args());
    }
  }

  private function validateCpf($document)
  {
    for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--) {
      $soma += $document[$i] * $j;
    }

    $resto = $soma % 11;

    if ($document[9] != ($resto < 2 ? 0 : 11 - $resto)) {
      return false;
    }

    for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--) {
      $soma += $document[$i] * $j;
    }

    $resto = $soma % 11;

    return $document[10] == ($resto < 2 ? 0 : 11 - $resto);
  }

  private function validateCnpj($document)
  {
    for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
      $soma += $document[$i] * $j;
      $j = ($j == 2) ? 9 : $j - 1;
    }

    $resto = $soma % 11;

    if ($document[12] != ($resto < 2 ? 0 : 11 - $resto)) {
      return false;
    }

    for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
      $soma += $document[$i] * $j;
      $j = ($j == 2) ? 9 : $j - 1;
    }

    $resto = $soma % 11;

    return $document[13] == ($resto < 2 ? 0 : 11 - $resto);
  }
}
