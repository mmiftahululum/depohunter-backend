<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DepositProduct;
use App\Models\DepositRate;

class Bank extends Model
{
    use HasFactory;

    // Agar semua kolom bisa diisi via Filament
    protected $guarded = []; 

    public function products()
    {
        return $this->hasMany(DepositProduct::class);
    }

    public function depositProducts()
    {
        return $this->hasMany(DepositProduct::class);
    }

    /**
     * Retrieve all deposit rates associated with the bank via its products.
     */
    public function depositRates()
    {
        return $this->hasManyThrough(
            DepositRate::class,
            DepositProduct::class,
            'bank_id', // Foreign key on DepositProduct
            'deposit_product_id', // Foreign key on DepositRate
            'id', // Local key on Bank
            'id' // Local key on DepositProduct
        );
    }
}
