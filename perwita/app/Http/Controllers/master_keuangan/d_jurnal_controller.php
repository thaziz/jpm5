<?php

namespace App\Http\Controllers\master_keuangan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\d_jurnal;
use App\d_jurnal_dt;
use App\master_akun;

use DB;
use Validator;
use Session;

class d_jurnal_controller extends Controller
{
    public function index(Request $request){
    	// return json_encode($request->all());

        $cabang = DB::table("cabang")->where("kode", $_GET["cab"])->select("nama")->first();
        $date = (substr($_GET['date'], 0, 1) == 0) ? substr($_GET['date'], 1, 1) : $_GET["date"];

        if(Session::get("cabang") == "000")
            $cabangs = DB::table("cabang")->select("kode", "nama")->get();
        else
            $cabangs = DB::table("cabang")->where("kode", Session::get("cabang"))->select("kode", "nama")->get();

        $idx = "";
        
        if($request->jenis == 'kas'){
            $idx = 'TK';
        }

    	$data = DB::table("d_jurnal")
                ->join("d_jurnal_dt", "d_jurnal_dt.jrdt_jurnal", "=", "d_jurnal.jr_id")
                ->join('d_akun', "d_akun.id_akun", "=", "d_jurnal_dt.jrdt_acc")
                ->where("d_akun.kode_cabang", $_GET['cab'])
                ->where(DB::raw("substring(jr_ref, 1,2)"), $idx)
                // ->where(DB::raw("date_part('month', jr_date)"), $date)
                // ->where(DB::raw("date_part('year', jr_date)"), $_GET["year"])
                ->select(DB::raw("distinct d_jurnal.jr_id"), "d_jurnal.*")->orderBy("jr_id", "desc")->get();

        // return json_encode($data);

        return view("keuangan.jurnal.index")->withData($data)->withCabang($cabang)->withCabangs($cabangs);
    }

    public function add(){

    	$cabangs = DB::table('cabang')->select("kode", "nama")->get();
        $cabang = DB::table('cabang')->select("kode")->first();
        $akun = master_akun::select(["id_akun", "nama_akun", "kode_cabang"])->get();

        return view("keuangan.jurnal.insert")
    			->withCabangs($cabangs)
                ->withCabang($cabang)
                ->withAkun(json_encode($akun));
    }

    public function save_data(Request $request){
       // return json_encode($request->all());

       $response = [
            'status'    => 'berhasil',
            'content'   => $request->all()
        ];

        $rules = [
            'jr_detail'     => 'required',
            'total_debet'   => 'same:total_kredit'
        ];

        $messages = [
            'jr_detail.required'    => 'Anda Diharuskan Memilih Transaksi Terlebih Dahulu.',
            'total_debet.same'      => 'Pastikan Total Debet Dan Total Kredit Harus Seimbang.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'status'    => 'gagal',
                'content'   => $validator->errors()->first()
            ];

            return json_encode($response);
        }

        $id = DB::table("d_jurnal")->max("jr_id");

       if($request->type_transaksi == "kas"){
            if($request->jenis_transaksi == 1){
                $try =  (DB::table('d_jurnal')->where(DB::raw("substring(jr_ref, 1, 3)"), "TKM")->orderBy('jr_insert', 'desc')->first()) ? substr(DB::table('d_jurnal')->where(DB::raw("substring(jr_ref, 1, 3)"), "TKM")->orderBy('jr_insert', 'desc')->first()->jr_ref, 13) : 0;
                $ref = "TKM".date("my")."/".date("d")."/00".($try+1);

                // return json_encode(($try+1));
            }
            else{
                $try =  (DB::table('d_jurnal')->where(DB::raw("substring(jr_ref, 1, 3)"), "TKK")->orderBy('jr_insert', 'desc')->first()) ? substr(DB::table('d_jurnal')->where(DB::raw("substring(jr_ref, 1, 3)"), "TKK")->orderBy('jr_insert', 'desc')->first()->jr_ref, 13) : 0;
                $ref = "TKK".date("my")."/".date("d")."/00".($try+1);
            }
       }

        $jurnal = new d_jurnal;
        $jurnal->jr_id = ($id+1);
        $jurnal->jr_year = date('Y');
        $jurnal->jr_date = date('Y-m-d');
        $jurnal->jr_detail = $request->jr_detail;
        $jurnal->jr_ref = $ref;
        $jurnal->jr_note = $request->jr_note;

        // $jurnal->save();

        if($jurnal->save()){
            foreach ($request->akun as $key => $data_akun) {
                $acc = DB::table("d_akun")->where("id_akun", $data_akun)->select("akun_dka")->first();
                $debet = str_replace('.', '', explode(',', $request->debet[$key])[0]);
                $kredit = str_replace('.', '', explode(',', $request->kredit[$key])[0]);

                // return json_encode($acc->akun_dka);

                if($debet != 0){
                    $value = ($acc->akun_dka == "D") ? $debet : ($debet * -1);
                    $pos = "D";
                }else if($kredit != 0){
                    $value = ($acc->akun_dka == "K") ? $kredit : ($kredit * -1);
                    $pos = "K";
                }else if($debet == 0 && $kredit == 0){
                    $value = 0;
                    $pos = $acc->akun_dka;
                }

                $jr_dt = new d_jurnal_dt;
                $jr_dt->jrdt_jurnal = ($id+1);
                $jr_dt->jrdt_detailid = ($key+1);
                $jr_dt->jrdt_acc = $data_akun;
                $jr_dt->jrdt_value = $value;
                $jr_dt->jrdt_type = "-";
                $jr_dt->jrdt_detail = "-";
                $jr_dt->jrdt_statusdk = $pos;

                $jr_dt->save();
            }
        }

        // if($jurnal->save()){

        // }

        return json_encode($response);

    }

    public function getDetail($id){
    	$detail = DB::table("d_trans_dt")
    				->where("trdt_code", $id)
    				->where("trdt_year", date("Y"))
    				->get();

    	$akun = master_akun::whereNotIn("id_akun", function($query){
            $query->select("id_parrent")
                  ->whereNotNull("id_parrent")
                  ->from("d_akun")->get();
        })->select(["id_akun", "nama_akun"])->get();

    	return view("keuangan.jurnal.form_detail")
    			->withDetail($detail)
    			->withAkun($akun);
    }

    public function showDetail($id){
        $detail = d_jurnal_dt::where("jrdt_jurnal", $id)->get();
        return view("keuangan.jurnal.show_detail")->withDetail($detail);
    }
}
