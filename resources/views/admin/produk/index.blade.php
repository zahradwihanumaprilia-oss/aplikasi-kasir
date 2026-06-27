@extends('layouts.app-internal')
@section('title', 'Kelola Produk Menu')
@section('header_title', 'Manajemen Produk Menu')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    .font-premium { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>

<div class="font-premium w-full space-y-6">
    
    @if(session('success'))
        <div class="p-4 bg-green-50 text-green-700 text-sm rounded-xl border border-green-200 font-medium shadow-xs max-w-3xl flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-green-500"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="w-full bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
        
        <div class="p-4 bg-slate-50 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="font-bold text-sm text-slate-700 flex items-center gap-2">
                    <i class="fa-solid fa-box text-slate-400"></i> Master Data Katalog Produk
                </h3>
            </div>
            
            <a href="{{ route('admin.produk.create') }}" 
               class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-xl text-xs flex justify-center items-center gap-1.5 cursor-pointer transition shadow-md shadow-orange-500/10">
                <i class="fa-solid fa-plus"></i> Tambah Produk
            </a>
        </div>

        <div class="p-6 w-full bg-white">
            <div class="w-full border border-gray-100 rounded-2xl overflow-hidden shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-slate-100 text-slate-600 text-xs font-bold uppercase border-b border-gray-200">
                                <th class="p-4 w-12 text-center">No</th>
                                <th class="p-4 w-24 text-center">Gambar</th>
                                <th class="p-4">Nama Menu</th>
                                <th class="p-4">Kategori</th>
                                <th class="p-4">Harga Jual</th>
                                <th class="p-4 text-center w-32">Stok & Status</th>
                                <th class="p-4 text-center w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-slate-600">
                            @forelse($produks as $produk)
                                <tr class="hover:bg-slate-50/50 transition">
                                    
                                    <td class="p-4 text-center w-12 font-bold text-slate-400 text-xs">
                                        {{ $loop->iteration }}
                                    </td>
                                    
                                    <td class="p-4 text-center w-24">
                                        @if($produk->gambar && \Illuminate\Support\Facades\Storage::disk('public')->exists($produk->gambar))
                                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Menu" class="w-12 h-12 object-cover rounded-xl border border-gray-200 shadow-sm mx-auto">
                                        @else
                                            <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center text-gray-300 border border-gray-200/50 mx-auto shadow-inner">
                                                <i class="fa-solid fa-image text-base text-slate-400"></i>
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <td class="p-4 font-bold text-slate-800">
                                        <span class="block">{{ $produk->nama }}</span>
                                        <span class="text-[11px] text-gray-400 font-normal block max-w-xs truncate mt-0.5">{{ $produk->deskripsi ?? 'Tidak ada deskripsi menu.' }}</span>
                                    </td>

                                    <td class="p-4 font-medium text-slate-600">
                                        <span class="bg-slate-50 px-2.5 py-1 rounded-lg border border-slate-200 text-xs">
                                            {{ $produk->category ? $produk->category->nama : 'Umum' }}
                                        </span>
                                    </td>

                                    <td class="p-4 font-extrabold text-slate-800">
                                        Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
                                    </td>

                                    <td class="p-4 text-center w-32">
                                        <div class="space-y-1">
                                            <span class="block text-xs font-semibold text-slate-700">
                                                Stok: {{ $produk->stok ?? 0 }} Pcs
                                            </span>
                                            
                                            @if(($produk->stok ?? 0) > 0 && $produk->tersedia)
                                                <span class="inline-block text-[10px] font-bold bg-green-50 text-green-700 border border-green-200 px-2 py-0.5 rounded-full">
                                                    Tersedia
                                                </span>
                                            @else
                                                <span class="inline-block text-[10px] font-bold bg-red-50 text-red-700 border border-red-200 px-2 py-0.5 rounded-full">
                                                    Habis / Off
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <td class="p-4 text-center w-28">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <a href="{{ route('admin.produk.edit', $produk->id) }}" 
                                               class="text-amber-600 hover:text-amber-700 text-xs font-semibold bg-amber-50 hover:bg-amber-100 px-2.5 py-1.5 rounded-lg inline-flex items-center gap-1 cursor-pointer transition">
                                                <i class="fa-solid fa-pen"></i> Edit
                                            </a>

                                            <form method="POST" action="{{ route('admin.produk.destroy', $produk->id) }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini? Semua data stok terkait juga akan terhapus.')" 
                                                        class="text-red-500 hover:text-red-700 font-semibold text-xs transition bg-red-50 hover:bg-red-100 px-2.5 py-1.5 rounded-lg inline-flex items-center gap-1 cursor-pointer">
                                                    <i class="fa-solid fa-trash-can"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-10 text-center text-gray-400 font-medium">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <i class="fa-solid fa-box-open text-3xl text-slate-200"></i>
                                            <span class="text-xs">Belum ada katalog produk terdaftar.</span>
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