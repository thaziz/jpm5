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
// use Datatables;


class kasKeluarController extends Controller
{
	public function index(){

		$data = DB::table('bukti_kas_keluar')
				  ->join('jenisbayar','idjenisbayar','=','bkk_jenisbayar')
				  ->join('cabang','kode','=','bkk_comp')
				  ->orderBy('bkk_id','ASC')
				  ->get();

		return view('purchase.buktikaskeluar.indexKasKeluar',compact('data'));
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

	public function create(){
		 $id = DB::table('bukti_kas_keluar')
	    		->where('bkk_comp','001')
	    		->max('bkk_nota');

	    $jenisbayar = DB::table('jenisbayar')
	    			    ->where('idjenisbayar','!=','1')
	    			    ->where('idjenisbayar','!=','10')
	    				->orderBy('idjenisbayar','asc')
	    				->get();
	   	$akun = DB::table('d_akun')
	   			  ->where('id_parrent',5)
	   			  ->get();

	    $year  = Carbon::now()->format('Y'); 
		$month = Carbon::now()->format('m');  	
		$now   = Carbon::now()->format('d-m-Y');
		
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

		$akun_kas = DB::table('d_akun')
				  ->where('id_parrent',1001)
				  ->get();


		$first = Carbon::now();
	    $second = Carbon::now()->format('d/m/Y');
	    $start = $first->subDays(30)->startOfDay()->format('d/m/Y');

		$bkk = 'BKK' . $month . $year . '/'. '001' . '/' .  $id;
		$now = Carbon::now()->format('d/m/Y');

		$agen = DB::select("SELECT kode as kode, nama as nama from agen");

		$vendor = DB::select("SELECT kode as kode, nama as nama from vendor");

		$subcon = DB::select("SELECT kode as kode, nama as nama from subcon");



		$supp = array_merge($agen,$vendor,$subcon);

		$sup_hutang = DB::select("SELECT nama_supplier as nama, no_supplier as kode 
								from supplier
								where status = 'SETUJU'
								and active = 'AKTIF'
								order by no_supplier");
		
		$vendor = DB::select("SELECT kode as kode, nama as nama from vendor");

		$agen = DB::table('agen')
						->get();

		$data = DB::table('subcon')
						->get();

		$supplier = array_merge($sup_hutang,$agen,$data,$vendor);

		
		return view('purchase.buktikaskeluar.createKasKeluar',compact('supplier','bkk','now','jenisbayar','akun','akun_kas','supp','second','start'));
	}

	public function simpan_patty(request $request){
	  // dd($request);
		
		$total = filter_var($request->total_pembayaran, FILTER_SANITIZE_NUMBER_INT);
		$total = $total/100;
		
		

		$cari_id_bkk = DB::table('bukti_kas_keluar')
						 ->max('bkk_id');

		if ($cari_id_bkk == null) {
			$cari_id_bkk = 1;
		}else{
			$cari_id_bkk += 1;
		}
		$cari_bkk = DB::table('bukti_kas_keluar')
					  ->where('bkk_nota',$request->no_trans)
					  ->get();

		if($cari_bkk == null){

			$save_bkk = DB::table('bukti_kas_keluar')
						   ->insert([
						   		'bkk_id'	 	 => $cari_id_bkk,
						   		'bkk_nota'	 	 => $request->no_trans,
						   		'bkk_tgl'		 => Carbon::now(),
						   		'bkk_jenisbayar' => $request->kode_bayar,
						   		'bkk_keterangan' => $request->keterangan,
						   		'bkk_akun_kas'	 => $request->nama_akun,
						   		'bkk_status'	 => 'Released',
						   		'bkk_supplier'	 => $request->nama_orang,
						   		'bkk_comp'		 => '001',
						   		'bkk_total'		 => $total,
						   		'created_at'	 => Carbon::now(),
					        	'updated_at' 	 => Carbon::now()
						   ]);



			for ($i=0; $i < count($request->acc_patty); $i++) { 


				$cari_id_bkkd = DB::table('bukti_kas_keluar_detail')
						 ->max('bkkd_id');

				if ($cari_id_bkkd == null) {
					$cari_id_bkkd = 1;
				}else{
					$cari_id_bkkd += 1;
				}

				$save_bkk_dt = DB::table('bukti_kas_keluar_detail')
						   ->insert([
						   		'bkkd_id'		  => $cari_id_bkkd,
						   		'bkkd_bkk_id'	  => $cari_id_bkk,
						   		'bkkd_bkk_dt'	  => $i+1,
						   		'bkkd_keterangan' => $request->ket_patty[$i],
						   		'bkkd_akun'		  => $request->acc_patty[$i],
						   		'bkkd_total'  	  => $request->bayar_patty[$i],
						   		'bkkd_debit'      => $request->debit_patty[$i],
						   		'created_at'	  => Carbon::now(),
					        	'updated_at' 	  => Carbon::now()
						    ]);
			
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
						   		'pc_tgl'		  => Carbon::now(),
						   		'pc_ref'	 	  => 8,
						   		'pc_akun' 		  => $request->acc_patty[$i],
						   		'pc_akun_kas' 	  => $request->nama_akun,
						   		'pc_keterangan'	  => $request->ket_patty[$i],
						   		'pc_debet'  	  => $request->bayar_patty[$i],
						   		'pc_no_trans'  	  => $request->no_trans,
						   		'pc_kredit'  	  => $request->bayar_patty[$i],
						   		'pc_edit'  	  	  => 'UNALLOWED',
						   		'pc_reim'  	  	  => 'UNRELEASED',
						   		'pc_comp'  	  	  => '001',
						   		'created_at'	  => Carbon::now(),
					        	'updated_at' 	  => Carbon::now()
						    ]);





				// JURNAL 


				
			}
			


			return response()->json(['id' => $cari_id_bkk]);
			

						   
		}else{
			return "DAta Sudah ADA";
		}


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
				  ->where('id_parrent',1001)
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

				$tgl;
				$count = 0;
				if ($request->rangepicker != '') {
					$count += 1;
				}
				if ($request->jenisbayar != '') {
					$count += 1;
				}
				if ($request->akun_kas != '') {
					$count += 1;
				}


				if ($count == 3) {
					

				$cari = DB::table('patty_cash')
							->join('jenisbayar','idjenisbayar','=','pc_ref')
							->join('d_akun','id_akun','=','pc_akun_kas')
							->where('pc_ref','=',$request->jenisbayar)
							->where('pc_akun_kas','=',$request->akun_kas)
							->where('pc_tgl','>=',$start)
							->where('pc_tgl','<=',$end)
							->take(1000)
							->get();
				$akun = DB::table('d_akun')
						  ->get();

				return view('purchase/laporan/table_patty',compact('cari','akun'));
				}else{
					Response()->json(['status'=>2]);
				}
		}else{
			// return 'asd';
				$cari = DB::table('patty_cash')
							->join('jenisbayar','idjenisbayar','=','pc_ref')
							->join('d_akun','id_akun','=','pc_akun_kas')
							->take(1000)
							->get();
				$akun = DB::table('d_akun')
						  ->get();

				return view('purchase/laporan/table_patty',compact('cari','akun'));
		}


	}

	public function detailkas($id){
		

		$cari_bkk_id = DB::table('bukti_kas_keluar')
					  ->join('cabang','kode','=','bkk_comp')
					  ->join('d_akun','id_akun','=','bkk_akun_kas')
					  ->join('jenisbayar','idjenisbayar','=','bkk_jenisbayar')
					  ->where('bkk_id',$id)
					  ->first();

		$tgl = Carbon::parse($cari_bkk_id->bkk_tgl)->format('d/m/y');
	    $cari_bkk_dt = DB::table('bukti_kas_keluar')
					  ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
					  ->join('cabang','kode','=','bkk_comp')
					  ->join('d_akun','id_akun','=','bkk_akun_kas')
					  ->join('jenisbayar','idjenisbayar','=','bkk_jenisbayar')
					  ->where('bkk_id',$id)
					  ->get();

		$terbilang = $this->terbilang($cari_bkk_id->bkk_total,$style=3);
			  
		

		return view('purchase/buktikaskeluar/kaskeluar',compact('cari_bkk_id','cari_bkk_dt','tgl','terbilang'));

	}

	public function edit($id){

		$cari_bkk = DB::table('bukti_kas_keluar')
					  ->where('bkk_id',$id)
					  ->first();

		if($cari_bkk->bkk_jenisbayar == 8){

			$data = DB::table('bukti_kas_keluar')
					  ->join('cabang','kode','=','bkk_comp')
					  ->where('bkk_id',$id)
					  ->first();

			$data_dt = DB::table('bukti_kas_keluar')
					  ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
					  ->where('bkk_id',$id)
					  ->get();

			$akun_kas = DB::table('d_akun')
					  ->where('id_parrent',1001)
					  ->get();

			$jenisbayar = DB::table('jenisbayar')
		    				->orderBy('idjenisbayar','asc')
		    				->get();

		    $akun = DB::table('d_akun')
		   			  ->where('id_parrent',5)
		   			  ->get();

		   	$first = Carbon::now();
	    	$second = Carbon::now()->format('d/m/Y');
	    	$start = $first->subDays(30)->startOfDay()->format('d/m/Y');

			return view('purchase.buktikaskeluar.editkaskeluar',compact('data','data_dt','akun_kas','akun','jenisbayar','id','second','start'));
		}else if ($cari_bkk->bkk_jenisbayar == 2 || 
				  $cari_bkk->bkk_jenisbayar == 6 || 
				  $cari_bkk->bkk_jenisbayar == 7 || 
				  $cari_bkk->bkk_jenisbayar == 9 ||
				  $cari_bkk->bkk_jenisbayar == 3) {

			if ($cari_bkk->bkk_jenisbayar == 6 || $cari_bkk->bkk_jenisbayar == 7) {
				$data = DB::table('bukti_kas_keluar')
					  ->select('bukti_kas_keluar.*','cabang.nama AS nama_cabang','cabang.kode AS kode_cabang','agen.nama AS nama_agen','agen.kode AS kode_agen')
					  ->join('cabang','cabang.kode','=','bukti_kas_keluar.bkk_comp')
					  ->join('agen','agen.kode','=','bukti_kas_keluar.bkk_supplier')
					  ->where('bkk_id',$id)
					  ->first();

				$data_dt = DB::table('bukti_kas_keluar')
					  ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
					  ->join('faktur_pembelian','fp_nofaktur','=','bkkd_ref')
					  ->where('bkk_id',$id)
					  ->get();
			}else if ($cari_bkk->bkk_jenisbayar == 2) {
				$data = DB::table('bukti_kas_keluar')
					  ->select('bukti_kas_keluar.*','cabang.nama AS nama_cabang','cabang.kode AS kode_cabang','nama_supplier AS nama_agen','no_supplier AS kode_agen')
					  ->join('cabang','cabang.kode','=','bukti_kas_keluar.bkk_comp')
					  ->join('supplier','no_supplier','=','bukti_kas_keluar.bkk_supplier')
					  ->where('bkk_id',$id)
					  ->first();

				$data_dt = DB::table('bukti_kas_keluar')
					  ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
					  ->join('faktur_pembelian','fp_nofaktur','=','bkkd_ref')
					  ->where('bkk_id',$id)
					  ->get();
			}else if ($cari_bkk->bkk_jenisbayar == 9) {
				$data = DB::table('bukti_kas_keluar')
					  ->select('bukti_kas_keluar.*','cabang.nama AS nama_cabang','cabang.kode AS kode_cabang','subcon.nama AS nama_agen','subcon.kode AS kode_agen')
					  ->join('cabang','cabang.kode','=','bukti_kas_keluar.bkk_comp')
					  ->join('subcon','subcon.kode','=','bukti_kas_keluar.bkk_supplier')
					  ->where('bkk_id',$id)
					  ->first();

				$data_dt = DB::table('bukti_kas_keluar')
					  ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
					  ->join('faktur_pembelian','fp_nofaktur','=','bkkd_ref')
					  ->where('bkk_id',$id)
					  ->get();
			}elseif ($cari_bkk->bkk_jenisbayar == 3) {
				// return 'asd';
				$supp = DB::select("SELECT no_supplier as kode,nama_supplier as nama 
								from supplier
								where no_supplier = '$cari_bkk->bkk_supplier'
								order by no_supplier");

				$agen = DB::table('agen')
							->where('kode',$cari_bkk->bkk_supplier)
							->get();

				$subcon = DB::table('subcon')
							->where('kode',$cari_bkk->bkk_supplier)
							->get();

				$vendor = DB::table('vendor')
							->where('kode',$cari_bkk->bkk_supplier)
							->get();


			    if ($supp != null) {
			    	$nama = $supp[0]->nama;
			    	$kode = $supp[0]->kode;
			    }elseif ($agen != null) {
			    	$nama = $agen[0]->nama;
			    	$kode = $agen[0]->kode;
			    }elseif ($subcon != null) {
			    	$nama = $subcon[0]->nama;
			    	$kode = $subcon[0]->kode;
			    }elseif ($vendor != null) {
			    	$nama = $vendor[0]->nama;
			    	$kode = $vendor[0]->kode;
			    }else{
			    	$nama = 0;
			    	$kode = 0;
			    }

				$data = DB::table('bukti_kas_keluar')
					  ->where('bkk_id',$id)
					  ->first();

				$data->nama_agen = $nama;
				$data->kode_agen = $kode;

				$data_dt = DB::table('bukti_kas_keluar')
					  ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
					  ->join('v_hutang','v_nomorbukti','=','bkkd_ref')
					  ->where('bkk_id',$id)
					  ->get();

				// return $data->kode;
			}


			$first = Carbon::now();
	    	$second = Carbon::now()->format('d/m/Y');
	    	$start = $first->subDays(30)->startOfDay()->format('d/m/Y');

			
	    	// return count($data_dt);
			$akun_kas = DB::table('d_akun')
					  ->where('id_parrent',1001)
					  ->get();

			$jenisbayar = DB::table('jenisbayar')
		    				->orderBy('idjenisbayar','asc')
		    				->get();

		    $akun = DB::table('d_akun')
		   			  ->where('id_parrent',5)
		   			  ->get();
			return view('purchase.buktikaskeluar.editkaskeluar',compact('data','data_dt','akun_kas','akun','jenisbayar','id','start','second'));

		}else if ($cari_bkk->bkk_jenisbayar == 4) {
			// return 'asd';
				$supp = DB::select("SELECT no_supplier as kode,nama_supplier as nama 
								from supplier
								where no_supplier = '$cari_bkk->bkk_supplier'
								order by no_supplier");

				$agen = DB::table('agen')
							->where('kode',$cari_bkk->bkk_supplier)
							->get();

				$subcon = DB::table('subcon')
							->where('kode',$cari_bkk->bkk_supplier)
							->get();

				$vendor = DB::table('vendor')
							->where('kode',$cari_bkk->bkk_supplier)
							->get();			

			    if ($supp != null) {
			    	$nama = $supp[0]->nama;
			    	$kode = $supp[0]->kode;
			    }elseif ($agen != null) {
			    	$nama = $agen[0]->nama;
			    	$kode = $agen[0]->kode;
			    }elseif ($subcon != null) {
			    	$nama = $subcon[0]->nama;
			    	$kode = $subcon[0]->kode;
			    }elseif ($vendor != null) {
			    	$nama = $vendor[0]->nama;
			    	$kode = $vendor[0]->kode;
			    }else{
			    	$nama = 0;
			    	$kode = 0;
			    }

				$data = DB::table('bukti_kas_keluar')
					  ->where('bkk_id',$id)
					  ->first();

				$data->nama_agen = $nama;
				$data->kode_agen = $kode;

				$data_dt = DB::table('bukti_kas_keluar')
					  ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
					  ->join('d_uangmuka','um_nomorbukti','=','bkkd_ref')
					  ->where('bkk_id',$id)
					  ->get();

				$first = Carbon::now();
		    	$second = Carbon::now()->format('d/m/Y');
		    	$start = $first->subDays(30)->startOfDay()->format('d/m/Y');

				
		    	// return count($data_dt);
				$akun_kas = DB::table('d_akun')
						  ->where('id_parrent',1001)
						  ->get();

				$jenisbayar = DB::table('jenisbayar')
			    				->orderBy('idjenisbayar','asc')
			    				->get();

			    $akun = DB::table('d_akun')
			   			  ->where('id_parrent',5)
			   			  ->get();


			   	$sup_hutang = DB::select("SELECT nama_supplier as nama, no_supplier as kode 
								from supplier
								where status = 'SETUJU'
								and active = 'AKTIF'
								order by no_supplier");
				
				$vendor = DB::select("SELECT kode as kode, nama as nama from vendor");
				
				$agen = DB::table('agen')
								->get();

				$subcon = DB::table('subcon')
								->get();

				$supplier = array_merge($sup_hutang,$agen,$subcon,$vendor);

			return view('purchase.buktikaskeluar.editkaskeluar',compact('data','data_dt','akun_kas','akun','jenisbayar','id','second','start','supplier'));
		}

	}


	public function update_patty(request $request){
		// dd($request);
		$total = filter_var($request->total_pembayaran, FILTER_SANITIZE_NUMBER_INT);
		$total = $total/100;


			$save_bkk = DB::table('bukti_kas_keluar')
						   ->where('bkk_id',$request->id)
						   ->update([
						   		'bkk_total'		 => $total,
					        	'updated_at' 	 => Carbon::now()
						   ]);

			$delete = DB::table('bukti_kas_keluar_detail')
						->where('bkkd_bkk_id',$request->id)
						->delete();
			for ($i=0; $i < count($request->acc_patty); $i++) { 


				$cari_id_bkkd = DB::table('bukti_kas_keluar_detail')
						 ->max('bkkd_id');

				if ($cari_id_bkkd == null) {
					$cari_id_bkkd = 1;
				}else{
					$cari_id_bkkd += 1;
				}

				$save_bkk_dt = DB::table('bukti_kas_keluar_detail')
						   ->insert([
						   		'bkkd_id'		  => $cari_id_bkkd,
						   		'bkkd_bkk_id'	  => $request->id,
						   		'bkkd_bkk_dt'	  => $i+1,
						   		'bkkd_keterangan' => $request->ket_patty[$i],
						   		'bkkd_akun'		  => $request->acc_patty[$i],
						   		'bkkd_total'  	  => $request->bayar_patty[$i],
						   		'bkkd_debit'      => $request->debit_patty[$i],
					        	'updated_at' 	  => Carbon::now()
						    ]);
			
			


		
				$save_patty = DB::table('patty_cash')
						   ->where('pc_no_trans',$request->no_trans)
						   ->update([
						   		'pc_tgl'		  => Carbon::now(),
						   		'pc_ref'	 	  => 8,
						   		'pc_akun' 		  => $request->acc_patty[$i],
						   		'pc_akun_kas' 	  => $request->nama_akun,
						   		'pc_keterangan'	  => $request->ket_patty[$i],
						   		'pc_debet'  	  => $request->bayar_patty[$i],
						   		'pc_no_trans'  	  => $request->no_trans,
						   		'pc_kredit'  	  => $request->bayar_patty[$i],
						   		'pc_comp'  	  	  => '001',
					        	'updated_at' 	  => Carbon::now()
						    ]);





				// JURNAL 


				
			}
			


			return "data berhasil";

			
	}
	public function hapus($id){
		$cari = DB::table('bukti_kas_keluar')
				  ->where('bkk_id',$id)
				  ->first();

		// return $cari->bkk_jenisbayar ;
		if ($cari->bkk_jenisbayar == 8) {
			if($cari != null){
			$hapus = DB::table('patty_cash')
					   ->where('pc_no_trans',$cari->bkk_nota)
					   ->delete();
			$hapus2 = DB::table('bukti_kas_keluar_detail')
						->where('bkkd_bkk_id',$id)
						->delete();

			$hapus3 = DB::table('bukti_kas_keluar')
					  ->where('bkk_id',$id)
					  ->delete();
			}else{
				return 0;
			}

		}elseif($cari->bkk_jenisbayar == 2 || $cari->bkk_jenisbayar == 6 || $cari->bkk_jenisbayar == 7 || $cari->bkk_jenisbayar == 9){
			
			$all_of = DB::table('bukti_kas_keluar')
						 ->where('bkk_id',$id)
						 ->first();	

			// return 'asd';		 
			if ($all_of->bkk_total == 0) {
				$hapus = DB::table('patty_cash')
						   ->where('pc_no_trans',$all_of->bkk_nota)
						   ->delete();
				$hapus3 = DB::table('bukti_kas_keluar')
						  ->where('bkk_id',$id)
						  ->delete();

				$hapus3 = DB::table('bukti_kas_keluar_detail')
						  ->where('bkkd_bkk_id',$id)
						  ->delete();
			}else{
				$cari_bkkd = DB::table('bukti_kas_keluar_detail')
						 ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
						 ->where('bkk_id',$id)
						 ->first();

				$cari_dt = DB::table('bukti_kas_keluar_detail')
							 ->where('bkkd_bkk_id',$id)
							 ->get();
				

				for ($i=0; $i < count($cari_dt); $i++) { 

					$cari_faktur = DB::table('faktur_pembelian')
								 ->where('fp_nofaktur',$cari_dt[$i]->bkkd_ref)
								 ->first();

					$cari_fp_in_bkk =DB::table('bukti_kas_keluar_detail')
								   ->where('bkkd_ref',$cari_faktur->fp_nofaktur)
								   ->get();
				
					$cari_fp_in_fpg =DB::table('fpg_dt')
									   ->where('fpgdt_idfp',$cari_faktur->fp_idfaktur)
									   ->get();
			

					if ($cari_fp_in_bkk != null && $cari_fp_in_fpg != null) {
						$status = 'Approved';
					}else{
						$status = 'Released';
					}

					$update_faktur = DB::table('faktur_pembelian')
								   ->where('fp_nofaktur',$cari_faktur->fp_nofaktur)
								   ->update([
								   		'fp_sisapelunasan' => $cari_faktur->fp_sisapelunasan + $cari_dt[$i]->bkkd_total,
								   		'fp_status'		   => $status,
							    		'updated_at'	   => Carbon::now()
								   ]);
				}
				
				

				$new_bkk = DB::table('bukti_kas_keluar')
							->where('bkk_id',$cari_bkkd->bkk_id)
							->first();

				$hapus = DB::table('patty_cash')
						   ->where('pc_no_trans',$new_bkk->bkk_nota)
						   ->delete();
				$hapus2 = DB::table('bukti_kas_keluar_detail')
							->where('bkkd_bkk_id',$id)
							->delete();

				$hapus3 = DB::table('bukti_kas_keluar')
						  ->where('bkk_id',$id)
						  ->delete();


				return 'success';
			}
		}elseif($cari->bkk_jenisbayar == 3){

			$all_of = DB::table('bukti_kas_keluar')
						 ->where('bkk_id',$id)
						 ->first();			 
			if ($all_of->bkk_total == 0) {
				$hapus = DB::table('patty_cash')
						   ->where('pc_no_trans',$all_of->bkk_nota)
						   ->delete();
				$hapus3 = DB::table('bukti_kas_keluar')
						  ->where('bkk_id',$id)
						  ->delete();

				$hapus3 = DB::table('bukti_kas_keluar_detail')
						  ->where('bkkd_bkk_id',$id)
						  ->delete();
			}else{
				$cari_bkkd = DB::table('bukti_kas_keluar_detail')
						 ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
						 ->where('bkk_id',$id)
						 ->first();

				$cari_dt = DB::table('bukti_kas_keluar_detail')
							 ->where('bkkd_bkk_id',$id)
							 ->get();
				

				for ($i=0; $i < count($cari_dt); $i++) { 

					$cari_faktur = DB::table('v_hutang')
								 ->where('v_nomorbukti',$cari_dt[$i]->bkkd_ref)
								 ->first();

					$cari_fp_in_bkk =DB::table('bukti_kas_keluar_detail')
								   ->where('bkkd_ref',$cari_faktur->v_nomorbukti)
								   ->get();

					$cari_fp_in_fpg =DB::table('fpg_dt')
									   ->where('fpgdt_idfp',$cari_faktur->v_nomorbukti)
									   ->get();
					if ($cari_fp_in_bkk != null && $cari_fp_in_fpg != null) {
						$status = 'Approved';
					}else{
						$status = 'Released';
					}

					$update_faktur = DB::table('v_hutang')
								   ->where('v_nomorbukti',$cari_faktur->v_nomorbukti)
								   ->update([
								   		'v_pelunasan' => $cari_faktur->v_pelunasan + $cari_dt[$i]->bkkd_total,
								   		'v_status'		   => $status,
							    		'updated_at'	   => Carbon::now()
								   ]);
				}
				
				

				$new_bkk = DB::table('bukti_kas_keluar')
							->where('bkk_id',$cari_bkkd->bkk_id)
							->first();

				$hapus = DB::table('patty_cash')
						   ->where('pc_no_trans',$new_bkk->bkk_nota)
						   ->delete();
				$hapus2 = DB::table('bukti_kas_keluar_detail')
							->where('bkkd_bkk_id',$id)
							->delete();

				$hapus3 = DB::table('bukti_kas_keluar')
						  ->where('bkk_id',$id)
						  ->delete();


				return 'success';

			}
		}elseif ($cari->bkk->jenisbayar == 4) {
			
		}
		
	}


	public function cari_faktur(request $request){
		// dd($request);
		

		if ($request->jb == 2 ) {

			$tgl  = explode('-', $request->tgl);
			$tgl[0] = str_replace('/', '-', $tgl[0]);
			$tgl[1] = str_replace('/', '-', $tgl[1]);
			$start = Carbon::parse($tgl[0])->format('Y-m-d');
			$end = Carbon::parse($tgl[1])->format('Y-m-d');
			$id = $request->id;
			$jb = $request->jb;

			$cari_id = DB::table('supplier')
						 ->where('no_supplier',$request->kode)
						 ->first();

			$data = DB::table('faktur_pembelian')
				  ->where('fp_tgl','>=',$start)
				  ->where('fp_tgl','<=',$end)
				  ->where('fp_jenisbayar','=',$request->jb)
				  ->where('fp_idsup','=',$cari_id->idsup)
				  ->where('fp_sisapelunasan','!=',0.00)
				  // ->where('fp_pending_status','=','APPROVED')
				  ->get();
			return view('purchase/buktikaskeluar/modalFaktur',compact('data','id','jb'));

		}elseif ($request->jb == 3) {
			$tgl = explode('-', $request->tgl);
			$tgl[0] = str_replace('/', '-', $tgl[0]);
			$tgl[1] = str_replace('/', '-', $tgl[1]);
			$start = Carbon::parse($tgl[0])->format('Y-m-d');
			$end = Carbon::parse($tgl[1])->format('Y-m-d');
			$id = $request->id;
			$jb = $request->jb;

			 $data = DB::table('v_hutang')
				  ->where('v_tgl','>=',$start)
				  ->where('v_tgl','<=',$end)
				  ->where('v_supid','=',$request->kode)
				  ->where('v_pelunasan','!=',0.00)
				  ->get();
			return view('purchase/buktikaskeluar/modalVoucher',compact('data','id','jb'));

		}elseif ($request->jb == 6 ) {

			$tgl = explode('-', $request->tgl);
			$tgl[0] = str_replace('/', '-', $tgl[0]);
			$tgl[1] = str_replace('/', '-', $tgl[1]);
			$start = Carbon::parse($tgl[0])->format('Y-m-d');
			$end = Carbon::parse($tgl[1])->format('Y-m-d');
			$id = $request->id;
			$jb = $request->jb;

			$data = DB::table('faktur_pembelian')
				  ->join('biaya_penerus','bp_faktur','=','fp_nofaktur')
				  // ->where('fp_tgl','>=',$start)
				  ->where('fp_tgl','<=',$end)
				  ->where('fp_jenisbayar','=',$request->jb)
				  ->where('bp_kode_vendor','=',$request->kode)
				  ->where('fp_sisapelunasan','!=',0.00)
				  ->where('fp_pending_status','=','APPROVED')

				  ->get();
			return view('purchase/buktikaskeluar/modalFaktur',compact('data','id','jb'));

		}elseif ($request->jb == 7 ) {
			$tgl = explode('-', $request->tgl);
			$tgl[0] = str_replace('/', '-', $tgl[0]);
			$tgl[1] = str_replace('/', '-', $tgl[1]);
			$start = Carbon::parse($tgl[0])->format('Y-m-d');
			$end = Carbon::parse($tgl[1])->format('Y-m-d');
			$id = $request->id;
			$jb = $request->jb;

			$data = DB::table('faktur_pembelian')
				  ->join('pembayaran_outlet','pot_faktur','=','fp_nofaktur')
				  ->where('fp_tgl','>=',$start)
				  ->where('fp_tgl','<=',$end)
				  ->where('fp_jenisbayar','=',$request->jb)
				  ->where('pot_kode_outlet','=',$request->kode)
				  ->where('fp_pending_status','=','APPROVED')
				  ->where('fp_sisapelunasan','!=',0.00)
				  ->get();
			return view('purchase/buktikaskeluar/modalFaktur',compact('data','id','jb'));

		}elseif ($request->jb == 9) {
			$tgl = explode('-', $request->tgl);
			$tgl[0] = str_replace('/', '-', $tgl[0]);
			$tgl[1] = str_replace('/', '-', $tgl[1]);
			$start = Carbon::parse($tgl[0])->format('Y-m-d');
			$end = Carbon::parse($tgl[1])->format('Y-m-d');
			$id = $request->id;
			$jb = $request->jb;

			$data = DB::table('faktur_pembelian')
				  ->join('pembayaran_subcon','pb_faktur','=','fp_nofaktur')
				  ->where('fp_tgl','>=',$start)
				  ->where('fp_tgl','<=',$end)
				  ->where('fp_jenisbayar','=',$request->jb)
				  ->where('pb_kode_subcon','=',$request->kode)
				  ->where('fp_pending_status','=','APPROVED')
				  ->where('fp_sisapelunasan','!=',0.00)
				  ->get();

			return view('purchase/buktikaskeluar/modalFaktur',compact('data','id','jb'));

		}elseif ($request->jb == 4) {



			$data = DB::table('d_uangmuka')
				  ->where('um_supplier','=',$request->um)
				  ->where('um_sisapelunasan','!=',0.00)
				  ->get();

			return view('purchase/buktikaskeluar/modalUm',compact('data','id','jb'));
		}
		


	}

	public function cari_detail(request $request){
		// dd($request);
		
			$data = DB::table('bukti_kas_keluar')
						   ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
						   ->where('bkkd_ref',$request->nota)
						   ->get();
			$bkk  = DB::SELECT("SELECT bkk_nota as nota,
									   bkk_tgl  as tgl,
									   bkkd_total as total,
									   bkkd_ref as faktur
								from bukti_kas_keluar 
								inner join bukti_kas_keluar_detail 
								on bkkd_bkk_id = bkk_id 
								where bkkd_ref  = '$request->nota'
								union 
								SELECT fpg_nofpg as nota,
									   fpg_tgl as tgl,
									   fpgdt_pelunasan as total,
									   fpgdt_idfp as faktur 
								from fpg 
								inner join fpg_dt 
								on fpgdt_idfpg = idfpg
								where fpgdt_idfp  = '$request->nota'");
			$total  = 0;
			for ($i=0; $i < count($bkk); $i++) { 
				$total += $bkk[$i]->total;
			}

			if ($request->jb == 2 || $request->jb == 6 || $request->jb == 7 || $request->jb == 9 ) {
				$faktur = DB::table('faktur_pembelian')
						->where('fp_nofaktur',$request->nota) 	
						->first();

				$nota =  'Rp. ' . number_format($faktur->fp_netto,2,',','.');
				$par  = $request->par;
				$sisa =  $faktur->fp_netto - $total;
			}elseif ($request->jb == 3) {
				 $faktur = DB::table('v_hutang')
						->where('v_nomorbukti',$request->nota) 	
						->first();

				$nota =  'Rp. ' . number_format($faktur->v_hasil,2,',','.');
				$par  = $request->par;
				$sisa =  $faktur->v_hasil - $total;
			}
			
			return view('purchase.buktikaskeluar.tablePembayaran',compact('bkk','total','nota','sisa','par'));

		

			

	}
	public function supp_drop(request $request){

		if ($request->id == 2 ) {
			$data = DB::select("SELECT nama_supplier as nama, no_supplier as kode 
								from supplier
								where status = 'SETUJU'
								and active = 'AKTIF'
								order by no_supplier");
					
		}elseif ($request->id == 6 || $request->id == 7 ){
			$agen = DB::table('agen')
						->get();
			$supp = DB::table('vendor')
						->get();
			$data = array_merge($agen,$supp);
		}elseif ($request->id == 4){
			$supp = DB::select("SELECT nama_supplier as nama, no_supplier as kode 
								from supplier
								where status = 'SETUJU'
								and active = 'AKTIF'
								order by no_supplier");

			$agen = DB::table('agen')
						->get();

			$data = DB::table('subcon')
						->get();

			$ven = DB::table('vendor')
						->get();
			$data = array_merge($supp,$agen,$data,$ven);

		}elseif ($request->id == 9) {
			$data = DB::table('subcon')
						->get();
		}elseif ($request->id == 3) {
			$data = DB::select("SELECT nama_supplier as nama, no_supplier as kode 
								from supplier
								where status = 'SETUJU'
								and active = 'AKTIF'
								order by no_supplier");
		}


		return view('purchase.buktikaskeluar.dropdownSupplier',compact('data'));
	}
	public function nama_supp(request $request){
		if ($request->jb == 2) {
			$data = DB::select("SELECT no_supplier as nama,nama_supplier as kode 
								from supplier
								where no_supplier = '$request->id'
								order by no_supplier");
			return response()->json([
							'data'=>$data[0]->kode
						]);
		}elseif ($request->jb == 6 || $request->jb == 7 ){
			$agen = DB::table('agen')
						// ->where('kode',$request->id)
						->get();
			$supp = DB::table('vendor')
						// ->where('kode',$request->id)
						->get();

			$data = array_merge($agen,$supp);
			$nama;
			for ($i=0; $i < count($data); $i++) { 
				if ($data[$i]->kode == $request->id) {
					$nama = $data[$i]->nama;
				}
			}
	
			return response()->json([
							'data'=>$nama
						]);
		}elseif ($request->jb == 9) {
			$data = DB::table('subcon')
						->where('kode',$request->id)
						->first();

			return response()->json([
							'data'=>$data->nama
						]);
		}elseif ($request->jb == 3) {
			$supp = DB::select("SELECT no_supplier as kode,nama_supplier as nama 
								from supplier
								where no_supplier = '$request->id'
								order by no_supplier");

			$agen = DB::table('agen')
						->where('kode',$request->id)
						->get();

			$subcon = DB::table('subcon')
						->where('kode',$request->id)
						->get();

		    if ($supp != null) {
		    	$data = $supp;
		    }elseif ($agen != null) {
		    	$data = $agen;
		    }elseif ($subcon != null) {
		    	$data = $subcon;
		    }else{
		    	$data[0]->nama = 0;
		    }

			return response()->json([
							'data'=>$data[0]->nama
						]);
		}
	}
	public function simpan_faktur(request $request){
		// dd($request);
		if ($request->kode_bayar == 2 || $request->kode_bayar == 6 || $request->kode_bayar == 7 || $request->kode_bayar == 9) {
			$cari_id_bkk = DB::table('bukti_kas_keluar')
						 ->max('bkk_id');


			if ($cari_id_bkk == null) {
					$cari_id_bkk = 1;
				}else{
					$cari_id_bkk += 1;
				}

			$total = filter_var($request->total_pembayaran, FILTER_SANITIZE_NUMBER_INT);
			$total = $total/100;


			// return 'asd';
			$save_bkk = DB::table('bukti_kas_keluar')
						  ->insert([
						   		'bkk_id'	 	 => $cari_id_bkk,
						   		'bkk_nota'	 	 => $request->no_trans,
						   		'bkk_tgl'		 => Carbon::now(),
						   		'bkk_jenisbayar' => $request->kode_bayar,
						   		'bkk_keterangan' => $request->keterangan,
						   		'bkk_akun_kas'	 => $request->nama_akun,
						   		'bkk_supplier'	 => $request->nama_supplier,
						   		'bkk_status'	 => 'Released',
						   		'bkk_comp'		 => '001',
						   		'bkk_akun_hutang'=> 210111000,
						   		'bkk_total'		 => $total,
						   		'created_at'	 => Carbon::now(),
					        	'updated_at' 	 => Carbon::now()
						   ]);

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
						   		'pc_tgl'		  => Carbon::now(),
						   		'pc_ref'	 	  => $request->kode_bayar,
						   		'pc_akun' 		  => 210111000,
						   		'pc_akun_kas' 	  => $request->nama_akun,
						   		'pc_keterangan'	  => $request->keterangan,
						   		'pc_debet'  	  => $total,
						   		'pc_no_trans'  	  => $request->no_trans,
						   		'pc_kredit'  	  => $total,
						   		'pc_edit'  	  	  => 'UNALLOWED',
						   		'pc_reim'  	  	  => 'UNRELEASED',
						   		'pc_comp'  	  	  => '001',
						   		'created_at'	  => Carbon::now(),
					        	'updated_at' 	  => Carbon::now()
						    ]);


			for ($i=0; $i < count($request->nofaktur); $i++) { 

				$cari_id_bkkd = DB::table('bukti_kas_keluar_detail')
						 ->max('bkkd_id');

				if ($cari_id_bkkd == null) {
					$cari_id_bkkd = 1;
				}else{
					$cari_id_bkkd += 1;
				}

				$cari_fp = DB::table('faktur_pembelian')
							 ->where('fp_nofaktur',$request->nofaktur[$i])
							 ->first();

				$biaya = filter_var($request->pelunasan[$i], FILTER_SANITIZE_NUMBER_INT);
				$biaya = $biaya/100;
				$fp = DB::table('faktur_pembelian')
						->where('fp_nofaktur',$request->nofaktur[$i])
						->first();

				$save_bkk_dt = DB::table('bukti_kas_keluar_detail')
						   ->insert([
						   		'bkkd_id'		  => $cari_id_bkkd,
						   		'bkkd_bkk_id'	  => $cari_id_bkk,
						   		'bkkd_bkk_dt'	  => $i+1,
						   		'bkkd_ref'		  => $request->nofaktur[$i],
						   		'bkkd_akun'		  => 210111000,
						   		'bkkd_keterangan' => $request->keterangan_bkkd[$i],
						   		'bkkd_total'  	  => $biaya,
						   		'bkkd_debit'      => 'debit',
						   		'created_at'	  => Carbon::now(),
					        	'updated_at' 	  => Carbon::now()
						    ]);

				$pelunasan = $cari_fp->fp_sisapelunasan - $biaya;

				if ($pelunasan < 0) {
					$pelunasan = 0;
				}

				 $update_faktur = DB::table('faktur_pembelian')
							 ->where('fp_nofaktur',$request->nofaktur[$i])
							 ->update([
								   	'fp_sisapelunasan' => $pelunasan,
								   	'fp_status' => 'Approved'
								   ]);
				

			}

			return response()->json(['id' => $cari_id_bkk]);
			

		}elseif ($request->kode_bayar == 3) {
			////////////////////////////////////////////////
			$cari_id_bkk = DB::table('bukti_kas_keluar')
						 ->max('bkk_id');


			if ($cari_id_bkk == null) {
					$cari_id_bkk = 1;
				}else{
					$cari_id_bkk += 1;
				}

			$total = filter_var($request->total_pembayaran, FILTER_SANITIZE_NUMBER_INT);
			$total = $total/100;


			// return 'asd';
			$save_bkk = DB::table('bukti_kas_keluar')
						  ->insert([
						   		'bkk_id'	 	 => $cari_id_bkk,
						   		'bkk_nota'	 	 => $request->no_trans,
						   		'bkk_tgl'		 => Carbon::now(),
						   		'bkk_jenisbayar' => $request->kode_bayar,
						   		'bkk_keterangan' => $request->keterangan,
						   		'bkk_akun_kas'	 => $request->nama_akun,
						   		'bkk_supplier'	 => $request->nama_supplier,
						   		'bkk_status'	 => 'Released',
						   		'bkk_comp'		 => '001',
						   		'bkk_akun_hutang'=> 210111000,
						   		'bkk_total'		 => $total,
						   		'created_at'	 => Carbon::now(),
					        	'updated_at' 	 => Carbon::now()
						   ]);

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
						   		'pc_tgl'		  => Carbon::now(),
						   		'pc_ref'	 	  => $request->kode_bayar,
						   		'pc_akun' 		  => 210111000,
						   		'pc_akun_kas' 	  => $request->nama_akun,
						   		'pc_keterangan'	  => $request->keterangan,
						   		'pc_debet'  	  => $total,
						   		'pc_no_trans'  	  => $request->no_trans,
						   		'pc_kredit'  	  => $total,
						   		'pc_edit'  	  	  => 'UNALLOWED',
						   		'pc_reim'  	  	  => 'UNRELEASED',
						   		'pc_comp'  	  	  => '001',
						   		'created_at'	  => Carbon::now(),
					        	'updated_at' 	  => Carbon::now()
						    ]);


			for ($i=0; $i < count($request->nofaktur); $i++) { 

				$cari_id_bkkd = DB::table('bukti_kas_keluar_detail')
						 ->max('bkkd_id');

				if ($cari_id_bkkd == null) {
					$cari_id_bkkd = 1;
				}else{
					$cari_id_bkkd += 1;
				}

				$cari_fp = DB::table('v_hutang')
							 ->where('v_nomorbukti',$request->nofaktur[$i])
							 ->first();

				$biaya = filter_var($request->pelunasan[$i], FILTER_SANITIZE_NUMBER_INT);
				$biaya = $biaya/100;
				$fp = DB::table('faktur_pembelian')
						->where('fp_nofaktur',$request->nofaktur[$i])
						->first();

				$save_bkk_dt = DB::table('bukti_kas_keluar_detail')
						   ->insert([
						   		'bkkd_id'		  => $cari_id_bkkd,
						   		'bkkd_bkk_id'	  => $cari_id_bkk,
						   		'bkkd_bkk_dt'	  => $i+1,
						   		'bkkd_ref'		  => $request->nofaktur[$i],
						   		'bkkd_akun'		  => 210111000,
						   		'bkkd_keterangan' => $request->keterangan_bkkd[$i],
						   		'bkkd_total'  	  => $biaya,
						   		'bkkd_debit'      => 'debit',
						   		'created_at'	  => Carbon::now(),
					        	'updated_at' 	  => Carbon::now()
						    ]);

				$pelunasan = $cari_fp->v_pelunasan - $biaya;

				if ($pelunasan < 0) {
					$pelunasan = 0;
				}

				 $update_faktur = DB::table('v_hutang')
							 ->where('v_nomorbukti',$request->nofaktur[$i])
							 ->update([
								   	'v_pelunasan' => $pelunasan,
								   	'v_status' => 'Approved'
								   ]);
				

			}

			return response()->json(['id' => $cari_id_bkk]);

		}elseif ($request->kode_bayar == 4) {
			 // "no_trans" => "BKK022018/001/001"
		  //     "tanggal" => "05/02/2018"
		  //     "kode_bayar" => "4"
		  //     "nama_supplier" => "- kode -"
		  //     "kode_supplier" => "cash"
		  //     "nama_orang" => ""
		  //     "keterangan" => ""
		  //     "hutang" => ""
		  //     "nama_akun" => "100111001"
		  //     "kas" => ""
		  //     "no_um" => array:1 [▶]
		  //     "supp_um_table" => array:1 [▶]
		  //     "ket_um" => array:1 [▶]
		  //     "total_um" => array:1 [▶]
		  //     "nominal_um" => array:1 [▶]
		  //     "total_pembayaran" => "Rp 333.333,00"


		      $cari_id_bkk = DB::table('bukti_kas_keluar')
						 ->max('bkk_id');


			if ($cari_id_bkk == null) {
					$cari_id_bkk = 1;
				}else{
					$cari_id_bkk += 1;
				}

			$total = filter_var($request->total_pembayaran, FILTER_SANITIZE_NUMBER_INT);
			$total = $total/100;
			$cari_bkk = DB::table('bukti_kas_keluar')
						  ->where('bkk_nota',$request->no_trans)
						  ->get();


			// return 'asd';
			if ($cari_bkk == null) {

				$save_bkk = DB::table('bukti_kas_keluar')
						  ->insert([
						   		'bkk_id'	 	 => $cari_id_bkk,
						   		'bkk_nota'	 	 => $request->no_trans,
						   		'bkk_tgl'		 => Carbon::now(),
						   		'bkk_jenisbayar' => $request->kode_bayar,
						   		'bkk_keterangan' => $request->keterangan,
						   		'bkk_akun_kas'	 => $request->nama_akun,
						   		'bkk_status'	 => 'Released',
						   		'bkk_comp'		 => '001',
						   		'bkk_akun_hutang'=> 210111000,
						   		'bkk_total'		 => $total,
						   		'created_at'	 => Carbon::now(),
					        	'updated_at' 	 => Carbon::now()
						   ]);

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
						   		'pc_tgl'		  => Carbon::now(),
						   		'pc_ref'	 	  => $request->kode_bayar,
						   		'pc_akun' 		  => 210111000,
						   		'pc_akun_kas' 	  => $request->nama_akun,
						   		'pc_keterangan'	  => $request->keterangan,
						   		'pc_debet'  	  => $total,
						   		'pc_no_trans'  	  => $request->no_trans,
						   		'pc_kredit'  	  => $total,
						   		'pc_edit'  	  	  => 'UNALLOWED',
						   		'pc_reim'  	  	  => 'UNRELEASED',
						   		'pc_comp'  	  	  => '001',
						   		'created_at'	  => Carbon::now(),
					        	'updated_at' 	  => Carbon::now()
						    ]);

				for ($i=0; $i < count($request->no_um); $i++) { 

					$cari_id_bkkd = DB::table('bukti_kas_keluar_detail')
							 ->max('bkkd_id');

					if ($cari_id_bkkd == null) {
						$cari_id_bkkd = 1;
					}else{
						$cari_id_bkkd += 1;
					}

					$cari_fp = DB::table('d_uangmuka')
								 ->where('um_nomorbukti',$request->no_um[$i])
								 ->first();

					$biaya = filter_var($request->nominal_um[$i], FILTER_SANITIZE_NUMBER_INT);
					$biaya = $biaya/100;
					$fp = DB::table('d_uangmuka')
							->where('um_nomorbukti',$request->no_um[$i])
							->first();

					$save_bkk_dt = DB::table('bukti_kas_keluar_detail')
							   ->insert([
							   		'bkkd_id'		  => $cari_id_bkkd,
							   		'bkkd_bkk_id'	  => $cari_id_bkk,
							   		'bkkd_bkk_dt'	  => $i+1,
							   		'bkkd_ref'		  => $request->no_um[$i],
							   		'bkkd_akun'		  => 210111000,
							   		'bkkd_keterangan' => $request->ket_um[$i],
							   		'bkkd_total'  	  => $biaya,
						   			'bkkd_supplier'	  => $request->supp_um_table[$i],
							   		'bkkd_debit'      => 'debit',
							   		'created_at'	  => Carbon::now(),
						        	'updated_at' 	  => Carbon::now()
							    ]);

					$pelunasan = $cari_fp->um_sisapelunasan - $biaya;

					if ($pelunasan < 0) {
						$pelunasan = 0;
					}

					 $update_faktur = DB::table('d_uangmuka')
								 ->where('um_nomorbukti',$request->no_um[$i])
								 ->update([
									   	'um_sisapelunasan' => $pelunasan,
									   	'um_status' => 'Approved'
									   ]);
					

				}

				return response()->json(['id' => $cari_id_bkk]);

			}else{
				return 'data sudah ada';
			}
			
		}

	}

	public function cari_detail_edit(request $request){
		// dd($request);
		if ($request->jb != 3) {
			// /dd($request);

		$dt = DB::table('faktur_pembelian')
				->where('fp_nofaktur',$request->nota)
				->first();

	

		$bkk  = DB::SELECT("SELECT bkk_nota as nota,
									   bkkd_id  as id,
									   bkk_tgl  as tgl,
									   bkkd_total as total,
									   bkkd_ref as faktur
								from bukti_kas_keluar 
								inner join bukti_kas_keluar_detail 
								on bkkd_bkk_id = bkk_id 
								where bkkd_ref  = '$dt->fp_nofaktur'");

		 $fpg = DB::select("SELECT fpg_nofpg as nota,
									   fpgdt_id  as id,
									   fpg_tgl as tgl,
									   fpgdt_pelunasan as total,
									   fpgdt_idfp as faktur 
								from fpg 
								inner join fpg_dt 
								on fpgdt_idfpg = idfpg
								where fpgdt_idfp  = '$dt->fp_idfaktur'");
		$bkk = array_merge($bkk,$fpg);

		$cari_faktur = DB::table('faktur_pembelian')
						 ->where('fp_nofaktur',$request->nota)
						 ->first();

		$query_bkkd = DB::table('bukti_kas_keluar_detail')
						->select('bkkd_total as bkkd_total')
						->where('bkkd_id','!=',$request->bkkd_id)
						->where('bkkd_ref','=',$request->nota)
						->get();

		$query_fpgdt = DB::table('fpg_dt')
						->select('fpgdt_pelunasan as bkkd_total')
						->where('fpgdt_idfp','=',$dt->fp_idfaktur)
						->get();
		 $query_pembayaran = array_merge($query_bkkd,$query_fpgdt);

		$pembayaran = 0;
		if ($query_pembayaran != null) {
			for ($i=0; $i < count($query_pembayaran); $i++) { 
			 $pembayaran += $query_pembayaran[$i]->bkkd_total;
			}
		}
		
		$pembayaran;
		$sisa_terbayar = $cari_faktur->fp_netto-$pembayaran;
		$total_biaya_faktur = $cari_faktur->fp_netto;
		$sisa_terbayar;
		$bkkd_id = $request->bkkd_id;
		$nota    = $request->nota;
		$par   	 = $request->par;

		return view('purchase.buktikaskeluar.tablePembayaranEdit',compact('bkk','pembayaran','sisa_terbayar','total_biaya_faktur','bkkd_id','nota','par'));
		}else{

			$dt = DB::table('faktur_pembelian')
				->where('fp_nofaktur',$request->nota)
				->first();

			$bkk  = DB::SELECT("SELECT bkk_nota as nota,
									   bkkd_id  as id,
									   bkk_tgl  as tgl,
									   bkkd_total as total,
									   bkkd_ref as faktur
								from bukti_kas_keluar 
								inner join bukti_kas_keluar_detail 
								on bkkd_bkk_id = bkk_id 
								where bkkd_ref  = '$dt->fp_nofaktur'");

		 	$fpg = DB::select("SELECT fpg_nofpg as nota,
									   fpgdt_id  as id,
									   fpg_tgl as tgl,
									   fpgdt_pelunasan as total,
									   fpgdt_idfp as faktur 
								from fpg 
								inner join fpg_dt 
								on fpgdt_idfpg = idfpg
								where fpgdt_idfp  = '$dt->fp_idfaktur'");

			$cari_faktur = DB::table('v_hutang')
							 ->where('v_nomorbukti',$request->nota)
							 ->first();

			$query_bkkd = DB::table('bukti_kas_keluar_detail')
						->select('bkkd_total as bkkd_total')
						->where('bkkd_id','!=',$request->bkkd_id)
						->where('bkkd_ref','=',$request->nota)
						->get();

			$query_fpgdt = DB::table('fpg_dt')
						->select('fpgdt_pelunasan as bkkd_total')
						->where('fpgdt_idfp','=',$dt->fp_idfaktur)
						->get();

			$query_pembayaran = array_merge($query_bkkd,$query_fpgdt);
			$pembayaran = 0;
			if ($query_pembayaran != null) {
				for ($i=0; $i < count($pembayaran); $i++) { 
				$pembayaran += $query_pembayaran[$i]->bkkd_total;
				}
			}
			

			$sisa_terbayar = $cari_faktur->v_hasil-$pembayaran;
			$total_biaya_faktur = $cari_faktur->v_hasil;
			$sisa_terbayar;
			$bkkd_id = $request->bkkd_id;
			$nota    = $request->nota;
			$par   	 = $request->par;

			return view('purchase.buktikaskeluar.tablePembayaranEdit',compact('bkk','pembayaran','sisa_terbayar','total_biaya_faktur','bkkd_id','nota','par'));
			}
		
	}
	public function hapus_data_faktur(request $request){
		// dd($request);
		$cari_bkkd = DB::table('bukti_kas_keluar_detail')
						 ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
						 ->where('bkkd_id',$request->id)
						 ->first();

		if ($cari_bkkd->bkk_jenisbayar == 2 || $cari_bkkd->bkk_jenisbayar == 6 || $cari_bkkd->bkk_jenisbayar == 7 || $cari_bkkd->bkk_jenisbayar == 9) {
			$cari_faktur = DB::table('faktur_pembelian')
						 ->where('fp_nofaktur',$cari_bkkd->bkkd_ref)
						 ->first();
			$cari_fp_in_bkk =DB::table('bukti_kas_keluar_detail')
							   ->where('bkkd_ref',$cari_faktur->fp_nofaktur)
							   ->get();

			$cari_fp_in_fpg =DB::table('fpg_dt')
							   ->where('fpgdt_idfp',$cari_faktur->fp_idfaktur)
							   ->get();
			if ($cari_fp_in_bkk != null && $cari_fp_in_fpg != null) {
				$status = 'Approved';
			}else{
				$status = 'Released';
			}

			$update_faktur = DB::table('faktur_pembelian')
							   ->where('fp_nofaktur',$cari_faktur->fp_nofaktur)
							   ->update([
							   		'fp_sisapelunasan' => $cari_faktur->fp_sisapelunasan + $cari_bkkd->bkkd_total,
							   		'fp_status'		   => $status,
						    		'updated_at'	   => Carbon::now()
							   ]);

			$update_bkk = DB::table('bukti_kas_keluar')
							->where('bkk_id',$cari_bkkd->bkk_id)
							->update([
								'bkk_total' => $cari_bkkd->bkk_total - $cari_bkkd->bkkd_total
							]);

			$new_bkk = DB::table('bukti_kas_keluar')
						->where('bkk_id',$cari_bkkd->bkk_id)
						->first();

			$update_patty = DB::table('patty_cash')
							  ->where('pc_no_trans',$new_bkk->bkk_nota)
							  ->update([
							  	'pc_debet'  => $new_bkk->bkk_total,
							  	'pc_kredit' => $new_bkk->bkk_total
							  ]);

			$hapus_bkkd = DB::table('bukti_kas_keluar_detail')
							 ->where('bkkd_id',$request->id)
							 ->delete();

			return 'success';
		}else if($cari_bkkd->bkk_jenisbayar == 3){
			$cari_faktur = DB::table('v_hutang')
						 ->where('v_nomorbukti',$cari_bkkd->bkkd_ref)
						 ->first();
			$cari_fp_in_bkk =DB::table('bukti_kas_keluar_detail')
							   ->where('bkkd_ref',$cari_faktur->v_nomorbukti)
							   ->get();

			$cari_fp_in_fpg =DB::table('fpg_dt')
							   ->where('fpgdt_idfp',$cari_faktur->v_id)
							   ->get();
			if ($cari_fp_in_bkk != null && $cari_fp_in_fpg != null) {
				$status = 'Approved';
			}else{
				$status = 'Released';
			}

			$update_faktur = DB::table('v_hutang')
							   ->where('v_nomorbukti',$cari_faktur->v_nomorbukti)
							   ->update([
							   		'v_pelunasan' => $cari_faktur->v_pelunasan + $cari_bkkd->bkkd_total,
							   		'v_status'		   => $status,
						    		'updated_at'	   => Carbon::now()
							   ]);

			$update_bkk = DB::table('bukti_kas_keluar')
							->where('bkk_id',$cari_bkkd->bkk_id)
							->update([
								'bkk_total' => $cari_bkkd->bkk_total - $cari_bkkd->bkkd_total
							]);

			$new_bkk = DB::table('bukti_kas_keluar')
						->where('bkk_id',$cari_bkkd->bkk_id)
						->first();

			$update_patty = DB::table('patty_cash')
							  ->where('pc_no_trans',$new_bkk->bkk_nota)
							  ->update([
							  	'pc_debet'  => $new_bkk->bkk_total,
							  	'pc_kredit' => $new_bkk->bkk_total
							  ]);

			$hapus_bkkd = DB::table('bukti_kas_keluar_detail')
							 ->where('bkkd_id',$request->id)
							 ->delete();

			return 'success';
		}elseif ($cari_bkkd->bkk_jenisbayar == 4) {

			$cari_faktur = DB::table('d_uangmuka')
						 ->where('um_nomorbukti',$cari_bkkd->bkkd_ref)
						 ->first();
			$cari_fp_in_bkk =DB::table('bukti_kas_keluar_detail')
							   ->where('bkkd_ref',$cari_faktur->um_nomorbukti)
							   ->get();

			$cari_fp_in_fpg =DB::table('fpg_dt')
							   ->where('fpgdt_idfp',$cari_faktur->um_id)
							   ->get();
			if ($cari_fp_in_bkk != null && $cari_fp_in_fpg != null) {
				$status = 'Approved';
			}else{
				$status = 'Released';
			}

			$update_faktur = DB::table('d_uangmuka')
							   ->where('um_nomorbukti',$cari_faktur->um_nomorbukti)
							   ->update([
							   		'um_sisapelunasan' => $cari_faktur->um_sisapelunasan + $cari_bkkd->bkkd_total,
							   		'um_status'		   => $status,
						    		'updated_at'	   => Carbon::now()
							   ]);

			$update_bkk = DB::table('bukti_kas_keluar')
							->where('bkk_id',$cari_bkkd->bkk_id)
							->update([
								'bkk_total' => $cari_bkkd->bkk_total - $cari_bkkd->bkkd_total
							]);

			$new_bkk = DB::table('bukti_kas_keluar')
						->where('bkk_id',$cari_bkkd->bkk_id)
						->first();

			$update_patty = DB::table('patty_cash')
							  ->where('pc_no_trans',$new_bkk->bkk_nota)
							  ->update([
							  	'pc_debet'  => $new_bkk->bkk_total,
							  	'pc_kredit' => $new_bkk->bkk_total
							  ]);

			$hapus_bkkd = DB::table('bukti_kas_keluar_detail')
							 ->where('bkkd_id',$request->id)
							 ->delete();

			return 'success';
		}
		

		
	}
	public function update_faktur(request $request){
		// dd($request);

		// return $request->kode_bayar;
		$total = filter_var($request->total_pembayaran, FILTER_SANITIZE_NUMBER_INT);
		$total = $total/100;

		$update_bkk = DB::table('bukti_kas_keluar')
					  ->where('bkk_nota',$request->no_trans)
					  ->update([
					  	'bkk_total' => $total
					  ]);
		$update_patty = DB::table('patty_cash')
						->where('pc_no_trans',$request->no_trans)
						->update([
						 'pc_debet'			=> $total,
						 'pc_kredit'		=> $total,
						 'pc_keterangan'	=> $request->keterangan
						]);

		if ($request->kode_bayar  == 2 || $request->kode_bayar  == 6 || $request->kode_bayar  == 7 || $request->kode_bayar  == 9) {
			// return 'asd';
			for ($i=0; $i < count($request->bkkd_id); $i++) { 

			$pelunasan = filter_var($request->pelunasan[$i], FILTER_SANITIZE_NUMBER_INT);
			$pelunasan;
			$pelunasan = $pelunasan/100;


			if ($request->bkkd_id[$i] != 0 ) {

				$cari_fp     = DB::table('bukti_kas_keluar_detail')
								 ->where('bkkd_id',$request->bkkd_id[$i])
								 ->first();

				$cari_faktur = DB::table('faktur_pembelian')
								 ->where('fp_nofaktur',$request->nofaktur[$i])
								 ->first();

				$jumlah_fp   = $cari_faktur->fp_sisapelunasan + $cari_fp->bkkd_total;

				$update_fp   = DB::table('faktur_pembelian')
								 ->where('fp_nofaktur',$request->nofaktur[$i])
								 ->update([
								 	'fp_sisapelunasan' => $jumlah_fp
								 ]);

				/////////////////////
				$update_bkkd = DB::table('bukti_kas_keluar_detail')
								 ->where('bkkd_id',$request->bkkd_id[$i])
								 ->update([
								 	'bkkd_total' 		=> $pelunasan,
								 	'bkkd_keterangan'	=> $request->keterangan_bkkd[$i]
								 ]);

				$new_cari_faktur = DB::table('faktur_pembelian')
								 ->where('fp_nofaktur',$request->nofaktur[$i])
								 ->first();

				$new_fp      = $new_cari_faktur->fp_sisapelunasan - $pelunasan;

				$update_fp   = DB::table('faktur_pembelian')
								 ->where('fp_nofaktur',$request->nofaktur[$i])
								 ->update([
								 	'fp_sisapelunasan' => $new_fp
								 ]);

			} else{

				$cari_bkk = DB::table('bukti_kas_keluar')
							 ->where('bkk_nota',$request->no_trans)
							 ->get('bkkd_id');


				$cari_id  = DB::table('bukti_kas_keluar_detail')
							 ->max('bkkd_id');
							 
				if ($cari_id != null) {
					$cari_id += 1;
				}else{
					$cari_id = 1;
				}

				$cari_dt  = DB::table('bukti_kas_keluar_detail')
							 ->where('bkkd_bkk_id',$cari_bkk->bkk_id)
							 ->max('bkkd_bkk_dt');

				if ($cari_dt != null) {
					$cari_dt += 1;
				}else{
					$cari_dt = 1;
				}
				$new_cari_faktur = DB::table('faktur_pembelian')
								 ->where('fp_nofaktur',$request->nofaktur[$i])
								 ->first();

				$new_fp      = $new_cari_faktur->fp_sisapelunasan - $pelunasan;


				$update_fp   = DB::table('faktur_pembelian')
								 ->where('fp_nofaktur',$request->nofaktur[$i])
								 ->update([
								 	'fp_sisapelunasan' => $new_fp
								 ]);

				$save_bkk_dt = DB::table('bukti_kas_keluar_detail')
						   ->insert([
						   		'bkkd_id'		  => $cari_id,
						   		'bkkd_bkk_id'	  => $cari_bkk->bkk_id,
						   		'bkkd_bkk_dt'	  => $cari_dt,
						   		'bkkd_ref'		  => $request->nofaktur[$i],
						   		'bkkd_akun'		  => 210111000,
						   		'bkkd_keterangan' => $request->keterangan_bkkd[$i],
						   		'bkkd_total'  	  => $pelunasan,
						   		'bkkd_debit'      => 'debit',
						   		'created_at'	  => Carbon::now(),
					        	'updated_at' 	  => Carbon::now()
						    ]);


				}
			}
		}else if($request->kode_bayar == 3){

			for ($i=0; $i < count($request->bkkd_id); $i++) { 

			$pelunasan = filter_var($request->pelunasan[$i], FILTER_SANITIZE_NUMBER_INT);
			$pelunasan;
			$pelunasan = $pelunasan/100;


			if ($request->bkkd_id[$i] != 0 ) {

				$cari_fp     = DB::table('bukti_kas_keluar_detail')
								 ->where('bkkd_id',$request->bkkd_id[$i])
								 ->first();

				$cari_faktur = DB::table('v_hutang')
								 ->where('v_nomorbukti',$request->nofaktur[$i])
								 ->first();

				$jumlah_fp   = $cari_faktur->v_pelunasan + $cari_fp->bkkd_total;

				$update_fp   = DB::table('v_hutang')
								 ->where('v_nomorbukti',$request->nofaktur[$i])
								 ->update([
								 	'v_pelunasan' => $jumlah_fp
								 ]);

				/////////////////////
				$update_bkkd = DB::table('bukti_kas_keluar_detail')
								 ->where('bkkd_id',$request->bkkd_id[$i])
								 ->update([
								 	'bkkd_total' 		=> $pelunasan,
								 	'bkkd_keterangan'	=> $request->keterangan_bkkd[$i]
								 ]);

				$new_cari_faktur = DB::table('v_hutang')
								 ->where('v_nomorbukti',$request->nofaktur[$i])
								 ->first();

				$new_fp      = $new_cari_faktur->v_pelunasan - $pelunasan;

				$update_fp   = DB::table('v_hutang')
								 ->where('v_nomorbukti',$request->nofaktur[$i])
								 ->update([
								 	'v_pelunasan' => $new_fp
								 ]);

			} else{

				$cari_bkk = DB::table('bukti_kas_keluar')
							 ->where('bkk_nota',$request->no_trans)
							 ->first();


				$cari_id  = DB::table('bukti_kas_keluar_detail')
							 ->max('bkkd_id');
							 
				if ($cari_id != null) {
					$cari_id += 1;
				}else{
					$cari_id = 1;
				}

				$cari_dt  = DB::table('bukti_kas_keluar_detail')
							 ->where('bkkd_bkk_id',$cari_bkk->bkk_id)
							 ->max('bkkd_bkk_dt');

				if ($cari_dt != null) {
					$cari_dt += 1;
				}else{
					$cari_dt = 1;
				}
				$new_cari_faktur = DB::table('v_hutang')
								 ->where('v_nomorbukti',$request->nofaktur[$i])
								 ->first();

				$new_fp      = $new_cari_faktur->v_pelunasan - $pelunasan;


				$update_fp   = DB::table('v_hutang')
								 ->where('v_nomorbukti',$request->nofaktur[$i])
								 ->update([
								 	'v_pelunasan' => $new_fp
								 ]);

				$save_bkk_dt = DB::table('bukti_kas_keluar_detail')
						   ->insert([
						   		'bkkd_id'		  => $cari_id,
						   		'bkkd_bkk_id'	  => $cari_bkk->bkk_id,
						   		'bkkd_bkk_dt'	  => $cari_dt,
						   		'bkkd_ref'		  => $request->nofaktur[$i],
						   		'bkkd_akun'		  => 210111000,
						   		'bkkd_keterangan' => $request->keterangan_bkkd[$i],
						   		'bkkd_total'  	  => $pelunasan,
						   		'bkkd_debit'      => 'debit',
						   		'created_at'	  => Carbon::now(),
					        	'updated_at' 	  => Carbon::now()
						    ]);


			}
		}

		return 'success';

		}elseif ($request->kode_bayar == 4) {
			// dd($request);
			// return 'asd';
			for ($i=0; $i < count($request->bkkd_id); $i++) { 

			$pelunasan = filter_var($request->nominal_um[$i], FILTER_SANITIZE_NUMBER_INT);
			$pelunasan;
			$pelunasan = $pelunasan/100;


			if ($request->bkkd_id[$i] != 0 ) {

				$cari_fp     = DB::table('bukti_kas_keluar_detail')
								 ->where('bkkd_id',$request->bkkd_id[$i])
								 ->first();

				$cari_faktur = DB::table('d_uangmuka')
								 ->where('um_nomorbukti',$request->no_um[$i])
								 ->first();

				$jumlah_fp   = $cari_faktur->um_sisapelunasan + $cari_fp->bkkd_total;

				$update_fp   = DB::table('d_uangmuka')
								 ->where('um_nomorbukti',$request->no_um[$i])
								 ->update([
								 	'um_sisapelunasan' => $jumlah_fp
								 ]);

				/////////////////////
				$update_bkkd = DB::table('bukti_kas_keluar_detail')
								 ->where('bkkd_id',$request->bkkd_id[$i])
								 ->update([
								 	'bkkd_total' 		=> $pelunasan,
								 	'bkkd_keterangan'	=> $request->keterangan_bkkd[$i]
								 ]);

				$new_cari_faktur = DB::table('d_uangmuka')
								 ->where('um_nomorbukti',$request->no_um[$i])
								 ->first();

				$new_fp      = $new_cari_faktur->um_sisapelunasan - $pelunasan;

				$update_fp   = DB::table('d_uangmuka')
								 ->where('um_nomorbukti',$request->um_nomorbukti[$i])
								 ->update([
								 	'um_sisapelunasan' => $new_fp
								 ]);

			} else{

				$cari_bkk = DB::table('bukti_kas_keluar')
							 ->where('bkk_nota',$request->no_trans)
							 ->first();


				$cari_id  = DB::table('bukti_kas_keluar_detail')
							 ->max('bkkd_id');
							 
				if ($cari_id != null) {
					$cari_id += 1;
				}else{
					$cari_id = 1;
				}

				$cari_dt  = DB::table('bukti_kas_keluar_detail')
							 ->where('bkkd_bkk_id',$cari_bkk->bkk_id)
							 ->max('bkkd_bkk_dt');

				if ($cari_dt != null) {
					$cari_dt += 1;
				}else{
					$cari_dt = 1;
				}
				$new_cari_faktur = DB::table('d_uangmuka')
								 ->where('um_nomorbukti',$request->no_um[$i])
								 ->first();

				$new_fp      = $new_cari_faktur->um_sisapelunasan - $pelunasan;


				$update_fp   = DB::table('d_uangmuka')
								 ->where('um_nomorbukti',$request->no_um[$i])
								 ->update([
								 	'um_sisapelunasan' => $new_fp
								 ]);

				$save_bkk_dt = DB::table('bukti_kas_keluar_detail')
						   ->insert([
						   		'bkkd_id'		  => $cari_id,
						   		'bkkd_bkk_id'	  => $cari_bkk->bkk_id,
						   		'bkkd_bkk_dt'	  => $cari_dt,
						   		'bkkd_ref'		  => $request->no_um[$i],
						   		'bkkd_akun'		  => 210111000,
						   		'bkkd_keterangan' => $request->ket_um[$i],
						   		'bkkd_total'  	  => $pelunasan,
						   		'bkkd_supplier'   => $request->supp_um_table[$i],
						   		'bkkd_debit'      => 'debit',
						   		'created_at'	  => Carbon::now(),
					        	'updated_at' 	  => Carbon::now()
						    ]);


			}
		}
		}
	}

	public function cari_nama(request $request){

		$supp = DB::select("SELECT nama_supplier as nama, no_supplier as kode 
								from supplier
								where status = 'SETUJU'
								and active = 'AKTIF'
								order by no_supplier");

		$agen = DB::table('agen')
						->get();

		$data = DB::table('subcon')
						->get();

		$ven = DB::table('vendor')
						->get();
		$data = array_merge($supp,$agen,$data,$ven);

		for ($i=0; $i < count($data); $i++) { 
			if ($data[$i]->kode == $request->nama) {
				$nama = $data[$i]->nama;
			}
		}

		return response()->json(['nama' => $nama]);
	}

}