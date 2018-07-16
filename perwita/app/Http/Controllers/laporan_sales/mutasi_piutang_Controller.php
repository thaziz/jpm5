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
		$array = array_values($result_customer);	

    // if ($array != null) {
    //     $cus_invoice = "AND i_total_tagihan = $array[$i] "; 
    //   }else{
    //       $cus_invoice = '';
    //   }
    
    
      
    for ($i=0; $i <count($array) ; $i++) { 
    
      $saldoawal[$i] = DB::table('invoice')
                        ->select(DB::raw('SUM(i_total_tagihan) as saldoawal'))
                        ->where('i_tanggal','>',$tglawal)
                        ->where('i_tanggal','<',$tglakhir)
                        ->where('i_kode_customer','=',$array[$i])
                        ->get();

          if ($saldoawal[$i][0]->saldoawal != null) {
               $saldoawal[$i] =  $saldoawal[$i];
          }else{
               $saldoawal[$i][0]->saldoawal = 0;
          }

      $piutangbaru[$i] = DB::table('invoice')
                        ->select(DB::raw('SUM(i_total_tagihan) as piutangbaru'))
                        ->where('i_tanggal','>',$tglakhir)
                        ->where('i_kode_customer','=',$array[$i])
                        ->get();

          if ($piutangbaru[$i][0]->piutangbaru != null) {
               $piutangbaru[$i] =  $piutangbaru[$i];
          }else{
               $piutangbaru[$i][0]->piutangbaru = 0;
          }

      $nota_debet[$i] = DB::table('cn_dn_penjualan')
                        ->select(DB::raw('SUM(cd_total) as nota_debet'))
                        ->where('cd_tanggal','>',$tglawal)
                        ->where('cd_tanggal','<',$tglakhir)
                        ->where('cd_jenis','=','D')
                        ->where('cd_customer','=',$array[$i])
                        ->get();
      
          if ($nota_debet[$i][0]->nota_debet != null) {
           $nota_debet[$i] =  $nota_debet[$i];
          }else{
               $nota_debet[$i][0]->nota_debet = 0;
          }

      $cash[$i] = DB::table('kwitansi')
                        ->select(DB::raw('SUM(k_netto) as cash'))
                        ->where('k_tanggal','>',$tglawal)
                        ->where('k_tanggal','<',$tglakhir)
                        ->where('k_jenis_pembayaran','=','T')
                        ->where('k_kode_customer','=',$array[$i])
                        ->get();

          if ($cash[$i][0]->cash != null) {
           $cash[$i] =  $cash[$i];
          }else{
               $cash[$i][0]->cash = 0;
          }


      $cek_bg_trsn[$i] = DB::table('kwitansi')
                        ->select(DB::raw('SUM(k_netto) as cek_bg_trsn'))
                        ->where('k_tanggal','>',$tglawal)
                        ->where('k_tanggal','<',$tglakhir)
                        ->Where('k_jenis_pembayaran','=', 'C')
                        ->where('k_kode_customer','=',$array[$i])
                        ->get();

          if ($cek_bg_trsn[$i][0]->cek_bg_trsn != null) {
           $cek_bg_trsn[$i] =  $cek_bg_trsn[$i];
          }else{
               $cek_bg_trsn[$i][0]->cek_bg_trsn = 0;
          }

      $uangmuka[$i] = DB::table('kwitansi')
                        ->select(DB::raw('SUM(k_netto) as uangmuka'))
                        ->where('k_tanggal','>',$tglawal)
                        ->where('k_tanggal','<',$tglakhir)
                        ->where('k_jenis_pembayaran','=','U')
                        ->where('k_kode_customer','=',$array[$i])
                        ->get();

          if ($uangmuka[$i][0]->uangmuka != null) {
           $uangmuka[$i] =  $uangmuka[$i];
          }else{
               $uangmuka[$i][0]->uangmuka = 0;
          }

      $nota_kredit[$i] =  DB::table('cn_dn_penjualan')
                        ->select(DB::raw('SUM(cd_total) as nota_kredit'))
                        ->where('cd_tanggal','>',$tglawal)
                        ->where('cd_tanggal','<',$tglakhir)
                        ->where('cd_jenis','=','K')
                        ->where('cd_customer','=',$array[$i])
                        ->get();     

          if ($nota_kredit[$i][0]->nota_kredit != null) {
           $nota_kredit[$i] =  $nota_kredit[$i];
          }else{
               $nota_kredit[$i][0]->nota_kredit = 0;
          }            


    }
    return $array;
    // return [$saldoawal,$piutangbaru,$nota_debet,$cash,$cek_bg_trsn,$uangmuka,$nota_kredit];
    $data = array_merge([$array,$saldoawal,$piutangbaru,$nota_debet,$cash,$cek_bg_trsn,$uangmuka,$nota_kredit]);
    return view('purchase/master/master_penjualan/laporan/lap_mutasi_piutang/ajax_mutasipiutang_rekap',compact('saldoawal','data','array'));
    

    
    
		

  }
  	  


}
