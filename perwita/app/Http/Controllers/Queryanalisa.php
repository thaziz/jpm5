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
		
		return $array;


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

	public function kartuhutangdetail(){


		$tglawal = '2018-06-02';
		$tglakhir = '2018-07-02';

		$supplier = DB::select("select fp_idsup from faktur_pembelian where fp_tgl BETWEEN '$tglawal' and '$tglakhir'");

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
			
				$cash = DB::select("select 'CASH' as flag, bkk_tgl as tgl, bkk_supplier as supplier , bkk_nota as nota, bkk_total as nominal from bukti_kas_keluar where bkk_tgl BETWEEN '$tglawal' and '$tglakhir' and bkk_supplier = '$no_supplier'");
			

			$bkk = DB::select("select 'BG' as flag , bkk_supplier as supplier, bkk_nota as nota, bkk_tgl as tgl, bkk_total as nominal from bukti_kas_keluar where bkk_jenisbayar = '2' and bkk_supplier = '$no_supplier' and bkk_tgl BETWEEN '$tglawal' and '$tglakhir'");

			$returnbeli = DB::select("select 'RN' as flag, rn_supplier as supplier, rn_nota as nota, rn_tgl as tgl, rn_totalreturn as nominal from returnpembelian where rn_supplier = '$idsup' and rn_tgl BETWEEN '$tglawal' and '$tglakhir'");


			$isidetail = array_merge($hutangbaru , $vc, $cn, $dn, $cash, $bkk, $returnbeli);
			array_push($data['isidetail'] , $isidetail);
		}

		return $data;

	}

	public function rekapmutasihutang(){

		$tglawal = '2018-06-02';
		$tglakhir = '2018-07-02';

		$akun = DB::select("select * from faktur_pembelian where fp_tgl BETWEEN '$tglawal' and '$tglakhir'");

		$akunhutang = [];
		for($i = 0; $i < count($akun); $i++){
			$akunhutang = $akun[$i]->fp_acchutang;
			$subacchutang = substr($acchutangdagang, 0 , 4);

			array_push($akunhutang, $subacchutang);			
		}

		$arrayuniq = array_unique($akunhutang);
		$values = array_values($arrayuniq);

		for($j = 0; $j < count($values);$j++){
			$akunhutangdagang = $values[$j];
			$hutangsupplier = DB::select("select * from faktur_pembelian where fp_tgl BETWEEN '$tglawal' and '$tglakhir' and fp_acchutang LIKE 'akunhutangdagang%' and fp_tgl BETWEEN '$tglawal' and '$tglakhir'");
		}

		
	}

	//detail akun 
	public function detailmutasihutang(){
		$akun = DB::select("select * from faktur_pembelian where fp_tgl BETWEEN '$tglawal' and '$tglakhir'");

		$akunhutang = [];
		for($i = 0; $i < count($akun); $i++){
			$akunhutang = $akun[$i]->fp_acchutang;
			$subacchutang = substr($acchutangdagang, 0 , 4);

			array_push($akunhutang, $subacchutang);			
		}

		$arrayuniq = array_unique($akunhutang);
		$values = array_values($arrayuniq);

		for($j = 0; $j < count($values);$j++){
			$akunhutangdagang = $values[$j];
			$hutangsupplier = DB::select("select * from faktur_pembelian where fp_tgl BETWEEN '$tglawal' and '$tglakhir' and fp_acchutang LIKE 'akunhutangdagang%' and fp_tgl BETWEEN '$tglawal' and '$tglakhir'");
		}
	}
}