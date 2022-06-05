<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pesanan;
use DataTables;
use Validator;
use Exception;
use Auth;
use DB;

class UserController extends Controller
{
    //
    public function dashboard()
    {
        try {
            switch(Auth::user()->role) {
                case 'customer':
                    $id_user = Auth::user()->id;
                    $paket = DB::table('jenis_paket as jp')->select(
                        'jp.nama_paket',
                        DB::raw("(SELECT COUNT(*) FROM pesanan as p WHERE p.id_paket = jp.id AND p.id_user = $id_user AND MONTH(created_at) = MONTH(now()) AND YEAR(created_at) = YEAR(now())) AS total")
                    )
                    ->get();
                    $totalBulan = Pesanan::where('id_user', $id_user)->whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->count();
                    $totalSemua = Pesanan::where('id_user', $id_user)->count();
    
                    $nama_paket = [];
                    $total = [];
                    foreach($paket as $p) {
                        array_push($nama_paket, $p->nama_paket);
                        if($p->total == null) {
                            array_push($total, 0);
                        } else {
                            array_push($total, intval($p->total));
                        }
                    }

                    $data = [
                        'nama_paket' => $nama_paket,
                        'total' => $total,
                        'total_bulan' => $totalBulan,
                        'total_semua' => $totalSemua
                    ];
                    break;
                case 'admin':
                    $paket = DB::table('jenis_paket as jp')->select(
                        'jp.nama_paket',
                        DB::raw("(SELECT COUNT(*) FROM pesanan as p WHERE p.id_paket = jp.id AND MONTH(created_at) = MONTH(now()) AND YEAR(created_at) = YEAR(now())) AS total")
                    )
                    ->get();
                    $totalPesananBulan = Pesanan::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->count();
                    $totalPendapatanBulan = Pesanan::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->sum('total_pembayaran');
                    $totalPesananSemua = Pesanan::count();
                    $totalPelanggan = User::where('role', 'customer')->count();
    
                    $nama_paket = [];
                    $total = [];
                    foreach($paket as $p) {
                        array_push($nama_paket, $p->nama_paket);
                        if($p->total == null) {
                            array_push($total, 0);
                        } else {
                            array_push($total, intval($p->total));
                        }
                    }

                    $data = [
                        'nama_paket' => $nama_paket,
                        'total' => $total,
                        'total_pesanan_bulan' => $totalPesananBulan,
                        'total_pesanan_semua' => $totalPesananSemua,
                        'total_pendapatan_bulan' => $totalPendapatanBulan,
                        'total_pelanggan' => $totalPelanggan,
                    ];
                    break;
                case 'kurir':
                    $data = '';
                    break;
            }

            return view('backend.dashboard', compact(['data']));
        } catch (Exception $e) {
            return view('error');
        }
    }

    public function customer()
    {
        try {
            return view('backend.user.customer');
        } catch (Exception $e) {
            return view('error');
        }
    }

    public function customerList(Request $request)
    {
        if($request->ajax()) {
            $data = User::where('role', 'customer')->orderBy('role', 'asc')->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
        }
    }

    public function tambahCustomer(Request $request)
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
                'role' => 'customer'
            ]);

            return back()->with('success', 'Berhasil menambahkan Pelanggan');
        } catch (Exception $e) {
            return view('error');
            // dd($e->getMessage());
        }
    }

    public function updateCustomer(Request $request, $id)
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
            
            return back()->with('success', 'Data Pelanggan berhasil diperbarui.');
        } catch (Exception $e) {
            // return view('error');
            dd($e->getMessage());
        }
    }

    public function hapusCustomer($id)
    {
        try {
            $data = User::find($id);

            User::destroy($id);

            return response()->json('success', 200);
        } catch (Exception $e) {
            return view('error');
        }
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
