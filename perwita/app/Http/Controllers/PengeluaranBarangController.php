<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\tb_coa;
use App\tb_jurnal;
use App\patty_cash;
use DB;
use Response;
Use Carbon\Carbon;
use Session;
use Mail;
use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;
// use Datatables;

use app\barang_terima;


class PengeluaranBarangController extends Controller
{

	public function index() {
		
		// return 'asd';
		$data = DB::table('pengeluaran_barang')
				  // ->where('pb_comp','001')
				  ->get();
		return view('purchase/pengeluaran_barang/index',compact('data'));
	}
	public function create() {

		$id = DB::table('pengeluaran_barang')
	    		->where('pb_comp','000')
	    		->max('pb_nota');

	    $year  = Carbon::now()->format('Y'); 
		$month = Carbon::now()->format('m');  	
		$now   = Carbon::now()->format('d/m/Y');
		
	   	if(isset($id)) {

			$explode = explode("/", $id);
		    $id = $explode[2];
			$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
			$string = (int)$id + 1;
			$id = str_pad($string, 3, '0', STR_PAD_LEFT);

		}

		else {
			$id = '001';
		}


		$first = Carbon::now();
	    $second = Carbon::now()->format('d/m/Y');
	    $start = $first->subDays(30)->startOfDay()->format('d/m/Y');

		$pb 	= 'SPPB-' . $month . $year . '/'. '000' . '/' .  $id;
		$cabang = DB::table('cabang')
					->get();
		$item   = DB::table('masteritem')
					->get();

        $gudang = DB::table('mastergudang')
            ->get();
        $kodecabang = session::get('cabang');
        $namacabang = DB::select(" SELECT nama FROM cabang WHERE kode = '$kodecabang' ");
        return view('purchase/pengeluaran_barang/create', compact('pb','now','cabang','item','gudang','kodecabang','namacabang'));
	}

	public function detail() {
		return view('purchase/pengeluaran_barang/detail');
	}

