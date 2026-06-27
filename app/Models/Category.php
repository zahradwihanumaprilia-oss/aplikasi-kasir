<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang asli di database
    protected $table = 'categories';

    protected $fillable = [
        'nama',
        'ikon',
        'urutan',
        'aktif'
    ];

    // RELASI: 1 Kategori memiliki banyak produk (hasMany)
    public function products()
    {
        return $this->hasMany(Product::class, 'kategori_id', 'id');
    }
}