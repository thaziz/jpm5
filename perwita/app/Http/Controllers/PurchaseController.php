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


class PurchaseController extends Controller
{
	public function k(){		
		  $users = \DB::table('delivery_order')->paginate();
		  
		   return view('k', compact('users'));
	}
	public function cetak(Request $request,$id){
       $data = $request;
       $request->catatan;
       $request->bayar;
       $request->subtotal;
       $request->diskon;
       $request->totalharga;
       $request->jumlahharga;
       $request->ppn;
		$data2['po'] = DB::select("select * from pembelian_order, supplier where po_id = '$id'");
		$data2['supplier'] = DB::select("select * from supplier where active='AKTIF'");

		$data2['podt'] = DB::select("select * from pembelian_orderdt, spp, masteritem, cabang, mastergudang where podt_idpo = '$id' and podt_idspp = spp_id and podt_kodeitem = kode_item and spp_cabang = kode and podt_lokasigudang = mg_id");

		$data2['spp'] = DB::select("select distinct spp_nospp , spp_keperluan, nama_department , nama , spp_tgldibutuhkan from  pembelian_order , spp, pembelian_orderdt, cabang, masterdepartment where po_id = '$id' and podt_idpo = po_id  and podt_idspp = spp_id and spp_cabang = kode and spp_bagian = kode_department ");
	

		$data2['gudang'] = DB::select("select * from mastergudang");

		foreach ($data2['po'] as $key => $value) {
			$a = $value->nama_supplier;
		}
		foreach ($data2['po'] as $key => $value) {
			$b = $value->telp;
		}
		foreach ($data2['po'] as $key => $value) {
			$c = $value->no_kontrak;
		}
		foreach ($data2['po'] as $key => $value) {
			$d = $value->created_at;
		}
		foreach ($data2['po'] as $key => $value) {
			$e = $value->po_no;
		}
		foreach ($data2['spp'] as $key => $value) {
			$f = $value->spp_nospp;
		}
		foreach ($data2['podt'] as $key => $value) {
			$g = $value->spp_tgldibutuhkan;
		}
		foreach ($data2['po'] as $key => $value) {
			$h = $value->po_noform;
		}
		foreach ($data2['po'] as $key => $value) {
			$i = $value->no_kontrak;
		}
		foreach ($data2['po'] as $key => $value) {
			$j = $value->po_subtotal;
		}
		foreach ($data2['po'] as $key => $value) {
			$k = $value->po_diskon;
		}
		foreach ($data2['po'] as $key => $value) {
			$L = $value->po_ppn;
		}
		foreach ($data2['po'] as $key => $value) {
			$m = $value->po_totalharga;
		}
		foreach ($data2['po'] as $key => $value) {
			$n = $value->po_bayar	;
		}

		/*dd($data2);*/
      return view('purchase.purchase.print',compact('data','request','data2','a','b','c','d','e','f','g','h','i','j','k','L','m','n'));
    } 
	public function spp_index () {
		$data['spp'] = DB::select("select * from spp, masterdepartment, cabang, confirm_order where spp_bagian = kode_department and co_idspp = spp_id and spp_cabang = kode order by spp_id desc");


		$data['belumdiproses'] = DB::table("spp")->where('spp_status' , '=' , 'DITERBITKAN')->count();
		$data['disetujui'] = DB::table("spp")->where('spp_status' , '=' , 'DISETUJUI')->count();
		$data['masukgudang'] = DB::table("spp")->where('spp_status' , '=' , 'MASUK GUDANG')->count();
		$data['selesai'] = DB::table("spp")->where('spp_status' , '=' , 'SELESAI')->count();

		return view('purchase.spp.index', compact('data'));
	}
	
	public function getnospp(Request $request){
		
		$idspp =   spp_purchase::where('spp_cabang' , $request->comp)->max('spp_id');
		if(isset($idspp)) {
		/*	$explode = explode("/", $nosppid);
			$idspp = $explode[2];*/
		//	dd($nosppid);
			$string = (int)$idspp + 1;
			$idspp = str_pad($string, 3, '0', STR_PAD_LEFT);
		}

		else {
			$idspp = '001';
		}

		return json_encode($idspp) ;
	}
	
	public function createspp () {

		$data['barang'] = DB::table('masteritem')
					        ->leftJoin('stock_gudang', 'stock_gudang.sg_item', '=', 'masteritem.kode_item')
					        ->get();


	/*	$data['barang'] = DB::select("select distinct is_kodeitem, unitstock, is_harga, sg_qty, nama_masteritem from  supplier, masteritem, itemsupplier LEFT OUTER JOIN stock_gudang on sg_item = is_kodeitem where is_kodeitem = kode_item and is_supplier = no_supplier");
*/
		$data['barangfull'] = DB::select("select * from supplier, masteritem, itemsupplier where is_kodeitem = kode_item and is_supplier = no_supplier and status = 'SETUJU'");

		$data['cabang'] = master_cabang::all();	

		$data['jenisitem'] = masterJenisItemPurchase::all();			        
	
		$data['supplier'] = DB::select("select * from supplier where status = 'SETUJU' and active = 'AKTIF'");

		$data['department'] = master_department::all();

		

		$data['gudang'] = masterGudangPurchase::all();
		$data['kendaraan'] = DB::select("select * from tb_vhc left outer join tb_vhctpe on tb_vhc.kode = tb_vhctpe.kode");
		

		return view('purchase.spp.create', compact('data'));
	}

	public function ajax_hargasupplier($id){
		//$array = $id;
		
	
		$data['supplier'] = DB::select("select * from masteritem, itemsupplier, supplier  where is_supplier = no_supplier and kode_item = '$id' and kode_item = is_kodeitem and status = 'SETUJU'");
		$data['stock'] = DB::select("select * from  masteritem LEFT OUTER JOIN stock_gudang on kode_item = sg_item where kode_item = '$id'");
		$data['mastersupplier'] = DB::select("select * from supplier where status = 'SETUJU'");

		return json_encode($data);
	}

	public function ajax_jenisitem(Request $request){
		$jenisitem = $request->jenisitem;
		$updatestock = $request->updatestock;
		$penerimaan = $request->penerimaan;

		if($penerimaan == 'T'){
			$ajax = DB::select("select distinct kode_item, nama_masteritem, unitstock, harga from masteritem LEFT OUTER JOIN itemsupplier on kode_item = is_kodeitem where jenisitem = '$jenisitem'");	
		}		
		if($penerimaan != 'T' && $updatestock != '') {			
			$ajax = DB::select("select distinct kode_item, nama_masteritem, unitstock, harga from masteritem LEFT OUTER JOIN itemsupplier on kode_item = is_kodeitem where jenisitem = '$jenisitem' and updatestock = '$updatestock' ");	
		}

		return json_encode($ajax);
		
	}

	public function savespp(Request $request) {
	//	dd($request);
			$nospp = $request->nospp;
			$cabang = $request->comp;
			$dataspp = DB::select("select * from spp where spp_nospp = '$nospp' and spp_cabang = '$cabang'");
			if(count($dataspp) == 0){

			

			$lastid = spp_purchase::max('spp_id'); 
			if(isset($lastid)) {
				$idspp = $lastid;
				$idspp = (int)$idspp + 1;
			}

			else {
				$idspp = 1;
			}
			
			$nosppid =   spp_purchase::where('spp_cabang' , $request->comp)->max('spp_nospp');
		//	dd($nosppid);
			if(isset($nosppid)) {
				$explode = explode("/", $nosppid);
				$nosppid = $explode[2];
			//	dd($nosppid);
				$string = (int)$nosppid + 1;
				$nospp = str_pad($string, 3, '0', STR_PAD_LEFT);
			}

			else {
				$nospp = '001';
			}

		//rumus no_spp$
			$tgl = $request->tgl_dibutuhkan;
			$date = date('Y-m-d', strtotime($tgl));
			$cabang = $request->comp;
			$tanggal = explode("-", $date);
			$hasilbulan = $tanggal[1];
			$hasiltahun = $tanggal[0];
			
		//	dd($hasilbulan);
			if($hasilbulan == '01') {
				
				$nospp = 'SPP/'. $cabang . '/' . $nospp .'/I/' . $hasiltahun;
			}
			if($hasilbulan == '02') {
				$nospp = 'SPP/'. $cabang . '/' . $nospp .'/II/' . $hasiltahun;
				
			}
			if($hasilbulan == '03') {
				$nospp = 'SPP/'. $cabang . '/' . $nospp .'/III/' . $hasiltahun;
				
			}
			if($hasilbulan == '04') {
				$nospp = 'SPP/'. $cabang . '/' . $nospp .'/IV/' . $hasiltahun;
				
			}
			if($hasilbulan == '05') {
				$nospp = 'SPP/'. $cabang .'/' . $nospp .'/v/' . $hasiltahun;
				
			}
			if($hasilbulan == '06') {
				$nospp = 'SPP/'. $cabang . '/' . $nospp .'/VI/' . $hasiltahun;
				
			}
			if($hasilbulan == '07') {
				$nospp = 'SPP/'. $cabang . '/' . $nospp .'/VII/' . $hasiltahun;
			}
			if($hasilbulan == '08') {
				$nospp = 'SPP/'. $cabang . '/' . $nospp .'/VIII/' . $hasiltahun;
			}
			if($hasilbulan == '09') {
				$nospp = 'SPP/'. $cabang . '/' . $nospp .'/IX/' . $hasiltahun;
			}
			if($hasilbulan == '10') {
				$nospp = 'SPP/'. $cabang . '/' . $nospp .'/X/' . $hasiltahun;
			}
			if($hasilbulan == '11') {
				$nospp = 'SPP/'. $cabang . '/' . $nospp .'/XI/' . $hasiltahun;
			}
			if($hasilbulan == '12') {
				$nospp = 'SPP/'. $cabang . '/' . $nospp .'/XII/' . $hasiltahun;
			}

			$tbb = $request->total_biaya;
			$hasiltbb = str_replace(',', '', $tbb);
			
			$spp = new spp_purchase();
			$spp->spp_nospp = strtoupper($request->nospp);
			$spp->spp_id = strtoupper($idspp);
			$spp->spp_tgldibutuhkan = strtoupper($request->tgl_dibutuhkan);
			$spp->spp_cabang = strtoupper($request->comp);
			$spp->spp_bagian = strtoupper($request->bagian);
			$spp->spp_keperluan = strtoupper($request->keperluan);
			$spp->spp_status = 'DITERBITKAN';
			$spp->spp_noform = 'JPM/FR/PURC/01';
			$spp->spp_keterangan = strtoupper($request->keterangan);
			$spp->spp_penerimaan = $request->spp_penerimaan;

			$jenisitem = explode(",", $request->jenisitem);
			$idjenisitem = $jenisitem[0];

			if($request->spp_penerimaan == 'T'){
				$spp->spp_tipe = 'J';				
			}
			else {
				if($request->updatestock == 'Y'){
					$spp->spp_lokasigudang = $request->gudang;
					$spp->spp_tipe = 'S';
				}
				else if($request->updatestock == 'T'){
					$spp->spp_tipe = 'NS';
				}
			}

			$spp->save();



			$co = new co_purchase();

			$lastidco = co_purchase::max('co_id'); 
			
			
			
			if(isset($lastidco)) {
				$idco = $lastidco + 1;
			
			}
			else {
				$idco = 1;
			
			}

			$status = 'BELUM DI SETUJUI';
		//	$time = '';

			$co->co_id = $idco;
			$co->co_noco = 'CO' . '-' . $idspp;
			$co->co_idspp = $spp->spp_id;
			$co->mng_umum_approved = $status;
		//	$co->time_mng_umum_approved = $time;
			$co->co_mng_pem_approved = $status;
		//	$co->co_time_mng_pem_approved = $time;
			$co->co_staffpemb_approved = $status;
		//	$co->co_time_staffpemb_approved = $status;
			$co->save();

			//menghitung banyaknya barang
			$countidbarang = count($request->idbarang);			
			$sppdt = new sppdt_purchase();

			//menghitung id sppdt
			$lastidsppd = sppdt_purchase::max('sppd_idsppdetail'); 
			
			if(isset($lastidsppd)) {
			/*	$explode = explode("-", $lastidsppd);
				$idsppdt = $explode[1];*/
				$idsppdt = $lastidsppd;
				$id_sppdt = (int)$idsppdt + 1;
			}
			else {
				$id_sppdt = 1;			
			}

			$sup = $request->supplier;
			$seq = 1;
			$row = $request->row;


			$brg = 0;
			$j = 1;

			$countsup = $request->row;
			$arrsup = array();
			for($i = 0; $i<$countsup; $i++) {
					$idsupplier = $request->supplier[$i];
					$explode = explode("," , $idsupplier);
					$id_supplier = $explode[0];
					$countrsup = $explode[2];		
					array_push($arrsup, $countrsup);
			}

			$string = $request->idbarang;
	/*		dd($arrsup);*/
	/*		dd($string);*/
			$arrbrg = array();
			$indxbrg = array();
			for($k=0;$k<count($string);$k++){
				$idbarang = $request->idbarang[$k];
				$explode = explode("," , $idbarang);
				$idbrang = $explode[0];
			
				array_push($arrbrg , $idbrang);
				
			}
		/*	dd($arrbrg);*/
	//	dd($request->qty_request);
			$string_idbrg = $request->qty_request;
		//	dd($string_idbrg);
			for($k=0;$k<count($string_idbrg);$k++){
				$idbarang2 = $request->qty_request[$k];
				
				$indx = $idbarang2;
				//array_push($arrbrg , $idbrang);
				array_push($indxbrg , $indx);
			}

			/*dd($arrbrg);*/
		//	dd($indxbrg);
			$valsup = array_count_values($arrsup);
			$countvalsup = count($valsup);
			$n = 0;
		//	dd($request->supplier , $indxbrg);
			for($i=0;$i<$row;$i++){
				$sppdt = new sppdt_purchase();
				
				//idbarang
				$string = $request->idbarang[$brg];
				$explode = explode(",", $string);
				$kodeitem = $explode[1];
				
				//idsupplier
				$idsupplier = $request->supplier[$i];
				$explode = explode("," , $idsupplier);
				$id_supplier = $explode[6];
				$countrsup = $explode[2]; 

				$sppdt->sppd_idsppdetail= $id_sppdt;
				$sppdt->sppd_idspp = $spp->spp_id;
				$sppdt->sppd_seq = $seq;

				$idbrg = $arrsup[$i] - 1;
				//arrbrg = kodeitem;
				//arrsup = 	no kolom;
				//valsup = count per index

				if($countrsup == $indxbrg[$n]) { 
					$sppdt->sppd_kodeitem = $arrbrg[$n];
					$sppdt->sppd_qtyrequest = $request->qty[$n];

					if($request->updatestock == 'T'){
						$sppdt->sppd_kendaraan = $request->kendaraan[$n];
					}
				
					//$n++;
				}
				else {
					$n = $n + 1;
					$sppdt->sppd_kodeitem = $arrbrg[$n];
					$sppdt->sppd_qtyrequest = $request->qty[$n];

					if($request->updatestock == 'T'){
						$sppdt->sppd_kendaraan = $request->kendaraan[$n];
					}
					
				}


				$stringharga = $request->harga[$i];
				$replacehrg = str_replace(',', '', $stringharga);
				
				$sppdt->sppd_supplier =$id_supplier;
				$sppdt->sppd_bayar = $request->bayar[$i];
				$sppdt->sppd_harga = $replacehrg;
				$sppdt->save();
				$id_sppdt++;
				$seq++;
			}


			$spptb = new spptb_purchase();
			//menghitung id sppdt
		

			$lastidspptb = 	spptb_purchase::max('spptb_id'); ;
		
			if(isset($lastidspptb)) {			
				/*$explode = explode("-", $lastidspptb->spptb_id);
				$idspptb = $explode[1];*/
				$idspptb = $lastidspptb;
				$idspptb = (int)$idspptb + 1;
				
			}
			else {
				$idspptb = 1;
				
			}	
			for($j=0;$j<count($request->totbiaya);$j++){

				$spptb = new spptb_purchase();
			
					$stringtb = $request->totbiaya[$j];
					$replacetb = str_replace(',', '', $stringtb);
					
				$spptb->spptb_id = $idspptb;
				$spptb->spptb_idspp = $spp->spp_id;
				$spptb->spptb_supplier = $request->idsupplier[$j];
				$spptb->spptb_totalbiaya = $replacetb;
				$spptb->spptb_bayar = $request->syaratkredit[$j];
				$spptb->save();
				$idspptb++;
			}
		}

       		return redirect('suratpermintaanpembelian');
	}


	public function updatespp($id, Request $request){
	/*	dd($request);*/

		$updatespp = spp_purchase::find($id);
	

		$updatespp->spp_nospp = $request->nospp;
		$updatespp->spp_id = $request->idspp;
		$updatespp->spp_tgldibutuhkan = $request->tgl_dibutuhkan;
		$updatespp->spp_cabang = strtoupper($request->cabang);
		$updatespp->spp_bagian = strtoupper($request->bagian);
		$updatespp->spp_keperluan = strtoupper($request->keperluan);
		$updatespp->save();

		
		$n = 0; //index untuk array barang
		for($i=0; $i<count($request->itembarang); $i++) {
			$updatesppdt = sppdt_purchase::where([['sppd_idspp', '=', $id], ['spp_detail.sppd_idsppdetail' , '=' , $request->idsppd[$i]]]  );

			$explode = explode(",", $request->itembarang[$i]);
			$idbrg = $explode[1];


			$replacehrg = str_replace(',', '', $request->harga[$i]);

			
			  if($idbrg == $n) {
				$updatesppdt->update([
				 	'sppd_kodeitem' => $request->item[$n],
				 	'sppd_qtyrequest' => $request->qtyrequest[$n],
				 	
			 	]);			 	
			 }
			 else {
			 	$n = (int)$n + 1;
			 	$updatesppdt->update([
				 	'sppd_kodeitem' => $request->item[$n],
				 	'sppd_qtyrequest' => $request->qtyrequest[$n]
			 	]);	
			 }
			// dd( $request->idsuplier[$i]);
			 $updatesppdt->update([
			 	'sppd_supplier' => $request->idsuplier[$i],
		 		'sppd_bayar' => $request->syaratkredit[$i],
		 		'sppd_harga' =>$replacehrg
			 ]);
		}
		
		for($k=0; $k<count($request->idsup); $k++){
			$updatespptb = spptb_purchase::where([['spptb_idspp', '=', $id] , ['spp_totalbiaya.spptb_id' , '=' , $request->idspptb[$k]]]);
			$replacetotal = str_replace(',', '', $request->bayar[$k]);
			$explode1 = explode(",", $request->idsup[$k]);
			$idsupp = $explode1[0];

			$updatespptb->update([
				'spptb_supplier' => $idsupp,
				'spptb_totalbiaya' => $replacetotal
				]);

		}

		return redirect('suratpermintaanpembelian');	
	}

	public function detailspp ($id) {

		$data['spp'] = DB::select("select * from confirm_order, spp, masterdepartment where co_idspp = '$id' and spp_bagian = kode_department and co_idspp = spp_id");
		
		$data['sppdt'] =  DB::select("select * from spp, masteritem, supplier, spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item where sppd_idspp = '$id' and sppd_idspp = spp_id and kode_item = sppd_kodeitem and idsup = sppd_supplier order by sppd_seq asc");

		$data['gudang'] = DB::select("select mg_namagudang from spp, mastergudang where spp_lokasigudang = mg_id and spp_id = '$id'");

		$data['kendaraan'] = DB::select("select distinct sppd_kendaraan, merk, vhccde from spp_detail, tb_vhc where sppd_kendaraan = id_vhc and sppd_idspp = '$id'");
		$data['countkendaraan'] = count($data['kendaraan']);

		$data['masterkendaraan'] = DB::select("select * from tb_vhc");

		$data['sppdt_barang'] = DB::select("select distinct sppd_kodeitem, nama_masteritem, sppd_qtyrequest, sppd_kendaraan , sg_qty, unitstock from  masteritem , spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item  where sppd_idspp = '$id' and kode_item = sppd_kodeitem");
		
		$data['spptb'] =  DB::select("select * from spp_totalbiaya,spp, supplier where spptb_idspp = '$id' and spptb_idspp = spp.spp_id and spptb_supplier = idsup");
		
		$data['sppd_brg'] = DB::select("select sppd_kodeitem from spp_detail where sppd_idspp='$id'");

		$data['codt'] = DB::select("select *  from confirm_order, spp, confirm_order_dt LEFT OUTER JOIN stock_gudang on codt_kodeitem = sg_item where confirm_order_dt.codt_idco=co_id and co_idspp = '$id' and co_idspp = spp_id");

		$data['codt_supplier'] = DB::select("select distinct codt_supplier, nama_supplier from supplier, confirm_order_dt, spp, confirm_order where codt_supplier = idsup and co_idspp = spp_id and spp_id = '$id' and codt_idco = co_id");
		
		$data['hitungbayar'] = DB::select("select distinct sppd_supplier, sppd_bayar, nama_supplier from spp_detail, supplier where sppd_idspp = '$id' and sppd_supplier = idsup");

		$data['count'] = count($data['spptb']);
		$data['countcodt'] = count($data['codt']);

		$data['count_brg'] = count($data['sppdt_barang']);
	
		$data['supplier'] = DB::select("select * from supplier where status = 'SETUJU'");
		$data['item'] = DB::select("select * from masteritem, jenis_item where masteritem.jenisitem = jenis_item.kode_jenisitem ORDER BY kode_item DESC");

		$data['cabang'] = master_cabang::all();			        
	
		$data['supplier'] = DB::select("select * from supplier where status = 'SETUJU'");

		$data['department'] = master_department::all();

		$barang = array();
		for($i=0; $i<count($data['sppd_brg']);$i++){
				array_push($barang , $data['sppd_brg'][$i]->sppd_kodeitem);
		}


		$data['countbrg'] = array_count_values($barang);
		

	/*	dd($data);*/
	
		return view('purchase.spp.detail', compact('data'));
	}


	public function statusspp($id) {
			$data['spp'] = DB::select("select * from confirm_order, spp, masterdepartment where co_idspp = '$id' and spp_bagian = kode_department and co_idspp = spp_id");
	/*	dd($data['spp']);*/
		
		$data['sppdt'] =  DB::select("select * from spp, masteritem, supplier, spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item where sppd_idspp = '$id' and sppd_idspp = spp_id and kode_item = sppd_kodeitem and idsup = sppd_supplier order by sppd_seq asc");

		$data['sppdt_barang'] = DB::select("select distinct sppd_kodeitem, nama_masteritem, sppd_qtyrequest, sg_qty, unitstock from  masteritem , spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item  where sppd_idspp = '$id' and kode_item = sppd_kodeitem ");
		
		$data['spptb'] =  DB::select("select * from spp_totalbiaya,spp, supplier where spptb_idspp = '$id' and spptb_idspp = spp.spp_id and spptb_supplier = idsup");
		
		$data['sppd_brg'] = DB::select("select sppd_kodeitem from spp_detail where sppd_idspp='$id'");

		$data['codt'] = DB::select("select *  from confirm_order, masteritem, spp, confirm_order_dt LEFT OUTER JOIN stock_gudang on codt_kodeitem = sg_item where confirm_order_dt.codt_idco=co_id and co_idspp = '$id' and co_idspp = spp_id and codt_kodeitem = kode_item");

		$data['codt_supplier'] = DB::select("select distinct codt_supplier, nama_supplier from supplier, confirm_order_dt, spp, confirm_order where codt_supplier = idsup and co_idspp = spp_id and spp_id = '$id' and codt_idco = co_id");

		$data['codt_tb'] =  DB::select("select * from confirm_order_tb, confirm_order where cotb_idco = co_id and co_idspp = '$id' ");
		
		
		$data['count'] = count($data['spptb']);
		$data['countcodt'] = count($data['codt']);

		$data['count_brg'] = count($data['sppdt_barang']);
	
		$data['supplier'] = DB::select("select * from supplier where status = 'SETUJU'");
		$data['item'] = DB::select("select * from masteritem, jenis_item where masteritem.jenisitem = jenis_item.kode_jenisitem   ORDER BY kode_item DESC");

		$data['count_po'] = DB::select("select count(*) as total from pembelian_orderdt where podt_idspp = '$id' ");
	/*	dd($data['count_po']);*/


		$barang = array();
		for($i=0; $i<count($data['sppd_brg']);$i++){
				array_push($barang , $data['sppd_brg'][$i]->sppd_kodeitem);
		}


		$data['countbrg'] = array_count_values($barang);

		return view('purchase.spp.status_spp', compact('data'));
	}

	public function deletespp($id) {
		$data2 = spp_purchase::find($id); 
     
      	$data3 = DB::select("select * from spp_totalbiaya where spptb_idspp = '$id'");
      	
 		$idpo = $data3[0]->spptb_poid;

 		if($idpo == NULL) {
 		//	dd('null');
			$data2->delete($data2);				
 		}
 		else {
 		//	dd('tdknull');
	     	$po = purchase_orderr::find($idpo);
	     	/*dd($idpo);
	     	dd($po);*/
	     	$po->delete($po);
     		$data2->delete($data2);
 		}
       	Session::flash('sukses', 'data item berhasil dihapus');
        return redirect('suratpermintaanpembelian');
	}



	public function createPdfSpp($id)
	{	
		$dataSpp = $this->getQueryForPdfSpp($id)[0];
		$supplier1 = [];
		$supplier2 = [];
		$supplier3 = [];
		$suppliers = [];

		foreach ($dataSpp as $key => $value) {
			$suppliers[] = $key;
		}
		
		switch (count($suppliers)) {
			case 1:
					$supplier1 = $this->getSupplier($supplier1, $suppliers[0], $dataSpp);
				break;

			case 2:
					$supplier1 = $this->getSupplier($supplier1, $suppliers[0], $dataSpp);
					$supplier2 = $this->getSupplier($supplier2, $suppliers[1], $dataSpp);
					array_push($supplier1["hargaTotal"], "---");
					array_push($supplier2["hargaTotal"], "---");
					$hargaTotal = array_reverse($supplier2["hargaTotal"]);
					$supplier2["hargaTotal"] = $hargaTotal;
				break;
				
			default:
					$supplier1 = $this->getSupplier($supplier1, $suppliers[0], $dataSpp);
					$supplier2 = $this->getSupplier($supplier2, $suppliers[1], $dataSpp);
					$supplier3 = $this->getSupplier($supplier3, $suppliers[2], $dataSpp);
					//$hargaTotal = array($supplier2["hargaTotal"],$supplier2["hargaTotal"],$supplier3["hargaTotal"]);
				break;
		}	
		
		//dd($supplier1, $supplier2, $supplier3);			
		return view('purchase.spp.createPDF', [
			"spp" => $this->getQueryForPdfSpp($id)[1],
			"suppliers" => $suppliers,
			"supplier1" => $supplier1,
			"supplier2" => $supplier2,
			"supplier3" => $supplier3,
		]);
	}

	private function getSupplier($name, $data, $fromData = array())
	{
		$total = 0;
		$ttlPrice = 0;

		for ($j = 0; $j < count(array_values($fromData[$data])); $j++) { 
			$total += $fromData[$data][$j]["harga"] * $fromData[$data][$j]["quantity"];
			$ttlPrice = $fromData[$data][$j]["harga"] * $fromData[$data][$j]["quantity"];

			$name["supplier"] = $data;
			$name["id"][] = $fromData[$data][$j]["id"];
			$name["status"][] = $fromData[$data][$j]["status"];
			$name["barang"][] = $fromData[$data][$j]["barang"];
			$name["quantity"][] = $fromData[$data][$j]["quantity"];
			$name["hargaSatuan"][] = $fromData[$data][$j]["harga"];
			$name["hargaTotal"][] = $ttlPrice;								 
			$name["TOTAL"] = $total;
			$name["unitstock"][] = $fromData[$data][$j]["unitstock"];
		}

		return $name;
	}

