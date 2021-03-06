<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use PDF;
use App\masterItemPurchase;
use App\masterSupplierPurchase;
use App\master_cabang;
use App\masterJenisItemPurchase;
use App\spp_purchase;
use App\sppdt_purchase;
use App\spptb_purchase;
use App\master_department;
use App\co_purchase;
use App\co_purchasedt;
use App\co_purchasetb;
use App\masterGudangPurchase;
use App\masterbank;
use App\purchase_orderr;
use App\purchase_orderdt;
use App\stock_mutation;
use App\stock_gudang;
use App\penerimaan_barang;
use App\penerimaan_barangdt;
use App\fakturpembelian;
use App\fakturpembeliandt;
use App\tb_master_pajak;
use App\tb_coa;
use App\jenisbayar;
use App\tb_jurnal;
use App\tandaterima;
use App\formfpg;
use App\formfpg_dt;
use App\formfpg_bank;
use App\masterbank_dt;
use App\v_hutang;
use App\ikhtisar_kas;
use App\barang_terima;
use App\bukti_bank_keluar;
use App\bukti_bank_keluar_dt;
use App\bukti_bank_keluar_biaya;
use App\master_akun;
Use App\d_jurnal;
Use App\d_jurnal_dt;
Use App\cndn;
Use App\cndn_dt;
use App\fakturpajakmasukan;
use DB;
Use Carbon\Carbon;
use Session;
use Mail;
use App\returnpembelian;
use App\returnpembelian_dt;

use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;


class Queryanalisa extends Controller
{


	public function view(){
		return view('purchase/pelunasanhutangbank/queryanalisa');
	}

	//berdasarkan supplier
	public function kartuhutangrekap(){

		// KARTU HUTANG REKAP BERDASARKAN AKUN

		$tglawal = '2018-06-02';
		$tglakhir = '2018-07-03';

		$supplier = DB::select("select fp_idsup from faktur_pembelian where fp_tgl BETWEEN '$tglawal' and '$tglakhir' and fp_jenisbayar = '2'");


		$arraysup = [];
		for($i = 0; $i < count($supplier); $i++){
			$idsup = $supplier[$i]->fp_idsup;
			array_push($arraysup , $idsup);
		}


		//unique supplier
		$result_supplier = array();
		foreach ($arraysup as &$v) {
		    if (!isset($result_supplier[$v]))
		        $result_supplier[$v] =& $v;
		}

		$array = array_values($result_supplier);
		

	//	cari data supplier
		$data['carisupp'] = array();
		for($j = 0; $j < count($array); $j++){
			
						$idsupplier = $array[$j];
						$carisupp = DB::select("select idsup , nama_supplier, no_supplier  from  supplier where idsup = '$idsupplier'");
			array_push($data['carisupp'], $carisupp);
		}


		$data['saldoawal'] = [];

		//mencari semua supplier dgn id unique
		for($i = 0; $i < count($array); $i++){

			$no_supplier = $data['carisupp'][$i][0]->no_supplier;
		
			$idsup = $data['carisupp'][$i][0]->idsup;


			//mencari saldo awal
			$datasaldoawal = DB::select("select * from faktur_pembelian where fp_idsup = '$idsup' and fp_tgl BETWEEN '$tglawal' and '$tglakhir' ");

			//countfpsaldoawal
			$saldoawal = 0;
			for($k = 0 ; $k < count($datasaldoawal); $k++){
				$netto = $datasaldoawal[$k]->fp_netto;
				$saldoawal = $saldoawal + $netto;
			}

			array_push($data['saldoawal'] , $saldoawal);
		}

		//return $result_supplier;
		$data['kartuhutang'] = [];
		$totalsupplier = 0;
	
		//return $data['carisupp'];
		
		for($i = 0; $i < count($array); $i++){
			
			$no_supplier = $data['carisupp'][$i][0]->no_supplier;
		//	return $no_supplier;
			$idsup = $data['carisupp'][$i][0]->idsup;

//			$statement = DB::select(DB::raw("SET @saldowawal = '$saldoawal'"));

			$bbk = DB::select("select bbkd_supplier as supplier,  bbk_nota as nota, bbk_tgl as tgl, bbkd_nominal as nominal ,'K' as flag from bukti_bank_keluar_detail, bukti_bank_keluar where bbkd_idbbk = bbk_id and bbkd_akunhutang LIKE '2101%' and bbkd_supplier = '$no_supplier' and bbk_tgl BETWEEN '$tglawal' and '$tglakhir'");


			$fp = DB::select("select  'D' as flag, fp_nofaktur as nota , fp_idsup as supplier, fp_tgl as tgl , fp_netto as nominal from faktur_pembelian where fp_jenisbayar = '2' and fp_idsup = '$idsup' and fp_tgl BETWEEN '$tglawal' and '$tglakhir'");


			$um = DB::select("select 'K' as flag, fp_idsup as supplier, fp_nofaktur as nota, fp_tgl as tgl, fp_uangmuka as nominal from faktur_pembelian where fp_jenisbayar = '2' and fp_uangmuka != 0.00 and fp_idsup = '$idsup' and fp_tgl BETWEEN '$tglawal' and '$tglakhir'");

			$bkk = DB::select("select 'K' as flag , bkk_supplier as supplier, bkk_nota as nota, bkk_tgl as tgl, bkk_total as nominal from bukti_kas_keluar where bkk_jenisbayar = '2' and bkk_supplier = '$no_supplier' and bkk_tgl BETWEEN '$tglawal' and '$tglakhir'");


			$datas= array_merge( $fp, $um, $bkk , $bbk);

			array_push($data['kartuhutang'] , $datas);

		}

	//	return $data['kartuhutang'];
	
		$data['totalhutangkredit'] = [];
		$data['totalhutangdebit'] = [];

		for($i = 0; $i < count($data['kartuhutang']); $i++){
				$totalhutangdebit = 0;
				$totalhutangkredit = 0;
			for($j = 0; $j < count($data['kartuhutang'][$i]); $j++){
						if($data['kartuhutang'][$i][$j]->flag == 'D'){
							$totalhutangdebit = $totalhutangdebit + floatval($data['kartuhutang'][$i][$j]->nominal);
						}
						else {
							$totalhutangkredit = $totalhutangkredit + floatval($data['kartuhutang'][$i][$j]->nominal);
						}		
			}

			array_push($data['totalhutangdebit'] , $totalhutangdebit );
			array_push($data['totalhutangkredit'] , $totalhutangkredit );
		}

		return json_encode($data);

	}

