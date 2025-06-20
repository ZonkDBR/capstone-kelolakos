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
        Schema::create('lokasi_kos', function (Blueprint $table) {
            $table->id('id_lokasi');
            $table->string('nama_kos', 100);
            $table->text('alamat');
            $table->integer('kapasitas_total');
            $table->string('kontak_pengelola', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi_kos');
    }
};
