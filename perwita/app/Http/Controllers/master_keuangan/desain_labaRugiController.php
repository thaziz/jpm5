<?php

namespace App\Http\Controllers\master_keuangan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\desain_laba_rugi;
use App\desain_laba_rugi_dt;
use DB;

class desain_labaRugiController extends Controller
{
    public function index(){
    	$data = DB::table("d_akun")
    			->whereIn("id_akun", function($query){
    				$query->select('d_akun.id_akun')
    						->from("d_akun")
    						->join("d_akun_saldo", "d_akun.id_akun", "=", "d_akun_saldo.id_akun")
    						->where("d_akun_saldo.is_active", "=", "1")->get();
    			})->select("id_akun", "nama_akun", "id_parrent")->orderBy("d_akun.id_akun", "asc")->get();

        $desain = DB::table("desain_laba_rugi")->select("*")->orderBy("tanggal_buat", "desc")->get();

        //return json_encode($desain);

    	return view("keuangan.desain_laba_rugi.index")->withData(json_encode($data))->withDesain($desain);
    }

    public function add(){
        $datadetail = DB::table("d_akun")
                      ->whereIn("id_akun", function($query){
                        $query->select("id_akun")
                                ->from("d_akun_saldo")
                                ->where("is_active", 1)->get();
                      })->get();

    	return view("keuangan.desain_laba_rugi.form_tambah")->withDatadetail(json_encode($datadetail));
    }

    public function save(Request $request){
        // return json_encode($request->detail);
        $response = [
            "status"    => "sukses",
            "content"   => "berhasil"
        ];

        $id = (DB::table("desain_laba_rugi")->max("id_desain") == null) ? 1 : (DB::table("desain_laba_rugi")->max("id_desain")+1);
        
        $desain_neraca = new desain_laba_rugi;
        $desain_neraca->id_desain = $id;
        $desain_neraca->is_active = 0;

        if($desain_neraca->save()){

            foreach($request->neraca as $dataNeraca){
                DB::table("desain_laba_rugi_dt")->insert([
                    "id_desain"     => $id,
                    "nomor_id"      => $dataNeraca["nomor_id"],
                    "id_parrent"    => $dataNeraca["id_parrent"],
                    "level"         => $dataNeraca["level"],
                    "jenis"         => $dataNeraca["jenis"],
                    "type"          => $dataNeraca["type"],
                    "keterangan"    => $dataNeraca["keterangan"],
                ]);
            }

            foreach($request->detail as $data_detail){
                DB::table("desain_laba_rugi_detail_dt")->insert([
                    "id_desain"     => $id,
                    "nomor_id"      => $data_detail["nomor_id"],
                    "id_akun"   	=> $data_detail["id_akun"]
                ]);
            }

            return json_encode($response);
        }
    }

     public function view($id){
        $data = []; $no = 0;
        $dataDetail = DB::table("desain_laba_rugi_dt")
            ->join("desain_laba_rugi", "desain_laba_rugi.id_desain", "=", "desain_laba_rugi_dt.id_desain")
            ->where("desain_laba_rugi.id_desain", $id)
            ->get();

        foreach ($dataDetail as $dataDetail) {

            $dataTotal = 0;

            if($dataDetail->jenis == 2){
                $dataAkun = DB::table("desain_laba_rugi_detail_dt")->where("id_desain", $dataDetail->id_desain)->where("nomor_id", $dataDetail->nomor_id)->select("id_akun")->get();

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
                "nama_perkiraan"    => $dataDetail->keterangan,
                "type"              => $dataDetail->type,
                "jenis"             => $dataDetail->jenis,
                "parrent"           => $dataDetail->id_parrent,
                "total"             => $dataTotal
            ];

            $no++;
        }

        //return json_encode($data);

        return view("keuangan.desain_laba_rugi.view")->withData($data);
    }

    public function setActive($id){
        $response = [
            "status"    => "sukses",
            "content"   => "berhasil"
        ];

        $update = DB::table("desain_laba_rugi")->update(["is_active" => 0]);
        $update2 = DB::table("desain_laba_rugi")->where("id_desain", $id)->update(["is_active" => 1]);

        return json_encode($response);
    }

    public function edit($id){
        $detail = DB::table("desain_laba_rugi_dt")->where("id_desain", $id)->get();

        $akun = DB::table("desain_laba_rugi_detail_dt")
                ->leftjoin("d_akun", "d_akun.id_akun", "=", "desain_laba_rugi_detail_dt.id_akun")
                ->where("desain_laba_rugi_detail_dt.id_desain", $id)
                ->select("desain_laba_rugi_detail_dt.*", "d_akun.nama_akun")->get();

        $datadetail = DB::table("d_akun")
                      ->whereIn("id_akun", function($query){
                        $query->select("id_akun")
                                ->from("d_akun_saldo")
                                ->where("is_active", 1)->get();
                      })->get();

        // return json_encode($akun);
        return view("keuangan.desain_laba_rugi.form_edit")->withDetail(json_encode($detail))->withAkun(json_encode($akun))->withDatadetail(json_encode($datadetail))->withId($id);
    }

    public function update($id, Request $request){
        // return json_encode($request->all());

        $response = [
            "status"    => "sukses",
            "content"   => "berhasil"
        ];

        $deleteDetail = DB::table("desain_laba_rugi_dt")->where("id_desain", $id)->delete();
        $deleteAkun = DB::table("desain_laba_rugi_detail_dt")->where("id_desain", $id)->delete();

        foreach($request->neraca as $dataNeraca){
            DB::table("desain_laba_rugi_dt")->insert([
                "id_desain"     => $id,
                "nomor_id"      => $dataNeraca["nomor_id"],
                "id_parrent"    => $dataNeraca["id_parrent"],
                "level"         => $dataNeraca["level"],
                "jenis"         => $dataNeraca["jenis"],
                "type"          => $dataNeraca["type"],
                "keterangan"    => $dataNeraca["keterangan"],
            ]);
        }

        foreach($request->detail as $data_detail){
            DB::table("desain_laba_rugi_detail_dt")->insert([
                "id_desain"     => $id,
                "nomor_id"      => $data_detail["nomor_id"],
                "id_akun"       => $data_detail["id_akun"]
            ]);
        }

        return json_encode($response);
    }

    public function delete($id){
        $response = [
            "status"    => "sukses",
            "content"   => "berhasil"
        ];

        $deleteNeraca = DB::table("desain_laba_rugi")->where("id_desain", $id)->delete();
        $deleteDetail = DB::table("desain_laba_rugi_dt")->where("id_desain", $id)->delete();
        $deleteAKun = DB::table("desain_laba_rugi_detail_dt")->where("id_desain", $id)->delete();

        return json_encode($response);
    }
}
