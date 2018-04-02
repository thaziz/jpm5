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
  // laporan neraca start

  public function index_neraca(Request $request, $throttle){
      if($throttle == "perbandingan_bulan"){
          $m1 = explode('/', $request["m"]); $m2 = explode('/', $request["y"]);

          // return json_encode($m1);

          $datat1 = []; $datat2 = []; $no = 0; $request = $request->all(); $data_akun1 = []; $data_akun2 = []; $total_in_header1 = []; $total_in_header2 = [];

          $dateToSearch = ($request["m"] < 10) ? str_replace("0", "", $request["m"]) : $request["m"];
          // return $dateToSearch;

          $dataDetail = DB::table("desain_neraca_dt")
              ->join("desain_neraca", "desain_neraca.id_desain", "=", "desain_neraca_dt.id_desain")
              ->where("desain_neraca.is_active", 1)
              ->get();

          foreach ($dataDetail as $dataDetail) {

              $dataTotal1 = 0; $dataTotal2 = 0;

              if($dataDetail->jenis == 2){
                  $dataAkun = DB::table("desain_detail_dt")->where("id_desain", $dataDetail->id_desain)->where("nomor_id", $dataDetail->nomor_id)->select("id_akun")->get();

                  foreach ($dataAkun as $akun) {
                      $sub = strlen($akun->id_akun);

                      $total = DB::table("d_akun_saldo")
                                  ->where(DB::raw("substring(id_akun, 1, ".$sub.")"), $akun->id_akun)
                                  ->where("d_akun_saldo.bulan", $m1[0])
                                  ->where("d_akun_saldo.tahun", $m1[1])
                                  ->select(DB::raw("sum(saldo_akun) as total"))->first();

                      $transaksi = DB::table("d_jurnal_dt")
                                  ->where(DB::raw("substring(jrdt_acc, 1, ".$sub.")"), $akun->id_akun)
                                  ->whereIn("d_jurnal_dt.jrdt_jurnal", function($query) use ($m1, $request){
                                      $query->select("jr_id")
                                            ->from("d_jurnal")
                                            ->where(DB::raw("date_part('month', jr_date)"), $m1[0])
                                            ->where(DB::raw("date_part('year', jr_date)"), $m1[1])->get();
                                  })->select(DB::raw("sum(jrdt_value) as total"))->first();

                      $dataTotal1 += ($total->total + $transaksi->total);

                      $data_akun1[count($data_akun1)] = [
                          "nomor_id"   => $dataDetail->nomor_id,
                          "nama_akun"  => DB::table("d_akun")->where("id_akun", $akun->id_akun)->select("nama_akun")->first()->nama_akun,
                          "id_akun"    => $akun->id_akun,
                          "class"      => $dataDetail->nomor_id." ".$dataDetail->id_parrent,
                          "total"      => $total->total + $transaksi->total,
                          'is_parrent' => false
                      ];

                      if(array_key_exists($dataDetail->id_parrent, $total_in_header1))
                          $total_in_header1[$dataDetail->id_parrent] += ($total->total + $transaksi->total);
                          // $total_in_header[$dataDetail->id_parrent] = $total_in_header[$dataDetail->id_parrent]." + ".($total->total + $transaksi->total);
                          //return $dataTotal;

                      $total = DB::table("d_akun_saldo")
                                  ->where(DB::raw("substring(id_akun, 1, ".$sub.")"), $akun->id_akun)
                                  ->where("d_akun_saldo.bulan", $m2[0])
                                  ->where("d_akun_saldo.tahun", $m2[1])
                                  ->select(DB::raw("sum(saldo_akun) as total"))->first();

                      $transaksi = DB::table("d_jurnal_dt")
                                  ->where(DB::raw("substring(jrdt_acc, 1, ".$sub.")"), $akun->id_akun)
                                  ->whereIn("d_jurnal_dt.jrdt_jurnal", function($query) use ($m2, $request){
                                      $query->select("jr_id")
                                            ->from("d_jurnal")
                                            ->where(DB::raw("date_part('month', jr_date)"), $m2[0])
                                            ->where(DB::raw("date_part('year', jr_date)"), $m2[1])->get();
                                  })->select(DB::raw("sum(jrdt_value) as total"))->first();

                      $dataTotal2 += ($total->total + $transaksi->total);

                      if(array_key_exists($dataDetail->id_parrent, $total_in_header2))
                          $total_in_header2[$dataDetail->id_parrent] += ($total->total + $transaksi->total);
                          // $total_in_header[$dataDetail->id_parrent] = $total_in_header[$dataDetail->id_parrent]." + ".($total->total + $transaksi->total);
                          //return $dataTotal;

                      $data_akun2[count($data_akun2)] = [
                          "nomor_id"   => $dataDetail->nomor_id,
                          "nama_akun"  => DB::table("d_akun")->where("id_akun", $akun->id_akun)->select("nama_akun")->first()->nama_akun,
                          "id_akun"    => $akun->id_akun,
                          "class"      => $dataDetail->nomor_id." ".$dataDetail->id_parrent,
                          "total"      => $total->total + $transaksi->total,
                          'is_parrent' => false
                      ];

                  }

                  // return $dataTotal;

              }else if($dataDetail->jenis == "1"){
                  $total_in_header1[$dataDetail->nomor_id] = 0;
                  $total_in_header2[$dataDetail->nomor_id] = 0;
              }

              $datat1[$no] = [
                  "nomor_id"          => $dataDetail->nomor_id,
                  "nama_perkiraan"    => $dataDetail->keterangan,
                  "type"              => $dataDetail->type,
                  "jenis"             => $dataDetail->jenis,
                  "parrent"           => $dataDetail->id_parrent,
                  "total"             => $dataTotal1
              ];

              $datat2[$no] = [
                  "nomor_id"          => $dataDetail->nomor_id,
                  "nama_perkiraan"    => $dataDetail->keterangan,
                  "type"              => $dataDetail->type,
                  "jenis"             => $dataDetail->jenis,
                  "parrent"           => $dataDetail->id_parrent,
                  "total"             => $dataTotal2
              ];

              $no++;
          }

          // return json_encode($datat1);

          $mydatatotal1 = $this->get_total($datat1, "neraca");
          $mydatatotal2 = $this->get_total($datat2, "neraca");

          // return json_encode($mydatatotal);

          return view("laporan_neraca.index")->withDatat1($datat1)->withDatat2($datat2)->withRequest($request)->withThrottle($throttle)->withMydatatotal1($mydatatotal1)->withMydatatotal2($mydatatotal2)->withTotal_in_header1($total_in_header1)->withTotal_in_header2($total_in_header2)->withData_akun1($data_akun1)->withData_akun2($data_akun2);

      }else if($throttle == "perbandingan_tahun"){
          // return json_encode($m1);

          $datat1 = []; $datat2 = []; $no = 0; $request = $request->all(); $data_akun1 = []; $data_akun2 = []; $total_in_header1 = []; $total_in_header2 = [];

          $dateToSearch = ($request["m"] < 10) ? str_replace("0", "", $request["m"]) : $request["m"];
          // return $dateToSearch;

          $dataDetail = DB::table("desain_neraca_dt")
              ->join("desain_neraca", "desain_neraca.id_desain", "=", "desain_neraca_dt.id_desain")
              ->where("desain_neraca.is_active", 1)
              ->get();

          foreach ($dataDetail as $dataDetail) {

              $dataTotal1 = 0; $dataTotal2 = 0;

              if($dataDetail->jenis == 2){
                  $dataAkun = DB::table("desain_detail_dt")->where("id_desain", $dataDetail->id_desain)->where("nomor_id", $dataDetail->nomor_id)->select("id_akun")->get();

                  foreach ($dataAkun as $akun) {
                      $sub = strlen($akun->id_akun);

                      $total = DB::table("d_akun_saldo")
                                  ->where(DB::raw("substring(id_akun, 1, ".$sub.")"), $akun->id_akun)
                                  ->where("d_akun_saldo.tahun", $request["m"])
                                  ->select(DB::raw("sum(saldo_akun) as total"))->first();

                      $transaksi = DB::table("d_jurnal_dt")
                                  ->where(DB::raw("substring(jrdt_acc, 1, ".$sub.")"), $akun->id_akun)
                                  ->whereIn("d_jurnal_dt.jrdt_jurnal", function($query) use ($request){
                                      $query->select("jr_id")
                                            ->from("d_jurnal")
                                            ->where(DB::raw("date_part('year', jr_date)"), $request["m"])->get();
                                  })->select(DB::raw("sum(jrdt_value) as total"))->first();

                      $dataTotal1 += ($total->total + $transaksi->total);
                      $data_akun1[count($data_akun1)] = [
                          "nomor_id"   => $dataDetail->nomor_id,
                          "nama_akun"  => DB::table("d_akun")->where("id_akun", $akun->id_akun)->select("nama_akun")->first()->nama_akun,
                          "id_akun"    => $akun->id_akun,
                          "class"      => $dataDetail->nomor_id." ".$dataDetail->id_parrent,
                          "total"      => $total->total + $transaksi->total,
                          'is_parrent' => false
                      ];

                      if(array_key_exists($dataDetail->id_parrent, $total_in_header1))
                          $total_in_header1[$dataDetail->id_parrent] += ($total->total + $transaksi->total);
                          // $total_in_header[$dataDetail->id_parrent] = $total_in_header[$dataDetail->id_parrent]." + ".($total->total + $transaksi->total);
                          //return $dataTotal;

                      $total = DB::table("d_akun_saldo")
                                  ->where(DB::raw("substring(id_akun, 1, ".$sub.")"), $akun->id_akun)
                                  ->where("d_akun_saldo.tahun", $request["y"])
                                  ->select(DB::raw("sum(saldo_akun) as total"))->first();

                      $transaksi = DB::table("d_jurnal_dt")
                                  ->where(DB::raw("substring(jrdt_acc, 1, ".$sub.")"), $akun->id_akun)
                                  ->whereIn("d_jurnal_dt.jrdt_jurnal", function($query) use ($request){
                                      $query->select("jr_id")
                                            ->from("d_jurnal")
                                            ->where(DB::raw("date_part('year', jr_date)"), $request["y"])->get();
                                  })->select(DB::raw("sum(jrdt_value) as total"))->first();

                      $dataTotal2 += ($total->total + $transaksi->total);
                      if(array_key_exists($dataDetail->id_parrent, $total_in_header2))
                          $total_in_header2[$dataDetail->id_parrent] += ($total->total + $transaksi->total);
                          // $total_in_header[$dataDetail->id_parrent] = $total_in_header[$dataDetail->id_parrent]." + ".($total->total + $transaksi->total);
                          //return $dataTotal;

                      $data_akun2[count($data_akun2)] = [
                          "nomor_id"   => $dataDetail->nomor_id,
                          "nama_akun"  => DB::table("d_akun")->where("id_akun", $akun->id_akun)->select("nama_akun")->first()->nama_akun,
                          "id_akun"    => $akun->id_akun,
                          "class"      => $dataDetail->nomor_id." ".$dataDetail->id_parrent,
                          "total"      => $total->total + $transaksi->total,
                          'is_parrent' => false
                      ];

                      //return $dataTotal;
                  }

                  // return $dataTotal;

              }else if($dataDetail->jenis == "1"){
                  $total_in_header1[$dataDetail->nomor_id] = 0;
                  $total_in_header2[$dataDetail->nomor_id] = 0;
              }

              $datat1[$no] = [
                  "nomor_id"          => $dataDetail->nomor_id,
                  "nama_perkiraan"    => $dataDetail->keterangan,
                  "type"              => $dataDetail->type,
                  "jenis"             => $dataDetail->jenis,
                  "parrent"           => $dataDetail->id_parrent,
                  "total"             => $dataTotal1
              ];

              $datat2[$no] = [
                  "nomor_id"          => $dataDetail->nomor_id,
                  "nama_perkiraan"    => $dataDetail->keterangan,
                  "type"              => $dataDetail->type,
                  "jenis"             => $dataDetail->jenis,
                  "parrent"           => $dataDetail->id_parrent,
                  "total"             => $dataTotal2
              ];

              $no++;
          }

          // return json_encode($total_in_header1);

          $mydatatotal1 = $this->get_total($datat1, "neraca");
          $mydatatotal2 = $this->get_total($datat2, "neraca");

          // return json_encode($mydatatotal1);

          return view("laporan_neraca.index")->withDatat1($datat1)->withDatat2($datat2)->withRequest($request)->withThrottle($throttle)->withMydatatotal1($mydatatotal1)->withMydatatotal2($mydatatotal2)->withTotal_in_header1($total_in_header1)->withTotal_in_header2($total_in_header2)->withData_akun1($data_akun1)->withData_akun2($data_akun2);
      }else{
          $data = []; $no = 0; $request = $request->all(); $data_akun = []; $data_akun_no = 0; $total_in_header = [];

          $dateToSearch = ($request["m"] < 10) ? str_replace("0", "", $request["m"]) : $request["m"];
          // return $dateToSearch;

          $dataDetail = DB::table("desain_neraca_dt")
              ->join("desain_neraca", "desain_neraca.id_desain", "=", "desain_neraca_dt.id_desain")
              ->where("desain_neraca.is_active", 1)
              ->get();



          foreach ($dataDetail as $dataDetail) {

              $dataTotal = 0;

              if($dataDetail->jenis == 2){
                  $dataAkun = DB::table("desain_detail_dt")->where("id_desain", $dataDetail->id_desain)->where("nomor_id", $dataDetail->nomor_id)->select("id_akun")->get();

                  foreach ($dataAkun as $akun) {
                      $sub = strlen($akun->id_akun);

                      if($throttle == "bulan"){
                          $total = DB::table("d_akun_saldo")
                                  ->where(DB::raw("substring(id_akun, 1, ".$sub.")"), $akun->id_akun)
                                  ->where("d_akun_saldo.bulan", $request["m"])
                                  ->where("d_akun_saldo.tahun", $request["y"])
                                  ->select(DB::raw("sum(saldo_akun) as total"))->first();

                          $transaksi = DB::table("d_jurnal_dt")
                                  ->where(DB::raw("substring(jrdt_acc, 1, ".$sub.")"), $akun->id_akun)
                                  ->whereIn("d_jurnal_dt.jrdt_jurnal", function($query) use ($dateToSearch, $request){
                                      $query->select("jr_id")
                                            ->from("d_jurnal")
                                            ->where(DB::raw("date_part('month', jr_date)"), $dateToSearch)
                                            ->where(DB::raw("date_part('year', jr_date)"), $request["y"])->get();
                                  })->select(DB::raw("sum(jrdt_value) as total"))->first();
                      }else{
                          $total = DB::table("d_akun_saldo")
                                  ->where(DB::raw("substring(id_akun, 1, ".$sub.")"), $akun->id_akun)
                                  ->where("d_akun_saldo.tahun", $request["y"])
                                  ->select(DB::raw("sum(saldo_akun) as total"))->first();

                          $transaksi = DB::table("d_jurnal_dt")
                                  ->where(DB::raw("substring(jrdt_acc, 1, ".$sub.")"), $akun->id_akun)
                                  ->whereIn("d_jurnal_dt.jrdt_jurnal", function($query) use ($dateToSearch, $request){
                                      $query->select("jr_id")
                                            ->from("d_jurnal")
                                            ->where(DB::raw("date_part('year', jr_date)"), $request["y"])->get();
                                  })->select(DB::raw("sum(jrdt_value) as total"))->first();
                      }

                      $dataTotal += ($total->total + $transaksi->total);

                      $data_akun[count($data_akun)] = [
                          "nomor_id"   => $dataDetail->nomor_id,
                          "nama_akun"  => DB::table("d_akun")->where("id_akun", $akun->id_akun)->select("nama_akun")->first()->nama_akun,
                          "id_akun"    => $akun->id_akun,
                          "class"      => $dataDetail->nomor_id." ".$dataDetail->id_parrent,
                          "total"      => $total->total + $transaksi->total,
                          'is_parrent' => false
                      ];

                      if(array_key_exists($dataDetail->id_parrent, $total_in_header))
                          $total_in_header[$dataDetail->id_parrent] += ($total->total + $transaksi->total);
                          // $total_in_header[$dataDetail->id_parrent] = $total_in_header[$dataDetail->id_parrent]." + ".($total->total + $transaksi->total);
                          //return $dataTotal;
                  }

                  // return $dataTotal;

              }else if($dataDetail->jenis == "1"){
                  $total_in_header[$dataDetail->nomor_id] = 0;
              }

              $data[$no] = [
                  "nomor_id"          => $dataDetail->nomor_id,
                  "nama_perkiraan"    => $dataDetail->keterangan,
                  "type"              => $dataDetail->type,
                  "jenis"             => $dataDetail->jenis,
                  "parrent"           => $dataDetail->id_parrent,
                  "total"             => $dataTotal,
                  "level"             => $dataDetail->level
              ];

              $no++;
          }

          // return json_encode($total_in_header);
          // return json_encode($data_akun);

          $mydatatotal = $this->get_total($data, "neraca");

          // return json_encode($mydatatotal);

          $ses = 0;

          if($throttle == "bulan"){
              $cek = DB::table("d_periode_keuangan")->where("bulan", $request["m"])->where("tahun", $request["y"])->select("*")->get();

              if(count($cek) == 0){
                $ses = [
                    "info" => "Periode Bulan Yang Dipilih Belum Dibuat. Semua Nilai Neraca Akan Menjadi 0..",
                    
                ];
              }
          }else if($throttle == "tahun"){
              $cek = DB::table("d_periode_keuangan")->where("tahun", $request["y"])->select("*")->get();

              if(count($cek) == 0){
                $ses = [
                    "info" => "Periode Tahun Yang Dipilih Belum Dibuat. Semua Nilai Neraca Akan Menjadi 0..",
                    
                ];
              }
          }

          return view("laporan_neraca.index")->withData($data)->withMydatatotal($mydatatotal)->withRequest($request)->withThrottle($throttle)->withData_akun($data_akun)->withTotal_in_header($total_in_header)->withSes($ses);
      }
  }

  public function print_pdf_neraca(Request $request, $throttle){

      // return json_encode($throttle);

      if($throttle == "perbandingan_bulan"){
          $m1 = explode('/', $request["m"]); $m2 = explode('/', $request["y"]);

          // return json_encode($m1);

          $datat1 = []; $datat2 = []; $no = 0; $request = $request->all();

          $dateToSearch = ($request["m"] < 10) ? str_replace("0", "", $request["m"]) : $request["m"];
          // return $dateToSearch;

          $dataDetail = DB::table("desain_neraca_dt")
              ->join("desain_neraca", "desain_neraca.id_desain", "=", "desain_neraca_dt.id_desain")
              ->where("desain_neraca.is_active", 1)
              ->get();

          foreach ($dataDetail as $dataDetail) {

              $dataTotal1 = 0; $dataTotal2 = 0;

              if($dataDetail->jenis == 2){
                  $dataAkun = DB::table("desain_detail_dt")->where("id_desain", $dataDetail->id_desain)->where("nomor_id", $dataDetail->nomor_id)->select("id_akun")->get();

                  foreach ($dataAkun as $akun) {
                      $sub = strlen($akun->id_akun);

                      $total = DB::table("d_akun_saldo")
                                  ->where(DB::raw("substring(id_akun, 1, ".$sub.")"), $akun->id_akun)
                                  ->where("d_akun_saldo.bulan", $m1[0])
                                  ->where("d_akun_saldo.tahun", $m1[1])
                                  ->select(DB::raw("sum(saldo_akun) as total"))->first();

                      $transaksi = DB::table("d_jurnal_dt")
                                  ->where(DB::raw("substring(jrdt_acc, 1, ".$sub.")"), $akun->id_akun)
                                  ->whereIn("d_jurnal_dt.jrdt_jurnal", function($query) use ($m1, $request){
                                      $query->select("jr_id")
                                            ->from("d_jurnal")
                                            ->where(DB::raw("date_part('month', jr_date)"), $m1[0])
                                            ->where(DB::raw("date_part('year', jr_date)"), $m1[1])->get();
                                  })->select(DB::raw("sum(jrdt_value) as total"))->first();

                      $dataTotal1 += ($total->total + $transaksi->total);

                      $total = DB::table("d_akun_saldo")
                                  ->where(DB::raw("substring(id_akun, 1, ".$sub.")"), $akun->id_akun)
                                  ->where("d_akun_saldo.bulan", $m2[0])
                                  ->where("d_akun_saldo.tahun", $m2[1])
                                  ->select(DB::raw("sum(saldo_akun) as total"))->first();

                      $transaksi = DB::table("d_jurnal_dt")
                                  ->where(DB::raw("substring(jrdt_acc, 1, ".$sub.")"), $akun->id_akun)
                                  ->whereIn("d_jurnal_dt.jrdt_jurnal", function($query) use ($m2, $request){
                                      $query->select("jr_id")
                                            ->from("d_jurnal")
                                            ->where(DB::raw("date_part('month', jr_date)"), $m2[0])
                                            ->where(DB::raw("date_part('year', jr_date)"), $m2[1])->get();
                                  })->select(DB::raw("sum(jrdt_value) as total"))->first();

                      $dataTotal2 += ($total->total + $transaksi->total);

                      //return $dataTotal;
                  }

                  // return $dataTotal;

              }

              $datat1[$no] = [
                  "nomor_id"          => $dataDetail->nomor_id,
                  "nama_perkiraan"    => $dataDetail->keterangan,
                  "type"              => $dataDetail->type,
                  "jenis"             => $dataDetail->jenis,
                  "parrent"           => $dataDetail->id_parrent,
                  "total"             => $dataTotal1
              ];

              $datat2[$no] = [
                  "nomor_id"          => $dataDetail->nomor_id,
                  "nama_perkiraan"    => $dataDetail->keterangan,
                  "type"              => $dataDetail->type,
                  "jenis"             => $dataDetail->jenis,
                  "parrent"           => $dataDetail->id_parrent,
                  "total"             => $dataTotal2
              ];

              $no++;
          }

          // return json_encode($datat1);

          $mydatatotal1 = $this->get_total($datat1, "neraca");
          $mydatatotal2 = $this->get_total($datat2, "neraca");

          // return json_encode($mydatatotal);

          $pdf = PDF::loadView('laporan_neraca.pdf', compact('datat1', 'datat2', 'mydatatotal1', 'mydatatotal2', 'request', 'throttle'))
                  ->setPaper('A4','potrait');

          return $pdf->stream('Laporan_Perbandingan_Neraca_Bulan_'.$request["m"].'_Dan_'.$request["y"].'.pdf');

      }else if($throttle == "perbandingan_tahun"){
          // return json_encode($m1);

          $datat1 = []; $datat2 = []; $no = 0; $request = $request->all();

          $dateToSearch = ($request["m"] < 10) ? str_replace("0", "", $request["m"]) : $request["m"];
          // return $dateToSearch;

          $dataDetail = DB::table("desain_neraca_dt")
              ->join("desain_neraca", "desain_neraca.id_desain", "=", "desain_neraca_dt.id_desain")
              ->where("desain_neraca.is_active", 1)
              ->get();

          foreach ($dataDetail as $dataDetail) {

              $dataTotal1 = 0; $dataTotal2 = 0;

              if($dataDetail->jenis == 2){
                  $dataAkun = DB::table("desain_detail_dt")->where("id_desain", $dataDetail->id_desain)->where("nomor_id", $dataDetail->nomor_id)->select("id_akun")->get();

                  foreach ($dataAkun as $akun) {
                      $sub = strlen($akun->id_akun);

                      $total = DB::table("d_akun_saldo")
                                  ->where(DB::raw("substring(id_akun, 1, ".$sub.")"), $akun->id_akun)
                                  ->where("d_akun_saldo.tahun", $request["m"])
                                  ->select(DB::raw("sum(saldo_akun) as total"))->first();

                      $transaksi = DB::table("d_jurnal_dt")
                                  ->where(DB::raw("substring(jrdt_acc, 1, ".$sub.")"), $akun->id_akun)
                                  ->whereIn("d_jurnal_dt.jrdt_jurnal", function($query) use ($request){
                                      $query->select("jr_id")
                                            ->from("d_jurnal")
                                            ->where(DB::raw("date_part('year', jr_date)"), $request["m"])->get();
                                  })->select(DB::raw("sum(jrdt_value) as total"))->first();

                      $dataTotal1 += ($total->total + $transaksi->total);

                      $total = DB::table("d_akun_saldo")
                                  ->where(DB::raw("substring(id_akun, 1, ".$sub.")"), $akun->id_akun)
                                  ->where("d_akun_saldo.tahun", $request["y"])
                                  ->select(DB::raw("sum(saldo_akun) as total"))->first();

                      $transaksi = DB::table("d_jurnal_dt")
                                  ->where(DB::raw("substring(jrdt_acc, 1, ".$sub.")"), $akun->id_akun)
                                  ->whereIn("d_jurnal_dt.jrdt_jurnal", function($query) use ($request){
                                      $query->select("jr_id")
                                            ->from("d_jurnal")
                                            ->where(DB::raw("date_part('year', jr_date)"), $request["y"])->get();
                                  })->select(DB::raw("sum(jrdt_value) as total"))->first();

                      $dataTotal2 += ($total->total + $transaksi->total);

                      //return $dataTotal;
                  }

                  // return $dataTotal;

              }

              $datat1[$no] = [
                  "nomor_id"          => $dataDetail->nomor_id,
                  "nama_perkiraan"    => $dataDetail->keterangan,
                  "type"              => $dataDetail->type,
                  "jenis"             => $dataDetail->jenis,
                  "parrent"           => $dataDetail->id_parrent,
                  "total"             => $dataTotal1
              ];

              $datat2[$no] = [
                  "nomor_id"          => $dataDetail->nomor_id,
                  "nama_perkiraan"    => $dataDetail->keterangan,
                  "type"              => $dataDetail->type,
                  "jenis"             => $dataDetail->jenis,
                  "parrent"           => $dataDetail->id_parrent,
                  "total"             => $dataTotal2
              ];

              $no++;
          }

          // return json_encode($datat1);

          $mydatatotal1 = $this->get_total($datat1, "neraca");
          $mydatatotal2 = $this->get_total($datat2, "neraca");

          // return json_encode($mydatatotal1);

          $pdf = PDF::loadView('laporan_neraca.pdf', compact('datat1', 'datat2', 'mydatatotal1', 'mydatatotal2', 'request', 'throttle'))
                  ->setPaper('A4','potrait');

          return $pdf->stream('Laporan_Perbandingan_Neraca_Tahun_'.$request["m"].'_Dan_'.$request["y"].'.pdf');
      }else{

          $data = []; $no = 0; $request = $request->all();

          $dateToSearch = ($request["m"] < 10) ? str_replace("0", "", $request["m"]) : $request["m"];
          // return $dateToSearch;

          $dataDetail = DB::table("desain_neraca_dt")
              ->join("desain_neraca", "desain_neraca.id_desain", "=", "desain_neraca_dt.id_desain")
              ->where("desain_neraca.is_active", 1)
              ->get();

          foreach ($dataDetail as $dataDetail) {

              $dataTotal = 0;

              if($dataDetail->jenis == 2){
                  $dataAkun = DB::table("desain_detail_dt")->where("id_desain", $dataDetail->id_desain)->where("nomor_id", $dataDetail->nomor_id)->select("id_akun")->get();

                  foreach ($dataAkun as $akun) {
                      $sub = strlen($akun->id_akun);

                      if($throttle == "bulan"){
                          $total = DB::table("d_akun_saldo")
                                  ->where(DB::raw("substring(id_akun, 1, ".$sub.")"), $akun->id_akun)
                                  ->where("d_akun_saldo.bulan", $request["m"])
                                  ->where("d_akun_saldo.tahun", $request["y"])
                                  ->select(DB::raw("sum(saldo_akun) as total"))->first();

                          $transaksi = DB::table("d_jurnal_dt")
                                  ->where(DB::raw("substring(jrdt_acc, 1, ".$sub.")"), $akun->id_akun)
                                  ->whereIn("d_jurnal_dt.jrdt_jurnal", function($query) use ($dateToSearch, $request){
                                      $query->select("jr_id")
                                            ->from("d_jurnal")
                                            ->where(DB::raw("date_part('month', jr_date)"), $dateToSearch)
                                            ->where(DB::raw("date_part('year', jr_date)"), $request["y"])->get();
                                  })->select(DB::raw("sum(jrdt_value) as total"))->first();
                      }else{
                          $total = DB::table("d_akun_saldo")
                                  ->where(DB::raw("substring(id_akun, 1, ".$sub.")"), $akun->id_akun)
                                  ->where("d_akun_saldo.tahun", $request["y"])
                                  ->select(DB::raw("sum(saldo_akun) as total"))->first();

                          $transaksi = DB::table("d_jurnal_dt")
                                  ->where(DB::raw("substring(jrdt_acc, 1, ".$sub.")"), $akun->id_akun)
                                  ->whereIn("d_jurnal_dt.jrdt_jurnal", function($query) use ($dateToSearch, $request){
                                      $query->select("jr_id")
                                            ->from("d_jurnal")
                                            ->where(DB::raw("date_part('year', jr_date)"), $request["y"])->get();
                                  })->select(DB::raw("sum(jrdt_value) as total"))->first();
                      }

                      $dataTotal += ($total->total + $transaksi->total);

                      //return $dataTotal;
                  }

                  // return $dataTotal;

              }

              $data[$no] = [
                  "nomor_id"          => $dataDetail->nomor_id,
                  "nama_perkiraan"    => $dataDetail->keterangan,
                  "type"              => $dataDetail->type,
                  "jenis"             => $dataDetail->jenis,
                  "parrent"           => $dataDetail->id_parrent,
                  "total"             => $dataTotal
              ];

              $no++;
          }

          // return json_encode($data);

          $mydatatotal = $this->get_total($data, "neraca");

          // return json_encode($mydatatotal);

          $pdf = PDF::loadView('laporan_neraca.pdf', compact('data', 'mydatatotal', 'request', 'throttle'))
                  ->setPaper('A4','potrait');

          if($throttle == "bulan")
              return $pdf->stream('Laporan_Neraca_Bulan_'.$request["m"].'_'.$request["y"].'.pdf');
          else
              return $pdf->stream('Laporan_Neraca_Tahun_'.$request["y"].'.pdf');
          }

  }

  public function print_excel_neraca(Request $request, $throttle){

      return json_encode($throttle);

      if($throttle == "perbandingan_bulan"){
          $m1 = explode('/', $request["m"]); $m2 = explode('/', $request["y"]);

          // return json_encode($m1);

          $datat1 = []; $datat2 = []; $no = 0; $request = $request->all();

          $dateToSearch = ($request["m"] < 10) ? str_replace("0", "", $request["m"]) : $request["m"];
          // return $dateToSearch;

          $dataDetail = DB::table("desain_neraca_dt")
              ->join("desain_neraca", "desain_neraca.id_desain", "=", "desain_neraca_dt.id_desain")
              ->where("desain_neraca.is_active", 1)
              ->get();

          foreach ($dataDetail as $dataDetail) {

              $dataTotal1 = 0; $dataTotal2 = 0;

              if($dataDetail->jenis == 2){
                  $dataAkun = DB::table("desain_detail_dt")->where("id_desain", $dataDetail->id_desain)->where("nomor_id", $dataDetail->nomor_id)->select("id_akun")->get();

                  foreach ($dataAkun as $akun) {
                      $sub = strlen($akun->id_akun);

                      $total = DB::table("d_akun_saldo")
                                  ->where(DB::raw("substring(id_akun, 1, ".$sub.")"), $akun->id_akun)
                                  ->where("d_akun_saldo.bulan", $m1[0])
                                  ->where("d_akun_saldo.tahun", $m1[1])
                                  ->select(DB::raw("sum(saldo_akun) as total"))->first();

                      $transaksi = DB::table("d_jurnal_dt")
                                  ->where(DB::raw("substring(jrdt_acc, 1, ".$sub.")"), $akun->id_akun)
                                  ->whereIn("d_jurnal_dt.jrdt_jurnal", function($query) use ($m1, $request){
                                      $query->select("jr_id")
                                            ->from("d_jurnal")
                                            ->where(DB::raw("date_part('month', jr_date)"), $m1[0])
                                            ->where(DB::raw("date_part('year', jr_date)"), $m1[1])->get();
                                  })->select(DB::raw("sum(jrdt_value) as total"))->first();

                      $dataTotal1 += ($total->total + $transaksi->total);

                      $total = DB::table("d_akun_saldo")
                                  ->where(DB::raw("substring(id_akun, 1, ".$sub.")"), $akun->id_akun)
                                  ->where("d_akun_saldo.bulan", $m2[0])
                                  ->where("d_akun_saldo.tahun", $m2[1])
                                  ->select(DB::raw("sum(saldo_akun) as total"))->first();

                      $transaksi = DB::table("d_jurnal_dt")
                                  ->where(DB::raw("substring(jrdt_acc, 1, ".$sub.")"), $akun->id_akun)
                                  ->whereIn("d_jurnal_dt.jrdt_jurnal", function($query) use ($m2, $request){
                                      $query->select("jr_id")
                                            ->from("d_jurnal")
                                            ->where(DB::raw("date_part('month', jr_date)"), $m2[0])
                                            ->where(DB::raw("date_part('year', jr_date)"), $m2[1])->get();
                                  })->select(DB::raw("sum(jrdt_value) as total"))->first();

                      $dataTotal2 += ($total->total + $transaksi->total);

                      //return $dataTotal;
                  }

                  // return $dataTotal;

              }

              $datat1[$no] = [
                  "nomor_id"          => $dataDetail->nomor_id,
                  "nama_perkiraan"    => $dataDetail->keterangan,
                  "type"              => $dataDetail->type,
                  "jenis"             => $dataDetail->jenis,
                  "parrent"           => $dataDetail->id_parrent,
                  "total"             => $dataTotal1
              ];

              $datat2[$no] = [
                  "nomor_id"          => $dataDetail->nomor_id,
                  "nama_perkiraan"    => $dataDetail->keterangan,
                  "type"              => $dataDetail->type,
                  "jenis"             => $dataDetail->jenis,
                  "parrent"           => $dataDetail->id_parrent,
                  "total"             => $dataTotal2
              ];

              $no++;
          }

          // return json_encode($datat1);

          $mydatatotal1 = $this->get_total($datat1, "neraca");
          $mydatatotal2 = $this->get_total($datat2, "neraca");

          // return json_encode($mydatatotal);

          Excel::create('Laporan_Perbandingan_Neraca_Bulan_'.$request["m"].'_Dan_'.$request["y"], function($excel) use ($datat1, $datat2, $mydatatotal1, $mydatatotal2, $request, $throttle) {

              $excel->sheet('laporan Neraca', function($sheet) use ($datat1, $datat2, $mydatatotal1, $mydatatotal2, $request, $throttle) {

                  $sheet->loadView('laporan_neraca.excel')
                        ->with("data1", $datat1)
                        ->with("data2", $datat2)
                        ->with("mydatatotal1", $mydatatotal1)
                        ->with("mydatatotal2", $mydatatotal2)
                        ->with("request", $request)
                        ->with("throttle", $throttle);

              });

          })->export('xls');

      }else if($throttle == "perbandingan_tahun"){
          // return json_encode($m1);

          $datat1 = []; $datat2 = []; $no = 0; $request = $request->all();

          $dateToSearch = ($request["m"] < 10) ? str_replace("0", "", $request["m"]) : $request["m"];
          // return $dateToSearch;

          $dataDetail = DB::table("desain_neraca_dt")
              ->join("desain_neraca", "desain_neraca.id_desain", "=", "desain_neraca_dt.id_desain")
              ->where("desain_neraca.is_active", 1)
              ->get();

          foreach ($dataDetail as $dataDetail) {

              $dataTotal1 = 0; $dataTotal2 = 0;

              if($dataDetail->jenis == 2){
                  $dataAkun = DB::table("desain_detail_dt")->where("id_desain", $dataDetail->id_desain)->where("nomor_id", $dataDetail->nomor_id)->select("id_akun")->get();

                  foreach ($dataAkun as $akun) {
                      $sub = strlen($akun->id_akun);

                      $total = DB::table("d_akun_saldo")
                                  ->where(DB::raw("substring(id_akun, 1, ".$sub.")"), $akun->id_akun)
                                  ->where("d_akun_saldo.tahun", $request["m"])
                                  ->select(DB::raw("sum(saldo_akun) as total"))->first();

                      $transaksi = DB::table("d_jurnal_dt")
                                  ->where(DB::raw("substring(jrdt_acc, 1, ".$sub.")"), $akun->id_akun)
                                  ->whereIn("d_jurnal_dt.jrdt_jurnal", function($query) use ($request){
                                      $query->select("jr_id")
                                            ->from("d_jurnal")
                                            ->where(DB::raw("date_part('year', jr_date)"), $request["m"])->get();
                                  })->select(DB::raw("sum(jrdt_value) as total"))->first();

                      $dataTotal1 += ($total->total + $transaksi->total);

                      $total = DB::table("d_akun_saldo")
                                  ->where(DB::raw("substring(id_akun, 1, ".$sub.")"), $akun->id_akun)
                                  ->where("d_akun_saldo.tahun", $request["y"])
                                  ->select(DB::raw("sum(saldo_akun) as total"))->first();

                      $transaksi = DB::table("d_jurnal_dt")
                                  ->where(DB::raw("substring(jrdt_acc, 1, ".$sub.")"), $akun->id_akun)
                                  ->whereIn("d_jurnal_dt.jrdt_jurnal", function($query) use ($request){
                                      $query->select("jr_id")
                                            ->from("d_jurnal")
                                            ->where(DB::raw("date_part('year', jr_date)"), $request["y"])->get();
                                  })->select(DB::raw("sum(jrdt_value) as total"))->first();

                      $dataTotal2 += ($total->total + $transaksi->total);

                      //return $dataTotal;
                  }

                  // return $dataTotal;

              }

              $datat1[$no] = [
                  "nomor_id"          => $dataDetail->nomor_id,
                  "nama_perkiraan"    => $dataDetail->keterangan,
                  "type"              => $dataDetail->type,
                  "jenis"             => $dataDetail->jenis,
                  "parrent"           => $dataDetail->id_parrent,
                  "total"             => $dataTotal1
              ];

              $datat2[$no] = [
                  "nomor_id"          => $dataDetail->nomor_id,
                  "nama_perkiraan"    => $dataDetail->keterangan,
                  "type"              => $dataDetail->type,
                  "jenis"             => $dataDetail->jenis,
                  "parrent"           => $dataDetail->id_parrent,
                  "total"             => $dataTotal2
              ];

              $no++;
          }

          // return json_encode($datat1);

          $mydatatotal1 = $this->get_total($datat1, "neraca");
          $mydatatotal2 = $this->get_total($datat2, "neraca");

          // return json_encode($mydatatotal1);

          Excel::create('Laporan_Perbandingan_Neraca_Tahun_'.$request["m"].'_Dan_'.$request["y"], function($excel) use ($datat1, $datat2, $mydatatotal1, $mydatatotal2, $request, $throttle) {

              $excel->sheet('laporan Neraca', function($sheet) use ($datat1, $datat2, $mydatatotal1, $mydatatotal2, $request, $throttle) {

                  $sheet->loadView('laporan_neraca.excel')
                        ->with("data1", $datat1)
                        ->with("data2", $datat2)
                        ->with("mydatatotal1", $mydatatotal1)
                        ->with("mydatatotal2", $mydatatotal2)
                        ->with("request", $request)
                        ->with("throttle", $throttle);

              });

          })->export('xls');

      }else{

          $data = []; $no = 0; $request = $request->all();

          $dateToSearch = ($request["m"] < 10) ? str_replace("0", "", $request["m"]) : $request["m"];
          // return $dateToSearch;

          $dataDetail = DB::table("desain_neraca_dt")
              ->join("desain_neraca", "desain_neraca.id_desain", "=", "desain_neraca_dt.id_desain")
              ->where("desain_neraca.is_active", 1)
              ->get();

          foreach ($dataDetail as $dataDetail) {

              $dataTotal = 0;

              if($dataDetail->jenis == 2){
                  $dataAkun = DB::table("desain_detail_dt")->where("id_desain", $dataDetail->id_desain)->where("nomor_id", $dataDetail->nomor_id)->select("id_akun")->get();

                  foreach ($dataAkun as $akun) {
                      $sub = strlen($akun->id_akun);

                      if($throttle == "bulan"){
                          $total = DB::table("d_akun_saldo")
                                  ->where(DB::raw("substring(id_akun, 1, ".$sub.")"), $akun->id_akun)
                                  ->where("d_akun_saldo.bulan", $request["m"])
                                  ->where("d_akun_saldo.tahun", $request["y"])
                                  ->select(DB::raw("sum(saldo_akun) as total"))->first();

                          $transaksi = DB::table("d_jurnal_dt")
                                  ->where(DB::raw("substring(jrdt_acc, 1, ".$sub.")"), $akun->id_akun)
                                  ->whereIn("d_jurnal_dt.jrdt_jurnal", function($query) use ($dateToSearch, $request){
                                      $query->select("jr_id")
                                            ->from("d_jurnal")
                                            ->where(DB::raw("date_part('month', jr_date)"), $dateToSearch)
                                            ->where(DB::raw("date_part('year', jr_date)"), $request["y"])->get();
                                  })->select(DB::raw("sum(jrdt_value) as total"))->first();
                      }else{
                          $total = DB::table("d_akun_saldo")
                                  ->where(DB::raw("substring(id_akun, 1, ".$sub.")"), $akun->id_akun)
                                  ->where("d_akun_saldo.tahun", $request["y"])
                                  ->select(DB::raw("sum(saldo_akun) as total"))->first();

                          $transaksi = DB::table("d_jurnal_dt")
                                  ->where(DB::raw("substring(jrdt_acc, 1, ".$sub.")"), $akun->id_akun)
                                  ->whereIn("d_jurnal_dt.jrdt_jurnal", function($query) use ($dateToSearch, $request){
                                      $query->select("jr_id")
                                            ->from("d_jurnal")
                                            ->where(DB::raw("date_part('year', jr_date)"), $request["y"])->get();
                                  })->select(DB::raw("sum(jrdt_value) as total"))->first();
                      }

                      $dataTotal += ($total->total + $transaksi->total);

                      //return $dataTotal;
                  }

                  // return $dataTotal;

              }

              $data[$no] = [
                  "nomor_id"          => $dataDetail->nomor_id,
                  "nama_perkiraan"    => $dataDetail->keterangan,
                  "type"              => $dataDetail->type,
                  "jenis"             => $dataDetail->jenis,
                  "parrent"           => $dataDetail->id_parrent,
                  "total"             => $dataTotal
              ];

              $no++;
          }

          // return json_encode($data);

          $mydatatotal = $this->get_total($data, "neraca");

          if($throttle == "bulan"){

              Excel::create('Laporan_Neraca_Bulan_'.$request["m"].'_'.$request["y"], function($excel) use ($data, $mydatatotal, $request, $throttle) {

                  $excel->sheet('laporan Neraca', function($sheet) use ($data, $mydatatotal, $request, $throttle) {

                      $sheet->loadView('laporan_neraca.excel')
                            ->with("data", $data)
                            ->with("mydatatotal", $mydatatotal)
                            ->with("request", $request)
                            ->with("throttle", $throttle);

                  });

              })->export('xls');
          }
          else{

              Excel::create('Laporan_Neraca_Tahun_'.$request["y"], function($excel) use ($data, $mydatatotal, $request, $throttle) {

                  $excel->sheet('laporan Neraca', function($sheet) use ($data, $mydatatotal, $request, $throttle) {

                      $sheet->loadView('laporan_neraca.excel')
                            ->with("data", $data)
                            ->with("mydatatotal", $mydatatotal)
                            ->with("request", $request)
                            ->with("throttle", $throttle);

                  });

              })->export('xls');
          }

      }

  }

  // end neraca

  public function getTotalFromTotal($idTotal, $id_desain, $data, $table){
      $mydatatotal = 0; $tots = 0;

      if($table == "neraca")
          $dataAkun = DB::table("desain_detail_dt")->where("id_desain", $id_desain)->where("nomor_id", $idTotal)->select("id_akun")->get();
      elseif($table == "laba_rugi")
          $dataAkun = DB::table("desain_laba_rugi_detail_dt")->where("id_desain", $id_desain)->where("nomor_id", $idTotal)->select("id_akun")->get();


      foreach ($dataAkun as $akun) {
          foreach ($data as $dataku) {
              if ($dataku['nomor_id'] == $akun->id_akun) {
                  if($dataku['jenis'] == "2")
                      $tots += $dataku["total"];
                  else if($dataku['jenis'] == "3")
                      $tots += $this->getTotalFromTotal($dataku['nomor_id'], $id_desain, $data, $table);
              }
          }
      }

      $mydatatotal = $tots;

      return $mydatatotal;
  }


  public function get_total($data, $table){

      $mydatatotal = []; $idx = 0;

      if($table == "neraca"){
          $loopTotal = DB::table("desain_neraca_dt")
              ->join("desain_neraca", "desain_neraca.id_desain", "=", "desain_neraca_dt.id_desain")
              ->where("desain_neraca.is_active", 1)
              ->where("desain_neraca_dt.jenis", 3)
              ->get();

          foreach($loopTotal as $tot){
              $dataAkun = DB::table("desain_detail_dt")->where("id_desain", $tot->id_desain)->where("nomor_id", $tot->nomor_id)->select("id_akun")->get();
              $tots = 0;

              // return json_encode($data);

              foreach ($dataAkun as $akun) {
                  foreach ($data as $dataku) {
                      if ($dataku['nomor_id'] == $akun->id_akun) {
                          if($dataku['jenis'] == "2")
                              $tots += $dataku["total"];
                          else if($dataku['jenis'] == "3")
                              $tots += $this->getTotalFromTotal($dataku['nomor_id'], $tot->id_desain, $data, $table);
                      }
                  }
              }

              $mydatatotal[$tot->nomor_id] = $tots;

              $idx++;
          }
      }elseif($table == "laba_rugi"){
          $loopTotal = DB::table("desain_laba_rugi_dt")
              ->join("desain_laba_rugi", "desain_laba_rugi.id_desain", "=", "desain_laba_rugi_dt.id_desain")
              ->where("desain_laba_rugi.is_active", 1)
              ->where("desain_laba_rugi_dt.jenis", 3)
              ->get();

          foreach($loopTotal as $tot){
              $dataAkun = DB::table("desain_laba_rugi_detail_dt")->where("id_desain", $tot->id_desain)->where("nomor_id", $tot->nomor_id)->select("id_akun")->get();
              $tots = 0;

              // return json_encode($data);

              foreach ($dataAkun as $akun) {
                  foreach ($data as $dataku) {
                      if ($dataku['nomor_id'] == $akun->id_akun) {
                          if($dataku['jenis'] == "2")
                              $tots += $dataku["total"];
                          else if($dataku['jenis'] == "3")
                              $tots += $this->getTotalFromTotal($dataku['nomor_id'], $tot->id_desain, $data, $table);
                      }
                  }
              }

              $mydatatotal[$tot->nomor_id] = $tots;

              $idx++;
          }
      }
      return $mydatatotal;
  }
}
