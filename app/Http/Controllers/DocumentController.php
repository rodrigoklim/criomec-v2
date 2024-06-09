<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionManager;
use App\Helpers\Response;
use App\Http\Services\DocumentValidationServices;
use App\Models\CustomerPf;
use App\Models\CustomerPj;
use App\Rules\ValidateCompanyDocumentRule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class DocumentController extends Controller
{
  public function validateDocument(Request $request)
  {
    $request->validate([
        'document' => [
            'required',
            Rule::unique(CustomerPj::class, 'document'),
            Rule::unique(CustomerPf::class, 'document'),
            new ValidateCompanyDocumentRule(),
        ],
    ], [
        'document.unique' => 'Cliente já cadastrado',
    ]);

    $customer = [];
    $validatedDocument = preg_replace('/\D/', '', $request->document);

    if ($request->birthdate) {
      $response = DocumentValidationServices::validateCpf([
          'cpf' => $validatedDocument,
          'birthdate' => $request->birthdate,
      ]);

      if (!$response->nome) {
        throw ValidationException::withMessages(
            ['document' => 'CPF ou Data de nascimento inválidos', 'birthdate' => 'CPF ou Data de nascimento inválidos']
        );
      }

      $customer = [
          'name' => $response->nome,
          'document' => $validatedDocument,
          'birthdate' => $response->data_nascimento,
          'status' => $response->situacao_cadastral,
          'type' => 'pf',
          'withNF' => true,
      ];

      return redirect()
          ->route('customers.company_data', ['id' => $customer['document'], 'type' => $customer['type']])
          ->with('customer', $customer);
    }

    $response = DocumentValidationServices::validateCnpj($validatedDocument);
    $customer = [
        'corporate_name' => $response['company']['name'],
        'document' => $response['taxId'],
        'ie' => $response['registrations'][0]['number'],
        'address' => $response['address'],
        'status' => $response['status']['text'],
        'main_activity' => $response['mainActivity']['text'],
        'type' => 'pj',
        'withNF' => true,
    ];

    return redirect()
        ->route('customers.company_data', ['id' => $customer['document'], 'type' => $customer['type']])
        ->with('customer', $customer);
  }
}
