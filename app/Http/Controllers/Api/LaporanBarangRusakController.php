<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LaporanBarangRusak;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class LaporanBarangRusakController extends Controller
{
    public function index()
    {
        $laporan = LaporanBarangRusak::all();
        return response()->json($laporan, 200);
    }

    public function store(Request $request)
    {
        // $user = User::findOrFail($id);

        $data = $request->validate([
            'nama_barang' => 'required|string',
            'description' => 'required|string',
            'tanggal' => 'required|date',
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
                    $path = $file->store('images', 'public');
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
        $barangRusak = LaporanBarangRusak::find($id);

        if (!$barangRusak) {
            return response()->json(['message' => 'Laporan Barang Rusak tidak ditemukan'], 404);
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
            'nama_barang' => 'required|string|max:255',
            'description' => 'required|string',
            'tanggal' => 'required|date',
            // 'image' => 'nullable|array',
            // 'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
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
                    $images[] = $file->store('images', 'public');
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
