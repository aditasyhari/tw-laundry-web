<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisPaket;
use App\Models\Pesanan;
use Carbon\Carbon;
use Exception;
use Validator;
use DB;
use DateTime;

class LaporanController extends Controller
{
    //
    public function keuangan()
    {
        return view('backend.laporan.keuangan');
    }

    public function pesanan(Request $request)
    {
        try {
            $method = $request->method();
            if($method == 'GET') {
                $paket = DB::table('jenis_paket as jp')->select(
                    'jp.nama_paket',
                    DB::raw("(SELECT COUNT(*) FROM pesanan as p WHERE p.id_paket = jp.id AND MONTH(created_at) = MONTH(now()) AND YEAR(created_at) = YEAR(now())) AS total")
                )
                ->get();

                $date = Carbon::now();
                $bulan = $date->format('F');
                $tahun = $date->format('Y');
                $nama_paket = [];
                $total = [];
                foreach($paket as $p) {
                    array_push($nama_paket, $p->nama_paket);
                    array_push($total, $p->total);
                }

                return view('backend.laporan.pesanan', compact(['nama_paket', 'total', 'bulan', 'tahun']));
            } else {
                $validator = Validator::make($request->all(), [
                    'bulan' => 'required',
                    'tahun' => 'required',
                ]);
                    
                if ($validator->fails()) {
                    return back()->with('error', 'Pastikan bulan dan tahun dipilih!');
                }

                $paket = DB::table('jenis_paket as jp')->select(
                    'jp.nama_paket',
                    DB::raw("(SELECT COUNT(*) FROM pesanan as p WHERE p.id_paket = jp.id AND MONTH(created_at) = $request->bulan AND YEAR(created_at) = $request->tahun) AS total")
                )
                ->get();

                $nomor_bulan  = intval($request->bulan);
                $dateObj   = DateTime::createFromFormat('!m', $nomor_bulan);
                $bulan = $dateObj->format('F');
                $tahun = $request->tahun;
                $nama_paket = [];
                $total = [];
                foreach($paket as $p) {
                    array_push($nama_paket, $p->nama_paket);
                    array_push($total, $p->total);
                }

                return view('backend.laporan.pesanan', compact(['nama_paket', 'total', 'bulan', 'tahun']));
            }
        } catch (Exception $e) {\
            dd($e->getMessage());
            return view('error');
        }
    }
}
