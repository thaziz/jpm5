<?php

namespace App\Http\Controllers\master_keuangan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

class saldo_piutang_controller extends Controller
{
    public function index($cabang){

        $cab  = DB::table('cabang')
                ->select("kode", "nama")->get();

        if($cabang != null){
            $data = DB::table('d_saldo_piutang')
                ->join("d_saldo_piutang_detail", "d_saldo_piutang_detail.id_saldo_piutang", "=", "d_saldo_piutang.id")
                ->join('customer', 'customer.kode', '=', 'd_saldo_piutang.kode_customer')
                ->join('cabang', 'cabang.kode', '=', 'd_saldo_piutang.kode_cabang')
                ->where("d_saldo_piutang.periode", date("m/Y"))
                ->where('kode_cabang', $cabang)
                ->select("d_saldo_piutang.*", "customer.alamat as alamat_customer", "customer.nama as nama_customer", "cabang.nama as nama_cabang", DB::raw('sum(d_saldo_piutang_detail.jumlah) as jumlah'))
                ->groupBy('d_saldo_piutang.id', 'customer.nama', 'cabang.nama', 'customer.alamat')->get();
        }else{
            $data = DB::table('d_saldo_piutang')
                ->join("d_saldo_piutang_detail", "d_saldo_piutang_detail.id_saldo_piutang", "=", "d_saldo_piutang.id")
                ->join('customer', 'customer.kode', '=', 'd_saldo_piutang.kode_customer')
                ->join('cabang', 'cabang.kode', '=', 'd_saldo_piutang.kode_cabang')
                ->where("d_saldo_piutang.periode", date("m/Y"))
                ->where('kode_cabang', $cab[0]->kode)
                ->select("d_saldo_piutang.*", "customer.alamat as alamat_customer", "customer.nama as nama_customer", "cabang.nama as nama_cabang", DB::raw('sum(d_saldo_piutang_detail.jumlah) as jumlah'))
                ->groupBy('d_saldo_piutang.id', 'customer.nama', 'cabang.nama', 'customer.alamat')->get();
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

        $cab  = DB::table('cabang')
                ->select("kode", "nama")->get();

    	$cust = DB::table('customer')->select("kode", "nama", "alamat")->get();

        // return $cab;
    	return view("keuangan.saldo_piutang.insert")
    		   ->withCust($cust)
    		   ->withCab($cab);
    }

    public function save(Request $request){
        return $request->all();
        
        $m1 = explode('/', $request["cust"]["periode"]);
        $response = [
            "status"    => "sukses"
        ];

        $id = (DB::table("d_saldo_piutang")->max("id") == null) ? 1 : (DB::table("d_saldo_piutang")->max("id")+1);

        DB::table("d_saldo_piutang")->insert([
            "id"                => $id,
            "kode_cabang"       => $request["cust"]["cabang"],
            "kode_customer"     => $request["cust"]["customer"],
            "periode"           => $request["cust"]["periode"],
            "tanggal_buat"      => date("Y-m-d H:i:s"),
            "terakhir_diupdate" => date("Y-m-d H:i:s"),
        ]);

        // return json_encode($ids);

        foreach($request['detail'] as $detail){
            $ids = (DB::table('d_saldo_piutang_detail')->where("id_saldo_piutang", $id)->max("id_detail") == null) ? 1 : (DB::table('d_saldo_piutang_detail')->where("id_saldo_piutang", $id)->max("id_detail")+1);

            DB::table("d_saldo_piutang_detail")->insert([
                "id_saldo_piutang"  => $id,
                "id_detail"         => $ids,
                "id_referensi"      => $detail["nomor_faktur"],
                "jumlah"            => $detail["jumlah"]
            ]);

        }

    	return json_encode($response);
    }
}
