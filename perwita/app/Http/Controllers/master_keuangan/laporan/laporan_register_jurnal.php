<?php

namespace App\Http\Controllers\master_keuangan\laporan;

ini_set('max_execution_time', 120);

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Dompdf\Dompdf;
use PDF;
use Excel;
use Session;

class laporan_register_jurnal extends Controller
{
    // register jurnal pdf start

    public function print_pdf_register_single(Request $request){
        // return "okee";
    	// return json_encode($request->all());

    	$d1 = date_format(date_create($request->tanggal), "Y-m-d");
        $d2 = date_format(date_create($request->sampai), "Y-m-d");

    	$range = ['1001', '1099']; $detail = [];

    	if($request->jenis == "bank")
    		$range = ['1101', '1109'];

    	$data = DB::table('d_jurnal_dt')
    				->join('d_jurnal', 'd_jurnal.jr_id', '=', 'd_jurnal_dt.jrdt_jurnal')
    				->whereBetween("d_jurnal.jr_date", [$d1, $d2])
    				->whereBetween(DB::raw("substring(d_jurnal_dt.jrdt_acc, 1, 4)"), $range)
    				->select("d_jurnal.*")->distinct('d_jurnal.jr_id')->get();

    	// return json_encode($data);

    	foreach ($data as $key => $value) {
    		$detail[$value->jr_id] = DB::table('d_jurnal_dt')
    										->join('d_akun', 'd_akun.id_akun', '=', 'd_jurnal_dt.jrdt_acc')
    										->where("d_jurnal_dt.jrdt_jurnal", $value->jr_id)
    										->select("d_jurnal_dt.*", "d_akun.nama_akun")
    										->get();
    	}

    	// return json_encode($data);

        return view('laporan_register_jurnal.pdf', compact("request", "detail", "data", "d1", "d2"));

    	$pdf = PDF::loadView('laporan_register_jurnal.pdf', compact("request", "detail", "data", "d1", "d2"))->setPaper('A4','landscape');

    	return $pdf->stream('Laporan_Register_Jurnal.pdf');
    }

    // register jurnal pdf end
}
