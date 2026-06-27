<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('pesanan_id')->constrained('orders')->onDelete('cascade'); 
            $table->foreignId('produk_id')->constrained('products')->onDelete('cascade'); 
            $table->integer('jumlah')->unsigned(); 
            $table->decimal('harga_satuan', 12, 2); 
            $table->decimal('subtotal', 12, 2); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};