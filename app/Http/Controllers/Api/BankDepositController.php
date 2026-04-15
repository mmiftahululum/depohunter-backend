<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankDepositController extends Controller
{
    public function index(Request $request)
    {
        // 1. Validasi Parameter Wajib
        $validated = $request->validate([
            'amount'    => 'required|numeric|min:1',
            'duration'  => 'nullable|integer|in:1,3,6,12,24',
            'bank_type' => 'nullable|string|in:digital,konvensional',
            'limit'     => 'nullable|integer|min:1|max:100',
        ], [
            'amount.required' => 'Parameter amount wajib diisi.',
            'amount.numeric'  => 'Parameter amount harus berupa angka.',
            'amount.min'      => 'Parameter amount harus lebih dari 0.',
            'duration.in'     => 'Parameter duration hanya boleh: 1, 3, 6, 12, atau 24.',
            'bank_type.in'    => 'Parameter bank_type hanya boleh: digital atau konvensional.',
        ]);

        try {
            $amount   = (float) $validated['amount'];
            $duration = $request->input('duration');
            $bankType = $request->input('bank_type');
            $limit    = $request->input('limit');

            // 2. Query Bank dengan relasi produk & rate
            $query = Bank::with([
                'products' => function ($q) use ($amount, $duration) {
                    $q->where('is_active', true)
                      ->where('min_deposit', '<=', $amount)
                      ->with([
                          'rates' => function ($rq) use ($duration) {
                              if ($duration) {
                                  $rq->where('duration_months', $duration);
                              }
                              $rq->orderBy('duration_months', 'asc');
                          }
                      ]);
                }
            ]);

            // 3. Filter Tipe Bank (opsional)
            if ($bankType) {
                $query->where('type', $bankType);
            }

            // 4. Hanya ambil bank yang punya produk aktif sesuai budget
            $query->whereHas('products', function ($q) use ($amount) {
                $q->where('is_active', true)
                  ->where('min_deposit', '<=', $amount);
            });

            // 5. Ambil data
            $banks = $query->orderBy('name', 'asc')->get();

            // 6. Filter bank yang produknya punya rate (setelah filter duration)
            $banks = $banks->filter(function ($bank) {
                return $bank->products->filter(function ($product) {
                    return $product->rates->isNotEmpty();
                })->isNotEmpty();
            });

            // 7. Batasi jumlah bank jika ada parameter limit
            if ($limit) {
                $banks = $banks->take($limit);
            }

            // 8. Format Data
            $data = $banks->map(function ($bank) use ($amount) {
                $products = $bank->products
                    ->filter(fn ($product) => $product->rates->isNotEmpty())
                    ->map(function ($product) use ($amount) {
                        $rates = $product->rates->map(function ($rate) use ($amount) {
                            // Hitung simulasi profit
                            $grossProfit = $amount * ($rate->interest_rate / 100) * ($rate->duration_months / 12);
                            $taxAmount   = $grossProfit * ($rate->tax_percent / 100);
                            $netProfit   = $grossProfit - $taxAmount;

                            // Bunga bersih setelah pajak
                            $netInterestRate = $rate->interest_rate - ($rate->interest_rate * ($rate->tax_percent / 100));

                            return [
                                'duration_months'   => (string) $rate->duration_months,
                                'duration_text'     => $rate->duration_months . ' Bulan',
                                'interest_rate'     => (string) $rate->interest_rate,
                                'tax_percent'       => (string) $rate->tax_percent,
                                'net_interest_rate' => (string) round($netInterestRate, 4),
                                'simulation'        => [
                                    'gross_profit' => (string) round($grossProfit, 2),
                                    'tax_amount'   => (string) round($taxAmount, 2),
                                    'net_profit'   => (string) round($netProfit, 2),
                                ],
                            ];
                        })->values();

                        return [
                            'id'            => (string) $product->id,
                            'name'          => $product->name,
                            'min_deposit'   => (string) $product->min_deposit,
                            'affiliate_link' => $product->referral_link,
                            'rates'         => $rates,
                        ];
                    })->values();

                return [
                    'bank' => [
                        'id'          => (string) $bank->id,
                        'name'        => $bank->name,
                        'logo'        => $bank->logo_url ? asset('storage/' . $bank->logo_url) : null,
                        'type'        => ucfirst($bank->type),
                        'color'       => $bank->color_code,
                        'website'     => $bank->website_url,
                        'description' => $bank->description,
                        'stock_code'  => $bank->stock_code,
                    ],
                    'products' => $products,
                ];
            })->values();

            return $this->successResponse([
                'count'  => (string) $data->count(),
                'params' => [
                    'amount'    => (string) $amount,
                    'duration'  => $duration ? (string) $duration : null,
                    'bank_type' => $bankType,
                ],
                'data' => $data,
            ]);

        } catch (\Exception $e) {
            return $this->errorResponse(
                'Terjadi kesalahan saat mengambil data bank & deposito',
                ['error' => $e->getMessage()],
                500
            );
        }
    }

    public function byBank(Request $request)
    {
        // 1. Validasi Parameter Wajib
        $validated = $request->validate([
            'bank_id' => 'required|integer|exists:banks,id',
        ], [
            'bank_id.required' => 'Parameter bank_id wajib diisi.',
            'bank_id.integer'  => 'Parameter bank_id harus berupa angka.',
            'bank_id.exists'   => 'Bank dengan ID tersebut tidak ditemukan.',
        ]);

        try {
            $bankId = $validated['bank_id'];

            // 2. Ambil data bank beserta semua produk aktif & rate-nya
            $bank = Bank::with([
                'products' => function ($q) {
                    $q->where('is_active', true)
                      ->with([
                          'rates' => function ($rq) {
                              $rq->orderBy('duration_months', 'asc');
                          }
                      ]);
                }
            ])->findOrFail($bankId);

            // 3. Format produk & rate
            $products = $bank->products->map(function ($product) {
                $rates = $product->rates->map(function ($rate) {
                    $netInterestRate = $rate->interest_rate
                        - ($rate->interest_rate * ($rate->tax_percent / 100));

                    return [
                        'duration_months'   => (string) $rate->duration_months,
                        'duration_text'     => $rate->duration_months . ' Bulan',
                        'interest_rate'     => (string) $rate->interest_rate,
                        'tax_percent'       => (string) $rate->tax_percent,
                        'net_interest_rate' => (string) round($netInterestRate, 4),
                    ];
                })->values();

                return [
                    'id'             => (string) $product->id,
                    'name'           => $product->name,
                    'min_deposit'    => (string) $product->min_deposit,
                    'affiliate_link' => $product->referral_link,
                    'total_rates'    => (string) $rates->count(),
                    'rates'          => $rates,
                ];
            })->values();

            // 4. Format Response
            $data = [
                'bank' => [
                    'id'          => (string) $bank->id,
                    'name'        => $bank->name,
                    'logo'        => $bank->logo_url ? asset('storage/' . $bank->logo_url) : null,
                    'type'        => ucfirst($bank->type),
                    'color'       => $bank->color_code,
                    'website'     => $bank->website_url,
                    'description' => $bank->description,
                    'stock_code'  => $bank->stock_code,
                ],
                'total_products' => (string) $products->count(),
                'products'       => $products,
            ];

            return $this->successResponse($data);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Bank tidak ditemukan.', null, 404);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Terjadi kesalahan saat mengambil data deposito bank',
                ['error' => $e->getMessage()],
                500
            );
        }
    }
}
