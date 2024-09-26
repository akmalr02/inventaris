<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $laporan = Laporan::with(['laporanBarangRusak', 'laporanBarangKosong.barang', 'pesananBarang.barang', 'user'])->get();
        return response()->json($laporan, 200);
    }

    public function store(Request $request)
    {
        // $data = $request->Validated([]);
    }
    public function show() {}
    public function update() {}
    public function destroy(string $id)
    {
        $laporan = Laporan::find($id);

        if (!$laporan) {
            return response()->json(['message' => 'Pesanan Barang tidak ditemukan'], 404);
        }

        $laporan->delete();

        return response()->json(['message' => 'Pesanan Barang berhasil dihapus']);
    }
}
