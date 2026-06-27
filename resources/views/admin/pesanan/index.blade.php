@extends('layouts.app-internal')
@section('title', 'Riwayat Pemesanan')
@section('header_title', '📜 Riwayat Transaksi Penjualan')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    .font-premium { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>

<div class="font-premium w-full space-y-6">
    
    <div class="flex justify-between items-center bg-white/80 backdrop-blur-md px-5 py-3 rounded-2xl border border-gray-100 shadow-xs">
        <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-full flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-500"></i> Log Aktivitas Transaksi Lunas
        </span>
        <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-full border border-gray-200">
            Total: {{ $orders->count() }} Terbayar
        </span>
    </div>

    <div class="w-full bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
        <div class="p-4 bg-slate-50 border-b border-gray-100 font-bold text-sm text-slate-700 flex items-center gap-2">
            <i class="fa-solid fa-receipt text-slate-400"></i> Daftar Transaksi Pelanggan (Selesai)
        </div>

        <div class="p-6 w-full bg-white">
            <div class="w-full border border-gray-100 rounded-2xl overflow-hidden shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-slate-100 text-slate-600 text-xs font-bold uppercase border-b border-gray-200">
                                <th class="p-4 w-12 text-center">No</th>
                                <th class="p-4">ID Nota / Kode</th>
                                <th class="p-4">Meja</th>
                                <th class="p-4">Tanggal & Waktu</th>
                                <th class="p-4">Total Bayar</th>
                                <th class="p-4 text-center">Metode</th>
                                <th class="p-4 text-center">Status</th>
                                <th class="p-4 text-center w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-slate-600">
                            @forelse($orders as $order)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="p-4 text-center font-bold text-slate-400 text-xs">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="p-4 font-extrabold text-slate-800 tracking-tight">
                                        #{{ $order->kode_pesanan }}
                                    </td>
                                    <td class="p-4 font-semibold text-slate-600">
                                        <span class="bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200 text-xs">
                                            🪑 {{ $order->nomor_meja ?? 'Meja Online' }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-xs text-slate-500 font-medium">
                                        {{ $order->created_at->format('d M Y, H:i') }} WIB
                                    </td>
                                    <td class="p-4 font-black text-slate-800">
                                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="px-2 py-0.5 rounded-sm bg-blue-50 text-blue-600 border border-blue-100 text-[10px] font-bold uppercase">
                                            {{ $order->metode_bayar ?? 'QRIS' }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-block text-[10px] font-bold bg-green-50 text-green-700 border border-green-200 px-2 py-0.5 rounded-full uppercase select-none">
                                            Lunas
                                        </span>
                                    </td>
                                    <td class="p-4 text-center w-24">
                                        <a href="{{ route('pesanan.struk', $order->id) }}" target="_blank"
                                           class="text-emerald-600 hover:text-emerald-700 text-xs font-semibold bg-emerald-50 hover:bg-emerald-100 px-2.5 py-1.5 rounded-lg inline-flex items-center gap-1 cursor-pointer transition focus:outline-none">
                                            <i class="fa-solid fa-print"></i> Struk
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-10 text-center text-gray-400 font-medium">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <i class="fa-solid fa-receipt text-3xl text-slate-200"></i>
                                            <span class="text-xs">Belum ada riwayat transaksi lunas yang tercatat.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection