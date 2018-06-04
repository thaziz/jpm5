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
		return view('purchase/laporan_analisa_pembelian/lap_kartu_hutang/lap_kartu_hutang');
	}


	//-----



}
