<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // ⬇️ Tambahkan ini agar Laravel tahu kamu pakai tabel 'pembayarans', bukan 'payments'
    protected $table = 'pembayarans';

    protected $fillable = [
        'product_id',
        'tanggal_pembayaran',
        'metode_pembayaran',
        'status_pembayaran',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
