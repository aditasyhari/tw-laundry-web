<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Exception;
use Auth;

class EmailController extends Controller
{
    public function login(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if($user) {
                if (Hash::check($request->password, $user->password)) {
                    Auth::login($user);
                    return redirect()->intended('dashboard');
                } else {
                    return back()->with('error', 'Password salah');
                }
            } else {
                return back()->with('error', 'Email belum terdaftar');
            }
        } catch (Exception $e) {
            return view('error');
        }
    }
}