	private function getQueryForPdfSpp($id)
	{
		$tmpDataBarang = [];
		$tmpDataSpp = [];
		$detailSpp = sppdt_purchase::with('belongs')->where("sppd_idspp", $id)->get();
		$spp = $detailSpp[0]["belongs"]["table"];
		$created_at = DB::table("spp")->select("created_at")->where("spp_id", $id)->get();
		
		for ($index = 0; $index < count($detailSpp); $index++) { 

			$tempSupplier[] = DB::table("supplier")
					  ->select("nama_supplier", "active")
					  ->where("no_supplier", $detailSpp[$index]['sppd_supplier'])
					  ->get();

			$tempBarang[] = DB::table("masteritem")
					  ->select('nama_masteritem', 'unitstock')
					  ->where('kode_item', $detailSpp[$index]['sppd_kodeitem'])
					  ->get();

			$department = DB::table($spp)
					  ->join("masterdepartment", "{$spp}.spp_bagian", '=', "masterdepartment.kode_department")
					  ->select("masterdepartment.nama_department")
					  ->where("masterdepartment.kode_department", $detailSpp[$index]["belongs"]["spp_bagian"])
					  ->first();

			$pOrder = DB::table('pembelian_orderdt')
					   ->select("podt_idpo", "podt_idspp")
					   ->where([
					   		[ "podt_idspp", $detailSpp[$index]['belongs']['spp_id'] ],
					   		[ "podt_kodeitem", $detailSpp[$index]['sppd_kodeitem'] ],
					   ])->get();

			$PO = "";
			if (!empty($pOrder)) {
				$po = DB::table("pembelian_order")->select("po_no")->where("po_id", $pOrder[0]->podt_idpo)->get();
				$PO = $po[0]->po_no;
			} else {
				$PO = "Belum Memiliki PO";
			}

			$tmpDataBarang[$tempSupplier[$index][0]->nama_supplier][] = array(
				"id" => $detailSpp[$index]["sppd_idsppdetail"],
				"status" => $tempSupplier[$index][0]->active,
				"barang" => $tempBarang[$index][0]->nama_masteritem,
				"quantity" => $detailSpp[$index]['sppd_qtyrequest'],
				"harga" => $detailSpp[$index]['sppd_harga'],
				"unitstock" => $tempBarang[$index][0]->unitstock
			);

			$tmpDataSpp = array(
				"no_spp" => $detailSpp[$index]["belongs"]["spp_nospp"],
				"cabang" => $detailSpp[$index]["belongs"]["spp_cabang"],
				"created_at" => $created_at[0]->created_at,
				"keperluan" => $detailSpp[$index]['belongs']['spp_keperluan'],
				"tglSpp" => $detailSpp[$index]['belongs']['spp_tgldibutuhkan'],
				"bagian" => $department->nama_department,
				"noPO" => $PO,
				"noForm" => $detailSpp[$index]["belongs"]["spp_noform"]
			);
		}

		return array($tmpDataBarang, $tmpDataSpp);	
	}
	
	public function deletesup($id){

		$datasptb = spptb_purchase::find($id);

		$datasptb->delete($datasptb);
		Session::flash('sukses', 'data item berhasil dihapus');
        return redirect('masteritem/masteritem');	
	}

	public function confirm_order () {
		$data['spp']=spp_purchase::all();

		$data['co']=DB::select("select * from confirm_order, spp where co_idspp = spp_id order by co_id desc");


		return view('purchase.confirm_order.index', compact('data'));
	}


	

	public function confirm_order_dt ($id) {
		
	$data['spp'] = DB::select("select * from confirm_order, spp, masterdepartment where co_idspp = '$id' and spp_bagian = kode_department and co_idspp = spp_id");
	/*	dd($data['spp']);*/
		
		$data['sppdt'] =  DB::select("select * from spp, masteritem, supplier, spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item where sppd_idspp = '$id' and sppd_idspp = spp_id and kode_item = sppd_kodeitem and  sppd_supplier = idsup order by sppd_seq asc");

		$data['sppdt_barang'] = DB::select("select distinct sppd_kodeitem, nama_masteritem, sppd_qtyrequest, sg_qty, unitstock from  masteritem , spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item  where sppd_idspp = '$id' and kode_item = sppd_kodeitem ");
		
		$data['spptb'] =  DB::select("select * from spp_totalbiaya,spp, supplier where spptb_idspp = '$id' and spptb_idspp = spp.spp_id and spptb_supplier = idsup");
		
		$data['sppd_brg'] = DB::select("select sppd_kodeitem from spp_detail where sppd_idspp='$id'");

		$data['codt'] = DB::select("select *  from confirm_order, masteritem, spp, confirm_order_dt LEFT OUTER JOIN stock_gudang on codt_kodeitem = sg_item where confirm_order_dt.codt_idco=co_id and co_idspp = '$id' and co_idspp = spp_id and codt_kodeitem = kode_item");

		$data['codt_supplier'] = DB::select("select distinct codt_supplier, nama_supplier from supplier, confirm_order_dt, spp, confirm_order where codt_supplier = idsup and co_idspp = spp_id and spp_id = '$id' and codt_idco = co_id");

		$data['codt_tb'] =  DB::select("select * from confirm_order_tb, confirm_order where cotb_idco = co_id and co_idspp = '$id' ");
		
		
		$data['count'] = count($data['spptb']);
		$data['countcodt'] = count($data['codt']);

		$data['count_brg'] = count($data['sppdt_barang']);
	
		$data['supplier'] = DB::select("select * from supplier where status = 'SETUJU'");
		$data['item'] = DB::select("select * from masteritem, jenis_item where masteritem.jenisitem = jenis_item.kode_jenisitem   ORDER BY kode_item DESC");

		$barang = array();
		for($i=0; $i<count($data['sppd_brg']);$i++){
				array_push($barang , $data['sppd_brg'][$i]->sppd_kodeitem);
		}


		$data['countbrg'] = array_count_values($barang);
		
	//	dd($data);
		

		return view('purchase.confirm_orderdetail.index4', compact('data'));
	}	




	public function ajax_confirmorderdt(Request $request) {

		$id = $request->idspp;
		
		$data['spp'] = DB::select("select * from confirm_order, spp, masterdepartment where co_idspp = '$id' and spp_bagian = kode_department and co_idspp = spp_id");
		
		$data['sppdt'] =  DB::select("select * from spp, masteritem, supplier, spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item where sppd_idspp = '$id' and sppd_idspp = spp_id and kode_item = sppd_kodeitem and idsup = sppd_supplier order by sppd_seq asc");

		

		$data['sppdt_barang'] = DB::select("select distinct sppd_kodeitem, nama_masteritem, sppd_qtyrequest, sg_qty, unitstock from  masteritem , spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item  where sppd_idspp = '$id' and kode_item = sppd_kodeitem");
		
		$data['spptb'] =  DB::select("select * from spp_totalbiaya,spp, supplier where spptb_idspp = '$id' and spptb_idspp = spp.spp_id and spptb_supplier = idsup");
		
		
		$data['codt_tb'] =  DB::select("select * from confirm_order_tb, confirm_order where cotb_idco = co_id and co_idspp = '$id' ");
		$data['counthrgbrg'] = count($data['sppdt']);
		$data['count'] = count($data['spptb']);
		$data['countbrg'] = count($data['sppdt_barang']);

		$data['codt'] = DB::select("select *  from confirm_order, masteritem, spp, confirm_order_dt LEFT OUTER JOIN stock_gudang on codt_kodeitem = sg_item where confirm_order_dt.codt_idco=co_id and co_idspp = '$id' and co_idspp = spp_id and codt_kodeitem = kode_item");

		$data['codt_supplier'] = DB::select("select distinct codt_supplier, nama_supplier from supplier, confirm_order_dt, spp, confirm_order where codt_supplier = idsup and co_idspp = spp_id and spp_id = '$id' and codt_idco = co_id");
		

	//	$data['count'] = count($data['spptb']);
		$data['countcodt'] = count($data['codt']);
	
		
		return json_encode($data);

		
	}

	public function saveconfirmorderdt(Request $request){
	//	dd($request);

		$updatespp = spp_purchase::where('spp_id', '=', $request->idspp);
		$updatespp->update([
			'spp_status' => 'DITERIMA',
		]);	

		$idsppcodt = $request->idspp;

		$co = co_purchase::find($idsppcodt);

		$codt = new co_purchasedt();

		$mytime = Carbon::now();		
		if($request->mngstaffpemb != '') {
			$co->co_staffpemb_approved = $request->mngstaffpemb;
			$co->co_time_staffpemb_approved = $mytime;
			$co->save();
		}

		if($request->mngpembsetuju != '') {
			$co->co_mng_pem_approved = $request->mngpembsetuju;
			$co->co_time_mng_pem_approved = $mytime;
			$co->save();
		}

		$setuju = 'DISETUJUI';
		
		$co->co_mng_pem_approved = $setuju;
		$co->co_time_mng_pem_approved = $mytime;
		$co->save();

		$co->co_staffpemb_approved = $setuju;
		$co->co_time_staffpemb_approved = $mytime;
		$co->save();

		$countitem = count($request->item);

		$countitm = count($request->supplier);

	/*	if($countitm > 1) {
			dd('yes lbh dr 1');
		}
		else {
			dd('no');
		}*/

/*		dd($countitm);*/
		
		$countapproval = count($request->qtyapproval);

		$n = 1;
		$idsup = 0;
		for($i = 0 ; $i <$countapproval; $i++) {

			$lastid = co_purchasedt::max('codt_id'); 

			if(isset($lastid)) {
				$idco = (int)$lastid + 1;
			}
			else {
				$idco = 1;
			}

			$codt = new co_purchasedt();


				$codt->codt_id = $idco;
				$codt->codt_idco = $request->idco;
				$codt->codt_seq = $n;
				$codt->codt_kodeitem = $request->item[$i];
				$codt->codt_qtyrequest = $request->qtyrequest[$i];
				$codt->codt_qtyapproved = $request->qtyapproval[$i];

				/*$string = $request->supplier3[$i];
				$explode = explode(",", $string);
				$idsup = $explode[0];*/

				$codt->codt_supplier = $request->datasup[$i];
				/*if(count($request->supplier) > 1 ){
					
					$idsup++;
				}
				else {
					$codt->codt_supplier = $request->supplier[$idsup];	
				}*/
				
				$codt->codt_harga = $request->harga[$i];
				$codt->save();
				$n++;	
		}	


		$cotb = new co_purchasetb();
		for($k=0; $k < count($request->bayar); $k++){

			if($request->bayar[$k] == "undefined") {

			}
			else{
				$cotb = new co_purchasetb();
				$lastid = co_purchasetb::max('cotb_id'); 	
				if(isset($lastid)) {
					$idcotb = (int)$lastid + 1;
				}
				else {
					$idcotb = 1;
				}
				$stringharga = $request->bayar[$k];
				$replacehrg = str_replace(',', '', $stringharga);

				$cotb->cotb_id = $idcotb;
				$cotb->cotb_idco = $request->idco;

			
				$cotb->cotb_supplier =$request->datasup[$k];

				$cotb->cotb_totalbiaya = $replacehrg;
				$cotb->cotb_setuju = 'BELUM DI SETUJUI';
				$cotb->cotb_bayar = $request->spptb_bayar[$k];
				$cotb->save();
			}


		}
		


		$data['co'] = DB::select("select * from confirm_order where co_idspp = '$idsppcodt'");
		$data['spp'] = DB::select("select * from spp, masterdepartment, cabang where spp_bagian = kode_department and spp_id = '$idsppcodt' and spp_cabang =  kode ");
	//	dd($data['spp']);
		$data = array('namacabang'=>$data['spp'][0]->nama ,
						'nospp' => $data['spp'][0]->spp_nospp,
						'setujumngumum'=> $data['co'][0]->mng_umum_approved,
						'setujumngpem' => $data['co'][0]->co_mng_pem_approved,
						'setujustaffpemb' => $data['co'][0]->co_staffpemb_approved);

		return redirect('konfirmasi_order/konfirmasi_order');
	}

	public function createAjax() {
		$ana = 'halo';

		return $ana;
	}

	public function pdf_spp () {

		/*$cabang = masterGudangPurchase::all();
		*/

		$pdf = PDF::loadView('purchase/outputsurat/spp')->setPaper('a4', 'landscape');

    	return $pdf->stream();
    //	return view('purchase/outputsurat/spp1');
	}

	
public function purchase_order() {

		$data['po'] = DB::select("select * from pembelian_order, supplier, cabang where po_supplier = idsup and po_cabang = kode order by po_id desc");
		$data['spp'] = DB::select("select * from  spp, supplier, cabang, confirm_order, confirm_order_tb where co_idspp = spp_id and co_mng_pem_approved = 'DISETUJUI' and spp_cabang = kode and cotb_idco = co_id and cotb_supplier = idsup  and cotb_setuju = 'BELUM DI SETUJUI'");

		$data['countspp'] = count($data['spp']);
		
		$data['posetuju'] = DB::table("pembelian_order")->where('po_setujufinance' , '=' , 'DISETUJUI')->count();
		$data['porevisi'] = DB::table("pembelian_order")->where('po_setujufinance' , '=' , 'DIREVISI')->count();
		$data['poditolak'] = DB::table("pembelian_order")->where('po_setujufinance' , '=' , 'DITOLAK')->count();
		$data['poblmdiproses'] = DB::table("pembelian_order")->whereNull('po_setujufinance')->count();

		Session::flash('message', 'Terdapat ' . count($data['spp']). ' data SPP yang belum di proses'); 

		//dd($data);
		 return view('purchase/purchase/index', compact('data'));

	}

	

	public function ajax_tampilspp(Request $request){
		$array =  $request->idspp;
		$data = array();
			$explode = explode("," , $array[0]);
			$idsupplier = $explode[1];
		//	return $idsupplier ;
			$data['supplier'] = DB::select("select * from supplier where idsup ='$idsupplier' and active = 'AKTIF' ");

			$data['gudang'] = DB::select("select * from mastergudang");
		for($j=0; $j < count($array); $j++){
				$explode = explode("," , $array[$j]);
				$idspp = $explode[0]; 
				$nosupplier = $explode[1]; 
				$gudang = $explode[2];
				
			if($gudang == 'null'){
							$data['spp'][] = DB::select("select * from spp, spp_totalbiaya, confirm_order, confirm_order_tb, supplier , cabang where co_idspp = spp_id and spp_id = '$idspp' and spp_cabang = kode and cotb_idco = co_id and cotb_supplier = idsup and active = 'AKTIF' and idsup = '$nosupplier' and cotb_supplier = '$nosupplier' and spptb_idspp = '$idspp' and spptb_supplier = cotb_supplier");
			}	
			else {
							$data['spp'][] = DB::select("select * from mastergudang, spp, spp_totalbiaya, confirm_order, confirm_order_tb, supplier , cabang where co_idspp = spp_id and spp_id = '$idspp' and spp_cabang = kode and cotb_idco = co_id and cotb_supplier = idsup and active = 'AKTIF' and idsup = '$nosupplier' and cotb_supplier = '$nosupplier' and spptb_idspp = '$idspp' and spptb_idspp = spp_id and spp_lokasigudang = mg_id and spptb_supplier = cotb_supplier");
			}	
			$data['codt'][] = DB::select("select * from confirm_order, masteritem,  confirm_order_dt , confirm_order_tb, spp where co_idspp = '$idspp' and codt_idco = co_id and cotb_idco = co_id and co_idspp = spp_id and codt_supplier = cotb_supplier and codt_supplier = '$nosupplier' and codt_kodeitem = kode_item");
		}
		return json_encode($data);
	}

	public function updatekeuangan(Request $request){
		$setujukeuangan = $request->valsetuju;
		$keterangan = $request->keterangan;
		$idpo = $request->poid;
		$idgudang = [];
		$lokasigudang = [];

		$updatepo = purchase_orderr::where('po_id', '=', $idpo);
		$updatepo->update([
			'po_setujufinance' => $setujukeuangan,
			'po_keteranganfinance' => $keterangan,			
		]);	
		for($j=0; $j < count($request->idspp); $j++){
		$idspp = $request->idspp[$j];
			if($idspp != '') {
				$updatespp = spp_purchase::where('spp_id' , '=' , $idspp);
				$updatespp->update([
					'spp_status' => $setujukeuangan
				]);

			}
		}

		$po = DB::select("select * from pembelian_order, pembelian_orderdt where podt_idpo = po_id and po_id = '$idpo'");
		for($ds = 0; $ds < count($po); $ds++){
			$namagudang = $po[$ds]->podt_lokasigudang;
			array_push($lokasigudang , $namagudang);		
		}
		
		
		$idgudang = array_unique($lokasigudang);

	
		for($j=0;$j < count($idgudang); $j++) {
			if($setujukeuangan == 'DISETUJUI'){

			$lastid = barang_terima::max('bt_id'); 

			if(isset($lastid)) {
				$idbarangterima = $lastid;
				$idbarangterima = (int)$idbarangterima + 1;
				
			}

			else {
				$idbarangterima = 1;
				
			}
				$nopo = DB::select("select * from pembelian_order where po_id = '$idpo'");
				$idsupplier = $nopo[0]->po_supplier;
				$nosupplier = DB::select("select * from supplier where idsup = '$idsupplier'");

				$barangterima = new barang_terima();
				$barangterima->bt_id = $idbarangterima;
				$barangterima->bt_flag = 'PO';
				$barangterima->bt_notransaksi = $nopo[0]->po_no;
				$barangterima->bt_supplier = $nosupplier[0]->idsup;
				$barangterima->bt_idtransaksi = $idpo;
				$barangterima->bt_statuspenerimaan = 'BELUM DI TERIMA';
				$barangterima->bt_gudang = $idgudang[$j];
				$barangterima->bt_tipe = $nopo[0]->po_tipe;
				$barangterima->bt_cabangpo = $nopo[0]->po_cabang;
				$barangterima->save();
			}
		}
		

		return json_encode('sukses');
	}

	public function detailpurchasekeuangan(Request $request){
		$id = $request->poid;
		$data['po'] = DB::select("select * from pembelian_order, supplier where po_id = '$id' and po_supplier = idsup and active = 'AKTIF'");

		$data['supplier'] = DB::select("select * from supplier where active='AKTIF'");

		$data['podt'] = DB::select("select * from pembelian_orderdt, spp, masteritem, cabang, mastergudang where podt_idpo = '$id' and podt_idspp = spp_id and podt_kodeitem = kode_item and spp_cabang = kode and podt_lokasigudang = mg_id");

		$data['spp'] = DB::select("select distinct spp_id , spp_nospp , spp_keperluan, nama_department , nama , spp_tgldibutuhkan from  pembelian_order , spp, pembelian_orderdt, cabang, masterdepartment where po_id = '$id' and podt_idpo = po_id  and podt_idspp = spp_id and spp_cabang = kode and spp_bagian = kode_department ");
		
		$idspp = [];
		for($i =0; $i < count($data['spp']); $i++){
			$data['idspp'][]= $data['spp'][$i]->spp_id;
			 array_push($idspp , $data['idspp']);
		}

		$data['gudang'] = DB::select("select * from mastergudang");
		$data['pbpo'] = DB::select("select pb_po from penerimaan_barang where pb_po = '$id'");

	

		/*dd($data['idspp']);*/

		for($j=0; $j < count($idspp); $j++){
			$data['podtbarang'][] = DB::select("select * from  pembelian_orderdt, masteritem, mastergudang where podt_idspp = ". $data['idspp'][$j] ." and podt_kodeitem = kode_item and podt_lokasigudang = mg_id and podt_idpo='$id'");
		}

		$data['countbrg'] = count($idspp);
 		
 		
	//	dd($data);

		return json_encode($data);
	}

	public function detailpurchase($id) {		
		$data['po'] = DB::select("select * from pembelian_order, supplier where po_id = '$id' and po_supplier = idsup and active = 'AKTIF'");

		$data['supplier'] = DB::select("select * from supplier where active='AKTIF'");

		$data['podt'] = DB::select("select * from pembelian_orderdt, spp, masteritem, cabang, mastergudang where podt_idpo = '$id' and podt_idspp = spp_id and podt_kodeitem = kode_item and spp_cabang = kode and podt_lokasigudang = mg_id");

		$data['spp'] = DB::select("select distinct spp_id , spp_nospp , spp_keperluan, nama_department , nama , spp_tgldibutuhkan from  pembelian_order , spp, pembelian_orderdt, cabang, masterdepartment where po_id = '$id' and podt_idpo = po_id  and podt_idspp = spp_id and spp_cabang = kode and spp_bagian = kode_department ");
		
		$idspp = [];
		for($i =0; $i < count($data['spp']); $i++){
			$data['idspp'][]= $data['spp'][$i]->spp_id;
			 array_push($idspp , $data['idspp']);
		}

		$data['gudang'] = DB::select("select * from mastergudang");


	

		/*dd($data['idspp']);*/

		for($j=0; $j < count($idspp); $j++){
			$data['podtbarang'][] = DB::select("select * from  pembelian_orderdt, masteritem, mastergudang where podt_idspp = ". $data['idspp'][$j] ." and podt_kodeitem = kode_item and podt_lokasigudang = mg_id and podt_idpo='$id'");
		}

		$data['countbrg'] = count($idspp);
 		
 		
	//	dd($data);

		return view('purchase/purchase/detail_purchase', compact('data'));
	}

	public function updatepurchase($id, Request $request){
	//	dd($request);

		$updatepo = purchase_orderr::where('po_id', '=', $id);
			$replacesubtotal = str_replace(',', '', $request->subtotal);
			$replacetotal = str_replace(',', '', $request->totalharga);

		$lengkap = 0;
		$tdklengkap = 0;
		for($i = 0; $i < count($request->statuskirim); $i++) {
			if($request->statuskirim[$i] == 'LENGKAP' ) {
				$lengkap = $lengkap + 1;
			}
			else {
				$tdklengkap = $tdklengkap +1;
			}
		}
		$status = '';
		if($lengkap == count($request->statuskirim)) {
			$status = 'LENGKAP';
		}
		else {
			$status = 'TIDAK LENGKAP';
		}

		$updatepo->update([
			'po_catatan' => $request->catatan,
			'po_bayar' => $request->bayar,
			'po_supplier' => $request->supplier,
			'po_diskon' => $request->diskon,
			'po_ppn' => $request->ppn,
			'po_subtotal' =>$replacesubtotal,
			'po_totalharga' => $replacetotal,
			'po_status' => $status,
			'po_jenisppn' => $request->jenisppn,
		]);			 	

		for($j = 0; $j < count($request->statuskirim); $j++) {
			$jumlahharga = str_replace(',', '', $request->jumlahharga[$j]);
			$totalharga2 = str_replace(',', '', $request->totalharga2[$j]);

			$updatepodt = purchase_orderdt::where('podt_idpo' , '=', $id);
			$updatepodt->update([
				'podt_qtykirim' => $request->qtykirim[$j],
				'podt_supplier' => $request->supplier,
				'podt_jumlahharga' => $jumlahharga,
				'podt_statuskirim' => $request->statuskirim[$j],
				'podt_lokasigudang' => $request->lokasigudang[$j],
				'podt_totalharga' => $totalharga2
			]);
		}

		return redirect('purchaseorder/purchaseorder');	
	}

	public function savepurchase(Request $request){
		
			/*dd($request);*/
			
			
			$current_time = Carbon::now()->toDateTimeString();
			for($k = 0 ; $k < count($request->idcotbsetuju); $k++) {
				$updateco = co_purchasetb::where('cotb_id', '=', $request->idcotbsetuju[$k]);
				$updateco->update([
				 	'cotb_setuju' => 'DISETUJUI',
				 	'cotb_timesetuju' => $current_time,
				 	
			 	]);	
			}

			$lastid = purchase_orderr::max('po_id'); 

			if(isset($lastid)) {
				$po_id = $lastid;
				$po_id = (int)$po_id + 1;
				$no_po = str_pad($po_id, 4, '0', STR_PAD_LEFT);
			}

			else {
				$po_id = 1;
				$no_po = str_pad($po_id, 4, '0', STR_PAD_LEFT);
			}


			
			$time = Carbon::now();
	//	$newtime = date('Y-M-d H:i:s', $time);  
		
				$year =Carbon::createFromFormat('Y-m-d H:i:s', $time)->year; 
				$month =Carbon::createFromFormat('Y-m-d H:i:s', $time)->month; 

				if($month < 10) {
					$month = '0' . $month;
				}

				$year = substr($year, 2);


				$comp = $request->cabang;
				$idpo =   purchase_orderr::where('po_cabang' , $comp)->max('po_id');
				
				if(isset($idpo)) {
					/*$explode = explode("/", $idpo);
					$idpo = $explode[2];*/

					$string = (int)$idpo + 1;
					$idpo = str_pad($string, 3, '0', STR_PAD_LEFT);
				}

				else {
					$idpo = '001';
				}


				$comp = $request->cabang;
				$nopo = 'PO' . $month . $year . '/' . $comp . '/' .  $idpo;

			$temptdklengkap = 0;
			$lengkap = 0;

			for($j=0;$j<count($request->status);$j++){
				if($request->status[$j] == 'TIDAK LENGKAP'){
					$temptdklengkap = $temptdklengkap + 1;
				}
				else {
					$lengkap = $lengkap + 1;
				}
			}

			$po = new purchase_orderr();
				$po->po_id = $po_id;
				$po->po_no = $nopo;
				$po->po_catatan = strtoupper($request->catatan);
				$po->po_bayar = strtoupper($request->bayar);

				if($lengkap == count($request->status)) {
					$po->po_status ='LENGKAP';
				}
				else {
					$po->po_status = 'TIDAK LENGKAP';
				}

				$replacesubtotal = str_replace(',', '', $request->subtotal);
				$replacetotal = str_replace(',', '', $request->total);

				$po->po_supplier = strtoupper($request->idsupplier);
				if($request->diskon == ''){

				}
				else {
					$po->po_diskon = strtoupper($request->diskon);
				}
				if($request->ppn == ''){

				}
				else {
					$po->po_ppn = strtoupper($request->ppn);
				}
				$po->po_subtotal = $replacesubtotal;
				$po->po_totalharga = $replacetotal;
				$po->po_noform = 'JPM/FR/PURC/02 Januari-' . $year;
				$po->po_cabang = $comp;
				$po->po_updatefp = 'T';
				$po->po_tipe = $request->spptipe;
				$po->po_penerimaan = $request->spp_penerimaan;
				$po->po_jenisppn = $request->jenisppn;
				$po->save();


			for($n = 0; $n < count($request->kodeitem); $n++) {
			/*	dd('ana');*/
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
				$podt->podt_kodeitem = strtoupper($request->kodeitem[$n]);
				$podt->podt_approval = strtoupper($request->qtyapproved[$n]);
				$podt->podt_qtykirim = strtoupper($request->qtykirim[$n]);
				$podt->podt_supplier =	strtoupper($request->idsupplier);

				$replaceharga = str_replace(',', '', $request->harga[$n]);
				$replacetotalharga = str_replace(',', '', $request->totalharga[$n]);

				$podt->podt_jumlahharga = $replaceharga;
				$podt->podt_statuskirim = strtoupper($request->status[$n]);
				$podt->podt_idspp = strtoupper($request->idspp[$n]);
				$podt->podt_idpo = $po->po_id;
				$podt->podt_totalharga = $replacetotalharga;
				$podt->podt_lokasigudang = strtoupper($request->lokasikirim[$n]);
			//	$podt->podt_tglkirim =
				$podt->save();

					/*	$updatesppdt = sppdt_purchase::where([['sppd_idspp', '=', $id], ['spp_detail.sppd_idsppdetail' , '=' , $request->idsppd[$i]]]);*/

				$updatespptb = spptb_purchase::where([['spptb_idspp', '=', $request->idspp[$n]] , ['spptb_supplier' , '=' , $request->nosupplier]]);

					$updatespptb->update([
					 	'spptb_poid' => $po_id
				 		]);	
/*
					$updatespp = spp_purchase::where('spp_id' , '=' , $request->idspp[$n]);
					$updatespp->update([
							'spp_status' => 'DISETUJUI',
					]);*/
			}
		return redirect('purchaseorder/purchaseorder');	
	}

