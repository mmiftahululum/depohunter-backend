<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepositRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('deposit_rates')->truncate();
        DB::table('deposit_rates')->insert(array (
  0 => 
  array (
    'id' => 1,
    'deposit_product_id' => 1,
    'duration_months' => 1,
    'interest_rate' => 5.75,
    'tax_percent' => '20.00',
    'created_at' => '2026-01-01 14:29:18',
    'updated_at' => '2026-10-29 09:39:55',
  ),
  1 => 
  array (
    'id' => 2,
    'deposit_product_id' => 1,
    'duration_months' => 3,
    'interest_rate' => 5.25,
    'tax_percent' => '20.00',
    'created_at' => '2026-01-01 14:45:26',
    'updated_at' => '2026-06-18 10:39:14',
  ),
  2 => 
  array (
    'id' => 3,
    'deposit_product_id' => 1,
    'duration_months' => 6,
    'interest_rate' => 5.25,
    'tax_percent' => '20.00',
    'created_at' => '2026-01-01 14:55:04',
    'updated_at' => '2026-01-01 14:55:04',
  ),
  3 => 
  array (
    'id' => 4,
    'deposit_product_id' => 1,
    'duration_months' => 12,
    'interest_rate' => 5.25,
    'tax_percent' => '20.00',
    'created_at' => '2026-01-01 14:55:23',
    'updated_at' => '2026-01-01 14:55:23',
  ),
  4 => 
  array (
    'id' => 5,
    'deposit_product_id' => 2,
    'duration_months' => 1,
    'interest_rate' => 5.5,
    'tax_percent' => '20.00',
    'created_at' => '2026-01-01 15:12:19',
    'updated_at' => '2026-01-01 15:13:50',
  ),
  5 => 
  array (
    'id' => 6,
    'deposit_product_id' => 2,
    'duration_months' => 3,
    'interest_rate' => 5.5,
    'tax_percent' => '20.00',
    'created_at' => '2026-01-01 15:12:45',
    'updated_at' => '2026-01-01 15:12:45',
  ),
  6 => 
  array (
    'id' => 7,
    'deposit_product_id' => 2,
    'duration_months' => 6,
    'interest_rate' => 5.5,
    'tax_percent' => '20.00',
    'created_at' => '2026-01-01 15:13:04',
    'updated_at' => '2026-01-01 15:13:04',
  ),
  7 => 
  array (
    'id' => 8,
    'deposit_product_id' => 2,
    'duration_months' => 12,
    'interest_rate' => 5.5,
    'tax_percent' => '20.00',
    'created_at' => '2026-01-01 15:13:27',
    'updated_at' => '2026-01-01 15:13:27',
  ),
  8 => 
  array (
    'id' => 9,
    'deposit_product_id' => 3,
    'duration_months' => 1,
    'interest_rate' => 5.75,
    'tax_percent' => '20.00',
    'created_at' => '2026-01-01 15:15:36',
    'updated_at' => '2026-01-01 15:15:36',
  ),
  9 => 
  array (
    'id' => 10,
    'deposit_product_id' => 3,
    'duration_months' => 3,
    'interest_rate' => 5.75,
    'tax_percent' => '20.00',
    'created_at' => '2026-01-01 15:15:56',
    'updated_at' => '2026-01-01 15:15:56',
  ),
  10 => 
  array (
    'id' => 11,
    'deposit_product_id' => 3,
    'duration_months' => 6,
    'interest_rate' => 5.75,
    'tax_percent' => '20.00',
    'created_at' => '2026-01-01 15:16:18',
    'updated_at' => '2026-01-01 15:16:18',
  ),
  11 => 
  array (
    'id' => 12,
    'deposit_product_id' => 3,
    'duration_months' => 12,
    'interest_rate' => 5.75,
    'tax_percent' => '20.00',
    'created_at' => '2026-01-01 15:16:41',
    'updated_at' => '2026-01-01 15:16:41',
  ),
  12 => 
  array (
    'id' => 13,
    'deposit_product_id' => 4,
    'duration_months' => 1,
    'interest_rate' => 6,
    'tax_percent' => '20.00',
    'created_at' => '2026-01-01 15:17:05',
    'updated_at' => '2026-01-01 15:17:05',
  ),
  13 => 
  array (
    'id' => 14,
    'deposit_product_id' => 4,
    'duration_months' => 3,
    'interest_rate' => 6,
    'tax_percent' => '20.00',
    'created_at' => '2026-01-01 15:17:24',
    'updated_at' => '2026-01-01 15:17:24',
  ),
  14 => 
  array (
    'id' => 15,
    'deposit_product_id' => 4,
    'duration_months' => 6,
    'interest_rate' => 5.75,
    'tax_percent' => '20.00',
    'created_at' => '2026-01-01 15:17:45',
    'updated_at' => '2026-01-01 15:17:45',
  ),
  15 => 
  array (
    'id' => 16,
    'deposit_product_id' => 4,
    'duration_months' => 12,
    'interest_rate' => 5.75,
    'tax_percent' => '20.00',
    'created_at' => '2026-01-01 15:18:00',
    'updated_at' => '2026-01-01 15:18:00',
  ),
  16 => 
  array (
    'id' => 17,
    'deposit_product_id' => 5,
    'duration_months' => 1,
    'interest_rate' => 8.5,
    'tax_percent' => '20.00',
    'created_at' => '2026-01-27 15:39:53',
    'updated_at' => '2026-01-27 15:39:53',
  ),
  17 => 
  array (
    'id' => 18,
    'deposit_product_id' => 6,
    'duration_months' => 1,
    'interest_rate' => 3.75,
    'tax_percent' => '20.00',
    'created_at' => '2026-05-29 06:53:25',
    'updated_at' => '2026-05-29 06:53:25',
  ),
  18 => 
  array (
    'id' => 19,
    'deposit_product_id' => 6,
    'duration_months' => 3,
    'interest_rate' => 4.75,
    'tax_percent' => '20.00',
    'created_at' => '2026-05-29 07:15:01',
    'updated_at' => '2026-05-29 07:15:01',
  ),
  19 => 
  array (
    'id' => 20,
    'deposit_product_id' => 6,
    'duration_months' => 6,
    'interest_rate' => 5.25,
    'tax_percent' => '20.00',
    'created_at' => '2026-05-29 07:34:30',
    'updated_at' => '2026-05-29 07:34:30',
  ),
  20 => 
  array (
    'id' => 21,
    'deposit_product_id' => 6,
    'duration_months' => 12,
    'interest_rate' => 6,
    'tax_percent' => '20.00',
    'created_at' => '2026-05-29 07:34:40',
    'updated_at' => '2026-05-29 07:34:40',
  ),
  21 => 
  array (
    'id' => 22,
    'deposit_product_id' => 7,
    'duration_months' => 1,
    'interest_rate' => 2.75,
    'tax_percent' => '20.00',
    'created_at' => '2026-10-29 14:43:57',
    'updated_at' => '2026-10-29 14:43:57',
  ),
  22 => 
  array (
    'id' => 23,
    'deposit_product_id' => 7,
    'duration_months' => 6,
    'interest_rate' => 3,
    'tax_percent' => '20.00',
    'created_at' => '2026-10-29 14:44:47',
    'updated_at' => '2026-10-29 14:44:47',
  ),
  23 => 
  array (
    'id' => 24,
    'deposit_product_id' => 8,
    'duration_months' => 1,
    'interest_rate' => 3,
    'tax_percent' => '20.00',
    'created_at' => '2026-10-29 14:47:50',
    'updated_at' => '2026-10-29 14:47:50',
  ),
  24 => 
  array (
    'id' => 25,
    'deposit_product_id' => 9,
    'duration_months' => 1,
    'interest_rate' => 2.25,
    'tax_percent' => '20.00',
    'created_at' => '2026-10-30 11:40:09',
    'updated_at' => '2026-10-30 11:40:09',
  ),
));
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
