<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'harga',
        'deskripsi',
    ];

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
}

