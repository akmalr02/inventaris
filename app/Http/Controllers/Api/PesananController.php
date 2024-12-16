<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PesananBarang;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use App\Models\User;


class PesananController extends Controller
{
    public function index()
    {
        // $user = Auth::user();

        // if (!$user) {
        //     return response()->json(['user tidak ditemukakn', 401]);
        // }

        // $pesanan = PesananBarang::with(['barang', 'user'])->whare($user->id)->get;

        // if (!$pesanan) {
        //     return response()->json(['pesanan tidak di temukan', 401]);
        // }

        // return response()->json($pesanan);
    }
}
