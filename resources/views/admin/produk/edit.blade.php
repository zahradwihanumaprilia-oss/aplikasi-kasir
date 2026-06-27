@extends('layouts.app-internal')
@section('title', 'Edit Produk')
@section('header_title', '📝 Edit Katalog Produk')

@section('content')
<div class="space-y-6 max-w-3xl mx-auto">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.produk.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-700 transition flex items-center gap-1">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog Produk
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-100">
        <h3 class="font-bold text-base text-slate-800 mb-6 flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square text-orange-500"></i> Ubah Informasi Detail Produk
        </h3>

        <form method="POST" action="{{ route('admin.produk.update', $produk->id) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wide">Nama Produk / Menu <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $produk->nama) }}" required 
                           class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition text-slate-800">
                    @error('nama') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wide">Kategori Menu <span class="text-red-500">*</span></label>
                    <select name="kategori_id" required 
                            class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition cursor-pointer text-slate-800">
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $produk->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wide">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="harga_jual" value="{{ old('harga_jual', $produk->harga_jual) }}" required min="0"
                           class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition text-slate-800">
                    @error('harga_jual') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wide">Jumlah Stok Menu <span class="text-red-500">*</span></label>
                    <input type="number" name="stok" value="{{ old('stok', $produk->stok ?? 0) }}" required min="0"
                           class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition text-slate-800">
                    @error('stok') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wide">Status Menu <span class="text-red-500">*</span></label>
                <div class="mt-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="tersedia" value="1" class="sr-only peer" {{ old('tersedia', $produk->tersedia) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                        <span class="ml-3 text-sm font-medium text-slate-600">Centang jika menu Ready</span>
                    </label>
                </div>
            </div>

            <div class="p-4 bg-slate-50 border border-gray-200 rounded-xl space-y-3">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Foto Makanan / Minuman</label>
                <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                    <div class="text-center">
                        <span class="block text-[10px] text-gray-400 font-bold mb-1 uppercase">Foto Saat Ini</span>
                        @if($produk->gambar && \Illuminate\Support\Facades\Storage::disk('public')->exists($produk->gambar))
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Foto Lama" class="w-16 h-16 object-cover rounded-xl border border-gray-200 bg-white p-0.5 shadow-xs">
                        @else
                            <div class="w-16 h-16 bg-white border border-gray-200 rounded-xl flex items-center justify-center text-gray-300 text-xs">
                                <i class="fa-solid fa-image text-lg"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex-1 w-full">
                        <span class="block text-[10px] text-gray-400 font-bold mb-1 uppercase">Ganti Foto Baru (Opsional)</span>
                        <input type="file" name="gambar" accept="image/*"
                               class="w-full p-1.5 bg-white border border-gray-200 rounded-xl text-sm file:mr-3 file:py-1 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100 transition cursor-pointer">
                    </div>
                </div>
                @error('gambar') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wide">Deskripsi Singkat Menu</label>
                <textarea name="deskripsi" rows="3" 
                          class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition resize-none text-slate-800">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.produk.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 px-5 rounded-xl text-sm transition">Batal</a>
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 px-5 rounded-xl text-sm transition shadow-md flex items-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-square-check"></i> Perbarui Katalog
                </button>
            </div>
        </form>
    </div>
</div>
@endsection