<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Meja yang tersedia di sebuah cafe (untuk fitur reservasi/booking).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cafe_table', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cafe_id');
            $table->string('no_table', 50);
            $table->integer('max_person')->default(2);
            $table->timestamps();

            $table->foreign('cafe_id')->references('id')->on('cafe')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cafe_table');
    }
};
