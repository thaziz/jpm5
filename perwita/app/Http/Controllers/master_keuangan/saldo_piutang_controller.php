<?php

namespace App\Http\Controllers\master_keuangan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use DB;

class saldo_piutang_controller extends Controller
{
    public function index($cabang){

        if(cek_periode() == 0)
            return view("keuangan.err.err_periode");

        if(Session::get('cabang') != '000'){
            $cek_exist = DB::table('d_saldo_piutang')->where('kode_cabang', Session::get('cabang'))->get();

            if(count($cek_exist) > 0){
                $this->generate_saldo_piutang(date('m/Y'));
            }
        }

        $cab  = DB::table('cabang')
                ->select("kode", "nama")->get();

        // return $cabang;

        if($cabang != "null"){
            $data = DB::table('d_saldo_piutang')
                ->join('customer', 'customer.kode', '=', 'd_saldo_piutang.kode_customer')
                ->join('cabang', 'cabang.kode', '=', 'd_saldo_piutang.kode_cabang')
                ->where("d_saldo_piutang.periode", date("m/Y"))
                ->where('kode_cabang', $cabang)
                ->select("d_saldo_piutang.*", "customer.alamat as alamat_customer", "customer.nama as nama_customer", "cabang.nama as nama_cabang")->get();
        }elseif($cabang == "null"){
            $data = DB::table('d_saldo_piutang')
                ->join('customer', 'customer.kode', '=', 'd_saldo_piutang.kode_customer')
                ->join('cabang', 'cabang.kode', '=', 'd_saldo_piutang.kode_cabang')
                ->where("d_saldo_piutang.periode", date("m/Y"))
                ->where('kode_cabang', "=", $cab[0]->kode)
                ->select("d_saldo_piutang.*", "customer.alamat as alamat_customer", "customer.nama as nama_customer", "cabang.nama as nama_cabang")->get();
        }

        $detail = DB::table('d_saldo_piutang_detail')
                  ->whereIn('id_saldo_piutang', function($query){
                     $query->select('id')
                           ->where("periode", date("m/Y"))
                           ->from('d_saldo_piutang')->get();
                  })->select("*")->get();

        $datajson = json_encode($data);
        $detailjson = json_encode($detail);

        // return $data;

    	return view("keuangan.saldo_piutang.index")->withData($data)->withCab($cab)->withCabang($cabang)->withDatajson($datajson)->withDetailjson($detailjson);
    }

    public function add(){
    	// $cab  = DB::table('cabang')
     //            ->whereNotIn('kode', function($query){
     //                $query->select('kode_cabang')
     //                      ->where('periode', date('m/Y'))
     //                      ->whereNotNull('kode_cabang')
     //                      ->from('d_saldo_piutang')->get();
     //            })
     //            ->select("kode", "nama")->get();

        $cek_exist = DB::table('d_saldo_piutang')->where('kode_cabang', Session::get('cabang'))->where("periode", date('m/Y'))->get();

        if(count($cek_exist) > 0){
            return "<center>Penambahan Saldo Piutang Hanya Dilakukan Di Awal Musim...</center>";
        }

        $cab  = DB::table('cabang')
                ->whereNotIn('kode', function($query){
                     $query->select('kode_cabang')
                           ->from('d_saldo_piutang')->get();
                })->select("kode", "nama")->get();

    	$cust = DB::table('customer')->select("kode", "nama", "alamat")->get();

        // return $cab;
    	return view("keuangan.saldo_piutang.insert")
    		   ->withCust($cust)
    		   ->withCab($cab);
    }

    public function save(Request $request){
        // return $request->all();
        
        $m1 = explode('/', $request["cust"]["periode"]);
        $response = [
            "status"    => "sukses"
        ];

        for ($i=0; $i < count($request["customer"]); $i++) {
            $jml = str_replace(".", "", explode(",", $request["jumlah"][$i])[0]);
            $id = (DB::table("d_saldo_piutang")->max("id") == null) ? 1 : (DB::table("d_saldo_piutang")->max("id")+1);

            // return $jml;

            DB::table("d_saldo_piutang")->insert([
                "id"                => $id,
                "kode_cabang"       => $request["cabang"],
                "kode_customer"     => $request["customer"][$i],
                "jumlah"            => $jml,
                "periode"           => $request["periode"],
                "tanggal_buat"      => date("Y-m-d H:i:s"),
                "terakhir_diupdate" => date("Y-m-d H:i:s"),
            ]);
        }

        // return json_encode($ids);

        // foreach($request['detail'] as $detail){
        //     $ids = (DB::table('d_saldo_piutang_detail')->where("id_saldo_piutang", $id)->max("id_detail") == null) ? 1 : (DB::table('d_saldo_piutang_detail')->where("id_saldo_piutang", $id)->max("id_detail")+1);

        //     DB::table("d_saldo_piutang_detail")->insert([
        //         "id_saldo_piutang"  => $id,
        //         "id_detail"         => $ids,
        //         "id_referensi"      => $detail["nomor_faktur"],
        //         "jumlah"            => $detail["jumlah"]
        //     ]);

        // }

    	return json_encode($response);
    }


    public function generate_saldo_piutang($m){
        $date_init = explode("/", $m)[0]."/01/".explode("/", $m)[1];

        $date = date("m/Y", strtotime("-1 months", strtotime($date_init)));

        $loop = DB::table("d_saldo_piutang")->where("periode", $date)->where("kode_cabang", Session::get('cabang'))->get();

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


    public function cek(){

        $m = "05/2018"; $date_init = explode("/", $m)[0]."/01/".explode("/", $m)[1];

        $date = date("m/Y", strtotime("-1 months", strtotime($date_init)));

        $data = DB::table("d_saldo_piutang")
                ->where("kode_cabang", "001")
                ->where("kode_customer", "CS/03/0017")
                ->where("periode", $date)
                ->select("jumlah")->first();

        $inv = DB::table("invoice")
               ->where("i_kode_cabang", "001")
               ->where("i_kode_customer", "CS/03/0017")
               ->where(DB::raw("date_part('month', i_tanggal)"), date('m', strtotime("-1 months", strtotime($date_init))))
               ->where(DB::raw("date_part('year', i_tanggal)"), date('Y', strtotime("-1 months", strtotime($date_init))))
               ->select(DB::raw('coalesce(invoice.i_total, 0) as total'), 'invoice.i_nomor', 'invoice.i_tanggal', 'invoice.i_jatuh_tempo', 'invoice.i_keterangan')
               ->groupBy('invoice.i_nomor', 'invoice.i_tanggal', 'invoice.i_jatuh_tempo', 'invoice.i_keterangan')->get();

        $kwt = DB::table("kwitansi_d")
               ->join("kwitansi", "kwitansi.k_nomor", "=", "kwitansi_d.kd_k_nomor")
               ->where("kwitansi.k_kode_customer", 'CS/03/0017')
               ->where("kwitansi.k_kode_cabang", "001")
               ->where(DB::raw("date_part('month', k_tanggal)"), date('m', strtotime("-1 months", strtotime($date_init))))
               ->where(DB::raw("date_part('year', k_tanggal)"), date('Y', strtotime("-1 months", strtotime($date_init))))
               ->select("kwitansi_d.kd_k_nomor", DB::raw("(kwitansi_d.kd_total_bayar - kwitansi_d.kd_memorial) as kd_total_bayar"), "kwitansi_d.kd_keterangan", 'kwitansi.k_tanggal')->get();

        return $inv;

        // return number_format(($inv->total + $data->jumlah), 2);

        // $data = DB::table("")
    }
}
