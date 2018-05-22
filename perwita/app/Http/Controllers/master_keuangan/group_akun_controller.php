<?php

namespace App\Http\Controllers\master_keuangan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\d_group_akun;

use DB;
use Auth;
use Session;

class group_akun_controller extends Controller
{
    public function index(){
    	$data = DB::table("d_group_akun")->select("*")->get();

    	return view("keuangan.group_akun.index")->withData($data);
    }

    public function add(){
        // $akun = json_encode(DB::table("d_akun")->select("id_akun", "nama_akun", "group_neraca", "group_laba_rugi")->orderBy("id_akun", "asc")->get());
        $ids = DB::table("d_group_akun")->orderBy("id", "desc")->first()->id;

    	return view("keuangan.group_akun.insert")->withIds($ids);
    }

    public function save(Request $request){
    	// return json_encode($request->all());

    	$response = [
            "status" => "sukses",
            "content" => "null"
        ];

    	$id = "GA-".$request->kode_group;

    	$cek = DB::table("d_group_akun")->where("id", $id)->select("*")->first();

    	// return json_encode($cek);

    	if(count($cek)){
    		$response = [
	            "status" => "exist",
	            "content" => $cek->nama_group
	        ];

	        return json_encode($response);
    	}

    	$group = new d_group_akun;
    	$group->id = $id;
    	$group->nama_group = $request->nama_group;
    	$group->jenis_group = $request->jenis;

    	if($group->save())
			return json_encode($response);
    }

    public function edit($id){
    	$group = DB::table("d_group_akun")->where("id", $id)->first();

    	return view("keuangan.group_akun.edit")
    		   ->withGroup($group);
    }

    public function update(Request $request){
    	// return json_encode($request->all());

    	$response = [
            "status" => "sukses",
            "content" => "null"
        ];

    	// return json_encode($cek);

    	$group = DB::table("d_group_akun")->where("id", $request->kode_group)->update([
    		"nama_group"	=> $request->nama_group
    	]);

		return json_encode($response);
    }

    public function hapus($id){
    	DB::table("d_group_akun")->where("id", $id)->delete();
    	Session::flash('sukses', "Data Master Group Akun Berhasil Dihapus.");

    	return redirect(url("master_keuangan/group_akun"));
    }
}
