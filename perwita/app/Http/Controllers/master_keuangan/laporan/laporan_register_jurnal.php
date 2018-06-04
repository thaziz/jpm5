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

    public function print_pdf_register_single(Request $Request, $throttle){
    	return "okee";
    }

    // register jurnal pdf end
}
