<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

class laba_rugiController extends Controller
{
	public function index(){
	$pendapatan=DB::table('d_tipe_akun')->select('ta_kode')->where('ta_detail','Pendapatan')->first();
	$bebanPokok=DB::table('d_tipe_akun')->select('ta_kode')->where('ta_detail','BEBAN POKOK')->first();
	$operasional=DB::table('d_tipe_akun')->select('ta_kode')->where('ta_detail','OPERASIONAL')->first();
	$umumdanAdmin=DB::table('d_tipe_akun')->select('ta_kode')->where('ta_detail','UMUM DAN ADMIN')->first();
	$biayaLain=DB::table('d_tipe_akun')->select('ta_kode')->where('ta_detail','BIAYA LAIN')->first();
	$pendapatanLain=DB::table('d_tipe_akun')->select('ta_kode')->where('ta_detail','PENDAPATAN LAIN')->first();
	
	 $pendapatan = explode('-', $pendapatan->ta_kode);
	 $bebanPokok = explode('-', $bebanPokok->ta_kode);
	 $operasional = explode('-', $operasional->ta_kode);
	 $umumdanAdmin = explode('-', $umumdanAdmin->ta_kode);
	 $biayaLain = explode('-', $biayaLain->ta_kode);
	 $pendapatanLain = explode('-', $pendapatanLain->ta_kode);
	 
    $pendapatan=DB::select("select jr_detail as nama,sum(jrdt_value) as value
from d_jurnal 
join 
d_jurnal_dt on d_jurnal.jr_id=d_jurnal_dt.jrdt_jurnal
where  cast ( SUBSTR(d_jurnal_dt.jrdt_acc,1,2) as int8)  BETWEEN  $pendapatan[0] and $pendapatan[1]
group by jr_detail");

    $bebanPokok=DB::select("select jr_detail as nama,sum(jrdt_value) as value
from d_jurnal 
join 
d_jurnal_dt on d_jurnal.jr_id=d_jurnal_dt.jrdt_jurnal
where  cast ( SUBSTR(d_jurnal_dt.jrdt_acc,1,2) as int8)  BETWEEN  $bebanPokok[0] and $bebanPokok[1]
group by jr_detail");
    $operasional=DB::select("select jr_detail as nama,sum(jrdt_value) as value
from d_jurnal 
join 
d_jurnal_dt on d_jurnal.jr_id=d_jurnal_dt.jrdt_jurnal
where  cast ( SUBSTR(d_jurnal_dt.jrdt_acc,1,2) as int8)  BETWEEN  $operasional[0] and $operasional[1]
group by jr_detail");
      $umumdanAdmin=DB::select("select jr_detail as nama,sum(jrdt_value) as value
from d_jurnal 
join 
d_jurnal_dt on d_jurnal.jr_id=d_jurnal_dt.jrdt_jurnal
where  cast ( SUBSTR(d_jurnal_dt.jrdt_acc,1,2) as int8)  BETWEEN  $umumdanAdmin[0] and $umumdanAdmin[1]
group by jr_detail");
      $biayaLain=DB::select("select jr_detail as nama,sum(jrdt_value) as value
from d_jurnal 
join 
d_jurnal_dt on d_jurnal.jr_id=d_jurnal_dt.jrdt_jurnal
where  cast ( SUBSTR(d_jurnal_dt.jrdt_acc,1,2) as int8)  BETWEEN  $biayaLain[0] and $biayaLain[1]
group by jr_detail");
      $pendapatanLain=DB::select("select jr_detail as nama,sum(jrdt_value) as value
from d_jurnal 
join 
d_jurnal_dt on d_jurnal.jr_id=d_jurnal_dt.jrdt_jurnal
where  cast ( SUBSTR(d_jurnal_dt.jrdt_acc,1,2) as int8)  BETWEEN 91 and 99
group by jr_detail");

    
    return view('laporan_laba_rugi.index',compact('pendapatan','bebanPokok','operasional','umumdanAdmin','biayaLain','pendapatanLain'));
	}
}
