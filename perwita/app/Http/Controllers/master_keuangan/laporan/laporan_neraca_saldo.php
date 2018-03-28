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
    public function index_neraca_saldo(Request $request, $throttle){

      $data = DB::table("d_akun")
            ->join('d_akun_saldo', 'd_akun_saldo.id_akun', '=', 'd_akun.id_akun')
            ->where('d_akun_saldo.bulan', '01')
      			->whereNotIn('d_akun.id_akun', function($query){
      				$query->select("id_parrent")
      					  ->whereNotNull("id_parrent")
      					  ->from('d_akun')->get();
      			})
            ->select('d_akun.id_akun', 'd_akun.nama_akun', 'd_akun.akun_dka', DB::raw("sum (d_akun_saldo.saldo_akun) as saldo"))
      			->orderBy('d_akun.id_akun', 'asc')->groupBy("d_akun.id_akun")->get();

      // return $data;

      return view("laporan_neraca_saldo.index")
              ->withRequest($request)
              ->withThrottle($throttle)
              ->withData($data);
    }
}
