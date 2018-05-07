<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use carbon\carbon;
use DB;
use App\biaya_penerus_kas;
use App\biaya_penerus_kas_detail;

class loadingController extends Controller
{	
	public function FunctionName($value='')
	{
		# code...
	}

    public function index_loading()
    {	
    	$cabang = Auth::user()->kode_cabang;
    	if (Auth::user()->punyaAkses('Biaya Penerus Loading','all')) {
    		$data = DB::table('biaya_penerus_kas')
				->join('cabang','kode','=','bpk_comp')
    				  ->where('bpk_jenis_biaya','LOADING')
    				  ->get();
    	}else{
    		$data = DB::table('biaya_penerus_kas')
				->join('cabang','kode','=','bpk_comp')
    				  ->where('bpk_jenis_biaya','loading')
    				  ->where('bpk_comp',$cabang)
    				  ->get();
    	}

    	return view('purchase.kas.index_loading',compact('data'));
    }

    public function create_loading()
    {
    	$year  = Carbon::now()->format('Y'); 
		$month = Carbon::now()->format('m');  	
		$now   = Carbon::now()->format('d-m-Y');
		$cabang = DB::table('cabang')
					->get();
		$angkutan = DB::table('tipe_angkutan')
					->get();
		$akun_persen     = DB::table('master_persentase')
					  ->where('cabang','GLOBAL')
					  ->get();

		$akun_paket  = DB::table('master_persentase')
					  ->where('cabang','GLOBAL')
					  ->where('jenis_biaya',1)
					  ->get();

		$akun_kargo  = DB::table('master_persentase')
					  ->where('cabang','GLOBAL')
					  ->where('jenis_biaya',5)
					  ->get();

		return view('purchase/kas/create_loading',compact('now','akun','akun_persen','cabang','angkutan','akun_kargo','akun_paket'));
    }

    public function cariresi(request $request)
    {	

		$biaya_bbm 	  = filter_var($request->data[7]['value'], FILTER_SANITIZE_NUMBER_INT);
		$biaya_dll 	  = filter_var($request->data[6]['value'], FILTER_SANITIZE_NUMBER_INT);
		$data     	  = [];
		$tujuan       = [];
		$total_tarif  = 0;
		$penerus      = [];
		$total_penerus= 0;
		$tipe_data    = $request->head[2]['value'];
		$cabang 	  = $request->head[4]['value'];
		$resi 		  = [];
		$now 		  = Carbon::now()->format('Y-m-d');

		for ($i=0; $i < count($request->resi_array); $i++) { 
			$cari_resi = DB::table('delivery_order')
						   ->leftjoin('biaya_penerus_kas_detail','bpkd_no_resi','=','nomor')
						   ->whereIn('nomor',$request->resi_array)
						   ->where('jenis_tarif',9)
						   ->orderBy('nomor','ASC')
						   ->get();

		}

		// return $cari_resi;
		for ($i=0; $i < count($cari_resi); $i++) {
			$resi[$i] = $cari_resi[$i]->nomor;
			if ($cari_resi[$i]->bpkd_no_resi != null) {
				unset($resi[$i]);
			}
		}
		// return $resi;
		$resi = array_unique($resi);
		$resi = array_values($resi);
		
		for ($i=0 ; $i < count($resi); $i++) { 

			$cari = DB::table('delivery_order')
				  ->join('kota','id','=','id_kota_asal')
				  ->where('nomor',$resi[$i])
				  ->get();

			$cari1 = DB::table('delivery_order')
				  ->select('nama','id')
				  ->join('kota','id','=','id_kota_asal')
				  ->where('nomor',$resi[$i])
				  ->get();

		   	$data[$i]   = $cari;
		   	$tujuan[$i] = $cari1;
		}

		//Menjumlah tarif resi
		$data = array_filter($data);
		$data = array_values($data);
		$tujuan = array_filter($tujuan);
		$tujuan = array_values($tujuan);

		if (count($data) != 0) {

		//menghitung tarif penerus
			for ($i=0; $i < count($data); $i++) { 
				$hasil = $data[$i][0]->total_net;
				$penerus[$i]=(float)$hasil;
			}
		
			$total_penerus =array_sum($penerus);
			$total_penerus =round($total_penerus,2);
			$total_tarif   =round($total_penerus,2);
			return view('purchase/kas/tabelBiayakas',compact('data','tujuan','total_tarif','kas_surabaya','penerus','total_penerus','tipe_data'));
	
		}else{
			return response()->json(['status' => 0]);
		}
    }

