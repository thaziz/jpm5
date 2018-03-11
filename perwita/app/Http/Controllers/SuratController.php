<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use PDF;
class SuratController extends Controller
{
	public function pdf_pengalamankerja () {
		$pdf = PDF::loadView('outputsurat/pengalamankerja');

    	return $pdf->stream();
	}

	public function pdf_tidaklagibekerja () {
		$pdf = PDF::loadView('outputsurat/tidaklagibekerja');

    	return $pdf->stream();
	}

	public function pdf_legalisirdataupah () {
		$pdf = PDF::loadView('outputsurat/legalisirdataupah');

    	return $pdf->stream();
	}

	public function pdf_surattidakaktifBPJS () {
		$pdf = PDF::loadView('outputsurat/surattidakaktifBPJS');

    	return $pdf->stream();
	}

	public function pdf_suratlaporanpekerjaresign () {
		$pdf = PDF::loadView('outputsurat/suratlaporanpekerjaresign');

    	return $pdf->stream();
	}

	public function pdf_suratpengajuanpinjambank () {
		$pdf = PDF::loadView('outputsurat/suratpengajuanpinjambank');

    	return $pdf->stream();
	}

	public function pdf_suratpengantarpendaftaranbpjskesehatan () {
		$pdf = PDF::loadView('outputsurat/pengantarpendaftaranbpjskesehatan');

    	return $pdf->stream();
	}

	public function pdf_suratketerangankerjapengajuankpr () {
		$pdf = PDF::loadView('outputsurat/keterangankerjapengajuankpr');

    	return $pdf->stream();
	}


	public function view () {
		return view('form_surat_surat.pengalamankerja');
	}

}
