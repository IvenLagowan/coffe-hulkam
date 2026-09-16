<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Header transaksi/pesanan pelanggan pada sebuah cafe.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('order_code', 20)->nullable();
            $table->uuid('cafe_id');
            $table->foreignId('cust_id')->constrained('users')->cascadeOnDelete();
            $table->string('channel_pembayaran')->default('cash');   // cash, qris
            $table->dateTime('tgl');
            $table->string('status')->default('Masuk');              // Masuk, Dibayar, Diproses, Siap Diambil, Selesai, Komplain
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->dateTime('waktu_pembayaran')->nullable();
            $table->timestamps();

            $table->foreign('cafe_id')->references('id')->on('cafe')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
