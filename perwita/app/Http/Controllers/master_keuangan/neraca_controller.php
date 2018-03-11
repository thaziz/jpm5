<?php

namespace App\Http\Controllers\master_keuangan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

class neraca_controller extends Controller
{
    public function index(){
      $data = []; $no = 0;
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
            $total = DB::table("d_akun_saldo")
                  ->where(DB::raw("substring(id_akun, 1, ".$sub.")"), $akun->id_akun)
                  ->select(DB::raw("sum(saldo_akun) as total"))->first();

            $transaksi = DB::table("d_jurnal_dt")
                  ->where(DB::raw("substring(jrdt_acc, 1, ".$sub.")"), $akun->id_akun)
                  ->select(DB::raw("sum(jrdt_value) as total"))->first();

            $dataTotal += ($total->total + $transaksi->total);

            //return $dataTotal;
          }

          // return $dataTotal;

        }

        $data[$no] = [
          "nama_perkiraan"  => $dataDetail->keterangan,
          "type"        => $dataDetail->type,
          "jenis"       => $dataDetail->jenis,
          "parrent"     => $dataDetail->id_parrent,
          "total"       => $dataTotal
        ];

        $no++;
      }

      //return json_encode($data);

      return view("keuangan.neraca.index")->withData($data);
    }
}