	public function createpurchase(){
		$data['spp_asli'] = DB::select("select * from confirm_order, spp where co_idspp = spp_id");
		
		$data['spp'] = DB::select("select * from  spp, supplier, cabang, confirm_order, confirm_order_tb where co_idspp = spp_id and co_mng_pem_approved = 'DISETUJUI' and spp_cabang = kode and cotb_idco = co_id and cotb_supplier = idsup  and cotb_setuju = 'BELUM DI SETUJUI'");

		$data['po'] = DB::select("select * from spp, pembelian_orderdt where podt_idspp = spp_id");
		$data['cabang'] = DB::select('select * from cabang');
		$data['gudang'] = masterGudangPurchase::all();
		//dd($data);


		return view('purchase/purchase/create',compact('data'));
	}




	public function purchasedetail($id) {
	/*	$id = ['13','14'];
		dd($id);
	*/	$data['spp'] = DB::select("select * from confirm_order, spp, spp_totalbiaya, supplier, masterdepartment where spp_bagian = kode_department and co_idspp = spp_id and spptb_idspp = spp_id and spptb_supplier = idsup and co_id='$id'");
		$data['po'] = DB::select("select * from spp, pembelian_orderdt where podt_idspp = spp_id");
		$data['countpo'] = count($data['po']);
		$data['codt_tb'] =  DB::select("select * from confirm_order_tb, confirm_order , supplier where cotb_idco = co_id and co_idspp = '$id' and cotb_supplier = idsup");
		$data['codt'] = DB::select("select *  from confirm_order, masteritem, spp, confirm_order_dt LEFT OUTER JOIN stock_gudang on codt_kodeitem = sg_item where confirm_order_dt.codt_idco=co_id and co_idspp = '$id' and co_idspp = spp_id and codt_kodeitem = kode_item");
		$data['codt_supplier'] = DB::select("select distinct codt_supplier, nama_supplier from supplier, confirm_order_dt, spp, confirm_order where codt_supplier = idsup and co_idspp = spp_id and spp_id = '$id' and codt_idco = co_id");
		

		return view('purchase/purchase/detail_purchase', compact('data'));
	}

	public function getcabang(Request $request){
			$comp = $request->val;
			if($comp != '000'){
					$data['spp'] = DB::select("select * from  spp, supplier, cabang, confirm_order, confirm_order_tb where co_idspp = spp_id and co_mng_pem_approved = 'DISETUJUI' and spp_cabang = kode and cotb_idco = co_id and cotb_supplier = idsup  and cotb_setuju = 'BELUM DI SETUJUI' and kode = '$comp'");
			}
			else {
					$data['spp'] = DB::select("select * from  spp, supplier, cabang, confirm_order, confirm_order_tb where co_idspp = spp_id and co_mng_pem_approved = 'DISETUJUI' and spp_cabang = kode and cotb_idco = co_id and cotb_supplier = idsup  and cotb_setuju = 'BELUM DI SETUJUI'");	
			}

			return json_encode($data);
	}

	//warehouse 

	public function penerimaanbarang() {

		$data['gudang'] = DB::select("select * from mastergudang");
		$data['terima'] = DB::select("select * from barang_terima, supplier where bt_supplier = idsup ");

	/*	$data['penerimaan'] = DB::select("select LEFT(po_no, 2) as flag ,po_no as nobukti, po_supplier as supplier, nama_supplier as nmsupplier , po_id as id, string_agg(pb_status,',') as p   from supplier, pembelian_order LEFT OUTER JOIN penerimaan_barang on pb_po = po_id  where po_supplier = idsup and po_tipe != 'J' and po_setujufinance = 'DISETUJUI' group by po_id , po_no, nama_supplier  UNION select LEFT(fp_nofaktur, 2) as flag, fp_nofaktur as nobukti, fp_idsup as supplier , nama_supplier as nmsupplier, fp_idfaktur as id , string_agg(pb_status,',') as p  from supplier, faktur_pembelian LEFT OUTER JOIN penerimaan_barang on fp_idfaktur = pb_fp where fp_tipe != 'J' and fp_tipe != 'PO' and fp_idsup = idsup group by nobukti, supplier , nmsupplier , id order by id desc"); //kurang session login company
		
		$data['status'] = array();
		for($z=0; $z < count($data['penerimaan']); $z++){				
				$temp = 0;
				$status = $data['penerimaan'][$z]->p;
			

			if($status == 'LENGKAP') {
				$status_fix = 'LENGKAP';
			}
			else if($status == 'TIDAK LENGKAP') {
				$status_fix = 'TIDAK LENGKAP';
			}
			else if($status == null){
				$status_fix = 'BELUM DI TERIMA';
			}
			else {
				$status_double = explode("," , $status);
				$temp = 0;

			for($xz=0; $xz < count($status_double); $xz++){								
					//array_push($data['status'] , $status);
				if($status_double[$xz] == 'LENGKAP') {
					$temp = 1;
				}
				
			}

				if($temp > 0 ) {
					$status_fix = 'LENGKAP';
				}
				else {
					$status_fix = 'TIDAK LENGKAP';
				}			
			}
			array_push($data['status'] , $status_fix);
		}
		*/
		

		return view('purchase/penerimaan_barang/index', compact('data'));
	}


	public function cekgudang(Request $request) {
		$idgudang = $request->idgudang;
		$data['terima'] = DB::select("select * from barang_terima, supplier where bt_gudang = '$idgudang' and bt_supplier = idsup");
		return json_encode($data);
	}

	public function savepenerimaan(Request $request){
return DB::transaction(function() use ($request) {   

		$dataItems=[];
		$akun=[];
		$idsppupdate = [];
		$arrayspp = [];

		
		$flag = $request->flag;
		//SAVE PENERIMAAN PO
		$gudang = $request->gudang;
		$cabang2 = DB::select("select * from mastergudang where mg_id ='$gudang'");
		$cabang = $cabang2[0]->mg_cabang;
		if($flag == 'PO'){
			/*dd($request);*/
		$mytime = Carbon::now(); 
		
		//MEMBUAT NOFORMTT	
		$time = Carbon::now();
	//	$newtime = date('Y-M-d H:i:s', $time);  
		
		$year =Carbon::createFromFormat('Y-m-d H:i:s', $time)->year; 
		$month =Carbon::createFromFormat('Y-m-d H:i:s', $time)->month; 

		if($month < 10) {
			$month = '0' . $month;
		}

		$year = substr($year, 2);

		$idpb =   penerimaan_barang::where('pb_comp' , $cabang)->max('pb_lpb');
		
		if(isset($idpb)) {
			$explode = explode("/", $idpb);
			$idpb = $explode[2];

			$string = explode("-", $idpb);
			$idpb = $string[1];
			$string = (int)$idpb + 1;
			$idpb = str_pad($string, 3, '0', STR_PAD_LEFT);
		}

		else {
			$idpb = '001';
		}

		if($request->updatestock == 'IYA') {
			$lpb = 'LPB' . $month . $year . '/' . $cabang . '/S-' .  $idpb;
		}
		else {
			$lpb = 'LPB' . $month . $year . '/' . $cabang . '/NS-' .  $idpb;	
		}
		//case Penerimaan Barang

		//idpb
			$lastidpb =   penerimaan_barang::max('pb_id');
			if(isset($lastidpb)) {
			//	dd('ana');
		
				$idpb = $lastidpb;
				$idpb = (int)$idpb + 1;
			}
			else {
				$idpb = 1;
			}

			//save penerimaan_barang
			$idpo = $request->po_id;
			//$query = DB::select("select * from penerimaan_barang where pb_po ='$idpo'"); 	
				
			$penerimaanbarang = new penerimaan_barang();
			$penerimaanbarang->pb_id = $idpb;
			$penerimaanbarang->pb_comp =  $cabang;
			$penerimaanbarang->pb_date = $request->tgl_dibutuhkan;
			$penerimaanbarang->pb_status = '';
			$penerimaanbarang->pb_po = $request->po_id;
			$penerimaanbarang->pb_updatestock =$request->updatestock;
			$penerimaanbarang->pb_lpb = $lpb;
			$penerimaanbarang->pb_suratjalan = $request->suratjalan;
			$penerimaanbarang->pb_supplier = $request->idsup;
			$penerimaanbarang->pb_gudang = $request->gudang;
			
			$penerimaanbarang->save();

			for($i = 0 ; $i < count($request->qtyterima); $i++ ){
				$penerimaanbarangdt = new penerimaan_barangdt();

		
				if($request->qtyterima[$i] != '') { // TIDAK SAMPLING

					$dataItems[$i]['accpersediaan']=$request->accpersediaan[$i];
					$dataItems[$i]['subtotal']=$request->jumlahharga[$i]*$request->qtyterima[$i];

					$no_po = $request->po_id;


					$idpbpk =   penerimaan_barang::where('pb_po' , $idpo)->max('pb_id');
					$lastidpbdt = penerimaan_barangdt::max('pbdt_id'); 

					if(isset($lastidpbdt)) {
						$idpbdt = $lastidpbdt;
						$idpbdt = (int)$idpbdt + 1;
					}
					else {
						$idpbdt = 1;
					}

					$iditem2 = $request->kodeitem[$i];
					$idspp = $request->idspp[$i];

					/*$selectdikirim = DB::select("select * from pembelian_orderdt where podt_idpo = '$no_po' and podt_kodeitem = '$iditem2' and podt_idspp='$idspp' ");
					$quantitikirim = (int)$selectdikirim[0]->podt_qtykirim;
					dd($quantitikirim);

					if($quantitikirim  == $request->qtyterima[$i]){
						$status = "LENGKAP";
					}
					else {
						$status = "TIDAK LENGKAP";
					}*/

					//melihatqtydisetiapitem
				$select = DB::select("select * from penerimaan_barangdt where pbdt_item = '$iditem2' and pbdt_po = '$no_po' and pbdt_idspp = '$idspp'"); 
				
				//melihatqtydikirimdisetiapitem
				$selectdikirim = DB::select("select * from pembelian_orderdt where podt_idpo = '$no_po' and podt_kodeitem = '$iditem2' and podt_idspp='$idspp' ");
				$quantitikirim = (int)$selectdikirim[0]->podt_qtykirim;
				$qty = $request->qtyterima[$i];
				$qtyditerima = (int)$qty;

				//membuat status
				if($qtyditerima == $quantitikirim) {
					$status = "LENGKAP";
				}
				else {
					$jumlahqty = 0;
					for($k = 0; $k < count($select); $k++){
						$qtyitem = $select[$k]->pbdt_qty;
						$jumlahqty = $jumlahqty + (int)$qtyitem;
					}


					$jumstatus = $jumlahqty + (int)$qty;
					$qtydikirim = $request->qtydikirim[$i];
				//	dd($jumstatus . $qtydikirim);
					if($jumstatus == $qtydikirim){
						$status = "LENGKAP";
					}
					else {
						$status = "TIDAK LENGKAP";
					}
				}


					//total harga
					$totalharga = (int)$request->qtyterima[$i] * (int)$request->jumlaharga[$i];

					$penerimaanbarangdt->pbdt_id = $idpbdt;
					$penerimaanbarangdt->pbdt_idpb = $idpbpk;
					$penerimaanbarangdt->pbdt_date = $mytime;
					$penerimaanbarangdt->pbdt_item = $request->kodeitem[$i];
					$penerimaanbarangdt->pbdt_qty = $request->qtyterima[$i];	
					$penerimaanbarangdt->pbdt_hpp =$request->jumlaharga[$i];
					$penerimaanbarangdt->pbdt_po =$request->po_id;
					$penerimaanbarangdt->pbdt_updatestock =$request->updatestock;
					$penerimaanbarangdt->pbdt_status = $status;
					$penerimaanbarangdt->pbdt_suratjalan = $request->suratjalan;
					$penerimaanbarangdt->pbdt_totalharga = $totalharga;
					$penerimaanbarangdt->pbdt_idspp = $request->idspp[$i];

					$penerimaanbarangdt->save();
				}
				else if($request->qtyterima[$i] == '') { // SAMPLING
				
					if($request->qtysampling[$i] != ''){

					$dataItems[$i]['accpersediaan']=$request->accpersediaan[$i];					
					$dataItems[$i]['subtotal']=$request->jumlahharga[$i]*$request->qtydikirim[$i];	

						
						$idpbpk =   penerimaan_barang::where('pb_po' , $idpo)->max('pb_id');
						$lastidpbdt = penerimaan_barangdt::max('pbdt_id'); 

						if(isset($lastidpbdt)) {
							$idpbdt = $lastidpbdt;
							$idpbdt = (int)$idpbdt + 1;
						}
						else {
							$idpbdt = 1;
						}

						$iditem2 = $request->kodeitem[$i];
						$idspp = $request->idspp[$i];
						$no_po = $request->po_id;
						
						$selectdikirim = DB::select("select * from pembelian_orderdt where podt_idpo = '$no_po' and podt_kodeitem = '$iditem2' and podt_idspp='$idspp' ");
						$quantitikirim = (int)$selectdikirim[0]->podt_qtykirim;

						if($quantitikirim  < $request->qtysampling[$i]){
							$status2 = "SAMPLING";
						}
						else {
							//$status = "TIDAK LENGKAP";
						}

						//total harga
						$totalharga = (int)$request->qtysampling[$i] * (int)$request->hpp[$i];

						$penerimaanbarangdt->pbdt_id = $idpbdt;
						$penerimaanbarangdt->pbdt_idpb = $idpbpk;
						$penerimaanbarangdt->pbdt_date = $mytime;
						$penerimaanbarangdt->pbdt_item = $request->kodeitem[$i];
						$penerimaanbarangdt->pbdt_qty = $request->qtysampling[$i];	
						$penerimaanbarangdt->pbdt_hpp =$request->jumlahharga[$i];
						$penerimaanbarangdt->pbdt_po =$request->po_id;
						$penerimaanbarangdt->pbdt_updatestock =$request->updatestock;
						$penerimaanbarangdt->pbdt_status = $status2;
						$penerimaanbarangdt->pbdt_suratjalan = $request->suratjalan;
						$penerimaanbarangdt->pbdt_totalharga = $totalharga;
						$penerimaanbarangdt->pbdt_idspp = $request->idspp[$i];

						$penerimaanbarangdt->save();
					}
				}
			}

			$no_po = $request->po_id;
			$nomor= $request->ref;   
			
			//update status pb header
			$statusheaderpb = DB::select("select * from penerimaan_barang , penerimaan_barangdt where pb_id = pbdt_idpb and pb_po = '$no_po'");
			//$statusheaderpb[0]->pbdt_status;
			
			/*dd($statusheaderpb[4]->pbdt_status);*/
			$statusheaderpo = DB::select("select * from pembelian_order , pembelian_orderdt where po_id = podt_idpo and po_id = '$no_po'");
			$hitungpo = count($statusheaderpo);
			$hitungpb = count($statusheaderpb);
			
			//ambil status di detail
			$statusbrg = array();
			for($indx = 0 ; $indx < $hitungpb; $indx++){

				$status = $statusheaderpb[$indx]->pbdt_status;
				array_push($statusbrg , $status);
			}

			//memeriksa status lengkap di detail
			$tempsts = 0;
			$tempspling = 0;
			for($sts = 0; $sts < count($statusbrg); $sts++){
				if($statusbrg[$sts] == "LENGKAP"){
					$tempsts = $tempsts + 1;
				}
				else if($statusbrg[$sts] == "SAMPLING") {
					$tempspling = $tempspling + 1;
				}
			}

			if($tempspling == $hitungpo){
				$statuspb = "LENGKAP";
			}
			else {
				$selisih = $hitungpo - $tempsts;
				if($selisih == $tempspling) {
					$statuspb = "LENGKAP";
				}
				else {
					$statuspb = "TIDAK LENGKAP";
				}
			}


			$query3 = penerimaan_barang::where('pb_id' , '=' , $idpbpk);
			$query3->update([
				'pb_status' => $statuspb,
				/*'pb_totaljumlah' => $jmlhrg, */
			]);	

			$query4 = barang_terima::where([['bt_idtransaksi' , '=' , $no_po], ['bt_flag' , '=' , 'PO']]);
			$query4->update([
				'bt_statuspenerimaan' => $statuspb,
			]);

			$spp = DB::select("select * from spp, spp_totalbiaya where spptb_idspp = spp_id and spptb_poid = '$no_po'");

			for($j = 0; $j < count($spp); $j++){
				$id2 = $spp[$j]->spp_id;
				array_push($idsppupdate , $id2);
			}


			if($statuspb == 'TIDAK LENGKAP'){
				for($k = 0; $k < count($idsppupdate); $k++){
					$idspp2 = $idsppupdate[$k];
					$queryspp = spp_purchase::where('spp_id', '=' , $idspp2);
					$queryspp->update([
						'spp_status' => 'MASUK GUDANG'
					]);
				}				
			}
			else {
				for($k = 0; $k < count($idsppupdate); $k++){
					$idspp2 = $idsppupdate[$k];
					$queryspp = spp_purchase::where('spp_id', '=' , $idspp2);
					$queryspp->update([
						'spp_status' => 'SELESAI'
					]);
				}	
			}



		} // END SAVE PO

		//SAVE PENERIMAAN FP
		else {
		/*dd($request);*/
			$mytime = Carbon::now(); 		
			//MEMBUAT NOFORMTT	
				$time = Carbon::now();
		//	$newtime = date('Y-M-d H:i:s', $time);  
			
			$year =Carbon::createFromFormat('Y-m-d H:i:s', $time)->year; 
			$month =Carbon::createFromFormat('Y-m-d H:i:s', $time)->month; 

			if($month < 10) {
				$month = '0' . $month;
			}

			$year = substr($year, 2);

			$idpb =   penerimaan_barang::where('pb_comp' ,  $cabang)->max('pb_lpb');
			
			if(isset($idpb)) {
				$explode = explode("/", $idpb);
				$idpb = $explode[2];
				$string = explode("-", $idpb);
				$idpb = $string[1];
				$string = (int)$idpb + 1;
				$idpb = str_pad($string, 3, '0', STR_PAD_LEFT);
			}

			else {
				$idpb = '001';
			}


			if($request->updatestock == 'IYA') {
				$lpb = 'LPB' . $month . $year . '/' .  $cabang . '/S-' .  $idpb;
			}
			else {
				$lpb = 'LPB' . $month . $year . '/' .  $cabang  . '/NS-' .  $idpb;	
			}

			//case Penerimaan Barang

			//idpb
				$lastidpb =   penerimaan_barang::max('pb_id');
				if(isset($lastidpb)) {
				//	dd('ana');
			
					$idpb = $lastidpb;
					$idpb = (int)$idpb + 1;
				}
				else {
					$idpb = 1;
				}

				//save penerimaan_barang
				$idpo = $request->idfp;
				//$query = DB::select("select * from penerimaan_barang where pb_po ='$idpo'"); 	
					
				$penerimaanbarang = new penerimaan_barang();
				$penerimaanbarang->pb_id = $idpb;
				$penerimaanbarang->pb_comp =  $cabang;
				$penerimaanbarang->pb_date = $request->tgl_dibutuhkan;
				$penerimaanbarang->pb_status = '';
				$penerimaanbarang->pb_fp = $request->idfp;
				$penerimaanbarang->pb_updatestock =$request->updatestock;
				$penerimaanbarang->pb_lpb = $lpb;
				$penerimaanbarang->pb_suratjalan = $request->suratjalan;
				$penerimaanbarang->pb_supplier = $request->idsup;
				$penerimaanbarang->pb_gudang = $request->gudang;
				$penerimaanbarang->save();
				
				for($i = 0 ; $i < count($request->qtyterima); $i++ ){
					$penerimaanbarangdt = new penerimaan_barangdt();
			
					if($request->qtyterima[$i] != '') {
						$idfp = $request->idfp;

						$idpbpk =   penerimaan_barang::where('pb_fp' , $idfp)->max('pb_id');
						$lastidpbdt = penerimaan_barangdt::max('pbdt_id'); 

						if(isset($lastidpbdt)) {
							$idpbdt = $lastidpbdt;
							$idpbdt = (int)$idpbdt + 1;
						}
						else {
							$idpbdt = 1;
						}

						$iditem2 = $request->kodeitem[$i];
						$idspp = $request->idspp[$i];

					

						//melihatqtydisetiapitem
					$select = DB::select("select * from penerimaan_barangdt where pbdt_item = '$iditem2' and pbdt_idfp = '$idfp'"); 
					
					//melihatqtydikirimdisetiapitem
					$selectdikirim = DB::select("select * from faktur_pembeliandt where fpdt_idfp = '$idfp' and fpdt_kodeitem = '$iditem2'");

					$quantitikirim = (int)$selectdikirim[0]->fpdt_qty;
					$qty = $request->qtyterima[$i];
					$qtyditerima = (int)$qty;

					//membuat status
					if($qtyditerima == $quantitikirim) {
						$status = "LENGKAP";
					}
					else {
						$jumlahqty = 0;
						for($k = 0; $k < count($select); $k++){
							$qtyitem = $select[$k]->pbdt_qty;
							$jumlahqty = $jumlahqty + (int)$qtyitem;
						}

						//dd($qty);
						$jumstatus = $jumlahqty + (int)$qty;
						$qtydikirim = $request->qtydikirim[$i];
						
					

						if($jumstatus == $qtydikirim){
							$status = "LENGKAP";
						}
						else {
							$status = "TIDAK LENGKAP";
						}
					}


						//total harga
						$totalharga = (int)$request->qtyterima[$i] * (int)$request->jumlaharga[$i];

						$penerimaanbarangdt->pbdt_id = $idpbdt;
						$penerimaanbarangdt->pbdt_idpb = $idpbpk;
						$penerimaanbarangdt->pbdt_date = $mytime;
						$penerimaanbarangdt->pbdt_item = $request->kodeitem[$i];
						$penerimaanbarangdt->pbdt_qty = $request->qtyterima[$i];	
						$penerimaanbarangdt->pbdt_hpp =$request->jumlaharga[$i];
						$penerimaanbarangdt->pbdt_idfp =$request->idfp;
						$penerimaanbarangdt->pbdt_updatestock =$request->updatestock;
						$penerimaanbarangdt->pbdt_status = $status;
						$penerimaanbarangdt->pbdt_suratjalan = $request->suratjalan;
						$penerimaanbarangdt->pbdt_totalharga = $totalharga;;
						$penerimaanbarangdt->pbdt_idspp = $request->idspp[$i];
						$penerimaanbarangdt->save();
					}
					else if($request->qtyterima[$i] == '') {
					
						if($request->qtysampling[$i] != ''){
							$idfp = $request->idfp;
							$idpbpk =   penerimaan_barang::where('pb_fp' , $idfp)->max('pb_id');
							$lastidpbdt = penerimaan_barangdt::max('pbdt_id'); 

							if(isset($lastidpbdt)) {
								$idpbdt = $lastidpbdt;
								$idpbdt = (int)$idpbdt + 1;
							}
							else {
								$idpbdt = 1;
							}

							$iditem2 = $request->kodeitem[$i];
							
							$idfp = $request->idfp;
							
							$selectdikirim = DB::select("select * from faktur_pembeliandt where fpdt_idfp = '$idfp' and fpdt_kodeitem = '$iditem2'");
							$quantitikirim = (int)$selectdikirim[0]->fpdt_qty;
							
							
							if($quantitikirim  < $request->qtysampling[$i]){
								$status2 = "SAMPLING";
							}
							else {
								//$status = "TIDAK LENGKAP";
							}

							//total harga
							$totalharga = (int)$request->qtysampling[$i] * (int)$request->jumlaharga[$i];

							$penerimaanbarangdt->pbdt_id = $idpbdt;
							$penerimaanbarangdt->pbdt_idpb = $idpbpk;
							$penerimaanbarangdt->pbdt_date = $mytime;
							$penerimaanbarangdt->pbdt_item = $request->kodeitem[$i];
							$penerimaanbarangdt->pbdt_qty = $request->qtysampling[$i];	
							$penerimaanbarangdt->pbdt_hpp =$request->jumlahharga[$i];
							$penerimaanbarangdt->pbdt_idfp =$request->idfp;
							$penerimaanbarangdt->pbdt_updatestock =$request->updatestock;
							$penerimaanbarangdt->pbdt_status = $status2;
							$penerimaanbarangdt->pbdt_suratjalan = $request->suratjalan;
							$penerimaanbarangdt->pbdt_totalharga = $totalharga;
						
							$penerimaanbarangdt->save();
						}
					}
				}


			//	dd($totalharga);
				$idfp = $request->idfp;

				
				//update status pb header
				$statusheaderpb = DB::select("select * from penerimaan_barang , penerimaan_barangdt where pb_id = pbdt_idpb and pb_fp = '$idfp'");
				//$statusheaderpb[0]->pbdt_status;
				
				/*dd($statusheaderpb[4]->pbdt_status);*/
				$statusheaderpo = DB::select("select * from faktur_pembelian , faktur_pembeliandt where fpdt_idfp = fp_idfaktur and fp_idfaktur = '$idfp'");
				$hitungpo = count($statusheaderpo);
				$hitungpb = count($statusheaderpb);
				
				//ambil status di detail
				$statusbrg = array();
				for($indx = 0 ; $indx < $hitungpb; $indx++){

					$status = $statusheaderpb[$indx]->pbdt_status;
					array_push($statusbrg , $status);
				}

				//memeriksa status lengkap di detail
				$tempsts = 0;
				$tempspling = 0;
				for($sts = 0; $sts < count($statusbrg); $sts++){
					if($statusbrg[$sts] == "LENGKAP"){
						$tempsts = $tempsts + 1;
					}
					else if($statusbrg[$sts] == "SAMPLING") {
						$tempspling = $tempspling + 1;
					}
				}

				if($tempspling == $hitungpo){
					$statuspb = "LENGKAP";
				}
				else {
					$selisih = $hitungpo - $tempsts;
					if($selisih == $tempspling) {
						$statuspb = "LENGKAP";
					}
					else {
						$statuspb = "TIDAK LENGKAP";
					}
				}


				$query3 = penerimaan_barang::where('pb_id' , '=' , $idpbpk);
				$query3->update([
					'pb_status' => $statuspb,
					/*'pb_totaljumlah' => $jmlhrg, */
				]);	
		
		
		
		}
		



		//MASUK STOCK
	if($request->updatestock == 'IYA') {
		for($i = 0 ; $i < count($request->qtyterima); $i++ ){
			if(empty($request->qtyterima[$i])) {

			}
			else {
			$iditem = $request->kodeitem[$i];
			/*dd($iditem);*/
			$masteritem = DB::select("select * from masteritem where kode_item ='$iditem'");
			$minstock = $masteritem[0]->minstock;		

			$stockgudang = new stock_gudang();
			$lastid = stock_gudang::max('sg_id'); 


			if(isset($lastid)) {
				$idgudang = $lastid;
				$idgudang = (int)$lastid + 1;
			}
			else {
				$idgudang = 1;
			}

			$gudang = $request->gudang;
			$comp =  $cabang;
			$datagudang = DB::select("select * from stock_gudang where sg_item = '$iditem' and sg_gudang = '$gudang' and sg_cabang = '$comp'");
	//		dd($idgudang);
			
			if(empty($datagudang)){
				$stockgudang->sg_id = $idgudang;
				
				$stockgudang->sg_item = $iditem;
				$stockgudang->sg_qty = $request->qtyterima[$i];
				$stockgudang->sg_minstock = $minstock;
				$stockgudang->sg_cabang =  $cabang;
				$stockgudang->sg_gudang = $request->gudang;
				$stockgudang->save();
			}
			else {
				$qtystock = $datagudang[0]->sg_qty;
				$qtyterima = $request->qtyterima[$i];
				$tambahstock = (int)$qtystock + (int)$qtyterima;

				$updategudang = stock_gudang::where('sg_item' , '=' , $iditem);

				$updategudang->update([
				 	'sg_qty' => $tambahstock,
			 	]);	
			}

		

			if($flag == 'PO'){
				$stock_mutation = new stock_mutation();
				$lastidsm = stock_mutation::max('sm_id'); 
				

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
				$stock_mutation->sm_mutcat = '1';
				$stock_mutation->sm_qty = $request->qtyterima[$i];
				$stock_mutation->sm_use = '0';
				$stock_mutation->sm_hpp = $request->jumlahharga[$i];
				$stock_mutation->sm_lpb =  $lpb ;
				$stock_mutation->sm_suratjalan = $request->suratjalan ;
				$stock_mutation->sm_po = $request->po_id ;
				$stock_mutation->sm_id_gudang = $request->gudang;
				$stock_mutation->sm_sisa = $request->qtyterima[$i];
				$stock_mutation->sm_flag = 'PO';
				$stock_mutation->save();
			}
			else {
				$stock_mutation = new stock_mutation();
				$lastidsm = stock_mutation::max('sm_id'); 
				

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
				$stock_mutation->sm_mutcat = '1';
				$stock_mutation->sm_qty = $request->qtyterima[$i];
				$stock_mutation->sm_use = '0';
				$stock_mutation->sm_hpp = $request->jumlahharga[$i];
				$stock_mutation->sm_lpb =  $lpb ;
				$stock_mutation->sm_suratjalan = $request->suratjalan ;
				$stock_mutation->sm_po = $request->idfp ;
				$stock_mutation->sm_id_gudang = $request->gudang;
				$stock_mutation->sm_sisa = $request->qtyterima[$i];
				$stock_mutation->sm_flag = 'FP';
				$stock_mutation->save();
			}
		
		}
		}


$Nilaijurnal=[];			
	$totalHutang=0;
	//dd($dataItems);
	//dd($request->all());
//comp =hudang;
//comp=po_po;
	if(count($dataItems)!=0){
$Nilaijurnal=$this->groupJurnal($dataItems);

//dd($Nilaijurnal);
$indexakun=0;
	foreach ($Nilaijurnal as  $dataJurnal) {
		  $akunPersediaan=master_akun::
	                  select('id_akun','nama_akun')
	                  ->where('id_akun','like', ''.$dataJurnal['accpersediaan'].'%')                                    
	                  ->where('kode_cabang',$cabang)
	                  ->orderBy('id_akun')
	                  ->first();

	        if(count($akunPersediaan)!=0){
	        $akun[$indexakun]['id_akun']=$akunPersediaan->id_akun;
	        $akun[$indexakun]['value']=$dataJurnal['subtotal'];
	        $akun[$indexakun]['dk']='D';
	    	$indexakun++;
	    	}
	    	else{
	    	    $dataInfo=['status'=>'gagal','info'=>'Akun Persediaan Untuk Cabang Belum Tersedia, Kode Parent '.$dataJurnal['accpersediaan']];
	    	    DB::rollback();
	            return json_encode($dataInfo);
	    	}    	
	    	
	    	$totalHutang=$totalHutang+$dataJurnal['subtotal'];
	}            

               $akunHutang=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', ''.$request->acchutangsupplierpo.'%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first();  

                  if(count($akunHutang)==0){
                        $dataInfo=['status'=>'gagal','info'=>'Akun HUtang Untuk Cabang Belum Tersedia'];
                        DB::rollback();
                        return json_encode($dataInfo);
                    }

                $akun[$indexakun]['id_akun']=$akunHutang->id_akun;
                $akun[$indexakun]['value']=$totalHutang;
                $akun[$indexakun]['dk']='K';



		        //$nomor= $request->po_id;                              
                $id_jurnal=d_jurnal::max('jr_id')+1;
                    foreach ($akun as $key => $detailData) {                            
                            $id_jrdt=$key;
                            $jurnal_dt[$key]['jrdt_jurnal']=$id_jurnal;
                            $jurnal_dt[$key]['jrdt_detailid']=$id_jrdt+1;
                            $jurnal_dt[$key]['jrdt_acc']=$detailData['id_akun'];
                            $jurnal_dt[$key]['jrdt_value']=$detailData['value'];
                            $jurnal_dt[$key]['jrdt_statusdk']=$detailData['dk'];
                        }

                    d_jurnal::create([
                           'jr_id'=>$id_jurnal,
                           'jr_year'=> date('Y'),
                           'jr_date'=> date('Y-m-d'),
                           'jr_detail'=> 'PENERIMAAN BARANG'.' '.$request->type_kiriman,
                           'jr_ref'=> $nomor,
                           'jr_note'=> 'PENERIMAAN BARANG',
                            ]);
                    d_jurnal_dt::insert($jurnal_dt);

		}


		}
	$dataInfo=['status'=>'sukses'];        
        return json_encode($dataInfo);

	});
		
	}

