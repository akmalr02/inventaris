<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    public function index()
    {
        $user = User::all();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user, 200);
    }

    public function store(Request $request) {}

    public function show(string $id)
    {
        // Log::info("Mencari user dengan ID: " . $id);

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user, 200);
    }

    public function update(Request $request, String $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Mendapatkan role user yang sedang login
        $currentUserRole = $user->role;

        $rules = [
            'name' => 'nullable|max:225',
            'email' => 'nullable|email',
            'phone' => 'nullable|min:11|max:13',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Validasi request
        $data = $request->validate($rules);

        // Inisialisasi array untuk gambar baru
        $images = [];

        // Proses upload file jika ada
        if ($request->hasFile('image')) {
            try {
                foreach ($request->file('image') as $file) {
                    $path = $file->store('user', 'public');
                    $images[] = $path;
                }
                $data['image'] = json_encode($images);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Failed to upload image', 'error' => $e->getMessage()], 500);
            }
        } else {
            unset($data['image']); // Pastikan 'image' tidak diisi jika tidak ada file baru
        }

        // Hash password jika ada
        if (isset($data['password']) && $data['password'] !== null) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Hanya admin yang dapat mengubah role
        if ($currentUserRole !== 'admin') {
            unset($data['role']);
        }

        $user->update($data);
        return response()->json($user, 200);
    }


    public function destroyImage(string $id)
    {
        // Mencari user berdasarkan ID
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Menghapus gambar-gambar yang terkait dengan user (jika ada)
        if ($user->image) {
            $images = json_decode($user->image); // Mengambil array gambar dari JSON
            foreach ($images as $image) {
                // Menghapus file gambar dari penyimpanan
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }

            // Menghapus data gambar dari database
            $user->image = null;
            $user->save();  // Simpan perubahan ke database
        }

        return response()->json(['message' => 'Gambar berhasil dihapus'], 200);
    }


    public function gantiPassword(Request $request, String $id)
    {
        // Cek user berdasarkan id
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        // return response()->json($user->password);

        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Password Lama Salah!!!'], 400);
            // return response()->json(!Hash::check($request->current_password, $user->password));
        }
        // return response()->json('berhasil');


        // Aturan validasi
        $rules = [
            'password' => 'required|min:3|max:255|confirmed',
        ];

        // Validasi input
        $data = $request->validate($rules);

        // Hash password baru
        $hashedPassword = Hash::make($data['password']);

        // Update password user
        $user->update(['password' => $hashedPassword]);

        return response()->json(['message' => 'Berhasil Mengubah Password'], 200);
    }
}
