@extends('layouts.app-internal')
@section('title', 'Antrian Transaksi Kasir')
@section('header_title', '🛒 Antrian Transaksi Kasir')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 bg-emerald-50 text-emerald-800 text-xs font-bold rounded-xl border border-emerald-100">{{ session('success') }}</div>
    @endif

    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <table class="w-full text-left">
            <thead>
                <tr class="text-slate-400 uppercase text-[10px] tracking-widest border-b">
                    <th class="p-4">Kode Pesanan</th>
                    <th class="p-4">Total</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y text-xs">
                @forelse($orders as $order)
                <tr>
                    <td class="p-4 font-bold text-slate-800">{{ $order->kode_pesanan }}</td>
                    <td class="p-4 font-semibold text-slate-600">Rp {{ number_format($order->total_harga, 0) }}</td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded-full text-[10px] font-bold 
                            {{ $order->status == 'lunas' ? 'bg-blue-100 text-blue-700' : 
                               ($order->status == 'selesai_diantar' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700') }}">
                            {{ strtoupper($order->status) }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        @if($order->status == 'lunas')
                            <form action="{{ route('kasir.konfirmasi_antar', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs font-bold transition">
                                    <i class="fa-solid fa-truck mr-1"></i> Konfirmasi Antar
                                </button>
                            </form>
                        @elseif($order->status == 'selesai_diantar')
                            <span class="text-emerald-600 font-bold px-3 py-1 bg-emerald-50 rounded-lg">
                                <i class="fa-solid fa-check mr-1"></i> Selesai
                            </span>
                        @else
                            <span class="text-slate-400 italic">Menunggu Pembayaran</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-slate-400">Belum ada antrian pesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection