<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /**
     * Handle login request.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(LoginRequest $request)
    {
        // DB::enableQueryLog();

        // Ambil kredensial dari request
        $credentials = $request->only('email', 'password');

        // Coba autentikasi menggunakan guard 'api'
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda salah',
            ], 401);
        }
        // dd(DB::getQueryLog());

        // Autentikasi berhasil
        return response()->json([
            'success' => true,
            'user'    => auth()->guard('api')->user(),
            'token'   => $token,
        ], 200);
    }
}
