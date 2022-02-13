<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Validator;

class RegisterController extends Controller
{
    //
    public function index()
    {
        return view('backend.auth.register');
    }

    public function register(Request $request)
    {
        try {
            $newUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'no_telp' => $request->no_telp,
                'password' => Hash::make('password'),
            ]);

            Auth::login($newUser);
            return redirect()->intended('dashboard');

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
