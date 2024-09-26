<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;



class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('category')->get();

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
            'name' => 'required|unique:barangs|max:255',
            'description' => 'required|max:255',
            'categories_id' => 'required|integer',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'jumlah' => 'required|integer'
        ];

        // $validator = Validator::make($request->all(), $ruls);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }
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
}
