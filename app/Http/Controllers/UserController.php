<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function customer()
    {
        return view('backend.user.customer');
    }

    public function kurir()
    {
        return view('backend.user.kurir');
    }
}
