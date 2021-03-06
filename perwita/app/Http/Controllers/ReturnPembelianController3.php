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


class ReturnPembelianController extends Controller
{
	


	public function returnpembelian() {
		$cabang = session::get('cabang');

		if($cabang == 000){
			$data['rn'] = DB::select("select * from returnpembelian, pembelian_order , supplier where rn_supplier = idsup and rn_idpotidakaktif = po_id ");
		}
		else {
			$data['rn'] = DB::select("select * from returnpembelian , pembelian_orer, supplier where rn_supplier = idsup where rn_cabang = '$cabang' and rn_idpotidakaktif = po_id");
		}

		return view('purchase/return_pembelian/index' , compact('data'));
	}

	public function createreturnpembelian(){
		$data['cabang'] = DB::select("select * from cabang");
		$data['supplier'] = DB::select("select * from supplier where active = 'AKTIF' and status = 'SETUJU'");
		return view('purchase/return_pembelian/create', compact('data'));
	}

	public function getpo(Request $request){
		$supplier = $request->supplier;
		$data['po'] = DB::select("select * from pembelian_order where po_supplier = '$supplier' and po_idfaktur is null and po_setujufinance = 'DISETUJUI' and po_statusreturn = 'AKTIF'");

		return json_encode($data);
	}


	public function detailreturnpembelian ($id){
		$cabang = session::get('cabang');

		if($cabang == 000){
			$data['rn'] = DB::select("select * from returnpembelian, pembelian_order , supplier where rn_supplier = idsup and rn_idpotidakaktif = po_id and rn_id = '$id'");

			$data['rndt'] = DB::select("select * from returnpembelian, returnpembelian_dt , pembelian_order , masteritem where rndt_id = rn_id and rn_idpotidakaktif = po_id and rndt_item = kode_item and rn_id = '$id'");

			$data['cabang'] = DB::select("select * from cabang");
			$data['supplier'] = DB::select("select * from supplier where active = 'AKTIF' and status = 'SETUJU'");
		}
		else {
		$data['rn'] = DB::select("select * from returnpembelian, pembelian_order , supplier where rn_supplier = idsup and rn_idpotidakaktif = po_id and rn_id = '$id' and rn_cabang = '$cabang'");

			$data['rndt'] = DB::select("select * from returnpembelian, returnpembelian_dt , pembelian_order , masteritem where rndt_id = rn_id and rn_idpotidakaktif = po_id and rndt_item = kode_item and rn_id = '$id' and rn_cabang = '$cabang'");
			$data['cabang'] = DB::select("select * from cabang");
			$data['supplier'] = DB::select("select * from supplier where active = 'AKTIF' and status = 'SETUJU'");
		}

		return view('purchase/return_pembelian/detail' , compact('data'));
	}

	public function hapusdata ($id){

	}
	public function hslfaktur(Request $request){

		$idpo = $request->checked[0];

		$data['po'] = DB::select("select * from pembelian_order, pembelian_orderdt, masteritem where podt_idpo = po_id and po_id = '$idpo' and podt_kodeitem = kode_item");
		
		return json_encode($data);

	}

	public function getnota (Request $request){
		$cabang = $request->comp;
		$bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('y');

		/*$mon = date('Y-m'); */
		$mon =Carbon::now(); 


		//return $mon;
		$rn = DB::select("select * from returnpembelian where rn_cabang = '$cabang'  and to_char(rn_tgl, 'MM') = '$bulan' and to_char(rn_tgl, 'YY') = '$tahun' order by rn_id desc limit 1");
		
		if(count($rn) > 0) {
			$explode = explode("/", $rn[0]->rn_nota);
			$idrn = $explode[2];
		

			$idrn = (int)$idrn + 1;
			$data['idreturn'] = str_pad($idrn, 3, '0', STR_PAD_LEFT);
			
		}
		else {
			$data['idreturn'] = '001';
		}

		
		return json_encode($data);
	
	}


