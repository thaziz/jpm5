<?php

namespace App\Http\Controllers\master_keuangan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\master_akun;
use App\master_akun_saldo;
use Validator;
use DB;
use Session;

class akun_Controller extends Controller
{
    public function index(){
    	$data = master_akun::whereNull("id_parrent")->get();
    	return view("keuangan.master_akun.index")->withData($data);
    	//return $data;
    }

    public function add($parrent){

    	$data = master_akun::whereNull("id_parrent")->get();
    	$nama = "Tidak Memiliki Parrent";
    	$provinsi = DB::table("provinsi")->orderBy("nama", "asc")->get();

    	if($parrent != 0){
    		$data = master_akun::where("id_parrent", "=", $parrent)->get();
    		$nama = master_akun::where("id_akun", "=", $parrent)->first();
    	}

    	return view("keuangan.master_akun.insert")
    		->withData($data)
    		->withParrent($parrent)
    		->withProvinsi($provinsi)
    		->withNama($nama);
    }

    public function kota($id_provinsi){
    	$kota = DB::table("kota")->where("id_provinsi", "=", $id_provinsi)->orderBy("nama", "asc")->get();
    	$html = "";

    	foreach ($kota as $dataKota) {
    		$html = $html.'<option value="'.$dataKota->id.'">'.$dataKota->nama.'</option>';
    	}

    	return '<option value="0">Pilih Kota</option>'.$html;
    }

    public function save_data(Request $request){
        //return json_encode($request->all());
        //return json_encode(explode(",", str_replace(".", "", substr($request->saldo_awal, 3)))[0]);

    	$response = [
			'status' 	=> 'berhasil',
			'content'	=> $request->all()
		];

    	$rules = [
    		'id_akun' 			=> 'required|',
    		'nama_akun'			=> 'required'
    	];

    	$messages = [
    		'id_akun.required'		=> 'Inputan Kode Akun Tidak Boleh Kosong',
    		'nama_akun.required'	=> 'Inputan Nama Akun Tidak Boleh Kosong',
    	];

    	$validator = Validator::make($request->all(), $rules, $messages);

    	if($validator->fails()){
    		$response = [
    			'status' 	=> 'gagal',
    			'content'	=> $validator->errors()->first()
    		];

    		return json_encode($response);
    	}

    	$cek = master_akun::find($request->id_akun);

    	if($request->id_parrent != 0){
    		$cek = master_akun::find($request->akun_parent.$request->id_akun);
    	}

    	if(count($cek) > 0){
    		$response = [
    			'status' 	=> 'gagal',
    			'content'	=> "Inputan Id Akun Sudah Ada Di Database"
    		];

    		return json_encode($response);
    	}

        $id = $request->id_akun;
    	$akun = new master_akun;
    	$akun->id_akun = $request->id_akun;
    	$akun->nama_akun = ucwords($request->nama_akun);
    	$akun->akun_dka = $request->akun_dka;
    	if($request->id_parrent != 0){
    		$akun->id_akun = $request->akun_parent.$request->id_akun;
            $id = $request->akun_parent.$request->id_akun;
    		$akun->id_parrent = $request->id_parrent;
    	}

    	if($request->id_provinsi != 0)
    		$akun->id_provinsi = $request->id_provinsi;

    	if($request->id_kota != 0)
    		$akun->id_kota = $request->id_kota;

    	$akun->is_active = $request->is_active;

    	if($akun->save()){
            if(isset($request->saldo)){
                $saldo = new master_akun_saldo;
                $saldo->id_akun = $id;
                $saldo->tahun = date("Y");
                $saldo->saldo_akun = explode(",", str_replace(".", "", substr($request->saldo_awal, 3)))[0];

                if(explode(",", str_replace(".", "", substr($request->saldo_debet, 3)))[0] != 0){
                    if($request->akun_dka == "D")
                        $saldo->saldo_akun = explode(",", str_replace(".", "", substr($request->saldo_debet, 3)))[0];
                    else
                        $saldo->saldo_akun = (explode(",", str_replace(".", "", substr($request->saldo_debet, 3)))[0] * -1);
                }else{
                    if($request->akun_dka == "K")
                        $saldo->saldo_akun = explode(",", str_replace(".", "", substr($request->saldo_kredit, 3)))[0];
                    else
                        $saldo->saldo_akun = (explode(",", str_replace(".", "", substr($request->saldo_kredit, 3)))[0] * -1);
                }

                if($saldo->save())
                    return json_encode($response);
            }
            return json_encode($response);
        }
    }

    public function edit($parrent){

    	$data = master_akun::find($parrent);
    	$provinsi = DB::table("provinsi")->orderBy("nama", "asc")->get();

    	return view("keuangan.master_akun.edit")
    		->withData($data)
    		->withProvinsi($provinsi);
    }

    public function update_data(Request $request, $id){
    	$response = [
			'status' 	=> 'berhasil',
			'content'	=> $request->all()
		];

		$akun = master_akun::find($id);
		$akun->nama_akun = $request->nama_akun;
		$akun->is_active = $request->is_active;

		if($akun->save()){
			return json_encode($response);
		}    	
    }

    public function hapus_data($id){
    	$data = master_akun::where("id_parrent", "=", $id)->get();

    	foreach ($data as $dataSubAkun) {
            DB::table('d_akun')->where("id_akun", '=', $dataSubAkun->id_akun)->delete();
            $this->hapus_data($dataSubAkun->id_akun);
         }

        DB::table('d_akun_saldo')->where("id_akun", '=', $id)->delete();
        DB::table('d_akun')->where("id_akun", '=', $id)->delete();
    	Session::flash('sukses', "Data Akun Berhasil Dihapus.");
    	return redirect(route("akun.index"));
    }
}
