<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PesananController extends Controller
{
    //
    public function list()
    {
        return view('backend.pesanan.index');
    }
}
