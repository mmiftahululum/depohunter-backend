<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('banks')->truncate();
        DB::table('banks')->insert(array (
  0 => 
  array (
    'id' => 1,
    'name' => 'Jago',
    'logo_url' => 'bank-logos/01KP84AQPK5CJAETVGC7A22AS9.jpg',
    'description' => 'Bank Jago awalnya bernama Bank Artos Indonesia, yang berdiri sebagai bank konvensional. Pada tahun 2019, perusahaan investasi digital PT Metamorfosis Ekosistem Indonesia (bagian dari ekosistem Gojek) mulai berinvestasi dan mengambil alih kepemilikan.

Sejak saat itu, bank ini bertransformasi menjadi bank digital dan resmi berganti nama menjadi Bank Jago pada tahun 2020. Transformasi ini fokus pada pengembangan layanan keuangan berbasis aplikasi yang terintegrasi dengan ekosistem digital, termasuk kerja sama dengan Gojek.

Kini, Bank Jago dikenal sebagai salah satu pionir bank digital di Indonesia yang mengutamakan kemudahan, fleksibilitas, dan inovasi dalam pengelolaan keuangan.',
    'code_saham' => 'ARTO',
    'color_code' => '#000000',
    'type' => 'digital',
    'is_ojk_verified' => 1,
    'is_lps_insured' => 1,
    'created_at' => '2026-01-01 14:08:47',
    'updated_at' => '2026-04-16 01:45:04',
  ),
  1 => 
  array (
    'id' => 2,
    'name' => 'Amar Bank',
    'logo_url' => 'bank-logos/01KG003BVEN64VA8C9EYAM38TD.png',
    'description' => NULL,
    'code_saham' => NULL,
    'color_code' => '#000000',
    'type' => 'digital',
    'is_ojk_verified' => 1,
    'is_lps_insured' => 1,
    'created_at' => '2026-01-27 15:10:36',
    'updated_at' => '2026-01-27 15:10:36',
  ),
  2 => 
  array (
    'id' => 3,
    'name' => 'Sea Bank',
    'logo_url' => 'bank-logos/01KSS6Z8HVGHK1D9X2VMP33HY3.png',
    'description' => 'SeaBank (PT Bank SeaBank Indonesia) adalah bank digital yang berafiliasi dengan Sea Group (perusahaan induk Shopee dan Garena). Layanan ini menyediakan aplikasi perbankan terintegrasi untuk menabung, bertransaksi, dan deposito.',
    'code_saham' => 'NYSE',
    'color_code' => '#000000',
    'type' => 'digital',
    'is_ojk_verified' => 1,
    'is_lps_insured' => 1,
    'created_at' => '2026-05-29 06:32:59',
    'updated_at' => '2026-05-29 06:32:59',
  ),
  3 => 
  array (
    'id' => 4,
    'name' => 'BCA',
    'logo_url' => 'bank-logos/QXgaWJppxzFqWx4GCsVPxzuje89XwMVp0pqwEC99.png',
    'description' => 'Bank Central Asia (BCA) adalah bank swasta terbesar di Indonesia berdasarkan total aset dan kapitalisasi pasar. Bank ini didirikan pada 21 Februari 1957 dan pernah menjadi bagian penting dari Grup Salim. Saat ini BCA dikendalikan oleh keluarga Hartono melalui PT Dwimuria Investama Andalan, perusahaan yang terkait dengan grup Djarum.[2]

Per akhir 2025, BCA memiliki total aset sebesar Rp 1.586,8 triliun dan membukukan laba bersih Rp 57,5 triliun.[1] Bank ini melayani lebih dari 43 juta rekening nasabah dan memproses lebih dari 115 juta transaksi setiap hari.[3]',
    'code_saham' => 'BBCA',
    'color_code' => '#1a7dff',
    'type' => 'konvensional',
    'is_ojk_verified' => 1,
    'is_lps_insured' => 1,
    'created_at' => '2026-10-29 12:24:29',
    'updated_at' => '2026-10-29 12:24:29',
  ),
  4 => 
  array (
    'id' => 5,
    'name' => 'MANDIRI',
    'logo_url' => 'bank-logos/siEdpnshQHgiglkgf4xYvmFBEZqnXB1iJaKztuGN.png',
    'description' => 'PT Bank Mandiri (Persero) Tbk adalah sebuah badan usaha milik negara Indonesia yang bergerak di bidang perbankan korporat. Pemerintah Indonesia memegang mayoritas saham perusahaan ini melalui Danantara.

Untuk mendukung kegiatan bisnisnya, hingga akhir tahun 2025, bank ini memiliki 139 unit Kantor Cabang, 2.014 Kantor Cabang Pembantu, dan 12.972 unit mesin ATM dan CRM yang tersebar di seluruh Indonesia. Bank ini juga memiliki kantor di Shanghai, Cayman Islands, Dili, Hong Kong (termasuk kantor remitansi), dan Singapura, dengan kantor cabang anak perusahaan di Kuala Lumpur (Mandiri International Remittance) dan London.[3][4]',
    'code_saham' => 'BMRI',
    'color_code' => '#4f46e5',
    'type' => 'konvensional',
    'is_ojk_verified' => 1,
    'is_lps_insured' => 1,
    'created_at' => '2026-10-30 11:36:58',
    'updated_at' => '2026-10-30 11:36:58',
  ),
));
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
