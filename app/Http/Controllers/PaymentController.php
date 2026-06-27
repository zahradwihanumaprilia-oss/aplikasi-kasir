<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\StokLog;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        
        // Keamanan Validasi: Hitung Signature Key untuk memastikan keaslian data dari Midtrans
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        // 1. Perbaikan: Tambahkan kurung kurawal pembuka { untuk proteksi signature
        if ($hashed == $request->signature_key) {
            
            $transaksi = Transaksi::where('kode_transaksi', $request->order_id)->first();

            if (!$transaksi) {
                return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
            }

            // Skenario jika transaksi berhasil diselesaikan oleh pelanggan
            if ($request->transaction_status == 'settlement') {
                $transaksi->update([
                    'status' => 'lunas',
                    'metode_bayar' => 'qris'
                ]);

                // Pengurangan kuantitas stok produk secara otomatis saat status lunas terkonfirmasi
                foreach ($transaksi->detailTransaksis as $detail) {
                    $produk = $detail->produk;
                    $produk->decrement('stok', $detail->jumlah);

                    StokLog::create([
                        'produk_id' => $produk->id,
                        'tipe' => 'keluar',
                        'jumlah' => $detail->jumlah,
                        'keterangan' => 'Sistem QRIS Otomatis ' . $transaksi->kode_transaksi
                    ]);
                } // 2. Perbaikan: Menutup foreach dengan benar
            }

            // 3. Perbaikan: Return ini ditaruh di luar block status 'settlement' agar status lain (seperti pending/expire) tetap mengembalikan respon sukses ke Midtrans
            return response()->json(['message' => 'Webhook berhasil diproses']);
            
        } // 4. Perbaikan: Menutup block signature validasi

        // Jika signature key tidak cocok
        return response()->json(['message' => 'Signature Key Tidak Valid'], 403);
    }
}