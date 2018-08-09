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

class laporan_neraca_saldo extends Controller
{
    public function index_neraca_saldo(Request $request){

      // return json_encode($request->all());
      $bulan = $tahun = '';  $data_detail = [];

      if($request->jenis == 'Bulan'){

      	$bulan = explode('-', $request->d1)[1]; $tahun = explode('-', $request->d1)[0];
      	$bulan_forJurnal = ($bulan < 10) ? str_replace('0', '', $bulan) : $bulan;

      	// return $bulan_forJurnal; 

      	$data = DB::table('d_akun')
      			->select('d_akun.*')
      			->get();

      	foreach($data as $key => $akun){
      		$saldo_awal = DB::table('d_akun_saldo')
      						->where('id_akun', $akun->id_akun)
      						->where('bulan', '01')
      						->where('tahun', '2018')
      						->select(DB::raw('coalesce(saldo_akun, 0) as saldo'))
      						->first();

      		$mutasi_bank = DB::table('d_jurnal_dt')
      						->join('d_jurnal', 'd_jurnal.jr_id', '=', 'd_jurnal_dt.jrdt_jurnal')
      						->where(DB::raw("date_part('month', jr_date)"), $bulan_forJurnal)
      						->where(DB::raw("date_part('year', jr_date)"), $tahun)
      						->where('jrdt_acc', $akun->id_akun)
      						->where(DB::raw('substring(jr_no,1,1)'), 'B')
      						->select(DB::raw('coalesce(sum(jrdt_value), 0) as total'))
      						->first();

      		$mutasi_kas = DB::table('d_jurnal_dt')
      						->join('d_jurnal', 'd_jurnal.jr_id', '=', 'd_jurnal_dt.jrdt_jurnal')
      						->where(DB::raw("date_part('month', jr_date)"), $bulan_forJurnal)
      						->where(DB::raw("date_part('year', jr_date)"), $tahun)
      						->where('jrdt_acc', $akun->id_akun)
      						->where(DB::raw('substring(jr_no,1,1)'), 'K')
      						->select(DB::raw('coalesce(sum(jrdt_value), 0) as total'))
      						->first();

      		$mutasi_memorial = DB::table('d_jurnal_dt')
      						->join('d_jurnal', 'd_jurnal.jr_id', '=', 'd_jurnal_dt.jrdt_jurnal')
      						->where(DB::raw("date_part('month', jr_date)"), $bulan_forJurnal)
      						->where(DB::raw("date_part('year', jr_date)"), $tahun)
      						->where('jrdt_acc', $akun->id_akun)
      						->where(DB::raw('substring(jr_no,1,1)'), 'M')
      						->select(DB::raw('coalesce(sum(jrdt_value), 0) as total'))
      						->first();

      		// return json_encode($mutasi_bank);

      		$data_detail[$akun->id_akun] = [
      			'saldo_akun'		=> ($saldo_awal) ? $saldo_awal->saldo : 0,
      			'mutasi_bank'		=> ($mutasi_bank) ? $mutasi_bank->total : 0,
      			'mutasi_kas'		=> ($mutasi_kas) ? $mutasi_kas->total : 0,
      			'mutasi_memorial'	=> ($mutasi_memorial) ? $mutasi_memorial->total : 0,
      		];

      		// return $akun->id_akun;
      	}

      }

      // return $data_detail;

      return view("laporan_neraca_saldo.pdf")
              ->withRequest($request->all())
              ->withData_detail($data_detail)
              ->withData($data);
    }
}
