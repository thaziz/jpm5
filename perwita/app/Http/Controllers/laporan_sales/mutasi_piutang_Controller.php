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
	  $awal = $request->min;
	  $akir = $request->max;

    $array = '';

    //invoice
    if ($request->customer != '' || $request->customer != null) {
      $customer_invoice = "AND i_kode_customer = '".$request->customer."' ";
    }else{
      $customer_invoice = "AND i_kode_customer = '".$array."'";
    }
    if ($request->akun != '' || $request->akun != null) {
      $akun_invoice = " AND i_acc_piutang = '".$request->akun."' ";
    }else{
      $akun_invoice = '';
    }
    if ($request->cabang != '' || $request->cabang != null) {
      $cabang_invoice = " AND i_kode_cabang = '".$request->cabang."' ";
    }else{
      $cabang_invoice = '';
    }
    //end
    //cndn
    if ($request->customer != '' || $request->customer != null) {
      $customer_cndn = " AND cd_customer = '".$request->customer."' ";
    }else{
      $customer_cndn = '';
    }
    if ($request->akun != '' || $request->akun != null) {
      $akun_cndn = " AND cd_acc = '".$request->akun."' ";
    }else{
      $akun_cndn = '';
    }
    if ($request->cabang != '' || $request->cabang != null) {
      $cabang_cndn = " AND cd_kode_cabang = '".$request->cabang."' ";
    }else{
      $cabang_cndn = '';
    }
    //end
    //Kwitansi
    if ($request->customer != '' || $request->customer != null) {
      $customer_kwitansi = " AND k_kode_customer = '".$request->customer."' ";
    }else{
      $customer_kwitansi = '';
    }
    if ($request->akun != '' || $request->akun != null) {
      $akun_kwitansi = " AND kwitansi_d.kd_kode_akun_acc = '".$request->akun."' ";
    }else{
      $akun_kwitansi = '';
    }
    if ($request->cabang != '' || $request->cabang != null) {
      $cabang_kwitansi = " AND k_kode_cabang = '".$request->cabang."' ";
    }else{
      $cabang_kwitansi = '';
    }
    //end
    //posting pemabayaran
    if ($request->customer != '' || $request->customer != null) {
      $customer_postingbayar = " AND kwitansi.k_kode_customer = '".$request->customer."' ";
    }else{
      $customer_postingbayar = '';
    }
    if ($request->akun != '' || $request->akun != null) {
      $akun_postingbayar = " AND posting_pembayaran_d.kode_acc = '".$request->akun."' ";
    }else{
      $akun_postingbayar = '';
    }
    if ($request->cabang != '' || $request->cabang != null) {
      $cabang_postingbayar = " AND posting_pembayaran.kode_cabang = '".$request->cabang."' ";
    }else{
      $cabang_postingbayar = '';
    }
    //end

	  $customer  =  DB::select("SELECT i_kode_customer from invoice where i_tanggal BETWEEN '$awal' and '$akir'");

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

    if ($request->customer != '') {
      $array[0] = $request->customer; 
    }else{
      $array = array_values($result_customer); 
    }

    for ($i=0; $i <count($array) ; $i++) { 
        $dtt = $array[$i]['customer'];
        $customer[$i] = DB::table('customer')->select('kode','nama')->where('kode','=',$dtt)->get();
    }
    // return $customer;

    $dtt = [];
    for ($i=0; $i <count($customer) ; $i++) { 
      
      $dtt[$i] = $customer[$i][0]->kode;
      
      $saldoawal[$i] = DB::select("SELECT sum(i_total_tagihan) as saldo,i_kode_customer as customer from invoice 
                      where i_tanggal >= '$awal' 
                        and i_tanggal <= '$akir' 
                        and i_kode_customer = '$dtt[$i]'
                       $akun_invoice $cabang_invoice
                      group by i_kode_customer");

      $piutangbaru[$i] = DB::select("SELECT sum(i_total_tagihan) as piutang_baru,i_kode_customer as customer from invoice
                      where i_tanggal > '$akir' 
                        and i_kode_customer = '$dtt[$i]'
                      $akun_invoice $cabang_invoice
                      group by i_kode_customer");

      $notadebet[$i] = DB::select("SELECT SUM(cd_total) as nota_debet,cd_customer as customer FROM cn_dn_penjualan 
                      where cd_tanggal >= '$awal' 
                        and cd_tanggal <= '$akir'
                        and cd_jenis <= 'D'
                        and cd_customer = '$dtt[$i]'
                      $akun_cndn $cabang_cndn
                      group by cd_customer");

      $cash[$i] = DB::select("SELECT SUM(k_netto) as cash,k_kode_customer as customer FROM kwitansi
                      left join kwitansi_d on kwitansi.k_id = kwitansi_d.kd_id
                      where k_tanggal >= '$awal' 
                        and k_tanggal <= '$akir'
                        and k_jenis_pembayaran = 'T'
                        and k_kode_customer = '$dtt[$i]'
                      $akun_kwitansi $cabang_kwitansi
                      group by k_kode_customer");

      $cek_bg_trsn[$i] = DB::select("SELECT SUM(posting_pembayaran_d.jumlah) as cek_bg_trsn,kode_customer FROM posting_pembayaran 
                      join posting_pembayaran_d on posting_pembayaran.nomor = posting_pembayaran_d.nomor_posting_pembayaran
                      where tanggal >= '$awal' 
                      and tanggal <= '$akir'
                      and kode_customer = '$dtt[$i]'
                      $akun_postingbayar $cabang_postingbayar
                      group by kode_customer");      

      $uangmuka[$i] = DB::select("SELECT SUM(k_netto) as uangmuka,k_kode_customer FROM kwitansi 
                      where k_tanggal >= '$awal' 
                      and k_tanggal <= '$akir'
                      and k_jenis_pembayaran = 'U'
                      and k_kode_customer = '$dtt[$i]'
                      group by k_kode_customer");

      $nota_kredit[$i] = DB::select("SELECT SUM(cd_total) as nota_kredit,cd_customer FROM cn_dn_penjualan 
                      where cd_tanggal >= '$awal' 
                      and cd_tanggal <= '$akir'
                      and cd_jenis = 'K'
                      and cd_customer = '$dtt[$i]'
                      group by cd_customer");

      $sisa_uangmuka[$i] = DB::select("SELECT SUM(sisa_uang_muka) as sisa_uangmuka,kode_customer FROM uang_muka_penjualan 
                      where tanggal >= '$awal' 
                      and tanggal <= '$akir'
                      and kode_customer = '$dtt[$i]'
                      group by kode_customer");

    }
    // return [$sisa_uangmuka,$saldoawal];
    // return array_merge($saldoawal,$data_piutangbaru,$cash);


    return view('purchase/master/master_penjualan/laporan/lap_mutasi_piutang/ajax_mutasipiutang_rekap',compact('saldoawal','data','array','piutangbaru','notadebet','cash','cek_bg_trsn','uangmuka','nota_kredit','sisa_uangmuka','push_customer_lenght','customer'));

    }

    
  }
