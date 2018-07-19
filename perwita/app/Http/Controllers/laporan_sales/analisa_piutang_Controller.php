<?php

namespace App\Http\Controllers\laporan_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Carbon\carbon;

class analisa_piutang_Controller extends Controller
{
    public function index(){
      $customer = DB::select(" SELECT kode,nama FROM customer ORDER BY nama ASC ");
      $cabang   = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
      $piutang  = DB::select(" SELECT id_akun,nama_akun FROM d_akun where id_akun like '%1301%' ORDER BY nama_akun ASC ");

      return view('purchase/master/master_penjualan/laporan/lap_analisa_piutang/lap_analisapiutang',compact('customer','piutang','cabang'));
    }

    public function ajax_lap_analisa_piutang(Request $request) {
      
        $tglawal = $request->min;
        $tglakhir = $request->max;

        $customer  =  DB::select("SELECT i_kode_customer from invoice where i_tanggal BETWEEN '$tglawal' and '$tglakhir' order by i_nomor asc");
      
        $arraycus = [];
        for($i = 0; $i < count($customer); $i++){
            $cus_id['customer'] = $customer[$i]->i_kode_customer;   
            array_push($arraycus , $cus_id);
        }

       // return $arraycus;

       //unique customer
        $result_customer = array();
        foreach ($arraycus as &$v) {
            if (!isset($result_customer[$v['customer']]))
                $result_customer[$v['customer']] =& $v;
        }
        $array = array_values($result_customer);   

        


        $saldo_push = [];
        $terbayar_push = [];
        $tersisa_push = [];
        $sebelum_jatuhtempo_push= [];
        $jatuhtempo_30_push = [];
        $jatuhtempo_60_push = [];
        $jatuhtempo_90_push = [];
        $jatuhtempo_120_push = [];
        $jatuhtempo_180_push = [];
        $jatuhtempo_360_push = [];
        $jatuhtempo_lebih360_push = [];
        $tgl_jthtempo_now_push = [];
        
        for ($i=0; $i <count($array) ; $i++) { 

            $tgl_jthtempo_now = DB::table('invoice')
                            ->select('i_jatuh_tempo')
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->where('i_kode_customer','=',$array[$i])
                            ->get();
            array_push($tgl_jthtempo_now_push, $tgl_jthtempo_now);



            $saldoawal = DB::table('invoice')
                            ->select(DB::raw('SUM(i_total_tagihan) as saldoawal'))
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->where('i_kode_customer','=',$array[$i])
                            ->get();
            array_push($saldo_push, $saldoawal);

            $terbayar = DB::table('kwitansi')
                        ->select(DB::raw('SUM(k_netto) as terbayar'))
                        ->where('k_tanggal','>',$tglawal)
                        ->where('k_tanggal','<',$tglakhir)
                        ->where('k_kode_customer','=',$array[$i])
                        ->get();
            
            array_push($terbayar_push, $terbayar);

            $ss[$i] = ($saldo_push[$i][0]->saldoawal - $terbayar_push[$i][0]->terbayar);

            $date_now = carbon::now();
            $date_now_g = $date_now->year.'-'.$date_now->month.'-'.$date_now->day;

            $sebelum_jatuhtempo = DB::table('invoice')
                            ->select(DB::raw('SUM(i_total_tagihan) as sebelum_jatuhtempo'))
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->where('i_kode_customer','=',$array[$i])
                            ->where('i_jatuh_tempo','<',$date_now_g)
                            ->get();
            array_push($sebelum_jatuhtempo_push, $sebelum_jatuhtempo);

            $date_30 = carbon::now()->addDays(30);
            $date_30_g = $date_30->year.'-'.$date_30->month.'-'.$date_30->day;
            
            $jatuhtempo_30 = DB::table('invoice')
                            ->select(DB::raw('SUM(i_total_tagihan) as jatuhtempo_30'))
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->whereBetween('i_jatuh_tempo',[$tgl_jthtempo_now_push[$i][0]->i_jatuh_tempo,$date_30_g])
                            ->where('i_kode_customer','=',$array[$i])
                            ->get();
            array_push($jatuhtempo_30_push, $jatuhtempo_30);

            $date_60 = carbon::now()->addDays(60);
            $date_60_g = $date_60->year.'-'.$date_60->month.'-'.$date_60->day;
            
            $jatuhtempo_60 = DB::table('invoice')
                            ->select(DB::raw('SUM(i_total_tagihan) as jatuhtempo_60'))
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->whereBetween('i_jatuh_tempo',[$date_30_g,$date_60_g])
                            ->where('i_kode_customer','=',$array[$i])
                            ->get();
            array_push($jatuhtempo_60_push, $jatuhtempo_60);

            $date_90 = carbon::now()->addDays(90);
            $date_90_g = $date_90->year.'-'.$date_90->month.'-'.$date_90->day;
            
            $jatuhtempo_90 = DB::table('invoice')
                            ->select(DB::raw('SUM(i_total_tagihan) as jatuhtempo_90'))
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->whereBetween('i_jatuh_tempo',[$date_60_g,$date_90_g])
                            ->where('i_kode_customer','=',$array[$i])
                            ->get();
            array_push($jatuhtempo_90_push, $jatuhtempo_90);

            $date_120 = carbon::now()->addDays(120);
            $date_120_g = $date_120->year.'-'.$date_120->month.'-'.$date_120->day;
            
            $jatuhtempo_120 = DB::table('invoice')
                            ->select(DB::raw('SUM(i_total_tagihan) as jatuhtempo_120'))
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->whereBetween('i_jatuh_tempo',[$date_90_g,$date_120_g])
                            ->where('i_kode_customer','=',$array[$i])
                            ->get();
            array_push($jatuhtempo_120_push, $jatuhtempo_120);


            $date_180 = carbon::now()->addDays(180);
            $date_180_g = $date_180->year.'-'.$date_180->month.'-'.$date_180->day;
            
            $jatuhtempo_180 = DB::table('invoice')
                            ->select(DB::raw('SUM(i_total_tagihan) as jatuhtempo_180'))
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->whereBetween('i_jatuh_tempo',[$date_120_g,$date_180_g])
                            ->where('i_kode_customer','=',$array[$i])
                            ->get();
            array_push($jatuhtempo_180_push, $jatuhtempo_180);

            $date_360 = carbon::now()->addDays(360);
            $date_360_g = $date_360->year.'-'.$date_360->month.'-'.$date_360->day;
            
            $jatuhtempo_360 = DB::table('invoice')
                            ->select(DB::raw('SUM(i_total_tagihan) as jatuhtempo_360'))
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->whereBetween('i_jatuh_tempo',[$date_180_g,$date_360_g])
                            ->where('i_kode_customer','=',$array[$i])
                            ->get();
            array_push($jatuhtempo_360_push, $jatuhtempo_360);

            $date_360 = carbon::now()->addDays(360);
            $date_360_g = $date_360->year.'-'.$date_360->month.'-'.$date_360->day;
            
            $jatuhtempo_lebih360 = DB::table('invoice')
                            ->select(DB::raw('SUM(i_total_tagihan) as jatuhtempo_lebih360'))
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->where('i_jatuh_tempo','>',$date_360_g)
                            ->where('i_kode_customer','=',$array[$i])
                            ->get();
            array_push($jatuhtempo_lebih360_push, $jatuhtempo_lebih360);


        }
        
        // [$terbayar_push,$saldo_push,$ss,$sebelum_jatuhtempo_push,$jatuhtempo_30_push,$jatuhtempo_60_push,$jatuhtempo_90_push,$jatuhtempo_120_push,$jatuhtempo_180_push,$jatuhtempo_360_push,$tgl_jthtempo_now_push];

        return view('purchase/master/master_penjualan/laporan/lap_analisa_piutang/ajax_analisapiutang_rekap',compact('array','saldo_push','terbayar_push','ss','sebelum_jatuhtempo_push','jatuhtempo_30_push','jatuhtempo_60_push','jatuhtempo_90_push','jatuhtempo_120_push','jatuhtempo_180_push','jatuhtempo_360_push','jatuhtempo_lebih360_push','tgl_jthtempo_now_push'));
    }

}
