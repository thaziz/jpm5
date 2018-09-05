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
use Auth;
use App\d_jurnal;
use App\d_jurnal_dt;
class pendingController extends Controller
{
	public function index(){
		$cabang = Auth::user()->kode_cabang;
		if (Auth::user()->punyaAkses('Pending','all')) {
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
		}else{
			$agen = DB::table('faktur_pembelian')
				  ->join('biaya_penerus','bp_faktur','=','fp_nofaktur')
				  ->join('agen','bp_kode_vendor','=','kode')
				  ->where('fp_pending_status','PENDING')	  
				  ->where('fp_comp',$cabang)	  
				  ->get();

			$vendor = DB::table('faktur_pembelian')
					  ->join('biaya_penerus','bp_faktur','=','fp_nofaktur')
					  ->join('vendor','bp_kode_vendor','=','kode')
					  ->where('fp_pending_status','PENDING')	  
					  ->where('fp_comp',$cabang)	  
					  ->get();

			
			$data = array_merge($agen,$vendor);
		}
	 	

		// return Auth::user()->m_level;


	

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
			$percent->komisi = $percent->komisi_agen;
		}else{
			$percent = DB::table('vendor')
					->where('kode',$header->fp_supplier	)
					->first();
			$percent->komisi = $percent->komisi_vendor;
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
		// dd($request->all());
		return DB::transaction(function() use ($request) {  
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



		   	// //JURNAL
			   	$faktur = DB::table('faktur_pembelian')
			   				->join('biaya_penerus','bp_faktur','=','fp_nofaktur')
			   				->where('fp_nofaktur',$request->no_trans)
			   				->first();

			   	$cari_dt=DB::table('biaya_penerus_dt')		
						 ->join('delivery_order','bpd_pod','=','nomor')
						 ->where('bpd_bpid','=',$faktur->bp_id)
						 ->get();


				for ($i=0; $i < count($cari_dt); $i++) { 

					$cari_asal_2[$i] = $cari_dt[$i]->kode_cabang; 
				}
				if (isset($cari_asal_2)) {
				    $unik_asal = array_unique($cari_asal_2);
				    $unik_asal = array_values($unik_asal);

				    // return $unik_asal;
				    for ($i=0; $i < count($unik_asal); $i++) { 
						for ($a=0; $a < count($cari_dt); $a++) { 
							if($cari_dt[$a]->kode_cabang==$unik_asal[$i]){
								${$unik_asal[$i]}[$a] = $cari_dt[$a]->bpd_nominal;
							}
						}
					}

					for ($i=0; $i < count($unik_asal); $i++) { 
						${'total'.$unik_asal[$i]} = array_sum(${$unik_asal[$i]});
					}
					// $harga_array = [];
					for ($i=0; $i < count($unik_asal); $i++) { 
						 $harga_array[$i] = ${'total'.$unik_asal[$i]};
					}
					for ($i=0; $i < count($harga_array); $i++) { 
						 $jurnal[$i]['harga'] = round($harga_array[$i],2);
						 $jurnal[$i]['asal'] = $unik_asal[$i];

					}


				}

				// dd($jurnal);

				$id_jurnal=d_jurnal::max('jr_id')+1;
				// dd($id_jurnal);

				$delete_jurnal = DB::table('d_jurnal')
							   ->where('jr_ref',$request->no_trans)
							   ->delete();
				$jenis_bayar = DB::table('jenisbayar')
								 ->where('idjenisbayar',6)
								 ->first();
				if ($pending_status == "APPROVED") {
					$save_jurnal = d_jurnal::create(['jr_id'=> $id_jurnal,
											'jr_year'   => carbon::parse(str_replace('/', '-', $request->tN))->format('Y'),
											'jr_date' 	=> carbon::parse(str_replace('/', '-', $request->tN))->format('Y-m-d'),
											'jr_detail' => $jenis_bayar->jenisbayar,
											'jr_ref'  	=> $request->no_trans,
											'jr_note'  	=> 'BIAYA PENERUS HUTANG',
											'jr_insert' => carbon::now(),
											'jr_update' => carbon::now(),
											]);
				}
				


				$akun 	  = [];
				$akun_val = [];
				array_push($akun, $faktur->fp_acchutang);
				array_push($akun_val, (float)$faktur->fp_netto);
				// dd($akun_val);
				for ($i=0; $i < count($jurnal); $i++) { 

					$id_akun = DB::table('d_akun')
									  ->where('id_akun','like','5315' . '%')
									  ->where('kode_cabang',$jurnal[$i]['asal'])
									  ->first();

					if ($id_akun == null) {
						return response()->json(['status'=>0,'pesan'=>'Akun Biaya Untuk Cabang Ini Tidak Tersedia']);
					}
					array_push($akun, $id_akun->id_akun);
					array_push($akun_val, $jurnal[$i]['harga']);
				}

				$data_akun = [];
				for ($i=0; $i < count($akun); $i++) { 

					$cari_coa = DB::table('d_akun')
									  ->where('id_akun',$akun[$i])
									  ->first();

					if (substr($akun[$i],0, 1)==2) {
						
						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'D';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan);
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'K';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan);
						}
					}else if (substr($akun[$i],0, 1)>2) {

						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'D';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan);
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'K';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan);
						}
					}
				}

				if ($pending_status == 'APPROVED') {
					$jurnal_dt = d_jurnal_dt::insert($data_akun);
				}

				$lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();
				// dd($lihat);

			   				 
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
			   			  	'pk_keterangan'		=> $request->x,
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
			   	//JURNAL
			   	$faktur = DB::table('faktur_pembelian')
			   				->join('biaya_penerus','bp_faktur','=','fp_nofaktur')
			   				->where('fp_nofaktur',$request->no_trans)
			   				->first();

			   	$cari_dt=DB::table('biaya_penerus_dt')		
						 ->join('delivery_order','bpd_pod','=','nomor')
						 ->where('bpd_bpid','=',$faktur->bp_id)
						 ->get();


				for ($i=0; $i < count($cari_dt); $i++) { 

					$cari_asal_2[$i] = $cari_dt[$i]->kode_cabang; 
				}
				if (isset($cari_asal_2)) {
				    $unik_asal = array_unique($cari_asal_2);
				    $unik_asal = array_values($unik_asal);

				    // return $unik_asal;
				    for ($i=0; $i < count($unik_asal); $i++) { 
						for ($a=0; $a < count($cari_dt); $a++) { 
							if($cari_dt[$a]->kode_cabang==$unik_asal[$i]){
								${$unik_asal[$i]}[$a] = $cari_dt[$a]->bpd_nominal;
							}
						}
					}

					for ($i=0; $i < count($unik_asal); $i++) { 
						${'total'.$unik_asal[$i]} = array_sum(${$unik_asal[$i]});
					}
					// $harga_array = [];
					for ($i=0; $i < count($unik_asal); $i++) { 
						 $harga_array[$i] = ${'total'.$unik_asal[$i]};
					}
					for ($i=0; $i < count($harga_array); $i++) { 
						 $jurnal[$i]['harga'] = round($harga_array[$i],2);
						 $jurnal[$i]['asal'] = $unik_asal[$i];

					}


				}

				// dd($jurnal);

				$id_jurnal=d_jurnal::max('jr_id')+1;
				// dd($id_jurnal);
				$jenis_bayar = DB::table('jenisbayar')
								 ->where('idjenisbayar',6)
								 ->first();
				if ($pending_status == "APPROVED") {
					$save_jurnal = d_jurnal::create(['jr_id'=> $id_jurnal,
											'jr_year'   => carbon::parse(str_replace('/', '-', $request->tN))->format('Y'),
											'jr_date' 	=> carbon::parse(str_replace('/', '-', $request->tN))->format('Y-m-d'),
											'jr_detail' => $jenis_bayar->jenisbayar,
											'jr_ref'  	=> $request->no_trans,
											'jr_note'  	=> 'BIAYA PENERUS HUTANG',
											'jr_insert' => carbon::now(),
											'jr_update' => carbon::now(),
											]);
				}
				


				$akun 	  = [];
				$akun_val = [];
				array_push($akun, $faktur->fp_acchutang);
				array_push($akun_val, (float)$faktur->fp_netto);
				for ($i=0; $i < count($jurnal); $i++) { 

					$id_akun = DB::table('d_akun')
									  ->where('id_akun','like','5315' . '%')
									  ->where('kode_cabang',$jurnal[$i]['asal'])
									  ->first();

					if ($id_akun == null) {
						return response()->json(['status'=>0,'pesan'=>'Akun Biaya Untuk Cabang Ini Tidak Tersedia'])
					}
					array_push($akun, $id_akun->id_akun);
					array_push($akun_val, $jurnal[$i]['harga']);
				}

				$data_akun = [];
				for ($i=0; $i < count($akun); $i++) { 

					$cari_coa = DB::table('d_akun')
									  ->where('id_akun',$akun[$i])
									  ->first();

					if (substr($akun[$i],0, 1)==2) {
						
						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'D';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan);
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'K';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan);
						}
					}else if (substr($akun[$i],0, 1)>2) {

						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'D';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan);
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'K';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan);
						}
					}
				}

				if ($pending_status == 'APPROVED') {
					$jurnal_dt = d_jurnal_dt::insert($data_akun);
				}

				$lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();
				// dd($lihat);
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
		   			  	'pk_keterangan'		=> $request->x,
		   			  	'created_at'		=> Carbon::now(),
		   			  	'updated_at'		=> Carbon::now()
		   			  ]);
		   	return 'Success';
			 
		}
		});
		

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
		

		$cabang = Auth::user()->kode_cabang;
		if (Auth::user()->punyaAkses('Pending Subcon','all')) {
			$data = DB::table('faktur_pembelian')
				  ->join('pembayaran_subcon','pb_faktur','=','fp_nofaktur')
				  ->join('subcon','pb_kode_subcon','=','kode')
				  ->where('fp_pending_status','PENDING')	  
				  ->get();

		}else{
			$data = DB::table('faktur_pembelian')
				  ->join('pembayaran_subcon','pb_faktur','=','fp_nofaktur')
				  ->join('subcon','pb_kode_subcon','=','kode')
				  ->where('fp_pending_status','PENDING')	  
				  ->where('fp_comp',$cabang)	  
				  ->get();

		}
		// return $fix_persen;
		// return 'asd';
		return view('purchase.pending.indexPendingSubcon',compact('data'));

	}

	public function create_subcon(request $request){
		$header = DB::table('faktur_pembelian')
				  ->join('pembayaran_subcon','pb_faktur','=','fp_nofaktur')
				  ->where('fp_idfaktur',$request->id)
				  ->first();	

		$pb_id = $header->pb_id;
		
		$list = DB::select("SELECT pembayaran_subcon_dt.*,delivery_order.*, asal.nama as asal,tujuan.nama as tujuan  
								   FROM pembayaran_subcon_dt
								   inner join delivery_order on nomor = pbd_resi
								   inner join 
								   (SELECT id,nama FROM kota) as asal on id_kota_asal = asal.id
								    inner join 
								   (SELECT id,nama FROM kota) as tujuan on id_kota_tujuan = tujuan.id
								   where pbd_pb_id = '$pb_id'
								   and pbd_status = 'PENDING'");

			$percent = DB::table('subcon')
					->where('kode',$header->fp_supplier)
					->first();
			

		// return $percent;
		$persen = [];
		for ($i=0; $i < count($list); $i++) { 
			$bagi 	= round($list[$i]->pbd_tarif_harga)/round($list[$i]->pbd_tarif_resi);
			$persen[$i] = round($bagi,4)*100;

			$list[$i]->pbd_tarif_resi = round($list[$i]->pbd_tarif_resi);
			$list[$i]->pbd_tarif_harga	  = round($list[$i]->pbd_tarif_harga);
		}

	

		return view('purchase.pending.createPendingSubcon',compact('header','list','persen','percent'));
	}

	public function save_subcon(Request $request){
		// dd($request->status);
		if($request->status == 1){

		   for ($i=0; $i < count($request->id_bpd); $i++) { 
		   	$update = DB::table('pembayaran_subcon_dt')
						->where('pbd_pb_id',$request->id_bpd[$i])
						->where('pbd_pb_dt',$request->dt_bpd[$i])
						->update([
							'pbd_status' => 'APPROVED'
						]);
					
		   }
			//UPDATE BP
		    $cari_bpd = DB::table('pembayaran_subcon_dt')
		   				 ->where('pbd_pb_id',$request->id_bpd[0])
		   				 ->get();

		   	
		   	 for ($i=0; $i < count($cari_bpd); $i++) { 
		   	 	$status[$i] = $cari_bpd[$i]->pbd_status;
		   	 }

		   	if (isset($status)) {

		   	 	if (in_array('PENDING', $status)) {
	   	 			$pending_status = 'PENDING';
		   	 	}else{
		   	 		$pending_status = 'APPROVED';
		   	 	}

		   	 	$update_bp = DB::table('faktur_pembelian')
			   	 			 ->join('pembayaran_subcon','fp_nofaktur','=','pb_faktur')
			   				 ->where('pb_id',$request->id_bpd[0])
			   				 ->update([
			   				 	'fp_pending_status' => $pending_status
			   				 ]);


			   	//JURNAL
			   	$faktur = DB::table('faktur_pembelian')
			   				->join('biaya_penerus','bp_faktur','=','fp_nofaktur')
			   				->where('fp_nofaktur',$request->no_trans)
			   				->first();

			   	$cari_dt=DB::table('biaya_penerus_dt')		
						 ->join('delivery_order','bpd_pod','=','nomor')
						 ->where('bpd_bpid','=',$faktur->bp_id)
						 ->get();


				for ($i=0; $i < count($cari_dt); $i++) { 

					$cari_asal_2[$i] = $cari_dt[$i]->kode_cabang; 
				}



				if (isset($cari_asal_2)) {
				    $unik_asal = array_unique($cari_asal_2);
				    $unik_asal = array_values($unik_asal);

				    // return $unik_asal;
				    for ($i=0; $i < count($unik_asal); $i++) { 
						for ($a=0; $a < count($cari_dt); $a++) { 
							if($cari_dt[$a]->kode_cabang==$unik_asal[$i]){
								${$unik_asal[$i]}[$a] = $cari_dt[$a]->bpd_nominal;
							}
						}
					}

					for ($i=0; $i < count($unik_asal); $i++) { 
						${'total'.$unik_asal[$i]} = array_sum(${$unik_asal[$i]});
					}
					// $harga_array = [];
					for ($i=0; $i < count($unik_asal); $i++) { 
						 $harga_array[$i] = ${'total'.$unik_asal[$i]};
					}
					for ($i=0; $i < count($harga_array); $i++) { 
						 $jurnal[$i]['harga'] = round($harga_array[$i],2);
						 $jurnal[$i]['asal'] = $unik_asal[$i];

					}


				}

				// dd($jurnal);

				$id_jurnal=d_jurnal::max('jr_id')+1;
				// dd($id_jurnal);
				$jenis_bayar = DB::table('jenisbayar')
								 ->where('idjenisbayar',9)
								 ->first();
				if ($pending_status == "APPROVED") {
					$save_jurnal = d_jurnal::create(['jr_id'=> $id_jurnal,
											'jr_year'   => carbon::parse(str_replace('/', '-', $request->tN))->format('Y'),
											'jr_date' 	=> carbon::parse(str_replace('/', '-', $request->tN))->format('Y-m-d'),
											'jr_detail' => $jenis_bayar->jenisbayar,
											'jr_ref'  	=> $request->no_trans,
											'jr_note'  	=> 'PEMBAYARAN SUBCON',
											'jr_insert' => carbon::now(),
											'jr_update' => carbon::now(),
											]);
				}
				


				$akun 	  = [];
				$akun_val = [];
				array_push($akun, $faktur->fp_acchutang);
				array_push($akun_val, (float)$faktur->fp_netto);
				for ($i=0; $i < count($jurnal); $i++) { 

					$id_akun = DB::table('d_akun')
									  ->where('id_akun','like','5210' . '%')
									  ->where('kode_cabang',$jurnal[$i]['asal'])
									  ->first();

					if ($id_akun == null) {
						return response()->json(['status'=>0,'pesan'=>'Akun Biaya Untuk Cabang Ini Tidak Tersedia'])
					}
					array_push($akun, $id_akun->id_akun);
					array_push($akun_val, $jurnal[$i]['harga']);
				}

				$data_akun = [];
				for ($i=0; $i < count($akun); $i++) { 

					$cari_coa = DB::table('d_akun')
									  ->where('id_akun',$akun[$i])
									  ->first();

					if (substr($akun[$i],0, 1)==2) {
						
						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'D';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan);
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'K';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan);
						}
					}else if (substr($akun[$i],0, 1)>2) {

						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'D';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan);
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'K';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan);
						}
					}
				}

				if ($pending_status == 'APPROVED') {
					$jurnal_dt = d_jurnal_dt::insert($data_akun);
				}

				$lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();
				// dd($lihat);
			   				 
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
		   	$update = DB::table('pembayaran_subcon_dt')
						->where('pbd_pb_id',$request->id_bpd_modal)
						->where('pbd_pb_dt',$request->dt_bpd_modal)
						->update([
							'pbd_status' => 'APPROVED'
						]);
			//UPDATE BP
		    $cari_bpd = DB::table('pembayaran_subcon_dt')
		   				 ->where('pbd_pb_id',$request->id_bpd_modal[0])
		   				 ->get();

		   	
		   	 for ($i=0; $i < count($cari_bpd); $i++) { 
		   	 	$status[$i] = $cari_bpd[$i]->pbd_status;
		   	 }

		   	 if (isset($status)) {
		   	 	if (in_array('PENDING', $status)) {
	   	 			$pending_status = 'PENDING';
		   	 	}else{
		   	 		$pending_status = 'APPROVED';
		   	 	}

		   	 	$update_bp = DB::table('faktur_pembelian')
			   	 			 ->join('pembayaran_subcon','fp_nofaktur','=','pb_faktur')
			   				 ->where('pb_id',$request->id_bpd_modal[0])
			   				 ->update([
			   				 	'fp_pending_status' => $pending_status
			   				 ]);


			   	//JURNAL
			   	$faktur = DB::table('faktur_pembelian')
			   				->join('biaya_penerus','bp_faktur','=','fp_nofaktur')
			   				->where('fp_nofaktur',$request->no_trans)
			   				->first();

			   	$cari_dt=DB::table('biaya_penerus_dt')		
						 ->join('delivery_order','bpd_pod','=','nomor')
						 ->where('bpd_bpid','=',$faktur->bp_id)
						 ->get();


				for ($i=0; $i < count($cari_dt); $i++) { 

					$cari_asal_2[$i] = $cari_dt[$i]->kode_cabang; 
				}



				if (isset($cari_asal_2)) {
				    $unik_asal = array_unique($cari_asal_2);
				    $unik_asal = array_values($unik_asal);

				    // return $unik_asal;
				    for ($i=0; $i < count($unik_asal); $i++) { 
						for ($a=0; $a < count($cari_dt); $a++) { 
							if($cari_dt[$a]->kode_cabang==$unik_asal[$i]){
								${$unik_asal[$i]}[$a] = $cari_dt[$a]->bpd_nominal;
							}
						}
					}

					for ($i=0; $i < count($unik_asal); $i++) { 
						${'total'.$unik_asal[$i]} = array_sum(${$unik_asal[$i]});
					}
					// $harga_array = [];
					for ($i=0; $i < count($unik_asal); $i++) { 
						 $harga_array[$i] = ${'total'.$unik_asal[$i]};
					}
					for ($i=0; $i < count($harga_array); $i++) { 
						 $jurnal[$i]['harga'] = round($harga_array[$i],2);
						 $jurnal[$i]['asal'] = $unik_asal[$i];

					}


				}

				// dd($jurnal);

				$id_jurnal=d_jurnal::max('jr_id')+1;
				// dd($id_jurnal);
				$jenis_bayar = DB::table('jenisbayar')
								 ->where('idjenisbayar',9)
								 ->first();
				if ($pending_status == "APPROVED") {
					$save_jurnal = d_jurnal::create(['jr_id'=> $id_jurnal,
											'jr_year'   => carbon::parse(str_replace('/', '-', $request->tN))->format('Y'),
											'jr_date' 	=> carbon::parse(str_replace('/', '-', $request->tN))->format('Y-m-d'),
											'jr_detail' => $jenis_bayar->jenisbayar,
											'jr_ref'  	=> $request->no_trans,
											'jr_note'  	=> 'PEMBAYARAN SUBCON',
											'jr_insert' => carbon::now(),
											'jr_update' => carbon::now(),
											]);
				}
				


				$akun 	  = [];
				$akun_val = [];
				array_push($akun, $faktur->fp_acchutang);
				array_push($akun_val, (float)$faktur->fp_netto);
				for ($i=0; $i < count($jurnal); $i++) { 

					$id_akun = DB::table('d_akun')
									  ->where('id_akun','like','5210' . '%')
									  ->where('kode_cabang',$jurnal[$i]['asal'])
									  ->first();

					if ($id_akun == null) {
						return response()->json(['status'=>0,'pesan'=>'Akun Biaya Untuk Cabang Ini Tidak Tersedia'])
					}
					array_push($akun, $id_akun->id_akun);
					array_push($akun_val, $jurnal[$i]['harga']);
				}

				$data_akun = [];
				for ($i=0; $i < count($akun); $i++) { 

					$cari_coa = DB::table('d_akun')
									  ->where('id_akun',$akun[$i])
									  ->first();

					if (substr($akun[$i],0, 1)==2) {
						
						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'D';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan);
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'K';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan);
						}
					}else if (substr($akun[$i],0, 1)>2) {

						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'D';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan);
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'K';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan);
						}
					}
				}

				if ($pending_status == 'APPROVED') {
					$jurnal_dt = d_jurnal_dt::insert($data_akun);
				}

				$lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();
				// dd($lihat);
			   				 
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

}