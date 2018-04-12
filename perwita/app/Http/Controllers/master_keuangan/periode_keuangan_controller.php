<?php

namespace App\Http\Controllers\master_keuangan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\master_akun_saldo;

use App\d_periode_keuangan;
use DB;

class periode_keuangan_controller extends Controller
{
    public function make(Request $request){

        // return json_encode($request->all());

        $this->generate_saldo_piutang($request["bulan"]."/".$request["tahun"]);

        return "aa";

        $response = [
            'status' => 'sukses',
        ];

        $cek = DB::table('d_periode_keuangan')->where('bulan', $request->bulan)->where("tahun", $request->tahun)->first();

        if(count($cek) > 0){
            $response = [
                'status' => 'exist',
            ];

            return json_encode($response);
        }

        $cek2 = DB::table('d_periode_keuangan')->select("*")->limit(1)->first();

        if($request->bulan < date("m") || $request->tahun < date("Y")){
            $response = [
                'status' => 'past_insert',
            ];

            return json_encode($response);
        }

        $id = (DB::table("d_periode_keuangan")->max("id") == null) ? 1 : (DB::table("d_periode_keuangan")->max("id")+1);
        $periode = new d_periode_keuangan;

        $periode->id = $id;
        $periode->bulan = $request->bulan;
        $periode->tahun = $request->tahun;
        $periode->status = "accessable";

        // return json_encode($ret);

        if($periode->save()){
            
            $this->generate_akun($request);

            return json_encode($response);
        }

        $response = [
            'status' => 'gagal',
        ];

        return json_encode($response);

    }

    public function setting(Request $request){
        // return json_encode($request->all());
        $response = [
            'status' => 'sukses',
        ];

        $periode = d_periode_keuangan::find($request->id);
        $periode->status = $request->val;

        if($periode->save())
            return json_encode($response);
    }


    public function generate_akun($request){
        $data = DB::table("d_akun_saldo")
                    ->where("bulan", "<", $request->bulan)
                    ->where("tahun", "<=", $request->tahun)
                    ->select(DB::raw("distinct(tahun)"), "bulan")->limit(1)->first();

            $d = 0; $t = 0;

            if(count($data) > 0){
                $d = $data->bulan; $t = $data->tahun;
            }

            $akun = DB::table("d_akun")->select("id_akun")->get();

            $ret = [];

            foreach ($akun as $key => $value) {

                $saldo = null; $transaksi = null;

                if($d != 0 && $t != 0){
                    $saldo = DB::table("d_akun_saldo")
                             ->where("id_akun", $value->id_akun)
                             ->where("bulan", $d)
                             ->where("tahun", "$t")
                             ->select('saldo_akun')->first()->saldo_akun;

                    $transaksi = DB::table("d_jurnal_dt")
                                 ->where("jrdt_acc", $value->id_akun)
                                 ->whereIn("d_jurnal_dt.jrdt_jurnal", function($query) use ($d, $t){
                                    $query->select("jr_id")
                                          ->from("d_jurnal")
                                          ->where(DB::raw("date_part('month', jr_date)"), $d)
                                          ->where(DB::raw("date_part('year', jr_date)"), $t)->get();
                                 })->select(DB::raw("sum(jrdt_value) as total"))->first()->total;
                }




                $saldo_baru = new master_akun_saldo;
                $saldo_baru->id_akun = $value->id_akun;
                $saldo_baru->tahun = $request->tahun;

                if($saldo == null && $transaksi == null)
                    $saldo_baru->saldo_akun = null ;
                else
                    $saldo_baru->saldo_akun = $saldo + $transaksi ;

                $saldo_baru->is_active = "1";
                $saldo_baru->bulan = $request->bulan;

                $saldo_baru->save();
                
            }

            return true;
    }

