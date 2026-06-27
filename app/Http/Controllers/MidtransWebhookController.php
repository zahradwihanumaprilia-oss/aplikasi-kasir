<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransWebhookController extends Controller
{
    public function handleNotification(Request $request)
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);

        try {
            $notif = new Notification();
            $transaction = $notif->transaction_status;
            $orderId = $notif->order_id;

            // Cari order berdasarkan kode_pesanan
            $order = Order::where('kode_pesanan', $orderId)->first();
            
            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Gunakan Database Transaction untuk menjaga integritas data
            DB::transaction(function () use ($order, $transaction) {
                
                // Jika pembayaran berhasil (settlement atau capture)
                if (in_array($transaction, ['settlement', 'capture'])) {
                    
                    // Cek status agar stok tidak berkurang dua kali (Double Processing Prevention)
                    if ($order->status !== 'lunas') {
                        $order->update(['status' => 'lunas']);

                        // Pengurangan Stok
                        foreach ($order->items as $item) {
                            $product = Product::find($item->produk_id);
                            if ($product) {
                                // Pastikan nama kolom 'qty' atau 'jumlah' sesuai dengan model OrderItem kamu
                                $qty = $item->jumlah ?? $item->qty; 
                                $product->decrement('stok', $qty);
                            }
                        }
                    }
                } 
                // Jika pembayaran pending
                elseif ($transaction == 'pending') {
                    $order->update(['status' => 'pending']);
                } 
                // Jika pembayaran dibatalkan/kadaluarsa
                elseif (in_array($transaction, ['deny', 'expire', 'cancel'])) {
                    $order->update(['status' => 'batal']);
                }
            });

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}