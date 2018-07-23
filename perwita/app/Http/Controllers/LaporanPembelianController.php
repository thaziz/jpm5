<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\masterItemPurchase;
use App\masterGroupItemPurchase;
use App\master_department;
use App\masterGudangPurchase;
use App\masterSupplierPurchase;
use Carbon\Carbon;
use PDF;
use DB;
use Excel;

class LaporanPembelianController extends Controller
{
	//=============================== LAPORAN MASTER ITEM PEMBELIAN ========================================//
	public function lap_masteritem()
	{
		$data = DB::select("SELECT * from masteritem");
		return view('purchase/laporan/lap_masteritem/lap_masteritem',compact('data'));
	}
	public function report_masteritem(Request $request){
		$data = $request->a;	
	   		$dat = '';
				for ($save=0; $save <count($data) ; $save++) { 
					$dat = $dat.','.$data[$save];
				}
				$dat =explode(',', $dat); 
				json_encode($dat);
		        for ($i=1; $i <count($dat) ; $i++) { 
					$dat1[$i] = DB::select("SELECT * from masteritem where kode_item = '$dat[$i]'");
		        }
		return view("purchase/laporan/lap_masteritem/report_masteritem",compact('dat1'));
	}
	//END OF


	//---


	//============================== LAPORAN MASTER GUDANG =======================================================//

	public function lap_mastergudang()
	{
		$data = DB::select("SELECT * from mastergudang");
		return view('purchase/laporan/lap_mastergudang/lap_mastergudang',compact('data'));
	}
	public function report_mastergudang(Request $request){
		$data = $request->a;	
	   		$dat = '';
				for ($save=0; $save <count($data) ; $save++) { 
					$dat = $dat.','.$data[$save];
				}
				$dat =explode(',', $dat); 
				json_encode($dat);
		        for ($i=1; $i <count($dat) ; $i++) { 
					$dat1[$i] = DB::select("SELECT * from mastergudang where mg_id = '$dat[$i]'");
		        }	
		return view("purchase/laporan/lap_mastergudang/report_mastergudang",compact('dat1'));
	}
	//END OF


	//---


	//============================ LPAORAN MASTER SUPPLIER =======================================================//

	public function lap_mastersupplier()
	{
		$data = DB::table("supplier as s")->select('s.*','k.nama as kota','p.nama as prov')->join('kota as k','k.id','=','s.kota')->join('provinsi as p','p.id','=','s.propinsi')->get();
		return view('purchase/laporan/lap_mastersupplier/lap_mastersupplier',compact('data'));
	}
	public function report_mastersupplier(Request $request){
		$data = $request->a;	
	   		$dat = '';
				for ($save=0; $save <count($data) ; $save++) { 
					$dat = $dat.','.$data[$save];
				}
				$dat =explode(',', $dat); 
				json_encode($dat);
		        for ($i=1; $i <count($dat) ; $i++) { 
					$dat1[$i] = DB::table("supplier as s")->select('s.*','k.nama as kota','p.nama as prov')->join('kota as k','k.id','=','s.kota')->join('provinsi as p','p.id','=','s.propinsi')->where('no_supplier','=',$dat[$i])->get();
		        }	
		        // dd($dat1);
		return view("purchase/laporan/lap_mastersupplier/report_mastersupplier",compact('dat1'));
	}
	//END OF


	//---


	//=============================== LAPORAN SPP =================================================//

	public function lap_spp()
	{
		$data = DB::select("SELECT spp.*,mastergudang.mg_namagudang as nama from spp join mastergudang on mastergudang.mg_id =  spp.spp_lokasigudang");
		return view('purchase/laporan/lap_spp/lap_spp',compact('data'));
	}
	public function report_spp(Request $request){
		$data = $request->a;	
	   		$dat = '';
				for ($save=0; $save <count($data) ; $save++) { 
					$dat = $dat.','.$data[$save];
				}
				$dat =explode(',', $dat); 
				json_encode($dat);
		        for ($i=1; $i <count($dat) ; $i++) { 
					$dat1[$i] = DB::select("SELECT spp.*,mastergudang.mg_namagudang as nama from spp join mastergudang on mastergudang.mg_id =  spp.spp_lokasigudang where spp_nospp = '$dat[$i]'");
		        }
		return view("purchase/laporan/lap_spp/report_spp",compact('dat1'));
	}

