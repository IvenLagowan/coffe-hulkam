<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Daftar menu (makanan/minuman) milik sebuah cafe.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cafe_id');
            $table->string('nama_menu');
            $table->decimal('harga', 12, 2)->default(0);
            $table->text('deskripsi')->nullable();
            $table->string('gambar', 500)->nullable();
            $table->string('kategori')->nullable();            // Kopi, Non-Kopi, Makanan, Snack
            $table->string('status')->default('tersedia');     // tersedia, habis
            $table->timestamps();

            $table->foreign('cafe_id')->references('id')->on('cafe')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