	public function updatepenerimaanbarang(Request  $request) {
		$qty = $request->qty;
		$idpb = $request->idpb;
		$idpbdt = $request->idpbdt;
		$status = $request->status;
		$kodeitem = $request->kodeitem;
		$suratjalan = $request->suratjalan;
		$iddetail = $request->iddetail;

		$updatepenerimaanheader = penerimaan_barang::find($idpb);
		$updatepenerimaanheader->pb_suratjalan = $suratjalan;
		$updatepenerimaanheader->save();

		for($i = 0 ; $i < count($request->arrqty); $i++){
			$updatedetail = penerimaan_barangdt::where([['pbdt_idpb', '=', $idpb], ['pbdt_id' , '=' , $request->arridpbdt[$i]], ['pbdt_item' , '=' , $request->arrkodeitem[$i]]]);

			$harga = str_replace(',', '', $request->arrharga[$i]);

			$updatedetail->update([
				 	'pbdt_qty' => $request->arrqty[$i],
				 	'pbdt_status' => $request->arrstatus[$i],
				 	'pbdt_totalharga' => $harga,				 	
			 	]);	
		}

		$flag = $request->flag;
		//update di header
		//update status pb header
		if($flag == 'FP'){
			$statusheaderpb = DB::select("select * from penerimaan_barang , penerimaan_barangdt where pb_id = pbdt_idpb and pb_fp = '$iddetail'");

			//$statusheaderpb[0]->pbdt_status;
			
			/*dd($statusheaderpb[4]->pbdt_status);*/
			$statusheaderpo = DB::select("select * from faktur_pembelian , faktur_pembeliandt where fpdt_idfp = fp_idfaktur and fp_idfaktur = '$iddetail'");
			$hitungpo = count($statusheaderpo);
			$hitungpb = count($statusheaderpb);
			
			//ambil status di detail
			$statusbrg = array();
			for($indx = 0 ; $indx < $hitungpb; $indx++){

				$status = $statusheaderpb[$indx]->pbdt_status;
				array_push($statusbrg , $status);
			}

			//memeriksa status lengkap di detail
			$tempsts = 0;
			$tempspling = 0;
			for($sts = 0; $sts < count($statusbrg); $sts++){
				if($statusbrg[$sts] == "LENGKAP"){
					$tempsts = $tempsts + 1;
				}
				else if($statusbrg[$sts] == "SAMPLING") {
					$tempspling = $tempspling + 1;
				}
			}

			if($tempspling == $hitungpo){
				$statuspb = "LENGKAP";
			}
			else {
				$selisih = $hitungpo - $tempsts;
				if($selisih == $tempspling) {
					$statuspb = "LENGKAP";
				}
				else {
					$statuspb = "TIDAK LENGKAP";
				}
			}


			$query3 = penerimaan_barang::where('pb_id' , '=' , $idpb);
			$query3->update([
				'pb_status' => $statuspb,
				/*'pb_totaljumlah' => $jmlhrg, */
			]);	
		}
		

		return json_encode('sukses');
	}

	public function detailterimabarang($id) {

		$data['cabang'] = DB::select("select * from cabang");
		
		$data['header'] = DB::select("select * from barang_terima , supplier where bt_id = '$id' and bt_supplier = idsup");

		$idgudang = $data['header'][0]->bt_gudang;

		$carigudang = DB::select("select * from mastergudang where mg_id = '$idgudang'");

		$data['comp'] = $carigudang[0]->mg_cabang;

		$idtransaksi = $data['header'][0]->bt_idtransaksi;

		$flag = $data['header'][0]->bt_flag;

		//PO


		$data['status'] = [];
		if($flag == 'PO'){
		$data['po'] = DB::select("select distinct spp_id, acc_hutang, po_ppn,po_diskon, spp_cabang, podt_idspp , po_id, spp_nospp, po_no, spp_lokasigudang, nama_supplier , idsup  from pembelian_order, pembelian_orderdt, spp, supplier where po_id = '$idtransaksi' and podt_idpo = po_id and podt_idspp = spp_id and po_supplier = idsup");

			for($j = 0; $j < count($data['po']); $j++){
				$idspp = $data['po'][$j]->spp_id; 
				$data['podtbarang'][] = DB::select("select * from masteritem, supplier, pembelian_order , spp, pembelian_orderdt where podt_idpo = po_id and podt_idspp = spp_id and po_supplier = idsup and podt_idpo = '$idtransaksi' and podt_kodeitem = kode_item  and spp_id = '$idspp' and podt_lokasigudang='$idgudang'");

			//	dd(count($data['podtbarang'][$j]));
				for($p = 0; $p < count($data['podtbarang'][$j]); $p++){
					$kodeitem = $data['podtbarang'][$j][$p]->podt_kodeitem;
					$data['sisa'][] = DB::select("select  podt_kodeitem, podt_qtykirim, podt_idspp,  sum(pbdt_qty), string_agg(pbdt_status,',') as p from pembelian_orderdt LEFT OUTER JOIN  penerimaan_barangdt on podt_kodeitem = pbdt_item and podt_idspp = pbdt_idspp where podt_idpo = '$idtransaksi' and podt_kodeitem = '$kodeitem' and podt_idspp = '$idspp' group by podt_kodeitem,podt_qtykirim, podt_idspp");
				}
				
			}
			$data['flag'] = "PO";

			for($z=0; $z < count($data['sisa']); $z++){				
				$temp = 0;
				$status = $data['sisa'][$z][0]->p;
			

			if($status == 'LENGKAP') {
				$status_fix = 'LENGKAP';
			}
			else if($status == 'TIDAK LENGKAP') {
				$status_fix = 'TIDAK LENGKAP';
			}
			else if($status == 'SAMPLING'){
				$status_fix = 'LENGKAP';
			}
			else {
				$status_double = explode("," , $status);
				$temp = 0;

			for($xz=0; $xz < count($status_double); $xz++){								
					//array_push($data['status'] , $status);
				if($status_double[$xz] == 'LENGKAP') {
					$temp = 1;
				}
				
			}

				if($temp > 0 ) {
					$status_fix = 'LENGKAP';
				}
				else {
					$status_fix = 'TIDAK LENGKAP';
				}			
			}
			array_push($data['status'] , $status_fix);
			}
		} //END IF
		else if($flag == 'FP'){
			$data['flag'] = 'FP';

			$data['fp'] = DB::select("select * from faktur_pembelian, supplier where fp_idsup = idsup and fp_idfaktur = '$id' ");

			$data['fpdt'] = DB::select("select * from faktur_pembelian, faktur_pembeliandt, masteritem where fpdt_kodeitem = kode_item and fpdt_idfp = fp_idfaktur and fp_idfaktur = '$id'");

			for($z = 0; $z < count($data['fpdt']); $z++){
				$kodeitem = $data['fpdt'][$z]->fpdt_kodeitem;
				$data['sisa'][] = DB::select("select  fpdt_id, fpdt_kodeitem, fpdt_qty, fpdt_idfp, sum(pbdt_qty), nama_masteritem, string_agg(pbdt_status,',') as p from masteritem, faktur_pembeliandt LEFT OUTER JOIN penerimaan_barangdt on fpdt_kodeitem = pbdt_item and fpdt_idfp = pbdt_idfp where fpdt_idfp = '$id' and fpdt_kodeitem = '$kodeitem' and fpdt_kodeitem = kode_item group by nama_masteritem, fpdt_kodeitem , fpdt_qty, fpdt_idfp, fpdt_id");
 			}

 			for($z=0; $z < count($data['sisa']); $z++){				
				$temp = 0;
				$status = $data['sisa'][$z][0]->p;
			

			if($status == 'LENGKAP') {
				$status_fix = 'LENGKAP';
			}
			else if($status == 'TIDAK LENGKAP') {
				$status_fix = 'TIDAK LENGKAP';
			}
			else if($status == null){
				$status_fix = 'BELUM DI TERIMA';
			}
			else {
				$status_double = explode("," , $status);
				$temp = 0;

			for($xz=0; $xz < count($status_double); $xz++){								
					//array_push($data['status'] , $status);
				if($status_double[$xz] == 'LENGKAP') {
					$temp = 1;
				}
				
			}

				if($temp > 0 ) {
					$status_fix = 'LENGKAP';
				}
				else {
					$status_fix = 'TIDAK LENGKAP';
				}			
			}
			array_push($data['status'] , $status_fix);			
		}
		}
		$jurnal_dt=collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk
                        FROM d_akun a join d_jurnal_dt jd
                        on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
                        (select j.jr_id from d_jurnal j where jr_ref='$id')")); 
		
		
		return view('purchase/penerimaan_barang/detail_copy', compact('data','jurnal_dt'));
			
	}


	public function laporanpenerimaan($id) {
		
		$data['penerimaan'] = DB::select("select *  from penerimaan_barang , pembelian_order where  pb_po = '$id' and pb_po = po_id");
		$data['barang'][] = DB::select("select * from penerimaan_barangdt , pembelian_orderdt, masteritem where pbdt_po = podt_idpo and pbdt_po = '$id' and podt_kodeitem = pbdt_item and podt_kodeitem = kode_item and pbdt_item = kode_item");
		
	//	$pdf = PDF::loadView('purchase/penerimaan_barang/laporan_penerimaan' , $data , true)->setPaper('a4', 'potrait');

			/*dd($data);*/
		return view('purchase/penerimaan_barang/laporan_penerimaan', compact('data'));
    //	return $pdf->stream();
	}


	public function changeqtyterima(Request $request){
		$iditem = $request->kodeitem;
		$idpo = $request->po_id;
		$idspp = $request->idspp;
		$flag = $request->flag;
		$idfp = $request->idfp;
		
		if($flag == 'PO'){
			$data['pbdt'] = DB::select("select * from penerimaan_barangdt where pbdt_item = '$iditem' and pbdt_po = '$idpo' and pbdt_idspp = '$idspp'");
		}
		else {
			$data['pbdt'] = DB::select("select * from penerimaan_barangdt where pbdt_item = '$iditem' and pbdt_idfp = '$idfp'");	
		}


		return json_encode($data);

	}

	public function ajaxpenerimaan(Request $request){

		$flag = $request->flag;

		if($flag == 'PO'){
			$iditem = $request->kodeitem;
			$idpo = $request->po_id;	
			
			$data['judul'] = DB::select("select *  from penerimaan_barang  where  pb_po = '$idpo'");
			for($i = 0 ; $i < count($data['judul']); $i++){
				$idlpb = $data['judul'][$i]->pb_lpb;
				$idpb = $data['judul'][$i]->pb_id;

				$data['barang'][] = DB::select("select * from penerimaan_barangdt , pembelian_orderdt, masteritem, spp where pbdt_po = podt_idpo and pbdt_po = '$idpo'  and podt_kodeitem = pbdt_item and podt_kodeitem = kode_item and pbdt_item = kode_item and pbdt_idspp = podt_idspp and pbdt_idpb ='$idpb' and pbdt_idspp = spp_id");
			}
		}
		else if($flag == 'FP') {
			$iditem = $request->kodeitem;
			$idfp = $request->idfp;

			$data['judul'] = DB::select("select * from penerimaan_barang where pb_fp = '$idfp'");
			for($c=0; $c < count($data['judul']); $c++){
				$idlpb = $data['judul'][$c]->pb_lpb;
				$idpb = $data['judul'][$c]->pb_id;

				$data['barang'][] = DB::select("select * from penerimaan_barangdt , faktur_pembelian, faktur_pembeliandt, masteritem where fpdt_idfp = pbdt_idfp and pbdt_idfp = '$idfp'  and fpdt_kodeitem = pbdt_item and fpdt_kodeitem = kode_item and pbdt_item = kode_item  and pbdt_idfp ='$idfp' and fpdt_idfp = fp_idfaktur and fp_idfaktur = '$idfp' and pbdt_idpb ='$idpb'  ");
			}
		}
			
		
		return json_encode($data);
		
	

	}

	private function getCollection($id, $col)
	{
		$data = penerimaan_barang::with("many")->where($col, $id)->get();
		$objectToarray = (array) $data;

		return $objectToarray;
	}

	private function receiveItem($id, $col, $flag)
	{
		$collection = $this->getCollection($id, $col);
		$key = "pbdt_data";
		$temp = [];
		if ($flag === "FP") {
			for($i = 0; $i < count($collection["\x00*\x00items"]); $i++) {
				$detail[$i] = $collection["\x00*\x00items"][$i];

				for($j = 0; $j < count($detail[$i]["many"]); $j++) {
					$M_faktur_pembelian = DB::table("faktur_pembelian")
									   ->select("fp_nofaktur")
									   ->where("fp_idfaktur", $detail[$i]->pb_fp)
									   ->get();

					$M_master_item = DB::table("masteritem")
										->select("nama_masteritem", "unitstock")
										->where("kode_item", $detail[$i]["many"][$j]["pbdt_item"])
										->get();
					
					$temp[$key.($i + 1)][$j]["nomor_PO"] = $M_faktur_pembelian[0]->fp_nofaktur;
					$temp[$key.($i + 1)][$j]["nomor_LPB"] = $detail[$i]->pb_lpb;
					$temp[$key.($i + 1)][$j]["nomor_SJ"] = $detail[$i]->pb_suratjalan;
					$temp[$key.($i + 1)][$j]["date"] = $detail[$i]->pb_date;
					$temp[$key.($i + 1)][$j]["dari"] = "Undefined";
					$temp[$key.($i + 1)][$j]["status"] = $detail[$i]->pb_status;
					$temp[$key.($i + 1)][$j]["barang"] = $M_master_item[0]->nama_masteritem;
					$temp[$key.($i + 1)][$j]["unitstock"] = $M_master_item[0]->unitstock;
					$temp[$key.($i + 1)][$j]["quantity"] = $detail[$i]["many"][$j]["pbdt_qty"];
					$temp[$key.($i + 1)][$j]["hargaSatuan"] = $detail[$i]["many"][$j]["pbdt_hpp"];
					$temp[$key.($i + 1)][$j]["hargaTotal"] = $detail[$i]["many"][$j]["pbdt_totalharga"];
				}
			}
		} else {
			for($i = 0; $i < count($collection["\x00*\x00items"]); $i++) {
				$detail[$i] = $collection["\x00*\x00items"][$i];

				for($j = 0; $j < count($detail[$i]["many"]); $j++) {
					$M_pembelian_order = DB::table("pembelian_order")
									   ->select("po_no")
									   ->where("po_id", $detail[$i]->pb_po)
									   ->get();

					$M_master_item = DB::table("masteritem")
										->select("nama_masteritem", "unitstock")
										->where("kode_item", $detail[$i]["many"][$j]["pbdt_item"])
										->get();
					
					$temp[$key.($i + 1)][$j]["nomor_PO"] = $M_pembelian_order[0]->po_no;
					$temp[$key.($i + 1)][$j]["nomor_LPB"] = $detail[$i]->pb_lpb;
					$temp[$key.($i + 1)][$j]["nomor_SJ"] = $detail[$i]->pb_suratjalan;
					$temp[$key.($i + 1)][$j]["date"] = $detail[$i]->pb_date;
					$temp[$key.($i + 1)][$j]["dari"] = "Undefined";
					$temp[$key.($i + 1)][$j]["status"] = $detail[$i]->pb_status;
					$temp[$key.($i + 1)][$j]["barang"] = $M_master_item[0]->nama_masteritem;
					$temp[$key.($i + 1)][$j]["unitstock"] = $M_master_item[0]->unitstock;
					$temp[$key.($i + 1)][$j]["quantity"] = $detail[$i]["many"][$j]["pbdt_qty"];
					$temp[$key.($i + 1)][$j]["hargaSatuan"] = $detail[$i]["many"][$j]["pbdt_hpp"];
					$temp[$key.($i + 1)][$j]["hargaTotal"] = $detail[$i]["many"][$j]["pbdt_totalharga"];
				}
			}
		}
		
		return $temp;
	}


	public function createPdfTerimaBarang($id, $index, $flag)
	{	
		$_USE_MODEL = "";
		$key = "pbdt_data";
		$PBoutput = [];

		if ($flag === "FP") {
			$_USE_MODEL = $this->receiveItem($id, "pb_fp", $flag);
			for($i = 0; $i < count($_USE_MODEL); $i++) {
				for($j = 0; $j < count($_USE_MODEL[$key.($i + 1)]); $j++) {
					$PBoutput[$key.($i + 1)]["nomor_PO"] = $_USE_MODEL[$key.($i + 1)][$j]["nomor_PO"];
					$PBoutput[$key.($i + 1)]["nomor_LPB"] = $_USE_MODEL[$key.($i + 1)][$j]["nomor_LPB"];
					$PBoutput[$key.($i + 1)]["nomor_SJ"] = $_USE_MODEL[$key.($i + 1)][$j]["nomor_SJ"];
					$PBoutput[$key.($i + 1)]["date"] = $_USE_MODEL[$key.($i + 1)][$j]["date"];
					$PBoutput[$key.($i + 1)]["dari"] = $_USE_MODEL[$key.($i + 1)][$j]["dari"];
					$PBoutput[$key.($i + 1)]["status"] = $_USE_MODEL[$key.($i + 1)][$j]["status"];
					$PBoutput[$key.($i + 1)]["barang"][] = $_USE_MODEL[$key.($i + 1)][$j]["barang"];
					$PBoutput[$key.($i + 1)]["unitstock"][] = $_USE_MODEL[$key.($i + 1)][$j]["unitstock"];
					$PBoutput[$key.($i + 1)]["quantity"][] = $_USE_MODEL[$key.($i + 1)][$j]["quantity"];
					$PBoutput[$key.($i + 1)]["hargaSatuan"][] = $_USE_MODEL[$key.($i + 1)][$j]["hargaSatuan"];
					$PBoutput[$key.($i + 1)]["hargaTotal"][] = $_USE_MODEL[$key.($i + 1)][$j]["hargaTotal"];
				}
			}
		} else if ($flag === "PO"){
			$_USE_MODEL = $this->receiveItem($id, "pb_po", $flag);
			for($i = 0; $i < count($_USE_MODEL); $i++) {
				for($j = 0; $j < count($_USE_MODEL[$key.($i + 1)]); $j++) {
					$PBoutput[$key.($i + 1)]["nomor_PO"] = $_USE_MODEL[$key.($i + 1)][$j]["nomor_PO"];
					$PBoutput[$key.($i + 1)]["nomor_LPB"] = $_USE_MODEL[$key.($i + 1)][$j]["nomor_LPB"];
					$PBoutput[$key.($i + 1)]["nomor_SJ"] = $_USE_MODEL[$key.($i + 1)][$j]["nomor_SJ"];
					$PBoutput[$key.($i + 1)]["date"] = $_USE_MODEL[$key.($i + 1)][$j]["date"];
					$PBoutput[$key.($i + 1)]["dari"] = $_USE_MODEL[$key.($i + 1)][$j]["dari"];
					$PBoutput[$key.($i + 1)]["status"] = $_USE_MODEL[$key.($i + 1)][$j]["status"];
					$PBoutput[$key.($i + 1)]["barang"][] = $_USE_MODEL[$key.($i + 1)][$j]["barang"];
					$PBoutput[$key.($i + 1)]["unitstock"][] = $_USE_MODEL[$key.($i + 1)][$j]["unitstock"];
					$PBoutput[$key.($i + 1)]["quantity"][] = $_USE_MODEL[$key.($i + 1)][$j]["quantity"];
					$PBoutput[$key.($i + 1)]["hargaSatuan"][] = $_USE_MODEL[$key.($i + 1)][$j]["hargaSatuan"];
					$PBoutput[$key.($i + 1)]["hargaTotal"][] = $_USE_MODEL[$key.($i + 1)][$j]["hargaTotal"];
				}
			}
		} else {
			echo "<h1 class='text-center'>Cannot Found the Flag!</h1>";
		}
	
		return view('purchase.penerimaan_barang.createPDF', [
			"data" => $PBoutput["pbdt_data".$index]
		]);
	}

	
	public function pengeluaranbarang() {
		return view('purchase/pengeluaran_barang/index');
	}


	public function createpengeluaranbarang() {
		return view('purchase/pengeluaran_barang/create');
	}

	public function detailpengeluaranbarang() {
		return view('purchase/pengeluaran_barang/detail');
	}

	public function konfirmpengeluaranbarang() {
		return view('purchase/konfirmasi_pengeluaranbarang/index');
	}
	

	public function detailkonfirmpengeluaranbarang() {
		return view('purchase/konfirmasi_pengeluaranbarang/detail');
	}

	public function stockopname() {
		return view('purchase/stock_opname/index');
	}

	public function createstockopname() {
		return view('purchase/stock_opname/create');
	}


	public function detailstockopname() {
		return view('purchase/stock_opname/detail');
	}

	public function bastockopname() {
		 return view('purchase/stockopname/beritaacara');
	}


	public function stockgudang() {
		$data['cabang'] = master_cabang::all();
		$data['stock'] = DB::select("select * from stock_gudang, masteritem where sg_item = kode_item");
		 return view('purchase/stockgudang/index', compact('data'));
	}