    public function save_loading(request $request)
    {
    	// dd($request->all());
		return DB::transaction(function() use ($request) {  

	    	$id = DB::table('biaya_penerus_kas')
					->max('bpk_id');
			if($id != null){
				$id+=1;
			}else{
				$id=1;
			}

		 	$cari_data = DB::table('biaya_penerus_kas')
					->where('bpk_nota',$request->no_trans)
					->first();


			$akun = DB::table('d_akun')
					  ->where('id_akun','like','2199'.'%')
					  ->where('kode_cabang',$request->cabang)
					  ->first();

			if ($akun == null) {
				$akun = DB::table('d_akun')
					  ->where('id_akun','like','2199'.'%')
					  ->where('kode_cabang','000')
					  ->first();
			}

	        if($cari_data == 0){
				biaya_penerus_kas::create([
				  	'bpk_id'      	  	 => $id,
				  	'bpk_nota'  	  	 => $request->no_trans,
				  	'bpk_jenis_biaya' 	 => $request->jenis_pembiayaan,
				  	'bpk_pembiayaan'  	 => $request->pembiayaan,
				  	'bpk_total_tarif' 	 => round($request->total_tarif,2),
				  	'bpk_tanggal'     	 => Carbon::parse($request->tN)->format('Y-m-d'),
				  	'bpk_nopol'		  	 => strtoupper($request->nopol),
				  	'bpk_status'	  	 => 'Released',
				  	'bpk_status_pending' => 'APPROVED',	
				  	'bpk_kode_akun'		 => $request->nama_kas,
				  	'bpk_sopir'		 	 => strtoupper($request->nama_sopir),
				  	'bpk_keterangan'	 => strtoupper($request->note),
				  	'bpk_tipe_angkutan'  => $request->jenis_kendaraan,		
				  	'created_at'		 => Carbon::now(),
				  	'bpk_comp'	 		 => $request->cabang,
				  	'bpk_tarif_penerus'	 => $request->total_penerus,
				  	'bpk_edit'	 		 => 'UNALLOWED',
				  	'bpk_biaya_lain'	 => 0,
				  	'bpk_jarak'	 		 => 0,
				  	'bpk_harga_bbm'	     => 0,
					'bpk_jenis_bbm'      => 0,
					'bpk_acc_biaya'      => $akun->id_akun,
				  	'created_by'		 => Auth::user()->m_name,
				  	'updated_by'		 => Auth::user()->m_name,
				]);

			}else{
				return response()->json(['status'=>0]);
			}



			for ($i=0; $i < count($request->no_resi); $i++) { 
				$id_bpkd = DB::table('biaya_penerus_kas_detail')
					->max('bpkd_id');

				if($id_bpkd != null){
					$id_bpkd+=1;
				}else{
					$id_bpkd=1;
				}
			
				
					
				biaya_penerus_kas_detail::create([
			  		'bpkd_id'				=> $id_bpkd,
					'bpkd_bpk_id'	  	 	=> $id,
					'bpkd_bpk_dt'			=> $i+1,
					'bpkd_no_resi'			=> $request->no_resi[$i],
					'bpkd_kode_cabang_awal'	=> $request->comp[$i],
					'bpkd_tanggal'  		=> $request->tanggal[$i],
					'bpkd_pengirim'	 		=> $request->pengirim[$i],
					'bpkd_penerima'			=> $request->penerima[$i],
					'bpkd_asal'				=> $request->asal[$i],
					'bpkd_tujuan'			=> $request->tujuan[$i],
					'bpkd_status_resi'		=> $request->status[$i],
					'bpkd_tarif'			=> $request->tarif[$i],
					'bpkd_tarif_penerus'	=> $request->penerus[$i],
					'created_at'			=> Carbon::now(),
					'bpk_comp'				=> $request->cabang,
					'bpkd_pembiayaan'		=> 0

				]);
				
			}
			

			$cari_id_pc = DB::table('patty_cash')
						 ->max('pc_id');

			if ($cari_id_pc == null) {
				$cari_id_pc = 1;
			}else{
				$cari_id_pc += 1;
			}


		
			$save_patty = DB::table('patty_cash')
				   ->insert([
			   		'pc_id'		  	  => $cari_id_pc,
			   		'pc_tgl'		  => Carbon::parse($request->tN)->format('Y-m-d'),
			   		'pc_ref'	 	  => 10,
			   		'pc_akun' 		  => $akun->id_akun,
			   		'pc_akun_kas' 	  => $request->nama_kas,
			   		'pc_keterangan'	  => $request->note,
			   		'pc_comp'  	  	  => $request->cabang,
			   		'pc_edit'  	  	  => 'UNALLOWED',
			   		'pc_reim'  	  	  => 'UNRELEASED',
			   		'pc_debet'  	  => 0,
			   		'pc_no_trans'  	  => $request->no_trans,
			   		'pc_kredit'  	  => $request->total_penerus,
			   		'created_at'	  => Carbon::now(),
			   		'updated_by'	  => Auth::user()->m_username,
			   		'created_by'	  => Auth::user()->m_username,
		        	'updated_at' 	  => Carbon::now()
			]);

			return response()->json(['status'=>1,'id'=>$id]);

		});
    }

