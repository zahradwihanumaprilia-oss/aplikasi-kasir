@extends('layouts.app-internal')
@section('title', 'Dashboard Admin - Smart Kasir')
@section('header_title', '📊 Sales Dashboard Overview')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    .font-premium { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>

<div class="font-premium space-y-6 animate-fade-in">

    <div class="flex justify-between items-center bg-white/80 backdrop-blur-md px-5 py-3 rounded-2xl border border-gray-100 shadow-xs">
        <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-full flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Mode Live Monitor Aktivitas Toko
        </span>
        <span class="text-xs font-bold text-slate-400 bg-slate-50 px-3 py-1.5 rounded-full border border-slate-100">
            {{ now()->translatedFormat('F Y') }}
        </span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="relative overflow-hidden bg-gradient-to-br from-[#1B5E20] to-[#2E7D32] p-6 rounded-2xl text-white shadow-md transition duration-300 hover:-translate-y-1 hover:shadow-lg">
            <div class="flex justify-between items-start z-10 relative">
                <div>
                    <p class="text-xs font-bold text-emerald-100/70 uppercase tracking-wider">Potensi Omzet</p>
                    <h3 class="text-2xl font-black mt-2 tracking-tight">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 bg-white/15 backdrop-blur-md rounded-xl flex items-center justify-center text-lg shadow-inner">💰</div>
            </div>
            <div class="mt-5 z-10 relative"><span class="text-[10px] font-extrabold bg-white/20 text-white px-2.5 py-1 rounded-full">Total Lunas</span></div>
        </div>

        <div class="relative overflow-hidden bg-gradient-to-br from-[#0284C7] to-[#0369A1] p-6 rounded-2xl text-white shadow-md transition duration-300 hover:-translate-y-1 hover:shadow-lg">
            <div class="flex justify-between items-start z-10 relative">
                <div>
                    <p class="text-xs font-bold text-sky-100/70 uppercase tracking-wider">Estimasi Profit</p>
                    <h3 class="text-2xl font-black mt-2 tracking-tight">Rp {{ number_format($totalProfit, 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 bg-white/15 backdrop-blur-md rounded-xl flex items-center justify-center text-lg shadow-inner">📈</div>
            </div>
            <div class="mt-5 z-10 relative"><span class="text-[10px] font-extrabold bg-white/20 text-white px-2.5 py-1 rounded-full">Margin Bersih 25%</span></div>
        </div>

        <div class="relative overflow-hidden bg-gradient-to-br from-[#EA580C] to-[#C2410C] p-6 rounded-2xl text-white shadow-md transition duration-300 hover:-translate-y-1 hover:shadow-lg">
            <div class="flex justify-between items-start z-10 relative">
                <div>
                    <p class="text-xs font-bold text-orange-100/70 uppercase tracking-wider">Total Transaksi</p>
                    <h3 class="text-3xl font-black mt-2 tracking-tight">{{ $totalTransaksi }} Kali</h3>
                </div>
                <div class="w-10 h-10 bg-white/15 backdrop-blur-md rounded-xl flex items-center justify-center text-lg shadow-inner">🛒</div>
            </div>
            <div class="mt-5 z-10 relative"><span class="text-[10px] font-extrabold bg-white/20 text-white px-2.5 py-1 rounded-full">Data Valid</span></div>
        </div>

        <div class="relative overflow-hidden bg-gradient-to-br from-[#7C3AED] to-[#6D28D9] p-6 rounded-2xl text-white shadow-md transition duration-300 hover:-translate-y-1 hover:shadow-lg">
            <div class="flex justify-between items-start z-10 relative">
                <div>
                    <p class="text-xs font-bold text-purple-100/70 uppercase tracking-wider">Total User</p>
                    <h3 class="text-3xl font-black mt-2 tracking-tight">{{ $totalUsers }} Akun</h3>
                </div>
                <div class="w-10 h-10 bg-white/15 backdrop-blur-md rounded-xl flex items-center justify-center text-lg shadow-inner">👥</div>
            </div>
            <div class="mt-5 z-10 relative"><span class="text-[10px] font-extrabold bg-white/20 text-white px-2.5 py-1 rounded-full">Hak Akses Sistem</span></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h4 class="text-sm font-bold text-slate-800">Analisis Penjualan</h4>
            <div class="relative h-64 mt-4"><canvas id="chartPenjualanBulanan"></canvas></div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-center">
            <h4 class="text-sm font-bold text-slate-800 self-start">Produk per Kategori</h4>
            <div class="relative h-44 my-4"><canvas id="chartDonutKategori"></canvas></div>
            <div class="text-center"><span class="block text-2xl font-black">{{ array_sum($donutValues) }}</span><span class="text-[10px] uppercase font-bold text-gray-400">Total Produk</span></div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <h4 class="text-sm font-bold text-slate-800 mb-4">Stok Produk Kritis (< 10 Pcs)</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b">
                        <th class="pb-3">Menu</th>
                        <th class="pb-3">Sisa Stok</th>
                        <th class="pb-3 text-right">Harga</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y">
                    @forelse($topProducts as $item)
                        <tr>
                            <td class="py-3 font-bold text-slate-800">{{ $item->nama }}</td>
                            <td class="py-3 font-bold text-red-600">{{ $item->stok }} Pcs</td>
                            <td class="py-3 text-right font-black">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="p-4 text-center">Stok semua produk aman!</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data untuk Chart dari Controller
    const labels = {!! json_encode($donutLabels) !!};
    const values = {!! json_encode($donutValues) !!};

    // Donut Chart
    new Chart(document.getElementById('chartDonutKategori'), {
        type: 'doughnut',
        data: { labels: labels, datasets: [{ data: values, backgroundColor: ['#1B5E20', '#43A047', '#81C784', '#A5D6A7'] }] },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
    });
</script>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1. Bar Chart (Penjualan Bulanan)
        new Chart(document.getElementById('chartPenjualanBulanan'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{ label: 'Omzet', data: [12, 19, 3, 5, 2, 3], backgroundColor: '#43A047' }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // 2. Donut Chart (Kategori)
        new Chart(document.getElementById('chartDonutKategori'), {
            type: 'doughnut',
            data: { 
                labels: {!! json_encode($donutLabels) !!}, 
                datasets: [{ 
                    data: {!! json_encode($donutValues) !!}, 
                    backgroundColor: ['#1B5E20', '#43A047', '#81C784', '#A5D6A7'] 
                }] 
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
    });
</script>