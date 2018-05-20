<?php

namespace App\Http\Controllers\master_keuangan\laporan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Dompdf\Dompdf;
use PDF;
use Excel;
use Session;

class laporan_buku_besar extends Controller
{
    public function index_buku_besar_single(Request $request, $throttle){

    	$data = [];

    	$data = DB::table("d_jurnal_dt")
    			->join("d_jurnal", "d_jurnal.jr_id", "=", "d_jurnal_dt.jrdt_jurnal")
    			->join("d_akun", "d_akun.main_id", "=", DB::raw("substring(d_jurnal_dt.jrdt_acc, 1, 4)"))
    			->where(DB::raw("date_part('month', jr_date)"), $request->m)
                ->where("d_jurnal.jr_year", $request->y)
                ->select(DB::raw("distinct(substring(d_jurnal_dt.jrdt_acc, 1, 4)) as akun"), "main_name")->get();

        $grap = DB::table("d_jurnal_dt")
    			->join("d_jurnal", "d_jurnal.jr_id", "=", "d_jurnal_dt.jrdt_jurnal")
    			->where(DB::raw("date_part('month', jr_date)"), $request->m)
                ->where("d_jurnal.jr_year", $request->y)
                ->select("d_jurnal_dt.jrdt_value", DB::raw("substring(d_jurnal_dt.jrdt_acc, 1, 4) as acc"), "d_jurnal.jr_ref", "d_jurnal.jr_note", "d_jurnal.jr_date", "d_jurnal_dt.jrdt_statusdk")->orderBy("d_jurnal_dt.jrdt_statusdk", "asc")->get();

        foreach ($data as $key => $data_akun) {
            $saldo_awal[$data_akun->akun] = DB::table("d_akun_saldo")
                                            ->where(DB::raw("substring(d_akun_saldo.id_akun, 1, 4)"), $data_akun->akun)
                                            ->where("d_akun_saldo.bulan", $request->m)
                                            ->where("d_akun_saldo.tahun", $request->y)
                                            ->select(DB::raw("sum(d_akun_saldo.saldo_akun) as saldo"))->first()->saldo;
        }

        // return $saldo_awal;

    	return view("laporan_buku_besar.index.index_single")
    		   ->withThrottle($throttle)
               ->withRequest($request)
               ->withSaldo_awal($saldo_awal)
               ->withData($data)
               ->withGrap($grap);

    }
}