	public function cari_stock(request $request){
		$data = DB::select("SELECT sum(sg_qty) as sg_qty, unitstock	
								   from stock_gudang
								   join masteritem
								   on kode_item = sg_item
								   where sg_item = '$request->id'
								   group by unitstock");
		if ($data == null) {
			$data = 1;
		}
		$jenis = DB::table('masteritem')
				  ->where('kode_item',$request->id)
				  ->first();

		return response()->json(['data'=>$data,'jenis' => $jenis]);
	}

	public function save_pengeluaran(request $request){
		// dd($request);
		$valid = 0;
		if ($request->keperluan != '') {
			$valid += 1;
		}

		if ($request->peminta != '') {
			$valid += 1;
		}

		$array_table=[];
		$valid_table = 1;
		for ($i=0; $i < count($request->nama_barang); $i++) { 
			$array_table[$i] = $request->nama_barang[$i];
		}

		if (in_array('0', $array_table)) {
			$valid_table = 0;
		}
		// return $valid_table;
		if ($valid == 2 && $valid_table == 1) {
			
			$tgl = str_replace('/', '-', $request->tgl);
			$tgl = Carbon::parse($tgl)->format('Y-m-d');

			$cari_id = DB::table('pengeluaran_barang')
						 ->max('pb_id');

			if ($cari_id == null) {
				$cari_id = 1;
			}else{
				$cari_id += 1;
			}
			$save = DB::table('pengeluaran_barang')
						->insert([
							'pb_id' 	   		=> $cari_id,
							'pb_nota' 	   		=> $request->no_sppb,
							'pb_tgl'	   		=> $tgl,
							'pb_keperluan' 		=> $request->keperluan,
							'pb_peminta'   		=> $request->cabang_peminta,
							'pb_nama_peminta'   => $request->peminta,
							'created_at'   		=> Carbon::now(),
							'updated_at'   		=> Carbon::now(),
							'pb_status'   		=> 'Released',
							'pb_comp'			=> $request->cabang_penyedia,
							'pb_jenis_keluar'	=> $request->jp
						]);


			for ($i=0; $i < count($request->nama_barang); $i++) { 

				$cari_id_dt = DB::table('pengeluaran_barang_dt')
						 ->max('pbd_id');

				if ($cari_id_dt == null) {
					$cari_id_dt = 1;
				}else{
					$cari_id_dt += 1;
				}

				if ($request->stock_gudang[$i] != 0) {
					$save_dt = DB::table('pengeluaran_barang_dt')
								 ->insert([
								 	'pbd_id'	 		=> $cari_id_dt,
								 	'pbd_pb_id'	 		=> $cari_id,
								 	'pbd_pb_dt'	 		=> $i+1,
								 	'pbd_nama_barang'	=> $request->nama_barang[$i],
								 	'pbd_jumlah_barang' => $request->diminta[$i],						 	
								 	'pbd_nopol' 		=> $request->nopol[$i]					 	

								 ]);
				}
				
			}

			return response()->json(['status' => 1,
									 'id'	  => $cari_id]);
		}else{
			return response()->json(['status' => 0]);			
		}
	}

	public function hapus($id){
		$delete = DB::table('pengeluaran_barang')
					->where('pb_id',$id)
					->delete();
		$delete = DB::table('pengeluaran_barang_dt')
					->where('pbd_pb_id',$id)
					->delete();

	}

	public function edit($id){
		$data 	 = DB::table('pengeluaran_barang')
					->where('pb_id',$id)
					->first();
		$data_dt = DB::table('pengeluaran_barang_dt')
					->join('masteritem','kode_item','=','pbd_nama_barang')
					->where('pbd_pb_id',$id)
					->get();
		$tgl 	= Carbon::parse($data->pb_tgl)->format('d/m/Y');

		$cabang = DB::table('cabang')
					->get();
		$item   = DB::table('masteritem')
					->get();

		$count  = count($data_dt);
		return view('purchase/pengeluaran_barang/edit',compact('tgl','cabang','item','data','data_dt','count','id'));
	}

	public function update_pengeluaran(request $request,$id){

		$valid = 0;
		if ($request->keperluan != '') {
			$valid += 1;
		}

		if ($request->peminta != '') {
			$valid += 1;
		}

		$array_table=[];
		$valid_table = 1;
		for ($i=0; $i < count($request->nama_barang); $i++) { 
			$array_table[$i] = $request->nama_barang[$i];
		}

		if (in_array('0', $array_table)) {
			$valid_table = 0;
		}
		// return $valid_table;
		if ($valid == 2 && $valid_table == 1) {
			$this->hapus($id);
	        $this->save_pengeluaran($request);

	    	return response()->json(['status' => 1,
									 'id'	  => $id]);
		}else{

			return response()->json(['status' => 0]);			
		}
	}

	public function konfirmpengeluaranbarang() {
		$data = DB::table('pengeluaran_barang')
				// ->where('pb_comp','001')
				->get();


		return view('purchase/konfirmasi_pengeluaranbarang/index',compact('data'));
	}
	

	public function detailkonfirmpengeluaranbarang($id) {
		$data = DB::table('pengeluaran_barang')
				->where('pb_id',$id)
				->first();

		$tgl  = Carbon::parse($data->pb_tgl)->format('d/m/Y');

		$data_dt = DB::table('pengeluaran_barang_dt')
					->join('masteritem','kode_item','=','pbd_nama_barang')
					->where('pbd_pb_id',$id)
					->orderBy('pbd_pb_id',$id)
					->get();

		for ($i=0; $i < count($data_dt); $i++) { 
			$temp1[$i] = $data_dt[$i]->pbd_nama_barang;
		}
		// $gudang=[];
		for ($i=0; $i < count($data_dt); $i++) { 
			$temp[$i] = DB::select("SELECT sum(sg_qty) as sum from stock_gudang
									   where sg_item = '$temp1[$i]'");

		 	$gudang1[$i]   = DB::table('stock_gudang')
							  ->join('mastergudang','sg_gudang','=','mg_id')
							  ->select('mg_namagudang','mg_id','sg_id')
							  ->where('sg_item',$temp1[$i])
							  ->where('sg_cabang',$data->pb_comp)
							  // ->orderBy('mg_id')
							  ->orderBy('mg_id','ASC')
							  ->get();

			$jumlah1[$i]   = DB::select("SELECT sg_gudang, sg_qty as qty from
											   stock_gudang 
											   WHERE sg_cabang = '$data->pb_comp'
											   AND sg_item = '$temp1[$i]'
											   ORDER BY sg_gudang ASC");

			
		}

		// return $temp;


		for ($i=0; $i < count($gudang1); $i++) { 
			if ($gudang1[$i] == null) {
				$gudang[$i][0]['mg_namagudang'] = 'null';
				$gudang[$i][0]['mg_id'] = 'null';
				$gudang[$i][0]['sg_id'] = 'null';
				$jumlah[$i][0]['sg_gudang'] = 'null';
				$jumlah[$i][0]['qty'] = 0;
			}else{
				for ($a=0; $a < count($gudang1[$i]); $a++) { 
					// return $gudang[$i][$a]->mg_namagudang;
					$gudang[$i][$a]['mg_namagudang'] = $gudang1[$i][$a]->mg_namagudang;
					$gudang[$i][$a]['mg_id'] = $gudang1[$i][$a]->mg_id;		
					$gudang[$i][$a]['sg_id'] = $gudang1[$i][$a]->sg_id;
					$jumlah[$i][$a]['sg_gudang'] = $jumlah1[$i][$a]->sg_gudang;
					$jumlah[$i][$a]['qty'] = $jumlah1[$i][$a]->qty;;		
				}
			}
		}
		// return $gudang;	
		// return $jumlah;
		// $data_dt[1][0]->sum;
		return view('purchase/konfirmasi_pengeluaranbarang/detail',compact('data','temp','temp1','data_dt','tgl','jumlah','id','gudang'));
	}
	public function approve(request $request){
		// dd($request); 	

		$total = [];
		$data = DB::table('pengeluaran_barang')
			      // ->join('pengeluaran_barang_dt','pbd_pb_id','=','pb_id')
			      // ->join('pengeluaran_barang_gudang','pbg_pbd_id','=','pbd_id')
				  ->where('pb_id',$request->id)
				  ->first();
		for ($i=0; $i < count($request->pbd_nama_barang); $i++) { 
			// save pbg
			$cari_id_pbg = DB::table('pengeluaran_barang_gudang')
						 ->max('pbg_id');
			if ($cari_id_pbg == null) {
				$cari_id_pbg = 1;
			}else{
				$cari_id_pbg += 1;
			}
			$create_pbg = DB::table('pengeluaran_barang_gudang')
						->insert([
							'pbg_pbd_id' 	  => $request->pbd_id[$i],
							'pbg_pb_id' 	  => $request->id,
							'pbg_pbd_dt' 	  => $i+1,
							'pbg_kode_gudang' => $request->nama_gudang[$i],
							'pbg_pbd_qty' 	  => $request->jumlah_setuju[$i],
							'pbg_id' 		  => $cari_id_pbg,
							'pbg_comp' 		  => $data->pb_comp
						]);
			
			$cari_sm = DB::table('stock_mutation')
						 ->where('sm_stock',$request->sg_id[$i])
						 ->where('sm_sisa','!=','0')
						 ->where('sm_mutcat','=','1')
						 ->orderBy('sm_date','ASC')
						 ->get();
			$kurang = $request->jumlah_setuju[$i];
			for ($a=0; $a < count($cari_sm); $a++) { 

				$sisa = $cari_sm[$a]->sm_sisa - $kurang;
				if ($sisa < 0) {
					$sisa = 0;
				}

				$update_sm_sisa = DB::table('stock_mutation')
									->where('sm_id','=',$cari_sm[$a]->sm_id)
									->update([
										'sm_sisa' => $sisa
									]);

				$cari_sm_use = DB::table('stock_mutation')
						 ->where('sm_id','=',$cari_sm[$a]->sm_id)
						 ->first();

				$sm_use = $cari_sm[$a]->sm_qty - $cari_sm_use->sm_sisa;



				$update_sm_use = DB::table('stock_mutation')
									->where('sm_id','=',$cari_sm[$a]->sm_id)
									->update([
										'sm_use' => $sm_use
									]);

				$cari_sm_use = DB::table('stock_mutation')
						 ->where('sm_id','=',$cari_sm[$a]->sm_id)
						 ->first();


				if ($kurang > 0) {

					$cari_id_sm = DB::table('stock_mutation')
							    ->max('sm_id');

					$cari_id_sm += 1;

					$create_sm_mutation = DB::table('stock_mutation')
											->insert([
												'sm_stock'		=> $request->sg_id[$i],
												'sm_id'			=> $cari_id_sm,
												'sm_comp'		=> $data->pb_comp,
												'sm_date'		=> Carbon::now(),
												'sm_item'		=> $request->pbd_nama_barang[$i],
												'sm_mutcat'		=> 2,
												'sm_qty'		=> $cari_sm_use->sm_use,
												'sm_use'		=> $cari_sm_use->sm_use,
												'sm_hpp'		=> $cari_sm_use->sm_hpp,
												'sm_spptb'		=> $data->pb_nota,
												'created_at'	=> Carbon::now(),
												'updated_at'	=> Carbon::now(),
												'sm_po'			=> $cari_id_pbg,
												'sm_id_gudang'	=> $request->nama_gudang[$i],
												'sm_sisa'		=> 0,
												'sm_flag'		=> 'PBG'
											]);
					$psm_id = DB::table('pengeluaran_stock_mutasi')
								->max('psm_id');

					if ($psm_id != null) {
						$psm_id += 1;
					}else{
						$psm_id =  1;
					}

					$create_psm = DB::table('pengeluaran_stock_mutasi')
											->insert([
												'psm_id'    => $psm_id,
												'psm_harga' => $cari_sm_use->sm_hpp,
												'psm_sm_id' => $cari_id_sm,
												'psm_qty'   => $cari_sm_use->sm_use,
												'psm_item'  => $cari_sm_use->sm_item,
												'psm_sm_po' => $cari_sm[$a]->sm_po
											]);

					$cari_sm_keluar = DB::table('stock_mutation')
									->where('sm_id',$cari_id_sm)
									->first();
					$temp      = round($cari_sm_keluar->sm_qty * $cari_sm_keluar->sm_hpp,2);
		
					array_push($total, $temp);
				}	
				
				$cari_kurang = DB::table('stock_mutation')
						 ->where('sm_id','=',$cari_sm[$a]->sm_id)
						 ->first();

				$kurang -= $cari_kurang->sm_use;

				

				
			}

			

			$cari_stock = DB::table('stock_gudang')
								->where('sg_id',$request->sg_id[$i])
								->first();
			$stock = $cari_stock->sg_qty-$request->jumlah_setuju[$i];
			$update_stock = DB::table('stock_gudang')
								->where('sg_id',$request->sg_id[$i])
								->update([
									'sg_qty' => $stock
								]);


			
		}



		$total1 = array_sum($total);
		$setuju = DB::table('pengeluaran_barang')
					->where('pb_id',$request->id)
					->update([
						'pb_status' => 'Approved',
						'pb_total' => $total1
					]);

		$jml_setuju = [];
		for ($i=0; $i < count($request->pbd_id1); $i++) { 
			$temp1 = 0;
			for ($a=0; $a < count($request->pbd_id); $a++) { 
				if ($request->pbd_id[$a] == $request->pbd_id1[$i]) {
					$temp1 += $request->jumlah_setuju[$a];
				}
			}
			// return $temp1;
			$setuju_dt = DB::table('pengeluaran_barang_dt')
					->where('pbd_pb_id',$request->id)
					->update([
						'pbd_disetujui' => $temp1,
						'pbd_keterangan' => $request->Keterangan[$i]
			]);
		}


			

		return response()->json(['status'=>1]);
	}

	public function printing($id){
		$data = DB::table('pengeluaran_barang')
				  ->where('pb_id',$id)
				  ->first();
		$data_dt = DB::table('pengeluaran_barang_dt')
					->join('masteritem','kode_item','=','pbd_nama_barang')
					->where('pbd_pb_id',$id)
					->get();


		$tgl 	= Carbon::parse($data->pb_tgl)->format('d/m/Y');


		return view('purchase/konfirmasi_pengeluaranbarang/printout',compact('data','data_dt','tgl'));
	}

	public function stockopname() {

		$data = DB::table('stock_opname')
				  ->join('mastergudang','mg_id','=','so_gudang')
				  ->get();
		for ($i=0; $i < count($data); $i++) { 
			$tgl[$i] = Carbon::parse($data[$i]->so_bulan)->format('F');
		}


		return view('purchase/stock_opname/index',compact('data','tgl'));
	}

	public function createstockopname() {

		$cabang  = DB::table('mastergudang')
					 ->get();
		$now = Carbon::now()->format('F');

		$id = DB::table('stock_opname')
	    		->where('so_comp','000')
	    		->max('so_nota');

	    $year  = Carbon::now()->format('Y'); 
		$month = Carbon::now()->format('m');  	
		$now   = Carbon::now()->format('d/m/Y');
		
	   	if(isset($id)) {

			$explode = explode("/", $id);
		    $id = $explode[2];
			$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
			$string = (int)$id + 1;
			$id = str_pad($string, 3, '0', STR_PAD_LEFT);

		}

		else {
			$id = '001';
		}


		$first = Carbon::now();
	    $second = Carbon::now()->format('d/m/Y');
	    $start = $first->subDays(30)->startOfDay()->format('d/m/Y');

		$pb  = 'SO-' . $month . $year . '/'. '000' . '/' .  $id;
		return view('purchase/stock_opname/create',compact('cabang','now','pb'));
	}


	public function detailstockopname() {
		return view('purchase/stock_opname/detail');
	}

	
	public function cari_sm($id){

		$data = DB::table('stock_gudang')
				  ->join('masteritem','kode_item','=','sg_item')
				  ->where('sg_gudang',$id)
				  ->get();


		return response()->json([
							'data' => $data
						   ]);
	}



	public function save_stock_opname(request $request){
		// dd($request->all());	
		$tgl = Carbon::parse($request->tgl)->format('Y-m-d');
		$gudang = DB::table('mastergudang')
					 ->where('mg_id',$request->cabang)
					 ->first();
		$cari_max_id = DB::table('stock_opname')
					     ->max('so_id');
		if ($cari_max_id != null) {
			$cari_max_id += 1;
		}else{
			$cari_max_id = 1;
		}

		if (in_array('lebih', $request->status) || in_array('kurang', $request->status)) {
			$status = 'TIDAK';
		}else{
			$status = 'SESUAI';
		}

		// return $status;
		$save_stock_opname = DB::table('stock_opname')
							   ->insert([
							   	'so_id'       => $cari_max_id,
							   	'so_gudang'   => $request->cabang,
							   	'so_bulan'    => $tgl,
							   	'so_nota'     => $request->so,
							   	'so_comp'     => $gudang->mg_cabang,
							   	'so_user'  	  => 'inori',
								'so_status'   => $status,
							   	'created_at'  => Carbon::now(),
							   	'updated_at'  => Carbon::now()	
							]);

		for ($i=0; $i < count($request->id_stock); $i++) { 


			if ($request->status[$i] == 'lebih') {

				$cari_max_id_dt = DB::table('stock_opname_dt')
					     		->max('sod_id');

				if ($cari_max_id_dt != null) {
					$cari_max_id_dt += 1;
				}else{
					$cari_max_id_dt = 1;
				}

				$cari_max_sm = DB::table('stock_mutation')
						     		->max('sm_id');

				if ($cari_max_sm != null) {
					$cari_max_sm += 1;
				}else{
					$cari_max_sm = 1;
				}


				$stock = DB::table('stock_mutation')
						   ->where('sm_stock',$request->id_stock[$i])
						   ->where('sm_mutcat',1)
						   ->where('sm_flag','PO')
						   ->orderBy('sm_date','ASC')
						   ->get();

				$insert_data = DB::table('stock_mutation')
										->insert([
											'sm_id' 		=> $cari_max_sm,
											'sm_stock'		=> $request->id_stock[$i],
											'sm_comp'		=> $gudang->mg_cabang,
											'sm_date'   	=> Carbon::now(),
											'sm_item'		=> $request->sg_item[$i],
											'sm_mutcat' 	=> 1,
											'sm_qty'		=> $request->val_status[$i],
											'sm_use'		=> 0,
											'sm_hpp'		=> $stock[0]->sm_hpp,
											'sm_spptb'		=> $request->so,
											'created_at'	=> Carbon::now(),
											'updated_at'	=> Carbon::now(),
											'sm_po'			=> $cari_max_id,
											'sm_id_gudang'  => $stock[0]->sm_id_gudang,
											'sm_sisa'		=> $request->val_status[$i],
											'sm_flag'		=> 'SO+'
										]);

				$cari_stock_gudang = DB::table('stock_gudang')
									   ->where('sg_id',$request->id_stock[$i])
									   ->first();
				$pengurangan_stock = $cari_stock_gudang->sg_qty + $request->val_status[$i];

				$update_stock = DB::table('stock_gudang')
								  ->where('sg_id',$request->id_stock[$i])
								  ->update([
								  	'sg_qty'  =>   $pengurangan_stock
								  ]);

			}else if($request->status[$i] == 'kurang'){

				$stock = DB::table('stock_mutation')
						   ->where('sm_stock',$request->id_stock[$i])
						   ->where('sm_mutcat',1)
						   ->where('sm_sisa','!=',0)
						   ->where('sm_flag','PO')
						   ->orderBy('sm_date','ASC')
						   ->get();
				$kurang = $request->val_status[$i];
				for ($a=0; $a < count($stock); $a++) { 

					$sm_sisa = $stock[$a]->sm_sisa - $request->val_status[$i];

					if($sm_sisa < 0){
						$sm_sisa = 0;
					}

					$update_sm = DB::table('stock_mutation')
								   ->where('sm_id',$stock[$a]->sm_id)
								   ->update([
								   	'sm_sisa' => $sm_sisa,
								   ]);

					$cari_sm_use = DB::table('stock_mutation')
								   ->where('sm_id',$stock[$a]->sm_id)
								   ->first();

					$sm_use = $cari_sm_use->sm_qty - $cari_sm_use->sm_sisa;

					$update_sm_use = DB::table('stock_mutation')
									   ->where('sm_id',$cari_sm_use->sm_id)
									   ->update([
									   	'sm_use' => $sm_use
									   ]);
					$cari_sm_last = DB::table('stock_mutation')
									  ->where('sm_id',$cari_sm_use->sm_id)
									  ->first();

					if ($kurang > 0) {

						$cari_id_sm = DB::table('stock_mutation')
							    ->max('sm_id');

						$cari_id_sm += 1;

						$create_sm_mutation = DB::table('stock_mutation')
												->insert([
													'sm_stock'		=> $stock[$a]->sm_stock,
													'sm_id'			=> $cari_id_sm,
													'sm_comp'		=> $gudang->mg_cabang,
													'sm_date'		=> Carbon::now(),
													'sm_item'		=> $request->sg_item[$i],
													'sm_mutcat'		=> 2,
													'sm_qty'		=> $request->val_status[$i],
													'sm_use'		=> $request->val_status[$i],
													'sm_hpp'		=> $cari_sm_last->sm_hpp,
													'sm_spptb'		=> $request->so,
													'created_at'	=> Carbon::now(),
													'updated_at'	=> Carbon::now(),
													'sm_po'			=> $cari_max_id,
													'sm_id_gudang'	=> $request->nama_gudang[$i],
													'sm_sisa'		=> 0,
													'sm_flag'		=> 'SO-'
												]);
					}

					$cari_kurang = DB::table('stock_mutation')
						 ->where('sm_id','=',$cari_sm_last->sm_id)
						 ->first();

					$kurang -= $cari_kurang->sm_use;

				}

				$cari_stock_gudang = DB::table('stock_gudang')
									   ->where('sg_id',$request->id_stock[$i])
									   ->first();
				$pengurangan_stock = $cari_stock_gudang->sg_qty - $request->val_status[$i];

				$update_stock = DB::table('stock_gudang')
								  ->where('sg_id',$request->id_stock[$i])
								  ->update([
								  	'sg_qty'  =>   $pengurangan_stock
								  ]);


			}

		}

		

			for ($i=0; $i < count($request->sg_item); $i++) { 

				$cari_max_sod = DB::table('stock_opname_dt')
							  ->max('sod_id');

				if ($cari_max_sod != null) {
					$cari_max_sod += 1;
				}else{
					$cari_max_sod = 1;
				}

				$save_stock_opname_dt = DB::table('stock_opname_dt')
							   ->insert([
							   	'sod_id'       		=> $cari_max_sod,
							   	'sod_so_id'    		=> $cari_max_id,
							   	'sod_so_dt'    		=> $i+1,
							   	'sod_item'     		=> $request->sg_item[$i],
							   	'sod_jumlah_stock'  => $request->stock[$i],
							   	'sod_jumlah_real'   => $request->real[$i],
							   	'sod_status'  	  	=> $request->status[$i],
							   	'sod_jumlah_status' => $request->val_status[$i],
							   	'sod_keterangan'  	=> $request->keterangan[$i],
							   	'created_at'   		=> Carbon::now(),
							   	'updated_at'   		=> Carbon::now()	
							]);
			}	

			return response()->json(['status' => 1]);			  
			
	}

	public function berita_acara($id){
		$data = DB::table('stock_opname')
				  ->join('stock_opname_dt','sod_so_id','=','so_id')
				  ->join('masteritem','kode_item','=','sod_item')
				  ->where('so_id',$id)
				  ->get();
		return view('purchase/stock_opname/beritaacara',compact('data','tgl'));
	}

    public function get_gudang(Request $request){
//dd($request);
        $req_gudang = $request->gudang;
        $mastergudang = DB::select(DB::raw(" SELECT mg_id,mg_namagudang,mg_cabang FROM mastergudang WHERE mg_cabang = '$req_gudang' ORDER BY mg_namagudang ASC "));
        return $mastergudang;
    }
}
