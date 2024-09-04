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
        Schema::create('laporan_barang_rusaks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->text('description');
            $table->date('tanggal');
            $table->json('image');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            //tambahkan foto barang rusak dan user id pelapor
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_barang_rusaks');
    }
};