	//END OF 


	//---


	//=============================== LAPORAN PO =================================================//

	public function lap_po()
	{
		$data = DB::table('pembelian_order')->select('pembelian_order.*','supplier.nama_supplier as nama')->join('supplier','supplier.idsup','=','pembelian_order.po_supplier')->get();
		return view('purchase/laporan/lap_po/lap_po',compact('data'));
	}
	public function report_po(Request $request){
		$data = $request->a;	
	   		$dat = '';
				for ($save=0; $save <count($data) ; $save++) { 
					$dat = $dat.','.$data[$save];
				}
				$dat =explode(',', $dat); 
				json_encode($dat);
		        for ($i=1; $i <count($dat) ; $i++) { 
					$dat1[$i] = DB::table('pembelian_order')->select('pembelian_order.*','supplier.nama_supplier as nama')->join('supplier','supplier.idsup','=','pembelian_order.po_supplier')->where('po_no','=',$dat[$i])->get();
		        }
		return view("purchase/laporan/lap_po/report_po",compact('dat1'));
	}

	//END OF 


	//---


	//=============================== LAPORAN FAKTUR PAJAK PEMBELIAN =================================================//

	public function lap_fakturpembelian()
	{
		$data = DB::table('faktur_pembelian')->get();
		return view('purchase/laporan/lap_fakturpembelian/lap_fakturpembelian',compact('data'));
	}
	public function report_fakturpembelian(Request $request){
				// dd($request);
		$data = $request->a;	
	   		$dat = '';
				for ($save=0; $save <count($data) ; $save++) { 
					$dat = $dat.','.$data[$save];
				}
				$dat =explode(',', $dat); 
				json_encode($dat);
		        for ($i=1; $i <count($dat) ; $i++) { 
					$dat1[$i] = DB::table('faktur_pembelian')->where('fp_nofaktur','=',$dat[$i])->get();
		        }
		        // dd($dat1);
		return view("purchase/laporan/lap_fakturpembelian/report_fakturpembelian",compact('dat1'));
	}

	//END OF



	// ---


	//START PELUNASAN HUTANG - BAYAR KAS
	public function lap_masterkaskeluar() {
		$array = DB::table('bukti_kas_keluar')->get();
		return view('purchase/laporan/lap_pelunasanhutang-bayarkas/lap_pelunasanhutang-bayarkas',compact('array'));
	}
	public function report_bayarkas(Request $request){
		$data = $request->a;	
	   		$dat = '';
				for ($save=0; $save <count($data) ; $save++) { 
					$dat = $dat.','.$data[$save];
				}
				$dat =explode(',', $dat); 
				json_encode($dat);
		        for ($i=1; $i <count($dat) ; $i++) { 
					$dat1[$i] = DB::table('bukti_kas_keluar')->where('bkk_nota','=',$dat[$i])->get();
		        }
		        // dd($dat1);
		return view("purchase/laporan/lap_pelunasanhutang-bayarkas/report_bayarkas",compact('dat1'));
	}

	//END OF


	//----


	//START PELUNASAN HUTANG - BAYAR BANK
	public function lap_masterbayarbank() {
		$array = DB::table('bukti_bank_keluar')->get();
		return view('purchase/laporan/lap_pelunasanhutang-bayarbank/lap_pelunasanhutang-bayarbank',compact('array'));
	}
	public function report_bayarbank( Request $request ){
			$data = $request->a;	
	   		$dat = '';
				for ($save=0; $save <count($data) ; $save++) { 
					$dat = $dat.','.$data[$save];
				}
				$dat =explode(',', $dat); 
				json_encode($dat);
		        for ($i=1; $i <count($dat) ; $i++) { 
					$dat1[$i] = DB::table('bukti_bank_keluar')->where('bbk_nota','=',$dat[$i])->get();
		        }
		        // dd($dat1);
		return view("purchase/laporan/lap_pelunasanhutang-bayarbank/report_bayarbank",compact('dat1'));
	}
	//END OF


