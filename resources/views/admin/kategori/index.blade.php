@extends('layouts.app-internal')
@section('title', 'Manajemen Kategori Menu')
@section('header_title', '🗂️ Manajemen Kategori Menu')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    .font-premium { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>

<div class="font-premium w-full space-y-6">
    
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-emerald-50 text-emerald-800 text-xs font-bold rounded-2xl border border-emerald-100 shadow-xs max-w-3xl">
            <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="w-full bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
        
        <div class="p-5 bg-slate-50 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="font-extrabold text-sm text-slate-800 tracking-tight">Pengaturan & Data Kategori</h3>
                <p class="text-[11px] text-gray-400 font-medium mt-0.5">Kelola penambahan kelompok menu dan monitor status keaktifannya</p>
            </div>
            <span class="text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 px-3 py-1 rounded-full">
                <i class="fa-solid fa-layer-group mr-1"></i> Mode Master Data
            </span>
        </div>

        <div class="p-6 flex flex-col lg:flex-row gap-8 items-start w-full bg-white">
            
            <div class="w-full lg:w-1/3 bg-slate-50 p-5 rounded-2xl border border-gray-100">
                <div class="mb-4 border-b border-gray-200 pb-3">
                    <h4 class="text-xs font-extrabold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-folder-plus text-[#43A047]"></i> Buat Kategori Baru
                    </h4>
                </div>
                
                <form method="POST" action="{{ route('admin.kategori.store') }}" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-500 mb-1.5 uppercase tracking-widest">Nama Kelompok Menu</label>
                        <input type="text" name="nama" required 
                               class="w-full p-3 bg-white border border-gray-200 rounded-xl text-xs text-slate-700 focus:outline-hidden focus:border-[#43A047] focus:ring-2 focus:ring-[#E8F5E9] transition-all" 
                               placeholder="Misal: Makanan Utama, Coffee, Dessert">
                        @error('nama') 
                            <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>
                    
                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label class="block text-[10px] font-extrabold text-slate-500 mb-1.5 uppercase tracking-widest">Ikon Sistem</label>
                            <select name="ikon" required
                                    class="w-full p-3 bg-white border border-gray-200 rounded-xl text-xs text-slate-700 focus:outline-hidden focus:border-[#43A047] transition-all cursor-pointer">
                                <option value="fa-tags" selected>🏷️ Default (Tag)</option>
                                <option value="fa-bowl-rice">🍚 Makanan Utama</option>
                                <option value="fa-bowl-food">🍜 Mangkok / Mie</option>
                                <option value="fa-pizza-slice">🍕 Pizza / Fast Food</option>
                                <option value="fa-burger">🍔 Burger / Fast Food</option>
                                <option value="fa-ice-cream">🍦 Es Krim / Dessert</option>
                                <option value="fa-cake-candles">🍰 Kue / Roti</option>
                                <option value="fa-mug-hot">☕ Kopi / Hangat</option>
                                <option value="fa-glass-water">🥤 Minuman Segar</option>
                                <option value="fa-cookie-bite">🍪 Camilan / Snack</option>
                            </select>
                            @error('ikon') 
                                <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>

                        <div class="w-1/2">
                            <label class="block text-[10px] font-extrabold text-slate-500 mb-1.5 uppercase tracking-widest">Urutan Posisi</label>
                            <input type="number" name="urutan" value="1" min="1" 
                                   class="w-full p-3 bg-white border border-gray-200 rounded-xl text-xs text-slate-700 focus:outline-hidden focus:border-[#43A047] transition-all">
                            @error('urutan') 
                                <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-[#1B5E20] to-[#43A047] text-white font-extrabold py-3 px-4 rounded-xl text-xs flex justify-center items-center gap-2 cursor-pointer hover:opacity-95 mt-2 transition-all shadow-md shadow-emerald-900/10">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Daftarkan Kategori
                    </button>
                </form>
            </div>

            <div class="w-full lg:w-2/3 border border-gray-100 rounded-2xl overflow-hidden shadow-xs">
                <div class="p-4 bg-slate-50 border-b border-gray-100 flex justify-between items-center">
                    <span class="text-xs font-extrabold text-slate-700 flex items-center gap-2">
                        <i class="fa-solid fa-tags text-[#43A047]"></i> Kategori Menu yang Sedang Aktif
                    </span>
                    <span class="text-[10px] bg-slate-100 px-2 py-0.5 rounded-md text-slate-500 font-bold">Aktif</span>
                </div>
                
                <div class="w-full overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 text-[10px] font-bold uppercase tracking-wider border-b border-gray-100">
                                <th class="p-4 w-16 text-center">No</th>
                                <th class="p-4">Struktur Kategori</th>
                                <th class="p-4 text-center w-28">Status</th>
                                <th class="p-4 text-center w-36">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-xs text-slate-600">
                            @php $no = 1; @endphp
                            @forelse($kategoris as $kategori)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="p-4 text-center font-extrabold text-gray-400 bg-slate-50/10 w-16 text-[11px]">{{ $no++ }}</td>
                                    <td class="p-4 font-bold text-slate-800">
                                        <div class="flex items-center gap-3">
                                            <span class="w-8 h-8 flex items-center justify-center bg-[#E8F5E9] text-[#43A047] rounded-xl text-xs border border-emerald-100/40">
                                                <i class="fa-solid {{ $kategori->ikon ?? 'fa-tags' }}"></i>
                                            </span>
                                            <span class="tracking-tight text-xs font-semibold">{{ $kategori->nama }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4 text-center w-28">
                                        @if($kategori->aktif)
                                            <span class="text-[10px] font-black bg-emerald-50 text-emerald-700 border border-emerald-100 px-2.5 py-0.5 rounded-full inline-block">
                                                TERSEDIA
                                            </span>
                                        @else
                                            <span class="text-[10px] font-black bg-rose-50 text-rose-700 border border-rose-100 px-2.5 py-0.5 rounded-full inline-block">
                                                NON-AKTIF
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="p-4 text-center w-36">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.kategori.edit', $kategori->id) }}" 
                                               class="text-amber-600 hover:text-amber-700 font-bold text-[10px] bg-amber-50 hover:bg-amber-100 px-3 py-1.5 rounded-xl border border-amber-100/30 transition-all flex items-center gap-1 cursor-pointer">
                                                <i class="fa-solid fa-pen"></i> Edit
                                            </a>

                                            <form method="POST" action="{{ route('admin.kategori.destroy', $kategori->id) }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')" 
                                                        class="text-rose-600 hover:text-rose-700 font-bold text-[10px] bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-xl flex items-center gap-1 cursor-pointer border border-rose-100/30 transition-all">
                                                    <i class="fa-solid fa-trash-can"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-10 text-center text-gray-400 font-medium text-xs">
                                        Belum ada kategori aktif terdaftar.
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