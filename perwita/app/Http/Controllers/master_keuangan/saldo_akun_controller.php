<?php

namespace App\Http\Controllers\master_keuangan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\master_akun_saldo;
use App\master_akun;

use DB;
use Validator;

class saldo_akun_controller extends Controller
{
    public function index(){
        
        if(cek_periode() == 0)
            // return view("keuangan.err.err_periode");

    	$data = master_akun_saldo::where("tahun", "=", date("Y"))->where("bulan", "=", date("m"))->whereNotNull("saldo_akun")->orderBy("id_akun", "asc")->get();

    	//return date("Y");

        // return $data;

    	return view("keuangan.akun_saldo.index")->withData($data);
    }

    public function add($parrent){

    	$data = master_akun::whereNotIn("id_akun", function($query){
    		$query->select("id_parrent")
    			  ->whereNotNull("id_parrent")
    			  ->from("d_akun")->get();
    	})->select(["id_akun", "nama_akun"])->get();

    	return view("keuangan.akun_saldo.insert")
    		->withData($data);
    }

    public function save_data(Request $request){
    	$response = [
			'status' 	=> 'berhasil',
			'content'	=> $request->all()
		];

    	$dka = master_akun::where("id_akun", $request->id_akun)->select("akun_dka")->first();
    	$saldo = master_akun_saldo::where("id_akun", $request->id_akun)->where("tahun", date("Y"));
        $upd = 0;

        //return json_encode($saldo);

        $saldo->saldo_akun = explode(",", str_replace(".", "", substr($request->saldo_awal, 3)))[0];

        //return json_encode($dka);

        if(explode(",", str_replace(".", "", substr($request->saldo_debet, 3)))[0] != 0){
            if($dka->akun_dka == "D")
                $upd = explode(",", str_replace(".", "", substr($request->saldo_debet, 3)))[0];
            else
                $upd = (explode(",", str_replace(".", "", substr($request->saldo_debet, 3)))[0] * -1);
        }else{
            if($dka->akun_dka == "K")
                $upd = explode(",", str_replace(".", "", substr($request->saldo_kredit, 3)))[0];
            else
                $upd = (explode(",", str_replace(".", "", substr($request->saldo_kredit, 3)))[0] * -1);
        }

        //return $upd;

        $saldo->update([
            "saldo_akun"    => $upd,
            "is_active"     => "1"
        ]);

        return json_encode($response);
    }

    public function edit($id){
        $data = DB::table("d_akun_saldo")
                ->join("d_akun", "d_akun.id_akun", "=", "d_akun_saldo.id_akun")
                ->where("d_akun_saldo.id_akun", $id)
                ->where("d_akun_saldo.bulan", date("m"))
                ->where("d_akun_saldo.tahun", date("Y"))
                ->select("d_akun_saldo.*", "d_akun.*")
                ->first();

        // return json_encode($data);

        return view("keuangan.akun_saldo.edit")
               ->withData($data);
    }

    public function update(Request $request){
        $response = [
            'status'    => 'sukses',
            'content'   => ""
        ];

        $data = DB::table("d_akun_saldo")
                ->where("d_akun_saldo.id_akun", $request->id_akun)
                ->where("d_akun_saldo.bulan", date("m"))
                ->where("d_akun_saldo.tahun", date("Y"));
        $akn = DB::table("d_akun")->where("id_akun", $request->id_akun)->first();

        $saldo_debet = str_replace(".", "", explode(",", $request->saldo_debet)[0]);
        $saldo_kredit = str_replace(".", "", explode(",", $request->saldo_kredit)[0]);

        if($saldo_debet == 0){
            $saldo = ($akn->akun_dka == "D") ? ($saldo_kredit * -1) : $saldo_kredit;
        }else if($saldo_kredit == 0){
            $saldo = ($akn->akun_dka == "D") ? $saldo_debet : ($saldo_debet * -1);
        }

        $data->update([
            "saldo_akun"    => $saldo
        ]);

        return $response;
    }
}
