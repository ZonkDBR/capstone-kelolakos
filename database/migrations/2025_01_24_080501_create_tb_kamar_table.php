<?php

// Migration: create_kamar_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbKamarTable extends Migration
{
    public function up()
    {
        Schema::create('kamar', function (Blueprint $table) {
            $table->id('id_kamar');
            $table->foreignId('id_lokasi')->constrained('lokasi_kos', 'id_lokasi');;
            $table->string('nomor_kamar', 20);
            $table->string('tipe_kamar', 50)->nullable();
            $table->decimal('harga', 10, 2);
            $table->text('fasilitas')->nullable();
            $table->enum('status', ['Kosong', 'Terisi'])->default('Kosong');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kamar');
    }
}


