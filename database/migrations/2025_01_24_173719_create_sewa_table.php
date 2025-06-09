<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sewa', function (Blueprint $table) {
            $table->id('id_sewa');
            $table->foreignId('id_penghuni')->constrained('penghuni', 'id_penghuni');
            $table->foreignId('id_kamar')->constrained('kamar', 'id_kamar');
            $table->date('tanggal_sewa');
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status', ['Aktif', 'Berahkir'])->default('Aktif');
            $table->string('status_pembayaran')->default('Belum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sewa');
    }
};