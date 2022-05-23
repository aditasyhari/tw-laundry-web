<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Validator;
use Exception;

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

    public function kurirList(Request $request)
    {
        if($request->ajax()) {
            $data = User::where('role', 'kurir')->orderBy('role', 'asc')->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
        }
    }

    public function tambahKurir(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'email' => 'required|email|unique:users',
                'alamat' => 'required',
                'no_wa' => 'required|numeric|unique:users',
            ]);
                
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'no_wa' => $request->no_wa,
                'role' => 'kurir'
            ]);

            return back()->with('success', 'Berhasil menambahkan Kurir.');
        } catch (Exception $e) {
            return view('error');
            // dd($e->getMessage());
        }
    }

    public function updateKurir(Request $request, $id)
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

            $user = User::find($id);
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
            
            return back()->with('success', 'Data Kurir berhasil diperbarui.');
        } catch (Exception $e) {
            // return view('error');
            dd($e->getMessage());
        }
    }

    public function hapusKurir($id)
    {
        try {
            $data = User::find($id);

            User::destroy($id);

            return response()->json('success', 200);
        } catch (Exception $e) {
            return view('error');
        }
    }

}
