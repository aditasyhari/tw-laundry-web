<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Validator;
use Auth;

class ProfileController extends Controller
{
    //
    public function index()
    {
        return view('backend.profile.index');
    }

    public function ubahProfile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'email' => 'required|email',
                'alamat' => 'required',
                'no_wa' => 'required|numeric',
            ]);
                
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $user = User::find(Auth::user()->id);
            $input = $request->all();

            if($request->email != $user->email) {
                $checkEmail = User::where('email', $request->email)->count();
                if($checkEmail) {
                    return back()->with('error', 'Email ini sudah ada sebelumnya.');
                }

                $input['email_verified_at'] = null;
            }

            if($request->no_wa != $user->no_wa) {
                $checkWa = User::where('no_wa', $request->no_wa)->count();
                if($checkWa) {
                    return back()->with('error', 'No. WA ini sudah ada sebelumnya.');
                }

                $input['wa_verified_at'] = null;
            }

            $user->update($input);
            
            return back()->with('success', 'Profile berhasil diperbarui.');
        } catch (Exception $e) {
            // return view('error');
            dd($e->getMessage());
        }
    }

    public function ubahPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'old_password' => 'nullable',
                'password' => 'required|confirmed|min:8',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $user = User::find(Auth::user()->id);

            if($user->password != null) {
                if (Hash::check($request->old_password, $user->password)) {
                    $user->update([
                        'password' => Hash::make($request->password)
                    ]);
                    
                    return back()->with('success', 'Password berhasil diperbarui');
                }

                return back()->with('error', 'Password lama tidak sesuai');
            } else {
                $user->update([
                    'password' => Hash::make($request->password)
                ]);
                
                return back()->with('success', 'Password berhasil diperbarui');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            // return view('error');
        }
    }
}
