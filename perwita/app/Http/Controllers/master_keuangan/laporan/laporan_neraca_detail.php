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

class laporan_neraca_detail extends Controller
{
  public function index_neraca(Request $request, $throttle){
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

      $data_neraca = []; $no = 0; $data_detail = []; $no_detail = 0;

      $id = DB::table("desain_neraca")->where("is_active", 1)->select("id_desain")->first()->id_desain;

      $dataDetail = DB::table("desain_neraca_dt")
          ->join("desain_neraca", "desain_neraca.id_desain", "=", "desain_neraca_dt.id_desain")
          ->where("desain_neraca.id_desain", $id)
          ->get();


      foreach ($dataDetail as $dataDetail) {

          $dataTotal = 0;

          if($dataDetail->jenis == 2){
            $data_detail_dt = DB::table("desain_detail_dt")
                          ->join("d_group_akun", "desain_detail_dt.id_group", "=", "d_group_akun.id")
                          ->where("desain_detail_dt.id_parrent", $dataDetail->nomor_id)
                          ->select("desain_detail_dt.*", "d_group_akun.*")
                          ->get();

            foreach ($data_detail_dt as $detail_dt) {
              
                $akun = DB::table('d_akun')->where('group_neraca', $detail_dt->id_group)->orderBy('id_akun', 'asc')->get();

                foreach ($akun as $key => $data_akun) {

                  if($throttle == "bulan"){

                      $data_date = $request->y.'-'.($request->m + 1).'-01';
                      $data_saldo = $request->y.'-'.$request->m.'-01';
                      $id_group = $detail_dt->id_group;

                      if($_GET["cab"] == "all"){
                        // $transaksi = DB::table("d_jurnal_dt")
                        //            ->join("d_akun", "d_jurnal_dt.jrdt_acc", "=", "d_akun.id_akun")
                        //            ->join("d_jurnal", "d_jurnal_dt.jrdt_jurnal", "=", "d_jurnal.jr_id")
                        //            ->where("d_akun.id_akun", $data_akun->id_akun)
                        //            ->where(DB::raw("date_part('month', jr_date)"), '<=', $date)
                        //            ->where("d_jurnal.jr_year", $request->y)
                        //            ->select(DB::raw("sum(jrdt_value) as total"))->first();

                        $saldo_awal = akun::select(DB::raw('sum(coalesce(opening_balance, 0)) as value'))
                                ->where("d_akun.id_akun", $data_akun->id_akun)
                                ->where("d_akun.opening_date", '<=', $data_saldo)
                                ->first();

                        $mutasi_debet = DB::table('d_jurnal_dt')
                                        ->join('d_jurnal', 'd_jurnal.jr_id', '=', 'd_jurnal_dt.jrdt_jurnal')
                                        ->join('d_akun', 'd_jurnal_dt.jrdt_acc', '=', 'd_akun.id_akun')
                                        ->where('d_akun.id_akun', $data_akun->id_akun)
                                        ->where('jr_date', '<', $data_date)
                                        ->where('jr_date', '>=', DB::raw("opening_date"))
                                        ->where("jrdt_statusdk", 'D')
                                        ->select(DB::raw('sum(coalesce(d_jurnal_dt.jrdt_value, 0)) as value'))->first();

                        $mutasi_kredit = DB::table('d_jurnal_dt')
                                        ->join('d_jurnal', 'd_jurnal.jr_id', '=', 'd_jurnal_dt.jrdt_jurnal')
                                        ->join('d_akun', 'd_jurnal_dt.jrdt_acc', '=', 'd_akun.id_akun')
                                        ->where('d_akun.id_akun', $data_akun->id_akun)
                                        ->where('jr_date', '<', $data_date)
                                        ->where('jr_date', '>=', DB::raw("opening_date"))
                                        ->where("jrdt_statusdk", 'K')
                                        ->select(DB::raw('sum(coalesce(d_jurnal_dt.jrdt_value, 0)) as value'))->first();

                        // return json_encode($saldo_awal->value." + ".$mutasi_debet->value." + ".$mutasi_kredit->value);

                      }else{
                        $transaksi = DB::table("d_jurnal_dt")
                                   ->join("d_akun", "d_jurnal_dt.jrdt_acc", "=", "d_akun.id_akun")
                                   ->join("d_jurnal", "d_jurnal_dt.jrdt_jurnal", "=", "d_jurnal.jr_id")
                                   ->where("d_akun.id_akun", $data_akun->id_akun)
                                   ->where(DB::raw("date_part('month', jr_date)"), '<=', $date)
                                   ->where("d_jurnal.jr_year", $request->y)
                                   ->select(DB::raw("sum(jrdt_value) as total"))->first();

                        $saldo_awal = DB::table("d_akun")
                                ->where("d_akun.group_neraca", $detail_dt->id_group)
                                ->select(DB::raw("sum(opening_balance) as saldo"))->first();

                        // $saldo_awal = DB::table("d_akun_saldo")
                        //               ->join("d_akun", "d_akun.id_akun", "=", "d_akun_saldo.id_akun")
                        //               ->where("d_akun.id_akun", $data_akun->id_akun)
                        //               ->where("d_akun_saldo.bulan", $request->m)
                        //               ->where("d_akun_saldo.tahun", $request->y)
                        //               ->select(DB::raw("sum(saldo_akun) as saldo"))->first();
                      }

                      $saldo = $saldo_awal->value + $mutasi_debet->value + $mutasi_kredit->value;

                      // return $saldo;

                      $total_akhir = $saldo;

                    }

                    $data_detail[count($data_detail)] = [
                      'id_group'    => $detail_dt->id_group,
                      'id_akun'     => $data_akun->id_akun,
                      'nama_akun'   => $data_akun->nama_akun,
                      'total_akhir' => $total_akhir,
                    ];

                }

                $data_neraca[count($data_neraca)] = [
                  'id_group'    => $detail_dt->id_group,
                  'nama_group'  => $detail_dt->nama_group
                ];

            }
          }
      }

      // return json_encode($data_detail);

      return view("laporan_neraca_detail.pdf")
             ->withThrottle($throttle)
             ->withRequest($request)
             ->withData_neraca($data_neraca)
             ->withData_detail($data_detail)
             ->withCabangs($cabangs)
             ->withCabang($cabang);
  }


  public function get_detail($data_akun, $key, $request, $dateToSearch, $throttle, $throttle_num = null){
      
  }


   public function getTotalFromTotal($idTotal, $id_desain, $data, $table){
      
  }


  public function get_total($data, $table){

  }
}
