<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
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
use Auth;
use Yajra\Datatables\Datatables;
use App\d_jurnal;
use App\d_jurnal_dt;
// use Datatables;


class kasKeluarController extends Controller
{


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

	public function index(){
		$cabang = Auth::user()->kode_cabang;
		if (Auth::user()->punyaAkses('Bukti Kas Keluar','all')) {
			$data = DB::table('bukti_kas_keluar')
				  ->join('jenisbayar','idjenisbayar','=','bkk_jenisbayar')
				  ->join('cabang','kode','=','bkk_comp')
				  ->orderBy('bkk_id','ASC')
				  ->get();
		}else{
			$data = DB::table('bukti_kas_keluar')
				  ->join('jenisbayar','idjenisbayar','=','bkk_jenisbayar')
				  ->join('cabang','kode','=','bkk_comp')
				  ->where('kode',$cabang)
				  ->orderBy('bkk_id','ASC')
				  ->get();
		}
		
		return view('purchase.buktikaskeluar.indexKasKeluar',compact('data'));
	}

	

	public function create()
	{
		$cabang = DB::table('cabang')
					->get();

		$jenis_bayar = DB::table('jenisbayar')
						 ->where('idjenisbayar','!=',1)
						 ->where('idjenisbayar','!=',5)
						 ->where('idjenisbayar','!=',10)
						 ->orderBy('idjenisbayar','ASC')
						 ->get();
		$now  = carbon::now()->format('d/m/Y');

		
						 
		return view('purchase.buktikaskeluar.createKasKeluar',compact('cabang','jenis_bayar','now'));
	}