	//-----


	//START LAPORAN PAJAK MASUKAN	
	public function lap_fakturpajakmasukan() {
		$array = DB::table('fakturpajakmasukan')->get();
		return view('purchase/laporan/lap_fakturpajakmasukan/lap_fakturpajakmasukan',compact('array'));
	}
	public function report_fakturpajakmasukan( Request $request ){
			$data = $request->a;	
	   		$dat = '';
				for ($save=0; $save <count($data) ; $save++) { 
					$dat = $dat.','.$data[$save];
				}
				$dat =explode(',', $dat); 
				json_encode($dat);
		        for ($i=1; $i <count($dat) ; $i++) { 
					$dat1[$i] = DB::table('fakturpajakmasukan')->where('fpm_nota','=',$dat[$i])->get();
		        }
		        // dd($dat1);
		return view("purchase/laporan/lap_fakturpajakmasukan/report_fakturpajakmasukan",compact('dat1'));
	}
	//END OF


	//-----
	

	//START LAPORAN PENERIMAAN BARANG	
	public function lap_penerimaanbarang() {
		$array = DB::table('penerimaan_barang')
					->select('penerimaan_barang.*','supplier.nama_supplier as supplier','mastergudang.mg_namagudang as gudang','d_akun.nama_akun as akun')
					->join('supplier','supplier.idsup','=','penerimaan_barang.pb_supplier')
					->join('mastergudang','mastergudang.mg_id','=','penerimaan_barang.pb_gudang')
					->join('d_akun','d_akun.id_akun','=','penerimaan_barang.pb_acchutangdagang')
					->get();
		return view('purchase/laporan/lap_penerimaanbarang/lap_penerimaanbarang',compact('array'));
	}
	public function report_penerimaanbarang( Request $request ){
			$data = $request->a;	
	   		$dat = '';
				for ($save=0; $save <count($data) ; $save++) { 
					$dat = $dat.','.$data[$save];
				}
				$dat =explode(',', $dat); 
				json_encode($dat);
		        for ($i=1; $i <count($dat) ; $i++) { 
					$dat1[$i] = DB::table('penerimaan_barang')
					->select('penerimaan_barang.*','supplier.nama_supplier as supplier','mastergudang.mg_namagudang as gudang','d_akun.nama_akun as akun')
					->join('supplier','supplier.idsup','=','penerimaan_barang.pb_supplier')
					->join('mastergudang','mastergudang.mg_id','=','penerimaan_barang.pb_gudang')
					->join('d_akun','d_akun.id_akun','=','penerimaan_barang.pb_acchutangdagang')
					->where('pb_id','=',$dat[$i])->get();
		        }
		        // dd($dat1);
		return view("purchase/laporan/lap_penerimaanbarang/report_penerimaanbarang",compact('dat1'));
	}
	//END OF


	//-----


	//START LAPORAN PENGELUARAN BARANG	
	public function lap_pengeluaranbarang() {
		$array = DB::table('pengeluaran_barang')->get();
		return view('purchase/laporan/lap_pengeluaranbarang/lap_pengeluaranbarang',compact('array'));
	}
	public function report_pengeluaranbarang( Request $request ){
			$data = $request->a;	
	   		$dat = '';
				for ($save=0; $save <count($data) ; $save++) { 
					$dat = $dat.','.$data[$save];
				}
				$dat =explode(',', $dat); 
				json_encode($dat);
		        for ($i=1; $i <count($dat) ; $i++) { 
					$dat1[$i] = DB::table('pengeluaran_barang')->where('pb_id','=',$dat[$i])->get();
		        }
		        // dd($dat1);
		return view("purchase/laporan/lap_pengeluaranbarang/report_pengeluaranbarang",compact('dat1'));
	}
	//END OF


	//-----



