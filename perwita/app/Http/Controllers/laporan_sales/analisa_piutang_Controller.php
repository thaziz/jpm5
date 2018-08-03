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
        $customer  =  DB::select("SELECT i_kode_customer,i_nomor from invoice where i_tanggal BETWEEN '$tglawal' and '$tglakhir' order by i_kode_customer asc");
      
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
            //cust
            $cust_arr = $array[$i]['customer'];

            //tgl
            $tgl_jthtempo_now = DB::table('invoice')
                            ->select('i_jatuh_tempo')
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->where('i_kode_customer','=',$array[$i])
                            ->get();    
            array_push($tgl_jthtempo_now_push, $tgl_jthtempo_now);

            //saldo awal
            $saldoawal = DB::table('invoice')
                            ->select(DB::raw('SUM(i_total_tagihan) as saldoawal'))
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->where('i_kode_customer','=',$array[$i])
                            ->get();
            array_push($saldo_push, $saldoawal);

            //cari kwitansi
            $kwitansi_inv = DB::select("select k_nomor, sum(kwitansi.k_jumlah) as kwitansi_inv from kwitansi where k_tanggal > '$tglawal' and k_tanggal < '$tglakhir' and k_kode_customer = '$cust_arr' and  k_jenis_pembayaran != 'F' and k_jenis_pembayaran != 'U' and k_jenis_pembayaran != 'C' group by k_kode_customer,k_nomor");

            //kwitansi + posting bayar
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

            $terbayar_fix[$i] = $terbayar_kwi[$i] + $terbayar_post[$i];
            $ss[$i] = ($saldo_push[$i][0]->saldoawal - $terbayar_fix[$i]);
            $sisa_saldo[$i] = ($saldo_push[$i][0]->saldoawal - $ss[$i]);

            //end of


            // return $kwitansi_inv;
            // return $customer;

            //======================= Sebelum 
            $date_now =  strtotime ( $tglakhir );
            $date_now_g = date('Y-m-j' , $date_now);

            for ($g=0; $g <count($customer) ; $g++) { 
                $inv_sjt = $customer[$g]->i_nomor;
                

                $sebelum_jatuhtempo = DB::table('invoice')
                            ->select(DB::raw('SUM(i_total_tagihan) as sebelum_jatuhtempo'))
                            ->where('i_tanggal','>',$tglawal)
                            ->where('i_tanggal','<',$tglakhir)
                            ->where('i_nomor','=',$inv_sjt)
                            ->where('i_kode_customer','=',$array[$i])
                            ->where('i_jatuh_tempo','>',$date_now_g)
                            ->get();

                $sebelum_jatuhtempo_kw =  DB::select("select sum(kwitansi.k_jumlah) as jatuhtempo_30_kw from kwitansi,kwitansi_d where kd_nomor_invoice = '$inv_sjt' and k_tanggal > '$tglawal' and k_tanggal < '$tglakhir' and k_kode_customer = '$cust_arr' and  kwitansi.k_jenis_pembayaran != 'C'  group by k_kode_customer");
                
                $kwitansi_kode =  DB::select("select k_nomor from kwitansi,kwitansi_d where kd_nomor_invoice = '$inv_sjt' and k_tanggal > '$tglawal' and k_tanggal < '$tglakhir' and k_kode_customer = '$cust_arr' and  k_jenis_pembayaran != 'F' and k_jenis_pembayaran != 'U' and k_jenis_pembayaran != 'C'");

                $sebelum_jatuhtempo_pst = DB::select("select sum(posting_pembayaran.jumlah) as terbayar_posting from posting_pembayaran,posting_pembayaran_d where tanggal > '$tglawal' and tanggal < '$tglakhir' and kode_customer = '$cust_arr' group by kode_customer");
            }

            return $sebelum_jatuhtempo_kw;
            // sebelum jth tempo Invoice
            if ($sebelum_jatuhtempo[$i]->sebelum_jatuhtempo == null) {
                $sebelum_jatuhtempo[$i] = 0;
            }else{
                $sebelum_jatuhtempo[$i] = $sebelum_jatuhtempo[$i]->sebelum_jatuhtempo;
            }
            //sebelum jth tempo kwitansi
            if ($sebelum_jatuhtempo_kw == null) {
                $sebelum_jatuhtempo_kw = 0;
            }else{
                $sebelum_jatuhtempo_kw = $sebelum_jatuhtempo_kw[$i]->jatuhtempo_30_kw;
            }

            $sebelum_jatuhtempo_hasil[$i] = ($sebelum_jatuhtempo[$i]-$sebelum_jatuhtempo_kw);  
            // return [$sebelum_jatuhtempo[$i], $sebelum_jatuhtempo_kw];
            // return [$sebelum_jatuhtempo_hasil,$sebelum_jatuhtempo,$sebelum_jatuhtempo_kw];
            //================================ end sebelum







            //================================ 0 - 30 hari
            $date_30 = strtotime ( '+30 day' , strtotime ( $tglakhir ));
            $date_30_g = date('Y-m-j' , $date_30);
            for ($g=0; $g <count($customer) ; $g++) { 
                $cust_30[$g] = $customer[$g]->i_nomor;
                $jatuhtempo_30 = DB::table('invoice')
                        ->select(DB::raw('SUM(i_total_tagihan) as jatuhtempo_30'))
                        ->where('i_tanggal','>',$tglawal)
                        ->where('i_tanggal','<',$tglakhir)
                        ->where('i_nomor','=',$cust_30[$g])
                        ->where('i_jatuh_tempo','>',$tgl_jthtempo_now_push[0][$i]->i_jatuh_tempo)
                        ->where('i_jatuh_tempo','<',$date_30_g)
                        ->where('i_kode_customer','=',$array[$i])
                        ->get();
                $jatuhtempo_30_kw =  DB::select("select sum(kwitansi.k_jumlah) as jatuhtempo_30_kw from kwitansi where k_tanggal > '$tglawal' and k_tanggal < '$tglakhir' and k_kode_customer = '$cust_arr' and  k_jenis_pembayaran != 'F' and k_jenis_pembayaran != 'U' and k_jenis_pembayaran != 'C' and k_nomor = '$cust_30[$g]'  group by k_kode_customer");
            }
            

            array_push($jatuhtempo_30_push, $jatuhtempo_30);
            
            // return $jatuhtempo_30;
            if ($jatuhtempo_30[$i]->jatuhtempo_30 == null) {
                $jatuhtempo_30[$i] = 0;
            }else{
                $jatuhtempo_30[$i] = $jatuhtempo_30_push[$i][0]->jatuhtempo_30;
            }

            if ($jatuhtempo_30[$i] == 0) {
                $jatuhtempo_30_hasil[$i] = 0;
            }else{
                $jatuhtempo_30_hasil[$i] = $jatuhtempo_30[$i] - $sisa_saldo[$i];
            }   

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
            // return $jatuhtempo_60;
            if ($jatuhtempo_60[$i]->jatuhtempo_60 == null) {
                $jatuhtempo_60[$i] = 0;
            }else{
                $jatuhtempo_60[$i] = $jatuhtempo_60_push[$i][0]->jatuhtempo_60;
            }

            if ($jatuhtempo_60[$i] == 0) {
                $jatuhtempo_60_hasil[$i] = 0;
            }else{
                $jatuhtempo_60_hasil[$i] = $jatuhtempo_60[$i] - $sisa_saldo[$i];
            }


            //90 hari
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
            // return $jatuhtempo_90;
            if ($jatuhtempo_90[$i]->jatuhtempo_90 == null) {
                $jatuhtempo_90[$i] = 0;
            }else{
                $jatuhtempo_90[$i] = $jatuhtempo_90_push[$i][0]->jatuhtempo_90;
            }

            if ($jatuhtempo_90[$i] == 0) {
                $jatuhtempo_90_hasil[$i] = 0;
            }else{
                $jatuhtempo_90_hasil[$i] = $jatuhtempo_90[$i] - $sisa_saldo[$i];
            }
            // return $jatuhtempo_90_hasil;



            


            //120 hari
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

            //180 hari
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
            
            //360 hari
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

            //lebih hari 360
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

        return view('purchase/master/master_penjualan/laporan/lap_analisa_piutang/ajax_analisapiutang_rekap',compact('array','saldo_push','terbayar_push','ss','sebelum_jatuhtempo_push','jatuhtempo_30_push','jatuhtempo_60_hasil','jatuhtempo_90_push','jatuhtempo_120_push','jatuhtempo_180_push','jatuhtempo_360_push','jatuhtempo_lebih360_push','tgl_jthtempo_now_push','sisa_saldo','sebelum_jatuhtempo_hasil','jatuhtempo_30_hasil'));
    }

}
