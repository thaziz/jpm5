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
        $cabang   = DB::select(" SELECT kode,nama FROM cabang ORDER BY kode ASC ");

        return view('purchase/master/master_penjualan/laporan/lap_analisa_piutang/lap_analisapiutang',compact('customer','piutang','cabang'));
    }

    public function piutang_dropdown(Request $req)
    {
        $piutang  = DB::table('d_akun')
                      ->select('id_akun','nama_akun')
                      ->where('id_akun','like','13%')
                      ->where('kode_cabang',$req->cabang)
                      ->orderBy('id_akun','ASC')
                      ->get();
        return response()->json(['piutang'=>$piutang]);           
    }

    public function ajax_lap_analisa_piutang(Request $req) {
        $invoice_0       = [];
        $invoice_0_30    = [];
        $invoice_31_60   = [];
        $invoice_61_90   = [];
        $invoice_91_120  = [];
        $invoice_121_180 = [];
        $invoice_181_360 = [];
        $invoice_360     = [];
        $umur            = [];
        $total_invoice         = 0;
        $total_terbayar        = 0;
        $total_sisa_saldo      = 0;
        $total_umur            = 0;
        $total_invoice_0       = 0;
        $total_invoice_0_30    = 0;
        $total_invoice_31_60   = 0;
        $total_invoice_61_90   = 0;
        $total_invoice_91_120  = 0;
        $total_invoice_121_180 = 0;
        $total_invoice_181_360 = 0;
        $total_invoice_360     = 0;

        if ($req->customer != null) {
            $customer = 'and i_kode_customer = '."'$req->customer'";
        }else{
            $customer = '';
        }

        if ($req->cabang != null) {
            $cabang = 'and i_kode_cabang = '."'$req->cabang'";
        }else{
            $cabang = '';
        }

        if ($req->akun != null) {
            $akun = 'and i_acc_piutang = '."'$req->akun'";
        }else{
            $akun = '';
        }
        $sql = "SELECT * FROM invoice 
                where i_nomor != '0' 
                $akun $customer $cabang
                ORDER BY i_nomor ASC";
        $invoice   = DB::select($sql);

        // dd($invoice);
        $invoice_temp = $invoice;
        for ($i=0; $i < count($invoice_temp); $i++) { 
            if ($invoice_temp[$i]->i_jatuh_tempo_tt != null) {
                if (carbon::parse($invoice_temp[$i]->i_jatuh_tempo_tt)->toDateTimeString() < carbon::parse($req->min)->toDateTimeString()) {
                    if (carbon::parse($invoice_temp[$i]->i_jatuh_tempo_tt)->toDateTimeString() > carbon::parse($req->max)->toDateTimeString()) {
                        unset($invoice[$i]);
                    }
                }else{
                    unset($invoice[$i]);
                }
            }elseif ($invoice_temp[$i]->i_jatuh_tempo_tt == null){
                if (carbon::parse($req->min)->toDateTimeString() <  carbon::parse($invoice_temp[$i]->i_tanggal)->toDateTimeString()) {
                    if (carbon::parse($invoice_temp[$i]->i_tanggal)->toDateTimeString() > carbon::parse($req->max)->toDateTimeString()) {
                        unset($invoice[$i]);
                    }
                }else{
                    unset($invoice[$i]);
                }
            }
        }

        $invoice = array_values($invoice);
        

        // MENCARI PIUTANG AWAL BERDASARKAN KWITANSI DAN POSTING
        $kwitansi_tambah = [];
        for ($i=0; $i < count($invoice); $i++) { 
            $kwitansi = DB::table('kwitansi_d')
                      ->select('kd_total_bayar as total','k_tanggal as tanggal')
                      ->join('kwitansi','kd_id','=','k_id')
                      ->where('kd_nomor_invoice',$invoice[$i]->i_nomor)
                      ->where('k_jenis_pembayaran','!=','F')
                      ->get();

            for ($a=0; $a < count($kwitansi); $a++) { 
                if (carbon::parse($req->min)->toDateTimeString() <  carbon::parse($kwitansi[$a]->tanggal)->toDateTimeString()) {
                    if (carbon::parse($kwitansi[$a]->tanggal)->toDateTimeString() > carbon::parse($req->max)->toDateTimeString()) {
                        $invoice[$i]->i_sisa_akhir += $kwitansi[$a]->total;
                    }
                }else{
                    $invoice[$i]->i_sisa_akhir += $kwitansi[$a]->total;
                }
            }


            $posting = DB::table('kwitansi_d')
                          ->select('kd_total_bayar as total','k_tgl_posting as tanggal')
                          ->join('kwitansi','kd_id','=','k_id')
                          ->where('kd_nomor_invoice',$invoice[$i]->i_nomor)
                          ->where('k_jenis_pembayaran','=','F')
                          ->get();
            for ($a=0; $a < count($posting); $a++) { 
                if (carbon::parse($req->min)->toDateTimeString() <  carbon::parse($posting[$a]->tanggal)->toDateTimeString()) {
                    if (carbon::parse($posting[$a]->tanggal)->toDateTimeString() > carbon::parse($req->max)->toDateTimeString()) {

                        $invoice[$i]->i_sisa_akhir += $posting[$a]->total;
                    }
                }else{
                    $invoice[$i]->i_sisa_akhir += $posting[$a]->total;
                }
            }
            if ($invoice[$i]->i_jatuh_tempo_tt != null) {
                $tanggal_jatuh_tempo = strtotime($req->max) - strtotime($invoice[$i]->i_jatuh_tempo_tt);
                $tanggal_jatuh_tempo = $tanggal_jatuh_tempo/86400;
                array_push($umur,$tanggal_jatuh_tempo);
                if ($tanggal_jatuh_tempo < 0) {
                    array_push($invoice_0,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,0);
                    array_push($invoice_121_180,0);
                    array_push($invoice_181_360,0);
                    array_push($invoice_360,0);
                }elseif ($tanggal_jatuh_tempo >= 0 and $tanggal_jatuh_tempo <= 30){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,0);
                    array_push($invoice_121_180,0);
                    array_push($invoice_181_360,0);
                    array_push($invoice_360,0);
                }elseif ($tanggal_jatuh_tempo >= 31 and $tanggal_jatuh_tempo >= 60){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,0);
                    array_push($invoice_121_180,0);
                    array_push($invoice_181_360,0);
                    array_push($invoice_360,0);
                }elseif ($tanggal_jatuh_tempo >= 61 and $tanggal_jatuh_tempo >= 90){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_91_120,0);
                    array_push($invoice_121_180,0);
                    array_push($invoice_181_360,0);
                    array_push($invoice_360,0);
                }elseif ($tanggal_jatuh_tempo >= 91 and $tanggal_jatuh_tempo >= 120){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_121_180,0);
                    array_push($invoice_181_360,0);
                    array_push($invoice_360,0);
                }elseif ($tanggal_jatuh_tempo >= 121 and $tanggal_jatuh_tempo >= 180){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,0);
                    array_push($invoice_121_180,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_181_360,0);
                    array_push($invoice_360,0);
                }elseif ($tanggal_jatuh_tempo >= 181 and $tanggal_jatuh_tempo >= 360){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,0);
                    array_push($invoice_121_180,0);
                    array_push($invoice_181_360,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_360,0);
                }elseif ($tanggal_jatuh_tempo >= 360){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,0);
                    array_push($invoice_121_180,0);
                    array_push($invoice_181_360,0);
                    array_push($invoice_360,$invoice[$i]->i_sisa_akhir);
                }
            }elseif ($invoice[$i]->i_jatuh_tempo_tt == null){
                $tanggal_jatuh_tempo = strtotime($req->max) - strtotime($invoice[$i]->i_jatuh_tempo);
                $tanggal_jatuh_tempo = $tanggal_jatuh_tempo/86400;
                array_push($umur,$tanggal_jatuh_tempo);
                if ($tanggal_jatuh_tempo < 0) {
                    array_push($invoice_0,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,0);
                    array_push($invoice_121_180,0);
                    array_push($invoice_181_360,0);
                    array_push($invoice_360,0);
                }elseif ($tanggal_jatuh_tempo >= 0 and $tanggal_jatuh_tempo <= 30){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,0);
                    array_push($invoice_121_180,0);
                    array_push($invoice_181_360,0);
                    array_push($invoice_360,0);
                }elseif ($tanggal_jatuh_tempo >= 31 and $tanggal_jatuh_tempo <= 60){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,0);
                    array_push($invoice_121_180,0);
                    array_push($invoice_181_360,0);
                    array_push($invoice_360,0);
                }elseif ($tanggal_jatuh_tempo >= 61 and $tanggal_jatuh_tempo <= 90){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_91_120,0);
                    array_push($invoice_121_180,0);
                    array_push($invoice_181_360,0);
                    array_push($invoice_360,0);
                }elseif ($tanggal_jatuh_tempo >= 91 and $tanggal_jatuh_tempo <= 120){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_121_180,0);
                    array_push($invoice_181_360,0);
                    array_push($invoice_360,0);
                }elseif ($tanggal_jatuh_tempo >= 121 and $tanggal_jatuh_tempo <= 180){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,0);
                    array_push($invoice_121_180,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_181_360,0);
                    array_push($invoice_360,0);
                }elseif ($tanggal_jatuh_tempo >= 181 and $tanggal_jatuh_tempo <= 360){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,0);
                    array_push($invoice_121_180,0);
                    array_push($invoice_181_360,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_360,0);
                }elseif ($tanggal_jatuh_tempo >= 360){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,0);
                    array_push($invoice_121_180,0);
                    array_push($invoice_181_360,0);
                    array_push($invoice_360,$invoice[$i]->i_sisa_akhir);
                }else{
                    dd($tanggal_jatuh_tempo);
                }
            }
        }

        for ($i=0; $i < count($invoice); $i++) { 
            $total_invoice += $invoice[$i]->i_total_tagihan;
            $temp = $invoice[$i]->i_total_tagihan - $invoice[$i]->i_sisa_akhir;
            $total_terbayar += $temp;
            $total_sisa_saldo += $invoice[$i]->i_sisa_akhir;
            $total_umur += $umur[$i];
            $total_invoice_0 += $invoice_0[$i];
            $total_invoice_0_30 += $invoice_0_30[$i];
            $total_invoice_31_60 += $invoice_31_60[$i];
            $total_invoice_61_90 += $invoice_61_90[$i];
            $total_invoice_91_120 += $invoice_91_120[$i];
            $total_invoice_121_180 += $invoice_121_180[$i];
            $total_invoice_181_360 += $invoice_181_360[$i];
            $total_invoice_360 += $invoice_360[$i];
        }
        return view('purchase.master.master_penjualan.laporan.lap_analisa_piutang.ajax_analisapiutang_rekap',
                         compact('invoice',
                                 'invoice_0',
                                 'invoice_0_30',
                                 'invoice_31_60',
                                 'invoice_61_90',
                                 'invoice_91_120',
                                 'invoice_121_180',
                                 'invoice_181_360',
                                 'invoice_360',
                                 'umur',
                                 'total_invoice',
                                 'total_terbayar',
                                 'total_sisa_saldo',
                                 'total_umur',
                                 'total_invoice_0',
                                 'total_invoice_0_30',
                                 'total_invoice_31_60',
                                 'total_invoice_61_90',
                                 'total_invoice_91_120',
                                 'total_invoice_121_180',
                                 'total_invoice_181_360',
                                 'total_invoice_360'
                                ));
    }
}
