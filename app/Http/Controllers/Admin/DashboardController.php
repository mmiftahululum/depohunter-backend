<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\DepositProduct;
use App\Models\DepositRate;
use App\Models\GlobalSetting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBanks = Bank::count();
        $totalProducts = DepositProduct::count();
        $totalRates = DepositRate::count();
        
        $settings = GlobalSetting::all()->keyBy('key');
        $biRate = $settings->get('bi_rate')?->value ?? 6.00;
        $lpsLimitGeneral = $settings->get('lps_limit_general')?->value ?? 4.25;
        $lpsLimitBpr = $settings->get('lps_limit_bpr')?->value ?? 6.75;

        // Top 5 Suku Bunga Tertinggi
        $topRates = DepositRate::with(['product.bank'])
            ->orderBy('interest_rate', 'desc')
            ->limit(5)
            ->get();

        // Bank Terbaru
        $recentBanks = Bank::withCount('products')
            ->latest()
            ->limit(5)
            ->get();

        // Distribusi Tipe Bank
        $bankTypesCount = [
            'digital' => Bank::where('type', 'digital')->count(),
            'konvensional' => Bank::where('type', 'konvensional')->count(),
            'bpr' => Bank::where('type', 'bpr')->count(),
        ];

        return view('admin.dashboard', compact(
            'totalBanks',
            'totalProducts',
            'totalRates',
            'biRate',
            'lpsLimitGeneral',
            'lpsLimitBpr',
            'topRates',
            'recentBanks',
            'bankTypesCount'
        ));
    }
}