	public function nota_bukti_kas(request $req)
	{
		$bulan = Carbon::now()->format('m');
	    $tahun = Carbon::now()->format('y');

	    $cari_nota = DB::select("SELECT  substring(max(bkk_nota),13) as id from bukti_kas_keluar
	                                    WHERE bkk_comp = '$req->cabang'
	                                    AND to_char(created_at,'MM') = '$bulan'
	                                    AND to_char(created_at,'YY') = '$tahun'");

	    $index = (integer)$cari_nota[0]->id + 1;
	    $index = str_pad($index, 3, '0', STR_PAD_LEFT);

		
		$nota = 'BKK' . $bulan . $tahun . '/' . $req->cabang . '/' .$index;

		return response()->json(['nota'=>$nota]);
	}

	public function akun_kas_dropdown(request $req)
	{
		$akun = DB::table('d_akun')
					  ->where('kode_cabang',$req->cabang)
					  ->where('id_akun','like','1001'.'%')
					  ->get();
		return view('purchase.buktikaskeluar.akun_kas_dropdown',compact('akun'));
	}

	

	public function akun_biaya_dropdown(request $req)
	{
		$akun = DB::table('master_akun_fitur')
				  ->where('maf_group','1')
				  ->where('maf_cabang',$req->cabang)
				  ->get();

		return view('purchase.buktikaskeluar.akun_biaya_dropdown',compact('akun'));
	}

	public function supplier_dropdown(request $req)
	{	
		if (isset($req->sup)) {
			$sup = $req->sup;
		}else{
			$sup = 0;
		}
		if ($req->jenis_bayar == 2) {
			$all = DB::select("SELECT no_supplier as kode, nama_supplier as nama from supplier where status = 'SETUJU' and active = 'AKTIF' order by no_supplier");
			return view('purchase.buktikaskeluar.supplier_dropdown',compact('all','sup'));
		} elseif($req->jenis_bayar == 3){
			$agen 	  = DB::select("SELECT kode, nama from agen order by kode");

			$vendor   = DB::select("SELECT kode, nama from vendor order by kode "); 

			$subcon   = DB::select("SELECT kode, nama from subcon order by kode "); 

			$supplier = DB::select("SELECT no_supplier as kode, nama_supplier as nama from supplier where status = 'SETUJU' and active = 'AKTIF' order by no_supplier");

			$all = array_merge($agen,$vendor,$subcon,$supplier);
			return view('purchase.buktikaskeluar.supplier_dropdown',compact('all','sup'));
		} elseif($req->jenis_bayar == 4){
			$agen 	  = DB::select("SELECT kode, nama from agen order by kode");

			$vendor   = DB::select("SELECT kode, nama from vendor order by kode "); 

			$subcon   = DB::select("SELECT kode, nama from subcon order by kode "); 

			$supplier = DB::select("SELECT no_supplier as kode, nama_supplier as nama from supplier where status = 'SETUJU' and active = 'AKTIF' order by no_supplier");

			$all = array_merge($agen,$vendor,$subcon,$supplier);
			return view('purchase.buktikaskeluar.supplier_dropdown',compact('all','sup'));
		} elseif($req->jenis_bayar == 6){
			$agen 	  = DB::select("SELECT kode, nama from agen where kategori != 'OUTLET' order by kode");

			$vendor   = DB::select("SELECT kode, nama from vendor order by kode "); 

			$all = array_merge($agen,$vendor);

			return view('purchase.buktikaskeluar.supplier_dropdown',compact('all','sup'));
		} elseif($req->jenis_bayar == 7){
			$all 	  = DB::select("SELECT kode, nama from agen where kategori = 'OUTLET' or kategori = 'AGEN DAN OUTLET' order by kode ASC");

			return view('purchase.buktikaskeluar.supplier_dropdown',compact('all','sup'));
		} elseif($req->jenis_bayar == 9){
			$all   = DB::select("SELECT kode, nama from subcon order by kode "); 

			return view('purchase.buktikaskeluar.supplier_dropdown',compact('all','sup'));
		}
	}

	public function save_patty(request $req)
	{
		return DB::transaction(function() use ($req) {  

			// dd($req->all());
			$cari_nota = DB::table('bukti_kas_keluar')
						   ->where('bkk_nota',$req->nota)
						   ->first();

			$user = Auth::user()->m_name;

			if (Auth::user()->m_name == null) {
				return response()->json([
					'status'=>1,
					'message'=>'Nama User Anda Belum Ada, Silahkan Hubungi Pihak Terkait'
				]);
			}

			$cari_nota = DB::table('bukti_kas_keluar')
						   ->where('bkk_nota',$req->nota)
						   ->first();
			if ($cari_nota != null) {
				if ($cari_nota->updated_by == $user) {
					return 'Data Sudah Ada';
				}else{
					$bulan = Carbon::now()->format('m');
				    $tahun = Carbon::now()->format('y');

				    $cari_nota = DB::select("SELECT  substring(max(bkk_nota),13) as id from bukti_kas_keluar
				                                    WHERE bkk_comp = '$req->cabang'
				                                    AND to_char(created_at,'MM') = '$bulan'
				                                    AND to_char(created_at,'YY') = '$tahun'");

				    $index = (integer)$cari_nota[0]->id + 1;
				    $index = str_pad($index, 3, '0', STR_PAD_LEFT);

					
					$nota = 'BKK' . $bulan . $tahun . '/' . $req->cabang . '/' .$index;
				}
			}elseif ($cari_nota == null) {
				$nota = $req->nota;
			}

			$id = DB::table('bukti_kas_keluar')
					->max('bkk_id');

			if ($id == null) {
				$id = 1;
			}else{
				$id += 1;
			}

			$header = DB::table('bukti_kas_keluar')
				  ->insert([
				  	'bkk_id'  			=> $id,
					'bkk_nota' 			=> $nota,
					'bkk_tgl' 			=> carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
					'bkk_jenisbayar' 	=> $req->jenis_bayar,
					'bkk_keterangan' 	=> strtoupper($req->keterangan_head),
					'bkk_comp' 			=> $req->cabang,
					'bkk_total' 		=> filter_var($req->total, FILTER_SANITIZE_NUMBER_INT)/100,
					'created_at' 		=> carbon::now(),
					'updated_at' 		=> carbon::now(),
					'bkk_akun_kas' 		=> $req->kas,
					'bkk_supplier' 		=> $req->supplier_patty,
					'bkk_akun_hutang' 	=> $req->hutang,
					'bkk_status' 		=> 'RELEASED',
					'updated_by' 		=> Auth::user()->m_name,
	  				'created_by' 		=> Auth::user()->m_name,
			  	]);

			$id_pt = DB::table('patty_cash')
					   ->max('pc_id')+1;	

			$patty_cash = DB::table('patty_cash')
						->insert([
							'pc_id'			=> $id_pt,
							'pc_ref'  		=> $req->jenis_bayar,
							'pc_akun'  		=> $req->kas,
							'pc_keterangan' => strtoupper($req->keterangan_head),
							'pc_debet' 		=> filter_var($req->total, FILTER_SANITIZE_NUMBER_INT)/100,
							'pc_kredit' 	=> 0,
							'updated_at' 	=> carbon::now(),
							'created_at' 	=> carbon::now(),
							'pc_akun_kas' 	=> $req->kas,
							'pc_tgl' 		=> carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
							'pc_user'  		=> Auth::user()->m_name,
							'pc_comp' 		=> $req->cabang,
							'pc_asal_comp'	=> $req->cabang,
							'pc_no_trans' 	=> $nota,
							'pc_edit'  		=> 'UNALLOWED',
							'pc_reim'  		=> 'UNRELEASED',
						]);	

			for ($i=0; $i < count($req->pt_seq); $i++) {

				$id_dt = DB::table('bukti_kas_keluar_detail')
						   ->max('bkkd_id');
				if ($id_dt == null) {
					$id_dt = 1;
				}else{
					$id_dt += 1;
				}

				$detail = DB::table('bukti_kas_keluar_detail')
				  ->insert([
				  	'bkkd_id'  			=> $id_dt,
					'bkkd_bkk_id'  		=> $id,
					'bkkd_bkk_dt'  		=> $i+1,
					'bkkd_keterangan' 	=> strtoupper($req->pt_keterangan[$i]),
					'bkkd_akun'  		=> $req->pt_akun_biaya[$i],
					'bkkd_total' 		=> $req->pt_nominal[$i],
					'bkkd_debit' 		=> $req->pt_debet[$i],
					'updated_at'		=> carbon::now(),
					'created_at' 		=> carbon::now(),
					'bkkd_ref' 			=> 'NONE',
					'bkkd_supplier' 	=> 'NONE',
					]);

				$id_pt = DB::table('patty_cash')
						   ->max('pc_id')+1;

				$patty_cash = DB::table('patty_cash')
							->insert([
								'pc_id'			=> $id_pt,
								'pc_ref'  		=> $req->jenis_bayar,
								'pc_akun'  		=> $req->pt_akun_biaya[$i],
								'pc_keterangan' => strtoupper($req->pt_keterangan[$i]),
								'pc_debet' 		=> 0,
								'pc_kredit' 	=> $req->pt_nominal[$i],
								'updated_at' 	=> carbon::now(),
								'created_at' 	=> carbon::now(),
								'pc_akun_kas' 	=> $req->kas,
								'pc_tgl' 		=> carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
								'pc_user'  		=> Auth::user()->m_name,
								'pc_comp' 		=> $req->cabang,
								'pc_asal_comp'	=> $req->cabang,
								'pc_no_trans' 	=> $nota,
								'pc_edit'  		=> 'UNALLOWED',
								'pc_reim'  		=> 'UNRELEASED',
							]);	
				
			}





			// //JURNAL
			$id_jurnal=d_jurnal::max('jr_id')+1;
			// dd($id_jurnal);
			$jenis_bayar = DB::table('jenisbayar')
							 ->where('idjenisbayar',$req->jenis_bayar)
							 ->first();

			$jurnal = d_jurnal::create(['jr_id'		=> $id_jurnal,
										'jr_year'   => carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y'),
										'jr_date' 	=> carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
										'jr_detail' => $jenis_bayar->jenisbayar,
										'jr_ref'  	=> $nota,
										'jr_note'  	=> 'BUKTI KAS KELUAR',
										'jr_insert' => carbon::now(),
										'jr_update' => carbon::now(),
										]);


			$akun 	  = [];
			$akun_val = [];
			array_push($akun, $req->kas);
			array_push($akun_val, filter_var($req->total,FILTER_SANITIZE_NUMBER_INT)/100);

			for ($i=0; $i < count($req->pt_akun_biaya); $i++) { 

				array_push($akun, $req->pt_akun_biaya[$i]);
				array_push($akun_val, $req->pt_nominal[$i]);
			}

			$data_akun = [];
			for ($i=0; $i < count($akun); $i++) { 

				$cari_coa = DB::table('d_akun')
								  ->where('id_akun',$akun[$i])
								  ->first();

				if (substr($akun[$i],0, 1)==1) {
					
					if ($cari_coa->akun_dka == 'D') {
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'K';
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'D';
					}
				}else if (substr($akun[$i],0, 1)>1) {

					if ($cari_coa->akun_dka == 'D') {
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'K';
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'D';
					}
				}
			}
			// dd($data_akun);
			$jurnal_dt = d_jurnal_dt::insert($data_akun);
			$lihat = d_jurnal_dt::where('jrdt_jurnal',$id_jurnal)->get();
			// dd($lihat);

			return response()->json(['status'=>1,'id'=>$id]);

		});
	}

	public function update_patty(request $req)
	{
		return DB::transaction(function() use ($req) {  

			$cari_nota = DB::table('bukti_kas_keluar')
						   ->where('bkk_nota',$req->nota)
						   ->first();


			if ($cari_nota == null) {
				return response()->json(['status'=>3]);
			}

			$nota = $req->nota;
			$id = $cari_nota->bkk_id;

			$header = DB::table('bukti_kas_keluar')
				  ->where('bkk_nota',$nota)
				  ->update([
					'bkk_nota' 			=> $nota,
					'bkk_tgl' 			=> carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
					'bkk_jenisbayar' 	=> $req->jenis_bayar,
					'bkk_keterangan' 	=> strtoupper($req->keterangan_head),
					'bkk_comp' 			=> $req->cabang,
					'bkk_total' 		=> filter_var($req->total, FILTER_SANITIZE_NUMBER_INT)/100,
					'created_at' 		=> carbon::now(),
					'updated_at' 		=> carbon::now(),
					'bkk_akun_kas' 		=> $req->kas,
					'bkk_supplier' 		=> $req->supplier_patty,
					'bkk_akun_hutang' 	=> $req->hutang,
					'bkk_status' 		=> 'RELEASED',
					'updated_by' 		=> Auth::user()->m_name,
	  				'created_by' 		=> Auth::user()->m_name,
			  	]);

			$delete = DB::table('bukti_kas_keluar_detail')
						->where('bkkd_bkk_id',$cari_nota->bkk_id)
						->delete();

			$delete = DB::table('patty_cash')
						->where('pc_no_trans',$nota)
						->delete();

			$id_pt = DB::table('patty_cash')
					   ->max('pc_id')+1;	

			$patty_cash = DB::table('patty_cash')
						->insert([
							'pc_id'			=> $id_pt,
							'pc_ref'  		=> $req->jenis_bayar,
							'pc_akun'  		=> $req->kas,
							'pc_keterangan' => strtoupper($req->keterangan_head),
							'pc_debet' 		=> filter_var($req->total, FILTER_SANITIZE_NUMBER_INT)/100,
							'pc_kredit' 	=> 0,
							'updated_at' 	=> carbon::now(),
							'created_at' 	=> carbon::now(),
							'pc_akun_kas' 	=> $req->kas,
							'pc_tgl' 		=> carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
							'pc_user'  		=> Auth::user()->m_name,
							'pc_comp' 		=> $req->cabang,
							'pc_asal_comp'	=> $req->cabang,
							'pc_no_trans' 	=> $nota,
							'pc_edit'  		=> 'UNALLOWED',
							'pc_reim'  		=> 'UNRELEASED',
						]);	
			for ($i=0; $i < count($req->pt_seq); $i++) {

				$id_dt = DB::table('bukti_kas_keluar_detail')
						   ->max('bkkd_id');
				if ($id_dt == null) {
					$id_dt = 1;
				}else{
					$id_dt += 1;
				}

				$detail = DB::table('bukti_kas_keluar_detail')
				  ->insert([
				  	'bkkd_id'  			=> $id_dt,
					'bkkd_bkk_id'  		=> $id,
					'bkkd_bkk_dt'  		=> $i+1,
					'bkkd_keterangan' 	=> strtoupper($req->pt_keterangan[$i]),
					'bkkd_akun'  		=> $req->pt_akun_biaya[$i],
					'bkkd_total' 		=> $req->pt_nominal[$i],
					'bkkd_debit' 		=> $req->pt_debet[$i],
					'updated_at'		=> carbon::now(),
					'created_at' 		=> carbon::now(),
					'bkkd_ref' 			=> 'NONE',
					'bkkd_supplier' 	=> 'NONE',
					]);


				$id_pt = DB::table('patty_cash')
						   ->max('pc_id')+1;
						   
				$patty_cash = DB::table('patty_cash')
							->insert([
								'pc_id'			=> $id_pt,
								'pc_ref'  		=> $req->jenis_bayar,
								'pc_akun'  		=> $req->pt_akun_biaya[$i],
								'pc_keterangan' => strtoupper($req->pt_keterangan[$i]),
								'pc_debet' 		=> 0,
								'pc_kredit' 	=> $req->pt_nominal[$i],
								'updated_at' 	=> carbon::now(),
								'created_at' 	=> carbon::now(),
								'pc_akun_kas' 	=> $req->kas,
								'pc_tgl' 		=> carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
								'pc_user'  		=> Auth::user()->m_name,
								'pc_comp' 		=> $req->cabang,
								'pc_asal_comp'	=> $req->cabang,
								'pc_no_trans' 	=> $nota,
								'pc_edit'  		=> 'UNALLOWED',
								'pc_reim'  		=> 'UNRELEASED',
							]);	
				
			}

			
			// //JURNAL
			$delete_jurnal = DB::table('d_jurnal')
							   ->where('jr_ref',$nota)
							   ->delete();

			$id_jurnal=d_jurnal::max('jr_id')+1;
			// dd($id_jurnal);
			$jenis_bayar = DB::table('jenisbayar')
							 ->where('idjenisbayar',$req->jenis_bayar)
							 ->first();

			$jurnal = d_jurnal::create(['jr_id'		=> $id_jurnal,
										'jr_year'   => carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y'),
										'jr_date' 	=> carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
										'jr_detail' => $jenis_bayar->jenisbayar,
										'jr_ref'  	=> $nota,
										'jr_note'  	=> 'BUKTI KAS KELUAR',
										'jr_insert' => carbon::now(),
										'jr_update' => carbon::now(),
										]);


			$akun 	  = [];
			$akun_val = [];
			array_push($akun, $req->kas);
			array_push($akun_val, filter_var($req->total,FILTER_SANITIZE_NUMBER_INT)/100);

			for ($i=0; $i < count($req->pt_akun_biaya); $i++) { 

				array_push($akun, $req->pt_akun_biaya[$i]);
				array_push($akun_val, $req->pt_nominal[$i]);
			}

			$data_akun = [];
			for ($i=0; $i < count($akun); $i++) { 

				$cari_coa = DB::table('d_akun')
								  ->where('id_akun',$akun[$i])
								  ->first();

				if (substr($akun[$i],0, 1)==1) {
					
					if ($cari_coa->akun_dka == 'D') {
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'K';
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'D';
					}
				}else if (substr($akun[$i],0, 1)>1) {

					if ($cari_coa->akun_dka == 'D') {
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'K';
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'D';
					}
				}
			}
			// dd($data_akun);
			$jurnal_dt = d_jurnal_dt::insert($data_akun);
			$lihat = d_jurnal_dt::where('jrdt_jurnal',$id_jurnal)->get();
			// dd($lihat);

			return response()->json(['status'=>1]);

		});
	}

	public function cari_hutang(request $req)
	{
		$agen 	  = DB::select("SELECT kode, nama, acc_hutang from agen order by kode");

		$vendor   = DB::select("SELECT kode, nama, acc_hutang from vendor order by kode "); 

		$subcon   = DB::select("SELECT kode, nama, acc_code as acc_hutang from subcon order by kode "); 

	    $akun_kas = DB::table('d_akun')
				  ->where('nama_akun','like','%KAS KECIL%')
				  ->get();
		$supplier = DB::select("SELECT no_supplier as kode, nama_supplier as nama, acc_hutang from supplier order by no_supplier");

		$all = array_merge($agen,$vendor,$subcon,$supplier);
		$data = [];
		for ($i=0; $i < count($all); $i++) { 
			if ($req->supplier == $all[$i]->kode) {
				$data = $all[$i];
			}
		}
		return response()->json(['data'=>$data]);
	}

	public function cari_faktur(request $req)
	{	
		// dd($req->all());

		$jenis_bayar = $req->jenis_bayar;
		if ($req->jenis_bayar == 2 or $req->jenis_bayar == 6 or $req->jenis_bayar == 7 or $req->jenis_bayar == 9) {

			if ($req->filter_faktur == 'tanggal') {
				$tgl = explode('-',$req->periode);
				$tgl[0] = carbon::parse($tgl[0])->format('Y-m-d');
				$tgl[1] = carbon::parse($tgl[1])->format('Y-m-d');
				if ($req->jenis_bayar == 2) {
					$supplier = DB::table('supplier')
						  ->where('active','AKTIF')
						  ->where('no_supplier',$req->supplier_faktur)
						  ->first();

					$data = DB::table('faktur_pembelian')
							  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  ->where('fp_idsup',$supplier->idsup)
							  ->where('fp_comp',$req->cabang)
							  ->where('fp_tgl','>=',$tgl[0])
							  ->where('fp_tgl','<=',$tgl[1])
							  ->where('fp_sisapelunasan','!=',0)
							  ->whereNotIn('fp_nofaktur',$req->valid)
							  ->get();

				}elseif ($req->jenis_bayar == 6 or $req->jenis_bayar == 7 or $req->jenis_bayar == 9) {
					$data = DB::table('faktur_pembelian')
							  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  ->where('fp_supplier',$req->supplier_faktur)
							  ->where('fp_comp',$req->cabang)
							  ->where('fp_tgl','>=',$tgl[0])
							  ->where('fp_tgl','<=',$tgl[1])
							  ->where('fp_sisapelunasan','!=',0)
							  ->whereNotIn('fp_nofaktur',$req->valid)
							  ->get();
				}
				

				return view('purchase.buktikaskeluar.tabel_modal_faktur',compact('data','jenis_bayar'));
			}elseif ($req->filter_faktur == 'jatuh_tempo') {
				$tgl = explode('-',$req->periode);
				$tgl[0] = carbon::parse($tgl[0])->format('Y-m-d');
				$tgl[1] = carbon::parse($tgl[1])->format('Y-m-d');

				if ($req->jenis_bayar == 2) {
					$supplier = DB::table('supplier')
						  ->where('active','AKTIF')
						  ->where('no_supplier',$req->supplier_faktur)
						  ->first();

					$data = DB::table('faktur_pembelian')
							  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  ->where('fp_idsup',$supplier->idsup)
							  ->where('fp_comp',$req->cabang)
							  ->where('fp_tgl','>=',$tgl[0])
							  ->where('fp_tgl','<=',$tgl[1])
							  ->where('fp_sisapelunasan','!=',0)
							  ->whereNotIn('fp_nofaktur',$req->valid)
							  ->get();
				}elseif ($req->jenis_bayar == 6 or $req->jenis_bayar == 7 or $req->jenis_bayar == 9) {
					$data = DB::table('faktur_pembelian')
							  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  ->where('fp_supplier',$req->supplier_faktur)
							  ->where('fp_comp',$req->cabang)
							  ->where('fp_jatuhtempo','>=',$tgl[0])
							  ->where('fp_jatuhtempo','<=',$tgl[1])
							  ->where('fp_sisapelunasan','!=',0)
							  ->whereNotIn('fp_nofaktur',$req->valid)
							  ->get();
				}

				return view('purchase.buktikaskeluar.tabel_modal_faktur',compact('data','jenis_bayar'));
			}elseif ($req->filter_faktur == 'faktur') {

				if ($req->jenis_bayar == 2) {
					$supplier = DB::table('supplier')
							  ->where('active','AKTIF')
							  ->where('no_supplier',$req->supplier_faktur)
							  ->first();

					$data = DB::table('faktur_pembelian')
							  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  ->where('fp_idsup',$supplier->idsup)
							  ->where('fp_nofaktur',$req->faktur_nomor)
							  ->where('fp_comp',$req->cabang)
							  ->where('fp_sisapelunasan','!=',0)
							  ->whereNotIn('fp_nofaktur',$req->valid)
							  ->get();
				}elseif ($req->jenis_bayar == 6 or $req->jenis_bayar == 7 or $req->jenis_bayar == 9) {
					$data = DB::table('faktur_pembelian')
							  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  ->where('fp_supplier',$req->supplier_faktur)
							  ->where('fp_nofaktur',$req->faktur_nomor)
							  ->where('fp_comp',$req->cabang)
							  ->where('fp_sisapelunasan','!=',0)
							  ->whereNotIn('fp_nofaktur',$req->valid)
							  ->get();
				}

				return response()->json(['data'=>$data]);
			}
			
		}elseif ($req->jenis_bayar == 3) {
			if ($req->filter_faktur == 'tanggal') {
				$tgl = explode('-',$req->periode);
				$tgl[0] = carbon::parse($tgl[0])->format('Y-m-d');
				$tgl[1] = carbon::parse($tgl[1])->format('Y-m-d');


				$data = DB::table('v_hutang')
						  ->where('v_supid',$req->supplier_faktur)
						  ->where('vc_comp',$req->cabang)
						  ->where('v_tgl','>=',$tgl[0])
						  ->where('v_tgl','<=',$tgl[1])
						  ->where('v_pelunasan','!=',0)
						  ->whereNotIn('v_nomorbukti',$req->valid)
						  ->get();

				return view('purchase.buktikaskeluar.tabel_modal_voucher',compact('data','jenis_bayar'));
			}elseif ($req->filter_faktur == 'jatuh_tempo') {
				$tgl = explode('-',$req->periode);
				$tgl[0] = carbon::parse($tgl[0])->format('Y-m-d');
				$tgl[1] = carbon::parse($tgl[1])->format('Y-m-d');

				$data = DB::table('v_hutang')
						  ->where('v_supid',$req->supplier_faktur)
						  ->where('vc_comp',$req->cabang)
						  ->where('v_tempo','>=',$tgl[0])
						  ->where('v_tempo','<=',$tgl[1])
						  ->where('v_pelunasan','!=',0)
						  ->whereNotIn('v_nomorbukti',$req->valid)
						  ->get();

				return view('purchase.buktikaskeluar.tabel_modal_voucher',compact('data','jenis_bayar'));
			}elseif ($req->filter_faktur == 'faktur') {

				$data = DB::table('v_hutang')
						  ->where('v_supid',$req->supplier_faktur)
						  ->where('vc_comp',$req->cabang)
						  ->where('v_nomorbukti',$req->faktur_nomor)
						  ->where('v_pelunasan','!=',0)
						  ->whereNotIn('v_nomorbukti',$req->valid)
						  ->get();

				return response()->json(['data'=>$data]);
			}
		}else if($req->jenis_bayar == 4){
			if ($req->filter_faktur == 'tanggal') {
				$tgl = explode('-',$req->periode);
				$tgl[0] = carbon::parse($tgl[0])->format('Y-m-d');
				$tgl[1] = carbon::parse($tgl[1])->format('Y-m-d');


				$data = DB::table('d_uangmuka')
						  ->where('um_supplier',$req->supplier_faktur)
						  ->where('um_comp',$req->cabang)
						  ->where('um_tgl','>=',$tgl[0])
						  ->where('um_tgl','<=',$tgl[1])
						  ->where('um_sisapelunasan','!=',0)
						  ->whereNotIn('um_nomorbukti',$req->valid)
						  ->get();

				return view('purchase.buktikaskeluar.tabel_modal_um',compact('data','jenis_bayar'));
			}elseif ($req->filter_faktur == 'jatuh_tempo') {
				$tgl = explode('-',$req->periode);
				$tgl[0] = carbon::parse($tgl[0])->format('Y-m-d');
				$tgl[1] = carbon::parse($tgl[1])->format('Y-m-d');

				$data = DB::table('d_uangmuka')
						  ->where('um_supplier',$req->supplier_faktur)
						  ->where('um_comp',$req->cabang)
						  ->where('um_tgl','>=',$tgl[0])
						  ->where('um_tgl','<=',$tgl[1])
						  ->where('um_sisapelunasan','!=',0)
						  ->whereNotIn('um_nomorbukti',$req->valid)
						  ->get();

				return view('purchase.buktikaskeluar.tabel_modal_um',compact('data','jenis_bayar'));
			}elseif ($req->filter_faktur == 'faktur') {

				$data = DB::table('d_uangmuka')
						  ->where('um_supplier',$req->supplier_faktur)
						  ->where('um_comp',$req->cabang)
						  ->where('um_nomorbukti',$req->faktur_nomor)
						  ->where('um_sisapelunasan','!=',0)
						  ->whereNotIn('um_nomorbukti',$req->valid)
						  ->get();

				return response()->json(['data'=>$data]);
			}
		}

	}

	public function append_faktur(request $req)
	{	
		if ($req->jenis_bayar == 2 or $req->jenis_bayar == 6 or $req->jenis_bayar == 7 or $req->jenis_bayar == 9) {
			$data = DB::table('faktur_pembelian')
				  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
				  ->whereIn('fp_nofaktur',$req->check_array)
				  ->get();

		}elseif ($req->jenis_bayar == 3){
			$data = DB::table('v_hutang')
				  ->whereIn('v_nomorbukti',$req->check_array)
				  ->get();
		}else if($req->jenis_bayar == 4){
			$data = DB::table('d_uangmuka')
				  ->whereIn('um_nomorbukti',$req->check_array)
				  ->get();
		}
		

		return response()->json(['data'=>$data]);
	}

	public function append_faktur_edit(request $req)
	{	
		// dd($req->all());
		if ($req->jenis_bayar == 2 or $req->jenis_bayar == 6 or $req->jenis_bayar == 7 or $req->jenis_bayar == 9) {

			$data = DB::table('faktur_pembelian')
				  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
				  ->whereIn('fp_nofaktur',$req->check_array)
				  ->get();

			if (isset($req->nota)) {
				$cari_bkk = DB::table('bukti_kas_keluar')
							  ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
							  ->where('bkk_nota',$req->nota)
							  ->get();
				for ($i=0; $i < count($data); $i++) { 
					for ($a=0; $a < count($cari_bkk); $a++) { 
						if ($data[$i]->fp_nofaktur == $cari_bkk[$a]->bkkd_ref) {
							$data[$i]->fp_sisapelunasan += $cari_bkk[$a]->bkkd_total;
						}
					}
				}
			}

		}elseif ($req->jenis_bayar == 3){
			$data = DB::table('v_hutang')
				  ->whereIn('v_nomorbukti',$req->check_array)
				  ->get();

			if (isset($req->nota)) {
				$cari_bkk = DB::table('bukti_kas_keluar')
							  ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
							  ->where('bkk_nota',$req->nota)
							  ->get();
				for ($i=0; $i < count($data); $i++) { 
					for ($a=0; $a < count($cari_bkk); $a++) { 
						if ($data[$i]->v_nomorbukti == $cari_bkk[$a]->bkkd_ref) {
							$data[$i]->v_pelunasan += $cari_bkk[$a]->bkkd_total;
						}
					}
				}
			}

		}else if($req->jenis_bayar == 4){
			$data = DB::table('d_uangmuka')
				  ->whereIn('um_nomorbukti',$req->check_array)
				  ->get();

			if (isset($req->nota)) {
				$cari_bkk = DB::table('bukti_kas_keluar')
							  ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
							  ->where('bkk_nota',$req->nota)
							  ->get();
				for ($i=0; $i < count($data); $i++) { 
					for ($a=0; $a < count($cari_bkk); $a++) { 
						if ($data[$i]->um_nomorbukti == $cari_bkk[$a]->bkkd_ref) {
							$data[$i]->um_sisapelunasan += $cari_bkk[$a]->bkkd_total;
						}
					}
				}
			}
		}
		

		return response()->json(['data'=>$data]);
	}

	public function histori_faktur(request $req)
	{
		if (isset($req->nota)) {
			$nota = $req->nota;
		}else{
			$nota = 0;
		}

		$fpg = DB::select("SELECT fpg_nofpg as nota, fpg_tgl as tanggal, fpgdt_pelunasan as total 
							from fpg inner join fpg_dt on fpgdt_idfpg = idfpg where fpgdt_nofaktur = '$req->fp_faktur'");	

		$bkk = DB::select("SELECT bkk_nota as nota, bkk_tgl as tanggal, bkkd_total as total 
							from bukti_kas_keluar 
							inner join bukti_kas_keluar_detail on bkkd_bkk_id = bkk_id 
							where bkkd_ref = '$req->fp_faktur' and bkk_nota != '$nota'");	
		$data = array_merge($fpg,$bkk);

		return view('purchase.buktikaskeluar.histori_faktur',compact('data'));
	}

	public function debet_faktur(request $req)
	{	
		$data = [];
		if ($req->jenis_bayar == 2 or $req->jenis_bayar == 6 or $req->jenis_bayar == 7 or $req->jenis_bayar == 9) {
			$fp = DB::table('faktur_pembelian')
					->where('fp_nofaktur',$req->fp_faktur)
					->first();

			$data = DB::table('cndnpembelian')
					  ->join('cndnpembelian_dt','cndn_id','=','cndt_idcn')
					  ->where('cndt_idfp',$fp->fp_idfaktur)
					  ->where('cndn_jeniscndn','D')
					  ->get();
		}
		

		return view('purchase.buktikaskeluar.debet_faktur',compact('data'));
	}

	public function kredit_faktur(request $req)
	{
		$data = [];
		if ($req->jenis_bayar == 2 or $req->jenis_bayar == 6 or $req->jenis_bayar == 7 or $req->jenis_bayar == 9) {
			$fp = DB::table('faktur_pembelian')
					->where('fp_nofaktur',$req->fp_faktur)
					->first();

			$data = DB::table('cndnpembelian')
					  ->join('cndnpembelian_dt','cndn_id','=','cndt_idcn')
					  ->where('cndt_idfp',$fp->fp_idfaktur)
					  ->where('cndn_jeniscndn','K')
					  ->get();
		}

		return view('purchase.buktikaskeluar.kredit_faktur',compact('data'));
	}

	public function um_faktur(request $req)
	{
		$data = [];
		if ($req->jenis_bayar == 2 or $req->jenis_bayar == 6 or $req->jenis_bayar == 7 or $req->jenis_bayar == 9) {
			$fp = DB::table('faktur_pembelian')
					->where('fp_nofaktur',$req->fp_faktur)
					->first();
						
			$data = DB::table('uangmukapembelian_fp')
					  ->join('uangmukapembeliandt_fp','umfpdt_idum','=','umfp_idfp')
					  ->where('umfpdt_idfp',$fp->fp_idfaktur)
					  ->get();
		}

		return view('purchase.buktikaskeluar.kredit_faktur',compact('data'));
	}
	public function detail_faktur(request $req)
	{
		if ($req->jenis_bayar == 2 or $req->jenis_bayar == 6 or $req->jenis_bayar == 7 or $req->jenis_bayar == 9) {
			$data = DB::table('faktur_pembelian')
					->where('fp_nofaktur',$req->fp_faktur)
					->first();
			if (isset($req->nota)) {

				$bkkd = DB::table('bukti_kas_keluar_detail')
						  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
						  ->where('bkk_nota',$req->nota)
						  ->where('bkkd_ref',$req->fp_faktur)
						  ->first();
				if ($bkkd != null) {
					$data->fp_sisapelunasan = $data->fp_sisapelunasan + $bkkd->bkkd_total;
				}
			}
			return response()->json(['data'=>$data]);
		}elseif ($req->jenis_bayar == 3) {
			$data = DB::table('v_hutang')
					->where('v_nomorbukti',$req->fp_faktur)
					->first();

			if (isset($req->nota)) {

				$bkkd = DB::table('bukti_kas_keluar_detail')
						  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
						  ->where('bkk_nota',$req->nota)
						  ->where('bkkd_ref',$req->fp_faktur)
						  ->first();
				if ($bkkd != null) {
					$data->v_pelunasan = $data->v_pelunasan + $bkkd->bkkd_total;
				}
			}
			return response()->json(['data'=>$data]);
		}elseif ($req->jenis_bayar == 4){
			$data = DB::table('d_uangmuka')
					->where('um_nomorbukti',$req->fp_faktur)
					->first();

			if (isset($req->nota)) {

				$bkkd = DB::table('bukti_kas_keluar_detail')
						  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
						  ->where('bkk_nota',$req->nota)
						  ->where('bkkd_ref',$req->fp_faktur)
						  ->first();
				if ($bkkd != null) {
					$data->um_sisapelunasan = $data->um_sisapelunasan + $bkkd->bkkd_total;
				}
			}
		}
		return response()->json(['data'=>$data]);
	}
	public function save_form(request $req)
	{
		return DB::transaction(function() use ($req) {  
			// dd($req->all());
			$user = Auth::user()->m_name;
			if (Auth::user()->m_name == null) {
				return response()->json([
					'status'=>0,
					'message'=>'Nama User Anda Belum Ada, Silahkan Hubungi Pihak Terkait'
				]);
			}

			$cari_nota = DB::table('bukti_kas_keluar')
						   ->where('bkk_nota',$req->nota)
						   ->first();
						   
			if ($cari_nota != null) {
				if ($cari_nota->updated_by == $user) {
					return 'Data Sudah Ada';
				}else{
					$bulan = Carbon::now()->format('m');
				    $tahun = Carbon::now()->format('y');

				    $cari_nota = DB::select("SELECT  substring(max(bkk_nota),13) as id from bukti_kas_keluar
				                                    WHERE bkk_comp = '$req->cabang'
				                                    AND to_char(created_at,'MM') = '$bulan'
				                                    AND to_char(created_at,'YY') = '$tahun'");

				    $index = (integer)$cari_nota[0]->id + 1;
				    $index = str_pad($index, 3, '0', STR_PAD_LEFT);

					
					$nota = 'BKK' . $bulan . $tahun . '/' . $req->cabang . '/' .$index;
				}
			}elseif ($cari_nota == null) {
				$nota = $req->nota;
			}
			

			

			$id = DB::table('bukti_kas_keluar')
					->max('bkk_id');

			if ($id == null) {
				$id = 1;
			}else{
				$id += 1;
			}

			$header = DB::table('bukti_kas_keluar')
				  ->insert([
				  	'bkk_id'  			=> $id,
					'bkk_nota' 			=> $nota,
					'bkk_tgl' 			=> carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
					'bkk_jenisbayar' 	=> $req->jenis_bayar,
					'bkk_keterangan' 	=> strtoupper($req->keterangan_head),
					'bkk_comp' 			=> $req->cabang,
					'bkk_total' 		=> filter_var($req->total, FILTER_SANITIZE_NUMBER_INT)/100,
					'created_at' 		=> carbon::now(),
					'updated_at' 		=> carbon::now(),
					'bkk_akun_kas' 		=> $req->kas,
					'bkk_supplier' 		=> $req->supplier_faktur,
					'bkk_akun_hutang' 	=> $req->hutang,
					'bkk_status' 		=> 'RELEASED',
					'updated_by' 		=> Auth::user()->m_name,
	  				'created_by' 		=> Auth::user()->m_name,
			  	]);

			for ($i=0; $i < count($req->fp_faktur); $i++) {

				$id_dt = DB::table('bukti_kas_keluar_detail')
						   ->max('bkkd_id');
				if ($id_dt == null) {
					$id_dt = 1;
				}else{
					$id_dt += 1;
				}
				if ($req->jenis_bayar == 4) {
					$sisa_um = filter_var($req->fp_pelunasan[$i], FILTER_SANITIZE_NUMBER_FLOAT);
				}else{
					$sisa_um = 0;
				}

				$detail = DB::table('bukti_kas_keluar_detail')
				  ->insert([
				  	'bkkd_id'  			=> $id_dt,
					'bkkd_bkk_id'  		=> $id,
					'bkkd_bkk_dt'  		=> $i+1,
					'bkkd_keterangan' 	=> strtoupper($req->fp_keterangan[$i]),
					'bkkd_akun'  		=> $req->hutang,
					'bkkd_total' 		=> filter_var($req->fp_pelunasan[$i], FILTER_SANITIZE_NUMBER_FLOAT),
					'bkkd_debit' 		=> 'DEBET',
					'updated_at'		=> carbon::now(),
					'created_at' 		=> carbon::now(),
					'bkkd_ref' 			=> $req->fp_faktur[$i],
					'bkkd_supplier' 	=> $req->supplier_faktur,
					'bkkd_sisaum'    	=> $sisa_um,
					]);

				$id_pt = DB::table('patty_cash')
					   ->max('pc_id')+1;	

				$patty_cash = DB::table('patty_cash')
							->insert([
								'pc_id'			=> $id_pt,
								'pc_ref'  		=> $req->jenis_bayar,
								'pc_akun'  		=> $req->kas,
								'pc_keterangan' => strtoupper($req->keterangan_head),
								'pc_debet' 		=> filter_var($req->total, FILTER_SANITIZE_NUMBER_INT)/100,
								'pc_kredit' 	=> 0,
								'updated_at' 	=> carbon::now(),
								'created_at' 	=> carbon::now(),
								'pc_akun_kas' 	=> $req->kas,
								'pc_tgl' 		=> carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
								'pc_user'  		=> Auth::user()->m_name,
								'pc_comp' 		=> $req->cabang,
								'pc_asal_comp'	=> $req->cabang,
								'pc_no_trans' 	=> $nota,
								'pc_edit'  		=> 'UNALLOWED',
								'pc_reim'  		=> 'UNRELEASED',
							]);	


				if ($req->jenis_bayar == 2 or $req->jenis_bayar == 6 or $req->jenis_bayar == 7 or $req->jenis_bayar == 9) {
					$cari_faktur = DB::table('faktur_pembelian')
									 ->where('fp_nofaktur',$req->fp_faktur[$i])
									 ->first();
					$update_faktur =DB::table('faktur_pembelian')
									  ->where('fp_nofaktur',$req->fp_faktur[$i])
									  ->update([
									  	'fp_sisapelunasan' => $cari_faktur->fp_sisapelunasan - filter_var($req->fp_pelunasan[$i], FILTER_SANITIZE_NUMBER_FLOAT)
									  ]);
				}elseif ($req->jenis_bayar == 3) {
					$cari_faktur = DB::table('v_hutang')
									 ->where('v_nomorbukti',$req->fp_faktur[$i])
									 ->first();
					$update_faktur =DB::table('v_hutang')
									  ->where('v_nomorbukti',$req->fp_faktur[$i])
									  ->update([
									  	'v_pelunasan' => $cari_faktur->v_pelunasan - filter_var($req->fp_pelunasan[$i], FILTER_SANITIZE_NUMBER_FLOAT)
									  ]);
				}else{
					$cari_faktur = DB::table('d_uangmuka')
									 ->where('um_nomorbukti',$req->fp_faktur[$i])
									 ->first();
					$update_faktur =DB::table('d_uangmuka')
									  ->where('um_nomorbukti',$req->fp_faktur[$i])
									  ->update([
									  	'um_sisapelunasan' => $cari_faktur->um_sisapelunasan - filter_var($req->fp_pelunasan[$i], FILTER_SANITIZE_NUMBER_FLOAT),
									  	'um_sisaterpakai' => $cari_faktur->um_sisaterpakai + filter_var($req->fp_pelunasan[$i], FILTER_SANITIZE_NUMBER_FLOAT)
									  ]);
				}
				

			}


		
			// //JURNAL
			$id_jurnal=d_jurnal::max('jr_id')+1;
			// dd($id_jurnal);
			$jenis_bayar = DB::table('jenisbayar')
							 ->where('idjenisbayar',$req->jenis_bayar)
							 ->first();

			$jurnal = d_jurnal::create(['jr_id'		=> $id_jurnal,
										'jr_year'   => carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y'),
										'jr_date' 	=> carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
										'jr_detail' => $jenis_bayar->jenisbayar,
										'jr_ref'  	=> $nota,
										'jr_note'  	=> 'BUKTI KAS KELUAR',
										'jr_insert' => carbon::now(),
										'jr_update' => carbon::now(),
										]);

			if ($req->jenis_bayar == 2 || $req->jenis_bayar == 6 || $req->jenis_bayar == 7  || $req->jenis_bayar == 9 || $req->jenis_bayar == 3)  {

				$akun 	  = [];
				$akun_val = [];
				$jumlah   = [];
				array_push($akun, $req->kas);
				array_push($akun, '2102');
				array_push($akun_val, filter_var($req->total, FILTER_SANITIZE_NUMBER_INT)/100);

				for ($i=0; $i < count($req->fp_pelunasan); $i++) { 
					array_push($jumlah, filter_var($req->fp_pelunasan[$i], FILTER_SANITIZE_NUMBER_FLOAT));
				}

				$jumlah = array_sum($jumlah);

				array_push($akun_val, $jumlah);

				$data_akun = [];
				for ($i=0; $i < count($akun); $i++) { 

					$cari_coa = DB::table('d_akun')
									  ->where('id_akun','like',$akun[$i].'%')
									  ->where('kode_cabang',$req->cabang)
									  ->first();

					if (substr($akun[$i],0, 1)==1) {
						
						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'K';
                			$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'D';
                			$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
						}
					}else if (substr($akun[$i],0, 1)>1) {

						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'K';
                			$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'D';
                			$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
						}
					}

					$id_pt = DB::table('patty_cash')
						   ->max('pc_id');
						if ($id_pt == null) {
							$id_pt = 1;
						}else{
							$id_pt += 1;
						}

					$patty_cash = DB::table('patty_cash')
									->insert([
										'pc_id'  		=> $id_pt,
										'pc_ref'  		=> $req->jenis_bayar,
										'pc_akun'  		=> $cari_coa->id_akun,
										'pc_keterangan' => strtoupper($req->keterangan_head),
										'pc_debet' 		=> 0,
										'pc_kredit' 	=> filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT),
										'updated_at' 	=> carbon::now(),
										'created_at' 	=> carbon::now(),
										'pc_akun_kas' 	=> $req->kas,
										'pc_tgl' 		=> carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
										'pc_user'  		=> Auth::user()->m_name,
										'pc_comp' 		=> $req->cabang,
										'pc_asal_comp'	=> $req->cabang,
										'pc_no_trans' 	=> $nota,
										'pc_edit'  		=> 'UNALLOWED',
										'pc_reim'  		=> 'UNRELEASED',
									]);	
				}
			}elseif ($req->jenis_bayar == 4) {
				$akun 	  = [];
				$akun_val = [];
				$jumlah   = [];
				$comp     = [];
				
				array_push($akun, $req->kas);
				array_push($akun, '1405');
				array_push($akun_val, filter_var($req->total, FILTER_SANITIZE_NUMBER_INT)/100);

				for ($i=0; $i < count($req->fp_pelunasan); $i++) { 
					array_push($jumlah, filter_var($req->fp_pelunasan[$i], FILTER_SANITIZE_NUMBER_INT));
				}

				$jumlah = array_sum($jumlah);

				array_push($akun_val, $jumlah);

				$data_akun = [];
				for ($i=0; $i < count($akun); $i++) { 

					$cari_coa = DB::table('d_akun')
									  ->where('id_akun','like',$akun[$i].'%')
									  ->where('kode_cabang',$req->cabang)
									  ->first();
					if (substr($akun[$i],0, 4) == 1001) {
						
						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'K';
                			$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'D';
                			$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
						}
					}else if (substr($akun[$i],0, 2) == 14) {

						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'D';
                			$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'K';
                			$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->ed_keterangan);
						}
					}

					$id_pt = DB::table('patty_cash')
						   ->max('pc_id');
						if ($id_pt == null) {
							$id_pt = 1;
						}else{
							$id_pt += 1;
						}

					$patty_cash = DB::table('patty_cash')
									->insert([
										'pc_id'  		=> $id_pt,
										'pc_ref'  		=> $req->jenis_bayar,
										'pc_akun'  		=> $cari_coa->id_akun,
										'pc_keterangan' => strtoupper($req->keterangan_head),
										'pc_debet' 		=> 0,
										'pc_kredit' 	=> filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT),
										'updated_at' 	=> carbon::now(),
										'created_at' 	=> carbon::now(),
										'pc_akun_kas' 	=> $req->kas,
										'pc_tgl' 		=> carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
										'pc_user'  		=> Auth::user()->m_name,
										'pc_comp' 		=> $req->cabang,
										'pc_asal_comp'	=> $req->cabang,
										'pc_no_trans' 	=> $nota,
										'pc_edit'  		=> 'UNALLOWED',
										'pc_reim'  		=> 'UNRELEASED',
									]);	
				}
				
			}
			
			// dd($data_akun);
			$jurnal_dt = d_jurnal_dt::insert($data_akun);
			$lihat = d_jurnal_dt::where('jrdt_jurnal',$id_jurnal)->get();
			// dd($lihat);

			return response()->json(['status'=>1,'id'=>$id]);

		});
	}

	public function edit($id)
	{
		$cabang = DB::table('cabang')
					->get();

		$jenis_bayar = DB::table('jenisbayar')
						 ->where('idjenisbayar','!=',1)
						 ->where('idjenisbayar','!=',5)
						 ->where('idjenisbayar','!=',10)
						 ->orderBy('idjenisbayar','ASC')
						 ->get();

		$akun = DB::table('d_akun')
						 ->get();

		$now  = carbon::now()->format('d/m/Y');

		$data = DB::table('bukti_kas_keluar')
				  ->where('bkk_id',$id)
				  ->first();
		if ($data->bkk_jenisbayar == 2 || $data->bkk_jenisbayar == 6 || $data->bkk_jenisbayar == 7  || $data->bkk_jenisbayar == 9 ) {
			$data_dt = DB::table('bukti_kas_keluar_detail')
					 ->join('faktur_pembelian','fp_nofaktur','=','bkkd_ref')
					 ->where('bkkd_bkk_id',$id)
					 ->get();
		}elseif($data->bkk_jenisbayar == 3){
			$data_dt = DB::table('bukti_kas_keluar_detail')
					 ->join('v_hutang','v_nomorbukti','=','bkkd_ref')
					 ->where('bkkd_bkk_id',$id)
					 ->get();
		}elseif($data->bkk_jenisbayar == 4){
			$data_dt = DB::table('bukti_kas_keluar_detail')
					 ->join('d_uangmuka','um_nomorbukti','=','bkkd_ref')
					 ->where('bkkd_bkk_id',$id)
					 ->get();
		}else{
			$data_dt = DB::table('bukti_kas_keluar_detail')
					 ->where('bkkd_bkk_id',$id)
					 ->get();
		}
		

		if (Auth::user()->punyaAkses('Bukti Kas Keluar','ubah')) {
			return view('purchase.buktikaskeluar.EditKasKeluar',compact('cabang','jenis_bayar','now','id','data','data_dt','akun'));
		}else{
			return Redirect()->back();
		}
						 
	}

	public function cari_faktur_edit(request $req)
	{	
		// dd($req->all());

		$jenis_bayar = $req->jenis_bayar;
		if ($req->jenis_bayar == 2 or $req->jenis_bayar == 6 or $req->jenis_bayar == 7 or $req->jenis_bayar == 9) {

			if ($req->filter_faktur == 'tanggal') {
				$tgl = explode('-',$req->periode);
				$tgl[0] = carbon::parse($tgl[0])->format('Y-m-d');
				$tgl[1] = carbon::parse($tgl[1])->format('Y-m-d');
				if ($req->jenis_bayar == 2) {
					$supplier = DB::table('supplier')
						  ->where('active','AKTIF')
						  ->where('no_supplier',$req->supplier_faktur)
						  ->first();

					$data = DB::table('faktur_pembelian')
							  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  ->select('fp_nofaktur')
							  ->where('fp_idsup',$supplier->idsup)
							  ->where('fp_comp',$req->cabang)
							  ->where('fp_tgl','>=',$tgl[0])
							  ->where('fp_tgl','<=',$tgl[1])
							  ->where('fp_sisapelunasan','!=',0)
							  ->whereNotIn('fp_nofaktur',$req->valid)
							  ->get();
					$temp1 = [];

					for ($i=0; $i < count($data); $i++) { 
						$temp1[$i]=$data[$i]->fp_nofaktur;
					}

					if (isset($req->nota)) {

						$bkkd = DB::table('bukti_kas_keluar_detail')
						  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
						  ->where('bkk_nota',$req->nota)
						  ->get();


						$bkkd_fp = DB::table('faktur_pembelian')
								  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  	  ->select('fp_nofaktur')
								  ->where('fp_idsup',$supplier->idsup)
								  ->where('fp_comp',$req->cabang)
								  ->where('fp_tgl','>=',$tgl[0])
								  ->where('fp_tgl','<=',$tgl[1])
								  ->whereNotIn('fp_nofaktur',$req->valid)
								  ->get();

						$temp2 = [];
						for ($i=0; $i < count($bkkd_fp); $i++) { 
							for ($a=0; $a < count($bkkd); $a++) { 
								if ($bkkd_fp[$i]->fp_nofaktur == $bkkd[$a]->bkkd_ref) {
									$temp2[$i] = $bkkd[$a]->bkkd_ref;
								}
							}
						}
						$data = array_merge($temp1,$temp2);
					}

					$unik = array_unique($data);

					$data = DB::table('faktur_pembelian')
							  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  ->whereIn('fp_nofaktur',$unik)
							  ->get();
							  
					if (isset($req->nota)) {

						$bkkd = DB::table('bukti_kas_keluar_detail')
						  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
						  ->where('bkk_nota',$req->nota)
						  ->get();

						for ($i=0; $i < count($data); $i++) { 
						 	for ($a=0; $a < count($bkkd); $a++) { 
						 		if ($data[$i]->fp_nofaktur == $bkkd[$a]->bkkd_ref) {
									$data[$i]->fp_sisapelunasan += $bkkd[$a]->bkkd_total;
						 		}
						 	}
						} 
					}

				}elseif ($req->jenis_bayar == 6 or $req->jenis_bayar == 7 or $req->jenis_bayar == 9) {
					$data = DB::table('faktur_pembelian')
							  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  ->select('fp_nofaktur')
							  ->where('fp_comp',$req->cabang)
							  ->where('fp_tgl','>=',$tgl[0])
							  ->where('fp_tgl','<=',$tgl[1])
							  ->where('fp_sisapelunasan','!=',0)
							  ->whereNotIn('fp_nofaktur',$req->valid)
							  ->get();

					$temp1 = [];

					for ($i=0; $i < count($data); $i++) { 
						$temp1[$i]=$data[$i]->fp_nofaktur;
					}

					if (isset($req->nota)) {

						$bkkd = DB::table('bukti_kas_keluar_detail')
						  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
						  ->where('bkk_nota',$req->nota)
						  ->get();


						$bkkd_fp = DB::table('faktur_pembelian')
								  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  	  ->select('fp_nofaktur')
							  	  ->where('fp_supplier',$req->supplier_faktur)
								  ->where('fp_comp',$req->cabang)
								  ->where('fp_tgl','>=',$tgl[0])
								  ->where('fp_tgl','<=',$tgl[1])
								  ->whereNotIn('fp_nofaktur',$req->valid)
								  ->get();

						$temp2 = [];
						for ($i=0; $i < count($bkkd_fp); $i++) { 
							for ($a=0; $a < count($bkkd); $a++) { 
								if ($bkkd_fp[$i]->fp_nofaktur == $bkkd[$a]->bkkd_ref) {
									$temp2[$i] = $bkkd[$a]->bkkd_ref;
								}
							}
						}
						$data = array_merge($temp1,$temp2);
					}

					$unik = array_unique($data);

					$data = DB::table('faktur_pembelian')
							  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  ->whereIn('fp_nofaktur',$unik)
							  ->get();
					if (isset($req->nota)) {

						$bkkd = DB::table('bukti_kas_keluar_detail')
						  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
						  ->where('bkk_nota',$req->nota)
						  ->get();

						for ($i=0; $i < count($data); $i++) { 
						 	for ($a=0; $a < count($bkkd); $a++) { 
						 		if ($data[$i]->fp_nofaktur == $bkkd[$a]->bkkd_ref) {
									$data[$i]->fp_sisapelunasan += $bkkd[$a]->bkkd_total;
						 		}
						 	}
						} 
					}
				}
				return view('purchase.buktikaskeluar.tabel_modal_faktur',compact('data','jenis_bayar'));
			}elseif ($req->filter_faktur == 'jatuh_tempo') {
				$tgl = explode('-',$req->periode);
				$tgl[0] = carbon::parse($tgl[0])->format('Y-m-d');
				$tgl[1] = carbon::parse($tgl[1])->format('Y-m-d');

				if ($req->jenis_bayar == 2) {

					$supplier = DB::table('supplier')
						  ->where('active','AKTIF')
						  ->where('no_supplier',$req->supplier_faktur)
						  ->first();

					$data = DB::table('faktur_pembelian')
							  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  ->select('fp_nofaktur')
							  ->where('fp_idsup',$supplier->idsup)
							  ->where('fp_comp',$req->cabang)
							  ->where('fp_jatuhtempo','>=',$tgl[0])
							  ->where('fp_jatuhtempo','<=',$tgl[1])
							  ->where('fp_sisapelunasan','!=',0)
							  ->whereNotIn('fp_nofaktur',$req->valid)
							  ->get();

					$temp1 = [];

					for ($i=0; $i < count($data); $i++) { 
						$temp1[$i]=$data[$i]->fp_nofaktur;
					}

					if (isset($req->nota)) {

						$bkkd = DB::table('bukti_kas_keluar_detail')
						  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
						  ->where('bkk_nota',$req->nota)
						  ->get();


						$bkkd_fp = DB::table('faktur_pembelian')
								  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  	  ->select('fp_nofaktur')
							  	  ->where('fp_idsup',$supplier->idsup)
								  ->where('fp_comp',$req->cabang)
								  ->where('fp_jatuhtempo','>=',$tgl[0])
								  ->where('fp_jatuhtempo','<=',$tgl[1])
								  ->whereNotIn('fp_nofaktur',$req->valid)
								  ->get();

						$temp2 = [];
						for ($i=0; $i < count($bkkd_fp); $i++) { 
							for ($a=0; $a < count($bkkd); $a++) { 
								if ($bkkd_fp[$i]->fp_nofaktur == $bkkd[$a]->bkkd_ref) {
									$temp2[$i] = $bkkd[$a]->bkkd_ref;
								}
							}
						}
						$data = array_merge($temp1,$temp2);
					}

					$unik = array_unique($data);

					$data = DB::table('faktur_pembelian')
							  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  ->whereIn('fp_nofaktur',$unik)
							  ->get();

					if (isset($req->nota)) {

						$bkkd = DB::table('bukti_kas_keluar_detail')
						  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
						  ->where('bkk_nota',$req->nota)
						  ->get();

						for ($i=0; $i < count($data); $i++) { 
						 	for ($a=0; $a < count($bkkd); $a++) { 
						 		if ($data[$i]->fp_nofaktur == $bkkd[$a]->bkkd_ref) {
									$data[$i]->fp_sisapelunasan += $bkkd[$a]->bkkd_total;
						 		}
						 	}
						} 
					}
				}elseif ($req->jenis_bayar == 6 or $req->jenis_bayar == 7 or $req->jenis_bayar == 9) {
					$data = DB::table('faktur_pembelian')
							  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  ->select('fp_nofaktur')
							  ->where('fp_supplier',$req->supplier_faktur)
							  ->where('fp_comp',$req->cabang)
							  ->where('fp_jatuhtempo','>=',$tgl[0])
							  ->where('fp_jatuhtempo','<=',$tgl[1])
							  ->where('fp_sisapelunasan','!=',0)
							  ->whereNotIn('fp_nofaktur',$req->valid)
							  ->get();

					$temp1 = [];

					for ($i=0; $i < count($data); $i++) { 
						$temp1[$i]=$data[$i]->fp_nofaktur;
					}

					if (isset($req->nota)) {

						$bkkd = DB::table('bukti_kas_keluar_detail')
						  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
						  ->where('bkk_nota',$req->nota)
						  ->get();


						$bkkd_fp = DB::table('faktur_pembelian')
								  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  	  ->select('fp_nofaktur')
							  	  ->where('fp_supplier',$req->supplier_faktur)
								  ->where('fp_comp',$req->cabang)
								  ->where('fp_jatuhtempo','>=',$tgl[0])
								  ->where('fp_jatuhtempo','<=',$tgl[1])
								  ->whereNotIn('fp_nofaktur',$req->valid)
								  ->get();

						$temp2 = [];
						for ($i=0; $i < count($bkkd_fp); $i++) { 
							for ($a=0; $a < count($bkkd); $a++) { 
								if ($bkkd_fp[$i]->fp_nofaktur == $bkkd[$a]->bkkd_ref) {
									$temp2[$i] = $bkkd[$a]->bkkd_ref;
								}
							}
						}
						$data = array_merge($temp1,$temp2);
					}

					$unik = array_unique($data);

					$data = DB::table('faktur_pembelian')
							  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  ->whereIn('fp_nofaktur',$unik)
							  ->get();
					if (isset($req->nota)) {

						$bkkd = DB::table('bukti_kas_keluar_detail')
						  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
						  ->where('bkk_nota',$req->nota)
						  ->get();

						for ($i=0; $i < count($data); $i++) { 
						 	for ($a=0; $a < count($bkkd); $a++) { 
						 		if ($data[$i]->fp_nofaktur == $bkkd[$a]->bkkd_ref) {
									$data[$i]->fp_sisapelunasan += $bkkd[$a]->bkkd_total;
						 		}
						 	}
						} 
					}
				}
				return view('purchase.buktikaskeluar.tabel_modal_faktur',compact('data','jenis_bayar'));
			}elseif ($req->filter_faktur == 'faktur') {

				if ($req->jenis_bayar == 2) {
					$supplier = DB::table('supplier')
							  ->where('active','AKTIF')
							  ->where('no_supplier',$req->supplier_faktur)
							  ->first();

					$data = DB::table('faktur_pembelian')
							  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  ->select('fp_nofaktur')
							  ->where('fp_idsup',$supplier->idsup)
							  ->where('fp_nofaktur',$req->faktur_nomor)
							  ->where('fp_comp',$req->cabang)
							  ->where('fp_sisapelunasan','!=',0)
							  ->whereNotIn('fp_nofaktur',$req->valid)
							  ->get();

					$temp1 = [];

					for ($i=0; $i < count($data); $i++) { 
						$temp1[$i]=$data[$i]->fp_nofaktur;
					}

					if (isset($req->nota)) {

						$bkkd = DB::table('bukti_kas_keluar_detail')
						  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
						  ->where('bkk_nota',$req->nota)
						  ->get();


						$bkkd_fp = DB::table('faktur_pembelian')
								  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  	  ->select('fp_nofaktur')
							  	  ->where('fp_idsup',$supplier->idsup)
							      ->where('fp_nofaktur',$req->faktur_nomor)
								  ->where('fp_comp',$req->cabang)
								  ->whereNotIn('fp_nofaktur',$req->valid)
								  ->get();

						$temp2 = [];
						for ($i=0; $i < count($bkkd_fp); $i++) { 
							for ($a=0; $a < count($bkkd); $a++) { 
								if ($bkkd_fp[$i]->fp_nofaktur == $bkkd[$a]->bkkd_ref) {
									$temp2[$i] = $bkkd[$a]->bkkd_ref;
								}
							}
						}
						$data = array_merge($temp1,$temp2);
					}

					$unik = array_unique($data);
					$data = DB::table('faktur_pembelian')
							  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  ->whereIn('fp_nofaktur',$unik)
							  ->get();

					if (isset($req->nota)) {

						$bkkd = DB::table('bukti_kas_keluar_detail')
						  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
						  ->where('bkk_nota',$req->nota)
						  ->get();

						for ($i=0; $i < count($data); $i++) { 
						 	for ($a=0; $a < count($bkkd); $a++) { 
						 		if ($data[$i]->fp_nofaktur == $bkkd[$a]->bkkd_ref) {
									$data[$i]->fp_sisapelunasan += $bkkd[$a]->bkkd_total;
						 		}
						 	}
						} 
					}
				}elseif ($req->jenis_bayar == 6 or $req->jenis_bayar == 7 or $req->jenis_bayar == 9) {
					$data = DB::table('faktur_pembelian')
							  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  ->select('fp_nofaktur')
							  ->where('fp_supplier',$req->supplier_faktur)
							  ->where('fp_nofaktur',$req->faktur_nomor)
							  ->where('fp_comp',$req->cabang)
							  ->where('fp_sisapelunasan','!=',0)
							  ->whereNotIn('fp_nofaktur',$req->valid)
							  ->get();
					$temp1 = [];

					for ($i=0; $i < count($data); $i++) { 
						$temp1[$i]=$data[$i]->fp_nofaktur;
					}

					if (isset($req->nota)) {

						$bkkd = DB::table('bukti_kas_keluar_detail')
						  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
						  ->where('bkk_nota',$req->nota)
						  ->get();


						$bkkd_fp = DB::table('faktur_pembelian')
								  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  	  ->select('fp_nofaktur')
							  	  ->where('fp_supplier',$req->supplier_faktur)
							      ->where('fp_nofaktur',$req->faktur_nomor)
								  ->where('fp_comp',$req->cabang)
								  ->whereNotIn('fp_nofaktur',$req->valid)
								  ->get();

						$temp2 = [];
						for ($i=0; $i < count($bkkd_fp); $i++) { 
							for ($a=0; $a < count($bkkd); $a++) { 
								if ($bkkd_fp[$i]->fp_nofaktur == $bkkd[$a]->bkkd_ref) {
									$temp2[$i] = $bkkd[$a]->bkkd_ref;
								}
							}
						}
						$data = array_merge($temp1,$temp2);
					}

					$unik = array_unique($data);

					$data = DB::table('faktur_pembelian')
							  ->leftjoin('form_tt','fp_idtt','=','tt_idform')
							  ->whereIn('fp_nofaktur',$unik)
							  ->get();

					if (isset($req->nota)) {

						$bkkd = DB::table('bukti_kas_keluar_detail')
						  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
						  ->where('bkk_nota',$req->nota)
						  ->get();

						for ($i=0; $i < count($data); $i++) { 
						 	for ($a=0; $a < count($bkkd); $a++) { 
						 		if ($data[$i]->fp_nofaktur == $bkkd[$a]->bkkd_ref) {
									$data[$i]->fp_sisapelunasan += $bkkd[$a]->bkkd_total;
						 		}
						 	}
						} 
					}
				}

				return response()->json(['data'=>$data]);
			}
			
		}elseif ($req->jenis_bayar == 3) {
			if ($req->filter_faktur == 'tanggal') {
				$tgl = explode('-',$req->periode);
				$tgl[0] = carbon::parse($tgl[0])->format('Y-m-d');
				$tgl[1] = carbon::parse($tgl[1])->format('Y-m-d');


				 $data = DB::table('v_hutang')
						  ->where('v_supid',$req->supplier_faktur)
						  ->where('vc_comp',$req->cabang)
						  ->where('v_tgl','>=',$tgl[0])
						  ->where('v_tgl','<=',$tgl[1])
						  ->where('v_pelunasan','!=',0)
						  ->whereNotIn('v_nomorbukti',$req->valid)
						  ->get();

				$temp1 = [];

				for ($i=0; $i < count($data); $i++) { 
					$temp1[$i]=$data[$i]->v_nomorbukti;
				}

				if (isset($req->nota)) {

					$bkkd = DB::table('bukti_kas_keluar_detail')
					  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
					  ->where('bkk_nota',$req->nota)
					  ->get();


					$bkkd_fp = DB::table('v_hutang')
						  ->where('v_supid',$req->supplier_faktur)
						  ->where('vc_comp',$req->cabang)
						  ->where('v_tgl','>=',$tgl[0])
						  ->where('v_tgl','<=',$tgl[1])
						  ->whereNotIn('v_nomorbukti',$req->valid)
						  ->get();

					$temp2 = [];
					for ($i=0; $i < count($bkkd_fp); $i++) { 
						for ($a=0; $a < count($bkkd); $a++) { 
							if ($bkkd_fp[$i]->v_nomorbukti == $bkkd[$a]->bkkd_ref) {
								$temp2[$i] = $bkkd[$a]->bkkd_ref;
							}
						}
					}
					$data = array_merge($temp1,$temp2);
				}

				$unik = array_unique($data);
				$data = DB::table('v_hutang')
						  ->whereIn('v_nomorbukti',$unik)
						  ->get();
				if (isset($req->nota)) {

					$bkkd = DB::table('bukti_kas_keluar_detail')
					  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
					  ->where('bkk_nota',$req->nota)
					  ->get();

					for ($i=0; $i < count($data); $i++) { 
					 	for ($a=0; $a < count($bkkd); $a++) { 
					 		if ($data[$i]->v_nomorbukti == $bkkd[$a]->bkkd_ref) {
								$data[$i]->v_pelunasan += $bkkd[$a]->bkkd_total;
					 		}
					 	}
					} 
				}
				return view('purchase.buktikaskeluar.tabel_modal_voucher',compact('data','jenis_bayar'));
			}elseif ($req->filter_faktur == 'jatuh_tempo') {
				$tgl = explode('-',$req->periode);
				$tgl[0] = carbon::parse($tgl[0])->format('Y-m-d');
				$tgl[1] = carbon::parse($tgl[1])->format('Y-m-d');

				$data = DB::table('v_hutang')
						  ->where('v_supid',$req->supplier_faktur)
						  ->where('vc_comp',$req->cabang)
						  ->where('v_tempo','>=',$tgl[0])
						  ->where('v_tempo','<=',$tgl[1])
						  ->where('v_pelunasan','!=',0)
						  ->whereNotIn('v_nomorbukti',$req->valid)
						  ->get();

				$temp1 = [];

				for ($i=0; $i < count($data); $i++) { 
					$temp1[$i]=$data[$i]->fp_nofaktur;
				}

				if (isset($req->nota)) {

					$bkkd = DB::table('bukti_kas_keluar_detail')
					  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
					  ->where('bkk_nota',$req->nota)
					  ->get();


					$bkkd_fp = DB::table('v_hutang')
						  ->where('v_supid',$req->supplier_faktur)
						  ->where('vc_comp',$req->cabang)
						  ->where('v_tempo','>=',$tgl[0])
						  ->where('v_tempo','<=',$tgl[1])
						  ->whereNotIn('v_nomorbukti',$req->valid)
						  ->get();

					$temp2 = [];
					for ($i=0; $i < count($bkkd_fp); $i++) { 
						for ($a=0; $a < count($bkkd); $a++) { 
							if ($bkkd_fp[$i]->v_nomorbukti == $bkkd[$a]->bkkd_ref) {
								$temp2[$i] = $bkkd[$a]->bkkd_ref;
							}
						}
					}
					$data = array_merge($temp1,$temp2);
				}

				$unik = array_unique($data);

				$data = DB::table('v_hutang')
						  ->whereIn('v_nomorbukti',$unik)
						  ->get();
				if (isset($req->nota)) {

					$bkkd = DB::table('bukti_kas_keluar_detail')
					  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
					  ->where('bkk_nota',$req->nota)
					  ->get();

					for ($i=0; $i < count($data); $i++) { 
					 	for ($a=0; $a < count($bkkd); $a++) { 
					 		if ($data[$i]->v_nomorbukti == $bkkd[$a]->bkkd_ref) {
								$data[$i]->v_pelunasan += $bkkd[$a]->bkkd_total;
					 		}
					 	}
					} 
				}
				return view('purchase.buktikaskeluar.tabel_modal_voucher',compact('data','jenis_bayar'));
			}elseif ($req->filter_faktur == 'faktur') {

				$data = DB::table('v_hutang')
						  ->where('v_supid',$req->supplier_faktur)
						  ->where('vc_comp',$req->cabang)
						  ->where('v_nomorbukti',$req->faktur_nomor)
						  ->where('v_pelunasan','!=',0)
						  ->whereNotIn('v_nomorbukti',$req->valid)
						  ->get();
				$temp1 = [];

				for ($i=0; $i < count($data); $i++) { 
					$temp1[$i]=$data[$i]->v_nomorbukti;
				}

				if (isset($req->nota)) {

					$bkkd = DB::table('bukti_kas_keluar_detail')
					  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
					  ->where('bkk_nota',$req->nota)
					  ->get();


					$bkkd_fp = DB::table('v_hutang')
						  ->where('v_supid',$req->supplier_faktur)
						  ->where('vc_comp',$req->cabang)
						  ->where('v_nomorbukti',$req->faktur_nomor)
						  ->whereNotIn('v_nomorbukti',$req->valid)
						  ->get();

					$temp2 = [];
					for ($i=0; $i < count($bkkd_fp); $i++) { 
						for ($a=0; $a < count($bkkd); $a++) { 
							if ($bkkd_fp[$i]->v_nomorbukti == $bkkd[$a]->bkkd_ref) {
								$temp2[$i] = $bkkd[$a]->bkkd_ref;
							}
						}
					}
					$data = array_merge($temp1,$temp2);
				}

				$unik = array_unique($data);

				$data = DB::table('v_hutang')
						  ->whereIn('v_nomorbukti',$unik)
						  ->get();
				if (isset($req->nota)) {

					$bkkd = DB::table('bukti_kas_keluar_detail')
					  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
					  ->where('bkk_nota',$req->nota)
					  ->get();

					for ($i=0; $i < count($data); $i++) { 
					 	for ($a=0; $a < count($bkkd); $a++) { 
					 		if ($data[$i]->v_nomorbukti == $bkkd[$a]->bkkd_ref) {
								$data[$i]->v_pelunasan += $bkkd[$a]->bkkd_total;
					 		}
					 	}
					} 
				}

				return response()->json(['data'=>$data]);
			}
		}elseif ($req->jenis_bayar == 4) {
			if ($req->filter_faktur == 'tanggal') {
				$tgl = explode('-',$req->periode);
				$tgl[0] = carbon::parse($tgl[0])->format('Y-m-d');
				$tgl[1] = carbon::parse($tgl[1])->format('Y-m-d');


				 $data = DB::table('d_uangmuka')
						  ->where('um_supplier',$req->supplier_faktur)
						  ->where('um_comp',$req->cabang)
						  ->where('um_tgl','>=',$tgl[0])
						  ->where('um_tgl','<=',$tgl[1])
						  ->where('um_sisapelunasan','!=',0)
						  ->whereNotIn('um_nomorbukti',$req->valid)
						  ->get();

				$temp1 = [];

				for ($i=0; $i < count($data); $i++) { 
					$temp1[$i]=$data[$i]->um_nomorbukti;
				}

				if (isset($req->nota)) {

					$bkkd = DB::table('bukti_kas_keluar_detail')
					  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
					  ->where('bkk_nota',$req->nota)
					  ->get();


					$bkkd_fp = DB::table('d_uangmuka')
						  ->where('um_supplier',$req->supplier_faktur)
						  ->where('um_comp',$req->cabang)
						  ->where('um_tgl','>=',$tgl[0])
						  ->where('um_tgl','<=',$tgl[1])
						  ->whereNotIn('um_nomorbukti',$req->valid)
						  ->get();

					$temp2 = [];
					for ($i=0; $i < count($bkkd_fp); $i++) { 
						for ($a=0; $a < count($bkkd); $a++) { 
							if ($bkkd_fp[$i]->um_nomorbukti == $bkkd[$a]->bkkd_ref) {
								$temp2[$i] = $bkkd[$a]->bkkd_ref;
							}
						}
					}
					$data = array_merge($temp1,$temp2);
				}

				$unik = array_unique($data);
				$data = DB::table('d_uangmuka')
						  ->whereIn('um_nomorbukti',$unik)
						  ->get();
				if (isset($req->nota)) {

					$bkkd = DB::table('bukti_kas_keluar_detail')
					  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
					  ->where('bkk_nota',$req->nota)
					  ->get();

					for ($i=0; $i < count($data); $i++) { 
					 	for ($a=0; $a < count($bkkd); $a++) { 
					 		if ($data[$i]->um_nomorbukti == $bkkd[$a]->bkkd_ref) {
								$data[$i]->um_sisapelunasan += $bkkd[$a]->bkkd_total;
					 		}
					 	}
					} 
				}
				return view('purchase.buktikaskeluar.tabel_modal_um',compact('data','jenis_bayar'));
			}elseif ($req->filter_faktur == 'jatuh_tempo') {
				$tgl = explode('-',$req->periode);
				$tgl[0] = carbon::parse($tgl[0])->format('Y-m-d');
				$tgl[1] = carbon::parse($tgl[1])->format('Y-m-d');

				$data = DB::table('d_uangmuka')
						  ->where('um_supplier',$req->supplier_faktur)
						  ->where('um_comp',$req->cabang)
						  ->where('um_tgl','>=',$tgl[0])
						  ->where('um_tgl','<=',$tgl[1])
						  ->where('um_sisapelunasan','!=',0)
						  ->whereNotIn('um_nomorbukti',$req->valid)
						  ->get();

				$temp1 = [];

				for ($i=0; $i < count($data); $i++) { 
					$temp1[$i]=$data[$i]->fp_nofaktur;
				}

				if (isset($req->nota)) {

					$bkkd = DB::table('bukti_kas_keluar_detail')
					  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
					  ->where('bkk_nota',$req->nota)
					  ->get();


					$bkkd_fp = DB::table('d_uangmuka')
						  ->where('um_supplier',$req->supplier_faktur)
						  ->where('um_comp',$req->cabang)
						  ->where('um_tgl','>=',$tgl[0])
						  ->where('um_tgl','<=',$tgl[1])
						  ->whereNotIn('um_nomorbukti',$req->valid)
						  ->get();

					$temp2 = [];
					for ($i=0; $i < count($bkkd_fp); $i++) { 
						for ($a=0; $a < count($bkkd); $a++) { 
							if ($bkkd_fp[$i]->um_nomorbukti == $bkkd[$a]->bkkd_ref) {
								$temp2[$i] = $bkkd[$a]->bkkd_ref;
							}
						}
					}
					$data = array_merge($temp1,$temp2);
				}

				$unik = array_unique($data);

				$data = DB::table('d_uangmuka')
						  ->whereIn('um_nomorbukti',$unik)
						  ->get();
				if (isset($req->nota)) {

					$bkkd = DB::table('bukti_kas_keluar_detail')
					  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
					  ->where('bkk_nota',$req->nota)
					  ->get();

					for ($i=0; $i < count($data); $i++) { 
					 	for ($a=0; $a < count($bkkd); $a++) { 
					 		if ($data[$i]->um_nomorbukti == $bkkd[$a]->bkkd_ref) {
								$data[$i]->um_sisapelunasan += $bkkd[$a]->bkkd_total;
					 		}
					 	}
					} 
				}
				return view('purchase.buktikaskeluar.tabel_modal_um',compact('data','jenis_bayar'));
			}elseif ($req->filter_faktur == 'faktur') {

				$data = DB::table('d_uangmuka')
						  ->where('um_supplier',$req->supplier_faktur)
						  ->where('um_comp',$req->cabang)
						  ->where('um_nomorbukti',$req->faktur_nomor)
						  ->where('um_sisapelunasan','!=',0)
						  ->whereNotIn('um_nomorbukti',$req->valid)
						  ->get();
				$temp1 = [];

				for ($i=0; $i < count($data); $i++) { 
					$temp1[$i]=$data[$i]->um_nomorbukti;
				}

				if (isset($req->nota)) {

					$bkkd = DB::table('bukti_kas_keluar_detail')
					  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
					  ->where('bkk_nota',$req->nota)
					  ->get();


					$bkkd_fp = DB::table('d_uangmuka')
						  ->where('um_supplier',$req->supplier_faktur)
						  ->where('um_comp',$req->cabang)
						  ->where('um_nomorbukti',$req->faktur_nomor)
						  ->whereNotIn('um_nomorbukti',$req->valid)
						  ->get();

					$temp2 = [];
					for ($i=0; $i < count($bkkd_fp); $i++) { 
						for ($a=0; $a < count($bkkd); $a++) { 
							if ($bkkd_fp[$i]->um_nomorbukti == $bkkd[$a]->bkkd_ref) {
								$temp2[$i] = $bkkd[$a]->bkkd_ref;
							}
						}
					}
					$data = array_merge($temp1,$temp2);
				}

				$unik = array_unique($data);

				$data = DB::table('d_uangmuka')
						  ->whereIn('um_nomorbukti',$unik)
						  ->get();
				if (isset($req->nota)) {

					$bkkd = DB::table('bukti_kas_keluar_detail')
					  ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
					  ->where('bkk_nota',$req->nota)
					  ->get();

					for ($i=0; $i < count($data); $i++) { 
					 	for ($a=0; $a < count($bkkd); $a++) { 
					 		if ($data[$i]->um_nomorbukti == $bkkd[$a]->bkkd_ref) {
								$data[$i]->um_sisapelunasan += $bkkd[$a]->bkkd_total;
					 		}
					 	}
					} 
				}

				return response()->json(['data'=>$data]);
			}
		}

	}

	public function update_form(request $req)
	{
		return DB::transaction(function() use ($req) {  
			// dd($req->all());
			$cari_nota = DB::table('bukti_kas_keluar')
						   ->where('bkk_nota',$req->nota)
						   ->first();
			if ($cari_nota == null) {
				return response()->json(['status'=>3]);
			}

			$id = $cari_nota->bkk_id;


			$cari_dt = DB::table('bukti_kas_keluar_detail')
						 ->where('bkkd_bkk_id',$id)
						 ->get();

			for ($i=0; $i < count($cari_dt); $i++) { 
				$detail = DB::table('bukti_kas_keluar_detail')
							->where('bkkd_ref',$cari_dt[$i]->bkkd_ref)
							->first();

				if ($cari_nota->bkk_jenisbayar == 2 or $cari_nota->bkk_jenisbayar == 6 or $cari_nota->bkk_jenisbayar == 7 or $cari_nota->bkk_jenisbayar == 9) {
					$cari_faktur = DB::table('faktur_pembelian')
									 ->where('fp_nofaktur',$detail->bkkd_ref)
									 ->first();
					$update_faktur =DB::table('faktur_pembelian')
									  ->where('fp_nofaktur',$detail->bkkd_ref)
									  ->update([
									  	'fp_sisapelunasan' => $cari_faktur->fp_sisapelunasan + $detail->bkkd_total
									  ]);
				}elseif ($cari_nota->bkk_jenisbayar == 3) {
					$cari_faktur = DB::table('v_hutang')
									 ->where('v_nomorbukti',$detail->bkkd_ref)
									 ->first();
					$update_faktur =DB::table('v_hutang')
									  ->where('v_nomorbukti',$detail->bkkd_ref)
									  ->update([
									  	'v_pelunasan' => $cari_faktur->v_pelunasan + $detail->bkkd_total
									  ]);
				}else{
					$cari_faktur = DB::table('d_uangmuka')
									 ->where('um_nomorbukti',$detail->bkkd_ref)
									 ->first();

					$update_faktur = DB::table('d_uangmuka')
									  ->where('um_nomorbukti',$detail->bkkd_ref)
									  ->update([
									  	'um_sisapelunasan' => $cari_faktur->um_sisapelunasan + $detail->bkkd_total,
									  	'um_sisaterpakai' => $cari_faktur->um_sisaterpakai - $detail->bkkd_total
									  ]);
			
				}
			}

			$delete = DB::table('bukti_kas_keluar_detail')
							->where('bkkd_bkk_id',$id)
							->delete();

			$nota = $req->nota;
			$header = DB::table('bukti_kas_keluar')
			      ->where('bkk_id',$id)
				  ->update([
				  	'bkk_id'  			=> $id,
					'bkk_nota' 			=> $nota,
					'bkk_tgl' 			=> carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
					'bkk_jenisbayar' 	=> $req->jenis_bayar,
					'bkk_keterangan' 	=> strtoupper($req->keterangan_head),
					'bkk_comp' 			=> $req->cabang,
					'bkk_total' 		=> filter_var($req->total, FILTER_SANITIZE_NUMBER_INT)/100,
					'updated_at' 		=> carbon::now(),
					'bkk_akun_kas' 		=> $req->kas,
					'bkk_supplier' 		=> $req->supplier_faktur,
					'bkk_akun_hutang' 	=> $req->hutang,
					'bkk_status' 		=> 'RELEASED',
					'updated_by' 		=> Auth::user()->m_name,
			  	]);

			$id_pt = DB::table('patty_cash')
					   ->max('pc_id')+1;	

			$patty_cash = DB::table('patty_cash')
						->insert([
							'pc_id'			=> $id_pt,
							'pc_ref'  		=> $req->jenis_bayar,
							'pc_akun'  		=> $req->kas,
							'pc_keterangan' => strtoupper($req->keterangan_head),
							'pc_debet' 		=> filter_var($req->total, FILTER_SANITIZE_NUMBER_INT)/100,
							'pc_kredit' 	=> 0,
							'updated_at' 	=> carbon::now(),
							'created_at' 	=> carbon::now(),
							'pc_akun_kas' 	=> $req->kas,
							'pc_tgl' 		=> carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
							'pc_user'  		=> Auth::user()->m_name,
							'pc_comp' 		=> $req->cabang,
							'pc_asal_comp'	=> $req->cabang,
							'pc_no_trans' 	=> $nota,
							'pc_edit'  		=> 'UNALLOWED',
							'pc_reim'  		=> 'UNRELEASED',
						]);	

			for ($i=0; $i < count($req->fp_faktur); $i++) {

				$id_dt = DB::table('bukti_kas_keluar_detail')
						   ->max('bkkd_id');
				if ($id_dt == null) {
					$id_dt = 1;
				}else{
					$id_dt += 1;
				}

				if ($req->jenis_bayar == 4) {
					$sisa_um = filter_var($req->fp_pelunasan[$i], FILTER_SANITIZE_NUMBER_FLOAT);
				}else{
					$sisa_um = 0;
				}

				$detail = DB::table('bukti_kas_keluar_detail')
				  ->insert([
				  	'bkkd_id'  			=> $id_dt,
					'bkkd_bkk_id'  		=> $id,
					'bkkd_bkk_dt'  		=> $i+1,
					'bkkd_keterangan' 	=> strtoupper($req->fp_keterangan[$i]),
					'bkkd_akun'  		=> $req->hutang,
					'bkkd_total' 		=> filter_var($req->fp_pelunasan[$i], FILTER_SANITIZE_NUMBER_FLOAT),
					'bkkd_debit' 		=> 'DEBET',
					'updated_at'		=> carbon::now(),
					'created_at' 		=> carbon::now(),
					'bkkd_ref' 			=> $req->fp_faktur[$i],
					'bkkd_sisaum'		=> $sisa_um,
					'bkkd_supplier' 	=> $req->supplier_faktur,
					]);

				if ($req->jenis_bayar == 2 or $req->jenis_bayar == 6 or $req->jenis_bayar == 7 or $req->jenis_bayar == 9) {
					$cari_faktur = DB::table('faktur_pembelian')
									 ->where('fp_nofaktur',$req->fp_faktur[$i])
									 ->first();
					$update_faktur =DB::table('faktur_pembelian')
									  ->where('fp_nofaktur',$req->fp_faktur[$i])
									  ->update([
									  	'fp_sisapelunasan' => $cari_faktur->fp_sisapelunasan - filter_var($req->fp_pelunasan[$i], FILTER_SANITIZE_NUMBER_FLOAT)
									  ]);
				}elseif ($req->jenis_bayar == 3) {
					$cari_faktur = DB::table('v_hutang')
									 ->where('v_nomorbukti',$req->fp_faktur[$i])
									 ->first();
					$update_faktur =DB::table('v_hutang')
									  ->where('v_nomorbukti',$req->fp_faktur[$i])
									  ->update([
									  	'v_pelunasan' => $cari_faktur->v_pelunasan - filter_var($req->fp_pelunasan[$i], FILTER_SANITIZE_NUMBER_FLOAT)
									  ]);
				}else{
					$cari_faktur = DB::table('d_uangmuka')
									 ->where('um_nomorbukti',$req->fp_faktur[$i])
									 ->first();
							$update_faktur =DB::table('d_uangmuka')
									  ->where('um_nomorbukti',$req->fp_faktur[$i])
									  ->update([
									  	'um_sisapelunasan' => $cari_faktur->um_sisapelunasan - filter_var($req->fp_pelunasan[$i], FILTER_SANITIZE_NUMBER_FLOAT),
									  	'um_sisaterpakai' => $cari_faktur->um_sisaterpakai + filter_var($req->fp_pelunasan[$i], FILTER_SANITIZE_NUMBER_FLOAT)
									  ]);
				}
				

			}


			


			// //JURNAL

			$delete_jurnal = DB::table('d_jurnal')
							   ->where('jr_ref',$nota)
							   ->delete();

			$id_jurnal=d_jurnal::max('jr_id')+1;
			// dd($id_jurnal);
			$jenis_bayar = DB::table('jenisbayar')
							 ->where('idjenisbayar',$req->jenis_bayar)
							 ->first();

			$jurnal = d_jurnal::create(['jr_id'		=> $id_jurnal,
										'jr_year'   => carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y'),
										'jr_date' 	=> carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
										'jr_detail' => $jenis_bayar->jenisbayar,
										'jr_ref'  	=> $nota,
										'jr_note'  	=> 'BUKTI KAS KELUAR',
										'jr_insert' => carbon::now(),
										'jr_update' => carbon::now(),
										]);

			if ($req->jenis_bayar == 2 || $req->jenis_bayar == 6 || $req->jenis_bayar == 7  || $req->jenis_bayar == 9 || $req->jenis_bayar == 3)  {

				$akun 	  = [];
				$akun_val = [];
				$jumlah   = [];
				array_push($akun, $req->kas);
				array_push($akun, '2102');
				array_push($akun_val, filter_var($req->total, FILTER_SANITIZE_NUMBER_INT)/100);

				for ($i=0; $i < count($req->fp_pelunasan); $i++) { 
					array_push($jumlah, filter_var($req->fp_pelunasan[$i], FILTER_SANITIZE_NUMBER_FLOAT));
				}

				$jumlah = array_sum($jumlah);

				array_push($akun_val, $jumlah);

				$data_akun = [];
				for ($i=0; $i < count($akun); $i++) { 

					$cari_coa = DB::table('d_akun')
									  ->where('id_akun','like',$akun[$i].'%')
									  ->where('kode_cabang',$req->cabang)
									  ->first();

					if (substr($akun[$i],0, 1)==1) {
						
						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'K';
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'D';
						}
					}else if (substr($akun[$i],0, 1)>1) {

						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'K';
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'D';
						}
					}


					$id_pt = DB::table('patty_cash')
						   ->max('pc_id');
						if ($id_pt == null) {
							$id_pt = 1;
						}else{
							$id_pt += 1;
						}

					$patty_cash = DB::table('patty_cash')
									->insert([
										'pc_id'  		=> $id_pt,
										'pc_ref'  		=> $req->jenis_bayar,
										'pc_akun'  		=> $cari_coa->id_akun,
										'pc_keterangan' => strtoupper($req->keterangan_head),
										'pc_debet' 		=> 0,
										'pc_kredit' 	=> filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT),
										'updated_at' 	=> carbon::now(),
										'created_at' 	=> carbon::now(),
										'pc_akun_kas' 	=> $req->kas,
										'pc_tgl' 		=> carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
										'pc_user'  		=> Auth::user()->m_name,
										'pc_comp' 		=> $req->cabang,
										'pc_asal_comp'	=> $req->cabang,
										'pc_no_trans' 	=> $nota,
										'pc_edit'  		=> 'UNALLOWED',
										'pc_reim'  		=> 'UNRELEASED',
									]);	
				}
			}elseif ($req->jenis_bayar == 4) {
				$akun 	  = [];
				$akun_val = [];
				$jumlah   = [];
				$comp     = [];
				
				array_push($akun, $req->kas);
				array_push($akun, '1405');
				array_push($akun_val, filter_var($req->total, FILTER_SANITIZE_NUMBER_INT)/100);

				for ($i=0; $i < count($req->fp_pelunasan); $i++) { 
					array_push($jumlah, filter_var($req->fp_pelunasan[$i], FILTER_SANITIZE_NUMBER_FLOAT));
				}

				$jumlah = array_sum($jumlah);

				array_push($akun_val, $jumlah);

				$data_akun = [];
				for ($i=0; $i < count($akun); $i++) { 

					$cari_coa = DB::table('d_akun')
									  ->where('id_akun','like',$akun[$i].'%')
									  ->where('kode_cabang',$req->cabang)
									  ->first();
					if (substr($akun[$i],0, 4) == 1001) {
						
						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'K';
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'D';
						}
					}else if (substr($akun[$i],0, 2) == 14) {

						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'D';
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT);
							$data_akun[$i]['jrdt_statusdk'] = 'K';
						}
					}

					$id_pt = DB::table('patty_cash')
						   ->max('pc_id');
						if ($id_pt == null) {
							$id_pt = 1;
						}else{
							$id_pt += 1;
						}

					$patty_cash = DB::table('patty_cash')
									->insert([
										'pc_id'  		=> $id_pt,
										'pc_ref'  		=> $req->jenis_bayar,
										'pc_akun'  		=> $cari_coa->id_akun,
										'pc_keterangan' => strtoupper($req->keterangan_head),
										'pc_debet' 		=> 0,
										'pc_kredit' 	=> filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_FLOAT),
										'updated_at' 	=> carbon::now(),
										'created_at' 	=> carbon::now(),
										'pc_akun_kas' 	=> $req->kas,
										'pc_tgl' 		=> carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
										'pc_user'  		=> Auth::user()->m_name,
										'pc_comp' 		=> $req->cabang,
										'pc_asal_comp'	=> $req->cabang,
										'pc_no_trans' 	=> $nota,
										'pc_edit'  		=> 'UNALLOWED',
										'pc_reim'  		=> 'UNRELEASED',
									]);	
				}
				
			}
			
			// dd($data_akun);
			$jurnal_dt = d_jurnal_dt::insert($data_akun);
			$lihat = d_jurnal_dt::where('jrdt_jurnal',$id_jurnal)->get();
			// dd($lihat);

			return response()->json(['status'=>1]);

		});
	}

	public function jurnal(request $req)
	{
		$bkk = DB::table('bukti_kas_keluar')	
				 ->where('bkk_id',$req->id)
				 ->first();
		$data= DB::table('d_jurnal')
				 ->join('d_jurnal_dt','jrdt_jurnal','=','jr_id')
				 ->join('d_akun','jrdt_acc','=','id_akun')
				 ->where('jr_ref',$bkk->bkk_nota)
				 ->get();


		$d = [];
		$k = [];
		for ($i=0; $i < count($data); $i++) { 
			if ($data[$i]->jrdt_value < 0) {
				$data[$i]->jrdt_value *= -1;
			}
		}

		for ($i=0; $i < count($data); $i++) { 
			if ($data[$i]->jrdt_statusdk == 'D') {
				$d[$i] = $data[$i]->jrdt_value;
			}elseif ($data[$i]->jrdt_statusdk == 'K') {
				$k[$i] = $data[$i]->jrdt_value;
			}
		}
		$d = array_values($d);
		$k = array_values($k);

		$d = array_sum($d);
		$k = array_sum($k);

		return view('purchase.buktikaskeluar.jurnal',compact('data','d','k'));
	}

	public function printing(request $req){
		

		$cari_bkk_id = DB::table('bukti_kas_keluar')
					  ->join('cabang','kode','=','bkk_comp')
					  ->join('d_akun','id_akun','=','bkk_akun_kas')
					  ->join('jenisbayar','idjenisbayar','=','bkk_jenisbayar')
					  ->where('bkk_id',$req->id)
					  ->first();

		$tgl = Carbon::parse($cari_bkk_id->bkk_tgl)->format('d/m/y');

	    $cari_bkk_dt = DB::table('bukti_kas_keluar')
					  ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
					  ->join('cabang','kode','=','bkk_comp')
					  ->join('d_akun','id_akun','=','bkk_akun_kas')
					  ->join('jenisbayar','idjenisbayar','=','bkk_jenisbayar')
					  ->where('bkk_id',$req->id)
					  ->get();

		$terbilang = $this->terbilang($cari_bkk_id->bkk_total,$style=3);
			  
		

		return view('purchase/buktikaskeluar/print',compact('cari_bkk_id','cari_bkk_dt','tgl','terbilang'));

	}
	public function hapus(request $req)
	{
		return DB::transaction(function() use ($req) {  
			$cari_nota = DB::table('bukti_kas_keluar')
						   ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
						   ->where('bkk_id',$req->id)
						   ->get();

			for ($i=0; $i < count($cari_nota); $i++) { 

				if ($cari_nota[$i]->bkk_jenisbayar == 2 or $cari_nota[$i]->bkk_jenisbayar == 6 or $cari_nota[$i]->bkk_jenisbayar == 7 or $cari_nota[$i]->bkk_jenisbayar == 9) {
					$cari_faktur = DB::table('faktur_pembelian')
									 ->where('fp_nofaktur',$cari_nota[$i]->bkkd_ref)
									 ->first();
					$update_faktur =DB::table('faktur_pembelian')
									  ->where('fp_nofaktur',$cari_nota[$i]->bkkd_ref)
									  ->update([
									  	'fp_sisapelunasan' => $cari_faktur->fp_sisapelunasan + $cari_nota[$i]->bkkd_total
									  ]);
				}elseif ($cari_nota[0]->bkk_jenisbayar == 3) {
					$cari_faktur = DB::table('v_hutang')
									 ->where('v_nomorbukti',$cari_nota[$i]->bkkd_ref)
									 ->first();
					$update_faktur =DB::table('v_hutang')
									  ->where('v_nomorbukti',$cari_nota[$i]->bkkd_ref)
									  ->update([
									  	'v_pelunasan' => $cari_faktur->v_pelunasan + $cari_nota[$i]->bkkd_total
									  ]);
				}else if($cari_nota[0]->bkk_jenisbayar == 4){
					$cari_faktur = DB::table('d_uangmuka')
									 ->where('um_nomorbukti',$cari_nota[$i]->bkkd_ref)
									 ->first();

					$update_faktur = DB::table('d_uangmuka')
									  ->where('um_nomorbukti',$cari_nota[$i]->bkkd_ref)
									  ->update([
									  	'um_sisapelunasan' => $cari_faktur->um_sisapelunasan + $cari_nota[$i]->bkkd_total,
									  	'um_sisaterpakai' => $cari_faktur->um_sisaterpakai - $cari_nota[$i]->bkkd_total
									  ]);
				}
			}

			$delete_jurnal = DB::table('d_jurnal')
							   ->where('jr_ref',$cari_nota[0]->bkk_nota)
							   ->delete();

			$delete_patty = DB::table('patty_cash')
							   ->where('pc_no_trans',$cari_nota[0]->bkk_nota)
							   ->delete();

			$delete_bkk   = DB::table('bukti_kas_keluar')
							   ->where('bkk_nota',$cari_nota[0]->bkk_nota)
							   ->delete();

			
		});
	}

		public function patty_cash(){

		$second = Carbon::now()->format('d/m/Y');
	        // $start = $first->subMonths(1)->startOfMonth();
		$first = Carbon::now();
	    $start = $first->subDays(30)->startOfDay()->format('d/m/Y');

	    $jenisbayar = DB::table('jenisbayar')
	    				->orderBy('idjenisbayar','asc')
	    				->get();

	    $akun_kas = DB::table('d_akun')
				  ->where('nama_akun','like','%KAS KECIL%')
				  ->get();

		return view('purchase/laporan/laporan_patty',compact('second','start','jenisbayar','akun_kas'));
	}

	public function cari_patty(request $request){
		// dd($request);

		// "rangepicker" => "16/12/2017 - 15/01/2018"
	 //      "jenisbayar" => "8"
	 //      "akun_kas" => "100111001"
    	
		if (isset($request->akun_kas)) {
			// return 'asd';
				$tgl = explode('-',$request->rangepicker);
					$tgl[0] = str_replace('/', '-', $tgl[0]);
					$tgl[1] = str_replace('/', '-', $tgl[1]);
					$tgl[0] = str_replace(' ', '', $tgl[0]);
					$tgl[1] = str_replace(' ', '', $tgl[1]);
					$start  = Carbon::parse($tgl[0])->format('Y-m-d');
					$end    = Carbon::parse($tgl[1])->format('Y-m-d');

				$bkk = DB::table('bukti_kas_keluar')
					 ->select('bkk_nota as nota','created_by')	
					 ->get();

				$bpk = DB::table('biaya_penerus_kas')
					 ->select('bpk_nota as nota','created_by')	
					 ->get();

				$all = array_merge($bkk,$bpk);
				$arr = [];
				for ($i=0; $i < count($all); $i++) { 
					$arr[$i] = $all[$i]->nota;
				}
				
				$data= DB::table('d_jurnal')
						 ->join('d_jurnal_dt','jrdt_jurnal','=','jr_id')
						 ->join('d_akun','jrdt_acc','=','id_akun')
						 ->select('jr_ref','jr_date','jrdt_acc','jrdt_detail','jr_ref','jrdt_value','jrdt_statusdk')
						 ->whereIn('jr_ref',$arr)
						 ->orderBy('jr_ref','jrdt_detailid','ASC')
						 ->get();

				$d = [];
				$k = [];
				for ($i=0; $i < count($data); $i++) { 
					for ($a=0; $a < count($all); $a++) { 
						if ($all[$a]->nota == $data[$i]->jr_ref) {
							$data[$i]->created_by = $all[$a]->created_by;
						}
					}
					if ($data[$i]->jrdt_value < 0) {
						$data[$i]->jrdt_value *= -1;
					}
				}

				for ($i=0; $i < count($data); $i++) { 
					if ($data[$i]->jrdt_statusdk == 'D') {
						$d[$i] = $data[$i]->jrdt_value;
					}elseif ($data[$i]->jrdt_statusdk == 'K') {
						$k[$i] = $data[$i]->jrdt_value;
					}
				}
				$d = array_values($d);
				$k = array_values($k);

				$d = array_sum($d);
				$k = array_sum($k);
				// dd($d);
				return view('purchase/laporan/table_patty',compact('data','akun','d','k'));
		}
	}
}