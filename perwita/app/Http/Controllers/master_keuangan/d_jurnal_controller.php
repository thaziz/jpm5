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

        if($_GET['cab'] != 'all')
            $cabang_nama = DB::table("cabang")->where("kode", $_GET["cab"])->select("nama")->first()->nama;
        else
            $cabang_nama = "Semua Cabang";
        
        $date = (substr($_GET['date'], 0, 1) == 0) ? substr($_GET['date'], 1, 1) : $_GET["date"];

        if(Session::get("cabang") == "000"){
            $cabangs = DB::table("cabang")->select("kode", "nama")->get();
        }
        else{
            $cabangs = DB::table("cabang")->where("kode", Session::get("cabang"))->select("kode", "nama")->get();
        }

        $idx = "";
        
        if($request->jenis == 'kas'){
            $idx = 'TK';
        }

        if($_GET['cab'] != 'all'){
            $data = DB::table("d_jurnal")
                ->join("d_jurnal_dt", "d_jurnal_dt.jrdt_jurnal", "=", "d_jurnal.jr_id")
                ->join('cabang', 'cabang.kode', '=', DB::raw('substring(jr_no, 9, 3)'))
                ->where(DB::raw('substring(jr_no, 9, 3)'), $_GET['cab'])
                ->where(DB::raw("substring(jr_ref, 1,2)"), $idx)
                // ->where(DB::raw("date_part('month', jr_date)"), $date)
                // ->where(DB::raw("date_part('year', jr_date)"), $_GET["year"])
                ->select(DB::raw("distinct d_jurnal.jr_id"), "d_jurnal.*", 'cabang.nama')->orderBy("jr_id", "desc")->get();
        }else{
            $data = DB::table("d_jurnal")
                ->join("d_jurnal_dt", "d_jurnal_dt.jrdt_jurnal", "=", "d_jurnal.jr_id")
                ->join('cabang', 'cabang.kode', '=', DB::raw('substring(jr_no, 9, 3)'))
                ->where(DB::raw("substring(jr_ref, 1,2)"), $idx)
                // ->where(DB::raw("date_part('month', jr_date)"), $date)
                // ->where(DB::raw("date_part('year', jr_date)"), $_GET["year"])
                ->select(DB::raw("distinct d_jurnal.jr_id"), "d_jurnal.*", 'cabang.nama')->orderBy("jr_id", "desc")->get();
        }

        // return json_encode($data);

        return view("keuangan.jurnal.index")->withData($data)->withCabang_nama($cabang_nama)->withCabangs($cabangs);
    }

    public function add(Request $request){

        // return json_encode($request->all());

        if($request->cab == 'all')
    	   $cabangs = DB::table('cabang')->select("kode", "nama")->orderBy('kode', 'asc')->get();
        else
           $cabangs = DB::table('cabang')->where("kode", $request->cab)->select("kode", "nama")->get();

        $cabang = DB::table('cabang')->select("kode")->first();
        $akun_real = master_akun::select(["id_akun", "nama_akun", "kode_cabang"])
                        ->where('is_active', 1)
                        ->where(DB::raw('substring(id_akun, 1, 2)'), '10')->get();

        $akun_all = master_akun::select(["id_akun", "nama_akun", "kode_cabang"])
                        ->where('is_active', 1)
                        ->where(DB::raw('substring(id_akun, 1, 2)'), '!=', '11')->get();

        // return $cabangs;

        return view("keuangan.jurnal.insert")
    			->withCabangs($cabangs)
                ->withCabang($cabang)
                ->withAkun_real(json_encode($akun_real))
                ->withAkun_all($akun_all);
    }

    public function edit(Request $request){

        $data = DB::table("d_jurnal")
                ->where('d_jurnal.jr_id', $request->id)
                ->select(DB::raw('substring(jr_no, 9, 3) as kode'))->first();

        if(!$data)
            return '<center class="text-muted">Data Transaksi Ini Tidak Bisa Kami Temukan</center>';

        $cabangs = DB::table('cabang')->where("kode", $data->kode)->select("kode", "nama")->get();

        $data_jurnal = DB::table("d_jurnal")
                            ->where('d_jurnal.jr_id', $request->id)
                            ->select("*")->first();

        $data_detail = DB::table("d_jurnal_dt")
                            ->join('d_akun', 'd_akun.id_akun', '=', 'd_jurnal_dt.jrdt_acc')
                            ->where('jrdt_jurnal', $data_jurnal->jr_id)
                            ->select('d_jurnal_dt.*', 'd_akun.nama_akun')->get();

        $dd = json_encode($data_detail);


        $cabang = DB::table('cabang')->select("kode")->first();

        $akun_real = master_akun::select(["id_akun", "nama_akun", "kode_cabang"])
                        ->where('is_active', 1)
                        ->where(DB::raw('substring(id_akun, 1, 2)'), '10')->get();

        $akun_all = master_akun::select(["id_akun", "nama_akun", "kode_cabang"])
                        ->where('is_active', 1)
                        ->where(DB::raw('substring(id_akun, 1, 2)'), '!=', '11')->get();

        return view("keuangan.jurnal.edit")
                ->withCabangs($cabangs)
                ->withCabang($cabang)
                ->withAkun_real(json_encode($akun_real))
                ->withAkun_all($akun_all)
                ->withData_jurnal($data_jurnal)
                ->withData_detail($data_detail)
                ->withDd($dd);
    }

    public function save_data(Request $request){
       // return json_encode($request->all());

       $date = explode('-', $request->jr_date);

       if(!DB::table('d_periode_keuangan')->where('bulan', $date[1])->where('tahun', $date[2])->where('status', 'accessable')->first()){
            $response = [
                'status'    => 'blocked',
                'content'   => 'null'
            ];

            return $response;
       }

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
                $jr = DB::table('d_jurnal')->where(DB::raw("substring(jr_ref, 1, 3)"), "TKM")->where(DB::raw("concat(date_part('month', jr_date), '-', date_part('year', jr_date))"), date('n-Y', strtotime($request->jr_date)))->orderBy('jr_insert', 'desc')->first();

                $ref =  ($jr) ? (explode('/', $jr->jr_ref)[2] + 1) : 1;
                $ref = "TKM-".date("my", strtotime($request->jr_date))."/".$request->cabang."/".str_pad($ref, 4, '0', STR_PAD_LEFT);
                $jr_no = get_id_jurnal('KM', $request->cabang, $request->jr_date);

                // return json_encode($jr);
                // return json_encode($jr_no.' __ '.$ref);
            }
            else{
               $jr = DB::table('d_jurnal')->where(DB::raw("substring(jr_ref, 1, 3)"), "TKK")->where(DB::raw("concat(date_part('month', jr_date), '-', date_part('year', jr_date))"), date('n-Y'))->orderBy('jr_insert', 'desc')->first();

                $ref =  ($jr) ? (explode('/', $jr->jr_ref)[2] + 1) : 1;
                $ref = "TKK-".date("my", strtotime($request->jr_date))."/".$request->cabang."/".str_pad($ref, 4, '0', STR_PAD_LEFT);
                $jr_no = get_id_jurnal('KK', $request->cabang, $request->jr_date);

                // return json_encode($jr);
                // return json_encode($jr_no." __ ".$ref);
            }
       }

        $jurnal = new d_jurnal;
        $jurnal->jr_id = ($id+1);
        $jurnal->jr_year = $date[2];
        $jurnal->jr_date = date('Y-m-d', strtotime($request->jr_date));
        $jurnal->jr_detail = $request->jr_detail;
        $jurnal->jr_ref = $ref;
        $jurnal->jr_note = $request->jr_detail;
        $jurnal->jr_no = $jr_no;
        $jurnal->jr_on_proses = 2;

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

    public function update(Request $request){
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

        $jurnal = d_jurnal::find($request->id_transaksi);
        $jurnal->jr_detail = $request->jr_detail;
        $jurnal->jr_note = $request->jr_detail;
        // $jurnal->jr_on_proses = 2;

        if($jurnal->save()){

            $deleted = DB::table('d_jurnal_dt')->where('jrdt_jurnal', $request->id_transaksi)->delete();

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
                $jr_dt->jrdt_jurnal = $request->id_transaksi;
                $jr_dt->jrdt_detailid = ($key+1);
                $jr_dt->jrdt_acc = $data_akun;
                $jr_dt->jrdt_value = $value;
                $jr_dt->jrdt_type = "-";
                $jr_dt->jrdt_detail = "-";
                $jr_dt->jrdt_statusdk = $pos;

                $jr_dt->save();
            }
        }

        if($jurnal->save()){

        }

        return json_encode($response);

    }

    public function delete(Request $request){
       // return json_encode($request->all());

       $response = [
            'status'    => 'berhasil',
        ];

        $delete = DB::table('d_jurnal')->where('jr_id', $request->id)->delete();

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

    public function list_transaksi(Request $request){

        // return json_encode($request->all());

        $data = d_jurnal::where(DB::raw("substring(jr_no, 1, 2)"), "KK")
                ->where(DB::raw('substring(jr_no, 9, 3)'), $request->cab)
                ->orWhere(DB::raw("substring(jr_no, 1, 2)"), "KM")
                ->where(DB::raw('substring(jr_no, 9, 3)'), $request->cab)
                ->with(['detail' => function($query){
                    $query->with('akun');
                }])->get();

        $data_json = json_encode($data);
        $cab_nama = DB::table('cabang')->where('kode', $request->cab)->first()->nama;
        // return $data;

        return view('keuangan.jurnal.list_transaksi', compact('data', 'data_json', 'cab_nama'));
    }
}
