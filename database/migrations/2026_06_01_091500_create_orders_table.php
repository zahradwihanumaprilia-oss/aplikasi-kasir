<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('orders', function (Blueprint $table) {
        $table->id(); 
        $table->string('kode_pesanan')->unique(); 
        $table->foreignId('pengguna_id')->nullable()->constrained('users')->onDelete('set null');
        $table->decimal('total_harga', 12, 2); 
        $table->enum('metode_bayar', ['tunai', 'qris'])->default('tunai'); 
        $table->enum('status', ['pending', 'proses', 'lunas', 'batal'])->default('pending'); 
        $table->text('catatan')->nullable(); 
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};