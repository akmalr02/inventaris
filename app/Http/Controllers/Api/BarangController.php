<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\LaporanBarangKosong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('category')->where('jumlah', '>', 0)->get();

        return response()->json($barangs, 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:barangs|max:255',
            'description' => 'required|max:255',
            'categories_id' => 'required',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'jumlah' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $images = [];
            foreach ($request->file('image') as $file) {

                $path = $file->store('barangs', 'public');
                $images[] = $path;
            }

            $data['image'] = json_encode($images);

            $Barang = Barang::create($data);
            return response()->json($Barang, 200);
        }
    }

    public function show(String $id)
    {
        $barang = Barang::with('category')->find($id);

        if (!$barang) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        return response()->json($barang, 200);
    }

    public function update(Request $request, String $id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['massage' => 'barang tidak ditemukan']);
        }

        $ruls = [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'categories_id' => 'required|integer',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'jumlah' => 'required|integer'
        ];


        $updateBarang = $request->validate($ruls);

        if ($request->hasFile('image')) {
            $images = [];
            foreach ($request->file('image') as $file) {

                $path = $file->store('barangs', 'public');
                $images[] = $path;
            }

            if ($barang->image) {
                $oldImages = json_decode($barang->image, true);
                foreach ($oldImages as $oldImage) {
                    Storage::delete('public/' . $oldImage);
                }
            }
            $updateBarang['image'] = json_encode($images);
        }
        var_dump($barang);

        $barang->update($updateBarang);
        return response()->json($barang, 201);
    }

    public function destroy($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['massage' => 'Barang tidak ditemukan']);
        }

        try {
            $barang->delete();
            return response()->json(['message' => 'Barang berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete Barang',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function tambahBarang(Request $request, $id)
    {
        // Validasi input jumlah dan tanggal
        $request->validate([
            'jumlah' => 'required|integer',
            'tanggal' => 'required|date'
        ]);

        // Cari laporan barang kosong di tabel laporan_barang_kosongs berdasarkan ID
        $laporanBarangKosong = LaporanBarangKosong::find($id);

        if (!$laporanBarangKosong) {
            return response()->json(['message' => 'Laporan barang kosong tidak ditemukan.'], 404);
        }

        // Cari barang di tabel Barang berdasarkan barang_id dari laporan barang kosong
        $barang = Barang::find($laporanBarangKosong->barang_id);

        if ($barang) {
            // Jika barang ada, tambahkan jumlahnya
            $barang->jumlah += $request->input('jumlah');
            $barang->save(); // Simpan perubahan
        } else {
            return response()->json(['message' => 'Barang tidak ditemukan di tabel barang.'], 404);
        }

        // Hapus laporan dari tabel laporan_barang_kosongs setelah stok barang diperbarui
        $laporanBarangKosong->delete();

        return response()->json(['message' => 'Jumlah barang berhasil diperbarui dan laporan barang kosong telah dihapus.', 'data' => $barang], 200);
    }
}
