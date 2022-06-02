<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JenisPaket;
use App\Models\Pesanan;
use App\Models\ListPesanan;
use DataTables;
use Exception;
use Validator;
use Storage;
use Auth;
use DB;

class PesananController extends Controller
{
    public function index()
    {
        try {
            return view('backend.pesanan.index');
        } catch (Exception $e) {
            return view('error');
        }
    }

    public function list(Request $request)
    {
        if($request->ajax()) {
            switch(Auth::user()->role) {
                case 'admin':
                    $data = Pesanan::orderBy('id', 'desc')->get();
                    break;
                case 'kurir':
                    $data = Pesanan::where('antar', 'kurir')->orWhere('ambil', 'kurir')->where('id_kurir', Auth::user()->id)->orderBy('id', 'desc')->get();
                    break;
                case 'customer':
                    $data = Pesanan::where('id_user', Auth::user()->id)->orderBy('id', 'desc')->get();
                    break;
            }

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
        }
    }

    public function detail($id_transaksi)
    {
        try {
            $pesanan = Pesanan::where('id_transaksi', $id_transaksi)->first();
            $list_pesanan = ListPesanan::where('id_pesanan', $pesanan->id)->get();

            return view('backend.pesanan.detail', compact(['pesanan', 'list_pesanan']));
        } catch (Exception $e) {
            return view('error');
        }
    }

    public function tambah()
    {
        try {
            if(Auth::user()->wa_verified_at == null) {
                return back()->with('error', 'Verifikasi No. WA anda dengan cara login menggunakan No. WA anda!');
            }

            $kiloan = JenisPaket::where('jenis_paket', 'kiloan')->get();
            $item = JenisPaket::where('jenis_paket', 'item')->get();

            return view('backend.pesanan.tambah', compact(['kiloan', 'item']));
        } catch (Exception $e) {
            return view('error');
        }
    }