	//START LAPORAN DEPART	
	public function lap_department() {
		$array = DB::table('masterdepartment')->get();
		return view('purchase/laporan/lap_masterdepartment/lap_masterdepartment',compact('array'));
	}
	public function report_masterdepartment( Request $request ){
			$data = $request->a;	
	   		$dat = '';
				for ($save=0; $save <count($data) ; $save++) { 
					$dat = $dat.','.$data[$save];
				}
				$dat =explode(',', $dat); 
				json_encode($dat);
		        for ($i=1; $i <count($dat) ; $i++) { 
					$dat1[$i] = DB::table('masterdepartment')->where('kode_department','=',$dat[$i])->get();
		        }
		        // dd($dat1);
		return view("purchase/laporan/lap_masterdepartment/report_masterdepartment",compact('dat1'));
	}
	//END OF


	//-----



	//START LAPORAN PRESENTASE	
	public function lap_persen() {
		$array = DB::table('master_persentase')->get();
		return view('purchase/laporan/lap_masterpersen/lap_persen',compact('array'));
	}
	public function report_persen( Request $request ){
			$data = $request->a;	
	   		$dat = '';
				for ($save=0; $save <count($data) ; $save++) { 
					$dat = $dat.','.$data[$save];
				}
				$dat =explode(',', $dat); 
				json_encode($dat);
		        for ($i=1; $i <count($dat) ; $i++) { 
					$dat1[$i] = DB::table('master_persentase')->where('kode','=',$dat[$i])->get();
		        }
		        // dd($dat1);
		return view("purchase/laporan/lap_masterpersen/report_persen",compact('dat1'));
	}
	//END OF


	//-----


	//START LAPORAN PRESENTASE	
	public function lap_bbm() {
		$array = DB::table('master_bbm')->get();
		return view('purchase/laporan/lap_bbm/lap_bbm',compact('array'));
	}
	public function report_bbm( Request $request ){
			$data = $request->a;	
	   		$dat = '';
				for ($save=0; $save <count($data) ; $save++) { 
					$dat = $dat.','.$data[$save];
				}
				$dat =explode(',', $dat); 
				json_encode($dat);
		        for ($i=1; $i <count($dat) ; $i++) { 
					$dat1[$i] = DB::table('master_bbm')->where('mb_id','=',$dat[$i])->get();
		        }
		        // dd($dat1);
		return view("purchase/laporan/lap_bbm/report_bbm",compact('dat1'));
	}
	//END OF


	//-----


	//START LAPORAN PRESENTASE	
	public function lap_voucherhutang() {
		$array = DB::table('v_hutang')->get();
		return view('purchase/laporan/lap_voucherhutang/lap_voucherhutang',compact('array'));
	}
	public function report_voucherhutang( Request $request ){
			$data = $request->a;	
	   		$dat = '';
				for ($save=0; $save <count($data) ; $save++) { 
					$dat = $dat.','.$data[$save];
				}
				$dat =explode(',', $dat); 
				json_encode($dat);
		        for ($i=1; $i <count($dat) ; $i++) { 
					$dat1[$i] = DB::table('v_hutang')->where('v_nomorbukti','=',$dat[$i])->get();
		        }
		        // dd($dat1);
		return view("purchase/laporan/lap_voucherhutang/report_voucherhutang",compact('dat1'));
	}
	//END OF


	//-----


	//START LAPORAN UANGMUKA	
	public function lap_uangmuka() {
		$array = DB::table('v_hutang')->get();
		return view('purchase/laporan/lap_uangmuka/lap_uangmuka',compact('array'));
	}
	public function report_uangmuka( Request $request ){
			$data = $request->a;	
	   		$dat = '';
				for ($save=0; $save <count($data) ; $save++) { 
					$dat = $dat.','.$data[$save];
				}
				$dat =explode(',', $dat); 
				json_encode($dat);
		        for ($i=1; $i <count($dat) ; $i++) { 
					$dat1[$i] = DB::table('v_hutang')->where('v_nomorbukti','=',$dat[$i])->get();
		        }
		        // dd($dat1);
		return view("purchase/laporan/lap_uangmuka/report_uangmuka",compact('dat1'));
	}
	//END OF


	//-----


