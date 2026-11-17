<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDepositRateRequest;
use App\Http\Requests\Admin\UpdateDepositRateRequest;
use App\Models\Bank;
use App\Models\DepositProduct;
use App\Models\DepositRate;
use App\Models\GlobalSetting;
use Illuminate\Http\Request;

class DepositRateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DepositRate::with(['product.bank']);

        // Filter Bank
        if ($request->filled('bank_filter')) {
            $bankId = $request->bank_filter;
            $query->whereHas('product', function ($q) use ($bankId) {
                $q->where('bank_id', $bankId);
            });
        }

        // Filter Produk
        if ($request->filled('deposit_product_id')) {
            $query->where('deposit_product_id', $request->deposit_product_id);
        }

        // Filter Tenor
        if ($request->filled('duration_months')) {
            $query->where('duration_months', $request->duration_months);
        }

        // Search text
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('product', function ($pq) use ($search) {
                    $pq->where('name', 'like', "%{$search}%")
                       ->orWhereHas('bank', function ($bq) use ($search) {
                           $bq->where('name', 'like', "%{$search}%");
                       });
                });
            });
        }

        // Default sort by interest_rate desc (seperti Filament)
        $rates = $query->orderBy('interest_rate', 'desc')
            ->paginate(15)
            ->withQueryString();

        $banks = Bank::orderBy('name')->get();
        $products = DepositProduct::with('bank')->orderBy('name')->get();
        $settings = GlobalSetting::all()->keyBy('key');

        return view('admin.deposit_rates.index', compact('rates', 'banks', 'products', 'settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $banks = Bank::orderBy('name')->get();
        $defaultProductId = $request->query('deposit_product_id');
        $defaultBankId = $request->query('bank_filter');

        if ($defaultProductId && !$defaultBankId) {
            $prod = DepositProduct::find($defaultProductId);
            if ($prod) {
                $defaultBankId = $prod->bank_id;
            }
        }

        $products = $defaultBankId 
            ? DepositProduct::where('bank_id', $defaultBankId)->orderBy('name')->get()
            : collect();

        $settings = GlobalSetting::all()->keyBy('key');

        return view('admin.deposit_rates.create', compact('banks', 'products', 'defaultBankId', 'defaultProductId', 'settings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepositRateRequest $request)
    {
        DepositRate::create($request->validated());

        return redirect()->route('admin.deposit-rates.index', [
            'deposit_product_id' => $request->deposit_product_id
        ])->with('success', 'Suku Bunga Deposito berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DepositRate $depositRate)
    {
        $depositRate->load(['product.bank']);
        $banks = Bank::orderBy('name')->get();
        $currentBankId = $depositRate->product?->bank_id;
        
        $products = $currentBankId
            ? DepositProduct::where('bank_id', $currentBankId)->orderBy('name')->get()
            : collect();

        $settings = GlobalSetting::all()->keyBy('key');

        return view('admin.deposit_rates.edit', compact('depositRate', 'banks', 'products', 'currentBankId', 'settings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepositRateRequest $request, DepositRate $depositRate)
    {
        $depositRate->update($request->validated());

        return redirect()->route('admin.deposit-rates.index', [
            'deposit_product_id' => $depositRate->deposit_product_id
        ])->with('success', 'Data suku bunga deposito berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DepositRate $depositRate)
    {
        $productId = $depositRate->deposit_product_id;
        $depositRate->delete();

        return redirect()->route('admin.deposit-rates.index', ['deposit_product_id' => $productId])
            ->with('success', 'Suku bunga deposito berhasil dihapus!');
    }

    /**
     * Ajax API: Ambil daftar produk berdasarkan bank_id untuk dynamic dropdown.
     */
    public function getProductsByBank($bankId)
    {
        $products = DepositProduct::where('bank_id', $bankId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'min_deposit']);

        $bank = Bank::find($bankId);

        return response()->json([
            'products' => $products,
            'bank' => $bank ? [
                'id' => $bank->id,
                'name' => $bank->name,
                'type' => $bank->type,
                'is_lps_insured' => (bool) $bank->is_lps_insured,
                'is_ojk_verified' => (bool) $bank->is_ojk_verified,
            ] : null,
        ]);
    }
}
