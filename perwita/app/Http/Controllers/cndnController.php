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
use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;


class cndnController extends Controller
{
	

	public function cndnpembelian() {
		$cabang = session::get('cabang');
		if($cabang == 000){
			$data['cndn'] = DB::select("select * from cndnpembelian ");
		}
		else {
			$data['cndn'] = DB::select("select * from cndnpembelian where cndn_comp = '$cabang'");
		}
		return view('purchase/cndn_pembelian/index', compact('data'));
	}



	public function save(Request $request){

	
		$id = DB::table('cndnpembelian')  	
	    		->max('cndn_id'); 
						if(isset($id)) {
							$id = $id;
							$id = (int)$id + 1;
							
						}
						else {
							$id = 1;
						}

		$bruto = str_replace(',', '', $request->bruto);						
		$jumlahppn = str_replace(',', '', $request->jumlahppn);						
		$jumlahpph = str_replace(',', '', $request->jumlahpph);	

		$cndn = new cndn();	
		$cndn->cndn_id			= $id;	
		$cndn->cndn_tgl			= $request->tgl;
		$cndn->cndn_supplier	= $request->supplier;
		$cndn->cndn_acchutangdagang = $request->acchutang;
		$cndn->cndn_acccndn		= $request->accbiaya;
		$cndn->cndn_bruto = $bruto;
		$cndn->cndn_comp = $request->cabang;
		$cndn->cndn_nota = $request->nota;
		$cndn->cndn_hasilppn = $request->hasilppn;				
		$cndn->cndn_hasilpph = $request->hasilpph;				
		$cndn->create_by = $request->username;
		$cndn->cndn_jeniscndn = $request->jeniscndn;
		$cndn->cndn_jenissup = $request->jenissup;
		$cndn->cndn_keterangan = $request->keterangan;
		$cndn->save();
		

		for($i = 0; $i < count($request->idfaktur); $i++){

			
			$sisahutang = str_replace(',', '', $request->sisahutang[$i]);
			$nettocn = str_replace(',', '', $request->nettocn[$i]);


			$iddt = DB::table('cndnpembelian_dt')  	
	    		->max('cndt_id'); 
						if(isset($id)) {
							$iddt = $iddt;
							$iddt = (int)$iddt + 1;
							
						}
						else {
							$iddt = 1;
						}

		
				$cndt = new cndn_dt();
				$cndt->cndt_id =  $iddt;
				$cndt->cndt_idcn = $id;
				$cndt->cndt_idfp = $request->idfaktur[$i];
				$cndt->cndt_tgl = $request->tgl;
			
				$cndt->cndt_sisahutang = $sisahutang;
				$cndt->create_by = $request->username;
				$cndt->cndt_nettocn = $nettocn;
				if(isset($request->inputppn[$i])) {
						
						
				}
				else {
					//$nilaippn = str_replace(',', '', $request->nilaippn);	
						$hasilppn = str_replace(',', '', $request->nilaipph[$i]);	
						$cndt->cndt_jenisppn = $request->jenisppn[$i];
						$cndt->cndt_nilaippn = $request->inputppn[$i];
						$cndt->cndt_hasilppn = $hasilppn;
				}

				if(isset($request->inputpph[$i]) ) {
					
						
				}
				else {
					//	$nilaippn = str_replace(',', '', $request->nilaipph);	
						$hasilpph = str_replace(',', '', $request->hasilpph[$i]);	
						$cndt->cndt_jenispph = $request->jenispph[$i];
						$cndt->cndt_nilaipph = $request->inputpph[$i];
						$cndt->cndt_hasilpph = $hasilpph;
				}
				$cndt->save();
			

			

			
		}

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

	public function detailcndnpembelian($id) {

		$data['cndndt'] = DB::select("select * from cndnpembelian, cndnpembelian_dt, faktur_pembelian where cndt_idcn = cndn_id and cndn_id ='$id' and cndt_idfp = fp_idfaktur ");

		$data['cndn'] = DB::select("select * from cndnpembelian where cndn_id = '$id'");
		$data['cabang'] = DB::select("select * from cabang");
		$data['supplier'] = DB::select("select * from supplier where active = 'AKTIF' and status = 'SETUJU'");
		$data['pph'] = DB::select("select * from pajak");
		$data['akunbiaya'] = DB::select("select * from akun_biaya");

	//	dd($data);

		return view('purchase/cndn_pembelian/detail', compact('data'));
	}
}