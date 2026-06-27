@extends('layouts.app-internal')
@section('title', 'Laporan Manajemen')
@section('header_title', '📊 Laporan & Analitik Bisnis')

@section('content')
<div class="space-y-8 animate-in fade-in duration-500">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $cards = [
                ['label' => 'Total Omzet', 'value' => 'Rp ' . number_format($totalOmzetLunas, 0, ',', '.'), 'icon' => 'fa-wallet', 'color' => 'emerald'],
                ['label' => 'Estimasi Profit', 'value' => 'Rp ' . number_format($estimasiProfit, 0, ',', '.'), 'icon' => 'fa-chart-line', 'color' => 'blue'],
                ['label' => 'Total Terjual', 'value' => $totalItemTerjual . ' Porsi', 'icon' => 'fa-utensils', 'color' => 'purple'],
                ['label' => 'Stok Habis', 'value' => $stokHabisCount . ' Item', 'icon' => 'fa-box-open', 'color' => 'rose'],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $card['label'] }}</p>
                    <p class="text-lg font-black text-slate-800 mt-1">{{ $card['value'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-{{$card['color']}}-50 text-{{$card['color']}}-600 flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid {{ $card['icon'] }}"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                <h4 class="font-bold text-slate-800 flex items-center gap-2"><i class="fa-solid fa-trophy text-amber-500"></i> Top 5 Menu Terlaris</h4>
            </div>
            <table class="w-full text-sm">
                <tbody class="divide-y divide-slate-50">
                    @forelse($produkTerlaris as $item)
                    <tr>
                        <td class="p-4 font-bold text-slate-600">{{ $item->nama }}</td>
                        <td class="p-4 text-right font-black text-emerald-600">{{ $item->total_terjual }} Porsi</td>
                    </tr>
                    @empty
                    <tr><td colspan="2" class="p-4 text-center text-slate-400">Data belum tersedia</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                <h4 class="font-bold text-slate-800 flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation text-rose-500"></i> Peringatan Stok Kritis</h4>
                <button onclick="window.print()" class="text-[10px] font-bold bg-slate-900 text-white px-3 py-1 rounded-lg hover:bg-slate-700 transition">Cetak</button>
            </div>
            <table class="w-full text-sm">
                <tbody class="divide-y divide-slate-50">
                    @forelse($produkKritis as $prod)
                    <tr>
                        <td class="p-4 font-bold text-slate-600">{{ $prod->nama }}</td>
                        <td class="p-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $prod->stok <= 0 ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $prod->stok }} Pcs Tersisa
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="2" class="p-4 text-center text-slate-400">Semua stok aman!</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection