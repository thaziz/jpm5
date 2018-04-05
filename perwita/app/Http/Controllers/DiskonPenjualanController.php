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

        $cabang = DB::table('cabang')
            ->select('kode', 'nama')
            ->get();

        return view('sales/diskon_penjualan/index', compact('data', 'cabang'));
    }

    public function create()
    {

        return view('sales/diskon_penjualan/create');
    }
}
