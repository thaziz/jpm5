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

class laporan_register_jurnal extends Controller
{
    // register jurnal pdf start

    public function print_pdf_register_single(Request $request){
    	// return json_encode($Request->all());
    	$pdf = PDF::loadView('laporan_register_jurnal.pdf', compact("request"))->setPaper('A4','potrait');

    	return $pdf->stream('Laporan_Register_Jurnal.pdf');
    }

    // register jurnal pdf end
}
