<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        // Kasir hanya melihat pesanan yang sudah Lunas dan belum Selesai
        $orders = Order::whereIn('status', ['lunas', 'selesai_diantar'])
                    ->orderBy('created_at', 'desc')
                    ->get();
                    
        return view('kasir.orders.index', compact('orders'));
    }

        // Pastikan fungsi ini tetap ada agar kasir bisa menandai pesanan selesai
    public function konfirmasiAntar($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status === 'lunas') { // Hanya pesanan lunas yang bisa diantar
            $order->update(['status' => 'selesai_diantar']);
            return redirect()->back()->with('success', 'Pesanan sedang diantar!');
        }
        return redirect()->back()->with('error', 'Pesanan belum dibayar.');
    }

}