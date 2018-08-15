<?php

namespace App\Http\Controllers\master_keuangan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\desain_laba_rugi;
use App\desain_laba_rugi_dt;
use DB;
use Session;

class desain_labaRugiController extends Controller
{
    public function index(){
    	// $data = DB::table("d_akun")
        //      ->whereIn("id_akun", function($query){
        //          $query->select('d_akun.id_akun')
        //                  ->from("d_akun")
        //                  ->join("d_akun_saldo", "d_akun.id_akun", "=", "d_akun_saldo.id_akun")
        //                  ->where("d_akun_saldo.is_active", "=", "1")->get();
        //      })->select("id_akun", "nama_akun", "id_parrent")->orderBy("d_akun.id_akun", "asc")->get();

        $desain = DB::table("desain_laba_rugi")->select("*")->orderBy("id_desain", "desc")->get();

        // return json_encode($data);

    	return view("keuangan.desain_laba_rugi.index")->withDesain($desain);
    }

    public function add(){
        $data_akun = DB::table("d_akun")->select("*")->get();
        $data_group = DB::table("d_group_akun")->where("jenis_group", 2)->select("*")->orderBy("nama_group", "asc")->get();

        // return json_encode($data_akun);
        // return json_encode($data_group);

        return view("keuangan.desain_laba_rugi.form_tambah")
               ->withData_akun(json_encode($data_akun))
               ->withData_group(json_encode($data_group));
    }

    public function save(Request $request){
        // return json_encode($request->all());
        $response = [
            "status"    => "sukses",
            "content"   => "berhasil"
        ];

        $id = (DB::table("desain_laba_rugi")->max("id_desain") == null) ? 1 : (DB::table("desain_laba_rugi")->max("id_desain")+1);
        
        $desain_laba_rugi = new desain_laba_rugi;
        $desain_laba_rugi->id_desain = $id;
        $desain_laba_rugi->nama_desain = $request->nama_desain;
        $desain_laba_rugi->is_active = 0;

        if($desain_laba_rugi->save()){

            foreach($request->data_neraca as $dataNeraca){
                DB::table("desain_laba_rugi_dt")->insert([
                    "id_desain"     => $id,
                    "nomor_id"      => $dataNeraca["nomor_id"],
                    "id_parrent"    => $dataNeraca["id_parrent"],
                    "level"         => $dataNeraca["level"],
                    "jenis"         => $dataNeraca["jenis"],
                    "type"          => 'null',
                    "keterangan"    => $dataNeraca["keterangan"],
                ]);
            }

            if(isset($request->data_detail)){
                foreach($request->data_detail as $data_detail){
                    DB::table("desain_laba_rugi_detail_dt")->insert([
                        "id_desain"          => $id,
                        "id_parrent"         => $data_detail["id_parrent"],
                        "nomor_id"           => $data_detail["nomor_id"],
                        "id_group"           => $data_detail["id_group"],
                        "dari"               => $data_detail["dari"],
                        "nama"               => $data_detail["nama"]
                    ]);
                }
            }

            return json_encode($response);
        }
    }

    public function setActive($id){
        $response = [
            "status"    => "sukses",
            "content"   => "berhasil"
        ];

        $cek = DB::table("desain_laba_rugi")->where("id_desain", $id)->first();

        if(count($cek) == 0){
            $response = [
                "status"    => "miss",
            ];

           return json_encode($response);
        }

        $update = DB::table("desain_laba_rugi")->update(["is_active" => 0]);
        $update2 = DB::table("desain_laba_rugi")->where("id_desain", $id)->update(["is_active" => 1]);

        return json_encode($response);
    }

    public function edit($id){
        $cek = DB::table("desain_laba_rugi")->where("id_desain", $id)->first();

        if(count($cek) == 0){
            Session::flash("err", "Ups. Kami Tidak Bisa Menemukan Data Desain Yang Dimaksud..");
            return redirect(route("desain_laba_rugi.index"));
        }

        $data_akun = DB::table("d_akun")->select("*")->get();
        $data_group = DB::table("d_group_akun")->where("jenis_group", "2")->select("*")->orderBy("nama_group", "asc")->get();
        $data_desain = DB::table("desain_laba_rugi")->where("id_desain", $id)->first();
        $data_neraca = DB::table("desain_laba_rugi_dt")->where("id_desain", $id)->get();
        $data_detail = DB::table("desain_laba_rugi_detail_dt")->where("id_desain", "$id")->get();

        // return json_encode($data_akun);
        // return json_encode($data_group);

        return view("keuangan.desain_laba_rugi.form_edit")
               ->withId($id)
               ->withData_akun(json_encode($data_akun))
               ->withData_group(json_encode($data_group))
               ->withData_neraca(json_encode($data_neraca))
               ->withData_detail(json_encode($data_detail))
               ->withData_desain($data_desain);
    }

