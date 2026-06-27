@extends('layouts.app-internal')
@section('title', 'Detail Pembayaran')
@section('header_title', 'Validasi Pesanan Pelanggan')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 bg-slate-50 border-b border-gray-100 flex justify-between items-center">
        <div>
            <h3 class="font-bold text-lg text-slate-800">Rincian Item Pesanan</h3>
            <p class="text-xs text-orange-600 font-mono font-bold mt-0.5">Kode: {{ $transaksi->kode_transaksi }}</p>
        </div>
        <a href="{{ route('kasir.dashboard') }}" class="text-xs font-bold text-slate-600 hover:text-slate-800 bg-slate-100 px-3 py-1.5 rounded-xl transition">&larr; Kembali</a>
    </div>

    <div class="p-6 space-y-4">
        @foreach($transaksi->detailTransaksis as $detail)
            <div class="flex justify-between items-center border-b border-gray-50 pb-3">
                <div>
                    <h4 class="font-bold text-sm text-slate-800">{{ $detail->produk->nama_produk }}</h4>
                    <p class="text-xs text-gray-400">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</p>
                </div>
                <span class="font-bold text-sm text-slate-700">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
            </div>
        @endforeach

        <div class="flex justify-between items-center pt-4 border-t border-gray-200">
            <span class="font-bold text-base text-slate-600">Total Tagihan:</span>
            <span class="font-black text-2xl text-orange-600">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="p-6 bg-slate-50 border-t border-gray-100 grid grid-cols-2 gap-4">
        <form method="POST" action="{{ route('kasir.bayar.tunai', $transaksi->id) }}">
            @csrf
            <button type="submit" onclick="return confirm('Konfirmasi pembayaran tunai langsung lunas?')" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 px-4 rounded-xl transition flex justify-center items-center gap-2 shadow-xs">
                <i class="fa-solid fa-money-bill-wave text-green-400"></i> Bayar Cash / Tunai
            </button>
        </form>

        <form method="POST" action="{{ route('kasir.proses.qris', $transaksi->id) }}">
            @csrf
            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-xl transition flex justify-center items-center gap-2 shadow-md shadow-orange-500/10">
                <i class="fa-solid fa-qrcode"></i> Bayar QRIS (Gopay/OVO)
            </button>
        </form>
    </div>
</div>
@endsection