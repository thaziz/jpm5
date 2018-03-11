<?php

namespace App\Http\Controllers\master_keuangan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\d_jurnal;
use App\d_jurnal_dt;

use DB;
use Validator;

class d_jurnal_controller extends Controller
{
    public function index(){
	// return "aaa";
	$data = d_jurnal::orderBy('jr_year', "asc")->get();
    	return view("keuangan.jurnal.index")->withData($data);
    }

    public function add(){
    	$transaksi = DB::table('d_trans')->select("*")->get();
    	return view("keuangan.jurnal.insert")
    			->withTransaksi($transaksi);
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

        $transaksi = DB::table("d_trans")->where("tr_code", $request->jr_detail)->first();
        $id = DB::table("d_jurnal")->max("jr_id"); 

        $jurnal = new d_jurnal;
        $jurnal->jr_id = ($id+1);
        $jurnal->jr_year = $request->jr_year;
        $jurnal->jr_date = date('Y-m-d', strtotime($request->jr_date));
        $jurnal->jr_detail = $transaksi->tr_name;
        $jurnal->jr_ref = null;
        $jurnal->jr_note = $request->jr_note;

        if($jurnal->save()){
            $detailid = 1;
            for ($i=0; $i < count($request->nama_akun_debet); $i++) { 
                $debet = new d_jurnal_dt;
                $debet->jrdt_jurnal = ($id+1);
                $debet->jrdt_detailid = $detailid;
                $debet->jrdt_acc = $request->nama_akun_debet[$i];
                $debet->jrdt_value = explode(",", str_replace(".", "", substr($request->debet[$i], 3)))[0];
                $debet->jrdt_type = "-";
                $debet->jrdt_detail = "-";
                $debet->jrdt_statusdk = "D";

                $debet->save();
                $detailid++;
            }

            for ($i=0; $i < count($request->nama_akun_kredit); $i++) { 
                $debet = new d_jurnal_dt;
                $debet->jrdt_jurnal = ($id+1);
                $debet->jrdt_detailid = $detailid;
                $debet->jrdt_acc = $request->nama_akun_kredit[$i];
                $debet->jrdt_value = explode(",", str_replace(".", "", substr($request->kredit[$i], 3)))[0];
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

    	$akun = DB::table("d_akun")->select("*")->get();

    	return view("keuangan.jurnal.form_detail")
    			->withDetail($detail)
    			->withAkun($akun);
    }

    public function showDetail($id){
        $detail = d_jurnal_dt::where("jrdt_jurnal", $id)->get();
        return view("keuangan.jurnal.show_detail")->withDetail($detail);
    }
}
