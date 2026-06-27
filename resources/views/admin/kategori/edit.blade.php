@extends('layouts.app-internal')
@section('title', 'Edit Kategori')
@section('header_title', '📝 Edit Kategori Menu')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    .font-premium { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>

<div class="font-premium space-y-6 max-w-2xl mx-auto">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.kategori.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-700 transition flex items-center gap-1">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Kategori
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-100">
        <h3 class="font-bold text-base text-slate-800 mb-6 flex items-center gap-2">
            <i class="fa-solid fa-tags text-orange-500"></i> Ubah Data Kategori
        </h3>

        <form method="POST" action="{{ route('admin.kategori.update', $kategori->id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $kategori->nama) }}" required 
                       class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-sm focus:outline-hidden focus:border-orange-500 transition" 
                       placeholder="Misal: Makanan Utama / Minuman Segar">
                @error('nama') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Ikon Sistem <span class="text-red-500">*</span></label>
                    <select name="ikon" required 
                            class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-sm focus:outline-hidden focus:border-orange-500 transition cursor-pointer">
                        @php
                            $icons = [
                                'fa-tags' => '🏷️ Default (Tag)',
                                'fa-bowl-rice' => '🍚 Makanan Utama (Piring Nasi)',
                                'fa-bowl-food' => '🍜 Mangkok / Mie',
                                'fa-pizza-slice' => '🍕 Pizza / Fast Food',
                                'fa-burger' => '🍔 Burger / Fast Food',
                                'fa-ice-cream' => '🍦 Es Krim / Dessert',
                                'fa-cake-candles' => '🍰 Kue / Roti',
                                'fa-mug-hot' => '☕ Kopi / Hangat',
                                'fa-glass-water' => '🥤 Minuman Segar',
                                'fa-cookie-bite' => '🍪 Camilan / Snack',
                            ];
                        @endphp
                        
                        @foreach($icons as $value => $label)
                            <option value="{{ $value }}" {{ old('ikon', $kategori->ikon) == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('ikon') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Urutan Posisi <span class="text-red-500">*</span></label>
                    <input type="number" name="urutan" value="{{ old('urutan', $kategori->urutan ?? 1) }}" min="1" required
                           class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-sm focus:outline-hidden focus:border-orange-500 transition">
                    @error('urutan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Status Kategori <span class="text-red-500">*</span></label>
                <select name="aktif" required 
                        class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-sm focus:outline-hidden focus:border-orange-500 transition cursor-pointer">
                    <option value="1" {{ old('aktif', $kategori->aktif) == 1 ? 'selected' : '' }}>Aktif (Muncul Pilihan di Produk)</option>
                    <option value="0" {{ old('aktif', $kategori->aktif) == 0 ? 'selected' : '' }}>Non-Aktif (Disembunyikan)</option>
                </select>
                @error('aktif') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                <a href="{{ route('admin.kategori.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 px-5 rounded-xl text-sm transition">
                    Batal
                </a>
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 px-5 rounded-xl text-sm transition shadow-md shadow-orange-500/10 flex items-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-square-check"></i> Perbarui Kategori
                </button>
            </div>

        </form>
    </div>
</div>
@endsection