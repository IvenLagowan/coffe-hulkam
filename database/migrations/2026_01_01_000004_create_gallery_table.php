<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Galeri foto suasana/ruangan sebuah cafe.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cafe_id');
            $table->string('gambar', 500);
            $table->string('nama_ruangan', 100)->nullable();
            $table->integer('lantai')->nullable();
            $table->timestamps();

            $table->foreign('cafe_id')->references('id')->on('cafe')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery');
    }
};
