<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return Laporan::all();
    }

    public function store(Request $request)
    {
        $data = $request->Validated([]);
    }
    public function show() {}
    public function update() {}
    public function destroy() {}
}