	public function fatkurpembelian() {

		// return 'asd';
		$data['faktur'] = DB::select("SELECT * from faktur_pembelian 
									  inner join jenisbayar on idjenisbayar= fp_jenisbayar order by fp_tgl desc");
						
		// return 'asd';
		return view('purchase/fatkur_pembelian/index', compact('data'));
	}


	public function cetakfaktur ($id){
		//return $id;

		$data['judul'] = DB::select("select * from faktur_pembelian, supplier where fp_idfaktur = '$id' and fp_idsup = idsup");
		$data['barang'] = DB::select("select * from faktur_pembelian , faktur_pembeliandt, masteritem where fpdt_idfp = fp_idfaktur and fp_idfaktur = '$id' and fpdt_kodeitem = kode_item");
	//	dd($data);
		return view('purchase/fatkur_pembelian/faktur_pembelian' , compact('data'));
	}

	public function updatestockbarang(Request $request){
		$idsup = $request->idsup;
		$updatestock = $request->updatestock;
		$groupitem = $request->groupitem;
		$stock = $request->stock;
		
		$barang= DB::select("select * from itemsupplier, masteritem where is_idsup = '$idsup' and is_updatestock = '$updatestock' and is_kodeitem = kode_item and is_jenisitem = '$groupitem'");
		//return json_encode($barang);

		if(count($barang) > 0) {
			$data['barang'] = $barang;
			$data['status'] = 'Terikat Kontrak';
			
		}
		else {
			if($stock == 'Y'){
				$data['barang']= DB::select("select * from masteritem where updatestock = '$updatestock' and jenisitem = '$groupitem'");
				$data['status'] = 'Tidak Terikat Kontrak';
			}
			else {
				$data['barang']= DB::select("select * from masteritem where jenisitem = '$groupitem'");
				$data['status'] = 'Tidak Terikat Kontrak';	
			}

		}

			$data['supplier'] = DB::select("select * from supplier where idsup = '$idsup'");
		return json_encode($data);
	}

	public function createfatkurpembelian() {		
	
		$time = Carbon::now();
	//	$newtime = date('Y-M-d H:i:s', $time);  
		
		$year =Carbon::createFromFormat('Y-m-d H:i:s', $time)->year; 
		$month =Carbon::createFromFormat('Y-m-d H:i:s', $time)->month; 

		if($month < 10) {
			$month = '0' . $month;
		}

		$year = substr($year, 2);

		$idfaktur =  fakturpembelian::where('fp_comp' , 'C001')->max('fp_idfaktur');
		
		//dd($idfaktur);

		if(isset($idfaktur)) {
			/*$explode = explode("/", $idfaktur);
			$idfaktur = $explode[2];*/

			$string = (int)$idfaktur + 1;
			$idfaktur = str_pad($string, 3, '0', STR_PAD_LEFT);
		}

		else {
			$idfaktur = '001';
		}



		$data['nofp'] = 'FP' . $month . $year . '/' . 'C001' . '/' .  $idfaktur;
		/*dd($data['nofp']);*/

		
		$data['supplier'] = DB::select("select * from supplier where status = 'SETUJU'");
		$data['barang'] = DB::table('masteritem')
					        ->leftJoin('stock_gudang', 'stock_gudang.sg_item', '=', 'masteritem.kode_item')
					        ->get();
		$data['gudang'] =  masterGudangPurchase::all();
		$data['pajak'] = tb_master_pajak::all();

		$data['jenisitem'] = masterJenisItemPurchase::all();			        
		$data['cabang'] = DB::select("select * from cabang"); 
		
	
		return view('purchase/fatkur_pembelian/create', compact('data'));
	}


	public function detailfatkurpembelian($id) {
		$data['faktur'] = DB::select("select * from faktur_pembelian,supplier where  fp_idsup = idsup and fp_idfaktur = '$id'");
		$data['fakturdt'] = DB::select("select * from faktur_pembelian,supplier,faktur_pembeliandt , masteritem where fpdt_idfp = fp_idfaktur and fp_idsup = idsup and fpdt_kodeitem = kode_item and fp_idfaktur = '$id'");

		$data['fakturdtpo'] = DB::select("select * from faktur_pembelian, pembelian_order, supplier,faktur_pembeliandt , masteritem where fpdt_idfp = fp_idfaktur and fp_idsup = idsup and fpdt_kodeitem = kode_item and fp_idfaktur = '$id' and fpdt_idpo = po_id");

		$data['tt'] = DB::select("select * from faktur_pembelian, form_tt, supplier where fp_idtt = tt_idform and fp_idfaktur = '$id' and tt_idsupplier =idsup");
		/*dd($data);*/ 
		return view('purchase/fatkur_pembelian/detail', compact('data'));
	}

	public function savefakturpo(Request $request){
		/*dd($request);*/
		$variable = $request->supplier_po;
		$data = explode(",", $variable);
		$idsup = $data[0];
		$netto = str_replace(',', '', $request->nettohutang_po);
		$nofaktur = $request->no_faktur;

			//MEMBUAT NOFORMTT	
			$time = Carbon::now();
		//	$newtime = date('Y-M-d H:i:s', $time);  
			
			$year =Carbon::createFromFormat('Y-m-d H:i:s', $time)->year; 
			$month =Carbon::createFromFormat('Y-m-d H:i:s', $time)->month; 

			if($month < 10) {
				$month = '0' . $month;
			}

			$year = substr($year, 2);

			$idtt = DB::select("select tt_noform , max(tt_idform) from form_tt where tt_idcabang = 'C002' GROUP BY tt_idcabang, tt_noform");
			

			if(is_null($idtt)) {
				return $idtt;
				$explode = explode("/", $idtt);
				$idtt = $explode[2];

				$string = (int)$idtt + 1;
				$idtt = str_pad($string, 3, '0', STR_PAD_LEFT);
			}
			else {
				$idtt = '001';
			}
		
			$nott = 'TT' . $month . $year . '/' . 'C001' . '/' .  $idtt;

			//TANDA TERIMA	
			$lastidtt = tandaterima::max('tt_idform'); 
				if(isset($lastidtt)) {
					$idtt = $lastidtt;
					$idtt = (int)$idtt + 1;
				}
				else {
					$idtt = 1;
				}

			$tandaterima = new tandaterima();

			$tandaterima->tt_idform = $idtt;
			$tandaterima->tt_tgl = $request->tgl_po;
			$tandaterima->tt_idsupplier =$idsup;
			$tandaterima->tt_totalterima = $netto;
			$tandaterima->tt_kwitansi = $request->kwitansi;
			$tandaterima->tt_suratperan = $request->suratperan;
			$tandaterima->tt_suratjalanasli = $request->suratjalanasli;
			$tandaterima->tt_noform = $nott;
			$tandaterima->tt_tglkembali = $request->jatuhtempo_po;
			$tandaterima->tt_idcabang = 'C001';
			$tandaterima->tt_nofp = $nofaktur;

			$tandaterima->save();


			$idtandaterima = DB::select("select tt_idform from form_tt where tt_nofp = '$nofaktur'");
			

			$lastid = fakturpembelian::max('fp_idfaktur'); 
				if(isset($lastid)) {
					$idfaktur = $lastid;
					$idfaktur = (int)$idfaktur + 1;
				}
				else {
					$idfaktur = 1;
				}



				$total = str_replace(',', '', $request->jumlahtotal_po);
				$dpp = str_replace(',', '', $request->dpp_po);
				$hasilpph = str_replace(',', '', $request->hasilpph_po);
				$hasilppn = str_replace(',', '', $request->hasilppn_po);
				$netto = str_replace(',', '', $request->nettohutang_po);

				

			/*	$tgl = date_format($request->tglitem , "yyyy-m-d");
				$jatuhtempo - date_format($request->jatuhtempo, "yyyy-m-d");*/

				if(isset($request->diskon)){
					$request->diskon = 0;
				}

				$fatkurpembeliand = new fakturpembelian();
				$fatkurpembeliand->fp_idfaktur = $idfaktur; 
				$fatkurpembeliand->fp_nofaktur = $nofaktur;
				$fatkurpembeliand->fp_tgl = $request->tgl_po;
				$fatkurpembeliand->fp_idsup = $idsup;
				$fatkurpembeliand->fp_keterangan = $request->keterangan_po;
				$fatkurpembeliand->fp_noinvoice = $request->no_invoice_po;
				$fatkurpembeliand->fp_jatuhtempo = $request->jatuhtempo_po;
				$fatkurpembeliand->fp_jumlah = $total;
				if($request->disc_item_po != ''){
								$fatkurpembeliand->fp_discount = $request->disc_item_po;

				}

				$fatkurpembeliand->fp_dpp =$dpp;
				if($request->hasilppn_po != ''){
					$fatkurpembeliand->fp_jenisppn = $request->jenisppn_po;
					$fatkurpembeliand->fp_ppn = $hasilppn;
				}

				if($request->hasilpph_po != ''){
			
					$string = explode(",", $request->jenispph_po);
					$jenispph = $string[0];
					$fatkurpembeliand->fp_jenispph = $jenispph;
					$fatkurpembeliand->fp_pph = $hasilpph;
				}

				$fatkurpembeliand->fp_netto = $netto;
				$fatkurpembeliand->fp_jenisbayar = 2;
				$fatkurpembeliand->fp_idtt = $idtandaterima[0]->tt_idform;
				$fatkurpembeliand->fp_comp = 'C001';
				$fatkurpembeliand->fp_sisapelunasan = $netto;
				
				$fatkurpembeliand->fp_fakturpajak = 1;

				$fatkurpembeliand->fp_tipe = 'PO';
				$fatkurpembeliand->save();



				//update data telah difaktur
				//update di po				
				$time = Carbon::now();
				for($indxpo = 0 ; $indxpo < count($request->idpoheader); $indxpo++){	
					if($request->jenis != 'J'){ //UPDATE  BUKAN JASA
						if($request->flag != 'FP'){ // DARI PO
							$updatepo = purchase_orderr::where('po_id', '=', $request->idpoheader[$indxpo]);	// UPDATE PO			
							$updatepo->update([
							 	'po_idfaktur' => $idfaktur,
							 	'po_timefaktur' => $time,
							 	'po_updatefp' => 'Y'
						 	]);

						 	$updatepb = penerimaan_barang::where('pb_po' , '=' , $request->idpoheader[$indxpo]);
						 	$updatepb->update([
						 		'pb_terfaktur' => $idfaktur,
						 		'pb_timeterfaktur' => $time,
						 		]);

						} // END DARI PO BUKAN JASA
						else { //FP BUKAN JASA
								$updatefp = fakturpembelian::where('fp_idfaktur', '=' , $request->idpoheader[$indxpo]);
								$updatefp->update([
									'fp_terfaktur' => $idfaktur,
									'fp_timeterfaktur' => $time,
								]);

								$updatepb = penerimaan_barang::where('pb_fp' , '=' , $request->idpoheader[$indxpo]);
								 	$updatepb->update([
								 		'pb_terfaktur' => $idfaktur,
								 		'pb_timeterfaktur' => $time,
						 		]);
						}
					} //END DATA BUKAN JASA
					else {
						if($request->flag == 'PO') { //UPDATE PO
							$updatepo = purchase_orderr::where('po_id', '=', $request->idpoheader[$indxpo]);	// UPDATE PO			
							$updatepo->update([
							 	'po_idfaktur' => $idfaktur,
							 	'po_timefaktur' => $time,
							 	'po_updatefp' => 'Y'
						 	]);
						} 
						
					}					 	
				}


		$datafaktur = DB::select("select * from faktur_pembelian where fp_nofaktur = '$nofaktur'");
	//	return count($request->item_po);

		for($i = 0 ; $i < count($request->item_po); $i++){
			
			
				$lastidfpdt = fakturpembeliandt::max('fpdt_id');

				if(isset($lastidfpdt)) {
					$idfakturdt = $lastidfpdt;
					$idfakturdt = (int)$idfakturdt + 1;
				}
				else {
					$idfakturdt = 1;
				}

				$idfp = $datafaktur[0]->fp_idfaktur;

				$harga = str_replace(',', '', $request->hpp[$i]);
				$totalharga = str_replace(',', '', $request->totalharga[$i]);
	
				$fatkurpembeliandt2 = new fakturpembeliandt();
				$fatkurpembeliandt2->fpdt_id = $idfakturdt;
				$fatkurpembeliandt2->fpdt_idfp = $idfp;
				$fatkurpembeliandt2->fpdt_kodeitem = $request->item_po[$i];
				$fatkurpembeliandt2->fpdt_qty = $request->qty[$i];
				/*$fatkurpembeliandt->fpdt_gudang = $request->pb_gudang[$i];*/
				$fatkurpembeliandt2->fpdt_harga =  $harga;
				$fatkurpembeliandt2->fpdt_totalharga =  $totalharga;
				$fatkurpembeliandt2->fpdt_updatedstock =  $request->updatestock[$i];

				$iditem = $request->item_po[$i];
			//	return $iditem;
				$masteritem =DB::select("select * from masteritem where kode_item = '$iditem'");
				
				$acc_persediaan = $masteritem[0]->acc_persediaan;
			
				$fatkurpembeliandt2->fpdt_accbiaya = $acc_persediaan;
				if($request->flag == 'PO'){
					$fatkurpembeliandt2->fpdt_idpo = $request->idpo[$i];				
				}
				else {
					$fatkurpembeliandt2->fpdt_idfppo = $request->idpo[$i];
	
				}
				$fatkurpembeliandt2->save();
		}

	}


	// FAKTUR tanpa po
	public function savefaktur(Request $request) {
	/*dd($request);*/
			$variable = $request->supplier;
			$data = explode(",", $variable);
			$idsup = $data[0];
		
	

		$nofaktur = $request->nofaktur;

		$datafaktur = DB::select("select * from faktur_pembelian where fp_nofaktur = '$nofaktur'");
		/*$no_faktur = $datafaktur[0]->fp_nofaktur;*/


		if(empty($datafaktur)) {
			$lastid = fakturpembelian::max('fp_idfaktur'); 
			if(isset($lastid)) {
				$idfaktur = $lastid;
				$idfaktur = (int)$idfaktur + 1;
			}
			else {
				$idfaktur = 1;
			}

			$fatkurpembelian = new fakturpembelian();
			$fatkurpembelian->fp_idfaktur = $idfaktur; 
			$fatkurpembelian->fp_nofaktur = $nofaktur;
			$fatkurpembelian->fp_tgl = $request->tgl;
			$fatkurpembelian->fp_idsup = $idsup;
			$fatkurpembelian->fp_keterangan = $request->keterangan;
			$fatkurpembelian->fp_noinvoice = $request->no_invoice;
			$fatkurpembelian->fp_jatuhtempo = $request->jatuhtempo;
			$fatkurpembelian->save();


			$lastidfpdt = fakturpembeliandt::max('fpdt_id'); 
			if(isset($lastidfpdt)) {
				$idfakturdt = $lastidfpdt;
				$idfakturdt = (int)$idfakturdt + 1;
			}
			else {
				$idfakturdt = 1;
			}


			$harga = str_replace(',', '', $request->harga);
			$totalharga = str_replace(',', '', $request->amount);
			$biaya = str_replace(',', '', $request->biaya);

			$fatkurpembeliandt = new fakturpembeliandt();
			$fatkurpembeliandt->fpdt_id = $idfakturdt;
			$fatkurpembeliandt->fpdt_idfp = $idfaktur;
			$fatkurpembeliandt->fpdt_kodeitem = $request->nama_item;
			$fatkurpembeliandt->fpdt_qty = $request->qty;
			$fatkurpembeliandt->fpdt_gudang = $request->gudang;
			$fatkurpembeliandt->fpdt_harga =  $harga;
			$fatkurpembeliandt->fpdt_totalharga =  $totalharga;
			$fatkurpembeliandt->fpdt_updatedstock =  $request->updatestock;
			$fatkurpembeliandt->fpdt_biaya = $biaya;  
			$fatkurpembeliandt->fpdt_accbiaya =  $request->acc_biaya;
			$fatkurpembeliandt->fpdt_keterangan =  $request->keterangan_fp;
			$fatkurpembeliandt->fpdt_diskon =  $request->diskon2;
			$fatkurpembeliandt->save();
			/*$fatkurpembeliandt->fpdt_idpo =  */
			
		}
		else {
			$lastidfpdt = fakturpembeliandt::max('fpdt_id'); 
			if(isset($lastidfpdt)) {
				$idfakturdt = $lastidfpdt;
				$idfakturdt = (int)$idfakturdt + 1;
			}
			else {
				$idfakturdt = 1;
			}

			$idfp = $datafaktur[0]->fp_idfaktur;

			$harga = str_replace(',', '', $request->harga);
			$totalharga = str_replace(',', '', $request->amount);
			$biaya = str_replace(',', '', $request->biaya);

			$fatkurpembeliandt = new fakturpembeliandt();
			$fatkurpembeliandt->fpdt_id = $idfakturdt;
			$fatkurpembeliandt->fpdt_idfp = $idfp;
			$fatkurpembeliandt->fpdt_kodeitem = $request->nama_item;
			$fatkurpembeliandt->fpdt_qty = $request->qty;
			$fatkurpembeliandt->fpdt_gudang = $request->gudang;
			$fatkurpembeliandt->fpdt_harga =  $harga;
			$fatkurpembeliandt->fpdt_totalharga =  $totalharga;
			$fatkurpembeliandt->fpdt_updatedstock =  $request->updatestock;
			$fatkurpembeliandt->fpdt_biaya = $biaya;  
			$fatkurpembeliandt->fpdt_accbiaya =  $request->acc_biaya;
			$fatkurpembeliandt->fpdt_keterangan =  $request->keterangan_fp;
			$fatkurpembeliandt->save();
			/*$fatkurpembeliandt->fpdt_idpo =  */
	
		}	


		$data['fpdt'] = DB::select("select * from faktur_pembelian, faktur_pembeliandt, masteritem, mastergudang where fpdt_idfp = fp_idfaktur and fp_nofaktur = '$nofaktur' and fpdt_kodeitem = kode_item and fpdt_gudang = mg_id ");

		return json_encode($data);

	}

	public function update_fp(Request $request){
		$nofaktur = $request->nofakturitem;
		$jumlahtotal = $request->jumlahtotal;
		$variable = $request->idsupitem;
		$data = explode(",", $variable);
		$idsup = $data[0];
		$netto = str_replace(',', '', $request->nettohutang);
		$cabang = $request->cabang;

			//MEMBUAT NOFORMTT	
			$time = Carbon::now();
		//	$newtime = date('Y-M-d H:i:s', $time);  
			
			$year =Carbon::createFromFormat('Y-m-d H:i:s', $time)->year; 
			$month =Carbon::createFromFormat('Y-m-d H:i:s', $time)->month; 

			if($month < 10) {
				$month = '0' . $month;
			}

			$year = substr($year, 2);


			// SAVE TANDA TERIMA
			$idtt = DB::select("select tt_noform , max(tt_idform) from form_tt where tt_idcabang = '$cabang' GROUP BY tt_idcabang, tt_noform");
			


			if(is_null($idtt)) {
				return $idtt;
				$explode = explode("/", $idtt);
				$idtt = $explode[2];

				$string = (int)$idtt + 1;
				$idtt = str_pad($string, 3, '0', STR_PAD_LEFT);
			}

			else {
				$idtt = '001';
			}



			$nott = 'TT' . $month . $year . '/' . $cabang . '/' .  $idtt;

			//TANDA TERIMA	
			$lastidtt = tandaterima::max('tt_idform'); 
				if(isset($lastidtt)) {
					$idtt = $lastidtt;
					$idtt = (int)$idtt + 1;
				}
				else {
					$idtt = 1;
				}

			$tandaterima = new tandaterima();

			$tandaterima->tt_idform = $idtt;
			$tandaterima->tt_tgl = $request->tglitem;
			$tandaterima->tt_idsupplier =$idsup;
			$tandaterima->tt_totalterima = $netto;
			$tandaterima->tt_kwitansi = $request->kwitansi;
			$tandaterima->tt_suratperan = $request->suratperan;
			$tandaterima->tt_suratjalanasli = $request->suratjalanasli;
			$tandaterima->tt_noform = $request->notandaterima2;
			$tandaterima->tt_lainlain = $request->lainlain_tt2;
			$tandaterima->tt_tglkembali = $request->jatuhtempoitem;
			$tandaterima->tt_idcabang = $cabang;
			$tandaterima->tt_nofp = $nofaktur;


			$tandaterima->save();

			//SAVE FAKTUR PAJAK MASUKAN
			


			$idtandaterima = DB::select("select tt_idform from form_tt where tt_nofp = '$nofaktur'");
			

			$lastid = fakturpembelian::max('fp_idfaktur'); 
				if(isset($lastid)) {
					$idfaktur = $lastid;
					$idfaktur = (int)$idfaktur + 1;
				}
				else {
					$idfaktur = 1;
				}



				$total = str_replace(',', '', $request->jumlahtotal);
				$dpp = str_replace(',', '', $request->dpp);
				$hasilpph = str_replace(',', '', $request->hasilpph);
				$hasilppn = str_replace(',', '', $request->hasilppn);
				$netto = str_replace(',', '', $request->nettohutang);

				

			/*	$tgl = date_format($request->tglitem , "yyyy-m-d");
				$jatuhtempo - date_format($request->jatuhtempo, "yyyy-m-d");*/

				if(isset($request->diskon)){
					$request->diskon = 0;
				}


				$fatkurpembelian = new fakturpembelian();
				$fatkurpembelian->fp_idfaktur = $idfaktur; 
				$fatkurpembelian->fp_nofaktur = $nofaktur;
				$fatkurpembelian->fp_tgl = $request->tglitem;
				$fatkurpembelian->fp_idsup = $idsup;
				$fatkurpembelian->fp_keterangan = $request->keteranganheader;
				$fatkurpembelian->fp_noinvoice = $request->noinvoice;
				$fatkurpembelian->fp_jatuhtempo = $request->jatuhtempoitem;
				$fatkurpembelian->fp_jumlah = $total;

				if($request->diskon != ''){
					$fatkurpembelian->fp_discount = $request->diskon;
				}

				$fatkurpembelian->fp_dpp =$dpp;

				if($request->hasilppn != ''){
					$fatkurpembelian->fp_jenisppn = $request->jenisppn;
					$fatkurpembelian->fp_ppn = $hasilppn;
				}
				

				if($request->hasilpph != ''){
					$string = explode(",", $request->jenispph);
					$jenispph = $string[0];
					$fatkurpembelian->fp_jenispph = $jenispph;
					$fatkurpembelian->fp_pph = $hasilpph;
				}
			

				$fatkurpembelian->fp_netto = $netto;
				$fatkurpembelian->fp_jenisbayar = 2;
				$fatkurpembelian->fp_idtt = $idtandaterima[0]->tt_idform;
				$fatkurpembelian->fp_comp = $request->cabang;
			
				
				$fatkurpembelian->fp_fakturpajak = 1;
				
				
				if($request->penerimaan[0] == 'T'){
					$fatkurpembelian->fp_tipe = 'J';
					$fatkurpembelian->fp_updatestock = $request->updatestock[0];
				}
				else {
					if($request->updatestock[0] == 'Y'){
						$fatkurpembelian->fp_tipe = "S";
					}
					else {
						$fatkurpembelian->fp_tipe = 'NS';
					}
				}

				$fatkurpembelian->fp_updatestock = $request->updatestock[0];
				$fatkurpembelian->fp_terimabarang = 'BELUM';
				$fatkurpembelian->save();

					

					if($request->penerimaan[0] == 'T'){
						
					}
					else {
						
					

					for($i = 0; $i < count($request->gudang); $i++){
						$lastidterima = barang_terima::max('bt_id'); 

						if(isset($lastid)) {
							$idbarangterima = $lastidterima;
							$idbarangterima = (int)$idbarangterima + 1;
							
						}

						else {
							$idbarangterima = 1;
							
						}
							$gudang = explode(",", $request->gudang[$i]);
							$idgudang = $gudang[0];

							$barangterima = new barang_terima();
							$barangterima->bt_id = $idbarangterima;
							$barangterima->bt_flag = 'FP';
							$barangterima->bt_notransaksi = $nofaktur;
							$barangterima->bt_supplier =  $idsup;
							$barangterima->bt_idtransaksi = $idfaktur;
							$barangterima->bt_statuspenerimaan = 'BELUM DI TERIMA';
							$barangterima->bt_gudang = $idgudang[$i];
							
							if($request->updatestock[0] == 'Y'){
								$barangterima->bt_tipe = 'S';
							}
							else {
								$barangterima->bt_tipe  = 'NS';
							}

							$barangterima->bt_cabangpo = $request->cabang;
							$barangterima->save();
					}

					}


			for($x=0; $x < count($request->item); $x++){
				$lastidfpdt = fakturpembeliandt::max('fpdt_id');

				if(isset($lastidfpdt)) {
					$idfakturdt = $lastidfpdt;
					$idfakturdt = (int)$idfakturdt + 1;
				}
				else {
					$idfakturdt = 1;
				}

				$harga = str_replace(',', '', $request->harga[$x]);
				$totalharga = str_replace(',', '', $request->totalharga[$x]);
				$biaya = str_replace(',', '', $request->biaya[$x]);


				$kodeitem = explode(",", $request->item[$x]);
				$iditem = $kodeitem[0];
				$gudang = explode(",", $request->gudang[$x]);
				$idgudang = $gudang[0];

				$fatkurpembeliandt = new fakturpembeliandt();
				$fatkurpembeliandt->fpdt_id = $idfakturdt;
				$fatkurpembeliandt->fpdt_idfp = $idfaktur;
				$fatkurpembeliandt->fpdt_kodeitem = $iditem;
				$fatkurpembeliandt->fpdt_qty = $request->qty[$x];
				$fatkurpembeliandt->fpdt_gudang =$idgudang;
				$fatkurpembeliandt->fpdt_harga =  $harga;
				$fatkurpembeliandt->fpdt_totalharga =  $totalharga;
				$fatkurpembeliandt->fpdt_updatedstock =  $request->updatestock[$x];
				$fatkurpembeliandt->fpdt_biaya = $biaya;  
				$fatkurpembeliandt->fpdt_accbiaya =  $request->acc_biaya[$x];
				$fatkurpembeliandt->fpdt_keterangan =  $request->keteranganitem[$x];
				$fatkurpembeliandt->fpdt_diskon =  $request->diskonitem[$x];
				$fatkurpembeliandt->fpdt_groupitem =  $request->groupitem;
				$fatkurpembeliandt->save();
				/*$fatkurpembeliandt->fpdt_idpo =  */
			}


			if($hasilppn != ''){
				$lastidpajak =  fakturpajakmasukan::max('fpm_id');;
					if(isset($lastidpajak)) {
						$idpajakmasukan = $lastidpajak;
						$idpajakmasukan = (int)$idpajakmasukan + 1;
					}
					else {
						$idpajakmasukan = 1;
					} 

					$fpm = new fakturpajakmasukan ();
					$fpm->fpm_id = $idpajakmasukan;
					$fpm->fpm_nota = $request->nofaktur_pajak;
					$fpm->fpm_tgl = $request->tglfaktur_pajak;
					$fpm->fpm_masapajak = $request->masapajak_faktur;
					$dpp = str_replace(',', '', $request->dpp_fakturpembelian);
					$fpm->fpm_dpp = $dpp;	
					$hasilppn = str_replace(',', '', $request->hasilppn_fakturpembelian);
					$fpm->fpm_hasilppn = $dpp;
					$fpm->fpm_jenisppn = $request->jenisppn_faktur;
					$fpm->fpm_inputppn = $request->inputppn_fakturpembelian;
					$netto = str_replace(',', '', $request->netto_faktur);
					$fpm->fpm_netto =$netto;
					$fpm->fpm_idfaktur = $idfaktur;
					$fpm->save();
			}
			


		return json_encode('sukses');
		
	}
	
	public function getnotatt(Request $request){
		$cabang = $request->cabang;
			//MEMBUAT NOFORMTT	
			$time = Carbon::now();
		//	$newtime = date('Y-M-d H:i:s', $time);  
			
			$year =Carbon::createFromFormat('Y-m-d H:i:s', $time)->year; 
			$month =Carbon::createFromFormat('Y-m-d H:i:s', $time)->month; 

			if($month < 10) {
				$month = '0' . $month;
			}

			$year = substr($year, 2);
		$idtt = DB::select("select tt_noform , max(tt_idform) from form_tt where tt_idcabang = '$cabang' GROUP BY tt_idcabang, tt_noform");
			if(count($idtt) > 0) {
				
				$explode = explode("/", $idtt[0]->tt_noform);
				$idtt = $explode[2];

				$string = (int)$idtt + 1;
				$idtt2 = str_pad($string, 3, '0', STR_PAD_LEFT);
			}
			else {
				$idtt2 = '001';
			}



			return json_encode($idtt2);
	}

	public function getbiayalain (Request $request){
		$cabang = $request->cabang;
		if($cabang == '000'){
			$data['biaya'] = DB::select("select * from d_akun");
		}
		else {
			$data['biaya'] = DB::select("select * from d_akun where kode_cabang = '$cabang'");
		}

		$faktur = DB::select("select * from faktur_pembelian where fp_comp = '$cabang' order by fp_idfaktur desc limit 1");

		//return $idbbk;
		if(count($faktur) > 0) {
		
			$explode = explode("/", $faktur[0]->fp_nofaktur);
			$idfaktur = $explode[2];
		//	dd($nosppid);
			$idfaktur = (int)$idfaktur + 1;
			$data['idfaktur'] = str_pad($idfaktur, 3, '0', STR_PAD_LEFT);
		}

		else {
	
			$data['idfaktur'] = '001';
		}

	
		return json_encode($data);
	}

	public function update_tt(Request $request){
			$idform = $request->idform;
			$lain = strtoupper($request->lainlain);
			$updatetandaterima = tandaterima::where('tt_idform', '=', $idform);

			$updatetandaterima->update([
			 	'tt_lainlain' => $lain
			]);	

			return json_encode('sukses');		 	
	
	}


	public function terbilang($x, $style=4) {
    if($x<0) {
        $hasil = "minus ". trim($this->kekata($x));
    } else {
        $hasil = trim($this->kekata($x));
    }     
    switch ($style) {
        case 1:
            $hasil = strtoupper($hasil);
            break;
        case 2:
            $hasil = strtolower($hasil);
            break;
        case 3:
            $hasil = ucwords($hasil);
            break;
        default:
            $hasil = ucfirst($hasil);
            break;
    }     
    return $hasil;
}

public function kekata($x) {
    $x = abs($x);
    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
    "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($x <12) {
        $temp = " ". $angka[$x];
    } else if ($x <20) {
        $temp = $this->kekata($x - 10). " belas";
    } else if ($x <100) {
        $temp = $this->kekata($x/10)." puluh". $this->kekata($x % 10);
    } else if ($x <200) {
        $temp = " seratus" . $this->kekata($x - 100);
    } else if ($x <1000) {
        $temp = $this->kekata($x/100) . " ratus" . $this->kekata($x % 100);
    } else if ($x <2000) {
        $temp = " seribu" . $this->kekata($x - 1000);
    } else if ($x <1000000) {
        $temp = $this->kekata($x/1000) . " ribu" . $this->kekata($x % 1000);
    } else if ($x <1000000000) {
        $temp = $this->kekata($x/1000000) . " juta" . $this->kekata($x % 1000000);
    } else if ($x <1000000000000) {
        $temp = $this->kekata($x/1000000000) . " milyar" . $this->kekata(fmod($x,1000000000));
    } else if ($x <1000000000000000) {
        $temp = $this->kekata($x/1000000000000) . " trilyun" . $this->kekata(fmod($x,1000000000000));
    }     
        return $temp;
}
 
