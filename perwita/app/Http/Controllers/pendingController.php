<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use PDF;
use App\tb_coa;
use App\tb_jurnal;
use DB;
use Response;
Use Carbon\Carbon;
use Session;
use Mail;
use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;
use App\master_note;

class pendingController extends Controller
{
	public function index(){
	 	$agen = DB::table('faktur_pembelian')
				  ->join('biaya_penerus','bp_faktur','=','fp_nofaktur')
				  ->join('agen','bp_kode_vendor','=','kode')
				  ->where('fp_pending_status','PENDING')	  
				  ->get();

		$vendor = DB::table('faktur_pembelian')
				  ->join('biaya_penerus','bp_faktur','=','fp_nofaktur')
				  ->join('vendor','bp_kode_vendor','=','kode')
				  ->where('fp_pending_status','PENDING')	  
				  ->get();
		$data = array_merge($agen,$vendor);




	

		return view('purchase.pending.indexPending',compact('data'));
	}

	public function create(request $request){
		$header = DB::table('faktur_pembelian')
				  ->join('biaya_penerus','bp_faktur','=','fp_nofaktur')
				  ->where('fp_idfaktur',$request->id)
				  ->first();	

		$bp_id = $header->bp_id;
		
		$list = DB::select("SELECT biaya_penerus_dt.*,delivery_order.*, asal.nama as asal,tujuan.nama as tujuan  
								   FROM biaya_penerus_dt 
								   inner join delivery_order on nomor = bpd_pod
								   inner join 
								   (SELECT id,nama FROM kota) as asal on id_kota_asal = asal.id
								    inner join 
								   (SELECT id,nama FROM kota) as tujuan on id_kota_tujuan = tujuan.id
								   where bpd_bpid = '$bp_id'
								   and bpd_status = 'PENDING'");
		if ($header->bp_tipe_vendor == 'AGEN') {
			$percent = DB::table('agen')
					->where('kode',$header->fp_supplier)
					->first();
		}else{
			$percent = DB::table('vendor')
					->where('kode',$header->fp_supplier	)
					->first();
		}

		// return $percent;
		$persen = [];
		for ($i=0; $i < count($list); $i++) { 
			$bagi 	= round($list[$i]->bpd_nominal)/round($list[$i]->bpd_tarif_resi);
			$persen[$i] = round($bagi,4)*100;

			$list[$i]->bpd_tarif_resi = round($list[$i]->bpd_tarif_resi);
			$list[$i]->bpd_nominal	  = round($list[$i]->bpd_nominal);
		}

	

		return view('purchase.pending.createPending',compact('header','list','persen','percent'));
	}

	public function save(Request $request){
		// dd($request->status);
		if($request->status == 1){

		   for ($i=0; $i < count($request->id_bpd); $i++) { 
		   	$update = DB::table('biaya_penerus_dt')
						->where('bpd_bpid',$request->id_bpd[$i])
						->where('bpd_bpdetail',$request->dt_bpd[$i])
						->update([
							'bpd_status' => 'APPROVED'
						]);
					
		   }
			//UPDATE BP
		    $cari_bpd = DB::table('biaya_penerus_dt')
		   				 ->where('bpd_bpid',$request->id_bpd[0])
		   				 ->get();

		   	
		   	 for ($i=0; $i < count($cari_bpd); $i++) { 
		   	 	$status[$i] = $cari_bpd[$i]->bpd_status;
		   	 }

		   	 if (isset($status)) {
		   	 	if (in_array('PENDING', $status)) {
	   	 			$pending_status = 'PENDING';
		   	 	}else{
		   	 		$pending_status = 'APPROVED';
		   	 	}

		   	 $update_bp = DB::table('faktur_pembelian')
			   	 			 ->join('biaya_penerus','fp_nofaktur','=','bp_faktur')
			   				 ->where('bp_id',$request->id_bpd[0])
			   				 ->update([
			   				 	'fp_pending_status' => $pending_status
			   				 ]);
			   				 
		   	 }

		   
		   	

			 for ($i=0; $i < count($request->bpd_id); $i++) { 

			 	$cari_max_pending = DB::table('pending_keterangan')
		   	 					   ->max('pk_id');

			 	if ($cari_max_pending != null) {
		   	 		$cari_max_pending += 1;
				 }else{
				   	$cari_max_pending = 1;
				 }
			 	$save = DB::table('pending_keterangan')
			   			  ->insert([
			   			  	'pk_id'				=> $cari_max_pending,
			   			  	'pk_id_bpd'			=> $request->bpd_id[$i],
			   			  	'pk_keterangan'		=> $request->keterangan,
			   			  	'created_at'		=> Carbon::now(),
			   			  	'updated_at'		=> Carbon::now()
			   			  ]);
			 }

			 return 'Success';
		
		}else{
			// return 'asd';
		   	$update = DB::table('biaya_penerus_dt')
						->where('bpd_bpid',$request->id_bpd_modal)
						->where('bpd_bpdetail',$request->dt_bpd_modal)
						->update([
							'bpd_status' => 'APPROVED'
						]);
			//UPDATE BP
		    $cari_bpd = DB::table('biaya_penerus_dt')
		   				 ->where('bpd_bpid',$request->id_bpd_modal[0])
		   				 ->get();

		   	
		   	 for ($i=0; $i < count($cari_bpd); $i++) { 
		   	 	$status[$i] = $cari_bpd[$i]->bpd_status;
		   	 }

		   	 if (isset($status)) {
		   	 	if (in_array('PENDING', $status)) {
	   	 			$pending_status = 'PENDING';
		   	 	}else{
		   	 		$pending_status = 'APPROVED';
		   	 	}

		   	 	$update_bp = DB::table('faktur_pembelian')
			   	 			 ->join('biaya_penerus','fp_nofaktur','=','bp_faktur')
			   				 ->where('bp_id',$request->id_bpd_modal[0])
			   				 ->update([
			   				 	'fp_pending_status' => $pending_status
			   				 ]);
			   				 
		   	 }
		   
		   	 
				
			$cari_max_pending = DB::table('pending_keterangan')
		   	 					   ->max('pk_id');

		   	if ($cari_max_pending != null) {
		   	 	$cari_max_pending += 1;
		   	}else{
		   	 	$cari_max_pending = 1;
		   	}
			
		   	$save = DB::table('pending_keterangan')
		   			  ->insert([
		   			  	'pk_id'				=> $cari_max_pending,
		   			  	'pk_id_bpd'			=> $request->bpd_id_modal,
		   			  	'pk_keterangan'		=> $request->pk_keterangan,
		   			  	'created_at'		=> Carbon::now(),
		   			  	'updated_at'		=> Carbon::now()
		   			  ]);
		   	return 'Success';
			 
		}
		

	}

	public function index_kas(){
		$data = DB::table('biaya_penerus_kas')
				  ->join('master_persentase','bpk_pembiayaan','=','kode')
				  ->where('bpk_status_pending','PENDING')
				  ->get();

		$hasil = [];
		for ($i=0; $i < count($data); $i++) { 
			$persen = $data[$i]->bpk_tarif_penerus/$data[$i]->bpk_total_tarif;
			$persen = $persen*100;
			$persen = round($persen,2);
			$hasil[$i]= $persen;
		}

		return view('purchase.pending.indexPendingKas',compact('data','hasil'));

	}
	public function save_kas($id){
		DB::table('biaya_penerus_kas')
			->where('bpk_id',$id)
			->update([
				'bpk_status_pending' => 'APPROVED'
			]);
	}

	public function index_subcon(){
		

		$data = DB::table('faktur_pembelian')
				  ->join('pembayaran_subcon','fp_nofaktur','=','pb_faktur')
				  ->where('fp_pending_status','PENDING')
				  ->get();

		$data_dt = DB::table('faktur_pembelian')
				  ->join('pembayaran_subcon','fp_nofaktur','=','pb_faktur')
				  ->join('pembayaran_subcon_dt','pbd_pb_id','=','pb_id')
				  ->where('fp_pending_status','PENDING')
				  ->get();
		$persen=[];
		for ($i=0; $i < count($data); $i++) { 
			$persen[$i] = DB::table('master_persentase')
				  ->where('kode',$data[$i]->pb_id_persen)
				  ->get();
		}

		for ($i=0; $i < count($data); $i++) { 
			for ($a=0; $a < count($data_dt); $a++) { 
				if ($data_dt[$a]->pbd_pb_id == $data[$i]->pb_id) {
					$hasil[$a] = $data_dt[$a]->pbd_tarif_resi;
				}

				$hasil = array_sum($hasil);
				$total = $data[$i]->fp_netto/$hasil;
				$total = $total*100;
			}
			$fix_persen[$i] = $total;
		}
		// return $fix_persen;
		// return 'asd';
		return view('purchase.pending.indexPendingSubcon',compact('data','persen','fix_persen'));

	}

	public function save_subcon($id){
		$update = DB::table('faktur_pembelian')
					->where('fp_idfaktur',$id)
					->update([
						'fp_pending_status' => 'APPROVED'
					]);
	}


}