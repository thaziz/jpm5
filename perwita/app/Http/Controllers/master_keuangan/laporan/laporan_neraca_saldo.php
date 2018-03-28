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
      			->whereNotIn('id_akun', function($query){
      				$query->select("id_parrent")
      					  ->whereNotNull("id_parrent")
      					  ->from('d_akun')->get();
      			})
      			->orderBy('d_akun', 'asc')->get();

      return view("laporan_neraca_saldo.index")
              ->withRequest($request)
              ->withThrottle($throttle)
              ->withData($data);
    }
}
