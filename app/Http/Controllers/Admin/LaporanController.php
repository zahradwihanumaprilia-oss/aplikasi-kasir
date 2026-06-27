<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem; // 💡 SAKRAL: Wajib dipanggil agar hitungan porsi terjual bebas error sql
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    // ==============================================================
    // 1. MENAMPILKAN RIWAYAT PESANAN MASUK (HANYA YANG LUNAS)
    // ==============================================================
    public function riwayatPesanan()
    {
        // Hanya ambil pesanan yang statusnya 'lunas' atau 'selesai_diantar'
        $orders = Order::whereIn('status', ['lunas', 'selesai_diantar'])
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('admin.pesanan.index', compact('orders'));
    }

    // ==============================================================
    // 2. HALAMAN CETAK STRUK KASIR (MODEL THERMAL ALFAMART)
    // ==============================================================
    public function cetakStruk($id)
    {
        // 💡 PERBAIKAN: Hapus 'orderItems' kalau memang tidak ada di Model Order, 
        // gunakan 'items' saja (sesuaikan dengan nama fungsi di Model Order.php milikmu)
        $order = Order::with(['items.product']) 
            ->where('id', $id)
            ->orWhere('kode_pesanan', $id)
            ->firstOrFail();

        return view('admin.pesanan.struk', compact('order'));
    }

    // ==============================================================
    // 3. MENU LAPORAN UTAMA (NERACA KEUANGAN + RADAR KONTROL STOK)
    // ==============================================================
    public function menuLaporan(Request $request)
    {
        // --- SECTION A: RINGKASAN DATA KEUANGAN ---
        $totalOmzetLunas = Order::whereIn('status', ['lunas', 'success'])->sum('total_harga');
        $estimasiProfit = $totalOmzetLunas * 0.25;
        
        // Menghitung total porsi terjual (Sudah aman membaca pesanan_id sesuai database kamu)
        $totalItemTerjual = OrderItem::whereHas('order', function($query) {
                $query->whereIn('status', ['lunas', 'success']);
            })->sum('jumlah');

        // --- SECTION B: RADAR KONTROL STOK BARANG ---
        $stokMenipisCount = Product::where('stok', '<', 10)->where('stok', '>', 0)->count();
        $stokHabisCount = Product::where('stok', '<=', 0)->count();

        $produkKritis = Product::with('category')
            ->orderBy('stok', 'asc')
            ->take(5)
            ->get();

        // --- SECTION C: AMBIL DATA URUTAN PRODUK TERLARIS (PAKSA KOLOM LOKAL BAWAAN INDONESIA) ---
        // 💡 Solusi Jitu: Kita pakai manual Join & GroupBy agar terbebas 100% dari tebakan nama kolom otomatis Laravel!
        $produkTerlaris = Product::join('order_items', 'products.id', '=', 'order_items.produk_id')
            ->join('orders', 'order_items.pesanan_id', '=', 'orders.id')
            ->whereIn('orders.status', ['lunas', 'success'])
            ->select('products.*', DB::raw('SUM(order_items.jumlah) as total_terjual'))
            ->groupBy('products.id', 'products.kategori_id', 'products.nama', 'products.slug', 'products.harga_jual', 'products.stok', 'products.gambar', 'products.deskripsi', 'products.tersedia', 'products.created_at', 'products.updated_at')
            ->orderBy('total_terjual', 'desc')
            ->take(5)
            ->get();

        return view('admin.laporan.index', compact(
            'totalOmzetLunas', 
            'estimasiProfit', 
            'totalItemTerjual', 
            'stokMenipisCount', 
            'stokHabisCount', 
            'produkKritis',
            'produkTerlaris'
        ));
    }
}