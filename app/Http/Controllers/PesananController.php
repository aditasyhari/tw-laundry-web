<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JenisPaket;
use App\Models\Pesanan;
use App\Models\ListPesanan;
use Exception;
use Validator;
use Auth;

class PesananController extends Controller
{
    //
    public function tambah()
    {
        try {
            $kiloan = JenisPaket::where('jenis_paket', 'kiloan')->get();
            $item = JenisPaket::where('jenis_paket', 'item')->get();

            return view('backend.pesanan.tambah', compact(['kiloan', 'item']));
        } catch (Exception $e) {
            return view('error');
        }
    }

    public function list()
    {
        try {
            return view('backend.pesanan.index');
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
                $id_transaksi = $start_transaksi + $max_transaksi + 1;
            } else {
                $id_transaksi = $start_transaksi + 1;
            }

            $id_kurir = User::select('id')->where('role', 'kurir')->inRandomOrder()->pluck('id')->first();

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

            try {
                if($request->antar == 'kurir') {
                    $kurir = User::find($id_kurir);
                    $check_wa = checkNumberWa($kurir->no_wa);
                    if($check_wa == 'true') {
                        $pesan = "TW Laundry - Ada pesanan baru yang harus diambil. Cek website sekarang!";
                        sendwa($kurir->no_wa, $pesan);
                    }
                }
            } catch (Exception $error) {

            }

            return back()->with('success', 'Pesanan berhasil dibuat, tunggu validasi.');
        } catch (Exception $e) {
            return view('error');
            dd($e->getMessage());
        }
    }
}
