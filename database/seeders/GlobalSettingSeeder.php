<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GlobalSetting;

class GlobalSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. BI Rate
        GlobalSetting::create([
            'key' => 'bi_rate', 
            'label' => 'BI Rate (Suku Bunga Acuan)', 
            'value' => 6.00
        ]);
        
        // 2. Batas LPS Bank Umum
        GlobalSetting::create([
            'key' => 'lps_limit_general', 
            'label' => 'Batas LPS (Bank Umum/Digital)', 
            'value' => 4.25
        ]);
        
        // 3. Batas LPS BPR
        GlobalSetting::create([
            'key' => 'lps_limit_bpr', 
            'label' => 'Batas LPS (BPR)', 
            'value' => 6.75
        ]);
    }
}