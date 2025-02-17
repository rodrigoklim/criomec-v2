<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionManager;
use App\Helpers\Response;
use App\Http\Requests\UpsertProductRequest;
use App\Models\Ncm;
use App\Models\Product;
use App\Models\ProductLog;
use App\Models\ProductUnit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $tenantId = $request->user()->tenant_id ?? $request->user()->id;

    $products = Product::where('tenant_id', $tenantId)->paginate(10);

    return Inertia::render('Products/IndexPage', ['products' => $products]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return Inertia::render('Products/ProductCreate');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(UpsertProductRequest $request)
  {
    DB::beginTransaction();
    try {
      $tenantId = $request->user()->tenant_id ?? $request->user()->id;
      $product = Product::create([
          'tenant_id' => $tenantId,
          'name' => $request->name,
          'ncm' => $request->ncm,
          'cest' => $request->cest,
          'sku' => $request->sku,
          'operation' => $request->operation,
          'is_active' => true,
      ]);

      foreach ($request->units as $unit) {
        ProductUnit::create([
            'product_id' => $product->id,
            'unit' => $unit['unit'],
        ]);
      }

      ProductLog::create([
          'product_id' => $product->id,
          'user_id' => $request->user()->id,
          'action' => 'cadastro inicial',
      ]);

      DB::commit();

      return redirect()->route('products.show', $product->id);
    } catch (\Exception $e) {
      DB::rollBack();
      ExceptionManager::handleException($e, 'Erro ao criar produto');
      dd($e);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $product = Product::find($id);
    if (!$product) {
      return redirect()->route('products.index');
    }

    $product = Product::with([
        'units',
        'logs.user' => function ($query) {
          $query->orderBy('created_at', 'desc');
        },
    ])->findOrFail($id);

    return Inertia::render('Products/ProductCreate', ['product' => $product]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    return redirect()->route('products.show', $id);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    DB::beginTransaction();
    try {
      $product = Product::findOrFail($id);
      $product->update([
          'name' => $request->name,
          'ncm' => $request->ncm,
          'cest' => $request->cest,
          'sku' => $request->sku,
          'operation' => $request->operation,
          'is_active' => true,
      ]);

      ProductUnit::where('product_id', $id)->delete();

      foreach ($request->units as $unit) {
        ProductUnit::create([
            'product_id' => $product->id,
            'unit' => $unit['unit'],
        ]);
      }

      ProductLog::create([
          'product_id' => $product->id,
          'user_id' => $request->user()->id,
          'action' => 'alteração no cadastro',
      ]);

      DB::commit();

      return redirect()->route('products.show', $product->id);
    } catch (\Exception $e) {
      DB::rollBack();
      ExceptionManager::handleException($e, 'Erro ao criar produto');
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }

  public function getByNcm($ncm)
  {
    $ncms = Ncm::where('ncm', 'like', "%$ncm%")->paginate(4);

    return Response::getJsonResponse('success', $ncms, 200);
  }
}
