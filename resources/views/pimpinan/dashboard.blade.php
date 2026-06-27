@extends('layouts.app-internal')
@section('title', 'Dashboard Pimpinan')
@section('header_title', '📊 Analitik & Laporan Keuangan')

@section('content')
<!-- FORCE INJECT TAILWIND V4 PLAY CDN AGAR LAYOUT PASTI RAPI INSTAN -->
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<!-- FONT PREMIUM: Plus Jakarta Sans -->
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    .font-premium { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>

<div class="font-premium w-full space-y-6">
    
    <!-- GRID KARTU METRIK RINGKASAN -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- 1. KARTU TOTAL OMZET -->
        <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Total Omzet Bersih Terfilter</p>
                <h4 class="text-2xl font-black text-emerald-600 mt-1">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h4>
            </div>
            <div class="p-4 bg-emerald-50 text-emerald-500 rounded-xl text-2xl"><i class="fa-solid fa-money-bill-trend-up"></i></div>
        </div>

        <!-- 2. KARTU TOTAL TRANSAKSI -->
        <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Volume Transaksi Sukses</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1">{{ $total_transaksi }} Transaksi</h4>
            </div>
            <div class="p-4 bg-slate-50 text-slate-500 rounded-xl text-2xl"><i class="fa-solid fa-receipt"></i></div>
        </div>
    </div>

    <!-- AREA BLOCK FILTER RENTANG WAKTU -->
    <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-100">
        <form method="GET" action="{{ route('pimpinan.dashboard') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-[10px] font-extrabold text-slate-500 mb-1.5 uppercase tracking-wider">Tanggal Mulai</label>
                <input type="date" name="tgl_mulai" value="{{ $tgl_mulai }}" class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-[#43A047] transition">
            </div>
            <div>
                <label class="block text-[10px] font-extrabold text-slate-500 mb-1.5 uppercase tracking-wider">Tanggal Selesai</label>
                <input type="date" name="tgl_selesai" value="{{ $tgl_selesai }}" class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-[#43A047] transition">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-slate-800 hover:bg-slate-900 text-white font-extrabold py-3 rounded-xl text-xs transition flex justify-center items-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-filter"></i> Saring Data
                </button>
                <a href="{{ route('pimpinan.cetak.pdf', ['tgl_mulai' => $tgl_mulai, 'tgl_selesai' => $tgl_selesai]) }}" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-extrabold py-3 rounded-xl text-xs transition flex justify-center items-center gap-1.5 cursor-pointer shadow-md shadow-orange-500/10">
                    <i class="fa-solid fa-file-pdf"></i> Ekspor PDF
                </a>
            </div>
        </form>
    </div>

    <!-- TABEL LOG TRANSAKSI FINANSIAL -->
    <div class="w-full bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
        <div class="p-4 bg-slate-50 border-b border-gray-100">
            <span class="text-xs font-extrabold text-slate-700 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-[#43A047]"></i> Riwayat Audit Pembayaran Lunas
            </span>
        </div>
        <div class="w-full overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-[10px] font-bold uppercase tracking-wider border-b border-gray-100">
                        <th class="p-4 text-center w-16">No</th>
                        <th class="p-4">Kode Transaksi</th>
                        <th class="p-4">Waktu Pelunasan</th>
                        <th class="p-4">Metode</th>
                        <th class="p-4 text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-slate-600">
                    @php $no = 1; @endphp
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4 text-center font-extrabold text-gray-400 w-16">{{ $no++ }}</td>
                            <td class="p-4 font-mono font-bold text-orange-600">{{ $order->kode_pesanan }}</td>
                            <td class="p-4 font-medium text-slate-500">{{ $order->created_at->format('d M Y - H:i') }} WIB</td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 font-black text-[9px] rounded-sm uppercase {{ $order->metode_bayar == 'qris' ? 'bg-sky-50 text-sky-700 border border-sky-100' : 'bg-orange-50 text-orange-700 border border-orange-100' }}">
                                    {{ $order->metode_bayar }}
                                </span>
                            </td>
                            <td class="p-4 text-right font-black text-slate-800">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-gray-400 font-medium">
                                Tidak ada data penjualan lunas pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection