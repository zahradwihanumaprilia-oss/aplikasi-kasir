@extends('layouts.app-internal')
@section('title', 'Display QRIS')
@section('header_title', 'Metode Pembayaran QRIS')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-2xl shadow-xl border border-gray-100 p-6 text-center">
    <h3 class="font-bold text-lg text-slate-800">Tunjukkan QR Code Ke Pelanggan</h3>
    <p class="text-xs text-slate-400 mt-0.5">Silakan scan menggunakan aplikasi e-wallet atau m-banking</p>

    <div class="my-6 p-4 bg-slate-50 border border-gray-100 rounded-2xl inline-block shadow-xs">
        @if($qrUrl)
            <img src="{{ $qrUrl }}" alt="QRIS Core API" class="w-64 h-64 mx-auto object-contain">
        @else
            <div class="w-64 h-64 flex flex-col items-center justify-center text-red-500 bg-gray-100 rounded-xl p-4">
                <i class="fa-solid fa-circle-exclamation text-3xl mb-2"></i>
                <p class="text-xs font-bold leading-tight">Gagal memuat gambar QRIS dari SandBox Midtrans.</p>
            </div>
        @endif
    </div>

    <div class="mb-6">
        <p class="text-xs text-gray-400 font-medium">Total Nominal Tagihan</p>
        <h4 class="text-2xl font-black text-slate-800 mt-0.5">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</h4>
        <p class="text-[11px] font-mono font-bold text-orange-600 mt-1">{{ $transaksi->kode_transaksi }}</p>
    </div>

    <div class="p-3 bg-blue-50 text-blue-700 text-xs font-semibold rounded-xl border border-blue-100 flex items-center justify-center gap-2 animate-pulse">
        <i class="fa-solid fa-spinner animate-spin"></i> Menunggu konfirmasi pembayaran otomatis dari server webhook...
    </div>

    <a href="{{ route('kasir.dashboard') }}" class="mt-5 block text-xs font-bold text-gray-400 hover:text-slate-600 hover:underline">&larr; Kembali Ke Antrian Utama</a>
</div>
@endsection