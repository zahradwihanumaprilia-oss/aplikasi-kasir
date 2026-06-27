<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('pesanan_id')->unique()->constrained('orders')->onDelete('cascade'); 
            $table->enum('metode', ['tunai', 'qris'])->default('tunai'); 
            $table->decimal('nominal_bayar', 12, 2); 
            $table->string('ref_qris')->nullable(); 
            $table->enum('status', ['pending', 'lunas', 'gagal'])->default('pending'); 
            $table->timestamp('lunas_pada')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};