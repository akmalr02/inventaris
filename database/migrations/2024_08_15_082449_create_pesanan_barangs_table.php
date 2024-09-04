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
        Schema::create('pesanan_barangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id'); // Mengganti nama_barang menjadi barang_id
            $table->text('description');
            $table->date('tanggal');
            $table->integer('jumlah_pesanan');
            $table->unsignedBigInteger('user_id'); // Menambahkan kolom user_id pemesan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_barangs');
    }
};
