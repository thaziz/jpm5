<?php

namespace App\Http\Controllers\master_keuangan\laporan;

ini_set('max_execution_time', 120);

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Dompdf\Dompdf;
use PDF;
use Excel;

class laporan_neraca_saldo extends Controller
{
    public function index_neraca_saldo(Request $request){

      // return json_encode($request->all());

      $data = DB::table('d_akun')->select('d_akun.nama_akun', 'd_akun.id_akun')->get();

      // return $data;

      return view("laporan_neraca_saldo.pdf")
              ->withRequest($request->all())
              ->withData($data);
    }
}
