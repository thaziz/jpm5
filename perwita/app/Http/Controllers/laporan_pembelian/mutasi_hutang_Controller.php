<?php

namespace App\Http\Controllers\laporan_pembelian;
ini_set('max_execution_time', 3600);
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use PDF;
use Auth;
use Carbon\carbon;
use Yajra\Datatables\Datatables;    
class mutasi_hutang_Controller extends Controller
{
  
	public function index(){
  		$supplier = DB::table('supplier')->get();
  	 	$piutang = DB::table('d_akun')->get();
  	 	$cabang = DB::table('cabang')->get();

        return view('purchase/laporan_analisa_pembelian/lap_mutasi_hutang/lap_mutasi_hutang',compact('supplier','piutang','cabang'));
	}
	public function cari_ajax_mutasi_hutang(Request $request){
		dd($request->all());
		//untuk bbk
		if ($request->akun != '' || $request->akun != null) {
			$akun_bbk = " AND bbkd_akunhutang = '".$request->akun."' ";
		}else{
			$akun_bbk = '';
		}
		if ($request->cabang != '' || $request->cabang != null) {
			$cabang_bbk = " AND bbk_cabang = '".$request->cabang."' ";
		}else{
			$cabang_bbk = '';
		}

		if ($request->supplier != '' || $request->supplier != null) {
			$supplier_bbk = " AND bbkd_jenissup = '".$request->supplier."' ";
		}else{
			$supplier_bbk = '';
		}
		
		//untuk fp_pembelian		
		if ($request->akun != '' || $request->akun != null) {
			$akun_fp = " AND fp_acchutang = '".$request->akun."' ";
		}else{
			$akun_fp = '';
		}
		if ($request->supplier != '' || $request->supplier != null) {
			$supplier_fp = " AND fp_idsup = '".$request->supplier_id."' ";
		}else{
			$supplier_fp = '';
		}
		if ($request->cabang != '' || $request->cabang != null) {
			$cabang_fp = " AND fp_comp = '".$request->cabang."' ";
		}else{
			$cabang_fp = '';
		}
		
		//untuk bkk
		if ($request->akun != '' || $request->akun != null) {
			$akun_bkk = " AND bkk_akun_hutang = '".$request->akun."' ";
		}else{
			$akun_bkk = '';
		}
		// if ($request->supplier != '' || $request->supplier != null) {
		// 	$supplier_bkk = " AND bkk_supplier = '".$request->supplier."' ";
		// }else{
		// 	$supplier_bkk = '';
		// }
		if ($request->cabang != '' || $request->cabang != null) {
			$cabang_bkk = " AND bkk_comp = '".$request->cabang."' ";
		}else{
			$cabang_bkk = '';
		}
		

		$tglawal = $request->min;
		$tglakhir = $request->max;

		$akun = DB::select("select * from faktur_pembelian where fp_tgl BETWEEN '$tglawal' and '$tglakhir'");
		$akunpajak = DB::select("select * from v_hutang where v_tgl BETWEEN '$tglawal' and '$tglakhir'");

		$data['akunhutang'] = [];
		for($i = 0; $i < count($akun); $i++){
			$akunhutang['idakun'] = $akun[$i]->fp_acchutang;
			$subacchutang = substr($akunhutang['idakun'], 0 , 4);
			$akunhutang['idakun'] = substr($akunhutang['idakun'], 0 , 4);
			$akunhutang['jenisakun'] = 'HUTANG DAGANG';
			array_push($data['akunhutang'], $akunhutang);			
		}

		for($j = 0; $j < count($akunpajak); $j++){
			$akunhutang['idakun'] = $akunpajak[$j]->v_acchutang;
			$subacchutang = substr($akunhutang['idakun'], 0,4);
			$akunhutang['idakun'] = $subacchutang;
			$akunhutang['jenisakun'] = 'HUTANG PAJAK';
			array_push($data['akunhutang'] , $akunhutang);
		}

		$result_supplier = array();
		foreach ($data['akunhutang'] as &$v) {
		    if (!isset($result_supplier[$v['idakun']]))
		        $result_supplier[$v['idakun']] =& $v;
		}


		
		$values = array_values($result_supplier);
		$data['akunhutang'] = $values;
		


		$data['hutangsupplier'] = [];
		for($g = 0; $g < count($data['akunhutang']); $g++){
			$saldoawal = 0;
			$akunhutangdagang = $values[$g]['idakun'];
			$jenishutang = $values[$g]['jenisakun'];

			$hutangsupplier1 = DB::select("select * from v_hutang where v_tgl BETWEEN '$tglawal' and '$tglakhir' and v_acchutang LIKE '$akunhutangdagang%'");

			$hutangsupplier2 = DB::select("select * from faktur_pembelian where fp_tgl BETWEEN '$tglawal' and '$tglakhir' and fp_acchutang LIKE '$akunhutangdagang%'");
							
			if(count($hutangsupplier1) != 0){
				$hutangsupplier3= DB::select("select * from v_hutang where v_tgl BETWEEN '$tglawal' and '$tglakhir' and v_acchutang LIKE '$akunhutangdagang%'");
				for($j = 0; $j < count($hutangsupplier3); $j++){
					$netto = $hutangsupplier3[$j]->v_hasil;
					$saldoawal = floatval($saldoawal) + floatval($netto);
				}
			}

			if(count($hutangsupplier2) != 0){
				$hutangsupplier4 =DB::select("select * from faktur_pembelian where fp_tgl BETWEEN '$tglawal' and '$tglakhir' and fp_acchutang LIKE '$akunhutangdagang%'");
				for($j = 0; $j < count($hutangsupplier2); $j++){
					$netto = $hutangsupplier4[$j]->fp_netto;
					$saldoawal = floatval($saldoawal) + floatval($netto);
				}
			}
			
			if(count($hutangsupplier1) != 0 && count($hutangsupplier2) != 0) {
				$hutangsuppliers['data'] =	array_merge($hutangsupplier3 , $hutangsupplier4);
				$hutangsuppliers['saldoawal'] = $saldoawal;	
			}
			else if(count($hutangsupplier1) != 0 && count($hutangsupplier2) == 0) {
				$hutangsuppliers['data'] = $hutangsupplier3;
				$hutangsuppliers['saldoawal'] = $saldoawal;
			}
			else {
				$hutangsuppliers['data'] = $hutangsupplier4;
				$hutangsuppliers['saldoawal'] = $saldoawal;
			}

			

			array_push($data['hutangsupplier'] , $hutangsuppliers);

		}

		

		
		 	$data['akun'] = [];
		


	
		//getnamaakun
		for($i = 0; $i < count($data['akunhutang']); $i++){
			$akun = $data['akunhutang'][$i]['idakun'];
			$namaakun['jenisakun'] = $data['akunhutang'][$i]['jenisakun'];
			$datakun = DB::select("select * from d_akun where id_akun LIKE '$akun%' and kode_cabang = '000'");
			$namaakun['id_akun'] = $akun;
			$namaakun2 = $datakun[0]->nama_akun;
			$namaakun['nama_akun'] = substr($namaakun2, 0, -5);

			array_push($data['akun'] , $namaakun);
		}

		//isidetail		
		$data['isidetail'] = [];

		for($j = 0; $j < count($data['akunhutang']); $j++){
			$hutangbaru = 0;
			$idakun = $data['akunhutang'][$j]['idakun'];
			$jenisakun = $data['akunhutang'][$j]['jenisakun'];
			$voucherhutang = 0;
			$cn   = 0;
			$cash = 0;
			$um   = 0;
			$bg   = 0;
			$dn   = 0;
			$rn   = 0;
			$datas['isi'] = [];
			if($jenisakun == 'HUTANG DAGANG'){
				$datahutangbaru = DB::select("select * from faktur_pembelian where fp_tgl > '$tglakhir' and fp_acchutang LIKE '$idakun%'");

				$datavoucherhutang = DB::select("select * from v_hutang , v_hutangd where v_tgl BETWEEN '$tglawal' and '$tglakhir' and vd_id = v_id and vd_acc LIKE '$idakun%'");

				if(count($datahutangbaru) != 0){
					for($m = 0; $m < count($datahutangbaru); $m++){
						$netto = $datahutangbaru[$m]->fp_netto;
						$hutangbaru = floatval($hutangbaru) + floatval($netto); 						
					}

					$datas['flag'] = 'hutangbaru';
					$datas['isi']['hutangbaru'] = $hutangbaru;
				}
				else {
					$datas['flag'] = 'hutangbaru';
					$datas['isi']['hutangbaru'] = 0;
				}

				if(count($datavoucherhutang) != 0){
								for($m = 0; $m < count($datavoucherhutang); $m++){
									$netto = $datavoucherhutang[$m]->vd_nominal;
									$voucherhutang = floatval($voucherhutang) + floatval($netto);
									
								}
					$datas['flag'] = 'voucherhutang';
					$datas['isi']['voucherhutang'] = $voucherhutang;
				}
				else {
					$datas['flag'] = 'voucherhutang';
					$datas['isi']['voucherhutang'] = 0;
				}



				$datacn = DB::select("select * from cndnpembelian where cndn_acchutangdagang LIKE '$idakun%' and cndn_tgl BETWEEN '$tglawal' and '$tglakhir' and cndn_jeniscndn = 'K'");

				if(count($datacn) != 0 ){
								for($m = 0; $m < count($datacn); $m++){
									$bruto = $datacn[$m]->cndn_bruto;
									$cn= floatval($bruto) + floatval($cn);
									
								}
					$datas['flag'] = 'creditnota';
					$datas['isi']['creditnota'] = $cn;
				}
				else {
					$datas['flag'] = 'creditnota';
					$datas['isi']['creditnota'] = 0;
				}

				$datacash = DB::select("select 'CASH' as flag, bkk_tgl as tgl, bkk_supplier as supplier , bkk_nota as nota, bkk_total as nominal from bukti_kas_keluar where bkk_tgl BETWEEN '$tglawal' and '$tglakhir' and bkk_akun_hutang LIKE '$idakun%'");


				if(count($datacash) != 0) {
					for($m = 0 ; $m < count($datacash); $m++){
						$netto = $datacash[$m]->nominal;
						$cash = floatval($cash) + floatval($netto);
					}
					$datas['flag'] = 'cash';
					$datas['isi']['cash'] = $cash;
				}
				else {
						$datas['flag'] = 'cash';
						$datas['isi']['cash'] = 0;
				}
				$dataum = DB::select("select * from faktur_pembelian where fp_tgl BETWEEN '$tglawal' and '$tglakhir' and fp_acchutang LIKE '$idakun%' and fp_uangmuka != 0.00");

				
				if(count($dataum) != 0){
								for($m = 0; $m < count($dataum); $m++){
									$netto = $dataum[$m]->fp_uangmuka;
									$um = floatval($um) + floatval($netto);									
								}
					$datas['flag'] = 'uangmuka';
					$datas['isi']['uangmuka'] = $um;
				
				}
				else {
					$datas['flag'] = 'uangmuka';
					$datas['isi']['uangmuka'] = 0;
				}	
				
				$databg = DB::select("select bbkd_supplier as supplier,  bbk_nota as nota, bbk_tgl as tgl, bbkd_nominal as nominal ,'K' as flag from bukti_bank_keluar_detail, bukti_bank_keluar where bbkd_idbbk = bbk_id and bbkd_akunhutang LIKE '$idakun%' and bbk_tgl BETWEEN '$tglawal' and '$tglakhir'");

				if(count($databg) != 0){
								for($m = 0; $m < count($databg); $m++){
				
									$netto = $databg[$m]->nominal;
									$bg = floatval($bg) + floatval($netto);
								}
						$datas['flag'] = 'bg';
						$datas['isi']['bg'] = $bg;
				}
				else {

					$datas['flag'] = 'bg';
					$datas['isi']['bg'] = $bg;
				}

				$returnbeli = DB::select("select  rn_supplier as supplier, rn_nota as nota, rn_tgl as tgl, rn_totalreturn as nominal from returnpembelian where rn_tgl BETWEEN '$tglawal' and '$tglakhir'");

				if(count($returnbeli) != 0){
					for($m = 0; $m < count($returnbeli); $m++){
	
						$netto = $returnbeli[$m]->nominal;
						$rn = floatval($rn) + floatval($netto);
					}
					$datas['flag'] = 'rn';
					$datas['isi']['rn'] = $rn;
				}
				else {
					$datas['flag'] = 'rn';
					$datas['isi']['rn'] = $rn;
				}


				$datadn = DB::select("select * from cndnpembelian where cndn_acchutangdagang LIKE '$idakun%' and cndn_tgl BETWEEN '$tglawal' and '$tglakhir' and cndn_jeniscndn = 'D'");

				if(count($datadn) != 0 ){
								for($m = 0; $m < count($datadn); $m++){
									$bruto = $datadn[$m]->cndn_bruto;
									$dn= floatval($bruto) + floatval($dn);
									
								}
					$datas['flag'] = 'debitnota';
					$datas['isi']['debitnota'] = $dn;
				}
				else {
					$datas['flag'] = 'debitnota';
					$datas['isi']['debitnota'] = 0;
				}

				$datas['isi']['saldoakhir'] = floatval($data['hutangsupplier'][$j]['saldoawal']) + floatval($hutangbaru) - (floatval($cash) + floatval($um) + floatval($bg) + floatval($rn) + floatval($dn)) + (floatval($voucherhutang) + floatval($cn));


				$datajenis = $data['akunhutang'][$j]['idakun'];
				$datajenissupplier = '2101';
				$datajenisketiga = '2102';
				$sisauangum = 0;
				if($datajenis == $datajenissupplier){
					$dataum = DB::select("select * from d_uangmuka where um_jenissup = 'supplier'");
					for($key = 0; $key < count($dataum);$key++){
						$nilaium = $dataum[$key]->um_sisaterpakai;
						$sisauangum = floatval($sisauangum) + floatval($nilaium);
					}					
				}
				else if($jenisakun == $datajenisketiga) {
					$dataum = DB::select("select * from d_uangmuka where um_jenissup != 'supplier'");
					for($key = 0; $key < count($dataum);$key++){
						$nilaium = $dataum[$key]->um_sisaterpakai;
						$sisauangum = floatval($sisauangum) + floatval($nilaium);
					}	
				}

				$datas['isi']['sisaum'] = $sisauangum;
			
			}


			else if($jenisakun == 'HUTANG PAJAK'){
				$datahutangbaru = DB::select("select * from faktur_pembelian where fp_tgl > '$tglakhir' and fp_accpph LIKE '$idakun%'");

				if(count($datahutangbaru) != 0){
					for($m = 0; $m < count($datahutangbaru); $m++){
						$netto = $datahutangbaru[$m]->fp_pph;
						$hutangbaru = floatval($hutangbaru) + floatval($netto);
					}
					$datas['isi']['hutangbaru'] = $sisauangum;
				}
				else {
					$datas['isi']['hutangbaru'] = 0;
				}

				
			}

			
			array_push($data['isidetail'] , $datas);
		}

		// return $data;
        return view('purchase/laporan_analisa_pembelian/lap_mutasi_hutang/ajax_mutasi_hutang/ajax_mutasi_hutang',compact('data'));
	}

}
