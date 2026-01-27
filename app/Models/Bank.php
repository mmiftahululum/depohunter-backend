<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    // Agar semua kolom bisa diisi via Filament
    protected $guarded = []; 

    public function products()
    {
        return $this->hasMany(DepositProduct::class);
    }
}