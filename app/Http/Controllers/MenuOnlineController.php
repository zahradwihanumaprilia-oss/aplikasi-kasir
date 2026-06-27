<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Exception;

class MenuOnlineController extends Controller
{
    public function index()
    {
        $produks = Product::with(['category'])
            ->orderBy('stok', 'desc')
            ->get();
            
        return view('menu-online', compact('produks'));
    }

   public function checkoutSistem(Request $request)
    {
        try {
            $request->validate([
                'total_harga' => 'required|numeric',
                'items' => 'required|array'
            ]);

            return DB::transaction(function () use ($request) {
                $invoiceUnik = 'SMARTKASIR-' . time();

                // 1. Simpan Pesanan
                $order = Order::create([
                    'kode_pesanan' => $invoiceUnik,
                    'pengguna_id'  => null,
                    'total_harga'  => $request->total_harga,
                    'metode_bayar' => 'qris',
                    'status'       => 'pending',
                ]);

                // 2. Loop Items
                foreach ($request->items as $produkId => $qty) {
                    $produk = Product::find($produkId);
                    if ($produk && $produk->stok >= $qty) {
                        OrderItem::create([
                            'pesanan_id'   => $order->id,
                            'produk_id'    => $produk->id,
                            'jumlah'       => $qty,
                            'harga_satuan' => $produk->harga_jual,
                            'subtotal'     => $produk->harga_jual * $qty,
                        ]);
                        $produk->decrement('stok', $qty);
                    }
                }

                // 3. Konfigurasi Midtrans
                Config::$serverKey = env('MIDTRANS_SERVER_KEY');
                Config::$isProduction = false;
                Config::$isSanitized = true;
                Config::$is3ds = true;
                
                $params = [
                    'transaction_details' => [
                        'order_id' => $invoiceUnik,
                        'gross_amount' => (int) $request->total_harga,
                    ],
                    // Tambahkan detail ini agar Midtrans tidak reject transaksi
                    'customer_details' => [
                        'first_name' => 'Pelanggan',
                        'email' => 'pelanggan@smartkasir.com',
                    ],
                ];

                $snapToken = Snap::getSnapToken($params);

                return response()->json([
                    'success' => true,
                    'order_id_real' => $order->id,
                    'snap_token' => $snapToken 
                ]);
            });

        } catch (Exception $e) {
            // Tulis error ke log agar kamu bisa cek saat tombol stuck
            \Log::error('Checkout Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
}