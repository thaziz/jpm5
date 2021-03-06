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
        // return "aa";
        // if(cek_periode() == 0)
        //     return view("keuangan.err.err_periode");

        $cabang = DB::table("cabang")->where("kode", $_GET["cab"])->select("nama")->first();

        if(Session::get("cabang") == "000")
            $cabangs = DB::table("cabang")->select("kode", "nama")->get();
        else
            $cabangs = DB::table("cabang")->where("kode", Session::get("cabang"))->select("kode", "nama")->get();

        $data = DB::table("d_akun")
                ->join("cabang", "cabang.kode", "=", "d_akun.kode_cabang")
                // ->join('d_akun_saldo', 'd_akun_saldo.id_akun', '=', 'd_akun.id_akun')
                //->where("d_akun_saldo.bulan", date('m'))
                //->where("d_akun_saldo.tahun", date('Y'))
                ->where("d_akun.kode_cabang", $_GET["cab"])
                ->select("d_akun.*", "cabang.nama as nama_cabang")
                ->orderBy("id_akun", "asc")->get();

        // return json_encode($data);
        return view("keuangan.master_akun.index")->withData($data)->withCabang($cabang)->withCabangs($cabangs);
    }

    public function add($parrent){

        $data = master_akun::whereNull("id_parrent")->get();
        $nama = "Tidak Memiliki Parrent";
        $provinsi = DB::table("provinsi")->orderBy("nama", "asc")->get();

        $cabang = DB::table("cabang")
                  ->join("kota", "kota.id", "=", "cabang.id_kota")
                  ->join("provinsi", "kota.id_provinsi", "=", "provinsi.id")
                  ->orderBy("cabang.nama", "asc")->select("cabang.kode as kode_cabang", "cabang.nama as nama_cabang", "provinsi.id as id_provinsi", "provinsi.nama as nama_provinsi")->get();

        $subakun = master_akun::orderBy("nama_akun", "asc")->get();
        $namakota = "";

        $group_neraca = DB::table("d_group_akun")->select("id", "nama_group", "jenis_group")->get();

        //return json_encode($cabang);

        if($parrent != 0){
            $data = master_akun::where("id_parrent", "=", $parrent)->get();
            $nama = master_akun::where("id_akun", "=", $parrent)->first();
            $namakota = DB::table("kota")->where("id", $nama->id_kota)->first();
        }

        // return $cabang;



        return view("keuangan.master_akun.insert")
            ->withData($data)
            ->withParrent($parrent)
            ->withProvinsi($provinsi)
            ->withCabang($cabang)->withCabangjson(json_encode($cabang))
            ->withNama($nama)
            ->withGroup_neraca($group_neraca)
            ->withNamakota($namakota)
            ->withSubakun($subakun);
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
        // return json_encode($request->all());
        // return json_encode(explode(",", str_replace(".", "", substr($request->saldo_awal, 3)))[0]);

        $bulan = ($request->opening_date != '') ? explode('-', $request->opening_date)[0] : '';
        $tahun = ($request->opening_date != '') ? explode('-', $request->opening_date)[1] : '';

        $date = $tahun.'-'.$bulan.'-01';

        // return json_encode($date);

        $response = [
            "status" => "sukses",
            "content" => "null"
        ];

        if($request->kode_cabang == "*"){

            // membuat untuk semua cabang

            $cabang = DB::table("cabang")->select("kode", "nama")->get();

            foreach ($cabang as $key => $data_cabang) {
                $prov = DB::table("cabang")
                        ->join("kota", "cabang.id_kota", "=", "kota.id")
                        ->join("provinsi", "kota.id_provinsi", "=", "provinsi.id")
                        ->where("cabang.kode", $data_cabang->kode)
                        ->select("provinsi.id")->first();

                $cek = DB::table('d_akun')->where('id_akun', $request->kode_akun.''.$prov->id.''.$data_cabang->kode)->first();

                if(count($cek) == 0){

                    $akun = new master_akun;
                    $akun->id_akun = $request->kode_akun.''.$prov->id.''.$data_cabang->kode;
                    $akun->nama_akun = $request->nama_akun." ".$data_cabang->nama;
                    $akun->id_parrent = '\n';
                    $akun->id_provinsi = $prov->id;
                    $akun->akun_dka = $request->posisi_dk;
                    $akun->is_active = $request->status_aktif;
                    $akun->kode_cabang = $data_cabang->kode;
                    $akun->type_akun = $request->type_akun;
                    $akun->main_id = $request->kode_akun;
                    $akun->main_name = $request->nama_akun;
                    $akun->group_neraca = $request->group_neraca;
                    $akun->group_laba_rugi = $request->group_laba_rugi;
                    $akun->shareable = "1";
                    $akun->opening_balance = 0;
                    $akun->opening_date = null;

                    $akun->save();

                    // if($akun->save()){
                    //     $saldo = new master_akun_saldo;
                    //     $saldo->id_akun = $request->kode_akun.''.$prov->id.''.$data_cabang->kode;
                    //     $saldo->tahun = date("Y");
                    //     $saldo->is_active = 1;
                    //     $saldo->bulan = date("m");
                    //     $saldo->saldo_akun = 0;

                    //     $saldo->save();
                    // }
                }

            }

        }else{

            // membuat 1 akun

            $cek = DB::table('d_akun')->where('id_akun', $request->kode_akun.$request->add_kode)->first();

            if(count($cek) > 0){
                $response = [
                    "status" => "exist",
                    "content" => $cek->nama_akun
                ];

                return json_encode($response);
            }

            $prov = DB::table("cabang")
                    ->join("kota", "cabang.id_kota", "=", "kota.id")
                    ->join("provinsi", "kota.id_provinsi", "=", "provinsi.id")
                    ->where("cabang.kode", $request->kode_cabang)
                    ->select("provinsi.id")->first();

            $akun = new master_akun;
            $akun->id_akun = $request->kode_akun."".$request->add_kode;
            $akun->nama_akun = $request->nama_akun.' '.$request->add_nama;
            $akun->id_parrent = '\n';
            $akun->id_provinsi = $prov->id;
            $akun->akun_dka = $request->posisi_dk;
            $akun->is_active = $request->status_aktif;
            $akun->kode_cabang = $request->kode_cabang;
            $akun->type_akun = $request->type_akun;
            $akun->main_id = $request->kode_akun;
            $akun->main_name = $request->nama_akun;
            $akun->group_neraca = $request->group_neraca;
            $akun->group_laba_rugi = $request->group_laba_rugi;
            $akun->shareable = "1";
            $akun->opening_balance = str_replace(".", "", explode(",", $request->opening_balance)[0]);
            $akun->opening_date = ($request->opening_date == '') ? null : $date;

            $akun->save();

            // if($akun->save()){
            //     if(isset($request->saldo)){
            //         $saldo = new master_akun_saldo;
            //         $saldo->id_akun = "aaa";
            //         $saldo->tahun = date("Y");
            //         $saldo->is_active = 1;
            //         $saldo->bulan = date("m");

            //         $saldo_debet = str_replace(".", "", explode(",", $request->saldo_debet)[0]);
            //         $saldo_kredit = str_replace(".", "", explode(",", $request->saldo_kredit)[0]);

            //         if($saldo_debet == 0){
            //             $saldo->saldo_akun = ($request->posisi_dk == "D") ? ($saldo_kredit * -1) : $saldo_kredit;
            //         }else if($saldo_kredit == 0){
            //             $saldo->saldo_akun = ($request->posisi_dk == "D") ? $saldo_debet : ($saldo_debet * -1);
            //         }

            //         $saldo->save();
            //     }else{
            //         $saldo = new master_akun_saldo;
            //         $saldo->id_akun = $request->kode_akun."".$request->add_kode;
            //         $saldo->tahun = date("Y");
            //         $saldo->is_active = 1;
            //         $saldo->bulan = date("m");
            //         $saldo->saldo_akun = 0;

            //         $saldo->save();
            //     }
            // }
        }

        return json_encode($response);
    }

    public function edit($parrent){

        $data = DB::table("d_akun")
                ->join("cabang", "cabang.kode", "=", "d_akun.kode_cabang")
                //->join('d_akun_saldo', 'd_akun_saldo.id_akun', '=', 'd_akun.id_akun')
                ->where("d_akun.id_akun", $parrent)
                //->where("d_akun_saldo.bulan", date('m'))
                //->where("d_akun_saldo.tahun", date('Y'))
                ->select("d_akun.*", "cabang.nama as nama_cabang")
                ->orderBy("id_akun")->first();
        $provinsi = DB::table("provinsi")->orderBy("nama", "asc")->get();

        $group_neraca = DB::table("d_group_akun")->select("id", "nama_group", "jenis_group")->get();

        // return json_encode($data);

        return view("keuangan.master_akun.edit")
            ->withData($data)
            ->withGroup_neraca($group_neraca)
            ->withProvinsi($provinsi);
    }

    public function update_data(Request $request){
        // return json_encode($request->all());
        $response = [
            'status'    => 'sukses',
            'content'   => $request->all()
        ];
        
        $cek = explode('-', $request->opening_date);
        
        $bulan = ($request->opening_date != '') ? explode('-', $request->opening_date)[0] : '';
        $tahun = ($request->opening_date != '') ? explode('-', $request->opening_date)[1] : '';
        
        if(count($cek) == 3){
            $bulan = ($request->opening_date != '') ? explode('-', $request->opening_date)[1] : '';
            $tahun = ($request->opening_date != '') ? explode('-', $request->opening_date)[0] : '';
        }
        
        $date = $tahun.'-'.$bulan.'-01';
        // return json_encode($date);

        $akun = master_akun::find($request->kode_akun);
        $akun->nama_akun = $request->nama_akun;
        $akun->akun_dka = $request->posisi_dk;
        $akun->is_active = $request->status_aktif;
        $akun->group_neraca = $request->group_neraca;
        $akun->group_laba_rugi = $request->group_laba_rugi;
        $akun->opening_balance = str_replace(".", "", explode(",", $request->opening_balance)[0]);
        $akun->opening_date = ($request->opening_date == '') ? null : $date;

        if($akun->save()){
            return json_encode($response);
        }
    }

    public function hapus_data($id){

        $cek = DB::table("d_jurnal_dt")->where("jrdt_acc", $id)->select("*")->get();

        if(count($cek) > 0){
            Session::flash('terpakai', "Akun Ini Terpakai Di Jurnal, Sehingga Tidak Bisa Dihapus.");
            return redirect(route("akun.index"));
        }

        DB::table('d_akun')->where("id_akun", '=', $id)->delete();
        DB::table('d_akun_saldo')->where("id_akun", '=', $id)->delete();
        Session::flash('sukses', "Data Akun Berhasil Dihapus.");
        return redirect(route("akun.index").'?cab='.$_GET["cab"]);
    }

    public function cek_parrent($id){
        $data = master_akun::find($id);
        $dataInside = master_akun::where("id_parrent", $id)->get();

        $response = [
            "data"          => $data,
            "data_inside"   => $dataInside
        ];

        return json_encode($response);
    }

    public function share_akun(){

        $dt_ids = [];

        $akun_pusat = DB::table("d_akun")->where("kode_cabang", "000")->select("main_id", "main_name", "akun_dka", "is_active", "type_akun", "group_neraca", "group_laba_rugi", "shareable")->get();

        // return $akun_pusat;

        $cabang = DB::table("cabang")
                  ->join("kota", "kota.id", "=", "cabang.id_kota")
                  ->select("cabang.kode", "cabang.nama", "kota.id_provinsi")
                  ->orderBy("cabang.kode", "asc")->get();

        foreach($akun_pusat as $data_akun){

            foreach($cabang as $data_cabang){

                $ids = $data_akun->main_id."".$data_cabang->id_provinsi."".$data_cabang->kode;

                $cek = DB::table("d_akun")->where("id_akun", $ids)->first();

                if(count($cek) == 0){
                    $akun = new master_akun;
                    $akun->id_akun = $ids;
                    $akun->nama_akun = $data_akun->main_name." ".$data_cabang->nama;
                    $akun->id_parrent = '\n';
                    $akun->id_provinsi = $data_cabang->id_provinsi;
                    $akun->akun_dka = $data_akun->akun_dka;
                    $akun->is_active = $data_akun->is_active;
                    $akun->kode_cabang = $data_cabang->kode;
                    $akun->type_akun = $data_akun->type_akun;
                    $akun->main_id = $data_akun->main_id;
                    $akun->main_name = $data_akun->main_name;
                    $akun->group_neraca = $data_akun->group_neraca;
                    $akun->group_laba_rugi = $data_akun->group_laba_rugi;
                    $akun->shareable = $data_akun->shareable;

                    if($akun->save()){
                        $saldo = new master_akun_saldo;
                        $saldo->id_akun = $ids;
                        $saldo->tahun = date("Y");
                        $saldo->is_active = 1;
                        $saldo->bulan = date("m");
                        $saldo->saldo_akun = 0;

                        $saldo->save();
                    }
                }


            }

        }

        return "Akun Pusat Berhasil Di Share Ke Semua Cabang";
    }

    public function get_akun($cabang){
        if($cabang != 'all')
            $data = DB::table("d_akun")->where('kode_cabang', $cabang)->select("id_akun", "nama_akun")->orderBy("id_akun", "asc")->get();
        else
            $data = DB::table("d_akun")->select("id_akun", "nama_akun")->orderBy("id_akun", "asc")->get();

        return json_encode($data);
    }
}
