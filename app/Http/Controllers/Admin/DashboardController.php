<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Product, Category, User, Order};
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama admin.
     */
    public function index()
    {
        // 1. Data Keuangan
        $totalOmzet = Order::whereIn('status', ['lunas', 'success'])->sum('total_harga');
        $totalProfit = $totalOmzet * 0.25; // Margin 25%

        // 2. Statistik Operasional
        $totalTransaksi = Order::whereIn('status', ['lunas', 'success'])->count();
        $totalUsers = User::count();

        // 3. Data Grafik Kategori
        $kategoriData = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(4)
            ->get();

        $donutLabels = $kategoriData->pluck('nama')->toArray();
        $donutValues = $kategoriData->pluck('products_count')->toArray();

        // 4. Produk Kritis (Stok < 10)
        $topProducts = Product::with('category')
            ->where('stok', '<', 10)
            ->orderBy('stok', 'asc')
            ->take(4)
            ->get();

        return view('admin.dashboard', compact(
            'totalOmzet',
            'totalProfit',
            'totalTransaksi',
            'totalUsers',
            'donutLabels',
            'donutValues',
            'topProducts'
        ));
    }
}