	// pihak ketiga
	public function kartuhutangrekappihakketiga(){

		// KARTU HUTANG REKAP BERDASARKAN AKUN

		$tglawal = '2018-06-02';
		$tglakhir = '2018-07-03';

		$supplier = DB::select("select fp_supplier , fp_jenisbayar from faktur_pembelian where fp_tgl BETWEEN '$tglawal' and '$tglakhir' and fp_jenisbayar = '6' or fp_jenisbayar = '7' or fp_jenisbayar = '9'");


		$arraysup = [];
		for($i = 0; $i < count($supplier); $i++){
			$idsup['supplier']= $supplier[$i]->fp_supplier;	
			$idsup['jenisbayar'] = $supplier[$i]->fp_jenisbayar;		
			array_push($arraysup , $idsup);
		}


		//unique supplier
		$result_supplier = array();
		foreach ($arraysup as &$v) {
		    if (!isset($result_supplier[$v['supplier']]))
		        $result_supplier[$v['supplier']] =& $v;
		}


		$array = array_values($result_supplier);		
		
		
	//	cari data supplier
		$data['carisupp'] = array();
		for($j = 0; $j < count($array); $j++){
			
						$idsupplier = $array[$j]['supplier'];
						$jenisbayar = $array[$j]['jenisbayar'];
						$pecahstring = substr($idsupplier, 0,2);

						if($pecahstring == 'SC'){
							$carisupp['supplier'] = DB::select("select kode , nama  from  subcon where kode = '$idsupplier'");
							$carisupp['jenisbayar'] = $array[$j]['jenisbayar'];
						}
						elseif($pecahstring == 'AV'){
							$carisupp['supplier'] = DB::select("select kode , nama  from  vendor where kode = '$idsupplier'");
							$carisupp['jenisbayar'] = $array[$j]['jenisbayar'];

						}
						elseif($pecahstring == 'AG'){
							$carisupp['supplier'] = DB::select("select kode , nama  from  agen where kode = '$idsupplier'");
							$carisupp['jenisbayar'] = $array[$j]['jenisbayar'];
						}
					
			array_push($data['carisupp'], $carisupp);
		}

		
		$data['saldoawal'] = [];

		//mencari semua supplier dgn id unique
		for($i = 0; $i < count($array); $i++){

			
			$idsup = $data['carisupp'][$i]['supplier'][0]->kode;
			$jenisbayar = $data['carisupp'][$i]['jenisbayar'];


			//mencari saldo awal
			$datasaldoawal = DB::select("select * from faktur_pembelian where fp_supplier = '$idsup' and fp_tgl BETWEEN '$tglawal' and '$tglakhir' and fp_jenisbayar = '$jenisbayar'");

			//countfpsaldoawal
			$saldoawal = 0;
			for($k = 0 ; $k < count($datasaldoawal); $k++){
				$netto = $datasaldoawal[$k]->fp_netto;
				$saldoawal = $saldoawal + $netto;
			}

			array_push($data['saldoawal'] , $saldoawal);
		}

		//return $result_supplier;
		$data['kartuhutang'] = [];
		$totalsupplier = 0;
	
		//return $data['carisupp'];
		
		for($i = 0; $i < count($array); $i++){
			
		
		//	return $no_supplier;
			$idsup = $data['carisupp'][$i]['supplier'][0]->kode;
			$jenisbayar = $data['carisupp'][$i]['jenisbayar'];


//			$statement = DB::select(DB::raw("SET @saldowawal = '$saldoawal'"));

			$bbk = DB::select("select bbkd_supplier as supplier,  bbk_nota as nota, bbk_tgl as tgl, bbkd_nominal as nominal ,'K' as flag from bukti_bank_keluar_detail, bukti_bank_keluar where bbkd_idbbk = bbk_id and bbkd_akunhutang LIKE '2102%' and bbkd_supplier = '$idsup' and bbk_tgl BETWEEN '$tglawal' and '$tglakhir'");


			$fp = DB::select("select  'D' as flag, fp_nofaktur as nota , fp_supplier as supplier, fp_tgl as tgl , fp_netto as nominal from faktur_pembelian where fp_jenisbayar = '$jenisbayar' and fp_supplier = '$idsup' and fp_tgl BETWEEN '$tglawal' and '$tglakhir'");


			$um = DB::select("select 'K' as flag, fp_supplier as supplier, fp_nofaktur as nota, fp_tgl as tgl, fp_uangmuka as nominal from faktur_pembelian where fp_jenisbayar = '$jenisbayar' and fp_uangmuka != 0.00 and fp_supplier = '$idsup' and fp_tgl BETWEEN '$tglawal' and '$tglakhir'");

			$bkk = DB::select("select 'K' as flag , bkk_supplier as supplier, bkk_nota as nota, bkk_tgl as tgl, bkk_total as nominal from bukti_kas_keluar where bkk_jenisbayar = '$jenisbayar' and bkk_supplier = '$idsup' and bkk_tgl BETWEEN '$tglawal' and '$tglakhir'");


			$datas= array_merge( $fp, $um, $bkk , $bbk);

			array_push($data['kartuhutang'] , $datas);

		}

	//	return $data['kartuhutang'];
	
		$data['totalhutangkredit'] = [];
		$data['totalhutangdebit'] = [];

		for($i = 0; $i < count($data['kartuhutang']); $i++){
				$totalhutangdebit = 0;
				$totalhutangkredit = 0;
			for($j = 0; $j < count($data['kartuhutang'][$i]); $j++){
						if($data['kartuhutang'][$i][$j]->flag == 'D'){
							$totalhutangdebit = $totalhutangdebit + floatval($data['kartuhutang'][$i][$j]->nominal);
						}
						else {
							$totalhutangkredit = $totalhutangkredit + floatval($data['kartuhutang'][$i][$j]->nominal);
						}		
			}

			array_push($data['totalhutangdebit'] , $totalhutangdebit );
			array_push($data['totalhutangkredit'] , $totalhutangkredit );
		}

		return json_encode($data);

	}