    public function edit_loading(request $request)
    {
    	$year  = Carbon::now()->format('Y'); 
		$month = Carbon::now()->format('m');  	
		$now   = Carbon::now()->format('d-m-Y');
		$cabang = DB::table('cabang')
					->get();
		$angkutan = DB::table('tipe_angkutan')
					->get();
		$akun_persen     = DB::table('master_persentase')
					  ->where('cabang','GLOBAL')
					  ->get();

		$akun_paket  = DB::table('master_persentase')
					  ->where('cabang','GLOBAL')
					  ->where('jenis_biaya',1)
					  ->get();

		$akun_kargo  = DB::table('master_persentase')
					  ->where('cabang','GLOBAL')
					  ->where('jenis_biaya',5)
					  ->get();

		$data = DB::table('biaya_penerus_kas')
				  ->where('bpk_id',$request->id)
				  ->first();

		$data_dt = DB::table('biaya_penerus_kas_detail')
				  ->where('bpkd_bpk_id',$request->id)
				  ->get();

		$akun_kas = DB::table('d_akun')
    			  ->where('id_akun','like','1003'.'%')
    			  ->where('kode_cabang',$data->bpk_comp)
    			  ->get();
		$id = $request->id;
		for ($i=0; $i < count($data_dt); $i++) { 
			$resi[$i] = $data_dt[$i]->bpkd_no_resi;
		}
		$resi = implode(" ", $resi);

		return view('purchase/kas/edit_loading',compact('now','akun','akun_persen','cabang','angkutan','akun_kargo','akun_paket','data','data_dt','id','akun_kas','resi'));
    }

