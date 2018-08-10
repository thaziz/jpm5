<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\tb_coa;
use App\d_jurnal;
use App\d_jurnal_dt;
use App\tb_jurnal;
use App\patty_cash;
use DB;
use Response;
Use Carbon\Carbon;
use Session;
use Mail;
use Auth;
use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;
// use Datatables;

use App\barang_terima;


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
		$now   = Carbon::now()->format('d/m/Y');

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

	public function ganti_nota(request $req)
	{
		$bulan = Carbon::now()->format('m');
	    $tahun = Carbon::now()->format('y');

	    $cari_nota = DB::select("SELECT  substring(max(bkk_nota),14) as id from bukti_kas_keluar
	                                    WHERE bkk_comp = '$req->cabang'
	                                    AND to_char(bkk_tgl,'MM') = '$bulan'
	                                    AND to_char(bkk_tgl,'YY') = '$tahun'");

	    $index = (integer)$cari_nota[0]->id + 1;
	    $index = str_pad($index, 4, '0', STR_PAD_LEFT);

		
		$nota = 'SPPB' . $bulan . $tahun . '/' . $req->cabang . '/' .$index;

		return response()->json(['nota'=>$nota]);
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
								   and sg_cabang = '$request->cabang'
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
   		return DB::transaction(function() use ($request) {  

   			$cab = DB::table('cabang')
   					 ->where('kode',$request->cabang)
   					 ->first();
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
								'pb_comp'			=> $request->cabang,
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

					$kodeitem = $request->nama_barang[$i];
					$cabang = $request->cabang;

					$dataitem = DB::select("select * from masteritem where kode_item = '$kodeitem'");
					$accpersediaan2 = $dataitem[0]->acc_persediaan;

					$accpersediaan = substr($accpersediaan2, 0,4);
					$jenisitem = substr($kodeitem, 0,1);


					$datakun2 = DB::select("select * from d_akun where id_akun LIKE '$accpersediaan%' and kode_cabang = '$cabang'");

					$akunpersediaan = $datakun2[0]->id_akun;

					if($jenisitem == 'P'){
						$akunbiaya = DB::select("select * from d_akun where id_akun LIKE '5111%' and kode_cabang = '$cabang'");
					}
					else if($jenisitem == 'S'){
						$akunbiaya = DB::select("select * from d_akun where id_akun LIKE '5106%' and  kode_cabang = '$cabang'  or id_akun LIKE '5206%' and  kode_cabang = '000' or id_akun LIKE '5306%' and  kode_cabang = '$cabang' ");
					}
					else if($jenisitem == 'A'){
						if ($cab->kode == '000') {
							$akunbiaya = DB::select("select * from d_akun where id_akun LIKE '7105%' and kode_cabang = '$cabang'");
						}else{
							$akunbiaya = DB::select("select * from d_akun where id_akun LIKE '6103%' and kode_cabang = '$cabang'");
						}
					}
					else if($jenisitem == 'C'){
						$akunbiaya = DB::select("select * from d_akun where id_akun LIKE '1604%' and kode_cabang = '$cabang'");
					}
					else {
						$akunbiaya = DB::select("select * from d_akun where kode_cabang = '$cabang' ");
					}

					$akunbiaya2 = $akunbiaya[0]->id_akun;

					if ($request->stock_gudang[$i] != 0) {
						$save_dt = DB::table('pengeluaran_barang_dt')
									 ->insert([
									 	'pbd_id'	 		=> $cari_id_dt,
									 	'pbd_pb_id'	 		=> $cari_id,
									 	'pbd_pb_dt'	 		=> $i+1,
									 	'pbd_nama_barang'	=> $request->nama_barang[$i],
									 	'pbd_jumlah_barang' => $request->diminta[$i],
									 	'pbd_nopol' 		=> $request->nopol[$i],
									 	'pbd_akunhutangpersediaan' => $akunpersediaan,
									 	'pbd_akunhutangbiaya' => $akunbiaya2,
									 ]);
					}
					
				}

				return response()->json(['status' => 1,
										 'id'	  => $cari_id]);
			}else{
				return response()->json(['status' => 0]);			
			}
		});
	}

	public function hapus($id){
		$delete = DB::table('pengeluaran_barang')
					->where('pb_id',$id)
					->delete();
		$delete = DB::table('pengeluaran_barang_dt')
					->where('pbd_pb_id',$id)
					->delete();
		return redirect()->back();
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
		return view('purchase/konfirmasi_pengeluaranbarang/detail',compact('data','temp','temp1','data_dt','tgl','jumlah','id','gudang'));
	}
	public function approve(request $request){
		// dd($request->all()); 	
   		return DB::transaction(function() use ($request) {  

   		$datajurnal = [];
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
			if ($request->jumlah_setuju[$i] == '') {
				$request->jumlah_setuju[$i] = 0;
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
			
			//save barang terima
			$lastid = barang_terima::max('bt_id'); 

			if(isset($lastid)) {
				$idbarangterima = $lastid;
				$idbarangterima = (int)$idbarangterima + 1;
				
			}
			else {
				$idbarangterima = 1;
				
			}	
				$idtransaksi = $request->id;
				$datapb = DB::select("select * from pengeluaran_barang where pb_id = '$idtransaksi'");
				$idsupplier = $datapb[0]->pb_comp;
				$jeniskeluar = $datapb[0]->pb_jenis_keluar;
				
				if($jeniskeluar == 'Moving Gudang') {
					$barangterima = new barang_terima();
					$barangterima->bt_id = $idbarangterima;
					$barangterima->bt_flag = 'PBG';
					$barangterima->bt_notransaksi = $datapb[0]->pb_nota;
					$barangterima->bt_agen = $idsupplier;
					$barangterima->bt_idtransaksi = $idtransaksi;
					$barangterima->bt_statuspenerimaan = 'BELUM DI TERIMA';
					$barangterima->bt_gudang = $request->nama_gudang[$i];
					$barangterima->bt_tipe = 'S';
					$barangterima->bt_cabangpo = $datapb[0]->pb_peminta;
					$barangterima->save();

				}



			$cari_sm = DB::table('stock_mutation')
						 ->where('sm_stock',$request->sg_id[$i])
						 ->where('sm_sisa','!=','0')
						 ->where('sm_mutcat','=','1')
						 ->orderBy('sm_date','ASC')
						 ->get();
						 
			$kurang = $request->jumlah_setuju[$i];

			for ($a=0; $a < count($cari_sm); $a++) { 

				$sisa = $cari_sm[$a]->sm_sisa - $kurang;
				$pengurangan_sisa = $kurang - $cari_sm[$a]->sm_sisa;
				if ($pengurangan_sisa<0) {
					$pengurangan_sisa = 0;
				}
				
				$sm_use_new = $kurang - $pengurangan_sisa;
				if ($sisa < 0) {
					$sisa = 0;
				}

				if ($pengurangan_sisa < 0) {
					$pengurangan_sisa = 0;
				}
				// dd($pengurangan_sisa);

				$update_sm_sisa = DB::table('stock_mutation')
									->where('sm_id','=',$cari_sm[$a]->sm_id)
									->update([
										'sm_sisa' => $sisa
									]);

				$cari_sm_use = DB::table('stock_mutation')
						 ->where('sm_id','=',$cari_sm[$a]->sm_id)
						 ->first();

				$sm_use = $cari_sm_use->sm_qty - $cari_sm_use->sm_sisa;



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
												'sm_qty'		=> $sm_use_new,
												'sm_use'		=> $sm_use_new,
												'sm_hpp'		=> $cari_sm_use->sm_hpp,
												'sm_spptb'		=> $data->pb_nota,
												'created_at'	=> Carbon::now(),
												'updated_at'	=> Carbon::now(),
												'created_by'	=> Auth::user()->m_name,
												'updated_by'	=> Auth::user()->m_name,
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
												'psm_pb_id' => $request->id,
												'psm_harga' => $cari_sm_use->sm_hpp,
												'psm_sm_id' => $cari_id_sm,
												'psm_qty'   => $sm_use_new,
												'psm_item'  => $cari_sm_use->sm_item,
												'psm_total' => $cari_sm_use->sm_hpp * $cari_sm_use->sm_use,
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

				$kurang = $pengurangan_sisa;
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

		if($jeniskeluar == 'Pemakaian Reguler'){
				$hppsm = DB::select("select * from pengeluaran_stock_mutasi where psm_pb_id = '$idtransaksi'");

				//return $hppsm;

				$datapb = DB::select("select * from pengeluaran_barang where pb_id = '$idtransaksi'");

				$datapbd = DB::select("select * from pengeluaran_barang , pengeluaran_barang_dt where pb_id = '$idtransaksi' and pbd_pb_id = pb_id");
				for($i = 0; $i < count($datapbd); $i++){
					$item = $datapbd[$i]->pbd_nama_barang;
					//return $item;
					$hppsm = DB::select("select * from pengeluaran_stock_mutasi where psm_item = '$item' and psm_pb_id = '$idtransaksi'");

					$hppitem = 0;
					//return count($hppsm);
					for($j =0; $j < count($hppsm); $j++){
						$harga = $hppsm[$j]->psm_harga;
						$qty = $hppsm[$j]->psm_qty;
						
						$hppitem = floatval($harga) * floatval($qty);						
					//	return $hppitem;
					}


					$dataakun = array (
						'id_akun' => $datapbd[$i]->pbd_akunhutangpersediaan,
						'subtotal' => $hppitem,
						'dk' => 'D',
						'detail' => $datapb[0]->pb_keperluan,
					);	

					array_push($datajurnal, $dataakun);
				}

				for($m = 0; $m < count($datapbd); $m++){
					$item = $datapbd[$m]->pbd_nama_barang;
					$hppsm = DB::select("select * from pengeluaran_stock_mutasi where psm_item = '$item'");
					$hppitem = 0;
					for($j =0; $j < count($hppsm); $j++){
						$harga = $hppsm[$j]->psm_harga;
						$qty = $hppsm[$j]->psm_qty;
						
						$hppitem = floatval($harga) * floatval($qty);
					}

					$dataakun = array (
						'id_akun' => $datapbd[$m]->pbd_akunhutangbiaya,
						'subtotal' => $hppitem,
						'dk' => 'D',
						'detail' => $datapb[0]->pb_keperluan,
					);	

					array_push($datajurnal, $dataakun);
				}
				
				//return $datajurnal;

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
			        $jurnal->jr_detail = 'PENGELUARAN BARANG GUDANG';
			        $jurnal->jr_ref = $datapb[0]->pb_nota;
			        $jurnal->jr_note = $datapb[0]->pb_keperluan;
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
					
			}	

		return response()->json(['status'=>1]);
	});
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

	/*	$data['brggudang'] = DB::select("select * from stock_gudang where ")*/


		return view('purchase/stock_opname/index',compact('data','tgl'));
	}

	public function createstockopname() {

		$cabang  = DB::table('cabang')
					 ->get();
		$gudang = DB::table('mastergudang')
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
			$id = str_pad($string, 4, '0', STR_PAD_LEFT);

		}

		else {
			$id = '0001';
		}


		$first = Carbon::now();
	    $second = Carbon::now()->format('d/m/Y');
	    $start = $first->subDays(30)->startOfDay()->format('d/m/Y');

		$pb  = 'SO-' . $month . $year . '/'. '000' . '/' .  $id;

		
		return view('purchase/stock_opname/create',compact('cabang','now','pb'));
	}


	public function getnotaopname(Request $request){
		$cabang = $request->comp;
		$bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('y');

		//return $mon;
		$idnota = DB::select("select * from stock_opname where so_comp = '$cabang'  and to_char(so_tgl, 'MM') = '$bulan' and to_char(so_tgl, 'YY') = '$tahun' order by so_id desc limit 1");

	//	$idspp =   spp_purchase::where('spp_cabang' , $request->comp)->max('spp_id');
		if(count($idnota) != 0) {
		
			$explode = explode("/", $idnota[0]->so_nota);
			$idnota = $explode[2];

			$string = (int)$idnota + 1;
			$idnota = str_pad($string, 4, '0', STR_PAD_LEFT);
		}

		else {
		
			$idnota = '0001';
		}


		$datainfo =['status' => 'sukses' , 'data' => $idnota];
		return json_encode($datainfo) ;
	}

	public function detailstockopname() {
		return view('purchase/stock_opname/detail');
	}

	
	public function cari_sm(Request $request){
		$idgudang = $request->idgudang;
		$idcabang = $request->idcabang;

		$data = DB::table('stock_gudang')
				  ->join('masteritem','kode_item','=','sg_item')
				  ->where('sg_gudang',$idgudang)
				  ->where('sg_cabang' , $idcabang )
				  ->get();


		return response()->json([
							'data' => $data
						   ]);
	}



	public function save_stock_opname(request $request){
		/*dd($request->all());	*/
		
		/*$explode = explode("/", $request->tgl);
		$tgl = $explode[1];*/
		return DB::transaction(function() use ($request) {  
			$gudang = DB::table('mastergudang')
					 ->where('mg_id',$request->cabang2)
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
		$today = date("Y-m-d");
		$save_stock_opname = DB::table('stock_opname')
							   ->insert([
							   	'so_id'       => $cari_max_id,
							   	'so_gudang'   => $request->gudang,
							   	'so_bulan'    => $request->tgl,
							   	'so_nota'     => $request->so,
							   	'so_comp'     => $request->cabang2,
							   	'so_user'  	  => $request->username,
								'so_status'   => $status,
							   	'created_at'  => Carbon::now(),
							   	'updated_at'  => Carbon::now(),
							   	'so_tgl'      => $today,
							   	'create_by'   => $request->username,
							   	'update_by'   => $request->username,
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
						   ->where('sm_stock', '=' , $request->id_stock[$i])
						   ->where('sm_mutcat', '=' ,1)
						   ->where('sm_flag','=','PO')
						   ->where('sm_sisa','<>' , 0 )
						   ->orderBy('sm_id', '=' ,'ASC')
						   ->get();

				$insert_data = DB::table('stock_mutation')
										->insert([
											'sm_id' 		=> $cari_max_sm,
											'sm_stock'		=> $request->id_stock[$i],
											'sm_comp'		=> $request->cabang2,
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
											'sm_flag'		=> 'SO+',
											'created_by'		=> $request->username,
											'updated_by'		=> $request->username,
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
						   ->where('sm_stock', '=' , $request->id_stock[$i])
						   ->where('sm_mutcat', '=' , 1)
						   ->where('sm_sisa','!=',0)
						   ->where('sm_flag', '=' ,'PO')
						   ->orderBy('sm_id', '=' , 'ASC')
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
								   	'updated_by' => $request->username,
								   ]);

					$cari_sm_use = DB::table('stock_mutation')
								   ->where('sm_id',$stock[$a]->sm_id)
								   ->first();

					$sm_use = $cari_sm_use->sm_qty - $cari_sm_use->sm_sisa;

					$update_sm_use = DB::table('stock_mutation')
									   ->where('sm_id',$cari_sm_use->sm_id)
									   ->update([
									   	'sm_use' => $sm_use,
									   	'updated_by' => $request->username,
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
													'sm_comp'		=> $request->cabang,
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
													'sm_flag'		=> 'SO-',
													'created_by' 	=> $request->username,
													'updated_by' => $request->username,
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

				$item = $request->sg_item[$i];
				$cabang = $request->cabang2;
				$gudang = $request->gudang;

				$dataselisih = DB::select("select * from stock_mutation where sm_item = '$item' and sm_mutcat = '1' and sm_comp = '$cabang' and sm_id_gudang = '$gudang' and sm_sisa != '0' order by sm_id asc");

				return $dataselisih;
				$selisihharga = $dataselisih[0]->sm_hpp;
				$harga = $request->val_status[$i] * $selisihharga;
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
							   	'updated_at'   		=> Carbon::now(),
							   	'sod_hargaselisih'  => $harga,	
							]);
			}	

			return response()->json(['status' => 1]);	

		});
				  
			
	}

	public function berita_acara($id){
		 $data['stockopname'] = DB::select("select * from stock_opname, mastergudang where so_id = '$id' and so_gudang = mg_id");
        for ($i=0; $i < count($data['stockopname']); $i++) { 
            $data['tgl'][$i] = Carbon::parse($data['stockopname'][$i]->so_bulan)->format('F');
        }

        $data['stockopname_dt'] = DB::select("select * from stock_opname_dt, masteritem where sod_so_id = '$id' and sod_item = kode_item");

		return view('purchase/stock_opname/print_berita_acara',compact('data'));
	}

    public function get_gudang(Request $request){
//dd($request);
        $req_gudang = $request->gudang;
        $mastergudang = DB::select(DB::raw(" SELECT mg_id,mg_namagudang,mg_cabang FROM mastergudang WHERE mg_cabang = '$req_gudang' ORDER BY mg_namagudang ASC "));
        return $mastergudang;
    }
}
