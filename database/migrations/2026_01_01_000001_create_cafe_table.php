<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel utama data cafe/kedai yang dikelola vendor.
 * PK berupa UUID (string) mengikuti pola aplikasi (Str::uuid()).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cafe', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('vendor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama');
            $table->string('status')->default('pending');      // pending, approved, rejected
            $table->text('alasan_ditolak')->nullable();
            $table->string('titik_geo')->nullable();
            $table->string('no_telp', 30)->nullable();
            $table->text('alamat')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('fasilitas')->nullable();
            $table->text('galeri')->nullable();                // legacy field (URL galeri lama)
            $table->string('foto_profil', 500)->nullable();
            $table->string('jam_operasional')->nullable();
            $table->boolean('is_open')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cafe');
    }
};
