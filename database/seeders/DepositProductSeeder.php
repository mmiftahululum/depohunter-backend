<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepositProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('deposit_products')->truncate();
        DB::table('deposit_products')->insert(array (
  0 => 
  array (
    'id' => 1,
    'bank_id' => 1,
    'name' => 'Deposito Reguler 1jt',
    'min_deposit' => '1000000.00',
    'description' => NULL,
    'referral_link' => 'https://jago.com/id/kantong/deposito',
    'is_active' => 1,
    'created_at' => '2026-01-01 14:27:45',
    'updated_at' => '2026-10-29 10:31:01',
  ),
  1 => 
  array (
    'id' => 2,
    'bank_id' => 1,
    'name' => 'Deposito Reguler 100jt',
    'min_deposit' => '100000000.00',
    'description' => NULL,
    'referral_link' => 'https://jago.com/id/kantong/deposito',
    'is_active' => 1,
    'created_at' => '2026-01-01 14:38:36',
    'updated_at' => '2026-10-29 10:31:01',
  ),
  2 => 
  array (
    'id' => 3,
    'bank_id' => 1,
    'name' => 'Deposito Reguler 500jt',
    'min_deposit' => '500000000.00',
    'description' => NULL,
    'referral_link' => 'https://jago.com/id/kantong/deposito',
    'is_active' => 1,
    'created_at' => '2026-01-01 14:39:03',
    'updated_at' => '2026-10-29 10:31:01',
  ),
  3 => 
  array (
    'id' => 4,
    'bank_id' => 1,
    'name' => 'Deposito Reguler 1M',
    'min_deposit' => '1000000000.00',
    'description' => NULL,
    'referral_link' => 'https://jago.com/id/kantong/deposito',
    'is_active' => 1,
    'created_at' => '2026-01-01 14:58:07',
    'updated_at' => '2026-10-29 10:31:01',
  ),
  4 => 
  array (
    'id' => 5,
    'bank_id' => 2,
    'name' => 'Deposito',
    'min_deposit' => '1000000.00',
    'description' => NULL,
    'referral_link' => 'https://amarbank.co.id',
    'is_active' => 1,
    'created_at' => '2026-01-27 15:15:29',
    'updated_at' => '2026-10-29 10:31:01',
  ),
  5 => 
  array (
    'id' => 6,
    'bank_id' => 3,
    'name' => 'Deposito 1 Juta',
    'min_deposit' => '1000000.00',
    'description' => NULL,
    'referral_link' => 'https://seabank.co.id',
    'is_active' => 1,
    'created_at' => '2026-05-29 06:37:04',
    'updated_at' => '2026-10-29 10:31:01',
  ),
  6 => 
  array (
    'id' => 7,
    'bank_id' => 4,
    'name' => 'DEPOSITO 8jt',
    'min_deposit' => '8000000.00',
    'description' => NULL,
    'referral_link' => NULL,
    'is_active' => 1,
    'created_at' => '2026-10-29 14:41:41',
    'updated_at' => '2026-10-29 14:41:41',
  ),
  7 => 
  array (
    'id' => 8,
    'bank_id' => 4,
    'name' => 'DEPOSITO 2M',
    'min_deposit' => '2000000000.00',
    'description' => NULL,
    'referral_link' => NULL,
    'is_active' => 1,
    'created_at' => '2026-10-29 14:47:19',
    'updated_at' => '2026-10-29 14:47:31',
  ),
  8 => 
  array (
    'id' => 9,
    'bank_id' => 5,
    'name' => 'DEPOSITO',
    'min_deposit' => '1000000.00',
    'description' => NULL,
    'referral_link' => 'https://www.bankmandiri.co.id/suku-bunga-dana',
    'is_active' => 1,
    'created_at' => '2026-10-30 11:39:45',
    'updated_at' => '2026-10-30 11:40:49',
  ),
));
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
