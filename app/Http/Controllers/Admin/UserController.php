<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        // Mengambil semua user selain user admin utama agar tidak terhapus sengaja
        $users = User::where('email', '!=', 'admin@apps.com')->with('roles')->get();
        $roles = Role::all();
        
        // 💡 PERBAIKAN 1: Diubah menjadi admin.users.index (pakai s) agar klop dengan folder fisikmu gaes!
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Menyematkan role secara otomatis lewat Spatie
        $user->assignRole($request->role);

        return redirect()->route('admin.user.index')->with('success', 'Pegawai baru berhasil didaftarkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        
        // 💡 PERBAIKAN 2: Diubah menjadi admin.users.edit (pakai s) agar form editnya berhasil dipanggil
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6', 
            'role' => 'required|exists:roles,name',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Enkripsi password baru jika kolom password diisi di form gaes
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Sinkronisasi ulang role Spatie agar otomatis terupdate ke role baru
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.user.index')->with('success', 'Data pegawai berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'Akun pegawai berhasil dihapus!');
    }
}