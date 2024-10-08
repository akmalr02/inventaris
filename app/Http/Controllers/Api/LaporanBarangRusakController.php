<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LaporanBarangRusak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class LaporanBarangRusakController extends Controller
{
    public function index()
    {
        $laporan = LaporanBarangRusak::with(['user', 'barang'])->get();
        return response()->json($laporan, 200);
    }

    public function store(Request $request)
    {
        // $user = User::findOrFail($id);

        $data = $request->validate([
            'barang_id' => 'required',
            'description' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah_rusak' => 'required|integer|min:1',
            'kondisi' => 'required|in:Ringan,Sedang,Berat',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        if ($user) {
            $data['user_id'] = $user->id;
        } else {
            return response()->json(['message' => 'User tidak ditemukan'], 401);
        }

        if ($request->hasFile('image')) {
            try {
                $images = [];
                foreach ($request->file('image') as $file) {
                    $path = $file->store('barangRusak', 'public');
                    $images[] = $path;
                }
                $data['image'] = json_encode($images);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Failed to upload image', 'error' => $e->getMessage()], 500);
            }
        }

        try {
            $barangRusak = LaporanBarangRusak::create($data);
            return response()->json($barangRusak, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create Laporan Barang Rusak', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $barangRusak = LaporanBarangRusak::with('user', 'barang')->find($id);

        if (!$barangRusak) {
            return response()->json(['message' => 'Laporan Barang Rusak tidak ditemukan'], 404);
        }

        $barangRusak->user_name = $barangRusak->user ? $barangRusak->user->name : null;

        if ($barangRusak->barang) {
            $barangRusak->barang_name = $barangRusak->barang->name;
        } else {
            $barangRusak->barang_name = null;
        }

        return response()->json($barangRusak);
    }

    public function update(Request $request, String $id)
    {
        $barangRusak = LaporanBarangRusak::find($id);
        if (!$barangRusak) {
            return response()->json(['message' => 'Laporan tidak ditemukan'], 404);
        }

        $data = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'description' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah_rusak' => 'required|integer|min:1',
            'kondisi' => 'required|in:Ringan,Sedang,Berat',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 401);
        }

        $data['user_id'] = $user->id;

        if ($request->hasFile('image')) {
            try {
                $images = [];
                foreach ($request->file('image') as $file) {
                    $images[] = $file->store('barangRusak', 'public');
                }

                if ($barangRusak->image) {
                    $oldImages = json_decode($barangRusak->image, true);
                    foreach ($oldImages as $oldImage) {
                        Storage::delete('public/' . $oldImage);
                    }
                }

                $data['image'] = json_encode($images);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Failed to update images', 'error' => $e->getMessage()], 500);
            }
        }

        try {
            $barangRusak->update($data);
            return response()->json($barangRusak, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update Laporan Barang Rusak', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $laporanBarangRusak = LaporanBarangRusak::find($id);

        if (!$laporanBarangRusak) {
            return response()->json(['message' => 'Laporan Barang Rusak tidak ditemukan'], 404);
        }
        try {
            $laporanBarangRusak->delete();
            return response()->json(['message' => 'Laporan Barang Rusak berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete Laporan Barang Rusak',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
