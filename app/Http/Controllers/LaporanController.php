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
use DataTables;

class LaporanController extends Controller
{
    //
    public function keuangan(Request $request)
    {
        try {
            $method = $request->method();
            if($method == 'GET') {
                $paket = DB::table('jenis_paket as jp')->select(
                    'jp.nama_paket',
                    DB::raw("(SELECT SUM(total_pembayaran) FROM pesanan as p WHERE p.id_paket = jp.id AND MONTH(created_at) = MONTH(now()) AND YEAR(created_at) = YEAR(now())) AS total")
                )
                ->get();

                $date = Carbon::now();
                $bulan = $date->translatedFormat('F');
                $tahun = $date->format('Y');
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

                $jumlah = array_sum($total);

                return view('backend.laporan.keuangan', compact(['nama_paket', 'total', 'bulan', 'tahun', 'jumlah']));        
            } else {
                $validator = Validator::make($request->all(), [
                    'dari' => 'required',
                    'sampai' => 'required',
                ]);
                    
                if ($validator->fails()) {
                    return back()->with('error', 'Pastikan tanggal dipilih dengan benar!');
                }

                $dari = Carbon::parse($request->dari)->translatedFormat('d F Y');
                $sampai = Carbon::parse($request->sampai)->translatedFormat('d F Y');
                $dari_date = $request->dari;
                $sampai_date = $request->sampai;
                $nama_paket = [];
                $total = [];

                $paket = JenisPaket::select('id', 'nama_paket')->get();
                
                foreach($paket as $p) {
                    array_push($nama_paket, $p->nama_paket);
                    $total_uang = Pesanan::where('id_paket', $p->id)
                                    ->whereDate('created_at', '>=', $request->dari)
                                    ->whereDate('created_at', '<=', $request->sampai)
                                    ->sum('total_pembayaran');

                    if($total_uang == null) {
                        array_push($total, 0);
                    } else {
                        array_push($total, intval($total_uang));
                    }
                }

                $jumlah = array_sum($total);

                return view('backend.laporan.keuangan', compact(['nama_paket', 'total', 'dari', 'sampai', 'jumlah', 'dari_date', 'sampai_date']));        
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            return view('error');
        }
    }

    public function listKeuangan(Request $request)
    {
        if($request->ajax()) {
            if($request->dari && $request->sampai) {
                $data = Pesanan::orderBy('id', 'desc')
                        ->whereDate('created_at', '>=', $request->dari)
                        ->whereDate('created_at', '<=', $request->sampai)
                        ->where('status_cucian', 'selesai')
                        ->get();
            } else {
                $tahun = date('Y');
                $bulan = date('m');
                $data = Pesanan::orderBy('id', 'desc')
                        ->whereYear('created_at', '>=', $tahun)
                        ->whereMonth('created_at', '<=', $bulan)
                        ->get();
            }

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
        }
    }

    public function listPesanan(Request $request)
    {
        if($request->ajax()) {
            if($request->dari && $request->sampai) {
                $data = Pesanan::orderBy('id', 'desc')
                        ->whereDate('created_at', '>=', $request->dari)
                        ->whereDate('created_at', '<=', $request->sampai)
                        ->where('status_cucian', 'selesai')
                        ->get();
            } else {
                $tahun = date('Y');
                $bulan = date('m');
                $data = Pesanan::orderBy('id', 'desc')
                        ->whereYear('created_at', '>=', $tahun)
                        ->whereMonth('created_at', '<=', $bulan)
                        ->get();
            }

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
        }
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
                $bulan = $date->translatedFormat('F');
                $tahun = $date->format('Y');
                $nama_paket = [];
                $total = [];
                foreach($paket as $p) {
                    array_push($nama_paket, $p->nama_paket);
                    array_push($total, $p->total);
                }

                $jumlah = array_sum($total);

                return view('backend.laporan.pesanan', compact(['nama_paket', 'total', 'bulan', 'tahun', 'jumlah']));
            } else {
                $validator = Validator::make($request->all(), [
                    'dari' => 'required',
                    'sampai' => 'required',
                ]);
                    
                if ($validator->fails()) {
                    return back()->with('error', 'Pastikan tanggal dipilih dengan benar!');
                }

                $dari = Carbon::parse($request->dari)->translatedFormat('d F Y');
                $sampai = Carbon::parse($request->sampai)->translatedFormat('d F Y');
                $nama_paket = [];
                $total = [];

                $paket = JenisPaket::select('id', 'nama_paket')->get();
                
                foreach($paket as $p) {
                    array_push($nama_paket, $p->nama_paket);
                    $total_order = Pesanan::where('id_paket', $p->id)
                                    ->whereDate('created_at', '>=', $request->dari)
                                    ->whereDate('created_at', '<=', $request->sampai)
                                    ->count();

                    if($total_order == null) {
                        array_push($total, 0);
                    } else {
                        array_push($total, intval($total_order));
                    }
                }

                $jumlah = array_sum($total);

                return view('backend.laporan.pesanan', compact(['nama_paket', 'total', 'dari', 'sampai', 'jumlah']));
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            return view('error');
        }
    }
}
