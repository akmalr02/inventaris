<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LaporanBarangKosong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LaporanBarangKosongController extends Controller
{
    public function index()
    {
        return LaporanBarangKosong::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'barang_id' => 'required',
            'description' => 'required',
            'tanggal' => 'required',

        ]);

        $user = Auth::user();
        if ($user) {
            $data['user_id'] = $user->id;
        } else {
            return response()->json(['message' => 'User tidak ditemukan'], 401);
        }

        $barangKosong = LaporanBarangKosong::create($data);
        return response()->json($barangKosong, 200);
    }

    public function show(String $id)
    {
        $barangKosong = LaporanBarangKosong::find($id);

        if (!$barangKosong) {
            return response()->json(['message' => 'Laporan Barang Kosong tidak ditemukan'], 404);
        }
        return response()->json($barangKosong);
    }

    public function update(Request $request, String $id)
    {
        $barangKosong = LaporanBarangKosong::find($id);
        if (!$barangKosong) {
            return response()->json(['error' => 'Barang kosong not found'], 404);
        }
        $ruls = [
            'barang_id' => 'required',
            'description' => 'required',
            'tanggal' => 'required',
        ];
        $data = $request->validate($ruls);

        $user = Auth::user();
        if ($user) {
            $data['user_id'] = $user->id;
        } else {
            return response()->json(['message' => 'User tidak ditemukan'], 401);
        }

        $barangKosong->update($data);
        return response()->json($barangKosong, 200);
    }

    public function destroy(String $id)
    {
        $barangKosong = LaporanBarangKosong::find($id);
        if (!$barangKosong) {
            return response()->json(['error' => 'Laporan Barang kosong not found'], 404);
        }

        try {
            $barangKosong->delete();
            return response()->json(['message' => 'Laporan Barang kosong deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete Laporan Barang kosong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
