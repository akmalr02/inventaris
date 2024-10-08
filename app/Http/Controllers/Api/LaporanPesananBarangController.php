<?php

namespace App\Http\Controllers\Api;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\PesananBarang;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LaporanPesananBarangController extends Controller
{
    public function index()
    {
        $pesanan = PesananBarang::with(['barang', 'user'])->get();
        return response()->json($pesanan, 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'description' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jumlah_pesanan' => 'required|integer',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 401);
        }

        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 401);
        }

        // Mencari barang berdasarkan barang_id
        $barang = Barang::find($data['barang_id']);

        // Mengecek apakah stok barang mencukupi
        if ($barang->jumlah < $data['jumlah_pesanan']) {
            return response()->json(['message' => 'Stok barang tidak mencukupi'], 400);
        }

        // Kurangi jumlah barang
        $barang->jumlah -= $data['jumlah_pesanan'];
        $barang->save();  // Simpan perubahan stok barang


        $data['user_id'] = $user->id;
        $pesananBarang = PesananBarang::create($data);

        return response()->json($pesananBarang, 201);
    }

    public function show($id)
    {
        $pesananBarang = PesananBarang::with('user', 'barang')->find($id);

        if (!$pesananBarang) {
            return response()->json(['message' => 'Pesanan Barang tidak ditemukan'], 404);
        }

        $pesananBarang->user_name = $pesananBarang->user ? $pesananBarang->user->name : null;

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