	public function save(Request $request){
		return DB::transaction(function() use ($request) {  
		
		$lastid = returnpembelian::max('rn_id'); 
		$total = str_replace(',', '',  $request->total);
		$subtotal = str_replace(',', '',  $request->subtotal);
		$ppn = str_replace(',', '',  $request->ppn);
		$hasilppn = str_replace(',', '',  $request->hasilppn);
		$cabang = $request->cabang;
		if(isset($lastid)) {
			$idrn = $lastid;
			$idrn = (int)$idrn + 1;
		}

		else {
			$idrn = 1;
		}

		$rn = new returnpembelian();
		$rn->rn_id = $idrn;
		$rn->rn_tgl = $request->tgl;
		$rn->rn_supplier = $request->supplier;
		$rn->rn_keterangan = $request->keterangan;
		$rn->create_by = $request->username;
		$rn->rn_subtotal = $subtotal;
		$rn->rn_jenisppn = $request->jenisppn;
		$rn->rn_idpoaktif = $request->idpo;
		$rn->rn_idpotidakaktif = $request->idpo;
		
		if($request->jenisppn == 'T'){

		}
		else {
			$rn->rn_ppn = $ppn;
			$rn->rn_hasilppn = $hasilppn;
			$rn->rn_inputppn = $request->inputppn;

		}

		$rn->rn_totalharga = $total;
		$rn->rn_nota = $request->nota;
		$rn->rn_cabang = $request->cabang;
		$rn->save();

		for($i = 0; $i < count($request->kodeitem); $i++){

		$lastidrndt = returnpembelian_dt::max('rndt_id'); 

		

		if(isset($lastidrndt)) {
			//return $lastidrndt . 'isser';
			$idrndt = $lastidrndt;
			$idrndt = (int)$idrndt + 1;
			//return $idrndt;
		}

		else {
			//	return $lastidrndt . 'tdkisset';
			$idrndt = 1;
		}
		$jumlahharga = str_replace(',', '',  $request->jumlahharga[$i]);
		$totalharga = str_replace(',', '',  $request->totalharga[$i]);

			$rndt = new returnpembelian_dt();
			$rndt->rndt_id = $idrndt;
			$rndt->rndt_idrn = $idrn;
			$rndt->rndt_item = $request->kodeitem[$i];
			$rndt->rndt_qtypo = $request->qtypo[$i];
			$rndt->rndt_qtyreturn = $request->qtyretrun;
			$rndt->rndt_harga = $jumlahharga[$i];
			$rndt->rndt_totalharga = $totalharga[$i];
			$rndt->create_by = $request->username;
			$rndt->save();
		}
		
		// update PO
		$idpo = $request->idpo;
		$updatepo = purchase_orderr::where('po_id' , $idpo);

		$updatepo->update([
		 	'po_statusreturn' => 'TIDAK AKTIF'
	 		]);	


		// NAMBAH ROW PO
		$po = new purchase_orderr();

		$lastidpo = purchase_orderr::max('po_id'); 
		if(isset($lastidpo)) {
			$idpo2 = $lastidpo;
			$idpo2 = (int)$idpo2 + 1;
		}

		else {
			$idpo2 = 1;
		}

		$data['po'] = DB::select("select * from pembelian_order where po_id = '$idpo'");

		$po->po_id = $idpo2;
		$po->po_no = $request->nopo;
		$po->po_catatan = $data['po'][0]->po_catatan;
		$po->po_bayar = $data['po'][0]->po_bayar;

		$po->po_status ='LENGKAP';
		
		

		$po->po_supplier = strtoupper($request->supplier);
		
		if($request->jenisppn == 'T'){

		}
		else {
			$hasilppn = str_replace(',', '', $request->hasilppn);
			$po->po_ppn = strtoupper($request->inputppn);
			$po->po_hasilppn = $hasilppn;
		}

		$subtotal = str_replace(',', '', $request->subtotal);
		$total = str_replace(',', '', $request->total);
		$po->po_subtotal = $subtotal;
		$po->po_totalharga = $total;
		$po->po_noform = $data['po'][0]->po_noform;
		$po->po_cabang = $data['po'][0]->po_cabang;
		$po->po_updatefp = $data['po'][0]->po_updatefp;
		$po->po_tipe = $data['po'][0]->po_tipe;
		$po->po_penerimaan = $data['po'][0]->po_penerimaan;
		$po->po_jenisppn = $request->jenisppn;
		$po->po_statusreturn = 'AKTIF';
		$po->create_by = $request->username;	
		$po->po_setujufinance = 'DISETUJUI';
	//	$po->save();


		
		// update PO
		
		$updatereturn = returnpembelian::where('rn_id' , $idrn);

		$updatereturn->update([
		 	'rn_idpoaktif' => $idpo2,
	 		]);	


		
		$data['podt'] = DB::select("select * from pembelian_orderdt where podt_idpo = '$idpo'");


		for($n = 0; $n < count($data['podt']); $n++) {
		
				$lastidpo = purchase_orderdt::max('podt_id'); 
				if(isset($lastidpo)) {
					$podt_id = $lastidpo;
					$podt_id = (int)$podt_id + 1;
				}
				else {
					$podt_id = 1;
				}

				$podt = new purchase_orderdt();
				$podt->podt_id = $podt_id;
				$podt->podt_kodeitem = $data['podt'][$n]->podt_kodeitem;
				$podt->podt_approval = $data['podt'][$n]->podt_approval;
				$podt->podt_qtykirim = $data['podt'][$n]->podt_qtykirim;
				$podt->podt_supplier =	$data['podt'][$n]->podt_supplier;

			

				$podt->podt_jumlahharga = $data['podt'][$n]->podt_jumlahharga;
				$podt->podt_statuskirim = $data['podt'][$n]->podt_statuskirim;
				$podt->podt_idspp = $data['podt'][$n]->podt_idspp;
				$podt->podt_idpo = $idpo2;
				$podt->podt_totalharga = $data['podt'][$n]->podt_totalharga;
				$podt->podt_lokasigudang = $data['podt'][$n]->podt_lokasigudang;
				$podt->create_by = $request->username;	
			//	$podt->save();

			}

			//update podt
			for($j = 0; $j < count($request->kodeitem); $j++){
				$updatepodt = purchase_orderdt::where([['podt_idpo' , '=' , $idpo2],['podt_kodeitem' , '=' , $request->kodeitem[$j]]]);
				$hasilqty = (int)$request->qtypo[$j] - (int)$request->qtyreturn[$j];
				$jumlahharga = str_replace(',', '', $request->jumlahharga[$j]);
				$totalharga = str_replace(',', '', $request->totalharga[$j]);
				$updatepodt->update([
					'podt_approval' => $hasilqty,
				 	'podt_qtykirim' => $hasilqty,
				 	'podt_jumlahharga' => $jumlahharga,
				 	'podt_totalharga' => $totalharga,
			 		]);
			}


		

			$datastockmutation = 0;
			for($k = 0; $k < count($request->kodeitem); $k++){
				$iditem = $request->kodeitem[$k];
				$data['iditem'][] = $iditem;
				$data['pb'][] = DB::select("select * from penerimaan_barangdt where pbdt_po = '$idpo' and pbdt_item = '$iditem'");

				$hitungpb = count($data['pb']);

				if($hitungpb != 0){ // jika jumlah pb tidak 0
					for($i = 0 ; $i < count($data['pb']); $i++){
						for ($j = 0; $j < count($data['pb'][$i]); $j++){
							$jumlahperitem = 0;

							//	return $hitungpb;
								for($z = 0; $z < count($data['pb']); $z++){
									for($x = 0; $x < count($data['pb'][$z]); $x++){
										$jumlahperitem = $jumlahperitem + $data['pb'][$z][$x]->pbdt_qty;
									//	$jumlahperitem = 3;
									}
								}

								
								//	return $qty . $idpbdt . $iditem . $idpo . $jumlahperitem . $request->qtyreturn[$k];
								$hz = (int) count($data['pb'][$i]) - 1;
								if($jumlahperitem >= $request->qtyreturn[$k]){ // 

									$qty = $data['pb'][$i][$hz]->pbdt_qty;
									$idpbdt = $data['pb'][$i][$hz]->pbdt_qty;

									if($request->qtyreturn[$k] == $qty){ // SAMA

										$updatepbdt =  penerimaan_barangdt::where([['pbdt_po' , '=' ,$idpo],['pbdt_item' , '=' , $iditem],['pbdt_id' , '=' , $idpbdt]]);						
										$updatepbdt->update([
											'pbdt_qty' => 0,
											]);


										
									//	return $idpo . $iditem . $idpbdt;
										$idpb = $data['pb'][$i][$hz]->pbdt_idpb;


											//update di stockmutation di penerimaan barang
										$updatesmt = stock_mutation::where([['sm_flag' , '=' , 'PO'], ['sm_po' , '=' , $idpb] , ['sm_id_gudang' , '=' , $request->lokasigudang[$k] ], ['sm_comp' , '=' , $cabang] , ['sm_item' , '=' , $iditem]]);

										$updatesmt->update([
											'sm_qty' => 0,
											'sm_sisa' => 0,
											'update_by' => $request->username
											]);
									} // END SAMA
									else if($request->qtyreturn[$k] > $qty) {
										$hasilselisih = (int)$request->qtyreturn[$k] - (int)$qty;
										$updatepbdt =  penerimaan_barangdt::where([['pbdt_po' , '=' ,$idpo],['pbdt_item' , '=' , $iditem],['pbdt_id' , '=' , $idpbdt]]);						
										$updatepbdt->update([
											'pbdt_qty' => $hasilselisih,
											]);


										
									//	return $idpo . $iditem . $idpbdt;
										$idpb = $data['pb'][$i][$j]->pbdt_idpb;


											//update di stockmutation di penerimaan barang
										$updatesmt = stock_mutation::where([['sm_flag' , '=' , 'PO'], ['sm_po' , '=' , $idpb] , ['sm_id_gudang' , '=' , $request->lokasigudang[$k] ], ['sm_comp' , '=' , $cabang] , ['sm_item' , '=' , $iditem]]);

										$updatesmt->update([
											'sm_qty' => $hasilselisih,
											'sm_sisa' => $hasilselisih,
											'update_by' => $request->username
											]);
									}
									else {
										//perulangan

										
									}





								} // end jumlahperitem >= $request->qtyreturn[$k]
							
							} // for data[pb][0]
						} // for data[pb]
					} // jika jumlah pb tidak 0
				
					


			}// END FOR KODEITEM
			
			return json_encode($data);
			
			//update pbdt
		/*	for($j = 0; $j < count($request->kodeitem); $j++){
				$iditem = $request->kodeitem[$j];
				$jumlahterima = 0;


				$data['pb'][] = DB::select("select * from penerimaan_barangdt where pbdt_po = '$idpo' and pbdt_item = '$iditem'");

				//return json_encode($data);
				if(count($data['pb'][0]) != 0 ) {
					for($x = 0 ; $x < count($data['pb'][0]); $x++){
						$jumlahterima = $jumlahterima + (int)$data['pb'][0][$x]->pbdt_qty;
					}

					

				//update peritem di pbdt
				$hasilqty = (int)$request->qtypo[$j] - (int)$request->qtyreturn[$j];

			

				//return $hasilqty . $jumlahterima;
				if((int)$jumlahterima > $hasilqty){
					//update idpo di penerimaan barang
						$updatepb = penerimaan_barang::where('pb_po' , $idpo);
						$updatepb->update([
							'pb_po' => $idpo2,
							]);

						$updatepbdt =  penerimaan_barangdt::where('pbdt_po' ,$idpo);
						$updatepbdt->update([
							'pbdt_po' => $idpo2,
							]);
						
						//STOCK MUTATION
						
						$stock_mutation = new stock_mutation();
						$lastidsm = stock_mutation::max('sm_id'); 
						$mytime = Carbon::now(); 

						if(isset($lastidsm)) {
							$idsm = $lastidsm;
							$idsm = (int)$lastidsm + 1;
						}
						else {
							$idsm = 1;
						}
						$datagudang2 = DB::select("select * from stock_gudang where sg_item = '$iditem'");
						$idgudang2 = $datagudang2[0]->sg_id;
				//		dd($idgudang2);
						$stock_mutation->sm_stock = $idgudang2;
						$stock_mutation->sm_id = $idsm;
						$stock_mutation->sm_comp =  $cabang;
						$stock_mutation->sm_date = 	$mytime;
						$stock_mutation->sm_item = $iditem;
						$stock_mutation->sm_mutcat = '4';
						$stock_mutation->sm_qty = $request->qtyreturn[$j];
						$stock_mutation->sm_use =  $request->qtyreturn[$j];
						$stock_mutation->sm_hpp = $jumlahharga;
						$stock_mutation->sm_lpb =  $request->nota ;
						$stock_mutation->sm_suratjalan = '-' ;
						$stock_mutation->sm_po = $idrn ;
						$stock_mutation->sm_id_gudang = $request->lokasigudang[$j];
						$stock_mutation->sm_sisa = '0';
						$stock_mutation->sm_flag = 'RN';
						$stock_mutation->save();
						

						//UPDATE DATA STOCK GUDANG
						$lokasigudang = $request->lokasigudang[$j];

						$stockgudang = DB::select("select * from stock_gudang where sg_gudang = '$lokasigudang' and sg_cabang = '$cabang' and sg_item = '$iditem' ");

						//return $stockgudang[0]->sg_qty;
						$hasilstockgudang = (int)$stockgudang[0]->sg_qty - (int)$request->qtyreturn[$j];

						$updatestockgudang = stock_gudang::where([['sg_gudang' , '=', $request->lokasigudang[$j]],['sg_cabang' , '=' , $cabang], ['sg_item' , '=' , $iditem]]);

						$updatestockgudang->update([
							'sg_qty' => $hasilstockgudang,
							]);
					
				
				
				}
				}
			}*/
			
			return json_encode($data);
		});	
	}
}