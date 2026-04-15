<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index()
    {
        try {
            $settings = GlobalSetting::all(['key', 'value', 'label']);
            $formattedSettings = $settings->pluck('value', 'key');

            // Hitung Summary Bank
            $digitalBanks = \App\Models\Bank::where('type', 'digital')->count();
            $nonDigitalBanks = \App\Models\Bank::where('type', '!=', 'digital')->count();

            return $this->successResponse([
                'settings' =>$formattedSettings,
                'summary' => [
                    'digital_banks' =>(string) $digitalBanks,
                    'non_digital_banks' =>(string) $nonDigitalBanks,
                    'total_banks' =>(string) ($digitalBanks + $nonDigitalBanks)
                ],
                // 'meta' => $settings 
            ]);

        } catch (\Exception $e) {
            return $this->errorResponse(
                'Gagal mengambil data konfigurasi',
                ['error' => $e->getMessage()]
            );
        }
    }
}