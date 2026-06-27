<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    // Wajib daftarkan semua kolom ini agar bisa di-insert / update oleh controller
    protected $fillable = [
        'kategori_id',
        'nama',
        'slug',
        'harga_jual',
        'stok',
        'gambar',
        'deskripsi',
        'tersedia'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id', 'id');
    }

    public function stockLogs()
    {
        return $this->hasMany(StockLog::class, 'produk_id', 'id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'produk_id', 'id');
    }
    
    public function product()
    {
        // Pastikan foreign key di sini juga adalah 'produk_id'
        return $this->belongsTo(Product::class, 'produk_id', 'id');
    }
    
}