    public function cariresiedit(request $request)
    {	
	    
		$biaya_bbm 	  = filter_var($request->data[7]['value'], FILTER_SANITIZE_NUMBER_INT);
		$biaya_dll 	  = filter_var($request->data[6]['value'], FILTER_SANITIZE_NUMBER_INT);
		$data     	  = [];
		$tujuan       = [];
		$total_tarif  = 0;
		$penerus      = [];
		$total_penerus= 0;
		$tipe_data    = $request->head[2]['value'];
		$cabang 	  = $request->head[4]['value'];
		$resi 		  = [];
		$now 		  = Carbon::now()->format('Y-m-d');

		for ($i=0; $i < count($request->resi_array); $i++) { 

			$cari_resi = DB::table('delivery_order')
						   ->leftjoin('biaya_penerus_kas_detail','bpkd_no_resi','=','nomor')
						   ->whereIn('nomor',$request->resi_array)
						   ->where('jenis_tarif',9)
						   ->orderBy('nomor','ASC')
						   ->get();

			$cari_resi2 = DB::table('biaya_penerus_kas_detail')
						   	->where('bpkd_bpk_id',$request->id)
						   ->get();
		}

		// return $cari_resi;
		for ($i=0; $i < count($cari_resi); $i++) {
			$resi[$i] = $cari_resi[$i]->nomor;
			if ($cari_resi[$i]->bpkd_no_resi != null) {
				unset($resi[$i]);
			}
		}
		// return $resi;
		$resi = array_unique($resi);
		$resi = array_values($resi);
		

		for ($i=0; $i < count($cari_resi2); $i++) { 
			for ($a=0; $a < count($cari_resi); $a++) { 
				if ($cari_resi[$a]->nomor == $cari_resi2[$i]->bpkd_no_resi) {
					array_push($resi, $cari_resi[$a]->nomor);
				}
			}
		}


		for ($i=0 ; $i < count($resi); $i++) { 

			$cari = DB::table('delivery_order')
				  ->join('kota','id','=','id_kota_asal')
				  ->where('nomor',$resi[$i])
				  ->get();

			$cari1 = DB::table('delivery_order')
				  ->select('nama','id')
				  ->join('kota','id','=','id_kota_asal')
				  ->where('nomor',$resi[$i])
				  ->get();


		   	$data[$i]   = $cari;
		   	$tujuan[$i] = $cari1;
		}



		//Menjumlah tarif resi
		$data = array_filter($data);
		$data = array_values($data);
		$tujuan = array_filter($tujuan);
		$tujuan = array_values($tujuan);

		if (count($data) != 0) {

		//menghitung tarif penerus
			for ($i=0; $i < count($data); $i++) { 
				$hasil = $data[$i][0]->total_net;
				$penerus[$i]=(float)$hasil;
			}
		
			$total_penerus =array_sum($penerus);
			$total_penerus =round($total_penerus,2);
			$total_tarif   =round($total_penerus,2);
			return view('purchase/kas/tabelBiayakas',compact('data','tujuan','total_tarif','kas_surabaya','penerus','total_penerus','tipe_data'));
	
		}else{
			return response()->json(['status' => 0]);
		}
    }

