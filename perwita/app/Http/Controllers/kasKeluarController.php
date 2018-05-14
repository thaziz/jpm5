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

		$data = DB::table('bukti_kas_keluar')
				  ->join('jenisbayar','idjenisbayar','=','bkk_jenisbayar')
				  ->join('cabang','kode','=','bkk_comp')
				  ->orderBy('bkk_id','ASC')
				  ->get();
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
	                                    AND to_char(bkk_tgl,'MM') = '$bulan'
	                                    AND to_char(bkk_tgl,'YY') = '$tahun'");

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
		if ($req->jenis_bayar == 2) {
			$all = DB::select("SELECT no_supplier as kode, nama_supplier as nama from supplier order by no_supplier");
			return view('purchase.buktikaskeluar.supplier_dropdown',compact('all'));
		} elseif($req->jenis_bayar == 3){
			$agen 	  = DB::select("SELECT kode, nama from agen order by kode");

			$vendor   = DB::select("SELECT kode, nama from vendor order by kode "); 

			$subcon   = DB::select("SELECT kode, nama from subcon order by kode "); 

			$supplier = DB::select("SELECT no_supplier as kode, nama_supplier as nama from supplier order by no_supplier");

			$all = array_merge($agen,$vendor,$subcon,$supplier);
			return view('purchase.buktikaskeluar.supplier_dropdown',compact('all'));
		} elseif($req->jenis_bayar == 4){
			$agen 	  = DB::select("SELECT kode, nama from agen order by kode");

			$vendor   = DB::select("SELECT kode, nama from vendor order by kode "); 

			$subcon   = DB::select("SELECT kode, nama from subcon order by kode "); 

			$supplier = DB::select("SELECT no_supplier as kode, nama_supplier as nama from supplier order by no_supplier");

			$all = array_merge($agen,$vendor,$subcon,$supplier);
			return view('purchase.buktikaskeluar.supplier_dropdown',compact('all'));
		} elseif($req->jenis_bayar == 6){
			$agen 	  = DB::select("SELECT kode, nama from agen where kategori != 'OUTLET' order by kode");

			$vendor   = DB::select("SELECT kode, nama from vendor order by kode "); 

			$all = array_merge($agen,$vendor);

			return view('purchase.buktikaskeluar.supplier_dropdown',compact('all'));
		} elseif($req->jenis_bayar == 7){
			$all 	  = DB::select("SELECT kode, nama from agen where kategori = 'OUTLET' order by kode");

			return view('purchase.buktikaskeluar.supplier_dropdown',compact('all'));
		} elseif($req->jenis_bayar == 9){
			$all   = DB::select("SELECT kode, nama from subcon order by kode "); 

			return view('purchase.buktikaskeluar.supplier_dropdown',compact('all'));
		}
	}

	public function save_patty(request $req)
	{
		return DB::transaction(function() use ($req) {  

			// dd($req->all());
			$cari_nota = DB::table('bukti_kas_keluar')
						   ->where('bkk_nota',$req->nota)
						   ->first();



			if ($cari_nota == null) {
				$nota = $req->nota;
			}else{
				$bulan = Carbon::now()->format('m');
			    $tahun = Carbon::now()->format('y');

			    $cari_nota = DB::select("SELECT  substring(max(bkk_nota),13) as id from bukti_kas_keluar
			                                    WHERE bkk_comp = '$req->cabang'
			                                    AND to_char(bkk_tgl,'MM') = '$bulan'
			                                    AND to_char(bkk_tgl,'YY') = '$tahun'");

			    $index = (integer)$cari_nota[0]->id + 1;
			    $index = str_pad($index, 3, '0', STR_PAD_LEFT);

				
				$nota = 'BKK' . $bulan . $tahun . '/' . $req->cabang . '/' .$index;
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
					'bkk_total' 		=> filter_var($req->total, FILTER_SANITIZE_NUMBER_INT),
					'created_at' 		=> carbon::now(),
					'updated_at' 		=> carbon::now(),
					'bkk_akun_kas' 		=> $req->kas,
					'bkk_supplier' 		=> $req->supplier_patty,
					'bkk_akun_hutang' 	=> $req->hutang,
					'bkk_status' 		=> 'RELEASED',
					'updated_by' 		=> Auth::user()->m_name,
	  				'created_by' 		=> Auth::user()->m_name,
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
								'pc_akun'  		=> $req->hutang,
								'pc_keterangan' => strtoupper($req->keterangan_head),
								'pc_debet' 		=> 0,
								'pc_kredit' 	=> filter_var($req->total, FILTER_SANITIZE_NUMBER_INT),
								'updated_at' 	=> carbon::now(),
								'created_at' 	=> carbon::now(),
								'pc_akun_kas' 	=> $req->kas,
								'pc_tgl' 		=> carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
								'pc_user'  		=> Auth::user()->m_name,
								'pc_comp' 		=> $req->cabang,
								'pc_no_trans' 	=> $nota,
								'pc_edit'  		=> 'UNALLOWED',
								'pc_reim'  		=> 'UNRELEASED',
							]);	
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
			array_push($akun_val, $req->total);

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
		}else{
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
		}else{
			
		}
		

		return response()->json(['data'=>$data]);
	}

	public function histori_faktur(request $req)
	{
		if (isset($nota)) {
			$nota = $req->nota;
		}else{
			$nota = 0;
		}

		$fpg = DB::select("SELECT fpg_nofpg as nota, fpg_tgl as tanggal, fpgdt_jumlahtotal as total 
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
			return response()->json(['data'=>$data]);
		}elseif ($req->jenis_bayar == 3) {
			$data = DB::table('v_hutang')
					->where('v_nomorbukti',$req->fp_faktur)
					->first();
			return response()->json(['data'=>$data]);
		}else{

		}
		
	}
	public function save_form(request $req)
	{
		return DB::transaction(function() use ($req) {  
			// dd($req->all());
			$cari_nota = DB::table('bukti_kas_keluar')
						   ->where('bkk_nota',$req->nota)
						   ->first();



			if ($cari_nota == null) {
				$nota = $req->nota;
			}else{
				$bulan = Carbon::now()->format('m');
			    $tahun = Carbon::now()->format('y');

			    $cari_nota = DB::select("SELECT  substring(max(bkk_nota),13) as id from bukti_kas_keluar
			                                    WHERE bkk_comp = '$req->cabang'
			                                    AND to_char(bkk_tgl,'MM') = '$bulan'
			                                    AND to_char(bkk_tgl,'YY') = '$tahun'");

			    $index = (integer)$cari_nota[0]->id + 1;
			    $index = str_pad($index, 3, '0', STR_PAD_LEFT);

				
				$nota = 'BKK' . $bulan . $tahun . '/' . $req->cabang . '/' .$index;
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
					'bkk_total' 		=> filter_var($req->total, FILTER_SANITIZE_NUMBER_INT),
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

				$detail = DB::table('bukti_kas_keluar_detail')
				  ->insert([
				  	'bkkd_id'  			=> $id_dt,
					'bkkd_bkk_id'  		=> $id,
					'bkkd_bkk_dt'  		=> $i+1,
					'bkkd_keterangan' 	=> strtoupper($req->fp_keterangan[$i]),
					'bkkd_akun'  		=> $req->hutang,
					'bkkd_total' 		=> filter_var($req->fp_pelunasan[$i], FILTER_SANITIZE_NUMBER_INT),
					'bkkd_debit' 		=> 'DEBET',
					'updated_at'		=> carbon::now(),
					'created_at' 		=> carbon::now(),
					'bkkd_ref' 			=> $req->fp_faktur[$i],
					'bkkd_supplier' 	=> $req->supplier_faktur,
					]);

				if ($req->jenis_bayar == 2 or $req->jenis_bayar == 6 or $req->jenis_bayar == 7 or $req->jenis_bayar == 9) {
					$cari_faktur = DB::table('faktur_pembelian')
									 ->where('fp_nofaktur',$req->fp_faktur[$i])
									 ->first();
					$update_faktur =DB::table('faktur_pembelian')
									  ->where('fp_nofaktur',$req->fp_faktur[$i])
									  ->update([
									  	'fp_sisapelunasan' => $cari_faktur->fp_sisapelunasan - filter_var($req->fp_pelunasan[$i], FILTER_SANITIZE_NUMBER_INT)
									  ]);
				}elseif ($req->jenis_bayar == 3) {
					$cari_faktur = DB::table('v_hutang')
									 ->where('v_nomorbukti',$req->fp_faktur[$i])
									 ->first();
					$update_faktur =DB::table('v_hutang')
									  ->where('v_nomorbukti',$req->fp_faktur[$i])
									  ->update([
									  	'v_pelunasan' => $cari_faktur->v_pelunasan - filter_var($req->fp_pelunasan[$i], FILTER_SANITIZE_NUMBER_INT)
									  ]);
				}else{
					$cari_faktur = DB::table('v_hutang')
									 ->where('v_nomorbukti',$req->fp_faktur[$i])
									 ->first();
					$update_faktur =DB::table('v_hutang')
									  ->where('v_nomorbukti',$req->fp_faktur[$i])
									  ->update([
									  	'v_pelunasan' => $cari_faktur->v_pelunasan - filter_var($req->fp_pelunasan[$i], FILTER_SANITIZE_NUMBER_INT)
									  ]);
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
								'pc_akun'  		=> $req->hutang,
								'pc_keterangan' => strtoupper($req->keterangan_head),
								'pc_debet' 		=> 0,
								'pc_kredit' 	=> filter_var($req->total, FILTER_SANITIZE_NUMBER_INT),
								'updated_at' 	=> carbon::now(),
								'created_at' 	=> carbon::now(),
								'pc_akun_kas' 	=> $req->kas,
								'pc_tgl' 		=> carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
								'pc_user'  		=> Auth::user()->m_name,
								'pc_comp' 		=> $req->cabang,
								'pc_no_trans' 	=> $nota,
								'pc_edit'  		=> 'UNALLOWED',
								'pc_reim'  		=> 'UNRELEASED',
							]);	
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
			$jumlah   = [];
			array_push($akun, $req->kas);
			array_push($akun, '2101');
			array_push($akun_val, $req->total);

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

				if (substr($akun[$i],0, 1)==1) {
					
					if ($cari_coa->akun_dka == 'D') {
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
						$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'K';
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
						$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'D';
					}
				}else if (substr($akun[$i],0, 1)>1) {

					if ($cari_coa->akun_dka == 'D') {
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
						$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'K';
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
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

}