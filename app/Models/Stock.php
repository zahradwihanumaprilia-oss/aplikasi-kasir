<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stock';

    protected $fillable = [
        'produk_id',
        'jumlah',
        'stok_minimum'
    ];

    // RELASI: Baris kuantitas ini milik sebuah produk tertentu (belongsTo)
    public function product()
    {
        return $this->belongsTo(Product::class, 'produk_id', 'id');
    }
}