    public function simpan(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'paket' => 'required',
                'nama_barang' => 'required',
                'ciri_barang' => 'required',
                'jumlah_barang' => 'required',
                'antar' => 'required',
                'ambil' => 'required',
                'pembayaran' => 'required'
            ]);
                
            if ($validator->fails()) {
                return back()->with('error', 'Pastikan semua terisi dengan benar!');
            }

            $start_transaksi = 1120;
            $paket = JenisPaket::find($request->paket);
            $max_transaksi = Pesanan::max('id_transaksi');

            if($max_transaksi != null) {
                $id_transaksi = $max_transaksi + 1;
            } else {
                $id_transaksi = $start_transaksi + 1;
            }

            if($request->antar == 'kurir' || $request->ambil == 'kurir') {
                $id_kurir = User::select('id')->where('role', 'kurir')->inRandomOrder()->pluck('id')->first();
            } else {
                $id_kurir = null;
            }

            $pesanan = Pesanan::create([
                'id_transaksi' => $id_transaksi,
                'id_user' => Auth::user()->id,
                'id_kurir' => $id_kurir,
                'id_paket' => $paket->id,
                'nama' => Auth::user()->nama,
                'email' => Auth::user()->email,
                'no_wa' => Auth::user()->no_wa,
                'alamat' => Auth::user()->alamat,
                'nama_paket' => $paket->nama_paket,
                'harga_paket' => $paket->harga_paket,
                'antar' => $request->antar,
                'ambil' => $request->ambil,
                'pembayaran' => $request->pembayaran
            ]);

            $total_item = count($request->nama_barang);
            $nama_barang = $request->nama_barang;
            $ciri_barang = $request->ciri_barang;
            $jumlah_barang = $request->jumlah_barang;

            for($i = 0; $i < $total_item; $i++) {
                ListPesanan::create([
                    'id_pesanan' => $pesanan->id,
                    'nama_barang' => $nama_barang[$i],
                    'ciri_ciri' => $ciri_barang[$i],
                    'jumlah' => $jumlah_barang[$i]
                ]);
            }

            if($request->antar == 'kurir') {
                try {
                    $kurir = User::find($id_kurir);
                    $pesan = "TW Laundry - Ada pesanan baru yang harus diambil. Cek website sekarang!";
                    sendwa($kurir->no_wa, $pesan);
                } catch (Exception $error) {
    
                }
            }

            return back()->with('success', 'Pesanan berhasil dibuat, tunggu validasi.');
        } catch (Exception $e) {
            return view('error');
            dd($e->getMessage());
        }
    }

    public function validasi(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'total_kg' => 'required',
                'total_pembayaran' => 'required',
                'nama_barang' => 'required',
                'ciri_barang' => 'required',
                'jumlah_barang' => 'required',
            ]);
            
            if ($validator->fails()) {
                return back()->with('error', 'Pastikan semua terisi dengan benar!');
            }
            
            DB::beginTransaction();

            $pesanan = Pesanan::find($id);
            $pesanan->update([
                'total_kg' => $request->total_kg,
                'total_pembayaran' => $request->total_pembayaran,
                'status_cucian' => 'proses'
            ]);

            ListPesanan::where('id_pesanan', $id)->delete();

            $total_item = count($request->nama_barang);
            $nama_barang = $request->nama_barang;
            $ciri_barang = $request->ciri_barang;
            $jumlah_barang = $request->jumlah_barang;

            for($i = 0; $i < $total_item; $i++) {
                ListPesanan::create([
                    'id_pesanan' => $id,
                    'nama_barang' => $nama_barang[$i],
                    'ciri_ciri' => $ciri_barang[$i],
                    'jumlah' => $jumlah_barang[$i]
                ]);
            }

            DB::commit();

            try {
                $check_wa = checkNumberWa($pesanan->no_wa);
                if($check_wa == 'true') {
                    if($pesanan->pembayaran == 'dana') {
                        $pesan = "TW Laundry - Cucian Anda sudah divalidasi, cucian sedang diproses.\nUnggah bukti pembayaran DANA sekarang, cek website.";
                    } else {
                        $pesan = "TW Laundry - Cucian Anda sudah divalidasi, cucian sedang diproses.";
                    }
                    sendwa($pesanan->no_wa, $pesan);
                }
            } catch (Exception $error) {

            }

            return back()->with('success', 'Berhasil Validasi');
        } catch (Exception $e) {
            DB::rollback();
            return view('error');
            // dd($e->getMessage());
        }
    }

    public function uploadBukti(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'bukti_bayar' => 'required|max:2048',
            ]);
            
            if ($validator->fails()) {
                return back()->with('error', 'Pastikan file dengan benar!');
            }
            
            DB::beginTransaction();

            $path = "images/bukti-tf/";
            $pesanan = Pesanan::find($id);

            if (Storage::disk('public')->exists($path.$pesanan->bukti_bayar)) {
                Storage::disk('public')->delete($path.$pesanan->bukti_bayar);
            }
            
            $nameFile = uploads($request->bukti_bayar, $path);
            $pesanan->update([
                'bukti_bayar' => $nameFile
            ]);

            DB::commit();

            $admin = User::where('role', 'admin')->get();
            foreach($admin as $mimin) {
                try {
                    $pesan = "TW Laundry - Pesanan dengan ID Transaksi $pesanan->id_transaksi sudah upload bukti pembayaran DANA. Segera cek dan validasi !";
                    sendwa($mimin->no_wa, $pesan);
                } catch (Exception $error) {
    
                }
            }

            return back()->with('success', 'Berhasil Validasi');
        } catch (Exception $e) {
            DB::rollback();
            return view('error');
            // dd($e->getMessage());
        }
    }

    public function tolakBukti($id)
    {
        try {
            
            DB::beginTransaction();

            $path = "images/bukti-tf/";
            $pesanan = Pesanan::find($id);

            $pesanan->update([
                'bukti_bayar' => null
            ]);
            
            if (Storage::disk('public')->exists($path.$pesanan->bukti_bayar)) {
                Storage::disk('public')->delete($path.$pesanan->bukti_bayar);
            }

            DB::commit();

            try {
                $pesan = "TW Laundry - Bukti Pembayaran dengan ID Transaksi $pesanan->id_transaksi ditolak. Silahkan upload kembali, pastikan yang anada upload benar !";
                sendwa($pesanan->no_wa, $pesan);
            } catch (Exception $error) {

            }

            return back()->with('success', 'Tolak Bukti Pembayaran Berhasil');
        } catch (Exception $e) {
            DB::rollback();
            return view('error');
            // dd($e->getMessage());
        }
    }

    public function terimaBukti($id)
    {
        try {
            
            DB::beginTransaction();

            $pesanan = Pesanan::find($id);
            $pesanan->update([
                'status_bayar' => 'sudah'
            ]);

            DB::commit();

            try {
                $pesan = "TW Laundry - Bukti Pembayaran dengan ID Transaksi $pesanan->id_transaksi sudah divalidasi.";
                sendwa($pesanan->no_wa, $pesan);
            } catch (Exception $error) {

            }

            return back()->with('success', 'Validasi Bukti Pembayaran Berhasil');
        } catch (Exception $e) {
            DB::rollback();
            return view('error');
            // dd($e->getMessage());
        }
    }

    public function selesai($id)
    {
        try {
            
            DB::beginTransaction();

            $pesanan = Pesanan::find($id);
            $pesanan->update([
                'status_cucian' => 'selesai'
            ]);

            DB::commit();

            return back()->with('success', 'Cucian Selesai');
        } catch (Exception $e) {
            DB::rollback();
            return view('error');
            // dd($e->getMessage());
        }
    }

    public function sendNotif($id)
    {
        try {
            $pesanan = Pesanan::find($id);
            
            if($pesanan->ambil == 'kurir') {
                $wa_kurir = User::select('no_wa')->where('id', $pesanan->id_kurir)->pluck('no_wa')->first();
                try {
                    $pesan_kurir = "TW Laundry - Cucian dengan ID Transaksi $pesanan->id_transaksi sudah SELESAI. Silahkan datang ke Laundry dan antarkan ke alamat Pelanggan.";
                    $pesan_customer = "TW Laundry - Cucian dengan ID Transaksi $pesanan->id_transaksi sudah SELESAI. Cucian akan segera diantar oleh Kurir, silahkan tunggu. Terimakasih.";

                    sendwa($pesanan->no_wa, $pesan_customer);
                    sendwa($wa_kurir, $pesan_kurir);
                } catch (Exception $error) {
    
                }
            } else {
                $pesan_customer = "TW Laundry - Cucian dengan ID Transaksi $pesanan->id_transaksi sudah SELESAI. Cucian sudah dapat diambil, terimakasih.";
                sendwa($pesanan->no_wa, $pesan_customer);
            }

            return back()->with('success', 'Notifikasi WA berhasil dikirim');
        } catch (Exception $e) {
            dd($e->getMessage());
            return view('error');
        }
    }

    public function bayarCod($id)
    {
        try {
            
            DB::beginTransaction();

            $pesanan = Pesanan::find($id);
            $pesanan->update([
                'status_bayar' => 'sudah'
            ]);

            DB::commit();

            return back()->with('success', 'Validasi Pembayaran COD Berhasil');
        } catch (Exception $e) {
            DB::rollback();
            return view('error');
            // dd($e->getMessage());
        }
    }
}
