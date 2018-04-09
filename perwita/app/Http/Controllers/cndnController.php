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
use App\fakturpajakmasukan;
use DB;
Use Carbon\Carbon;
use Session;
use Mail;
use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;


class cndnController extends Controller
{
	

	public function cndnpembelian() {
		return view('purchase/cndn_pembelian/index');
	}



	public function save(Request $request){
		return json_encode('ok');
	}
	public function getnota (Request $request){
		$cabang = $request->comp;
		
		$mon = Carbon::now(); 
		$cndn = DB::select("select * from cndnpembelian where cndn_comp = '$cabang' and created_at = '$mon' order by cndn_id desc limit 1");
		
		if(count($cndn) > 0) {
			$explode = explode("/", $cndn[0]->cndn_nota);
			$idcndn = $explode[2];
		

			$idcndn = (int)$idcndn + 1;
			$data['idcndn'] = str_pad($idcndn, 3, '0', STR_PAD_LEFT);
			
		}
		else {
			$data['idcndn'] = '001';
		}

		$data['ppn'] = DB::select("select * from d_akun where kode_cabang = '$cabang' and id_akun LIKE '2302%' ");
		$data['pph'] = DB::select("select * from d_akun where kode_cabang = '$cabang' and id_akun LIKE '2305%'  or id_akun LIKE '2306%' or id_akun LIKE '2307%' or id_akun LIKE '2308%' or id_akun LIKE '2309%' ");
		return json_encode($data);
	
	}


	public function getsupplier(Request $request){
		$idjenis = $request->idjenis;

		if($idjenis == '2'){ // SUPPLIER HUTANG DAGANG
			$data['isi'] = DB::select("select * from supplier where status = 'SETUJU' and active = 'AKTIF' ");
		}
		elseif($idjenis == '6'){ //BIAYA AGEN / VENDOR
			$data['isi'] = DB::select("select kode, nama from agen where kategori = 'AGEN' union select kode,nama from vendor");

		}
		elseif($idjenis == '7'){ // OUTLET
			$data['isi'] = DB::select("select * from agen where kategori = 'OUTLET'");

		}
		elseif($idjenis == '3'){ // voucher hutang
			$data['isi'] = DB::select("select * from supplier where status = 'SETUJU' and active = 'AKTIF' ");
		}
		elseif($idjenis == '4'){ // UANG MUKA PEMBELIAN
			$data['isi'] = DB::select("select no_supplier as kode, nama_supplier as nama from supplier where status = 'SETUJU' and active = 'AKTIF' union select kode , nama from vendor union select kode, nama from agen union select kode, nama from subcon");
		}
		elseif($idjenis == '9'){ // SUBCON
			$data['isi'] = DB::select("select * from subcon ");
		}
		elseif($idjenis == '1'){
			$data['isi'] = DB::select("select * from cabang");
 		}

 		return json_encode($data);
	}

	public function getfaktur(Request $request){
		$idsup = $request->idsup;
		$idjenisbayar = $request->jenis;
		$cabang = $request->cabang;

		if($idjenisbayar == '2' ){
				$data['fakturpembelian'] = DB::select("select * from faktur_pembelian, supplier, form_tt , cabang where fp_idsup ='$idsup' and fp_jenisbayar = '$idjenisbayar' and fp_idsup = idsup and fp_idtt = tt_idform and fp_comp = kode and fp_sisapelunasan != '0.00' and fp_comp = '$cabang'");
				
			}
			else if($idjenisbayar == '6' || $idjenisbayar == '7'  ){
				$data['fakturpembelian'] = DB::select("select fp_jatuhtempo, fp_idfaktur, fp_nofaktur, cabang.nama as namacabang, fp_noinvoice, agen.nama as namaoutlet , fp_sisapelunasan from  agen , cabang, faktur_pembelian LEFT OUTER JOIN form_tt on fp_nofaktur = tt_nofp where  fp_jenisbayar = '$idjenisbayar'  and fp_comp = cabang.kode and fp_sisapelunasan != '0.00' and fp_supplier = '$idsup' and fp_supplier = agen.kode and fp_pending_status = 'APPROVED' and fp_comp = '$cabang'" );
			}
			else if($idjenisbayar == '9'){
				$data['fakturpembelian'] = DB::select("select fp_jatuhtempo, fp_idfaktur, fp_nofaktur, cabang.nama as namacabang, fp_noinvoice, subcon.nama as namavendor , fp_sisapelunasan from  subcon , cabang, faktur_pembelian LEFT OUTER JOIN form_tt on fp_nofaktur = tt_nofp where  fp_jenisbayar = '$idjenisbayar'  and fp_comp = cabang.kode and fp_sisapelunasan != '0.00' and fp_supplier = '$idsup' and fp_supplier = subcon.kode and fp_pending_status = 'APPROVED' and fp_comp = '$cabang'" );
			}
			
	
		return json_encode($data);
	}

	public function hslfaktur(Request $request){
	

		for($i = 0; $i < count($request->checked); $i++){
			$idfaktur = $request->checked[$i];
			$data['faktur'][] = DB::select("select * from faktur_pembelian where fp_idfaktur = '$idfaktur'");
		}

		return json_encode($data);
	}

	public function createcndnpembelian() {

		$data['cabang'] = DB::select("select * from cabang");
		$data['supplier'] = DB::select("select * from supplier where active = 'AKTIF' and status = 'SETUJU'");
		$data['pph'] = DB::select("select * from pajak");
		$data['akunbiaya'] = DB::select("select * from akun_biaya");
		return view('purchase/cndn_pembelian/create' , compact('data'));
	}

	public function detailcndnpembelian() {
		return view('purchase/cndn_pembelian/detail');
	}
}