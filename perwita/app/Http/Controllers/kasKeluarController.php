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

	    $cari_nota = DB::select("SELECT  substring(max(bkk_nota),12) as id from bukti_kas_keluar
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

	public function histori_faktur(request $req)
	{
		
		return view('purchase.buktikaskeluar.histori_faktur');
	}

	public function return_faktur(request $req)
	{
		
		return view('purchase.buktikaskeluar.return_faktur');
	}

	public function debet_faktur(request $req)
	{
		
		return view('purchase.buktikaskeluar.debet_faktur');
	}

	public function kredit_faktur(request $req)
	{
		
		return view('purchase.buktikaskeluar.kredit_faktur');
	}

	public function save_patty(request $req)
	{
		return DB::transaction(function() use ($req) {  

			dd($req->all());
			$cari_nota = DB::table('bukti_kas_keluar')
						   ->where('bkk_nota',$req->nota)
						   ->first();



			if ($cari_nota == null) {
				$nota = $req->nota;
			}else{
				$bulan = Carbon::now()->format('m');
			    $tahun = Carbon::now()->format('y');

			    $cari_nota = DB::select("SELECT  substring(max(bkk_nota),12) as id from bukti_kas_keluar
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

			DB::table('bukti_kas_keluar')
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
					'bkk_akun_hutang' 	=> 0,
					'bkk_status' 		=> 'RELEASED',
					'updated_by' 		=> Auth::user()->m_name,
	  				'created_by' 		=> Auth::user()->m_name,
			  	]);

			for ($i=0; $i < count($req->pt_seq); $i++) {
				$id_dt = DB::table('biaya_penerus_kas_detail')
						   ->max('bkkd_id');
				if ($id_dt == null) {
					$id_dt = 1;
				}else{
					$id_dt += 1;
				}

				// 'bkkd_id'  			=> $id_dt,
				// 'bkkd_bkk_id'  		=> $id,
				// 'bkkd_bkk_dt'  		=> $i+1,
				// 'bkkd_keterangan' 	=> ,
				// 'bkkd_akun'  		=> ,
				// 'bkkd_total' 		=> ,
				// 'bkkd_debit' 		=> ,
				// 'updated_at'		=> ,
				// 'created_at' 		=> ,
				// 'bkkd_ref' 			=> ,
				// 'bkkd_supplier' 	=> ,
			}


			

		});
	}

}