<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositRate extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product()
    {
        // Parameter kedua 'deposit_product_id' penting agar Laravel tahu foreign key-nya
        return $this->belongsTo(DepositProduct::class, 'deposit_product_id');
    }
}