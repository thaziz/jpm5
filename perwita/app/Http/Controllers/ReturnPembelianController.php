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
use Yajra\Datatables\Datatables;


class ReturnPembelianController extends Controller
{
	


	public function returnpembelian() {
		$cabang = session::get('cabang');
		return view('purchase/return_pembelian/index' , compact('data'));
	}

	public function returnpembeliantable(Request $request) {		
  		  $tgl='';
  		  $noreturn='';  		  
  		  $tgl1=date('Y-m-d',strtotime($request->tanggal1));
  		  $tgl2=date('Y-m-d',strtotime($request->tanggal2));

  		  
  		  if($request->tanggal1!='' && $request->tanggal2!=''){  		  	
  		  	$tgl="and rn_tgl>= '$tgl1' AND rn_tgl <= '$tgl2'";
  		  }
  		  if($request->noreturn!=''){
  		  	$noreturn="and rn_nota='$request->noreturn'";
  		  }  		  

		 $data='';

		 $cabang = session::get('cabang');

		$data='';

		if($cabang == 000){
			$data= DB::select("select *,'no' as no from returnpembelian, pembelian_order , supplier where rn_supplier = idsup and rn_idpotidakaktif = po_id  $tgl $noreturn");
		}
		else {
			$data = DB::select("select *,'no' as no from returnpembelian , pembelian_orer, supplier where rn_supplier = idsup where rn_cabang = '$cabang' and rn_idpotidakaktif = po_id $tgl $noreturn ");
		}

                        
		$data=collect($data);	

			return DataTables::of($data)
			->editColumn('rn_tgl', function ($data) {            
            	return date('d-m-Y',strtotime($data->rn_tgl));
            })
           ->editColumn('po_no', function ($data) { 
 			 	return '<a 
 			 	href='.url('purchaseorder/detail/'.$data->po_id.'').'> 			 	
 			 	'.$data->po_no.'</a>
 			 	<input type="hidden" value="'.$data->po_id.'"  class="po_id">';
            })
           
           ->addColumn('action', function ($data) {                 
				$action='';
				$action.='<a class="btn btn-sm btn-success" 
				href='.url('returnpembelian/detailreturnpembelian/'.$data->rn_id.'').'> 			 					
				<i class="fa fa-arrow-right" aria-hidden="true"></i> </a>  <a class="btn btn-sm btn-danger" onclick="hapusdata({{$rn->rn_id}})">
				                              <i class="fa fa-trash"> </i> 
				                            </a>';
				return $action;


            })
            
			->make(true);	



    }

	public function createreturnpembelian(){
		$data['cabang'] = DB::select("select * from cabang");
		$data['supplier'] = DB::select("select * from supplier where active = 'AKTIF' and status = 'SETUJU'");
		return view('purchase/return_pembelian/create', compact('data'));
	}

	public function getbarangpo(Request $request){
		$idpo = $request->idpo;

		$datas['barang'] = DB::select("select * from pembelian_orderdt, pembelian_order, masteritem where podt_idpo = '$idpo' and podt_idpo = po_id and podt_kodeitem = kode_item");
		$datas['barang1'] = DB::select("select * from pembelian_orderdt, pembelian_order, masteritem where podt_idpo = '$idpo' and podt_idpo = po_id and podt_kodeitem = kode_item");

		if(count($request->databarang) != 0){
			for($i = 0 ; $i < count($datas['barang']); $i++){
				for($j = 0; $j < count($request->databarang); $j++){
					if($request->databarang[$j] == $datas['barang'][$i]->podt_kodeitem){
						unset($datas['barang1'][$i]);
					}
				}
			}
			$datas['barang1'] = array_values($datas['barang1']);
			$data['podt'] = $datas['barang1'];
		}
		else {
			$data['podt'] = $datas['barang1'];
		}

		$data['countpodt'] = count($data['podt']);
		return json_encode($data);
		
	}

	public function hasilbarangpo(Request $request){
		for($i = 0; $i < count($request->idpo); $i++){
			$idpo = $request->idpo[$i];
			$kodeitem = $request->kodeitem[$i];
			$data['po'] = DB::select("select * from pembelian_order, pembelian_orderdt, masteritem where podt_idpo = po_id and po_id = '$idpo' and podt_kodeitem = '$kodeitem' and podt_kodeitem = kode_item");
		}

		return json_encode($data);
	}

	public function getpo(Request $request){
		$supplier = $request->supplier;
		$cabang = $request->cabang;
		$idpo = $request->idpo;
		if(count($idpo) == 0){
		
			$data['po'] = DB::select("select * from pembelian_order where po_supplier = '$supplier' and po_idfaktur is null and po_setujufinance = 'SETUJU' and po_statusreturn = 'AKTIF' and po_cabang = '$cabang' and po_id != '$idpo' ");
			
		}
		else {
			$data['po'] = DB::select("select * from pembelian_order where po_supplier = '$supplier' and po_idfaktur is null and po_setujufinance = 'SETUJU' and po_statusreturn = 'AKTIF' and po_cabang = '$cabang'  ");
				
		}

		return json_encode($data);
	}