    public function generate_saldo_piutang($m){
        $date_init = explode("/", $m)[0]."/01/".explode("/", $m)[1];

        $date = date("m/Y", strtotime("-1 months", strtotime($date_init)));

        $loop = DB::table("d_saldo_piutang")->where("periode", $date)->get();

        foreach($loop as $piutang){
            $saldo = 0;

            $id = (DB::table("d_saldo_piutang")->max("id") == null) ? 1 : (DB::table("d_saldo_piutang")->max("id")+1);

            $data = DB::table("d_saldo_piutang")
                ->where("kode_cabang", $piutang->kode_cabang)
                ->where("kode_customer", $piutang->kode_customer)
                ->where("periode", $date)
                ->select("jumlah")->first();

            $ids = (DB::table("d_saldo_piutang_detail")->where("id_saldo_piutang", $id)->max("id_detail") == null) ? 1 : (DB::table("d_saldo_piutang_detail")->where("id_saldo_piutang", $id)->max("id_detail")+1);

            DB::table("d_saldo_piutang_detail")->insert([
                "id_saldo_piutang"  => $id,
                "id_detail"         => $ids,
                "id_referensi"      => "null",
                "jumlah"            => $data->jumlah,
                "tanggal"           => null,
                "jatuh_tempo"       => null,
                "keterangan"        => "Saldo Awal Periode ".$date,
            ]);

            $saldo += $data->jumlah;

            $inv = DB::table("invoice")
                   ->where("i_kode_cabang", $piutang->kode_cabang)
                   ->where("i_kode_customer", $piutang->kode_customer)
                   ->where(DB::raw("date_part('month', i_tanggal)"), date('m', strtotime("-1 months", strtotime($date_init))))
                   ->where(DB::raw("date_part('year', i_tanggal)"), date('Y', strtotime("-1 months", strtotime($date_init))))
                   ->select(DB::raw('coalesce(invoice.i_total, 0) as total'), 'invoice.i_nomor', 'invoice.i_tanggal', 'invoice.i_jatuh_tempo', 'invoice.i_keterangan')
                   ->groupBy('invoice.i_nomor', 'invoice.i_tanggal', 'invoice.i_jatuh_tempo', 'invoice.i_keterangan')->get();


            foreach ($inv as $invoice) {
                $ids = (DB::table("d_saldo_piutang_detail")->where("id_saldo_piutang", $id)->max("id_detail") == null) ? 1 : (DB::table("d_saldo_piutang_detail")->where("id_saldo_piutang", $id)->max("id_detail")+1);

                DB::table("d_saldo_piutang_detail")->insert([
                    "id_saldo_piutang"  => $id,
                    "id_detail"         => $ids,
                    "id_referensi"      => $invoice->i_nomor,
                    "jumlah"            => $invoice->total,
                    "tanggal"           => $invoice->i_tanggal,
                    "jatuh_tempo"       => $invoice->i_jatuh_tempo,
                    "keterangan"        => $invoice->i_keterangan,
                ]);

                $saldo += $invoice->total;
            }

            $kwt = DB::table("kwitansi_d")
               ->join("kwitansi", "kwitansi.k_nomor", "=", "kwitansi_d.kd_k_nomor")
               ->where("kwitansi.k_kode_customer", $piutang->kode_customer)
               ->where("kwitansi.k_kode_cabang", $piutang->kode_cabang)
               ->where(DB::raw("date_part('month', k_tanggal)"), date('m', strtotime("-1 months", strtotime($date_init))))
               ->where(DB::raw("date_part('year', k_tanggal)"), date('Y', strtotime("-1 months", strtotime($date_init))))
               ->select("kwitansi_d.kd_k_nomor", DB::raw("(kwitansi_d.kd_total_bayar - kwitansi_d.kd_memorial) as kd_total_bayar"), "kwitansi_d.kd_keterangan", 'kwitansi.k_tanggal')->get();

            foreach ($kwt as $kwitansi) {
                $ids = (DB::table("d_saldo_piutang_detail")->where("id_saldo_piutang", $id)->max("id_detail") == null) ? 1 : (DB::table("d_saldo_piutang_detail")->where("id_saldo_piutang", $id)->max("id_detail")+1);

                DB::table("d_saldo_piutang_detail")->insert([
                    "id_saldo_piutang"  => $id,
                    "id_detail"         => $ids,
                    "id_referensi"      => $kwitansi->kd_k_nomor,
                    "jumlah"            => $kwitansi->kd_total_bayar,
                    "tanggal"           => $kwitansi->k_tanggal,
                    "jatuh_tempo"       => null,
                    "keterangan"        => $kwitansi->kd_keterangan,
                ]);

                $saldo -= $kwitansi->kd_total_bayar;
            }


            DB::table("d_saldo_piutang")->insert([
                "id"                => $id,
                "kode_cabang"       => $piutang->kode_cabang,
                "kode_customer"     => $piutang->kode_customer,
                "jumlah"            => $saldo,
                "periode"           => $m,
                "tanggal_buat"      => date("Y-m-d H:i:s"),
                "terakhir_diupdate" => date("Y-m-d H:i:s"),
            ]);
        }
    }

}
