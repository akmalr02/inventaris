<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return response()->json($category);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:categories',
            'description' => 'required|max:255',
        ]);

        $category = Category::create($data);
        return response()->json($category, 201);
    }

    public function show(String $id)
    {
        $data = Category::find($id);

        if (!$data) {
            return response()->json(['message' => 'category tidak di temukan']);
        }

        return response()->json($data, 201);
    }

    public function update(Request $request, String $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'category tidak di temukan']);
        }

        $data = $request->validate([
            'name' => 'required|unique:categories',
            'description' => 'required|max:255',

        ]);

        $category->update($data);
        return response()->json($category, 201);
    }

    public function destroy(String $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'category tidak di temukan']);
        }

        try {
            $category->delete();
            return response()->json(['message' => 'category berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete categry',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
