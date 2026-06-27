@extends('layouts.app-internal')
@section('title', 'Tambah Produk Baru')
@section('header_title', 'Manajemen Produk Menu')

@section('content')
<div class="space-y-6 max-w-3xl mx-auto">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.produk.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-700 transition flex items-center gap-1">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog Produk
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-red-50 text-red-700 text-sm rounded-xl border border-red-200 font-medium shadow-xs">
            <div class="font-bold mb-1"><i class="fa-solid fa-circle-exclamation mr-2"></i> Periksa kembali isian Anda:</div>
            <ul class="list-disc pl-5 space-y-0.5 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-xs w-full">
        
        <div class="p-4 bg-slate-50 border-b border-gray-100 font-bold text-sm text-slate-700 flex items-center gap-2">
            <i class="fa-solid fa-plus text-orange-500"></i> Tambah Produk Menu Baru
        </div>
        
        <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Menu <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Es Kopi Susu Aren"
                           class="w-full text-sm px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-orange-500 transition text-slate-800 bg-slate-50/50">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori Menu <span class="text-red-500">*</span></label>
                    <select name="kategori_id" required 
                            class="w-full text-sm px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-orange-500 transition text-slate-800 bg-slate-50/50 cursor-pointer">
                        <option value="" disabled selected>-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 text-sm font-semibold">Rp</span>
                        <input type="number" name="harga_jual" value="{{ old('harga_jual') }}" required placeholder="0" min="0"
                               class="w-full text-sm pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-orange-500 transition text-slate-800 bg-slate-50/50">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Stok Awal <span class="text-red-500">*</span></label>
                    <input type="number" name="stok" value="{{ old('stok', 0) }}" required min="0"
                           class="w-full text-sm px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-orange-500 transition text-slate-800 bg-slate-50/50">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" rows="3" placeholder="Tuliskan keterangan menu..."
                          class="w-full text-sm px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-orange-500 transition text-slate-800 bg-slate-50/50 resize-none">{{ old('deskripsi') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Foto Produk Menu (Opsional)</label>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-center p-4 bg-slate-50/50 border-2 border-gray-200 border-dashed rounded-xl">
                    <div class="text-center flex flex-col items-center justify-center">
                        <div id="preview-container" class="w-20 h-20 bg-white border border-gray-200 rounded-xl flex items-center justify-center text-gray-300 text-sm overflow-hidden shadow-sm">
                            <i id="preview-icon" class="fa-solid fa-image text-xl"></i>
                            <img id="image-preview" src="#" alt="Preview" class="hidden w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="sm:col-span-3 text-center sm:text-left space-y-1">
                        <label for="gambar" class="inline-block relative cursor-pointer bg-white border border-gray-200 px-4 py-2 rounded-xl text-xs font-bold text-orange-500 hover:text-orange-600 transition shadow-sm">
                            <span><i class="fa-cloud-arrow-up mr-1"></i> Pilih Berkas Foto</span>
                            <input id="gambar" name="gambar" type="file" accept="image/*" class="sr-only" onchange="previewImage(this)">
                        </label>
                        <p class="text-[11px] text-gray-400">PNG, JPG, JPEG maks 2MB</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-4 flex justify-end gap-2">
                <button type="reset" onclick="resetPreview()" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-2.5 px-5 rounded-xl text-xs transition">
                    Reset Form
                </button>
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 px-5 rounded-xl text-xs transition shadow-md shadow-orange-500/10">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-preview').classList.remove('hidden');
                document.getElementById('preview-icon').classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    }
    function resetPreview() {
        document.getElementById('image-preview').src = "#";
        document.getElementById('image-preview').classList.add('hidden');
        document.getElementById('preview-icon').classList.remove('hidden');
    }
</script>
@endsection