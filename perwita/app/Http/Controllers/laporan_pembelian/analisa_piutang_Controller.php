<?php

namespace App\Http\Controllers\laporan_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class analisa_piutang_Controller extends Controller
{
    public function index(){
      return 'a';
      $customer = DB::select(" SELECT kode,nama FROM customer ORDER BY nama ASC ");
      $cabang   = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
      $piutang  = DB::select(" SELECT id_akun,nama_akun FROM d_akun where id_akun like '%1301%' ORDER BY nama_akun ASC ");

      return view('purchase/master/master_penjualan/laporan/lap_analisa_piutang/lap_analisapiutang',compact('customer','piutang','cabang'));
    }

    public function ajax_lap_analisa_piutang(Request $request) {
      dd($request->all());
    }

}
