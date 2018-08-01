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
        $customer  =  DB::select("SELECT i_kode_customer from invoice where i_tanggal BETWEEN '$tglawal' and '$tglakhir' order by i_kode_customer asc");
      
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

        $saldo_push                 = [];
        $terbayar_push              = [];
        $terbayar_posting_push      = [];
        $tersisa_push               = [];
        $sebelum_jatuhtempo_push    = [];
        $jatuhtempo_30_push         = [];
        $jatuhtempo_60_push         = [];
        $jatuhtempo_90_push         = [];
        $jatuhtempo_120_push        = [];
        $jatuhtempo_180_push        = [];
        $jatuhtempo_360_push        = [];
        $jatuhtempo_lebih360_push   = [];
        $tgl_jthtempo_now_push      = [];
        
        for ($i=0; $i <count($array) ; $i++) { 

            $tgl_jthtempo_now = DB::table('invoice')
                            ->select('i_jatuh_tempo')
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->where('i_kode_customer','=',$array[$i])
                            ->get();    

            array_push($tgl_jthtempo_now_push, $tgl_jthtempo_now);

            // return $tgl_jthtempo_now_push;
            $saldoawal = DB::table('invoice')
                            ->select(DB::raw('SUM(i_total_tagihan) as saldoawal'))
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->where('i_kode_customer','=',$array[$i])
                            ->get();
            array_push($saldo_push, $saldoawal);

            // return $saldoawal;

            $cust_arr = $array[$i]['customer'];

            $terbayar = DB::select("select sum(kwitansi.k_jumlah) as terbayar from kwitansi where k_tanggal > '$tglawal' and k_tanggal < '$tglakhir' and k_kode_customer = '$cust_arr' and  k_jenis_pembayaran != 'F' and k_jenis_pembayaran != 'U' and k_jenis_pembayaran != 'C' group by k_kode_customer");
            array_push($terbayar_push, $terbayar);

            $terbayar_posting = DB::select("select sum(posting_pembayaran.jumlah) as terbayar_posting from posting_pembayaran,posting_pembayaran_d where tanggal > '$tglawal' and tanggal < '$tglakhir' and kode_customer = '$cust_arr' group by kode_customer");

            array_push($terbayar_posting_push, $terbayar_posting);

            if ($terbayar == null) {
                $terbayar_push = 0;
            }

            if ($terbayar_push == null) {
                $terbayar_kwi[$i] = 0;
            }else{
                $terbayar_kwi[$i] = $terbayar_push[$i][0]->terbayar;
            }

            if ($terbayar_posting == null) {
                $terbayar_post[$i] = 0;
            }else{
                $terbayar_post[$i] = $terbayar_posting_push[$i][0]->terbayar_posting;
            }

            // return $terbayar_posting_push;
            $terbayar_fix[$i] = $terbayar_kwi[$i] + $terbayar_post[$i];


            $ss[$i] = ($saldo_push[$i][0]->saldoawal - $terbayar_fix[$i]);
            $sisa_saldo[$i] = ($saldo_push[$i][0]->saldoawal - $ss[$i]);


            $date_now =  strtotime ( $tglakhir );
            $date_now_g = date('Y-m-j' , $date_now);

            $sebelum_jatuhtempo = DB::table('invoice')
                            ->select(DB::raw('SUM(i_total_tagihan) as sebelum_jatuhtempo'))
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->where('i_kode_customer','=',$array[$i])
                            ->where('i_jatuh_tempo','>',$date_now_g)
                            ->get();

            array_push($sebelum_jatuhtempo_push, $sebelum_jatuhtempo);

            if ($sebelum_jatuhtempo[$i]->sebelum_jatuhtempo == null) {
                $sebelum_jatuhtempo[$i] = 0;
            }else{
                $sebelum_jatuhtempo[$i] = $sebelum_jatuhtempo_push[$i][0]->sebelum_jatuhtempo;
            }

            if ($sebelum_jatuhtempo[$i] == 0) {
                 $sebelum_jatuhtempo_fix[$i] = 0;
            }else{
                $sebelum_jatuhtempo_fix[$i] = $sebelum_jatuhtempo[$i] -  $terbayar_fix[$i];
            }
            
            $sebelum_jatuhtempo_hasil[$i] = ($saldo_push[$i][0]->saldoawal - $terbayar_kwi[$i]);  

            $date_30 = strtotime ( '+30 day' , strtotime ( $tglakhir ));
            $date_30_g = date('Y-m-j' , $date_30);
            for ($u=0; $u <count($tgl_jthtempo_now_push[$i]) ; $u++) { 
                $jatuhtempo_30 = DB::table('invoice')
                            ->select(DB::raw('SUM(i_total_tagihan) as jatuhtempo_30'))
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->where('i_jatuh_tempo','>',$tgl_jthtempo_now_push[$i][$u]->i_jatuh_tempo)
                            ->where('i_jatuh_tempo','<',$date_30_g)
                            ->where('i_kode_customer','=',$array[$i])
                            ->get();
                array_push($jatuhtempo_30_push, $jatuhtempo_30);
            }
            // return $jatuhtempo_30;
            if ($jatuhtempo_30[$i]->jatuhtempo_30 == null) {
                $jatuhtempo_30[$i] = 0;
            }else{
                $jatuhtempo_30[$i] = $jatuhtempo_30_push[$i][0]->jatuhtempo_30;
            }

            if ($jatuhtempo_30[$i] == 0) {
                 $jatuhtempo_30_fix[$i] = 0;
            }else{
                $jatuhtempo_30_fix[$i] = $jatuhtempo_30[$i] -  $terbayar_fix[$i];
            }
            
            $jatuhtempo_30_hasil[$i] = ($saldo_push[$i][0]->saldoawal - $terbayar_kwi[$i]);  
            
            //60 hari
            $date_60 = strtotime ( '+60 day' , strtotime ( $tglakhir ));
            $date_60_g = date('Y-m-j' , $date_60);
            $jatuhtempo_60 = DB::table('invoice')
                            ->select(DB::raw('SUM(i_total_tagihan) as jatuhtempo_60'))
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->whereBetween('i_jatuh_tempo',[$date_30_g,$date_60_g])
                            ->where('i_kode_customer','=',$array[$i])
                            ->get();
            array_push($jatuhtempo_60_push, $jatuhtempo_60);


            $date_90 = strtotime ( '+90 day' , strtotime ( $tglakhir ));
            $date_90_g = date('Y-m-j' , $date_90);
            $jatuhtempo_90 = DB::table('invoice')
                            ->select(DB::raw('SUM(i_total_tagihan) as jatuhtempo_90'))
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->whereBetween('i_jatuh_tempo',[$date_60_g,$date_90_g])
                            ->where('i_kode_customer','=',$array[$i])
                            ->get();
            array_push($jatuhtempo_90_push, $jatuhtempo_90);

            $date_120 = strtotime ( '+120 day' , strtotime ( $tglakhir ));
            $date_120_g = date('Y-m-j' , $date_120);


            $jatuhtempo_120 = DB::table('invoice')
                            ->select(DB::raw('SUM(i_total_tagihan) as jatuhtempo_120'))
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->whereBetween('i_jatuh_tempo',[$date_90_g,$date_120_g])
                            ->where('i_kode_customer','=',$array[$i])
                            ->get();
            array_push($jatuhtempo_120_push, $jatuhtempo_120);

            $date_180 = strtotime ( '+180 day' , strtotime ( $tglakhir ));
            $date_180_g = date('Y-m-j' , $date_180);

            $jatuhtempo_180 = DB::table('invoice')
                            ->select(DB::raw('SUM(i_total_tagihan) as jatuhtempo_180'))
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->whereBetween('i_jatuh_tempo',[$date_120_g,$date_180_g])
                            ->where('i_kode_customer','=',$array[$i])
                            ->get();
            array_push($jatuhtempo_180_push, $jatuhtempo_180);
            
            $date_360 = strtotime ( '+360 day' , strtotime ( $tglakhir ));
            $date_360_g = date('Y-m-j' , $date_360);

            $jatuhtempo_360 = DB::table('invoice')
                            ->select(DB::raw('SUM(i_total_tagihan) as jatuhtempo_360'))
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->whereBetween('i_jatuh_tempo',[$date_180_g,$date_360_g])
                            ->where('i_kode_customer','=',$array[$i])
                            ->get();
            array_push($jatuhtempo_360_push, $jatuhtempo_360);

            $jatuhtempo_lebih360 = DB::table('invoice')
                            ->select(DB::raw('SUM(i_total_tagihan) as jatuhtempo_lebih360'))
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->where('i_jatuh_tempo','>',$date_360_g)
                            ->where('i_kode_customer','=',$array[$i])
                            ->get();
            array_push($jatuhtempo_lebih360_push, $jatuhtempo_lebih360);


        }
            // return $jatuhtempo_30_push;
        // return $sisa_saldo;
        // return $ss;

        // $sebelum_jatuhtempo_push;    
        
        // [$terbayar_push,$saldo_push,$ss,$sebelum_jatuhtempo_push,$jatuhtempo_30_push,$jatuhtempo_60_push,$jatuhtempo_90_push,$jatuhtempo_120_push,$jatuhtempo_180_push,$jatuhtempo_360_push,$tgl_jthtempo_now_push];

        return view('purchase/master/master_penjualan/laporan/lap_analisa_piutang/ajax_analisapiutang_rekap',compact('array','saldo_push','terbayar_push','ss','sebelum_jatuhtempo_push','jatuhtempo_30_push','jatuhtempo_60_push','jatuhtempo_90_push','jatuhtempo_120_push','jatuhtempo_180_push','jatuhtempo_360_push','jatuhtempo_lebih360_push','tgl_jthtempo_now_push','sisa_saldo','sebelum_jatuhtempo_fix'));
    }

}
