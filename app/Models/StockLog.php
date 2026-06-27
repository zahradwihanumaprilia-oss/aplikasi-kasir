<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    use HasFactory;

    protected $table = 'stock_logs';

    protected $fillable = [
        'produk_id',
        'pengguna_id',
        'tipe',
        'stok_sebelum',
        'perubahan',
        'catatan'
    ];

    // RELASI: Log mutasi ini mencatat perubahan pada produk tertentu (belongsTo)
    public function product()
    {
        return $this->belongsTo(Product::class, 'produk_id', 'id');
    }

    // RELASI: Log mutasi ini dieksekusi/diinput oleh petugas tertentu (belongsTo)
    public function user()
    {
        return $this->belongsTo(User::class, 'pengguna_id', 'id');
    }
}