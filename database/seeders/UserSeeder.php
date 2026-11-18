<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('users')->insert(array (
  0 => 
  array (
    'id' => 1,
    'name' => 'muhammad miftahul ulum',
    'email' => 'muhammadmu35@gmail.com',
    'email_verified_at' => NULL,
    'password' => '$2y$12$RLg90pdiH1zsyE22rXAIfeoF8xJZbYz5VZoSkzCBvWXA041tJ/mOa',
    'remember_token' => 'QSo5AMRCqJ1blfIYDJJzGzvtZLENTRwwRKAPo2rFrvsnEXPddkfWtCbiliry',
    'created_at' => '2026-01-01 11:37:16',
    'updated_at' => '2026-01-01 11:37:16',
  ),
));
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
