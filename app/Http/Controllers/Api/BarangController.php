<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class BarangController extends Controller
{
    public function index()
    {
        return Barang::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'categories_id' => 'required',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'jumlah' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $images = [];
            foreach ($request->file('image') as $file) {

                $path = $file->store('images', 'public');
                $images[] = $path;
            }

            $data['image'] = json_encode($images);

            $Barang = Barang::create($data);
            return response()->json($Barang, 200);
        }
    }

    public function show(String $id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['massage' => 'barang tidak ditemukan']);
        }

        return response()->json($barang);
    }

    public function update(Request $request, String $id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['massage' => 'barang tidak ditemukan']);
        }

        $updateBarang = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'categories_id' => 'required',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'jumlah' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $images = [];
            foreach ($request->file('image') as $file) {

                $path = $file->store('images', 'public');
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
}
