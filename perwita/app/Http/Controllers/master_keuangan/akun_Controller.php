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

        // if(cek_periode() == 0)
        //     return view("keuangan.err.err_periode");

        $data = master_akun::whereNull("id_parrent")->orderBy("id_akun")->get();
        //return json_encode($data);
        return view("keuangan.master_akun.index")->withData($data);
        //return $data;
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
        //return json_encode(explode(",", str_replace(".", "", substr($request->saldo_awal, 3)))[0]);

        $response = [
            "status" => "sukses",
            "content" => "null"
        ];

        $cek = DB::table('d_akun')->where('id_akun', $request->kode_akun.$request->add_kode)->first();

        if(count($cek) > 0){
            $response = [
                "status" => "exist",
                "content" => "null"
            ];

            return json_encode($response);
        }

        $akun = new d_akun;
        $akun->id_akun = $request->kode_akun.$request->add_kode;
        $akun->nama_akun = $request->nama_akun;
        $akun->id_parrent = '\n';

        return json_encode($response);
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
            'status'    => 'berhasil',
            'content'   => $request->all()
        ];

        $akun = master_akun::find($id);
        $akun->nama_akun = $request->nama_akun;
        $akun->is_active = $request->is_active;

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
        return redirect(route("akun.index"));
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
}
