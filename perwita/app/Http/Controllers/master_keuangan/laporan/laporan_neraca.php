<?php

namespace App\Http\Controllers\master_keuangan\laporan;

ini_set('max_execution_time', 120);

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\master_akun as akun;
use App\desain_neraca as neraca;
use App\desain_neraca_detail as neraca_detail;

use DB;
use Dompdf\Dompdf;
use PDF;
use Excel;
use Session;

class laporan_neraca extends Controller
{
  // laporan neraca Index Start

  public function index_neraca_single(Request $request, $throttle){

    // return $request->all();

      $cabang = DB::table("cabang")->where("kode", $_GET["cab"])->select("nama")->first();

      if(Session::get("cabang") == "000")
          $cabangs = DB::table("cabang")->select("kode", "nama")->get();
      else
          $cabangs = DB::table("cabang")->where("kode", Session::get("cabang"))->select("kode", "nama")->get();

      $cek = count(DB::table("desain_neraca")->where("is_active", 1)->first());
      $desain = DB::table("desain_neraca")->select("*")->orderBy("id_desain", "desc")->get();
      $date = (substr($request->m, 0, 1) == 0) ? substr($request->m, 1, 1) : $request->m;

      if(count($desain) == 0){
        return view("laporan_neraca.err.empty_desain");
      }elseif($cek == 0){
        return view("laporan_neraca.err.missing_active")->withDesain($desain);
      }


      $data_date = $request->y.'-'.($request->m+1).'-01';
      $data_real = $request->y.'-'.$request->m.'-01';
      $neraca = neraca::where('is_active', 1)->first();
      $id = $neraca->id_desain;

      $detail = neraca_detail::where('id_desain', $neraca->id_desain)
                  ->with(['detail' => function($query) use ($id, $data_date){
                    $query->where('id_desain', $id)->with(['akun' => function($query) use ($data_date){
                      $query->select('id_akun', 'nama_akun', 'akun_dka', DB::raw('coalesce(opening_balance, 0)'), 'opening_date', 'group_neraca')
                                ->with([
                                      'mutasi_bank_debet' => function($query) use ($data_date){
                                            $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                                                  ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                                  ->where('jr_date', '>=', DB::raw("opening_date"))
                                                  ->where('jr_date', '<', $data_date)
                                                  ->groupBy('jrdt_acc', 'opening_date')
                                                  ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'), 'opening_date');
                                      }
                                ])
                                ->orderBy('id_akun', 'asc');
                    }]);
                  }])
                  ->orderBy('nomor_id', 'asc')
                  ->get();

      // return json_encode($detail);

      return view("laporan_neraca.print_pdf.pdf_single", compact('throttle', 'request', 'neraca', 'detail', 'data_date', 'data_real'));
  }

  // laporan neraca index end
}
