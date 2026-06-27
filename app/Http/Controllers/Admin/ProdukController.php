<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;  
use App\Models\Category; 
use App\Models\Stock;    
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        // 💡 PERBAIKAN: Hapus 'stock' karena sekarang kolom stok sudah menyatu murni di tabel products
        $produks = Product::with(['category'])->latest()->get();
        
        return view('admin.produk.index', compact('produks'));
    }

    public function create()
    {
        $kategoris = Category::where('aktif', true)->get();
        return view('admin.produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:categories,id',
            'nama' => 'required|string|max:191',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0', // 💡 Menambahkan validasi input stok awal
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $slug = Str::slug($request->nama);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('produk', 'public');
        }

        // 💡 LANGSUNG SIMPAN STOK KE TABEL PRODUCTS
        Product::create([
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'slug' => $slug,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok, // <-- Mengisi kolom stok baru langsung
            'gambar' => $gambarPath,
            'deskripsi' => $request->deskripsi,
            'tersedia' => $request->stok > 0 ? true : false,
        ]);

        // 💡 HAPUS perintah Stock::create karena tabelnya sudah tidak ada

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // 💡 PERBAIKAN UTAMA: Hapus 'with(stock)' karena stok sudah menjadi kolom lokal di tabel products
        $produk = Product::findOrFail($id);
        $kategoris = Category::where('aktif', true)->get();
        
        return view('admin.produk.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'kategori_id' => 'required|exists:categories,id',
            'nama' => 'required|string|max:191',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0', // 💡 Menambahkan validasi update stok
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('gambar')) {
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $product->gambar = $request->file('gambar')->store('produk', 'public');
        }

        // 💡 UPDATE LANGSUNG KOLOM STOK DI TABEL PRODUCTS
        $product->update([
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok, // <-- Update kolom stok lokal
            'deskripsi' => $request->deskripsi,
            'tersedia' => $request->stok > 0 ? true : false,
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->gambar && Storage::disk('public')->exists($product->gambar)) {
            Storage::disk('public')->delete($product->gambar);
        }
        $product->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}