<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DepositRate;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
   public function index(Request $request)
    {
        // 1. Ambil Parameter dari Flutter
        $amount = $request->query('amount', 10000000); // Default Rp 10 Juta
        $duration = $request->query('duration'); // Filter Tenor (opsional)
        $minInterest = $request->query('min_interest'); // Filter Bunga Min (opsional)

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
