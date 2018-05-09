<?php

namespace App\Http\Controllers\master_keuangan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\desain_neraca;
use App\desain_neraca_detail;
use DB;

class desain_neracaController extends Controller
{
    public function index(){
    	// $data = DB::table("d_akun")
    	// 		->whereIn("id_akun", function($query){
    	// 			$query->select('d_akun.id_akun')
    	// 					->from("d_akun")
    	// 					->join("d_akun_saldo", "d_akun.id_akun", "=", "d_akun_saldo.id_akun")
    	// 					->where("d_akun_saldo.is_active", "=", "1")->get();
    	// 		})->select("id_akun", "nama_akun", "id_parrent")->orderBy("d_akun.id_akun", "asc")->get();

        $desain = DB::table("desain_neraca")->select("*")->orderBy("id_desain", "desc")->get();

        // return json_encode($data);

    	return view("keuangan.desain_neraca.index")->withDesain($desain);
    }

    public function add(){
        $data_akun = DB::table("d_akun")->select("*")->get();

        $data_group = DB::table("d_group_akun")->where("jenis_group", "Neraca/Balance Sheet")->select("*")->orderBy("nama_group", "asc")->get();

        // return json_encode($data_akun);
        // return json_encode($data_group);
    	return view("keuangan.desain_neraca.form_tambah")
               ->withData_akun(json_encode($data_akun))
               ->withData_group(json_encode($data_group));
    }

    public function save(Request $request){
        // return json_encode($request->all());
        $response = [
            "status"    => "sukses",
            "content"   => "berhasil"
        ];

        $id = (DB::table("desain_neraca")->max("id_desain") == null) ? 1 : (DB::table("desain_neraca")->max("id_desain")+1);
        
        $desain_neraca = new desain_neraca;
        $desain_neraca->id_desain = $id;
        $desain_neraca->nama_desain = $request->nama_desain;
        $desain_neraca->is_active = 0;

        if($desain_neraca->save()){

            foreach($request->data_neraca as $dataNeraca){
                DB::table("desain_neraca_dt")->insert([
                    "id_desain"     => $id,
                    "nomor_id"      => $dataNeraca["nomor_id"],
                    "id_parrent"    => $dataNeraca["id_parrent"],
                    "level"         => $dataNeraca["level"],
                    "jenis"         => $dataNeraca["jenis"],
                    "type"          => $dataNeraca["type"],
                    "keterangan"    => $dataNeraca["keterangan"],
                ]);
            }

            if(isset($request->data_detail)){
                foreach($request->data_detail as $data_detail){
                    DB::table("desain_detail_dt")->insert([
                        "id_desain"          => $id,
                        "id_parrent"         => $data_detail["id_parrent"],
                        "nomor_id"           => $data_detail["nomor_id"],
                        "id_referensi"       => $data_detail["id_group"],
                        "dari"               => $data_detail["dari"]
                    ]);
                }
            }

            return json_encode($response);
        }
    }

    public function edit($id){
        $detail = DB::table("desain_neraca_dt")->where("id_desain", $id)->get();

        $akun = DB::table("desain_detail_dt")
                ->leftJoin("d_akun", "d_akun.id_akun", "=", "desain_detail_dt.id_akun")
                ->where("desain_detail_dt.id_desain", $id)
                ->select("desain_detail_dt.*", "d_akun.nama_akun")->get();

        $datadetail = DB::table("d_akun")
                      ->whereIn("id_akun", function($query){
                        $query->select("id_akun")
                                ->from("d_akun_saldo")
                                ->where("is_active", 1)->get();
                      })->get();

        //return $akun;
        return view("keuangan.desain_neraca.form_edit")->withDetail(json_encode($detail))->withAkun(json_encode($akun))->withDatadetail(json_encode($datadetail))->withId($id);
    }

    public function update($id, Request $request){
        // return json_encode($request->all());

        $response = [
            "status"    => "sukses",
            "content"   => "berhasil"
        ];

        $deleteDetail = DB::table("desain_neraca_dt")->where("id_desain", $id)->delete();
        $deleteAkun = DB::table("desain_detail_dt")->where("id_desain", $id)->delete();

        foreach($request->neraca as $dataNeraca){
            DB::table("desain_neraca_dt")->insert([
                "id_desain"     => $id,
                "nomor_id"      => $dataNeraca["nomor_id"],
                "id_parrent"    => $dataNeraca["id_parrent"],
                "level"         => $dataNeraca["level"],
                "jenis"         => $dataNeraca["jenis"],
                "type"          => $dataNeraca["type"],
                "keterangan"    => $dataNeraca["keterangan"],
            ]);
        }

        if(isset($request->detail)){
            foreach($request->detail as $data_detail){
                DB::table("desain_detail_dt")->insert([
                    "id_desain"     => $id,
                    "nomor_id"      => $data_detail["nomor_id"],
                    "id_akun"       => $data_detail["id_akun"]
                ]);
            }
        }
        

        return json_encode($response);
    }

    public function setActive($id){
        $response = [
            "status"    => "sukses",
            "content"   => "berhasil"
        ];

        $update = DB::table("desain_neraca")->update(["is_active" => 0]);
        $update2 = DB::table("desain_neraca")->where("id_desain", $id)->update(["is_active" => 1]);

        return json_encode($response);
    }

    public function delete($id){
        $response = [
            "status"    => "sukses",
            "content"   => "berhasil"
        ];

        $deleteNeraca = DB::table("desain_neraca")->where("id_desain", $id)->delete();
        $deleteDetail = DB::table("desain_neraca_dt")->where("id_desain", $id)->delete();
        $deleteAKun = DB::table("desain_detail_dt")->where("id_desain", $id)->delete();

        return json_encode($response);
    }

    public function view($id){
        $data_neraca = []; $no = 0; $data_detail = []; $no_detail = 0;

        $dataDetail = DB::table("desain_neraca_dt")
            ->join("desain_neraca", "desain_neraca.id_desain", "=", "desain_neraca_dt.id_desain")
            ->where("desain_neraca.id_desain", $id)
            ->get();

        foreach ($dataDetail as $dataDetail) {

            $dataTotal = 0;

            if($dataDetail->jenis == 2){
                $data_detail_dt = DB::table("desain_detail_dt")
                              ->join("d_group_akun", "desain_detail_dt.id_referensi", "=", "d_group_akun.id")
                              ->where("desain_detail_dt.id_parrent", $dataDetail->nomor_id)
                              ->select("desain_detail_dt.*", "d_group_akun.*")
                              ->get();

                foreach ($data_detail_dt as $detail_dt) {
                    $data_detail[$no_detail] = [
                        "id_referensi"      => $detail_dt->id_referensi,
                        "nama_referensi"    => $detail_dt->nama_group,
                        "id_parrent"        => $detail_dt->id_parrent,
                        "nomor_id"          => $detail_dt->nomor_id,
                        "total"             => "XXXX"
                    ];

                    $no_detail++;
                }
            }

            $data_neraca[$no] = [
                "keterangan"        => $dataDetail->keterangan,
                "type"              => $dataDetail->type,
                "jenis"             => $dataDetail->jenis,
                "parrent"           => $dataDetail->id_parrent,
                "level"             => $dataDetail->level,
                "nomor_id"          => $dataDetail->nomor_id,
                "total"             => "XXXX"
            ];

            $no++;
        }

        // return json_encode($data_detail);

        return view("keuangan.desain_neraca.view")->withData_neraca($data_neraca)->withData_detail($data_detail);
    }
}
