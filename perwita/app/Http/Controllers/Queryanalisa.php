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
	public function kartuhutangrekap(){

		// KARTU HUTANG REKAP BERDASARKAN AKUN

		$supplier = DB::table('faktur_pembelian')
					->select('fp_idsup')
					->get();

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

		//return $result_supplier;
		$data['kartuhutang'] = [];
		$totalsupplier = 0;
		//return $data['carisupp'];
		
		for($i = 0; $i < count($array); $i++){
			
			$no_supplier = $data['carisupp'][$i][0]->no_supplier;
		//	return $no_supplier;
			$idsup = $data['carisupp'][$i][0]->idsup;

			$bbk = DB::select("select bbkd_supplier as supplier,  bbk_nota as nota, bbk_tgl as tgl, bbkd_nominal as nominal ,'K' as flag from bukti_bank_keluar_detail, bukti_bank_keluar where bbkd_idbbk = bbk_id and bbkd_akunhutang LIKE '2101%' and bbkd_supplier = '$no_supplier'");


			$fp = DB::select("select 'D' as flag, fp_nofaktur as nota , fp_idsup, fp_tgl as tgl , fp_netto as nominal from faktur_pembelian where fp_jenisbayar = '2' and fp_idsup = '$idsup' ");


			$um = DB::select("select 'K' as flag, fp_idsup as supplier, fp_nofaktur as nota, fp_tgl as tgl, fp_uangmuka as nominal from faktur_pembelian where fp_jenisbayar = '2' and fp_uangmuka != 0.00 and fp_idsup = '$idsup'");

			$bkk = DB::select("select 'K' as flag , bkk_supplier as supplier, bkk_nota as nota, bkk_tgl as tgl, bkk_total as nominal from bukti_kas_keluar where bkk_jenisbayar = '2' and bkk_supplier = '$no_supplier'");


			$datas= array_merge($fp, $um, $bkk , $bbk);

			array_push($data['kartuhutang'] , $datas);

		}

	
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
			$datasaldoawal = DB::select("select * from faktur_pembelian where fp_idsup = '$idsup'");

			//countfpsaldoawal
			$saldoawal = 0;
			for($k = 0 ; $k < count($datasaldoawal); $k++){
				$netto = $datasaldoawal[$k]->fp_netto;
				$saldoawal = $saldoawal + $netto;
			}

			array_push($data['saldoawal'] , $saldoawal);
		}

		$databaru = DB::select("select * from faktur_pembelian where fp_tgl > '$tglakhir'");

		for($i = 0; $i < count($databaru); $i++){
			
		}

		return $data;

	}
}