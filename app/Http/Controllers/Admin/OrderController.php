<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // 💡 Pastikan memanggil model Order kamu

class OrderController extends Controller
{
    public function index()
    {
        // Ambil data transaksi terbaru dari database untuk ditampilkan ke admin
        $orders = Order::orderBy('created_at', 'desc')->get();
        
        return view('admin.pesanan.index', compact('orders'));
    }

    public function cetakStruk($id)
    {
        // Fungsi pemicu cetak struk dari baris tabel riwayat
        $order = Order::with(['items.product', 'orderItems.product'])->findOrFail($id);
        return view('admin.pesanan.struk', compact('order'));
    }
}