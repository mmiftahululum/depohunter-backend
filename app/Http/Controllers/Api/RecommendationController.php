<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DepositRate;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
   public function index(Request $request)
    {
        try {
            // 1. Ambil Parameter dari Flutter
            $amount = $request->input('amount', 5000000); // Default Rp 5 Juta
            $duration = $request->input('duration'); // Filter Tenor (opsional)
            $minInterest = $request->input('min_interest'); // Filter Bunga Min (opsional)

            // 2. Query Database dengan Relasi
            $query = DepositRate::with(['product.bank'])
                ->whereHas('product', function($q) use ($amount) {
                    $q->where('is_active', true);
                    // Jika user kirim amount 0, kita abaikan filter minimum deposit
                    if ($amount > 0) {
                        $q->where('min_deposit', '<=', $amount);
                    }
                });

            // 3. Terapkan Filter Tambahan
            if ($duration) {
                $query->where('duration_months', $duration);
            }
            
            if ($minInterest) {
                $query->where('interest_rate', '>=', $minInterest);
            }

            // 4. Sorting (Bunga Tertinggi -> Tenor Tercepat)
            $rates = $query->orderBy('interest_rate', 'desc')
                           ->orderBy('duration_months', 'asc')
                           ->take(20) // Batasi 20 hasil teratas
                           ->get();

            // 5. Format Data JSON untuk Flutter
            $data = $rates->map(function ($rate) use ($amount) {
                // Hitung Estimasi Cuan
                $grossProfit = $amount * ($rate->interest_rate / 100) * ($rate->duration_months / 12);
                $taxAmount = $grossProfit * ($rate->tax_percent / 100);
                $netProfit = $grossProfit - $taxAmount;

                return [
                    'id' => (string) $rate->id,
                    'bank' => [
                        'name' => $rate->product->bank->name,
                        'logo' => $rate->product->bank->logo_url ? asset('storage/' . $rate->product->bank->logo_url) : null,
                        'type' => ucfirst($rate->product->bank->type), // Digital / Konvensional
                        'color' => $rate->product->bank->color_code,
                        'website' => $rate->product->bank->website_url, // Link Website
                    ],
                    'product' => [
                        'name' => $rate->product->name,
                        'affiliate_link' => $rate->product->referral_link,
                    ],
                    'rate' => [
                        'duration' => (string) $rate->duration_months, // Angka (int)
                        'duration_text' => $rate->duration_months . ' Bulan', // Teks
                        'interest_rate' => (string) $rate->interest_rate,
                        'tax_percent' => (string) $rate->tax_percent,
                    ],
                    'simulation' => [
                        'input_amount' => (string) $amount,
                        'gross_profit' => (string) $grossProfit,
                        'net_profit' => (string) $netProfit, // INI YANG DICARI USER (Cuan Bersih)
                    ]
                ];
            });

            return $this->successResponse([
                'count' => (string) $data->count(),
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Terjadi kesalahan saat mengambil data rekomendasi',
                ['error' => $e->getMessage()],
                500
            );
        }
    }
    public function topBanks(Request $request)
    {
        try {
            // 1. Ambil Parameter
            $amount = $request->input('amount', 5000000); // Default 1 Juta
            $limit = $request->input('limit', 5); // Default 5 Top Bank
            $duration = $request->input('duration'); // Opsional Filter Tenor

            // 2. Query Database
            // Kita cari rate tertinggi, tapi harus valid (active) dan sesuai budget (min_deposit <= amount)
            $rates = DepositRate::with(['product.bank'])
                ->whereHas('product', function($q) use ($amount) {
                    $q->where('is_active', true);
                    if ($amount > 0) {
                        $q->where('min_deposit', '<=', $amount);
                    }
                });

            // Terapkan filter duration jika ada
            if ($duration) {
                $rates->where('duration_months', $duration);
            }

            // Lanjutkan query
            $rates = $rates
                // Sort 1: Tenor Tercepat (Agar unique mengambil yang tenornya paling kecil)
                ->orderBy('duration_months', 'asc')
                // Sort 2: Bunga Tertinggi
                ->orderBy('interest_rate', 'desc')
                // Sort 3: Minimal Deposito Terbesar
                ->orderByRaw('
                    (SELECT min_deposit FROM deposit_products WHERE deposit_products.id = deposit_rates.deposit_product_id) DESC
                ')
                ->get();

            // 3. Filter Unik Bank (Ambil 1 terbaik per bank, yaitu tenor tercepat)
            $uniqueRates = $rates->unique(function ($item) {
                return $item->product->bank_id;
            });

            // 4. Sort Ulang Berdasarkan Bunga Tertinggi
            $topBanks = $uniqueRates->sortByDesc('interest_rate')->take($limit);

            // 5. Format Data
            $data = $topBanks->map(function ($rate) use ($amount) {
                 // Hitung Estimasi Cuan (Opsional, tapi bagus untuk ditampilkan)
                 $grossProfit = $amount * ($rate->interest_rate / 100) * ($rate->duration_months / 12);
                 $taxAmount = $grossProfit * ($rate->tax_percent / 100);
                 $netProfit = $grossProfit - $taxAmount;

                return [
                    'id' => (string) $rate->id,
                    'bank' => [
                        'id' => (string) $rate->product->bank->id,
                        'name' => $rate->product->bank->name,
                        'logo' => $rate->product->bank->logo_url ? asset('storage/' . $rate->product->bank->logo_url) : null,
                        'type' => ucfirst($rate->product->bank->type),
                        'color' => $rate->product->bank->color_code,
                        'website' => $rate->product->bank->website_url,
                    ],
                    'product' => [
                        'name' => $rate->product->name,
                        'min_deposit' => (string) $rate->product->min_deposit,
                        'affiliate_link' => $rate->product->referral_link,
                    ],
                    'rate' => [
                        'duration' => (string) $rate->duration_months,
                        'duration_text' => $rate->duration_months . ' Bulan',
                        'interest_rate' => (string) $rate->interest_rate,
                        'tax_percent' => (string) $rate->tax_percent,
                    ],
                    'simulation' => [
                        'input_amount' => (string) $amount,
                        'gross_profit' => (string) $grossProfit,
                        'net_profit' => (string) $netProfit,
                    ]
                ];
            });

            return $this->successResponse([
                'count' => (string) $data->count(),
                'data' => $data->values() // values() untuk reset keys array setelah unique
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Terjadi kesalahan saat mengambil data top banks',
                ['error' => $e->getMessage()],
                500
            );
        }

        // 4. Sorting (Bunga Tertinggi -> Tenor Tercepat)
        $rates = $query->orderBy('interest_rate', 'desc')
                       ->orderBy('duration_months', 'asc')
                       ->take(20) // Batasi 20 hasil teratas
                       ->get();

        // 5. Format Data JSON untuk Flutter
        $data = $rates->map(function ($rate) use ($amount) {
            // Hitung Estimasi Cuan
            $grossProfit = $amount * ($rate->interest_rate / 100) * ($rate->duration_months / 12);
            $taxAmount = $grossProfit * ($rate->tax_percent / 100);
            $netProfit = $grossProfit - $taxAmount;

            return [
                'id' => $rate->id,
                'bank' => [
                    'name' => $rate->product->bank->name,
                    'logo' => $rate->product->bank->logo_url ? asset('storage/' . $rate->product->bank->logo_url) : null,
                    'type' => ucfirst($rate->product->bank->type), // Digital / Konvensional
                    'color' => $rate->product->bank->color_code,
                    'website' => $rate->product->bank->website_url, // Link Website
                    'description' => $rate->product->bank->description,
                    'code_saham' => $rate->product->bank->code_saham,
                ],
                'product' => [
                    'name' => $rate->product->name,
                    'affiliate_link' => $rate->product->referral_link,
                ],
                'rate' => [
                    'duration' => $rate->duration_months, // Angka (int)
                    'duration_text' => $rate->duration_months . ' Bulan', // Teks
                    'interest_rate' => (float) $rate->interest_rate,
                    'tax_percent' => (float) $rate->tax_percent,
                    'is_lps' => (bool) $rate->is_lps_insured, // Status LPS dari database
                ],
                'simulation' => [
                    'input_amount' => (int) $amount,
                    'gross_profit' => (int) $grossProfit,
                    'net_profit' => (int) $netProfit, // INI YANG DICARI USER (Cuan Bersih)
                ]
            ];
        });

        return response()->json([
            'status' => 'success',
            'count' => $data->count(),
            'data' => $data
        ]);
    }
}