	public function cetaktt($id){
		$data['tt'] = DB::select("select * from faktur_pembelian, form_tt, supplier where tt_idform = '$id' and tt_idsupplier = idsup and tt_nofp = fp_nofaktur");
		if(isset($data['tt'])){
					$data['terbilang'] = $this->terbilang($data['tt'][0]->tt_totalterima,$style=3);	
		}

		 $data['tgl'] = Carbon::parse($data['tt'][0]->tt_tglkembali)->format('D');
		 if($data['tgl'] == 'Sun'){
			    	$data['tgl'] = 'Minggu';
			    }else if($data['tgl'] == 'Mon'){
			    	$data['tgl'] = 'Senin';
			    
				}else if($data['tgl'] == 'Tue'){
			    	$data['tgl'] = 'Selasa';
			    
				}else if($data['tgl'] == 'Wed'){
			    	$data['tgl'] = 'Rabu';
			    
				}else if($data['tgl'] == 'Thu'){
			    	$data['tgl'] = 'Kamis';
			    }else if($data['tgl'] == 'Fri'){
			    	$data['tgl'] = 'Jumat';
				}else if($data['tgl'] == 'Sat'){
			    	$data['tgl'] = 'Sabtu';
				}

	
		return view('purchase/fatkur_pembelian/cetaktt2' , compact('data'));
	}
	
	public function supplierfaktur(Request $request){
		$variable = $request->idsup;
		$data = explode(",", $variable);
		$idsup = $data[0];


			//query FP JASA MASUK
	//		select  LEFT(po_no,2) as flag , po_cabang as cabang, po_id as id , po_no as nobukti, pb_po, po_tipe as penerimaan, po_totalharga as totalharga from pembelian_order LEFT OUTER JOIN penerimaan_barang on pb_po = po_id where po_supplier = '1' and po_tipe != 'J' union select LEFT(fp_nofaktur,2) as flag , fp_comp as cabang, fp_idfaktur, fp_nofaktur as nobukti, fp_idfaktur, fp_tipe as penerimaan, fp_netto as totalharga from faktur_pembelian where fp_idsup = '1' and fp_tipe = 'J' union select  LEFT(po_no,2) as flag , po_cabang as cabang, po_id as id , po_no as nobukti, po_id, po_tipe as penerimaan, po_totalharga as totalharga from pembelian_order LEFT OUTER JOIN penerimaan_barang on pb_po = po_id and po_supplier = '1' where po_tipe = 'J' union select  LEFT(fp_nofaktur,2) as flag , fp_comp as cabang, fp_idfaktur as id , fp_nofaktur as nobukti, pb_po, fp_tipe as penerimaan, fp_netto as totalharga from faktur_pembelian LEFT OUTER JOIN penerimaan_barang on pb_fp = fp_idfaktur where fp_idsup = '1' and fp_tipe != 'J' order by id desc/*/*

	/*	if($$data['penerimaan'] != 'J'){ //PO
						$idpo = $data['po'][$i]->id;

						$data['isi'][] = DB::select("select *  from pembelian_order LEFT OUTER JOIN  penerimaan_barang on po_id = pb_po and pb_po = po_id where po_supplier = '$idsup' and po_id = '$idpo' ");
						return json_encode($data);

							for($z=0; $z < count($data['isi']); $z++){				
									$temp = 0;
									$status = $data['isi'][$z]->p;
								

								if($status == 'LENGKAP') {
									$status_fix = 'LENGKAP';
								}
								else if($status == 'TIDAK LENGKAP') {
									$status_fix = 'TIDAK LENGKAP';
								}
								else if($status == null){
									$status_fix = 'BELUM DI TERIMA';
								}
								else {
									$status_double = explode("," , $status);
									$temp = 0;

								for($xz=0; $xz < count($status_double); $xz++){								
										//array_push($data['status'] , $status);
									if($status_double[$xz] == 'LENGKAP') {
										$temp = 1;
									}
									
								}

									if($temp > 0 ) {
										$status_fix = 'LENGKAP';
									}
									else {
										$status_fix = 'TIDAK LENGKAP';
									}			
								}
								array_push($data['alias'] , $status_fix);
							}


					}	
					else { //PO JASA
						$data['penerimaan'] = $data['po'][$i]->penerimaan;
						$data['alias'] = 'JASA';
					}*/


			$data['po'] = DB::select("select  LEFT(po_no,2) as flag , po_cabang as cabang, po_id as id , po_no as nobukti, pb_po, po_tipe as penerimaan, po_totalharga as totalharga from pembelian_order LEFT OUTER JOIN penerimaan_barang on pb_po = po_id where po_supplier = '$idsup' and po_tipe != 'J' and pb_terfaktur IS null union select  LEFT(po_no,2) as flag , po_cabang as cabang, po_id as id , po_no as nobukti, po_id, po_tipe as penerimaan, po_totalharga as totalharga from pembelian_order LEFT OUTER JOIN penerimaan_barang on pb_po = po_id and po_supplier = '$idsup' where po_tipe = 'J' and po_idfaktur IS null union select  LEFT(fp_nofaktur,2) as flag , fp_comp as cabang, fp_idfaktur as id , fp_nofaktur as nobukti, pb_po, fp_tipe as penerimaan, fp_netto as totalharga from faktur_pembelian LEFT OUTER JOIN penerimaan_barang on pb_fp = fp_idfaktur where fp_idsup = '$idsup' and fp_tipe != 'J' and fp_tipe != 'PO' and fp_terfaktur IS null order by id desc");

			

			$data['penerimaan'] = [];
			for($i = 0 ; $i < count($data['po']); $i++){
				$flag = $data['po'][$i]->flag;			
				if($flag == 'PO'){
					$penerimaan = $data['po'][$i]->penerimaan;
					array_push($data['penerimaan'] , $penerimaan);
				}
				else {
					$penerimaan = $data['po'][$i]->penerimaan;
					array_push($data['penerimaan'] , $penerimaan);
				}
			}

			$data['status'] = [];
			for($inx = 0; $inx < count($data['penerimaan']); $inx++){
				if($data['penerimaan'][$inx] != 'J'){
					$flag =	$data['po'][$inx]->flag;

					if($flag == 'PO'){
						$id = $data['po'][$inx]->id;
						$datas['data'] = DB::select("select po_no, po_totalharga, po_id, string_agg(pb_status,',') as p from pembelian_order LEFT OUTER JOIN penerimaan_barang on pb_po = po_id where po_supplier = '$idsup' and po_tipe != 'J' and po_id = '$id'  group by po_id , po_no order by p");
							$temp = 0;

						//	return json_encode($datas['data'][0]->p);
							for($ji = 0 ; $ji < count($datas['data']); $ji++){
								$status =$datas['data'][$ji]->p;
								if($status == 'LENGKAP') {
									$status_fix = 'LENGKAP';
								}
								else if($status == 'TIDAK LENGKAP') {
									$status_fix = 'TIDAK LENGKAP';
								}	
								else if($status == null){
									$status_fix = 'BELUM DI TERIMA';
								}
								else {
									$status_double = explode("," , $status);
									$temp = 0;
								for($xz=0; $xz < count($status_double); $xz++){								
										//array_push($data['status'] , $status);
									if($status_double[$xz] == 'LENGKAP') {
										$temp = 1;
									}
									
								}

									if($temp > 0 ) {
										$status_fix = 'LENGKAP';
									}
									else {
										$status_fix = 'TIDAK LENGKAP';
									}			
								}
								array_push($data['status'] , $status_fix);	
							}
							
									
				}
				else {
					$id = $data['po'][$inx]->id;
						$datas['data'] = DB::select("select fp_nofaktur, fp_netto, fp_idfaktur, string_agg(pb_status,',') as p from faktur_pembelian LEFT OUTER JOIN penerimaan_barang on pb_fp = fp_idfaktur where fp_idsup = '$idsup' and fp_tipe != 'J' and fp_idfaktur = '$id'  group by fp_idfaktur , fp_nofaktur order by fp_idfaktur desc");
							$temp = 0;

						//	return json_encode($datas['data'][0]->p);
							for($ji = 0 ; $ji < count($datas['data']); $ji++){
								$status =$datas['data'][$ji]->p;
								if($status == 'LENGKAP') {
									$status_fix = 'LENGKAP';
								}
								else if($status == 'TIDAK LENGKAP') {
									$status_fix = 'TIDAK LENGKAP';
								}	
								else if($status == null){
									$status_fix = 'BELUM DI TERIMA';
								}
								else {
									$status_double = explode("," , $status);
									$temp = 0;
								for($xz=0; $xz < count($status_double); $xz++){								
										//array_push($data['status'] , $status);
									if($status_double[$xz] == 'LENGKAP') {
										$temp = 1;
									}
									
								}

									if($temp > 0 ) {
										$status_fix = 'LENGKAP';
									}
									else {
										$status_fix = 'TIDAK LENGKAP';
									}			
								}
								array_push($data['status'] , $status_fix);	
							}
				}
			}
				else {
					$flag =	$data['po'][$inx]->flag;
					$status_fix = $flag . ' TIPE JASA';
					array_push($data['status'] , $status_fix);
				}
			}			

			$data['supplier'] = DB::select("select * from supplier where idsup = '$idsup'");	
			return json_encode($data);

	}


	public function tampil_po(Request $request){
					
		$array = $request->nobukti;
		$jenis = $request->jenis;
		$flag = $request->flag;

		for($j=0; $j < count($array); $j++){
			$no_po = $array[$j];

			if($flag[$j] == 'PO'){				
				if($jenis[$j] != 'J'){

					$data['po'][] = DB::select("select po_id ,po_no, po_totalharga, po_tipe  from pembelian_order, penerimaan_barang where po_id = pb_po and po_no = '$no_po' Group by po_id, po_no");
					$data['po_barang'][] = DB::select("select distinct  nama_masteritem, acc_persediaan , pb_gudang, pbdt_item, pbdt_idspp, sum(pbdt_totalharga) as sumharga, sum(podt_qtykirim) as qty_po, pb_po , pbdt_updatestock, pbdt_hpp, sum(pbdt_qty) as sumqty, pb_comp  from penerimaan_barang , pembelian_order, penerimaan_barangdt, pembelian_orderdt, masteritem where po_id = podt_idpo and pbdt_idpb = pb_id and pbdt_item = kode_item  and podt_kodeitem = pbdt_item and podt_idpo = pb_po and  pbdt_po = pb_po and pbdt_idspp = podt_idspp and po_no = '$no_po' group by pb_gudang, nama_masteritem, pbdt_item, pbdt_idspp, pb_po, pbdt_updatestock ,pbdt_hpp, pb_comp, acc_persediaan");

					$data['barang_penerimaan'] = DB::select("select distinct nama_masteritem, acc_persediaan , pb_gudang, pbdt_item, pbdt_idspp, sum(pbdt_totalharga) as sumharga, podt_qtykirim , pb_po , pbdt_updatestock, pbdt_hpp, sum(pbdt_qty) as sumqty, pb_comp  from penerimaan_barang , penerimaan_barangdt, masteritem, pembelian_orderdt where pbdt_idpb = pb_id and pbdt_item = kode_item  and podt_kodeitem = pbdt_item and podt_idpo = pb_po and  pbdt_po = pb_po and pbdt_idspp = podt_idspp  group by pb_gudang, nama_masteritem, pbdt_item, pbdt_idspp, pb_po, pbdt_updatestock ,pbdt_hpp, pb_comp, podt_qtykirim,acc_persediaan");
				}
				else {

					$data['po'][] = DB::select("select po_id ,po_no, po_totalharga, po_tipe  from pembelian_order where  po_no = '$no_po' Group by po_id, po_no");

					$data['po_barang'][] = DB::select("select po_id, acc_persediaan, nama_masteritem, podt_totalharga, podt_kodeitem, podt_qtykirim, podt_jumlahharga from pembelian_order,  masteritem, pembelian_orderdt where podt_kodeitem = kode_item and podt_idpo = po_id and po_no = '$no_po'");

					$data['barang_penerimaan'] = DB::select("select po_id, acc_persediaan, nama_masteritem, podt_kodeitem, podt_qtykirim, podt_totalharga, podt_jumlahharga from pembelian_order,  masteritem, pembelian_orderdt where podt_kodeitem = kode_item and podt_idpo = po_id");

					
				}

			}
			//FP
			else {

				if($jenis[0] != 'J') {
					$data['po'][] = DB::select("select fp_idfaktur , fp_tipe, fp_nofaktur, fp_netto from faktur_pembelian where fp_nofaktur = '$no_po'");

					$data['po_barang'][] = DB::select("select distinct fpdt_accbiaya, nama_masteritem, fpdt_gudang, fp_nofaktur, fpdt_kodeitem, pbdt_idfp, sum(pbdt_totalharga) as sumharga, fpdt_qty , pb_fp , pbdt_updatestock, pbdt_hpp, sum(pbdt_qty) as sumqty, pb_comp, fpdt_diskon  from penerimaan_barang , penerimaan_barangdt, masteritem, faktur_pembeliandt, faktur_pembelian where pbdt_idpb = pb_id and pbdt_item = kode_item  and fpdt_kodeitem = pbdt_item and fpdt_idfp = pb_fp and pbdt_idfp = pb_fp and fpdt_idfp = fp_idfaktur and pbdt_idfp = fp_idfaktur and fp_nofaktur = '$no_po'  group by pb_gudang, nama_masteritem, pbdt_item, pb_po, pbdt_updatestock ,pbdt_hpp, pb_comp,  fp_nofaktur, fpdt_qty, fpdt_gudang, fpdt_kodeitem, pbdt_idfp , pb_fp, fpdt_diskon, fpdt_accbiaya ");

					$data['barang_penerimaan'] = DB::select("select distinct fpdt_accbiaya, nama_masteritem, fpdt_diskon, fpdt_gudang, fpdt_kodeitem, pbdt_idfp, sum(pbdt_totalharga) as sumharga, fpdt_qty , pb_fp , pbdt_updatestock, pbdt_hpp, sum(pbdt_qty) as sumqty, pb_comp  from penerimaan_barang , penerimaan_barangdt, masteritem, faktur_pembeliandt where pbdt_idpb = pb_id and pbdt_item = kode_item  and fpdt_kodeitem = pbdt_item and fpdt_idfp = pb_fp and pbdt_idfp = pb_fp  group by pb_gudang, nama_masteritem, pbdt_item, pb_po, pbdt_updatestock ,pbdt_hpp, pb_comp, fpdt_qty, fpdt_gudang, fpdt_kodeitem, pbdt_idfp , pb_fp, fpdt_diskon, fpdt_accbiaya");
				}
				else {


					$data['po'][] = DB::select("select fp_idfaktur ,fp_nofaktur, fp_netto, fp_tipe  from faktur_pembelian where fp_nofaktur = '$no_po'");

					$data['po_barang'][] = DB::select("select fpdt_kodeitem, fpdt_diskon, fpdt_harga, fpdt_biaya, fp_idfaktur, acc_persediaan, nama_masteritem, fpdt_totalharga, fpdt_biaya, fpdt_qty from faktur_pembelian,  masteritem, faktur_pembeliandt where fpdt_kodeitem = kode_item and fpdt_idfp = fp_idfaktur and fp_nofaktur = '$no_po'");

					$data['barang_penerimaan'] = DB::select("select fp_idfaktur, fpdt_diskon, fpdt_kodeitem, acc_persediaan, nama_masteritem, fpdt_totalharga, fpdt_biaya, fpdt_qty, fpdt_harga from faktur_pembelian,  masteritem, faktur_pembeliandt where fpdt_kodeitem = kode_item and fpdt_idfp = fp_idfaktur and fp_tipe = 'J'");

					
				}
				
			}
		}

		

		return json_encode($data);
	}


	public function voucherhutang() {
		return view('purchase/voucher_hutang/index');
	}

	public function createvoucherhutang() {
		return view('purchase/voucher_hutang/create');
	}

	public function detailvoucherhutang() {
		return view('purchase/voucher_hutang/detail');
	}

	public function returnpembelian() {
		return view('purchase/return_pembelian/index');
	}

	public function createreturnpembelian() {
		return view('purchase/return_pembelian/create');
	}

	public function detailreturnpembelian() {
		return view('purchase/return_pembelian/detail');
	}

	public function cndnpembelian() {
		return view('purchase/cndn_pembelian/index');
	}

	public function createcndnpembelian() {
		return view('purchase/cndn_pembelian/create');
	}

	public function detailcndnpembelian() {
		return view('purchase/cndn_pembelian/detail');
	}

	public function uangmukapembelian() {
		return view('purchase/uangmukapembelian/index');
	}

	public function createuangmukapembelian() {
		return view('purchase/uangmukapembelian/create');
	}

	public function detailuangmukapembelian() {
		return view('purchase/uangmukapembelian/detail');
	}

	


	public function pelunasanhutangbank() {
		$data['bbk'] = DB::select("select * from bukti_bank_keluar, cabang, masterbank where bbk_cabang = cabang.kode and bbk_kodebank = mb_id" );

		return view('purchase/pelunasanhutangbank/index' , compact('data'));
	}

	public function createpelunasanbank() {
		$data['bank'] = DB::select("select * from masterbank");
		$data['cabang'] = DB::select("select * from cabang");
		$data['akun'] = DB::select("select * from d_akun");
		return view('purchase/pelunasanhutangbank/create', compact('data'));
	}

	public function detailpelunasanbank($id) {
		$data['bank'] = DB::select("select * from masterbank");
		$data['cabang'] = DB::select("select * from cabang");
		$data['akun'] = DB::select("select * from d_akun");
			$data['bbk'] = DB::select("select * from bukti_bank_keluar, cabang, masterbank where bbk_cabang = cabang.kode and bbk_kodebank = mb_id and bbk_id = '$id'" );
			$flag = $data['bbk'][0]->bbk_flag;
			if($flag == 'CEKBG'){
				$bbkd = DB::select("select * from bukti_bank_keluar, bukti_bank_keluar_detail, cabang, masterbank where bbk_cabang = cabang.kode and bbk_kodebank = mb_id and bbkd_idbbk = bbk_id and bbk_id = '$id'");
				//dd(count($bbkd));
				for($j = 0 ; $j < count($bbkd); $j++){
					$jenissup = $bbkd[$j]->bbkd_jenissup;
					if($jenissup == 'supplier'){
						$data['jenissup'][] = 'supplier';
						$data['bbkd'][] = DB::select("select * from bukti_bank_keluar, bukti_bank_keluar_detail, cabang, masterbank, supplier where bbk_cabang = cabang.kode and bbk_kodebank = mb_id and bbkd_idbbk = bbk_id and bbkd_supplier = supplier.no_supplier and active = 'AKTIF' and bbkd_jenissup = 'supplier' and bbk_id = '$id' ");
					}
					else if($jenissup == 'agen'){
						$data['jenissup'][] = 'agen';
						$data['bbkd'][] = DB::select("select * from bukti_bank_keluar, bukti_bank_keluar_detail, cabang, masterbank, agen where bbk_cabang = cabang.kode and bbk_kodebank = mb_id and bbkd_idbbk = bbk_id and bbkd_supplier = agen.kode  and bbkd_jenissup == 'agen' and bbk_id = '$id'");
					}
					else if($jenissup == 'subcon'){
						$data['jenissup'][] = 'subcon';
						$data['bbkd'][] = DB::select("select * from bukti_bank_keluar, bukti_bank_keluar_detail, cabang, masterbank, subcon where bbk_cabang = cabang.kode and bbk_kodebank = mb_id and bbkd_idbbk = bbk_id and bbkd_supplier = subcon.kode and bbkd_jenissup == 'subcon' and bbk_id = '$id' ");
					}
					else if($jenissup == 'cabang'){
						$data['jenissup'][] = 'cabang';
						$data['bbkd'][] = DB::select("select * from bukti_bank_keluar, bukti_bank_keluar_detail, cabang, masterbank where bbk_cabang = cabang.kode and bbk_kodebank = mb_id and bbkd_idbbk = bbk_id and bbkd_supplier = cabang.kode and bbkd_jenissup = 'cabang' and bbk_id = '$id'");
					}
				}
			}
			else {
				$data['bbkd'] = DB::select("select * from bukti_bank_keluar, bukti_bank_keluar_biaya, cabang, masterbank, d_akun where bbk_cabang = cabang.kode and bbk_kodebank = mb_id and bbkb_idbbk = bbk_id and bbkb_akun = id_akun and bbk_id = '$id' ");
			}

		//dd($data['bbkd']);

		return view('purchase/pelunasanhutangbank/detail' , compact('data'));
	}

	public function nocheckpelunasanhutangbank(Request $request){
		$idbank = $request->kodebank;

		$data['fpgbank'] = DB::select("select * from fpg_cekbank,fpg where fpgb_kodebank = '$idbank' and fpgb_idfpg = idfpg");
		return json_encode($data);
	}

	public function getcek(Request $request){

		for($i=0; $i < count($request->idfpg); $i++){

			//return (count($request->idfpg));
		$idfpg = $request->idfpg[$i];
		$idfpgb = $request->idfpgb[$i];

		$fpg = DB::select("select * from fpg where idfpg = '$idfpg'");
		$jenisbayar = $fpg[0]->fpg_jenisbayar;

		if($jenisbayar == '4'){
			$fpg2 = DB::select("select * from fpg, d_uangmuka where idfpg = '$idfpg' and fpg_agen = um_supplier");
			$jenissup = $fpg2[0]->um_jenissup;
			$data['jenissup'] = $jenissup;
			if($jenissup == 'supplier'){
				$data['fpg'] = DB::select("select * from fpg, fpg_cekbank ,supplier, masterbank, jenisbayar where idfpg = '$idfpg' and fpg_supplier = idsup and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id fpgb_id = '$idfpgb' and fpgb_idfpg = idfpg and idfpg = '$idfpg'");
			}
			else if($jenissup == 'agen'){
				$data['fpg'] = DB::select("select * from fpg,agen, fpg_cekbank , masterbank, jenisbayar where idfpg = '$idfpg' and fpg_agen = kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpgb_id = '$idfpgb' and fpgb_idfpg = idfpg and idfpg = '$idfpg'");	
			}
			else if($jenissup == 'subcon'){
				$data['fpg'] = DB::select("select * from fpg, fpg_cekbank, subcon, masterbank, jenisbayar where idfpg = '$idfpg' and fpg_agen = kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpgb_id = '$idfpgb' and fpgb_idfpg = idfpg and idfpg = '$idfpg'");	
			}
			

		}
		else if($jenisbayar == '2' || $jenisbayar == '3'){
			$data['fpg'] = DB::select("select * from fpg, fpg_cekbank, supplier, masterbank, jenisbayar where idfpg = '$idfpg' and fpg_supplier = idsup and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpgb_id = '$idfpgb' and fpgb_idfpg = idfpg and idfpg = '$idfpg'");	
		}
		else if($jenisbayar == '6' || $jenisbayar == '7'){
			$data['fpg'] = DB::select("select * from fpg,agen, masterbank, fpg_cekbank, jenisbayar where idfpg = '$idfpg' and fpg_agen = kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpgb_id = '$idfpgb' and fpgb_idfpg = idfpg and idfpg = '$idfpg'");	
		}

		else if($jenisbayar == '9'){
			$data['fpg'] = DB::select("select * from fpg, fpg_cekbank, subcon, masterbank, jenisbayar where idfpg = '$idfpg' and fpg_agen = kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpgb_id = '$idfpgb' and fpgb_idfpg = idfpg and idfpg = '$idfpg'");	
		}
		else if($jenisbayar == '1'){
			$data['fpg'] = DB::select("select * from fpg, fpg_cekbank, cabang, masterbank, jenisbayar where idfpg = '$idfpg' and fpg_agen = kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpgb_id = '$idfpgb' and fpgb_idfpg = idfpg and idfpg = '$idfpg'");
		}

		else if($jenisbayar == '5'){ 
			$data['fpg'] = DB::select("select * from fpg, fpg_dt, supplier where idfpg ='$idfpg' and  fpgdt_idfpg = idfpg ");
	
		}
	}
		/*$data['fpgbank'] = DB::select("select * from fpg_cekbank , fpg where fpdb_id = '$idfpgb' and fpgb_idfpg = idfpg and idfpg = '$idfpg' and fpdb_id = '$idfpgb' and fpgb_idfpg = idfpg and idfpg = '$idfpg'");*/

		return json_encode($data);
	}

