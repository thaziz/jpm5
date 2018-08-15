<?php

namespace App\Http\Controllers\laporan_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class mutasi_piutang_Controller extends Controller
{
  public function index()
  {
      $customer = DB::select(" SELECT kode,nama FROM customer ORDER BY nama ASC ");
      $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
      $piutang = DB::select(" SELECT id_akun,nama_akun FROM d_akun where id_akun like '%1301%' ORDER BY nama_akun ASC ");

      return view('purchase/master/master_penjualan/laporan/lap_mutasi_piutang/lap_mutasipiutang',compact('customer','piutang','cabang'));
  }
  public function ajax_mutasipiutang_rekap(Request $request)
  {
	  // dd($request->all());
	  $tglawal = $request->min;
	  $tglakhir = $request->max;

	  $customer  =  DB::select("SELECT i_kode_customer from invoice where i_tanggal BETWEEN '$tglawal' and '$tglakhir'");
	  
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
    // dd($request->all());
    if ($request->customer != '') {
      $array[0] = $request->customer; 
    }else{
      $array = array_values($result_customer); 
    }

    // if ($array != null) {
    //     $cus_invoice = "AND i_total_tagihan = $array[$i] "; 
    //   }else{
    //       $cus_invoice = '';
    //   }

    $push_saldo       = [];
    $push_piutangbaru = [];
    $push_nota_debet  = [];
    $push_cash        = [];
    $push_cek_bg_trsn = [];
    $push_uangmuka    = [];
    $push_nota_kredit = [];
    $push_customer_lenght = [];

    for ($i=0; $i <count($array) ; $i++) { 

      $customer_lenght = DB::table('customer')->select('kode','nama')->where('kode',$array[$i])->get(); 

      array_push($push_customer_lenght,$customer_lenght);
      // return $push_customer_lenght;
      if ($request->cabang == '') {
        $saldoawal[$i] = DB::table('invoice')
                        ->select(DB::raw('SUM(i_total_tagihan) as saldoawal'))
                        ->where('i_tanggal','>',$tglawal)
                        ->where('i_tanggal','<',$tglakhir)
                        ->where('i_kode_customer','=',$array[$i])
                        // ->where('i_kode_cabang','=',)
                        ->get();
      }else{
        $saldoawal[$i] = DB::table('invoice')
                        ->select(DB::raw('SUM(i_total_tagihan) as saldoawal'))
                        ->where('i_tanggal','>',$tglawal)
                        ->where('i_tanggal','<',$tglakhir)
                        ->where('i_kode_customer','=',$array[$i])
                        ->where('i_kode_cabang','=',$request->cabang)
                        ->get();
      }


      if ($saldoawal[$i][0]->saldoawal == null) {
          $saldoawal[$i][0]->saldoawal = 0;
      }else{
          $saldoawal[$i] = $saldoawal[$i];
      }
      // return $saldoawal;


      $piutangbaru[$i] = DB::table('invoice')
                        ->select(DB::raw('SUM(i_total_tagihan) as piutang_baru'))
                        ->where('i_tanggal','>',$tglakhir)
                        ->where('i_kode_customer','=',$array[$i])
                        ->get();
      if ($piutangbaru[$i][0]->piutang_baru == null) {
          $piutangbaru[$i][0]->piutang_baru = 0;
      }else{
          $piutangbaru[$i] = $piutangbaru[$i];
      }

      if ($request->cabang == '') {
        $notadebet[$i] = DB::table('cn_dn_penjualan')
                        ->select(DB::raw('SUM(cd_total) as nota_debet'))
                        ->where('cd_tanggal','>',$tglawal)
                        ->where('cd_tanggal','<',$tglakhir)
                        ->where('cd_jenis','=','D')
                        ->where('cd_customer','=',$array[$i])
                        ->get();
      }else{
        $notadebet[$i] = DB::table('cn_dn_penjualan')
                        ->select(DB::raw('SUM(cd_total) as nota_debet'))
                        ->where('cd_tanggal','>',$tglawal)
                        ->where('cd_tanggal','<',$tglakhir)
                        ->where('cd_jenis','=','D')
                        ->where('cd_customer','=',$array[$i])
                        ->where('cd_kode_cabang','=',$request->cabang)
                        ->get();
      }
      
      
      if ($notadebet[$i][0]->nota_debet == null) {
          $notadebet[$i][0]->nota_debet = 0;
      }else{
          $notadebet[$i] = $notadebet[$i];
      }

      if ($request->cabang == '') {
        $cash[$i] = DB::table('kwitansi')
                        ->select(DB::raw('SUM(k_netto) as cash'))
                        ->where('k_tanggal','>',$tglawal)
                        ->where('k_tanggal','<',$tglakhir)
                        ->where('k_jenis_pembayaran','=','T')
                        ->where('k_kode_customer','=',$array[$i])
                        ->get();
      }else{
        $cash[$i] = DB::table('kwitansi')
                        ->select(DB::raw('SUM(k_netto) as cash'))
                        ->where('k_tanggal','>',$tglawal)
                        ->where('k_tanggal','<',$tglakhir)
                        ->where('k_jenis_pembayaran','=','T')
                        ->where('k_kode_customer','=',$array[$i])
                        ->where('k_kode_cabang','=',$request->cabang)
                        ->get();
      }
      
      if ($cash[$i][0]->cash == null) {
          $cash[$i][0]->cash = 0;
      }else{
          $cash[$i] = $cash[$i];
      }

      // return $cash;

      if ($request->cabang == '') {
      }else{
      }
      $cek_bg_trsn[$i] = DB::table('posting_pembayaran as pb')
                        ->select(DB::raw('SUM(pbdt.jumlah) as cek_bg_trsn'))
                        ->join('posting_pembayaran_d as pbdt','pb.nomor','=','pbdt.nomor_posting_pembayaran')
                        ->where('tanggal','>',$tglawal)
                        ->where('tanggal','<',$tglakhir)
                        // ->Where('jenis_pembayaran','=', 'C')
                        ->where('kode_customer','=',$array[$i])
                        ->get();

      if ($cek_bg_trsn[$i][0]->cek_bg_trsn == null) {
          $cek_bg_trsn[$i][0]->cek_bg_trsn = 0;
      }else{
          $cek_bg_trsn[$i] = $cek_bg_trsn[$i];
      }

      if ($request->cabang == '') {
        $uangmuka[$i] = DB::table('kwitansi')
                        ->select(DB::raw('SUM(k_netto) as uangmuka'))
                        ->where('k_tanggal','>',$tglawal)
                        ->where('k_tanggal','<',$tglakhir)
                        ->where('k_jenis_pembayaran','=','U')
                        ->where('k_kode_customer','=',$array[$i])
                        ->get();
      }else{
        $uangmuka[$i] = DB::table('kwitansi')
                        ->select(DB::raw('SUM(k_netto) as uangmuka'))
                        ->where('k_tanggal','>',$tglawal)
                        ->where('k_tanggal','<',$tglakhir)
                        ->where('k_jenis_pembayaran','=','U')
                        ->where('k_kode_customer','=',$array[$i])
                        ->where('k_kode_cabang','=',$request->cabang)
                        ->get();
      }
      

      if ($uangmuka[$i][0]->uangmuka == null) {
          $uangmuka[$i][0]->uangmuka = 0;
      }else{
          $uangmuka[$i] = $uangmuka[$i];
      }

      if ($request->cabang == '') {
        $nota_kredit[$i] =  DB::table('cn_dn_penjualan')
                        ->select(DB::raw('SUM(cd_total) as nota_kredit'))
                        ->where('cd_tanggal','>',$tglawal)
                        ->where('cd_tanggal','<',$tglakhir)
                        ->where('cd_jenis','=','K')
                        ->where('cd_customer','=',$array[$i])
                        ->get(); 
      }else{
        $nota_kredit[$i] =  DB::table('cn_dn_penjualan')
                        ->select(DB::raw('SUM(cd_total) as nota_kredit'))
                        ->where('cd_tanggal','>',$tglawal)
                        ->where('cd_tanggal','<',$tglakhir)
                        ->where('cd_jenis','=','K')
                        ->where('cd_customer','=',$array[$i])
                        ->where('cd_kode_cabang','=',$request->cabang)
                        ->get(); 
      }
          

      if ($nota_kredit[$i][0]->nota_kredit == null) {
          $nota_kredit[$i][0]->nota_kredit = 0;
      }else{
          $nota_kredit[$i] = $nota_kredit[$i];
      } 

      if ($request->cabang == '') {
        $sisa_uangmuka[$i] =  DB::table('uang_muka_penjualan')
                        ->select(DB::raw('SUM(sisa_uang_muka) as sisa_uangmuka'))
                        ->where('tanggal','>',$tglawal)
                        ->where('tanggal','<',$tglakhir)
                        ->where('kode_customer','=',$array[$i])
                        ->get(); 
      }else{
        $sisa_uangmuka[$i] =  DB::table('uang_muka_penjualan')
                        ->select(DB::raw('SUM(sisa_uang_muka) as sisa_uangmuka'))
                        ->where('tanggal','>',$tglawal)
                        ->where('tanggal','<',$tglakhir)
                        ->where('kode_customer','=',$array[$i])
                        ->where('kode_cabang','=',$request->cabang)
                        ->get(); 
      }
          

      if ($sisa_uangmuka[$i][0]->sisa_uangmuka == null) {
          $sisa_uangmuka[$i][0]->sisa_uangmuka = 0;
      }else{
          $sisa_uangmuka[$i] = $sisa_uangmuka[$i];
      }                

    }
    // return $customer_lenght;
    return view('purchase/master/master_penjualan/laporan/lap_mutasi_piutang/ajax_mutasipiutang_rekap',compact('saldoawal','data','array','piutangbaru','notadebet','cash','cek_bg_trsn','uangmuka','nota_kredit','sisa_uangmuka','push_customer_lenght'));
  }
  	  


}
