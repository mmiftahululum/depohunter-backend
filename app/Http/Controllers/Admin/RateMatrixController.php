<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateMatrixRateRequest;
use App\Models\Bank;
use App\Models\DepositProduct;
use App\Models\DepositRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RateMatrixController extends Controller
{
    /**
     * Tampilkan halaman matriks suku bunga deposito.
     */
    public function index(Request $request)
    {
        $banks = Bank::withCount('products')->orderBy('name')->get();

        // Default ke bank yang dipilih via query string atau bank pertama
        $selectedBankId = $request->query('bank_id');
        if (!$selectedBankId && $banks->isNotEmpty()) {
            // Prioritaskan bank yang memiliki produk
            $firstWithProducts = $banks->firstWhere('products_count', '>', 0);
            $selectedBankId = $firstWithProducts ? $firstWithProducts->id : $banks->first()->id;
        }

        $selectedProductId = $request->query('deposit_product_id');

        return view('admin.rate_matrix.index', compact('banks', 'selectedBankId', 'selectedProductId'));
    }

    /**
     * API: Ambil data matriks (bank, produk, tenor, dan suku bunga) dalam format JSON.
     */
    public function getData(Request $request)
    {
        $validated = $request->validate([
            'bank_id' => ['required', 'integer', 'exists:banks,id'],
            'deposit_product_id' => ['nullable', 'integer', 'exists:deposit_products,id'],
        ]);

        $bankId = $validated['bank_id'];
        $bank = Bank::findOrFail($bankId);

        // Ambil semua produk milik bank ini untuk opsi filter
        $allProductsOfBank = DepositProduct::where('bank_id', $bankId)
            ->orderBy('min_deposit', 'asc')
            ->get(['id', 'name', 'min_deposit']);

        // Query produk yang akan ditampilkan dalam matriks
        $productsQuery = DepositProduct::with(['rates' => function ($q) {
            $q->orderBy('duration_months', 'asc');
        }])
        ->where('bank_id', $bankId);

        if (!empty($validated['deposit_product_id'])) {
            $productsQuery->where('id', $validated['deposit_product_id']);
        }

        $products = $productsQuery->orderBy('min_deposit', 'asc')->get();

        // Kumpulkan seluruh tenor yang ada di database untuk produk bank ini,
        // lalu gabungkan dengan tenor standar deposito (1, 3, 6, 12 bulan)
        $existingTenors = [];
        foreach ($products as $product) {
            foreach ($product->rates as $rate) {
                $existingTenors[] = (int) $rate->duration_months;
            }
        }

        $standardTenors = [1, 3, 6, 12];
        $allTenors = array_unique(array_merge($standardTenors, $existingTenors));
        sort($allTenors);

        // Susun baris matriks berdasarkan produk (Tier Nominal Minimum Deposito)
        $rows = [];
        foreach ($products as $product) {
            // Buat lookup map suku bunga per tenor
            $ratesMap = [];
            foreach ($product->rates as $rate) {
                $ratesMap[$rate->duration_months] = [
                    'id' => $rate->id,
                    'interest_rate' => (float) $rate->interest_rate,
                    'duration_months' => (int) $rate->duration_months,
                    'tax_percent' => (float) $rate->tax_percent,
                    'updated_at' => $rate->updated_at ? $rate->updated_at->format('d/m/Y H:i') : null,
                ];
            }

            // Lengkapi dengan semua tenor kolom matriks
            $ratesByTenor = [];
            foreach ($allTenors as $tenor) {
                $ratesByTenor[$tenor] = $ratesMap[$tenor] ?? null;
            }

            $rows[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'min_deposit' => (float) $product->min_deposit,
                'min_deposit_formatted' => 'Rp ' . number_format($product->min_deposit, 0, ',', '.'),
                'is_active' => (bool) $product->is_active,
                'rates' => $ratesByTenor,
            ];
        }

        return response()->json([
            'success' => true,
            'bank' => [
                'id' => $bank->id,
                'name' => $bank->name,
                'type' => $bank->type,
                'code_saham' => $bank->code_saham,
                'logo_url' => $bank->logo_url ? asset('storage/' . $bank->logo_url) : null,
                'is_ojk_verified' => (bool) $bank->is_ojk_verified,
                'is_lps_insured' => (bool) $bank->is_lps_insured,
            ],
            'products_list' => $allProductsOfBank->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'min_deposit_formatted' => 'Rp ' . number_format($p->min_deposit, 0, ',', '.'),
                ];
            }),
            'tenors' => $allTenors,
            'rows' => $rows,
        ]);
    }

    /**
     * API: Update atau buat suku bunga individu langsung dari cell matriks (Inline Editing).
     */
    public function updateRate(UpdateMatrixRateRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            // Update jika tenor untuk produk tersebut sudah ada, atau buat baru jika belum ada
            $rate = DepositRate::updateOrCreate(
                [
                    'deposit_product_id' => $validated['deposit_product_id'],
                    'duration_months' => $validated['duration_months'],
                ],
                [
                    'interest_rate' => $validated['interest_rate'],
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Suku bunga ' . $rate->duration_months . ' bulan berhasil disimpan (' . number_format($rate->interest_rate, 2) . '%).',
                'data' => [
                    'id' => $rate->id,
                    'deposit_product_id' => (int) $rate->deposit_product_id,
                    'duration_months' => (int) $rate->duration_months,
                    'interest_rate' => (float) $rate->interest_rate,
                    'tax_percent' => (float) $rate->tax_percent,
                    'updated_at' => $rate->updated_at ? $rate->updated_at->format('d/m/Y H:i') : null,
                ],
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('RateMatrixController updateRate error: ' . $e->getMessage(), [
                'exception' => $e,
                'payload' => $validated,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }
}
