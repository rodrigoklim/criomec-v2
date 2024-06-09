<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionManager;
use App\Helpers\Response;
use App\Http\Requests\CompanyDataRequest;
use App\Http\Services\GoogleMapsService;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerContact;
use App\Models\CustomerPayment;
use App\Models\CustomerPf;
use App\Models\CustomerPj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

  public function show(string $document, string $type): \Inertia\Response|\Illuminate\Http\RedirectResponse
  {
    if ($type === 'pj') {
      $customer = CustomerPj::where('document', $document)->first();
    } else {
      $customer = CustomerPf::where('document', $document)->first();
    }

    if (!session('customer') && !$customer) {
      return redirect()->route('customers.create');
    }

    return Inertia::render('Customers/Create/Partials/CompanyData', [
        'customer' => session('customer') ?? $customer->toArray(),
        'step' => 'company-data',
    ]);
  }

  public function showContact(string $id): \Inertia\Response|\Illuminate\Http\RedirectResponse
  {
    $customer = Customer::find($id);
    $customer->with('customerData');
    $customer->customerData->with('contacts');
    if (!$customer) {
      return redirect()->back();
    }

    return Inertia::render('Customers/Create/Partials/CompanyContacts', [
        'customer' => $customer->customerData,
        'contacts' => $customer->customerData->contacts,
        'step' => 'contact',
    ]);
  }

  public function showAddresses(string $id): \Inertia\Response|\Illuminate\Http\RedirectResponse
  {
    $customer = Customer::find($id);
    $customer->with('customerData');
    $customer->customerData->with('address');
    if (!$customer) {
      return redirect()->back();
    }

    return Inertia::render('Customers/Create/Partials/CompanyAddresses', [
        'customer' => $customer->customerData,
        'addresses' => $customer->customerData->address,
        'step' => 'address',
    ]);
  }

  public function showPaymentInfo(string $id): \Inertia\Response|\Illuminate\Http\RedirectResponse
  {
    $customer = Customer::find($id);
    $customer->with('customerData');
    $customer->customerData->with('payment');
    if (!$customer) {
      return redirect()->back();
    }

    return Inertia::render('Customers/Create/Partials/CompanyPayment', [
        'customer' => $customer->customerData,
        'customerPayment' => $customer->customerData->payment,
        'step' => 'payment',
    ]);
  }

  public function storeCompanyData(CompanyDataRequest $request): \Illuminate\Http\RedirectResponse
  {
    DB::beginTransaction();
    try {
      $data = array_merge(['tenant_id' => 'teste-id'], $request->toArray());

      switch ($data['type']) {
        case 'pj':
          $customer = CustomerPj::updateOrCreate(['document' => $data['document']], $data);
          break;
        case 'pf':
          $customer = CustomerPf::updateOrCreate(['document' => $data['document']], $data);
          break;
        default:
          throw new \Exception('Invalid type');
      }

      DB::commit();

      return redirect()->route('customers.contact', ['id' => $customer->id])->with('customer', $customer);
    } catch (\Exception $e) {
      DB::rollBack();
      ExceptionManager::handleException($e, func_get_args());

      return redirect()->back()->with('error', 'Erro ao salvar dados');
    }
  }

  public function storeContact(Request $request, $id): \Illuminate\Http\RedirectResponse
  {
    DB::beginTransaction();
    try {
      foreach ($request->contacts as $contact) {
        CustomerContact::updateOrCreate(['id' => $contact['id'] ?? null], $contact);
      }

      $customer = Customer::find($id);
      $customer->with('customerData');

      DB::commit();

      return redirect()->route('customers.contact', ['id' => $id])->with('customer', $customer->customerData);
    } catch (\Exception $e) {
      DB::rollBack();
      ExceptionManager::handleException($e, func_get_args());

      return redirect()->back()->with('error', 'Erro ao salvar dados');
    }
  }

  public function deleteContact($id): \Illuminate\Http\RedirectResponse
  {
    DB::beginTransaction();
    try {
      CustomerContact::destroy($id);

      DB::commit();

      return redirect()->back()->with('success', 'Contato deletado com sucesso');
    } catch (\Exception $e) {
      DB::rollBack();
      ExceptionManager::handleException($e, func_get_args());

      return redirect()->back()->with('error', 'Erro ao deletar contato');
    }
  }

  public function storeAddress(Request $request, $id): \Illuminate\Http\RedirectResponse
  {
    DB::beginTransaction();
    try {
      foreach ($request->addresses as $address) {
        CustomerAddress::updateOrCreate(['id' => $address['id'] ?? null], $address);
      }

      $customer = Customer::find($id);
      $customer->with('customerData');

      DB::commit();

      return redirect()->route('customers.address', ['id' => $id])->with('customer', $customer->customerData);
    } catch (\Exception $e) {
      DB::rollBack();
      ExceptionManager::handleException($e, func_get_args());

      return redirect()->back()->with('error', 'Erro ao salvar dados');
    }
  }

  public function storePayment(Request $request, $id): \Illuminate\Http\RedirectResponse
  {
    DB::beginTransaction();
    try {
      $payment = [];
      if ($request->type === 'upfront') {
        $payment = [
            'type' => $request->type,
            'parameters' => 'bank-transfer',
            'bank_account' => $request->parameters,
            'customer_id' => $request->customer_id,
        ];
      }

      if ($request->type === 'cash') {
        $payment = [
            'type' => $request->type,
            'parameters' => $request->parameters,
            'customer_id' => $request->customer_id,
        ];
      }

      if ($request->type === 'installments') {
        $payment = [
            'type' => $request->type,
            'parameters' => $request->parameters,
            'installments' => implode(',', $request->details['installments']),
            'due_date' => $request->details['due_date'],
            'contract_number' => $request->details['contract_number'],
            'commitment_number' => $request->details['commitment_number'],
            'bank_account' => $request->details['bank'],
            'customer_id' => $request->customer_id,
        ];
      }

      CustomerPayment::updateOrCreate(['id' => $request['id'] ?? null], $payment);

      $customer = Customer::find($id);
      $customer->with('customerData');

      DB::commit();

      return redirect()->route('customers.payment', ['id' => $id])->with('customer', $customer->customerData);
    } catch (\Exception $e) {
      DB::rollBack();
      ExceptionManager::handleException($e, func_get_args());

      return redirect()->back()->with('error', 'Erro ao salvar dados');
    }
  }

  public function deleteAddress($id)
  {
    DB::beginTransaction();
    try {
      $address = CustomerAddress::find($id);
      if (!$address) {
        return;
      }

      $customer = Customer::find($address->customer_id);
      $address->delete();

      $addresses = $customer->customerData->address;

      DB::commit();

      return redirect()->back()->with(['success' => 'Endereço deletado com sucesso', ['address' => $addresses]]);
    } catch (\Exception $e) {
      DB::rollBack();
      ExceptionManager::handleException($e, func_get_args());

      return redirect()->back()->with('error', 'Erro ao deletar contato');
    }
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