    public function update($id, Request $request){
        // return json_encode($request->all());

        $response = [
            "status"    => "sukses",
            "content"   => "berhasil"
        ];

        $deleteDetail = DB::table("desain_laba_rugi_dt")->where("id_desain", $id)->delete();
        $deleteAkun = DB::table("desain_laba_rugi_detail_dt")->where("id_desain", $id)->delete();

        DB::table("desain_laba_rugi")->where("id_desain", $id)->update([ "nama_desain" => $request->nama_desain ]);

        foreach($request->data_neraca as $dataNeraca){
            DB::table("desain_laba_rugi_dt")->insert([
                "id_desain"     => $id,
                "nomor_id"      => $dataNeraca["nomor_id"],
                "id_parrent"    => $dataNeraca["id_parrent"],
                "level"         => $dataNeraca["level"],
                "jenis"         => $dataNeraca["jenis"],
                "type"          => 'null',
                "keterangan"    => $dataNeraca["keterangan"],
            ]);
        }

        if(isset($request->data_detail)){
            foreach($request->data_detail as $data_detail){
                DB::table("desain_laba_rugi_detail_dt")->insert([
                    "id_desain"          => $id,
                    "id_parrent"         => $data_detail["id_parrent"],
                    "nomor_id"           => $data_detail["nomor_id"],
                    "id_group"           => $data_detail["id_group"],
                    "dari"               => $data_detail["dari"],
                    "nama"               => $data_detail["nama"]
                ]);
            }
        }
        

        return json_encode($response);
    }

    public function delete($id){
        $response = [
            "status"    => "sukses",
            "content"   => "berhasil"
        ];

        if(count( DB::table("desain_laba_rugi")->where("id_desain", $id)->first()) == 0){
            Session::flash("sukses", "Data Desain Laba Rugi Dengan ID ".$id." Berhasil Dihapus.");
            return redirect(route("desain_laba_rugi.index"));
        }

        $deleteNeraca = DB::table("desain_laba_rugi")->where("id_desain", $id)->delete();
        $deleteDetail = DB::table("desain_laba_rugi_dt")->where("id_desain", $id)->delete();
        $deleteAKun = DB::table("desain_laba_rugi_detail_dt")->where("id_desain", $id)->delete();

        Session::flash("sukses", "Data Desain Laba Rugi Dengan ID ".$id." Berhasil Dihapus.");

        return redirect(route("desain_laba_rugi.index"));
    }

    public function view($id){
        $data_neraca = []; $no = 0; $data_detail = []; $no_detail = 0;

        $cek = DB::table("desain_laba_rugi")->where("id_desain", $id)->first();

        if(count($cek) == 0){
            return '<center><small class="text-muted">Ups. Kami Tidak Bisa Menemukan Data Desain Ini. Cobalah Untuk Muat Ulang Halaman..</small></center>';
        }


        $dataDetail = DB::table("desain_laba_rugi_dt")
            ->join("desain_laba_rugi", "desain_laba_rugi.id_desain", "=", "desain_laba_rugi_dt.id_desain")
            ->where("desain_laba_rugi.id_desain", $id)
            ->orderBy('nomor_id', 'asc')
            ->get();

        foreach ($dataDetail as $dataDetail) {

            $dataTotal = 0;

            $data_neraca[count($data_neraca)] = [
                "keterangan"        => $dataDetail->keterangan,
                "type"              => $dataDetail->type,
                "jenis"             => $dataDetail->jenis,
                "parrent"           => $dataDetail->id_parrent,
                "level"             => $dataDetail->level,
                "nomor_id"          => $dataDetail->nomor_id,
                "total"             => "XXXX"
            ];

        }

        // return json_encode($data_neraca);

        return view("keuangan.desain_laba_rugi.view")->withData_neraca($data_neraca)->withData_detail($data_detail)->withCek($cek);
    }
}
