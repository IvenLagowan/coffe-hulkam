<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Baris detail item pada sebuah transaksi.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_detail', function (Blueprint $table) {
            $table->id();
            $table->uuid('transaksi_id');
            $table->uuid('menu_id');
            $table->integer('jumlah')->default(1);
            $table->decimal('harga_saat_transaksi', 12, 2)->default(0);

            $table->foreign('transaksi_id')->references('id')->on('transaksi')->cascadeOnDelete();
            $table->foreign('menu_id')->references('id')->on('menu')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_detail');
    }
};