    public function update_loading(request $request)
    {
		return DB::transaction(function() use ($request) {  

		 	$cari_data = DB::table('biaya_penerus_kas')
					->where('bpk_nota',$request->no_trans)
					->first();


			$akun = DB::table('d_akun')
					  ->where('id_akun','like','2199'.'%')
					  ->where('kode_cabang',$request->cabang)
					  ->first();

			if ($akun == null) {
				$akun = DB::table('d_akun')
					  ->where('id_akun','like','2199'.'%')
					  ->where('kode_cabang','000')
					  ->first();
			}

				biaya_penerus_kas::where('bpk_nota',$request->no_trans)->update([
				  	'bpk_nota'  	  	 => $request->no_trans,
				  	'bpk_jenis_biaya' 	 => $request->jenis_pembiayaan,
				  	'bpk_pembiayaan'  	 => $request->pembiayaan,
				  	'bpk_total_tarif' 	 => round($request->total_tarif,2),
				  	'bpk_tanggal'     	 => Carbon::parse($request->tN)->format('Y-m-d'),
				  	'bpk_nopol'		  	 => strtoupper($request->nopol),
				  	'bpk_status'	  	 => 'Released',
				  	'bpk_status_pending' => 'APPROVED',	
				  	'bpk_kode_akun'		 => $request->nama_kas,
				  	'bpk_sopir'		 	 => strtoupper($request->nama_sopir),
				  	'bpk_keterangan'	 => strtoupper($request->note),
				  	'bpk_tipe_angkutan'  => $request->jenis_kendaraan,		
				  	'updated_at'		 => Carbon::now(),
				  	'bpk_comp'	 		 => $request->cabang,
				  	'bpk_tarif_penerus'	 => $request->total_penerus,
				  	'bpk_edit'	 		 => 'UNALLOWED',
				  	'bpk_biaya_lain'	 => 0,
				  	'bpk_jarak'	 		 => 0,
				  	'bpk_harga_bbm'	     => 0,
					'bpk_jenis_bbm'      => 0,
					'bpk_acc_biaya'      => $akun->id_akun,
				  	'updated_by'		 => Auth::user()->m_name,
				]);

		

			biaya_penerus_kas_detail::where('bpkd_bpk_id',$request->id)->delete();

			for ($i=0; $i < count($request->no_resi); $i++) { 

				$id_bpkd = DB::table('biaya_penerus_kas_detail')
					->max('bpkd_id');

				if($id_bpkd != null){
					$id_bpkd+=1;
				}else{
					$id_bpkd=1;
				}
			
				
					
				biaya_penerus_kas_detail::create([
			  		'bpkd_id'				=> $id_bpkd,
					'bpkd_bpk_id'	  	 	=> $request->id,
					'bpkd_bpk_dt'			=> $i+1,
					'bpkd_no_resi'			=> $request->no_resi[$i],
					'bpkd_kode_cabang_awal'	=> $request->comp[$i],
					'bpkd_tanggal'  		=> $request->tanggal[$i],
					'bpkd_pengirim'	 		=> $request->pengirim[$i],
					'bpkd_penerima'			=> $request->penerima[$i],
					'bpkd_asal'				=> $request->asal[$i],
					'bpkd_tujuan'			=> $request->tujuan[$i],
					'bpkd_status_resi'		=> $request->status[$i],
					'bpkd_tarif'			=> $request->tarif[$i],
					'bpkd_tarif_penerus'	=> $request->penerus[$i],
					'created_at'			=> Carbon::now(),
					'bpk_comp'				=> $request->cabang,
					'bpkd_pembiayaan'		=> 0

				]);
				
			}
			

			$cari_id_pc = DB::table('patty_cash')
						 ->max('pc_id');

			if ($cari_id_pc == null) {
				$cari_id_pc = 1;
			}else{
				$cari_id_pc += 1;
			}


		
			$save_patty = DB::table('patty_cash')
				   ->where('pc_no_trans',$request->no_trans)
				   ->update([
			   		'pc_tgl'		  => Carbon::parse($request->tN)->format('Y-m-d'),
			   		'pc_ref'	 	  => 10,
			   		'pc_akun' 		  => $akun->id_akun,
			   		'pc_akun_kas' 	  => $request->nama_kas,
			   		'pc_keterangan'	  => $request->note,
			   		'pc_comp'  	  	  => $request->cabang,
			   		'pc_edit'  	  	  => 'UNALLOWED',
			   		'pc_reim'  	  	  => 'UNRELEASED',
			   		'pc_debet'  	  => 0,
			   		'pc_no_trans'  	  => $request->no_trans,
			   		'pc_kredit'  	  => $request->total_penerus,
			   		'updated_by'	  => Auth::user()->m_username,
		        	'updated_at' 	  => Carbon::now()
			]);

			return response()->json(['status'=>1,'id'=>$request->id]);

		});
    }

}
