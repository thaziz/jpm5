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

    	$data = master_akun_saldo::where("tahun", "=", date("Y"))->get();

    	//return date("Y");

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
}
