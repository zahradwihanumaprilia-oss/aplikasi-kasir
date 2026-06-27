@extends('layouts.app-internal')
@section('title', 'Kelola Pegawai')
@section('header_title', 'Manajemen Akun Pegawai')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 bg-green-50 text-green-700 text-sm rounded-xl border border-green-200 font-medium shadow-xs">
            <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-red-50 text-red-700 text-sm rounded-xl border border-red-200 font-medium shadow-xs">
            <i class="fa-solid fa-circle-xmark mr-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-100">
        <h3 class="font-bold text-base text-slate-800 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-user-plus text-orange-500"></i> Tambah Akun Pegawai Baru
        </h3>
        <form method="POST" action="{{ route('admin.user.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase">Nama Lengkap</label>
                <input type="text" name="name" required class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-sm focus:outline-hidden focus:border-orange-500 transition" placeholder="Misal: Ahmad Kasir">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase">Alamat Email</label>
                <input type="email" name="email" required class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-sm focus:outline-hidden focus:border-orange-500 transition" placeholder="ahmad@apps.com">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase">Password Akses</label>
                <input type="password" name="password" required class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-sm focus:outline-hidden focus:border-orange-500 transition" placeholder="Minimal 8 Karakter">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase">Hak Akses (Role)</label>
                <select name="role" required class="w-full p-2.5 bg-slate-50 border border-gray-200 rounded-xl text-sm focus:outline-hidden focus:border-orange-500 transition cursor-pointer">
                    <option value="">-- Pilih Role --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ strtoupper($role->name) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-4 flex justify-end mt-2">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition shadow-md shadow-orange-500/10 flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Pegawai
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-xs">
        <div class="p-4 bg-slate-50 border-b border-gray-100 font-bold text-sm text-slate-700 flex items-center gap-2">
            <i class="fa-solid fa-users text-slate-400"></i> Struktur Pengguna Internal Aplikasi
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-100 text-slate-600 text-xs font-bold uppercase border-b border-gray-200">
                        <th class="p-4">Nama Lengkap</th>
                        <th class="p-4">Username / Email</th>
                        <th class="p-4">Hak Akses Sistem</th>
                        <th class="p-4 text-center w-48">Tindakan</th> </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-slate-600">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4 font-bold text-slate-800">{{ $user->name }}</td>
                            <td class="p-4 text-xs font-mono">{{ $user->email }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full {{ $user->hasRole('admin') ? 'bg-red-100 text-red-800' : ($user->hasRole('kasir') ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800') }} uppercase tracking-wider">
                                    {{ $user->roles->first()->name ?? 'No Role' }}
                                </span>
                            </td>
                            
                            <td class="p-4 text-center w-48">
                                @if($user->id !== auth()->id())
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.user.edit', $user->id) }}" 
                                           class="text-amber-600 hover:text-amber-700 font-semibold text-xs transition bg-amber-50 hover:bg-amber-100 px-2.5 py-1.5 rounded-lg inline-flex items-center gap-1 cursor-pointer border border-amber-100/10">
                                            <i class="fa-solid fa-pen"></i> Edit
                                        </a>

                                        <form method="POST" action="{{ route('admin.user.destroy', $user->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin mencabut akses pegawai ini?')" 
                                                    class="text-red-500 hover:text-red-700 font-semibold text-xs transition bg-red-50 hover:bg-red-100 px-2.5 py-1.5 rounded-lg inline-flex items-center gap-1 cursor-pointer border border-red-100/10">
                                                <i class="fa-solid fa-trash-can"></i> Hapus Akses
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400 italic font-medium bg-slate-100 px-2.5 py-1.5 rounded-lg inline-block">
                                        <i class="fa-solid fa-user-check text-green-500 mr-1"></i>Akun Anda (Aktif)
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection