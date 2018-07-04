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
    public function index(){
    	// return "aaa";

        $cabang = DB::table("cabang")->where("kode", $_GET["cab"])->select("nama")->first();
        $date = (substr($_GET['date'], 0, 1) == 0) ? substr($_GET['date'], 1, 1) : $_GET["date"];

        if(Session::get("cabang") == "000")
            $cabangs = DB::table("cabang")->select("kode", "nama")->get();
        else
            $cabangs = DB::table("cabang")->where("kode", Session::get("cabang"))->select("kode", "nama")->get();

    	$data = DB::table("d_jurnal")
                ->join("d_jurnal_dt", "d_jurnal_dt.jrdt_jurnal", "=", "d_jurnal.jr_id")
                ->join('d_akun', "d_akun.id_akun", "=", "d_jurnal_dt.jrdt_acc")
                ->where("d_akun.kode_cabang", $_GET['cab'])
                ->where(DB::raw("substring(jr_ref, 1,5)"), "TRANS")
                // ->where(DB::raw("date_part('month', jr_date)"), $date)
                // ->where(DB::raw("date_part('year', jr_date)"), $_GET["year"])
                ->select(DB::raw("distinct d_jurnal.jr_id"), "d_jurnal.*")->orderBy("jr_id", "desc")->get();

        // return json_encode($data);

        return view("keuangan.jurnal.index")->withData($data)->withCabang($cabang)->withCabangs($cabangs);
    }

    public function add(){
    	$cabangs = DB::table('cabang')->select("kode", "nama")->get();
        $cabang = DB::table('cabang')->select("kode")->first();
        $akun = master_akun::whereNotIn("id_akun", function($query){
            $query->select("id_parrent")
                  ->whereNotNull("id_parrent")
                  ->from("d_akun")->get();
        })->select(["id_akun", "nama_akun", "kode_cabang"])->get();
        // return $cabangs;
    	return view("keuangan.jurnal.insert")
    			->withCabangs($cabangs)
                ->withCabang($cabang)
                ->withAkun(json_encode($akun));
    }

    public function save_data(Request $request){
       //return json_encode($request->all());

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
        $ref = "TRANS".date("my")."/".date("d")."/00".($id+1);

        $jurnal = new d_jurnal;
        $jurnal->jr_id = ($id+1);
        $jurnal->jr_year = date('Y');
        $jurnal->jr_date = date('Y-m-d', strtotime($request->jr_date));
        $jurnal->jr_detail = $request->jr_detail;
        $jurnal->jr_ref = $ref;
        $jurnal->jr_note = $request->jr_note;

        if($jurnal->save()){
            $detailid = 1;
            for ($i=0; $i < count($request->nama_akun_debet); $i++) { 

                $acc = DB::table("d_akun")->where("id_akun", $request->nama_akun_debet[$i])->select("akun_dka")->first();

                $value = ($acc->akun_dka != "D") ? (explode(",", str_replace(".", "", substr($request->debet[$i], 0)))[0] * -1) : explode(",", str_replace(".", "", substr($request->debet[$i], 0)))[0];

                $debet = new d_jurnal_dt;
                $debet->jrdt_jurnal = ($id+1);
                $debet->jrdt_detailid = $detailid;
                $debet->jrdt_acc = $request->nama_akun_debet[$i];
                $debet->jrdt_value = $value;
                $debet->jrdt_type = "-";
                $debet->jrdt_detail = "-";
                $debet->jrdt_statusdk = "D";

                $debet->save();
                $detailid++;
            }

            for ($i=0; $i < count($request->nama_akun_kredit); $i++) { 
                $acc = DB::table("d_akun")->where("id_akun", $request->nama_akun_kredit[$i])->select("akun_dka")->first();

                $value = ($acc->akun_dka != "K") ? (explode(",", str_replace(".", "", substr($request->kredit[$i], 0)))[0] * -1) : explode(",", str_replace(".", "", substr($request->kredit[$i], 0)))[0];

                $debet = new d_jurnal_dt;
                $debet->jrdt_jurnal = ($id+1);
                $debet->jrdt_detailid = $detailid;
                $debet->jrdt_acc = $request->nama_akun_kredit[$i];
                $debet->jrdt_value = $value;
                $debet->jrdt_type = "-";
                $debet->jrdt_detail = "-";
                $debet->jrdt_statusdk = "K";

                $debet->save();
                $detailid++;
            }
        }

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
