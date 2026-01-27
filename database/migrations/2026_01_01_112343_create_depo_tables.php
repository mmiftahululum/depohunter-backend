<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Tabel Banks
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('logo_url')->nullable(); 
            $table->string('color_code')->default('#000000');
            $table->enum('type', ['digital', 'konvensional', 'bpr']);
            $table->boolean('is_ojk_verified')->default(true);
            $table->boolean('is_lps_insured')->default(true);
            $table->timestamps();
        });

        // 2. Tabel Products (Jenis Deposito)
        Schema::create('deposit_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g. "Deposito Maksi"
            $table->decimal('min_deposit', 15, 2)->default(0); // Min penempatan
            $table->text('description')->nullable();
            $table->string('referral_link')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Tabel Rates (Bunga & Tenor)
        Schema::create('deposit_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deposit_product_id')->constrained('deposit_products')->onDelete('cascade');
            $table->integer('duration_months'); // 1, 3, 6, 12
            $table->float('interest_rate'); // % per tahun (e.g. 6.0)
            $table->decimal('tax_percent', 5, 2)->default(20.0); // Default pajak 20%
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deposit_rates');
        Schema::dropIfExists('deposit_products');
        Schema::dropIfExists('banks');
    }
};