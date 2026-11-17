<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDepositProductRequest;
use App\Http\Requests\Admin\UpdateDepositProductRequest;
use App\Models\Bank;
use App\Models\DepositProduct;
use Illuminate\Http\Request;

class DepositProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DepositProduct::with(['bank'])->withCount('rates');

        if ($request->filled('bank_id')) {
            $query->where('bank_id', $request->bank_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('bank', function ($bq) use ($search) {
                      $bq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $banks = Bank::orderBy('name')->get();
        $selectedBank = $request->filled('bank_id') ? Bank::find($request->bank_id) : null;

        return view('admin.deposit_products.index', compact('products', 'banks', 'selectedBank'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $banks = Bank::orderBy('name')->get();
        $defaultBankId = $request->query('bank_id');

        return view('admin.deposit_products.create', compact('banks', 'defaultBankId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepositProductRequest $request)
    {
        DepositProduct::create($request->validated());

        return redirect()->route('admin.deposit-products.index', ['bank_id' => $request->bank_id])
            ->with('success', 'Produk Deposito berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DepositProduct $depositProduct)
    {
        $banks = Bank::orderBy('name')->get();

        return view('admin.deposit_products.edit', compact('depositProduct', 'banks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepositProductRequest $request, DepositProduct $depositProduct)
    {
        $depositProduct->update($request->validated());

        return redirect()->route('admin.deposit-products.index', ['bank_id' => $depositProduct->bank_id])
            ->with('success', 'Data produk deposito berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DepositProduct $depositProduct)
    {
        $bankId = $depositProduct->bank_id;
        $depositProduct->delete();

        return redirect()->route('admin.deposit-products.index', ['bank_id' => $bankId])
            ->with('success', 'Produk deposito berhasil dihapus!');
    }
}
