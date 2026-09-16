<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Reservasi/booking meja oleh pelanggan.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cafe_id');
            $table->uuid('table_id');
            $table->foreignId('cust_id')->constrained('users')->cascadeOnDelete();
            $table->integer('num_person')->default(1);
            $table->dateTime('tgl');
            $table->text('catatan')->nullable();
            $table->string('status')->default('pending');   // pending, confirmed, cancelled, completed
            $table->timestamps();

            $table->foreign('cafe_id')->references('id')->on('cafe')->cascadeOnDelete();
            $table->foreign('table_id')->references('id')->on('cafe_table')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
