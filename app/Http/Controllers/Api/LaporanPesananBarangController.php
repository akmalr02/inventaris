<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\PesananBarang;
use Illuminate\Support\Facades\Auth;

class LaporanPesananBarangController extends Controller
{
    public function index()
    {
        return PesananBarang::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'description' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah_pesanan' => 'required|integer',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 401);
        }

        $data['user_id'] = $user->id;
        $pesananBarang = PesananBarang::create($data);

        return response()->json($pesananBarang, 201);
    }

    public function show($id)
    {
        $pesananBarang = PesananBarang::find($id);

        if (!$pesananBarang) {
            return response()->json(['message' => 'Pesanan Barang tidak ditemukan'], 404);
        }

        return response()->json($pesananBarang);
    }

    public function update(Request $request, $id)
    {
        $pesananBarang = PesananBarang::find($id);

        if (!$pesananBarang) {
            return response()->json(['message' => 'Pesanan Barang tidak ditemukan'], 404);
        }

        $data = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'description' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah_pesanan' => 'required|integer',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 401);
        }

        $data['user_id'] = $user->id;
        $pesananBarang->update($data);

        return response()->json($pesananBarang);
    }

    public function destroy($id)
    {
        $pesananBarang = PesananBarang::find($id);

        if (!$pesananBarang) {
            return response()->json(['message' => 'Pesanan Barang tidak ditemukan'], 404);
        }

        $pesananBarang->delete();

        return response()->json(['message' => 'Pesanan Barang berhasil dihapus']);
    }
}