	public function detailreturnpembelian ($id){
		$cabang = session::get('cabang');

		if($cabang == 000){
			$data['rn'] = DB::select("select * from returnpembelian, pembelian_order , supplier where rn_supplier = idsup and rn_idpotidakaktif = po_id and rn_id = '$id'");
			$jurnalRef = $data['rn'][0]->rn_nota;
			$data['rndt'] = DB::select("select * from returnpembelian_dt , masteritem, pembelian_orderdt, returnpembelian where rndt_idrn = rn_id and rndt_idrn = '$id' and rndt_item = kode_item and rn_idpoaktif = podt_idpo and rndt_item = podt_kodeitem");
			$data['cabang'] = DB::select("select * from cabang");
			$data['supplier'] = DB::select("select * from supplier where active = 'AKTIF' and status = 'SETUJU'");
		}
		else {
			$data['rn'] = DB::select("select * from returnpembelian, pembelian_order , supplier where rn_supplier = idsup and rn_idpotidakaktif = po_id and rn_id = '$id' and rn_cabang = '$cabang'");
			$jurnalRef = $data['rn'][0]->rn_nota;
			$data['rndt'] = DB::select("select * from returnpembelian_dt , masteritem, pembelian_orderdt, returnpembelian where rndt_idrn = rn_id and rndt_idrn = '$id' and rndt_item = kode_item and rn_idpoaktif = podt_idpo and rndt_item = podt_kodeitem");

			$data['cabang'] = DB::select("select * from cabang");
			$data['supplier'] = DB::select("select * from supplier where active = 'AKTIF' and status = 'SETUJU'");
		}



		$data['jurnal_return'] =collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk
		                    FROM d_akun a join d_jurnal_dt jd
		                    on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
		                    (select j.jr_id from d_jurnal j where jr_ref='$jurnalRef' and jr_detail = 'RETURN PEMBELIAN RETURN')"));
		
		$data['jurnal_terima'] =collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk
		                    FROM d_akun a join d_jurnal_dt jd
		                    on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
		                    (select j.jr_id from d_jurnal j where jr_ref='$jurnalRef' and jr_detail = 'RETURN PEMBELIAN TERIMA')"));
		

		return view('purchase/return_pembelian/detail' , compact('data'));
	}

	public function hapusdata ($id){
		
		 $datareturn = DB::select("select * from returnpembelian where rn_id = '$id'");
		 $idpo = $datareturn[0]->rn_idpoaktif;
		 $idpotdkaktif = $datareturn[0]->rn_idpotidakaktif;
	

		  //UPDATE STOCK MUTATION 
		  $datasm = DB::select("select * from returnpembelian_sm where rnsm_idrn = '$id' ");
		  for($i =0 ; $i < count($datasm); $i++){
			  $datasmqty = $datasm[$i]->rnsm_qty;
			  $datasmid = $datasm[$i]->rnsm_idsm;

			  $datastock = DB::select("select * from stock_mutation where sm_id = '$datasmid'");
			  $qtystock = $datastock[0]->sm_qty;
			  $qtysisa = $datastock[0]->sm_sisa;
			  $sm_use =  (int)$qtystock + (int)$datasmqty;
			  $sm_sisa = (int)$qtysisa + (int)$datasmqty;

			    $updatesm = DB::table('stock_mutation')
                        ->where([['sm_id' , '=' , $datasmid]])
                        ->update([
                        	'sm_qty' => $sm_use,
                            'sm_sisa' => $sm_sisa,                                        
                        ]); 

            	//UPDATE PENERIMAAN BARANG DT
            	$idpb = $datastock[0]->sm_po;
            	$item = $datastock[0]->sm_item;
            	$updatepb = DB::table('penerimaan_barangdt')
            				->where([['pbdt_idpb' , '=' , $idpb] , ['pbdt_item' , '=' , $item]])
            				->update([
            					'pbdt_qty' => $sm_use,
            					'pbdt_po' => $idpotdkaktif,
            				]);
		  }


		  //UPDATE STOCK GUDANG
		 $datareturn = DB::select("select * from returnpembelian where rn_id = '$id'");
		 $idpo = $datareturn[0]->rn_idpoaktif;
		 $idpotdkaktif = $datareturn[0]->rn_idpotidakaktif;

		 $datareturndt = DB::select("select * from returnpembelian_dt where rndt_idrn = '$id'");

		 for($j = 0; $j < count($datareturndt); $j++){
		 	$kodeitem = $datareturndt[$j]->rndt_item;
		 	$datapo = DB::select("select * from pembelian_orderdt where podt_idpo = '$idpo' and podt_kodeitem = '$kodeitem'");
		 	$lokasigudang = $datapo[0]->podt_lokasigudang;

		 	$qty = $datareturndt[$j]->rndt_qtyreturn;
		 	$datagudang = DB::select("select * from stock_gudang where sg_item = '$kodeitem' and sg_gudang = '$lokasigudang'");
		 	$sgqty = $datagudang[0]->sg_qty;
		 	$hasilqty = (int)$sgqty + (int)$qty;
	 	 	$updatesg = DB::table('stock_gudang')
                    ->where([['sg_item' , '=' , $kodeitem],['sg_gudang' , '=' , $lokasigudang]])
                    ->update([
                        'sg_qty' => $hasilqty,                                                           
                    ]); 
		 }

		  //DELETE RETURN
		  DB::delete("DELETE from  stock_mutation where sm_po = '$id' and sm_flag = 'RN'");


	      $updatebt = DB::table('barang_terima')
	                ->where([['bt_idtransaksi' , '=' , $idpo], ['bt_flag' , '=' , 'PO']])
	                ->update([
	                    'bt_idtransaksi' => $idpotdkaktif
	                   ]);

	        $updatepb = DB::table('penerimaan_barangdt')
	    				->where('pbdt_po' , $idpo)
	    				->update([
	    					'pbdt_po' => $idpotdkaktif,
	    				]);

		  DB::delete("DELETE from  pembelian_order where po_id = '$idpo' and po_statusreturn = 'TIDAK AKTIF'");
		  $updatepo = DB::table('pembelian_order')
                    ->where('po_id' , $idpotdkaktif)
                    ->update([
                        'po_statusreturn' => 'AKTIF'
                       ]);

	        DB::delete("DELETE from  returnpembelian where rn_id = '$id'");   
	}

