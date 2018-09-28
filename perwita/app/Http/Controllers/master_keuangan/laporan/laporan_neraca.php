<?php

namespace App\Http\Controllers\master_keuangan\laporan;

ini_set('max_execution_time', 120);

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\master_akun as akun;

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

      // $cabang = DB::table("cabang")->where("kode", $_GET["cab"])->select("nama")->first();

      // if(Session::get("cabang") == "000")
      //     $cabangs = DB::table("cabang")->select("kode", "nama")->get();
      // else
      //     $cabangs = DB::table("cabang")->where("kode", Session::get("cabang"))->select("kode", "nama")->get();

      $cek = count(DB::table("desain_neraca")->where("is_active", 1)->first());
      $desain = DB::table("desain_neraca")->select("*")->orderBy("id_desain", "desc")->get();
      $date = (substr($request->m, 0, 1) == 0) ? substr($request->m, 1, 1) : $request->m;

      if(count($desain) == 0){
        return view("laporan_neraca.err.empty_desain");
      }elseif($cek == 0){
        return view("laporan_neraca.err.missing_active")->withDesain($desain);
      }

<<<<<<< HEAD
      $data_neraca = []; $no = 0; $data_detail = []; $no_detail = 0;

      $id = DB::table("desain_neraca")->where("is_active", 1)->select("id_desain")->first()->id_desain;

      $dataDetail = DB::table("desain_neraca_dt")
          ->join("desain_neraca", "desain_neraca.id_desain", "=", "desain_neraca_dt.id_desain")
          ->where("desain_neraca.id_desain", $id)
          ->orderBy('nomor_id', 'asc')
          ->get();

      // return json_encode($dataDetail);

      foreach ($dataDetail as $dataDetail) {

          $dataTotal = 0;

          if($dataDetail->jenis == 2){
            $data_detail_dt = DB::table("desain_detail_dt")
                          ->join("d_group_akun", "desain_detail_dt.id_group", "=", "d_group_akun.id")
                          ->where("desain_detail_dt.id_parrent", $dataDetail->nomor_id)
                          ->where('id_desain', $id)
                          ->select("desain_detail_dt.*", "d_group_akun.*")
                          ->get();

            foreach ($data_detail_dt as $detail_dt) {
              if($throttle == "bulan"){

                $data_date = $request->y.'-'.($request->m + 1).'-01';
                $data_saldo = $request->y.'-'.$request->m.'-01';
                $id_group = $detail_dt->id_group;

                if($_GET["cab"] == "all"){
                  // $transaksi = DB::table("d_jurnal_dt")
                  //            ->join("d_akun", "d_jurnal_dt.jrdt_acc", "=", "d_akun.id_akun")
                  //            ->join("d_jurnal", "d_jurnal_dt.jrdt_jurnal", "=", "d_jurnal.jr_id")
                  //            ->where("d_akun.group_neraca", $detail_dt->id_group)
                  //            ->where(DB::raw("date_part('month', jr_date)"), '<=', $date)
                  //            ->where("d_jurnal.jr_year", $request->y)
                  //            ->select(DB::raw("sum(jrdt_value) as total"))->first();

                  $saldo_awal = akun::select(DB::raw('sum(coalesce(opening_balance, 0)) as value'))
                                ->where("d_akun.group_neraca", $id_group)
                                ->where("d_akun.opening_date", '<=', $data_saldo)
                                ->first();

                  $mutasi_debet = DB::table('d_jurnal_dt')
                                  ->join('d_jurnal', 'd_jurnal.jr_id', '=', 'd_jurnal_dt.jrdt_jurnal')
                                  ->join('d_akun', 'd_jurnal_dt.jrdt_acc', '=', 'd_akun.id_akun')
                                  ->where('d_akun.group_neraca', $id_group)
                                  ->where('jr_date', '<', $data_date)
                                  ->where('jr_date', '>=', DB::raw("opening_date"))
                                  ->where("jrdt_statusdk", 'D')
                                  ->select(DB::raw('sum(coalesce(d_jurnal_dt.jrdt_value, 0)) as value'))->first();

                  $mutasi_kredit = DB::table('d_jurnal_dt')
                                  ->join('d_jurnal', 'd_jurnal.jr_id', '=', 'd_jurnal_dt.jrdt_jurnal')
                                  ->join('d_akun', 'd_jurnal_dt.jrdt_acc', '=', 'd_akun.id_akun')
                                  ->where('d_akun.group_neraca', $id_group)
                                  ->where('jr_date', '<', $data_date)
                                  ->where('jr_date', '>=', DB::raw("opening_date"))
                                  ->where("jrdt_statusdk", 'K')
                                  ->select(DB::raw('sum(coalesce(d_jurnal_dt.jrdt_value, 0)) as value'))->first();

                  // return json_encode($detail_dt->id_group);
                  // return json_encode($saldo_awal->value." + ".$mutasi_debet->value." + ".$mutasi_kredit->value);

                  // $saldo_awal = DB::table("d_akun_saldo")
                  //               ->join("d_akun", "d_akun.id_akun", "=", "d_akun_saldo.id_akun")
                  //               ->where("d_akun.group_neraca", $detail_dt->id_group)
                  //               ->where("d_akun_saldo.bulan", $request->m)
                  //               ->where("d_akun_saldo.tahun", $request->y)
                  //               ->select(DB::raw("sum(saldo_akun) as saldo"))->first();
                }else{
                  // $transaksi = DB::table("d_jurnal_dt")
                  //            ->join("d_akun", "d_jurnal_dt.jrdt_acc", "=", "d_akun.id_akun")
                  //            ->join("d_jurnal", "d_jurnal_dt.jrdt_jurnal", "=", "d_jurnal.jr_id")
                  //            ->where("d_akun.group_neraca", $detail_dt->id_group)
                  //            ->where("d_akun.kode_cabang", $_GET["cab"])
                  //            ->where(DB::raw("date_part('month', jr_date)"), '<=', $date)
                  //            ->where("d_jurnal.jr_year", $request->y)
                  //            ->select(DB::raw("sum(jrdt_value) as total"))->first();

                  $saldo_awal = akun::select(DB::raw('sum(coalesce(opening_balance, 0)) as value'))
                                ->where("d_akun.group_neraca", $detail_dt->id_group)
                                ->first();

                  $mutasi_debet = DB::table('d_jurnal_dt')
                                  ->join('d_jurnal', 'd_jurnal.jr_id', '=', 'd_jurnal_dt.jrdt_jurnal')
                                  ->join('d_akun', 'd_jurnal_dt.jrdt_acc', '=', 'd_akun.id_akun')
                                  ->where('d_akun.group_neraca', $id_group)
                                  ->where('jr_date', '<', $data_date)
                                  ->where('jr_date', '>', DB::raw("opening_date"))
                                  ->where("jrdt_statusdk", 'D')
                                  ->select(DB::raw('sum(coalesce(d_jurnal_dt.jrdt_value, 0)) as value'))->first();

                  $mutasi_kredit = DB::table('d_jurnal_dt')
                                  ->join('d_jurnal', 'd_jurnal.jr_id', '=', 'd_jurnal_dt.jrdt_jurnal')
                                  ->join('d_akun', 'd_jurnal_dt.jrdt_acc', '=', 'd_akun.id_akun')
                                  ->where('d_akun.group_neraca', $id_group)
                                  ->where('jr_date', '<', $data_date)
                                  ->where('jr_date', '>', DB::raw("opening_date"))
                                  ->where("jrdt_statusdk", 'K')
                                  ->select(DB::raw('sum(coalesce(d_jurnal_dt.jrdt_value, 0)) as value'))->first();

                  // $saldo_awal = DB::table("d_akun_saldo")
                  //               ->join("d_akun", "d_akun.id_akun", "=", "d_akun_saldo.id_akun")
                  //               ->where("d_akun.group_neraca", $detail_dt->id_group)
                  //               ->where("d_akun.kode_cabang", $_GET["cab"])
                  //               ->where("d_akun_saldo.bulan", $request->m)
                  //               ->where("d_akun_saldo.tahun", $request->y)
                  //               ->select(DB::raw("sum(saldo_akun) as saldo"))->first();
                }

                $saldo = $saldo_awal->value + $mutasi_debet->value + $mutasi_kredit->value;

                // return $saldo;

                $total_akhir = $saldo;

              }

                $data_detail[$no_detail] = [
                    "id_referensi"      => $detail_dt->id_group,
                    "nama_referensi"    => $detail_dt->nama_group,
                    "id_parrent"        => $detail_dt->id_parrent,
                    "nomor_id"          => $detail_dt->nomor_id,
                    "total"             => $total_akhir
                ];

                $no_detail++; $dataTotal += $total_akhir;
            }
          }else if($dataDetail->jenis == 3){
            $data_detail_dt = DB::table("desain_detail_dt")
                          ->where("desain_detail_dt.id_parrent", $dataDetail->nomor_id)
                          ->select("desain_detail_dt.*")
                          ->get();

            foreach ($data_detail_dt as $detail_dt) {
                $dataTotal += $data_neraca[$detail_dt->id_group]["total"];
            }
          }

          $data_neraca[$dataDetail->nomor_id] = [
              "keterangan"        => $dataDetail->keterangan,
              "type"              => $dataDetail->type,
              "jenis"             => $dataDetail->jenis,
              "parrent"           => $dataDetail->id_parrent,
              "level"             => $dataDetail->level,
              "nomor_id"          => $dataDetail->nomor_id,
              "total"             => $dataTotal
          ];

          $no++;
      }

      // return json_encode($data_neraca);

      return view("laporan_neraca.print_pdf.pdf_single")
             ->withThrottle($throttle)
             ->withRequest($request)
             ->withData_neraca($data_neraca)
             ->withData_detail($data_detail)
             ->withCabangs($cabangs)
             ->withCabang($cabang);
