<?php

namespace App\Http\Controllers\laporan_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Carbon\carbon;
use Auth;
class analisa_piutang_Controller extends Controller
{
    public function index(){
        $customer      = DB::select(" SELECT kode,nama FROM customer ORDER BY nama ASC ");
        $cabang        = DB::select(" SELECT kode,nama FROM cabang ORDER BY kode ASC ");
        $minr          = carbon::now()->startOfMonth()->format('Y-m-d');
        $maxr          = carbon::now()->now()->format('Y-m-d');
        $customerr     = carbon::now()->now()->format('Y-m-d');
        $jenis = 'all';
        $akunr = 'all';
        $cabangr = 'all';
        if (Auth::user()->punyaAkses('Laporan Penjualan','cabang')) {
            $piutang  = DB::table('d_akun')
                      ->select('id_akun','nama_akun')
                      ->where('id_akun','like','13%')
                      ->orderBy('id_akun','ASC')
                      ->get();
        }else{
            $piutang  = DB::table('d_akun')
                      ->select('id_akun','nama_akun')
                      ->where('id_akun','like','13%')
                      ->where('kode_cabang',Auth::user()->kode_cabang)
                      ->orderBy('id_akun','ASC')
                      ->get();
        }
        
        return view('purchase/master/master_penjualan/laporan/lap_analisa_piutang/analisa_piutang',compact('customer','piutang','cabang','jenis','minr','maxr','customerr','akunr','cabangr'));
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

    public function ajax_lap_analisa_piutang(Request $req) 
    {
        if ($req->laporan == 'hirarki') {
            return $this->hirarki($req);
        }elseif ($req->laporan == 'invoice'){
            return $this->invoice($req);
        }
    }

    function hirarki($req)
    {

        $invoice_0             = [];
        $invoice_0_30          = [];
        $invoice_31_60         = [];
        $invoice_61_90         = [];
        $invoice_91_120        = [];
        $invoice_121_180       = [];
        $invoice_181_360       = [];
        $invoice_120           = [];
        $umur                  = [];
        $total_invoice         = [];
        $total_terbayar        = [];
        $total_sisa_saldo      = [];
        $total_umur            = [];
        $total_invoice_0       = [];
        $total_invoice_0_30    = [];
        $total_invoice_31_60   = [];
        $total_invoice_61_90   = [];
        $total_invoice_91_120  = [];
        $total_invoice_120     = [];
        $laporan               = $req->laporan;
        $cab                   = [];
        $cab_nama              = [];
        $akun                  = [];
        $akun_nama             = [];
        $customer              = [];
        $customer_nama         = [];
        $invoice               = [];
        if ($req->customer != 'all') {
            $customer1 = 'and i_kode_customer = '."'$req->customer'";
        }else{
            $customer1 = '';
        }

        if ($req->cabang != 'all') {
            $cabang1 = 'and kode = '."'$req->cabang'";
        }else{
            $cabang1 = '';
        }

        if ($req->akun != 'all') {
            $akun1 = 'and i_acc_piutang = '."'$req->akun'";
        }else{
            $akun1 = '';
        }

        $cabang2 = DB::table('invoice')
                ->join('cabang','i_kode_cabang','=','kode')
                ->whereRaw("i_nomor != '0' $cabang1")
                ->orderBy('kode','ASC')
                ->get();

        $cab_temp = $cabang2;
        for ($i=0; $i < count($cab_temp); $i++) { 
            if ($cab_temp[$i]->i_tanggal_tanda_terima != null) {
                if (strtotime($req->min)/86400 < strtotime($cab_temp[$i]->i_tanggal_tanda_terima)/86400) {
                    if (strtotime($cab_temp[$i]->i_tanggal_tanda_terima)/86400 > strtotime($req->max)/86400) {
                        unset($cabang2[$i]);
                    }
                }else{
                    unset($cabang2[$i]);
                }
            }elseif ($cab_temp[$i]->i_tanggal_tanda_terima == null){
                if (strtotime($req->min)/86400 <  strtotime($cab_temp[$i]->i_tanggal)/86400) {
                    if (strtotime($cab_temp[$i]->i_tanggal)/86400 > strtotime($req->max)/86400) 
                    {
                        unset($cabang2[$i]);
                    }
                }else{
                    unset($cabang2[$i]);
                }
            }
        }
        $cabang2 = array_values($cabang2);
        $cab = [];
        for ($i=0; $i < count($cabang2); $i++) { 
            $cab[$i] = $cabang2[$i]->kode;
            $cab_nama[$i] = $cabang2[$i]->nama;
        }

        $cab = array_unique($cab);
        $cab = array_values($cab);

        $cab_nama = array_unique($cab_nama);
        $cab_nama = array_values($cab_nama);

        for ($i=0; $i < count($cab); $i++) { 
            // AKUN
            if(!isset($invoice_0[$i])){
                $invoice_0[$i]             = array();
                $invoice_0_30[$i]          = array();
                $invoice_31_60[$i]         = array();
                $invoice_61_90[$i]         = array();
                $invoice_91_120[$i]        = array();
                $invoice_121_180[$i]       = array();
                $invoice_181_360[$i]       = array();
                $invoice_120[$i]           = array();
                $umur[$i]                  = array();
                $total_invoice[$i]         = array();
                $total_terbayar[$i]        = array();
                $total_sisa_saldo[$i]      = array();
                $total_umur[$i]            = array();
                $total_invoice_0[$i]       = array();
                $total_invoice_0_30[$i]    = array();
                $total_invoice_31_60[$i]   = array();
                $total_invoice_61_90[$i]   = array();
                $total_invoice_91_120[$i]  = array();
                $total_invoice_120[$i]     = array();
            }
            $cabangs = $cab[$i];
            $akun2[$i] = DB::table('invoice')
                        ->join('d_akun','id_akun','=','i_acc_piutang')
                        ->whereRaw("i_nomor != '0' and i_kode_cabang = '$cabangs' $akun1")
                        ->get();

            $akun_temp = $akun2[$i];

            for ($a=0; $a < count($akun_temp); $a++) { 
                if ($akun_temp[$a]->i_tanggal_tanda_terima != null) {
                    if (strtotime($req->min)/86400 < strtotime($akun_temp[$a]->i_tanggal_tanda_terima)/86400) {
                        if (strtotime($akun_temp[$a]->i_tanggal_tanda_terima)/86400 > strtotime($req->max)/86400) {
                            unset($akun2[$i][$a]);
                        }
                    }else{
                        unset($akun2[$i][$a]);
                    }
                }elseif ($akun_temp[$a]->i_tanggal_tanda_terima == null){
                    if (strtotime($req->min)/86400 <  strtotime($akun_temp[$a]->i_tanggal)/86400) {
                        if (strtotime($akun_temp[$a]->i_tanggal)/86400 > strtotime($req->max)/86400) 
                        {
                            unset($akun2[$i][$a]);
                        }
                    }else{
                        unset($akun2[$i][$a]);
                    }
                }
            }

            $akun2[$i] = array_values($akun2[$i]);

            for ($a=0; $a < count($akun2[$i]); $a++) { 
                $akun[$i][$a] = $akun2[$i][$a]->i_acc_piutang;
                $akun_nama[$i][$a] = $akun2[$i][$a]->nama_akun;
            }
            
            // CUSTOMER
            if (isset($akun[$i])) {
                $akun[$i] = array_unique($akun[$i]);
                $akun[$i] = array_values($akun[$i]);

                $akun_nama[$i] = array_unique($akun_nama[$i]);
                $akun_nama[$i] = array_values($akun_nama[$i]);

                for ($a=0; $a < count($akun[$i]); $a++) { 

                    if(!isset($invoice_0[$i][$a])){
                        $invoice_0[$i][$a]             = array();
                        $invoice_0_30[$i][$a]          = array();
                        $invoice_31_60[$i][$a]         = array();
                        $invoice_61_90[$i][$a]         = array();
                        $invoice_91_120[$i][$a]        = array();
                        $invoice_121_180[$i][$a]       = array();
                        $invoice_181_360[$i][$a]       = array();
                        $invoice_120[$i][$a]           = array();
                        $umur[$i][$a]                  = array();
                        $total_invoice[$i][$a]         = array();
                        $total_terbayar[$i][$a]        = array();
                        $total_sisa_saldo[$i][$a]      = array();
                        $total_umur[$i][$a]            = array();
                        $total_invoice_0[$i][$a]       = array();
                        $total_invoice_0_30[$i][$a]    = array();
                        $total_invoice_31_60[$i][$a]   = array();
                        $total_invoice_61_90[$i][$a]   = array();
                        $total_invoice_91_120[$i][$a]  = array();
                        $total_invoice_120[$i][$a]     = array();
                    }

                    $akuns = $akun[$i][$a];
                    $customer2[$i][$a] = DB::table('invoice')
                                        ->join('customer','kode','=','i_kode_customer')
                                        ->whereRaw("i_nomor != '0' and i_kode_cabang = '$cabangs' and i_acc_piutang = '$akuns' $customer1")
                                        ->get();

                    $customer_temp = $customer2[$i][$a];

                    for ($c=0; $c < count($customer_temp); $c++) { 
                        if ($customer_temp[$c]->i_tanggal_tanda_terima != null) {
                            if (strtotime($req->min)/86400 < strtotime($customer_temp[$c]->i_tanggal_tanda_terima)/86400) {
                                if (strtotime($customer_temp[$c]->i_tanggal_tanda_terima)/86400 > strtotime($req->max)/86400) {
                                    unset($customer2[$i][$a][$c]);
                                }
                            }else{
                                unset($customer2[$i][$a][$c]);
                            }
                        }elseif ($customer_temp[$c]->i_tanggal_tanda_terima == null){
                            if (strtotime($req->min)/86400 <  strtotime($customer_temp[$c]->i_tanggal)/86400) {
                                if (strtotime($customer_temp[$c]->i_tanggal)/86400 > strtotime($req->max)/86400) 
                                {
                                    unset($customer2[$i][$a][$c]);
                                }
                            }else{
                                unset($customer2[$i][$a][$c]);
                            }
                        }
                    }

                    $customer2[$i][$a] = array_values($customer2[$i][$a]);

                    for ($c=0; $c < count($customer2[$i][$a]); $c++) { 
                        $customer[$i][$a][$c] = $customer2[$i][$a][$c]->i_kode_customer;
                        $customer_nama[$i][$a][$c] = $customer2[$i][$a][$c]->nama;
                    }

                    if (isset($customer[$i][$a])) {
                        $customer[$i][$a] = array_unique($customer[$i][$a]);
                        $customer[$i][$a] = array_values($customer[$i][$a]);

                        $customer_nama[$i][$a] = array_unique($customer_nama[$i][$a]);
                        $customer_nama[$i][$a] = array_values($customer_nama[$i][$a]);

                        // INVOICE
                        for ($e=0; $e < count($customer[$i][$a]); $e++) { 

                            if(!isset($invoice_0[$i][$a][$e])){
                                $invoice_0[$i][$a][$e]             = array();
                                $invoice_0_30[$i][$a][$e]          = array();
                                $invoice_31_60[$i][$a][$e]         = array();
                                $invoice_61_90[$i][$a][$e]         = array();
                                $invoice_91_120[$i][$a][$e]        = array();
                                $invoice_121_180[$i][$a][$e]       = array();
                                $invoice_181_360[$i][$a][$e]       = array();
                                $invoice_120[$i][$a][$e]           = array();
                                $umur[$i][$a][$e]                  = array();
                                $total_invoice[$i][$a][$e]         = 0;
                                $total_terbayar[$i][$a][$e]        = 0;
                                $total_sisa_saldo[$i][$a][$e]      = 0;
                                $total_umur[$i][$a][$e]            = 0;
                                $total_invoice_0[$i][$a][$e]       = 0;
                                $total_invoice_0_30[$i][$a][$e]    = 0;
                                $total_invoice_31_60[$i][$a][$e]   = 0;
                                $total_invoice_61_90[$i][$a][$e]   = 0;
                                $total_invoice_91_120[$i][$a][$e]  = 0;
                                $total_invoice_120[$i][$a][$e]     = 0;
                            }
                            $customers = $customer[$i][$a][$e];
                            $invoice2[$i][$a][$e] = DB::table('invoice')
                                                        ->whereRaw("i_nomor != '0' and i_kode_cabang = '$cabangs' and i_acc_piutang = '$akuns'  and i_kode_customer = '$customers'")
                                                        ->get();
                            $invoice_temp = $invoice2[$i][$a][$e];

                            for ($c=0; $c < count($invoice_temp); $c++) { 
                                if ($invoice_temp[$c]->i_tanggal_tanda_terima != null) {
                                    if (strtotime($req->min)/86400 < strtotime($invoice_temp[$c]->i_tanggal_tanda_terima)/86400) {
                                        if (strtotime($invoice_temp[$c]->i_tanggal_tanda_terima)/86400 > strtotime($req->max)/86400) {
                                            unset($invoice2[$i][$a][$e][$c]);
                                        }
                                    }else{
                                        unset($invoice2[$i][$a][$e][$c]);
                                    }
                                }elseif ($invoice_temp[$c]->i_tanggal_tanda_terima == null){
                                    if (strtotime($req->min)/86400 <  strtotime($invoice_temp[$c]->i_tanggal)/86400) {
                                        if (strtotime($invoice_temp[$c]->i_tanggal)/86400 > strtotime($req->max)/86400) 
                                        {
                                            unset($invoice2[$i][$a][$e][$c]);
                                        }
                                    }else{
                                        unset($invoice2[$i][$a][$e][$c]);
                                    }
                                }
                            }

                            $invoice[$i][$a][$e] = array_values($invoice2[$i][$a][$e]);

                            for ($f=0; $f < count($invoice[$i][$a][$e]); $f++) { 

                                if(!isset($invoice_0[$i][$a][$e][$f])){
                                    $invoice_0[$i][$a][$e][$f]             = array();
                                    $invoice_0_30[$i][$a][$e][$f]          = array();
                                    $invoice_31_60[$i][$a][$e][$f]         = array();
                                    $invoice_61_90[$i][$a][$e][$f]         = array();
                                    $invoice_91_120[$i][$a][$e][$f]        = array();
                                    $invoice_121_180[$i][$a][$e][$f]       = array();
                                    $invoice_181_360[$i][$a][$e][$f]       = array();
                                    $invoice_120[$i][$a][$e][$f]           = array();
                                    $umur[$i][$a][$e][$f]                  = array();
                                }
                                $i_nomor = $invoice[$i][$a][$e][$f]->i_nomor;
                                $kwitansi = DB::table('kwitansi_d')
                                              ->select('kd_total_bayar as total','k_tanggal as tanggal')
                                              ->join('kwitansi','kd_id','=','k_id')
                                              ->where('kd_nomor_invoice',$i_nomor)
                                              ->where('k_jenis_pembayaran','!=','F')
                                              ->where('k_jenis_pembayaran','!=','C')
                                              ->get();
                        
                                for ($c=0; $c < count($kwitansi); $c++) { 
                                    if (strtotime($req->min) <  strtotime($kwitansi[$c]->tanggal)) {
                                        if (strtotime($kwitansi[$c]->tanggal) > strtotime($req->max)) {
                                            $invoice[$i][$a][$e][$f]->i_sisa_akhir += $kwitansi[$c]->total;
                                        }
                                    }else{
                                        $invoice[$i][$a][$e][$f]->i_sisa_akhir += $kwitansi[$c]->total;
                                    }
                                }

                                $posting = DB::table('kwitansi_d')
                                              ->select('kd_total_bayar as total','k_tgl_posting as tanggal')
                                              ->join('kwitansi','kd_id','=','k_id')
                                              ->whereRaw("k_jenis_pembayaran = 'F' and kd_nomor_invoice = '$i_nomor'
                                                or k_jenis_pembayaran = 'C' and kd_nomor_invoice = '$i_nomor'")
                                              ->get();
                                for ($c=0; $c < count($posting); $c++) { 
                                    if (strtotime($req->min) <  strtotime($posting[$c]->tanggal)) {
                                        if (strtotime($posting[$c]->tanggal) > strtotime($req->max)) {

                                            $invoice[$i][$a][$e][$f]->i_sisa_akhir += $posting[$c]->total;
                                        }
                                    }else{
                                        $invoice[$i][$a][$e][$f]->i_sisa_akhir += $posting[$c]->total;
                                    }
                                }


                                if ($invoice[$i][$a][$e][$f]->i_jatuh_tempo_tt != null) {
                                    $tanggal_jatuh_tempo = strtotime($req->max) - strtotime($invoice[$i][$a][$e][$f]->i_jatuh_tempo_tt);
                                    $tanggal_jatuh_tempo = $tanggal_jatuh_tempo/86400;
                                    array_push($umur[$i][$a][$e][$f],$tanggal_jatuh_tempo);
                                    if ($tanggal_jatuh_tempo < 0) {
                                        array_push($invoice_0[$i][$a][$e][$f],$invoice[$i][$a][$e][$f]->i_sisa_akhir);
                                        array_push($invoice_0_30[$i][$a][$e][$f],0);
                                        array_push($invoice_31_60[$i][$a][$e][$f],0);
                                        array_push($invoice_61_90[$i][$a][$e][$f],0);
                                        array_push($invoice_91_120[$i][$a][$e][$f],0);
                                        array_push($invoice_120[$i][$a][$e][$f],0);
                                        
                                    }elseif ($tanggal_jatuh_tempo >= 0 and $tanggal_jatuh_tempo <= 30){
                                        array_push($invoice_0[$i][$a][$e][$f],0);
                                        array_push($invoice_0_30[$i][$a][$e][$f],$invoice[$i][$a][$e][$f]->i_sisa_akhir);
                                        array_push($invoice_31_60[$i][$a][$e][$f],0);
                                        array_push($invoice_61_90[$i][$a][$e][$f],0);
                                        array_push($invoice_91_120[$i][$a][$e][$f],0);
                                        array_push($invoice_120[$i][$a][$e][$f],0);
                                        
                                    }elseif ($tanggal_jatuh_tempo >= 31 and $tanggal_jatuh_tempo <= 60){
                                        array_push($invoice_0[$i][$a][$e][$f],0);
                                        array_push($invoice_0_30[$i][$a][$e][$f],0);
                                        array_push($invoice_31_60[$i][$a][$e][$f],$invoice[$i][$a][$e][$f]->i_sisa_akhir);
                                        array_push($invoice_61_90[$i][$a][$e][$f],0);
                                        array_push($invoice_91_120[$i][$a][$e][$f],0);
                                        array_push($invoice_120[$i][$a][$e][$f],0);
                                        
                                    }elseif ($tanggal_jatuh_tempo >= 61 and $tanggal_jatuh_tempo <= 90){
                                        array_push($invoice_0[$i][$a][$e][$f],0);
                                        array_push($invoice_0_30[$i][$a][$e][$f],0);
                                        array_push($invoice_31_60[$i][$a][$e][$f],0);
                                        array_push($invoice_61_90[$i][$a][$e][$f],$invoice[$i][$a][$e][$f]->i_sisa_akhir);
                                        array_push($invoice_91_120[$i][$a][$e][$f],0);
                                        array_push($invoice_120[$i][$a][$e][$f],0);
                                        
                                    }elseif ($tanggal_jatuh_tempo >= 91 and $tanggal_jatuh_tempo <= 120){
                                        array_push($invoice_0[$i][$a][$e][$f],0);
                                        array_push($invoice_0_30[$i][$a][$e][$f],0);
                                        array_push($invoice_31_60[$i][$a][$e][$f],0);
                                        array_push($invoice_61_90[$i][$a][$e][$f],0);
                                        array_push($invoice_91_120[$i][$a][$e][$f],$invoice[$i][$a][$e][$f]->i_sisa_akhir);
                                        array_push($invoice_120[$i][$a][$e][$f],0);
                                        
                                    }elseif ($tanggal_jatuh_tempo >= 121){
                                        array_push($invoice_0[$i][$a][$e][$f],0);
                                        array_push($invoice_0_30[$i][$a][$e][$f],0);
                                        array_push($invoice_31_60[$i][$a][$e][$f],0);
                                        array_push($invoice_61_90[$i][$a][$e][$f],0);
                                        array_push($invoice_91_120[$i][$a][$e][$f],0);
                                        array_push($invoice_120[$i][$a][$e][$f],$invoice[$i][$a][$e][$f]->i_sisa_akhir);
                                    }else{
                                        dd($tanggal_jatuh_tempo);
                                    }
                                }elseif ($invoice[$i][$a][$e][$f]->i_jatuh_tempo_tt == null){
                                    $tanggal_jatuh_tempo = strtotime($req->max) - strtotime($invoice[$i][$a][$e][$f]->i_jatuh_tempo);
                                    $tanggal_jatuh_tempo = $tanggal_jatuh_tempo/86400;
                                    array_push($umur[$i][$a][$e][$f],(string)$tanggal_jatuh_tempo);
                                    if ($tanggal_jatuh_tempo < 0) {
                                        array_push($invoice_0[$i][$a][$e][$f],$invoice[$i][$a][$e][$f]->i_sisa_akhir);
                                        array_push($invoice_0_30[$i][$a][$e][$f],0);
                                        array_push($invoice_31_60[$i][$a][$e][$f],0);
                                        array_push($invoice_61_90[$i][$a][$e][$f],0);
                                        array_push($invoice_91_120[$i][$a][$e][$f],0);
                                        array_push($invoice_120[$i][$a][$e][$f],0);
                                        
                                    }elseif ($tanggal_jatuh_tempo >= 0 and $tanggal_jatuh_tempo <= 30){
                                        array_push($invoice_0[$i][$a][$e][$f],0);
                                        array_push($invoice_0_30[$i][$a][$e][$f],$invoice[$i][$a][$e][$f]->i_sisa_akhir);
                                        array_push($invoice_31_60[$i][$a][$e][$f],0);
                                        array_push($invoice_61_90[$i][$a][$e][$f],0);
                                        array_push($invoice_91_120[$i][$a][$e][$f],0);
                                        array_push($invoice_120[$i][$a][$e][$f],0);
                                        
                                    }elseif ($tanggal_jatuh_tempo >= 31 and $tanggal_jatuh_tempo <= 60){
                                        array_push($invoice_0[$i][$a][$e][$f],0);
                                        array_push($invoice_0_30[$i][$a][$e][$f],0);
                                        array_push($invoice_31_60[$i][$a][$e][$f],$invoice[$i][$a][$e][$f]->i_sisa_akhir);
                                        array_push($invoice_61_90[$i][$a][$e][$f],0);
                                        array_push($invoice_91_120[$i][$a][$e][$f],0);
                                        array_push($invoice_120[$i][$a][$e][$f],0);
                                        
                                    }elseif ($tanggal_jatuh_tempo >= 61 and $tanggal_jatuh_tempo <= 90){
                                        array_push($invoice_0[$i][$a][$e][$f],0);
                                        array_push($invoice_0_30[$i][$a][$e][$f],0);
                                        array_push($invoice_31_60[$i][$a][$e][$f],0);
                                        array_push($invoice_61_90[$i][$a][$e][$f],$invoice[$i][$a][$e][$f]->i_sisa_akhir);
                                        array_push($invoice_91_120[$i][$a][$e][$f],0);
                                        array_push($invoice_120[$i][$a][$e][$f],0);
                                        
                                    }elseif ($tanggal_jatuh_tempo >= 91 and $tanggal_jatuh_tempo <= 120){
                                        array_push($invoice_0[$i][$a][$e][$f],0);
                                        array_push($invoice_0_30[$i][$a][$e][$f],0);
                                        array_push($invoice_31_60[$i][$a][$e][$f],0);
                                        array_push($invoice_61_90[$i][$a][$e][$f],0);
                                        array_push($invoice_91_120[$i][$a][$e][$f],$invoice[$i][$a][$e][$f]->i_sisa_akhir);
                                        array_push($invoice_120[$i][$a][$e][$f],0);
                                    }elseif ($tanggal_jatuh_tempo >= 121){
                                        array_push($invoice_0[$i][$a][$e][$f],0);
                                        array_push($invoice_0_30[$i][$a][$e][$f],0);
                                        array_push($invoice_31_60[$i][$a][$e][$f],0);
                                        array_push($invoice_61_90[$i][$a][$e][$f],0);
                                        array_push($invoice_91_120[$i][$a][$e][$f],0);
                                        array_push($invoice_120[$i][$a][$e][$f],$invoice[$i][$a][$e][$f]->i_sisa_akhir);
                                    }else{
                                        dd($tanggal_jatuh_tempo);
                                    }
                                }else{
                                    dd($invoice[$i][$a][$e][$f]);
                                }
                            }

                            for ($f=0; $f < count($invoice[$i][$a][$e]); $f++) { 
                                $total_invoice[$i][$a][$e] += $invoice[$i][$a][$e][$f]->i_total_tagihan;
                                $temp = $invoice[$i][$a][$e][$f]->i_total_tagihan + $invoice[$i][$a][$e][$f]->i_debet - $invoice[$i][$a][$e][$f]->i_kredit - $invoice[$i][$a][$e][$f]->i_sisa_akhir;
                                $total_terbayar[$i][$a][$e] += $temp;
                                $total_sisa_saldo[$i][$a][$e] += $invoice[$i][$a][$e][$f]->i_sisa_akhir;
                                $total_umur[$i][$a][$e] += $umur[$i][$a][$e][$f][0];
                                $total_invoice_0[$i][$a][$e] += $invoice_0[$i][$a][$e][$f][0];
                                $total_invoice_0_30[$i][$a][$e] += $invoice_0_30[$i][$a][$e][$f][0];
                                $total_invoice_31_60[$i][$a][$e] += $invoice_31_60[$i][$a][$e][$f][0];
                                $total_invoice_61_90[$i][$a][$e] += $invoice_61_90[$i][$a][$e][$f][0];
                                $total_invoice_91_120[$i][$a][$e] += $invoice_91_120[$i][$a][$e][$f][0];
                                $total_invoice_120[$i][$a][$e] += $invoice_120[$i][$a][$e][$f][0];
                            }
                        }
                    }
                }
            }
        }
        return view('purchase.master.master_penjualan.laporan.lap_analisa_piutang.ajax_analisapiutang_rekap',
                         compact(
                                 'laporan',
                                 'cab',
                                 'cab_nama',
                                 'customer',
                                 'customer_nama',
                                 'akun',
                                 'akun2',
                                 'akun_nama',
                                 'invoice',
                                 'invoice_0',
                                 'invoice_0_30',
                                 'invoice_31_60',
                                 'invoice_61_90',
                                 'invoice_91_120',
                                 'invoice_120',
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
                                 'total_invoice_120'
                                ));
    }

    function invoice($req)
    {
        $invoice_0       = [];
        $invoice_0_30    = [];
        $invoice_31_60   = [];
        $invoice_61_90   = [];
        $invoice_91_120  = [];
        $invoice_121_180 = [];
        $invoice_181_360 = [];
        $invoice_120     = [];
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
        $total_invoice_120     = 0;
        $laporan               = $req->laporan;

        if ($req->customer != 'all') {
            $customer = 'and i_kode_customer = '."'$req->customer'";
        }else{
            $customer = '';
        }

        if ($req->cabang != 'all') {
            $cabang = 'and i_kode_cabang = '."'$req->cabang'";
        }else{
            $cabang = '';
        }

        if ($req->akun != 'all') {
            $akun = 'and i_acc_piutang = '."'$req->akun'";
        }else{
            $akun = '';
        }

        $invoice = DB::table('invoice')
                     ->whereRaw("i_nomor != '0' $akun $customer $cabang")
                     ->orderBy('i_nomor','ASC')
                     ->get();
        $invoice_temp = $invoice;
        for ($i=0; $i < count($invoice_temp); $i++) { 
            if ($invoice_temp[$i]->i_tanggal_tanda_terima != null) {
                if (strtotime($req->min)/86400 < strtotime($invoice_temp[$i]->i_tanggal_tanda_terima)/86400) {
                    if (strtotime($invoice_temp[$i]->i_tanggal_tanda_terima)/86400 > strtotime($req->max)/86400) {
                        unset($invoice[$i]);
                    }
                }else{
                    unset($invoice[$i]);
                }
            }elseif ($invoice_temp[$i]->i_tanggal_tanda_terima == null){
                if (strtotime($req->min)/86400 <  strtotime($invoice_temp[$i]->i_tanggal)/86400) {
                    if (strtotime($invoice_temp[$i]->i_tanggal)/86400 > strtotime($req->max)/86400) 
                    {
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
                      ->where('k_jenis_pembayaran','!=','C')
                      ->get();

            for ($a=0; $a < count($kwitansi); $a++) { 
                if (strtotime($req->min) <  strtotime($kwitansi[$a]->tanggal)) {
                    if (strtotime($kwitansi[$a]->tanggal) > strtotime($req->max)) {
                        $invoice[$i]->i_sisa_akhir += $kwitansi[$a]->total;
                    }
                }else{
                    $invoice[$i]->i_sisa_akhir += $kwitansi[$a]->total;
                }
            }

            $i_nomor = $invoice[$i]->i_nomor;

            $posting = DB::table('kwitansi_d')
                          ->select('kd_total_bayar as total','k_tgl_posting as tanggal')
                          ->join('kwitansi','kd_id','=','k_id')
                          ->whereRaw("k_jenis_pembayaran = 'F' and kd_nomor_invoice = '$i_nomor'
                            or k_jenis_pembayaran = 'C' and kd_nomor_invoice = '$i_nomor'")
                          ->get();
            for ($a=0; $a < count($posting); $a++) { 
                if (strtotime($req->min) <  strtotime($posting[$a]->tanggal)) {
                    if (strtotime($posting[$a]->tanggal) > strtotime($req->max)) {

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
                    array_push($invoice_120,0);
                    
                }elseif ($tanggal_jatuh_tempo >= 0 and $tanggal_jatuh_tempo <= 30){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,0);
                    array_push($invoice_120,0);
                    
                }elseif ($tanggal_jatuh_tempo >= 31 and $tanggal_jatuh_tempo <= 60){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,0);
                    array_push($invoice_120,0);
                    
                }elseif ($tanggal_jatuh_tempo >= 61 and $tanggal_jatuh_tempo <= 90){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_91_120,0);
                    array_push($invoice_120,0);
                    
                }elseif ($tanggal_jatuh_tempo >= 91 and $tanggal_jatuh_tempo <= 120){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_120,0);
                    
                }elseif ($tanggal_jatuh_tempo >= 121){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,0);
                    array_push($invoice_120,$invoice[$i]->i_sisa_akhir);
                }else{
                    dd($tanggal_jatuh_tempo);
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
                    array_push($invoice_120,0);
                    
                }elseif ($tanggal_jatuh_tempo >= 0 and $tanggal_jatuh_tempo <= 30){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,0);
                    array_push($invoice_120,0);
                    
                }elseif ($tanggal_jatuh_tempo >= 31 and $tanggal_jatuh_tempo <= 60){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,0);
                    array_push($invoice_120,0);
                    
                }elseif ($tanggal_jatuh_tempo >= 61 and $tanggal_jatuh_tempo <= 90){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_91_120,0);
                    array_push($invoice_120,0);
                    
                }elseif ($tanggal_jatuh_tempo >= 91 and $tanggal_jatuh_tempo <= 120){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,$invoice[$i]->i_sisa_akhir);
                    array_push($invoice_120,0);
                }elseif ($tanggal_jatuh_tempo >= 121){
                    array_push($invoice_0,0);
                    array_push($invoice_0_30,0);
                    array_push($invoice_31_60,0);
                    array_push($invoice_61_90,0);
                    array_push($invoice_91_120,0);
                    array_push($invoice_120,$invoice[$i]->i_sisa_akhir);
                }else{
                    dd($tanggal_jatuh_tempo);
                }
            }else{
                dd($invoice[$i]);
            }
        }

        for ($i=0; $i < count($invoice); $i++) { 
            $total_invoice += $invoice[$i]->i_total_tagihan;
            $temp = $invoice[$i]->i_total_tagihan + $invoice[$i]->i_debet - $invoice[$i]->i_kredit - $invoice[$i]->i_sisa_akhir;
            $total_terbayar += $temp;
            $total_sisa_saldo += $invoice[$i]->i_sisa_akhir;
            $total_umur += $umur[$i];
            $total_invoice_0 += $invoice_0[$i];
            $total_invoice_0_30 += $invoice_0_30[$i];
            $total_invoice_31_60 += $invoice_31_60[$i];
            $total_invoice_61_90 += $invoice_61_90[$i];
            $total_invoice_91_120 += $invoice_91_120[$i];
            $total_invoice_120 += $invoice_120[$i];
        }
        return view('purchase.master.master_penjualan.laporan.lap_analisa_piutang.ajax_analisapiutang_rekap',
                         compact('invoice',
                                 'invoice_0',
                                 'invoice_0_30',
                                 'invoice_31_60',
                                 'invoice_61_90',
                                 'invoice_91_120',
                                 'invoice_120',
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
                                 'laporan',
                                 'total_invoice_120'
                                ));
    }

} 
