<?php

namespace App\Http\Controllers\master_keuangan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\master_akun_saldo;
use App\master_akun as akun;

use DB;
use Validator;
use Session;

class saldo_akun_controller extends Controller
{
    public function index(){
        
        // if(cek_periode() == 1)
            // return view("keuangan.err.err_periode");

        $cabang = DB::table("cabang")->where("kode", $_GET["cab"])->select("nama")->first();

        if(Session::get("cabang") == "000")
            $cabangs = DB::table("cabang")->select("kode", "nama")->get();
        else
            $cabangs = DB::table("cabang")->where("kode", Session::get("cabang"))->select("kode", "nama")->get();

        // $data = master_akun::where('kode_cabang', $_GET['cab'])
        //                         ->select('d_akun.id_akun', 'd_akun.nama_akun', 'd_akun.akun_dka', DB::raw('coalesce(d_akun_saldo.saldo_akun, 0) as saldo_saat_ini'))
        //                         ->leftjoin('d_akun_saldo', 'd_akun_saldo.id_akun', '=', 'd_akun.id_akun')
        //                         ->where('d_akun_saldo.bulan', $_GET['date'])
        //                         ->where('d_akun_saldo.tahun', $_GET['year'])
        //                         ->orWhereNull('d_akun_saldo.tahun')
        //                         ->whereNull('d_akun_saldo.bulan')
        //                         ->orderBy('d_akun.id_akun', 'asc')
        //                         ->get();

        $bulan_forJurnal = ($_GET['date'] < 10) ? str_replace('0', '', $_GET['date']) : $_GET['date'];
        $tahun = $_GET['year'];

        $date = $_GET['year'].'-'.$_GET['date'].'-01';

        $data = akun::select('id_akun', 'nama_akun', 'akun_dka', DB::raw('coalesce(opening_balance, 0)'))
                ->where('kode_cabang', $_GET['cab'])
                ->orderBy('id_akun', 'asc')->with([
                  'mutasi_bank_debet' => function($query) use ($date, $tahun){
                        $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                              ->where('jr_date', '<', $date)
                              ->where("jrdt_statusdk", 'D')
                              ->groupBy('jrdt_acc')
                              ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'));
                  },
                  'mutasi_bank_kredit' => function($query) use ($date, $tahun){
                        $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                              ->where('jr_date', '<', $date)
                              ->where("jrdt_statusdk", 'K')
                              ->groupBy('jrdt_acc')
                              ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'));
                  },
            ])->get();


        // return json_encode($data);

    	return view("keuangan.akun_saldo.index")->withData($data)->withCabang($cabang)->withCabangs($cabangs);
    }

    public function add($parrent){

    	$data = master_akun::whereNotIn("id_akun", function($query){
    		$query->select("id_parrent")
    			  ->whereNotNull("id_parrent")
    			  ->from("d_akun")->get();
    	})->select(["id_akun", "nama_akun"])->get();

    	return view("keuangan.akun_saldo.insert")
    		->withData($data);
    }

    public function save_data(Request $request){
    	$response = [
			'status' 	=> 'berhasil',
			'content'	=> $request->all()
		];

    	$dka = master_akun::where("id_akun", $request->id_akun)->select("akun_dka")->first();
    	$saldo = master_akun_saldo::where("id_akun", $request->id_akun)->where("tahun", date("Y"));
        $upd = 0;

        //return json_encode($saldo);

        $saldo->saldo_akun = explode(",", str_replace(".", "", substr($request->saldo_awal, 3)))[0];

        //return json_encode($dka);

        if(explode(",", str_replace(".", "", substr($request->saldo_debet, 3)))[0] != 0){
            if($dka->akun_dka == "D")
                $upd = explode(",", str_replace(".", "", substr($request->saldo_debet, 3)))[0];
            else
                $upd = (explode(",", str_replace(".", "", substr($request->saldo_debet, 3)))[0] * -1);
        }else{
            if($dka->akun_dka == "K")
                $upd = explode(",", str_replace(".", "", substr($request->saldo_kredit, 3)))[0];
            else
                $upd = (explode(",", str_replace(".", "", substr($request->saldo_kredit, 3)))[0] * -1);
        }

        //return $upd;

        $saldo->update([
            "saldo_akun"    => $upd,
            "is_active"     => "1"
        ]);

        return json_encode($response);
    }

    public function edit($id){
        $data = DB::table("d_akun_saldo")
                ->join("d_akun", "d_akun.id_akun", "=", "d_akun_saldo.id_akun")
                ->where("d_akun_saldo.id_akun", $id)
                ->where("d_akun_saldo.bulan", date("m"))
                ->where("d_akun_saldo.tahun", date("Y"))
                ->select("d_akun_saldo.*", "d_akun.*")
                ->first();

        // return json_encode($data);

        return view("keuangan.akun_saldo.edit")
               ->withData($data);
    }

    public function update(Request $request){
        $response = [
            'status'    => 'sukses',
            'content'   => ""
        ];

        $data = DB::table("d_akun_saldo")
                ->where("d_akun_saldo.id_akun", $request->id_akun)
                ->where("d_akun_saldo.bulan", date("m"))
                ->where("d_akun_saldo.tahun", date("Y"));
        $akn = DB::table("d_akun")->where("id_akun", $request->id_akun)->first();

        $saldo_debet = str_replace(".", "", explode(",", $request->saldo_debet)[0]);
        $saldo_kredit = str_replace(".", "", explode(",", $request->saldo_kredit)[0]);

        if($saldo_debet == 0){
            $saldo = ($akn->akun_dka == "D") ? ($saldo_kredit * -1) : $saldo_kredit;
        }else if($saldo_kredit == 0){
            $saldo = ($akn->akun_dka == "D") ? $saldo_debet : ($saldo_debet * -1);
        }

        $data->update([
            "saldo_akun"    => $saldo
        ]);

        return $response;
    }
}
