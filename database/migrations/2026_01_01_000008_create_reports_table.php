<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Laporan/komplain dari pengguna terhadap vendor/cafe (dikelola Admin).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelapor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('terlapor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->uuid('terlapor_cafe_id')->nullable();
            $table->string('tipe');                          // terhadap_vendor / terhadap_user
            $table->string('kategori_laporan');
            $table->text('deskripsi');
            $table->string('status')->default('baru');       // baru, ditinjau, selesai
            $table->text('bukti')->nullable();
            $table->timestamps();

            $table->foreign('terlapor_cafe_id')->references('id')->on('cafe')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