	//START LAPORAN TTT /TANDA TERIMA TAGIHAN	
	public function lap_ttt() {
		$data = DB::table('form_tt')->get();
		return view('purchase/laporan/lap_ttt/lap_ttt',compact('data'));
	}
	public function report_ttt( Request $request ){
			$data = $request->a;	
	   		$dat = '';
				for ($save=0; $save <count($data) ; $save++) { 
					$dat = $dat.','.$data[$save];
				}
				$dat =explode(',', $dat); 
				json_encode($dat);
		        for ($i=1; $i <count($dat) ; $i++) { 
					$dat1[$i] = DB::table('form_tt')->where('tt_idform','=',$dat[$i])->get();
		        }
		        // dd($dat1);
		return view("purchase/laporan/lap_ttt/report_ttt",compact('dat1'));
	}
	//END OF



	public function reportkartuhutang()
	{	
		$supplier = DB::table('supplier')->get();

		$akun = DB::table('d_akun')
			->where(function ($query) {
                $query->where('id_akun', 'like', '2101%')
                      ->orWhere('id_akun', 'like', '2102%');
    		})
    		->orderBy('id_akun','ASC')
    		->get();

		$cabang = DB::table('cabang')->get();
		

		$bbk = DB::select("select bbk_nota as nota, bbk_tgl as tgl, bbkd_nominal as kredit ,bbk_keterangan as keterangan,'K' as flag from bukti_bank_keluar_detail, bukti_bank_keluar where bbkd_idbbk = bbk_id and bbkd_akunhutang like '2101%' ");

		$fp = DB::select("select 'D' as flag, fp_nofaktur as nota,fp_keterangan as keterangan, fp_tgl as tgl , fp_netto as debet from faktur_pembelian where fp_jenisbayar = '2'");

		$um = DB::select("select 'K' as flag, fp_nofaktur as nota,fp_keterangan as keterangan, fp_tgl as tgl, fp_uangmuka as kredit from faktur_pembelian where fp_jenisbayar = '2' and fp_uangmuka != '0' ");

		$bkk = DB::select("select 'K' as flag , bkk_nota as nota,bkk_keterangan as keterangan, bkk_tgl as tgl, bkk_total as kredit from bukti_kas_keluar where bkk_jenisbayar = '2'");

		$data['data'] = array_merge($fp, $um, $bkk , $bbk);

		// return ($data['data']);

		
		return view('purchase/laporan_analisa_pembelian/lap_kartu_hutang/lap_kartu_hutang',compact('supplier','data','akun','cabang'));
	}
	public function carikartuhutan_perakun(Request $request)
	{
		// dd($request->all());
		$min= $request->min;
		$max= $request->max;

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
			$akun = " AND fp_acchutang = '".$request->akun."' ";
		}else{
			$akun = '';
		}
		if ($request->supplier != '' || $request->supplier != null) {
			$supplier = " AND fp_supplier = '".$request->supplier."' ";
		}else{
			$supplier = '';
		}
		if ($request->cabang != '' || $request->cabang != null) {
			$cabang = " AND fp_comp = '".$request->cabang."' ";
		}else{
			$cabang = '';
		}
		
		//untuk bkk
		if ($request->akun != '' || $request->akun != null) {
			$akun_bkk = " AND bkk_akun_hutang = '".$request->akun."' ";
		}else{
			$akun_bkk = '';
		}
		if ($request->supplier != '' || $request->supplier != null) {
			$supplier_bkk = " AND  AND bkk_supplier = '".$request->supplier."'  ";
		}else{
			$supplier_bkk = '';
		}
		if ($request->cabang != '' || $request->cabang != null) {
			$cabang_bkk = " AND bkk_comp = '".$request->cabang."' ";
		}else{
			$cabang_bkk = '';
		}




		$supplier = DB::table('faktur_pembelian')
					->select('fp_idsup')
					->get();

		$arraysup = array($supplier);
		$result_supplier = array_unique($arraysup);

	
		for($j = 0; $j < count($result_supplier); $j++){
			if (isset($result_supplier[0][$j]->fp_idsup)) {
				$idsupplier = 0;
			}else{
				$idsupplier = $result_supplier[0][$j]->fp_idsup;
			}
			$data['carisupp'] = DB::select("select idsup , nama_supplier, no_supplier  from  supplier where idsup = '$idsupplier' and fp_jenisbayar = '2'");
		}


