<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\DepositProduct;
use App\Models\DepositRate;
use App\Models\GlobalSetting;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Display the public homepage / banking intelligence dashboard.
     */
    public function index()
    {
        // 1. Settings (BI Rate, LPS Limits)
        $settings = GlobalSetting::all()->keyBy('key');
        $biRate = (float) ($settings->get('bi_rate')?->value ?? 6.00);
        $lpsLimitGeneral = (float) ($settings->get('lps_limit_general')?->value ?? 4.25);
        $lpsLimitBpr = (float) ($settings->get('lps_limit_bpr')?->value ?? 6.75);

        // 2. Bank Counts by Category
        $totalKonvensional = Bank::where('type', 'konvensional')->count();
        $totalDigital = Bank::where('type', 'digital')->count();
        $totalBpr = Bank::where('type', 'bpr')->count();
        $totalBanks = Bank::count();
        $totalProducts = DepositProduct::where('is_active', true)->count();
        $totalRates = DepositRate::count();

        // 3. Top Rates ordered by highest interest rate
        $topRates = DepositRate::with(['product.bank'])
            ->whereHas('product', function ($q) {
                $q->where('is_active', true);
            })
            ->orderBy('interest_rate', 'desc')
            ->get();

        // 4. Rate Averages
        $avgDigital = DepositRate::whereHas('product.bank', function ($q) {
            $q->where('type', 'digital');
        })->avg('interest_rate');
        $avgDigital = $avgDigital ? round($avgDigital, 2) : 6.25;

        $avgKonvensional = DepositRate::whereHas('product.bank', function ($q) {
            $q->where('type', 'konvensional');
        })->avg('interest_rate');
        $avgKonvensional = $avgKonvensional ? round($avgKonvensional, 2) : 4.10;

        // 5. Last updated date
        $latestRate = DepositRate::latest('updated_at')->first();
        $lastUpdated = $latestRate 
            ? Carbon::parse($latestRate->updated_at)->translatedFormat('d F Y') 
            : Carbon::now()->translatedFormat('d F Y');

        // Highest rate for initial calculator value
        $highestRate = $topRates->first()?->interest_rate ?? 8.00;

        return view('home', compact(
            'biRate',
            'lpsLimitGeneral',
            'lpsLimitBpr',
            'totalKonvensional',
            'totalDigital',
            'totalBpr',
            'totalBanks',
            'totalProducts',
            'totalRates',
            'topRates',
            'avgDigital',
            'avgKonvensional',
            'lastUpdated',
            'highestRate'
        ));
    }

    /**
     * Tampilkan halaman profil dan detail suku bunga deposito bank tertentu.
     */
    public function detailBank($id)
    {
        $bank = Bank::with(['products' => function ($q) {
            $q->where('is_active', true)->with(['rates' => function ($rq) {
                $rq->orderBy('duration_months', 'asc');
            }]);
        }])->findOrFail($id);

        // 1. Settings (BI Rate, LPS Limits)
        $settings = GlobalSetting::all()->keyBy('key');
        $biRate = (float) ($settings->get('bi_rate')?->value ?? 6.00);
        $lpsLimitGeneral = (float) ($settings->get('lps_limit_general')?->value ?? 4.25);
        $lpsLimitBpr = (float) ($settings->get('lps_limit_bpr')?->value ?? 6.75);

        // Kumpulkan semua rate bank ini
        $allRates = $bank->products->flatMap->rates;
        $maxRate = $allRates->max('interest_rate') ?? 0;
        $minRate = $allRates->min('interest_rate') ?? 0;

        // Tenors yang tersedia di bank ini
        $availableTenors = $allRates->pluck('duration_months')->unique()->sort()->values();

        // Bank lain untuk rekomendasi pembanding
        $otherBanks = Bank::where('id', '!=', $bank->id)
            ->withCount('products')
            ->with(['products' => function ($q) {
                $q->where('is_active', true)->with('rates');
            }])
            ->take(4)
            ->get();

        return view('detail-bank', compact(
            'bank',
            'biRate',
            'lpsLimitGeneral',
            'lpsLimitBpr',
            'allRates',
            'maxRate',
            'minRate',
            'availableTenors',
            'otherBanks'
        ));
    }
}
