<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

        protected $fillable = [
        'kode_pesanan',
        'pengguna_id',
        'total_harga',
        'metode_bayar',
        'status',
        'catatan'
    ];

    // RELASI: Pesanan ini diproses oleh seorang kasir/pengguna (belongsTo)
    public function user()
    {
        return $this->belongsTo(User::class, 'pengguna_id', 'id');
    }

   // Pastikan fungsi ini ada di dalam Model Order kamu gaes
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'pesanan_id');
    }

    // RELASI: 1 Pesanan memiliki 1 catatan verifikasi Pembayaran Midtrans (hasOne)
    public function payment()
    {
        return $this->hasOne(Payment::class, 'pesanan_id', 'id');
    }
}