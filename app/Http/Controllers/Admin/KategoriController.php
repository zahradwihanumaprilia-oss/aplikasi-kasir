<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category; // 💡 Menggunakan Category sesuai model baru
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        // Menggunakan Category dan mengurutkan berdasarkan kolom 'urutan' agar rapi
        $kategoris = Category::orderBy('urutan', 'asc')->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        // 💡 PERBAIKAN: Validasi diperketat agar mencakup string pilihan dari dropdown ikon baru
        $request->validate([
            'nama' => 'required|string|max:191',
            'ikon' => 'required|string|in:fa-tags,fa-bowl-rice,fa-bowl-food,fa-pizza-slice,fa-burger,fa-ice-cream,fa-cake-candles,fa-mug-hot,fa-glass-water,fa-cookie-bite',
            'urutan' => 'nullable|integer',
        ]);

        // Simpan data baru ke tabel categories
        Category::create([
            'nama' => $request->nama,
            'ikon' => $request->ikon ?? 'fa-tags',
            'urutan' => $request->urutan ?? 0,
            'aktif' => true,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Menampilkan Halaman Form Edit Kategori
     */
    public function edit($id)
    {
        $kategori = Category::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    /**
     * Memproses Pembaruan Data Kategori ke Database
     */
    public function update(Request $request, $id)
    {
        $kategori = Category::findOrFail($id);

        // 💡 PERBAIKAN: Validasi diperketat untuk menangani dropdown ikon dan status aktif/nonaktif
        $request->validate([
            'nama' => 'required|string|max:191',
            'ikon' => 'required|string|in:fa-tags,fa-bowl-rice,fa-bowl-food,fa-pizza-slice,fa-burger,fa-ice-cream,fa-cake-candles,fa-mug-hot,fa-glass-water,fa-cookie-bite',
            'urutan' => 'nullable|integer',
            'aktif' => 'required|in:0,1',
        ]);

        $kategori->update([
            'nama' => $request->nama,
            'ikon' => $request->ikon ?? 'fa-tags',
            'urutan' => $request->urutan ?? 0,
            'aktif' => $request->aktif,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kategori = Category::findOrFail($id);
        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}