	public function getnobbk(Request $request){
		$comp = $request->comp;
		$idbbk = DB::select("select * from bukti_bank_keluar where bbk_cabang = '$comp' order by bbk_id desc limit 1");

		//return $idbbk;
		if(count($idbbk) > 0) {
		
			$explode = explode("/", $idbbk[0]->bbk_nota);
			$idbbk = $explode[2];
		//	dd($nosppid);
			$string = (int)$idbbk + 1;
			$idbbk = str_pad($string, 3, '0', STR_PAD_LEFT);
		}

		else {
	
			$idbbk = '001';
		}

		return json_encode($idbbk) ;
	}
	
	public function simpanbbk (Request $request){

		$bbk = new bukti_bank_keluar();
		$cabang = $request->cabang;
		$lastid =  bukti_bank_keluar::max('bbk_id');;
		if(isset($lastid)) {
			$idbbk = $lastid;
			$idbbk = (int)$idbbk + 1;
		}
		else {
			$idbbk = 1;
		} 


		$bbk->bbk_id = $idbbk; $idbbk;
		$bbk->bbk_nota = $request->nobbk;
		$bbk->bbk_kodebank = $request->kodebank;
		$bbk->bbk_keterangan = $request->keteranganheader;
		if($request->flag == 'CEKBG'){
			$totalcekbg = str_replace(',', '', $request->totalcekbg);
			$bbk->bbk_cekbg = $totalcekbg;
		}
		else {
			$totalbiaya = str_replace(',', '', $request->totalbiaya);
			$bbk->bbk_biaya = $totalbiaya;
		}

		$total = str_replace(',', '', $request->total);
		$bbk->bbk_total = $total;
		$bbk->bbk_cabang = $request->cabang;
		$bbk->bbk_flag = $request->flag;
		$bbk->bbk_tgl = $request->tglbbk;
		$bbk->save();

		//return count($request->nofpg);
		if($request->flag == 'CEKBG'){
			for($i = 0; $i < count($request->nofpg); $i++){
				$bbkdt = new bukti_bank_keluar_dt();
			
				$lastidbbkd =  bukti_bank_keluar_dt::max('bbkd_id');
				if(isset($lastidbbkd)) {
						$idbbkd = $lastidbbkd;
						$idbbkd = (int)$idbbkd + 1;
				}
				else {
						$idbbkd = 1;
				} 

				$bbkdt->bbkd_id = $idbbkd;
				$bbkdt->bbkd_idbbk =$idbbk;
				$bbkdt->bbkd_nocheck = $request->notransaksi[$i];
				if($request->jatuhtempo[$i] != ''){
					$bbkdt->bbkd_jatuhtempo = $request->jatuhtempo[$i];					
				}
				
				$nominal = str_replace(',', '', $request->nominal[$i]);
				$explode = explode("-", $request->supplier[$i]);
				$idsupplier = $explode[0];
				$bbkdt->bbkd_nominal = $nominal;
				$bbkdt->bbkd_keterangan = $request->keterangan[$i];
				$bbkdt->bbkd_bank = $request->idbank[$i];
				$bbkdt->bbkd_supplier = $idsupplier;
				$bbkdt->bbkd_tglfpg = $request->tgl[$i];
				$bbkdt->bbkd_jenissup = $request->jenissup[$i];
				$bbkdt->save();
			}
		}
		else {
			for($j=0;$j<count($request->akun);$j++){
				$bbkb = new bukti_bank_keluar_biaya();

				$lastidbbkb =  bukti_bank_keluar_biaya::max('bbkb_id');
				if(isset($lastidbbkb)) {
						$idbbkb = $lastidbbkb;
						$idbbkb = (int)$idbbkb + 1;
				}
				else {
						$idbbkb = 1;
				} 
				$jumlah = str_replace(',', '', $request->jumlah[$j]);

				$bbkb->bbkb_id = $idbbkb;
				$bbkb->bbkb_idbbk = $idbbk;
				$bbkb->bbkb_akun = $request->akun[$j];
				$bbkb->bbkb_dk = $request->dk[$j];
				$bbkb->bbkb_nominal = $jumlah;
				$bbkb->bbkb_keterangan = $request->keterangan[$j];
				$bbkb->save();
			}
		}
		
		
		return json_encode('sukses');
	}

	public function cetakbbk(){
		return view('purchase/pelunasanhutangbank/print');
	}
	public function bankkaslain() {
		return view('purchase/bankkaslain/index');
	}

	public function createbankkaslain() {
		return view('purchase/bankkaslain/create');
	}

	public function detailbankkaslain() {
		return view('purchase/bankkaslain/detail');
	}

	public function mutasistock() {
		return view('purchase/mutasi_stock/index');
	}

	public function createmutasistock() {
		return view('purchase/mutasi_stock/create');
	}

	public function detailmutasistock() {
		return view('purchase/mutasi_stock/detail');
	}

	public function formtandaterimatagihan() {
		return view('purchase/formtandaterimatagihan/index');
	}

	public function createformtandaterimatagihan() {

		$data['supplier'] = DB::select("select * from supplier where status = 'SETUJU' and active = 'AKTIF'");
	//	dd('aan');
		return view('purchase/formtandaterimatagihan/create' , compact('data'));
	
	}

	public function detailformtandaterimatagihan() {
		return view('purchase/formtandaterimatagihan/detail');
	}

	public function formaju() {
		return view('purchase/formaju/index');
	}

	public function createformaju() {
		return view('purchase/formaju/create');
	}

	public function detailformaju() {
		return view('purchase/formaju/detail');
	}


	public function formfpg() {

		$fpg = DB::select("select * from fpg");
		$arrfpg = [];
		$data['fpg'] = DB::select("select * from   jenisbayar, fpg  where  fpg_jenisbayar = idjenisbayar ");

		/*for($i = 0; $i < count($fpg); $i++){
			$jenisbayar = $fpg[$i]->fpg_jenisbayar;
			if($jenisbayar == '5'){
				$fpg2 = DB::select("select * from   jenisbayar, fpg  where  fpg_jenisbayar = idjenisbayar ");
				//array_push($arrfpg, $fpg2);
			}
			if($jenisbayar == '2' || $jenisbayar == '3'){
				$fpg2 = DB::select("select * from   jenisbayar, fpg , supplier where fpg_supplier = idsup and fpg_jenisbayar = idjenisbayar ");
				//array_push($arrfpg, $fpg2);
				
			} 
			if($jenisbayar == '6' || $jenisbayar == '7') {
				$fpg2 = DB::select("select * from   jenisbayar, fpg LEFT OUTER JOIN  agen on fpg_agen = kode where fpg_jenisbayar = idjenisbayar ");	
				//array_push($arrfpg, $fpg2);

			}
			if($jenisbayar == '9'){
				$fpg2 = DB::select("select * from   jenisbayar, fpg LEFT OUTER JOIN  subcon on fpg_agen = kode where fpg_jenisbayar = idjenisbayar ");

			}
			array_push($arrfpg, $fpg2);
			$data['jenisbayar'][] = $jenisbayar;
		}*/


		//dd($arrfpg);
		return view('purchase/formfpg/index' , compact('data'));
	}

	public function createformfpg() {

		$data['supplier'] = DB::select("select * from supplier where status = 'SETUJU' and active = 'AKTIF'");
		$data['jenisbayar'] = DB::select("select * from jenisbayar where idjenisbayar != '8'  and idjenisbayar != 10");
		$data['bank'] = DB::select("select * from masterbank");
		$data['agen'] = DB::select("select * from agen where kategori = 'AGEN'");
		$time = Carbon::now();
	//	$newtime = date('Y-M-d H:i:s', $time);  
		
		$year =Carbon::createFromFormat('Y-m-d H:i:s', $time)->year; 
		$month =Carbon::createFromFormat('Y-m-d H:i:s', $time)->month; 

		if($month < 10) {
			$month = '0' . $month;
		}

		$year = substr($year, 2);

		$idfpg =  DB::select("select *  from fpg where fpg_cabang = 'C001' order by idfpg desc Limit 1");
		
	
		//dd(count($idfpg));



		if(count($idfpg) != 0) {
		//	dd($idfpg);
			$idfpg = $idfpg[0]->fpg_nofpg;
		//	dd($idfpg);
			$explode = explode("/", $idfpg);
			$idfpg = $explode[2];

			$string = (int)$idfpg + 1;
			$idfpg = str_pad($string, 3, '0', STR_PAD_LEFT);
		}

		else {
			
			$idfpg = '001';
		}

		//dd($idfpg);

		$data['nofpg'] = 'FPG' . $month . $year . '/' . 'C001' . '/' .  $idfpg;
		//dd($data);
		return view('purchase/formfpg/create', compact('data'));
	}

	public function printformfpg($id){
		

		$fpg = DB::select("select * from fpg, fpg_dt where idfpg ='$id' and fpgdt_idfpg = idfpg");

		$jenisbayar = $fpg[0]->fpg_jenisbayar;
		if($jenisbayar == '2'){
			$data['fpg'] = DB::select("select * from fpg, supplier where idfpg ='$id' and fpg_supplier = idsup");
			$data['fpg_dt'] = DB::select("select * from fpg_dt, fpg, faktur_pembelian where fpgdt_idfpg = idfpg and fpgdt_idfpg = '$id' and fpgdt_idfp = fp_idfaktur");
			$data['fpg_bank'] = DB::select("select * from fpg_cekbank,fpg, masterbank where fpgb_idfpg = idfpg and fpgb_idfpg = '$id' and fpgb_kodebank = mb_id");
			$data['katauang'] = $this->terbilang($data['fpg'][0]->fpg_totalbayar,$style=3);	
		}
		else if($jenisbayar == '5'){
			$data['fpg'] = DB::select("select * from fpg where idfpg ='$id'");
			$data['fpg_dt'] = DB::select("select * from fpg_dt, fpg, faktur_pembelian where fpgdt_idfpg = idfpg and fpgdt_idfpg = '$id'");
			$data['fpg_bank'] = DB::select("select * from fpg_cekbank,fpg, masterbank where fpgb_idfpg = idfpg and fpgb_idfpg = '$id' and fpgb_kodebank = mb_id");
			$data['katauang'] = $this->terbilang($data['fpg'][0]->fpg_totalbayar,$style=3);	
		}
		else if($jenisbayar == '6' || $jenisbayar == '7' ){
			$data['fpg'] = DB::select("select * from fpg, agen where idfpg ='$id' and fpg_agen = agen.kode");
			$data['fpg_dt'] = DB::select("select * from fpg_dt, fpg, faktur_pembelian where fpgdt_idfpg = idfpg and fpgdt_idfpg = '$id' and fpgdt_idfp = fp_idfaktur");
			$data['fpg_bank'] = DB::select("select * from fpg_cekbank,fpg, masterbank where fpgb_idfpg = idfpg and fpgb_idfpg = '$id' and fpgb_kodebank = mb_id");
			$data['katauang'] = $this->terbilang($data['fpg'][0]->fpg_totalbayar,$style=3);	
		}
		else if($jenisbayar == '4'){ // uang muka


		//	$data['fpg'] = DB::select("select * from fpg, agen where idfpg ='$id' and fpg_agen = agen.kode");
			$fpg2 = DB::select("select * from fpg, d_uangmuka where idfpg = '$id' and fpg_agen = um_supplier");
			$jenissup = $fpg2[0]->um_jenissup;
			$data['jenissup'] = $jenissup;
			if($jenissup == 'supplier'){	
				$data['fpg'] = DB::select("select * from fpg,supplier, masterbank, jenisbayar where idfpg = '$id' and fpg_supplier = idsup and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id");
			}
			else if($jenissup == 'agen'){
				$data['fpg'] = DB::select("select * from fpg,agen, masterbank, jenisbayar where idfpg = '$id' and fpg_agen = kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id");	
			}
			else if($jenissup == 'subcon'){
				$data['fpg'] = DB::select("select * from fpg,subcon, masterbank, jenisbayar where idfpg = '$id' and fpg_agen = kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id");	
			}

			$data['fpg_dt'] = DB::select("select * from fpg_dt, fpg, d_uangmuka where fpgdt_idfpg = idfpg and fpgdt_idfpg = '$id' and fpgdt_idfp = um_id");
			$data['fpg_bank'] = DB::select("select * from fpg_cekbank,fpg, masterbank where fpgb_idfpg = idfpg and fpgb_idfpg = '$id' and fpgb_kodebank = mb_id");
			$data['katauang'] = $this->terbilang($data['fpg'][0]->fpg_totalbayar,$style=3);	
		}
		else if($jenisbayar == '3'){ // voucher hutang
			for($i = 0; $i < count($fpg); $i++){
				$idfp = $fpg[$i]->fpgdt_idfp;
			$data['fpg'] = DB::select("select * from fpg, v_hutang, fpg_dt, supplier where idfpg ='$id' and fpg_supplier = v_supplier and fpgdt_idfp = v_id and fpgdt_idfpg = idfpg and v_supplier = idsup");


			}
	//		$data['fpg'] = DB::select("select * from fpg, v_hutang where idfpg ='$id' and fpg_supplier = v_supplier");
			$data['fpg_dt'] = DB::select("select * from fpg_dt, fpg, v_hutang where fpgdt_idfpg = idfpg and fpgdt_idfpg = '$id' and fpgdt_idfp = v_id");
			$data['fpg_bank'] = DB::select("select * from fpg_cekbank,fpg, masterbank where fpgb_idfpg = idfpg and fpgb_idfpg = '$id' and fpgb_kodebank = mb_id");
			$data['katauang'] = $this->terbilang($data['fpg'][0]->fpg_totalbayar,$style=3);	
		}
		else if($jenisbayar == '9'){
			$data['fpg'] = DB::select("select * from fpg, subcon where idfpg ='$id' and fpg_agen = subcon.kode");
			$data['fpg_dt'] = DB::select("select * from fpg_dt, fpg, faktur_pembelian where fpgdt_idfpg = idfpg and fpgdt_idfpg = '$id' and fpgdt_idfp = fp_idfaktur");
			$data['fpg_bank'] = DB::select("select * from fpg_cekbank,fpg, masterbank where fpgb_idfpg = idfpg and fpgb_idfpg = '$id' and fpgb_kodebank = mb_id");
			$data['katauang'] = $this->terbilang($data['fpg'][0]->fpg_totalbayar,$style=3);	
		}
		else if($jenisbayar == '1'){
			$data['fpg'] = DB::select("select * from fpg, ikhtisar_kas, cabang where idfpg ='$id' and fpg_agen = cabang.kode");
			$data['fpg_dt'] = DB::select("select * from fpg_dt, fpg, faktur_pembelian where fpgdt_idfpg = idfpg and fpgdt_idfpg = '$id' and fpgdt_idfp = fp_idfaktur");
			$data['fpg_bank'] = DB::select("select * from fpg_cekbank,fpg, masterbank where fpgb_idfpg = idfpg and fpgb_idfpg = '$id' and fpgb_kodebank = mb_id");
			$data['katauang'] = $this->terbilang($data['fpg'][0]->fpg_totalbayar,$style=3);	
		}
		
		//dd($data);
		return view('purchase/formfpg/fpg', compact('data'));
	}

	public function changesupplier(Request $request){
		
	
			$idsup = $request->idsup;
			$idjenisbayar = $request->idjenisbayar;

			if($idjenisbayar == '2' ){
				$data['fakturpembelian'] = DB::select("select * from faktur_pembelian, supplier, form_tt , cabang where fp_idsup ='$idsup' and fp_tipe != 'NS' and fp_tipe != 'S' and fp_jenisbayar = '$idjenisbayar' and fp_idsup = idsup and fp_idtt = tt_idform and fp_comp = kode and fp_sisapelunasan != '0.00'");
				
			}
			else if($idjenisbayar == '6' || $idjenisbayar == '7'  ){
				$data['fakturpembelian'] = DB::select("select fp_jatuhtempo, fp_idfaktur, fp_nofaktur, cabang.nama as namacabang, fp_noinvoice, agen.nama as namaoutlet , fp_sisapelunasan from  agen , cabang, faktur_pembelian LEFT OUTER JOIN form_tt on fp_nofaktur = tt_nofp where  fp_jenisbayar = '$idjenisbayar'  and fp_comp = cabang.kode and fp_sisapelunasan != '0.00' and fp_supplier = '$idsup' and fp_supplier = agen.kode and fp_pending_status = 'APPROVED'" );
			}
			else if($idjenisbayar == '9'){
				$data['fakturpembelian'] = DB::select("select fp_jatuhtempo, fp_idfaktur, fp_nofaktur, cabang.nama as namacabang, fp_noinvoice, subcon.nama as namavendor , fp_sisapelunasan from  subcon , cabang, faktur_pembelian LEFT OUTER JOIN form_tt on fp_nofaktur = tt_nofp where  fp_jenisbayar = '$idjenisbayar'  and fp_comp = cabang.kode and fp_sisapelunasan != '0.00' and fp_supplier = '$idsup' and fp_supplier = subcon.kode and fp_pending_status = 'APPROVED'" );
			}
			else if($idjenisbayar == '3'){
				$data['fakturpembelian'] = DB::select("select * from v_hutang, cabang, supplier where v_supplier = '$idsup' and vc_comp = kode and v_supplier = idsup and v_pelunasan != '0.00' ");
				
			}
			else if($idjenisbayar == '4'){ //uang muka pembelian
				$data['fakturpembelian'] = DB::select("select * from d_uangmuka, cabang where  um_supplier = '$idsup' and um_comp = kode");
			}
			else if($idjenisbayar == '1'){ //GIRO KAS KECIL
				$data['fakturpembelian'] = DB::select("select * from ikhtisar_kas, cabang where  ik_comp = '$idsup' and ik_comp = kode");
			}



			
		return json_encode($data);
	}

	public function getfaktur(Request $request){

		$idfp = $request->idfp;
		$nofaktur2 = $request->nofaktur;
		$jenisbayar = $request->jenisbayar;
		if($jenisbayar == '2' ){
			$idfp = $request->idfp;
			for($i = 0; $i < count($idfp); $i++){
				$idfp1 = $idfp[$i];		
				$nofaktur = $request->nofaktur2[$i];

				$data['faktur'][] = DB::select("select * from faktur_pembelian, form_tt where fp_idfaktur = '$idfp1' and fp_idtt = tt_idform ");
				$data['pembayaran'][] = DB::select("select fpg_nofpg as nofpg, fpg_tgl as tgl, fpgdt_pelunasan as pelunasan, fp_nofaktur as nofaktur, fp_idfaktur as idfp from fpg,fpg_dt, faktur_pembelian where fpgdt_idfp ='$idfp1' and fpgdt_idfpg = idfpg and fpgdt_idfp = fp_idfaktur and fpgdt_nofaktur = fp_nofaktur union select bkk_nota as nofpg, bkk_tgl as tgl, bkkd_total as pelunasan, bkkd_ref as nofaktur, fp_idfaktur as idfp from bukti_kas_keluar, bukti_kas_keluar_detail, faktur_pembelian where bkkd_bkk_id = bkk_id and bkkd_ref = '$nofaktur' and bkkd_ref = fp_nofaktur");
			}


			$data['perhitunganfaktur'] = array();
				$perhitunganfaktur = 0;

			for($kz = 0; $kz < count($data['pembayaran']); $kz++){

				if(count($data['pembayaran'][$kz]) == 0){
						$perhitunganfaktur = "0.00";
				}
				else {
					for($kf = 0; $kf < count($data['pembayaran'][$kz]); $kf++){
						$pelunasanfaktur = $data['pembayaran'][$kz][$kf]->pelunasan;
						$perhitunganfaktur = $perhitunganfaktur + (float)$pelunasanfaktur;
											
					}

				}
				array_push($data['perhitunganfaktur'], $perhitunganfaktur);
			}
		}
		else if ($jenisbayar == '3'){
			for($z = 0 ; $z < count($idfp); $z++){
				$idfp1 = $idfp[$z];		
				$nofaktur = $request->nofaktur2[$z];

				$data['faktur'][] = DB::select("select * from v_hutang where v_id = '$idfp1' ");
				$data['pembayaran'][] = DB::select("select fpg_nofpg as nofpg, fpg_tgl as tgl, fpgdt_pelunasan as pelunasan, v_nomorbukti as nofaktur, v_id as idfp from fpg,fpg_dt, v_hutang where fpgdt_idfp ='$idfp1' and fpgdt_idfpg = idfpg and fpgdt_idfp = v_id and fpgdt_nofaktur = v_nomorbukti union select bkk_nota as nofpg, bkk_tgl as tgl, bkkd_total as pelunasan, bkkd_ref as nofaktur, v_id as idfp from bukti_kas_keluar, bukti_kas_keluar_detail, v_hutang where bkkd_bkk_id = bkk_id and bkkd_ref = '$nofaktur' and bkkd_ref = v_nomorbukti");
			}

				$data['perhitunganfaktur'] = array();
				$perhitunganfaktur = 0;

			for($kz = 0; $kz < count($data['pembayaran']); $kz++){

				if(count($data['pembayaran'][$kz]) == 0){
						$perhitunganfaktur = "0.00";
				}
				else {
					for($kf = 0; $kf < count($data['pembayaran'][$kz]); $kf++){
						$pelunasanfaktur = $data['pembayaran'][$kz][$kf]->pelunasan;
						$perhitunganfaktur = $perhitunganfaktur + (float)$pelunasanfaktur;
											
					}

				}
				array_push($data['perhitunganfaktur'], $perhitunganfaktur);
			}
		}
		else if($jenisbayar == '6' || $jenisbayar == '7' || $jenisbayar == '9'){
			$idfp = $request->idfp;
			for($i = 0; $i < count($idfp); $i++){
				$idfp1 = $idfp[$i];		
				$nofaktur = $request->nofaktur2[$i];

				$data['faktur'][] = DB::select("select * from faktur_pembelian where fp_idfaktur = '$idfp1'");
				$data['pembayaran'][] = DB::select("select fpg_nofpg as nofpg, fpg_tgl as tgl, fpgdt_pelunasan as pelunasan, fp_nofaktur as nofaktur, fp_idfaktur as idfp from fpg,fpg_dt, faktur_pembelian where fpgdt_idfp ='$idfp1' and fpgdt_idfpg = idfpg and fpgdt_idfp = fp_idfaktur and fpgdt_nofaktur = fp_nofaktur union select bkk_nota as nofpg, bkk_tgl as tgl, bkkd_total as pelunasan, bkkd_ref as nofaktur, fp_idfaktur as idfp from bukti_kas_keluar, bukti_kas_keluar_detail, faktur_pembelian where bkkd_bkk_id = bkk_id and bkkd_ref = '$nofaktur' and bkkd_ref = fp_nofaktur");
			}


			$data['perhitunganfaktur'] = array();
				$perhitunganfaktur = 0;

			for($kz = 0; $kz < count($data['pembayaran']); $kz++){

				if(count($data['pembayaran'][$kz]) == 0){
						$perhitunganfaktur = "0.00";
				}
				else {
					for($kf = 0; $kf < count($data['pembayaran'][$kz]); $kf++){
						$pelunasanfaktur = $data['pembayaran'][$kz][$kf]->pelunasan;
						$perhitunganfaktur = $perhitunganfaktur + (float)$pelunasanfaktur;
											
					}

				}
				array_push($data['perhitunganfaktur'], $perhitunganfaktur);
			}
		}
		
		else if($jenisbayar == '4'){
			$idfp = $request->idfp;
			for($i = 0; $i < count($idfp); $i++){
				$idfp1 = $idfp[$i];		
				$nofaktur = $request->nofaktur2[$i];

				$data['faktur'][] = DB::select("select * from d_uangmuka where um_id = '$idfp1'");
				$data['pembayaran'][] = DB::select("select fpg_nofpg as nofpg, fpg_tgl as tgl, fpgdt_pelunasan as pelunasan, fp_nofaktur as nofaktur, fp_idfaktur as idfp from fpg,fpg_dt, faktur_pembelian where fpgdt_idfp ='$idfp1' and fpgdt_idfpg = idfpg and fpgdt_idfp = fp_idfaktur and fpgdt_nofaktur = fp_nofaktur union select bkk_nota as nofpg, bkk_tgl as tgl, bkkd_total as pelunasan, bkkd_ref as nofaktur, fp_idfaktur as idfp from bukti_kas_keluar, bukti_kas_keluar_detail, faktur_pembelian where bkkd_bkk_id = bkk_id and bkkd_ref = '$nofaktur' and bkkd_ref = fp_nofaktur");
			}


			$data['perhitunganfaktur'] = array();
				$perhitunganfaktur = 0;

			for($kz = 0; $kz < count($data['pembayaran']); $kz++){

				if(count($data['pembayaran'][$kz]) == 0){
						$perhitunganfaktur = "0.00";
				}
				else {
					for($kf = 0; $kf < count($data['pembayaran'][$kz]); $kf++){
						$pelunasanfaktur = $data['pembayaran'][$kz][$kf]->pelunasan;
						$perhitunganfaktur = $perhitunganfaktur + (float)$pelunasanfaktur;
											
					}

				}
				array_push($data['perhitunganfaktur'], $perhitunganfaktur);
			}
		}

		else if($jenisbayar == '1'){
			$idfp = $request->idfp;
			for($i = 0; $i < count($idfp); $i++){
				$idfp1 = $idfp[$i];		
				$nofaktur = $request->nofaktur2[$i];

				$data['faktur'][] = DB::select("select * from ikhtisar_kas where ik_id = '$idfp1'");
				$data['pembayaran'][] = DB::select("select fpg_nofpg as nofpg, fpg_tgl as tgl, fpgdt_pelunasan as pelunasan, fp_nofaktur as nofaktur, fp_idfaktur as idfp from fpg,fpg_dt, faktur_pembelian where fpgdt_idfp ='$idfp1' and fpgdt_idfpg = idfpg and fpgdt_idfp = fp_idfaktur and fpgdt_nofaktur = fp_nofaktur union select bkk_nota as nofpg, bkk_tgl as tgl, bkkd_total as pelunasan, bkkd_ref as nofaktur, fp_idfaktur as idfp from bukti_kas_keluar, bukti_kas_keluar_detail, faktur_pembelian where bkkd_bkk_id = bkk_id and bkkd_ref = '$nofaktur' and bkkd_ref = fp_nofaktur");
			}


			$data['perhitunganfaktur'] = array();
				$perhitunganfaktur = 0;

			for($kz = 0; $kz < count($data['pembayaran']); $kz++){

				if(count($data['pembayaran'][$kz]) == 0){
						$perhitunganfaktur = "0.00";
				}
				else {
					for($kf = 0; $kf < count($data['pembayaran'][$kz]); $kf++){
						$pelunasanfaktur = $data['pembayaran'][$kz][$kf]->pelunasan;
						$perhitunganfaktur = $perhitunganfaktur + (float)$pelunasanfaktur;
											
					}

				}
				array_push($data['perhitunganfaktur'], $perhitunganfaktur);
			}
		}

		return json_encode($data);
	}


