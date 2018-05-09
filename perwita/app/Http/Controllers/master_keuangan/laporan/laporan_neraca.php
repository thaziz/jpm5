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
use Session;

class laporan_neraca extends Controller
{
  // laporan neraca Index Start

  public function index_neraca_single(Request $request, $throttle){

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
                          ->join("d_group_akun", "desain_detail_dt.id_referensi", "=", "d_group_akun.id")
                          ->where("desain_detail_dt.id_parrent", $dataDetail->nomor_id)
                          ->select("desain_detail_dt.*", "d_group_akun.*")
                          ->get();

            foreach ($data_detail_dt as $detail_dt) {
              if($throttle == "bulan"){
                $transaksi = DB::table("d_jurnal_dt")
                             ->join("d_akun", "d_jurnal_dt.jrdt_acc", "=", "d_akun.id_akun")
                             ->join("d_jurnal", "d_jurnal_dt.jrdt_jurnal", "=", "d_jurnal.jr_id")
                             ->where("d_akun.group_neraca", $detail_dt->id_referensi)
                             ->where(DB::raw("date_part('month', jr_date)"), $request->m)
                             ->where("d_jurnal.jr_year", $request->y)
                             ->select(DB::raw("sum(jrdt_value) as total"))->first();
              }else if($throttle == "tahun"){
                $transaksi = DB::table("d_jurnal_dt")
                             ->join("d_akun", "d_jurnal_dt.jrdt_acc", "=", "d_akun.id_akun")
                             ->join("d_jurnal", "d_jurnal_dt.jrdt_jurnal", "=", "d_jurnal.jr_id")
                             ->where("d_akun.group_neraca", $detail_dt->id_referensi)
                             ->where("d_jurnal.jr_year", $request->y)
                             ->select(DB::raw("sum(jrdt_value) as total"))->first();
              }

                $data_detail[$no_detail] = [
                    "id_referensi"      => $detail_dt->id_referensi,
                    "nama_referensi"    => $detail_dt->nama_group,
                    "id_parrent"        => $detail_dt->id_parrent,
                    "nomor_id"          => $detail_dt->nomor_id,
                    "total"             => (is_null($transaksi->total)) ? 0 : $transaksi->total
                ];

                $no_detail++; $dataTotal += $transaksi->total;
            }
          }else if($dataDetail->jenis == 3){
            $data_detail_dt = DB::table("desain_detail_dt")
                          ->where("desain_detail_dt.id_parrent", $dataDetail->nomor_id)
                          ->select("desain_detail_dt.*")
                          ->get();

            foreach ($data_detail_dt as $detail_dt) {

                $dataTotal += $data_neraca[$detail_dt->id_referensi]["total"];
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

      return view("laporan_neraca.index.index_single")
             ->withThrottle($throttle)
             ->withRequest($request)
             ->withData_neraca($data_neraca)
             ->withData_detail($data_detail);
  }

  // laporan neraca index end
}