		//return $result_supplier;
		$data['kartuhutang'] = [];
		$totalsupplier = 0;
	
		
		for($i = 0; $i < count($result_supplier); $i++){
			
			$no_supplier = $data['carisupp'][$i]->no_supplier;
		//	return $no_supplier;
			$idsup = $data['carisupp'][$i]->idsup;

			$bbk = DB::select("select bbkd_supplier as supplier,  bbk_nota as nota, bbk_tgl as tgl, bbkd_nominal as nominal ,'K' as flag from bukti_bank_keluar_detail, bukti_bank_keluar where bbkd_idbbk = bbk_id and bbkd_akunhutang LIKE '2101%' and bbkd_supplier = '$no_supplier'");


			$fp = DB::select("select 'D' as flag, fp_nofaktur as nota , fp_idsup, fp_tgl as tgl , fp_netto as nominal from faktur_pembelian where fp_jenisbayar = '2' and fp_idsup = '$idsup' ");


			$um = DB::select("select 'K' as flag, fp_idsup as supplier, fp_nofaktur as nota, fp_tgl as tgl, fp_uangmuka as nominal from faktur_pembelian where fp_jenisbayar = '2' and fp_uangmuka != 0.00 and fp_idsup = '$idsup'");

			$bkk = DB::select("select 'K' as flag , bkk_supplier as supplier, bkk_nota as nota, bkk_tgl as tgl, bkk_total as nominal from bukti_kas_keluar where bkk_jenisbayar = '2' and bkk_supplier = '$no_supplier'");


			$datas= array_merge($fp, $um, $bkk , $bbk);

			array_push($data['kartuhutang'] , $datas);

		}

		$totalhutangdebit = 0;
		$totalhutangkredit = 0;
		$data['totalhutangkredit'] = [];
		$data['totalhutangdebit'] = [];

		for($i = 0; $i < count($data['kartuhutang']); $i++){
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

		


		// $bbk = DB::select("select 'K' as flag,bbk_nota as nota, bbk_tgl as tgl, bbkd_nominal as kredit ,bbk_keterangan as keterangan from bukti_bank_keluar_detail, bukti_bank_keluar where bbkd_idbbk = bbk_id and bbk_tgl >= '$min' AND bbk_tgl <= '$max' $akun_bbk $cabang_bbk $supplier_bbk ");

		// $fp = DB::select("select 'D' as flag, fp_nofaktur as nota,fp_keterangan as keterangan, fp_tgl as tgl , fp_netto as debet from faktur_pembelian where fp_jenisbayar = '2' and fp_tgl >= '$min' AND fp_tgl <= '$max' $akun $supplier $cabang ");

		// $um = DB::select("select 'K' as flag, fp_nofaktur as nota,fp_keterangan as keterangan, fp_tgl as tgl, fp_uangmuka as kredit from faktur_pembelian where fp_jenisbayar = '2' and fp_uangmuka != '0' and fp_tgl >= '$min' AND fp_tgl <= '$max' $akun $supplier $cabang");

		// $bkk = DB::select("select 'K' as flag , bkk_nota as nota,bkk_keterangan as keterangan, bkk_tgl as tgl, bkk_total as kredit from bukti_kas_keluar where bkk_jenisbayar = '2' and bkk_tgl >= '$min' AND bkk_tgl <= '$max' $akun_bkk $supplier_bkk $cabang_bkk ");

		// $data['data'] = array_merge($fp, $um, $bkk , $bbk);
		return view('purchase/laporan_analisa_pembelian/lap_kartu_hutang/kartu_hutang/ajax_pencarian_akun',compact('supplier','data','akun','cabang')); 

	}

