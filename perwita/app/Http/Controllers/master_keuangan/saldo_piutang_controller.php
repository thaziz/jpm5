<?php

namespace App\Http\Controllers\master_keuangan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

class saldo_piutang_controller extends Controller
{
    public function index(){
    	return view("keuangan.saldo_piutang.index");
    }

    public function add(){
    	$cab  = DB::table('cabang')->select("kode", "nama")->get();
    	$cust = DB::table('customer')->select("kode", "nama", "alamat")->get();
    	return view("keuangan.saldo_piutang.insert")
    		   ->withCust($cust)
    		   ->withCab($cab);
    }

    public function save(Request $request){
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
            $ids = (DB::table('d_saldo_piutang_detail')->where("id_saldo_piutang", 1)->max("id_detail") == null) ? 1 : (DB::table('d_saldo_piutang_detail')->where("id_saldo_piutang", 1)->max("id_detail")+1);

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
