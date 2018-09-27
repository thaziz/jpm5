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
use App\co_purchasedtpemb;
use App\co_purchasetbpemb;
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
use App\bukti_bank_keluar_bgakun;
use App\master_akun;
Use App\d_jurnal;
use App\cndn;
use App\cndn_dt;
Use App\d_jurnal_dt;
Use App\bank_masuk;
use App\fakturpajakmasukan;
use App\uangmukapembelian_fp;
use App\uangmukapembeliandt_fp;
use DB;
Use Carbon\Carbon;
use Session;
use Mail;
use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;
use Auth;
use App\bonsempengajuan;
use Yajra\Datatables\Datatables;

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
       $lokasigudang = [];
      /*	$data2['po'] = DB::table('pembelian_order')
       								  ->join('supplier','supplier.idsup','=','pembelian_order.po_supplier')
       								  ->where('po_id','=',$id)
       								  ->get();*/
     	$data2['po'] = DB::select("select *, pembelian_order.created_at as tglpo from pembelian_order, supplier where po_supplier = idsup and po_id = '$id'");

       	$sup = $data2['po'][0]->po_supplier;
		$data2['supplier'] = DB::select("select * from supplier where active='AKTIF' and idsup = $sup ");
		if($data2['po'][0]->po_tipe != 'J'){
					$data2['podt'] = DB::select("select * from pembelian_orderdt, spp, masteritem, cabang, mastergudang where podt_idpo = '$id' and podt_idspp = spp_id and podt_kodeitem = kode_item and spp_cabang = kode and podt_lokasigudang = mg_id");
		
					for($ds = 0; $ds < count($data2['podt']); $ds++){
							$namagudang = $data2['podt'][$ds]->podt_lokasigudang;
							array_push($lokasigudang , $namagudang);		
						}
						
						
						$idgudang = array_unique($lokasigudang);
						
						for($i = 0 ; $i < count($idgudang); $i++){
							$idgudang2 = $idgudang[$i];
							$data2['gudang'] = DB::select("select * from mastergudang where mg_id = '$idgudang2'");
						}
				}
		else{
					$data2['podt'] = DB::select("select * from pembelian_orderdt, spp, masteritem, cabang where podt_idpo = '$id' and podt_idspp = spp_id and podt_kodeitem = kode_item and spp_cabang = kode");
				}
		
		$data2['spp'] = DB::select("select distinct spp_nospp , spp_keperluan, nama_department , nama , spp_tgldibutuhkan from  pembelian_order , spp, pembelian_orderdt, cabang, masterdepartment where po_id = '$id' and podt_idpo = po_id  and podt_idspp = spp_id and spp_cabang = kode and spp_bagian = kode_department ");
		
		$data['kendaraan'] = DB::select("select distinct podt_kendaraan, nopol from pembelian_orderdt, kendaraan where podt_kendaraan = kendaraan.id and podt_idpo = '$id'");
		

		foreach ($data2['po'] as $key => $value) {
			$a = $value->nama_supplier;
		}
		// return $a;
		foreach ($data2['po'] as $key => $value) {
			$b = $value->telp;
		}
		foreach ($data2['po'] as $key => $value) {
			$c = $value->no_kontrak;
		}
		foreach ($data2['po'] as $key => $value) {
			$d = $value->tglpo;
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
      return view('purchase.purchase.print',compact('data','request','data2','a','b','c','d','e','f','g','h','i','j','k','L','m','n', 'data2'));
    } 
	public function spp_index () {
		$cabang = session::get('cabang');

		if(Auth::user()->punyaAkses('Surat Permintaan Pembelian','all')){
			$data['spp'] = DB::select("select * from spp, masterdepartment, cabang, confirm_order where spp_bagian = kode_department and co_idspp = spp_id and spp_cabang = kode order by spp_id desc");

			$data['belumdiproses'] = DB::table("spp")->where('spp_status' , '=' , 'DITERBITKAN')->count();
			$data['disetujui'] = DB::table("confirm_order")->where('man_keu' , '=' , 'DISETUJUI')->count();
			$data['masukgudang'] = DB::table("spp")->where('spp_status' , '=' , 'MASUK GUDANG')->count();
			$data['selesai'] = DB::table("spp")->where('spp_status' , '=' , 'SELESAI')->count();
			$data['statuskabag'] = DB::table("spp")->where('spp_statuskabag' , '=' , 'BELUM MENGETAHUI')->count();
		}else{
			$data['spp'] = DB::select("select * from spp, masterdepartment, cabang, confirm_order where spp_bagian = kode_department and co_idspp = spp_id and spp_cabang = kode and spp_cabang = '$cabang' order by spp_id desc");

			$data['belumdiproses'] = DB::table("spp")->where('spp_status' , '=' , 'DITERBITKAN')->where('spp_cabang' , '=' , $cabang)->count();
			$data['disetujui'] = DB::table("confirm_order")->where('man_keu' , '=' , 'DISETUJUI')->where('co_cabang' , '=' , $cabang)->count();
			$data['masukgudang'] = DB::table("spp")->where('spp_status' , '=' , 'MASUK GUDANG')->where('spp_cabang' , '=' , $cabang)->count();
			$data['selesai'] = DB::table("spp")->where('spp_status' , '=' , 'SELESAI')->where('spp_cabang' , '=' , $cabang)->count();

			$data['statuskabag'] = DB::table("spp")->where('spp_statuskabag' , '=' , 'BELUM MENGETAHUI')->where('spp_cabang' , '=' , $cabang)->count();
		}

		return view('purchase.spp.index', compact('data'));
	}


	public function spp_indextable (Request $request) {

		  $idjenisbayar='';
  		  $tgl='';
  		  $supplier='';
  		  $nofpg='';
  		  $tgl1=date('Y-m-d',strtotime($request->tanggal1));
  		  $tgl2=date('Y-m-d',strtotime($request->tanggal2));
  		  if($request->tanggal1!='' && $request->tanggal2!=''){  		  	
  		  	$tgl="and spp_tgldibutuhkan >= '$tgl1' AND spp_tgldibutuhkan <= '$tgl2'";
  		  }
  		  if($request->nosupplier!=''){
  		  	$supplier="and fpg_supplier=$request->nosupplier";
  		  }
  		  if($request->idjenisbayar!=''){
  		  	$idjenisbayar="and idjenisbayar=$request->idjenisbayar";
  		  }
  		  if($request->nofpg!=''){
  		  	$nofpg="and spp_nospp='$request->nofpg'";
  		  }

		$data='';

		$cabang = session::get('cabang');

		if(Auth::user()->punyaAkses('Surat Permintaan Pembelian','all')){
			$data= DB::select("select *,'no' as no from spp, masterdepartment, cabang, confirm_order where spp_bagian = kode_department and co_idspp = spp_id and spp_cabang = kode $tgl $nofpg order by spp_id desc");
		}else{
			$data= DB::select("select *,'no' as no from spp, masterdepartment, cabang, confirm_order where spp_bagian = kode_department and co_idspp = spp_id and spp_cabang = kode and spp_cabang = '$cabang' $tgl $nofpg order by spp_id desc");
		}


$data=collect($data);	




return DataTables::of($data)->
			editColumn('spp_tgldibutuhkan', function ($data) {            
            	return date('d-m-Y',strtotime($data->spp_tgldibutuhkan));
            })
            ->addColumn('detailspp', function ($data) {            
            	return  
            	'<a 
            	href='.url('suratpermintaanpembelian/detailspp/'.$data->spp_id.'').'>'.$data->spp_nospp.'</a>';
            })
          
            ->editColumn('spp_status', function ($data) { 

				
                      if($data->spp_status == 'DISETUJUI'){
                         return '<span class="label label-info">  DISETUJUI </a></span>';
                      }
                      elseif($data->spp_status == 'DITERIMA'){
                          return '<span class="label label-warning">  DITERIMA </span>';
                      }
                      elseif($data->spp_status == 'DITOLAK'){
                            return '<span class="label label-danger"> '.$data->spp_status.'</span>';
                      }
                      else {
                            return '<span class="label label-default"> '.$data->spp_status.'</span>';
                      }
                      

            })->editColumn('spp_cabang', function ($data) { 
            	

				$spp_cabang='';

				if($data->spp_status == 'DITERBITKAN'){
                         if(Auth::user()->punyaAkses('Surat Permintaan Pembelian','hapus')){
                           $spp_cabang.='<a href="#" class="btn btn-sm btn-danger" onclick="hapusData('.$data->spp_id.')"> <i class="fa fa-trash-o" aria-hidden="true"></i></a>';
                          }

                         if(Auth::user()->punyaAkses('Surat Permintaan Pembelian' , 'ubah')){
                           $spp_cabang.='<a class="btn btn-sm btn-warning"
                           href='.url('suratpermintaanpembelian/editspp/'.$data->spp_id.'').'>
                           <i class="fa fa-pencil" aria-hidden="true"></i>  </a>';                           
                        }

                }

                if(Auth::user()->punyaAkses('Surat Permintaan Pembelian','print')){
        
					$spp_cabang .='<a class="btn btn-sm btn-success" 
							href='.url('suratpermintaanpembelian/cetakspp/'.$data->spp_id.'').'>
					 <i class="fa fa-print" aria-hidden="true"></i></a>';
					
                }


				return $spp_cabang;


            
            })->addColumn('action', function ($data) {            	
            	$action='';
              	if($data->spp_statuskabag == 'BELUM MENGETAHUI'){
                $action.='<span class="label label-info"> <i class="fa fa-close"> </i> '.$data->spp_statuskabag.'</span>';
               }elseif($data->spp_statuskabag == 'SETUJU'){
                $action.='<span class="label label-info"> <i class="fa fa-check"> </i> '.$data->spp_statuskabag.'</span>';
               }
               return $action;
            })
			->make(true);	




		







	}

	public function spp_indexnotif (Request $request) {

		  $idjenisbayar='';
  		  $tglspp='';
  		  $tglco='';
  		  $supplier='';
  		  $nofpg='';
  		  $tgl1=date('Y-m-d',strtotime($request->tanggal1));
  		  $tgl2=date('Y-m-d',strtotime($request->tanggal2));
  		   if($request->tanggal1!='' && $request->tanggal2!=''){  		  	
  		  	$tglspp="and spp_tgldibutuhkan >= '$tgl1' AND spp_tgldibutuhkan <= '$tgl2'";
  		  	$tglco="and date(created_at) >= '$tgl1' AND date(created_at) <= '$tgl2'";
  		  }
  		  if($request->nosupplier!=''){
  		  	$supplier="and fpg_supplier=$request->nosupplier";
  		  }
  		  if($request->idjenisbayar!=''){
  		  	$idjenisbayar="and idjenisbayar=$request->idjenisbayar";
  		  }
  		  if($request->nofpg!=''){
  		  	$nofpg="and spp_nospp='$request->nofpg'";
  		  }


		$data='';

		$cabang = session::get('cabang');
		
		if(Auth::user()->punyaAkses('Surat Permintaan Pembelian','all')){			
			$data['belumdiproses'] = DB::table("spp")
			->whereRaw("spp_status = 'DITERBITKAN'  $tglspp $nofpg")			
			->count();
			$data['disetujui'] = DB::table("confirm_order")
			->whereRaw("man_keu = 'DISETUJUI'  $tglco")
			->count();						
			$data['masukgudang'] = DB::table("spp")
			->whereRaw("spp_status = 'MASUK GUDANG'  $tglspp $nofpg")
			->count();
			$data['selesai'] = DB::table("spp")
			->whereRaw("spp_status = 'SELESAI'  $tglspp $nofpg")			
			->count();
			$data['statuskabag'] = DB::table("spp")
			->whereRaw("spp_statuskabag = 'BELUM MENGETAHUI'  $tglspp $nofpg")			
			->count();
		}else{
			$data['belumdiproses'] = DB::table("spp")
			     ->whereRaw("spp_cabang='$cabang' and spp_status = 'DITERBITKAN'  $tglspp $nofpg")				
			     ->count();
			$data['disetujui'] = DB::table("confirm_order")
			     ->whereRaw("co_cabang='$cabang' and man_keu = 'DISETUJUI'  $tglco")				
			     ->count();
			$data['masukgudang'] = DB::table("spp")
				->whereRaw("spp_cabang='$cabang' and spp_status = 'MASUK GUDANG'  $tglspp $nofpg")						
			    ->count();
			$data['selesai'] = DB::table("spp")			
			    ->whereRaw("spp_cabang='$cabang' and spp_status = 'SELESAI'  $tglspp $nofpg")						
			    ->count();

			$data['statuskabag'] = DB::table("spp")			
			->whereRaw("spp_cabang='$cabang' and spp_statuskabag = 'BELUM MENGETAHUI'  $tglspp $nofpg")					
			->count();			
		}

	$html='';

   $html.='<div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-danger alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <h2 style="text-align:center"> <b>'.$data['belumdiproses'].'SPP </b></h2> <h4 style="text-align:center"> Belum di proses Staff Pembelian </h4>
      </div>
    </div>

     <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-success alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
      <h2 style="text-align:center"> <b> '.$data['statuskabag'].' SPP  </b></h2> <h4 style="text-align:center"> Belum di ketahui oleh Kepala Cabang </h4>
      </div>
    </div>

    <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-success alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
      <h2 style="text-align:center"> <b> '.$data['disetujui'].' SPP  </b></h2> <h4 style="text-align:center"> DISETUJUI oleh Staff Keuangan </h4>
      </div>
    </div>

    <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-warning alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <h2 style="text-align:center"> <b> '.$data['masukgudang'].' SPP  </b></h2> <h4 style="text-align:center"> <br> MASUK GUDANG  </h4>
      </div>
    </div>
    <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-info alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
         <h2 style="text-align:center"> <b> '.$data['selesai'].' SPP  </b></h2> <h4 style="text-align:center"> <br> SELESAI </h4>
      </div>
    </div>';
 return $html;
		
	}
	

	public function sppsetujukabag(Request $request){
		$namakabag = $request->namakabag;
		$keterangankabag = $request->kabag;
		$idspp = $request->idspp;
		$updatespp = spp_purchase::find($idspp);
		$updatespp->spp_namakabag = $request->namakabag;
		$updatespp->spp_keterangankabag = $request->keterangankabag;
		$updatespp->spp_statuskabag = 'SETUJU';
		$updatespp->spp_timesetujukabag = date('Y-m-d');
		$updatespp->save();


		return json_encode('sukses');
	}

	public function getnospp(Request $request){	
		$cabang = $request->comp;
		$tgl = $request->tglinput;
		$bulan = Carbon::parse($tgl)->format('m');
        $tahun = Carbon::parse($tgl)->format('y');

      	
		//return $mon;
		$idspp = DB::select("select * from spp where spp_cabang = '$cabang'  and to_char(spp_tgldibutuhkan, 'MM') = '$bulan' and to_char(spp_tgldibutuhkan, 'YY') = '$tahun' order by spp_id desc limit 1");

	//	$idspp =   spp_purchase::where('spp_cabang' , $request->comp)->max('spp_id');
		if(count($idspp) != 0) {		
			$explode = explode("/", $idspp[0]->spp_nospp);
			$idspp = $explode[2];

			$string = (int)$idspp + 1;
			$idspp = str_pad($string, 4, '0', STR_PAD_LEFT);
		}
		else {		
			$idspp = '0001';
		}


		$datainfo =['status' => 'sukses' , 'data' => $idspp];
		return json_encode($datainfo) ;
	}
	
	public function createspp () {

		$data['barang'] = DB::table('masteritem')
					        ->leftJoin('stock_gudang', 'stock_gudang.sg_item', '=', 'masteritem.kode_item')
					        ->get();


	/*	$data['barang'] = DB::select("select distinct is_kodeitem, unitstock, is_harga, sg_qty, nama_masteritem from  supplier, masteritem, itemsupplier LEFT OUTER JOIN stock_gudang on sg_item = is_kodeitem where is_kodeitem = kode_item and is_supplier = no_supplier");
*/
		$data['barangfull'] = DB::select("select * from supplier, masteritem, itemsupplier where is_kodeitem = kode_item and is_supplier = no_supplier and status = 'SETUJU' and active = 'AKTIF'");

		$data['cabang'] = master_cabang::all();	

		$data['jenisitem'] = masterJenisItemPurchase::all();			        
	
		$data['supplier'] = DB::select("select * from supplier where status = 'SETUJU' and active = 'AKTIF'");

		$data['department'] = master_department::all();

		

		$data['gudang'] = masterGudangPurchase::all();
		$data['kendaraan'] = DB::select("select * from kendaraan left outer join tipe_angkutan on kendaraan.tipe_angkutan = tipe_angkutan.kode");

		return view('purchase.spp.create', compact('data'));
	}

	public function ajax_hargasupplier(Request $request){
		//$array = $id;
		
		$id = $request->kodeitem;
		$gudang = $request->gudang;
		
		

		$data['supplier'] = DB::select("select * from masteritem, itemsupplier, supplier  where is_supplier = no_supplier and kode_item = '$id' and kode_item = is_kodeitem and status = 'SETUJU' and active = 'AKTIF'");

		$data['masteritem'] = DB::select("select * from masteritem where kode_item = '$id'");

		if($request->penerimaan != 'T'){
			$data['stock'] = DB::select("select * from  masteritem LEFT OUTER JOIN stock_gudang on kode_item = sg_item and  sg_gudang = '$gudang' where kode_item = '$id' ");
		}
		else {
			$data['stock'] = '-';
		}
		$data['mastersupplier'] = DB::select("select * from supplier where status = 'SETUJU' and active = 'AKTIF'");

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
		return DB::transaction(function() use ($request) {  
			/*dd($request);*/
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
				$nospp = str_pad($string, 4, '0', STR_PAD_LEFT);
			}

			else {
				$nospp = '0001';
			}

		//rumus no_spp$
			$tgl = $request->tgl_dibutuhkan;
			$date = date('Y-m-d', strtotime($tgl));
			$cabang = $request->comp;
			$tanggal = explode("-", $date);
			$hasilbulan = $tanggal[1];
			$hasiltahun = $tanggal[0];
			
		//	dd($hasilbulan);

			$nospp = $request->nospp;
			$dataspp = DB::select("select * from spp where spp_nospp = '$nospp'");
				if(count($dataspp) != 0){
						$explode = explode("/", $dataspp[0]->spp_nospp);
						$idspp3 = $explode[2];
					
						$idspp4 = (int)$idspp3 + 1;
						$akhirspp = str_pad($idspp4, 4, '0', STR_PAD_LEFT);
						$nospp = $explode[0] .'/' . $explode[1] . '/'  . $akhirspp;
				}
				else {
					$nospp = $nospp;
				}

			$tbb = $request->total_biaya;
			$hasiltbb = str_replace(',', '', $tbb);
			
			$time = Carbon::now();

			 $month = Carbon::now()->format('M');
       		 $year = Carbon::now()->format('Y');

			$spp = new spp_purchase();

			$spp->spp_nospp = strtoupper($nospp);
			$spp->spp_id = strtoupper($idspp);
			$spp->spp_tgldibutuhkan = strtoupper($request->tgl_dibutuhkan);
			$spp->spp_cabang = strtoupper($request->cabang);
			$spp->spp_bagian = strtoupper($request->bagian);
			$spp->spp_keperluan = strtoupper($request->keperluan);
			$spp->spp_status = 'DITERBITKAN';
			$spp->spp_noform = 'JPM/FR/PURC/01-02 ' . 'Januari ' . $year;
			$spp->spp_keterangan = strtoupper($request->keterangan);
			$spp->spp_penerimaan = $request->spp_penerimaan;
			$spp->create_by = $request->username;
			$spp->update_by = $request->username;
			$spp->spp_statuskabag = 'BELUM MENGETAHUI';
			$spp->spp_tglinput = $request->tglinput;

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
					$spp->spp_lokasigudang = $request->gudang;
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
			$co->staff_pemb = $status;
		//	$co->time_mng_umum_approved = $time;
			$co->man_keu = $status;
		//	$co->co_time_mng_pem_approved = $time;
		
			$co->co_cabang = $request->cabang;
			$co->create_by = $request->username;
			$co->update_by  = $request->username;
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
				$sppdt->sppd_kontrak = $request->statuskontrak[$i];
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
				
					$explode = explode("-" , $request->totbiaya[$j]);
					$stringtb = $explode[0];	
					$replacetb = str_replace(',', '', $stringtb);
					
					$sup = $explode[1];
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
       	});
	}


	public function updatespp(Request $request){
		return DB::transaction(function() use ($request) {  
			/*dd($request);*/
			$id = $request->idspp;
		DB::table('spp')
		->where('spp_id' , $id)
		->update([
			'spp_nospp' => $request->nospp,
			'spp_tgldibutuhkan' => $request->tgl_dibutuhkan,
			'spp_cabang' => $request->cabang,
			'spp_keperluan' => $request->keperluan,
			'spp_keterangan' => $request->keterangan,
			'spp_bagian' => $request->bagian,
		]);

		
		DB::DELETE("DELETE FROM spp_detail where sppd_idspp = '$id'");
		$n = 1; //index untuk array barang
		for($i=0; $i<count($request->barang); $i++) {	
			if($request->hargacek[$i] != ''){
				$lastidsppdt = sppdt_purchase::max('sppd_idsppdetail'); 
				if(isset($lastidsppdt)) {
					$idsppdt = (int)$lastidsppdt + 1;
				}
				else {
					$idsppdt = 1;
				}

				$harga = str_replace("," , "" , $request->hargacek[$i]);
				$sppdt = new sppdt_purchase();
				$sppdt->sppd_seq = $n;
				$sppdt->sppd_kodeitem = $request->barang[$i];
				$sppdt->sppd_qtyrequest = $request->qtyrequest[$i];
				$sppdt->sppd_harga = $harga;
				$sppdt->sppd_idspp = $id;
				$sppdt->sppd_idsppdetail = $idsppdt;
				if($request->jenisitem == 'S' && $request->updatestock == 'T'){
					$sppdt->sppd_kendaraan = $request->kendaraan[$i];
				}
				$sppdt->sppd_supplier = $request->suppliercek[$i];
				$sppdt->sppd_kontrak = 'TIDAK';
				$sppdt->save();
				$n++;
			}		
		}
		
		DB::DELETE("DELETE FROM spp_totalbiaya where spptb_idspp = '$id'");
		for($k=0; $k<count($request->suppliercekbayar); $k++){	
			$spptb = new spptb_purchase();
			$lastidspptb = spptb_purchase::max('spptb_id'); 
				if(isset($lastidspptb)) {
					$idspptb = (int)$lastidspptb + 1;
				}
				else {
					$idspptb = 1;
				}

			$totalbiaya = str_replace("," , "" , $request->totalbayarpembayaran[$k]);
			$spptb->spptb_totalbiaya = $totalbiaya;
			$spptb->spptb_id = $idspptb;
			$spptb->spptb_idspp = $id;
			$spptb->spptb_bayar = $request->syaratkredit[$k];
			$spptb->spptb_supplier = $request->suppliercekbayar[$k];
			$spptb->save();
		}

			return json_encode('sukses');	
		});
	}

	public function detailspp ($id) {

		

		$data['spp'] = DB::select("select *, spp.created_at as tglinput from confirm_order, spp, cabang,masterdepartment where co_idspp = '$id' and spp_bagian = kode_department and co_idspp = spp_id and spp_cabang = kode");
	/*	dd($data['spp']);*/


		$sppdt  = DB::select("select * from spp, spp_detail where sppd_idspp = spp_id and spp_id = '$id'");
		$grupitem = substr($sppdt[0]->sppd_kodeitem, 0,1);
		
		$jenisitem = DB::select("select * from jenis_item where kode_jenisitem = '$grupitem'");

		$data['jenisitem'] = $jenisitem[0]->keterangan_jenisitem;
		$data['stockjenisitem'] = $jenisitem[0]->stock;
		$data['kodejenisitem'] = $jenisitem[0]->kode_jenisitem;

		
		$lokasigudang = $data['spp'][0]->spp_lokasigudang;
		$tipespp = $data['spp'][0]->spp_tipe;
		if($tipespp == 'NS'){
			$namatipe = 'NON STOCK';
		}
		else if($tipespp == 'S'){
			$namatipe = 'STOCK';
		}
		else {
			$namatipe = 'JASA';
		}
		

		if($tipespp != 'J'){
			$data['sppdt'] =  DB::select("select * from spp, masteritem, supplier, spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item and sg_gudang = '$lokasigudang' where sppd_idspp = '$id' and sppd_idspp = spp_id and kode_item = sppd_kodeitem and  sppd_supplier = idsup order by sppd_seq asc");

			if($tipespp == 'NS' && $data['kodejenisitem'] == 'S'){
				$data['sppdt_barang'] = DB::select("select distinct sppd_kodeitem, sppd_kendaraan, nopol, nama_masteritem, sppd_qtyrequest, sg_qty, unitstock from kendaraan, masteritem , spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item and sg_gudang = '$lokasigudang' where sppd_idspp = '$id' and kode_item = sppd_kodeitem and sppd_kendaraan = kendaraan.id");

			}
			else {
				$data['sppdt_barang'] = DB::select("select distinct sppd_kodeitem, nama_masteritem, sppd_qtyrequest, sg_qty, unitstock from kendaraan, masteritem , spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item and sg_gudang = '$lokasigudang' where sppd_idspp = '$id' and kode_item = sppd_kodeitem");
			}

			$data['codt'] = DB::select("select *  from confirm_order, masteritem, spp, confirm_order_dt LEFT OUTER JOIN stock_gudang on codt_kodeitem = sg_item where confirm_order_dt.codt_idco=co_id and co_idspp = '$id' and co_idspp = spp_id and codt_kodeitem = kode_item");

			$data['gudang'] = DB::select("select mg_namagudang from spp, mastergudang where 	spp_lokasigudang = mg_id and spp_id = '$id'");

		}
		else {
			$data['sppdt'] =  DB::select("select * from spp, masteritem, supplier, spp_detail where sppd_idspp = '$id' and sppd_idspp = spp_id and kode_item = sppd_kodeitem and  sppd_supplier = idsup order by sppd_seq asc");

			$data['sppdt_barang'] = DB::select("select distinct sppd_kodeitem, nama_masteritem, sppd_qtyrequest, unitstock from  masteritem , spp_detail  where sppd_idspp = '$id' and kode_item = sppd_kodeitem ");
			
			$data['codt'] = DB::select("select *  from confirm_order, masteritem, spp, confirm_order_dt where confirm_order_dt.codt_idco=co_id and co_idspp = '$id' and co_idspp = spp_id and codt_kodeitem = kode_item");
		}
		
		$data['kendaraan'] = DB::select("select distinct sppd_kendaraan, merk, nopol from spp_detail, kendaraan where sppd_kendaraan = id and sppd_idspp = '$id'");

		$data['masterkendaraan'] = DB::select("select * from kendaraan");


		$data['countkendaraan'] = count($data['kendaraan']);

		$data['spptb'] =  DB::select("select * from spp_totalbiaya,spp, supplier where spptb_idspp = '$id' and spptb_idspp = spp.spp_id and spptb_supplier = idsup");
		
		$data['sppd_brg'] = DB::select("select sppd_kodeitem from spp_detail where sppd_idspp='$id'");

		$data['codt'] = DB::select("select *  from confirm_order, spp, confirm_order_dt LEFT OUTER JOIN stock_gudang on codt_kodeitem = sg_item where confirm_order_dt.codt_idco=co_id and co_idspp = '$id' and co_idspp = spp_id");

		$data['codt_supplier'] = DB::select("select distinct codt_supplier, nama_supplier from supplier, confirm_order_dt, spp, confirm_order where codt_supplier = idsup and co_idspp = spp_id and spp_id = '$id' and codt_idco = co_id");
		
		$data['hitungbayar'] = DB::select("select distinct sppd_supplier, sppd_bayar, nama_supplier from spp_detail, supplier where sppd_idspp = '$id' and sppd_supplier = idsup");

		$data['count'] = count($data['spptb']);
		$data['countcodt'] = count($data['codt']);

		$data['count_brg'] = count($data['sppdt_barang']);
	
		$data['supplier'] = DB::select("select * from supplier where status = 'SETUJU' and active = 'AKTIF'");
		$data['item'] = DB::select("select * from masteritem, jenis_item where masteritem.jenisitem = jenis_item.kode_jenisitem ORDER BY kode_item DESC");

		$data['cabang'] = master_cabang::all();			        
	
		$data['supplier'] = DB::select("select * from supplier where status = 'SETUJU' and active = 'AKTIF'");

		$data['department'] = master_department::all();

		$barang = array();
		for($i=0; $i<count($data['sppd_brg']);$i++){
				array_push($barang , $data['sppd_brg'][$i]->sppd_kodeitem);
		}


		$data['countbrg'] = array_count_values($barang);
		$data['tipespp'] = $tipespp;

		//dd($data);
		return view('purchase.spp.detail', compact('data'));
	}

	public function editspp($id){
		$data['spp'] = DB::select("select * from confirm_order, spp, masterdepartment, cabang where co_idspp = '$id' and spp_bagian = kode_department and co_idspp = spp_id and spp_cabang = kode");

		$sppdt  = DB::select("select * from spp, spp_detail where sppd_idspp = spp_id and spp_id = '$id'");
		$grupitem = substr($sppdt[0]->sppd_kodeitem, 0,1);
		
		$jenisitem = DB::select("select * from jenis_item where kode_jenisitem = '$grupitem'");

		$data['jenisitem'] = $jenisitem[0]->keterangan_jenisitem;
		$data['stockjenisitem'] = $jenisitem[0]->stock;
		$data['kodejenisitem'] = $jenisitem[0]->kode_jenisitem;

		$data['cabang'] = DB::select("select * from cabang");
		
		$cabang = $data['spp'][0]->spp_cabang;

		$data['department'] = DB::select("select * from masterdepartment");

		$data['gudang'] = DB::select("select * from mastergudang where mg_cabang = '$cabang'");
		
		$data['kendaraan'] = DB::select("select * from kendaraan");

		$lokasigudang = $data['spp'][0]->spp_lokasigudang;
		$tipespp = $data['spp'][0]->spp_tipe;

		if($tipespp != 'J'){
			$data['sppdt'] =  DB::select("select * from spp, masteritem, supplier, spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item and sg_gudang = '$lokasigudang' where sppd_idspp = '$id' and sppd_idspp = spp_id and kode_item = sppd_kodeitem and  sppd_supplier = idsup order by sppd_seq asc");
		if($tipespp == 'NS' && $data['jenisitem'] == 'S'){
			$data['sppdt_barang'] = DB::select("select distinct sppd_kodeitem, nama_masteritem, sppd_qtyrequest, sg_qty, unitstock, sppd_kendaraan from kendaraan, masteritem , spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item and sg_gudang = '$lokasigudang' where sppd_idspp = '$id' and kode_item = sppd_kodeitem  and sppd_kendaraan = kendaraan.id order by sppd_kodeitem asc");
		}
		else {
			$data['sppdt_barang'] = DB::select("select distinct sppd_kodeitem, nama_masteritem, sppd_qtyrequest, sg_qty, unitstock from  masteritem , spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item and sg_gudang = '$lokasigudang' where sppd_idspp = '$id' and kode_item = sppd_kodeitem order by sppd_kodeitem asc");	
		}	
		}
		else {
			$data['sppdt'] =  DB::select("select * from spp, masteritem, supplier, spp_detail where sppd_idspp = '$id' and sppd_idspp = spp_id and kode_item = sppd_kodeitem and  sppd_supplier = idsup order by sppd_seq asc");

			

			$data['sppdt_barang'] = DB::select("select distinct sppd_kodeitem, nama_masteritem, sppd_qtyrequest, unitstock from  masteritem , spp_detail  where sppd_idspp = '$id' and kode_item = sppd_kodeitem order by sppd_kodeitem asc ");
			
		}
		

		/*dd($data);*/
	
		return view('purchase.spp.edit', compact('data'));
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
	
		$data['supplier'] = DB::select("select * from supplier where status = 'SETUJU' and active = 'AKTIF'");
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

	public function cetakspp($id){
		$data['spp'] = DB::select("select *, spp.created_at as tglinput from confirm_order, spp, masterdepartment where co_idspp = '$id' and spp_bagian = kode_department and co_idspp = spp_id");

		$data['po'] = DB::select("select distinct(po_no) from pembelian_order, pembelian_orderdt, spp where podt_idspp = spp_id and podt_idspp = '$id' and podt_idpo = po_id");

		$data['sppdt'] =  DB::select("select * from spp, masteritem, supplier, spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item where sppd_idspp = '$id' and sppd_idspp = spp_id and kode_item = sppd_kodeitem and idsup = sppd_supplier order by sppd_seq asc");

		$data['gudang'] = DB::select("select mg_namagudang from spp, mastergudang where spp_lokasigudang = mg_id and spp_id = '$id'");

		$data['kendaraan'] = DB::select("select distinct sppd_kendaraan, merk, kode from spp_detail, kendaraan where sppd_kendaraan = id and sppd_idspp = '$id'");
		$data['countkendaraan'] = count($data['kendaraan']);

		$data['masterkendaraan'] = DB::select("select * from kendaraan");

		$data['sppdt_barang'] = DB::select("select distinct sppd_kodeitem, nama_masteritem, sppd_qtyrequest, sppd_kendaraan , unitstock, nopol, merk from  masteritem , spp_detail LEFT OUTER JOIN kendaraan on sppd_kendaraan = id  where sppd_idspp = '$id' and kode_item = sppd_kodeitem");
		
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
	
		$data['supplier'] = DB::select("select * from supplier where status = 'SETUJU' and active = 'AKTIF'");

		$data['department'] = master_department::all();


		$barang = array();
		for($i=0; $i<count($data['sppd_brg']);$i++){
				array_push($barang , $data['sppd_brg'][$i]->sppd_kodeitem);
		}


		$data['countbrg'] = array_count_values($barang);
		/*dd($data);*/
		return view('purchase.spp.cetakspp' , compact('data'));
	}


	public function kettolakspp(Request $request){
		$idspp = $request->idspp;

		$datasppdt = DB::select("select sppd_kodeitem,sppd_kettolak, nama_masteritem from spp_detail, masteritem where sppd_idspp = '$idspp' and sppd_status = 'TOLAK' and sppd_kodeitem = kode_item group by sppd_kodeitem, sppd_kettolak, nama_masteritem");

		return json_encode($datasppdt);

	}

	public function tmbhdatabarang (Request $request){
		$jenisitem = $request->jenisitem;
		$stock = $request->stock;
		$updatestock = $request->updatestock;

		$data['kodeitem'] = DB::select("select * from masteritem where jenisitem = '$jenisitem'");
		$data['supplier'] = DB::select("select * from supplier");
		$data['kendaraan'] = DB::select("select * from kendaraan");
 		return json_encode($data);
	}


	
	public function deletesup($id){

		$datasptb = spptb_purchase::find($id);

		$datasptb->delete($datasptb);
		Session::flash('sukses', 'data item berhasil dihapus');
        return redirect('masteritem/masteritem');	
	}

	public function confirm_order () {

		
		/*dd($data);*/
		return view('purchase.confirm_order.index');
	}

	function confirm_ordernotif(Request $request){
		  $html='';		 
          $data='';
  		  $tgl='';  		  
  		  $no='';
  		  $tgl1=date('Y-m-d',strtotime($request->tanggal1));
  		  $tgl2=date('Y-m-d',strtotime($request->tanggal2));
  		  if($request->tanggal1!='' && $request->tanggal2!=''){  		  	
  		  	$tgl="and spp_tgldibutuhkan >= '$tgl1' AND spp_tgldibutuhkan <= '$tgl2'";
  		  }  		  
  		  if($request->nofpg!=''){
  		  	$no="and spp_nospp='$request->nofpg'";
  		  }


  		  $cabang = session::get('cabang');

		if(Auth::user()->punyaAkses('Konfirmasi Order','all')){
			
			$data['pembelian'] = DB::select("select count(*) as count from spp, confirm_order where co_idspp = spp_id and staff_pemb = 'BELUM DI SETUJUI' and spp_statuskabag = 'SETUJU' $tgl $no");

			$data['keuangan'] = DB::select("select count(*) as count from spp, confirm_order where co_idspp = spp_id and man_keu = 'BELUM DI SETUJUI' and spp_statuskabag = 'SETUJU' $tgl $no");

		}
		else {
		
			$data['pembelian'] = DB::select("select count(*) as count from spp, confirm_order where co_idspp = spp_id and staff_pemb = 'BELUM DI SETUJUI' and spp_statuskabag = 'SETUJU' $tgl $no and spp_cabang = '$cabang'");

			$data['keuangan'] = DB::select("select count(*) as count from spp, confirm_order where co_idspp = spp_id and man_keu = 'BELUM DI SETUJUI' and spp_statuskabag = 'SETUJU' $tgl $no and spp_cabang = '$cabang'");
		}
		

	$html.='<div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-danger alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <h2 style="text-align:center"> <b> '.$data['pembelian'][0]->count.' SPP </b></h2> <h4 style="text-align:center"> Belum di proses Staff Pembelian </h4>
      </div>
    </div>

     <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-success alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
      <h2 style="text-align:center"> <b> '.$data['keuangan'][0]->count.' SPP  </b></h2> <h4 style="text-align:center"> Belum di proses Keuangan </h4>
      </div>
    </div>';
 return $html;

	}
	public function confirm_ordertable (Request $request) {		
		
		  $cabang = session::get('cabang');
          $data='';
  		  $tgl='';  		  
  		  $no='';
  		  $tgl1=date('Y-m-d',strtotime($request->tanggal1));
  		  $tgl2=date('Y-m-d',strtotime($request->tanggal2));
  		  if($request->tanggal1!='' && $request->tanggal2!=''){  		  	
  		  	$tgl="and spp_tgldibutuhkan >= '$tgl1' AND spp_tgldibutuhkan <= '$tgl2'";
  		  }  		  
  		  if($request->nofpg!=''){
  		  	$no="and spp_nospp='$request->nofpg'";
  		  }


		if(Auth::user()->punyaAkses('Konfirmasi Order','all')){
			$data=DB::select("select *, 'no' as no from confirm_order, spp, cabang where co_idspp = spp_id and spp_statuskabag = 'SETUJU' and spp_cabang = kode $tgl $no order by co_id desc ");
			$data=collect($data);			
		}
		else {
			$data=DB::select("select *,'no' as no from confirm_order, spp, cabang where co_idspp = spp_id and spp_statuskabag = 'SETUJU' and spp_cabang = '$cabang' and spp_cabang = kode $tgl $no order by co_id desc ");	
			$data=collect($data);			
		}



return 
			DataTables::of($data)->
			editColumn('spp_tgldibutuhkan', function ($data) {            
            	return date('d-m-Y',strtotime($data->spp_tgldibutuhkan));
            })
            ->editColumn('staff_pemb', function ($data) { 
            	$staff_pemb='';
				  if(Auth::user()->punyaAkses('Konfirmasi Order','aktif')){
				            if($data->staff_pemb == 'DISETUJUI'){
				$staff_pemb.='<a class="label label-info" href="
				                '.url('konfirmasi_order/konfirmasi_orderdetailpemb/'.$data->co_idspp.'').'
				                ">'.$data->staff_pemb.'</a>';                            				                
				                          }else{
				$staff_pemb.= '<a class="label label-warning" href="
								'.url('konfirmasi_order/konfirmasi_orderdetailpemb/'.$data->co_idspp.'').'
				                ">'.$data->staff_pemb.'</a>';                            				                
				                          }
				       }

				return $staff_pemb;

            })->editColumn('spp_cabang', function ($data) { 
            	return $data->spp_cabang.'-'.$data->nama;                                 
            
            })
            ->editColumn('man_keu',function($data){
			$man_keu='';
            	if(Auth::user()->punyaAkses('Konfirmasi Order Keu','aktif')){
                       if($data->man_keu == 'DISETUJUI'){
                       $man_keu.= '<a class="label label-info"  href="
				                '.url('konfirmasi_order/konfirmasi_orderdetailkeu/'.$data->co_idspp.'').'
				                ">'.$data->man_keu.'</a>';
                       
                          }else{
                	   $man_keu.='<a class="label label-danger" href="
				                '.url('konfirmasi_order/konfirmasi_orderdetailkeu/'.$data->co_idspp.'').'
				                ">'.$data->man_keu.'</a>';                           
                       }
                          
                }

                return $man_keu;



            })->addColumn('action', function ($data) {            	
            	if($data->man_keu == 'DISETUJUI' && $data->staff_pemb == 'DISETUJUI' )
            	return '<a class="btn btn-sm btn-success" href="
				                '.url('konfirmasi_order/cetakkonfirmasi/'.$data->co_id.'').'
				                ">
				                 <i class="fa fa-print" aria-hidden="true"></i>  </a>';            
            })
			->make(true);	

	}


	public function confirm_order_dtkeu ($id) {
		
	$data['spp'] = DB::select("select * from confirm_order, spp, cabang,masterdepartment where co_idspp = '$id' and spp_bagian = kode_department and co_idspp = spp_id and spp_cabang = kode");
	/*	dd($data['spp']);*/
	$setujumankeu = $data['spp'][0]->man_keu;
//	dd($setujumankeu);
	if($setujumankeu == 'DISETUJUI'){
		$data['suppliertb'] = DB::select("select * from confirm_order_tb, confirm_order, supplier where cotb_idco = co_id and co_idspp = '$id' and cotb_supplier = idsup");
		$data['codt_tb'] =  DB::select("select * from confirm_order_tb, confirm_order where cotb_idco = co_id and co_idspp = '$id' ");
	}
	else if($setujumankeu == 'BELUM DI SETUJUI'){

		$data['suppliertb'] = DB::select("select * from confirm_order_tb_pemb, confirm_order, supplier where cotbk_idco = co_id and co_idspp = '$id' and cotbk_supplier = idsup");	

		$data['codt_tb'] =  DB::select("select * from confirm_order_tb_pemb, confirm_order where cotbk_idco = co_id and co_idspp = '$id' ");		
	}
		
	/*dd($data['codt_tb']);*/

		$lokasigudang = $data['spp'][0]->spp_lokasigudang;
		$tipespp = $data['spp'][0]->spp_tipe;
		if($tipespp == 'NS'){
			$namatipe = 'NON STOCK';
		}
		else if($tipespp == 'S'){
			$namatipe = 'STOCK';
		}
		else {
			$namatipe = 'JASA';
		}
		
		$data['tipespp'] = $namatipe;

		if($tipespp != 'J'){
			$data['sppdt'] =  DB::select("select * from spp, masteritem, supplier, spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item and sg_gudang = '$lokasigudang' where sppd_idspp = '$id' and sppd_idspp = spp_id and kode_item = sppd_kodeitem and  sppd_supplier = idsup order by sppd_seq asc");


			$grupitem = substr($data['sppdt'][0]->sppd_kodeitem, 0,1);
		
			$jenisitem = DB::select("select * from jenis_item where kode_jenisitem = '$grupitem'");

			$data['jenisitem'] = $jenisitem[0]->keterangan_jenisitem;
			$data['stockjenisitem'] = $jenisitem[0]->stock;
			$data['kodejenisitem'] = $jenisitem[0]->kode_jenisitem;	

			if($tipespp == 'NS' && $data['jenisitem'] == 'SPARE PART KENDARAAN'){
			$data['sppdt_barang'] = DB::select("select distinct codtk_kodeitem, codtk_qtyrequest , codtk_kendaraan, nopol ,nama_masteritem, codtk_qtyapproved, sg_qty, unitstock from kendaraan, confirm_order, masteritem , confirm_order_dt_pemb LEFT OUTER JOIN stock_gudang on codtk_kodeitem = sg_item and sg_gudang = '$lokasigudang' where co_idspp = '$id' and kode_item = codtk_kodeitem and codtk_kendaraan = kendaraan.id and codtk_idco = co_id ");

			}
			else {
				$data['sppdt_barang'] = DB::select("select distinct codtk_kodeitem, codtk_qtyrequest ,nama_masteritem, codtk_qtyapproved, sg_qty, unitstock from confirm_order, masteritem , confirm_order_dt_pemb LEFT OUTER JOIN stock_gudang on codtk_kodeitem = sg_item and sg_gudang = '$lokasigudang' where co_idspp = '$id' and kode_item = codtk_kodeitem and codtk_idco = co_id ");

			}

			
			$grupitem = substr($data['sppdt_barang'][0]->codtk_kodeitem, 0,1);
		
			$jenisitem = DB::select("select * from jenis_item where kode_jenisitem = '$grupitem'");

			$data['jenisitem'] = $jenisitem[0]->keterangan_jenisitem;
			$data['stockjenisitem'] = $jenisitem[0]->stock;
			$data['kodejenisitem'] = $jenisitem[0]->kode_jenisitem;


			if($tipespp == 'NS' && $data['jenisitem'] == 'SPARE PART KENDARAAN'){
				$data['codt'] = DB::select("select *  from confirm_order, kendaraan, masteritem, spp, confirm_order_dt LEFT OUTER JOIN stock_gudang on codt_kodeitem = sg_item where confirm_order_dt.codt_idco=co_id and co_idspp = '$id' and co_idspp = spp_id and codt_kodeitem = kode_item and codt_kendaraan = kendaraan.id");
			}
			else {
				$data['codt'] = DB::select("select *  from confirm_order, masteritem, spp, confirm_order_dt LEFT OUTER JOIN stock_gudang on codt_kodeitem = sg_item where confirm_order_dt.codt_idco=co_id and co_idspp = '$id' and co_idspp = spp_id and codt_kodeitem = kode_item ");
			}

		}
		else {
			$data['sppdt'] =  DB::select("select * from spp, masteritem, supplier, spp_detail where sppd_idspp = '$id' and sppd_idspp = spp_id and kode_item = sppd_kodeitem and  sppd_supplier = idsup order by sppd_seq asc");

			$data['sppdt_barang'] = DB::select("select distinct codtk_kodeitem, nama_masteritem, codtk_qtyapproved, codtk_qtyrequest, unitstock from  masteritem , confirm_order_dt_pemb, confirm_order  where co_idspp = '$id' and kode_item = codtk_kodeitem and codtk_idco = co_id ");
			
			$grupitem = substr($data['sppdt_barang'][0]->codtk_kodeitem, 0,1);
		
			$jenisitem = DB::select("select * from jenis_item where kode_jenisitem = '$grupitem'");

			$data['jenisitem'] = $jenisitem[0]->keterangan_jenisitem;
			$data['stockjenisitem'] = $jenisitem[0]->stock;
			$data['kodejenisitem'] = $jenisitem[0]->kode_jenisitem;

			$data['codt'] = DB::select("select *  from confirm_order, masteritem, spp, confirm_order_dt where confirm_order_dt.codt_idco=co_id and co_idspp = '$id' and co_idspp = spp_id and codt_kodeitem = kode_item");
		}	
	
		$data['spptb'] =  DB::select("select * from spp_totalbiaya,spp, supplier where spptb_idspp = '$id' and spptb_idspp = spp.spp_id and spptb_supplier = idsup");


		
		$data['sppd_brg'] = DB::select("select sppd_kodeitem from spp_detail where sppd_idspp='$id'");

	

		$data['codt_supplier'] = DB::select("select distinct codt_supplier, nama_supplier from supplier, confirm_order_dt, spp, confirm_order where codt_supplier = idsup and co_idspp = spp_id and spp_id = '$id' and codt_idco = co_id");

		
		
		
		$data['count'] = count($data['suppliertb']);
		$data['countcodt'] = count($data['codt']);

		$data['count_brg'] = count($data['sppdt_barang']);
	
		$data['supplier'] = DB::select("select * from supplier where status = 'SETUJU' and active = 'AKTIF'");
		$data['item'] = DB::select("select * from masteritem, jenis_item where masteritem.jenisitem = jenis_item.kode_jenisitem   ORDER BY kode_item DESC");

		$barang = array();
		for($i=0; $i<count($data['sppd_brg']);$i++){
				array_push($barang , $data['sppd_brg'][$i]->sppd_kodeitem);
		}


		$data['countbrg'] = array_count_values($barang);
		
		return view('purchase.confirm_orderdetail.index4', compact('data' , 'tipespp' , 'namatipe'));
	}	

	public function cekhargatotal(Request $request){
		$data['datasupplier'] = [];
		$data['temp'] = [];
		$idspp = $request->idspp;
		for($i = 0; $i < count($request->hslsupplier); $i++){
			$idsup = $request->hslsupplier[$i];

			
			$dataspptb = DB::table('spp_totalbiaya')
						->where('spptb_idspp' , '=' , $idspp)
						->where('spptb_supplier' , '=' , $idsup)
						->get();

			if(count($dataspptb) == 0){
				$temp = 0;
				$supplier = DB::select("select * from supplier where idsup = '$idsup'");
			}
			else {
				$temp = 1;
				$supplier = DB::select("select * from spp_totalbiaya, supplier where spptb_idspp = '$idspp' and spptb_supplier = '$idsup' and spptb_supplier = idsup");
			}
			array_push($data['temp'] , $temp);
			array_push($data['datasupplier'] , $supplier);
		}
		return json_encode($data);
	}

	public function cekharga(Request $request){
		$kodeitem = $request->kodeitem;
		$supplier = $request->supplier;
		$data['masteritem'] = DB::select("select * from masteritem where kode_item = '$kodeitem'");

		$data['itemsupplier'] = DB::select("select * from itemsupplier, supplier where is_kodeitem = '$kodeitem' and is_idsup = idsup and is_idsup = '$supplier'");

		if(count($data['itemsupplier']) > 0){
			$data['harga'] = $data['itemsupplier'][0]->is_harga;
		}
		else {
			$data['harga'] = $data['masteritem'][0]->harga;
			
		}

		return json_encode($data);
	}

	public function ceksupplier(Request $request){
		
		$idspp = $request->idspp;


		$data['spp'] = DB::select("select * from confirm_order, spp, masterdepartment, cabang where co_idspp = '$idspp' and spp_bagian = kode_department and co_idspp = spp_id and spp_cabang = kode");

		$data['sppd'] = DB::select("select * from spp_detail, supplier where sppd_idspp = '$idspp' and sppd_supplier = idsup order by sppd_kodeitem asc");
		
		$grupitem = substr($data['sppd'][0]->sppd_kodeitem, 0,1);
		
		$jenisitem = DB::select("select * from jenis_item where kode_jenisitem = '$grupitem'");
		$data['jenisitem'] = $jenisitem[0]->keterangan_jenisitem;
		$data['stockjenisitem'] = $jenisitem[0]->stock;
		$data['kodejenisitem'] = $jenisitem[0]->kode_jenisitem;
		$tipespp = $data['spp'][0]->spp_tipe;


		if($tipespp == 'NS' && $data['jenisitem'] == 'S'){
			$data['sppdt'] =  DB::select("select distinct sppd_kendaraan, sppd_kodeitem, nama_masteritem, sppd_qtyrequest,unitstock from  kendaraan, masteritem, spp_detail where sppd_idspp = '$idspp' and kode_item = sppd_kodeitem and sppd_kendaraan = kendaraan.id order by sppd_kodeitem asc ");
		}
		else {
			$data['sppdt'] =  DB::select("select distinct sppd_kodeitem, nama_masteritem, sppd_qtyrequest,unitstock from  masteritem, spp_detail where sppd_idspp = '$idspp' and kode_item = sppd_kodeitem order by sppd_kodeitem asc ");
		}

		$data['temp'] = [];
		$data['supplier'] = [];
		for($i = 0; $i < count($data['sppdt']); $i++){
			$kodeitem = $data['sppdt'][$i]->sppd_kodeitem;
			$data['itemsupplier'] = DB::select("select * from itemsupplier, supplier where is_kodeitem = '$kodeitem' and is_idsup = idsup");

				if(count($data['itemsupplier']) > 0){
					$itemsupplier2 = DB::select("select * from itemsupplier, supplier where is_kodeitem = '$kodeitem' and is_idsup = idsup");
					array_push($data['temp'] , '0');
					array_push($data['supplier'] , $itemsupplier2);
				}
				else {
					array_push($data['temp'] , '1');
					$data['supplier2'] = DB::select("select * from supplier");
					array_push($data['supplier'] , $data['supplier2']);
				}
		}


		return json_encode($data);
	}

	public function confirm_order_dtpemb ($id) {
		
	$data['spp'] = DB::select("select * from confirm_order, spp, cabang,masterdepartment where co_idspp = '$id' and spp_bagian = kode_department and co_idspp = spp_id and spp_cabang = kode");
	/*	dd($data['spp']);*/

		
		$lokasigudang = $data['spp'][0]->spp_lokasigudang;
		$tipespp = $data['spp'][0]->spp_tipe;
		
		if($tipespp == 'NS'){
			$namatipe = 'NON STOCK';
		}
		else if($tipespp == 'S'){
			$namatipe = 'STOCK';
		}
		else {
			$namatipe = 'JASA';
		}
		


		if($tipespp != 'J'){
			$data['sppdt'] =  DB::select("select * from spp, masteritem, supplier, spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item and sg_gudang = '$lokasigudang' where sppd_idspp = '$id' and sppd_idspp = spp_id and kode_item = sppd_kodeitem and  sppd_supplier = idsup order by sppd_seq asc");

			$data['sppdt_barang'] = DB::select("select distinct sppd_kodeitem, nama_masteritem, sppd_qtyrequest, sg_qty, unitstock from  masteritem , spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item and sg_gudang = '$lokasigudang' where sppd_idspp = '$id' and kode_item = sppd_kodeitem order by sppd_kodeitem asc");

			$data['codt_barang'] = DB::select("select distinct codtk_kodeitem, nama_masteritem, codtk_qtyrequest, codtk_qtyapproved, sg_qty, unitstock from confirm_order, masteritem , confirm_order_dt_pemb LEFT OUTER JOIN stock_gudang on codtk_kodeitem = sg_item and sg_gudang = '$lokasigudang' where co_idspp = '$id' and kode_item = codtk_kodeitem and codtk_idco = co_id order by codtk_kodeitem asc");			

			$data['codt'] = DB::select("select *  from confirm_order, masteritem, spp, confirm_order_dt_pemb LEFT OUTER JOIN stock_gudang on codtk_kodeitem = sg_item and sg_gudang = '$lokasigudang' where confirm_order_dt_pemb.codtk_idco=co_id and co_idspp = '$id' and co_idspp = spp_id and codtk_kodeitem = kode_item");

			$grupitem = substr($data['sppdt_barang'][0]->sppd_kodeitem, 0,1);
			
			$jenisitem = DB::select("select * from jenis_item where kode_jenisitem = '$grupitem'");

			$data['jenisitem'] = $jenisitem[0]->keterangan_jenisitem;
			$data['stockjenisitem'] = $jenisitem[0]->stock;
			$data['kodejenisitem'] = $jenisitem[0]->kode_jenisitem;
			
			if($tipespp == 'NS' && $data['kodejenisitem'] == 'S'){
				$data['sppdt_barang'] = DB::select("select distinct nopol , sppd_kendaraan, sppd_kodeitem, nama_masteritem, sppd_qtyrequest, sg_qty, unitstock from kendaraan, masteritem , spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item and sg_gudang = '$lokasigudang' where sppd_idspp = '$id' and kode_item = sppd_kodeitem  and sppd_kendaraan = kendaraan.id order by sppd_kodeitem asc");

				$data['codt_barang'] = DB::select("select distinct codtk_kodeitem, nopol, nama_masteritem, codtk_qtyrequest, codtk_qtyapproved, sg_qty, unitstock from confirm_order, kendaraan, masteritem , confirm_order_dt_pemb LEFT OUTER JOIN stock_gudang on codtk_kodeitem = sg_item and sg_gudang = '$lokasigudang' where co_idspp = '$id' and kode_item = codtk_kodeitem and codtk_idco = co_id and codtk_kendaraan = kendaraan.id order by codtk_kodeitem asc");

				
			}
			else {
				$data['sppdt_barang'] = DB::select("select distinct sppd_kodeitem, nama_masteritem, sppd_qtyrequest, sg_qty, unitstock from  masteritem , spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item and sg_gudang = '$lokasigudang' where sppd_idspp = '$id' and kode_item = sppd_kodeitem order by sppd_kodeitem asc");

				$data['codt_barang'] = DB::select("select distinct codtk_kodeitem, nama_masteritem, codtk_qtyrequest, codtk_qtyapproved, sg_qty, unitstock from confirm_order, masteritem , confirm_order_dt_pemb LEFT OUTER JOIN stock_gudang on codtk_kodeitem = sg_item and sg_gudang = '$lokasigudang' where co_idspp = '$id' and kode_item = codtk_kodeitem and codtk_idco = co_id order by codtk_kodeitem asc");
			}


		}
		else {
			$data['sppdt'] =  DB::select("select * from spp, masteritem, supplier, spp_detail where sppd_idspp = '$id' and sppd_idspp = spp_id and kode_item = sppd_kodeitem and  sppd_supplier = idsup order by sppd_seq asc");

			$data['codt_barang'] = DB::select("select distinct codtk_kodeitem, codtk_qtyapproved, nama_masteritem, codtk_qtyrequest,  unitstock from confirm_order, masteritem , confirm_order_dt_pemb where co_idspp = '$id' and kode_item = codtk_kodeitem and codtk_idco = co_id order by codtk_kodeitem asc");		

			$data['sppdt_barang'] = DB::select("select distinct sppd_kodeitem, nama_masteritem, sppd_qtyrequest, unitstock from  masteritem , spp_detail  where sppd_idspp = '$id' and kode_item = sppd_kodeitem order by sppd_kodeitem asc ");
			
			$grupitem = substr($data['sppdt_barang'][0]->sppd_kodeitem, 0,1);
			
			$jenisitem = DB::select("select * from jenis_item where kode_jenisitem = '$grupitem'");

			$data['jenisitem'] = $jenisitem[0]->keterangan_jenisitem;
			$data['stockjenisitem'] = $jenisitem[0]->stock;
			$data['kodejenisitem'] = $jenisitem[0]->kode_jenisitem;

			$data['codt'] = DB::select("select *  from confirm_order, masteritem, confirm_order_dt_pemb where confirm_order_dt_pemb.codtk_idco=co_id and co_idspp = '$id' and  codtk_kodeitem = kode_item");
		}	
	
		$data['spptb'] =  DB::select("select * from spp_totalbiaya,spp, supplier where spptb_idspp = '$id' and spptb_idspp = spp.spp_id and spptb_supplier = idsup");
		
		$data['sppd_brg'] = DB::select("select sppd_kodeitem from spp_detail where sppd_idspp='$id'");

	

		$data['codt_supplier'] = DB::select("select distinct codtk_supplier, nama_supplier from supplier, confirm_order_dt_pemb, spp, confirm_order where codtk_supplier = idsup and co_idspp = spp_id and spp_id = '$id' and codtk_idco = co_id");

		$data['codt_tb'] =  DB::select("select * from confirm_order_tb_pemb, confirm_order where cotbk_idco = co_id and co_idspp = '$id' ");
		
		
		$data['count'] = count($data['spptb']);
		$data['countcodt'] = count($data['codt']);

		$data['count_brg'] = count($data['sppdt_barang']);
	
		$data['supplier'] = DB::select("select * from supplier where status = 'SETUJU' and active = 'AKTIF'");
		$data['item'] = DB::select("select * from masteritem, jenis_item where masteritem.jenisitem = jenis_item.kode_jenisitem   ORDER BY kode_item DESC");

		$barang = array();
		for($i=0; $i<count($data['sppd_brg']);$i++){
				array_push($barang , $data['sppd_brg'][$i]->sppd_kodeitem);
		}


		$data['countbrg'] = array_count_values($barang);
		
		//data data setelah revisi

		
		return view('purchase.confirm_orderdetail.index_pemb1', compact('data' , 'tipespp' , 'namatipe'));
	}	



	public function ajax_confirmorderdt(Request $request) {
	
		$id = $request->idspp;
		
		$data['spp'] = DB::select("select * from confirm_order, spp, masterdepartment where co_idspp = '$id' and spp_bagian = kode_department and co_idspp = spp_id");
		
		$tipespp = $data['spp'][0]->spp_tipe;
		$lokasigudang = $data['spp'][0]->spp_lokasigudang;
		if($tipespp == 'NS'){
			$namatipe = 'NON STOCK';
		}
		else if($tipespp == 'S'){
			$namatipe = 'STOCK';
		}
		else {
			$namatipe = 'JASA';
		}


		if($tipespp != 'J'){
			$data['sppdt'] =  DB::select("select * from spp, masteritem, supplier, spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item where sppd_idspp = '$id' and sppd_idspp = spp_id and kode_item = sppd_kodeitem and idsup = sppd_supplier order by sppd_seq asc");	

			$data['sppdt_barang'] = DB::select("select distinct sppd_kodeitem, nama_masteritem, sppd_qtyrequest, sg_qty, unitstock from  masteritem , spp_detail LEFT OUTER JOIN stock_gudang on sppd_kodeitem = sg_item and sg_gudang = '$lokasigudang'  where sppd_idspp = '$id' and kode_item = sppd_kodeitem");
			}
			else {
				$data['sppdt'] =  DB::select("select * from spp, masteritem, supplier, spp_detail  where sppd_idspp = '$id' and sppd_idspp = spp_id and kode_item = sppd_kodeitem and idsup = sppd_supplier order by sppd_seq asc");	

				$data['sppdt_barang'] = DB::select("select distinct sppd_kodeitem, nama_masteritem, sppd_qtyrequest, unitstock from  masteritem , spp_detail  where sppd_idspp = '$id' and kode_item = sppd_kodeitem");	
			}
		

		
		$data['spptb'] =  DB::select("select * from spp_totalbiaya,spp, supplier where spptb_idspp = '$id' and spptb_idspp = spp.spp_id and spptb_supplier = idsup");
		


		$dataco = DB::select("select * from confirm_order where co_idspp = '$id'");
		$pemroses = $request->pemroses;

		if($pemroses == 'PEMBELIAN'){
			$data['codt_tb'] =  DB::select("select * from confirm_order_tb_pemb, confirm_order where cotbk_idco = co_id and co_idspp = '$id' ");
			$data['counthrgbrg'] = count($data['sppdt']);
			$data['count'] = count($data['spptb']);
			$data['countbrg'] = count($data['sppdt_barang']);

			if($tipespp != 'J'){
				$data['codt'] = DB::select("select *  from confirm_order, masteritem, spp, confirm_order_dt_pemb LEFT OUTER JOIN stock_gudang on codtk_kodeitem = sg_item and codtk_lokasigudang = '$lokasigudang' where confirm_order_dt_pemb.codtk_idco=co_id and co_idspp = '$id' and co_idspp = spp_id and codtk_kodeitem = kode_item and co_idspp = spp_id");
			}
			else {
				$data['codt'] = DB::select("select *  from confirm_order, masteritem, spp, confirm_order_dt_pemb where confirm_order_dt_pemb.codtk_idco=co_id and co_idspp = '$id' and co_idspp = spp_id and codtk_kodeitem = kode_item");
			}


			

			$data['codt_supplier'] = DB::select("select distinct codtk_supplier, nama_supplier from supplier, confirm_order_dt_pemb, spp, confirm_order where codtk_supplier = idsup and co_idspp = spp_id and spp_id = '$id' and codtk_idco = co_id");
			$data['countcodt'] = count($data['codt']);
		}
		else if($pemroses == 'KEUANGAN'){
			$data['suppliertb'] = DB::select("select * from confirm_order_tb_pemb, confirm_order, supplier where cotbk_idco = co_id and co_idspp = '$id' and cotbk_supplier = idsup");
			$mankeusetuju = $dataco[0]->man_keu;
			//return json_encode($mankeusetuju);
			if($mankeusetuju == 'BELUM DI SETUJUI'){
				
			$data['codt_tb'] =  DB::select("select * from confirm_order_tb_pemb, confirm_order where cotbk_idco = co_id and co_idspp = '$id' ");
			//$data['counthrgbrg'] = count($data['sppdt']);
			$data['count'] = count($data['spptb']);
			$data['countbrg'] = count($data['sppdt_barang']);

			if($tipespp != 'J'){
				$data['codt'] = DB::select("select *  from confirm_order, masteritem, spp, confirm_order_dt_pemb LEFT OUTER JOIN stock_gudang on codtk_kodeitem = sg_item and codtk_lokasigudang = '$lokasigudang' where confirm_order_dt_pemb.codtk_idco=co_id and co_idspp = '$id' and co_idspp = spp_id and codtk_kodeitem = kode_item and co_idspp = spp_id");
			}
			else {
				$data['codt'] = DB::select("select *  from confirm_order, masteritem, spp, confirm_order_dt_pemb where confirm_order_dt_pemb.codtk_idco=co_id and co_idspp = '$id' and co_idspp = spp_id and codtk_kodeitem = kode_item");
			}

		

			$data['codt_supplier'] = DB::select("select distinct codtk_supplier, nama_supplier from supplier, confirm_order_dt_pemb, spp, confirm_order where codtk_supplier = idsup and co_idspp = spp_id and spp_id = '$id' and codtk_idco = co_id");
			$data['countcodt'] = count($data['codt']);
			}
			elseif($mankeusetuju == 'DISETUJUI'){
			//	dd($mankeusetuju);
				$data['suppliertb'] = DB::select("select * from confirm_order_tb, confirm_order, supplier where cotb_idco = co_id and co_idspp = '$id' and cotb_supplier = idsup");

				$data['codt_tb'] =  DB::select("select * from confirm_order_tb, confirm_order where cotb_idco = co_id and co_idspp = '$id' ");
				$data['counthrgbrg'] = count($data['sppdt']);
				$data['count'] = count($data['spptb']);
				$data['countbrg'] = count($data['sppdt_barang']);

				if($tipespp != 'J'){
					$data['codt'] = DB::select("select *  from confirm_order, masteritem, spp, confirm_order_dt LEFT OUTER JOIN stock_gudang on codt_kodeitem = sg_item and sg_gudang = '$lokasigudang' where confirm_order_dt.codt_idco=co_id and co_idspp = '$id' and co_idspp = spp_id and codt_kodeitem = kode_item");
				}
				else {
					$data['codt'] = DB::select("select *  from confirm_order, masteritem, spp, confirm_order_dt where confirm_order_dt.codt_idco=co_id and co_idspp = '$id' and co_idspp = spp_id and codt_kodeitem = kode_item");
				}

				$data['codt_supplier'] = DB::select("select distinct codt_supplier, nama_supplier from supplier, confirm_order_dt, spp, confirm_order where codt_supplier = idsup and co_idspp = spp_id and spp_id = '$id' and codt_idco = co_id");
				$data['countcodt'] = count($data['codt']);
			}
			
		}
		
		

	//	$data['count'] = count($data['spptb']);
		
		
		
		return json_encode($data);
	}

	public function cetakkonfirmasi($id){
		$spp = DB::select("select * from confirm_order_dt where codt_idco = '$id'");

		$grupitem = substr($spp[0]->codt_kodeitem, 0,1);
				
		$jenisitem = DB::select("select * from jenis_item where kode_jenisitem = '$grupitem'");

		$data['jenisitem'] = $jenisitem[0]->keterangan_jenisitem;
		$data['stockjenisitem'] = $jenisitem[0]->stock;
		$data['kodejenisitem'] = $jenisitem[0]->kode_jenisitem;
		$dataspp = DB::select("select * from spp where spp_id = '$id'");
		$data['tipespp'] = $dataspp[0]->spp_tipe;
		if($data['kodejenisitem'] == 'S' && $data['tipespp'] == 'NS') {
			$data['co'] = DB::select("select * from confirm_order, spp, confirm_order_dt, masteritem, supplier, kendaraan where co_id = codt_idco and codt_kodeitem = kode_item and codt_supplier = idsup and codt_idco = '$id' and co_idspp = spp_id and codt_kendaraan = kendaraan.id");

		}
		else{
			$data['co'] = DB::select("select * from confirm_order, spp, confirm_order_dt, masteritem, supplier where co_id = codt_idco and codt_kodeitem = kode_item and codt_supplier = idsup and codt_idco = '$id' and co_idspp = spp_id");

		}

		//dd($data);
		return view('purchase.confirm_order.cetak_co', compact('data'));
	}


	public function saveconfirmorderdt(Request $request){
		
		return DB::transaction(function() use ($request) { 

		if($request->pemroses == 'KEUANGAN'){
			$updatespp = spp_purchase::where('spp_id', '=', $request->idspp);
			$updatespp->update([
				'spp_status' => 'DISETUJUI',
			]);	
		}
		elseif($request->pemroses == 'PEMBELIAN') {
			$updatespp = spp_purchase::where('spp_id', '=', $request->idspp);
			$updatespp->update([
				'spp_status' => 'DIPROSES',
			]);
		}

		$idsppcodt = $request->idspp;
		$dataspp = DB::select("select * from spp where spp_id = '$idsppcodt'");
		$lokasigudang = $dataspp[0]->spp_lokasigudang;
		$co = co_purchase::find($idsppcodt);

		$codt = new co_purchasedtpemb();

		$mytime = Carbon::now();		
		if($request->pemroses == 'PEMBELIAN') {
			$co->staff_pemb = 'DISETUJUI';
			$co->time_staffpemb = $mytime;
			$co->save();

			$countapproval = count($request->barang);

			$n = 1;
			$idsup = 0;
			for($i = 0 ; $i < $countapproval; $i++) {
				if($request->status[$i] == 'SETUJU'){
						if($request->suppliercek[$i] != '' && $request->hargacek[$i] != ''){
					$lastid = co_purchasedtpemb::max('codtk_id'); 

					if(isset($lastid)) {
						$idco = (int)$lastid + 1;
					}
					else {
						$idco = 1;
					}

						$codt = new co_purchasedtpemb();

						$codt->codtk_id = $idco;
						$codt->codtk_idco = $request->idco;
						$codt->codtk_seq = $n;
						$codt->codtk_kodeitem = $request->barang[$i];
						$codt->codtk_qtyrequest = $request->qtyrequest[$i];
						$codt->codtk_qtyapproved = $request->qtyapproval[$i];
						$codt->codtk_supplier = $request->suppliercek[$i];
						
						if($request->namatipe == 'NON STOCK' && $request->jenisitem == 'S'){
							$codt->codtk_kendaraan = $request->kendaraan[$i];
						}
						
						$replacehrg = str_replace(',', '', $request->hargacek[$i]);
						$codt->codtk_harga = $replacehrg;
						$codt->codtk_tolak = $request->keterangantolak[$i];
						$codt->codtk_lokasigudang = $lokasigudang;

						$codt->save();

						$kodeitem = $request->barang[$i];

						$updatespp = sppdt_purchase::where([['sppd_idspp' , '=' , $request->idspp],['sppd_kodeitem' , '=' , $kodeitem]]);
						$updatespp->update([
							'sppd_status' => $request->status[$i],	
						]);	

						$n++;
						}	
				}
				else if($request->status[$i] == 'TIDAK SETUJU') {
					$kodeitem = $request->barang[$i];
					
					$updatespp = sppdt_purchase::where([['sppd_idspp' , '=' , $request->idspp],['sppd_kodeitem' , '=' , $kodeitem]]);
					$updatespp->update([
						'sppd_status' => 'TOLAK',
						'sppd_kettolak' => $request->keterangantolak[$i],	
					]);	
				}
						
			}	


			$cotb = new co_purchasetbpemb();
			for($k=0; $k < count($request->suppliercekbayar); $k++){
				

				if($request->suppliercekbayar[$k] == "undefined") {

				}
				else{
					$cotb = new co_purchasetbpemb();
					$lastid = co_purchasetbpemb::max('cotbk_id'); 	
					if(isset($lastid)) {
						$idcotb = (int)$lastid + 1;
					}
					else {
						$idcotb = 1;
					}
					$stringharga = $request->totalbayarpembayaran[$k];
					$replacehrg = str_replace(',', '', $stringharga);

					$cotb->cotbk_id = $idcotb;
					$cotb->cotbk_idco = $request->idco;

				
					$cotb->cotbk_supplier = $request->suppliercekbayar[$k];

					$cotb->cotbk_totalbiaya = $replacehrg;
					$cotb->cotbk_setuju = 'BELUM DI SETUJUI';
					$cotb->cotbk_bayar = $request->syaratkredit[$k];
					$cotb->save();
				}
			}

			$tempstatus = 0;

			for($p = 0; $p < count($request->status); $p++){
				if($request->status[$p] != 'SETUJU'){
					$tempstatus = (int)$tempstatus + 1;
				}
			
			}


			if($tempstatus == 0){
				$updatespp = spp_purchase::where('spp_id', '=', $request->idspp);
				$updatespp->update([
					'spp_status' => 'DISETUJUI',
				]);	
				$co = co_purchase::find($idsppcodt);
				$co->staff_pemb = 'DISETUJUI';
				$co->save();
			}
			else if($tempstatus == count($request->status)){
				$updatespp = spp_purchase::where('spp_id', '=', $request->idspp);
				$updatespp->update([
					'spp_status' => 'DITOLAK',
				]);	
				$co = co_purchase::find($idsppcodt);
				$co->staff_pemb = 'DITOLAK';
				$co->save();
			}
			else if((int)$tempstatus < count($request->status) && (int)$tempstatus > 0){
				$updatespp = spp_purchase::where('spp_id', '=', $request->idspp);
				$updatespp->update([
					'spp_status' => 'DITOLAK SEBAGIAN',
				]);	
				$co = co_purchase::find($idsppcodt);
				$co->staff_pemb = 'DITOLAK SEBAGIAN';
				$co->save();
			}
		}

		if($request->pemroses == 'KEUANGAN') {
			$co->man_keu = 'DISETUJUI';
			$co->time_mankeu = $mytime;
			$co->save();

			$countapproval = count($request->qtyapproval);

		$n = 1;
		$idsup = 0;
		for($i = 0 ; $i < $countapproval; $i++) {
			if($request->status[$i] == 'SETUJU'){
			
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


					$codt->codt_supplier = $request->datasup[$i];
					if($request->namatipe == 'NON STOCK' && $request->jenisitem == 'S') {
						$codt->codt_kendaraan = $request->nopol[$i];
					}
					
					$replacehrg = str_replace(',', '', $request->harga[$i]);
					$codt->codt_harga = $replacehrg;
					$codt->codt_tolak = $request->keterangantolak[$i];
					$codt->codt_lokasigudang = $lokasigudang;

					$codt->save();

					$kodeitem = $request->item[$i];

					$updatespp = sppdt_purchase::where([['sppd_idspp' , '=' , $request->idspp],['sppd_kodeitem' , '=' , $kodeitem]]);
					$updatespp->update([
						'sppd_status' => $request->status[$i],	
					]);	

					$n++;	
			}
			else {
				$kodeitem = $request->item[$i];

				$updatespp = sppdt_purchase::where([['sppd_idspp' , '=' , $request->idspp],['sppd_kodeitem' , '=' , $kodeitem]]);
				$updatespp->update([
					'sppd_status' => $request->status[$i],
					'sppd_kettolak' => $request->keterangantolak[$i],	
				]);	

			}		
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

			
				$cotb->cotb_supplier = $request->datasup[$k];

				$cotb->cotb_totalbiaya = $replacehrg;
				$cotb->cotb_setuju = 'BELUM DI SETUJUI';
				$cotb->cotb_bayar = $request->spptb_bayar[$k];
				$cotb->save();
			}
			}

						$tempstatus = 0;

			for($p = 0; $p < count($request->status); $p++){
				if($request->status[$p] != 'SETUJU'){
					$tempstatus = (int)$tempstatus + 1;
				}
			
			}


			if($tempstatus == 0){
				$updatespp = spp_purchase::where('spp_id', '=', $request->idspp);
				$updatespp->update([
					'spp_status' => 'DISETUJUI',
				]);	
				$co = co_purchase::find($idsppcodt);
				$co->man_keu = 'DISETUJUI';
				$co->save();
			}
			else if($tempstatus == count($request->status)){
				$updatespp = spp_purchase::where('spp_id', '=', $request->idspp);
				$updatespp->update([
					'spp_status' => 'DITOLAK',
				]);	
				$co = co_purchase::find($idsppcodt);
				$co->man_keu = 'DITOLAK';
				$co->save();
			}
			else if((int)$tempstatus < count($request->status) && (int)$tempstatus > 0){
				$updatespp = spp_purchase::where('spp_id', '=', $request->idspp);
				$updatespp->update([
					'spp_status' => 'DITOLAK SEBAGIAN',
				]);	
				$co = co_purchase::find($idsppcodt);
				$co->man_keu = 'DITOLAK SEBAGIAN';
				$co->save();
			}
		}


		$data['co'] = DB::select("select * from confirm_order where co_idspp = '$idsppcodt'");
		$data['spp'] = DB::select("select * from spp, masterdepartment, cabang where spp_bagian = kode_department and spp_id = '$idsppcodt' and spp_cabang =  kode ");
	//	dd($data['spp']);
		

		return json_encode('sukses');

		});
		
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

		$cabang = session::get('cabang');

		if(Auth::user()->punyaAkses('Purchase Order','all')){
			$data['po'] = DB::select("select * from pembelian_order, supplier, cabang where po_supplier = idsup and po_cabang = kode  and po_statusreturn = 'AKTIF' order by po_id desc");
			$data['spp'] = DB::select("select * from  spp, supplier, cabang, confirm_order, confirm_order_tb where co_idspp = spp_id and staff_pemb = 'DISETUJUI' and man_keu = 'DISETUJUI' and spp_cabang = kode and cotb_idco = co_id and cotb_supplier = idsup  and cotb_setuju = 'BELUM DI SETUJUI'");

			$data['countspp'] = count($data['spp']);
			
			$data['posetuju'] = DB::table("pembelian_order")->where([['po_setujufinance' , '=' , 'DISETUJUI'],['po_statusreturn' , '=' , 'AKTIF']])->count();

			$data['porevisi'] = DB::table("pembelian_order")->where([['po_setujufinance' , '=' , 'DIREVISI'],['po_statusreturn' , '=' , 'AKTIF']])->count();
			$data['poditolak'] = DB::table("pembelian_order")->where([['po_setujufinance' , '=' , 'DITOLAK'],['po_statusreturn' , '=' , 'AKTIF']])->count();

			$data['poblmdiproses'] = DB::table("pembelian_order")->whereNull('po_setujufinance')->where('po_statusreturn' , '=' , 'AKTIF')->count();

			Session::flash('message', 'Terdapat ' . count($data['spp']). ' data SPP yang belum di proses'); 

		}
		else{
			$data['po'] = DB::select("select * from pembelian_order, supplier, cabang where po_supplier = idsup and po_cabang = kode and po_cabang = '$cabang' and po_statusreturn = 'AKTIF' order by po_id desc");
			$data['spp'] = DB::select("select * from  spp, supplier, cabang, confirm_order, confirm_order_tb where co_idspp = spp_id and man_keu = 'DISETUJUI' and staff_pemb = 'DISETUJUI' and spp_cabang = kode and cotb_idco = co_id and cotb_supplier = idsup  and cotb_setuju = 'BELUM DI SETUJUI'");

			$data['countspp'] = count($data['spp']);
			
			$data['posetuju'] = DB::table("pembelian_order")->where([['po_setujufinance' , '=' , 'DISETUJUI'],['po_statusreturn' , '=' , 'AKTIF'],['po_cabang' , '=' , $cabang]])->count();

			$data['porevisi'] = DB::table("pembelian_order")->where([['po_setujufinance' , '=' , 'DIREVISI'],['po_statusreturn' , '=' , 'AKTIF'], ['po_cabang' , '=' , $cabang]])->count();
			$data['poditolak'] = DB::table("pembelian_order")->where([['po_setujufinance' , '=' , 'DITOLAK'],['po_statusreturn' , '=' , 'AKTIF'],['po_cabang' , '=' , $cabang]])->count();

			$data['poblmdiproses'] = DB::table("pembelian_order")->whereNull('po_setujufinance')->where('po_statusreturn' , '=' , 'AKTIF')->where('po_cabang' , '=' , $cabang)->count();

			Session::flash('message', 'Terdapat ' . count($data['spp']). ' data SPP yang belum di proses'); 
		}
		




	//	dd($data);
		 return view('purchase/purchase/index', compact('data'));

	}

	

	public function ajax_tampilspp(Request $request){
		$array =  $request->idspp;
		$data = array();
			$explode = explode("," , $array[0]);
			$idsupplier = $explode[1];
		//	return $idsupplier ;
			$data['supplier'] = DB::select("select * from supplier where idsup ='$idsupplier' and active = 'AKTIF' ");

			$data['itemsupplier'] = [];
		for($j=0; $j < count($array); $j++){
				$explode = explode("," , $array[$j]);
				$idspp = $explode[0]; 
				$nosupplier = $explode[1]; 
				$gudang = $explode[2];
				$idcotb = $explode[5];
				$idco = $explode[6];

			if($gudang == 'null'){
							$data['spp'][] = DB::select("select * from spp, spp_totalbiaya, confirm_order, confirm_order_tb, supplier , cabang where co_idspp = spp_id and spp_id = '$idspp' and spp_cabang = kode and cotb_idco = co_id and cotb_supplier = idsup and active = 'AKTIF' and idsup = '$nosupplier' and cotb_supplier = '$nosupplier' and spptb_idspp = '$idspp' and spptb_supplier = cotb_supplier and cotb_id = '$idcotb' and co_id = '$idco' and cotb_idco = co_id");
			}	
			else {
							$data['spp'][] = DB::select("select * from mastergudang, spp, spp_totalbiaya, confirm_order, confirm_order_tb, supplier , cabang where co_idspp = spp_id and spp_id = '$idspp' and spp_cabang = kode and cotb_idco = co_id and cotb_supplier = idsup and active = 'AKTIF' and idsup = '$nosupplier' and cotb_supplier = '$nosupplier' and spptb_idspp = '$idspp' and spptb_idspp = spp_id and spp_lokasigudang = mg_id and spptb_supplier = cotb_supplier and cotb_id = '$idcotb' and co_id = '$idco' and cotb_idco = co_id");
							$data['gudang'] = DB::select("select * from mastergudang where mg_id = '$gudang'");
			}	
			
			$datacodt = DB::select("select * from confirm_order_dt where codt_idco = '$idspp'");
			$dataspp = DB::select("select * from spp where spp_id = '$idspp'");

			$grupitem = substr($datacodt[0]->codt_kodeitem, 0,1);
		
			$jenisitem = DB::select("select * from jenis_item where kode_jenisitem = '$grupitem'");

			$data['jenisitem'] = $jenisitem[0]->keterangan_jenisitem;
			$data['stockjenisitem'] = $jenisitem[0]->stock;
			$data['kodejenisitem'] = $jenisitem[0]->kode_jenisitem;
			$tipespp = $dataspp[0]->spp_tipe;

			if($tipespp == 'NS' && $data['jenisitem'] == 'S'){
				$data['codt'][] = DB::select("select * from confirm_order, confirm_order_dt , confirm_order_tb, spp, masteritem, kendaraan where co_idspp = '$idspp' and codt_idco = co_id and cotb_idco = co_id and co_idspp = spp_id and codt_supplier = cotb_supplier and codt_supplier = '$nosupplier' and codt_kodeitem = kode_item and cotb_id = '$idcotb' and co_id = '$idco' and codt_kendaraan = kendaraan.id ");

			}
			else {
				$data['codt'][] = DB::select("select * from confirm_order, confirm_order_dt , confirm_order_tb, spp, masteritem where co_idspp = '$idspp' and codt_idco = co_id and cotb_idco = co_id and co_idspp = spp_id and codt_supplier = cotb_supplier and codt_supplier = '$nosupplier' and codt_kodeitem = kode_item and cotb_id = '$idcotb' and co_id = '$idco' ");

			}
		
			///testtt
		}

		for($i = 0; $i < count($array); $i++){
			for($key = 0; $key < count($data['codt'][$i]); $key++){

				$kodeitem = $data['codt'][$i][$key]->codt_kodeitem;
				$supplier = $data['codt'][$i][$key]->codt_supplier;
				$dataitemsupplier = DB::select("select * from itemsupplier where is_kodeitem = '$kodeitem' and is_idsup = '$supplier'");

				$itemsupplier2 = ([
					'is_keteranganitem' => ''
				]);

				if(count($dataitemsupplier) != 0){
					$itemsupplier = $dataitemsupplier[0]->is_keteranganitem;
					array_push($data['itemsupplier'] , $itemsupplier);
				}
				else {
					$itemsupplier = $itemsupplier2;
					array_push($data['itemsupplier'] , $itemsupplier);
				}

			}
		}
		
			

		return json_encode($data);
	}

	public function updatekeuangan(Request $request){
		
		
		

		return json_encode($idpo);
	}

	public function detailpurchasekeuangan(Request $request){
		$id = $request->poid;
		$data['po'] = DB::select("select * from pembelian_order, supplier, cabang where po_id = '$id' and po_supplier = idsup and active = 'AKTIF' and po_cabang = kode and po_statusreturn = 'AKTIF' ");

		$data['supplier'] = DB::select("select * from supplier where active='AKTIF'");
		$tipepo = $data['po'][0]->po_tipe;

		if($tipepo != 'J'){
			$data['podt'] = DB::select("select * from pembelian_orderdt, spp, masteritem, cabang, mastergudang where podt_idpo = '$id' and podt_idspp = spp_id and podt_kodeitem = kode_item and spp_cabang = kode and podt_lokasigudang = mg_id");
		}
		else {
			$data['podt'] = DB::select("select * from pembelian_orderdt, spp, masteritem, cabang where podt_idpo = '$id' and podt_idspp = spp_id and podt_kodeitem = kode_item and spp_cabang = kode ");	
		}

		$data['spp'] = DB::select("select distinct spp_id , spp_nospp , spp_keperluan, nama_department , nama , spp_tgldibutuhkan from  pembelian_order , spp, pembelian_orderdt, cabang, masterdepartment where po_id = '$id' and podt_idpo = po_id  and podt_idspp = spp_id and spp_cabang = kode and spp_bagian = kode_department ");
		
		$idspp = [];
		for($i =0; $i < count($data['spp']); $i++){
			$data['idspp'][]= $data['spp'][$i]->spp_id;
			 array_push($idspp , $data['idspp']);
		}

		$data['gudang'] = DB::select("select * from mastergudang");
		$data['pbpo'] = DB::select("select pb_po from penerimaan_barang where pb_po = '$id'");

	

		/*dd($data['idspp']);*/

		if($tipepo != 'J'){
			for($j=0; $j < count($idspp); $j++){
			$data['podtbarang'][] = DB::select("select * from  pembelian_orderdt, masteritem, mastergudang where podt_idspp = ". $data['idspp'][$j] ." and podt_kodeitem = kode_item and podt_lokasigudang = mg_id and podt_idpo='$id'");
			}
		}	
		else {
			for($j=0; $j < count($idspp); $j++){
			$data['podtbarang'][] = DB::select("select * from  pembelian_orderdt, masteritem where podt_idspp = ". $data['idspp'][$j] ." and podt_kodeitem = kode_item and podt_idpo='$id'");
			}
		}	
		
		$data['countbrg'] = count($idspp);
 		
 		$data['bt'] = DB::select("select * from barang_terima where bt_idtransaksi = '$id' and bt_flag = 'PO' and bt_statuspenerimaan != 'BELUM DI TERIMA'");

	//	dd($data);

		return json_encode($data);
	}

	public function detailpurchase($id) {		
		$data['po'] = DB::select("select * from pembelian_order, supplier, cabang where po_id = '$id' and po_supplier = idsup and active = 'AKTIF' and po_cabang = kode and po_statusreturn = 'AKTIF' ");

		$data['supplier'] = DB::select("select * from supplier where active='AKTIF'");

		if($data['po'][0]->po_tipe == 'J') {
			$data['podt'] = DB::select("select * from pembelian_orderdt, spp, masteritem, cabang, mastergudang where podt_idpo = '$id' and podt_idspp = spp_id and podt_kodeitem = kode_item and spp_cabang = kode and podt_lokasigudang = mg_id");
		}
		else {
			$data['podt'] = DB::select("select * from pembelian_orderdt, spp, kendaraan, masteritem, cabang where podt_idpo = '$id' and podt_idspp = spp_id and podt_kodeitem = kode_item and spp_cabang = cabang.kode and podt_kendaraan = kendaraan.id");	
		}


		$data['spp'] = DB::select("select distinct spp_id , spp_nospp , spp_keperluan, nama_department , nama , spp_tgldibutuhkan from  pembelian_order , spp, pembelian_orderdt, cabang, masterdepartment where po_id = '$id' and podt_idpo = po_id  and podt_idspp = spp_id and spp_cabang = kode and spp_bagian = kode_department ");
		
		$idspp = [];
		for($i =0; $i < count($data['spp']); $i++){
			$data['idspp'][]= $data['spp'][$i]->spp_id;
			 array_push($idspp , $data['idspp']);
		}

		$data['gudang'] = DB::select("select * from mastergudang");


	

		/*dd($data['idspp']);*/

		for($j=0; $j < count($idspp); $j++){
			if($data['po'][0]->po_tipe != 'J') {
				$data['podtbarang'][] = DB::select("select * from kendaraan, pembelian_orderdt, masteritem, mastergudang where podt_idspp = ". $data['idspp'][$j] ." and podt_kodeitem = kode_item and podt_lokasigudang = mg_id and podt_idpo='$id' and podt_kendaraan = kendaraan.id");
			}
			else {
				$data['podtbarang'][] = DB::select("select * from  pembelian_orderdt, masteritem where podt_idspp = ". $data['idspp'][$j] ." and podt_kodeitem = kode_item and podt_idpo='$id'");
			}
		}

		$data['countbrg'] = count($idspp);
 		
 		
	//	dd($data);

		return view('purchase/purchase/detail_purchase', compact('data'));
	}

	public function updatepurchase($id, Request $request){

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

		if($request->ppn != ''){
			$updatepo->update([
				'po_ppn' => $request->ppn,
				'po_jenisppn' => $request->jenisppn
			]);
		}

		if($request->diskon != ''){
				$updatepo->update([
					'po_diskon' => $request->diskon,
				]);
		}

		$updatepo->update([
			'po_catatan' => $request->catatan,
			'po_bayar' => $request->bayar,
			'po_supplier' => $request->supplier,
			'po_subtotal' =>$replacesubtotal,
			'po_totalharga' => $replacetotal,
			'po_status' => $status,
		]);			 	

		for($j = 0; $j < count($request->statuskirim); $j++) {
			$jumlahharga = str_replace(',', '', $request->jumlahharga[$j]);
			$totalharga2 = str_replace(',', '', $request->totalharga2[$j]);

			$updatepodt = purchase_orderdt::where([['podt_idpo' , '=', $id],['podt_kodeitem' , '=' , $request->kodeitem[$j]]]);
			$updatepodt->update([
				'podt_qtykirim' => $request->qtykirim[$j],
				'podt_supplier' => $request->supplier,
				'podt_jumlahharga' => $jumlahharga,
				'podt_statuskirim' => $request->statuskirim[$j],
				'podt_lokasigudang' => $request->lokasigudang[$j],
				'podt_totalharga' => $totalharga2
			]);
		}

		return json_encode('sukses');	
	}

	public function savepurchase(Request $request){
		
			//dd($request);
		return DB::transaction(function() use ($request) {  
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

		
				$year = Carbon::createFromFormat('Y-m-d H:i:s', $time)->year; 
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
					$idpo = str_pad($string, 4, '0', STR_PAD_LEFT);
				}

				else {
					$idpo = '0001';
				}

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

			$idsup = $request->idsupplier;
			$dataacchutang = DB::select("select * from supplier where idsup = '$idsup'");
			$acchutangdagang = $dataacchutang[0]->acc_hutang;
			$subacchutang = substr($acchutangdagang, 0 , 4);
			$idspp =$request->idspp[0];
			$dataspp = DB::select("select * from spp where spp_id = '$idspp'");
			$datacomp = $dataspp[0]->spp_cabang;

			$datakun = DB::select("select * from d_akun where id_akun LIKE '$subacchutang%' and  kode_cabang = '$datacomp'");
			$acchutang = $datakun[0]->id_akun;

				$po = new purchase_orderr();
				$po->po_id = $po_id;
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
					$hasilppn = str_replace(',', '', $request->hasilppn);
					$po->po_ppn = strtoupper($request->ppn);
					$po->po_hasilppn = $hasilppn;
				}
				$po->po_subtotal = $replacesubtotal;
				$po->po_totalharga = $replacetotal;
				$po->po_noform = 'JPM/FR/PURC/02 Januari-' . $year;
				$po->po_cabang = $comp;
				$po->po_updatefp = 'T';
				$po->po_tipe = $request->spptipe;
				$po->po_penerimaan = $request->spp_penerimaan;
				$po->po_jenisppn = $request->jenisppn;
				$po->po_statusreturn = 'AKTIF';
				$po->po_cabangtransaksi = $datacomp;
				$po->create_by = $request->username;
				$po->update_by = $request->username;

				$po->po_acchutangdagang = $acchutang;

				$po->save();

				$idspp =$request->idspp[0];
				$dataspp = DB::select("select * from spp where spp_id = '$idspp'");
				$datacomp = $dataspp[0]->spp_cabang;
				$tglspp = $dataspp[0]->spp_tglinput;

				/*$explodetglspp = explode("/", $tglspp);
				$substrtglspp = substr($explodetglspp[0], 3,7);
				$getmonth = substr($substrtglspp, 0,2);
				$getyear = substr($substrtglspp, 2,2);
				$tahun = '20' . $getyear;
				$tglspp = $tahun . '-' . $getmonth . '-' . '09'; */ 
			
				DB::table('pembelian_order')
				->where('po_id' , $po_id)
				->update(['po_tglspp' => $tglspp]);

				$getmonth = Carbon::parse($tglspp)->format('m');
				$getyear = Carbon::parse($tglspp)->format('y');

				$carinota = DB::select("SELECT  substring(max(po_no),12) as id from pembelian_order
                                        WHERE po_cabangtransaksi = '$datacomp'
                                        AND to_char(po_tglspp,'MM') = '$getmonth'
                                        AND to_char(po_tglspp,'YY') = '$getyear'");
          
  
	            $index = (integer)$carinota[0]->id + 1;
	            $index = str_pad($index, 4, '0' , STR_PAD_LEFT);
	            $nota = 'PO' .  $getmonth . $getyear . '/' . $datacomp . '/' . $index;

	          
	          DB::table('pembelian_order')
	           ->where('po_id' , $po_id)
	          ->update(['po_no' => $nota]);



			for($n = 0; $n < count($request->kodeitem); $n++) {
				$kodeitem = $request->kodeitem[$n];
				$dataitem = DB::select("select * from masteritem where kode_item = '$kodeitem'");
				
				if($request->spptipe == 'S'){
					$akunitem = substr($dataitem[0]->acc_persediaan, 0,4);

				}
				else {
					$akunitem = substr($dataitem[0]->acc_hpp, 0,4);
				}

				$datakun2 = DB::select("select * from d_akun where id_akun LIKE '$akunitem%' and kode_cabang = '$datacomp'");

				if(count($datakun2) == 0){
					DB::rollback();
					 $dataInfo=['status'=>'gagal','info'=>'Akun '.$akunitem .' Untuk Cabang ' .$datacomp. ' Belum Tersedia'];
					return json_encode($dataInfo);				
				}

				


				$dataakunitem = $datakun2[0]->id_akun;
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
				$podt->podt_keterangan = $request->keterangandt[$n];
				if($request->spptipe != 'J'){					
					$podt->podt_lokasigudang = strtoupper($request->lokasikirim[$n]);

				}
				
				$podt->podt_akunitem = $dataakunitem;
				$podt->podt_sisaterima = $request->qtykirim[$n];
				if($dataspp[0]->spp_tipe == 'NS' && $request->jenisitem == 'SPARE PART KENDARAAN'){
					$podt->podt_kendaraan = $request->kendaraan[$n];
				}

				$podt->save();

					/*	$updatesppdt = sppdt_purchase::where([['sppd_idspp', '=', $id], ['spp_detail.sppd_idsppdetail' , '=' , $request->idsppd[$i]]]);*/

				$updatespptb = spptb_purchase::where([['spptb_idspp', '=', $request->idspp[$n]] , ['spptb_supplier' , '=' , $request->nosupplier]]);

					$updatespptb->update([
					 	'spptb_poid' => $po_id
				 		]);	
/*
					$updatespp = spp_purchasse::where('spp_id' , '=' , $request->idspp[$n]);
					$updatespp->update([
							'spp_status' => 'DISETUJUI',
					]);*/
			}

			$lokasigudang = [];
			$updatepo = purchase_orderr::where('po_id', '=', $po_id);
			$updatepo->update([
				'po_setujufinance' => 'SETUJU',
			]);	
			for($j=0; $j < count($request->idspp); $j++){
			$idspp = $request->idspp[$j];
				if($idspp != '') {
					$updatespp = spp_purchase::where('spp_id' , '=' , $idspp);
					$updatespp->update([
						'spp_status' => 'TERBIT PO'
					]);

				}
			}

			$po = DB::select("select * from pembelian_order, pembelian_orderdt where podt_idpo = po_id and po_id = '$po_id'");

			$tipepo = $po[0]->po_tipe;
			if($tipepo != 'J'){
				for($ds = 0; $ds < count($po); $ds++){
				$namagudang = $po[$ds]->podt_lokasigudang;
				array_push($lokasigudang , $namagudang);		
			}
			
			$idgudang = array_unique($lokasigudang);

			
			for($j=0;$j < count($idgudang); $j++) {
				$lastid = barang_terima::max('bt_id'); 

				if(isset($lastid)) {
					$idbarangterima = $lastid;
					$idbarangterima = (int)$idbarangterima + 1;
					
				}

				else {
					$idbarangterima = 1;
					
				}
					$nopo = DB::select("select * from pembelian_order where po_id = '$po_id'");
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


		$dataInfo=['status'=>'sukses','info'=> $po_id];

		return json_encode($dataInfo);	

		});	
			
		
	}

	public function createpurchase(){
		$data['spp_asli'] = DB::select("select * from confirm_order, spp where co_idspp = spp_id");
		
		$data['spp'] = DB::select("select * from  spp, supplier, cabang, confirm_order, confirm_order_tb where co_idspp = spp_id and man_keu = 'DISETUJUI' and staff_pemb = 'DISETUJUI' and spp_cabang = kode and cotb_idco = co_id and cotb_supplier = idsup  and cotb_setuju = 'DISETUJUI'");

		$data['po'] = DB::select("select * from spp, pembelian_orderdt where podt_idspp = spp_id");
		$data['cabang'] = DB::select('select * from cabang');

//		$lokasigudang = $data['spp']
		$data['gudang'] = masterGudangPurchase::all();
		//dd($data);


		return view('purchase/purchase/create',compact('data'));
	}


	public function deletepurchase($id){
		/*DB::delete("DELETE from  pembelian_order where po_id = '$id'");*/
		return DB::transaction(function() use ($id) {
		$data2 = purchase_orderr::find($id); 
		
		$data['spptb'] = DB::select("select * from spp_totalbiaya where spptb_poid = '$id'");
		

		for ($j = 0; $j < count($data['spptb']); $j++){
			$idspp = $data['spptb'][$j]->spptb_idspp;

			$dataco = DB::select("select * from confirm_order where co_idspp = '$idspp'");
			$idco = $dataco[$j]->co_id;
			$idsupplier = $data['spptb'][$j]->spptb_supplier;
			$data['header3'] = DB::table('confirm_order_tb')
							->where([['cotb_idco', '=' , $idco],['cotb_supplier', '=' , $idsupplier]])
							->update([
								'cotb_setuju' => 'BELUM DI SETUJUI',
								'cotb_timesetuju' => null,
		
							]); 
			//return json_encode($idco . $idspp);			
		}
		//
		$data2->delete($data2);
			$updatespptb = spptb_purchase::where('spptb_poid', '=' , $id );
		$updatespptb->update([
		 	'spptb_poid' => null
	 		]);

		$barangterima = DB::select("select * from barang_terima where bt_idtransaksi = '$id' and bt_flag = 'PO' and bt_statuspenerimaan != 'BELUM DI TERIMA'");
		if(count($barangterima) > 0){
			DB::rollback();
			$datainfo = [
				'datainfo' => 'gagal',
				'message' => 'Data sudah masuk gudang',
			];
		}
		else {
			DB::delete("DELETE FROM barang_terima where bt_idtransaksi = '$id' and bt_flag = 'PO'");
			$datainfo = [
				'datainfo' => 'sukses',
				'message' => 'Data sudah masuk gudang',
			];
		}

       	Session::flash('sukses', 'data item berhasil dihapus');
        return json_encode($datainfo);
    });
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
					$data['spp'] = DB::select("select * from  spp, supplier, cabang, confirm_order, confirm_order_tb where co_idspp = spp_id and man_keu = 'DISETUJUI' and staff_pemb = 'DISETUJUI' and spp_cabang = kode and cotb_idco = co_id and cotb_supplier = idsup  and cotb_setuju = 'BELUM DI SETUJUI' and kode = '$comp'");
			}
			else {
					$data['spp'] = DB::select("select * from  spp, supplier, cabang, confirm_order, confirm_order_tb where co_idspp = spp_id and man_keu = 'DISETUJUI' and staff_pemb = 'DISETUJUI' and spp_cabang = kode and cotb_idco = co_id and cotb_supplier = idsup  and cotb_setuju = 'BELUM DI SETUJUI'");	
			}

			return json_encode($data);
	}

	public function grapcabang(){
		$data = DB::table('cabang')->select('kode', 'nama')->get();

		return json_encode($data);
	}

	//warehouse 

	public function penerimaanbarang() {

		$cabang = session::get('cabang');

		$gudangcomp = DB::select("select * from mastergudang where mg_cabang = '$cabang'");
		$idgudang = $gudangcomp[0]->mg_id;
		$data['idgudang'] = $idgudang;
		$data['terima'] = DB::select("select * from barang_terima where bt_gudang = '$idgudang'");

		for($i= 0; $i < count($data['terima']); $i++) {
			$tipe = $data['terima'][$i]->bt_flag;
			$idbt = $data['terima'][$i]->bt_id;
			if($tipe == 'PBG'){
				$terimages = DB::select("select *, nama as namasupplier from barang_terima, cabang where bt_gudang = '$idgudang' and bt_agen = kode and bt_id = '$idbt' and bt_flag = '$tipe'");		
			}
			else {
				$terimages = DB::select("select *, nama_supplier as namasupplier from barang_terima, supplier where bt_gudang = '$idgudang' and bt_supplier = idsup and bt_id = '$idbt' and bt_flag = '$tipe'");		
			}
			$data['flag'][] = $tipe;
			$data['terimasaja'][] = $terimages;
		}
		

		$data['gudang'] = DB::select("select * from mastergudang");
	

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
		$data['terima'] = DB::select("select * from barang_terima where bt_gudang = '$idgudang'");
		
		for($i = 0; $i < count($data['terima']); $i++){
			$tipe = $data['terima'][$i]->bt_flag;
			$idbt = $data['terima'][$i]->bt_id;
			if($tipe == 'PBG'){
				$terimages = DB::select("select *, nama as namasupplier from barang_terima, cabang where bt_gudang = '$idgudang' and bt_agen = kode and bt_id = '$idbt' and bt_flag = '$tipe'");		
			}
			else {
				$terimages = DB::select("select *, nama_supplier as namasupplier from barang_terima, supplier where bt_gudang = '$idgudang' and bt_supplier = idsup and bt_id = '$idbt' and bt_flag = '$tipe'");		
			}
			$data['flag'][] = $tipe;
			$data['terimasaja'][] = $terimages;
		}

		return json_encode($data);
	}

	public function valgudang(Request $request){
		$idcabang = $request->cabang;
	
		$data['gudang'] = DB::select("select * from mastergudang where mg_cabang = '$idcabang'");

		
		$idgudang = $data['gudang'][0]->mg_id;
		$data['terima'] = DB::select("select * from barang_terima, supplier where bt_gudang = '$idgudang' and bt_supplier = idsup");

		return json_encode($data);
	}


	public function savepenerimaan2 (Request $request){
		$datajurnal = [];
		$totalhutang = 0;
		for($i = 0; $i < count($request->accpersediaan); $i++){
			$totalharga = $request->qtyterima[$i] * $request->jumlahharga[$i];

			$datajurnal[$i]['id_akun'] = $request->accpersediaan[$i];
			$datajurnal[$i]['subtotal'] = $totalharga;
			$datajurnal[$i]['dk'] = 'D';

			$totalhutang = $totalhutang + $totalharga;
		}	


		$dataakun = array (
			'id_akun' => $request->acchutangsupplierpo,
			'subtotal' => $totalhutang,
			'dk' => 'K',
			);

		array_push($datajurnal, $dataakun );

		return json_encode($datajurnal);
	}

	public function savepenerimaan(Request $request){
    return DB::transaction(function() use ($request) {   

		$dataItems=[];
		$akun=[];
		$idsppupdate = [];
		$arrayspp = [];

		$datajurnal = [];
		$totalhutang = 0;
			
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
		
		/*$year =Carbon::createFromFormat('Y-m-d H:i:s', $time)->year; 
		$month =Carbon::createFromFormat('Y-m-d H:i:s', $time)->month; */

		$month = Carbon::parse($request->tgl_dibutuhkan)->format('m');
		$year = Carbon::parse($request->tgl_dibutuhkan)->format('y');

		
	
	
		$idpb2 = DB::select("select substr(MAX(pb_lpb), 16) as nota from penerimaan_barang where  to_char(pb_date, 'MM') = '$month' and to_char(pb_date, 'YY') = '$year' and pb_comp = '$cabang'");	
		

		//return $faktur;
		if(count($idpb2) > 0) {	
			$idpb = (int)$idpb2[0]->nota + 1;
			$idpb = str_pad($idpb, 4, '0', STR_PAD_LEFT);
			
			//return $data['idfaktur'];
		}

		else {
	
			$idpb = '0001';
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
			$penerimaanbarang->pb_suratjalan = strtoupper($request->suratjalan);
			$penerimaanbarang->pb_supplier = $request->idsup;
			$penerimaanbarang->pb_gudang = $request->gudang;
			$penerimaanbarang->pb_terimadari = strtoupper($request->diterimadari);
			$penerimaanbarang->create_by = $request->username;
			$penerimaanbarang->update_by = $request->username;
			$penerimaanbarang->pb_acchutangdagang = $request->acchutangsupplierpo;
			$penerimaanbarang->pb_keterangan = strtoupper($request->keterangan);
			
			$penerimaanbarang->save();

			for($i = 0 ; $i < count($request->qtyterima); $i++ ){
				$penerimaanbarangdt = new penerimaan_barangdt();

		
				if($request->qtyterima[$i] != '') { // TIDAK SAMPLING
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
					$idpodt = $request->idpodt[$i];

				

					//melihatqtydisetiapitem
				$select = DB::select("select * from penerimaan_barangdt where pbdt_item = '$iditem2' and pbdt_po = '$no_po' and pbdt_idspp = '$idspp' "); 
				
				//melihatqtydikirimdisetiapitem
				$selectdikirim = DB::select("select * from pembelian_orderdt where podt_idpo = '$no_po' and podt_kodeitem = '$iditem2' and podt_idspp='$idspp' and podt_id = '$idpodt'");

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
					$totalharga = (int)$request->qtyterima[$i] * (int)$request->jumlahharga[$i];

					$penerimaanbarangdt->pbdt_id = $idpbdt;
					$penerimaanbarangdt->pbdt_idpb = $idpbpk;
					$penerimaanbarangdt->pbdt_date = $mytime;
					$penerimaanbarangdt->pbdt_item = $request->kodeitem[$i];
					$penerimaanbarangdt->pbdt_qty = $request->qtyterima[$i];	
					$penerimaanbarangdt->pbdt_hpp =$request->jumlahharga[$i];
					$penerimaanbarangdt->pbdt_po =$request->po_id;
					$penerimaanbarangdt->pbdt_updatestock =$request->updatestock;
					$penerimaanbarangdt->pbdt_status = $status;
					$penerimaanbarangdt->pbdt_suratjalan = $request->suratjalan;
					$penerimaanbarangdt->pbdt_totalharga = $totalharga;
					$penerimaanbarangdt->pbdt_idspp = $request->idspp[$i];
					$penerimaanbarangdt->pbdt_acchpp = $request->acchpp[$i];
					$penerimaanbarangdt->pbdt_accpersediaan = $request->accpersediaan[$i];
					$penerimaanbarangdt->create_by = $request->username;
					$penerimaanbarangdt->update_by = $request->username;
					$penerimaanbarangdt->save();

					$accpersediaan = $request->accpersediaan[$i];

					$datakun2 = DB::select("select * from d_akun where id_akun LIKE '$accpersediaan' and kode_cabang = '$cabang'");

					$akundka = $datakun2[0]->akun_dka;

					$updatepo = purchase_orderdt::where([['podt_id' , '=' , $idpodt],['podt_kodeitem' , '=' , $request->kodeitem[$i]],['podt_idpo' , '=' , $no_po]]);


					$selisihsisa = (int)$quantitikirim - (int)$request->qtyterima[$i];
					$updatepo->update([
						'podt_sisaterima' => $selisihsisa,					
					]);


					if($akundka == 'D'){
						$datajurnal[$i]['id_akun'] = $request->accpersediaan[$i];
						$datajurnal[$i]['subtotal'] = $totalharga;
						$datajurnal[$i]['dk'] = 'D';
						$datajurnal[$i]['detail'] = $request->keterangandt[$i];
						$totalhutang = $totalhutang + $totalharga;

					}
					else {
						$datajurnal[$i]['id_akun'] = $request->accpersediaan[$i];
						$datajurnal[$i]['subtotal'] = '-' .$totalharga;
						$datajurnal[$i]['dk'] = 'D';
						$datajurnal[$i]['detail'] = $request->keterangandt[$i];
						$totalhutang = $totalhutang + $totalharga;
					}					

				}
				else if($request->qtyterima[$i] == '') { // SAMPLING
				
					if($request->qtysampling[$i] != ''){

					/*$dataItems[$i]['accpersediaan']=$request->accpersediaan[$i];					
					$dataItems[$i]['subtotal']=$request->jumlahharga[$i]*$request->qtydikirim[$i];	*/

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
						$totalharga = (int)$request->qtysampling[$i] * (int)$request->jumlahharga[$i];

						$penerimaanbarangdt->pbdt_id = $idpbdt;
						$penerimaanbarangdt->pbdt_idpb = $idpbpk;
						$penerimaanbarangdt->pbdt_date = $mytime;
						$penerimaanbarangdt->pbdt_item = $request->kodeitem[$i];
						$penerimaanbarangdt->pbdt_qty = $request->qtysampling[$i];	
						$penerimaanbarangdt->pbdt_hpp =$request->jumlahhharga[$i];
						$penerimaanbarangdt->pbdt_po =$request->po_id;
						$penerimaanbarangdt->pbdt_updatestock =$request->updatestock;
						$penerimaanbarangdt->pbdt_status = $status2;
						$penerimaanbarangdt->pbdt_suratjalan = $request->suratjalan;
						$penerimaanbarangdt->pbdt_totalharga = $totalharga;
						$penerimaanbarangdt->pbdt_idspp = $request->idspp[$i];
						$penerimaanbarangdt->pbdt_acchpp = $request->acchpp[$i];
						$penerimaanbarangdt->pbdt_accpersediaan = $request->accpersediaan[$i];
						$penerimaanbarangdt->create_by = $request->username;
						$penerimaanbarangdt->save();


						$updatepo = purchase_orderdt::where([['podt_id' , '=' , $idpodt],['podt_item' , '=' , $request->kodeitem[$i]],['podt_idpo' , '=' , $no_po]]);


						$selisihsisa = (int)$quantitikirim - (int)$request->qtyterima[$i];
						$updatepo->update([
							'podt_sisaterima' => $selisihsisa,					
						]);

						$accpersediaan = $request->accpersediaan[$i];

						$datakun2 = DB::select("select * from d_akun where id_akun LIKE '$accpersediaan' and kode_cabang = '$cabang'");

						$akundka = $datakun2[0]->akun_dka;

						if($akundka == 'D'){
							$datajurnal[$i]['id_akun'] = $request->accpersediaan[$i];
							$datajurnal[$i]['subtotal'] = $totalharga;
							$datajurnal[$i]['dk'] = 'D';
							$datajurnal[$i]['detail'] = $request->keterangandt[$i];
							$totalhutang = $totalhutang + $totalharga;

						}
						else {
							$datajurnal[$i]['id_akun'] = $request->accpersediaan[$i];
							$datajurnal[$i]['subtotal'] = '-' .$totalharga;
							$datajurnal[$i]['dk'] = 'D';
							$datajurnal[$i]['detail'] = $request->keterangandt[$i];
							$totalhutang = $totalhutang + $totalharga;
						}
					}
				}
			}

			$no_po = $request->po_id;
			$nomor= $request->ref;   
			
			//update status pb header
			$statusheaderpb = DB::select("select * from penerimaan_barang , penerimaan_barangdt where pb_id = pbdt_idpb and pb_po = '$no_po'");
			//$statusheaderpb[0]->pbdt_status;
			
			/*dd($statusheaderpb[4]->pbdt_status);*/
			$statusheaderpo = DB::select("select * from pembelian_order , pembelian_orderdt where po_id = podt_idpo and po_id = '$no_po' and po_statusreturn = 'AKTIF'");
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
			else if($tempsts > $hitungpo){
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
		else if($flag == 'FP'){
		/*dd($request);*/
			$mytime = Carbon::now(); 		
			//MEMBUAT NOFORMTT	
			$time = Carbon::now();
		//	$newtime = date('Y-M-d H:i:s', $time);  
			
			$month = Carbon::parse($request->tgl_dibutuhkan)->format('m');
			$year = Carbon::parse($request->tgl_dibutuhkan)->format('y');

			$idpb2 = DB::select("select substr(MAX(pb_lpb), 16) as nota from penerimaan_barang where  to_char(pb_date, 'MM') = '$month' and to_char(pb_date, 'YY') = '$year' and pb_comp = '$cabang'");	
		

			//return $faktur;
			if(count($idpb2) > 0) {	
				$idpb = (int)$idpb2[0]->nota + 1;
				$idpb = str_pad($idpb, 4, '0', STR_PAD_LEFT);
				
				//return $data['idfaktur'];
			}

			else {
		
				$idpb = '0001';
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
				$penerimaanbarang->pb_terimadari = $request->diterimadari;
				$penerimaanbarang->create_by = $request->username;
				$penerimaanbarang->update_by = $request->username;
				$penerimaanbarang->pb_acchutangdagang = $request->acchutangsupplier;
				$penerimaanbarang->pb_keterangan = $request->keterangan;
				$penerimaanbarang->save();
				


				$updatefaktur = fakturpembelian::where('fp_idfaktur' , '=' , $request->idfp);

				$updatefaktur->update([
				 	'fp_pending_status' => 'APPROVED',
				 	'fp_edit' => 'UNALLOWED',
			 	]);	


				
				for($i = 0 ; $i < count($request->qtyterima); $i++ ){
					$penerimaanbarangdt = new penerimaan_barangdt();
			
					if($request->qtyterima[$i] != '') {
						$idfp = $request->idfp;

						$dataItems[$i]['accpersediaan']=$request->accpersediaan[$i];					
						$dataItems[$i]['subtotal']=$request->jumlahharga[$i]*$request->qtydikirim[$i];


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
					//	$totalharga = (int)$request->qtyterima[$i] * (int)$request->jumlahharga[$i];

						//$hpp = str_replace($request->hpp[$i], "", ",")
						$hpp = str_replace(',', '', $request->hpp[$i]);
						$totalharga = str_replace(',', '', $request->jumlahharga[$i]);


						$penerimaanbarangdt->pbdt_id = $idpbdt;
						$penerimaanbarangdt->pbdt_idpb = $idpbpk;
						$penerimaanbarangdt->pbdt_date = $mytime;
						$penerimaanbarangdt->pbdt_item = $request->kodeitem[$i];
						$penerimaanbarangdt->pbdt_qty = $request->qtyterima[$i];	
						$penerimaanbarangdt->pbdt_hpp =$hpp;
						$penerimaanbarangdt->pbdt_idfp =$request->idfp;
						$penerimaanbarangdt->pbdt_updatestock =$request->updatestock;
						$penerimaanbarangdt->pbdt_status = $status;
						$penerimaanbarangdt->pbdt_suratjalan = $request->suratjalan;
						$penerimaanbarangdt->pbdt_totalharga = $totalharga;;
						$penerimaanbarangdt->pbdt_idspp = $request->idspp[$i];
						$penerimaanbarangdt->pbdt_acchpp = $request->acchpp[$i];
						$penerimaanbarangdt->pbdt_accpersediaan = $request->accpersediaan[$i];
						$penerimaanbarangdt->create_by = $request->username;
						$penerimaanbarangdt->update_by = $request->username;
						$penerimaanbarangdt->save();

						if($request->updatestock == "TIDAK"){
							$acchpp = $request->acchpp[$i];
							$datakun2 = DB::select("select * from d_akun where id_akun = '$acchpp' and kode_cabang = '$cabang'");
							$akundka = $datakun2[0]->akun_dka;

						}
						else {
							$accpersediaan = $request->accpersediaan[$i];
							$datakun2 = DB::select("select * from d_akun where id_akun = '$accpersediaan' and kode_cabang = '$cabang'");
							$akundka = $datakun2[0]->akun_dka;

						}

						if($akundka == 'D'){
							$datajurnal[$i]['id_akun'] = $request->accpersediaan[$i];
							$datajurnal[$i]['subtotal'] = $totalharga;
							$datajurnal[$i]['dk'] = 'D';
							$datajurnal[$i]['detail'] = $request->keteranganfpdetail[$i];
							$totalhutang = $totalhutang + $totalharga;
						}
						else {
							$datajurnal[$i]['id_akun'] = $request->accpersediaan[$i];
							$datajurnal[$i]['subtotal'] =  '-' . $totalharga;
							$datajurnal[$i]['dk'] = 'D';
							$datajurnal[$i]['detail'] = $request->keteranganfpdetail[$i];
							$totalhutang = $totalhutang + $totalharga;

						}
					}
					else if($request->qtyterima[$i] == '') {
					
						if($request->qtysampling[$i] != ''){
							$idfp = $request->idfp;
							$idpbpk =   penerimaan_barang::where('pb_fp' , $idfp)->max('pb_id');
							$lastidpbdt = penerimaan_barangdt::max('pbdt_id'); 

							$dataItems[$i]['accpersediaan']=$request->accpersediaan[$i];					
							$dataItems[$i]['subtotal']=$request->jumlahharga[$i]*$request->qtydikirim[$i];

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
						//	$totalharga = (int)$request->qtysampling[$i] * (int)$request->jumlahharga[$i];
							$hpp = str_replace(',', '', $request->hpp[$i]);
							$totalharga = str_replace(',', '', $request->jumlahharga[$i]);

							$penerimaanbarangdt->pbdt_id = $idpbdt;
							$penerimaanbarangdt->pbdt_idpb = $idpbpk;
							$penerimaanbarangdt->pbdt_date = $mytime;
							$penerimaanbarangdt->pbdt_item = $request->kodeitem[$i];
							$penerimaanbarangdt->pbdt_qty = $request->qtysampling[$i];	
							$penerimaanbarangdt->pbdt_hpp =$hpp;
							$penerimaanbarangdt->pbdt_idfp =$request->idfp;
							$penerimaanbarangdt->pbdt_updatestock =$request->updatestock;
							$penerimaanbarangdt->pbdt_status = $status2;
							$penerimaanbarangdt->pbdt_suratjalan = $request->suratjalan;
							$penerimaanbarangdt->pbdt_totalharga = $totalharga;
							$penerimaanbarangdt->pbdt_acchpp = $request->acchpp[$i];
							$penerimaanbarangdt->pbdt_accpersediaan = $request->accpersediaan[$i];
							$penerimaanbarangdt->create_by = $request->username;
							$penerimaanbarangdt->update_by = $request->username;
							$penerimaanbarangdt->save();
							
							if($request->updatestock == "TIDAK"){
								$acchpp = $request->acchpp[$i];
								$datakun2 = DB::select("select * from d_akun where id_akun = '$acchpp' and kode_cabang = '$cabang'");
								$akundka = $datakun2[0]->akun_dka;

								if($akundka == 'D'){
									$datajurnal[$i]['id_akun'] = $request->acchpp[$i];
									$datajurnal[$i]['subtotal'] = $totalharga;
									$datajurnal[$i]['dk'] = 'D';
									$datajurnal[$i]['detail'] = $request->keteranganfpdetail[$i];
									$totalhutang = $totalhutang + $totalharga;
								}
								else {
									$datajurnal[$i]['id_akun'] = $request->acchpp[$i];
									$datajurnal[$i]['subtotal'] =  '-' . $totalharga;
									$datajurnal[$i]['dk'] = 'D';
									$datajurnal[$i]['detail'] = $request->keteranganfpdetail[$i];
									$totalhutang = $totalhutang + $totalharga;
								}
							}
							else {
								$accpersediaan = $request->accpersediaan[$i];
								$datakun2 = DB::select("select * from d_akun where id_akun = '$accpersediaan' and kode_cabang = '$cabang'");
								$akundka = $datakun2[0]->akun_dka;

								if($akundka == 'D'){
									$datajurnal[$i]['id_akun'] = $request->accpersediaan[$i];
									$datajurnal[$i]['subtotal'] = $totalharga;
									$datajurnal[$i]['dk'] = 'D';
									$datajurnal[$i]['detail'] = $request->keteranganfpdetail[$i];
									$totalhutang = $totalhutang + $totalharga;
								}
								else {
									$datajurnal[$i]['id_akun'] = $request->accpersediaan[$i];
									$datajurnal[$i]['subtotal'] =  '-' . $totalharga;
									$datajurnal[$i]['dk'] = 'D';
									$datajurnal[$i]['detail'] = $request->keteranganfpdetail[$i];
									$totalhutang = $totalhutang + $totalharga;
								}
							}

							
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
				else if($tempsts > $hitungpo){
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
				
				$query4 = barang_terima::where([['bt_idtransaksi' , '=' , $request->idfp], ['bt_flag' , '=' , 'FP']]);
				$query4->update([
					'bt_statuspenerimaan' => $statuspb,
				]);

				$query4 = fakturpembelian::where('fp_idfaktur' , '=' , $request->idfp);
				$query4->update([
					'fp_terimabarang' => 'SUDAH',
				]);
		
		}
		else { // save pbg
			$mytime = Carbon::now(); 		
			//MEMBUAT NOFORMTT	
			$time = Carbon::now();
		//	$newtime = date('Y-M-d H:i:s', $time);  
			
		$month = Carbon::parse($request->tgl_dibutuhkan)->format('m');
		$year = Carbon::parse($request->tgl_dibutuhkan)->format('y');

			$idpb2 = DB::select("select substr(MAX(pb_lpb), 16) as nota from penerimaan_barang where  to_char(pb_date, 'MM') = '$month' and to_char(pb_date, 'YY') = '$year' and pb_comp = '$cabang'");	
		

			//return $faktur;
			if(count($idpb2) > 0) {	
				$idpb = (int)$idpb2[0]->nota + 1;
				$idpb = str_pad($idpb, 4, '0', STR_PAD_LEFT);
				
				//return $data['idfaktur'];
			}

			else {
		
				$idpb = '0001';
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
				$idpo = $request->idpbg;
				//$query = DB::select("select * from penerimaan_barang where pb_po ='$idpo'"); 	
					
				$penerimaanbarang = new penerimaan_barang();
				$penerimaanbarang->pb_id = $idpb;
				$penerimaanbarang->pb_comp =  $cabang;
				$penerimaanbarang->pb_date = $request->tgl_dibutuhkan;
				$penerimaanbarang->pb_status = '';
				$penerimaanbarang->pb_pbd = $request->idpbg;
				$penerimaanbarang->pb_updatestock =$request->updatestock;
				$penerimaanbarang->pb_lpb = $lpb;
				$penerimaanbarang->pb_suratjalan = $request->suratjalan;
				$penerimaanbarang->pb_supplier = $request->idsup;
				$penerimaanbarang->pb_gudang = $request->gudang;
				$penerimaanbarang->pb_terimadari = $request->diterimadari;
				$penerimaanbarang->create_by = $request->username;
				$penerimaanbarang->update_by = $request->username;
				$penerimaanbarang->pb_keterangan = $request->keterangan;
				$penerimaanbarang->save();
				

				
				for($i = 0 ; $i < count($request->qtyterima); $i++ ){
					$penerimaanbarangdt = new penerimaan_barangdt();
			
					if($request->qtyterima[$i] != '') {
						$idpbg = $request->idpbg;

						$idpbpk =   penerimaan_barang::where('pb_pbd' , $idpbg)->max('pb_id');
						$lastidpbdt = penerimaan_barangdt::max('pbdt_id'); 

						if(isset($lastidpbdt)) {
							$idpbdt = $lastidpbdt;
							$idpbdt = (int)$idpbdt + 1;
						}
						else {
							$idpbdt = 1;
						}

					$iditem2 = $request->kodeitem[$i];
						

					

					//melihatqtydisetiapitem
					$select = DB::select("select * from penerimaan_barangdt where pbdt_item = '$iditem2' and pbdt_idpbd = '$idpbg'"); 
					
					
				/*	$idpbg = '6';*/
					//$iditem2 = 'A-000001';
					$selectdikirim = DB::select("select * from pengeluaran_barang_dt where pbd_pb_id = '$idpbg' and pbd_nama_barang = '$iditem2'");

					/*return $iditem2;*/

					$quantitikirim = (int)$selectdikirim[0]->pbd_disetujui;
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
						$totalharga = (int)$request->qtyterima[$i] * (int)$request->jumlahharga[$i];

						$penerimaanbarangdt->pbdt_id = $idpbdt;
						$penerimaanbarangdt->pbdt_idpb = $idpbpk;
						$penerimaanbarangdt->pbdt_date = $mytime;
						$penerimaanbarangdt->pbdt_item = $request->kodeitem[$i];
						$penerimaanbarangdt->pbdt_qty = $request->qtyterima[$i];	
						$penerimaanbarangdt->pbdt_hpp =$request->jumlahharga[$i];
						$penerimaanbarangdt->pbdt_idpbd = $request->idpbg;
						$penerimaanbarangdt->pbdt_updatestock =$request->updatestock;
						$penerimaanbarangdt->pbdt_status = $status;
						$penerimaanbarangdt->pbdt_suratjalan = $request->suratjalan;
						$penerimaanbarangdt->pbdt_totalharga = $totalharga;;
						$penerimaanbarangdt->create_by = $request->username;
						$penerimaanbarangdt->update_by = $request->username;
						$penerimaanbarangdt->save();
					}
					else if($request->qtyterima[$i] == '') {
					
						if($request->qtysampling[$i] != ''){
							$idpbg = $request->idpbg;
							$idpbpk =   penerimaan_barang::where('pb_pbg' , $idpbg)->max('pb_id');
							$lastidpbdt = penerimaan_barangdt::max('pbdt_id'); 

							if(isset($lastidpbdt)) {
								$idpbdt = $lastidpbdt;
								$idpbdt = (int)$idpbdt + 1;
							}
							else {
								$idpbdt = 1;
							}

							$iditem2 = $request->kodeitem[$i];
							
							$idpbg = $request->idpbg;
							
						$selectdikirim = DB::select("select * from pengeluaran_barang_dt where pbd_pb_id = '$idpbg' and pbd_nama_barang = '$iditem2'");
							$quantitikirim = (int)$selectdikirim[0]->pbd_disetujui;
							
							
							if($quantitikirim  < $request->qtysampling[$i]){
								$status2 = "SAMPLING";
							}
							else {
								//$status = "TIDAK LENGKAP";
							}

							//total harga
							$totalharga = (int)$request->qtysampling[$i] * (int)$request->jumlahharga[$i];

							$penerimaanbarangdt->pbdt_id = $idpbdt;
							$penerimaanbarangdt->pbdt_idpb = $idpbpk;
							$penerimaanbarangdt->pbdt_date = $mytime;
							$penerimaanbarangdt->pbdt_item = $request->kodeitem[$i];
							$penerimaanbarangdt->pbdt_qty = $request->qtysampling[$i];	
							$penerimaanbarangdt->pbdt_hpp =$request->jumlahharga[$i];
							$penerimaanbarangdt->pbdt_idpbd = $request->idpbg;
							$penerimaanbarangdt->pbdt_updatestock =$request->updatestock;
							$penerimaanbarangdt->pbdt_status = $status2;
							$penerimaanbarangdt->pbdt_suratjalan = $request->suratjalan;
							$penerimaanbarangdt->pbdt_totalharga = $totalharga;
						
							$penerimaanbarangdt->create_by = $request->username;
							$penerimaanbarangdt->update_by = $request->username;
							$penerimaanbarangdt->save();
						}
					}
				}


			//	dd($totalharga);
				$idpbg = $request->idpbg;

				
				//update status pb header
				$statusheaderpb = DB::select("select * from penerimaan_barang , penerimaan_barangdt where pb_id = pbdt_idpb and pb_pbd = '$idpbg'");
				//$statusheaderpb[0]->pbdt_status;
				
				/*dd($statusheaderpb[4]->pbdt_status);*/
				$statusheaderpo = DB::select("select * from pengeluaran_barang , pengeluaran_barang_dt where pbd_pb_id = pb_id and pb_id = '$idpbg'");
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
				else if($tempsts > $hitungpo){
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
				
				$query4 = barang_terima::where([['bt_idtransaksi' , '=' , $request->idpbg], ['bt_flag' , '=' , 'PBG']]);
				$query4->update([
					'bt_statuspenerimaan' => $statuspb,
				]);

				/*$query4 = pengeluaranbarang::where('pb_id' , '=' , $request->idpbg);
				$query4->update([
					'fp_terimabarang' => 'SUDAH',
				]);*/
		} // end save pbg
		



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
				$stock_mutation->sm_po = $idpb;
				$stock_mutation->sm_id_gudang = $request->gudang;
				$stock_mutation->sm_sisa = $request->qtyterima[$i];
				$stock_mutation->sm_flag = 'PO';
				$stock_mutation->created_by = $request->username;
				$stock_mutation->updated_by = $request->username;
				$stock_mutation->save();
			}
			else if($flag == 'FP') {
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
				$stock_mutation->sm_po = $idpb ;
				$stock_mutation->sm_id_gudang = $request->gudang;
				$stock_mutation->sm_sisa = $request->qtyterima[$i];
				$stock_mutation->sm_flag = 'FP';
				$stock_mutation->created_by = $request->username;
				$stock_mutation->updated_by = $request->username;
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
				$stock_mutation->sm_po = $idpb ;
				$stock_mutation->sm_id_gudang = $request->gudang;
				$stock_mutation->sm_sisa = $request->qtyterima[$i];
				$stock_mutation->sm_flag = 'PBG';
				$stock_mutation->created_by = $request->username;
				$stock_mutation->updated_by = $request->username;
				$stock_mutation->save();
			}
		
		}
		}


			//save jurnal
			if($flag == 'FP'){ //jurnal jika FP
				$datajurnalum = [];
				$datafp = DB::select("select * from faktur_pembelian where fp_idfaktur = '$idfp'");			
				$tipefp = $datafp[0]->fp_tipe;

				if($tipefp == 'S'){
					
					//jurnal FP

					//akun ppn
					$hasilppn = $datafp[0]->fp_ppn;
					if($hasilppn != null){
						$datakun2 = DB::select("select * from d_akun where id_akun LIKE '2302%' and kode_cabang = '$cabang'");
						if(count($datakun2) == 0){
							 $dataInfo=['status'=>'gagal','info'=>'Akun PPN Untuk Cabang Belum Tersedia'];
						   	 DB::rollback();
					         return json_encode($dataInfo);
						}
						else {
							$akunppn = $datakun2[0]->id_akun;
							$akundka = $datakun2[0]->akun_dka;

							if($akundka == 'K'){
								$dataakun = array (
								'id_akun' => $akunppn,
								'subtotal' => '-' . $hasilppn,
								'dk' => 'D',
								'detail' => $request->fp_keterangan,
								);
							}
							else {
								$dataakun = array (
								'id_akun' => $akunppn,
								'subtotal' => $hasilppn,
								'dk' => 'D',
								'detail' => $request->fp_keterangan,
								);
							}
							array_push($datajurnal, $dataakun );

							$totalhutang = floatval($totalhutang) + floatval($hasilppn);
						}		
					}


					//akun pph
					$hasilpph = $datafp[0]->fp_pph;
					$jenispph = $datafp[0]->fp_jenispph;
					if($hasilpph != ''){
				
						$datapph = DB::select("select * from pajak where id = '$jenispph'");
						$kodepajak2 = $datapph[0]->acc1;
						$kodepajak = substr($kodepajak2, 0,4);

						$datakun2 = DB::select("select * from d_akun where id_akun LIKE '$kodepajak%' and kode_cabang = '$cabang'");
						if(count($datakun2) == 0){
							$dataInfo=['status'=>'gagal','info'=>'Akun PPH Untuk Cabang Belum Tersedia'];
						    DB::rollback();
					            return json_encode($dataInfo);
						}
						else {
							$akunpph = $datakun2[0]->id_akun;
							$akundka = $datakun2[0]->akun_dka;

							if($akundka == 'D'){
								$dataakun = array (
								'id_akun' => $akunpph,
								'subtotal' => '-' . $hasilpph,
								'dk' => 'K',
								'detail' => $request->fp_keterangan,
								);
							}
							else {
								$dataakun = array (
								'id_akun' => $akunpph,
								'subtotal' => $hasilpph,
								'dk' => 'K',
								'detail' => $request->fp_keterangan,
								);
							}
							array_push($datajurnal, $dataakun );
							$totalhutang = floatval($totalhutang) - floatval($hasilpph);
						}
				}


					$acchutangsupplier = $datafp[0]->fp_acchutang;
					$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 
					if(isset($lastidjurnal)) {
						$idjurnal = $lastidjurnal;
						$idjurnal = (int)$idjurnal + 1;
					}
					else {
						$idjurnal = 1;
					}
					
					$year = Carbon::parse($request->tgl_dibutuhkan)->format('Y');	
					$date = Carbon::parse($request->tgl_dibutuhkan)->format('Y-m-d');
					$jrno = get_id_jurnal('MM' , $cabang , $date);
					$jurnal = new d_jurnal();
					$jurnal->jr_id = $idjurnal;
			        $jurnal->jr_year = $year;
			        $jurnal->jr_date = $date;
			        $jurnal->jr_detail = 'PENERIMAAN BARANG ' . $request->flag;
			        $jurnal->jr_ref = $lpb;
			        $jurnal->jr_note = $request->keterangan;
			        $jurnal->jr_no = $jrno;
			        $jurnal->save();
		       		
			      
		        	$dataakun = array (
						'id_akun' => $acchutangsupplier,
						'subtotal' => $totalhutang,
						'dk' => 'K',
						'detail' => $request->fp_keterangan
					);	
			        

					array_push($datajurnal, $dataakun );
		    		$key  = 1;
		    		for($j = 0; $j < count($datajurnal); $j++){
		    			
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
		    			$jurnaldt->jrdt_acc = $datajurnal[$j]['id_akun'];
		    			$jurnaldt->jrdt_value = $datajurnal[$j]['subtotal'];
		    			$jurnaldt->jrdt_statusdk = $datajurnal[$j]['dk'];
		    			$jurnaldt->jrdt_detail = $datajurnal[$j]['detail'];
		    			$jurnaldt->save();
		    			$key++;
		    		} 
				}
			}
			else if($flag == 'PO'){ // jurnal jika bukan fp
				$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 
					if(isset($lastidjurnal)) {
						$idjurnal = $lastidjurnal;
						$idjurnal = (int)$idjurnal + 1;
					}
					else {
						$idjurnal = 1;
					}
					

					$year = Carbon::parse($request->tgl_dibutuhkan)->format('Y');
					$date = Carbon::parse($request->tgl_dibutuhkan)->format('Y-m-d');

					$jrno = get_id_jurnal('MM' , $cabang , $date);
					$jurnal = new d_jurnal();
					$jurnal->jr_id = $idjurnal;
			        $jurnal->jr_year = $year;
			        $jurnal->jr_date = $date;
			        $jurnal->jr_detail = 'PENERIMAAN BARANG ' . $request->flag;
			        $jurnal->jr_ref = $lpb;
			        $jurnal->jr_note = $request->keterangan;
			        $jurnal->jr_no = $jrno;
			        $jurnal->save();
		       		
			        if($flag == 'PO'){
		   	       		$dataakun = array (
						'id_akun' => $request->acchutangsupplierpo,
						'subtotal' => $totalhutang,
						'dk' => 'K',
						'detail' => $request->po_keterangan,
						);
			        }
			        else {
			        	$dataakun = array (
						'id_akun' => $request->acchutangsupplier,
						'subtotal' => $totalhutang,
						'dk' => 'K',
						'detail' => $request->po_keterangan,
						);	
			        }

					array_push($datajurnal, $dataakun );
		    		$key  = 1;
		    		for($j = 0; $j < count($datajurnal); $j++){
		    			
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
		    			$jurnaldt->jrdt_acc = $datajurnal[$j]['id_akun'];
		    			$jurnaldt->jrdt_value = $datajurnal[$j]['subtotal'];
		    			$jurnaldt->jrdt_statusdk = $datajurnal[$j]['dk'];
		    			$jurnaldt->jrdt_detail = $datajurnal[$j]['detail'];
		    			$jurnaldt->save();
		    			$key++;
		    		}   
			}
			else if($flag == 'PBG'){
				$idpbg = $request->idpbg;
				$datapsm = DB::select("select * from pengeluaran_stock_mutasi where psm_pb_id = '$idpbg'");
				$datapb = DB::select("select * from pengeluaran_barang where pb_id = '$idpbg'");
				$cabangasal = $datapb[0]->pb_comp;
				$gudang = $datapb[0]->pb_gudang_cabang;
				$datacomp = DB::select("select * from mastergudang where mg_id = '$gudang'");
				$cabangtujuan = $datacomp[0]->mg_cabang;
				$datajurnalpbg = [];
				

				for($j = 0; $j < count($datapsm); $j++){
					$item = $datapsm[$j]->psm_item;
					$dataitem = DB::select("select * from masteritem where kode_item = '$item'");
					$accpersediaan = $dataitem[0]->acc_persediaan;

					$accpersediaan = substr($accpersediaan, 0,4);
					$dataakunasal = DB::select("select * from d_akun where id_akun LIKE '$accpersediaan%' and kode_cabang = '$cabangasal'");
					$akunasal = $dataakunasal[0]->id_akun;

					$dataakuntujuan = DB::select("select * from d_akun where id_akun LIKE '$accpersediaan%' and kode_cabang = '$cabangtujuan'");
					$akuntujuan = $dataakuntujuan[0]->id_akun;


				
					$totalhutang = 0;
					for($i = 0; $i < count($request->accpersediaan); $i++){
						$totalharga = $request->qtyterima[$i] * $request->jumlahharga[$i];
						$datajurnalpbg[$i]['id_akun'] = $akunasal;
						$datajurnalpbg[$i]['subtotal'] = $totalharga;
						$datajurnalpbg[$i]['dk'] = 'D';
						$datajurnalpbg[$i]['detail'] = $datapb[0]->pb_keperluan;
						$totalhutang = $totalhutang + $totalharga;
					}	

					$dataakun = array (
						'id_akun' => $akuntujuan,
						'subtotal' => $totalhutang,
						'dk' => 'K',
						'detail' => $datapb[0]->pb_keperluan
						);
					array_push($datajurnalpbg, $dataakun);					
				}

					$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 
					if(isset($lastidjurnal)) {
						$idjurnal = $lastidjurnal;
						$idjurnal = (int)$idjurnal + 1;
					}
					else {
						$idjurnal = 1;
					}
				
					$year = Carbon::parse($request->tgl_dibutuhkan)->format('Y');
					$date = Carbon::parse($request->tgl_dibutuhkan)->format('Y-m-d');

					$jrno = get_id_jurnal('MM' , $cabang , $date);
					$jurnal = new d_jurnal();
					$jurnal->jr_id = $idjurnal;
			        $jurnal->jr_year = $year;
			        $jurnal->jr_date = $date;
			        $jurnal->jr_detail = 'PENERIMAAN BARANG ' . $request->flag;
			        $jurnal->jr_ref = $lpb;
			        $jurnal->jr_note = $request->keterangan;
			        $jurnal->jr_no = $jrno;
			        $jurnal->save();
		       		
		    		$key  = 1;
		    	
		    		for($j = 0; $j < count($datajurnalpbg); $j++){
		    			
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
		    			$jurnaldt->jrdt_acc = $datajurnalpbg[$j]['id_akun'];
		    			$jurnaldt->jrdt_value = $datajurnalpbg[$j]['subtotal'];
		    			$jurnaldt->jrdt_statusdk = $datajurnalpbg[$j]['dk'];
		    			$jurnaldt->jrdt_detail = $datajurnalpbg[$j]['detail'];
		    			$jurnaldt->save();
		    			$key++;
		    		}   


			}

		} // jika stock iya

			$cekjurnal = check_jurnal($lpb);
    		if($cekjurnal == 0){
    			$dataInfo =  $dataInfo=['status'=>'gagal','info'=>'Data Jurnal Tidak Balance :('];
				DB::rollback();
									        
    		}
    		elseif($cekjurnal == 1) {
    			$dataInfo =  $dataInfo=['status'=>'sukses','info'=>'Data Jurnal Balance :)'];
					        
    		}

    	//	$dataInfo =  $dataInfo=['status'=>'sukses','info'=>'Data Jurnal Balance :)'];
 
        return json_encode($dataInfo);

	});
		
	}

	public function updatepenerimaanbarang(Request  $request) {
		return DB::transaction(function() use ($request) { 
		$qty = $request->qty;
		$idpb = $request->idpb;
		$idpbdt = $request->idpbdt;
		$status = $request->status;
		$kodeitem = $request->kodeitem;
		$suratjalan = $request->suratjalan;
		$iddetail = $request->iddetail;
		$flag = $request->flag;



		$updatepenerimaanheader = penerimaan_barang::find($idpb);
		$updatepenerimaanheader->pb_suratjalan = $suratjalan;
		$updatepenerimaanheader->save();
		$dataItems=[];

		for($i = 0 ; $i < count($request->arrqty); $i++){
			$datapb = DB::select("select * from penerimaan_barang where pb_id = '$idpb'");
			$datagudang = $datapb[0]->pb_gudang;
			$datacomp = $datapb[0]->pb_comp;
			$acchutangdagang = $datapb[0]->pb_acchutangdagang;
			$iditem = $request->arrkodeitem[$i];


			/*return $datagudang . $datacomp;*/
			$datapbdt = DB::select("select * from penerimaan_barangdt where pbdt_item = '$iditem' and pbdt_idpb = '$idpb'");
			$qtypb = $datapbdt[0]->pbdt_qty;
			$accpersediaan = $datapbdt[0]->pbdt_accpersediaan;

			$querysg = DB::select("select * from stock_gudang where sg_gudang  = '$datagudang' and sg_cabang = '$datacomp' and sg_item = '$iditem'");

			/*return $querysg;*/
			$hasilqty = (int)$querysg[0]->sg_qty - (int)$qtypb;
			$hasilakhirqty = (int)$hasilqty + (int)$request->arrqty[$i];

		/*	return $hasilqty . $hasilakhirqty . $qtypb . (int)$querysg[0]->sg_qty . (int)$request->arrqty;*/

			$query6 = stock_gudang::where([['sg_gudang' , '=' , $datagudang],['sg_cabang' , '=' , $datacomp] , ['sg_item' , '=' , $iditem]]);
			$query6->update([
				'sg_qty' => $hasilakhirqty,
				]);

			
			if($flag == 'FP') {
				$query5 = stock_mutation::where([['sm_po' , '=' , $idpb],['sm_item' , '=' , $request->arrkodeitem[$i]],['sm_flag' , '=' ,'FP']]);
				$query5->update([
					'sm_qty' => $request->arrqty[$i],
				]);
			}
			else if($flag == 'PO'){
				$query5 = stock_mutation::where([['sm_po' , '=' , $idpb],['sm_item' , '=' , $request->arrkodeitem[$i]],['sm_flag' , '=' , 'PO']]);
				$query5->update([
					'sm_qty' => $request->arrqty[$i],
				]);
			}
			else {
				$query5 = stock_mutation::where([['sm_po' , '=' , $idpb],['sm_item' , '=' , $request->arrkodeitem[$i]],['sm_flag' , '=' , 'PBG']]);
				$query5->update([
					'sm_qty' => $request->arrqty[$i],

				]);
			}

			$updatedetail = penerimaan_barangdt::where([['pbdt_idpb', '=', $idpb], ['pbdt_id' , '=' , $request->arridpbdt[$i]], ['pbdt_item' , '=' , $request->arrkodeitem[$i]]]);

			$harga = str_replace(',', '', $request->arrharga[$i]);

			$updatedetail->update([
				 	'pbdt_qty' => $request->arrqty[$i],
				 	'pbdt_status' => $request->arrstatus[$i],
				 	'pbdt_totalharga' => $harga,				 	
			 	]);	


			//jurnal
			$datapbdt = DB::select("select * from penerimaan_barangdt where pbdt_idpb = '$idpb'");

			$databt = DB::select("select * from barang_terima where bt_idtransaksi = '$iddetail' and bt_flag = '$flag'");
			$idbt = $databt[0]->bt_id;
			$updatestock = $datapbdt[$i]->pbdt_updatestock;
			$accpersediaan = $datapbdt[$i]->pbdt_accpersediaan;
			$acchutang = $acchutangdagang . $datacomp;
			if($updatestock == 'IYA'){
				DB::delete("DELETE from  d_jurnal where jr_ref = '$idpb' and jr_detail = 'PENERIMAAN BARANG'");
				$datajurnal = [];
				$totalhutang = 0;
				for($ja = 0; $ja < count($request->arrakunitem); $ja++){
					
					$totalharga = str_replace(',', '', $request->arrharga[$ja]);

					$datajurnal[$ja]['id_akun'] = $request->arrakunitem[$ja];
					$datajurnal[$ja]['subtotal'] = $totalharga;
					$datajurnal[$ja]['dk'] = 'D';

					$totalhutang = $totalhutang + $totalharga;
				}	

				$dataakun = array (
					'id_akun' => $acchutangdagang,
					'subtotal' => $totalhutang,
					'dk' => 'K',
					);

				array_push($datajurnal, $dataakun );
				$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 
				if(isset($lastidjurnal)) {
					$idjurnal = $lastidjurnal;
					$idjurnal = (int)$idjurnal + 1;
				}
				else {
					$idjurnal = 1;
				}
			
				$year = Carbon::parse($mytime)->format('Y');
				$date = Carbon::parse($mytime)->format('Y-m-d');
				$jrno = get_id_jurnal('MM' , $cabang , $date);
				$jurnal = new d_jurnal();
				$jurnal->jr_id = $idjurnal;
		        $jurnal->jr_year = $year;
		        $jurnal->jr_date = $date;
		        $jurnal->jr_detail = 'PENERIMAAN BARANG';
		        $jurnal->jr_ref = $idpb;
		        $jurnal->jr_note = $flag;
		        $jurnal->jr_no = $jrno;
		        $jurnal->save();
	       		

	       
	    		$key  = 1;
	    		for($j = 0; $j < count($datajurnal); $j++){
	    			
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
	    			$jurnaldt->jrdt_acc = $datajurnal[$j]['id_akun'];
	    			$jurnaldt->jrdt_value = $datajurnal[$j]['subtotal'];
	    			$jurnaldt->jrdt_statusdk = $datajurnal[$j]['dk'];
	    			$jurnaldt->save();
	    			$key++;
	    		}   

			}
		}


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
			else if($tempsts > $hitungpo){
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

			$query5 = barang_terima::where('bt_idtransaksi' , '=' , $iddetail);
			$query5->update([
				'bt_statuspenerimaan' => $statuspb,
			]);

			
		}
		else if($flag == 'PO'){
			$statusheaderpb = DB::select("select * from penerimaan_barang , penerimaan_barangdt where pb_id = pbdt_idpb and pb_po = '$iddetail'");

			//$statusheaderpb[0]->pbdt_status;
			
			/*dd($statusheaderpb[4]->pbdt_status);*/
			$statusheaderpo = DB::select("select * from pembelian_order , pembelian_orderdt where podt_idpo = po_id and po_id = '$iddetail'");
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
			else if($tempsts > $hitungpo){
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

			$query5 = barang_terima::where('bt_idtransaksi' , '=' , $iddetail);
			$query5->update([
				'bt_statuspenerimaan' => $statuspb,
			]);

		}
		else {
			$statusheaderpb = DB::select("select * from penerimaan_barang , penerimaan_barangdt where pb_id = pbdt_idpb and pb_po = '$iddetail'");

			//$statusheaderpb[0]->pbdt_status;
			
			/*dd($statusheaderpb[4]->pbdt_status);*/
			$statusheaderpo = DB::select("select * from pembelian_order , pembelian_orderdt where podt_idpo = po_id and po_id = '$iddetail'");
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
			else if($tempsts > $hitungpo){
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

			$query5 = barang_terima::where('bt_idtransaksi' , '=' , $iddetail);
			$query5->update([
				'bt_statuspenerimaan' => $statuspb,
			]);
		}
			return json_encode('sukses');

		});

	}

	public function detailterimabarang($id) {

		

		//PO
		$data['header'] = DB::select("select * from barang_terima where bt_id = '$id'");
		$flag = $data['header'][0]->bt_flag;

		$data['status'] = [];
		if($flag == 'PO'){
		$data['header'] = DB::select("select * from barang_terima , supplier, mastergudang where bt_id = '$id' and bt_supplier = idsup and bt_gudang = mg_id");

		$data['cabang'] = DB::select("select * from cabang");
		
		$idgudang = $data['header'][0]->bt_gudang;

		$carigudang = DB::select("select * from mastergudang where mg_id = '$idgudang'");

		$data['comp'] = $carigudang[0]->mg_cabang;

		$idtransaksi = $data['header'][0]->bt_idtransaksi;

		$flag = $data['header'][0]->bt_flag;


		$data['po'] = DB::select("select distinct spp_id, po_acchutangdagang, po_ppn,po_diskon, spp_cabang, podt_idspp , po_id, spp_nospp, po_no, spp_lokasigudang, nama_supplier , idsup , po_catatan from pembelian_order, pembelian_orderdt, spp, supplier where po_id = '$idtransaksi' and podt_idpo = po_id and podt_idspp = spp_id and po_supplier = idsup");

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
		
			$data['cabang'] = DB::select("select * from cabang");
		
			$data['header'] = DB::select("select * from barang_terima , supplier, mastergudang where bt_id = '$id' and bt_supplier = idsup and bt_gudang = mg_id");

			$idgudang = $data['header'][0]->bt_gudang;

			$carigudang = DB::select("select * from mastergudang where mg_id = '$idgudang'");

			$data['comp'] = $carigudang[0]->mg_cabang;

			$idtransaksi = $data['header'][0]->bt_idtransaksi;

			$flag = $data['header'][0]->bt_flag;

			$data['fp'] = DB::select("select * from faktur_pembelian, supplier where fp_idsup = idsup and fp_idfaktur = '$idtransaksi' ");

		//	return $idtransaksi;

			$data['fpdt'] = DB::select("select * from faktur_pembelian, faktur_pembeliandt, masteritem where fpdt_kodeitem = kode_item and fpdt_idfp = fp_idfaktur and fp_idfaktur = '$idtransaksi'");
			

			for($z = 0; $z < count($data['fpdt']); $z++){
				$kodeitem = $data['fpdt'][$z]->fpdt_kodeitem;
				$data['sisa'][] = DB::select("select  fpdt_id, fpdt_kodeitem, fpdt_qty, fpdt_idfp, sum(pbdt_qty), nama_masteritem, string_agg(pbdt_status,',') as p from masteritem, faktur_pembeliandt LEFT OUTER JOIN penerimaan_barangdt on fpdt_kodeitem = pbdt_item and fpdt_idfp = pbdt_idfp where fpdt_idfp = '$idtransaksi' and fpdt_kodeitem = '$kodeitem' and fpdt_kodeitem = kode_item group by nama_masteritem, fpdt_kodeitem , fpdt_qty, fpdt_idfp, fpdt_id");
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

		//	dd($data);	
		}
		}
		else if($flag == 'PBG') {
			$data['flag'] = 'PBG';


			$data['cabang'] = DB::select("select * from cabang");
		
			$data['header'] = DB::select("select * from barang_terima , cabang, mastergudang where bt_id = '$id' and bt_agen = kode and bt_gudang = mg_id");

			$idgudang = $data['header'][0]->bt_gudang;

			$carigudang = DB::select("select * from mastergudang where mg_id = '$idgudang'");

			$data['comp'] = $carigudang[0]->mg_cabang;

			$idtransaksi = $data['header'][0]->bt_idtransaksi;

			$flag = $data['header'][0]->bt_flag;

			$data['pbg'] = DB::select("select * from pengeluaran_barang, cabang where pb_comp = kode and pb_id = '$idtransaksi' ");

			$data['pbgdt'] = DB::select("select * from pengeluaran_barang, pengeluaran_barang_dt, masteritem where pbd_nama_barang = kode_item and pbd_pb_id = pb_id and pb_id = '$idtransaksi'");
			

			for($z = 0; $z < count($data['pbgdt']); $z++){
				$kodeitem = $data['pbgdt'][$z]->pbd_nama_barang;
				$data['sisa'][] = DB::select("select  pbd_id, pbd_nama_barang, pbd_disetujui, pbd_pb_id, sum(pbdt_qty), nama_masteritem, string_agg(pbdt_status,',') as p from masteritem, pengeluaran_barang_dt LEFT OUTER JOIN penerimaan_barangdt on pbd_nama_barang = pbdt_item and pbd_pb_id = pbdt_idpbd where pbd_pb_id = '$idtransaksi' and pbd_nama_barang = '$kodeitem' and pbd_nama_barang = kode_item group by nama_masteritem, pbd_nama_barang , pbd_disetujui, pbd_pb_id, pbd_id");
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

		//	dd($data);	
		}
		}

		$jurnal_dt=collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk
                        FROM d_akun a join d_jurnal_dt jd
                        on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
                        (select j.jr_id from d_jurnal j where jr_ref='$id')")); 
		
	/*	dd($data);*/
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
		$idpbg = $request->idpbg;
		
		if($flag == 'PO'){
			$data['pbdt'] = DB::select("select * from penerimaan_barangdt where pbdt_item = '$iditem' and pbdt_po = '$idpo' and pbdt_idspp = '$idspp'");
		}
		else if($flag == 'FP') {
			$data['pbdt'] = DB::select("select * from penerimaan_barangdt where pbdt_item = '$iditem' and pbdt_idfp = '$idfp'");	
		}
		else {
			$data['pbdt'] = DB::select("select * from penerimaan_barangdt where pbdt_item = '$iditem' and pbdt_idpbd = '$idpbg'");	
		}


		return json_encode($data);

	}


	public function cetakterimabarang($id){
		
		$string = explode(",", $id);
		$flag = $string[1];
		$id = $string[0];
		$idpb = $string[2];
		$data['flag'] = $flag;
		if($flag == 'PO'){
			
			$idpo =$id;	
			
			$data['judul'] = DB::select("select *  from penerimaan_barang,pembelian_order  where  pb_po = '$idpo' and pb_po = po_id and pb_id = '$idpb'");
			for($i = 0 ; $i < count($data['judul']); $i++){
				$idlpb = $data['judul'][$i]->pb_lpb;
				$idpb = $data['judul'][$i]->pb_id;

				$data['barang'][] = DB::select("select * from penerimaan_barangdt , pembelian_orderdt, masteritem, spp where pbdt_po = podt_idpo and pbdt_po = '$idpo'  and podt_kodeitem = pbdt_item and podt_kodeitem = kode_item and pbdt_item = kode_item and pbdt_idspp = podt_idspp and pbdt_idpb ='$idpb' and pbdt_idspp = spp_id");
			}
		}
		else if($flag == 'FP') {
			
			$idfp = $id;

			$data['judul'] = DB::select("select * from penerimaan_barang, faktur_pembelian where pb_fp = '$idfp' and pb_fp = fp_idfaktur and pb_id = '$idpb'");
			
			for($c=0; $c < count($data['judul']); $c++){
				$idlpb = $data['judul'][$c]->pb_lpb;
				$idpb = $data['judul'][$c]->pb_id;

				$data['barang'][] = DB::select("select * from penerimaan_barangdt , faktur_pembelian, faktur_pembeliandt, masteritem where fpdt_idfp = pbdt_idfp and pbdt_idfp = '$idfp'  and fpdt_kodeitem = pbdt_item and fpdt_kodeitem = kode_item and pbdt_item = kode_item  and pbdt_idfp ='$idfp' and fpdt_idfp = fp_idfaktur and fp_idfaktur = '$idfp' and pbdt_idpb ='$idpb'  ");
			}
		}
		else {

			$idpbg = $id;

			//dd($idpbg);
			$data['judul'] = DB::select("select *, pengeluaran_barang.pb_id as idpengeluaran, penerimaan_barang.pb_id as idpenerimaan  from penerimaan_barang, pengeluaran_barang where pb_pbd = '$idpbg' and pb_pbd = pengeluaran_barang.pb_id and penerimaan_barang.pb_id = '$idpb'");
			
			//dd($idpb);
			for($c=0; $c < count($data['judul']); $c++){
				$idlpb = $data['judul'][$c]->pb_lpb;
				$idpb = $data['judul'][$c]->idpenerimaan;
			//	dd($idpb);

				$data['barang'][] = DB::select("select * from penerimaan_barangdt , pengeluaran_barang, pengeluaran_barang_dt, masteritem where pbd_pb_id = pbdt_idpbd and pbdt_idpbd = '$idpbg'  and pbd_nama_barang = pbdt_item and pbd_nama_barang = kode_item and pbdt_item = kode_item  and pbdt_idpbd ='$idpbg' and pbd_pb_id = pbdt_idpbd and pb_id = '$idpbg' and pbdt_idpb ='$idpb'  ");
			}
		}
			
		/*dd($data);*/
		return view('purchase/penerimaan_barang/createPDF', compact('data'));
	}

	public function hapusdatapenerimaan(Request $request){
		return DB::transaction(function() use ($request) {   



		$id = $request->id;
		$flag = $request->flag;
		$idtransaksi = $request->idtransaksi;

		if($flag == 'PO'){
			$datapb = DB::select("select * from penerimaan_barang , penerimaan_barangdt where pb_id = pbdt_idpb and pb_po = '$idtransaksi' and pb_id = '$id' ");
		}
		else if($flag == 'FP'){
			$datapb = DB::select("select * from penerimaan_barang , penerimaan_barangdt where pb_id = pbdt_idpb and pb_fp = '$idtransaksi' and pb_id = '$id' ");	
		}
		else {
			$datapb = DB::select("select * from penerimaan_barang , penerimaan_barangdt where pb_id = pbdt_idpb and pb_pbd = '$idtransaksi' and pb_id = '$id' ");	
		}

		$jr_note = $datapb[0]->pb_keterangan;
		$lpb = $datapb[0]->pb_lpb;
		DB::delete("DELETE from  d_jurnal where jr_ref = '$lpb' and jr_detail = 'PENERIMAAN BARANG $flag' and jr_note = '$jr_note'");

		for($x = 0; $x < count($datapb); $x++){
			$iditem = $datapb[$x]->pbdt_item;
			$qty = $datapb[$x]->pbdt_qty;
			$datacomp = $datapb[$x]->pb_comp;
			$datagudang = $datapb[$x]->pb_gudang;

			$stockgudang = DB::select("select * from stock_gudang where sg_item = '$iditem' and sg_cabang = '$datacomp' and sg_gudang = '$datagudang'");
			$sgqty = $stockgudang[0]->sg_qty;
			$hasilqty = (int)$sgqty - (int)$qty;

			/*return $iditem . $datacomp; $datagudang . $sgqty . $hasilqty;*/
			$query4 = stock_gudang::where([['sg_item' , '=' , $iditem],['sg_cabang' , '=' , $datacomp],['sg_gudang' , '=' , $datagudang]]);
			$query4->update([
				'sg_qty' => $hasilqty,
				
			]);	

		}
		
		if($flag == 'PO'){

			//update status pb header
			//update status pb header
			$statusheaderpb = DB::select("select * from penerimaan_barang , penerimaan_barangdt where pb_id = pbdt_idpb and pb_po = '$idtransaksi'");
			//$statusheaderpb[0]->pbdt_status;
			
			/*dd($statusheaderpb[4]->pbdt_status);*/
			$statusheaderpo = DB::select("select * from pembelian_order , pembelian_orderdt where po_id = podt_idpo and po_id = '$idtransaksi'");
			$hitungpo = count($statusheaderpo);
			$hitungpb = count($statusheaderpb);
			

			//datapembelian_orderdt
			for($k = 0; $k < count($statusheaderpb); $k++){
				$kodeitempb = $statusheaderpb[$k]->pbdt_item;
				$qty = $statusheaderpb[$k]->pbdt_qty;
				$idpo = $statusheaderpb[$k]->pbdt_po;

				$datapo = DB::select("select * from pembelian_orderdt where podt_idpo = '$idpo' and podt_kodeitem = '$kodeitempb'");
				$sisa = $datapo[0]->podt_sisaterima;

				$hasilpo = (integer)$sisa + (integer)$qty; 

				DB::table('pembelian_orderdt')
				->where('podt_idpo' , $idpo)
				->where('podt_kodeitem' , $kodeitempb)
				->update([
					'podt_sisaterima' => $hasilpo,
				]);
			}

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
			else if($tempsts > $hitungpo){
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


			$query3 = penerimaan_barang::where('pb_id' , '=' , $id);
			$query3->update([
				'pb_status' => 'TIDAK LENGKAP',
				/*'pb_totaljumlah' => $jmlhrg, */
			]);	

			
			if($hitungpb == 0){
			$query4 = barang_terima::where([['bt_idtransaksi' , '=' , $id],['bt_flag' , '=' , 'PO']]);
			$query4->update([
				'bt_statuspenerimaan' => 'BELUM DI TERIMA',
				
			]);	
			}
			else {

			$query4 = barang_terima::where([['bt_idtransaksi' , '=' , $idtransaksi], ['bt_flag' , '=' , 'PO']]);
			$query4->update([
				'bt_statuspenerimaan' => 'TIDAK LENGKAP',
			]);

			}

			DB::delete("DELETE from  stock_mutation where sm_po = '$id' and sm_flag = 'PO' and sm_mutcat = '1'");


		
		} // end flag PO
		else if($flag == 'FP'){
			
			//update status pb header
			//update status pb header
			$statusheaderpb = DB::select("select * from penerimaan_barang , penerimaan_barangdt where pb_id = pbdt_idpb and pb_po = '$idtransaksi'");
			//$statusheaderpb[0]->pbdt_status;
			
			/*dd($statusheaderpb[4]->pbdt_status);*/
			$statusheaderpo = DB::select("select * from faktur_pembelian , faktur_pembeliandt where fpdt_idfp = fp_idfaktur and fp_idfaktur = '$idtransaksi'");
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
			else if($tempsts > $hitungpo){
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


			$query3 = penerimaan_barang::where('pb_id' , '=' , $id);
			$query3->update([
				'pb_status' => 'TIDAK LENGKAP',
				/*'pb_totaljumlah' => $jmlhrg, */
			]);	

			
			
			if($hitungpb == 0){
				$query4 = barang_terima::where([['bt_idtransaksi' , '=' , $idtransaksi],['bt_flag' , '=' , 'FP']]);
			$query4->update([
				'bt_statuspenerimaan' => 'BELUM DI TERIMA',
				
			]);	
			}
			else {

			$query4 = barang_terima::where([['bt_idtransaksi' , '=' , $idtransaksi], ['bt_flag' , '=' , 'FP']]);
			$query4->update([
				'bt_statuspenerimaan' => 'TIDAK LENGKAP',
			]);

			}

			DB::delete("DELETE from  stock_mutation where sm_po = '$id' and sm_flag = 'FP' and sm_mutcat = '1'");
		}
		else {
			//update status pb header
			//update status pb header
			$statusheaderpb = DB::select("select * from penerimaan_barang , penerimaan_barangdt where pb_id = pbdt_idpb and pb_po = '$idtransaksi'");
			//$statusheaderpb[0]->pbdt_status;
			
			/*dd($statusheaderpb[4]->pbdt_status);*/
			$statusheaderpo = DB::select("select * from pengeluaran_barang , pengeluaran_barang_dt where pbd_pb_id = pb_id and pb_id = '$id'");
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
			else if($tempsts > $hitungpo){
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

			$query3 = penerimaan_barang::where('pb_id' , '=' , $id);
			$query3->update([
				'pb_status' => 'TIDAK LENGKAP',
				/*'pb_totaljumlah' => $jmlhrg, */
			]);	
			
			if($hitungpb == 0){
				$query4 = barang_terima::where([['bt_idtransaksi' , '=' , $idtransaksi],['bt_flag' , '=' , 'PBG']]);
				$query4->update([
					'bt_statuspenerimaan' => 'BELUM DI TERIMA',
					
				]);	
			}
			else {
				$query4 = barang_terima::where([['bt_idtransaksi' , '=' , $idtransaksi], ['bt_flag' , '=' , 'PBG']]);
				$query4->update([
					'bt_statuspenerimaan' => 'TIDAK LENGKAP',
				]);
			}

			DB::delete("DELETE from  stock_mutation where sm_po = '$id' and sm_flag = 'PBG' and sm_mutcat = '1'");	
		} 

		
		DB::delete("DELETE from  penerimaan_barang where pb_id = '$id'");
		
		return json_encode('sukses');
		});
	}

	public function lihatjurnal(Request $request){
		$lpb = $request->ref;
		$note = $request->note;
		$data['jurnal'] = collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk, jrdt_detail
                        FROM d_akun a join d_jurnal_dt jd
                        on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
                        (select j.jr_id from d_jurnal j where jr_ref='$lpb')")); 
		$data['countjurnal'] = count($data['jurnal']);
		$data['jurnalref'] = $lpb;
 		return json_encode($data);
	}

	

	public function lihatjurnalpelunasan(Request $request){
		$id = $request->id;
		$datas = $request->data;
		$bm = $request->bm;

		if($datas == 'BK'){
				$data['jurnal'] = collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk, jrdt_detail
		                        FROM d_akun a join d_jurnal_dt jd
		                        on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
		                        (select j.jr_id from d_jurnal j where jr_ref='$id')")); 
				$data['countjurnal'] = count($data['jurnal']);
		}
		else if($datas == 'BM'){				
				$data['jurnal'] = collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk, jrdt_detail
		                        FROM d_akun a join d_jurnal_dt jd
		                        on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
		                        (select j.jr_id from d_jurnal j where jr_ref='$bm')")); 
				$data['countjurnal'] = count($data['jurnal']);	
		}
 		return json_encode($data);
	}

	public function lihatjurnalumum(Request $request){
		$id = $request->nota;
		$detail = $request->detail;
		$data['jurnal'] = collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk, jrdt_detail
                        FROM d_akun a join d_jurnal_dt jd
                        on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
                        (select j.jr_id from d_jurnal j where jr_ref='$id' and jr_detail = '$detail')")); 
		$data['countjurnal'] = count($data['jurnal']);
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

				$data['jurnal'][] = collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk
                        FROM d_akun a join d_jurnal_dt jd
                        on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
                        (select j.jr_id from d_jurnal j where jr_ref='$idpb')")); 
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
		else {
			$iditem = $request->kodeitem;
			$idpbg = $request->idpbg;

			$data['judul'] = DB::select("select * from penerimaan_barang where pb_pbd = '$idpbg'");
			for($c=0; $c < count($data['judul']); $c++){
				$idlpb = $data['judul'][$c]->pb_lpb;
				$idpb = $data['judul'][$c]->pb_id;

				$data['barang'][] = DB::select("select * from penerimaan_barangdt , pengeluaran_barang, pengeluaran_barang_dt, masteritem where pbd_pb_id = pbdt_idpbd and pbdt_idpbd = '$idpbg'  and pbd_nama_barang = pbdt_item and pbd_nama_barang = kode_item and pbdt_item = kode_item  and pbdt_idpbd ='$idpbg' and pbdt_idpbd = pb_id and pb_id = '$idpbg' and pbdt_idpb ='$idpb'  ");
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
		$cabang = session::get('cabang');
		$data['cabang'] = master_cabang::all();
		$data['gudang'] = DB::select("select * from mastergudang");
		/*if($cabang == 000){
			$data['gudang'] = DB::select("select * from mastergudang");
		}
		else {
			$data['gudang'] = DB::select("select * from mastergudang where mg_cabang = '$cabang'");
		}*/


		if($cabang == 000){
			$data['stock'] = DB::select("select * from stock_gudang, masteritem where sg_item = kode_item");
		}
		else {
			$data['stock'] = DB::select("select * from stock_gudang, masteritem where sg_item = kode_item and sg_cabang = '$cabang'");			
		}
		 return view('purchase/stockgudang/index', compact('data'));
		
	}

	public function carigudang(Request $request){
		$idgudang = $request->idgudang;

		$data['gudang'] = DB::select("select * from stock_gudang, masteritem where sg_item = kode_item and sg_gudang = '$idgudang'");

		$data['count'] = count($data['gudang']);
		return json_encode($data); 
	}



	public function fatkurpembelian() {

		// return 'asd';
		$data['faktur'] = DB::select("SELECT * from faktur_pembelian 
									  inner join jenisbayar on idjenisbayar= fp_jenisbayar order by fp_tgl desc");

		$jenis = DB::table('jenisbayar')
				   ->where('idjenisbayar',2)
				   ->orWhere('idjenisbayar',6)
				   ->orWhere('idjenisbayar',7)
				   ->orWhere('idjenisbayar',9)
				   ->get();

		$cabang = DB::table('cabang')
                  ->get();
		

		$agen 	  = DB::select("SELECT kode, nama from agen order by kode");

		$vendor   = DB::select("SELECT kode, nama from vendor order by kode "); 

		$subcon   = DB::select("SELECT kode, nama from subcon order by kode "); 

		$supplier = DB::select("SELECT no_supplier as kode, nama_supplier as nama from supplier where status = 'SETUJU' and active = 'AKTIF' order by no_supplier");

		$all = array_merge($agen,$vendor,$subcon,$supplier);
		// return 'asd';
		return view('purchase/fatkur_pembelian/index', compact('data','jenis','all','cabang'));
	}

	public function datatable_faktur_pembelian(Request $req)
	{
		$cabang = DB::table('cabang')
                  ->where('kode',$req->cabang)
                  ->first();
        // dd($req->all());
	    if ($cabang == null) {
	      $cabang == '';
	    }else{
	      $cabang = 'and fp_comp ='."'$cabang->kode'";
	    }

	    if ($req->min == '') {
	      $min = '';
	    }else{
	      $min = 'and fp_tgl >='."'$req->min'";
	    }

	    if ($req->max == '') {
	      $max = '';
	    }else{
	      $max = 'and fp_tgl <='."'$req->max'";
	    }

	    if ($req->jenis == '') {
	      $jenis = '';
	    }else{
	      $jenis = 'and fp_jenisbayar ='."'$req->jenis'";
	    }

	    if ($req->customer == '') {
	      $customer = '';
	    }else{
	      $customer = 'and fp_supplier ='."'$req->customer'";
	    }


	    if ($req->nomor != '') {
	      if (Auth::user()->punyaAkses('Faktur Pembelian','all')) {
	          	$data = DB::table('faktur_pembelian')
	                    ->join('cabang','kode','=','fp_comp')
	                    ->where('fp_nofaktur','like','%'.$req->nomor.'%')
	                    ->get();
	      }else{
	          	$cabang = Auth::user()->kode_cabang;

	            $data = DB::table('faktur_pembelian')
	                    ->join('cabang','kode','=','fp_comp')
	                    ->where('fp_comp',$cabang)
	                    ->where('fp_nofaktur','like','%'.$req->nomor.'%')
	                    ->get();
	      }
	      
	    }else{
	      if (Auth::user()->punyaAkses('Faktur Pembelian','all')) {
	        $data = DB::table('faktur_pembelian')
	                    ->join('cabang','kode','=','fp_comp')
	                  ->whereRaw("fp_nofaktur != '0' $min $max $customer $jenis $cabang")
	                  ->orderBy('fp_tgl','DESC')
	                  ->get();
	      }else{
	        $cabang = Auth::user()->kode_cabang;
	        $data = DB::table('faktur_pembelian')
	                  ->join('cabang','kode','=','fp_comp')
	                  ->whereRaw("fp_comp ='$cabang' $min $max $customer $jenis")
	                  ->orderBy('fp_tgl','DESC')
	                  ->get();
	      }
	    }

	    $data = collect($data);

	    return Datatables::of($data)
	                      ->addColumn('aksi', function ($data) {
	                      	$a = '';
	                      	$b = '';
	                      	$c = '';
	                          if( Auth::user()->punyaAkses('Faktur Pembelian','ubah')){
	                          	if ( $data->fp_status == 'Released') {
	                          		if(cek_periode(carbon::parse($data->fp_tgl)->format('m'),carbon::parse($data->fp_tgl)->format('Y') ) != 0){
	                          			if ($data->fp_jenisbayar == 6 || $data->fp_jenisbayar == 7 || $data->fp_jenisbayar == 9) {
	                          				if ($data->fp_sisapelunasan == $data->fp_netto) {
	                          					$a =  '<a title="Edit" class="btn btn-sm btn-success" href='.url('fakturpembelian/edit_penerus/'.$data->fp_idfaktur.'').'>
					                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
					                                </a>';
	                          				}
	                          			}else{
	                          				if ($data->fp_sisapelunasan == $data->fp_netto) {
	                          					$a = '<a title="Edit" class="btn btn-sm btn-success" href='.url('fakturpembelian/detailfatkurpembelian/'.$data->fp_idfaktur.'').'><i class="fa fa-arrow-right" aria-hidden="true"></i> </a> ';
											}
	                          			}
	                              	}
	                          	}
	                          }

	                          if( Auth::user()->punyaAkses('Faktur Pembelian','hapus')){
	                          	if ( $data->fp_status == 'Released') {
	                          		if(cek_periode(carbon::parse($data->fp_tgl)->format('m'),carbon::parse($data->fp_tgl)->format('Y') ) != 0){
	                          			if ($data->fp_jenisbayar == 6 || $data->fp_jenisbayar == 7 || $data->fp_jenisbayar == 9) {
	                          				if ($data->fp_sisapelunasan == $data->fp_netto) {
	                          					$c =  '<a title="Hapus" class="btn btn-sm btn-danger" onclick="hapus(\''.$data->fp_idfaktur.'\')">
				                                <i class="fa fa-trash" aria-hidden="true"></i>
				                                </a> ';
											}
	                          					
	                          			}else{
	                          				if ($data->fp_sisapelunasan == $data->fp_netto) {
	                          					$c = '<a title="Hapus" class="btn btn-sm btn-danger" onclick="hapusData(\''.$data->fp_idfaktur.'\')">
				                                  <i class="fa fa-trash" aria-hidden="true"></i>
				                                </a>';
											}
	                          			}	
	                              	}
	                          	}
	                          }
	                          return $a . $b .$c  ;
	                          

	                                 
	                      })->addColumn('pihak_ketiga', function ($data) {
	                        $agen 	  = DB::select("SELECT kode, nama from agen order by kode");

							$vendor   = DB::select("SELECT kode, nama from vendor order by kode "); 

							$subcon   = DB::select("SELECT kode, nama from subcon order by kode "); 

							$supplier = DB::select("SELECT no_supplier as kode, nama_supplier as nama from supplier where status = 'SETUJU' and active = 'AKTIF' order by no_supplier");

							$all = array_merge($agen,$vendor,$subcon,$supplier);

	                        for ($i=0; $i < count($all); $i++) { 
	                          if ($data->fp_supplier == $all[$i]->kode) {
	                              return $all[$i]->nama;
	                          }
	                        }
	                      })->addColumn('status', function ($data) {
	                        if($data->fp_pending_status == 'APPROVED')
                            	return'<label class="label label-success">APPROVED</label>';
                         	elseif($data->fp_pending_status == 'PENDING')
                            	return'<label class="label label-danger">PENDING</label>';
                          
                          	
	                      })->addColumn('jenis_faktur', function ($data) {
	                        $jenis = DB::table('jenisbayar')
									   ->where('idjenisbayar',2)
									   ->orWhere('idjenisbayar',6)
									   ->orWhere('idjenisbayar',7)
									   ->orWhere('idjenisbayar',9)
									   ->get();

							for ($i=0; $i < count($jenis); $i++) { 
								if ($data->fp_jenisbayar == $jenis[$i]->idjenisbayar) {
									return $jenis[$i]->jenisbayar;
								}
							}
                          
                          	
	                      })->addColumn('detail', function ($data) {
							if($data->fp_jenisbayar == 6 || $data->fp_jenisbayar == 7 || $data->fp_jenisbayar == 9)
	                            return'<a class="fa asw fa-print" align="center"  title="edit" href="'.url('fakturpembelian/detailbiayapenerus').'/'.$data->fp_idfaktur.'"> Print Detail</a>';
							else
	                            return'<a class="fa asw fa-print" align="center"  title="edit" href='.url('fakturpembelian/cetakfaktur/'.$data->fp_idfaktur.'').'> Print Detail</a>';
                          
                          	
	                      })->addColumn('lunas', function ($data) {
							if($data->fp_sisapelunasan == 0)
                            	return'<label class="label label-info">LUNAS</label>';
                         	else
                            	return'<label class="label label-WARNING">BELUM</label>';
                          
                          	
	                      })
	                      ->addIndexColumn()
	                      ->make(true);
	}


	public function cetakfaktur ($id){
		//return $id;

		$data['judul'] = DB::select("select * from faktur_pembelian, supplier where fp_idfaktur = '$id' and fp_idsup = idsup");
		$data['barang'] = DB::select("select * from faktur_pembelian , faktur_pembeliandt, masteritem where fpdt_idfp = fp_idfaktur and fp_idfaktur = '$id' and fpdt_kodeitem = kode_item");

		$jurnalRef = $data['judul'][0]->fp_nofaktur;

		$data['jurnal_dt']=collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk
                        FROM d_akun a join d_jurnal_dt jd
                        on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
                        (select j.jr_id from d_jurnal j where jr_ref='$jurnalRef' and jr_detail = 'FAKTUR PEMBELIAN')"));
	
		return view('purchase/fatkur_pembelian/faktur_pembelian' , compact('data'));
	}

	public function updatestockbarang(Request $request){
		$idsup = $request->idsup;
		$datasup = explode("+" , $idsup);
		$idsup = $datasup[0];

		$updatestock = $request->updatestock;
		$groupitem = $request->groupitem;
		$stock = $request->stock;
		$cabang = $request->cabang;

	//	return $groupitem;
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

	public function datagroupitem(Request $request){
		$grupitem = $request->grupitem;
		if($grupitem != ''){
			//return $grupitem;
			$datagrup = DB::select("select * from jenis_item where kode_jenisitem = '$grupitem'");
			$kodestock = $datagrup[0]->stock;
			
		}
		else {
			$kodestock = $request->kodestock;
		}


		//return json_encode($kodestock);
		$data['groupitem'] = DB::select("select * from jenis_item where stock != '$kodestock'");
		$data['countgroupitem'] = count($data['groupitem']);
		
		return json_encode($data);
	}

	public function updatebarangitem(Request $request){
		$idsup = $request->idsup;
		$updatestock = $request->updatestock;
		$groupitem = $request->groupitem;
		$stock = $request->stock;
		
	//	return $groupitem;
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
			$idfaktur = str_pad($string, 4, '0', STR_PAD_LEFT);
		}

		else {
			$idfaktur = '0001';
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
		//dd($data);
	
		return view('purchase/fatkur_pembelian/create', compact('data'));
	}


	public function detailfatkurpembelian($id) {
		$data['faktur'] = DB::select("select * from faktur_pembelian,supplier,cabang where fp_idsup = idsup and fp_idfaktur = '$id' and fp_comp = kode");
		$data['fakturdt'] = DB::select("select * from faktur_pembelian,supplier,faktur_pembeliandt , masteritem, pembelian_order where fpdt_idfp = fp_idfaktur and fp_idsup = idsup and fpdt_kodeitem = kode_item and fp_idfaktur = '$id'");

  		$jurnalRef=$data['faktur'][0]->fp_nofaktur;
		$datas['fakturs'] = DB::select("select * from faktur_pembeliandt , pembelian_order, faktur_pembelian, supplier, masteritem where fpdt_idfp = fp_idfaktur and fp_idfaktur = '$id' and fp_idsup = idsup and fpdt_kodeitem = kode_item and fpdt_idpo = po_id");
		$data_tt = DB::select("select * from form_tt , form_tt_d where tt_idform = ttd_id");
		$data['no_tt'] = DB::select("select * from form_tt, form_tt_d where ttd_faktur = '$jurnalRef' and tt_idform = ttd_id"); 
		
		
		if($datas['fakturs'] == null){ //FP
			$data['status'] = 'FP';			
			$data['fakturdtpo'] = DB::select("select * from faktur_pembeliandt , faktur_pembelian, masteritem, supplier where fpdt_idfp = fp_idfaktur and fp_idfaktur = '$id' and fpdt_kodeitem = kode_item and fp_idsup = idsup");
			$grupitem = $data['fakturdtpo'][0]->fpdt_groupitem;
			$updatestock = $data['fakturdtpo'][0]->fpdt_updatedstock;
			$tipe = $data['fakturdtpo'][0]->fp_tipe;
			if($tipe == 'J'){
				$data['barang'] = DB::select("select * from masteritem where jenisitem = '$grupitem'");
			}

			else{
				$data['barang'] = DB::select("select * from masteritem where jenisitem = '$grupitem' and updatestock = '$updatestock'");}
		}
		else {
			$data['status'] = 'PO';			
			$data['fakturdtpo'] = DB::select("select * from faktur_pembeliandt , faktur_pembelian, pembelian_order, supplier, masteritem where fpdt_idfp = fp_idfaktur and fp_idfaktur = '$id' and fp_idsup = idsup and fpdt_kodeitem = kode_item and fpdt_idpo = po_id");

			$grupitem = $data['fakturdtpo'][0]->fpdt_groupitem;
			$updatestock = $data['fakturdtpo'][0]->fpdt_updatedstock;

			$data['barang'] = DB::select("select * from masteritem where jenisitem = '$grupitem' and updatestock = '$updatestock'");
		}

//		dd($data['fakturdtpo'][0]->fpdt_idpo);

	/*	$data['tt'] = DB::select("select * from faktur_pembelian, form_tt, supplier where fp_idtt = tt_idform and fp_idfaktur = '$id' and tt_idsupplier =idsup");*/
		$data['pajak'] = tb_master_pajak::all();
		$fpm =  DB::select("select * from fakturpajakmasukan  where  fpm_idfaktur = '$id'");
			if(count($fpm != 0)){
				$data['fpm'] =  DB::select("select * from fakturpajakmasukan  where  fpm_idfaktur = '$id'");
			}
			else {
				$data['fpm'] =  DB::select("select * from fakturpajakmasukan  where  fpm_idfaktur = '$id'");

			}

		$data['supplier'] = DB::select("select * from supplier where status = 'SETUJU'");
		

		$data['gudang'] =  masterGudangPurchase::all();
		$data['pajak'] = tb_master_pajak::all();
		$data['cabang'] = DB::select("select * from cabang");
	/*	$data['cndn'] = DB::select("select * from cndtpembelian_dt where cndt_idfp = '$id'");
		$data['fpg'] = DB::select("select * from fpg_dt where fpgdt_nofaktur = '$jurnalRef'");*/
		$data['jenisitem'] = masterJenisItemPurchase::all();
	//	dd(count($data['fpm']));
	/*	dd($data);*/

		$jurnal_dt=collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk
                        FROM d_akun a join d_jurnal_dt jd
                        on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
                        (select j.jr_id from d_jurnal j where jr_ref='$jurnalRef' and jr_detail = 'FAKTUR PEMBELIAN')"));

		$dataumfp = DB::select("select * from uangmukapembelian_fp, uangmukapembeliandt_fp where umfp_nofaktur = '$jurnalRef' and umfpdt_idumfp = umfp_id");

		//dd($dataumfp);
		if(count($dataumfp) != 0){
			$jurnal_um =collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk
		                    FROM d_akun a join d_jurnal_dt jd
		                    on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
		                    (select j.jr_id from d_jurnal j where jr_ref='$jurnalRef' and jr_detail = 'UANG MUKA PEMBELIAN FP')"));
		}

	/*	dd($data);*/
		return view('purchase/fatkur_pembelian/detail', compact('data','jurnal_dt', 'jurnal_um', 'dataumfp'));
	}	

	public function getbarang(Request $request){
		$id = $request->barang;

		$data['barang'] = DB::select("select * from masteritem where kode_item = '$id'");

		return json_encode($data);
	}

	public function getbarangfpitem (Request $request){
		$idsup = $request->idsup;
		$groupitem = $request->groupitem;
		$updatestock = $request->updatestock;
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
				$data['barang']= DB::select("select * from masteritem where jenisitem = '$groupitem' and updatestock = '$updatestock'");
				$data['status'] = 'Tidak Terikat Kontrak';	
			}

		}

		return json_encode($data);
	}

	public function savefakturpo(Request $request){
		return DB::transaction(function() use ($request) {   
			/*dd($request->all());*/
		$variable = $request->supplier_po;
		$data = explode("+", $variable);
		$idsup = $data[0];
		$kodesupplier2 = $data[4];
		$netto = str_replace(',', '', $request->nettohutang_po);
		$nofaktur = $request->no_faktur;
		$cabanginput = $request->cabang;
		$cabang = $request->cabangtransaksi;
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
			

			//TANDA TERIMA	
			$data_tt = explode("," , $request->inputtandaterima);

			$update_tt =  DB::table('form_tt_d')
	                ->where([['ttd_id' , '='  , $data_tt[0]], ['ttd_detail' , '=' , $data_tt[1]]])
	                ->update([
	                	'ttd_faktur' => $nofaktur,                                                           
		            ]);

			

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

				$datafp = DB::select("select * from faktur_pembelian where fp_nofaktur = '$nofaktur'");
				if(count($datafp) != 0){
/*						$explode = explode("/", $datafp[0]->fp_nofaktur);
						$idfaktur3 = $explode[2];
						$string = explode("-", $idfaktur3);
						$idfaktur2 = $string[1];
						$idfakturss = (int)$idfaktur2 + 1;
						$akhirfaktur = str_pad($idfakturss, 4, '0', STR_PAD_LEFT);
						$nofaktur = $explode[0] .'/' . $explode[1] . '/'  . $string[0] . '-' . $akhirfaktur;
*/						
				}
				else {
					$nofaktur = $nofaktur;
				}


				/*$datasupplier = DB::select("select * from supplier where idsup = '$idsup'");
				$kodesupplier2 = $datasupplier[0]->no_supplier;
*/
				$fatkurpembeliand = new fakturpembelian();
				$fatkurpembeliand->fp_idfaktur = $idfaktur; 
				$fatkurpembeliand->fp_nofaktur = $nofaktur;
				$fatkurpembeliand->fp_tgl = $request->tgl_po;
				$fatkurpembeliand->fp_idsup = $idsup;
				$fatkurpembeliand->fp_keterangan = strtoupper($request->keterangan_po);
				$fatkurpembeliand->fp_noinvoice = $request->no_invoice_po;
				$fatkurpembeliand->fp_jatuhtempo = $request->jatuhtempo_po;
				$fatkurpembeliand->fp_jumlah = $total;
				if($request->disc_item_po != ''){
					$fatkurpembeliand->fp_discount = $request->disc_item_po;
					$hasildiskon = str_replace(',', '', $request->hasildiskon_po);	
					$fatkurpembeliand->fp_hsldiscount = $hasildiskon;

				}

				$fatkurpembeliand->fp_dpp =$dpp;
				if($request->hasilppn_po != ''){
					$fatkurpembeliand->fp_jenisppn = $request->jenisppn_po;
					$fatkurpembeliand->fp_ppn = $hasilppn;
					$fatkurpembeliand->fp_inputppn = $request->inputppn_po;
				}

				if($request->hasilpph_po != '' && $request->hasilpph_po != 0.00){			
					$string = explode(",", $request->jenispph_po);
					$jenispph = $string[0];
					$fatkurpembeliand->fp_jenispph = $jenispph;
					$fatkurpembeliand->fp_pph = $hasilpph;
					$fatkurpembeliand->fp_nilaipph = $request->inputpph;

					$datapph = DB::select("select * from pajak where id = '$jenispph'");
					$kodepajak2 = $datapph[0]->acc1;
					$kodepajak = substr($kodepajak2, 0,4);

					$datakun2 = DB::select("select * from d_akun where id_akun LIKE '$kodepajak%' and kode_cabang = '$cabang'");
					if(count($datakun2) != 0){
						$acchutang = $datakun2[0]->id_akun;
						$fatkurpembeliand->fp_accpph = $acchutang;
					}
				}

				$fatkurpembeliand->fp_netto = $netto;
				$fatkurpembeliand->fp_jenisbayar = 2;
				//$fatkurpembeliand->fp_idtt = $idtandaterima[0]->tt_idform;
				$fatkurpembeliand->fp_comp = $cabang;
				$fatkurpembeliand->fp_sisapelunasan = $netto;
				
				
				$fatkurpembeliand->fp_pending_status = 'APPROVED';
				$fatkurpembeliand->fp_status = 'Released';
				$fatkurpembeliand->fp_tipe = 'PO';
				$fatkurpembeliand->fp_edit = 'ALLOWED';
				$fatkurpembeliand->fp_acchutang = $request->acchutangdagang;
				$fatkurpembeliand->created_by = $request->username;
				$fatkurpembeliand->updated_by = $request->username;
				$fatkurpembeliand->fp_supplier = $kodesupplier2 ;
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

					if($request->disc_item_po != ''){
						//update penerimaan barang
						$idpo_update = $request->idpoheader[$indxpo];
						$penerimaanbarang2 = DB::select("select * from penerimaan_barangdt where pbdt_po = '$idpo_update'");
						$adapb = count($penerimaanbarang2);

						if($adapb > 0) {
							for($po = 0; $po < count($request->item_po); $po++){
								$iditem_update = $request->item_po[$po];
								$penerimaanbarangheader = DB::select("select * from penerimaan_barangdt where pbdt_po = '$idpo_update' and pbdt_item = '$iditem_update'");
								$updatebrg = count($penerimaanbarangheader);

								if($updatebrg > 0){							
									$hargabarang = str_replace(',', '', $request->hpp[$po]);									
									$diskon = $request->disc_item_po;
									$nominal = (float)$diskon / 100 * (float)$hargabarang;
									$hargajadi = (float)$hargabarang - (float)$nominal;

									$setuju_dt = DB::table('penerimaan_barangdt')
											->where([['pbdt_po',$idpo_update],['pbdt_item' , $iditem_update]])
											->update([
												'pbdt_hpp' => $hargajadi,											
											]);														
								}

							}
						} // END UPDATE PENERIMAAN BARANG

						//UPDATE STOCK MUTATION PENERIMAAN
						$stokmutation = DB::select("select * from stock_mutation where sm_po = '$idpo_update' and sm_flag = 'PO' and sm_mutcat = '1'");
						$adasm = count($stokmutation);

						if($adasm > 0) {
							for($px = 0; $px < count($request->item_po); $px++){
								$iditem_update2 = $request->item_po[$px];
								$penerimaanbarangheader2 = DB::select("select * from stock_mutation where sm_po = '$idpo_update' and sm_item = '$iditem_update2' and sm_flag = 'PO'");
								$updatebrg2 = count($penerimaanbarangheader2);

								if($updatebrg2 > 0){							
									$hargabarang = str_replace(',', '', $request->hpp[$px]);									
									$diskon = $request->disc_item_po;
									$nominal = (float)$diskon / 100 * (float)$hargabarang;
									$hargajadi = (float)$hargabarang - (float)$nominal;

									$setuju_dt = DB::table('stock_mutation')
											->where([['sm_po',$idpo_update],['sm_item' , $iditem_update2],['sm_flag' , "PO"]])
											->update([
												'sm_hpp' => $hargajadi,											
											]);																		
								}

							}
						}// END UPDATE STOCK MUTATION


						//UPDATE PENGELUARAN BARANG
						$pengeluaranbarang2 = DB::select("select * from pengeluaran_stock_mutasi where psm_sm_po = '$idpo_update'");
						$adapbg = count($penerimaanbarang2);

						if($adapbg > 0){
							for($k = 0; $k < count($request->item_po); $k++){
								$iditem_update3 = $request->item_po[$k];
								$pengeluaranheader = DB::select("select * from pengeluaran_stock_mutasi where psm_sm_po = '$idpo_update' and psm_item = '$iditem_update3' ");
								$updatebrg2 = count($pengeluaranheader);

								if($updatebrg2 > 0){							
									$hargabarang = str_replace(',', '', $request->hpp[$k]);									
									$diskon = $request->disc_item_po;
									$nominal = (float)$diskon / 100 * (float)$hargabarang;
									$hargajadi = (float)$hargabarang - (float)$nominal;

									$setuju_dt = DB::table('pengeluaran_stock_mutasi')
											->where([['psm_sm_po',$idpo_update],['psm_item' , $iditem_update3]])
											->update([
												'psm_harga' => $hargajadi,											
											]);																									
										
								
								}
							}
						} // END PENGELUARAN BARANG

						$stock_mutation2 = DB::select("select * from stock_mutation where sm_po = '$idpo_update' and sm_flag = 'PBG' and sm_mutcat = '2'");

						$adasm2 = count($stock_mutation2);

						if($adasm2 > 0) {
							for($pz = 0; $pz < count($request->item_po); $pz++){
								$iditem_update2 = $request->item_po[$pz];
								$stockmutation2 = DB::select("select * from stock_mutation where sm_po = '$idpo_update' and sm_item = '$iditem_update2' and sm_flag = 'PBG'");
								$updatebrg2 = count($stockmutation2);

								if($updatebrg2 > 0){							
									$hargabarang = str_replace(',', '', $request->hpp[$pz]);									
									$diskon = 	$request->disc_item_po;
									$nominal = (float)$diskon / 100 * $hargabarang;
									$hargajadi = (float)$hargabarang - (float)$nominal;

									$setuju_dt = DB::table('stock_mutation')
											->where([['sm_po',$idpo_update],['sm_item' , $iditem_update2], ['sm_flag' , 'PBG']])
											->update([
												'sm_hpp' => $hargajadi,											
											]);												
								}

							}
						}
					}


				}


		$datafaktur = DB::select("select * from faktur_pembelian where fp_nofaktur = '$nofaktur'");
	
		for($i = 0 ; $i < count($request->item_po); $i++){
				$hargabarang = str_replace(',', '', $request->hpp[$i]);									
				$diskon = $request->disc_item_po;
				$nominal = (float)$diskon / 100 * (float)$hargabarang;
				$hargajadi = (float)$hargabarang - (float)$nominal;
				
			//	return $hargajadi;
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
				$fatkurpembeliandt2->fpdt_idfp = $idfaktur;
				$fatkurpembeliandt2->fpdt_kodeitem = $request->item_po[$i];
				$fatkurpembeliandt2->fpdt_qty = $request->qty[$i];
				/*$fatkurpembeliandt->fpdt_gudang = $request->pb_gudang[$i];*/
				$fatkurpembeliandt2->fpdt_harga =  $hargajadi;
				$total = (float) $hargajadi * $request->qty[$i];
				$fatkurpembeliandt2->fpdt_idpo = $request->idpo[$i];
				//return $total;

				$fatkurpembeliandt2->fpdt_accbiaya = $request->akunitem[$i];
				$fatkurpembeliandt2->fpdt_totalharga =  $total;
				$fatkurpembeliandt2->fpdt_keterangan = $request->keteranganitem[$i];
				$fatkurpembeliandt2->save();


				$akunitem = $request->akunitem[$i];
				$datakun = DB::select("select * from d_akun where id_akun = '$akunitem' and  kode_cabang = '$cabang'");
				$akundka = $datakun[0]->akun_dka;

				if($akundka == 'K'){
					$datajurnal[$i]['id_akun'] = $request->akunitem[$i];
					$datajurnal[$i]['subtotal'] = '-' . $total;
					$datajurnal[$i]['dk'] = 'D';
					$datajurnal[$i]['detail'] = $request->keteranganitem[$i];
				}
				else {
					$datajurnal[$i]['id_akun'] = $request->akunitem[$i];
					$datajurnal[$i]['subtotal'] =  $total;
					$datajurnal[$i]['dk'] = 'D';
					$datajurnal[$i]['detail'] = $request->keteranganitem[$i];	
				}
		}

		//save bayaruangmuka
			//save bayaruangmuka
			$datajurnalum = [];
			if($request->inputbayaruangmuka == 'sukses'){
			

			$lastid =  DB::table('uangmukapembelian_fp')->max('umfp_id');;
			if(isset($lastid)) {
				$idumfp = $lastid;
				$idumfp = (int)$idumfp + 1;
			}
			else {
				$idumfp = 1;
			} 

			 $totaljumlah = str_replace(',', '', $request->totaljumlah);
			 $umfp = new uangmukapembelian_fp;
			 $umfp->umfp_id = $idumfp;
			 $umfp->umfp_totalbiaya = $totaljumlah;
			 $umfp->umfp_tgl 	= $request->tglitem;
			 $umfp->umfp_idfp = $idfaktur;
			 $umfp->created_by = $request->username;
			 $umfp->updated_by = $request->username;
			 $umfp->umfp_keterangan = $request->keteranganumheader;
			 $umfp->umfp_nofaktur = $nofaktur;
			 $umfp->save();
			
			   

			 for($i = 0 ; $i < count($request->dibayarum); $i++){
			 	
			 	$lastids =  DB::table('uangmukapembeliandt_fp')->max('umfpdt_id');;
				if(isset($lastids)) {
					$idumfpdt = $lastids;
					$idumfpdt = (int)$idumfpdt + 1;
				}
				else {
					$idumfpdt = 1;
				} 

				$jumlahum = str_replace(',', '', $request->jumlahum[$i]);
				$dibayarum = str_replace(',', '', $request->dibayarum[$i]);
				$umfpdt = new uangmukapembeliandt_fp;
			  	$umfpdt->umfpdt_id =  $idumfpdt;
			  	$umfpdt->umfpdt_idumfp = $idumfp;
			  	$umfpdt->umfpdt_transaksibank = $request->nokas[$i];
			  	$umfpdt->umfpdt_tgl = $request->tglum[$i];
			  	$umfpdt->umfpdt_jumlahum = $jumlahum;
			  	$umfpdt->umfpdt_dibayar = $dibayarum;
			  	$umfpdt->umfpdt_keterangan = $request->keteranganum[$i];
			  	$umfpdt->umfpdt_idfp = $idfaktur;
			  	$umfpdt->umfpdt_notaum = $request->notaum[$i];
			  	$umfpdt->umfpdt_acchutang = $request->akunhutangum[$i];
			  	$umfpdt->umfpdt_flag = $request->flagum[$i];
			  	$umfpdt->save();

			  	$notaum = $request->notaum[$i];
			  	$dataum = DB::select("select * from d_uangmuka where um_nomorbukti = '$notaum'");
			  	$sisaterpakai = $dataum[0]->um_sisaterpakai;
			  	$pelunasan = $dataum[0]->um_sisapelunasan;

			  	
			  	$hasilterpakai = floatval($sisaterpakai) - floatval($dibayarum);

			  	/*return $hasilterpakai;*/
			  
			  	//return $hasilsisapakai;
			  	 $updateum = DB::table('d_uangmuka')
                ->where('um_nomorbukti' , $request->notaum[$i])
                ->update([
                	'um_sisaterpakai' => $hasilterpakai,                                                           
                ]);


                $notransaksi = $request->nokas[$i];
                if($request->flagum[$i] == 'FPG'){

                	$datafpg = DB::select("select * from fpg, fpg_dt where fpg_nofpg = '$notransaksi' and fpgdt_idfpg = idfpg");
                	$idfpg = $datafpg[0]->idfpg;
                	$sisaum = $datafpg[0]->fpgdt_sisapelunasanumfp;

                	$hasilsisa = floatval($sisaum) - floatval($dibayarum);
                	 $updateum = DB::table('fpg_dt')
	                ->where([['fpgdt_idfpg' , '='  , $idfpg], ['fpgdt_nofaktur' , '=' , $request->notaum[$i]]])
	                ->update([
	                	'fpgdt_sisapelunasanumfp' => $hasilsisa,                                                          
	                ]);
                }
                else {
                	$databkk = DB::select("select * from bukti_kas_keluar where bkk_nota = '$notransaksi'");
                	$idbkk = $databkk[0]->bkk_id;
                	$sisaum = $datafpg[0]->bkkd_sisaum;

                	$hasilsisa = floatval($sisaum) - floatval($dibayarum);
                	 $updateum = DB::table('bukti_kas_keluar_detail')
	                ->where([['bkkd_bkk_id' , '='  , $idbkk], ['bkkd_ref' , '=' , $request->notaum[$i]]])
	                ->update([
	                	'bkkd_sisaum' => $hasilsisa,                                                           
	                ]);
                }


               /* $updateum DB::table('formfpg')
                ->where('')*/

                $akunhutangum = $request->akunhutangum[$i];
               	$caridka = DB::select("select * from d_akun where id_akun = '$akunhutangum'");
               	$dka = $caridka[0]->akun_dka;

               	if($dka == 'D'){
               		$datajurnalum[$i]['id_akun'] = $akunhutangum;
					$datajurnalum[$i]['subtotal'] = '-' . $dibayarum;
					$datajurnalum[$i]['dk'] = 'K';
					$datajurnalum[$i]['detail'] =  $request->keteranganum[$i];
               	}
               	else {
               		$datajurnalum[$i]['id_akun'] = $akunhutangum;
					$datajurnalum[$i]['subtotal'] =  $dibayarum;
					$datajurnalum[$i]['dk'] = 'K';	
					$datajurnalum[$i]['detail'] = $request->keteranganum[$i];
               	}

			  }	


			  	$hasilsisapelunasan = floatval($netto) - floatval($totaljumlah);

			    $updatesm = DB::table('faktur_pembelian')
                ->where('fp_idfaktur' , $idfaktur)
                ->update([
                	'fp_uangmuka' => $totaljumlah,
                    'fp_sisapelunasan' => $hasilsisapelunasan,                                        
               	]);

                //savejurnal
               	$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 
				if(isset($lastidjurnal)) {
					$idjurnal = $lastidjurnal;
					$idjurnal = (int)$idjurnal + 1;
				}
				else {
					$idjurnal = 1;
				}
				
				$year = Carbon::parse($request->tgl_po)->format('Y');

				$jr_no = get_id_jurnal('MM' , $cabang, $request->tgl_po);

				$year = date('Y');	
				$date = date('Y-m-d');
				$jurnal = new d_jurnal();
				$jurnal->jr_id = $idjurnal;
		        $jurnal->jr_year = $year;
		        $jurnal->jr_date = $request->tgl_po;
		        $jurnal->jr_detail = 'UANG MUKA PEMBELIAN FP';
		        $jurnal->jr_ref = $nofaktur;
		        $jurnal->jr_note = $request->keteranganumheader;
		        $jurnal->jr_no = $jr_no;
		        $jurnal->save();
	       		
	       		$acchutangdagang = $request->acchutangdagang;
		        $caridkaheader = DB::select("select * from d_akun where id_akun = '$acchutangdagang'");
		        $akundkaheader = $caridkaheader[0]->akun_dka;

	       		if($akundkaheader == 'D'){
	       			$dataakun_um = array (
					'id_akun' => $request->acchutangdagang,
					'subtotal' => $totaljumlah,
					'dk' => 'D',
					'detail' => $request->keteranganumheader,
					);
	       		}
	       		else {
	       			$dataakun_um = array (
					'id_akun' => $request->acchutangdagang,
					'subtotal' => '-' . $totaljumlah,
					'dk' => 'D',
					'detail' => $request->keteranganumheader,
					);	
	       		}
		        		
				array_push($datajurnalum, $dataakun_um );
	    		
	    		$key  = 1;
	    		for($j = 0; $j < count($datajurnalum); $j++){
	    			
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
	    			$jurnaldt->jrdt_acc = $datajurnalum[$j]['id_akun'];
	    			$jurnaldt->jrdt_value = $datajurnalum[$j]['subtotal'];
	    			$jurnaldt->jrdt_statusdk = $datajurnalum[$j]['dk'];
	    			$jurnaldt->jrdt_detail = $datajurnalum[$j]['detail'];
	    			$jurnaldt->save();
	    			$key++;

				}
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

					$setuju_dt = DB::table('faktur_pembelian')
					->where('fp_idfaktur',$idfaktur)
					->update([
						'fp_fakturpajak' => $idpajakmasukan,											
					]);																				

			}

			//savejurnal
			$datajurnalpo = [];

			//akun PPN
			$datacomp2 = $request->cabangtransaksi;
			if($request->hasilppn_po != '' && $request->hasilpph_po == ''){
				$datakun2 = DB::select("select * from d_akun where id_akun LIKE '2302%' and kode_cabang = '$datacomp2'");
				if(count($datakun2) == 0){
					 $dataInfo=['status'=>'gagal','info'=>'Akun PPN Untuk Cabang Belum Tersedia'];
				    DB::rollback();
			            return json_encode($dataInfo);
				}
				else {
					$akunppn = $datakun2[0]->id_akun;
					$akundka = $datakun2[0]->akun_dka;

					if($akundka == 'K'){
						$dataakun = array (
						'id_akun' => $akunppn,
						'subtotal' => '-' . $hasilppn,
						'dk' => 'D',
						'detail' => $request->keterangan_po,
					);

					}
					else {
						$dataakun = array (
						'id_akun' => $akunppn,
						'subtotal' => $hasilppn,
						'dk' => 'D',
						'detail' => $request->keterangan_po
					);
					}
					array_push($datajurnalpo, $dataakun);
				}

				$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 

				//$totalhutangjr = floatval($hasilppn) - floatval($hasilpph);
				$acchutang = $request->acchutangdagang;

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
			        $jurnal->jr_detail = 'FAKTUR PEMBELIAN';
			        $jurnal->jr_ref = $nofaktur;
			        $jurnal->jr_note = $request->keterangan_po;
			        $jurnal->save();
		       		
			        
		       		$dataakun = array (
						'id_akun' => $acchutang,
						'subtotal' =>  $hasilppn,
						'dk' => 'K',
						'detail' => $request->keterangan_po,
					);

					array_push($datajurnalpo, $dataakun );
		    		$key  = 1;
		    		for($j = 0; $j < count($datajurnalpo); $j++){
		    			
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
		    			$jurnaldt->jrdt_acc = $datajurnalpo[$j]['id_akun'];
		    			$jurnaldt->jrdt_value = $datajurnalpo[$j]['subtotal'];
		    			$jurnaldt->jrdt_statusdk = $datajurnalpo[$j]['dk'];
		    			$jurnaldt->jrdt_detail = $datajurnalpo[$j]['detail'];
		    			$jurnaldt->save();
		    			$key++;
		    		}

			}

			if($request->hasilpph_po != '' && $request->hasilppn_po == ''){
				$datapph = DB::select("select * from pajak where id = '$jenispph'");
				$kodepajak2 = $datapph[0]->acc1;
				$kodepajak = substr($kodepajak2, 0,4);

				$datakun2 = DB::select("select * from d_akun where id_akun LIKE '$kodepajak%' and kode_cabang = '$datacomp2'");
				if(count($datakun2) == 0){
					$dataInfo=['status'=>'gagal','info'=>'Akun PPH Untuk '.$datacomp2.' Belum Tersedia'];
				    DB::rollback();
			            return json_encode($dataInfo);
				}
				else {
					$akunpph = $datakun2[0]->id_akun;
					$akundka = $datakun2[0]->akun_dka;


					if($akundka == 'D'){
						$dataakun = array (
							'id_akun' => $akunpph,
							'subtotal' => '-' . $hasilpph,
							'dk' => 'D',
							'detail' => $request->keterangan_po,
						);
					}
					else {
						$dataakun = array (
							'id_akun' => $akunpph,
							'subtotal' => $hasilpph,
							'dk' => 'K',
							'detail' => $request->keterangan_po,
						);
					}
					array_push($datajurnalpo, $dataakun );
				}

				$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 

				//$totalhutangjr = floatval($hasilppn) - floatval($hasilpph);
				$acchutang = $request->acchutangdagang;

					if(isset($lastidjurnal)) {
						$idjurnal = $lastidjurnal;
						$idjurnal = (int)$idjurnal + 1;
					}
					else {
						$idjurnal = 1;
					}
				
					$year = Carbon::parse($tgl_po)->format('Y');	
					$jr_no = get_id_jurnal('MM' , $cabang, $request->tgl_po);

					$jurnal = new d_jurnal();
					$jurnal->jr_id = $idjurnal;
			        $jurnal->jr_year = date('Y');
			        $jurnal->jr_date = date('Y-m-d');
			        $jurnal->jr_detail = 'FAKTUR PEMBELIAN';
			        $jurnal->jr_ref = $nofaktur;
			        $jurnal->jr_note = $request->keterangan_po;
			        $jurnal->jr_no = $jr_no;
			        $jurnal->save();
		       		
			        
		       		$dataakun = array (
						'id_akun' => $acchutang,
						'subtotal' => '-' . $hasilpph,
						'dk' => 'K',
						'detail' => $request->keterangan_po,
					);

					array_push($datajurnalpo, $dataakun);
		    		$key  = 1;
		    		for($j = 0; $j < count($datajurnalpo); $j++){
		    			
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
		    			$jurnaldt->jrdt_acc = $datajurnalpo[$j]['id_akun'];
		    			$jurnaldt->jrdt_value = $datajurnalpo[$j]['subtotal'];
		    			$jurnaldt->jrdt_statusdk = $datajurnalpo[$j]['dk'];
		    			$jurnaldt->jrdt_detail = $datajurnalpo[$j]['detail'];
		    			$jurnaldt->save();
		    			$key++;
		    		}	
			}


			if($request->hasilpph_po != '' && $request->hasilppn_po != ''){
				$datakun2 = DB::select("select * from d_akun where id_akun LIKE '2302%' and kode_cabang = '$datacomp2'");
				if(count($datakun2) == 0){
					 $dataInfo=['status'=>'gagal','info'=>'Akun PPN Untuk Cabang Belum Tersedia'];
				    DB::rollback();
			            return json_encode($dataInfo);
				}
				else {
					$akunppn = $datakun2[0]->id_akun;
					$akundka = $datakun2[0]->akun_dka;

					if($akundka == 'K'){
						$dataakun = array (
						'id_akun' => $akunppn,
						'subtotal' => '-' . $hasilppn,
						'dk' => 'D',
						'detail' => $request->keterangan_po,
					);

					}
					else {
						$dataakun = array (
						'id_akun' => $akunppn,
						'subtotal' => $hasilppn,
						'dk' => 'D',
						'detail' => $request->keterangan_po,
					);

					}
					array_push($datajurnalpo, $dataakun );
				}

				$datapph = DB::select("select * from pajak where id = '$jenispph'");
				$kodepajak2 = $datapph[0]->acc1;
				$kodepajak = substr($kodepajak2, 0,4);

				$datakun2 = DB::select("select * from d_akun where id_akun LIKE '$kodepajak%' and kode_cabang = '$datacomp2'");
				if(count($datakun2) == 0){
					$dataInfo=['status'=>'gagal','info'=>'Akun PPH Untuk '.$datacomp2.' Belum Tersedia'];
				    DB::rollback();
			            return json_encode($dataInfo);
				}
				else {
					$akunpph = $datakun2[0]->id_akun;
					$akundka = $datakun2[0]->akun_dka;


					if($akundka == 'D'){
						$dataakun = array (
							'id_akun' => $akunpph,
							'subtotal' => '-' . $hasilpph,
							'dk' => 'K',
							'detail' => $request->keterangan_po,
						);
					}
					else {
						$dataakun = array (
							'id_akun' => $akunpph,
							'subtotal' =>  $hasilpph,
							'dk' => 'K',
							'detail' => $request->keterangan_po,
						);
					}

					array_push($datajurnalpo, $dataakun );
				}

				$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 

				$totalhutangjr = floatval($hasilppn) - floatval($hasilpph);	
				
				$acchutang = $request->acchutangdagang;

					if(isset($lastidjurnal)) {
						$idjurnal = $lastidjurnal;
						$idjurnal = (int)$idjurnal + 1;
					}
					else {
						$idjurnal = 1;
					}
					
					$jr_no = get_id_jurnal('MM' , $cabang , $request->tgl_po);

					$year = Carbon::parse($request->tgl_po)->format('Y');	
					$date = date('Y-m-d');
					$jurnal = new d_jurnal();
					$jurnal->jr_id = $idjurnal;
			        $jurnal->jr_year = $year;
			        $jurnal->jr_date = $request->tgl_po;
			        $jurnal->jr_detail = 'FAKTUR PEMBELIAN';
			        $jurnal->jr_ref = $nofaktur;
			        $jurnal->jr_note = $request->keterangan_po;
			        $jurnal->jr_no = $jr_no;
			        $jurnal->save();
		       		
			        
		       		$dataakun = array (
						'id_akun' => $acchutang,
						'subtotal' => $totalhutangjr,
						'dk' => 'K',
						'detail' => $request->keterangan_po,
					);

					array_push($datajurnalpo, $dataakun);
		    		$key  = 1;
		    		for($j = 0; $j < count($datajurnalpo); $j++){
		    			
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
		    			$jurnaldt->jrdt_acc = $datajurnalpo[$j]['id_akun'];
		    			$jurnaldt->jrdt_value = $datajurnalpo[$j]['subtotal'];
		    			$jurnaldt->jrdt_statusdk = $datajurnalpo[$j]['dk'];
		    			$jurnaldt->jrdt_detail = $datajurnalpo[$j]['detail'];
		    			$jurnaldt->save();
		    			$key++;
		    		}	

			}


			$cekjurnal = check_jurnal($nofaktur);
    		if($cekjurnal == 0){
    			$dataInfo =  $dataInfo=['status'=>'gagal','info'=>'Data Jurnal Tidak Balance :('];
				DB::rollback();
									        
    		}
    		elseif($cekjurnal == 1) {
    			$dataInfo =  $dataInfo=['status'=>'sukses','info'=>'Data Jurnal Balance :)','message'=>$idfaktur];
					        
    		}

		return json_encode($dataInfo);

		});
		
	}


	// FAKTUR tanpa po tidak di pakek
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

		public function getprovinsi(Request $request){
			$idcabang = $request->cabang;
			$acchpp = substr($request->acc_hpp, 0,4);
			$accpersediaan = substr($request->acc_persediaan, 0,4);

		
		//	return json_encode($acchpp);
			$data['cabang'] = DB::Select("select * from cabang where kode = '$idcabang'");
			$idkota = $data['cabang'][0]->id_kota;

			$data['provinsi'] = DB::select("select * from kota where id = '$idkota'");
			$provinsi = $data['provinsi'][0]->id_provinsi;



			$data['hpp'] = DB::select("select * from d_akun where id_akun LIKE '$acchpp%' and kode_cabang = '$idcabang'");

		
			$data['persediaan'] = DB::select("select * from d_akun where id_akun LIKE '$accpersediaan%' and kode_cabang = '$idcabang'");

			return $data;
		}

		public function update_fp(Request $request){
			return DB::transaction(function() use ($request) {   
				
		$diskonJurnal=$request->diskon;
		$nofaktur = $request->nofakturitem;
		$jumlahtotal = $request->jumlahtotal;
		$variable = $request->idsupitem;
		$data = explode("+", $variable);
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

			$data_tt = explode("," , $request->inputtandaterima);

			$update_tt =  DB::table('form_tt_d')
	                ->where([['ttd_id' , '='  , $data_tt[0]], ['ttd_detail' , '=' , $data_tt[1]]])
	                ->update([
	                	'ttd_faktur' => $nofaktur,                                                           
		            ]);


			/*// SAVE TANDA TERIMA
			$idtt = DB::select("select tt_noform , max(tt_idform) from form_tt where tt_idcabang = '$cabang' GROUP BY tt_idcabang, tt_noform");
			


			if(is_null($idtt)) {
				
				$explode = explode("/", $idtt);
				$idtt = $explode[2];

				$string = (int)$idtt + 1;
				$idtt = str_pad($string, 4, '0', STR_PAD_LEFT);
			}

			else {
				$idtt = '0001';
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


			$tandaterima->save();*/
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


				$datafp = DB::select("select * from faktur_pembelian where fp_nofaktur = '$nofaktur'");
				if(count($datafp) != 0){
						$explode = explode("/", $datafp[0]->fp_nofaktur);
						$idfaktur3 = $explode[2];
						$string = explode("-", $idfaktur3);
						$idfaktur2 = $string[1];
						$idfakturss = (int)$idfaktur2 + 1;
						$akhirfaktur = str_pad($idfakturss, 4, '0', STR_PAD_LEFT);
						$nofaktur = $explode[0] .'/' . $explode[1] . '/'  . $string[0] . '-' . $akhirfaktur;
				}
				else {
					$nofaktur = $nofaktur;
				}


				$fatkurpembelian = new fakturpembelian();
				$fatkurpembelian->fp_idfaktur = $idfaktur; 
				$fatkurpembelian->fp_nofaktur = $nofaktur;
				$fatkurpembelian->fp_tgl = $request->tglitem;
				$fatkurpembelian->fp_idsup = $idsup;
				$fatkurpembelian->fp_keterangan = strtoupper($request->keteranganheader);
				$fatkurpembelian->fp_noinvoice = $request->noinvoice;
				$fatkurpembelian->fp_jatuhtempo = $request->jatuhtempoitem;
				$fatkurpembelian->fp_jumlah = $total;



				if($request->diskon != ''){
					$fatkurpembelian->fp_discount = $request->diskon;
					$hasildiskon = str_replace(',', '', $request->hasildiskon);	
					$fatkurpembelian->fp_hsldiscount = $hasildiskon;
	
				}
				

				$fatkurpembelian->fp_dpp =$dpp;

				if($request->hasilppn != ''){
					$fatkurpembelian->fp_jenisppn = $request->jenisppn;
					$fatkurpembelian->fp_ppn = $hasilppn;
					$fatkurpembelian->fp_inputppn = $request->inputppn;
				}
				

				if($request->hasilpph != ''){
					$string = explode(",", $request->jenispph);
					$jenispph = $string[0];
					$fatkurpembelian->fp_jenispph = $jenispph;
					$fatkurpembelian->fp_pph = $hasilpph;
					$fatkurpembelian->fp_nilaipph = $request->inputpph;

					$datapph = DB::select("select * from pajak where id = '$jenispph'");
					$kodepajak2 = $datapph[0]->acc1;
					$kodepajak = substr($kodepajak2, 0,4);
					if($kodepajak != ''){
					$datakun2 = DB::select("select * from d_akun where id_akun LIKE '$kodepajak%' and kode_cabang = '$cabang'");
					if(count($datakun2) != 0){
						$accpph = $datakun2[0]->id_akun;
						$fatkurpembelian->fp_accpph = $accpph;
					}
					}
				}
			

				$fatkurpembelian->fp_netto = $netto;
				$fatkurpembelian->fp_jenisbayar = 2;
				//$fatkurpembelian->fp_idtt = $idtandaterima[0]->tt_idform;
				$fatkurpembelian->fp_comp = $request->cabang;
			
				
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

				$comp = $request->cabang;

				$dataacchutang = DB::select("select * from supplier where idsup = '$idsup'");
				$nosupplier = $dataacchutang[0]->no_supplier;
				$acchutangdagang = $dataacchutang[0]->acc_hutang;
				$subacchutang = substr($acchutangdagang, 0 , 4);
				$datakun = DB::select("select * from d_akun where id_akun LIKE '$subacchutang%' and  kode_cabang = '$comp'");
				$acchutang = $datakun[0]->id_akun;
				$dataakundkajr = $datakun[0]->akun_dka;

				$fatkurpembelian->fp_updatestock = $request->updatestock[0];
				$fatkurpembelian->fp_terimabarang = 'BELUM';
				$fatkurpembelian->fp_pending_status = 'APPROVED';
				$fatkurpembelian->fp_status = 'Released';
				$fatkurpembelian->fp_edit = 'ALLOWED';
				$fatkurpembelian->fp_sisapelunasan = $netto;
				$fatkurpembelian->fp_acchutang = $acchutang;
				$fatkurpembelian->fp_supplier = $nosupplier;
				$fatkurpembelian->created_by = $request->username;
				$fatkurpembelian->updated_by = $request->username;

				$fatkurpembelian->save();

					if($request->penerimaan[0] == 'T'){
						
					}
					else {
						
					$lokasigudang = [];
					$idgudang = [];
					for($ds = 0; $ds < count($request->gudang); $ds++){
						$gudang = explode(",", $request->gudang[$ds]);
						$mgid = $gudang[0];
						

						array_push($lokasigudang , $mgid);		
					}
					
					
					$idgudang = array_unique($lokasigudang);
					for($i = 0; $i < count($idgudang); $i++){
						$lastidterima = barang_terima::max('bt_id'); 

						if(isset($lastidterima)) {
							$idbarangterima = $lastidterima;
							$idbarangterima = (int)$idbarangterima + 1;
						}
						else {
							$idbarangterima = 1;	
						}
							
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
			
			$datajurnal = [];
			$totalhutang = 0;



			for($x=0; $x < count($request->item); $x++){
				$lastidfpdt = fakturpembeliandt::max('fpdt_id');

			
				$iditem = $request->item[$x];
				if($request->penerimaan[$x] != 'T'){
					$gudang = explode(",", $request->gudang[$x]);
					$idgudang = $gudang[0];
				}
				
				$dataitem = DB::select("select * from masteritem where kode_item = '$iditem'");
				
				if($request->penerimaan[$x] == 'Y'){
					if($request->updatestock[$x] == 'Y'){
						$akunitem = substr($dataitem[0]->acc_persediaan, 0,4);
					}
					else {
						$akunitem = substr($dataitem[0]->acc_hpp, 0,4);
					}
				//	$fatkurpembeliandt->fpdt_gudang =$idgudang;
				}else {
					$akunitem = substr($dataitem[0]->acc_hpp, 0,4);
				}
				

				$datakun2 = DB::select("select * from d_akun where id_akun LIKE '$akunitem%' and kode_cabang = '$comp'");
				$dataakunitem = $datakun2[0]->id_akun;
				$dataakundka = $datakun2[0]->akun_dka;



				if(isset($lastidfpdt)) {
					$idfakturdt = $lastidfpdt;
					$idfakturdt = (int)$idfakturdt + 1;
				}
				else {
					$idfakturdt = 1;
				}

				$harga = str_replace(',', '', $request->harga[$x]);
				$totalharga = str_replace(',', '', $request->totalharga[$x]);
				$nettoitem = str_replace(',', '', $request->nettoitem[$x]);

			//	return $nettoitem . $request->nettoitem[$x];

				$fatkurpembeliandt = new fakturpembeliandt();
				$fatkurpembeliandt->fpdt_id = $idfakturdt;
				$fatkurpembeliandt->fpdt_idfp = $idfaktur;
				$fatkurpembeliandt->fpdt_kodeitem = $iditem;
				$fatkurpembeliandt->fpdt_qty = $request->qty[$x];
				if($request->penerimaan[$x] != 'T'){
					$fatkurpembeliandt->fpdt_gudang =$idgudang;
				}
				
				$fatkurpembeliandt->fpdt_harga =  $harga;
				$fatkurpembeliandt->fpdt_totalharga =  $totalharga;
				$fatkurpembeliandt->fpdt_updatedstock =  $request->updatestock[$x];



				if($request->biaya[$x] != ''){
					$biaya = str_replace(',', '', $request->biaya[$x]);
					$fatkurpembeliandt->fpdt_biaya = $biaya;  
				}
				
				if($request->penerimaan[$x] == 'Y'){
					if($request->updatestock[$x] == 'Y'){
						$fatkurpembeliandt->fpdt_accpersediaan =  $dataakunitem;
					}else{
						$fatkurpembeliandt->fpdt_accbiaya =  $dataakunitem;
					}
				}
				else {
					$fatkurpembeliandt->fpdt_accbiaya =  $dataakunitem;
				}

				$fatkurpembeliandt->fpdt_keterangan =  $request->keteranganitem[$x];
				$fatkurpembeliandt->fpdt_netto =  $nettoitem;
				$fatkurpembeliandt->fpdt_groupitem =  $request->groupitem[$x];
				$fatkurpembeliandt->save();
				/*$fatkurpembeliandt->fpdt_idpo =  */


				if($dataakundka == 'K'){
					$datajurnal[$x]['id_akun'] = $dataakunitem;
					$datajurnal[$x]['subtotal'] = '-' . $nettoitem;
					$datajurnal[$x]['dk'] = 'D';
					$datajurnal[$x]['detail'] =  $request->keteranganitem[$x];
				}
				else {
					$datajurnal[$x]['id_akun'] = $dataakunitem;
					$datajurnal[$x]['subtotal'] = $nettoitem;
					$datajurnal[$x]['dk'] = 'D';
					$datajurnal[$x]['detail'] = $request->keteranganitem[$x];
				}
				$totalhutang = $totalhutang + $nettoitem;
			}

			//save bayaruangmuka
			$datajurnalum = [];
			if($request->inputbayaruangmuka == 'sukses'){
			

			$lastid =  DB::table('uangmukapembelian_fp')->max('umfp_id');;
			if(isset($lastid)) {
				$idumfp = $lastid;
				$idumfp = (int)$idumfp + 1;
			}
			else {
				$idumfp = 1;
			} 

			 $totaljumlah = str_replace(',', '', $request->totaljumlah);
			 $umfp = new uangmukapembelian_fp;
			 $umfp->umfp_id = $idumfp;
			 $umfp->umfp_totalbiaya = $totaljumlah;
			 $umfp->umfp_tgl 	= $request->tglitem;
			 $umfp->umfp_idfp = $idfaktur;
			 $umfp->created_by = $request->username;
			 $umfp->updated_by = $request->username;
			 $umfp->umfp_keterangan = $request->keteranganumheader;
			 $umfp->umfp_nofaktur = $request->nofakturitem;
			 $umfp->save();
			
			   

			 for($i = 0 ; $i < count($request->dibayarum); $i++){
			 	
			 	$lastids =  DB::table('uangmukapembeliandt_fp')->max('umfpdt_id');;
				if(isset($lastids)) {
					$idumfpdt = $lastids;
					$idumfpdt = (int)$idumfpdt + 1;
				}
				else {
					$idumfpdt = 1;
				} 

				$jumlahum = str_replace(',', '', $request->jumlahum[$i]);
				$dibayarum = str_replace(',', '', $request->dibayarum[$i]);
				$umfpdt = new uangmukapembeliandt_fp;
			  	$umfpdt->umfpdt_id =  $idumfpdt;
			  	$umfpdt->umfpdt_idumfp = $idumfp;
			  	$umfpdt->umfpdt_transaksibank = $request->nokas[$i];
			  	$umfpdt->umfpdt_tgl = $request->tglum[$i];
			  	$umfpdt->umfpdt_jumlahum = $jumlahum;
			  	$umfpdt->umfpdt_dibayar = $dibayarum;
			  	$umfpdt->umfpdt_keterangan = $request->keteranganum[$i];
			  	$umfpdt->umfpdt_idfp = $idfaktur;
			  	$umfpdt->umfpdt_notaum = $request->notaum[$i];
			  	$umfpdt->umfpdt_acchutang = $request->akunhutangum[$i];
			  	$umfpdt->umfpdt_flag = $request->flagum[$i];
			  	$umfpdt->save();

			  	$notaum = $request->notaum[$i];
			  	$dataum = DB::select("select * from d_uangmuka where um_nomorbukti = '$notaum'");
			  	$sisaterpakai = $dataum[0]->um_sisaterpakai;
			  	$pelunasan = $dataum[0]->um_sisapelunasan;

			  	
			  	$hasilterpakai = floatval($sisaterpakai) - floatval($dibayarum);

			  	/*return $hasilterpakai;*/
			  
			  	//return $hasilsisapakai;
			  	 $updateum = DB::table('d_uangmuka')
                ->where('um_nomorbukti' , $request->notaum[$i])
                ->update([
                	'um_sisaterpakai' => $hasilterpakai,                                                           
                ]);


                $notransaksi = $request->nokas[$i];
                if($request->flagum[$i] == 'FPG'){

                	$datafpg = DB::select("select * from fpg, fpg_dt where fpg_nofpg = '$notransaksi' and fpgdt_idfpg = idfpg");
                	$idfpg = $datafpg[0]->idfpg;
                	$sisaum = $datafpg[0]->fpgdt_sisapelunasanumfp;

                	$hasilsisa = floatval($sisaum) - floatval($dibayarum);
                	 $updateum = DB::table('fpg_dt')
	                ->where([['fpgdt_idfpg' , '='  , $idfpg], ['fpgdt_nofaktur' , '=' , $request->notaum[$i]]])
	                ->update([
	                	'fpgdt_sisapelunasanumfp' => $hasilsisa,                                                           
	                ]);
                }
                else {
                	$databkk = DB::select("select * from bukti_kas_keluar where bkk_nota = '$notransaksi'");
                	$idbkk = $databkk[0]->bkk_id;
                	$sisaum = $datafpg[0]->bkkd_sisaum;

                	$hasilsisa = floatval($sisaum) - floatval($dibayarum);
                	 $updateum = DB::table('bukti_kas_keluar_detail')
	                ->where([['bkkd_bkk_id' , '='  , $idbkk], ['bkkd_ref' , '=' , $request->notaum[$i]]])
	                ->update([
	                	'bkkd_sisaum' => $hasilsisa,                                                           
	                ]);
                }



                $akunhutangum = $request->akunhutangum[$i];
               	$caridka = DB::select("select * from d_akun where id_akun = '$akunhutangum'");
               	$dka = $caridka[0]->akun_dka;

               	if($dka == 'D'){
               		$datajurnalum[$i]['id_akun'] = $akunhutangum;
					$datajurnalum[$i]['subtotal'] = '-' . $dibayarum;
					$datajurnalum[$i]['dk'] = 'K';
					$datajurnalum[$i]['detail'] = $request->keteranganum[$i];
               	}
               	else {
               		$datajurnalum[$i]['id_akun'] = $akunhutangum;
					$datajurnalum[$i]['subtotal'] = '-' . $dibayarum;
					$datajurnalum[$i]['dk'] = 'K';	
					$datajurnalum[$i]['detail'] = $request->keteranganum[$i];

               	}

			  }	


			  	$hasilsisapelunasan = floatval($netto) - floatval($totaljumlah);

			    $updatesm = DB::table('faktur_pembelian')
                ->where('fp_idfaktur' , $idfaktur)
                ->update([
                	'fp_uangmuka' => $totaljumlah,
                    'fp_sisapelunasan' => $hasilsisapelunasan,                                        
               	]);

                //savejurnal
               	$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 
				if(isset($lastidjurnal)) {
					$idjurnal = $lastidjurnal;
					$idjurnal = (int)$idjurnal + 1;
				}
				else {
					$idjurnal = 1;
				}
				
				$jr_no = get_id_jurnal('MM' , $cabang , $request->tglitem);
				$year = Carbon::parse($request->tglitem)->format('Y');	
				$date = $request->tglitem;
				$jurnal = new d_jurnal();
				$jurnal->jr_id = $idjurnal;
		        $jurnal->jr_year = $year;
		        $jurnal->jr_date = $date;
		        $jurnal->jr_detail = 'UANG MUKA PEMBELIAN FP';
		        $jurnal->jr_ref = $nofaktur;
		        $jurnal->jr_note = $request->keteranganumheader;
		        $jurnal->jr_no = $jr_no;
		        $jurnal->save();
	       		
	       		$acchutangdagang = $request->acchutangdagang;
		        $caridkaheader = DB::select("select * from d_akun where id_akun = '$acchutangdagang'");
		        $akundkaheader = $caridkaheader[0]->akun_dka;

	       		if($akundkaheader == 'D'){
	       			$dataakun_um = array (
					'id_akun' => $request->acchutangdagang,
					'subtotal' => '-' . $totaljumlah,
					'dk' => 'D',
					'detail' => $request->keteranganumheader,
					);
	       		}
	       		else {
	       			$dataakun_um = array (
					'id_akun' => $request->acchutangdagang,
					'subtotal' => $totaljumlah,
					'dk' => 'D',
					'detail' => $request->keteranganumheader,
					);	
	       		}
		        		
				array_push($datajurnalum, $dataakun_um );
	    		
	    		$key  = 1;
	    		for($j = 0; $j < count($datajurnalum); $j++){
	    			
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
	    			$jurnaldt->jrdt_acc = $datajurnalum[$j]['id_akun'];
	    			$jurnaldt->jrdt_value = $datajurnalum[$j]['subtotal'];
	    			$jurnaldt->jrdt_statusdk = $datajurnalum[$j]['dk'];
	    			$jurnaldt->jrdt_detail = $datajurnalum[$j]['detail'];
	    			$jurnaldt->save();
	    			$key++;

				}
			}


			// end save bayaruangmuka

			//save faktur pajak masukan
			if($hasilppn != ''){
				$lastidpajak =  fakturpajakmasukan::max('fpm_id');
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

			$comp = $request->cabang;

			//akun PPN
			if($request->hasilppn != ''){
				$datakun2 = DB::select("select * from d_akun where id_akun LIKE '2302%' and kode_cabang = '$comp'");
				if(count($datakun2) == 0){
					 $dataInfo=['status'=>'gagal','info'=>'Akun PPN Untuk Cabang Belum Tersedia'];
				    DB::rollback();
			            return json_encode($dataInfo);
				}
				else {
					$akunppn = $datakun2[0]->id_akun;
					$akundka = $datakun2[0]->akun_dka;


					if($akundka == 'K'){
						$dataakun = array (
						'id_akun' => $akunppn,
						'subtotal' => '-' . $hasilppn,
						'dk' => 'K',
						'detail' => $request->keteranganheader,
						);
					}
					else {
						$dataakun = array (
						'id_akun' => $akunppn,
						'subtotal' => $hasilppn,
						'dk' => 'D',
						'detail' => $request->keteranganheader,
						);
					}
					array_push($datajurnal, $dataakun );
					}
					$totalhutang = floatval($totalhutang) + floatval($hasilppn);
				}
			


			//akun PPH
			if($request->hasilpph != ''){				
					$datapph = DB::select("select * from pajak where id = '$jenispph'");
					$kodepajak2 = $datapph[0]->acc1;
					$kodepajak = substr($kodepajak2, 0,4);
					if($kodepajak != ''){
					$datakun2 = DB::select("select * from d_akun where id_akun LIKE '$kodepajak%' and kode_cabang = '$comp'");
					if(count($datakun2) == 0){
						$dataInfo=['status'=>'gagal','info'=>'Akun PPH Untuk Cabang Belum Tersedia'];
					    DB::rollback();
				            return json_encode($dataInfo);
					}
					else {
						$akunpph = $datakun2[0]->id_akun;
						$akundka = $datakun2[0]->akun_dka;

						if($akundka == 'D'){
							$dataakun = array (
							'id_akun' => $akunpph,
							'subtotal' => '-' . $hasilpph,
							'dk' => 'D',
							'detail' => $request->keteranganheader,
							);
						}
						else {
							$dataakun = array (
							'id_akun' => $akunpph,
							'subtotal' => $hasilpph,
							'dk' => 'K',
							'detail' => $request->keteranganheader,
							);
						}
						array_push($datajurnal, $dataakun);
					}

					$totalhutang = floatval($totalhutang) - floatval($hasilpph);
				}
			}

			//jurnal
			if($request->updatestock[0] == 'T'  || $request->kodestock[0] == 'T'){

				$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 
				if(isset($lastidjurnal)) {
					$idjurnal = $lastidjurnal;
					$idjurnal = (int)$idjurnal + 1;
				}
				else {
					$idjurnal = 1;
				}
			
				$year = Carbon::parse($request->tglitem)->format('Y');	
				$date = $request->tglitem;
				$jr_no = get_id_jurnal('MM', $cabang, $request->tglitem);
				$jurnal = new d_jurnal();
				$jurnal->jr_id = $idjurnal;
		        $jurnal->jr_year = $year;
		        $jurnal->jr_date = $date;
		        $jurnal->jr_detail = 'FAKTUR PEMBELIAN';
		        $jurnal->jr_ref = $nofaktur;
		        $jurnal->jr_note = $request->keteranganheader;
		        $jurnal->jr_no = $jr_no;
		        $jurnal->save();
	       		
		        
	       		$dataakun = array (
					'id_akun' => $acchutang,
					'subtotal' => $totalhutang,
					'dk' => 'K',
					'detail' => $request->keteranganheader,
				);

				array_push($datajurnal, $dataakun );
	    		$key  = 1;
	    		for($j = 0; $j < count($datajurnal); $j++){
	    			
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
	    			$jurnaldt->jrdt_acc = $datajurnal[$j]['id_akun'];
	    			$jurnaldt->jrdt_value = $datajurnal[$j]['subtotal'];
	    			$jurnaldt->jrdt_statusdk = $datajurnal[$j]['dk'];
	    			$jurnaldt->jrdt_detail = $datajurnal[$j]['detail'];
	    			$jurnaldt->save();
	    			$key++;
	    		}	
			}		
			   

			$cekjurnal = check_jurnal($nofaktur);
    		if($cekjurnal == 0){
    			$dataInfo =  $dataInfo=['status'=>'gagal','info'=>'Data Jurnal Tidak Balance :('];
				DB::rollback();
									        
    		}
    		elseif($cekjurnal == 1) {
    			$dataInfo =  $dataInfo=['status'=>'sukses','info'=>'Data Jurnal Balance :)','message'=>$idfaktur];
					        
    		}

    		

		return json_encode($dataInfo);
		});
	}


	
	
	public function getnotatt(Request $request){
			$cabang = $request->cabang;
			//MEMBUAT NOFORMTT	
			$time = Carbon::now();
		//	$newtime = date('Y-M-d H:i:s', $time);  
			
			$year =Carbon::createFromFormat('Y-m-d H:i:s', $time)->year; 
			$month =Carbon::createFromFormat('Y-m-d H:i:s', $time)->month; 

			$supplier = $request->supplier;
			$explode = explode("+" , $supplier);
			$nosupplier = $explode[4];
			if($request->edit == 'edit'){
				$nofaktur = $request->nofaktur;
				$data['tt'] = DB::select("select * from form_tt, form_tt_d where tt_supplier = '$nosupplier' and ttd_id = tt_idform and ttd_faktur is null or ttd_faktur = '$nofaktur' and ttd_id = tt_idform");
			}
			else {
				$data['tt'] = DB::select("select * from form_tt, form_tt_d where tt_supplier = '$nosupplier' and ttd_id = tt_idform and ttd_faktur is null");
			}
			/*return $nosupplier;*/

			$data['counttt'] = count($data['tt']);


			return json_encode($data);
	}

	public function getbiayalain (Request $request){
		$cabang = $request->cabang;
		$flag = $request->a;
		$tgl = $request->tgl;

		$bulan = Carbon::parse($tgl)->format('m');
        $tahun = Carbon::parse($tgl)->format('y');
        
    /*  return $bulan . $tahun;*/
		if($flag == ''){
				$faktur = DB::select("select substr(MAX(fp_nofaktur), 14) as nota from faktur_pembelian where  to_char(fp_tgl, 'MM') = '$bulan' and to_char(fp_tgl, 'YY') = '$tahun' and fp_comp = '$cabang' and fp_nofaktur LIKE '%/I-%'");

		}
		else if($flag == 'I') {
		$faktur = DB::select("select substr(MAX(fp_nofaktur), 14) as nota from faktur_pembelian where  to_char(fp_tgl, 'MM') = '$bulan' and to_char(fp_tgl, 'YY') = '$tahun' and fp_comp = '$cabang' and fp_nofaktur LIKE '%/$flag-%'");
		}
		else if($flag == 'PO'){
		$faktur = DB::select("select substr(MAX(fp_nofaktur), 15) as nota from faktur_pembelian where  to_char(fp_tgl, 'MM') = '$bulan' and to_char(fp_tgl, 'YY') = '$tahun' and fp_comp = '$cabang' and fp_nofaktur LIKE '%/$flag-%'");	
		}

		//return $faktur;
		if(count($faktur) > 0) {
		
			

			$idfaktur = (int)$faktur[0]->nota + 1;
			$data['idfaktur'] = str_pad($idfaktur, 4, '0', STR_PAD_LEFT);
			
			//return $data['idfaktur'];
		}

		else {
	
			$data['idfaktur'] = '0001';
		}

		$datainfo = ['status' => 'sukses' , 'data' => $data['idfaktur']];
		return json_encode($datainfo);
	
	}

	public function getnofpg (Request $request){

		$comp = $request->cabang;
		$tgl = $request->tgl;
		//return $comp;
		/*$idbbk = DB::select("select * from bukti_bank_keluar where bbk_cabang = '$comp'");*/
	
		$bulan = Carbon::parse($tgl)->format('m');
        $tahun = Carbon::parse($tgl)->format('y');


	  $carinota = DB::select("SELECT  substring(max(fpg_nofpg),13) as id from fpg
                                    WHERE fpg_cabang = '$comp'
                                    AND to_char(fpg_tgl,'MM') = '$bulan'
                                    AND to_char(fpg_tgl,'YY') = '$tahun'");
      

    //  dd($carinota)
     
        $index = (integer)$carinota[0]->id + 1;
        $index = str_pad($index, 4, '0' , STR_PAD_LEFT);
     //   $nota = 'FPG' .  $getmonth . $gettahun . '/' . $cabang . '/' . $index;

		$datainfo =['status' => 'sukses' , 'data' => $index];

		$data['idfpg'] = $index;
		
		$data['nofpg'] = 'FPG' . $bulan . $tahun . '/' . $comp . '/' . $index;

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
		$data = explode("+", $variable);
		$idsup = $data[0];
		$cabang = $request->cabang;

			if($cabang == '000'){
				$data['po'] = DB::select("select  LEFT(po_no,2) as flag , po_cabangtransaksi as cabang, po_id as id , po_no as nobukti, pb_po, po_tipe as penerimaan, po_totalharga as totalharga , po_ppn as hasilppn, po_jenisppn as jenisppn from pembelian_order LEFT OUTER JOIN penerimaan_barang on pb_po = po_id where po_supplier = '$idsup' and po_tipe != 'J'  and pb_terfaktur IS null and po_statusreturn = 'AKTIF' union select  LEFT(po_no,2) as flag , po_cabangtransaksi as cabang, po_id as id , po_no as nobukti, po_id, po_tipe as penerimaan, po_totalharga as totalharga, po_ppn as hasilppn, po_jenisppn as jenisppn from pembelian_order LEFT OUTER JOIN penerimaan_barang on pb_po = po_id and po_supplier = '$idsup' where po_tipe = 'J'  and po_idfaktur IS null and po_statusreturn = 'AKTIF' and po_setujufinance = 'SETUJU' order  by id desc");
	
			}		
			else {
				$data['po'] = DB::select("select  LEFT(po_no,2) as flag , po_cabangtransaksi as cabang, po_id as id , po_no as nobukti, pb_po, po_tipe as penerimaan, po_totalharga as totalharga , po_ppn as hasilppn, po_jenisppn as jenisppn from pembelian_order LEFT OUTER JOIN penerimaan_barang on pb_po = po_id where po_supplier = '$idsup' and po_tipe != 'J' and po_cabangtransaksi = '$cabang' and po_statusreturn = 'AKTIF' and pb_terfaktur IS null union select  LEFT(po_no,2) as flag , po_cabangtransaksi as cabang, po_id as id , po_no as nobukti, po_id, po_tipe as penerimaan, po_totalharga as totalharga, po_ppn as hasilppn, po_jenisppn as jenisppn from pembelian_order LEFT OUTER JOIN penerimaan_barang on pb_po = po_id and po_supplier = '$idsup' where po_tipe = 'J' and po_cabangtransaksi = '$cabang' and po_idfaktur IS null and po_statusreturn = 'AKTIF'  order  by id desc");
			}
			
			

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
						$datas['data'] = DB::select("select po_no, po_totalharga, po_id, string_agg(pb_status,',') as p from pembelian_order LEFT OUTER JOIN penerimaan_barang on pb_po = po_id where po_supplier = '$idsup' and po_tipe != 'J' and po_id = '$id' and po_statusreturn = 'AKTIF'  group by po_id , po_no order by p");
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

					$data['po'][] = DB::select("select po_id ,po_no, po_subtotal, po_tipe, po_ppn, po_jenisppn, po_totalharga, po_cabangtransaksi, po_acchutangdagang from pembelian_order, penerimaan_barang where po_id = pb_po and po_no = '$no_po' and po_statusreturn = 'AKTIF'  Group by po_id, po_no");
					$data['po_barang'][] = DB::select("select distinct po_id, po_no, nama_masteritem, acc_persediaan , pb_gudang, pbdt_item, pbdt_idspp, sum(pbdt_totalharga) as sumharga, sum(podt_qtykirim) as qty_po, pb_po , pbdt_updatestock, podt_jumlahharga, podt_akunitem, sum(pbdt_qty) as sumqty, pb_comp, acc_hpp  from penerimaan_barang , pembelian_order, penerimaan_barangdt, pembelian_orderdt, masteritem where po_id = podt_idpo and pbdt_idpb = pb_id and pbdt_item = kode_item  and podt_kodeitem = pbdt_item and podt_idpo = pb_po and  pbdt_po = pb_po and pbdt_idspp = podt_idspp and po_no = '$no_po'  and po_statusreturn = 'AKTIF'  group by pb_gudang, nama_masteritem, pbdt_item, pbdt_idspp, pb_po, pbdt_updatestock ,pbdt_hpp, pb_comp, acc_persediaan, podt_jumlahharga, acc_hpp, po_no, po_id, podt_akunitem");

					$data['barang_penerimaan'] = DB::select("select distinct nama_masteritem, acc_persediaan , pb_gudang, pbdt_item, pbdt_idspp, sum(pbdt_totalharga) as sumharga, podt_qtykirim , pb_po , pbdt_updatestock, podt_jumlahharga, sum(pbdt_qty) as sumqty, pb_comp, acc_hpp  from penerimaan_barang , penerimaan_barangdt, masteritem, pembelian_orderdt where pbdt_idpb = pb_id and pbdt_item = kode_item  and podt_kodeitem = pbdt_item and podt_idpo = pb_po and  pbdt_po = pb_po and pbdt_idspp = podt_idspp  group by pb_gudang, nama_masteritem, pbdt_item, pbdt_idspp, pb_po, pbdt_updatestock ,pbdt_hpp, pb_comp, podt_qtykirim,acc_persediaan, podt_jumlahharga, acc_hpp");
				}
				else {

					$data['po'][] = DB::select("select po_id ,po_no, po_subtotal, po_tipe, po_ppn, po_jenisppn, po_totalharga, po_cabangtransaksi, po_acchutangdagang  from pembelian_order where  po_no = '$no_po' and po_statusreturn = 'AKTIF'  Group by po_id, po_no");

					$data['po_barang'][] = DB::select("select po_no, po_id, nama_masteritem, podt_totalharga, podt_kodeitem, podt_qtykirim, podt_jumlahharga, podt_akunitem from pembelian_order,  masteritem, pembelian_orderdt where podt_kodeitem = kode_item and podt_idpo = po_id and po_no = '$no_po' and po_statusreturn = 'AKTIF' ");

					$data['barang_penerimaan'] = DB::select("select po_id, nama_masteritem, podt_kodeitem, podt_qtykirim, podt_totalharga, podt_jumlahharga from pembelian_order,  masteritem, pembelian_orderdt where podt_kodeitem = kode_item and podt_idpo = po_id");

					
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


	public function pelunasanhutangbank() {

		return view('purchase/pelunasanhutangbank/index');
	}


	public function pelunasanhutangbanktable(Request $request) {
		  $data='';
		  $bank='';
  		  $tgl='';
  		  $biaya='';
  		  $total='';
  		  $nofpg='';
  		  $tgl1=date('Y-m-d',strtotime($request->tanggal1));
  		  $tgl2=date('Y-m-d',strtotime($request->tanggal2));
  		  if($request->tanggal1!='' && $request->tanggal2!=''){  		  	
  		  	$tgl="and bbk_tgl >= '$tgl1' AND bbk_tgl <= '$tgl2'";
  		  }  		  
  		  if($request->bank!=''){
  		  	$bank="and mb_nama=$request->bank";
  		  }
  		  if($request->biaya!=''){
  		  	$biaya="and bbk_biaya=$request->biaya";
  		  }
  		  if($request->total!=''){
  		  	$total="and bbk_total=$request->total";
  		  }
  		  if($request->nofpg!=''){
  		  	$nofpg="and bbk_nota='$request->nofpg'";
  		  }
		 $cabang = session::get('cabang');
		 
	/*	$data= DB::select("select *,'no' as no from bukti_bank_keluar, cabang, masterbank where bbk_cabang = cabang.kode and bbk_kodebank = mb_id order by bbk_id desc" );*/





	   $cabang = session::get('cabang');
		if(Auth::user()->punyaAkses('Pelunasan Hutang','all')){
			$data= DB::select("select *,'no' as no from cabang, masterbank, bukti_bank_keluar LEFT OUTER JOIN fpg on bbk_idfpg = idfpg where bbk_cabang = cabang.kode and bbk_kodebank = mb_id $tgl $bank $biaya $total $nofpg order by bbk_id desc" );

		}
		else {
			$data= DB::select("select *,'no' as no from cabang, masterbank, bukti_bank_keluar LEFT OUTER JOIN fpg on bbk_idfpg = idfpg where bbk_cabang = cabang.kode and bbk_kodebank = mb_id order and bbk_cabang = '$cabang' $tgl $bank $biaya $total $nofpg order by bbk_id desc" );

		}


dd($data);

		$data=collect($data);


			return DataTables::of($data)
			->editColumn('bbk_tgl', function ($data) {            
            	return date('d-m-Y',strtotime($data->bbk_tgl));
            })
           ->editColumn('bbk_cekbg', function ($data) { 
                return number_format($data->bbk_cekbg, 2);                
            })
           ->editColumn('fpg_nofpg', function ($data) { 
 			 	if($data->fpg_nofpg != ''){
                     return $data->fpg_nofpg;
                }else{
                     return '-';
                }                               
            })
           ->editColumn('bbk_biaya', function ($data) { 
                return number_format($data->bbk_biaya, 2);                
            })->editColumn('bbk_total', function ($data) { 
                return number_format($data->bbk_total, 2);                
            })->addColumn('action', function ($data) {                 
				$action='';

            	if(Auth::user()->punyaAkses('Pelunasan Hutang','ubah')){
                   $action.='<a class="btn btn-sm btn-success text-right" 
                   href='.url('pelunasanhutangbank/detailpelunasanbank/'.$data->bbk_id.'').'>
                   <i class="fa fa-arrow-right" aria-hidden="true"></i></a> &nbsp'; 
                      }
                if(Auth::user()->punyaAkses('Pelunasan Hutang','print')){
                   $action.='<a class="btn btn-sm btn-info" 
                   href='.url('pelunasanhutangbank/cetak/'.$data->bbk_id.'').' type="button">
                    <i class="fa fa-print" aria-hidden="true"></i> </a>';
                }
                if(Auth::user()->punyaAkses('Pelunasan Hutang','hapus')){
                    $action.='<a class="btn btn-sm btn-danger" onclick="hapus('.$data->bbk_id.')" type="button"> <i class="fa fa-trash" aria-hidden="true"></i> </a>';
                }

				return $action;


            })
            
			->make(true);	




		
	}

	public function createpelunasanbank() {
		$data['bank'] = DB::select("select * from masterbank");
		$data['cabang'] = DB::select("select * from cabang");
		$cabang = session::get('cabang');
		if($cabang == 000){
			$data['akun'] = DB::select("select * from d_akun");
		}
		else {
			$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '5%' or id_akun LIKE '6%'");
		}
	
		return view('purchase/pelunasanhutangbank/create', compact('data'));
	}

	public function cetakbbk ($id) {
		$data['bbk'] = DB::select("select * from bukti_bank_keluar , masterbank where bbk_id = '$id' and bbk_kodebank = mb_id ");
		$flag = $data['bbk'][0]->bbk_flag;

		$data['terbilang'] = $this->terbilang($data['bbk'][0]->bbk_total,$style=3);	

		if($flag == 'CEKBG'){
			$data['detail'] = DB::select("select * from bukti_bank_keluar_detail , bukti_bank_keluar, d_akun, masterbank where bbkd_idbbk = bbk_id and bbk_id = '$id' and bbk_kodebank = mb_id and id_akun = mb_kode");
		}
		else if($flag == 'BGAKUN'){
			$data['detail'] = DB::select("select * from bukti_bank_keluar_akunbg , bukti_bank_keluar, d_akun, masterbank where bbkab_idbbk = bbk_id and bbk_id = '$id' and bbk_kodebank = mb_id and id_akun = mb_kode");
		}
		else {
			$data['detail'] = DB::select("select * from bukti_bank_keluar_biaya, bukti_bank_keluar, d_akun where bbkb_idbbk = bbk_id and bbk_id = '$id' and bbkb_akun = id_akun");
		}
	//	dd($data);
		return view('purchase/pelunasanhutangbank/cetakbbk', compact('data'));
	}

	public function detailpelunasanbank($id) {
		$cabang = session::get('cabang');

		$data['bank'] = DB::select("select * from masterbank");
		$data['cabang'] = DB::select("select * from cabang");
			if($cabang == 000){
				$data['akun'] = DB::select("select * from d_akun");

			}
			else {
				$data['akun'] = DB::select("select * from d_akun where id_akun LIKE '5%' or id_akun LIKE '6%'");
			}
			$data['bbk'] = DB::select("select * from bukti_bank_keluar, cabang, masterbank where bbk_cabang = cabang.kode and bbk_kodebank = mb_id and bbk_id = '$id'" );
			$flag = $data['bbk'][0]->bbk_flag;

			$data['bbkd'] = array();
			if($flag == 'CEKBG'){
				$bbkd = DB::select("select * from bukti_bank_keluar, bukti_bank_keluar_detail, cabang, masterbank where bbk_cabang = cabang.kode and bbk_kodebank = mb_id and bbkd_idbbk = bbk_id and bbk_id = '$id'");
			
				for($j = 0 ; $j < count($bbkd); $j++){
					$jenissup = $bbkd[$j]->bbkd_jenissup;
					if($jenissup == 'supplier'){
						$data['jenissup'][] = 'supplier';
						$data['bbkd'] = DB::select("select * from bukti_bank_keluar, bukti_bank_keluar_detail, cabang, masterbank, supplier where bbk_cabang = cabang.kode and bbk_kodebank = mb_id and bbkd_idbbk = bbk_id and bbkd_supplier = supplier.no_supplier and active = 'AKTIF' and bbkd_jenissup = 'supplier' and bbk_id = '$id' ");
					}
					else if($jenissup == 'agen'){
						$data['jenissup'][] = 'agen';
						$data['bbkd'] = DB::select("select * from bukti_bank_keluar, bukti_bank_keluar_detail, cabang, masterbank, agen where bbk_cabang = cabang.kode and bbk_kodebank = mb_id and bbkd_idbbk = bbk_id and bbkd_supplier = agen.kode  and bbkd_jenissup == 'agen' and bbk_id = '$id'");
					}
					else if($jenissup == 'subcon'){
						$data['jenissup'][] = 'subcon';
						$data['bbkd'] = DB::select("select * from bukti_bank_keluar, bukti_bank_keluar_detail, cabang, masterbank, subcon where bbk_cabang = cabang.kode and bbk_kodebank = mb_id and bbkd_idbbk = bbk_id and bbkd_supplier = subcon.kode and bbkd_jenissup == 'subcon' and bbk_id = '$id' ");
					}
					else if($jenissup == 'cabang'){
						$data['jenissup'][] = 'cabang';
						$data['bbkd']= DB::select("select * from bukti_bank_keluar, bukti_bank_keluar_detail, cabang, masterbank where bbk_cabang = cabang.kode and bbk_kodebank = mb_id and bbkd_idbbk = bbk_id and bbkd_supplier = cabang.kode and bbkd_jenissup = 'cabang' and bbk_id = '$id'");
					}
					else {
						$data['bbkd'] = DB::select("select * from bukti_bank_keluar, bukti_bank_keluar_detail, cabang, masterbank  where bbk_cabang = cabang.kode and bbkd_idbbk = bbk_id and bbkd_supplier = cabang.kode  and bbk_id = '$id' and bbk_kodebank = mb_id ");
					}
					/*$data['cndnt'][] = $cn;*/
				}
			}
			else if($flag == 'BIAYA') {
				$data['bbkd'] = DB::select("select * from bukti_bank_keluar, bukti_bank_keluar_biaya, cabang, masterbank, d_akun where bbk_cabang = cabang.kode and bbk_kodebank = mb_id and bbkb_idbbk = bbk_id and bbkb_akun = id_akun and bbk_id = '$id' ");
			}
			else if($flag == 'BGAKUN'){
				$data['bbkd'] = DB::select("select * from bukti_bank_keluar, bukti_bank_keluar_akunbg, cabang, masterbank, d_akun where bbk_cabang = cabang.kode and bbk_kodebank = mb_id and bbkab_idbbk = bbk_id and bbkab_akun = id_akun and bbk_id = '$id'");
			}

			$jurnalRef = $data['bbk'][0]->bbk_nota;
			
			$jurnal_dt=collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk
                        FROM d_akun a join d_jurnal_dt jd
                        on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
                        (select j.jr_id from d_jurnal j where jr_ref='$jurnalRef')")); 
		/*	dd($data['bbkd']);*/
			return view('purchase/pelunasanhutangbank/detail' , compact('data', 'jurnal_dt'));
	}

	public function nocheckpelunasanhutangbank(Request $request){
		$idbank = $request->kodebank;
		$cabang = $request->cabang;

	
			$datas['fpgbank'] = DB::select("select * from fpg_cekbank,fpg where fpgb_kodebank = '$idbank' and fpgb_idfpg = idfpg and fpgb_posting is null and fpg_cabang = '$cabang' order by idfpg ASC");
		




		return json_encode($datas);
	}

	public function getcek(Request $request){

		for($i=0; $i < count($request->idfpg); $i++){

			//return (count($request->idfpg));
		$idfpg = $request->idfpg[$i];
		$idfpgb = $request->idfpgb[$i];

		$fpg = DB::select("select * from fpg where idfpg = '$idfpg'");
		$jenisbayar = $fpg[0]->fpg_jenisbayar;

	/*	return $jenisbayar;*/
		if($jenisbayar == '4'){
			$fpg2 = DB::select("select * from fpg, d_uangmuka where idfpg = '$idfpg' and fpg_agen = um_supplier");
			$jenissup = $fpg2[0]->um_jenissup;
			$data['jenissup'] = $jenissup;
			if($jenissup == 'supplier'){
				$data['fpg'] = DB::select("select * from fpg, fpg_cekbank ,supplier, masterbank, jenisbayar where idfpg = '$idfpg' and fpg_agen = no_supplier and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpgb_id = '$idfpgb' and fpgb_idfpg = idfpg and idfpg = '$idfpg'");
			}
			else if($jenissup == 'agen'){
				$data['fpg'] = DB::select("select * from fpg,agen, fpg_cekbank , masterbank, jenisbayar where idfpg = '$idfpg' and fpg_agen = kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpgb_id = '$idfpgb' and fpgb_idfpg = idfpg and idfpg = '$idfpg'");	
			}
			else if($jenissup == 'subcon'){
				$data['fpg'] = DB::select("select * from fpg, fpg_cekbank, subcon, masterbank, jenisbayar where idfpg = '$idfpg' and fpg_agen = kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpgb_id = '$idfpgb' and fpgb_idfpg = idfpg and idfpg = '$idfpg'");	
			}

		}
		else if($jenisbayar == '2'){
			$data['fpg'] = DB::select("select * from fpg, fpg_cekbank, supplier, masterbank, jenisbayar where idfpg = '$idfpg' and fpg_supplier = idsup and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpgb_id = '$idfpgb' and fpgb_idfpg = idfpg and idfpg = '$idfpg'");	
		}
		else if($jenisbayar == '3'){

			$data['fpg'] = DB::select("select * from fpg, fpg_cekbank, supplier, masterbank, jenisbayar where idfpg = '$idfpg' and fpg_agen = no_supplier and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpgb_id = '$idfpgb' and fpgb_idfpg = idfpg and idfpg = '$idfpg'");		
		
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
			$data['fpg'] = DB::select("select * from fpg, fpg_cekbank, cabang, masterbank, jenisbayar where idfpg = '$idfpg' and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpgb_id = '$idfpgb' and fpgb_idfpg = idfpg and idfpg = '$idfpg' and fpg_cabang = kode");
		}
		else if($jenisbayar == '11'){
			$data['fpg'] = DB::select("select * from fpg, fpg_cekbank, cabang, masterbank, jenisbayar where idfpg = '$idfpg' and fpg_jenisbayar = idjenisbayar and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpgb_id = '$idfpgb' and fpgb_idfpg = idfpg and idfpg = '$idfpg' and fpg_cabang = kode");
		}
		else if($jenisbayar == '12'){
			$data['fpg'] = DB::select("select * from fpg, fpg_cekbank, cabang, masterbank, jenisbayar where idfpg = '$idfpg' and fpg_jenisbayar = idjenisbayar and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpgb_id = '$idfpgb' and fpgb_idfpg = idfpg and idfpg = '$idfpg' and fpg_cabang = kode");
		}
		else if($jenisbayar == '13'){ //PENCAIRAN BONSEM
			$data['fpg'] = DB::select("select * from fpg, fpg_cekbank, cabang, masterbank, jenisbayar where idfpg = '$idfpg' and fpg_jenisbayar = idjenisbayar and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpgb_id = '$idfpgb' and fpgb_idfpg = idfpg and idfpg = '$idfpg' and fpg_cabang = kode");
		}
	}
		/*$data['fpgbank'] = DB::select("select * from fpg_cekbank , fpg where fpdb_id = '$idfpgb' and fpgb_idfpg = idfpg and idfpg = '$idfpg' and fpdb_id = '$idfpgb' and fpgb_idfpg = idfpg and idfpg = '$idfpg'");*/

		return json_encode($data);
	}

	public function getnobbk(Request $request){
		$comp = $request->cabang;

		$tgl = $request->tgl;
		//return $comp;
		/*$idbbk = DB::select("select * from bukti_bank_keluar where bbk_cabang = '$comp'");*/
	
		$bulan = Carbon::parse($tgl)->format('m');
        $tahun = Carbon::parse($tgl)->format('y');



		//return $mon;
		$idbbk = DB::select("select * from bukti_bank_keluar where bbk_cabang = '$comp'  and to_char(bbk_tgl, 'MM') = '$bulan' and to_char(bbk_tgl, 'YY') = '$tahun' order by bbk_id desc limit 1");

		
		if(count($idbbk) > 0) {		
			$explode = explode("/", $idbbk[0]->bbk_nota);
			$idbbk = $explode[2];
			$string = (int)$idbbk + 1;
			$idbbk = str_pad($string, 4, '0', STR_PAD_LEFT);
		}
		else {
			$idbbk = '0001';
		}



		

		$datainfo =['status' => 'sukses' , 'data' => $idbbk];

		return json_encode($datainfo) ;
	}
	

	public function simpanbbk (Request $request){
		return DB::transaction(function() use ($request) { 

		$tempdone = 0;
		$bbk = new bukti_bank_keluar();
		$cabang = $request->cabang;
		$lastid =  bukti_bank_keluar::max('bbk_id');
		

		$datajurnal = [];
		$jurnalpb = [];
		$jurnalpbkeluar = [];
		$jurnalbonsem = [];
		$jurnalbonsemkeluar = [];
		$datajurnalbk = [];
		$datajurnalkm = [];
		$datajurnalbm = [];

		$datajurnalbiaya = [];
		$datajurnalbg = [];
		
		$jurnalkas = [];
		$totalhutang = 0;
		$totaltabbiaya = 0;
		$totalbgakun = 0;
		$kodebanks = $request->kodebank;
		$databank = DB::select("select * from masterbank where mb_id = '$kodebanks'");
		$akunhutangdagang = $databank[0]->mb_kode;
		

		//KODEBANK BK
		if($request->kodebank < 10){
			$kodebank = '0' . $request->kodebank;
		}	
		else {
			$kodebank = $request->kodebank;
		}

		if(isset($lastid)) {
			$idbbk = $lastid;
			$idbbk = (int)$idbbk + 1;
		}
		else {
			$idbbk = 1;
		} 

		$bbk->bbk_id = $idbbk;
		$bbk->bbk_nota = $request->nobbk;
		$bbk->bbk_kodebank = $request->kodebank;
		$bbk->bbk_keterangan = strtoupper($request->keteranganheader);
		if($request->flag == 'CEKBG'){
			$totalcekbg = str_replace(',', '', $request->totalcekbg);
			$bbk->bbk_cekbg = $totalcekbg;
		}
		else if($request->flag == 'BIAYA') {
			$totalbiaya = str_replace(',', '', $request->totalbiaya);
			$bbk->bbk_biaya = $totalbiaya;
		}
		else {
			$totalcekbg = str_replace(',', '', $request->totalcekbg);
			$bbk->bbk_cekbg = $totalcekbg;
		}

		$total = str_replace(',', '', $request->total);
		$bbk->bbk_total = $total;
		$bbk->bbk_cabang = $request->cabang;
		$bbk->bbk_flag = $request->flag;
		$bbk->bbk_tgl = $request->tglbbk;
		$bbk->bbk_akunbank = $akunhutangdagang;
		$bbk->create_by = $request->username;
		$bbk->update_by = $request->username;
		$bbk->save();

		/*dd($idbbk);*/

		//return count($request->nofpg);
		if($request->flag == 'CEKBG'){
			$akunkodebank = $request->akunkodebank;

			for($i = 0; $i < count($request->nofpg); $i++){
				$jurnalkaskeluar = [];
				$idfpg = $request->idfpg[$i];
				$datafpg = DB::select("select * from fpg where idfpg = '$idfpg'");
				$jenisbayarfpg = $datafpg[0]->fpg_jenisbayar;
				

				$bbkdt = new bukti_bank_keluar_dt();
				
				$lastidbbkd =  bukti_bank_keluar_dt::max('bbkd_id');
				if(isset($lastidbbkd)) {
						$idbbkd = $lastidbbkd;
						$idbbkd = (int)$idbbkd + 1;
				}
				else {
						$idbbkd = 1;
				} 

				/*dd($idbbk);*/
				$bbkdt->bbkd_id = $idbbkd;
				$bbkdt->bbkd_idbbk = $idbbk;
				$bbkdt->bbkd_nocheck = $request->notransaksi[$i];
				if($request->jatuhtempo[$i] != ''){
					$bbkdt->bbkd_jatuhtempo = $request->jatuhtempo[$i];					
				}
				
				$nominal = str_replace(',', '', $request->nominal[$i]);
				$explode = explode(" ", $request->supplier[$i]);
				$idsupplier = $explode[0];
				$bbkdt->bbkd_nominal = $nominal;
				$bbkdt->bbkd_keterangan = $request->keterangan[$i];
				$bbkdt->bbkd_bank = $request->idbank[$i];
				$bbkdt->bbkd_supplier = $idsupplier;
				$bbkdt->bbkd_tglfpg = $request->tgl[$i];
				$bbkdt->bbkd_jenissup = $request->jenissup[$i];
				$bbkdt->bbkd_idfpg = $request->idfpg[$i];
				$bbkdt->bbkd_akunhutang = $request->hutangdagang[$i];
				$bbkdt->bbkd_jenisbayarfpg = $jenisbayarfpg;
				$bbkdt->save();


				
				$datafpg = DB::select("select * from fpg,fpg_cekbank where idfpg = '$idfpg' and fpgb_idfpg = idfpg");
				$jenisbayar = $datafpg[0]->fpgb_jenisbayarbank;
				if($jenisbayar != 'INTERNET BANKING'){
						$data['idfpg'] = DB::table('fpg_cekbank')
						->where([['fpgb_idfpg', '=', $idfpg],['fpgb_nocheckbg' , '=' , $request->notransaksi[$i]]])
						->update([
							'fpgb_posting' => 'DONE',
						]);


					$dataallfpg = DB::select("select * from fpg, fpg_cekbank where idfpg = '$idfpg' and fpgb_idfpg = idfpg");
					for($x = 0; $x < count($dataallfpg); $x++){
						$done = $dataallfpg[$x]->fpgb_posting;
						if($done == 'DONE'){
							$tempdone = $tempdone + 1;
						}
					} 

					if($tempdone == count($dataallfpg)){
						$data['idfpg'] = DB::table('fpg')
						->where('idfpg' , $idfpg)
						->update([
							'fpg_posting' => 'DONE',
						]);
					}
				}
				else{ // pembayaran cekbg
					$data['idfpg'] = DB::table('fpg_cekbank')
						->where('fpgb_idfpg', '=', $idfpg)
						->update([
							'fpgb_posting' => 'DONE',
						]);


					$dataallfpg = DB::select("select * from fpg, fpg_cekbank where idfpg = '$idfpg' and fpgb_idfpg = idfpg");
					for($x = 0; $x < count($dataallfpg); $x++){
						$done = $dataallfpg[$x]->fpgb_posting;
						if($done == 'DONE'){
							$tempdone = $tempdone + 1;
						}
					} 

					if($tempdone == count($dataallfpg)){
						$data['idfpg'] = DB::table('fpg')
						->where('idfpg' , $idfpg)
						->update([
							'fpg_posting' => 'DONE',
						]);
					}
				} //end pembayaran cekbg



				if($jenisbayarfpg == 12 || $jenisbayarfpg == 11){
					if($jenisbayarfpg == 11){
						$datafpgdt = DB::select("select * from fpg, fpg_dt where idfpg = '$idfpg' and fpgdt_idfpg = idfpg");
						for($j = 0 ; $j < count($datafpgdt); $j++){
							$notabonsem = $datafpgdt[$j]->fpgdt_nofaktur;
							$date =  date('Y-m-d');
							$updatebonsem = bonsempengajuan::where('bp_nota' , '=' , $notabonsem);
							$updatebonsem->update([
								'bp_statusend' =>'FPG',
							]);
						}
					}

					$idfpgb = $request->idfpgb[$i];

					$datafpgb = DB::select("select * from fpg, fpg_cekbank where idfpg = fpgb_idfpg and fpgb_idfpg = '$idfpg' and fpgb_id = '$idfpgb'");
					

					
						$kelompokakun = $datafpgb[0]->fpgb_jeniskelompok;
						if($kelompokakun == 'SAMA BANK'){							
							$akunbanktujuan = $datafpgb[0]->fpgb_kodebanktujuan;
							$nominalfpgb = $datafpgb[0]->fpgb_nominal;
							$datacabangtujuan = DB::select("select * from masterbank where mb_kode = '$akunbanktujuan'");
							//dd($cabangtujuanbm);
							$cabangtujuanbm = $datacabangtujuan[0]->mb_cabangbank;
							//dd($cabangtujuanbm);
							$kodebanktujuan = $datacabangtujuan[0]->mb_id;

							$akunbankasal = $datafpgb[0]->fpg_kodebank;
							$akundkagb = DB::select("select * from d_akun where id_akun = '$akunbanktujuan'");
							$akundkagb = $akundkagb[0]->akun_dka;

							$akundkasal = DB::select("select * from d_akun where id_akun = '$akunbankasal'");
							$akundkasal = $akundkasal[0]->akun_dka;

							$time = Carbon::now();

							$updatebankmasuk = bank_masuk::where([['bm_notatransaksi', '=', $request->nofpg[$i]],['bm_idfpgb' , '=' , $idfpgb]]);
							$updatebankmasuk->update([
							 	'bm_tglterima' => $time,							 		 	
						 	]);



							$notabm = getnotabm($cabangtujuanbm , $request->tglbbk , $kodebanktujuan);
							
					

						
							$updatebankmasuk = bank_masuk::where([['bm_notatransaksi', '=', $request->nofpg[$i]],['bm_idfpgb' , '=' , $idfpgb]]);
							$updatebankmasuk->update([
							 	'bm_status' => 'DITERIMA', 
							 	'bm_nota' => $notabm,	 	
						 	]);
						
							
						$updatebbkd = bukti_bank_keluar_dt::where([['bbkd_id' ,'=' , $idbbkd ],['bbkd_idbbk' , '=' , $idbbk]]);
						$updatebbkd->update([
							'bbkd_notabm' => $notabm,
						]);


						$akunkasbank = '109911000';
						$datakasbank = DB::select("select * from d_akun where id_akun = '$akunkasbank'");
						$akundkakasbank = $datakasbank[0]->akun_dka;
						if($akundkasal == 'K'){ //ASAL BANK
							$jurnalpb[0]['id_akun'] = $akunbankasal;
							$jurnalpb[0]['subtotal'] = '-' . $total;
							$jurnalpb[0]['dk'] = 'D';
							$jurnalpb[0]['detail'] = $request->keterangan[$i];
						}			
						else {
							$jurnalpb[0]['id_akun'] = $akunbankasal;
							$jurnalpb[0]['subtotal'] = '-' . $total;
							$jurnalpb[0]['dk'] = 'K';
							$jurnalpb[0]['detail'] = $request->keterangan[$i];
						}

						if($akundkakasbank == 'D'){
							$jurnalpb[1]['id_akun'] = $akunkasbank;
							$jurnalpb[1]['subtotal'] =  $total;
							$jurnalpb[1]['dk'] = 'D';
							$jurnalpb[1]['detail'] = $request->keterangan[$i];
						}
						else {
							$jurnalpb[1]['id_akun'] = $akunkasbank;
							$jurnalpb[1]['subtotal'] = $total;
							$jurnalpb[1]['dk'] = 'K';
							$jurnalpb[1]['detail'] = $request->keterangan[$i];
						}


						//TUJUAN BANK
						if($akundkagb == 'D'){
							$jurnalpbkeluar[0]['id_akun'] = $akunbanktujuan;
							$jurnalpbkeluar[0]['subtotal'] = $nominal;
							$jurnalpbkeluar[0]['dk'] = 'D';
							$jurnalpbkeluar[0]['detail'] = $request->keterangan[$i];	
						}
						else {
							$jurnalpbkeluar[0]['id_akun'] = $akunbanktujuan;
							$jurnalpbkeluar[0]['subtotal'] = $nominal;
							$jurnalpbkeluar[0]['dk'] = 'K';
							$jurnalpbkeluar[0]['detail'] = $request->keterangan[$i];
						}

						if($akundkakasbank == 'K'){
							$jurnalpbkeluar[1]['id_akun'] = $akunkasbank;
							$jurnalpbkeluar[1]['subtotal'] = '-' . $nominal;
							$jurnalpbkeluar[1]['dk'] = 'D';
							$jurnalpbkeluar[1]['detail'] = $request->keterangan[$i];
						}
						else {
							$jurnalpbkeluar[1]['id_akun'] = $akunkasbank;
							$jurnalpbkeluar[1]['subtotal'] = '-' . $nominalfpgb;
							$jurnalpbkeluar[1]['dk'] = 'K';
							$jurnalpbkeluar[1]['detail'] = $request->keterangan[$i];
						}

						if(count($jurnalpbkeluar) != 0){

						       	$lastidjurnald = DB::table('d_jurnal')->max('jr_id'); 
								if(isset($lastidjurnald)) {
									$idjurnald = $lastidjurnald;
									$idjurnald = (int)$idjurnald + 1;
								}
								else {
									$idjurnald = 1;
								}


								$jr_no = get_id_jurnal('BM' . $kodebank , $cabangtujuanbm, $request->tglbbk);

								$jurnal = new d_jurnal();
								$jurnal->jr_id = $idjurnald;
						        $jurnal->jr_year = Carbon::parse($request->tglbbk)->format('Y');
						        $jurnal->jr_date = $request->tglbbk;
						        $jurnal->jr_detail = 'BUKTI BANK MASUK';
						        $jurnal->jr_ref = $notabm;
						        $jurnal->jr_note = $request->keteranganheader;
						        $jurnal->jr_no = $jr_no;
						        $jurnal->save();

						    $key = 1;
							for($j = 0; $j < count($jurnalpbkeluar); $j++){
	    			   			$lastidjurnaldt = DB::table('d_jurnal')->max('jr_id'); 
								if(isset($lastidjurnaldt)) {
									$idjurnaldt = $lastidjurnaldt;
									$idjurnaldt = (int)$idjurnaldt + 1;
								}
								else {
									$idjurnaldt = 1;
								}

				    			$jurnaldt = new d_jurnal_dt();
				    			$jurnaldt->jrdt_jurnal = $idjurnald;
				    			$jurnaldt->jrdt_detailid = $key;
				    			$jurnaldt->jrdt_acc = $jurnalpbkeluar[$j]['id_akun'];
				    			$jurnaldt->jrdt_value = $jurnalpbkeluar[$j]['subtotal'];
				    			$jurnaldt->jrdt_statusdk = $jurnalpbkeluar[$j]['dk'];
				    			$jurnaldt->jrdt_detail = $jurnalpbkeluar[$j]['detail'];
				    			$jurnaldt->save();
				    			$key++;
							}

							//cekjurnal

							$cekjurnal = check_jurnal($notabm);
				    		if($cekjurnal == 0){
				    			$dataInfo =  $dataInfo=['status'=>'gagal','info'=>'Data Jurnal Tidak Balance :('];
								/*DB::rollback();*/
													        
				    		}
				    		elseif($cekjurnal == 1) {
				    			$dataInfo =  $dataInfo=['status'=>'sukses','info'=>'Data Jurnal Balance :)'];
									        
				    		}
						}

					}
					else if($kelompokakun == 'BEDA BANK') {
							$akunbanktujuan = $datafpgb[0]->fpgb_kodebanktujuan;
							$nominalfpgb = $datafpgb[0]->fpgb_nominal;
							$datacabangtujuan = DB::select("select * from masterbank where mb_kode = '$akunbanktujuan'");
							//dd($cabangtujuanbm);
							$cabangtujuanbm = $datacabangtujuan[0]->mb_cabangbank;
							//dd($cabangtujuanbm);
							$kodebanktujuan = $datacabangtujuan[0]->mb_id;

							$akunbankasal = $datafpgb[0]->fpg_kodebank;
							$akundkagb = DB::select("select * from d_akun where id_akun = '$akunbanktujuan'");
							$akundkagb = $akundkagb[0]->akun_dka;

							$akunkasbank = '109911000';
							$datakasbank = DB::select("select * from d_akun where id_akun = '$akunkasbank'");
							$akundkakasbank = $datakasbank[0]->akun_dka;
							$nominalfpgb = $datafpgb[0]->fpgb_nominal;

							

							if($akundkagb == 'D'){
								$databedabank = array (
									'id_akun' => $akunkasbank,
									'subtotal' => $nominalfpgb,
									'dk' => 'D',
									'detail' => $request->keterangan[$i],
								);
							}
							else{
								$databedabank = array (
									'id_akun' => $akunkasbank,
									'subtotal' => $nominalfpgb,
									'dk' => 'K',
									'detail' => $request->keterangan[$i],
								);
							}

							array_push($datajurnal , $databedabank);

							$notabm = getnotabm($cabangtujuanbm, $request->tglbbk, $kodebank);

							$updatebankmasuk = bank_masuk::where([['bm_notatransaksi', '=', $request->nofpg[$i]],['bm_idfpgb' , '=' , $idfpgb]]);
							$updatebankmasuk->update([
							 	'bm_status' => 'DITRANSFER', 						 	
						 	]);		

						}
					else if($kelompokakun == 'KAS'){

						$akunbanktujuan = $datafpgb[0]->fpgb_kodebanktujuan;
					
						$nominalfpgb = $datafpgb[0]->fpgb_nominal;
						$datacabangtujuan = DB::select("select * from d_akun where id_akun = '$akunbanktujuan'");
						//dd($cabangtujuanbm);
						$cabangtujuankm = $datacabangtujuan[0]->kode_cabang;
						//dd($cabangtujuanbm);
					
						$akunbankasal = $datafpgb[0]->fpg_kodebank;
						$akundkagb = DB::select("select * from d_akun where id_akun = '$akunbanktujuan'");
						$akundkagb = $akundkagb[0]->akun_dka;

						$akundkasal = DB::select("select * from d_akun where id_akun = '$akunbankasal'");
						$akundkasal = $akundkasal[0]->akun_dka;

						$akunkasbank = '109911000';
						$datakasbank = DB::select("select * from d_akun where id_akun = '$akunkasbank'");
						$akundkakasbank = $datakasbank[0]->akun_dka;

						$now = Carbon::now();
						DB::table('kas_masuk')
						->where('km_idtransaksi' , $idfpg)
						->update([
							'km_tgl' => $request->tglbbk,
							'created_at' => $now,
							'updated_at' => $now
						]);


						if($akundkasal == 'K'){ //ASAL BANK BK
							$jurnalkas[0]['id_akun'] = $akunbankasal;
							$jurnalkas[0]['subtotal'] =  '-' . $total;
							$jurnalkas[0]['dk'] = 'D';
							$jurnalkas[0]['detail'] = $request->keterangan[$i];
						}			
						else {
							$jurnalkas[0]['id_akun'] = $akunbankasal;
							$jurnalkas[0]['subtotal'] = '-' . $total;
							$jurnalkas[0]['dk'] = 'K';
							$jurnalkas[0]['detail'] = $request->keterangan[$i];
						}

						if($akundkakasbank == 'D'){
							$jurnalkas[1]['id_akun'] = $akunkasbank;
							$jurnalkas[1]['subtotal'] =  $total;
							$jurnalkas[1]['dk'] = 'D';
							$jurnalkas[1]['detail'] = $request->keterangan[$i];
						}
						else {
							$jurnalkas[1]['id_akun'] = $akunkasbank;
							$jurnalkas[1]['subtotal'] =  $total;
							$jurnalkas[1]['dk'] = 'K';
							$jurnalkas[1]['detail'] = $request->keterangan[$i];
						} 
						// END BK

						//TUJUAN BANK

						if($akundkagb == 'D'){
							$dataakunkas = array (
								'id_akun' => $akunbanktujuan,
								'subtotal' => $nominal,
								'dk' => 'D',
								'detail' => $request->keterangan[$i],
							);
						}
						else {
							$dataakunkas = array (
								'id_akun' => $akunbanktujuan,
								'subtotal' => $nominal,
								'dk' => 'K',
								'detail' => $request->keterangan[$i],
							);
						}
						array_push($jurnalkaskeluar, $dataakunkas);

						if($akundkakasbank == 'K'){
							$dataakunkas = array (
								'id_akun' => $akunkasbank,
								'subtotal' => '-' . $nominalfpgb,
								'dk' => 'D',
								'detail' => $request->keterangan[$i],
							);
						}
						else{
							$dataakunkas = array (
								'id_akun' => $akunkasbank,
								'subtotal' => '-' . $nominal,
								'dk' => 'K',
								'detail' => $request->keterangan[$i],
							);
						}
						array_push($jurnalkaskeluar, $dataakunkas);


						if(count($jurnalkaskeluar) != 0){

						       	$lastidjurnald = DB::table('d_jurnal')->max('jr_id'); 
								if(isset($lastidjurnald)) {
									$idjurnald = $lastidjurnald;
									$idjurnald = (int)$idjurnald + 1;
								}
								else {
									$idjurnald = 1;
								}

								$notakm = getnotakm($cabangtujuankm , $request->tglbbk);


								$updatebbkd = bukti_bank_keluar_dt::where([['bbkd_id' ,'=' , $idbbkd ],['bbkd_idbbk' , '=' , $idbbk]]);
								$updatebbkd->update([
									'bbkd_notabm' => $notakm,
								]);

								$notakmm = getnotakm($cabangtujuankm , $request->tglbbk);
								$updatekm = 
								DB::table('kas_masuk')
								->where('km_idtransaksi' , $idfpg)
								->update([
									'km_nota' => $notakm,
									'km_status' => 'DITRANSFER',
								]);

								$jr_no = get_id_jurnal('KM', $cabangtujuankm, $request->tglbbk);

								$jurnal = new d_jurnal();
								$jurnal->jr_id = $idjurnald;
						        $jurnal->jr_year = Carbon::parse($request->tglbbk)->format('Y');
						        $jurnal->jr_date = $request->tglbbk;
						        $jurnal->jr_detail = 'KAS MASUK';
						        $jurnal->jr_ref = $notakm;
						        $jurnal->jr_note = $request->keteranganheader;
						        $jurnal->jr_no = $jr_no;
						        $jurnal->save();

						    $key = 1;
							for($j = 0; $j < count($jurnalkaskeluar); $j++){
	    			   			$lastidjurnaldt = DB::table('d_jurnal')->max('jr_id'); 
								if(isset($lastidjurnaldt)) {
									$idjurnaldt = $lastidjurnaldt;
									$idjurnaldt = (int)$idjurnaldt + 1;
								}
								else {
									$idjurnaldt = 1;
								}

				    			$jurnaldt = new d_jurnal_dt();
				    			$jurnaldt->jrdt_jurnal = $idjurnald;
				    			$jurnaldt->jrdt_detailid = $key;
				    			$jurnaldt->jrdt_acc = $jurnalkaskeluar[$j]['id_akun'];
				    			$jurnaldt->jrdt_value = $jurnalkaskeluar[$j]['subtotal'];
				    			$jurnaldt->jrdt_statusdk = $jurnalkaskeluar[$j]['dk'];
				    			$jurnaldt->jrdt_detail = $jurnalkaskeluar[$j]['detail'];
				    			$jurnaldt->save();
				    			$key++;
							}

							//cekjurnal
							$cekjurnal = check_jurnal($notakm);
				    		if($cekjurnal == 0){
				    			$dataInfo =  $dataInfo=['status'=>'gagal','info'=>'Data Jurnal Tidak Balance :('];
								/*DB::rollback();*/
													        
				    		}
				    		elseif($cekjurnal == 1) {
				    			$dataInfo = $dataInfo=['status'=>'sukses','info'=>'Data Jurnal Balance :)'];
									        
				    		}
						}


					} // END KAS	
				}
				else if($jenisbayarfpg == '13'){ // PENCARIAN BONSEM
					$datafpgdt = DB::select("select * from fpg, fpg_dt where idfpg = '$idfpg' and fpgdt_idfpg = idfpg");
					for($j = 0 ; $j < count($datafpgdt); $j++){
						$notabonsem = $datafpgdt[$j]->fpgdt_nofaktur;
						$date =  date('Y-m-d');
						$updatebonsem = bonsempengajuan::where('bp_nota' , '=' , $notabonsem);
						$updatebonsem->update([
							'bp_timepencairan' => $date,
							'bp_statusend' =>'CAIR',
						]);
					}

					$akunhutangdagang2 = $request->hutangdagang[$i];
					$datajurnal2 = DB::select("select * from d_akun where id_akun = '$akunhutangdagang2'");
					$akundka = $datajurnal2[0]->akun_dka;

						if($akundka == 'D'){
							$datajurnal[$i]['id_akun'] = $akunhutangdagang2;
							$datajurnal[$i]['subtotal'] =  $nominal;
							$datajurnal[$i]['dk'] = 'D';
							$datajurnal[$i]['detail'] = $request->keterangan[$i];
						}			
						else {
							$datajurnal[$i]['id_akun'] = $akunhutangdagang2;
							$datajurnal[$i]['subtotal'] = $nominal;
							$datajurnal[$i]['dk'] = 'K';
							$datajurnal[$i]['detail'] = $request->keterangan[$i];
		
						}
				}				
				else if($jenisbayarfpg == '1') { // GIRO KAS KECIL
				//jurnal GIRO KAS KECIL
					$datafpg = DB::select("select * from fpg where idfpg = '$idfpg'");
					$notafpg = $datafpg[0]->fpg_nofpg;
					$cabangtransaksi = $datafpg[0]->fpg_agen;
					$now = Carbon::now();
					$updatekm =
					
					DB::table('kas_masuk')
					->where('km_idtransaksi' , $idfpg)
					->update([
						'km_tgl' => $request->tglbbk,
						'created_at' => $now,
						'updated_at' => $now
					]);

					
					
					$notakm = getnotakm($cabangtransaksi , $request->tglbbk);
					$updatekm = 
					DB::table('kas_masuk')
					->where('km_idtransaksi' , $idfpg)
					->update([
						'km_nota' => $notakm,
						'km_status' => 'DITRANSFER',
					]);
					
					$updatebbkd = bukti_bank_keluar_dt::where([['bbkd_id' ,'=' , $idbbkd ],['bbkd_idbbk' , '=' , $idbbk]]);
						$updatebbkd->update([
							'bbkd_notabm' => $notakm,
						]);


					$nominal = str_replace(',', '', $request->nominal[$i]);

						

					$akunbank = $request->akunkodebank;
					$dataakunkodebank = DB::select("select * from d_akun where id_akun = '$akunbank'");
					$dkabankkeluar = $dataakunkodebank[0]->akun_dka;
					
					//jurnalBK GIRO KAS KECIL
					if($dkabankkeluar == 'D'){
						$datajurnalbk[0]['id_akun'] = $request->akunkodebank;
						$datajurnalbk[0]['subtotal'] = '-' . $nominal;
						$datajurnalbk[0]['dk'] = 'K';
						$datajurnalbk[0]['detail'] = $request->keterangan[$i];
					}
					else {
						$datajurnalbk[0]['id_akun'] = $request->akunkodebank;
						$datajurnalbk[0]['subtotal'] = $nominal;
						$datajurnalbk[0]['dk'] = 'D';
						$datajurnalbk[0]['detail'] = $request->keterangan[$i];	
					}

					$akunkasbank = '109911000';
					$dataakunkasbank = DB::select("select * from d_akun where id_akun = '$akunkasbank'");
					$dkakasbank = $dataakunkasbank[0]->akun_dka;

					if($dkakasbank == 'D') {
						$datajurnalbk[1]['id_akun'] = $akunkasbank;
						$datajurnalbk[1]['subtotal'] = $nominal;
						$datajurnalbk[1]['dk'] = 'D';
						$datajurnalbk[1]['detail'] = $request->keterangan[$i];
					}
					else {
						$datajurnalbk[1]['id_akun'] = $akunkasbank;
						$datajurnalbk[1]['subtotal'] = $nominal;
						$datajurnalbk[1]['dk'] = 'K';
						$datajurnalbk[1]['detail'] = $request->keterangan[$i];
					}

					//JURNAL KAS MASUK
					$akunkas = $request->hutangdagang[$i];
					$dataakunkas = DB::select("select * from d_akun where id_akun = '$akunkas'");
					$dkakas = $dataakunkas[0]->akun_dka;
					if($dkakas == 'D'){
						$datajurnalkm[0]['id_akun'] = $akunkas;
						$datajurnalkm[0]['subtotal'] = $nominal;
						$datajurnalkm[0]['dk'] = 'D';
						$datajurnalkm[0]['detail'] = $request->keterangan[$i];
					}
					else {
						$datajurnalkm[0]['id_akun'] = $akunkas;
						$datajurnalkm[0]['subtotal'] = $nominal;
						$datajurnalkm[0]['dk'] = 'K';
						$datajurnalkm[0]['detail'] = $request->keterangan[$i];
		
					}

					if($dkakasbank == 'D') {
						$datajurnalkm[1]['id_akun'] = $akunkasbank;
						$datajurnalkm[1]['subtotal'] = '-' . $nominal;
						$datajurnalkm[1]['dk'] = 'K';
						$datajurnalkm[1]['detail'] = $request->keterangan[$i];
					}
					else {
						$datajurnalkm[1]['id_akun'] = $akunkasbank;
						$datajurnalkm[1]['subtotal'] = $nominal;
						$datajurnalkm[1]['dk'] = 'D';
						$datajurnalkm[1]['detail'] = $request->keterangan[$i];
					}

				}
				else {			
				$akunhutangdagang2 = $request->hutangdagang[$i];
				$datajurnal2 = DB::select("select * from d_akun where id_akun = '$akunhutangdagang2'");
				$akundka = $datajurnal2[0]->akun_dka;

					if($akundka == 'D'){
						$datajurnal[$i]['id_akun'] = $akunhutangdagang2;
						$datajurnal[$i]['subtotal'] =  '-' . $nominal;
						$datajurnal[$i]['dk'] = 'K';
						$datajurnal[$i]['detail'] = $request->keterangan[$i];
					}			
					else {
						$datajurnal[$i]['id_akun'] = $akunhutangdagang2;
						$datajurnal[$i]['subtotal'] = '-' . $nominal;
						$datajurnal[$i]['dk'] = 'D';
						$datajurnal[$i]['detail'] = $request->keterangan[$i];
	
					}
				}
			}
		}
		else if($request->flag == 'BIAYA') {
				$jenisbayarfpg = 'BIAYA';
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


				$akunbiaya = $request->akun[$j];
				$datajurnal2 = DB::select("select * from d_akun where id_akun = '$akunbiaya'");
				$akundka2 = $datajurnal2[0]->akun_dka;

				if($request->dk[$j] == 'K'){
					if($akundka2 == 'D'){
						$datajurnalbiaya[$j]['id_akun'] = $request->akun[$j];
						$datajurnalbiaya[$j]['subtotal'] = '-' . $jumlah;
						$datajurnalbiaya[$j]['dk'] = 'K';
						$datajurnalbiaya[$j]['detail'] = $request->keterangan[$j];
					}
					else {
						$datajurnalbiaya[$j]['id_akun'] = $request->akun[$j];
						$datajurnalbiaya[$j]['subtotal'] = $jumlah;
						$datajurnalbiaya[$j]['dk'] = 'K';
						$datajurnalbiaya[$j]['detail'] = $request->keterangan[$j];	
					}
					$totaltabbiaya = (float)$totaltabbiaya - (float)$jumlah;
				}
				else {
					if($akundka2 == 'K'){
						$datajurnalbiaya[$j]['id_akun'] = $request->akun[$j];
						$datajurnalbiaya[$j]['subtotal'] = '-' . $jumlah;
						$datajurnalbiaya[$j]['dk'] = 'D';
						$datajurnalbiaya[$j]['detail'] = $request->keterangan[$j];	
					}
					else {
						$datajurnalbiaya[$j]['id_akun'] = $request->akun[$j];
						$datajurnalbiaya[$j]['subtotal'] = $jumlah;
						$datajurnalbiaya[$j]['dk'] = 'D';
						$datajurnalbiaya[$j]['detail'] = $request->keterangan[$j];
					}
					
					$totaltabbiaya = (float)$totaltabbiaya + (float)$jumlah;
				}
			}
		}
		else if($request->flag == 'BGAKUN'){
			for($j=0;$j<count($request->accbiayaakun);$j++){
				$idfpg = $request->idfpg[$j];
				$datafpg = DB::select("select * from fpg where idfpg = '$idfpg'");
				$jenisbayarfpg2 = $datafpg[0]->fpg_jenisbayar;
				$jenisbayarfpg = 'BGAKUN';


					$bbkb = new bukti_bank_keluar_bgakun();

				$lastidbbkab =  bukti_bank_keluar_bgakun::max('bbkab_id');
				if(isset($lastidbbkb)) {
						$idbbkab = 1;
				}
				else {
						$idbbkab = $lastidbbkab;
						$idbbkab = (int)$idbbkab + 1;
				} 

				$jumlah = str_replace(',', '', $request->nominalakun[$j]);
				$jumlahfpg = str_replace(',', '', $request->nominalfpg[$j]);

				$bbkb->bbkab_id = $idbbkab;
				$bbkb->bbkab_idbbk = $idbbk;
				$bbkb->bbkab_akun = $request->accbiayaakun[$j];
				$bbkb->bbkab_dk = $request->dk[$j];
				$bbkb->bbkab_nominal = $jumlah;
				$bbkb->bbkab_keterangan = $request->keteranganakunbg[$j];
				$bbkb->bbkab_nocheck = $request->nocheck[$j];
				$bbkb->bbkab_nofpg = $request->nofpg[$j];
				$bbkb->bbkab_idfpg = $request->idfpg[$j];
				$bbkb->bbkab_nominalfpg = $jumlahfpg;
				$bbkb->bbkab_keteranganfpg = $request->keteranganfpg[$j];
				$bbkb->bbkab_jenisbayarfpg = $jenisbayarfpg2;
				$bbkb->save();


				$akunbiaya = $request->accbiayaakun[$j];
				$datajurnal2 = DB::select("select * from d_akun where id_akun = '$akunbiaya'");
				$akundka2 = $datajurnal2[0]->akun_dka;

				$idfpg = $request->idfpg[$j];
				$datafpg = DB::select("select * from fpg_cekbank where fpgb_idfpg = '$idfpg'");
				$jenisbayar = $datafpg[0]->fpgb_jenisbayarbank;


				if($jenisbayar != 'INTERNET BANKING'){
						$data['idfpg'] = DB::table('fpg_cekbank')
						->where([['fpgb_idfpg', '=', $idfpg], ['fpgb_nocheckbg' , '=' , $request->nocheck[$j]]])
						->update([
							'fpgb_posting' => 'DONE',
						]);


					$dataallfpg = DB::select("select * from fpg, fpg_cekbank where idfpg = '$idfpg' and fpgb_idfpg = idfpg");
					for($x = 0; $x < count($dataallfpg); $x++){
						$done = $dataallfpg[$x]->fpgb_posting;
						if($done == 'DONE'){
							$tempdone = $tempdone + 1;
						}
					} 

					if($tempdone == count($dataallfpg)){
						$data['idfpg'] = DB::table('fpg')
						->where('idfpg' , $idfpg)
						->update([
							'fpg_posting' => 'DONE',
						]);
					}
				}
				else{
					$data['idfpg'] = DB::table('fpg_cekbank')
						->where('fpgb_idfpg', '=', $idfpg)
						->update([
							'fpgb_posting' => 'DONE',
						]);


					$dataallfpg = DB::select("select * from fpg, fpg_cekbank where idfpg = '$idfpg' and fpgb_idfpg = idfpg");
					for($x = 0; $x < count($dataallfpg); $x++){
						$done = $dataallfpg[$x]->fpgb_posting;
						if($done == 'DONE'){
							$tempdone = $tempdone + 1;
						}
					} 

					if($tempdone == count($dataallfpg)){
						$data['idfpg'] = DB::table('fpg')
						->where('idfpg' , $idfpg)
						->update([
							'fpg_posting' => 'DONE',
						]);
					}
				}


				if($request->dk[$j] == 'K'){
					if($akundka2 == 'K'){
						$datajurnalbg[$j]['id_akun'] = $request->accbiayaakun[$j];
						$datajurnalbg[$j]['subtotal'] = $jumlah;
						$datajurnalbg[$j]['dk'] = 'K';
						$datajurnalbg[$j]['detail'] = $request->keteranganakunbg[$j];

					}
					else {
						$datajurnalbg[$j]['id_akun'] = $request->accbiayaakun[$j];
						$datajurnalbg[$j]['subtotal'] = '-' . $jumlah;
						$datajurnalbg[$j]['dk'] = 'K';	
						$datajurnalbg[$j]['detail'] = $request->keteranganakunbg[$j];

					}

					$totalbgakun = (float)$totalbgakun - (float)$jumlah; 
				}
				else {
					if($akundka2 == 'K'){
						$datajurnalbg[$j]['id_akun'] = $request->accbiayaakun[$j];
						$datajurnalbg[$j]['subtotal'] = '-' . $jumlah;
						$datajurnalbg[$j]['dk'] = 'D';
						$datajurnalbg[$j]['detail'] = $request->keteranganakunbg[$j];

					}
					else {
						$datajurnalbg[$j]['id_akun'] = $request->accbiayaakun[$j];
						$datajurnalbg[$j]['subtotal'] = $jumlah;
						$datajurnalbg[$j]['dk'] = 'D';	
						$datajurnalbg[$j]['detail'] = $request->keteranganakunbg[$j];

					}

					$totalbgakun = (float)$totalbgakun + (float)$jumlah;
				}

			}
		}



		if($jenisbayarfpg == '1'){
			$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 
				if(isset($lastidjurnal)) {
					$idjurnal = $lastidjurnal;
					$idjurnal = (int)$idjurnal + 1;
				}
				else {
					$idjurnal = 1;
				}


				$tglbbk = $request->tglbbk;
				$jr_no = get_id_jurnal('BK' , $cabang, $tglbbk);
				$ref = explode("-", $jr_no);

				$kode = $ref[0] . $kodebank;
				$jr_no = $kode . '-' . $ref[1];


				$year =  Carbon::parse($tglbbk)->format('Y');	
				$date = $request->$tglbbk;
				$jurnal = new d_jurnal();
				$jurnal->jr_id = $idjurnal;
		        $jurnal->jr_year = Carbon::parse($date)->format('Y');
		        $jurnal->jr_date = $tglbbk;
		        $jurnal->jr_detail = 'BUKTI BANK KELUAR';
		        $jurnal->jr_ref = $request->nobbk;
		        $jurnal->jr_note = $request->keteranganheader;
		        $jurnal->jr_no = $jr_no;
		        $jurnal->save();
		
	  		
	 				
	    		$key  = 1;
	    		for($j = 0; $j < count($datajurnalbk); $j++){
	    			
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
	    			$jurnaldt->jrdt_acc = $datajurnalbk[$j]['id_akun'];
	    			$jurnaldt->jrdt_value = $datajurnalbk[$j]['subtotal'];
	    			$jurnaldt->jrdt_statusdk = $datajurnalbk[$j]['dk'];
	    			$jurnaldt->jrdt_detail = $datajurnalbk[$j]['detail'];
	    			$jurnaldt->save();
	    			$key++;
				}

				//save jurnal KM
				$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 
				if(isset($lastidjurnal)) {
					$idjurnal = $lastidjurnal;
					$idjurnal = (int)$idjurnal + 1;
				}
				else {
					$idjurnal = 1;
				}

				$tglbbk = $request->tglbbk;
				$jr_no = get_id_jurnal('KM' , $cabang, $tglbbk);

				$year =  Carbon::parse($tglbbk)->format('Y');	
				$date = $request->$tglbbk;
				$jurnal = new d_jurnal();
				$jurnal->jr_id = $idjurnal;
		        $jurnal->jr_year = Carbon::parse($date)->format('Y');
		        $jurnal->jr_date = $tglbbk;
		        $jurnal->jr_detail = 'KAS MASUK';
		        $jurnal->jr_ref = $notakm;
		        $jurnal->jr_note = $request->keteranganheader;
		        $jurnal->jr_no = $jr_no;
		        $jurnal->save();
		
	  			
	 			
	    		$key  = 1;
	    		for($j = 0; $j < count($datajurnalkm); $j++){
	    			
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
	    			$jurnaldt->jrdt_acc = $datajurnalkm[$j]['id_akun'];
	    			$jurnaldt->jrdt_value = $datajurnalkm[$j]['subtotal'];
	    			$jurnaldt->jrdt_statusdk = $datajurnalkm[$j]['dk'];
	    			$jurnaldt->jrdt_detail = $datajurnalkm[$j]['detail'];
	    			$jurnaldt->save();
	    			$key++;
				}

				$cekjurnal = check_jurnal($notakm);
	    		if($cekjurnal == 0){
	    			$dataInfo =  $dataInfo=['status'=>'gagal','info'=>'Data Jurnal KM Tidak Balance :('];
					/*DB::rollback();*/
										        
	    		}
	    		elseif($cekjurnal == 1) {
	    			$dataInfo =  $dataInfo=['status'=>'sukses','info'=>'Data Jurnal Balance :)','message'=>$idbbk];
						        
	    		}
			}
			else if($jenisbayarfpg == '12' || $jenisbayarfpg == '11' ){ // pindah buku
				//dd($datajurnal);
				$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 
				if(isset($lastidjurnal)) {
					$idjurnal = $lastidjurnal;
					$idjurnal = (int)$idjurnal + 1;
				}
				else {
					$idjurnal = 1;
				}

				$tglbbk = $request->tglbbk;
				$jr_no = get_id_jurnal('BK' , $cabang, $tglbbk);
				$ref = explode("-", $jr_no);

				$kode = $ref[0] . $kodebank;
				$jr_no = $kode . '-' . $ref[1];



				$year =  Carbon::parse($tglbbk)->format('Y');	
				$date = $request->$tglbbk;
				$jurnal = new d_jurnal();
				$jurnal->jr_id = $idjurnal;
		        $jurnal->jr_year = Carbon::parse($date)->format('Y');
		        $jurnal->jr_date = $tglbbk;
		        $jurnal->jr_detail = 'BUKTI BANK KELUAR';
		        $jurnal->jr_ref = $request->nobbk;
		        $jurnal->jr_note = $request->keteranganheader;
		        $jurnal->jr_no = $jr_no;
		        $jurnal->save();



				//PB BANK KELUAR
				$key = 1;
				for($j = 0; $j < count($jurnalpb); $j++){
		
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
	    			$jurnaldt->jrdt_acc = $jurnalpb[$j]['id_akun'];
	    			$jurnaldt->jrdt_value = $jurnalpb[$j]['subtotal'];
	    			$jurnaldt->jrdt_statusdk = $jurnalpb[$j]['dk'];
	    			$jurnaldt->jrdt_detail = $jurnalpb[$j]['detail'];
	    			$jurnaldt->save();
	    			$key++;
				}

			//	dd($jurnalpb);
				//KAS BANK KELUAR
				if(count($jurnalpb) == 0 ){
				$key = 1;
				for($j = 0; $j < count($jurnalkas); $j++){
		
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
	    			$jurnaldt->jrdt_acc = $jurnalkas[$j]['id_akun'];
	    			$jurnaldt->jrdt_value = $jurnalkas[$j]['subtotal'];
	    			$jurnaldt->jrdt_statusdk = $jurnalkas[$j]['dk'];
	    			$jurnaldt->jrdt_detail = $jurnalkas[$j]['detail'];
	    			$jurnaldt->save();
	    			$key++;

				}
			}


				if(count($datajurnal) != 0 && count($jurnalkas) == 0 && count($jurnalpb) == 0){
				//	dd($datajurnal);
					$akundkahutang2 = DB::select("select * from d_akun where id_akun = '$akunhutangdagang'");
			        $akundkahutang = $akundkahutang2[0]->akun_dka; 
			       
	        	        if($akundkahutang == 'D'){
	        	           	$dataakun = array (
	        				'id_akun' => $akunhutangdagang,
	        				'subtotal' => '-' . $total,
	        				'dk' => 'K',
	        				'detail' => $request->keteranganheader,
	        				);	
	        	        }
	        	        else {
	        	        	$dataakun = array (
	        				'id_akun' => $akunhutangdagang,
	        				'subtotal' => '-' . $total,
	        				'dk' => 'K',
	        				'detail' => $request->keteranganheader,
	        				);	
	        	        }
	        	        array_push($datajurnal, $dataakun);
					 
					
		    		$key  = 1;
		    		for($j = 0; $j < count($datajurnal); $j++){
		    			
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
		    			$jurnaldt->jrdt_acc = $datajurnal[$j]['id_akun'];
		    			$jurnaldt->jrdt_value = $datajurnal[$j]['subtotal'];
		    			$jurnaldt->jrdt_statusdk = $datajurnal[$j]['dk'];
		    			$jurnaldt->jrdt_detail = $datajurnal[$j]['detail'];
		    			$jurnaldt->save();
		    			$key++;
						
					}
				}

			}
			else if($jenisbayarfpg == 'BIAYA'){
				$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 
				if(isset($lastidjurnal)) {
					$idjurnal = $lastidjurnal;
					$idjurnal = (int)$idjurnal + 1;
				}
				else {
					$idjurnal = 1;
				}

				$tglbbk = $request->tglbbk;
				$jr_no = get_id_jurnal('BK' , $cabang, $tglbbk);
				$ref = explode("-", $jr_no);

				$kode = $ref[0] . $kodebank;
				$jr_no = $kode . '-' . $ref[1];



				$year =  Carbon::parse($tglbbk)->format('Y');	
				$date = $request->$tglbbk;
				$jurnal = new d_jurnal();
				$jurnal->jr_id = $idjurnal;
		        $jurnal->jr_year = Carbon::parse($date)->format('Y');
		        $jurnal->jr_date = $tglbbk;
		        $jurnal->jr_detail = 'BUKTI BANK KELUAR';
		        $jurnal->jr_ref = $request->nobbk;
		        $jurnal->jr_note = $request->keteranganheader;
		        $jurnal->jr_no = $jr_no;
		        $jurnal->save();
	       	
		        $akundkahutang2 = DB::select("select * from d_akun where id_akun = '$akunhutangdagang'");
		        $akundkahutang = $akundkahutang2[0]->akun_dka; 
		       
		        	        if($akundkahutang == 'D'){
		        	           	$dataakun = array (
		        				'id_akun' => $akunhutangdagang,
		        				'subtotal' => '-' . $totaltabbiaya,
		        				'dk' => 'K',
		        				'detail' => $request->keteranganheader,
		        				);	
		        	        }
		        	        else {
		        	        	$dataakun = array (
		        				'id_akun' => $akunhutangdagang,
		        				'subtotal' => '-' . $totaltabbiaya,
		        				'dk' => 'K',
		        				'detail' => $request->keteranganheader,
		        				);	
		        	        }
		        	        array_push($datajurnalbiaya, $dataakun );
		        	  
		     
	    		$key  = 1;
	    		for($j = 0; $j < count($datajurnalbiaya); $j++){
	    			
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
	    			$jurnaldt->jrdt_acc = $datajurnalbiaya[$j]['id_akun'];
	    			$jurnaldt->jrdt_value = $datajurnalbiaya[$j]['subtotal'];
	    			$jurnaldt->jrdt_statusdk = $datajurnalbiaya[$j]['dk'];
	    			$jurnaldt->jrdt_detail = $datajurnalbiaya[$j]['detail'];
	    			$jurnaldt->save();
	    			$key++;

				}	
			}
			else if($jenisbayarfpg == 'BGAKUN'){
				$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 
				if(isset($lastidjurnal)) {
					$idjurnal = $lastidjurnal;
					$idjurnal = (int)$idjurnal + 1;
				}
				else {
					$idjurnal = 1;
				}

				$tglbbk = $request->tglbbk;
				$jr_no = get_id_jurnal('BK' , $cabang, $tglbbk);
				$ref = explode("-", $jr_no);

				$kode = $ref[0] . $kodebank;
				$jr_no = $kode . '-' . $ref[1];



				$year =  Carbon::parse($tglbbk)->format('Y');	
				$date = $request->$tglbbk;
				$jurnal = new d_jurnal();
				$jurnal->jr_id = $idjurnal;
		        $jurnal->jr_year = Carbon::parse($date)->format('Y');
		        $jurnal->jr_date = $tglbbk;
		        $jurnal->jr_detail = 'BUKTI BANK KELUAR';
		        $jurnal->jr_ref = $request->nobbk;
		        $jurnal->jr_note = $request->keteranganheader;
		        $jurnal->jr_no = $jr_no;
		        $jurnal->save();
	       	
		        $akundkahutang2 = DB::select("select * from d_akun where id_akun = '$akunhutangdagang'");
		        $akundkahutang = $akundkahutang2[0]->akun_dka; 
		       
		        	        if($akundkahutang == 'D'){
		        	           	$dataakun = array (
		        				'id_akun' => $akunhutangdagang,
		        				'subtotal' => '-' . $totalbgakun,
		        				'dk' => 'K',
		        				'detail' => $request->keteranganheader,
		        				);	
		        	        }
		        	        else {
		        	        	$dataakun = array (
		        				'id_akun' => $akunhutangdagang,
		        				'subtotal' => '-' . $totalbgakun,
		        				'dk' => 'K',
		        				'detail' => $request->keteranganheader,
		        				);	
		        	        }
		        	        array_push($datajurnalbg, $dataakun );
		        	  
		     
	    		$key  = 1;
	    		for($j = 0; $j < count($datajurnalbg); $j++){
	    			
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
	    			$jurnaldt->jrdt_acc = $datajurnalbg[$j]['id_akun'];
	    			$jurnaldt->jrdt_value = $datajurnalbg[$j]['subtotal'];
	    			$jurnaldt->jrdt_statusdk = $datajurnalbg[$j]['dk'];
	    			$jurnaldt->jrdt_detail = $datajurnalbg[$j]['detail'];
	    			$jurnaldt->save();
	    			$key++;

				}
			}
			else{
				//save jurnal
				$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 
				if(isset($lastidjurnal)) {
					$idjurnal = $lastidjurnal;
					$idjurnal = (int)$idjurnal + 1;
				}
				else {
					$idjurnal = 1;
				}

				$tglbbk = $request->tglbbk;
				$jr_no = get_id_jurnal('BK' , $cabang, $tglbbk);
				$ref = explode("-", $jr_no);

				$kode = $ref[0] . $kodebank;
				$jr_no = $kode . '-' . $ref[1];



				$year =  Carbon::parse($tglbbk)->format('Y');	
				$date = $request->$tglbbk;
				$jurnal = new d_jurnal();
				$jurnal->jr_id = $idjurnal;
		        $jurnal->jr_year = Carbon::parse($date)->format('Y');
		        $jurnal->jr_date = $tglbbk;
		        $jurnal->jr_detail = 'BUKTI BANK KELUAR';
		        $jurnal->jr_ref = $request->nobbk;
		        $jurnal->jr_note = $request->keteranganheader;
		        $jurnal->jr_no = $jr_no;
		        $jurnal->save();
	       	
		        $akundkahutang2 = DB::select("select * from d_akun where id_akun = '$akunhutangdagang'");
		        $akundkahutang = $akundkahutang2[0]->akun_dka; 
		       
		        	        if($akundkahutang == 'D'){
		        	           	$dataakun = array (
		        				'id_akun' => $akunhutangdagang,
		        				'subtotal' => '-' . $total,
		        				'dk' => 'K',
		        				'detail' => $request->keteranganheader,
		        				);	
		        	        }
		        	        else {
		        	        	$dataakun = array (
		        				'id_akun' => $akunhutangdagang,
		        				'subtotal' => '-' . $total,
		        				'dk' => 'K',
		        				'detail' => $request->keteranganheader,
		        				);	
		        	        }
		        	        array_push($datajurnal, $dataakun );
		        	  
		     
	    		$key  = 1;
	    		for($j = 0; $j < count($datajurnal); $j++){
	    			
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
	    			$jurnaldt->jrdt_acc = $datajurnal[$j]['id_akun'];
	    			$jurnaldt->jrdt_value = $datajurnal[$j]['subtotal'];
	    			$jurnaldt->jrdt_statusdk = $datajurnal[$j]['dk'];
	    			$jurnaldt->jrdt_detail = $datajurnal[$j]['detail'];
	    			$jurnaldt->save();
	    			$key++;

				}
			}

			
			$cekjurnal = check_jurnal($request->nobbk);
    		if($cekjurnal == 0){
    			$dataInfo =  $dataInfo=['status'=>'gagal','info'=>'Data Jurnal BK Tidak Balance :('];
				DB::rollback();
									        
    		}
    		elseif($cekjurnal == 1) {
    			$dataInfo =  $dataInfo=['status'=>'sukses','info'=>'Data Jurnal Balance :)','message'=>$idbbk];
					        
    		}

    		//	$dataInfo =  $dataInfo=['status'=>'sukses','info'=>'Data Jurnal Balance :)','message'=>$idbbk];
   			
			return json_encode($dataInfo);
		});		
	}

	

	public function updatebbk(Request $request){
		return DB::transaction(function() use ($request) { 
		$idbbk = $request->bbkid;
	//	dd($request);
	/*	$this->hapusbbk($idbbk);
		$this->simpanbbk($request);
		return json_encode('sukses');	
		});*/
		$tempdone = 0;
		$cekbg = str_replace(',', '', $request->totalcekbg);
		$biaya = str_replace(',', '', $request->totalbiaya);
		$total = str_replace(',', '', $request->total);
		$totaljurnal = str_replace('.' , '' , $total);
		//$substrjurnal = substr($totaljurnal, 0,-2);


		//return $totaljurnal;
		$data['header4'] = DB::table('bukti_bank_keluar')
						->where('bbk_id' , $idbbk)
						->update([
							'bbk_cekbg' => $cekbg,
							'bbk_biaya' => $biaya,
							'bbk_total' => $total,
							'bbk_tgl' => $request->tglbbk,
							'bbk_keterangan' => $request->keteranganheader,
							'update_by' => $request->username
						]);
		$data['bbk'] = DB::select("select * from bukti_bank_keluar where bbk_id = '$idbbk'");
		$cabang = $data['bbk'][0]->bbk_cabang;
		$kodebank = $data['bbk'][0]->bbk_kodebank;

		if((int)$kodebank < 10){
			$kodebank = 0 . $kodebank;
		}
		else {
			$kodebank;
		}

		$datajurnal = [];
		$totalhutang = 0;

		$refjurnal = $data['bbk'][0]->bbk_nota;
		$akunkodebank = $data['bbk'][0]->bbk_akunbank;

		
		if($request->flag == 'CEKBG'){
				$dataallbbk['bbkasli'] = DB::select("select * from bukti_bank_keluar, bukti_bank_keluar_detail where bbk_id = '$idbbk' and bbkd_idbbk = bbk_id");
		$flag = $data['bbk'][0]->bbk_flag;
		
		

		for($j=0;$j< count($dataallbbk['bbkasli']); $j++){ // NOT DI FPG
			$datacheckbg = $dataallbbk['bbkasli'][$j]->bbkd_nocheck;
		
			$dataasli['bbk'] = DB::select("select * from bukti_bank_keluar, bukti_bank_keluar_detail where bbk_id = bbkd_idbbk and bbk_id = '$idbbk'");
			$idfpg = $dataasli['bbk'][$j]->bbkd_idfpg;
			$data['idfpg'] = DB::table('fpg_cekbank')
				->where([['fpgb_idfpg', '=', $idfpg], ['fpgb_nocheckbg' , '=' , $datacheckbg]])
				->update([
					'fpgb_posting' => null,
				]);

			
			
				$data['idfpg'] = DB::table('fpg')
				->where('idfpg' , $idfpg)
				->update([
					'fpg_posting' => null,
				]);
			
		}


		DB::delete("DELETE from  bukti_bank_keluar_detail where bbkd_idbbk = '$idbbk'");
		for($i = 0; $i < count($request->notransaksi); $i++){
				
				$nocheck = $request->notransaksi[$i];
			
					$data['bbkd'] = DB::select("select * from bukti_bank_keluar_detail where bbkd_idbbk = '$idbbk' and bbkd_nocheck = '$nocheck '");
						
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
								$bbkdt->bbkd_idfpg = $request->idfpg[$i];
								$bbkdt->bbkd_akunhutang = $request->akunhutangdagang[$i];
								$bbkdt->save();


								$idfpg = $request->idfpg[$i];
								$data['idfpg'] = DB::table('fpg_cekbank')
									->where([['fpgb_idfpg', '=', $idfpg], ['fpgb_nocheckbg' , '=' , $request->notransaksi[$i]]])
									->update([
										'fpgb_posting' => 'DONE',
									]);

								$dataallfpg = DB::select("select * from fpg, fpg_cekbank where idfpg = '$idfpg' and fpgb_idfpg = idfpg");
								for($x = 0; $x < count($dataallfpg); $x++){
									$done = $dataallfpg[$x]->fpgb_posting;
									if($done == 'DONE'){
										$tempdone = $tempdone + 1;
									}
								} 

								if($tempdone == count($dataallfpg)){
									$data['idfpg'] = DB::table('fpg')
									->where('idfpg' , $idfpg)
									->update([
										'fpg_posting' => 'DONE',
									]);
								}	
					$akundagang = $request->akunhutangdagang[$i];
					$dataakunhutang = DB::select("select * from d_akun where id_akun = '$akundagang'");
					$dkahutang = $dataakunhutang[0]->akun_dka;

					if($dkahutang == 'D'){					
						$datajurnal[$i]['id_akun'] = $request->akunhutangdagang[$i];
						$datajurnal[$i]['subtotal'] = '-' .$nominal;
						$datajurnal[$i]['dk'] = 'K';
						$datajurnal[$i]['detail'] = $request->keterangan[$i];
					}
					else {
						$datajurnal[$i]['id_akun'] = $request->akunhutangdagang[$i];
						$datajurnal[$i]['subtotal'] = '-' .$nominal;
						$datajurnal[$i]['dk'] = 'D';
						$datajurnal[$i]['detail'] = $request->keterangan[$i];
					}

				}
		} // END IF FLAG CEK BG
		else if($request->flag == 'BGAKUN'){
			DB::delete("DELETE from bukti_bank_keluar_akunbg where bbkab_idbbk = '$idbbk'");

			for($j=0;$j<count($request->accbiayaakun);$j++){
				$bbkb = new bukti_bank_keluar_bgakun();

				$lastidbbkab =  bukti_bank_keluar_bgakun::max('bbkab_id');
				if(isset($lastidbbkb)) {
						$idbbkab = 1;
				}
				else {
						$idbbkab = $lastidbbkab;
						$idbbkab = (int)$idbbkab + 1;
				} 
				$dataaccbiayaakun = explode("-", $request->accbiayaakun[$j]);
				$accbiayaakun = $dataaccbiayaakun[0];

				$jumlah = str_replace(',', '', $request->nominalakun[$j]);
				$jumlahfpg = str_replace(',', '', $request->nominalfpg[$j]);

				$bbkb->bbkab_id = $idbbkab;
				$bbkb->bbkab_idbbk = $idbbk;
				$bbkb->bbkab_akun = $accbiayaakun;
				$bbkb->bbkab_dk = $request->dk[$j];
				$bbkb->bbkab_nominal = $jumlah;
				$bbkb->bbkab_keterangan = $request->keteranganakunbg[$j];
				$bbkb->bbkab_nocheck = $request->nocheck[$j];
				$bbkb->bbkab_nofpg = $request->nofpg[$j];
				$bbkb->bbkab_idfpg = $request->idfpg[$j];
				$bbkb->bbkab_nominalfpg = $jumlahfpg;
				$bbkb->bbkab_keteranganfpg = $request->keteranganfpg[$j];
				$bbkb->save();


				$akunbiaya = $request->accbiayaakun[$j];
				$datajurnal2 = DB::select("select * from d_akun where id_akun = '$accbiayaakun'");
				//dd($datajurnal2);
				$akundka2 = $datajurnal2[0]->akun_dka;

				$idfpg = $request->idfpg[$j];
				$data['idfpg'] = DB::table('fpg_cekbank')
					->where([['fpgb_idfpg', '=', $idfpg], ['fpgb_nocheckbg' , '=' , $request->nocheck[$j]]])
					->update([
						'fpgb_posting' => 'DONE',
					]);


				if($request->dk[$j] == 'K'){
					if($akundka2 == 'K'){
						$datajurnal[$j]['id_akun'] = $accbiayaakun;
						$datajurnal[$j]['subtotal'] = '-' . $jumlah;
						$datajurnal[$j]['dk'] = 'K';
						$datajurnal[$j]['detail'] = $request->keteranganakunbg[$j];

					}
					else {
						$datajurnal[$j]['id_akun'] = $accbiayaakun;
						$datajurnal[$j]['subtotal'] =  $jumlah;
						$datajurnal[$j]['dk'] = 'D';	
						$datajurnal[$j]['detail'] = $request->keteranganakunbg[$j];

					}
				}
				else {

				}
				
			}
		}
		else { // DO SAVE BIAYA
			DB::delete("DELETE from  bukti_bank_keluar_biaya where bbkb_idbbk = '$idbbk'");	
			for($i = 0; $i < count($request->akun); $i++){		
			// END IF DATA CEK BG
				
				$noakun = $request->akun[$i];
				$data['bbkb'] = DB::select("select * from bukti_bank_keluar_biaya where bbkb_idbbk = '$idbbk' and bbkb_akun = '$noakun'");

					
					$bbkb = new bukti_bank_keluar_biaya();

					$lastidbbkb =  bukti_bank_keluar_biaya::max('bbkb_id');
					if(isset($lastidbbkb)) {
							$idbbkb = $lastidbbkb;
							$idbbkb = (int)$idbbkb + 1;
					}
					else {
							$idbbkb = 1;
					} 
					$jumlah = str_replace(',', '', $request->jumlah[$i]);

					$bbkb->bbkb_id = $idbbkb;
					$bbkb->bbkb_idbbk = $idbbk;
					$bbkb->bbkb_akun = $request->akun[$i];
					$bbkb->bbkb_dk = $request->dk[$i];
					$bbkb->bbkb_nominal = $jumlah;
					$bbkb->bbkb_keterangan = $request->keterangan[$i];
					$bbkb->save();

					$nominal2 = str_replace(',', '' , $jumlah);

					$akun = $request->akun[$i];
					$dataakun = DB::select("select * from d_akun where id_akun = '$akun'");
					//dd($dataakun);
					$dk = $dataakun[0]->akun_dka;
					//$substrnominal = substr($nominal2, 0,-2);	
					if($dk == 'D'){
						$datajurnal[$i]['id_akun'] = $request->akun[$i];
						$datajurnal[$i]['subtotal'] = $nominal2;
						$datajurnal[$i]['dk'] = 'D';
						$datajurnal[$i]['detail'] = $request->keterangan[$i];
					}
					else {
						$datajurnal[$i]['id_akun'] = $request->akun[$i];
						$datajurnal[$i]['subtotal'] = $nominal2;
						$datajurnal[$i]['dk'] = 'K';
						$datajurnal[$i]['detail'] = $request->keterangan[$i];
	
					}
			}

	

		}


		//save jurnal

			DB::delete("DELETE from  d_jurnal where jr_ref = '$refjurnal' and jr_detail = 'BUKTI BANK KELUAR'");
				$jr_no = get_id_jurnal('BK-' . $kodebank , $cabang, $request->tglbbk);

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
	        $jurnal->jr_year = Carbon::parse($request->tglbbk)->format('m');
	        $jurnal->jr_date = $request->tglbbk;
	        $jurnal->jr_detail = 'BUKTI BANK KELUAR';
	        $jurnal->jr_ref = $refjurnal;
	        $jurnal->jr_note = $request->keteranganheader;
	        $jurnal->jr_no = $jr_no;
	        $jurnal->save();
       	
	        
	        	$dataakun = array (
				'id_akun' => $akunkodebank,
				'subtotal' => '-' . $total,
				'dk' => 'K',
				'detail' => $request->keteranganheader,
				);	
	      

			array_push($datajurnal, $dataakun );
    		$key  = 1;
    		for($j = 0; $j < count($datajurnal); $j++){
    			
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
    			$jurnaldt->jrdt_acc = $datajurnal[$j]['id_akun'];
    			$jurnaldt->jrdt_value = $datajurnal[$j]['subtotal'];
    			$jurnaldt->jrdt_statusdk = $datajurnal[$j]['dk'];
    			$jurnaldt->jrdt_detail =  $datajurnal[$j]['detail'];
    			$jurnaldt->save();
    			$key++;
    		}  


    		$cekjurnal = check_jurnal($refjurnal);
    		if($cekjurnal == 0){
    			$dataInfo =  $dataInfo=['status'=>'gagal','info'=>'Data Jurnal Tidak Balance :('];
				DB::rollback();
									        
    		}
    		elseif($cekjurnal == 1) {
    			$dataInfo =  $dataInfo=['status'=>'sukses','info'=>'Data Jurnal Balance :)'];
					        
    		}


    	//	$dataInfo =  $dataInfo=['status'=>'sukses','info'=>'Data Jurnal Balance :)'];
    		return json_encode($dataInfo);
		});
		
	}
	

	public function hapusbbk($id){
		return DB::transaction(function() use ($id) { 
		$databbk = DB::select("select * from bukti_bank_keluar where bbk_id = '$id'");
		$flag = $databbk[0]->bbk_flag;
		$nobbk = $databbk[0]->bbk_nota;
		if($flag == 'BIAYA'){

		}elseif($flag == 'CEKBG'){
			$databbkd = DB::select("select * from bukti_bank_keluar_detail where bbkd_idbbk = '$id'");
			
			for($i = 0; $i < count($databbkd); $i++){

				$notabbkd = $databbkd[$i]->bbkd_notabm;
				$substr = substr($notabbkd, 0,2);
				$idfpg = $databbkd[$i]->bbkd_idfpg;
				$jenisfpg = $databbkd[$i]->bbkd_jenisbayarfpg;
				$datafpg = DB::select("select * from fpg, fpg_cekbank  where idfpg = '$idfpg' and fpgb_idfpg = idfpg");
				if($notabbkd != ''){
					if($jenisfpg == '1'){
						DB::delete("DELETE from  d_jurnal where jr_ref = '$notabbkd' and jr_detail = 'KAS MASUK'");
					}
					else {
						if($substr == 'BM'){
							DB::delete("DELETE from  d_jurnal where jr_ref = '$notabbkd' and jr_detail = 'BUKTI BANK MASUK'");
						}
						else if($substr == 'KM'){
							DB::delete("DELETE from  d_jurnal where jr_ref = '$notabbkd' and jr_detail = 'KAS MASUK'");
						}
					}
				}
				
				for($j = 0; $j < count($datafpg); $j++){
				$notafpg = $datafpg[$j]->fpg_nofpg;
			
				$idfpgb = $datafpg[$j]->fpgb_id;
				
				if($notabbkd != '') {
					
					if($jenisfpg == '1'){
						//DB::delete("DELETE from  d_jurnal where jr_ref = '$notabbkd' and jr_detail = 'KAS MASUK'");
					}
					else {
						

						if($substr == 'BM'){
						
							if($notabbkd != ''){
							
								$updatebankmasuk = bank_masuk::where([['bm_notatransaksi' , '=' , $notafpg],['bm_idfpgb' , '=', $idfpgb]]);
								$updatebankmasuk->update([
									'bm_status' => 'DIKIRIM',
									'bm_tglterima' => null,
									'bm_nota' => null
								]);
							}	
						}
						else if ($substr == 'KM'){
							//dd($notafpg);
						 	if($notabbkd != ''){
						 		
						 		$updatebankmasuk = DB::table('kas_masuk')->where([['km_notatransaksi' , '=' , $notafpg],['km_idfpgb' , '=' , $idfpgb]])
						 		->update([
						 			'km_status' => 'DIKIRIM',
						 			'km_tgl' => null,
						 			'km_nota' => null,
						 		]);
						 	}
							
						}
						
						}				
					}
				}
				

				$updatebbkbank = formfpg_bank::where('fpgb_idfpg', '=', $idfpg);
					$updatebbkbank->update([
					 	'fpgb_posting' => null, 	
				 	]);	

				 $updatebbk = formfpg::where('idfpg', '=', $idfpg);
					$updatebbk->update([
					 	'fpg_posting' => 'NOT', 	
				 	]);
			}
		}
		else if($flag == 'BGAKUN'){
			$databbkab = DB::select("select * from bukti_bank_keluar_akunbg where bbkab_idbbk = '$id'");
			for($j = 0; $j < count($databbkab); $j++){
				$idfpg = $databbkab[$j]->bbkab_idfpg;

				$updatebbkab = formfpg::where('idfpg' , '=' , $idfpg);
				$updatebbkab->update([
					'fpg_posting' => 'NOT',
				]);

				$updatebbkbank = formfpg_bank::where('fpgb_idfpg', '=', $idfpg);
					$updatebbkbank->update([
					 	'fpgb_posting' => null, 	
				 	]);
			}
		}

		DB::delete("DELETE from  d_jurnal where jr_ref = '$nobbk' and jr_detail = 'BUKTI BANK KELUAR'");
		DB::delete("DELETE from bukti_bank_keluar where bbk_id = '$id'");

		//return 'ok';
	});
	}

	public function createformtandaterimatagihan() {

		$data['supplier'] = DB::select("select * from supplier where status = 'SETUJU' and active = 'AKTIF'");
	//	dd('aan');
		return view('purchase/formtandaterimatagihan/create' , compact('data'));
	
	}

	


	public function formfpg() {
		$cabang = session::get('cabang');
		$data['jenisBayar'] = DB::select("select * from jenisbayar where idjenisbayar != '8'  and idjenisbayar != 10 ");
		$data['supplier'] =  DB::select("select * from supplier where status = 'SETUJU' and active = 'AKTIF'");

		if(Auth::user()->punyaAkses('Form Permintaan Giro','all')){			
			/*
			$data['fpg'] = DB::select("select * from   jenisbayar, fpg  where  fpg_jenisbayar = idjenisbayar order by fpg_nofpg desc limit 10");*/
			$data['belumdiproses'] = DB::table("fpg")->where('fpg_posting' , '=' , 'NOT')->count();
			$data['sudahdiproses'] = DB::table("fpg")->where('fpg_posting' , '=' , 'DONE')->count();
		}
		else {						/*
			$data['fpg'] = DB::select("select * from   jenisbayar, fpg , cabang where  fpg_jenisbayar = idjenisbayar and fpg_cabang = '$cabang' and fpg_cabang = kode order by fpg_nofpg asc limit 10");*/
			$data['belumdiproses'] = DB::table("fpg")->where('fpg_posting' , '=' , 'NOT')->where('fpg_cabang' ,'=' , $cabang)->count();
			$data['sudahdiproses'] = DB::table("fpg")->where('fpg_posting' , '=' , 'DONE')->where('fpg_cabang' ,'=' , $cabang)->count();
		}
	

		
		return view('purchase/formfpg/index' , compact('data'));
	}

	function formfpgNotif(Request $request){
		$idjenisbayar='';
  		  $tgl='';
  		  $supplier='';
  		  $nofpg='';
  		  $tgl1=date('Y-m-d',strtotime($request->tanggal1));
  		  $tgl2=date('Y-m-d',strtotime($request->tanggal2));
  		  $cabang = session::get('cabang');
  		  if($request->tanggal1!='' && $request->tanggal2!=''){  		  	
  		  	$tgl="and fpg_tgl >= '$tgl1' AND fpg_tgl <= '$tgl2'";
  		  }
  		  if($request->nosupplier!=''){
  		  	$supplier="and fpg_supplier=$request->nosupplier";
  		  }
  		  if($request->idjenisbayar!=''){
  		  	$idjenisbayar="and fpg_jenisbayar=$request->idjenisbayar";
  		  }
  		  if($request->nofpg!=''){
  		  	$nofpg="and fpg_nofpg='$request->nofpg'";
  		  }

		if(Auth::user()->punyaAkses('Form Permintaan Giro','all')){					
			$data['belumdiproses'] = DB::select("select count(*) as count from fpg where fpg_posting='NOT' $tgl $supplier $idjenisbayar $nofpg");
			$data['sudahdiproses'] = DB::select("select count(*) as count from fpg where fpg_posting='DONE' $tgl $supplier $idjenisbayar $nofpg");
		}
		else {						

			$data['belumdiproses'] = DB::select("select count(*) as count from fpg where fpg_posting='NOT' $tgl $supplier $idjenisbayar $nofpg and fpg_cabang=$cabang");
			$data['sudahdiproses'] = DB::select("select count(*) as count from fpg where fpg_posting='DONE' $tgl $supplier $idjenisbayar $nofpg and fpg_cabang=$cabang ");
		}

		$html='';

		$html.='<div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-danger alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <h2 style="text-align:center"> <b> '.$data['belumdiproses'][0]->count.' Data </b></h2> <h4 style="text-align:center"> Belum di Posting Bank Keluar </h4>
      </div>
    </div>

     <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-success alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
      <h2 style="text-align:center"> <b> '.$data['sudahdiproses'][0]->count.' Data  </b></h2> <h4 style="text-align:center"> Sudah di Posting Bank Keluar </h4>
      </div>
    </div>';


return $html;

	}

	function formfpgTable(Request $request){

  		  $idjenisbayar='';
  		  $tgl='';
  		  $supplier='';
  		  $nofpg='';
  		  $tgl1=date('Y-m-d',strtotime($request->tanggal1));
  		  $tgl2=date('Y-m-d',strtotime($request->tanggal2));
  		  if($request->tanggal1!='' && $request->tanggal2!=''){  		  	
  		  	$tgl="and fpg_tgl >= '$tgl1' AND fpg_tgl <= '$tgl2'";
  		  }
  		  if($request->nosupplier!=''){
  		  	$supplier="and fpg_supplier=$request->nosupplier";
  		  }
  		  if($request->idjenisbayar!=''){
  		  	$idjenisbayar="and idjenisbayar=$request->idjenisbayar";
  		  }
  		  if($request->nofpg!=''){
  		  	$nofpg="and fpg_nofpg='$request->nofpg'";
  		  }
		 $cabang = session::get('cabang');
		 $dataFpg='';
		if(Auth::user()->punyaAkses('Form Permintaan Giro','all')){						

			$dataFpg=DB::select("select *,row_number() OVER () as no from   jenisbayar, fpg  where  fpg_jenisbayar = idjenisbayar $tgl $supplier $idjenisbayar $nofpg  order by fpg_nofpg desc");

			$dataFpg=collect($dataFpg);			
		}
		else {	
			
			$dataFpg=DB::select("select *,row_number() OVER () as no  from   jenisbayar, fpg , cabang where  fpg_jenisbayar = idjenisbayar and fpg_cabang = '$cabang' and fpg_cabang = kode order by fpg_nofpg asc ");
			$dataFpg=collect($dataFpg);
			}


		return 
			DataTables::of($dataFpg)->
			editColumn('fpg_tgl', function ($dataFpg) {            
            	return date('d-m-Y',strtotime($dataFpg->fpg_tgl));
            })
            ->editColumn('fpg_keterangan', function ($dataFpg) { 
            	$fpg_keterangan='';
            	if($dataFpg->fpg_posting == 'DONE'){
                 $fpg_keterangan.=$dataFpg->fpg_keterangan.'<span class="label label-success"> Sudah Terposting </span> &nbsp';
            	}
                else{
                $fpg_keterangan.= $dataFpg->fpg_keterangan.'<span class="label label-warning">  Belum di Posting </span> &nbsp';
                }
				return $fpg_keterangan;
            })->editColumn('fpg_totalbayar', function ($dataFpg) { 
                return number_format($dataFpg->fpg_totalbayar, 2);                
            })->editColumn('fpg_cekbg', function ($dataFpg) { 
                return number_format($dataFpg->fpg_cekbg, 2);                
            })->editColumn('uangmuka', function ($dataFpg) { 
                return '-';
            })                        
            ->addColumn('action', function ($dataFpg) {            	
            	$html='';
            	   if(Auth::user()->punyaAkses('Form Permintaan Giro','ubah')){
/*'<a title="Edit" class="btn btn-sm btn-success" href='.url('fakturpembelian/edit_penerus/'.$data->fp_idfaktur.'').'>
				                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
				                                </a>';*/

                  $html.="<a class='btn btn-sm btn-success' 
                  href=".url("formfpg/detailformfpg/".$dataFpg->idfpg."").">
                  <i 			class='fa fa-arrow-right' aria-hidden='true'></i> </a>";
            	   }


             if(Auth::user()->punyaAkses('Form Permintaan Giro','print')){
                   if($dataFpg->fpg_jenisbayar == '5' || $dataFpg->fpg_jenisbayar == '12'){
                       $html.= "<a class='btn btn-sm btn-info'                        
                       href=".url("formfpg/printformfpg2/".$dataFpg->idfpg."").">
                            	<i class='fa fa-print' aria-hidden='true'></i></a>";
                   }else{
                   	   $html.="<a class='btn btn-sm btn-info'                    	   
                   	   href=".url("formfpg/printformfpg/".$dataFpg->idfpg."").">
                   	    <i class='fa fa-print' aria-hidden='true'></i> </a>";
             			}                          
            }




             if(Auth::user()->punyaAkses('Form Permintaan Giro','hapus')){                            
                            if($dataFpg->fpg_posting == 'DONE'){

                            }else{
						$html.="<a class='btn btn-sm btn-danger' onclick='hapusdata($dataFpg->idfpg)'> <i class='fa fa-trash' aria-hidden='true'></i> </a>";
                            }
            }

            return $html;           
            })
			->make(true);	

	}



	public function createformfpg() {

		$data['supplier'] = DB::select("select * from supplier where status = 'SETUJU' and active = 'AKTIF'");
		$data['jenisbayar'] = DB::select("select * from jenisbayar where idjenisbayar != '8'  and idjenisbayar != 10 ");

		$cabang = session::get('cabang');

		if(Auth::user()->punyaAkses('Form Permintaan Giro','all')){
			$data['bank'] = DB::select("select * from masterbank");
		}
		else {
			$data['bank'] = DB::select("select * from masterbank where mb_cabangbank = '$cabang'");
		}
		
		if(Auth::user()->punyaAkses('Form Permintaan Giro','all')){
			$data['tujuanbank'] = DB::select("select * from masterbank");
		}
		else {
			$data['tujuanbank'] = DB::select("select * from masterbank wher mb_cabangbank = '$cabang'");
		}

		if(Auth::user()->punyaAkses('Form Permintaan Giro','all')){
			$data['tujuanbankkas'] = DB::select("select * from d_akun where id_akun = '100111008' or id_akun = '100111001' or id_akun = '100114017'");
		}
		else {
			//$data['tujuanbank'] = DB::select("select * from masterbank wher mb_cabangbank = '$cabang'");
		}		
		
		$data['agen'] = DB::select("select * from agen where kategori = 'AGEN'");
		$data['cabang'] = DB::select("select * from cabang");
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
			$idfpg = str_pad($string, 4, '0', STR_PAD_LEFT);
		}

		else {
			
			$idfpg = '0001';
		}

		//dd($idfpg);

		
		//dd($data);
		return view('purchase/formfpg/create2', compact('data'));
	}


	public function hapusfpg($id){
		return DB::transaction(function() use ($id) { 

		$data['fpg'] = DB::select("select * from fpg, fpg_dt where idfpg = fpgdt_idfpg and idfpg = '$id'");

		$fpg = DB::select("select * from fpg where idfpg = '$id'");
		$jenisbayar = $fpg[0]->fpg_jenisbayar;
		for($i = 0; $i < count($data['fpg']); $i++){
			$idfp = $data['fpg'][$i]->fpgdt_idfp;
			$pelunasan = $data['fpg'][$i]->fpgdt_pelunasan;

			$jenisbayar = $data['fpg'][0]->fpg_jenisbayar;

			if($jenisbayar == '2' || $jenisbayar == '6' || $jenisbayar == '7' || $jenisbayar == '9'){
			$data['fp'] = DB::select("select * from faktur_pembelian where fp_idfaktur = '$idfp'");
			//$jenisbayar = $data['fp'][0]->fp_jenisbayar;
			$fppelunasan = $data['fp'][0]->fp_sisapelunasan;
			$hasilpengurangan = (float)$fppelunasan + (float)$pelunasan;

			$updatefaktur = fakturpembelian::where('fp_idfaktur', '=', $idfp);
					$updatefaktur->update([
					 	'fp_sisapelunasan' => $hasilpengurangan, 
					 	'fp_edit'	=> 'UNALLOWED',
				 	]);	


			$datacndn = DB::select("select * from cndnpembelian_dt where cndt_idfp = '$idfp'");
				if(count($datacndn) != 0){
					$updatecndn = cndn_dt::where('cndt_idfp' ,  '=' , $idfp);
					$updatecndn->update([
						'cndt_statusfpg' => 'NOT',
						]);
				}
			}
			else if($jenisbayar == '4'){
				$data['um'] =  DB::select("select * from d_uangmuka where um_id = '$idfp'");
				$fppelunasan = $data['um'][0]->um_sisapelunasan;
				$hasilpengurangan = (float)$fppelunasan + (float)$pelunasan;


				$updateformfpg = d_uangmuka::where('um_id' , '=' , $idfp);
				$updateformfpg->update([
					'um_sisapelunasan' => $hasilpengurangan,					
				]);
			}
			else if($jenisbayar == '1'){
				$data['ik'] =  DB::select("select * from ikhtisar_kas where ik_id = '$idfp'");
				$fppelunasan = $data['ik'][0]->ik_pelunasan;
				$hasilpengurangan = (float)$fppelunasan + (float)$pelunasan;


				$updateformfpg = ikhtisar_kas::where('ik_id' , '=' , $idfp);
				$updateformfpg->update([
					'ik_pelunasan' => $hasilpengurangan,
					'ik_status' => 'APPROVED',				
				]);
			}
			else if($jenisbayar == '11'){
				$data['bonsem'] =  DB::select("select * from bonsem_pengajuan where bp_id = '$idfp'");
				$fppelunasan = $data['bonsem'][0]->bp_pelunasan;
				$hasilpengurangan = (float)$fppelunasan + (float)$pelunasan;


				$updatebonsem = bonsempengajuan::where('bp_id' , '=' , $idfp);
				$updatebonsem->update([
					'bp_pelunasan' => $hasilpengurangan,					
				]);
			}
			else if($jenisbayar == '13'){
				$data['bonsem'] =  DB::select("select * from bonsem_pengajuan where bp_id = '$idfp'");
				$fppelunasan = $data['bonsem'][0]->bp_pelunasan;
				$hasilpengurangan = (float)$fppelunasan - (float)$pelunasan;


				$updatebonsem = bonsempengajuan::where('bp_id' , '=' , $idfp);
				$updatebonsem->update([
					'bp_pencairan' => $hasilpengurangan,					
				]);
			}

		}


		$data['fpgbank'] = DB::select("select * from fpg, fpg_cekbank where fpgb_idfpg = idfpg and idfpg = '$id'");


		for($i = 0; $i < count($data['fpgbank']);$i++){
			$idbank = $data['fpgbank'][$i]->fpg_idbank;
			$noseri = $data['fpgbank'][$i]->fpgb_nocheckbg;
			$idfpgb = $data['fpgbank'][$i]->fpgb_id;
			$notafpg = $data['fpgbank'][$i]->fpg_nofpg;
		
			$updatebank = masterbank_dt::where([['mbdt_idmb', '=', $idbank], ['mbdt_noseri' , '=' ,$noseri]]);

			$updatebank->update([
			 	'mbdt_nofpg' =>  null,
			 	'mbdt_setuju' => null,
			 	'mbdt_status' => null,
			 	'mbdt_nominal' => null,
			 	'mbdt_tglstatus' => null,
		 	]);	

			$bankmasuk = DB::select("select * from bank_masuk where bm_idfpgb = '$idfpgb' and bm_notatransaksi = '$notafpg'");
			if(count($bankmasuk) > 0) {
				$idbm = $bankmasuk[0]->bm_id;
				DB::delete("DELETE from bank_masuk where bm_id = '$idbm'");
			}
			//dd($idfpgb);
			//dd($notafpg);
			$kasmasuk = DB::select("select * from kas_masuk where km_idfpgb = '$idfpgb' and km_notatransaksi = '$notafpg'");
			//dd($kasmasuk);
			if(count($kasmasuk) > 0) {

				$idkm = $kasmasuk[0]->km_id;
				DB::delete("DELETE from kas_masuk where km_id = '$idkm'");
			}
		}
		//cekbankmasuk
		
		
		$fpg = DB::select("select * from fpg where idfpg = '$id'");
		$done = $fpg[0]->fpg_posting;
		if($done == 'DONE') {
			 $dataInfo=['status'=>'gagal','info'=>'NOTA FPG sudah di posting'];
			DB::rollback();
			return json_encode($dataInfo);
		}
		elseif($done == 'NOT'){

			DB::delete("DELETE from fpg where idfpg = '$id'");
			if($jenisbayar == '12'){
					$nofpg = $fpg[0]->fpg_nofpg;
					DB::delete("DELETE from bank_masuk where bm_nota = '$nofpg'");
			}
			 $dataInfo=['status'=>'sukses','info'=>'Data Berhasil di hapus'];

			return json_encode($dataInfo);
		}
		
		return json_encode($dataInfo);
	});
	}

	public function printformfpg($id){
		

		$fpg = DB::select("select * from fpg, fpg_dt where idfpg ='$id'");

		$jenisbayar = $fpg[0]->fpg_jenisbayar;

		if($jenisbayar == '2'){
			$data['fpg'] = DB::select("select *, cabang.nama as namacabang , supplier.alamat as alamatsupplier, supplier.telp as telpsupplier from fpg, supplier, cabang where idfpg ='$id' and fpg_supplier = idsup and fpg_cabang = cabang.kode");
			$data['fpg_dt'] = DB::select("select * from fpg_dt, fpg, faktur_pembelian where fpgdt_idfpg = idfpg and fpgdt_idfpg = '$id' and fpgdt_idfp = fp_idfaktur");
			$data['fpg_bank'] = DB::select("select * from fpg_cekbank,fpg, masterbank where fpgb_idfpg = idfpg and fpgb_idfpg = '$id' and fpgb_kodebank = mb_id");
			$data['katauang'] = $this->terbilang($data['fpg'][0]->fpg_totalbayar,$style=3);	
		}
		else if($jenisbayar == '5' || $jenisbayar == '12'){
			$data['fpg'] = DB::select("select *, cabang.nama as namacabang, cabang.alamat as alamatsupplier, cabang.telpon as telpsupplier from fpg, cabang where fpg_cabang = cabang.kode and idfpg ='$id'");
			$data['fpg_dt'] = DB::select("select * from fpg_dt, fpg, faktur_pembelian where fpgdt_idfpg = idfpg and fpgdt_idfpg = '$id'");
			$data['fpg_bank'] = DB::select("select * from fpg_cekbank,fpg, masterbank where fpgb_idfpg = idfpg and fpgb_idfpg = '$id' and fpgb_kodebank = mb_id");
			$data['katauang'] = $this->terbilang($data['fpg'][0]->fpg_totalbayar,$style=3);	
		}
		else if($jenisbayar == '6' || $jenisbayar == '7' ){
			$data['fpg'] = DB::select("select *, cabang.nama as namacabang, cabang.alamat as alamatsupplier, cabang.telepon as telpsupplier from fpg, agen, cabang where idfpg ='$id' and fpg_agen = agen.kode and fpg_cabang as cabang.kode");
			$data['fpg_dt'] = DB::select("select * from fpg_dt, fpg, faktur_pembelian where fpgdt_idfpg = idfpg and fpgdt_idfpg = '$id' and fpgdt_idfp = fp_idfaktur");
			$data['fpg_bank'] = DB::select("select * from fpg_cekbank,fpg, masterbank where fpgb_idfpg = idfpg and fpgb_idfpg = '$id' and fpgb_kodebank = mb_id");
			$data['katauang'] = $this->terbilang($data['fpg'][0]->fpg_totalbayar,$style=3);	
		}
		else if($jenisbayar == '4'){ // uang muka


		//	$data['fpg'] = DB::select("select * from fpg, agen where idfpg ='$id' and fpg_agen = agen.kode");
			$fpg2 = DB::select("select * from  fpg, d_uangmuka where idfpg = '$id' and fpg_agen = um_supplier ");
			$jenissup = $fpg2[0]->um_jenissup;
			$data['jenissup'] = $jenissup;
			if($jenissup == 'supplier'){	
				$data['fpg'] = DB::select("select *, cabang.nama as namacabang, supplier.alamat as alamatsupplier, supplier.telp as telpsupplier from cabang,fpg,supplier, masterbank, jenisbayar where idfpg = '$id' and fpg_agen = no_supplier and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpg_cabang = cabang.kode");
			}
			else if($jenissup == 'agen'){
				$data['fpg'] = DB::select("select *, cabang.nama as namacabang, cabang.alamat as alamatsupplier, cabang.telpon as telpsupplier from cabang,fpg,agen, masterbank, jenisbayar where idfpg = '$id' and fpg_agen = kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpg_cabang = cabang.kode");	
			}
			else if($jenissup == 'subcon'){
				$data['fpg'] = DB::select("select *,cabang.nama as namacabang, cabang.alamat as alamatsupplier, cabang.telpon as telpsupplier from cabang,fpg,subcon, masterbank, jenisbayar where idfpg = '$id' and fpg_agen = kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpg_cabang = cabang.kode");	
			}

			$data['fpg_dt'] = DB::select("select * from fpg_dt, fpg, d_uangmuka where fpgdt_idfpg = idfpg and fpgdt_idfpg = '$id' and fpgdt_idfp = um_id");
			$data['fpg_bank'] = DB::select("select * from fpg_cekbank,fpg, masterbank where fpgb_idfpg = idfpg and fpgb_idfpg = '$id' and fpgb_kodebank = mb_id");
			$data['katauang'] = $this->terbilang($data['fpg'][0]->fpg_totalbayar,$style=3);	
		}
		else if($jenisbayar == '3'){ // voucher hutang
			for($i = 0; $i < count($fpg); $i++){
				$idfp = $fpg[$i]->fpgdt_idfp;
			$data['fpg'] = DB::select("select *, cabang.nama as namacabang from cabang,fpg, v_hutang, fpg_dt, supplier where idfpg ='$id' and fpg_supplier = v_supplier and fpgdt_idfp = v_id and fpgdt_idfpg = idfpg and v_supplier = idsup and fpg_cabang = kode.cabang");


			}
	//		$data['fpg'] = DB::select("select * from fpg, v_hutang where idfpg ='$id' and fpg_supplier = v_supplier");
			$data['fpg_dt'] = DB::select("select * from fpg_dt, fpg, v_hutang where fpgdt_idfpg = idfpg and fpgdt_idfpg = '$id' and fpgdt_idfp = v_id");
			$data['fpg_bank'] = DB::select("select * from fpg_cekbank,fpg, masterbank where fpgb_idfpg = idfpg and fpgb_idfpg = '$id' and fpgb_kodebank = mb_id");
			$data['katauang'] = $this->terbilang($data['fpg'][0]->fpg_totalbayar,$style=3);	
		}
		else if($jenisbayar == '9'){
			$data['fpg'] = DB::select("select *, cabang.nama as namacabang, cabang.alamat as alamatsupplier, cabang.telpon as telpsupplier from cabang,fpg, subcon where idfpg ='$id' and fpg_agen = subcon.kode and fpg_cabang = cabang.kode");
			$data['fpg_dt'] = DB::select("select * from fpg_dt, fpg, faktur_pembelian where fpgdt_idfpg = idfpg and fpgdt_idfpg = '$id' and fpgdt_idfp = fp_idfaktur");
			$data['fpg_bank'] = DB::select("select * from fpg_cekbank,fpg, masterbank where fpgb_idfpg = idfpg and fpgb_idfpg = '$id' and fpgb_kodebank = mb_id");
			$data['katauang'] = $this->terbilang($data['fpg'][0]->fpg_totalbayar,$style=3);	
		}
		else if($jenisbayar == '1'){
			$data['fpg'] = DB::select("select *, cabang.nama as namacabang, cabang.alamat as alamatsupplier, cabang.telpon as telpsupplier from fpg, ikhtisar_kas, cabang where idfpg ='$id' and fpg_agen = cabang.kode ");
			$data['fpg_dt'] = DB::select("select * from fpg_dt, fpg, ikhtisar_kas where fpgdt_idfpg = idfpg and fpgdt_idfpg = '$id' and fpgdt_idfp = ik_id");
			$data['fpg_bank'] = DB::select("select * from fpg_cekbank,fpg, masterbank where fpgb_idfpg = idfpg and fpgb_idfpg = '$id' and fpgb_kodebank = mb_id");
			$data['katauang'] = $this->terbilang($data['fpg'][0]->fpg_totalbayar,$style=3);	
		}
		else if($jenisbayar == '11'){
			$data['fpg'] = DB::select("select *, cabang.nama as namacabang, cabang.alamat as alamatsupplier, cabang.telpon as telpsupplier from fpg, bonsem_pengajuan, cabang where idfpg ='$id' and fpg_agen = cabang.kode and bp_cabang = kode");
			$data['fpg_dt'] = DB::select("select * from fpg_dt, fpg, bonsem_pengajuan where fpgdt_idfpg = idfpg and fpgdt_idfpg = '$id' and fpgdt_idfp = bp_id");
			$data['fpg_bank'] = DB::select("select * from fpg_cekbank,fpg, masterbank where fpgb_idfpg = idfpg and fpgb_idfpg = '$id' and fpgb_kodebank = mb_id");
			$data['katauang'] = $this->terbilang($data['fpg'][0]->fpg_totalbayar,$style=3);	
		}
		else if($jenisbayar == '13'){
			$data['fpg'] = DB::select("select *, cabang.nama as namacabang, cabang.alamat as alamatsupplier, cabang.telpon as telpsupplier from fpg, bonsem_pengajuan, cabang where idfpg ='$id' and fpg_agen = cabang.kode and bp_cabang = kode");
			$data['fpg_dt'] = DB::select("select * from fpg_dt, fpg, bonsem_pengajuan where fpgdt_idfpg = idfpg and fpgdt_idfpg = '$id' and fpgdt_idfp = bp_id");
			$data['fpg_bank'] = DB::select("select * from fpg_cekbank,fpg, masterbank where fpgb_idfpg = idfpg and fpgb_idfpg = '$id' and fpgb_kodebank = mb_id");
			$data['katauang'] = $this->terbilang($data['fpg'][0]->fpg_totalbayar,$style=3);	
		}
		
		/*dd($data);*/
		return view('purchase/formfpg/fpg', compact('data'));
	}

	public function caritransaksi(Request $request){
		
		$jenisbayar = $request->jenisbayar;
		$kas = explode("+" , $request->kas);

		$datakas = DB::select("select * from d_akun where id_akun = '$kas[0]'");
		$cabang = $datakas[0]->kode_cabang;

		if($jenisbayar == '12'){

			$data['transaksi'] = DB::select("select * from ikhtisar_kas where ik_comp = '$cabang' and ik_status = 'APPROVED' and ik_pelunasan != 0.00 ");
		}
		else if($jenisbayar == '11') {
			$data['transaksi'] = DB::select("select * from bonsem_pengajuan where bp_cabang = '$cabang' and bp_setujukeu = 'SETUJU' and bp_pelunasan != 0.00 ");
		}

		return json_encode($data);

	}

	public function printformfpg2 ($id){
		$fpg = DB::select("select * from fpg, fpg_dt where idfpg ='$id'");

		$jenisbayar = $fpg[0]->fpg_jenisbayar;
		$data['fpg'] = DB::select("select *, cabang.nama as namacabang, cabang.alamat as alamatsupplier, cabang.telpon as telpsupplier from fpg, cabang where fpg_cabang = cabang.kode and idfpg ='$id'");
			$data['fpg_dt'] = DB::select("select * from fpg_dt, fpg, faktur_pembelian where fpgdt_idfpg = idfpg and fpgdt_idfpg = '$id'");
			$data['fpg_bank'] = DB::select("select * from fpg_cekbank,fpg, masterbank where fpgb_idfpg = idfpg and fpgb_idfpg = '$id' and fpgb_kodebank = mb_id");
			$data['katauang'] = $this->terbilang($data['fpg'][0]->fpg_totalbayar,$style=3);	
		
		return view('purchase/formfpg/fpg_lain', compact('data'));
	}

	public function changesupplier(Request $request){
		
			$cabang = $request->cabangfaktur;
			$idsup = $request->idsup;
			$nosupplier = $request->nosupplier;
			$idjenisbayar = $request->idjenisbayar;

				 
				if($idjenisbayar == '2' ){

					if($cabang == 000){
						$datas['fp'] = DB::select("select * from faktur_pembelian, supplier, form_tt , form_tt_d, cabang where fp_idsup ='$idsup' and fp_jenisbayar = '$idjenisbayar' and fp_idsup = idsup and tt_idform = ttd_id and ttd_faktur = fp_nofaktur and fp_comp = kode and fp_sisapelunasan != '0.00'  and fp_tipe != 'S' and fp_tipe != 'NS' union select * from faktur_pembelian, supplier, form_tt , form_tt_d , cabang where fp_idsup ='$idsup' and fp_jenisbayar = '$idjenisbayar' and fp_idsup = idsup and tt_idform = ttd_id and ttd_faktur = fp_nofaktur and fp_comp = kode and fp_sisapelunasan != '0.00' and fp_terimabarang = 'SUDAH' order by fp_idfaktur asc");
	
						$datas['fp1'] = DB::select("select * from faktur_pembelian, supplier, form_tt , form_tt_d, cabang where fp_idsup ='$idsup' and fp_jenisbayar = '$idjenisbayar' and fp_idsup = idsup and tt_idform = ttd_id and ttd_faktur = fp_nofaktur and fp_comp = kode and fp_sisapelunasan != '0.00' and fp_tipe != 'S' and fp_tipe != 'NS' union select * from faktur_pembelian, supplier, form_tt , form_tt_d , cabang where fp_idsup ='$idsup' and fp_jenisbayar = '$idjenisbayar' and fp_idsup = idsup and tt_idform = ttd_id and ttd_faktur = fp_nofaktur and fp_comp = kode and fp_sisapelunasan != '0.00' and fp_terimabarang = 'SUDAH' order by fp_idfaktur asc");
					}
					else{
						$datas['fp'] = DB::select("select * from faktur_pembelian, supplier, form_tt , form_tt_d, cabang where fp_idsup ='$idsup' and fp_jenisbayar = '$idjenisbayar' and fp_idsup = idsup and tt_idform = ttd_id and ttd_faktur = fp_nofaktur and fp_comp = kode and fp_sisapelunasan != '0.00' and fp_comp = '$cabang' and fp_tipe != 'S' and fp_tipe != 'NS' union select * from faktur_pembelian, supplier, form_tt , form_tt_d , cabang where fp_idsup ='$idsup' and fp_jenisbayar = '$idjenisbayar' and fp_idsup = idsup and tt_idform = ttd_id and ttd_faktur = fp_nofaktur and fp_comp = kode and fp_sisapelunasan != '0.00' and fp_terimabarang = 'SUDAH' order by fp_idfaktur asc");
	
						$datas['fp1'] = DB::select("select * from faktur_pembelian, supplier, form_tt , form_tt_d, cabang where fp_idsup ='$idsup' and fp_jenisbayar = '$idjenisbayar' and fp_idsup = idsup and tt_idform = ttd_id and ttd_faktur = fp_nofaktur and fp_comp = kode and fp_sisapelunasan != '0.00' and fp_comp = '$cabang' and fp_tipe != 'S' and fp_tipe != 'NS' union select * from faktur_pembelian, supplier, form_tt , form_tt_d , cabang where fp_idsup ='$idsup' and fp_jenisbayar = '$idjenisbayar' and fp_idsup = idsup and tt_idform = ttd_id and ttd_faktur = fp_nofaktur and fp_comp = kode and fp_sisapelunasan != '0.00' and fp_terimabarang = 'SUDAH' order by fp_idfaktur asc");
					}

					if(count($request->arrnofaktur) != 0){
						for($i = 0 ; $i < count($datas['fp']); $i++){
							for($j = 0; $j < count($request->arrnofaktur); $j++){
								if($request->arrnofaktur[$j] == $datas['fp'][$i]->fp_nofaktur){
									unset($datas['fp1'][$i]);
								}
							}
						}
						$datas['fp1'] = array_values($datas['fp1']);
           				$data['fakturpembelian'] = $datas['fp1'];
					}
					else {
						$data['fakturpembelian'] = $datas['fp1'];
					}
				
				}
				else if($idjenisbayar == '6' || $idjenisbayar == '7'  ){

					if($cabang == 000){
						$datas['fp']  = DB::select("select fp_jatuhtempo, fp_idfaktur, fp_nofaktur, cabang.nama as namacabang, fp_noinvoice, agen.nama as namaoutlet , fp_sisapelunasan from  agen , cabang, faktur_pembelian, form_tt, form_tt_d where  fp_jenisbayar = '$idjenisbayar'  and fp_comp = cabang.kode and fp_sisapelunasan != '0.00' and fp_supplier = '$nosupplier' and fp_supplier = agen.kode and fp_pending_status = 'APPROVED' and tt_idform = ttd_id and ttd_faktur = fp_nofaktur" );
	
						$datas['fp1']  = DB::select("select fp_jatuhtempo, fp_idfaktur, fp_nofaktur, cabang.nama as namacabang, fp_noinvoice, agen.nama as namaoutlet , fp_sisapelunasan from  agen , cabang, faktur_pembelian, form_tt, form_tt_d where  fp_jenisbayar = '$idjenisbayar'  and fp_comp = cabang.kode and fp_sisapelunasan != '0.00' and fp_supplier = '$nosupplier' and fp_supplier = agen.kode and fp_pending_status = 'APPROVED'  and tt_idform = ttd_id and ttd_faktur = fp_nofaktur " );
					}
					else{				
						$datas['fp']  = DB::select("select fp_jatuhtempo, fp_idfaktur, fp_nofaktur, cabang.nama as namacabang, fp_noinvoice, agen.nama as namaoutlet , fp_sisapelunasan from  agen , cabang, faktur_pembelian , form_tt where  fp_jenisbayar = '$idjenisbayar'  and fp_comp = cabang.kode and fp_sisapelunasan != '0.00' and fp_supplier = '$nosupplier' and fp_supplier = agen.kode and fp_pending_status = 'APPROVED' and fp_comp = '$cabang' and tt_idform = ttd_id and ttd_faktur = fp_nofaktur" );
	
						$datas['fp1']  = DB::select("select fp_jatuhtempo, fp_idfaktur, fp_nofaktur, cabang.nama as namacabang, fp_noinvoice, agen.nama as namaoutlet , fp_sisapelunasan from  agen , cabang, faktur_pembelian , form_tt where  fp_jenisbayar = '$idjenisbayar'  and fp_comp = cabang.kode and fp_sisapelunasan != '0.00' and fp_supplier = '$nosupplier' and fp_supplier = agen.kode and fp_pending_status = 'APPROVED' and fp_comp = '$cabang' and tt_idform = ttd_id and ttd_faktur = fp_nofaktur" );
					}

					if(count($request->arrnofaktur) != 0){
						for($i = 0 ; $i < count($datas['fp']); $i++){
							for($j = 0; $j < count($request->arrnofaktur); $j++){
								if($request->arrnofaktur[$j] == $datas['fp'][$i]->fp_nofaktur){
									unset($datas['fp1'][$i]);
								}
							}
						}
						$datas['fp1'] = array_values($datas['fp1']);
           				$data['fakturpembelian'] = $datas['fp1'];
					}
					else {
						$data['fakturpembelian'] = $datas['fp1'];
					}

				}
				else if($idjenisbayar == '9'){

					if($cabang == 000){
						$datas['fp']  = DB::select("select fp_jatuhtempo, fp_idfaktur, fp_nofaktur, cabang.nama as namacabang, fp_noinvoice, subcon.nama as namavendor , fp_sisapelunasan from  subcon , cabang, faktur_pembelian, form_tt where  fp_jenisbayar = '$idjenisbayar'  and fp_comp = cabang.kode and fp_sisapelunasan != '0.00' and fp_supplier = '$nosupplier' and fp_supplier = subcon.kode and fp_pending_status = 'APPROVED' and tt_idform = ttd_id and ttd_faktur = fp_nofaktur" );
										
							$datas['fp1']  = DB::select("select fp_jatuhtempo, fp_idfaktur, fp_nofaktur, cabang.nama as namacabang, fp_noinvoice, subcon.nama as namavendor , fp_sisapelunasan from  subcon , cabang, faktur_pembelian, form_tt where  fp_jenisbayar = '$idjenisbayar'  and fp_comp = cabang.kode and fp_sisapelunasan != '0.00' and fp_supplier = '$nosupplier' and fp_supplier = subcon.kode and fp_pending_status = 'APPROVED' and tt_idform = ttd_id and ttd_faktur = fp_nofaktur");
					}
					else{ 
						$datas['fp']  = DB::select("select fp_jatuhtempo, fp_idfaktur, fp_nofaktur, cabang.nama as namacabang, fp_noinvoice, subcon.nama as namavendor , fp_sisapelunasan from  subcon , cabang, faktur_pembelian , form_tt where  fp_jenisbayar = '$idjenisbayar'  and fp_comp = cabang.kode and fp_sisapelunasan != '0.00' and fp_supplier = '$nosupplier' and fp_supplier = subcon.kode and fp_pending_status = 'APPROVED' and fp_comp = '$cabang' and tt_idform = ttd_id and ttd_faktur = fp_nofaktur" );
						
						$datas['fp1']  = DB::select("select fp_jatuhtempo, fp_idfaktur, fp_nofaktur, cabang.nama as namacabang, fp_noinvoice, subcon.nama as namavendor , fp_sisapelunasan from  subcon , cabang, faktur_pembelian LEFT OUTER JOIN form_tt on fp_nofaktur = tt_nofp where  fp_jenisbayar = '$idjenisbayar'  and fp_comp = cabang.kode and fp_sisapelunasan != '0.00' and fp_supplier = '$nosupplier' and fp_supplier = subcon.kode and fp_pending_status = 'APPROVED' and fp_comp = '$cabang' and tt_idform = ttd_id and ttd_faktur = fp_nofaktur");
					}

					if(count($request->arrnofaktur) != 0){
						for($i = 0 ; $i < count($datas['fp']); $i++){
							for($j = 0; $j < count($request->arrnofaktur); $j++){
								if($request->arrnofaktur[$j] == $datas['fp'][$i]->fp_nofaktur){
									unset($datas['fp1'][$i]);
								}
							}
						}
						$datas['fp1'] = array_values($datas['fp1']);
           				$data['fakturpembelian'] = $datas['fp1'];
					}
					else {
						$data['fakturpembelian'] = $datas['fp1'];
					}

				}
				else if($idjenisbayar == '3'){
					if($cabang == 000){
						$datas['fp']  = DB::select("select * from v_hutang, cabang, supplier where v_supid = '$nosupplier' and vc_comp = kode and v_supid = no_supplier and v_pelunasan != '0.00' ");

					$datas['fp1']  = DB::select("select * from v_hutang, cabang, supplier where v_supid = '$nosupplier' and vc_comp = kode and v_supid = no_supplier and v_pelunasan != '0.00'");
					}
					else {
					$datas['fp']  = DB::select("select * from v_hutang, cabang, supplier where v_supid = '$nosupplier' and vc_comp = kode and v_supid = no_supplier and v_pelunasan != '0.00' and vc_comp = '$cabang' ");

					$datas['fp1']  = DB::select("select * from v_hutang, cabang, supplier where v_supid = '$nosupplier' and vc_comp = kode and v_supid = no_supplier and v_pelunasan != '0.00' and vc_comp = '$cabang' ");
					}					
					if(count($request->arrnofaktur) != 0){
						for($i = 0 ; $i < count($datas['fp']); $i++){
							for($j = 0; $j < count($request->arrnofaktur); $j++){
								if($request->arrnofaktur[$j] == $datas['fp'][$i]->v_nomorbukti){
									unset($datas['fp1'][$i]);
								}
							}
						}
						$datas['fp1'] = array_values($datas['fp1']);
           				$data['fakturpembelian'] = $datas['fp1'];
					}
					else {
						$data['fakturpembelian'] = $datas['fp1'];
					}
					
				}
				else if($idjenisbayar == '4'){ //uang muka pembelian

					if($cabang == 000){
						$datas['fp']  = DB::select("select * from d_uangmuka, cabang where  um_supplier = '$idsup' and um_comp = kode and um_sisapelunasan != '0.00'");

					$datas['fp1']  = DB::select("select * from d_uangmuka, cabang where  um_supplier = '$idsup' and um_comp = kode  and um_sisapelunasan != '0.00'");
					}
					else {
					$datas['fp']  = DB::select("select * from d_uangmuka, cabang where  um_supplier = '$idsup' and um_comp = kode and um_comp = '$cabang' and um_sisapelunasan != '0.00'");

					$datas['fp1']  = DB::select("select * from d_uangmuka, cabang where  um_supplier = '$idsup' and um_comp = kode and um_comp = '$cabang' and um_sisapelunasan != '0.00'");
					}

					if(count($request->arrnofaktur) != 0){
						for($i = 0 ; $i < count($datas['fp']); $i++){
							for($j = 0; $j < count($request->arrnofaktur); $j++){
								if($request->arrnofaktur[$j] == $datas['fp'][$i]->um_nomorbukti){
									unset($datas['fp1'][$i]);
								}
							}
						}
						$datas['fp1'] = array_values($datas['fp1']);
           				$data['fakturpembelian'] = $datas['fp1'];
					}
					else {
						$data['fakturpembelian'] = $datas['fp1'];
					}
				}
				else if($idjenisbayar == '1'){ //GIRO KAS KECIL
					$datas['fp']  = DB::select("select * from ikhtisar_kas, cabang where ik_comp = '$cabang' and ik_status = 'APPROVED' and ik_pelunasan != 0.00 and ik_comp = kode");

					$datas['fp1']  = DB::select("select * from ikhtisar_kas, cabang where ik_comp = '$cabang' and ik_status = 'APPROVED' and ik_pelunasan != 0.00 and ik_comp = kode");

					if(count($request->arrnofaktur) != 0){
						for($i = 0 ; $i < count($datas['fp']); $i++){
							for($j = 0; $j < count($request->arrnofaktur); $j++){
								if($request->arrnofaktur[$j] == $datas['fp'][$i]->ik_nota){
									unset($datas['fp1'][$i]);
								}
							}
						}
						$datas['fp1'] = array_values($datas['fp1']);
           				$data['fakturpembelian'] = $datas['fp1'];
					}
					else {
						$data['fakturpembelian'] = $datas['fp1'];
					}

				}
				else if($idjenisbayar == '11') { // BON SEMENTARA


					$datas['fp']  = DB::select("select * from bonsem_pengajuan, cabang where  bp_cabang = '$nosupplier' and bp_cabang = kode and bp_setujukeu = 'SETUJU' and bp_pelunasan != 0.00");

					$datas['fp1']  = DB::select("select * from bonsem_pengajuan, cabang where  bp_cabang = '$nosupplier' and bp_cabang = kode and bp_setujukeu = 'SETUJU' and bp_pelunasan != 0.00");

					if(count($request->arrnofaktur) != 0){
						for($i = 0 ; $i < count($datas['fp']); $i++){
							for($j = 0; $j < count($request->arrnofaktur); $j++){
								if($request->arrnofaktur[$j] == $datas['fp'][$i]->bp_nota){
									unset($datas['fp1'][$i]);
								}
							}
						}
						$datas['fp1'] = array_values($datas['fp1']);
           				$data['fakturpembelian'] = $datas['fp1'];
					}
					else {
						$data['fakturpembelian'] = $datas['fp1'];
					}
				}
				else if($idjenisbayar == '13'){
					$datas['fp']  = DB::select("select * from bonsem_pengajuan, cabang where  bp_cabang = '$nosupplier' and bp_cabang = kode and bp_setujukeu = 'SETUJU' and bp_pencairan != 0.00 and bp_statusend = 'FPG'");

					$datas['fp1']  = DB::select("select * from bonsem_pengajuan, cabang where  bp_cabang = '$nosupplier' and bp_cabang = kode and bp_setujukeu = 'SETUJU' and bp_pencairan != 0.00 and bp_statusend = 'FPG'");

					if(count($request->arrnofaktur) != 0){
						for($i = 0 ; $i < count($datas['fp']); $i++){
							for($j = 0; $j < count($request->arrnofaktur); $j++){
								if($request->arrnofaktur[$j] == $datas['fp'][$i]->bp_nota){
									unset($datas['fp1'][$i]);
								}
							}
						}
						$datas['fp1'] = array_values($datas['fp1']);
           				$data['fakturpembelian'] = $datas['fp1'];
					}
					else {
						$data['fakturpembelian'] = $datas['fp1'];
					}
				}


			
		return json_encode($data);
				
	}

	public function updatefaktur(Request $request){
		return DB::transaction(function() use ($request) { 
		$tgl = $request->tgl;
		$countidpo = count($request->po_id);
	//	return $countidpo;
		$idpo = [];
		for($j = 0; $j < $countidpo; $j++){
			$poid = $request->po_id[$j];
			array_push($idpo,$poid);
		}

		$idpo = array_unique($idpo);
		

		//UPDATE FAKTUR HEADER
		$idfaktur = $request->idfaktur;
		$nofaktur = $request->nofaktur;

		//DATA FAKTUR
		//$jumlahtotal = $request->jumlahtotal_po;
		$jumlahtotal = str_replace(',', '', $request->jumlahtotal_po);
		$dpp = str_replace(',', '', $request->dpp_po);
		$netto = str_replace(',', '', $request->nettohutang_po);


		$datafp = DB::select("select * from faktur_pembelian where fp_nofaktur = '$nofaktur'");


		$datappn = $datafp[0]->fp_ppn;
		$datapph = $datafp[0]->fp_pph;
		$datadiskon = $datafp[0]->fp_discount;
		
		if($request->hasilpph_po != 0.00 ){
			$pph = str_replace(',', '', $request->hasilpph_po);
			$stringpph = explode(",", $request->jenispph_po);
			$jenispph = $stringpph[0];
			$nilaipph = $stringpph[1];

			$data['header4'] = DB::table('faktur_pembelian')
							->where('fp_idfaktur' , $idfaktur)
							->update([
								'fp_jenispph' => $jenispph,
								'fp_nilaipph' => $nilaipph,
								'fp_pph' => $pph,
							]);
		}
		else {
			$data['header4'] = DB::table('faktur_pembelian')
							->where('fp_idfaktur' , $idfaktur)
							->update([
								'fp_jenispph' => null,
								'fp_nilaipph' => null,
								'fp_pph' => null,
							]);
		}
		if($request->hasilppn_po != ''){		
			$hasilppn = str_replace(',', '', $request->hasilppn_po);
			$data['header3'] = DB::table('faktur_pembelian')
							->where('fp_idfaktur' , $idfaktur)
							->update([
								'fp_ppn' => $hasilppn,
								'fp_inputppn' => $request->inputppn_po,
								'fp_jenisppn' => $request->jenisppn_po,
							]);

			$data['fpm'] = DB::table('fakturpajakmasukan')
							->where('fpm_idfaktur' , $idfaktur)
							->update([
								'fpm_dpp' => $dpp,
								'fpm_netto' => $netto,
								'fpm_hasilppn' => $hasilppn,
								'fpm_inputppn' => $request->inputppn_po,
								'fpm_jenisppn' => $request->jenisppn_po,
							]);
		}
		else {
			$hasilppn = str_replace(',', '', $request->hasilppn_po);
			$data['header3'] = DB::table('faktur_pembelian')
							->where('fp_idfaktur' , $idfaktur)
							->update([
								'fp_ppn' => null,
								'fp_inputppn' => null,
								'fp_jenisppn' => null,
							]);

			
			DB::delete("DELETE from  fakturpajakmasukan  where fpm_idfaktur = '$idfaktur'");

		
		}
		if($request->disc_item_po != '' || $request->disc_item_po != 0){
			$hasildiskon_po = str_replace(',', '', $request->hasildiskon_po);
			$data['header2'] = DB::table('faktur_pembelian')
							->where('fp_idfaktur' , $idfaktur)
							->update([
								'fp_discount' => $request->disc_item_po,
								'fp_hsldiscount' => $hasildiskon_po,
								
							]);
		}

		$datafp = DB::select("select * from faktur_pembelian where fp_idfaktur = '$idfaktur'");
		$umfp = $datafp[0]->fp_uangmuka;
		$totaljumlah = str_replace(",", "", $request->totaljumlah);
	
		$data['header'] = DB::table('faktur_pembelian')
							->where('fp_idfaktur' , $idfaktur)
							->update([
								'fp_keterangan' => $request->keterangan,
								'fp_noinvoice' => $request->invoice,
								'fp_jumlah' => $jumlahtotal,
								'fp_dpp'	=> $dpp,
								'fp_netto' => $netto,
								'fp_sisapelunasan' => $netto,
								'fp_uangmuka' => $totaljumlah,
								'updated_by' => $request->username,
							]);

		//UPDATE TT
		$data_tt = explode(",", $request->datatandaterima);

		$datatt = DB::Select("select * from form_tt_d where ttd_faktur = '$nofaktur'");
		$ttd_id = $datatt[0]->ttd_id;
		$ttd_detail = $datatt[0]->ttd_detail;

		$update_tt =  DB::table('form_tt_d')
	                ->where([['ttd_id' , '='  , $ttd_id], ['ttd_detail' , '=' , $ttd_detail]])
	                ->update([
	                	'ttd_faktur' => null                                                           
		            ]);

   		$update_tt =  DB::table('form_tt_d')
	                ->where([['ttd_id' , '='  , $data_tt[0]], ['ttd_detail' , '=' , $data_tt[1]]])
	                ->update([
	                	'ttd_faktur' => $nofaktur                                     
		            ]);


		$idfaktur = $request->idfaktur;
		if($request->flag == 'PO'){
			$countiditem = count($request->kodeitem);
			
			for($j= 0; $j < count($idpo); $j++){ // MENGHITUNG PO

				$idpo2 = $idpo[$j];
				
				//return $idfaktur;
				$datafp['fp'] = DB::select("select * from faktur_pembeliandt where fpdt_idfp = '$idfaktur'");
				//return $datafp['fp'];
				
				//$idfaktur = $idpo[$j];
			//	return $idpo[$j];
				//UPDATE PB PO

				

				$iditem = $request->kodeitem[0];
				//return $idpo2;


				
			//	$idpo2 = 5;
				$dataitempo['po'] = DB::select("select * from faktur_pembeliandt where fpdt_idfp = '$idfaktur' and fpdt_idpo = '$idpo2' and fpdt_kodeitem = '$iditem'");
			//	return count($dataitempo['po']);
			
				//DELETE & UPDATE 
				if(count($dataitempo['po']) == 0){ // JIKA KOSONG, MAKA
					$idpodb = $datafp['fp'][0]->fpdt_idpo;
					DB::delete("DELETE from faktur_pembeliandt where fpdt_idfp = '$idfaktur' and fpdt_idpo = '$idpodb'");


					//UPDATE
					$data['header7'] = DB::table('penerimaan_barang')
					->where('pb_po' , $idpodb)
					->update([
						'pb_po' => null,
					]);	


					//UPDATE PO
					$data['header5'] = DB::table('pembelian_order')
					->where('po_idfaktur' , $idfaktur)
					->update([
						'po_idfaktur' => null,
						'po_updatefp' => 'T'
					]);	


					//ADD DATA DI FP
					$nofaktur = $request->nofaktur;
					$datafaktur = DB::select("select * from faktur_pembelian where fp_nofaktur = '$nofaktur'");
			//		return count($request->kode_item);

					for($o = 0; $o < count($request->kodeitem); $o++){
						
						$hargabarang = str_replace(',', '', $request->harga[$o]);									
						$diskon = $request->disc_item_po;
						$nominal = (float)$diskon / 100 * (float)$hargabarang;
						$hargajadi = (float)$hargabarang - (float)$nominal;
					
						$lastidfpdt = fakturpembeliandt::max('fpdt_id');

						if(isset($lastidfpdt)) {
							$idfakturdt = $lastidfpdt;
							$idfakturdt = (int)$idfakturdt + 1;
						}
						else {
							$idfakturdt = 1;
						}

						$idfp = $datafaktur[0]->fp_idfaktur;

						$harga = str_replace(',', '', $request->harga[$o]);
						$totalharga = str_replace(',', '', $request->totalharga[$o]);
			
						$fatkurpembeliandt2 = new fakturpembeliandt();
						$fatkurpembeliandt2->fpdt_id = $idfakturdt;
						$fatkurpembeliandt2->fpdt_idfp = $idfp;
						$fatkurpembeliandt2->fpdt_kodeitem = $request->kodeitem[$o];
						$fatkurpembeliandt2->fpdt_qty = $request->qty[$o];
						/*$fatkurpembeliandt->fpdt_gudang = $request->pb_gudang[$i];*/
						$fatkurpembeliandt2->fpdt_harga =  $hargajadi;

						$total = (float) $hargajadi * $request->qty[$o];

						$fatkurpembeliandt2->fpdt_totalharga =  $total;
						$fatkurpembeliandt2->fpdt_updatedstock =  $request->updatestock[$o];

						$iditem = $request->kodeitem[$o];
					//	return $iditem;
						$masteritem =DB::select("select * from masteritem where kode_item = '$iditem'");
						
						$acc_persediaan = $masteritem[0]->acc_persediaan;
					
						$fatkurpembeliandt2->fpdt_accbiaya = $acc_persediaan;
						if($request->flag == 'PO'){
							$fatkurpembeliandt2->fpdt_idpo = $request->idpo2;				
						}
						
						$fatkurpembeliandt2->save();
					} // END LOOPING ITEM ADD PO
				} // END DATA FP PO '0'
			} // END FOR LOOPING PO 
			
			//UPDATE DI TETEK BENGEK PO
			for($indxpo = 0 ; $indxpo < count($request->po_id); $indxpo++){	
					
					if($request->disc_item_po != ''){
						//update penerimaan barang
						$idpo_update = $request->po_id[$indxpo];
						$penerimaanbarang2 = DB::select("select * from penerimaan_barangdt where pbdt_po = '$idpo_update'");
						$adapb = count($penerimaanbarang2);

						if($adapb > 0) {
							for($po = 0; $po < count($request->kodeitem); $po++){
								$iditem_update = $request->kodeitem[$po];
								$penerimaanbarangheader = DB::select("select * from penerimaan_barangdt where pbdt_po = '$idpo_update' and pbdt_item = '$iditem_update'");
								$updatebrg = count($penerimaanbarangheader);

								if($updatebrg > 0){							
									$hargabarang = str_replace(',', '', $request->harga[$po]);									
									$diskon = $request->disc_item_po;
									$nominal = (float)$diskon / 100 * (float)$hargabarang;
									$hargajadi = (float)$hargabarang - (float)$nominal;

									$setuju_dt = DB::table('penerimaan_barangdt')
											->where([['pbdt_po',$idpo_update],['pbdt_item' , $iditem_update]])
											->update([
												'pbdt_hpp' => $hargajadi,											
											]);																									
										
								
								}

							}
						} // END UPDATE PENERIMAAN BARANG
					}
				} // END FOR UPDATE 
			} // END FLAG PO
			else{ // FLAG FP
				//return $request->grupitem[$j];
					$countiditem = count($request->item);
				
					$datafpall = DB::select("select * from faktur_pembelian, faktur_pembeliandt where fp_idfaktur = '$idfaktur' and fpdt_idfp =fp_idfaktur");
					$countfpall = count($datafpall);

					DB::delete("DELETE from faktur_pembeliandt where fpdt_idfp = '$idfaktur'");
					for($j = 0; $j < $countiditem; $j++){
						
						$lastidfpdt = fakturpembeliandt::max('fpdt_id');

						if(isset($lastidfpdt)) {
							$idfakturdt = $lastidfpdt;
							$idfakturdt = (int)$idfakturdt + 1;
						}
						else {
							$idfakturdt = 1;
						}

						$harga = str_replace(',', '', $request->harga[$j]);
						$totalharga = str_replace(',', '', $request->totalharga[$j]);
						$biaya = str_replace(',', '', $request->biaya[$j]);
						$nettoitem = str_replace(',', '', $request->nettoitem[$j]);

						$fatkurpembeliandt = new fakturpembeliandt();
						$fatkurpembeliandt->fpdt_id = $idfakturdt;
						$fatkurpembeliandt->fpdt_idfp = $idfaktur;
						$fatkurpembeliandt->fpdt_kodeitem = $request->item[$j];
						$fatkurpembeliandt->fpdt_qty = $request->qty[$j];
						$fatkurpembeliandt->fpdt_gudang =$request->gudang[$j];
						$fatkurpembeliandt->fpdt_harga =  $harga;
						$fatkurpembeliandt->fpdt_totalharga =  $totalharga;
						$fatkurpembeliandt->fpdt_updatedstock =  $request->updatestock[$j];
						$fatkurpembeliandt->fpdt_biaya = $biaya;  
						$fatkurpembeliandt->fpdt_accbiaya =  $request->acc_biaya[$j];
						$fatkurpembeliandt->fpdt_accpersediaan =  $request->acc_persediaan[$j];
						$fatkurpembeliandt->fpdt_groupitem =  $request->grupitem[$j];
						$fatkurpembeliandt->fpdt_keterangan =  $request->keteranganitem[$j];
						$fatkurpembeliandt->fpdt_netto =  $nettoitem;
					//	$fatkurpembeliandt->fpdt_groupitem =  $request->groupitem[$j];
						$fatkurpembeliandt->save();


						} // END FOR COUNT ITEM*/
					} // END FOR FP ALL


								$tipefp = $datafp[0]->fp_tipe;
								$datacomp2 = $request->cabang;

								if($tipefp == 'NS' || $tipefp == 'J'){
									$nofaktur = $request->nofaktur;
									DB::delete("DELETE from  d_jurnal where jr_ref = '$nofaktur' and jr_detail = 'FAKTUR PEMBELIAN'");
									$datajurnal = [];
									$totalhutang = 0;
								//	$datajurnalum = [];
									//$nettohutangpo = str_replace(',', '', $request->nettohutang_po);

									for($ja = 0; $ja < count($request->acc_biaya); $ja++){
										
										$totalharga = str_replace(',', '', $request->nettoitem[$ja]);
									//	return $totalharga;
										$datajurnal[$ja]['id_akun'] = $request->acc_biaya[$ja];
										$datajurnal[$ja]['subtotal'] = $totalharga;
										$datajurnal[$ja]['dk'] = 'D';
										$datajurnal[$ja]['detail'] = $request->keterangan;

										$totalhutang = floatval($totalhutang) + floatval($totalharga);
									}	
									
									if($request->hasilppn_po != ''){

										$hasilppn = str_replace(',', '', $request->hasilppn_po);
										$datakun2 = DB::select("select * from d_akun where id_akun LIKE '2302%' and kode_cabang = '$datacomp2'");
										if(count($datakun2) == 0){
											 $dataInfo=['status'=>'gagal','info'=>'Akun PPN Untuk Cabang Belum Tersedia'];
										    DB::rollback();
									            return json_encode($dataInfo);
										}
										else {
											$akunppn = $datakun2[0]->id_akun;
											$akundka = $datakun2[0]->akun_dka;

											//return $akunppn;
											if($akundka == 'K'){
												$dataakun = array (
												'id_akun' => $akunppn,
												'subtotal' => '-' . $hasilppn,
												'dk' => 'K',
												'detail' => $request->keterangan,
												);
											}
											else {
												$dataakun = array (
												'id_akun' => $akunppn,
												'subtotal' => $hasilppn,
												'dk' => 'D',
												'detail' => $request->keterangan,
												);
											}
											array_push($datajurnal,$dataakun);
											}
											
											$totalhutang = floatval($totalhutang) + floatval($hasilppn);
										}
										
										

								//	return $request->hasilpph_po;

									//akun PPH
									if($request->hasilpph_po != 0){
										//return 'ok';
										$hasilppn = str_replace(',', '', $request->hasilppn_po);
										$hasilpph = str_replace(',', '', $request->hasilpph_po);

										$pph = str_replace(',', '', $request->hasilpph_po);
										$stringpph = explode(",", $request->jenispph_po);
										$jenispph = $stringpph[0];
										$nilaipph = $stringpph[1];


											$datapph = DB::select("select * from pajak where id = '$jenispph'");
											$kodepajak2 = $datapph[0]->acc1;
											$kodepajak = substr($kodepajak2, 0,4);

											$datakun2 = DB::select("select * from d_akun where id_akun LIKE '$kodepajak%' and kode_cabang = '$datacomp2'");
											if(count($datakun2) == 0){
												$dataInfo=['status'=>'gagal','info'=>'Akun PPH Untuk Cabang Belum Tersedia'];
											    DB::rollback();
										            return json_encode($dataInfo);
											}
											else {
												$akunpph = $datakun2[0]->id_akun;
												$akundka = $datakun2[0]->akun_dka;

												if($akundka == 'D'){
													$dataakun = array (
													'id_akun' => $akunpph,
													'subtotal' => '-' . $hasilpph,
													'dk' => 'D',
													'detail' => $request->keterangan,
													);
												}
												else {
													$dataakun = array (
													'id_akun' => $akunpph,
													'subtotal' => $hasilpph,
													'dk' => 'K',
													'detail' => $request->keterangan,
													);
												}
												array_push($datajurnal, $dataakun );
											}

											$totalhutang = floatval($totalhutang) - floatval($hasilpph);
									}

									$dataakun = array (
										'id_akun' => $request->acchutang,
										'subtotal' => $totalhutang,
										'dk' => 'K',
										'detail' => $request->keterangan,
										);

									array_push($datajurnal, $dataakun );
									
									

									$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 
									if(isset($lastidjurnal)) {
										$idjurnal = $lastidjurnal;
										$idjurnal = (int)$idjurnal + 1;
									}
									else {
										$idjurnal = 1;
									}
									
									$jr_no = get_id_jurnal('MM' , $datacomp2 , $request->tgl);

									$year = date('Y');	
									$date = date('Y-m-d');
									$jurnal = new d_jurnal();
									$jurnal->jr_id = $idjurnal;
							        $jurnal->jr_year =Carbon::parse($request->tgl)->format('Y');
							        $jurnal->jr_date = $request->tgl;
							        $jurnal->jr_detail = 'FAKTUR PEMBELIAN';
							        $jurnal->jr_ref = $nofaktur;
							        $jurnal->jr_note = $request->keterangan;
							        $jurnal->jr_no = $jr_no;
							        $jurnal->save();
						       		
						    		$key  = 1;
						    		for($j = 0; $j < count($datajurnal); $j++){
						    			
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
						    			$jurnaldt->jrdt_acc = $datajurnal[$j]['id_akun'];
						    			$jurnaldt->jrdt_value = $datajurnal[$j]['subtotal'];
						    			$jurnaldt->jrdt_statusdk = $datajurnal[$j]['dk'];
						    			$jurnaldt->jrdt_detail = $datajurnal[$j]['detail'];
						    			$jurnaldt->save();
						    			$key++;
						    		}
						    		
						    		$cekjurnal = check_jurnal($nofaktur);
							    		if($cekjurnal == 0){
							    			$dataInfo =  $dataInfo=['status'=>'gagal','info'=>'Data Jurnal Tidak Balance :('];
											DB::rollback();
																        
							    		}
							    		elseif($cekjurnal == 1) {
							    			$dataInfo =  $dataInfo=['status'=>'sukses','info'=>'Data Jurnal Balance :)','message'=>$idfaktur];
												        
							    		}

											        
								}
								else { // jurnal FP PO
								$datajurnalpo = [];
								$nofaktur = $request->nofaktur;
								DB::delete("DELETE from  d_jurnal where jr_ref = '$nofaktur' and jr_detail = 'FAKTUR PEMBELIAN'");
								//akun PPN
								$datacomp2 = $request->cabang;
								if($request->hasilppn_po != '' && $request->hasilpph_po == 0){
									$hasilppn = str_replace(',', '', $request->hasilppn_po);
									$datakun2 = DB::select("select * from d_akun where id_akun LIKE '2302%' and kode_cabang = '$datacomp2'");
									if(count($datakun2) == 0){
										 $dataInfo=['status'=>'gagal','info'=>'Akun PPN Untuk Cabang Belum Tersedia'];
									    DB::rollback();
								            return json_encode($dataInfo);
									}
									else {
										$akunppn = $datakun2[0]->id_akun;
										$akundka = $datakun2[0]->akun_dka;

										if($akundka == 'K'){
											$dataakun = array (
											'id_akun' => $akunppn,
											'subtotal' => '-' . $hasilppn,
											'dk' => 'D',
											'detail' => $request->keterangan,
										);

										}
										else {
											$dataakun = array (
											'id_akun' => $akunppn,
											'subtotal' => $hasilppn,
											'dk' => 'D',
											'detail' => $request->keterangan
										);

										}
										array_push($datajurnalpo, $dataakun );
									}

									$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 

									//$totalhutangjr = floatval($hasilppn) - floatval($hasilpph);
									$acchutang = $request->acchutang;

										if(isset($lastidjurnal)) {
											$idjurnal = $lastidjurnal;
											$idjurnal = (int)$idjurnal + 1;
										}
										else {
											$idjurnal = 1;
										}
										$jr_no = get_id_jurnal('MM' , $datacomp2 , $request->tgl);
										$year = date('Y');	
										$date = date('Y-m-d');
										$jurnal = new d_jurnal();
										$jurnal->jr_id = $idjurnal;
								        $jurnal->jr_year = Carbon::parse($request->tgl)->format('Y');
								        $jurnal->jr_date = $request->tgl;
								        $jurnal->jr_detail = 'FAKTUR PEMBELIAN';
								        $jurnal->jr_ref = $nofaktur;
								        $jurnal->jr_note = $request->keterangan;
								        $jurnal->jr_no = $jr_no;
								        $jurnal->save();
							       		
								        
							       		$dataakun = array (
											'id_akun' => $acchutang,
											'subtotal' =>  $hasilppn,
											'dk' => 'K',
											'detail' => $request->keterangan,
										);

										array_push($datajurnalpo, $dataakun);
							    		$key  = 1;
							    		for($j = 0; $j < count($datajurnalpo); $j++){
							    			
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
							    			$jurnaldt->jrdt_acc = $datajurnalpo[$j]['id_akun'];
							    			$jurnaldt->jrdt_value = $datajurnalpo[$j]['subtotal'];
							    			$jurnaldt->jrdt_statusdk = $datajurnalpo[$j]['dk'];
							    			$jurnaldt->jrdt_detail = $datajurnalpo[$j]['detail'];
							    			$jurnaldt->save();
							    			$key++;
							    		}
								}

								if($request->hasilpph_po != 0 && $request->hasilppn_po == ''){
									$hasilppn = str_replace(',', '', $request->hasilppn_po);
									$hasilpph = str_replace(',', '', $request->hasilpph_po);

									$pph = str_replace(',', '', $request->hasilpph_po);
									$stringpph = explode(",", $request->jenispph_po);
									$jenispph = $stringpph[0];
									$nilaipph = $stringpph[1];

									$datapph = DB::select("select * from pajak where id = '$jenispph'");
									$kodepajak2 = $datapph[0]->acc1;
									$kodepajak = substr($kodepajak2, 0,4);

									$datakun2 = DB::select("select * from d_akun where id_akun LIKE '$kodepajak%' and kode_cabang = '$datacomp2'");
									if(count($datakun2) == 0){
										$dataInfo=['status'=>'gagal','info'=>'Akun PPH Untuk '.$datacomp2.' Belum Tersedia'];
									    DB::rollback();
								            return json_encode($dataInfo);
									}
									else {
										$akunpph = $datakun2[0]->id_akun;
										$akundka = $datakun2[0]->akun_dka;


										if($akundka == 'D'){
											$dataakun = array (
												'id_akun' => $akunpph,
												'subtotal' => '-' . $hasilpph,
												'dk' => 'K',
												'detail' => $request->keterangan,
											);
										}
										else {
											$dataakun = array (
												'id_akun' => $akunpph,
												'subtotal' => $hasilpph,
												'dk' => 'K',
												'detail' => $request->keterangan,
											);
										}

										array_push($datajurnalpo, $dataakun );
									}

									$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 

									//$totalhutangjr = floatval($hasilppn) - floatval($hasilpph);
									$acchutang = $request->acchutang;

										if(isset($lastidjurnal)) {
											$idjurnal = $lastidjurnal;
											$idjurnal = (int)$idjurnal + 1;
										}
										else {
											$idjurnal = 1;
										}
										$jr_no = get_id_jurnal('MM' , $datacomp2 , $request->tgl);
										$year = date('Y');	
										$date = date('Y-m-d');
										$jurnal = new d_jurnal();
										$jurnal->jr_id = $idjurnal;
								        $jurnal->jr_year = Carbon::parse($request->tgl)->format('Y');
								        $jurnal->jr_date = $request->tgl;
								        $jurnal->jr_detail = 'FAKTUR PEMBELIAN';
								        $jurnal->jr_ref = $nofaktur;
								        $jurnal->jr_note = $request->keterangan;
								        $jurnal->jr_no = $jr_no;
								        $jurnal->save();
							       		
								        
							       		$dataakun = array (
											'id_akun' => $acchutang,
											'subtotal' => '-' . $hasilpph,
											'dk' => 'K',
											'detail' => $request->keterangan,
										);

										array_push($datajurnalpo, $dataakun);
							    		$key  = 1;
							    		for($j = 0; $j < count($datajurnalpo); $j++){
							    			
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
							    			$jurnaldt->jrdt_acc = $datajurnalpo[$j]['id_akun'];
							    			$jurnaldt->jrdt_value = $datajurnalpo[$j]['subtotal'];
							    			$jurnaldt->jrdt_statusdk = $datajurnalpo[$j]['dk'];
							    			$jurnaldt->jrdt_detail = $datajurnalpo[$j]['detail'];
							    			$jurnaldt->save();
							    			$key++;
							    		}	
								}


								if($request->hasilpph_po != 0 && $request->hasilppn_po != ''){
									$hasilppn = str_replace(',', '', $request->hasilppn_po);
									$hasilpph = str_replace(',', '', $request->hasilpph_po);

									$pph = str_replace(',', '', $request->hasilpph_po);
									$stringpph = explode(",", $request->jenispph_po);
									$jenispph = $stringpph[0];
									$nilaipph = $stringpph[1];

									$datakun2 = DB::select("select * from d_akun where id_akun LIKE '2302%' and kode_cabang = '$datacomp2'");
									if(count($datakun2) == 0){
										 $dataInfo=['status'=>'gagal','info'=>'Akun PPN Untuk Cabang Belum Tersedia'];
									    DB::rollback();
								            return json_encode($dataInfo);
									}
									else {
										$akunppn = $datakun2[0]->id_akun;
										$akundka = $datakun2[0]->akun_dka;

										if($akundka == 'K'){
											$dataakun = array (
											'id_akun' => $akunppn,
											'subtotal' => '-' . $hasilppn,
											'dk' => 'D',
											'detail' => $request->keterangan,
										);

										}
										else {
											$dataakun = array (
											'id_akun' => $akunppn,
											'subtotal' => $hasilppn,
											'dk' => 'D',
											'detail' => $request->keterangan,
										);

										}
										array_push($datajurnalpo, $dataakun );
									}

									$datapph = DB::select("select * from pajak where id = '$jenispph'");
									$kodepajak2 = $datapph[0]->acc1;
									$kodepajak = substr($kodepajak2, 0,4);

									$datakun2 = DB::select("select * from d_akun where id_akun LIKE '$kodepajak%' and kode_cabang = '$datacomp2'");
									if(count($datakun2) == 0){
										$dataInfo=['status'=>'gagal','info'=>'Akun PPH Untuk '.$datacomp2.' Belum Tersedia'];
									    DB::rollback();
								            return json_encode($dataInfo);
									}
									else {
										$akunpph = $datakun2[0]->id_akun;
										$akundka = $datakun2[0]->akun_dka;


										if($akundka == 'D'){
											$dataakun = array (
												'id_akun' => $akunpph,
												'subtotal' => '-' . $hasilpph,
												'dk' => 'K',
												'detail' => $request->keterangan,
											);
										}
										else {
											$dataakun = array (
												'id_akun' => $akunpph,
												'subtotal' =>  $hasilpph,
												'dk' => 'K',
												'detail' => $request->keterangan,
											);
										}

										array_push($datajurnalpo, $dataakun );
									}

									$lastidjurnal = DB::table('d_jurnal')->max('jr_id'); 

									$totalhutangjr = floatval($hasilppn) - floatval($hasilpph);
									$acchutang = $request->acchutang;

										if(isset($lastidjurnal)) {
											$idjurnal = $lastidjurnal;
											$idjurnal = (int)$idjurnal + 1;
										}
										else {
											$idjurnal = 1;
										}
									
										$year = date('Y');	
										$date = date('Y-m-d');
										$jr_no = get_id_jurnal('MM' , $datacomp2 , $request->tgl);
										$jurnal = new d_jurnal();
										$jurnal->jr_id = $idjurnal;
								        $jurnal->jr_year = Carbon::parse($request->tgl)->format('Y');
								        $jurnal->jr_date = $request->tgl;
								        $jurnal->jr_detail = 'FAKTUR PEMBELIAN';
								        $jurnal->jr_ref = $nofaktur;
								        $jurnal->jr_note = $request->keterangan;
								        $jurnal->jr_no = $jr_no;
								        $jurnal->save();
							       		
								        
							       		$dataakun = array (
											'id_akun' => $acchutang,
											'subtotal' => $totalhutangjr,
											'dk' => 'K',
											'detail' => $request->keterangan,
										);

										array_push($datajurnalpo, $dataakun);
							    		$key  = 1;
							    		for($j = 0; $j < count($datajurnalpo); $j++){
							    			
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
							    			$jurnaldt->jrdt_acc = $datajurnalpo[$j]['id_akun'];
							    			$jurnaldt->jrdt_value = $datajurnalpo[$j]['subtotal'];
							    			$jurnaldt->jrdt_statusdk = $datajurnalpo[$j]['dk'];
							    			$jurnaldt->jrdt_detail = $datajurnalpo[$j]['detail'];
							    			$jurnaldt->save();
							    			$key++;
							    		}	

							    		$cekjurnal = check_jurnal($nofaktur);
							    		if($cekjurnal == 0){
							    			$dataInfo =  $dataInfo=['status'=>'gagal','info'=>'Data Jurnal Tidak Balance :('];
											DB::rollback();
																        
							    		}
							    		elseif($cekjurnal == 1) {
							    			$dataInfo =  $dataInfo=['status'=>'sukses','info'=>'Data Jurnal Balance :)','message'=>$idfaktur];
												        
							    		}

									}
								}
								
								//UPDATE UM
					    		if($request->totaljumlah != 0.00){
					    			DB::delete("DELETE from d_jurnal where jr_detail = 'UANG MUKA PEMBELIAN FP' and jr_ref = '$nofaktur'");

					    			$dataumfp = DB::select("select * from uangmukapembelian_fp where umfp_idfp = '$idfaktur'");
					    			if(count($dataumfp) == 0){
										$lastid =  DB::table('uangmukapembelian_fp')->max('umfp_id');;
										if(isset($lastid)) {
											$idumfp = $lastid;
											$idumfp = (int)$idumfp + 1;
										}
										else {
											$idumfp = 1;
										} 

										 $totaljumlah = str_replace(',', '', $request->totaljumlah);
										 $umfp = new uangmukapembelian_fp;
										 $umfp->umfp_id = $idumfp;
										 $umfp->umfp_totalbiaya = $totaljumlah;
										 $umfp->umfp_tgl 	= $request->tglitem;
										 $umfp->umfp_idfp = $idfaktur;
										 $umfp->created_by = $request->username;
										 $umfp->updated_by = $request->username;
										 $umfp->umfp_keterangan = $request->keteranganumheader;
										 $umfp->umfp_nofaktur = $nofaktur;
										 $umfp->save();
										
										   

										 for($i = 0 ; $i < count($request->dibayarum); $i++){
										 	
										 	$lastids =  DB::table('uangmukapembeliandt_fp')->max('umfpdt_id');;
											if(isset($lastids)) {
												$idumfpdt = $lastids;
												$idumfpdt = (int)$idumfpdt + 1;
											}
											else {
												$idumfpdt = 1;
											} 

											$jumlahum = str_replace(',', '', $request->jumlahum[$i]);
											$dibayarum = str_replace(',', '', $request->dibayarum[$i]);
											$umfpdt = new uangmukapembeliandt_fp;
										  	$umfpdt->umfpdt_id =  $idumfpdt;
										  	$umfpdt->umfpdt_idumfp = $idumfp;
										  	$umfpdt->umfpdt_transaksibank = $request->nokas[$i];
										  	$umfpdt->umfpdt_tgl = $request->tglum[$i];
										  	$umfpdt->umfpdt_jumlahum = $jumlahum;
										  	$umfpdt->umfpdt_dibayar = $dibayarum;
										  	$umfpdt->umfpdt_keterangan = $request->keteranganum[$i];
										  	$umfpdt->umfpdt_idfp = $idfaktur;
										  	$umfpdt->umfpdt_notaum = $request->notaum[$i];
										  	$umfpdt->umfpdt_acchutang = $request->akunhutangum[$i];
										  	$umfpdt->umfpdt_flag = $request->flagum[$i];
										  	$umfpdt->save();

										  	$notaum = $request->notaum[$i];
										  	$dataum = DB::select("select * from d_uangmuka where um_nomorbukti = '$notaum'");
										  	$sisaterpakai = $dataum[0]->um_sisaterpakai;
										  	$pelunasan = $dataum[0]->um_sisapelunasan;

										  	
										  	$hasilterpakai = floatval($sisaterpakai) - floatval($dibayarum);

										  	/*return $hasilterpakai;*/
										  
										  	//return $hasilsisapakai;
										  	 $updateum = DB::table('d_uangmuka')
							                ->where('um_nomorbukti' , $request->notaum[$i])
							                ->update([
							                	'um_sisaterpakai' => $hasilterpakai,                                                           
							                ]);


							                $notransaksi = $request->nokas[$i];
							                if($request->flagum[$i] == 'FPG'){

							                	$datafpg = DB::select("select * from fpg, fpg_dt where fpg_nofpg = '$notransaksi' and fpgdt_idfpg = idfpg");
							                	$idfpg = $datafpg[0]->idfpg;
							                	$sisaum = $datafpg[0]->fpgdt_sisapelunasanumfp;

							                	$hasilsisa = floatval($sisaum) - floatval($dibayarum);
							                	 $updateum = DB::table('fpg_dt')
								                ->where([['fpgdt_idfpg' , '='  , $idfpg], ['fpgdt_nofaktur' , '=' , $request->notaum[$i]]])
								                ->update([
								                	'fpgdt_sisapelunasanumfp' => $hasilsisa,                                                          
								                ]);
							                }
							                else {
							                	$databkk = DB::select("select * from bukti_kas_keluar where bkk_nota = '$notransaksi'");
							                	$idbkk = $databkk[0]->bkk_id;
							                	$sisaum = $datafpg[0]->bkkd_sisaum;

							                	$hasilsisa = floatval($sisaum) - floatval($dibayarum);
							                	 $updateum = DB::table('bukti_kas_keluar_detail')
								                ->where([['bkkd_bkk_id' , '='  , $idbkk], ['bkkd_ref' , '=' , $request->notaum[$i]]])
								                ->update([
								                	'bkkd_sisaum' => $hasilsisa,                                                           
								                ]);
							                }


							               /* $updateum DB::table('formfpg')
							                ->where('')*/

							                $akunhutangum = $request->akunhutangum[$i];
							               	$caridka = DB::select("select * from d_akun where id_akun = '$akunhutangum'");
							               	$dka = $caridka[0]->akun_dka;

							               	if($dka == 'D'){
							               		$datajurnalum[$i]['id_akun'] = $akunhutangum;
												$datajurnalum[$i]['subtotal'] = '-' . $dibayarum;
												$datajurnalum[$i]['dk'] = 'K';
												$datajurnalum[$i]['detail'] =  $request->keteranganum[$i];
							               	}
							               	else {
							               		$datajurnalum[$i]['id_akun'] = $akunhutangum;
												$datajurnalum[$i]['subtotal'] = $dibayarum;
												$datajurnalum[$i]['dk'] = 'K';	
												$datajurnalum[$i]['detail'] = $request->keteranganum[$i];
							               	}

										  }	


					    			} // end umfp = 0;
					    			else {
					    				for($keys = 0; $keys < count($request->nokas); $keys++){
										$jumlahum = str_replace(",", "", $request->jumlahum[$keys]);
										$dibayar = str_replace(",", "", $request->dibayarum[$keys]);

										$notransaksi = $request->nokas[$keys];
										$notaum = $request->notaum[$keys];
										$idumfp = $request->idumfp;
										$dataumfpdt = DB::select("select * from uangmukapembeliandt_fp where umfpdt_transaksibank = '$notransaksi' and umfpdt_notaum = '$notaum' and umfpdt_idumfp = '$idumfp'");
										$databayar = $dataumfpdt[0]->umfpdt_dibayar;

										$dataum = DB::select("select * from d_uangmuka where um_nomorbukti = '$notaum'");
										$sisaterpakai = $dataum[0]->um_sisaterpakai;

										$selisihsisapakai = floatval($sisaterpakai) + floatval($databayar);
									  	
									  	$hasilumpakai = floatval($selisihsisapakai) - floatval($dibayar);

									  	 $updateum = DB::table('d_uangmuka')
						                ->where('um_nomorbukti' , $request->notaum[$keys])
						                ->update([
						                	'um_sisaterpakai' => $hasilumpakai,                                                           
						                ]);
									  	
									
										if($request->flagum[$keys] == 'FPG'){
						                	$datafpg = DB::select("select * from fpg, fpg_dt where fpg_nofpg = '$notransaksi' and fpgdt_idfpg = idfpg");
											$sisaumfpg = $datafpg[0]->fpgdt_sisapelunasanumfp;
											$idfpg = $datafpg[0]->fpgdt_idfpg;
											$selisih = floatval($sisaumfpg) + floatval($databayar);
											$hasilselisih = floatval($selisih) - floatval($dibayar);



											$updateum = DB::table('fpg_dt')
								                ->where([['fpgdt_idfpg' , '='  , $idfpg], ['fpgdt_nofaktur' , '=' , $request->notaum[$keys]]])
								                ->update([
								                	'fpgdt_sisapelunasanumfp' => $hasilselisih,                                                           
								                ]);

										}
										else {

											$datafpg = DB::select("select * from bukti_kas_keluar, bukti_kas_keluar_detail where bkk_nota = '$notransaksi' and bkkd_bkk_id = bkk_id");
											$sisaumfpg = $datafpg[0]->bkkd_total;
											$idfpg = $datafpg[0]->bkkd_bkk_id;
											$selisih = floatval($sisaumfpg) + floatval($databayar);
											$hasilselisih = floatval($selisih) - floatval($dibayar);



											$updateum = DB::table('bukti_kas_keluar_detail')
								                ->where([['bkkd_bkk_id' , '='  , $idfpg], ['bkkd_ref' , '=' , $request->notaum[$keys]]])
								                ->update([
								                	'bkkd_sisaum' => $hasilselisih,                                                           
								                ]);

										}

										$akunhutangum = $request->akunhutangum[$keys];
						               	$caridka = DB::select("select * from d_akun where id_akun = '$akunhutangum'");
						               	$dka = $caridka[0]->akun_dka;

						               	if($dka == 'D'){
						               		$datajurnalum[$keys]['id_akun'] = $akunhutangum;
											$datajurnalum[$keys]['subtotal'] = '-' . $dibayar;
											$datajurnalum[$keys]['dk'] = 'K';
											$datajurnalum[$keys]['detail'] = $request->keteranganumheader;
						               	}
						               	else {
						               		$datajurnalum[$keys]['id_akun'] = $akunhutangum;
											$datajurnalum[$keys]['subtotal'] =  $dibayar;
											$datajurnalum[$keys]['dk'] = 'K';
											$datajurnalum[$keys]['detail'] = $request->keteranganumheader;
						               	}
									} // end for

										for($i = 0; $i < count($request->nokas); $i++){
											$dibayar = str_replace(",", "", $request->dibayarum[$i]);

							            	$data['header4'] = DB::table('uangmukapembeliandt_fp')
												->where([['umfpdt_idumfp' , '=' , $request->idumfp],['umfpdt_transaksibank' , '=' , $request->nokas[$i]]])
												->update([
													'umfpdt_transaksibank' => $request->nokas[$i],
													'umfpdt_tgl' => $request->tglum[$i],
													'umfpdt_jumlahum' => $jumlahum,
													'umfpdt_dibayar' => $dibayar,
													'umfpdt_notaum' => $request->notaum[$i],
													'umfpdt_acchutang' => $request->akunhutangum[$i],
													'umfpdt_flag' => $request->flagum[$i]
												]);
							            } // end for

							            $totaljumlah = str_replace(",", "", $request->totaljumlah);

							    		$data['header4'] = DB::table('uangmukapembelian_fp')
										->where('umfp_id' , $request->idumfp)
										->update([
											'umfp_totalbiaya' => $totaljumlah,
											'umfp_keterangan' => $request->keteranganumheader
										]);
					    			} // end else

					    			
						    		

						            	$hasilsisapelunasan = floatval($netto) - floatval($totaljumlah);
									    $updatesm = DB::table('faktur_pembelian')
						                ->where('fp_idfaktur' , $idfaktur)
						                ->update([
						                	'fp_uangmuka' => $totaljumlah,
						                    'fp_sisapelunasan' => $hasilsisapelunasan,                                        
						               	]);

						               	 //savejurnal
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
										$jr_no = get_id_jurnal('MM' , $datacomp2 , $request->tgl);
										$jurnal = new d_jurnal();
										$jurnal->jr_id = $idjurnal;
								        $jurnal->jr_year = Carbon::parse($request->tgl)->format('Y');
								        $jurnal->jr_date = $request->tgl;
								        $jurnal->jr_detail = 'UANG MUKA PEMBELIAN FP';
								        $jurnal->jr_ref = $nofaktur;
								        $jurnal->jr_note = $request->keteranganumheader;
								        $jurnal->jr_no = $jr_no;
								        $jurnal->save();
							       		
							       		$acchutangdagang = $request->acchutang;
								        $caridkaheader = DB::select("select * from d_akun where id_akun = '$acchutangdagang'");
								        $akundkaheader = $caridkaheader[0]->akun_dka;

							       		if($akundkaheader == 'D'){
							       			$dataakun_um = array (
											'id_akun' => $request->acchutang,
											'subtotal' =>  $totaljumlah,
											'dk' => 'D',
											'detail' => $request->keteranganumheader,
											);
							       		}
							       		else {
							       			$dataakun_um = array (
											'id_akun' => $request->acchutang,
											'subtotal' => '-' .$totaljumlah,
											'dk' => 'D',
											'detail' => $request->keteranganumheader,
											);	
							       		}
								        		
										array_push($datajurnalum, $dataakun_um);
							    		
							    		$key  = 1;
							    		for($j = 0; $j < count($datajurnalum); $j++){
							    			
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
							    			$jurnaldt->jrdt_acc = $datajurnalum[$j]['id_akun'];
							    			$jurnaldt->jrdt_value = $datajurnalum[$j]['subtotal'];
							    			$jurnaldt->jrdt_statusdk = $datajurnalum[$j]['dk'];
							    			$jurnaldt->jrdt_detail = $datajurnalum[$j]['detail'];
							    			$jurnaldt->save();
							    			$key++;

										}

										$cekjurnal = check_jurnal($nofaktur);
										if($cekjurnal == 0){
								    			$dataInfo =  $dataInfo=['status'=>'gagal','info'=>'Data Jurnal Tidak Balance :('];
												DB::rollback();
																	        
								    		}
								    		elseif($cekjurnal == 1) {
								    			$dataInfo =  $dataInfo=['status'=>'sukses','info'=>'Data Jurnal Balance :)','message'=>$idfaktur];
													        
								    		}
					    		}
					    		
					    		return json_encode($dataInfo);
								  	
/*
					                $notransaksi = $request->nokas[$i];
					                if($request->flagum == 'FPG'){
					                	for($i = 0; $i < count($request->nokas); $i++){
					                			
					                			$dataumfpdt = DB::select("select * from uangmukapembeliandt_fp where umfpdt_transaksibank = '$notransaksi' and umfpdt_notaum = '$notaum' and umfpdt_idumfp = '$idumfp'");
												$dibayar = $dataumfpdt[0]->umfpdt_dibayar;

					                			$datafpg = DB::select("select * from fpg, fpg_dt where fpg_nofpg = '$notransaksi' and fpgdt_idfpg = idfpg");
							                	$idfpg = $datafpg[0]->idfpg;
							                	$sisaum = $datafpg[0]->;

							                	$hasilsisa = floatval($sisaum) - floatval($dibayar);

							                	 $updateum = DB::table('fpg_dt')
								                ->where([['fpgdt_idfpg' , '='  , $idfpg], ['fpgdt_nofaktur' , '=' , $request->notaum[$i]]])
								                ->update([
								                	'fpgdt_sisapelunasanumfp' => $hasilsisa,                                                           
								                ]);
					                	}
					                }
					                else {
					                	$databkk = DB::select("select * from bukti_kas_keluar where bkk_nota = '$notransaksi'");
					                	$idbkk = $databkk[0]->bkk_id;
					                	$sisaum = $datafpg[0]->bkkd_sisaum;

					                	$hasilsisa = floatval($sisaum) - floatval($dibayarum);
					                	 $updateum = DB::table('bukti_kas_keluar_detail')
						                ->where([['bkkd_bkk_id' , '='  , $idbkk], ['bkkd_ref' , '=' , $request->notaum[$i]]])
						                ->update([
						                	'bkkd_sisaum' => $hasilsisa,                                                           
						                ]);
					                }*/


		
	});
	}


	

	public function getum(Request $request){
		$idsup = $request->idsup;
		$explode = explode("+" , $idsup);
		$nosupplier = $explode[4];
		$cabang = $request->cabang;

	/*	$nosupplier = 'SP/EM/000008';
		$cabang = '000';*/

		/*$fpg =  DB::table('fpg')
				 ->join('fpg_cekbank','fpgb_idfpg','=','idfpg')
				 ->join('d_uangmuka','um_supplier','=','fpg_agen')
				 ->select('fpg_nofpg','fpg_agen', 'fpg_tgl' , 'fpg_acchutang', 'idfpg' , 'fpgb_nominal' , 'fpg_keterangan' , 'um_sisaterpakai' , 'um_nomorbukti')
				 ->where('fpgb_posting','DONE')
				 ->where('fpg_cabang' , $cabang)
				 ->where('fpg_agen' , $nosupplier)
				 ->get();

		$bk = DB::table('bukti_kas_keluar')
				 ->join('d_uangmuka','um_supplier','=','bkk_supplier')
				 ->select('bkk_nota','bkk_supplier', 'bkk_tgl', 'bkk_akun_hutang', 'bkk_id', 'bkk_total', 'bkk_keterangan' , 'um_sisaterpakai' , 'um_nomorbukti')
				 ->where('bkk_supplier' , $nosupplier)
				 ->where('bkk_comp' , $cabang)
				 ->get();



		$datas['um'] = array_merge($fpg, $bk);
		$datas['um1'] = array_merge($fpg, $bk);


		return json_encode($fpg);*/

		$datas['um'] = DB::select("select fpg_flag as flag, fpg_nofpg as nota, idfpg as idtransaksi, fpg_tgl as tgl, fpg_keterangan as keterangan, fpg_agen as supplier, fpg_totalbayar as totalbayar , fpgdt_sisapelunasanumfp as sisaterpakai, um_nomorbukti as no_um from fpg, d_uangmuka, fpg_dt where fpg_agen = '$nosupplier' and fpg_agen = um_supplier and fpg_posting = 'DONE' and fpgdt_idfpg = idfpg  and fpgdt_idfp = um_id and um_comp = '$cabang' union select bkk_flag as flag,  bkk_nota as nota, bkk_id as idtransaksi, bkk_tgl as tgl, bkk_keterangan as keterangan , bkk_supplier as supplier , bkk_total as totalbayar , bkkd_sisaum as sisaterpakai, um_nomorbukti as no_um  from bukti_kas_keluar, bukti_kas_keluar_detail, d_uangmuka where bkk_supplier = '$nosupplier' and bkk_supplier = um_supplier and bkkd_bkk_id = bkk_id   and bkkd_ref = um_supplier and um_comp = '$cabang'  ");

		$datas['um1'] = DB::select("select fpg_flag as flag, fpg_nofpg as nota, idfpg as idtransaksi, fpg_tgl as tgl, fpg_keterangan as keterangan, fpg_agen as supplier, fpg_totalbayar as totalbayar , fpgdt_sisapelunasanumfp as sisaterpakai, um_nomorbukti as no_um from fpg, d_uangmuka, fpg_dt where fpg_agen = '$nosupplier' and fpg_agen = um_supplier and fpg_posting = 'DONE' and fpgdt_idfpg = idfpg  and fpgdt_idfp = um_id and  um_comp = '$cabang' union select bkk_flag as flag, bkk_nota as nota, bkk_id as idtransaksi, bkk_tgl as tgl, bkk_keterangan as keterangan , bkk_supplier as supplier , bkk_total as totalbayar , bkkd_sisaum as sisaterpakai , um_nomorbukti as no_um from bukti_kas_keluar, bukti_kas_keluar_detail, d_uangmuka where bkk_supplier = '$nosupplier' and bkk_supplier = um_supplier and bkkd_bkk_id = bkk_id   and bkkd_ref = um_supplier and um_comp = '$cabang'  ");

		if(count($request->arrnoum) != 0){
			for($i = 0 ; $i < count($datas['um']); $i++){
				for($j = 0; $j < count($request->arrnoum); $j++){
					//	return $request->arrnoum[$j] . $datas['um'][$i]->nota;
					if($request->arrnoum[$j] == $datas['um'][$i]->nota){
						
						unset($datas['um1'][$i]);
					}
				}
			}
			$datas['um1'] = array_values($datas['um1']);
				$data['um'] = $datas['um1'];
				//return $datas['um1'];
		}
		else {
			$data['um'] = $datas['um1'];
		}


		return json_encode($data);

	}

	public function hasilum(Request $request){
		$id = $request->id;
		$data['um'] = DB::select("select fpg_flag as flag, fpg_nofpg as nota, um_nomorbukti as nota_um, idfpg as idtransaksi, fpg_tgl as tgl, fpg_keterangan as keterangan, fpg_agen as supplier, fpg_totalbayar as totalbayar , fpgdt_sisapelunasanumfp as sisaterpakai, fpg_acchutang as acchutang from fpg, fpg_dt, d_uangmuka where idfpg = '$id' and fpg_agen = um_supplier and fpg_posting = 'DONE' and fpg_jenisbayar = '4' and fpgdt_idfpg = idfpg and fpgdt_idfp = um_id union select bkk_flag as flag, bkk_nota as nota, um_nomorbukti as nota_um, bkk_id as idtransaksi, bkk_tgl as tgl, bkk_keterangan as keterangan , bkk_supplier as supplier , bkk_total as totalbayar , bkkd_sisaum as sisaterpakai, bkk_akun_hutang as acchutang from bukti_kas_keluar, d_uangmuka, bukti_kas_keluar_detail where bkk_id = '$id' and bkk_supplier = um_supplier and bkk_jenisbayar = '4' and bkkd_bkk_id = bkk_id and bkkd_ref = um_supplier");

		return json_encode($data);

	}

	public function hapusfakturpembelian($id){
		$data['faktur'] = DB::select("select * from faktur_pembelian where fp_idfaktur = '$id'");
		$flag = $data['faktur'][0]->fp_tipe;
		$nofaktur = $data['faktur'][0]->fp_nofaktur;
		if($flag == 'PO'){
			
				$data['ambilpo'] = DB::select("select * from faktur_pembelian, faktur_pembeliandt where fpdt_idfp = fp_idfaktur and fp_idfaktur = '$id'");
				$countambilpo = count($data['ambilpo']);
				for($i = 0; $i < $countambilpo; $i++){
					$idpbpo = $data['ambilpo'][$i]->fpdt_idpo;
						//UPDATE
					//return json_encode($idpbpo);
						$data['header7'] = DB::table('penerimaan_barang')
						->where('pb_po' , $idpbpo)
						->update([
							'pb_terfaktur' => null,
							'pb_timeterfaktur' => null,
						]);	

						//UPDATE PO
						$data['header5'] = DB::table('pembelian_order')
						->where([['po_idfaktur' , '=', $id] ,['po_id' , '=' , $idpbpo]])
						->update([
							'po_idfaktur' => null,
							'po_updatefp' => 'T'
						]);						
				}
				DB::delete("DELETE from d_jurnal where jr_detail = 'FAKTUR PEMBELIAN' and jr_ref = '$nofaktur'");						

				$deletefp = DB::table('fakturpajakmasukan')->where('fpm_idfaktur' , '=' , $id)->delete();
		
				$deletefp3 = DB::table('faktur_pembelian')->where('fp_idfaktur' , '=' , $id)->delete();
				$datatt = DB::Select("select * from form_tt_d where ttd_faktur = '$nofaktur'");
				$ttd_id = $datatt[0]->ttd_id;
				$ttd_detail = $datatt[0]->ttd_detail;

				$update_tt =  DB::table('form_tt_d')
			                ->where([['ttd_id' , '='  , $ttd_id], ['ttd_detail' , '=' , $ttd_detail]])
			                ->update([
			                	'ttd_faktur' => null                                                           
				            ]);
		}
		else {	
				$flag = $data['faktur'][0]->fp_tipe;
				if($flag != 'J') {				
					$deletefp = DB::table('fakturpajakmasukan')->where('fpm_idfaktur' , '=' , $id)->delete();
					$deletefp = DB::table('faktur_pembelian')->where('fp_idfaktur' , '=' , $id)->delete();	
					$datatt = DB::Select("select * from form_tt_d where ttd_faktur = '$nofaktur'");
					$ttd_id = $datatt[0]->ttd_id;
					$ttd_detail = $datatt[0]->ttd_detail;

					$update_tt =  DB::table('form_tt_d')
				                ->where([['ttd_id' , '='  , $ttd_id], ['ttd_detail' , '=' , $ttd_detail]])
				                ->update([
				                	'ttd_faktur' => null                                                           
					            ]);		
					$deletebt = 	DB::delete("DELETE from barang_terima where bt_idtransaksi = '$id' and bt_flag = 'FP'");
					$dataum = $data['faktur'][0]->fp_uangmuka;
					if($dataum != null){

						$dataumfp = DB::select("select * from uangmukapembelian_fp, uangmukapembeliandt_fp where umfp_nofaktur = '$nofaktur' and umfpdt_idumfp = umfp_id");
						for($n = 0 ; $n < count($dataumfp); $n++){
							$notaum = $dataumfp[$n]->umfpdt_notaum;
							$databayar = $dataumfp[$n]->umfpdt_dibayar;
							$notransaksi = $dataumfp[$n]->umfpdt_transaksibank;

							$dataum = DB::select("select * from d_uangmuka where um_nomorbukti = '$notaum'");
							$sisaterpakai = $dataum[0]->um_sisaterpakai;

							$selisihsisapakai = floatval($sisaterpakai) + floatval($databayar);
						  	$flag = $dataumfp[$n]->umfpdt_flag;
						 
						  	 $updateum = DB::table('d_uangmuka')
			                ->where('um_nomorbukti' , $notaum)
			                ->update([
			                	'um_sisaterpakai' => $selisihsisapakai,                                                           
			                ]);
						  	
						
							if($flag == 'FPG'){
			                	$datafpg = DB::select("select * from fpg, fpg_dt where fpg_nofpg = '$notransaksi' and fpgdt_idfpg = idfpg");
								$sisaumfpg = $datafpg[0]->fpgdt_sisapelunasanumfp;
								$idfpg = $datafpg[0]->fpgdt_idfpg;
								$selisih = floatval($sisaumfpg) + floatval($databayar);
							



								$updateum = DB::table('fpg_dt')
					                ->where([['fpgdt_idfpg' , '='  , $idfpg], ['fpgdt_nofaktur' , '=' , $notaum]])
					                ->update([
					                	'fpgdt_sisapelunasanumfp' => $selisih,                                                           
					                ]);

							}
							else {

								$datafpg = DB::select("select * from bukti_kas_keluar, bukti_kas_keluar_detail where bkk_nota = '$notransaksi' and bkkd_bkk_id = bkk_id");
								$sisaumfpg = $datafpg[0]->bkkd_total;
								$idfpg = $datafpg[0]->bkkd_bkk_id;
								$selisih = floatval($sisaumfpg) + floatval($databayar);
							


								$updateum = DB::table('bukti_kas_keluar_detail')
					                ->where([['bkkd_bkk_id' , '='  , $idfpg], ['bkkd_ref' , '=' , $notaum]])
					                ->update([
					                	'bkkd_sisaum' => $selisih,                                                           
					                ]);

							}


						}


						$deleteumfp = DB::delete("DELETE from uangmukapembelian_fp where umfp_nofaktur = '$nofaktur'");
						//DB::delete("DELETE from d_jurnal where umfp_nofaktur = '$nofaktur'");
					    DB::delete("DELETE from d_jurnal where jr_detail = 'UANG MUKA PEMBELIAN FP' and jr_ref = '$nofaktur'");


					}

					$tipestock = $data['faktur'][0]->fp_tipe;
					if($tipestock == 'NS'){
					    DB::delete("DELETE from d_jurnal where jr_detail = 'FAKTUR PEMBELIAN' and jr_ref = '$nofaktur'");						
					}
				}
				else {
					$deletefp = DB::table('fakturpajakmasukan')->where('fpm_idfaktur' , '=' , $id)->delete();
					$deletefp = DB::table('faktur_pembelian')->where('fp_idfaktur' , '=' , $id)->delete();
					$deleteumfp = DB::delete("DELETE from uangmukapembelian_fp where umfp_nofaktur = '$nofaktur'");
					DB::delete("DELETE from d_jurnal where jr_detail = 'FAKTUR PEMBELIAN' and jr_ref = '$nofaktur'");		

					$datatt = DB::Select("select * from form_tt_d where ttd_faktur = '$nofaktur'");
					$ttd_id = $datatt[0]->ttd_id;
					$ttd_detail = $datatt[0]->ttd_detail;

					$update_tt =  DB::table('form_tt_d')
				                ->where([['ttd_id' , '='  , $ttd_id], ['ttd_detail' , '=' , $ttd_detail]])
				                ->update([
				                	'ttd_faktur' => null                                                           
					            ]);				

				}

				
		}

		return json_encode('1');
	}

	public function updatestockbrgfp(Request $request){
		$idsup = $request->idsup;
		$updatestock = $request->updatestock;
		$groupitem = $request->groupitem;
		$grup = DB::select("select * from jenis_item where kode_jenisitem ='$groupitem'");
		$cabang = $request->cabang;
		//return $grup;
		$stock = $grup[0]->stock;
		$data['stock'] = $stock;


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

	public function getfaktur(Request $request){

		$idfp = $request->idfp;
		$nofaktur2 = $request->nofaktur;
		$jenisbayar = $request->jenisbayar;
		if($jenisbayar == '2' ){
			$idfp = $request->idfp;
			for($i = 0; $i < count($idfp); $i++){
				$idfp1 = $idfp[$i];		
				$nofaktur = $request->nofaktur2[$i];

				$data['faktur'][] = DB::select("select * from faktur_pembelian, form_tt, form_tt_d where fp_idfaktur = '$idfp1' and tt_idform = ttd_id and ttd_faktur = fp_nofaktur ");
				$data['pembayaran'][] = DB::select("select fpg_nofpg as nofpg, fpg_tgl as tgl, fpgdt_pelunasan as pelunasan, fp_nofaktur as nofaktur, fp_idfaktur as idfp from fpg,fpg_dt, faktur_pembelian where fpgdt_idfp ='$idfp1' and fpgdt_idfpg = idfpg and fpgdt_idfp = fp_idfaktur and fpgdt_nofaktur = fp_nofaktur union select bkk_nota as nofpg, bkk_tgl as tgl, bkkd_total as pelunasan, bkkd_ref as nofaktur, fp_idfaktur as idfp from bukti_kas_keluar, bukti_kas_keluar_detail, faktur_pembelian where bkkd_bkk_id = bkk_id and bkkd_ref = '$nofaktur' and bkkd_ref = fp_nofaktur");

				$data['cndn'][] = DB::select("select * from cndnpembelian, cndnpembelian_dt, faktur_pembelian where cndt_idcn = cndn_id  and cndt_idfp = fp_idfaktur and cndt_idfp = '$idfp1' and cndt_idfp = fp_idfaktur");

				$data['uangmuka'] = DB::select("select * from uangmukapembelian_fp, uangmukapembeliandt_fp, d_uangmuka, faktur_pembelian where umfpdt_idumfp = umfp_id and umfp_idfp = '$idfp1' and umfpdt_idfp = umfp_idfp  and umfp_idfp = fp_idfaktur and umfpdt_notaum = um_nomorbukti");

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

			$data['jeniscndn'] = array();
			for($zs = 0; $zs < count($data['cndn']); $zs++){
				for($xj = 0; $xj < count($data['cndn'][$zs]); $xj++){
					$jeniscndn = $data['cndn'][$zs][$xj]->cndn_jeniscndn;
					array_push($data['jeniscndn'] , $jeniscndn);
				}
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

				$data['cndn'][] = DB::select("select * from cndnpembelian, cndnpembelian_dt, faktur_pembelian where cndt_idcn = cndn_id  and cndt_idfp = fp_idfaktur and cndt_idfp = '$idfp1'");
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
				$nofaktur = $request->nofaktur[$i];

				$data['faktur'][] = DB::select("select * from d_uangmuka where um_id = '$idfp1'");
				$data['pembayaran'][] = DB::select("select fpg_nofpg as nofpg, fpg_tgl as tgl, fpgdt_pelunasan as pelunasan, um_nomorbukti as nofaktur, um_id as idfp from fpg,fpg_dt, d_uangmuka where fpgdt_idfp ='$idfp1' and fpgdt_idfpg = idfpg and fpgdt_idfp = um_id and fpgdt_nofaktur = um_nomorbukti union select bkk_nota as nofpg, bkk_tgl as tgl, bkkd_total as pelunasan, bkkd_ref as nofaktur, um_id as idfp from bukti_kas_keluar, bukti_kas_keluar_detail, d_uangmuka where bkkd_bkk_id = bkk_id and bkkd_ref = '$nofaktur' and bkkd_ref = um_nomorbukti");
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
				$data['pembayaran'][] = DB::select("select fpg_nofpg as nofpg, fpg_tgl as tgl, fpgdt_pelunasan as pelunasan, ik_nota as nofaktur, ik_id as idfp from fpg,fpg_dt, ikhtisar_kas where fpgdt_idfp ='$idfp1' and fpgdt_idfpg = idfpg and fpgdt_idfp = ik_id and fpgdt_nofaktur = ik_nota union select bkk_nota as nofpg, bkk_tgl as tgl, bkkd_total as pelunasan, bkkd_ref as nofaktur, ik_id as idfp from bukti_kas_keluar, bukti_kas_keluar_detail, ikhtisar_kas where bkkd_bkk_id = bkk_id and bkkd_ref = '$nofaktur' and bkkd_ref = ik_nota");
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
		else if($jenisbayar == '11'){
			$idfp = $request->idfp;
			for($i = 0; $i < count($idfp); $i++){
				$idfp1 = $idfp[$i];		
				$nofaktur = $request->nofaktur2[$i];

				$data['faktur'][] = DB::select("select * from bonsem_pengajuan where bp_id = '$idfp1'");
				$data['pembayaran'][] = DB::select("select fpg_nofpg as nofpg, fpg_tgl as tgl, fpgdt_pelunasan as pelunasan, bp_nota as nofaktur, bp_id as idfp from fpg,fpg_dt, bonsem_pengajuan where fpgdt_idfp ='$idfp1' and fpgdt_idfpg = idfpg and fpgdt_idfp = bp_id and fpgdt_nofaktur = bp_nota union select bkk_nota as nofpg, bkk_tgl as tgl, bkkd_total as pelunasan, bkkd_ref as nofaktur, bp_id as idfp from bukti_kas_keluar, bukti_kas_keluar_detail, bonsem_pengajuan where bkkd_bkk_id = bkk_id and bkkd_ref = '$nofaktur' and bkkd_ref = bp_nota");
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
		else if($jenisbayar == '13'){
			$idfp = $request->idfp;
			for($i = 0; $i < count($idfp); $i++){
				$idfp1 = $idfp[$i];		
				$nofaktur = $request->nofaktur2[$i];

				$data['faktur'][] = DB::select("select * from bonsem_pengajuan where bp_id = '$idfp1'");
				/*$data['pembayaran'][] = DB::select("select fpg_nofpg as nofpg, fpg_tgl as tgl, fpgdt_pelunasan as pelunasan, bp_nota as nofaktur, bp_id as idfp from fpg,fpg_dt, bonsem_pengajuan where fpgdt_idfp ='$idfp1' and fpgdt_idfpg = idfpg and fpgdt_idfp = bp_id and fpgdt_nofaktur = bp_nota union select bkk_nota as nofpg, bkk_tgl as tgl, bkkd_total as pelunasan, bkkd_ref as nofaktur, bp_id as idfp from bukti_kas_keluar, bukti_kas_keluar_detail, bonsem_pengajuan where bkkd_bkk_id = bkk_id and bkkd_ref = '$nofaktur' and bkkd_ref = bp_nota");*/
			}

			$data['pembayaran'][0] = 0;
			/*$data['perhitunganfaktur'] = array();
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
			}*/
		}

		return json_encode($data);
	}


	public function getkodeakun(Request $request){
		$id= $request->id;
		$data['table'] = DB::select("select * from masterbank,masterbank_dt where mbdt_idmb = mb_id and mb_id = '$id' order by mbdt_tglstatus desc ");

		return json_encode($data);
	}


	public function getakunbg(Request $request){
		$mbid = $request->idmb;

		for($i = 0; $i < count($mbid); $i++){
			$mbid2 = $mbid[$i];		
			$data['mbdt'][] = DB::select("select * from masterbank,masterbank_dt where mbdt_idmb = mb_id and mbdt_id = '$mbid2'");

		}
		return json_encode($data);
	}

	public function getjenisbayar(Request $request){
		$idjenis = $request->idjenis;

		if($idjenis == '2'){ // SUPPLIER HUTANG DAGANG
			$data['isi'] = DB::select("select * from supplier where status = 'SETUJU' and active = 'AKTIF' ");
		}
		elseif($idjenis == '6'){ //BIAYA AGEN / VENDOR

			$agen 	  = DB::select("SELECT kode, nama from agen where kategori != 'OUTLET' order by kode");

			$vendor   = DB::select("SELECT kode, nama from vendor order by kode "); 

			$data['isi'] = array_merge($agen,$vendor);

		}
		elseif($idjenis == '7'){ // OUTLET
			$data['isi'] = DB::select("SELECT kode, nama from agen where kategori = 'OUTLET' or kategori = 'AGEN DAN OUTLET' order by kode ASC");

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
		elseif($idjenis == '1' || $idjenis == '11' || $idjenis == '13'){
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
				$data['fpg'] = DB::select("select *, cabang.kode as kodecabang , cabang.nama as namacabang from fpg,supplier, masterbank, jenisbayar, cabang where idfpg = '$id' and fpg_agen = no_supplier and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpg_cabang = cabang.kode and active = 'AKTIF' and status = 'SETUJU'");
			}
			else if($jenissup == 'agen'){
				$data['fpg'] = DB::select("select *, cabang.kode as kodecabang, agen.kode as kodesupplier , cabang.nama as namacabang, agen.nama as namasupplier from fpg,agen, masterbank, jenisbayar, cabang where idfpg = '$id' and fpg_agen = agen.kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpg_cabang = cabang.kode");	
			}
			else if($jenissup == 'subcon'){
				$data['fpg'] = DB::select("select * , cabang.kode as kodecabang, agen.kode as kodesupplier , cabang.nama as namacabang, agen.nama as namasupplier  from fpg,subcon, masterbank, jenisbayar, cabang where idfpg = '$id' and fpg_agen = agen.kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id  and fpg_cabang = cabang.kode");	
			}
			

		}
		else if($jenisbayar == '2'){
			$data['fpg'] = DB::select("select *, cabang.kode as kodecabang , cabang.nama as namacabang from fpg,supplier, masterbank, jenisbayar, cabang where idfpg = '$id' and fpg_supplier = idsup and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpg_cabang = cabang.kode");	
		}
		else if($jenisbayar == '6' || $jenisbayar == '7'){
			$data['fpg'] = DB::select("select *,  cabang.kode as kodecabang, agen.kode as kodesupplier , cabang.nama as namacabang, agen.nama as namasupplier  from fpg,agen, masterbank, jenisbayar, cabang where idfpg = '$id' and fpg_agen = agen.kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpg_cabang = cabang.kode");	
		}

		else if($jenisbayar == '9'){
			$data['fpg'] = DB::select("select *, cabang.kode as kodecabang, agen.kode as kodesupplier , cabang.nama as namacabang, agen.nama as namasupplier  from fpg,subcon, masterbank, jenisbayar, cabang where idfpg = '$id' and fpg_agen = kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpg_cabang = cabang.kode");	
		}
		else if($jenisbayar == '1'){
			$data['fpg'] = DB::select("select *, fpg_agen as kodesupplier, cabang.kode as kodecabang , cabang.nama as namacabang, cabang.nama as namasupplier  from fpg,cabang, masterbank, jenisbayar where idfpg = '$id'  and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpg_cabang = cabang.kode");
		}
		else if($jenisbayar == '3'){
			$data['fpg'] = DB::select("select *, cabang.kode as kodecabang, supplier.no_supplier as kodesupplier , cabang.nama as namacabang, supplier.nama_supplier as namasupplier from fpg, masterbank, jenisbayar, supplier, cabang where  idfpg = '$id' and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpg_cabang = cabang.kode and fpg_agen = no_supplier ");
			/*$data['fpg'] = DB::select("select *, cabang.kode as kodecabang, agen.kode as kodesupplier , cabang.nama as namacabang, agen.nama as namasupplier  from fpg,cabang, masterbank, jenisbayar where idfpg = '$id' and fpg_agen = agen.kode and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpg_cabang = cabang.kode");*/
		}
		else if($jenisbayar == '5'){
			$data['fpg'] = DB::select("select *, cabang.kode as kodecabang, cabang.nama as namacabang  from fpg,cabang, masterbank, jenisbayar where idfpg = '$id' and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpg_cabang = cabang.kode");
		}
		else if($jenisbayar == '11'){
			$data['fpg'] = DB::select("select *, cabang.kode as kodecabang, cabang.nama as kodesupplier , cabang.nama as namacabang, cabang.nama as namasupplier from fpg, masterbank, jenisbayar, cabang where  idfpg = '$id' and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpg_cabang = cabang.kode and fpg_agen = cabang.kode ");
		}
		else if($jenisbayar == '12'){
			$data['fpg'] = DB::select("select *, cabang.kode as kodecabang, cabang.nama as kodesupplier, cabang.nama as namacabang, cabang.nama as namasupplier from fpg, masterbank, jenisbayar, cabang where idfpg = '$id' and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpg_cabang = cabang.kode");
		}
		else if($jenisbayar == '13'){
			$data['fpg'] = DB::select("select *, cabang.kode as kodecabang, cabang.nama as kodesupplier, cabang.nama as namacabang, cabang.nama as namasupplier from fpg, masterbank, jenisbayar, cabang where idfpg = '$id' and fpg_jenisbayar = idjenisbayar and fpg_idbank = mb_id and fpg_cabang = cabang.kode and fpg_agen = cabang.kode");
		}
		//dd($data['fpg']);	
		$jenisbayar = $data['fpg'][0]->fpg_jenisbayar;
		//dd($data['fpg']);
		if($jenisbayar == '2' || $jenisbayar == '6' || $jenisbayar == '7' || $jenisbayar == '9' ) {


		$data['fpgd'] = DB::select("select * from  fpg_dt, fpg , faktur_pembelian where idfpg = '$id' and fpgdt_idfpg = idfpg and fpgdt_idfp = fp_idfaktur");

		for($i = 0 ; $i < count($data['fpgd']); $i++){
			$idfp = $data['fpgd'][$i]->fpgdt_idfp;
			$nofaktur = $data['fpgd'][$i]->fp_nofaktur;

			$data['pembayaran'][] = DB::select("select fpg_nofpg as nofpg, fpg_tgl as tgl, fpgdt_pelunasan as pelunasan, fp_nofaktur as nofaktur, fp_idfaktur as idfp from fpg,fpg_dt, faktur_pembelian where fpgdt_idfp ='$idfp' and fpgdt_idfpg = idfpg and fpgdt_idfp = fp_idfaktur and fpgdt_nofaktur = fp_nofaktur union select bkk_nota as nofpg, bkk_tgl as tgl, bkkd_total as pelunasan, bkkd_ref as nofaktur, fp_idfaktur as idfp from bukti_kas_keluar, bukti_kas_keluar_detail, faktur_pembelian where bkkd_bkk_id = bkk_id and bkkd_ref = '$nofaktur' and bkkd_ref = fp_nofaktur");

			$data['cndn'][] = DB::select("select * from cndnpembelian, cndnpembelian_dt, faktur_pembelian where cndt_idcn = cndn_id  and cndt_idfp = fp_idfaktur and cndt_idfp = '$idfp'");

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

				$data['pembayaran'][] = DB::select("select fpg_nofpg as nofpg, fpg_tgl as tgl, fpgdt_pelunasan as pelunasan, um_nomorbukti as nofaktur, um_id as idfp from fpg,fpg_dt, d_uangmuka where fpgdt_idfp ='$idfp1' and fpgdt_idfpg = idfpg and fpgdt_idfp = um_id and fpgdt_nofaktur = um_nomorbukti union select bkk_nota as nofpg, bkk_tgl as tgl, bkkd_total as pelunasan, bkkd_ref as nofaktur, um_id as idfp from bukti_kas_keluar, bukti_kas_keluar_detail, d_uangmuka where bkkd_bkk_id = bkk_id and bkkd_ref = '$nofaktur' and bkkd_ref = um_nomorbukti");
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
		else if($jenisbayar == 11){
			$data['fpgd'] = DB::select("select * from  fpg_dt, fpg , bonsem_pengajuan where idfpg = '$id' and fpgdt_idfpg = idfpg and fpgdt_idfp = bp_id");

			for($i = 0 ; $i < count($data['fpgd']); $i++){
				$idfp1 = $data['fpgd'][$i]->fpgdt_idfp;
				$nofaktur = $data['fpgd'][$i]->bp_nota;

				$data['pembayaran'][] = DB::select("select fpg_nofpg as nofpg, fpg_tgl as tgl, fpgdt_pelunasan as pelunasan, bp_nota as nofaktur, bp_id as idfp from fpg,fpg_dt, bonsem_pengajuan where fpgdt_idfp ='$idfp1' and fpgdt_idfpg = idfpg and fpgdt_idfp = bp_id and fpgdt_nofaktur = bp_nota union select bkk_nota as nofpg, bkk_tgl as tgl, bkkd_total as pelunasan, bkkd_ref as nofaktur, bp_id as idfp from bukti_kas_keluar, bukti_kas_keluar_detail, bonsem_pengajuan where bkkd_bkk_id = bkk_id and bkkd_ref = '$nofaktur' and bkkd_ref = bp_nota");

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
		else if($jenisbayar == 13){
			$data['fpgd'] = DB::select("select * from  fpg_dt, fpg , bonsem_pengajuan where idfpg = '$id' and fpgdt_idfpg = idfpg and fpgdt_idfp = bp_id and fpg_jenisbayar = '13'");

			for($i = 0 ; $i < count($data['fpgd']); $i++){
				$idfp1 = $data['fpgd'][$i]->fpgdt_idfp;
				$nofaktur = $data['fpgd'][$i]->bp_nota;

				$data['pembayaran'][] = DB::select("select fpg_nofpg as nofpg, fpg_tgl as tgl, fpgdt_pelunasan as pelunasan, bp_nota as nofaktur, bp_id as idfp from fpg,fpg_dt, bonsem_pengajuan where fpgdt_idfp ='$idfp1' and fpgdt_idfpg = idfpg and fpgdt_idfp = bp_id and fpgdt_nofaktur = bp_nota and fpg_jenisbayar = '13' union select bkk_nota as nofpg, bkk_tgl as tgl, bkkd_total as pelunasan, bkkd_ref as nofaktur, bp_id as idfp from bukti_kas_keluar, bukti_kas_keluar_detail, bonsem_pengajuan where bkkd_bkk_id = bkk_id and bkkd_ref = '$nofaktur' and bkkd_ref = bp_nota");

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
		
		else {

			$data['fpg_bank'] = DB::select("select * from  fpg_cekbank, fpg, masterbank  where idfpg = '$id' and fpgb_idfpg = idfpg and fpgb_kodebank = mb_id");
			$data['bank'] = DB::select("select * from masterbank");
			$data['supplier'] = DB::select("select * from supplier");
		}
		
	//	dd($data);
		return view('purchase/formfpg/detail', compact('data'));
	}


	public function saveformfpg(Request $request){

		return DB::transaction(function() use ($request) {  
			$jenisbayar = $request->jenisbayar;
			$time = Carbon::now();
			//	$idbank = $request->idbank;
				$formfpg = new formfpg();

				$explode = explode("+", $request->selectOutlet);
				$idbank = $explode[0];
				$kodebank = $explode[4];
				//	dd($nosppid);

				$cabang = $request->cabang;
				$lastid =  formfpg::max('idfpg');;
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
			
				$formfpg->fpg_cekbg = $cekbg;
				$formfpg->fpg_nofpg = $request->nofpg;
				$formfpg->fpg_keterangan = strtoupper($request->keterangan);


				if($request->jenisbayar == 5 || $request->jenisbayar == 12) {
					//$formfpg->fpg_orang = $request->keterangantransfer;
					$formfpg->fpg_keterangan = strtoupper($request->keterangantransfer);

				}
				else if($request->jenisbayar == 2) {
					$explode = explode(",", $request->kodebayar);

					$kodesupplier = $explode[0];
					$datasupplier = DB::select("select * from supplier where idsup = '$kodesupplier'");
					$formfpg->fpg_supplier = $kodesupplier;
					$formfpg->fpg_agen = $datasupplier[0]->no_supplier;
				}
				else if($request->jenisbayar == 6 || $request->jenisbayar== 7 || $request->jenisbayar == 9 || $request->jenisbayar == 4 || $request->jenisbayar == 3 ){
					
					$explode = explode(",", $request->kodebayar);

					$kodesupplier = $explode[1];
					$formfpg->fpg_agen = $kodesupplier;
				}
				else {
					$formfpg->fpg_agen = $cabang;					
				}
				
				$formfpg->fpg_cabang = $cabang;

				//KODE BANKchan
				
				$formfpg->fpg_idbank = $idbank; 

				if($request->jenisbayar == 12 || $request->jenisbayar == 11){
					$formfpg->fpg_acchutang = $request->hutangdagang;
				
				}
				else {
					$formfpg->fpg_acchutang = $request->hutangdagang;
				}

				if($request->hutangbank != ''){
					$formfpg->fpg_accbg = $request->hutangbank;
				}

				if($request->hutangum != ''){
					$formfpg->fpg_accum = $request->hutangum;
				}
				$formfpg->fpg_kodebank = $kodebank;
				$formfpg->fpg_posting = 'NOT';
				$formfpg->create_by = $request->username;
				$formfpg->update_by = $request->username;
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
					$formfpg_dt->fpgdt_sisapelunasanumfp = $pelunasan;
					$formfpg_dt->save();

					
					if($request->jenisbayar == 2 || $request->jenisbayar == 7 || $request->jenisbayar == 6  || $request->jenisbayar == 9) {
						$updatefaktur = fakturpembelian::where('fp_nofaktur', '=', $request->nofaktur[$i]);
						$updatefaktur->update([
						 	'fp_sisapelunasan' => $sisafaktur,
						 	'fp_status' => 'APPROVED',
						 	'fp_edit' => 'UNALLOWED',
					 	]);	

						$idfaktur = $request->idfaktur[$i];
					 	$updatecndn = cndn_dt::where('cndt_idfp' ,  '=' , $idfaktur);
						$updatecndn->update([
							'cndt_statusfpg' => 'YES',
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
						 	'ik_status' => 'DONE',	
					 	]);	

					}
					else if($request->jenisbayar == 4){	
						$nofaktur = $request->nofaktur[$i];
						$dataum = DB::select("select * from d_uangmuka where um_nomorbukti = '$nofaktur'");
						$sisaterpakai = $dataum[0]->um_sisaterpakai;

						if($sisaterpakai == null){
							$temp = 0; 
							$sisaterpakai2 = $temp + $pelunasan;
						}
						else {
							$sisaterpakai2 = floatval($sisaterpakai) + floatval($pelunasan); 
						}

						$updateum = DB::table('d_uangmuka')
						->where('um_nomorbukti', $request->nofaktur[$i])
						->update([
							'um_sisapelunasan' => $sisafaktur,
							'um_sisaterpakai' => $sisaterpakai2,
						]);	
					}
					else if($request->jenisbayar == 11){

						$nofaktur = $request->nofaktur[$i];
						$databonsem = DB::select("select * from bonsem_pengajuan where bp_nota = '$nofaktur'");

						$pencairan = $databonsem[0]->bp_pencairan;

						if($pencairan == null){
							$temp = 0; 
							$pencairan2 = $temp + $pelunasan;
						}
						else {
							$pencairan2 = floatval($pencairan) + floatval($pelunasan); 
						}

						$updatebp = DB::table('bonsem_pengajuan')
						->where('bp_nota', $request->nofaktur[$i])
						->update([
							'bp_pelunasan' => $sisafaktur,
							'bp_pencairan' => $pencairan2,
						]);	
					}
					else if($request->jenisbayar == 13){
						$nofaktur = $request->nofaktur[$i];
						$databonsem = DB::select("select * from bonsem_pengajuan where bp_nota = '$nofaktur'");

						$pencairan = $databonsem[0]->bp_pencairan;

						if($pencairan == null){
							$temp = 0; 
							$pencairan2 = $temp + $pelunasan;
						}
						else {
							$pencairan2 = floatval($pencairan) + floatval($pelunasan); 
						}

						/*$updatebp = DB::table('bonsem_pengajuan')
						->where('bp_nota', $request->nofaktur[$i])
						->update([
							'bp_pencairan' => $pencairan2,
						]);	*/
					}
				}
			}
				if($request->jenisbayarbank == 'INTERNET BANKING') {
					if($request->jenisbayar == '12' || $request->jenisbayar == '11'){
						for($j=0; $j < count($request->kodebanktujuan); $j++){
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
								$formfpg_bank->fpgb_nominal = $nominalbank;
								$formfpg_bank->fpgb_cair = 'IYA';
								$formfpg_bank->fpgb_setuju = 'SETUJU';



								$formfpg_bank->fpgb_nocheckbg = null;
								$formfpg_bank->fpgb_norektujuan = $request->tujuannorekbank[$j];
								$formfpg_bank->fpgb_nmrekeningtujuan = $request->tujuannamabank[$j];
								$formfpg_bank->fpgb_banktujuan = $request->idbanktujuan[$j];
								$formfpg_bank->fpgb_nmbanktujuan = $request->namabanktujuan[$j];
								$formfpg_bank->fpgb_kodebanktujuan = $request->kodebanktujuan[$j];
								$formfpg_bank->fpgb_jeniskelompok = $request->kelompokbank[$j];
								$formfpg_bank->save();
							

							
								//	return 'yesy';
										if($request->kelompokbank[$j] == 'SAMA BANK'){
											$bankmasuk = new bank_masuk();
	
											$lastid_bm = bank_masuk::max('bm_id');
											if(isset($lastid_bm)){
												$idbm = $lastid_bm;
												$idbm = (int)$idbm + 1;
											}
											else {
												$idbm = 1;
											}
		
											$bankasal = DB::select("select * from masterbank where mb_kode = '$kodebank'");
											$cabangasal = $bankasal[0]->mb_cabangbank;
											$namaasal = $bankasal[0]->mb_nama;
											
											$kodetujuan = $request->kodebanktujuan[$j];
											$banktujuan = DB::select("select * from masterbank where mb_kode = '$kodetujuan'");
											$cabangtujuan = $banktujuan[0]->mb_cabangbank;
											$namatujuan = $banktujuan[0]->mb_nama;
		
											$bankmasuk->bm_id = $idbm;
											$bankmasuk->bm_bankasal = $kodebank;
											$bankmasuk->bm_cabangasal = $cabangasal;
											$bankmasuk->bm_cabangtujuan = $cabangtujuan;
											$bankmasuk->bm_banktujuan = $kodetujuan;
											$bankmasuk->bm_status = 'DIKIRIM';
											$bankmasuk->created_by = $request->username;
											$bankmasuk->updated_by = $request->username;
											$bankmasuk->bm_notatransaksi = $request->nofpg;
											$bankmasuk->bm_transaksi = $request->noseri[$j];
											$bankmasuk->bm_jenisbayar = $request->jenisbayarbank;
											$bankmasuk->bm_idfpgb = $idfpg_bank;
											$bankmasuk->bm_nominal = $nominalbank;
											$bankmasuk->bm_keterangan = $request->keterangantransfer;
											$bankmasuk->bm_namabankasal = $namaasal;
											$bankmasuk->bm_namabanktujuan = $namatujuan;
											$bankmasuk->bm_bankasaljurnal = '109911000';

											$bankmasuk->save();
										}
										else if($request->kelompokbank[$j] == 'BEDA BANK'){
										$bankmasuk = new bank_masuk();
	
										$lastid_bm = bank_masuk::max('bm_id');
										if(isset($lastid_bm)){
											$idbm = $lastid_bm;
											$idbm = (int)$idbm + 1;
										}
										else {
											$idbm = 1;
										}
										
										$akunkasbank = '109911000';
										$bankasal = DB::select("select * from masterbank where mb_kode = '$kodebank'");
										$cabangasal = $bankasal[0]->mb_cabangbank;
										$namaasal = $bankasal[0]->mb_nama;
										$kodetujuan = $request->kodebanktujuan[$j];
										$banktujuan = DB::select("select * from masterbank where mb_kode = '$kodetujuan'");
										$cabangtujuan = $banktujuan[0]->mb_cabangbank;
										$namatujuan = $banktujuan[0]->mb_nama;

										$bankmasuk->bm_id = $idbm;
										$bankmasuk->bm_bankasal = $kodebank;
										$bankmasuk->bm_cabangasal = $cabangasal;
										$bankmasuk->bm_cabangtujuan = $cabangtujuan;
										$bankmasuk->bm_banktujuan = $kodetujuan;
										$bankmasuk->bm_status = 'DIKIRIM';
										$bankmasuk->created_by = $request->username;
										$bankmasuk->updated_by = $request->username;
										$bankmasuk->bm_notatransaksi = $request->nofpg;
										$bankmasuk->bm_transaksi = $request->noseri[$j];
										$bankmasuk->bm_jenisbayar = $request->jenisbayarbank;
										$bankmasuk->bm_idfpgb = $idfpg_bank;
										$bankmasuk->bm_nominal = $nominalbank;
										$bankmasuk->bm_keterangan = $request->keterangantransfer;
										$bankmasuk->bm_namabankasal = $namaasal;
										$bankmasuk->bm_namabanktujuan = $namatujuan;
										$bankmasuk->bm_bankasaljurnal = $akunkasbank;
										$bankmasuk->save();
									}
									else if($request->kelompokbank[$j] == 'KAS'){
										$lastidkm =  DB::table('kas_masuk')->max('km_id');
										if(isset($lastidkm)) {
												$idkm = $lastidkm;
												$idkm = (int)$idkm + 1;
										}
										else {
												$idkm = 1;
										} 

										$kastujuan = $request->kodebanktujuan[$j];
										$datacabangterima = DB::select("select * from d_akun where id_akun = '$kastujuan'");

									 $datakm = array(
					                    'km_id' => strtoupper($idkm),
					                    'km_cabangterima' => $datacabangterima[0]->kode_cabang,
					                    'km_idtransaksi' => $idfpg,
					                    'km_notatransaksi' => $request->nofpg,
					                    'created_by' => $request->username,
					                    'updated_by' => $request->username,
					                    'km_nominal' => $nominalbank,
					                    'km_keterangan'=> strtoupper($request->keterangantransfer),
					                    'km_status' => 'DIKIRIM',
					                    'km_idfpgb' => $idfpg_bank,

				               			 );
					                $simpan = DB::table('kas_masuk')->insert($datakm);
								}		
						} // end for
					} // $jenisbayar
					else {
						
							$formfpg_bank = new formfpg_bank();
							$lastidfpg_bank =  formfpg_bank::max('fpgb_id');;
							if(isset($lastidfpg_bank)) {
									$idfpg_bank = $lastidfpg_bank;
									$idfpg_bank = (int)$idfpg_bank + 1;
							}
							else {
									$idfpg_bank = 1;
							} 

							$nominalbank =  str_replace(',', '', $request->nominalbank);

							$formfpg_bank->fpgb_idfpg = $idfpg;
							$formfpg_bank->fpgb_id = $idfpg_bank;
							$formfpg_bank->fpgb_kodebank = $idbank;
							$formfpg_bank->fpgb_jenisbayarbank = $request->jenisbayarbank;
							$formfpg_bank->fpgb_nominal = $nominalbank;
							$formfpg_bank->fpgb_cair = 'IYA';
							$formfpg_bank->fpgb_setuju = 'SETUJU';
							$formfpg_bank->save();
						
					}

				}
				else {
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


					if($request->jenisbayarbank == 'TF'){
						$formfpg_bank->fpgb_norekening = $request->norekening;
						$formfpg_bank->fpgb_norekening = $request->namabank;

					}
					if($request->jenisbayar == '12' || $request->jenisbayar == '11'){

							$formfpg_bank->fpgb_nocheckbg = $request->noseri[$j];
							$formfpg_bank->fpgb_norektujuan = $request->tujuannorekbank[$j];
							$formfpg_bank->fpgb_nmrekeningtujuan = $request->tujuannamabank[$j];
							$formfpg_bank->fpgb_banktujuan = $request->idbanktujuan[$j];
							$formfpg_bank->fpgb_nmbanktujuan = $request->namabanktujuan[$j];
							$formfpg_bank->fpgb_kodebanktujuan = $request->kodebanktujuan[$j];
							$formfpg_bank->fpgb_jeniskelompok = $request->kelompokbank[$j];



								
								//	return 'yesy';
									if($request->kelompokbank[$j] == 'SAMA BANK'){
										$bankmasuk = new bank_masuk();

										$lastid_bm = bank_masuk::max('bm_id');
										if(isset($lastid_bm)){
											$idbm = $lastid_bm;
											$idbm = (int)$idbm + 1;
										}
										else {
											$idbm = 1;
										}

										$bankasal = DB::select("select * from masterbank where mb_kode = '$kodebank'");
										
										$cabangasal = $bankasal[0]->mb_cabangbank;

										$kodetujuan = $request->kodebanktujuan[$j];
										$namaasal = $bankasal[0]->mb_nama;
										$banktujuan = DB::select("select * from masterbank where mb_kode = '$kodetujuan'");
										$cabangtujuan = $banktujuan[0]->mb_cabangbank;
										$namatujuan = $banktujuan[0]->mb_nama;
										$akunkasbank = '109911000';

										$bankmasuk->bm_id = $idbm;
										$bankmasuk->bm_bankasal = $kodebank;
										$bankmasuk->bm_cabangasal = $cabangasal;
										$bankmasuk->bm_cabangtujuan = $cabangtujuan;
										$bankmasuk->bm_banktujuan = $kodetujuan;
										$bankmasuk->bm_status = 'DIKIRIM';
										$bankmasuk->created_by = $request->username;
										$bankmasuk->updated_by = $request->username;
										$bankmasuk->bm_notatransaksi = $request->nofpg;
										$bankmasuk->bm_transaksi = $request->noseri[$j];
										$bankmasuk->bm_jenisbayar = $request->jenisbayarbank;
										$bankmasuk->bm_idfpgb = $idfpg_bank;
										$bankmasuk->bm_nominal = $nominalbank;
										$bankmasuk->bm_keterangan = $request->keterangantransfer;
										$bankmasuk->bm_namabankasal = $namaasal;
										$bankmasuk->bm_namabanktujuan = $namatujuan;
										$bankmasuk->bm_bankasaljurnal = '109911000';
										
										$bankmasuk->save();
									}
									else if($request->kelompokbank[$j] == 'BEDA BANK') {
										$bankmasuk = new bank_masuk();

										$lastid_bm = bank_masuk::max('bm_id');
										if(isset($lastid_bm)){
											$idbm = $lastid_bm;
											$idbm = (int)$idbm + 1;
										}
										else {
											$idbm = 1;
										}

										$bankasal = DB::select("select * from masterbank where mb_kode = '$kodebank'");
										$cabangasal = $bankasal[0]->mb_cabangbank;
										$namasal = $bankasal[0]->mb_nama;
										$kodetujuan = $request->kodebanktujuan[$j];
										$banktujuan = DB::select("select * from masterbank where mb_kode = '$kodetujuan'");
										$cabangtujuan = $banktujuan[0]->mb_cabangbank;
										$namatujuan = $banktujuan[0]->mb_nama;
										$akunkasbank = '109911000';


										$bankmasuk->bm_id = $idbm;
										$bankmasuk->bm_bankasal = $akunkasbank;
										$bankmasuk->bm_cabangasal = $cabangasal;
										$bankmasuk->bm_cabangtujuan = $cabangtujuan;
										$bankmasuk->bm_banktujuan = $kodetujuan;
										$bankmasuk->bm_status = 'DIKIRIM';
										$bankmasuk->created_by = $request->username;
										$bankmasuk->updated_by = $request->username;
										$bankmasuk->bm_notatransaksi = $request->nofpg;
										$bankmasuk->bm_transaksi = $request->noseri[$j];
										$bankmasuk->bm_jenisbayar = $request->jenisbayarbank;
										$bankmasuk->bm_idfpgb = $idfpg_bank;
										$bankmasuk->bm_nominal = $nominalbank;
										$bankmasuk->bm_keterangan = $request->keterangantransfer;
										$bankmasuk->bm_namabankasal = $namasal;
										$bankmasuk->bm_namabanktujuan = $namatujuan;
										$bankmasuk->bm_bankasaljurnal = '109911000';
										$bankmasuk->save();
									}
									else if($request->kelompokbank[$j] == 'KAS'){
										$lastidkm =  DB::table('kas_masuk')->max('km_id');
										if(isset($lastidkm)) {
												$idkm = $lastidkm;
												$idkm = (int)$idkm + 1;
										}
										else {
												$idkm = 1;
										} 

										$kastujuan = $request->kodebanktujuan[$j];
										$datacabangterima = DB::select("select * from d_akun where id_akun = '$kastujuan'");

										 $datakm = array(
						                    'km_id' => strtoupper($idkm),
						                    'km_cabangterima' => $datacabangterima[0]->kode_cabang,
						                    'km_idtransaksi' => $idfpg,
						                    'km_notatransaksi' => $request->nofpg,
						                    'created_by' => $request->username,
						                    'updated_by' => $request->username,
						                    'km_nominal' => $nominalbank,
						                    'km_keterangan'=> strtoupper($request->keterangantransfer),
						                    'km_status' => 'DIKIRIM',
						                    'km_idfpgb' => $idfpg_bank,
				               			 );
					               		 $simpan = DB::table('kas_masuk')->insert($datakm);
									}
												
					}
					else {
						$formfpg_bank->fpgb_nocheckbg = $request->noseri[$j];
					}

					if($request->jenisbayar != 7){
						$formfpg_bank->fpgb_jatuhtempo = $request->jatuhtempo[0];
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
				}


				if($request->jenisbayar == '1'){
						$lastidkm =  DB::table('kas_masuk')->max('km_id');
						if(isset($lastidkm)) {
								$idkm = $lastidkm;
								$idkm = (int)$idkm + 1;
						}
						else {
								$idkm = 1;
						} 

					 $datakm = array(
	                    'km_id' => strtoupper($idkm),
	                    'km_cabangterima' => $cabang,
	                    'km_idtransaksi' => $idfpg,
	                    'km_notatransaksi' => $request->nofpg,
	                    'created_by' => $request->username,
	                    'updated_by' => $request->username,
	                    'km_nominal' => $totalbayar,
	                    'km_keterangan'=> strtoupper($request->keterangan),
	                    'km_status' => 'DIKIRIM',
               			 );
	                $simpan = DB::table('kas_masuk')->insert($datakm);
				}


				for($key = 0; $key < count($request->notafaktur); $key++){
					$nominalfaktur = str_replace("," , "" , $request->nominalfaktur[$key]);
					if($request->jenistransaksi == '12'){

						$updatikhtisar = ikhtisar_kas::where('ik_nota' , '=' , $request->notafaktur[$key]);
						$updatikhtisar->update([
						 	'ik_pelunasan' => 0.00,
						 	'ik_status' => 'DONE',	 	
					 	]);	
					 }
					 else if($request->jenistransaksi == '11'){					 	
					 	$updatikhtisar = bonsempengajuan::where('bp_nota' , '=' , $request->notafaktur[$key]);
						$updatikhtisar->update([
						 	'bp_pelunasan' => 0.00,
						 	'bp_pencairan' => $nominalfaktur,	 	
					 	]);
					 }

						$lastidfpg =  formfpg_dt::max('fpgdt_id');;
						if(isset($lastidfpg)) {
								$idfpg_dt = $lastidfpg;
								$idfpg_dt = (int)$idfpg_dt + 1;
						}
						else {
								$idfpg_dt = 1;
						} 

						$nominalfaktur = str_replace("," , "" , $request->nominalfaktur[$key]);

						$formfpg_dt = new formfpg_dt();
						$formfpg_dt->fpgdt_idfpg = $idfpg;
						$formfpg_dt->fpgdt_id = $idfpg_dt;
						$formfpg_dt->fpgdt_tgl = $request->tglfpg;
						$formfpg_dt->fpgdt_jumlahtotal = $nominalfaktur;
						$formfpg_dt->fpgdt_pelunasan = $nominalfaktur;
						$formfpg_dt->fpgdt_sisafaktur = 0.00;
						$formfpg_dt->fpgdt_idfp = $request->idfaktur[$key];
						$formfpg_dt->fpgdt_keterangan = $request->keterangantransfer;
						$formfpg_dt->fpgdt_nofaktur = $request->notafaktur[$key];
						$formfpg_dt->save();
					
				}

				$data['isfpg'] = DB::select("select * from fpg where idfpg = '$idfpg'");
			return json_encode($data);
		});		
	}


	public function getfpg(){
		$nofpg = $request->nofpg;
		$data['isfpg'] = DB::select("select * from fpg where fpg_nofpg = '$nofpg'");
		return json_encode($data);
	}

	public function updateformfpg(Request $request){
		return DB::transaction(function() use ($request) {  
		$time = Carbon::now();
		$idfpg = $request->idfpg;
		$totalbayar =  str_replace(',', '', $request->totalbayar);
		$cekbg =  str_replace(',', '', $request->cekbg);
		$updatefpg = formfpg::where('idfpg', '=', $request->idfpg);
		$updatefpg->update([
			'fpg_totalbayar' => $totalbayar,
			'fpg_cekbg' => $cekbg,
			'update_by' => $request->username,
			'fpg_keterangan' => $request->keterangan,
			]);	

			//deletenofaktur		
			$cari = DB::table('fpg_dt')
  				  ->where('fpgdt_idfpg' , $idfpg)
                  ->get();
           

            for($k = 0 ; $k < count($cari); $k++){
            $idfpgdt = $cari[$k]->fpgdt_id;
            $pelunasan = $cari[$k]->fpgdt_pelunasan;
            $idfp = $cari[$k]->fpgdt_idfp;
            
			$jenisbayar = $request->jenisbayar;
			if($jenisbayar == '2' || $jenisbayar == '6' || $jenisbayar == '7' || $jenisbayar == '9'){
			
				$pelunasan2 = str_replace(',', '', $pelunasan);
				

				$deletefpgdt = DB::table('fpg_dt')->where('fpgdt_id' , '=' , $idfpgdt)->delete();
				$datafaktur = DB::select("select * from faktur_pembelian where fp_idfaktur = '$idfp'");
				$fp_pelunasan = $datafaktur[0]->fp_sisapelunasan;

				$penjumlahan = (float)$fp_pelunasan + (float)$pelunasan2;
				$updatefaktur = fakturpembelian::where('fp_idfaktur', '=' , $idfp);
						$updatefaktur->update([
							'fp_sisapelunasan' => $penjumlahan,
							'fp_edit' => 'ALLOWED',
						]);
			}
			else if($jenisbayar == '1'){
				
				$pelunasan = $request->pelunasan[$k];

				$pelunasan2 = str_replace(',', '', $pelunasan);
				

				$deletefpgdt = DB::table('fpg_dt')->where('fpgdt_id' , '=' , $idfpgdt)->delete();
				$datafaktur = DB::select("select * from ikhtisar_kas where ik_id = '$idfp'");
				$fp_pelunasan = $datafaktur[0]->ik_pelunasan;

				$penjumlahan = (float)$fp_pelunasan + (float)$pelunasan2;
				$updatefaktur = DB::table('ikhtisar_kas')
				->where('ik_id' , $idfp)
				->update([
					'ik_pelunasan' => $penjumlahan
				]);
			}
			else if($jenisbayar == '4'){
				$pelunasan = $request->pelunasan[$j];

				$pelunasan2 = str_replace(',', '', $pelunasan);
				

				$deletefpgdt = DB::table('fpg_dt')->where('fpgdt_id' , '=' , $idfpgdt)->delete();
				$datafaktur = DB::select("select * from d_uangmuka where um_id = '$idfp'");
				$fp_pelunasan = $datafaktur[0]->um_sisapelunasan;

				$penjumlahan = (float)$fp_pelunasan + (float)$pelunasan2;
				$updatefaktur = fakturpembelian::where('um_id', '=' , $idfp);
						$updatefaktur->update([
							'um_sisapelunasan' => $penjumlahan,
						]);
			}
			else if($jenisbayar == '11'){
				$pelunasan = $request->pelunasan[$j];

				$pelunasan2 = str_replace(',', '', $pelunasan);
				

				$deletefpgdt = DB::table('fpg_dt')->where('fpgdt_id' , '=' , $idfpgdt)->delete();
				$datafaktur = DB::select("select * from bonsem_pengajuan where bp_id = '$idfp'");
				$fp_pelunasan = $datafaktur[0]->bp_pelunasan;

				$penjumlahan = (float)$fp_pelunasan + (float)$pelunasan2;
				$updatefaktur = fakturpembelian::where('bp_id', '=' , $idfp);
						$updatefaktur->update([
							'bp_pelunasan' => $penjumlahan,
						]);
			}
			else if($jenisbayar == '13'){
				$pelunasan = $request->pelunasan[$j];

				$pelunasan2 = str_replace(',', '', $pelunasan);
				

				$deletefpgdt = DB::table('fpg_dt')->where('fpgdt_id' , '=' , $idfpgdt)->delete();
				$datafaktur = DB::select("select * from bonsem_pengajuan where bp_id = '$idfp'");
				$fp_pelunasan = $datafaktur[0]->bp_pencairan;

				$penjumlahan = (float)$fp_pelunasan + (float)$pelunasan2;
				$updatefaktur = fakturpembelian::where('bp_id', '=' , $idfp);
						$updatefaktur->update([
							'bp_pencairan' => $penjumlahan,
						]);
				}
            } //end delete nofaktur
         ///-------------------------------------------//

        //deletenobank
		$caribank = DB::table('fpg_cekbank')
  				  ->where('fpgb_idfpg' , $idfpg)
                  ->get();
	     for($k = 0; $k < count($caribank); $k++){
			$noseri = $caribank[$k]->fpgb_nocheckbg;
			$idfpgb = $caribank[$k]->fpgb_id;
			$mbid = $caribank[$k]->fpgb_kodebank;

			$jenisbayarbank = $caribank[$k]->fpgb_jenisbayarbank;
			if($jenisbayar == 'CHECK/BG'){
				$updatebank1 = masterbank_dt::where([['mbdt_idmb', '=', $mbid], ['mbdt_noseri' , '=' ,$noseri]]);

				$updatebank1->update([
					 	'mbdt_nofpg' =>  null,
					 	'mbdt_setuju' => null,
					 	'mbdt_status' => null,
					 	'mbdt_nominal' => null,
					 	'mbdt_tglstatus' => null,
				 	]);
			}	

			$deletefpgb = DB::table('fpg_cekbank')->where('fpgb_id' , '=' , $idfpgb)->delete();
	     }      	
        
		

		//addfaktur
		for($j=0;$j<count($request->nofaktur);$j++){
			$idfp = $request->idfaktur[$j];
			$cekidfp = DB::select("select * from fpg_dt where  fpgdt_idfpg = '$idfpg' and fpgdt_idfp = '$idfp'");
			


				
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
				$formfpg_dt->fpgdt_nofaktur = $request->nofaktur[$j];
				$formfpg_dt->fpgdt_sisapelunasanumfp = $pelunasan;
				$formfpg_dt->save();



				$updatefaktur = fakturpembelian::where('fp_nofaktur', '=', $request->nofaktur[$j]);
					$updatefaktur->update([
					 	'fp_sisapelunasan' => $sisafaktur,	 	
				 	]);			 				 
				
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
					 	'mbdt_setuju' => 'T',
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
	});
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

	public function groupJurnalFpItem($data) {
	    $groups = array();
	    $key = 0;
	    foreach ($data as $item) {
	        $key = $item['akun'];
	        if (!array_key_exists($key, $groups)) {
	            $groups[$key] = array(	                
	                'akun' => $item['akun'],
	                'subtotal' => $item['subtotal'],
	                'ppn'=>$item['ppn'],
	                'pph'=>$item['pph'],
	            );	            
	        } else {
	            $groups[$key]['subtotal'] = $groups[$key]['subtotal'] + $item['subtotal'];				
	            $groups[$key]['ppn'] = $groups[$key]['ppn'] + $item['ppn'];				
	            $groups[$key]['pph'] = $groups[$key]['pph'] + $item['pph'];		
	        }
	        $key++;
	    }
	    return $groups;
	}
}