	public function updatedata(Request $request){
		$idrn = $request->idrn;
		$this->hapusdata($idrn);
        $this->save($request);
        return json_encode('sukses');
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
			$data['idreturn'] = str_pad($idrn, 4, '0', STR_PAD_LEFT);
			
		}
		else {
			$data['idreturn'] = '0001';
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
			$rn->rn_inputppn = $hasilppn;

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

		$jumlahhargaterima = str_replace(',', '',  $request->jumlahhargaterima[$i]);
		$totalhargaterima = str_replace(',', '',  $request->totalhargaterima[$i]);


			$rndt = new returnpembelian_dt();
			$rndt->rndt_id = $idrndt;
			$rndt->rndt_idrn = $idrn;
			$rndt->rndt_item = $request->kodeitem[$i];
			$rndt->rndt_qtypo = $request->qtypo[$i];
			$rndt->rndt_qtyreturn = $request->qtyreturn[$i];
			$rndt->rndt_harga = $jumlahharga;
			$rndt->rndt_totalharga = $totalharga;
			$rndt->create_by = $request->username;
			$rndt->update_by = $request->username;
			$rndt->rndt_hargaterima = $jumlahhargaterima;
			$rndt->rndt_qtyterima = $request->qtyterima[$i];
			$rndt->rndt_totalhargaterima = $totalhargaterima;
			$rndt->rndt_akunitem = $request->akunitem[$i];
			$rndt->rndt_lokasigudang = $request->lokasigudang[$i];
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
		$po->po_hasilppn = $hasilppn;
		$po->po_statusreturn = 'AKTIF';
		$po->create_by = $request->username;	
		$po->po_setujufinance = 'SETUJU';
		$po->po_keteranganfinance = $data['po'][0]->po_keteranganfinance;
		$po->po_acchutangdagang = $data['po'][0]->po_acchutangdagang;
		$po->po_cabangtransaksi = $data['po'][0]->po_cabangtransaksi;
		$po->update_by = $request->username;
		$po->save();


		
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
				$podt->podt_keterangan = $data['podt'][$n]->podt_keterangan;
				$podt->podt_sisaterima = $data['podt'][$n]->podt_sisaterima;
				$podt->podt_akunitem = $data['podt'][$n]->podt_akunitem;
//				$podt->podt_akunitem = $data['podt'][$n]->podt_akunitem;
 				$podt->save();
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


				$datapb = DB::select("select * from barang_terima where bt_flag = 'PO' and bt_idtransaksi = '$idpo' and bt_statuspenerimaan != 'BELUM DI TERIMA'");

				if(count($datapb) != 0){



					//UPDATE DATA STOCK GUDANG
					$lokasigudang = $request->lokasigudang[$j];
					$iditem = $request->kodeitem[$j];
					$stockgudang = DB::select("select * from stock_gudang where sg_gudang = '$lokasigudang' and sg_cabang = '$cabang' and sg_item = '$iditem' ");
					$sgqty = $stockgudang[0]->sg_qty;
					$qtyreturn = $request->qtyreturn[$j];
					if((int)$sgqty > (int)$qtyreturn){
						/*	return $iditem . $cabang . $lokasigudang;*/
						//return $stockgudang[0]->sg_qty;
						$hasilstockgudang = (int)$stockgudang[0]->sg_qty - (int)$request->qtyreturn[$j];

						$updatestockgudang = stock_gudang::where([['sg_gudang' , '=', $request->lokasigudang[$j]],['sg_cabang' , '=' , $cabang], ['sg_item' , '=' , $iditem]]);

						$updatestockgudang->update([
							'sg_qty' => $hasilstockgudang,
							]);

						}
					}
					
				}

				
			


		

