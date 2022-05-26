<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Auth;

class PesananController extends Controller
{
    //
    public function tambah()
    {
        return view('backend.pesanan.tambah');
    }

    public function list()
    {
        return view('backend.pesanan.index');
    }

    public function simpan(Request $request)
    {
        try {
            dd($request->all());
        } catch (Exception $e) {
            dd($e->getMessage());
            return view('error');
        }
    }
}
