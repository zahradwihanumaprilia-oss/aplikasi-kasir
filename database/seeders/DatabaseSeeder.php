<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==============================================================
        // 1. MEMBUAT ROLE SPATIE (HAK AKSES)
        // ==============================================================
        $roleAdmin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $roleKasir = Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $rolePimpinan = Role::create(['name' => 'pimpinan', 'guard_name' => 'web']);

        // ==============================================================
        // 2. MEMBUAT DATA PENGGUNA (USERS) AWAL - SINKRON UTARA BREEZE
        // ==============================================================
        
        // Akun Utama Admin
        $admin = User::create([
            'name' => 'Admin Utama', // 💡 DIUBAH: Menggunakan 'name' agar sinkron dengan tabel
            'email' => 'admin@apps.com',
            'password' => Hash::make('password123'), // 💡 DIUBAH: Menggunakan 'password' agar sinkron dengan tabel
        ]);
        $admin->assignRole($roleAdmin);

        // Akun Utama Kasir
        $kasir = User::create([
            'name' => 'Kasir Toko', // 💡 DIUBAH: Menggunakan 'name'
            'email' => 'kasir@apps.com',
            'password' => Hash::make('password123'), // 💡 DIUBAH: Menggunakan 'password'
        ]);
        $kasir->assignRole($roleKasir);

        // Akun Utama Pimpinan / Owner
        $pimpinan = User::create([
            'name' => 'Pimpinan Cafe', // 💡 DIUBAH: Menggunakan 'name'
            'email' => 'pimpinan@apps.com',
            'password' => Hash::make('password123'), // 💡 DIUBAH: Menggunakan 'password'
        ]);
        $pimpinan->assignRole($rolePimpinan);


        // ==============================================================
        // 3. MEMBUAT DATA KATEGORI MENU (CATEGORIES) - TETAP BAHASA INDONESIA sesuai ERD
        // ==============================================================
        $katMakanan = Category::create([
            'nama' => 'Makanan Utama',
            'ikon' => 'fa-utensils',
            'urutan' => 1,
            'aktif' => true,
        ]);

        $katMinuman = Category::create([
            'nama' => 'Minuman Segar',
            'ikon' => 'fa-mug-hot',
            'urutan' => 2,
            'aktif' => true,
        ]);

        $katSnack = Category::create([
            'nama' => 'Camilan / Snack',
            'ikon' => 'fa-cookie',
            'urutan' => 3,
            'aktif' => true,
        ]);


        // ==============================================================
        // 4. MEMBUAT DATA PRODUK (PRODUCTS) & STOKNYA (STOCK)
        // ==============================================================
        
        // --- Produk Kategori Makanan ---
        $p1 = Product::create([
            'kategori_id' => $katMakanan->id,
            'nama' => 'Nasi Goreng Spesial',
            'slug' => Str::slug('Nasi Goreng Spesial'),
            'harga_jual' => 25000.00,
            'gambar' => null,
            'deskripsi' => 'Nasi goreng dengan bumbu racikan khas, telur mata sapi, dan kerupuk udang.',
            'tersedia' => true,
        ]);
        Stock::create([
            'produk_id' => $p1->id,
            'jumlah' => 50,
            'stok_minimum' => 5
        ]);

        $p2 = Product::create([
            'kategori_id' => $katMakanan->id,
            'nama' => 'Mie Goreng Jawa',
            'slug' => Str::slug('Mie Goreng Jawa'),
            'harga_jual' => 22000.00,
            'gambar' => null,
            'deskripsi' => 'Mie kuning tebal dimasak dengan sayuran segar, ayam suwir, dan kekian telur.',
            'tersedia' => true,
        ]);
        Stock::create([
            'produk_id' => $p2->id,
            'jumlah' => 40,
            'stok_minimum' => 5
        ]);

        // --- Produk Kategori Minuman ---
        $p3 = Product::create([
            'kategori_id' => $katMinuman->id,
            'nama' => 'Es Teh Manis Jumbo',
            'slug' => Str::slug('Es Teh Manis Jumbo'),
            'harga_jual' => 5000.00,
            'gambar' => null,
            'deskripsi' => 'Teh melati pilihan disajikan dingin manis ukuran gelas besar.',
            'tersedia' => true,
        ]);
        Stock::create([
            'produk_id' => $p3->id,
            'jumlah' => 100,
            'stok_minimum' => 10
        ]);

        $p4 = Product::create([
            'kategori_id' => $katMinuman->id,
            'nama' => 'Kopi Susu Gula Aren',
            'slug' => Str::slug('Kopi Susu Gula Aren'),
            'harga_jual' => 18000.00,
            'gambar' => null,
            'deskripsi' => 'Perpaduan espresso arabika, susu cair segar, dan sirup gula aren murni.',
            'tersedia' => true,
        ]);
        Stock::create([
            'produk_id' => $p4->id,
            'jumlah' => 60,
            'stok_minimum' => 8
        ]);

        // --- Produk Kategori Camilan ---
        $p5 = Product::create([
            'kategori_id' => $katSnack->id,
            'nama' => 'Kentang Goreng Krispi',
            'slug' => Str::slug('Kentang Goreng Krispi'),
            'harga_jual' => 15000.00,
            'gambar' => null,
            'deskripsi' => 'French fries digoreng garing bertabur sedikit garam gurih.',
            'tersedia' => true,
        ]);
        Stock::create([
            'produk_id' => $p5->id,
            'jumlah' => 30,
            'stok_minimum' => 5
        ]);
    }
}