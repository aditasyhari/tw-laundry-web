<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class WaController extends Controller
{
    //
    public function index()
    {
        return view('backend.auth.wa');
    }

    public function check(Request $request)
    {
        try {
            $no_telp = $request->no_telp;
            $user = User::where('no_wa', $no_telp)->first();

            if(isset($user)) {
                $checkwa = checkNumberWa($no_telp);
                if($checkwa != 'true') {
                    return back()->with('error', 'nomor belum terdaftar ke whatsapp.');
                } else {
                    $otp = rand(110022, 999900);
                    $user = User::find($user->id);
                    $user->update(['otp' => $otp]);
    
                    $body = "Kode OTP anda adalah $otp oleh Twingky Wingky Laundry";
                    $to = gantiFormatNomor($no_telp);
    
                    sendwa($to, $body);
    
                    return view('backend.auth.otp', compact(['no_telp']));
                }
            }

            return back()->with('error', 'nomor belum terdaftar.');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function login(Request $request)
    {
        try {
            $user = User::where('no_wa', $request->no_telp)->first();
            if ($user->otp == $request->otp) {
                if($user->wa_verified_at == null) {
                    User::where('no_wa', $request->no_telp)->update([
                        'wa_verified_at' => date("Y-m-d H:i:s")
                    ]);
                }
                
                Auth::login($user);
                return redirect()->intended('dashboard');
            }

            return back()->with('error', 'Gagal login kode OTP salah!');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

}
