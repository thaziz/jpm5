<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class DiskonPenjualanController extends Controller
{
    public function index()
    {

        $data = DB::table('d_disc_cabang')
            ->join('d_mem', 'dc_mem', '=', 'm_id')
            ->join('cabang', 'kode', '=', 'dc_cabang')
            ->select('dc_cabang', 'nama', 'dc_diskon', 'm_name')
            ->get();

        $status = Session::get('cabang');

        $akun = DB::table('d_akun')
            ->select('id_akun', 'nama_akun')
            ->where('id_akun', 'like', '5298%')
            ->get();

        if ($status == '000'){
            $cabang = DB::table('cabang')
                ->select('kode', 'nama')
                ->get();

        } else {
            $cabang = DB::table('cabang')
                ->select('kode', 'nama')
                ->where('kode', '=', $status)
                ->get();

        }

        return view('sales/diskon_penjualan/index', compact('data', 'cabang', 'akun'));
    }

    public function create()
    {
        return view('sales/diskon_penjualan/create');
    }

    public function getAkun(Request $request)
    {

    }
}