	public function allakunrekapkartuhutang(){
		
	}

	//per supplier
	public function kartuhutangdetail(){


		$tglawal = '2018-06-02';
		$tglakhir = '2018-07-02';

		$supplier = DB::select("select fp_idsup from faktur_pembelian where fp_tgl BETWEEN '$tglawal' and '$tglakhir' and fp_jenisbayar = '2'");

		$arraysup = [];
		for($i = 0; $i < count($supplier); $i++){
			$idsup = $supplier[$i]->fp_idsup;
			array_push($arraysup , $idsup);
		}


		//unique supplier
		$result_supplier = array();
		foreach ($arraysup as &$v) {
		    if (!isset($result_supplier[$v]))
		        $result_supplier[$v] =& $v;
		}

	
		$array = array_values($result_supplier);
		
	//	cari data supplier
		$data['carisupp'] = array();
		for($j = 0; $j < count($array); $j++){
			
						$idsupplier = $array[$j];
						$carisupp = DB::select("select idsup , nama_supplier, no_supplier  from  supplier where idsup = '$idsupplier'");
			array_push($data['carisupp'], $carisupp);
		}

		$data['saldoawal'] = [];

		//mencari semua supplier dgn id unique
		for($i = 0; $i < count($array); $i++){

			$no_supplier = $data['carisupp'][$i][0]->no_supplier;
		
			$idsup = $data['carisupp'][$i][0]->idsup;


			//mencari saldo awal
			$datasaldoawal = DB::select("select * from faktur_pembelian where fp_idsup = '$idsup' and fp_tgl BETWEEN '$tglawal' and '$tglakhir' ");

			//countfpsaldoawal
			$saldoawal = 0;
			for($k = 0 ; $k < count($datasaldoawal); $k++){
				$netto = $datasaldoawal[$k]->fp_netto;
				$saldoawal = $saldoawal + $netto;
			}

			array_push($data['saldoawal'] , $saldoawal);
		}


		//hutangbaru
		$data['isidetail'] = array();
		for($i = 0; $i < count($array); $i++){
			$no_supplier = $data['carisupp'][$i][0]->no_supplier;
		
			$idsup = $data['carisupp'][$i][0]->idsup;
			$databaru = DB::select("select * from faktur_pembelian where fp_tgl > '$tglakhir' and fp_idsup = '$idsup'");

			$hutangbaru = DB::select("select 'hutangbaru' as flag,  fp_tgl as tgl, fp_idsup as supplier , fp_nofaktur as nota , fp_netto as nominal from faktur_pembelian where fp_tgl > '$tglakhir' and fp_idsup = '$idsup'");
			
			$datavc = DB::select("select * from v_hutang where v_tgl BETWEEN '$tglawal' and '$tglakhir' and v_supid = '$no_supplier'");
			
			$vc = DB::select("select 'VC' as flag, v_tgl as tgl, v_supid as supplier, v_nomorbukti as nota, v_hasil as nominal from v_hutang where v_tgl BETWEEN '$tglawal' and '$tglakhir' and v_supid = '$no_supplier'");
			
			$datacn = DB::select("select * from cndnpembelian where cndn_jeniscndn = 'K' and cndn_tgl BETWEEN '$tglakhir' and '$tglawal' and cndn_supplier = '$idsup'");
		
				$cn = DB::select("select 'CN' as flag, cndn_tgl as tgl, cndn_supplier as supplier , cndn_nota as nota, cndn_bruto as nominal from cndnpembelian where cndn_jeniscndn = 'K' and cndn_supplier = '$idsup' and cndn_tgl BETWEEN '$tglawal' and '$tglakhir'" );
			

			$datadn = DB::select("select * from cndnpembelian where cndn_jeniscndn = 'D' and cndn_tgl BETWEEN '$tglakhir' and '$tglawal' and cndn_supplier = '$idsup'");
		
				$dn = DB::select("select 'CN' as flag, cndn_tgl as tgl, cndn_supplier as supplier , cndn_nota as nota, cndn_bruto as nominal from cndnpembelian where cndn_tgl BETWEEN '$tglawal' and '$tglakhir' and cndn_jeniscndn = 'D' and cndn_supplier = '$idsup'");


			$datacash = DB::select("select * from bukti_kas_keluar where bkk_tgl BETWEEN '$tglakhir' and '$tglawal' and bkk_supplier = '$no_supplier'");
			
			$cash = DB::select("select bbkd_supplier as supplier,  bbk_nota as nota, bbk_tgl as tgl, bbkd_nominal as nominal ,'K' as flag from bukti_bank_keluar_detail, bukti_bank_keluar where bbkd_idbbk = bbk_id and bbkd_supplier = '$idsup' and bbk_tgl BETWEEN '$tglawal' and '$tglakhir'");


			$bkk = DB::select("select 'BG' as flag , bkk_supplier as supplier, bkk_nota as nota, bkk_tgl as tgl, bkk_total as nominal from bukti_kas_keluar where bkk_jenisbayar = '2' and bkk_supplier = '$no_supplier' and bkk_tgl BETWEEN '$tglawal' and '$tglakhir'");

			$returnbeli = DB::select("select 'RN' as flag, rn_supplier as supplier, rn_nota as nota, rn_tgl as tgl, rn_totalreturn as nominal from returnpembelian where rn_supplier = '$idsup' and rn_tgl BETWEEN '$tglawal' and '$tglakhir'");


			$isidetail = array_merge($hutangbaru , $vc, $cn, $dn, $cash, $bkk, $returnbeli);
			array_push($data['isidetail'] , $isidetail);
		}

		return $data;

	}

