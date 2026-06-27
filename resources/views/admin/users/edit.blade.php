@extends('layouts.app-internal')
@section('title', 'Edit Akun Pegawai')
@section('header_title', '📝 Edit Akun Pegawai')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<div class="space-y-6 w-full font-premium">
    
    <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-100">
        <div class="mb-5 border-b border-gray-100 pb-3">
            <h3 class="text-sm font-extrabold text-slate-800 tracking-tight">Ubah Data & Hak Akses Pegawai</h3>
            <p class="text-[11px] text-gray-400 font-medium mt-0.5">Perbarui nama, email, password, atau tingkat jabatan internal sistem kasir</p>
        </div>

        <form method="POST" action="{{ route('admin.user.update', $user->id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-start">
                
                <div>
                    <label class="block text-[10px] font-extrabold text-slate-500 mb-1.5 uppercase tracking-wide">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                           class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:border-orange-500 transition-all" 
                           placeholder="Nama Pegawai">
                    @error('name') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-extrabold text-slate-500 mb-1.5 uppercase tracking-wide">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                           class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:border-orange-500 transition-all" 
                           placeholder="ahmad@apps.com">
                    @error('email') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-extrabold text-slate-500 mb-1.5 uppercase tracking-wide">Password Baru (Opsional)</label>
                    <input type="password" name="password" 
                           class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:border-orange-500 transition-all" 
                           placeholder="Kosongkan jika tidak diganti">
                    @error('password') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-extrabold text-slate-500 mb-1.5 uppercase tracking-wide">Hak Akses (Role)</label>
                    <select name="role" required class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:border-orange-500 transition-all">
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                {{ strtoupper($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-50">
                <a href="{{ route('admin.user.index') }}" 
                   class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-extrabold py-2.5 px-5 rounded-xl transition-all">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-orange-500 hover:bg-orange-600 text-white text-xs font-extrabold py-2.5 px-6 rounded-xl shadow-md shadow-orange-500/10 transition-all flex items-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-user-check"></i> Perbarui Akun Pegawai
                </button>
            </div>
        </form>
    </div>

</div>
@endsection