	public function carikartuhutang_persupplier(Request $request){

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

		// KARTU HUTANG REKAP BERDASARKAN AKUN

		// dd($request->all());
		$tglawal = $request->min;
		$tglakhir = $request->max;
		
		// $d = new Date($tglakhir); 
		// $d->modify('first day of previous month');
		$date = date("Y-m-j", strtotime("last day of previous month"));

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


			array_push($data['saldoawal'], $saldoawal);
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

			$bbk = DB::select("select bbkd_supplier as supplier,  bbk_nota as nota, bbk_tgl as tgl, bbkd_nominal as nominal ,'K' as flag,bbk_keterangan as keterangan from bukti_bank_keluar_detail, bukti_bank_keluar where bbkd_idbbk = bbk_id and bbkd_akunhutang LIKE '2101%' and bbkd_supplier = '$no_supplier' and bbk_tgl BETWEEN '$tglawal' and '$tglakhir' $akun_bbk $supplier_bbk $cabang_bbk");


			$fp = DB::select("select  'D' as flag, fp_nofaktur as nota , fp_idsup as supplier, fp_tgl as tgl , fp_netto as nominal,fp_keterangan as keterangan from faktur_pembelian where fp_jenisbayar = '2' and fp_idsup = '$idsup' and fp_tgl BETWEEN '$tglawal' and '$tglakhir' $akun_fp $supplier_fp $cabang_fp");


			$um = DB::select("select 'K' as flag, fp_idsup as supplier, fp_nofaktur as nota, fp_tgl as tgl, fp_uangmuka as nominal,fp_keterangan as keterangan from faktur_pembelian where fp_jenisbayar = '2' and fp_uangmuka != 0.00 and fp_idsup = '$idsup' and fp_tgl BETWEEN '$tglawal' and '$tglakhir' $akun_fp $supplier_fp $cabang_fp");

			$bkk = DB::select("select 'K' as flag , bkk_supplier as supplier, bkk_nota as nota, bkk_tgl as tgl, bkk_total as nominal,bkk_keterangan as keterangan from bukti_kas_keluar where bkk_jenisbayar = '2' and bkk_supplier = '$no_supplier' and bkk_tgl BETWEEN '$tglawal' and '$tglakhir' $akun_bkk  $cabang_bkk");


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

			
		 json_encode($data);

		 return view('purchase/laporan_analisa_pembelian/lap_kartu_hutang/kartu_hutang/ajax_pencarian_supplier',compact('data','date'));
	}


	public function carikartuhutang_persupplier_detail(Request $request){

		// dd($request->all());
		$tglawal = $request->min;
		$tglakhir = $request->max;

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

			
				$hutangbaru = DB::select("select 'hutangbaru' as flag,fp_keterangan as keterangan,  fp_tgl as tgl, fp_idsup as supplier , fp_nofaktur as nota , fp_netto as nominal from faktur_pembelian where fp_tgl > '$tglakhir' and fp_idsup = '$idsup'");
			


			$datavc = DB::select("select * from v_hutang where v_tgl BETWEEN '$tglawal' and '$tglakhir' and v_supid = '$no_supplier'");
			
			$vc = DB::select("select 'VC' as flag, v_tgl as tgl, v_supid as supplier,v_keterangan as keterangan, v_nomorbukti as nota, v_hasil as nominal from v_hutang where v_tgl BETWEEN '$tglawal' and '$tglakhir' and v_supid = '$no_supplier'");
			
			$datacn = DB::select("select * from cndnpembelian where cndn_jeniscndn = 'K' and cndn_tgl BETWEEN '$tglakhir' and '$tglawal' and cndn_supplier = '$idsup'");
		
				$cn = DB::select("select 'CN' as flag, cndn_tgl as tgl, cndn_supplier as supplier ,cndn_keterangan as keterangan, cndn_nota as nota, cndn_bruto as nominal from cndnpembelian where cndn_jeniscndn = 'K' and cndn_supplier = '$idsup' and cndn_tgl BETWEEN '$tglawal' and '$tglakhir'" );
			

			$datadn = DB::select("select * from cndnpembelian where cndn_jeniscndn = 'D' and cndn_tgl BETWEEN '$tglakhir' and '$tglawal' and cndn_supplier = '$idsup'");
		
				$dn = DB::select("select 'DN' as flag, cndn_tgl as tgl, cndn_supplier as supplier ,cndn_keterangan as keterangan, cndn_nota as nota, cndn_bruto as nominal from cndnpembelian where cndn_tgl BETWEEN '$tglawal' and '$tglakhir' and cndn_jeniscndn = 'D' and cndn_supplier = '$idsup'");


			$datacash = DB::select("select * from bukti_kas_keluar where bkk_tgl BETWEEN '$tglakhir' and '$tglawal' and bkk_supplier = '$no_supplier'");
			
			$cash = DB::select("select bbkd_supplier as supplier,  bbk_nota as nota, bbk_tgl as tgl,bbk_keterangan as keterangan, bbkd_nominal as nominal ,'K' as flag from bukti_bank_keluar_detail, bukti_bank_keluar where bbkd_idbbk = bbk_id and bbkd_supplier = '$idsup' and bbk_tgl BETWEEN '$tglawal' and '$tglakhir'");


			$bkk = DB::select("select 'BG' as flag , bkk_supplier as supplier, bkk_nota as nota, bkk_tgl as tgl, bkk_total as nominal from bukti_kas_keluar where bkk_jenisbayar = '2' and bkk_supplier = '$no_supplier' and bkk_tgl BETWEEN '$tglawal' and '$tglakhir'");

			$returnbeli = DB::select("select 'RN' as flag, rn_supplier as supplier,rn_keterangan as keterangan, rn_nota as nota, rn_tgl as tgl, rn_totalreturn as nominal from returnpembelian where rn_supplier = '$idsup' and rn_tgl BETWEEN '$tglawal' and '$tglakhir'");


			$isidetail = array_merge($hutangbaru , $vc, $cn, $dn, $cash, $bkk, $returnbeli);
			array_push($data['isidetail'] , $isidetail);
		}
		// return $data;

