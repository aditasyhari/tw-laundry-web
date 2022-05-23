<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class GoogleController extends Controller
{
    //
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->orWhere('email', $user->email)->first();
            // dd($user->avatar);

            if($finduser){
                if($finduser->email_verified_at == null) {
                    User::where('google_id', $user->id)->orWhere('email', $user->email)->update([
                        'email_verified_at' => date("Y-m-d H:i:s")
                    ]);
                }
                Auth::login($finduser);
                return redirect()->intended('dashboard');
            } else {
                $newUser = User::create([
                    'nama' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => date("Y-m-d H:i:s"),
                    'google_id'=> $user->id,
                    'photo' => $user->avatar
                ]);

                Auth::login($newUser);
                return redirect()->intended('dashboard');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
