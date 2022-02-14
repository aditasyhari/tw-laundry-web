<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    //
    public function keuangan()
    {
        return view('backend.laporan.keuangan');
    }

    public function pesanan()
    {
        return view('backend.laporan.pesanan');
    }
}
