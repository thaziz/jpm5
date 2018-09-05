<?php

namespace App\Http\Controllers\master_keuangan\laporan;

ini_set('max_execution_time', 300);

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\master_akun as akun;

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

      	$data = akun::select('id_akun', 'nama_akun')->orderBy('id_akun', 'asc')->with([
                  'mutasi_bank_debet' => function($query) use ($bulan_forJurnal, $tahun){
                        $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                              ->where(DB::raw("date_part('month', jr_date)"), $bulan_forJurnal)
                              ->where(DB::raw("date_part('year', jr_date)"), $tahun)
                              ->where("jrdt_statusdk", 'D')
                              ->where(DB::raw('substring(jr_no,1,1)'), 'B')
                              ->groupBy('jrdt_acc')
                              ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'));
                  },
                  'mutasi_bank_kredit' => function($query) use ($bulan_forJurnal, $tahun){
                        $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                              ->where(DB::raw("date_part('month', jr_date)"), $bulan_forJurnal)
                              ->where(DB::raw("date_part('year', jr_date)"), $tahun)
                              ->where("jrdt_statusdk", 'K')
                              ->where(DB::raw('substring(jr_no,1,1)'), 'B')
                              ->groupBy('jrdt_acc')
                              ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'));
                  },
                  'mutasi_kas_debet' => function($query) use ($bulan_forJurnal, $tahun){
                        $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                              ->where(DB::raw("date_part('month', jr_date)"), $bulan_forJurnal)
                              ->where(DB::raw("date_part('year', jr_date)"), $tahun)
                              ->where("jrdt_statusdk", 'D')
                              ->where(DB::raw('substring(jr_no,1,1)'), 'K')
                              ->groupBy('jrdt_acc')
                              ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'));
                  },
                  'mutasi_kas_kredit' => function($query) use ($bulan_forJurnal, $tahun){
                        $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                              ->where(DB::raw("date_part('month', jr_date)"), $bulan_forJurnal)
                              ->where(DB::raw("date_part('year', jr_date)"), $tahun)
                              ->where("jrdt_statusdk", 'K')
                              ->where(DB::raw('substring(jr_no,1,1)'), 'K')
                              ->groupBy('jrdt_acc')
                              ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'));
                  },
                  'mutasi_memorial_debet' => function($query) use ($bulan_forJurnal, $tahun){
                        $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                              ->where(DB::raw("date_part('month', jr_date)"), $bulan_forJurnal)
                              ->where(DB::raw("date_part('year', jr_date)"), $tahun)
                              ->where("jrdt_statusdk", 'D')
                              ->where(DB::raw('substring(jr_no,1,1)'), 'M')
                              ->groupBy('jrdt_acc')
                              ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'));
                  },
                  'mutasi_memorial_kredit' => function($query) use ($bulan_forJurnal, $tahun){
                        $query->join('d_jurnal', 'd_jurnal.jr_id', '=', 'jrdt_jurnal')
                              ->where(DB::raw("date_part('month', jr_date)"), $bulan_forJurnal)
                              ->where(DB::raw("date_part('year', jr_date)"), $tahun)
                              ->where("jrdt_statusdk", 'K')
                              ->where(DB::raw('substring(jr_no,1,1)'), 'M')
                              ->groupBy('jrdt_acc')
                              ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'));
                  }
            ])->get();

      }else if($request->jenis == 'Tahun'){

            $tahun = $request->y1;

            // return $bulan_forJurnal; 

            $data = DB::table('d_akun')
                        ->select('d_akun.*')
                        ->get();
      }

      // return json_encode($data);

      return view("laporan_neraca_saldo.pdf")
              ->withRequest($request->all())
              ->withData($data);
    }
}