			$datastockmutation = 0;
			for($k = 0; $k < count($request->kodeitem); $k++){
				$iditem = $request->kodeitem[$k];
				$data['iditem'][] = $iditem;
				$data['pb'][] = DB::select("select * from penerimaan_barangdt where pbdt_po = '$idpo' and pbdt_item = '$iditem' order by pbdt_id asc");

				$hitungpb = count($data['pb']);

				//return json_encode($data);

				$sisa = -1;

				if($hitungpb != 0){ // jika jumlah pb tidak 0
					$updatebarangterima = barang_terima::where([['bt_flag' , '=' , 'PO'], ['bt_idtransaksi' , '=' , $idpo]]);
						$updatebarangterima->update([
						'bt_idtransaksi' => $idpo2,
				 	]);

					for($i = 0 ; $i < count($data['pb']); $i++){
						
						$hz = (int) count($data['pb'][$i]) - 1;
							for ($j = 0; $j < count($data['pb'][$i]); $j++){
							$jumlahperitem = 0;
								
							//return $hz;
							$jumlahperitem = $jumlahperitem + $data['pb'][$i][$hz]->pbdt_qty;
							//	$jumlahperitem = 3;	
								
									
								//return $jumlahperitem . $request->qtyreturn[$k];	
								if((int)$jumlahperitem >= (int)$request->qtyreturn[$k]){// 
									$j = (int)1000;	
									$qty = $data['pb'][$i][$hz]->pbdt_qty;
									$idpbdt = $data['pb'][$i][$hz]->pbdt_id;
										

									//return $idpbdt  . $hz . $qty . $request->qtyreturn[$k] ;
									if((int)$request->qtyreturn[$k] == (int)$qty){ // SAMA


									//	return 'yes1';									
										//return $idpo . $idpbdt  . $idpbdt1 . $idpbdt2 . $iditem . $hz . $i;
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
											'updated_by' => $request->username
											]);


										$lokasigudang = $request->lokasigudang[$k];
										$datasmt = DB::select("select * from stock_mutation where sm_flag = 'PO' and sm_po = '$idpb' and sm_id_gudang = '$lokasigudang' and sm_comp = '$cabang' and sm_item = '$iditem'");

										 $cari_max_id = DB::table('returnpembelian_sm')
										                     ->max('rnsm_id');
										    if ($cari_max_id != null) {
										        $cari_max_id += 1;
										    }else{
										        $cari_max_id = 1;
										    }
										   $save_rnsm = DB::table('returnpembelian_sm')
					                           ->insert([
					                            'rnsm_id'       => $cari_max_id,
					                            'rnsm_idrn'     => $idrn,
					                            'rnsm_kodeitem' => $iditem,
					                            'rnsm_qty'      => $request->qtyreturn[$k],
					                            'rnsm_sisa'		=>  $request->qtyreturn[$k],
					                            'rnsm_idsm'     => $datasmt[0]->sm_id,
					                        ]);
										//$sisa = (int)$jumlahperitem - (int)$request->qtyreturn[$k];
									} // END SAMA
									else if((int)$request->qtyreturn[$k] < (int)$qty) {
									//	return 'yes2';
										$hasilselisih = (int)$qty -  (int)$request->qtyreturn[$k];

										$updatepbdt =  penerimaan_barangdt::where([['pbdt_po' , '=' ,$idpo],['pbdt_item' , '=' , $iditem],['pbdt_id' , '=' , $idpbdt]]);						
										$updatepbdt->update([
											'pbdt_qty' => $hasilselisih,
											]);


										
									//	return $idpo . $iditem . $idpbdt;
										$idpb = $data['pb'][$i][$hz]->pbdt_idpb;


											//update di stockmutation di penerimaan barang
										$updatesmt = stock_mutation::where([['sm_flag' , '=' , 'PO'], ['sm_po' , '=' , $idpb] , ['sm_id_gudang' , '=' , $request->lokasigudang[$k] ], ['sm_comp' , '=' , $cabang] , ['sm_item' , '=' , $iditem]]);

										$updatesmt->update([
											'sm_qty' => $hasilselisih,
											'sm_sisa' => $hasilselisih,
											'updated_by' => $request->username
											]);

										$lokasigudang = $request->lokasigudang[$k];
										$datasmt = DB::select("select * from stock_mutation where sm_flag = 'PO' and sm_po = '$idpb' and sm_id_gudang = '$lokasigudang' and sm_comp = '$cabang' and sm_item = '$iditem'");

										 $cari_max_id = DB::table('returnpembelian_sm')
										                     ->max('rnsm_id');
										    if ($cari_max_id != null) {
										        $cari_max_id += 1;
										    }else{
										        $cari_max_id = 1;
										    }
										   $save_rnsm = DB::table('returnpembelian_sm')
					                           ->insert([
					                            'rnsm_id'       => $cari_max_id,
					                            'rnsm_idrn'       => $idrn,
					                            'rnsm_kodeitem'       => $iditem,
					                            'rnsm_qty'       => $request->qtyreturn[$k],
					                            'rnsm_qty'       => $request->qtyreturn[$k],
					                            'rnsm_idsm'       => $datasmt[0]->sm_id,
					                        ]);
									}
								}
									else {
										//return 'yes3';
										//perulangan
										$return = $request->qtyreturn[$k];
										$yz = (int) count($data['pb'][$i]) - 1;
										for ($j = 0; $j < count($data['pb'][$i]); $j++){
											
											$qty = $data['pb'][$i][$yz]->pbdt_qty;
											$idpbdt = $data['pb'][$i][$yz]->pbdt_id;
											//return $qty . $idpbdt . $iditem;
											if($return != 0){


												if((int)$return > (int)$qty){
													$updatepbdt =  penerimaan_barangdt::where([['pbdt_po' , '=' ,$idpo],['pbdt_item' , '=' , $iditem],['pbdt_id' , '=' , $idpbdt]]);						
													$updatepbdt->update([
														'pbdt_qty' => 0,
														]);
											
												//	return $idpo . $iditem . $idpbdt;
													$idpb = $data['pb'][$i][$yz]->pbdt_idpb;

														//update di stockmutation di penerimaan barang
													$updatesmt = stock_mutation::where([['sm_flag' , '=' , 'PO'], ['sm_po' , '=' , $idpb] , ['sm_id_gudang' , '=' , $request->lokasigudang[$k] ], ['sm_comp' , '=' , $cabang] , ['sm_item' , '=' , $iditem]]);


													$lokasigudang = $request->lokasigudang[$k];

													$datasmt = DB::select("select * from stock_mutation where sm_flag = 'PO' and sm_po = '$idpb' and sm_id_gudang = '$lokasigudang' and sm_comp = '$cabang' and sm_item = '$iditem'");

													 $cari_max_id = DB::table('returnpembelian_sm')
													                     ->max('rnsm_id');
													    if ($cari_max_id != null) {
													        $cari_max_id += 1;
													    }else{
													        $cari_max_id = 1;
													    }

													   $save_rnsm = DB::table('returnpembelian_sm')
								                           ->insert([
								                            'rnsm_id'       => $cari_max_id,
								                            'rnsm_idrn'       => $idrn,
								                            'rnsm_kodeitem'       => $iditem,
								                            'rnsm_qty'       => $datasmt[0]->sm_qty,
								                            'rnsm_sisa'       => $datasmt[0]->sm_qty,
								                            'rnsm_idsm'       => $datasmt[0]->sm_id,
								                        ]);

													$updatesmt->update([
														'sm_qty' => 0,
														'sm_sisa' => 0,
														'updated_by' => $request->username
														]);	
													$return = (int)$return - (int)$qty;										
												}
												else if((int)$return < (int)$qty){
													$hasilqty = (int)$qty - (int)$return;
													$updatepbdt =  penerimaan_barangdt::where([['pbdt_po' , '=' ,$idpo],['pbdt_item' , '=' , $iditem],['pbdt_id' , '=' , $idpbdt]]);						
													$updatepbdt->update([
														'pbdt_qty' => $hasilqty,
														]);
											
												//	return $idpo . $iditem . $idpbdt;
													$idpb = $data['pb'][$i][$yz]->pbdt_idpb;

													
														//update di stockmutation di penerimaan barang
													$updatesmt = stock_mutation::where([['sm_flag' , '=' , 'PO'], ['sm_po' , '=' , $idpb] , ['sm_id_gudang' , '=' , $request->lokasigudang[$k] ], ['sm_comp' , '=' , $cabang] , ['sm_item' , '=' , $iditem]]);

													$lokasigudang = $request->lokasigudang[$k];
													$datasmt = DB::select("select * from stock_mutation where sm_flag = 'PO' and sm_po = '$idpb' and sm_id_gudang = '$lokasigudang' and sm_comp = '$cabang' and sm_item = '$iditem'");

													 $cari_max_id = DB::table('returnpembelian_sm')
													                     ->max('rnsm_id');
													    if ($cari_max_id != null) {
													        $cari_max_id += 1;
													    }else{
													        $cari_max_id = 1;
													    }

													    $hasilqty2 = (int)$hasilqty - (int)$qty; 
													   $save_rnsm = DB::table('returnpembelian_sm')
								                           ->insert([
								                            'rnsm_id'       => $cari_max_id,
								                            'rnsm_idrn'       => $idrn,
								                            'rnsm_kodeitem'       => $iditem,
								                            'rnsm_qty'       => $return,
								                            'rnsm_sisa'       => $return,
								                            'rnsm_idsm'       => $datasmt[0]->sm_id,
								 
								                        ]);

													$updatesmt->update([
														'sm_qty' => $hasilqty,
														'sm_sisa' => $hasilqty,
														'updated_by' => $request->username
														]);	
													$return = (int)$return - (int)$qty;	
												}
												else {
													$updatepbdt =  penerimaan_barangdt::where([['pbdt_po' , '=' ,$idpo],['pbdt_item' , '=' , $iditem],['pbdt_id' , '=' , $idpbdt]]);						
													$updatepbdt->update([
														'pbdt_qty' => 0,
														]);
											
												//	return $idpo . $iditem . $idpbdt;
													$idpb = $data['pb'][$i][$yz]->pbdt_idpb;

														//update di stockmutation di penerimaan barang
													$updatesmt = stock_mutation::where([['sm_flag' , '=' , 'PO'], ['sm_po' , '=' , $idpb] , ['sm_id_gudang' , '=' , $request->lokasigudang[$k] ], ['sm_comp' , '=' , $cabang] , ['sm_item' , '=' , $iditem]]);


													$lokasigudang = $request->lokasigudang[$k];
													$datasmt = DB::select("select * from stock_mutation where sm_flag = 'PO' and sm_po = '$idpb' and sm_id_gudang = '$lokasigudang' and sm_comp = '$cabang' and sm_item = '$iditem'");

													 $cari_max_id = DB::table('returnpembelian_sm')
													                     ->max('rnsm_id');
													    if ($cari_max_id != null) {
													        $cari_max_id += 1;
													    }else{
													        $cari_max_id = 1;
													    }
													   $save_rnsm = DB::table('returnpembelian_sm')
								                           ->insert([
								                            'rnsm_id'       => $cari_max_id,
								                            'rnsm_idrn'       => $idrn,
								                            'rnsm_kodeitem'       => $iditem,
								                            'rnsm_qty'       => $datasmt[0]->sm_qty,
								                            'rnsm_sisa'       => $datasmt[0]->sm_qty,
								                            'rnsm_idsm'       => $datasmt[0]->sm_id,
								                        ]);

													$updatesmt->update([
														'sm_qty' => 0,
														'sm_sisa' => 0,
														'updated_by' => $request->username
														]);
												}
											}
											$yz--;	
										}											
									}



								
								 // end jumlahperitem >= $request->qtyreturn[$k]
									$hz--;
							} // end for data[pb][0]
						
						} // for data[pb]
					} // jika jumlah pb tidak 0
				
					


			}// END FOR KODEITEM
			

			//update pbdt
			for($j = 0; $j < count($request->kodeitem); $j++){
				$iditem = $request->kodeitem[$j];
				$jumlahterima = 0;


				$data['pb'][] = DB::select("select * from penerimaan_barangdt where pbdt_po = '$idpo' and pbdt_item = '$iditem'");

				//return json_encode($data);
				if(count($data['pb']) != 0 ) {
					for($x = 0 ; $x < count($data['pb'][0]); $x++){
						$jumlahterima = $jumlahterima + (int)$data['pb'][0][$x]->pbdt_qty;
					}

				//update peritem di pbdt
				$hasilqty = (int)$request->qtypo[$j] - (int)$request->qtyreturn[$j];

			

				//return $hasilqty . $jumlahterima;
				if((int)$jumlahterima > $hasilqty){
					//update idpo di penerimaan barang					
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
						$lokasigudang = $request->lokasigudang[$j];
						$datagudang2 = DB::select("select * from stock_gudang where sg_item = '$iditem' and sg_gudang = '$lokasigudang' and sg_cabang = '$cabang'");
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
						$stock_mutation->created_by = $request->username;
						$stock_mutation->updated_by = $request->username;
						$stock_mutation->save();
				}
				}
			
			}

			//nambah persediaan ketika ada qtyterima
			$dataterima = DB::select("select * from returnpembelian, returnpembelian_dt where rn_id = '$idrn' and rndt_idrn = rn_id ");
			$jurnalreturn = [];
			$jurnalterima = [];
			for($i = 0; $i < count($dataterima); $i++){
				$qtyterima = $dataterima[$i]->rndt_qtyterima;
				$hargaterima = $dataterima[$i]->rndt_hargaterima;

				
				if($qtyterima != 0){
					//masuk gudang
					$itemterima = $dataterima[$i]->rndt_item;
					//UPDATE DATA STOCK GUDANG
					$lokasigudang = $dataterima[$i]->rndt_lokasigudang;
					$itemterima = $request->kodeitem[$i];
					$stockgudang = DB::select("select * from stock_gudang where sg_gudang = '$lokasigudang' and sg_cabang = '$cabang' and sg_item = '$itemterima' ");
				/*	return $iditem . $cabang . $lokasigudang;*/
					//return $stockgudang[0]->sg_qty;
					$hasilstockgudang = (int)$stockgudang[0]->sg_qty + (int)$qtyterima;

					$updatestockgudang = stock_gudang::where([['sg_gudang' , '=', $lokasigudang],['sg_cabang' , '=' , $cabang], ['sg_item' , '=' , $itemterima]]);

					$updatestockgudang->update([
						'sg_qty' => $hasilstockgudang,
						]);

					$datapodt = DB::select("select * from pembelian_orderdt where podt_idpo = '$idpo2' and podt_kodeitem = '$itemterima'");
					$qtypo = $datapodt[0]->podt_qtykirim;
					$hargapo = $datapodt[0]->podt_jumlahharga;

					$datapb = DB::select("select * from penerimaan_barang where pb_po = '$idpo2'");



					if(floatval($hargapo) != floatval($hargaterima)){

						$updatepodt = purchase_orderdt::where(['podt_idpo' , '=', $idpo2]);

						$lastidpodt = purchase_orderdt::max('podt_id'); 
							$mytime = Carbon::now(); 

							if(isset($lastidpodt)) {
								$idpodt = $lastidpodt;
								$idpodt = (int)$lastidpodt + 1;
							}
							else {
								$idpodt = 1;
							}	

						$updatepodt->insert([
						//	'podt_qtykirim' => $hasilqtypo,
							'podt_id' => $idpodt,
							'podt_kodeitem' => $itemterima,
							'podt_approval' => $datapodt[0]->podt_approval,
							'podt_qtykirim' => $qtyterima,
							'podt_jumlahharga' => $dataterima[0]->rndt_hargaterima,
							'podt_statuskirim' => 'LENGKAP',
							'podt_idspp' => $datapodt[0]->podt_idspp,
							'podt_idpo' => $datapodt[0]->podt_idpo,
							'podt_lokasigudang' => $lokasigudang,
							'podt_tglkirim' => $mytime,
							'podt_supplier' => $datapodt[0]->podt_supplier,
							'podt_totalharga' => $dataterima[$i]->rndt_totalhargaterima,
							'podt_akunitem' => $dataterima[$i]->rndt_akunitem,
							'podt_keterangan' => $datapodt[0]->podt_keterangan,
							'podt_sisaterima' => '0',
							]);

							$idakun = $datapodt[0]->podt_akunitem;

							$dataakun = DB::select("select * from d_akun where id_akun = '$idakun'");

						
							$dka = $dataakun[0]->akun_dka;

							if($dka == 'D'){
								$jurnalterima[$i]['id_akun'] = $datapodt[0]->podt_akunitem;
								$jurnalterima[$i]['subtotal'] = $dataterima[$i]->rndt_totalhargaterima;
								$jurnalterima[$i]['dk'] = 'D';
								$jurnalterima[$i]['detail'] = $datapodt[0]->podt_keterangan;
							}
							else {
								$jurnalterima[$i]['id_akun']  =  $datapodt[0]->podt_akunitem;
								$jurnalterima[$i]['subtotal'] = '-' .$dataterima[$i]->rndt_totalhargaterima;
								$jurnalterima[$i]['dk'] = 'D';	
								$jurnalterima[$i]['detail'] = $datapodt[0]->podt_keterangan;
							}

						}
						else {

							$idakun = $datapodt[0]->podt_akunitem;

							$dataakun = DB::select("select * from d_akun where id_akun = '$idakun'");
							$dka = $dataakun[0]->akun_dka;

							if($dka == 'D'){
								$jurnalterima[$i]['id_akun'] = $datapodt[0]->podt_akunitem;
								$jurnalterima[$i]['subtotal'] = '-' . $datapodt[0]->podt_totalharga;
								$jurnalterima[$i]['dk'] = 'D';
								$jurnalterima[$i]['detail'] = $datapodt[0]->podt_keterangan;
							}
							else {
								$jurnalterima[$i]['id_akun']  =  $datapodt[0]->podt_akunitem;
								$jurnalterima[$i]['subtotal'] = $datapodt[0]->podt_totalharga;
								$jurnalterima[$i]['dk'] = 'D';	
								$jurnalterima[$i]['detail'] = $datapodt[0]->podt_keterangan;
							}

							$hasilqtypo = (int)$datapodt[0]->podt_qtykirim + (int)$qtykirim;
							$updatepodt->update([
								'podt_qtykirim' => $hasilqtypo,
							]);
						}


					
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

						//$lokasigudang = $request->lokasigudang[$j];
						$datagudang2 = DB::select("select * from stock_gudang where sg_item = '$itemterima' and sg_gudang = '$lokasigudang' and sg_cabang = '$cabang'");
						$idgudang2 = $datagudang2[0]->sg_id;

				//		dd($idgudang2);
						$stock_mutation->sm_stock = $idgudang2;
						$stock_mutation->sm_id = $idsm;
						$stock_mutation->sm_comp =  $cabang;
						$stock_mutation->sm_date = 	$mytime;
						$stock_mutation->sm_item = $itemterima;
						$stock_mutation->sm_mutcat = '1';
						$stock_mutation->sm_qty = $qtyterima;
						$stock_mutation->sm_use =  0;
						$stock_mutation->sm_hpp = $dataterima[$i]->rndt_harga;
						$stock_mutation->sm_lpb =  $dataterima[0]->rn_nota;
						$stock_mutation->sm_suratjalan = '-' ;
						$stock_mutation->sm_po = $idrn ;
						$stock_mutation->sm_id_gudang = $lokasigudang;
						$stock_mutation->sm_sisa = $qtyterima;
						$stock_mutation->sm_flag = 'RN';
						$stock_mutation->created_by = $request->username;
						$stock_mutation->updated_by = $request->username;
						$stock_mutation->save();




				} // end if qty tdk kosong
			}
			
			$datapodt = DB::select("select * from pembelian_order, pembelian_orderdt where podt_idpo = po_id and podt_idpo = '$idpo2'");
				for($i = 0; $i < count($datapodt); $i++){
					$idakun = $datapodt[$i]->podt_akunitem;

					$dataakun = DB::select("select * from d_akun where id_akun = '$idakun'");
					$dka = $dataakun[0]->akun_dka;

					if($dka == 'D'){
						$jurnalreturn[$i]['id_akun'] = $datapodt[$i]->podt_akunitem;
						$jurnalreturn[$i]['subtotal'] = '-' . $datapodt[$i]->podt_totalharga;
						$jurnalreturn[$i]['dk'] = 'K';
						$jurnalreturn[$i]['detail'] = $datapodt[$i]->podt_keterangan;
					}
					else {
						$jurnalreturn[$i]['id_akun']  =  $datapodt[$i]->podt_akunitem;
						$jurnalreturn[$i]['subtotal'] = $datapodt[$i]->podt_totalharga;
						$jurnalreturn[$i]['dk'] = 'K';
						$jurnalreturn[$i]['detail'] = $datapodt[$i]->podt_keterangan;
					}

					//$totalhutang = $totalhutang + $totalharga;
				} // end for

				$cabang = $datapodt[0]->po_cabangtransaksi;
				//return $datapodt;
				$datadakun = DB::select("select * from d_akun where id_akun LIKE '1408%' and kode_cabang = '$cabang'");
				$akunreturn = $datadakun[0]->id_akun;
				$dkareturn = $datadakun[0]->akun_dka;


				$hargareturn = str_replace(',', '',  $request->totalreturn);

				if($dkareturn == 'D'){
					$dataakun2 = array (
						'id_akun' => $akunreturn,
						'subtotal' => $hargareturn,
						'dk' => 'D',
						'detail' => $request->keterangan,
					);
				}
				else {
					$dataakun2 = array (
						'id_akun' => $akunreturn,
						'subtotal' => '-'.$hargareturn,
						'dk' => 'D',
						'detail' => $request->keterangan,
					);
				}
				array_push($jurnalreturn,$dataakun2);


					$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 
					if(isset($lastidjurnal)) {
						$idjurnal = $lastidjurnal;
						$idjurnal = (int)$idjurnal + 1;
					}
					else {
						$idjurnal = 1;
					}
				
					$year = date('Y');	
					$date = date('Y-m-d');
					$jurnal = new d_jurnal();
					$jurnal->jr_id = $idjurnal;
			        $jurnal->jr_year = date('Y');
			        $jurnal->jr_date = date('Y-m-d');
			        $jurnal->jr_detail = 'RETURN PEMBELIAN RETURN';
			        $jurnal->jr_ref = $request->nota;
			        $jurnal->jr_note = $request->keterangan;
			        $jurnal->save();
		       		
			      
		        
		    		$key  = 1;
		    		for($j = 0; $j < count($jurnalreturn); $j++){
		    			
		    			$lastidjurnaldt = DB::table('d_jurnal')->max('jr_id'); 
						if(isset($lastidjurnaldt)) {
							$idjurnaldt = $lastidjurnaldt;
							$idjurnaldt = (int)$idjurnaldt + 1;
						}
						else {
							$idjurnaldt = 1;
						}

		    			$jurnaldt = new d_jurnal_dt();
		    			$jurnaldt->jrdt_jurnal = $idjurnal;
		    			$jurnaldt->jrdt_detailid = $key;
		    			$jurnaldt->jrdt_acc = $jurnalreturn[$j]['id_akun'];
		    			$jurnaldt->jrdt_value = $jurnalreturn[$j]['subtotal'];
		    			$jurnaldt->jrdt_statusdk = $jurnalreturn[$j]['dk'];
		    			$jurnaldt->jrdt_detail = $jurnalreturn[$j]['detail'];
		    			$jurnaldt->save();
		    			$key++;
		    		}   



		    		if(count($jurnalterima) != 0){
		    			$cabang = $datapodt[0]->po_cabangtransaksi;
						$datadakun = DB::select("select * from d_akun where id_akun LIKE '1408%' and kode_cabang = '$cabang'");
						$akunreturn = $datadakun[0]->id_akun;
						$dkareturn = $datadakun[0]->akun_dka;


						$hargaterima = str_replace(',', '',  $request->totalterima);

						if($dkareturn == 'D'){
							$dataakun2 = array (
								'id_akun' => $akunreturn,
								'subtotal' => '-' . $hargaterima,
								'dk' => 'K',
								'detail' => $request->keterangan,
							);
						}
						else {
							$dataakun2 = array (
								'id_akun' => $akunreturn,
								'subtotal' => $hargaterima,
								'dk' => 'K',
								'detail' => $request->keterangan,
							);
						}
						array_push($jurnalreturn,$dataakun2);


							$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 
							if(isset($lastidjurnal)) {
								$idjurnal = $lastidjurnal;
								$idjurnal = (int)$idjurnal + 1;
							}
							else {
								$idjurnal = 1;
							}
						
							$year = date('Y');	
							$date = date('Y-m-d');
							$jurnal = new d_jurnal();
							$jurnal->jr_id = $idjurnal;
					        $jurnal->jr_year = date('Y');
					        $jurnal->jr_date = date('Y-m-d');
					        $jurnal->jr_detail = 'RETURN PEMBELIAN TERIMA';
					        $jurnal->jr_ref = $request->nota;
					        $jurnal->jr_note = $request->keterangan;
					        $jurnal->save();
				       		
					      
				        
				    		$key  = 1;
				    		for($j = 0; $j < count($jurnalreturn); $j++){
				    			
				    			$lastidjurnaldt = DB::table('d_jurnal')->max('jr_id'); 
								if(isset($lastidjurnaldt)) {
									$idjurnaldt = $lastidjurnaldt;
									$idjurnaldt = (int)$idjurnaldt + 1;
								}
								else {
									$idjurnaldt = 1;
								}

				    			$jurnaldt = new d_jurnal_dt();
				    			$jurnaldt->jrdt_jurnal = $idjurnal;
				    			$jurnaldt->jrdt_detailid = $key;
				    			$jurnaldt->jrdt_acc = $jurnalreturn[$j]['id_akun'];
				    			$jurnaldt->jrdt_value = $jurnalreturn[$j]['subtotal'];
				    			$jurnaldt->jrdt_statusdk = $jurnalreturn[$j]['dk'];
				    			$jurnaldt->jrdt_detail = $jurnalreturn[$j]['detail'];
				    			$jurnaldt->save();
				    			$key++;
				    		} 
		    		}
			return json_encode($data);
		});	
	}
}