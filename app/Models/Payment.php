<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'pesanan_id',
        'metode',
        'nominal_bayar',
        'ref_qris',
        'status',
        'lunas_pada'
    ];

    protected $casts = [
        'lunas_pada' => 'datetime',
    ];

    // RELASI: Data invoice pembayaran ini ditujukan untuk sebuah pesanan tertentu (belongsTo)
    public function order()
    {
        return $this->belongsTo(Order::class, 'pesanan_id', 'id');
    }
}