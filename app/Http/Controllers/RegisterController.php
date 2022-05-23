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
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'email' => 'required|email|unique:users',
                'alamat' => 'required',
                'no_wa' => 'required|numeric|unique:users',
                'password' => 'required|confirmed|min:8',
            ]);
                
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $newUser = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'no_wa' => $request->no_wa,
                'password' => Hash::make($request->password),
            ]);

            Auth::login($newUser);
            return redirect()->intended('dashboard');

        } catch (Exception $e) {
            return view('error');
            dd($e->getMessage());
        }
    }
}