		return view('purchase/laporan_analisa_pembelian/lap_kartu_hutang/kartu_hutang/ajax_pencarian_supplier_detail',compact('data','date'));

	}


	public function carikartuhutang_perakun(Request $request){

		// KARTU HUTANG REKAP BERDASARKAN AKUN

		$tglawal = $request->min;
		$tglakhir = $request->max;

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

			$bbk = DB::select("select bbkd_supplier as supplier,  bbk_nota as nota, bbk_tgl as tgl, bbkd_nominal as nominal ,'K' as flag from bukti_bank_keluar_detail, bukti_bank_keluar where bbkd_idbbk = bbk_id and bbkd_akunhutang LIKE '2103%' and bbkd_supplier = '$idsup' and bbk_tgl BETWEEN '$tglawal' and '$tglakhir'");


			$fp = DB::select("select  'D' as flag, fp_nofaktur as nota , fp_idsup as supplier, fp_tgl as tgl , fp_netto as nominal from faktur_pembelian where fp_jenisbayar = '$jenisbayar' and fp_supplier = '$idsup' and fp_tgl BETWEEN '$tglawal' and '$tglakhir'");

			
			$um = DB::select("select 'K' as flag, fp_idsup as supplier, fp_nofaktur as nota, fp_tgl as tgl, fp_uangmuka as nominal from faktur_pembelian where fp_jenisbayar = '$jenisbayar' and fp_uangmuka != 0.00 and fp_supplier = '$idsup' and fp_tgl BETWEEN '$tglawal' and '$tglakhir'");

			$bkk = DB::select("select 'K' as flag , bkk_supplier as supplier, bkk_nota as nota, bkk_tgl as tgl, bkk_total as nominal from bukti_kas_keluar where bkk_jenisbayar = '$jenisbayar' and bkk_supplier = '$idsup' and bkk_tgl BETWEEN '$tglawal' and '$tglakhir'");


			return $datas= array_merge( $fp, $um, $bkk , $bbk);

			array_push($data['kartuhutang'] , $datas);

			return view('purchase/laporan_analisa_pembelian/lap_kartu_hutang/kartu_hutang/ajax_pencarian_supplier_detail',compact('data','date'));
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


	//-- LAPORAN MUTASI HUTANG


 	

	//-- END LAPORAN


	//-- LAPORAN ANALISA HUTANG

	public function reportanalisausiahutang(Request $request)
	{
		 return view('purchase/laporan/analisausiahutang');
	}

	//-- END LAOPRAN

}
