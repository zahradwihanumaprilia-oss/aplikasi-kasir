<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuOnlineController;
use App\Http\Controllers\Admin\{
    KategoriController, 
    ProdukController, 
    DashboardController, 
    LaporanController, 
    UserController
};
use App\Http\Controllers\Kasir\OrderController as KasirOrderController;
use App\Http\Controllers\MidtransWebhookController;

// 1. Redirect Utama
Route::get('/', fn() => redirect()->route('login'));

// 2. Redirect setelah Login (Role-based)
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasAnyRole(['admin', 'pimpinan', 'kasir'])) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('menu.index');
})->middleware(['auth'])->name('dashboard');

// 3. Menu Online (PUBLIC - Tanpa Middleware Auth agar bisa diakses pelanggan)
Route::get('/menu', [MenuOnlineController::class, 'index'])->name('menu.index');
Route::post('/menu/pesan', [MenuOnlineController::class, 'store'])->name('menu.pesan');
Route::post('/menu/checkout-sistem', [MenuOnlineController::class, 'checkoutSistem'])->name('menu.checkout_sistem');
Route::get('/pesanan/struk/{id}', [LaporanController::class, 'cetakStruk'])->name('pesanan.struk');

// 4. Webhook (PUBLIC)
Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handleNotification']);

// 5. Auth Routes
require __DIR__.'/auth.php';

// 6. Akses Khusus User yang Sudah Login
Route::middleware(['auth'])->group(function () {
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Akses Operasional & Bersama (Admin, Kasir, Pimpinan)
    Route::middleware(['role:admin|kasir|pimpinan'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('admin/produk', ProdukController::class)->names('admin.produk');
        Route::get('/admin/riwayat-pesanan', [LaporanController::class, 'riwayatPesanan'])->name('admin.pesanan.index');
    });

    // Akses Manajemen (Khusus Admin & Pimpinan)
    Route::middleware(['role:admin|pimpinan'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('kategori', KategoriController::class);
        Route::resource('user', UserController::class);
        Route::get('/laporan', [LaporanController::class, 'menuLaporan'])->name('laporan.index');
    });

    // Akses Khusus Kasir
    Route::middleware(['role:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
        Route::get('/antrian', [KasirOrderController::class, 'index'])->name('dashboard');
        Route::post('/pesanan/konfirmasi-antar/{id}', [KasirOrderController::class, 'konfirmasiAntar'])->name('konfirmasi_antar');
        Route::post('/pesanan/bayar-tunai/{id}', [KasirOrderController::class, 'bayarTunai'])->name('orders.bayar_tunai');
        Route::post('/pesanan/proses-qris/{id}', [KasirOrderController::class, 'prosesQris'])->name('orders.proses_qris');
    });
});