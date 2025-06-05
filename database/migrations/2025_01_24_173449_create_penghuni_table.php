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
        Schema::create('penghuni', function (Blueprint $table) {
            $table->id('id_penghuni');
            $table->foreignId('id_kamar')->nullable()->constrained('kamar', 'id_kamar');
            $table->foreignId('id_lokasi')->constrained('lokasi_kos', 'id_lokasi');
            $table->string('nama_penghuni', 100);
            $table->string('no_ktp', 20);
            $table->string('no_hp', 15)->nullable();
            $table->text('alamat_asal')->nullable();
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penghuni');
    }
};
