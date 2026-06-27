<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        // Menghubungkan ke tabel categories
        $table->foreignId('kategori_id')->constrained('categories')->onDelete('cascade');
        $table->string('nama');
        $table->string('slug')->unique();
        $table->decimal('harga_jual', 12, 2);
        $table->string('gambar')->nullable(); // Tempat simpan path foto
        $table->text('deskripsi')->nullable();
        $table->boolean('tersedia')->default(true);
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};