	// all akun
	public function rekapmutasihutang(){

		$tglawal = '2018-06-02';
		$tglakhir = '2018-08-02';

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
			$cn = 0;
			$cash = 0;
			$um = 0;
			$bg = 0;
			$dn = 0;
			$rn = 0;
			$datas['isi'] = [];
			
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


				$dataum = DB::select("select * from d_uangmuka where um_akunhutang LIKE '$idakun%'");

				if(count($dataum) != 0){
									for($key = 0; $key < count($dataum);$key++){
										$nilaium = $dataum[$key]->um_sisaterpakai;
										$sisauangum = floatval($sisauangum) + floatval($nilaium);
									}
				}
				else {
					$sisauangum = 0;
				}
			
				$datas['isi']['sisaum'] = $sisauangum;			
		

			array_push($data['isidetail'] , $datas);
		}

		return $data;
	}

	//detail akun 
	public function detailmutasihutang(){
		$tglawal = '2018-06-02';
		$tglakhir = '2018-08-02';

		$idakun = '2102';

		$datafp = DB::select("select * from faktur_pembelian where fp_tgl BETWEEN '$tglawal' and '$tglakhir' and fp_acchutang LIKE '$idakun%'");

		$datavc = DB::select("select * from v_hutang where v_tgl BETWEEN '$tglawal' and '$tglakhir' and v_acchutang LIKE '$idakun%'");



		$nosupplier = [];
		if($idakun == '2101'){
				if(count($datafp) != 0){
					for($g = 1; $g < count($datafp); $g++){
						$idsup = $datafp[$g]->fp_idsup;

						$datasupplier = DB::select("select * from supplier where idsup = '$idsup'");
						
						$no_supplier1['no_supplier'] = $datasupplier[0]->no_supplier;
						$no_supplier1['nama'] = $datasupplier[0]->nama_supplier;
						array_push($nosupplier , $no_supplier1);
					}
				}

				if(count($datavc) != 0){
					for($j = 0; $j < count($datavc); $j++){
						$idsup = $datavc[$j]->v_supid;
						$datasupplier = DB::select("select * from supplier where no_supplier = '$idsup'");
						
						$no_supplier1['no_supplier'] = $datasupplier[0]->no_supplier;
						$no_supplier1['nama'] = $datasupplier[0]->nama_supplier;
						array_push($nosupplier , $no_supplier1);
					}
				}
		}
		else {
			if(count($datafp) != 0){
						for($g = 0; $g < count($datafp); $g++){
							$idsup = $datafp[$g]->fp_supplier;

							$datasupplier = DB::select("select * from supplier where no_supplier = '$idsup'");
							$datacustomer = DB::select("select * from agen where kode = '$idsup'");

						//	return $datacustomer;
							$datavendor = DB::select("select * from vendor where kode = '$idsup'");
							$datasubcon = DB::select("select * from subcon where kode = '$idsup'");
							if(count($datacustomer) != 0){
								$no_supplier['no_supplier'] = $datacustomer[0]->kode;
								$no_supplier['nama'] = $datacustomer[0]->nama;
							}
							else if(count($datasupplier) != 0){
								$no_supplier['no_supplier'] = $datasupplier[0]->no_supplier;
								$no_supplier['nama'] = $datasupplier[0]->nama_supplier;
							}
							else if(count($datavendor) != 0){
								$no_supplier['no_supplier'] = $datavendor[0]->kode;
								$no_supplier['nama'] = $datavendor[0]->nama;
							}
							else if(count($datasubcon) !=0){
								$no_supplier['no_supplier'] = $datasubcon[0]->kode;
								$no_supplier['nama'] = $datasubcon[0]->nama;
							}
							array_push($nosupplier , $no_supplier);
						}
			}

			if(count($datavc) != 0){
						for($j = 0; $j < count($datavc); $j++){
							$idsup = $datavc[$j]->v_supid;
							$datasupplier = DB::select("select * from supplier where no_supplier = '$idsup'");
							$no_supplier['no_supplier'] = $datasupplier[0]->no_supplier;
							$no_supplier['nama'] = $datasupplier[0]->nama_supplier;
							array_push($nosupplier , $no_supplier);
						}
					}
		}

		$data['supplier'] = [];
		$result_supplier = array();
		foreach ($nosupplier as &$v) {
		    if (!isset($result_supplier[$v['no_supplier']]))
		        $result_supplier[$v['no_supplier']] =& $v;
		}

		$values = array_values($result_supplier);
		$data['supplier'] = $values;
		
		//menghitung saldo awal
		$data['saldoawal'] = [];
		for($key = 0; $key < count($values); $key++){
			$saldoawal  = 0;
			$supplier = $values[$key]['no_supplier'];
			$datafp = DB::select("select * from faktur_pembelian where fp_tgl BETWEEN '$tglawal' and '$tglakhir' and fp_acchutang LIKE '$idakun%' and fp_supplier = '$supplier' and fp_acchutang LIKE '$idakun%'");
			
			if(count($datafp) != 0){
				for($h = 0; $h < count($datafp); $h++){
					$netto = $datafp[$h]->fp_netto;
					$saldoawal = floatval($netto) +floatval($saldoawal);				
				}
			}

			$datavc = DB::select("select * from v_hutang where v_tgl BETWEEN '$tglawal' and '$tglakhir' and v_acchutang LIKE '$idakun%' and v_supid = '$supplier'");

			if(count($datavc) != 0){
				for($j = 0; $j < count($datavc); $j++){
					$netto = $datavc[$j]->v_hasil;
					$saldoawal = floatval($netto) + floatval($saldoawal);
				}
			}

			array_push($data['saldoawal'] , $saldoawal);
		}


		$data['isidetail'] = [];
		for($j = 0; $j < count($values); $j++){

			$hutangbaru = 0;
			$nosupplier = $values[$j]['no_supplier'];
			$voucherhutang = 0;
			$cn = 0;
			$cash = 0;
			$um = 0;
			$bg = 0;
			$dn = 0;
			$rn = 0;
			$sisauangum = 0;
			$datas['isi'] = [];

			if($idakun == '2101'){
				$datasupplier = DB::select("select * from supplier where no_supplier = '$nosupplier'");
				$idsupplier = $datasupplier[0]->idsup;
			}

				$datahutangbaru = DB::select("select * from faktur_pembelian where fp_tgl > '$tglakhir' and fp_supplier = '$nosupplier'");

				$datavoucherhutang = DB::select("select * from v_hutang , v_hutangd where v_tgl BETWEEN '$tglawal' and '$tglakhir' and vd_id = v_id and v_supid = '$nosupplier'");

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


				if(isset($idsupplier)){	
								$datacn = DB::select("select * from cndnpembelian where cndn_tgl BETWEEN '$tglawal' and '$tglakhir' and cndn_jeniscndn = 'K'and cndn_supplier = '$idsupplier'");
				
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
				}
				else {
						$datas['flag'] = 'creditnota';
						$datas['isi']['creditnota'] = 0;
				}

				$datacash = DB::select("select 'CASH' as flag, bkk_tgl as tgl, bkk_supplier as supplier , bkk_nota as nota, bkk_total as nominal from bukti_kas_keluar where bkk_tgl BETWEEN '$tglawal' and '$tglakhir' and bkk_supplier = '$nosupplier'");


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

				$dataum = DB::select("select * from faktur_pembelian where fp_tgl BETWEEN '$tglawal' and '$tglakhir' and fp_uangmuka != 0.00 and fp_supplier = '$nosupplier'");

				
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
				
				$databg = DB::select("select bbkd_supplier as supplier,  bbk_nota as nota, bbk_tgl as tgl, bbkd_nominal as nominal ,'K' as flag from bukti_bank_keluar_detail, bukti_bank_keluar, fpg where bbkd_idbbk = bbk_id and bbkd_akunhutang LIKE '$idakun%' and bbk_tgl BETWEEN '$tglawal' and '$tglakhir' and bbkd_idfpg = idfpg and fpg_agen = '$nosupplier'");

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
				if(isset($returnbeli)){
						$returnbeli = DB::select("select  rn_supplier as supplier, rn_nota as nota, rn_tgl as tgl, rn_totalreturn as nominal from returnpembelian where rn_tgl BETWEEN '$tglawal' and '$tglakhir' and rn_supplier = '$idsupplier'");

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
				}
				else {
					$datas['flag'] = 'rn';
					$datas['isi']['rn'] = $rn;	
				}
				

				if(isset($idsupplier))	{
								$datadn = DB::select("select * from cndnpembelian where cndn_acchutangdagang LIKE '$idakun%' and cndn_tgl BETWEEN '$tglawal' and '$tglakhir' and cndn_jeniscndn = 'D' and cndn_supplier = '$idsupplier'");
				
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
				}
				else {
						$datas['flag'] = 'debitnota';
						$datas['isi']['debitnota'] = 0;	
				}

				$datas['isi']['saldoakhir'] = floatval($data['saldoawal'][$j]) + floatval($hutangbaru) - (floatval($cash) + floatval($um) + floatval($bg) + floatval($rn) + floatval($dn)) + (floatval($voucherhutang) + floatval($cn));


				$dataum = DB::select("select * from d_uangmuka where um_supplier = '$nosupplier'");

				if(count($dataum) != 0){
					for($key = 0; $key < count($dataum);$key++){
						$nilaium = $dataum[$key]->um_sisaterpakai;
						$sisauangum = floatval($sisauangum) + floatval($nilaium);
					}
				}
				else {
					$sisauangum = 0;
				}
			
				$datas['isi']['sisaum'] = $sisauangum;			
		

			array_push($data['isidetail'] , $datas);	
		}

		return $data;


	}


	//all supplier
	public function rekapanalisahutang (){
		$tglawal = '2018-06-02';
		$tglakhir = '2018-09-02';

		$akun = DB::select("select * from faktur_pembelian where fp_jatuhtempo BETWEEN '$tglawal' and '$tglakhir'");
		$akunpajak = DB::select("select * from v_hutang where v_tempo BETWEEN '$tglawal' and '$tglakhir'");

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
		$data['blmjatuhtempo'] = [];
		for($g = 0; $g < count($data['akunhutang']); $g++){
			$saldoawal = 0;
			$sisapelunasan = 0;
			$terbayar = 0;
			$blmjatuhtempo = 0;
			$tigapuluh = 0;
			$empatpuluhlima =0;
			$enampuluh = 0;
			$sembilanpuluh = 0;

			$akunhutangdagang = $values[$g]['idakun'];
			$jenishutang = $values[$g]['jenisakun'];

			$hutangsupplier1 = DB::select("select * from v_hutang where v_tempo BETWEEN '$tglawal' and '$tglakhir' and v_acchutang LIKE '$akunhutangdagang%'");

			$hutangsupplier2 = DB::select("select * from faktur_pembelian where fp_jatuhtempo BETWEEN '$tglawal' and '$tglakhir' and fp_acchutang LIKE '$akunhutangdagang%'");
			
			//belum jatuh tempo;
			$fpblmjatuhtempo = DB::select("select * from faktur_pembelian,fpg, bukti_bank_keluar, bukti_bank_keluar_detail, fpg_dt where fp_jatuhtempo BETWEEN '$tglawal' and '$tglakhir' and bbkd_idbbk = bbk_id and bbkd_idfpg = idfpg and fpgdt_idfpg = idfpg and fpgdt_idfp = fp_idfaktur and fp_acchutang LIKE '$akunhutangdagang%' and fpgdt_nofaktur = fp_nofaktur and fpg_agen = fp_supplier and bbk_tgl < '$tglakhir'");

			$vcblmjatuhtempo = DB::select("select * from v_hutang, fpg, bukti_bank_keluar, bukti_bank_keluar_detail, fpg_dt where v_tempo BETWEEN '$tglawal' and '$tglakhir' and bbkd_idbbk = bbk_id and bbkd_idfpg = idfpg and fpgdt_idfpg = idfpg and fpgdt_idfp = v_id and v_acchutang LIKE '$akunhutangdagang%' and fpgdt_nofaktur = v_nomorbukti and fpg_agen = v_supid and bbk_tgl < '$tglakhir'");

			$tigapuluhhari = strtotime ( '+30 day' , strtotime ( $tglakhir ));
			$tgplhdate = date('Y-m-j' , $tigapuluhhari);

			$fptigapuluh = DB::select("select * from faktur_pembelian,fpg, bukti_bank_keluar, bukti_bank_keluar_detail, fpg_dt where fp_jatuhtempo BETWEEN '$tglawal' and '$tglakhir' and bbkd_idbbk = bbk_id and bbkd_idfpg = idfpg and fpgdt_idfpg = idfpg and fpgdt_idfp = fp_idfaktur and fp_acchutang LIKE '$akunhutangdagang%' and fpgdt_nofaktur = fp_nofaktur and fpg_agen = fp_supplier and bbk_tgl < '$tgplhdate'");

			$vctigapuluh = DB::select("select * from v_hutang, fpg, bukti_bank_keluar, bukti_bank_keluar_detail, fpg_dt where v_tempo BETWEEN '$tglawal' and '$tglakhir' and bbkd_idbbk = bbk_id and bbkd_idfpg = idfpg and fpgdt_idfpg = idfpg and fpgdt_idfp = v_id and v_acchutang LIKE '$akunhutangdagang%' and fpgdt_nofaktur = v_nomorbukti and fpg_agen = v_supid and bbk_tgl < '$tgplhdate'");

			$empatpuluhlimahari = strtotime('+45 day', strtotime($tglakhir));
			$emptplhdate = date('Y-m-j' , $empatpuluhlimahari);

			$fpemptplhlima = DB::select("select * from faktur_pembelian,fpg, bukti_bank_keluar, bukti_bank_keluar_detail, fpg_dt where fp_jatuhtempo BETWEEN '$tglawal' and '$tglakhir' and bbkd_idbbk = bbk_id and bbkd_idfpg = idfpg and fpgdt_idfpg = idfpg and fpgdt_idfp = fp_idfaktur and fp_acchutang LIKE '$akunhutangdagang%' and fpgdt_nofaktur = fp_nofaktur and fpg_agen = fp_supplier and bbk_tgl BETWEEN '$tgplhdate' and '$emptplhdate'");

			$vcemptplhlima = DB::select("select * from v_hutang, fpg, bukti_bank_keluar, bukti_bank_keluar_detail, fpg_dt where v_tempo BETWEEN '$tglawal' and '$tglakhir' and bbkd_idbbk = bbk_id and bbkd_idfpg = idfpg and fpgdt_idfpg = idfpg and fpgdt_idfp = v_id and v_acchutang LIKE '$akunhutangdagang%' and fpgdt_nofaktur = v_nomorbukti and fpg_agen = v_supid and bbk_tgl BETWEEN '$tgplhdate' and '$emptplhdate'");

			$enaempuluhhari = strtotime('+60 day', strtotime($tglakhir));
			$enmplhdate = date('Y-m-j' , $enaempuluhhari);

			$fpenmplh = DB::select("select * from faktur_pembelian,fpg, bukti_bank_keluar, bukti_bank_keluar_detail, fpg_dt where fp_jatuhtempo BETWEEN '$tglawal' and '$tglakhir' and bbkd_idbbk = bbk_id and bbkd_idfpg = idfpg and fpgdt_idfpg = idfpg and fpgdt_idfp = fp_idfaktur and fp_acchutang LIKE '$akunhutangdagang%' and fpgdt_nofaktur = fp_nofaktur and fpg_agen = fp_supplier and bbk_tgl BETWEEN '$emptplhdate' and '$enmplhdate'");

			$vcenmplh = DB::select("select * from v_hutang, fpg, bukti_bank_keluar, bukti_bank_keluar_detail, fpg_dt where v_tempo BETWEEN '$tglawal' and '$tglakhir' and bbkd_idbbk = bbk_id and bbkd_idfpg = idfpg and fpgdt_idfpg = idfpg and fpgdt_idfp = v_id and v_acchutang LIKE '$akunhutangdagang%' and fpgdt_nofaktur = v_nomorbukti and fpg_agen = v_supid and bbk_tgl BETWEEN '$emptplhdate' and '$enmplhdate'");


			$sembilanpuluhhari = strtotime('+90 day', strtotime($tglakhir));
			$smblnphdate = date('Y-m-j' , $sembilanpuluhhari);

			$fpsmblnpuluh = DB::select("select * from faktur_pembelian,fpg, bukti_bank_keluar, bukti_bank_keluar_detail, fpg_dt where fp_jatuhtempo BETWEEN '$tglawal' and '$tglakhir' and bbkd_idbbk = bbk_id and bbkd_idfpg = idfpg and fpgdt_idfpg = idfpg and fpgdt_idfp = fp_idfaktur and fp_acchutang LIKE '$akunhutangdagang%' and fpgdt_nofaktur = fp_nofaktur and fpg_agen = fp_supplier and bbk_tgl BETWEEN '$enmplhdate' and '$smblnphdate'");

			$vcsmblnpuluh = DB::select("select * from v_hutang, fpg, bukti_bank_keluar, bukti_bank_keluar_detail, fpg_dt where v_tempo BETWEEN '$tglawal' and '$tglakhir' and bbkd_idbbk = bbk_id and bbkd_idfpg = idfpg and fpgdt_idfpg = idfpg and fpgdt_idfp = v_id and v_acchutang LIKE '$akunhutangdagang%' and fpgdt_nofaktur = v_nomorbukti and fpg_agen = v_supid and bbk_tgl BETWEEN '$enmplhdate' and '$smblnphdate'");

			if(count($fpsmblnpuluh) != 0){
				for($key = 0 ; $key < count($fpsmblnpuluh) ; $key++){
					$nominalsembilanpuluh = $fpsmblnpuluh[$key]->bbkd_nominal;
					$sembilanpuluh = floatval($sembilanpuluh) + floatval($nominalsembilanpuluh);
				}
			}

			if(count($vcsmblnpuluh) != 0){
				for($key = 0; $key < count($vcsmblnpuluh); $key++){
					$nominalsembilanpuluh = $vcsmblnpuluh[$key]->bbkd_nominal;
					$sembilanpuluh = floatval($sembilanpuluh) + floatval($nominalenampuluh);
				}
			}

			$hutangsuppliers['90hari'] = $sembilanpuluh;

			
			if(count($fpenmplh) != 0){
				for($key = 0; $key < count($vcenmplh); $key++){
					$nominalenampuluh = $vcenmplh[$key]->bbkd_nominal;
					$enampuluh = floatval($enampuluh) + floatval($nominalenampuluh);
				}
			}

			if(count($vcenmplh) != 0){
				for($key = 0; $key < count($vcenmplh); $key++){
					$nominalenampuluh = $vcenmplh[$key]->bbkd_nominal;
					$enampuluh = floatval($enampuluh) + floatval($nominalenampuluh);
				}
			}

			$hutangsuppliers['60hari'] = $enampuluh;


			if(count($fpemptplhlima) != 0){
				for($key = 0; $key < count($fpemptplhlima); $key++){
					$nominalempatpuluhlima = $fpemptplhlima[$key]->bbkd_nominal;
					$empatpuluhlima = floatval($empatpuluhlima) + floatval($nominalempatpuluhlima);
				}
			}

			if(count($vcemptplhlima) != 0){
				for($key = 0; $key < count($vcemptplhlima); $key++){
					$nominalempatpuluhlima = $vcemptplhlima[$key]->bbkd_nominal;
					$empatpuluhlima = floatval($empatpuluhlima) + floatval($nominalempatpuluhlima);
				}
			}


			$hutangsuppliers['45hari'] = $empatpuluhlima;


			if(count($fptigapuluh) != 0){
				for($key = 0; $key < count($fptigapuluh); $key++){
					$nominaltigapuluh = $fptigapuluh[$key]->bbkd_nominal;
					$tigapuluh = floatval($nominaltigapuluh) + floatval($tigapuluh);
				}
			}

			if(count($vctigapuluh) != 0){
				for($key = 0; $key < count($vctigapuluh); $key++){
					$nominaltigapuluh = $fptigapuluh[$key]->bbkd_nominal;
					$tigapuluh = floatval($nominaltigapuluh) + floatval($tigapuluh);
				}
			}

			$hutangsuppliers['30hari'] = $empatpuluhlima;


			if(count($fpblmjatuhtempo) != 0){
				for($k = 0; $k < count($fpblmjatuhtempo); $k++){
					$nominal = $fpblmjatuhtempo[$k]->bbkd_nominal;
					$blmjatuhtempo = floatval($blmjatuhtempo) + floatval($nominal);
				}
			}

			if(count($vcblmjatuhtempo) != 0){
				for($i = 0; $i < count($vcblmjatuhtempo); $i++){
					$nominal = $vcblmjatuhtempo[$i]->bbkd_nominal;
					$blmjatuhtempo = floatval($blmjatuhtempo) + floatval($nominal);
				}
			}

			if(count($hutangsupplier1) != 0){	

				$datavc = DB::select("select * from v_hutang, fpg, fpg_dt, bukti_bank_keluar, bukti_bank_keluar_detail, bukti_kas_keluar, bukti_kas_keluar_detail where v_acchutang LIKE '$akunhutangdagang%' and v_tempo < '$tglakhir' and fpgdt_idfpg = idfpg and fpgdt_idfp = v_id and bbkd_idbbk = bbk_id and bbkd_idfpg = idfpg and bkkd_bkk_id = bkk_id and bkkd_ref = v_nomorbukti and bkk_tgl < '$tglakhir' and bbk_tgl < '$tglakhir'");

				for($j = 0; $j < count($datavc); $j++){
					$netto = $datavc[$j]->v_hasil;
					$dibayarbkk = $datavc[$j]->bkkd_total;
					$dibayarbbk = $datavc[$j]->bbkd_nominal;

					$terbayar = floatval($saldoawal) + (floatval($dibayarbbk) + floatval($dibayarbkk));
					$blmjatuhtempo = floatval($netto) - floatval($terbayar);
				}
			}

			return $terbayar;


			if(count($hutangsupplier2) != 0){
				
				$datafb = DB::select("select * from faktur_pembelian, fpg, fpg_dt, bukti_bank_keluar, bukti_bank_keluar_detail, bukti_kas_keluar, bukti_kas_keluar_detail where fp_acchutang LIKE '$akunhutangdagang%' and fp_jatuhtempo < '$tglakhir' and fpgdt_idfpg = idfpg and fpgdt_idfp = fp_idfaktur and bbkd_idbbk = bbk_id and bbkd_idfpg = idfpg and bkkd_bkk_id = bkk_id and bkkd_ref = fp_nofaktur and bkk_tgl < '$tglakhir' and bbk_tgl < '$tglakhir'");

				for($j = 0; $j < count($datafb); $j++){
					$netto = $datafb[$j]->fp_netto;
					$dibayarbkk = $datafb[$j]->bkkd_total;
					$dibayarbbk = $datafb[$j]->bbkd_nominal;

					$terbayar = floatval($saldoawal) + (floatval($dibayarbbk) + floatval($dibayarbkk));
					$blmjatuhtempo = floatval($netto) - floatval($terbayar);
				}
			}
			
		
			if(count($hutangsupplier1) != 0 && count($hutangsupplier2) != 0) {
				$hutangsuppliers['data'] =	array_merge($hutangsupplier1 , $hutangsupplier2);
				$hutangsuppliers['jumlahfaktur'] = $saldoawal;
				$hutangsuppliers['terbayar'] = $terbayar;

			}
			else if(count($hutangsupplier1) != 0 && count($hutangsupplier2) == 0) {
				$hutangsuppliers['data'] = $hutangsupplier1;
				$hutangsuppliers['jumlahfaktur'] = $saldoawal;
				$hutangsuppliers['terbayar'] = $terbayar;
			}
			else if(count($hutangsupplier1) == 0 && count($hutangsupplier2) != 0){
				$hutangsuppliers['data'] = $hutangsupplier2;
				$hutangsuppliers['jumlahfaktur'] = $saldoawal;
				$hutangsuppliers['terbayar'] = $terbayar;
			}
			else {
				$hutangsuppliers['data'] = $hutangsupplier2;
				$hutangsuppliers['jumlahfaktur'] = $saldoawal;
				$hutangsuppliers['terbayar'] = $terbayar;
			}

			$hutangsuppliers['blmjatuhtempo'] = $blmjatuhtempo;
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

		return json_encode($data);
	}




	public function detailanalisahutang(){
		$tglawal = '2018-06-02';
		$tglakhir = '2018-08-02';

		$idakun = '2101';

		$datafp = DB::select("select * from faktur_pembelian where fp_tgl BETWEEN '$tglawal' and '$tglakhir' and fp_acchutang LIKE '$idakun%'");

		$datavc = DB::select("select * from v_hutang where v_tgl BETWEEN '$tglawal' and '$tglakhir' and v_acchutang LIKE '$idakun%'");



		$nosupplier = [];
		if($idakun == '2101'){
				if(count($datafp) != 0){
					for($g = 1; $g < count($datafp); $g++){
						$idsup = $datafp[$g]->fp_idsup;

						$datasupplier = DB::select("select * from supplier where idsup = '$idsup'");
						
						$no_supplier1['no_supplier'] = $datasupplier[0]->no_supplier;
						$no_supplier1['nama'] = $datasupplier[0]->nama_supplier;
						array_push($nosupplier , $no_supplier1);
					}
				}

				if(count($datavc) != 0){
					for($j = 0; $j < count($datavc); $j++){
						$idsup = $datavc[$j]->v_supid;
						$datasupplier = DB::select("select * from supplier where no_supplier = '$idsup'");
						
						$no_supplier1['no_supplier'] = $datasupplier[0]->no_supplier;
						$no_supplier1['nama'] = $datasupplier[0]->nama_supplier;
						array_push($nosupplier , $no_supplier1);
					}
				}
		}
		else {
			if(count($datafp) != 0){
						for($g = 0; $g < count($datafp); $g++){
							$idsup = $datafp[$g]->fp_supplier;

							$datasupplier = DB::select("select * from supplier where no_supplier = '$idsup'");
							$datacustomer = DB::select("select * from agen where kode = '$idsup'");

						//	return $datacustomer;
							$datavendor = DB::select("select * from vendor where kode = '$idsup'");
							$datasubcon = DB::select("select * from subcon where kode = '$idsup'");
							if(count($datacustomer) != 0){
								$no_supplier['no_supplier'] = $datacustomer[0]->kode;
								$no_supplier['nama'] = $datacustomer[0]->nama;
							}
							else if(count($datasupplier) != 0){
								$no_supplier['no_supplier'] = $datasupplier[0]->no_supplier;
								$no_supplier['nama'] = $datasupplier[0]->nama_supplier;
							}
							else if(count($datavendor) != 0){
								$no_supplier['no_supplier'] = $datavendor[0]->kode;
								$no_supplier['nama'] = $datavendor[0]->nama;
							}
							else if(count($datasubcon) !=0){
								$no_supplier['no_supplier'] = $datasubcon[0]->kode;
								$no_supplier['nama'] = $datasubcon[0]->nama;
							}
							array_push($nosupplier , $no_supplier);
						}
			}

			if(count($datavc) != 0){
						for($j = 0; $j < count($datavc); $j++){
							$idsup = $datavc[$j]->v_supid;
							$datasupplier = DB::select("select * from supplier where no_supplier = '$idsup'");
							$no_supplier['no_supplier'] = $datasupplier[0]->no_supplier;
							$no_supplier['nama'] = $datasupplier[0]->nama_supplier;
							array_push($nosupplier , $no_supplier);
						}
					}
		}

		$data['supplier'] = [];
		$result_supplier = array();
		foreach ($nosupplier as &$v) {
		    if (!isset($result_supplier[$v['no_supplier']]))
		        $result_supplier[$v['no_supplier']] =& $v;
		}

		$values = array_values($result_supplier);
		$data['supplier'] = $values;

		
		for($i = 0; $i < count($values); $i++){
			$nosupplier = $values[$i]['no_supplier'];
			$datafp = DB::select("select * from faktur_pembelian where fp_supplier = '$nosupplier' and fp_tgl BETWEEN '$tglawal' and '$tglakhir'");

			$datavc = DB::select("select * from v_hutang where v_supid = '$nosupplier' and v_tgl BETWEEN '$tglawal' and '$tglakhir'");

			$jumlahfaktur = 0;
			$data['hutang'] = [];
			for($j = 0 ; $j < count($datafp); $j++){
				$idfaktur = $datafp[$j]->fp_idfaktur;

				$terbayar = DB::select("select * from faktur_pembelian where fp_tgl BETWEEN '$tglawal' and '$tglakhir' and fp_supplier = '$nosupplier' and fp_idfaktur = '$idfaktur'");


				$datahutang['nota'] = $datafp[$j]->fp_nofaktur;
				$datahutang['jatuhtempo'] = $datafp[$j]->fp_jatuhtempo;
				$datahutang['jumlahfaktur'] = $datafp[$j]->fp_netto;

				array_push($data['hutang'], $datahutang);
			} 

			
		}

		return json_encode($data);
	}
}