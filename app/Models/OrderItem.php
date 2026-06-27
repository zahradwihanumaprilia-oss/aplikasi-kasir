<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    // 💡 KUNCI FIX: Daftarkan semua kolom database Anda di sini tanpa ada yang tertinggal
    // Pastikan tulisannya 'produk_id' menggunakan huruf K sesuai nama kolom di phpMyAdmin Anda!
    protected $fillable = [
        'pesanan_id',
        'produk_id', 
        'jumlah',
        'harga_satuan',
        'subtotal'
    ];

    // RELASI: Menghubungkan detail item ke pesanan induknya
    public function order()
    {
        return $this->belongsTo(Order::class, 'pesanan_id', 'id');
    }

    // RELASI: Menghubungkan detail item ke data produk kuliner terkait
    public function product()
    {
        return $this->belongsTo(Product::class, 'produk_id', 'id');
    }
}