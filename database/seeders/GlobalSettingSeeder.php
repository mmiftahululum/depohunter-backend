<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GlobalSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('global_settings')->truncate();
        DB::table('global_settings')->insert(array (
  0 => 
  array (
    'id' => 1,
    'key' => 'bi_rate',
    'label' => 'BI Rate (Suku Bunga Acuan)',
    'value' => '6.75',
    'created_at' => '2026-01-01 17:00:58',
    'updated_at' => '2026-10-29 08:49:09',
  ),
  1 => 
  array (
    'id' => 2,
    'key' => 'lps_limit_general',
    'label' => 'Batas LPS (Bank Umum/Digital)',
    'value' => '4.25',
    'created_at' => '2026-01-01 17:00:58',
    'updated_at' => '2026-01-01 17:00:58',
  ),
  2 => 
  array (
    'id' => 3,
    'key' => 'lps_limit_bpr',
    'label' => 'Batas LPS (BPR)',
    'value' => '6.25',
    'created_at' => '2026-01-01 17:00:58',
    'updated_at' => '2026-10-29 08:49:49',
  ),
));
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