	public function getkodeakun(Request $request){
		$id= $request->id;
		$data['table'] = DB::select("select * from masterbank,masterbank_dt where mbdt_idmb = mb_id and mb_id = '$id'");

		return json_encode($data);
	}


	public function getakunbg(Request $request){
		$mbid = $request->idmb;

		for($i = 0; $i < count($mbid); $i++){
			$mbid2 = $mbid[$i];		
			$data['mbdt'][] = DB::select("select * from masterbank,masterbank_dt where mbdt_idmb = mb_id and mbdt_id = '$mbid2' ");

		}
		return json_encode($data);
	}

	public function getjenisbayar(Request $request){
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

	public function detailformfpg($id) {

		$fpg = DB::select("select * from fpg where idfpg = '$id'");
		$jenisbayar = $fpg[0]->fpg_jenisbayar;
		$data['jenisbayar'] = $fpg[0]->fpg_jenisbayar;
		if($jenisbayar == '4'){
			$fpg2 = DB::select("select * from fpg, d_uangmuka where idfpg = '$id' and fpg_agen = um_supplier");
			$jenissup = $fpg2[0]->um_jenissup;
			$data['jenissup'] = $jenissup;
			if($jenissup == 'supplier'){
				$data['fpg'] = DB::select("select * from fpg,supplier, masterbank, jenisbayar where idfpg = '$id' and fpg_supplier = idsup and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id");
			}
			else if($jenissup == 'agen'){
				$data['fpg'] = DB::select("select * from fpg,agen, masterbank, jenisbayar where idfpg = '$id' and fpg_agen = kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id");	
			}
			else if($jenissup == 'subcon'){
				$data['fpg'] = DB::select("select * from fpg,subcon, masterbank, jenisbayar where idfpg = '$id' and fpg_agen = kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id");	
			}
			

		}
		else if($jenisbayar == '2'){
			$data['fpg'] = DB::select("select * from fpg,supplier, masterbank, jenisbayar where idfpg = '$id' and fpg_supplier = idsup and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id");	
		}
		else if($jenisbayar == '6' || $jenisbayar == '7'){
			$data['fpg'] = DB::select("select * from fpg,agen, masterbank, jenisbayar where idfpg = '$id' and fpg_agen = kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id");	
		}

		else if($jenisbayar == '9'){
			$data['fpg'] = DB::select("select * from fpg,subcon, masterbank, jenisbayar where idfpg = '$id' and fpg_agen = kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id");	
		}
		else if($jenisbayar == '1'){
			$data['fpg'] = DB::select("select * from fpg,cabang, masterbank, jenisbayar where idfpg = '$id' and fpg_agen = kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id");
		}

		$jenisbayar = $data['fpg'][0]->fpg_jenisbayar;
		//dd($data['fpg']);
		if($jenisbayar == '2' || $jenisbayar == '6' || $jenisbayar == '7' || $jenisbayar == '9' ) {


		$data['fpgd'] = DB::select("select * from  fpg_dt, fpg , faktur_pembelian where idfpg = '$id' and fpgdt_idfpg = idfpg and fpgdt_idfp = fp_idfaktur");

		for($i = 0 ; $i < count($data['fpgd']); $i++){
			$idfp = $data['fpgd'][$i]->fpgdt_idfp;
			$nofaktur = $data['fpgd'][$i]->fp_nofaktur;

			$data['pembayaran'][] = DB::select("select fpg_nofpg as nofpg, fpg_tgl as tgl, fpgdt_pelunasan as pelunasan, fp_nofaktur as nofaktur, fp_idfaktur as idfp from fpg,fpg_dt, faktur_pembelian where fpgdt_idfp ='$idfp' and fpgdt_idfpg = idfpg and fpgdt_idfp = fp_idfaktur and fpgdt_nofaktur = fp_nofaktur union select bkk_nota as nofpg, bkk_tgl as tgl, bkkd_total as pelunasan, bkkd_ref as nofaktur, fp_idfaktur as idfp from bukti_kas_keluar, bukti_kas_keluar_detail, faktur_pembelian where bkkd_bkk_id = bkk_id and bkkd_ref = '$nofaktur' and bkkd_ref = fp_nofaktur");

		}

		
		$data['perhitungan'] = array();
		for($m = 0; $m < count($data['pembayaran']) ; $m++){
			$perhitunganfp = 0;
			for($f = 0; $f < count($data['pembayaran'][$m]); $f++){
				$pelunasanfp = $data['pembayaran'][$m][$f]->pelunasan;
				$perhitunganfp = $perhitunganfp + (float)$pelunasanfp;

			}
			array_push($data['perhitungan'], $perhitunganfp);
		}

		$data['fpg_bank'] = DB::select("select * from  fpg_cekbank, fpg, masterbank  where idfpg = '$id' and fpgb_idfpg = idfpg and fpgb_kodebank = mb_id");
		$data['bank'] = DB::select("select * from masterbank");
		$data['supplier'] = DB::select("select * from supplier");

		}
		else if($jenisbayar == 3){
			$data['fpgd'] = DB::select("select * from  fpg_dt, fpg , v_hutang where idfpg = '$id' and fpgdt_idfpg = idfpg and fpgdt_idfp = v_id");

			for($i = 0 ; $i < count($data['fpgd']); $i++){
				$idfp1 = $data['fpgd'][$i]->fpgdt_idfp;
				$nofaktur = $data['fpgd'][$i]->v_nomorbukti;

				$data['pembayaran'][] = DB::select("select fpg_nofpg as nofpg, fpg_tgl as tgl, fpgdt_pelunasan as pelunasan, v_nomorbukti as nofaktur, v_id as idfp from fpg,fpg_dt, v_hutang where fpgdt_idfp ='$idfp1' and fpgdt_idfpg = idfpg and fpgdt_idfp = v_id and fpgdt_nofaktur = v_nomorbukti union select bkk_nota as nofpg, bkk_tgl as tgl, bkkd_total as pelunasan, bkkd_ref as nofaktur, v_id as idfp from bukti_kas_keluar, bukti_kas_keluar_detail, v_hutang where bkkd_bkk_id = bkk_id and bkkd_ref = '$nofaktur' and bkkd_ref = v_nomorbukti");

			}

			
			$data['perhitungan'] = array();
			for($m = 0; $m < count($data['pembayaran']) ; $m++){
				$perhitunganfp = 0;
				for($f = 0; $f < count($data['pembayaran'][$m]); $f++){
					$pelunasanfp = $data['pembayaran'][$m][$f]->pelunasan;
					$perhitunganfp = $perhitunganfp + (float)$pelunasanfp;

				}
				array_push($data['perhitungan'], $perhitunganfp);
			}

			$data['fpg_bank'] = DB::select("select * from  fpg_cekbank, fpg, masterbank  where idfpg = '$id' and fpgb_idfpg = idfpg and fpgb_kodebank = mb_id");
			$data['bank'] = DB::select("select * from masterbank");
			$data['supplier'] = DB::select("select * from supplier");
		}
		else if($jenisbayar == 1){
			$data['fpgd'] = DB::select("select * from  fpg_dt, fpg , ikhtisar_kas where idfpg = '$id' and fpgdt_idfpg = idfpg and fpgdt_idfp = ik_id");

			for($i = 0 ; $i < count($data['fpgd']); $i++){
				$idfp1 = $data['fpgd'][$i]->fpgdt_idfp;
				$nofaktur = $data['fpgd'][$i]->ik_nota;

				$data['pembayaran'][] = DB::select("select fpg_nofpg as nofpg, fpg_tgl as tgl, fpgdt_pelunasan as pelunasan, v_nomorbukti as nofaktur, v_id as idfp from fpg,fpg_dt, v_hutang where fpgdt_idfp ='$idfp1' and fpgdt_idfpg = idfpg and fpgdt_idfp = v_id and fpgdt_nofaktur = v_nomorbukti union select bkk_nota as nofpg, bkk_tgl as tgl, bkkd_total as pelunasan, bkkd_ref as nofaktur, v_id as idfp from bukti_kas_keluar, bukti_kas_keluar_detail, v_hutang where bkkd_bkk_id = bkk_id and bkkd_ref = '$nofaktur' and bkkd_ref = v_nomorbukti");

			}

			
			$data['perhitungan'] = array();
			for($m = 0; $m < count($data['pembayaran']) ; $m++){
				$perhitunganfp = 0;
				for($f = 0; $f < count($data['pembayaran'][$m]); $f++){
					$pelunasanfp = $data['pembayaran'][$m][$f]->pelunasan;
					$perhitunganfp = $perhitunganfp + (float)$pelunasanfp;

				}
				array_push($data['perhitungan'], $perhitunganfp);
			}

			$data['fpg_bank'] = DB::select("select * from  fpg_cekbank, fpg, masterbank  where idfpg = '$id' and fpgb_idfpg = idfpg and fpgb_kodebank = mb_id");
			$data['bank'] = DB::select("select * from masterbank");
			$data['supplier'] = DB::select("select * from supplier");
		}
		else if($jenisbayar == 4){
			$data['fpgd'] = DB::select("select * from  fpg_dt, fpg , d_uangmuka where idfpg = '$id' and fpgdt_idfpg = idfpg and fpgdt_idfp = um_id");

			for($i = 0 ; $i < count($data['fpgd']); $i++){
				$idfp1 = $data['fpgd'][$i]->fpgdt_idfp;
				$nofaktur = $data['fpgd'][$i]->um_nomorbukti;

				$data['pembayaran'][] = DB::select("select fpg_nofpg as nofpg, fpg_tgl as tgl, fpgdt_pelunasan as pelunasan, v_nomorbukti as nofaktur, v_id as idfp from fpg,fpg_dt, v_hutang where fpgdt_idfp ='$idfp1' and fpgdt_idfpg = idfpg and fpgdt_idfp = v_id and fpgdt_nofaktur = v_nomorbukti union select bkk_nota as nofpg, bkk_tgl as tgl, bkkd_total as pelunasan, bkkd_ref as nofaktur, v_id as idfp from bukti_kas_keluar, bukti_kas_keluar_detail, v_hutang where bkkd_bkk_id = bkk_id and bkkd_ref = '$nofaktur' and bkkd_ref = v_nomorbukti");

			}

			
			$data['perhitungan'] = array();
			for($m = 0; $m < count($data['pembayaran']) ; $m++){
				$perhitunganfp = 0;
				for($f = 0; $f < count($data['pembayaran'][$m]); $f++){
					$pelunasanfp = $data['pembayaran'][$m][$f]->pelunasan;
					$perhitunganfp = $perhitunganfp + (float)$pelunasanfp;

				}
				array_push($data['perhitungan'], $perhitunganfp);
			}

			$data['fpg_bank'] = DB::select("select * from  fpg_cekbank, fpg, masterbank  where idfpg = '$id' and fpgb_idfpg = idfpg and fpgb_kodebank = mb_id");
			$data['bank'] = DB::select("select * from masterbank");
			$data['supplier'] = DB::select("select * from supplier");
		}
		//dd($data);
		return view('purchase/formfpg/detail', compact('data'));
	}


	public function saveformfpg(Request $request){
	
		$time = Carbon::now();
	//	$idbank = $request->idbank;
		$formfpg = new formfpg();

		$explode = explode(",", $request->selectOutlet);
		$idbank = $explode[0];
		//	dd($nosppid);

		$cabang = 'C001';
		$lastid =  formfpg::where('fpg_cabang' , $cabang)->max('idfpg');;
		if(isset($lastid)) {
				$idfpg = $lastid;
				$idfpg = (int)$idfpg + 1;
		}
		else {
				$idfpg = 1;
		} 

		$cekbg = str_replace(',', '', $request->cekbg);
		$totalbayar = str_replace(',', '', $request->totalbayar);

		$formfpg->idfpg = $idfpg;
		$formfpg->fpg_tgl = $request->tglfpg;
		$formfpg->fpg_jenisbayar = $request->jenisbayar;
		$formfpg->fpg_totalbayar = $totalbayar;
	//	$formfpg->fpg_uangmuka = $request->uangmuka;
		$formfpg->fpg_cekbg = $cekbg;
		$formfpg->fpg_nofpg = $request->nofpg;
		$formfpg->fpg_keterangan = $request->keterangan;

		if($request->jenisbayar == 5) {
			$formfpg->fpg_orang = $request->keterangantransfer;
		}
		else if($request->jenisbayar == 2) {
			$formfpg->fpg_supplier = $request->kodebayar;
		}
		else if($request->jenisbayar == 6 || $request->jenisbayar== 7 || $request->jenisbayar == 9 || $request->jenisbayar == 4 || $request->jenisbayar == 1){
			$formfpg->fpg_agen = $request->kodebayar;
		}
		
		$formfpg->fpg_cabang = 'C001';

		//KODE BANK
		
		$formfpg->fpg_idbank = $idbank; 
		$formfpg->acc_supplier = $request->hutangdagang;


		$formfpg->save();

		if($request->jenisbayar != 5){

	//	return count($request->nofaktur) . count($request->noseri);
		//SIMPAN FAKTUR
		for($i = 0 ; $i < count($request->nofaktur); $i++ ){
			$formfpg_dt = new formfpg_dt();

			$nofa = $request->nofaktur[$i];
			$lastidfpg =  formfpg_dt::max('fpgdt_id');;
			if(isset($lastidfpg)) {
					$idfpg_dt = $lastidfpg;
					$idfpg_dt = (int)$idfpg_dt + 1;
			}
			else {
					$idfpg_dt = 1;
			} 

				$netto = str_replace(',', '', $request->netto[$i]);
				$pelunasan = str_replace(',', '', $request->pelunasan[$i]);
				$sisafaktur = str_replace(',', '', $request->sisapelunasan[$i]);

			$formfpg_dt->fpgdt_idfpg = $idfpg;
			$formfpg_dt->fpgdt_id = $idfpg_dt;
			$formfpg_dt->fpgdt_idfp = $request->idfaktur[$i];
			$formfpg_dt->fpgdt_tgl = $request->tglfpg;
			if($request->jenisbayar != '7') {
				$formfpg_dt->fpgdt_jatuhtempo = $request->jatuhtempo[$i];
			}
			$formfpg_dt->fpgdt_jumlahtotal = $netto;
			$formfpg_dt->fpgdt_pelunasan = $pelunasan;
			$formfpg_dt->fpgdt_sisafaktur = $sisafaktur;
			$formfpg_dt->fpgdt_keterangan = $request->fpgdt_keterangan[$i];
			$formfpg_dt->fpgdt_nofaktur = $request->nofaktur[$i];
			$formfpg_dt->save();


			if($request->jenisbayar == 2 || $request->jenisbayar == 7 || $request->jenisbayar == 6  || $request->jenisbayar == 9) {
				$updatefaktur = fakturpembelian::where('fp_nofaktur', '=', $request->nofaktur[$i]);
				$updatefaktur->update([
				 	'fp_sisapelunasan' => $sisafaktur,	 	
			 	]);	
			}
			else if($request->jenisbayar == 3) { // VOUCHER HUTANG
				$updatevoucher = v_hutang::where('v_nomorbukti', '=', $request->nofaktur[$i]);
				$updatevoucher->update([
				 	'v_pelunasan' => $sisafaktur,	 	
			 	]);	
			}

			else if($request->jenisbayar == 1){
				$updatikhtisar = ikhtisar_kas::where('ik_nota' , '=' , $request->nofaktur[$i]);
				$updatikhtisar->update([
				 	'ik_pelunasan' => $sisafaktur,	 	
			 	]);	
			}

					 				 
		}
	}
		//SIMPAN CHECK
		for($j=0; $j < count($request->noseri); $j++){
			$formfpg_bank = new formfpg_bank();

			$lastidfpg_bank =  formfpg_bank::max('fpgb_id');;
			if(isset($lastidfpg_bank)) {
					$idfpg_bank = $lastidfpg_bank;
					$idfpg_bank = (int)$idfpg_bank + 1;
			}
			else {
					$idfpg_bank = 1;
			} 


		
			$nominalbank =  str_replace(',', '', $request->nominalbank[$j]);

			$formfpg_bank->fpgb_idfpg = $idfpg;
			$formfpg_bank->fpgb_id = $idfpg_bank;
			$formfpg_bank->fpgb_kodebank = $idbank;
			$formfpg_bank->fpgb_jenisbayarbank = $request->jenisbayarbank;
			$formfpg_bank->fpgb_nocheckbg = $request->noseri[$j];

			if($request->jenisbayar != 7){
				$formfpg_bank->fpgb_jatuhtempo = $request->jatuhtempo[0];
				$formfpg_bank->fpgb_hari = $request->jatuhtempo[0];

			}
			$formfpg_bank->fpgb_nominal = $nominalbank;
			$formfpg_bank->fpgb_cair = 'IYA';
			$formfpg_bank->fpgb_setuju = 'SETUJU';
			$formfpg_bank->save();


			$updatebank = masterbank_dt::where([['mbdt_idmb', '=', $idbank], ['mbdt_noseri' , '=' ,$request->noseri[$j]]]);

			$updatebank->update([
			 	'mbdt_nofpg' =>  $request->nofpg,
			 	'mbdt_setuju' => 'Y',
			 	'mbdt_status' => 'C',
			 	'mbdt_nominal' => $nominalbank,
			 	'mbdt_tglstatus' => $time
		 	]);			 		 
		}

		$nofpg = $request->nofpg;
		
		$nofpg = $request->nofpg;
		$data['isfpg'] = DB::select("select * from fpg where fpg_nofpg = '$nofpg'");
		return json_encode($data);
	}


	public function getfpg(){
		$nofpg = $request->nofpg;
		$data['isfpg'] = DB::select("select * from fpg where fpg_nofpg = '$nofpg'");
		return json_encode($data);
	}

	public function updateformfpg(Request $request){
		$time = Carbon::now();
		$idfpg = $request->idfpg;
		$totalbayar =  str_replace(',', '', $request->totalbayar);
		$cekbg =  str_replace(',', '', $request->cekbg);
		$updatefpg = formfpg::where('idfpg', '=', $request->idfpg);
		$updatefpg->update([
			'fpg_totalbayar' => $totalbayar,
			'fpg_cekbg' => $cekbg
			]);	

	
		for($j=0;$j<count($request->nofaktur);$j++){
			$idfp = $request->idfaktur[$j];
			$cekidfp = DB::select("select * from fpg_dt where fpgdt_idfp = '$idfp' and fpgdt_idfpg = '$idfpg'");

				if(count($cekidfp) > 0){
					$pelunasan = str_replace(',', '', $request->pelunasan[$j]);
					$sisafaktur = str_replace(',', '', $request->sisapelunasan[$j]);

					$updatefpgdt = formfpg_dt::where([['fpgdt_idfpg', '=', $idfpg], ['fpgdt_idfp', '=' , $idfp]]);
					$updatefpgdt->update([
						'fpgdt_pelunasan' => $pelunasan,
						'fpgdt_sisafaktur' =>$sisafaktur
						]);

					$updatefaktur = fakturpembelian::where('fp_idfaktur', '=' , $idfp);
					$updatefaktur->update([
						'fp_sisapelunasan' => $sisafaktur
						]);
				}
				else {
				$formfpg_dt = new formfpg_dt();

				$lastidfpg =  formfpg_dt::max('fpgdt_id');;
				if(isset($lastidfpg)) {
						$idfpg_dt = $lastidfpg;
						$idfpg_dt = (int)$idfpg_dt + 1;
				}
				else {
						$idfpg_dt = 1;
				} 

					$netto = str_replace(',', '', $request->netto[$j]);
					$pelunasan = str_replace(',', '', $request->pelunasan[$j]);
					$sisafaktur = str_replace(',', '', $request->sisapelunasan[$j]);

				$formfpg_dt->fpgdt_idfpg = $idfpg;
				$formfpg_dt->fpgdt_id = $idfpg_dt;
				$formfpg_dt->fpgdt_idfp = $request->idfaktur[$j];
				$formfpg_dt->fpgdt_tgl = $request->tglfpg;
				$formfpg_dt->fpgdt_jatuhtempo = $request->jatuhtempo[$j];
				$formfpg_dt->fpgdt_jumlahtotal = $netto;
				$formfpg_dt->fpgdt_pelunasan = $pelunasan;
				$formfpg_dt->fpgdt_sisafaktur = $sisafaktur;
				$formfpg_dt->fpgdt_keterangan = $request->fpgdt_keterangan[$j];
				$formfpg_dt->fpgdt_nofaktur = $request->fpgdt_keterangan[$j];
				$formfpg_dt->save();



				$updatefaktur = fakturpembelian::where('fp_nofaktur', '=', $request->nofaktur[$j]);


				
					$updatefaktur->update([
					 	'fp_sisapelunasan' => $sisafaktur,	 	
				 	]);			 				 
				}
			}

		//SIMPAN CHECK
		for($j=0; $j < count($request->noseri); $j++){
			$formfpg_bank = new formfpg_bank();

			$lastidfpg_bank =  formfpg_bank::max('fpgb_id');;
			if(isset($lastidfpg_bank)) {
					$idfpg_bank = $lastidfpg_bank;
					$idfpg_bank = (int)$idfpg_bank + 1;
			}
			else {
					$idfpg_bank = 1;
			} 


			$idbank = $request->idbank;
			$noseri = $request->noseri[$j];
			$cekidbank = DB::select("select * from fpg_cekbank where fpgb_kodebank = '$idbank' and fpgb_nocheckbg = '$noseri' and fpgb_idfpg = '$idfpg'");
			$nominalbank =  str_replace(',', '', $request->nominalbank[$j]);
			if(count($cekidbank) > 0){

				
				if($request->valrusak[$j] == 'rusak'){
					
					$updatefpgb = formfpg_bank::where([['fpgb_kodebank' , '=' ,$idbank],['fpgb_nocheckbg' , '=' , $noseri],['fpgb_idfpg' , '=' , $idfpg]]);

					$updatefpgb->update([
						'fpgb_cair' => 'TIDAK',
						'fpgb_setuju' => 'TIDAK',
						]);
					
					$updatebank = masterbank_dt::where([['mbdt_idmb', '=', $idbank], ['mbdt_noseri' , '=' ,$noseri]]);

					$updatebank->update([
					 	'mbdt_setuju' => 'TIDAK',
					 	'mbdt_status' => 'TIDAK',
					 	'mbdt_tglstatus' => $time
				 	]);		

				}
				else {
					$updatefpgb = formfpg_bank::where([['fpgb_kodebank' , '=' ,$idbank],['fpgb_nocheckbg' , '=' , $noseri],['fpgb_idfpg' , '=' , $idfpg]]);
					$updatefpgb->update([
						'fpgb_jenisbayarbank' => $request->jenisbayarbank,
						'fpgb_nocheckbg' => $noseri,
						'fpgb_nominal' => $nominalbank
						]);

						$idbank = $request->idbank;
						$updatebank = masterbank_dt::where([['mbdt_idmb', '=', $idbank], ['mbdt_noseri' , '=' ,$request->noseri[$j]]]);

						$updatebank->update([
						 	'mbdt_nofpg' =>  $request->nofpg,
						 	'mbdt_setuju' => 'Y',
						 	'mbdt_status' => 'C',
						 	'mbdt_nominal' => $nominalbank,
						 	'mbdt_tglstatus' => $time
					 	]);	

				}


			}
			else {
				$nominalbank =  str_replace(',', '', $request->nominalbank[$j]);
				$formfpg_bank->fpgb_idfpg = $idfpg;
				$formfpg_bank->fpgb_id = $idfpg_bank;
				$formfpg_bank->fpgb_kodebank = $request->idbank;
				$formfpg_bank->fpgb_jenisbayarbank = $request->jenisbayarbank;
				$formfpg_bank->fpgb_nocheckbg = $request->noseri[$j];
				$formfpg_bank->fpgb_jatuhtempo = $request->jatuhtempo[0];
				$formfpg_bank->fpgb_nominal = $nominalbank;
				$formfpg_bank->fpgb_hari = $request->jatuhtempo[0];
				$formfpg_bank->fpgb_cair = 'IYA';
				$formfpg_bank->fpgb_setuju = 'SETUJU';
				$formfpg_bank->save();
					$idbank = $request->idbank;
					$updatebank = masterbank_dt::where([['mbdt_idmb', '=', $idbank], ['mbdt_noseri' , '=' ,$request->noseri[$j]]]);

					$updatebank->update([
					 	'mbdt_nofpg' =>  $request->nofpg,
					 	'mbdt_setuju' => 'Y',
					 	'mbdt_status' => 'C',
					 	'mbdt_nominal' => $nominalbank,
					 	'mbdt_tglstatus' => $time
				 	]);	
			}

				 	
			 
		}

		return json_encode('sukses');
	}


	public function deletedetailformfpg(Request $request){
		//idfpgdt,idfp,pelunasan
		$idfpgdt = $request->idfpgdt;
		$idfp = $request->idfp;
		$pelunasan = $request->pelunasan;

		$pelunasan2 = str_replace(',', '', $pelunasan);
		

		$deletefpgdt = DB::table('fpg_dt')->where('fpgdt_id' , '=' , $idfpgdt)->delete();
		$datafaktur = DB::select("select * from faktur_pembelian where fp_idfaktur = '$idfp'");
		$fp_pelunasan = $datafaktur[0]->fp_sisapelunasan;

		$penjumlahan = (float)$fp_pelunasan + (float)$pelunasan2;
		$updatefaktur = fakturpembelian::where('fp_idfaktur', '=' , $idfp);
				$updatefaktur->update([
					'fp_sisapelunasan' => $penjumlahan
				]);

		return 'ok';
	}


	public function deletedetailbankformfpg(Request $request){
		
		$kodebank = $request->kodebank;
		$noseri = $request->noseri;
		$idfpgb = $request->idfpgb;
		$mbid = $request->mbid;
		$deletefpgb = DB::table('fpg_cekbank')->where('fpgb_id' , '=' , $idfpgb)->delete();
		
		$updatebank1 = masterbank_dt::where([['mbdt_idmb', '=', $mbid], ['mbdt_noseri' , '=' ,$request->noseri]]);

		$updatebank1->update([
			 	'mbdt_nofpg' =>  '',
			 	'mbdt_setuju' => '',
			 	'mbdt_status' => '',
			 	'mbdt_nominal' => '0.00',
			 	'mbdt_tglstatus' => '1999-09-19'
		 	]);	
	}

	public function pelaporanfakturpajakmasukan() {
		$data['supplier'] = DB::select("select * from supplier where status = 'SETUJU'");
		//dd($data);
		return view('purchase/pelaporanpajakmasukan/index' , compact('data'));
	}

	public function createpelaporanfakturpajakmasukan() {
		return view('purchase/pelaporanpajakmasukan/create');
	}

	public function detailpelaporanfakturpajakmasukan() {
		return view('purchase/pelaporanpajakmasukan/detail');
	}

	public function memorialpurchase() {
		return view('purchase/memorialpurchase/index');
	}

	public function creatememorialpurchase() {
		return view('purchase/memorialpurchase/create');
	}

	public function detailmemorialpurchase() {
		return view('purchase/memorialpurchase/detail');
	}

	//funngsi Thoriq
	public function groupJurnal($data) {
	    $groups = array();
	    $key = 0;
	    foreach ($data as $item) {
	        $key = $item['accpersediaan'];
	        if (!array_key_exists($key, $groups)) {
	            $groups[$key] = array(	                
	                'accpersediaan' => $item['accpersediaan'],
	                'subtotal' => $item['subtotal'],

	            );	            
	        } else {
	            $groups[$key]['subtotal'] = $groups[$key]['subtotal'] + $item['subtotal'];				
	        }
	        $key++;
	    }
	    return $groups;
	}
}
