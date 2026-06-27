<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_logs', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('produk_id')->constrained('products')->onDelete('cascade'); 
            $table->foreignId('pengguna_id')->constrained('users')->onDelete('cascade'); 
            $table->enum('tipe', ['masuk', 'keluar', 'penyesuaian']); 
            $table->integer('stok_sebelum'); 
            $table->integer('perubahan'); 
            $table->string('catatan')->nullable(); 
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_logs');
    }
};