=======
      if($throttle == 'bulan'){
        
        $data_date = $request->y.'-'.($request->m + 1).'-01';;
        $data_real = $request->y.'-'.$request->m.'-01';
        $neraca = neraca::where('is_active', 1)->first();
        $id = $neraca->id_desain;

        // return $data_date.' - '.$data_real;

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

      }else{

        $data_date = ($request->y + 1).'-01-01';
        $data_real = $request->y.'-01-01';
        $neraca = neraca::where('is_active', 1)->first();
        $id = $neraca->id_desain;

        // return $data_date.' - '.$data_real;

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

      }

      // return json_encode($detail);

      return view("laporan_neraca.print_pdf.pdf_single", compact('throttle', 'request', 'neraca', 'detail', 'data_date', 'data_real'));
>>>>>>> 727c97c1b3fa6d39fa2e9ab5474fbfcb2c1576fc
  }

  // laporan neraca index end

  public function index_neraca_perbandingan(Request $request, $throttle){

    if($throttle == 'bulan'){

        $data_date_1 = explode('-', $request->d1)[1].'-'.(explode('-', $request->d1)[0] + 1).'-01';
        $data_real_1 = explode('-', $request->d1)[1].'-'.explode('-', $request->d1)[0].'-01';

        $data_date_2 = explode('-', $request->d2)[1].'-'.(explode('-', $request->d2)[0] + 1).'-01';
        $data_real_2 = explode('-', $request->d2)[1].'-'.explode('-', $request->d2)[0].'-01';


        $neraca = neraca::where('is_active', 1)->first();
        $id = $neraca->id_desain;

        // return $data_date.' - '.$data_real;

        // data 1

        $detail_1 = neraca_detail::where('id_desain', $neraca->id_desain)
                    ->with(['detail' => function($query) use ($id, $data_date_1){
                      $query->where('id_desain', $id)->with(['akun' => function($query) use ($data_date_1){
                        $query->select('id_akun', 'nama_akun', 'akun_dka', DB::raw('coalesce(opening_balance, 0)'), 'opening_date', 'group_neraca')
                                  ->with([
                                        'mutasi_bank_debet' => function($query) use ($data_date_1){
                                              $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                                                    ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                                    ->where('jr_date', '>=', DB::raw("opening_date"))
                                                    ->where('jr_date', '<', $data_date_1)
                                                    ->groupBy('jrdt_acc', 'opening_date')
                                                    ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'), 'opening_date');
                                        }
                                  ])
                                  ->orderBy('id_akun', 'asc');
                      }]);
                    }])
                    ->orderBy('nomor_id', 'asc')
                    ->get();

      // data 2

      $detail_2 = neraca_detail::where('id_desain', $neraca->id_desain)
                    ->with(['detail' => function($query) use ($id, $data_date_2){
                      $query->where('id_desain', $id)->with(['akun' => function($query) use ($data_date_2){
                        $query->select('id_akun', 'nama_akun', 'akun_dka', DB::raw('coalesce(opening_balance, 0)'), 'opening_date', 'group_neraca')
                                  ->with([
                                        'mutasi_bank_debet' => function($query) use ($data_date_2){
                                              $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                                                    ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                                    ->where('jr_date', '>=', DB::raw("opening_date"))
                                                    ->where('jr_date', '<', $data_date_2)
                                                    ->groupBy('jrdt_acc', 'opening_date')
                                                    ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'), 'opening_date');
                                        }
                                  ])
                                  ->orderBy('id_akun', 'asc');
                      }]);
                    }])
                    ->orderBy('nomor_id', 'asc')
                    ->get();

      // return $detail_1;
      
      return view("laporan_neraca.print_pdf.pdf_perbandingan", compact('throttle', 'request', 'neraca', 'detail_1', 'detail_2', 'data_date_1', 'data_date_2', 'data_real_1', 'data_real_2'));
    
    }

  }
}
