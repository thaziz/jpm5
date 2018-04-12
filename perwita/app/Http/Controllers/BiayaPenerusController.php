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
use App\co_purchasetb;
use App\masterGudangPurchase;
use App\purchase_orderr;
use App\purchase_orderdt;
use App\stock_mutation;
use App\stock_gudang;
use App\penerimaan_barang;
use App\penerimaan_barangdt;
use App\fakturpembelian;
use App\fakturpembeliandt;
use App\biaya_penerus;
use App\biaya_penerus_dt;
use App\master_note;
use App\tb_master_pajak;
use App\tb_coa;
use App\tb_jurnal;
use DB;
use Response;
Use Carbon\Carbon;
use Session;
use Mail;
use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;
use Auth;

class BiayaPenerusController extends Controller
{
	public function getdatapenerus(){		
			$data = DB::table('akun')
					  ->get();
			$date = Carbon::now()->format('d/m/Y');

			$agen = DB::table('agen')
					  ->where('kategori','AGEN')
					  ->orWhere('kategori','AGEN DAN OUTLET')
					  ->get();
			$vendor = DB::table('vendor')
					  ->get();
			if (Auth::user()->punyaAKses('Biaya Penerus Hutang','all')) {
				$akun   = DB::table('d_akun')
						->get();
			}else{
				$akun   = DB::table('d_akun')
						->where('kode_cabang',Auth::user()->kode_cabang)
						->get();
			}
			
			$jt = Carbon::now()->subDays(-30)->format('d/m/Y');
			return view('purchase/fatkur_pembelian/form_biaya_penerus',compact('data','date','agen','vendor','now','jt','akun'));
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
		public function cari_do(request $request){

		
	        $results = array();
	        $queries = DB::table('delivery_order')
	        	->leftjoin('biaya_penerus_dt','nomor','=','bpd_pod')
	            ->where('nomor', 'like', '%'.strtoupper($request->term).'%')
	            ->where('bpd_pod',null)
	            ->take(10)->get();

	        if ($queries == null){
	            $results[] = [ 'id' => null, 'label' => 'Tidak ditemukan data terkait'];
	        } else {

	            foreach ($queries as $query)
	            {
	                $results[] = [ 'id' => $query->nomor, 'label' => $query->nomor,'validator'=>$query->bpd_pod];
	            }
	        }

	        return Response::json($results);


		}

	public function caripodsubcon(request $request){

		
	        $results = array();
	       $queries = DB::table('delivery_order')
	        	->leftjoin('pembayaran_subcon_dt','nomor','=','pbd_resi')
	            ->where('nomor', 'like', '%'.$request->term.'%')
	            ->take(10)->get();

	        if ($queries == null){
	            $results[] = [ 'id' => null, 'label' => 'Tidak ditemukan data terkait'];
	        } else {

	            foreach ($queries as $query)
	            {
	                $results[] = [ 'id' => $query->nomor, 
	                'label' => $query->nomor,
	                'validator'=>$query->pbd_resi,
	                'harga'=>$query->tarif_dasar,
	            	'comp' => $query->kode_cabang];
	            }
	        }
	        // return $results;
	        return Response::json($results);


		}

		public function carimaster(request $request){

			if ($request->vendor == 'AGEN') {


				$persen = DB::table('master_persentase')
	        			->where('kode_akun','LIKE','%'.'5319'.'%')
	        			->where('cabang',$request->cabang)
	        			->get();

	        	if ($persen == null) {

	        		$persen = DB::table('master_persentase')
	        			->where('kode_akun',5319)
	        			->where('cabang','GLOBAL')
	        			->get();
	        	}

			}else{


				$persen = DB::table('master_persentase')
	        			->where('kode_akun','LIKE','%'.'5315'.'%')
	        			->where('cabang',$request->cabang)
	        			->get();

	        	if ($persen == null) {
	        		$persen = DB::table('master_persentase')
	        			->where('kode_akun',5315)
	        			->where('cabang','GLOBAL')
	        			->get();
	        	}
			}
	        

	        return Response::json([
	        				'persen'=>$persen
	        				]);


		}

		public function autocomplete_biaya_penerus($i){

	        $data = DB::table('delivery_order')
	        			->where('nomor','=',strtoupper($i))
	        			->first();

	       if($data != null){
	       	
	       	return Response::json([
	       					'status'=>'1',
	        				'data'=>$data
	        				]);
	       }else{
	       	return Response::json([
	       					'status'=>'0',
	        				'data'=>'data tidak ada'
	        				]);
	       }
		}

		public function save_agen(request $request){
			
		}
		public function edit($id){

		 	
		}

		public function getdatapenerusedit(){

			$data = DB::table('akun')
					  ->get();
			$date = Carbon::now()->format('d/m/Y');

			$agen = DB::table('agen')
					  ->where()
					  ->get();
			$vendor = DB::table('vendor')
					  ->where()
					  ->get();
			$akun_biaya = DB::table('akun_biaya')
					  ->get();
		
			return view('purchase/fatkur_pembelian/editTableBiaya',compact('data','date','agen','vendor','akun_biaya','now'));
		}

		public function getpembayaranoutlet(){



			$date = Carbon::now()->format('d/m/Y');

			$agen = DB::table('agen')
					  ->where('kategori','OUTLET')
					  ->orWhere('kategori','AGEN DAN OUTLET')
					  ->get();

			$akun_biaya = DB::table('akun_biaya')
					  ->get();
			$first = Carbon::now();
	        $second = Carbon::now()->format('d/m/Y');
	        // $start = $first->subMonths(1)->startOfMonth();
	        $start = $first->subDays(30)->startOfDay()->format('d/m/Y');
	        $jt = Carbon::now()->subDays(-30)->format('d/m/Y');



			return view('purchase/fatkur_pembelian/PembayaranOutlet',compact('date','agen','akun_biaya','second','start','jt'));
		}
		public function cari_outlet(request $request,$agen){
			// dd($request);
			$id = DB::table('master_note')
					->max('mn_id');
			if($id == ''){
				$id = 1;
			}else{
				$id+=1;
			}
			
			$cari_note = DB::table('master_note')
							->where('mn_keterangan',$request->note)
							->get();


			if ($cari_note == null) {
				// return 'asd';
				if($request->note != ''){
					master_note::create([
							'mn_id'			=> $id,
							'mn_keterangan' => $request->note,
							'created_at'	=> Carbon::now()
					]);
				}
			}
		

		 $tgl = explode('-',$request->rangepicker);
		 $tgl = str_replace(' ', '', $tgl);
		for ($i=0; $i < count($tgl); $i++) { 
			$tgl[$i] = str_replace('/', '-', $tgl[$i]);
			$tgl[$i] = Carbon::parse($tgl[$i])->format('Y-m-d');
		}
		if(isset($tgl[1])){

			$list = DB::select("SELECT nomor,potd_pod,tanggal,nama_pengirim,nama_penerima,asal.nama as asal,asal.id as id_asal,
			 							tujuan.nama as tujuan,tujuan.id as id_tujuan,status,agen.nama as nama_agen,tarif_dasar,biaya_komisi,
			 							delivery_order.kode_cabang 
					 					FROM delivery_order
										LEFT JOIN agen on agen.kode = kode_outlet
										LEFT JOIN 
										(SELECT id,nama FROM kota) as asal on id_kota_asal = asal.id
										LEFT JOIN 
										(SELECT id,nama FROM kota) as tujuan on id_kota_tujuan = tujuan.id
										LEFT JOIN
										pembayaran_outlet_dt on potd_pod = nomor
										WHERE delivery_order.tanggal >= '$tgl[0]'
										AND delivery_order.tanggal <= '$tgl[1]'
										AND delivery_order.kode_outlet = '$agen'
										order by tanggal desc");
			

			$persen = DB::table('master_persentase')
			 			 ->where('kode_akun',5317)
			 			 ->get();
			
			$data = array();
	        foreach ($list as $r) {
	            $data[] = (array) $r;
	        }
	 
	        foreach ($data as $i => $key) {
	            
	            $data[$i]['komisi']	= round($data[$i]['tarif_dasar']*($persen[0]->persen/100),2);
	          
	        }
	        return view('purchase/fatkur_pembelian/detailpembayaranoutlet',compact('data'));
    	}
    

        
		}

		public function cari_outlet1(request $request,$agen){
			// dd($request->all());
			$ini = DB::table('master_note')
					->max('mn_id');
			if($ini == ''){
				$ini = 1;
			}else{
				$ini+=1;
			}
			
			$cari_note = DB::table('master_note')
							->where('mn_keterangan',$request->note)
							->get();


			if ($cari_note == null) {
				// return 'asd';
				if($request->note != ''){
					master_note::create([
							'mn_id'			=> $ini,
							'mn_keterangan' => $request->note,
							'created_at'	=> Carbon::now()
					]);
				}
			}
		
		 $id = $request->id;
		 $tgl = explode('-',$request->rangepicker);
		 $tgl = str_replace(' ', '', $tgl);
		for ($i=0; $i < count($tgl); $i++) { 
			$tgl[$i] = str_replace('/', '-', $tgl[$i]);
			$tgl[$i] = Carbon::parse($tgl[$i])->format('Y-m-d');
		}
		if(isset($tgl[1])){

			$list = DB::select("SELECT agen.kode_cabang,nomor,tanggal,nama_pengirim,nama_penerima,asal.nama as asal,asal.id as id_asal,
			 							tujuan.nama as tujuan,tujuan.id as id_tujuan,status,agen.nama as nama_agen,tarif_dasar,biaya_komisi
					 					FROM delivery_order
										LEFT JOIN agen on agen.kode = kode_outlet
										LEFT JOIN 
										(SELECT id,nama FROM kota) as asal on id_kota_asal = asal.id
										LEFT JOIN 
										(SELECT id,nama FROM kota) as tujuan on id_kota_tujuan = tujuan.id
										WHERE delivery_order.tanggal >= '$tgl[0]'
										AND delivery_order.tanggal <= '$tgl[1]'
										AND delivery_order.kode_outlet = '$agen'
										order by tanggal desc");


			$persen = DB::table('master_persentase')
			 			 ->where('kode_akun',5317)
			 			 ->get();
			
			$data = array();
	        foreach ($list as $r) {
	            $data[] = (array) $r;
	        }
	 
	        foreach ($data as $i => $key) {
	            
	            $data[$i]['komisi']	= round($data[$i]['tarif_dasar']*($persen[0]->persen/100),2);
	          
	        }
	        return view('purchase/fatkur_pembelian/detailTableOutlet',compact('data','id'));
    	}
    

        
		}


		public function notaoutlet(request $request){

			$year =Carbon::now()->format('y'); 
			$month =Carbon::now()->format('m'); 
			$mon =Carbon::now(); 

			$idfaktur =   fakturpembelian::where('fp_comp' , $request->cab)
											->where('fp_nofaktur','LIKE','%'.'O-0'.'%')
											->where('created_at','>=',$mon)
											->max('fp_nofaktur');
		//	dd($nosppid);
			if(isset($idfaktur)) {
				$explode  = explode("/", $idfaktur);
				$idfaktur = $explode[2];
				$idfaktur = filter_var($idfaktur, FILTER_SANITIZE_NUMBER_INT);
				$idfaktur = str_replace('-', '', $idfaktur) ;
				$string = (int)$idfaktur + 1;
				$idfaktur = str_pad($string, 3, '0', STR_PAD_LEFT);
			}

			else {
				$idfaktur = '001';
			}

			$nota = 'FP' . $month . $year . '/' . $request->cab . '/O-' .  $idfaktur;
			/*dd($data['nofp']);*/

			return response()->json(['nota' => $nota]);

		}


		public function notapenerusagen(request $request){
			$year =Carbon::now()->format('y'); 
			$month =Carbon::now()->format('m'); 

			 $idfaktur =   fakturpembelian::where('fp_comp' , $request->cab)
											->where('fp_jenisbayar','6')
											->max('fp_nofaktur');
		//	dd($nosppid);
			// return $idfaktur;
			if(isset($idfaktur)) {
				$explode  = explode("/", $idfaktur);
				$idfaktur = $explode[2];
				$idfaktur = filter_var($idfaktur, FILTER_SANITIZE_NUMBER_INT);
				$idfaktur = str_replace('-', '', $idfaktur) ;
				$string = (int)$idfaktur + 1;
				$idfaktur = str_pad($string, 3, '0', STR_PAD_LEFT);
			}

			else {
				$idfaktur = '001';
			}

			$nota = 'FP' . $month . $year . '/' . $request->cab . '/P-' .  $idfaktur;
			/*dd($data['nofp']);*/

			return response()->json(['nota' => $nota]);
			
		}
		public function notasubcon(request $request){
			$year =Carbon::now()->format('y'); 
			$month =Carbon::now()->format('m'); 

			 $idfaktur =   fakturpembelian::where('fp_comp' , $request->cab)
											->where('fp_nofaktur','LIKE','%'.'SC-0'.'%')
											->max('fp_nofaktur');
		//	dd($nosppid);
			if(isset($idfaktur)) {
				$explode  = explode("/", $idfaktur);
				$idfaktur = $explode[2];
				$idfaktur = filter_var($idfaktur, FILTER_SANITIZE_NUMBER_INT);
				$idfaktur = str_replace('-', '', $idfaktur) ;
				$string = (int)$idfaktur + 1;
				$idfaktur = str_pad($string, 3, '0', STR_PAD_LEFT);
			}

			else {
				$idfaktur = '001';
			}

			$nota = 'FP' . $month . $year . '/' . $request->cab . '/SC-' .  $idfaktur;
			/*dd($data['nofp']);*/

			return response()->json(['nota' => $nota]);
		}
		public function update_agen(request $request){
			
		}
		public function simpan_tt(request $request){
		
			 $id = DB::table('form_tt')
					->max('tt_idform');
			 if($id == null){
			 	$id=1;
			 }else{
			 	$id+=1;
			 }

			 $total = filter_var($request->total_terima, FILTER_SANITIZE_NUMBER_INT);
			 $total = $total/100;
			
		      	if($request->Kwitansi == 'on')	{
		      		$kwitansi = 'ADA';
		      	}else{
		      		$kwitansi = 'tidak ada';
		      	}
		      	if($request->Faktur == 'on')	{
		      		$Faktur = 'ada';
		      	}else{
		      		$Faktur = 'tidak ada';
		      	}
		      	if($request->Peranan == 'on')	{
		      		$Peranan = 'ada';
		      	}else{
		      		$Peranan = 'tidak ada';
		      	}
		      	if($request->Jalan == 'on')	{
		      		$Jalan = 'ada';
		      	}else{
		      		$Jalan = 'tidak ada';
		      	}

		      	$valid_notafp =DB::table('form_tt')
		      					 ->where('tt_nofp',$request->nota)
		      					 ->get();

		      	if($valid_notafp == null){
			        $save = DB::table('form_tt')
			        			->insert([
			        				'tt_idform'		 	 => $id,
			        				'tt_tgl'   			 => $request->modal_tanggal,
			        				'tt_idagen' 	 	 => $request->supplier,
			        				'tt_lainlain'		 => $request->modal_lain,
			        				'tt_tglkembali' 	 => $request->tgl_terima,
			        				'tt_totalterima'	 => round($total,2),
			        				'created_at'		 => Carbon::now(),
			        				'updated_at'	 	 => Carbon::now(),
			        				'tt_kwitansi'	 	 => strtoupper($kwitansi),
			        				'tt_suratperan'	 	 => strtoupper($Peranan),
			        				'tt_suratjalanasli'	 => strtoupper($Jalan),
			        				'tt_faktur'			 => strtoupper($Faktur),
			        				'tt_noform'			 => $request->no_tt,
			        				'tt_nofp'			 => $request->nota,
			        				'tt_idcabang'		 =>'001'
			        			]);
			        return response()->json(['status' => '1']);
			    }else{
			    	$save = DB::table('form_tt')
			    				->where('tt_noform',$request->no_tt)
			        			->update([
			        				'tt_idform'		 	 => $id,
			        				'tt_tgl'   			 => $request->modal_tanggal,
			        				'tt_idagen' 	 	 => $request->supplier,
			        				'tt_lainlain'		 => $request->modal_lain,
			        				'tt_tglkembali' 	 => $request->tgl_terima,
			        				'tt_totalterima'	 => round($total,2),
			        				'created_at'		 => Carbon::now(),
			        				'updated_at'	 	 => Carbon::now(),
			        				'tt_kwitansi'	 	 => strtoupper($kwitansi),
			        				'tt_suratperan'	 	 => strtoupper($Peranan),
			        				'tt_suratjalanasli'	 => strtoupper($Jalan),
			        				'tt_faktur'			 => strtoupper($Faktur),
			        				'tt_noform'			 => $request->no_tt,
			        				'tt_nofp'			 => $request->nota,
			        				'tt_idcabang'		 =>''
			        			]);
			    	return response()->json(['status' => '0']);
			    }

		}




		public function simpan_tt_subcon(request $request){
		
	

			 $total = filter_var($request->total_terima, FILTER_SANITIZE_NUMBER_INT);
			 $total = $total/100;
			
		      	if($request->Kwitansi == 'on')	{
		      		$kwitansi = 'ADA';
		      	}else{
		      		$kwitansi = 'tidak ada';
		      	}
		      	if($request->Faktur == 'on')	{
		      		$Faktur = 'ada';
		      	}else{
		      		$Faktur = 'tidak ada';
		      	}
		      	if($request->Peranan == 'on')	{
		      		$Peranan = 'ada';
		      	}else{
		      		$Peranan = 'tidak ada';
		      	}
		      	if($request->Jalan == 'on')	{
		      		$Jalan = 'ada';
		      	}else{
		      		$Jalan = 'tidak ada';
		      	}

		      	$valid_notafp =DB::table('form_tt')
		      					 ->where('tt_nofp',$request->nota)
		      					 ->first();

	
			    	$save = DB::table('form_tt')
			    				->where('tt_noform',$request->no_tt)
			        			->update([
			        				'tt_tgl'   			 => $request->modal_tanggal,
			        				'tt_idagen' 	 	 => $request->supplier,
			        				'tt_lainlain'		 => $request->modal_lain,
			        				'tt_tglkembali' 	 => $request->tgl_terima,
			        				'tt_totalterima'	 => round($total,2),
			        				'updated_at'	 	 => Carbon::now(),
			        				'tt_kwitansi'	 	 => strtoupper($kwitansi),
			        				'tt_suratperan'	 	 => strtoupper($Peranan),
			        				'tt_suratjalanasli'	 => strtoupper($Jalan),
			        				'tt_faktur'			 => strtoupper($Faktur),
			        				'tt_noform'			 => $request->no_tt,
			        				'tt_nofp'			 => $request->nota,
			        				'tt_idcabang'		 =>'001'
			        			]);
			    	return response()->json(['status' => '0']);
			    

		}
		public function cetak_tt(request $request){

			$cari_tipe = DB::table('faktur_pembelian')
						   ->where('fp_idfaktur',$request->id)
						   ->get();
			if ($cari_tipe[0]->fp_jenisbayar == 6) {
			    $nota = $request->nota;
				$data = DB::table('form_tt')
						  ->join('biaya_penerus','bp_faktur','=','tt_nofp')
						  ->join('faktur_pembelian','fp_nofaktur','=','tt_nofp')
						  ->join('agen','bp_kode_vendor','=','kode')
						  ->where('tt_noform',$nota)
						  ->get();
				if(isset($data)){
					$terbilang = $this->terbilang($data[0]->tt_totalterima,$style=3);	
				}
			    $tgl = Carbon::parse($data[0]->tt_tglkembali)->format('D');
			    if($tgl == 'Sun'){
			    	$tgl = 'Minggu';
			    }else if($tgl == 'Mon'){
			    	$tgl = 'Senin';
			    
				}else if($tgl == 'Tue'){
			    	$tgl = 'Selasa';
			    
				}else if($tgl == 'Wed'){
			    	$tgl = 'Rabu';
			    
				}else if($tgl == 'Thu'){
			    	$tgl = 'Kamis';
			    }else if($tgl == 'Fri'){
			    	$tgl = 'Jumat';
				}else if($tgl == 'Sat'){
			    	$tgl = 'Sabtu';
				}
				
				return view('purchase/fatkur_pembelian/cetaktt',compact('nota','data','tgl','terbilang','cari_tipe'));
			}else if($cari_tipe[0]->fp_jenisbayar == 7){

				$nota = $request->nota;
				$data = DB::table('form_tt')
						  ->join('pembayaran_outlet','pot_faktur','=','tt_nofp')
						  ->join('faktur_pembelian','fp_nofaktur','=','tt_nofp')
						  ->join('agen','pot_kode_outlet','=','kode')
						  ->where('tt_noform',$nota)
						  ->get();

				if(isset($data)){
					$terbilang = $this->terbilang($data[0]->tt_totalterima,$style=3);	
				}

			    $tgl = Carbon::parse($data[0]->tt_tglkembali)->format('D');
			    if($tgl == 'Sun'){
			    	$tgl = 'Minggu';
			    }else if($tgl == 'Mon'){
			    	$tgl = 'Senin';
			    
				}else if($tgl == 'Tue'){
			    	$tgl = 'Selasa';
			    
				}else if($tgl == 'Wed'){
			    	$tgl = 'Rabu';
			    
				}else if($tgl == 'Thu'){
			    	$tgl = 'Kamis';
			    }else if($tgl == 'Fri'){
			    	$tgl = 'Jumat';
				}else if($tgl == 'Sat'){
			    	$tgl = 'Sabtu';
				}
				
				return view('purchase/fatkur_pembelian/cetaktt',compact('nota','data','tgl','terbilang','cari_tipe'));
			}else if($cari_tipe[0]->fp_jenisbayar == 9){

				$nota = $request->nota;
				$data = DB::table('form_tt')
						  ->join('pembayaran_subcon','pb_faktur','=','tt_nofp')
						  ->join('faktur_pembelian','fp_nofaktur','=','tt_nofp')
						  ->join('subcon','kode','=','pb_kode_subcon')
						  ->where('tt_noform',$nota)
						  ->get();

				if(isset($data)){
					$terbilang = $this->terbilang($data[0]->tt_totalterima,$style=3);	
				}

			    $tgl = Carbon::parse($data[0]->tt_tglkembali)->format('D');
			    if($tgl == 'Sun'){
			    	$tgl = 'Minggu';
			    }else if($tgl == 'Mon'){
			    	$tgl = 'Senin';
			    
				}else if($tgl == 'Tue'){
			    	$tgl = 'Selasa';
			    
				}else if($tgl == 'Wed'){
			    	$tgl = 'Rabu';
			    
				}else if($tgl == 'Thu'){
			    	$tgl = 'Kamis';
			    }else if($tgl == 'Fri'){
			    	$tgl = 'Jumat';
				}else if($tgl == 'Sat'){
			    	$tgl = 'Sabtu';
				}
				
				return view('purchase/fatkur_pembelian/cetaktt',compact('nota','data','tgl','terbilang','cari_tipe'));
			}
		}

		public function hapus_biaya($id){
		 	
		}

		public function detailbiayapenerus(request $request){
			$cari_agen 	 = DB::table('faktur_pembelian')
						 ->where('fp_nofaktur',$request->id)
						 ->first();

			if ($cari_agen->fp_jenisbayar == 6) {
				$cari 	 = DB::table('faktur_pembelian')
						 ->join('biaya_penerus','bp_faktur','=','fp_nofaktur')
						 ->where('fp_nofaktur',$request->id)
						 ->get();
				if($cari[0]->bp_tipe_vendor == 'AGEN'){
						$cari_fp 	 = DB::table('faktur_pembelian')
									 ->join('biaya_penerus','bp_faktur','=','fp_nofaktur')
									 ->join('agen','bp_kode_vendor','=','kode')
									 ->where('fp_nofaktur',$request->id)
									 ->get();
					}else{
						$cari_fp 	 = DB::table('faktur_pembelian')
									 ->join('biaya_penerus','bp_faktur','=','fp_nofaktur')
									 ->join('vendor','bp_kode_vendor','=','kode')
									 ->where('fp_nofaktur',$request->id)
									 ->get();
					}

					$cari_bpd 	 = DB::table('biaya_penerus_dt')
								 ->join('delivery_order','nomor','=','bpd_pod')
								 ->join('kota','id_kota_asal','=','id')
								 ->where('bpd_bpid',$cari_fp[0]->bp_id)
								 ->orderBy('bpd_bpdetail')
								 ->get();

					$kota_tujuan = DB::table('biaya_penerus_dt')
								 ->join('delivery_order','nomor','=','bpd_pod')
								 ->join('kota','id_kota_tujuan','=','id')
								 ->where('bpd_bpid',$cari_fp[0]->bp_id)
								 ->orderBy('bpd_bpdetail')
								 ->get();

					// return $cari_bpd;
				
					$pdf = PDF::loadView('purchase/fatkur_pembelian/detailBiayaPenerus',compact('cari_fp','cari_bpd','kota_tujuan'))
								->setPaper('a4','potrait');
					return $pdf->stream('detail-biaya-penerus-'.$cari_fp[0]->fp_nofaktur.'.pdf');
			}elseif ($cari_agen->fp_jenisbayar == 7) {
				$cari_fp 	 = DB::table('faktur_pembelian')
									 ->join('pembayaran_outlet','pot_faktur','=','fp_nofaktur')
									 ->join('agen','pot_kode_outlet','=','kode')
									 ->where('fp_nofaktur',$request->id)
									 ->get();

				$cari_bpd 	 = DB::table('pembayaran_outlet_dt')
								 ->join('delivery_order','nomor','=','potd_pod')
								 ->join('kota','id_kota_asal','=','id')
								 ->where('potd_potid',$cari_fp[0]->pot_id)
								 ->orderBy('potd_potdetail')
								 ->get();

				$kota_tujuan = DB::table('pembayaran_outlet_dt')
								 ->join('delivery_order','nomor','=','potd_pod')
								 ->join('kota','id_kota_tujuan','=','id')
								 ->where('potd_potid',$cari_fp[0]->pot_id)
								 ->orderBy('potd_potdetail')
								 ->get();

				$pdf = PDF::loadView('purchase/fatkur_pembelian/detailBiayaPenerus',compact('cari_fp','cari_bpd','kota_tujuan'))
								->setPaper('a4','potrait');
				return $pdf->stream('detail-biaya-penerus-'.$cari_fp[0]->fp_nofaktur.'.pdf');
				
			}elseif ($cari_agen->fp_jenisbayar == 9) {

				$cari_fp 	 = DB::table('faktur_pembelian')
									 ->join('pembayaran_subcon','pb_faktur','=','fp_nofaktur')
									 ->join('subcon','pb_kode_subcon','=','kode')
									 ->where('fp_nofaktur',$request->id)
									 ->get();

				$cari_bpd 	 = DB::table('pembayaran_subcon_dt')
								 ->join('delivery_order','nomor','=','pbd_resi')
								 ->join('kota','id_kota_asal','=','id')
								 ->where('pbd_pb_id',$cari_fp[0]->pb_id)
								 ->orderBy('pbd_pb_dt')
								 ->get();

				$kota_tujuan = DB::table('pembayaran_subcon_dt')
								 ->join('delivery_order','nomor','=','pbd_resi')
								 ->join('kota','id_kota_tujuan','=','id')
								 ->where('pbd_pb_id',$cari_fp[0]->pb_id)
								 ->orderBy('pbd_pb_dt')
								 ->get();

				$pdf = PDF::loadView('purchase/fatkur_pembelian/detailBiayaPenerus',compact('cari_fp','cari_bpd','kota_tujuan'))
								->setPaper('a4','potrait');
				return $pdf->stream('detail-biaya-penerus-'.$cari_fp[0]->fp_nofaktur.'.pdf');
			}
					
		}

		public function buktibiayapenerus(request $request){


			$cari_fp	= DB::table('faktur_pembelian')			
						 ->join('cabang','kode','=','fp_comp')
						 ->join('biaya_penerus','bp_faktur','=','fp_nofaktur')
						 ->join('agen','bp_kode_vendor','=','agen.kode')
						 ->where('fp_nofaktur','=',$request->id)
						 ->get();

			$cari_bpd 	 = DB::table('biaya_penerus_dt')
						 ->join('delivery_order','nomor','=','bpd_pod')
						 ->join('kota','id_kota_asal','=','id')
						 ->where('bpd_bpid',$cari_fp[0]->bp_id)
						 ->orderBy('bpd_bpdetail')
						 ->get();

		    $cari_asal   = DB::table('biaya_penerus_dt')
						 ->join('delivery_order','nomor','=','bpd_pod')
						 ->select('id_kota_asal')
						 ->where('bpd_bpid',$cari_fp[0]->bp_id)
						 ->orderBy('bpd_bpdetail')
						 ->get();

			for ($i=0; $i < count($cari_asal); $i++) { 

				$cari_asal_2[$i] = $cari_asal[$i]->id_kota_asal; 
			}
			if (isset($cari_asal_2)) {
			    $unik_asal = array_unique($cari_asal_2);

			    for ($i=0; $i < count($unik_asal); $i++) { 
					for ($a=0; $a < count($cari_bpd); $a++) { 
						if($cari_bpd[$a]->id_kota_asal==$unik_asal[$i]){
							${$unik_asal[$i]}[$a] = $cari_bpd[$a]->bpd_nominal;
						}
					}
				}

				for ($i=0; $i < count($unik_asal); $i++) { 
					${'total'.$unik_asal[$i]} = array_sum(${$unik_asal[$i]});
				}
				
				for ($i=0; $i < count($unik_asal); $i++) { 
					 $harga_array[$i] = ${'total'.$unik_asal[$i]};
				}
				for ($i=0; $i < count($harga_array); $i++) { 
					 $harga_array[$i] = round($harga_array[$i]);
				}
				// return $harga_array;
				$total_harga=array_sum($harga_array);

				$terbilang = $this->terbilang($total_harga,$style=3);

				if(count($harga_array)<10){
					$td = 10-count($harga_array);
					for ($i=0; $i < $td; $i++) {  
						if(!isset($harga_array[$i])){
							$harga_array[$i] = ' ';
						}
					}
				}
			}
			return view('purchase/fatkur_pembelian/buktiBiayaPenerus',compact('cari_fp','harga_array','total_harga','terbilang'));
		}

		public function cari_note(request $request){
		$term = $request->term;

		$results = array();
	       $queries = DB::table('master_note')
	            ->where('mn_keterangan', 'like', '%'.$term.'%')
	            ->take(10)->get();

	        if ($queries == null){
	            $results[] = [ 'id' => null, 'label' => 'Tidak ditemukan data terkait'];
	        } else {

	            foreach ($queries as $query)
	            {
	                $results[] = [ 'id' => $query->mn_keterangan, 'label' => $query->mn_keterangan];
	            }
	        }

	        return Response::json($results);
		}

		public function save_outlet(request $request){
			// dd($request);	
			// "selectOutlet" => "A012"
	  //     "rangepicker" => "02/08/2017 - 01/02/2018"
	  //     "note" => "Biaya untuk outlet wisnu"
	  //     "nofaktur" => "FP0218/001/O-003"
	  //     "tgl" => "01-February-2018"
	  //     "chck" => array:25 [▶]
	  //     "no_resi" => array:25 [▶]
	  //     "komisi" => array:25 [▶]
	  //     "biaya_komisi" => array:25 [▶]
	  //     "total_komisi" => array:25 [▶]
	  //     "total_tarif" => "Rp 44.700,00"
	  //     "total_komisi_outlet" => "Rp 4.470,00"
	  //     "total_komisi_tambahan" => "Rp 0,00"
	  //     "total_all_komisi" => "Rp 4.470,00"
			$year =Carbon::now()->format('Y'); 
			$month =Carbon::now()->format('m'); 

			$request->total_tarif = filter_var($request->total_tarif, FILTER_SANITIZE_NUMBER_FLOAT);
			$request->total_tarif = $request->total_tarif/100;

			$request->total_komisi_outlet = filter_var($request->total_komisi_outlet, FILTER_SANITIZE_NUMBER_FLOAT);
			$request->total_komisi_outlet = $request->total_komisi_outlet/100;

			$request->total_komisi_tambahan = filter_var($request->total_komisi_tambahan, FILTER_SANITIZE_NUMBER_FLOAT);
			$request->total_komisi_tambahan = $request->total_komisi_tambahan/100;

			$request->total_all_komisi = filter_var($request->total_all_komisi, FILTER_SANITIZE_NUMBER_FLOAT);
			$request->total_all_komisi = $request->total_all_komisi/100;

			$tgl = explode('-',$request->rangepicker);
			$tgl[0] = str_replace('/', '-', $tgl[0]);
			$tgl[1] = str_replace('/', '-', $tgl[1]);
			$tgl[0] = str_replace(' ', '', $tgl[0]);
			$tgl[1] = str_replace(' ', '', $tgl[1]);
			
			$cari_id = DB::table('faktur_pembelian')
		     			->max('fp_idfaktur');

		     $id = DB::table('form_tt')
					->max('tt_idform');
			 if($id == null){
			 	$id=1;
			 }else{
			 	$id+=1;
			 }
			$akun_hutang = DB::table('agen')
							 ->where('kode',$request->selectOutlet)
							 ->first();
			$akun_hutang = $akun_hutang->acc_hutang;
			// return $akun_hutang;
			$idfaktur = DB::table('form_tt')->where('tt_idcabang' , '001')
									   ->where('tt_noform','LIKE','%'.'P-0'.'%')
									   ->max('tt_noform');
			//	dd($nosppid);
				if(isset($idfaktur)) {
					$explode  = explode("/", $idfaktur);
					$idfaktur = $explode[2];
					$idfaktur = filter_var($idfaktur, FILTER_SANITIZE_NUMBER_INT);
					$idfaktur = str_replace('-', '', $idfaktur) ;
					$string = (int)$idfaktur + 1;
					$idfaktur = str_pad($string, 3, '0', STR_PAD_LEFT);
				}

				else {
					$idfaktur = '001';
				}

				$nota = 'TT' . $month . $year . '/' . '' . '/P-' .  $idfaktur;

			$save = DB::table('form_tt')
			        			->insert([
			        				'tt_idform'		 	 => $id,
			        				'tt_tgl'   			 => Carbon::parse($tgl[1])->format('Y-m-d'),
			        				'tt_idagen' 	 	 => $request->selectOutlet,
			        				'tt_totalterima'	 => round($request->total_all_komisi,2),
			        				'created_at'		 => Carbon::now(),
			        				'tt_tglkembali'	 	 => Carbon::now(),
			        				'updated_at'	 	 => Carbon::now(),
			        				'tt_kwitansi'	 	 => 'ADA',
			        				'tt_suratperan'	 	 => 'ADA',
			        				'tt_suratjalanasli'	 => 'ADA',
			        				'tt_faktur'			 => 'ADA',
			        				'tt_noform'			 => $nota,
			        				'tt_nofp'			 => $request->nofaktur,
			        				'tt_idcabang'		 =>'001'
			        			]);


		     if($cari_id == null){
		     	$cari_id = 1;
		     }else{
		     	$cari_id+=1;
		     }
		   	
		   $cari_tt = DB::table('form_tt')
		    			 ->where('tt_nofp',$request->nofaktur)
		    			 ->get();
			fakturpembelian::create([
								'fp_idfaktur'		=> $cari_id,
								'fp_nofaktur'		=> $request->nofaktur,
								'fp_tgl'			=> Carbon::now(),
								'fp_jenisbayar' 	=> 7,
								'fp_comp'			=> '001',
								'created_at'		=> Carbon::now(),
								'fp_keterangan'		=> $request->note,
								'fp_status'			=> 'Released',
								'fp_pending_status'	=> 'APPROVED',
								'fp_supplier'		=> $request->selectOutlet,
								'fp_netto'			=> round($request->total_all_komisi,2),
								'fp_sisapelunasan'  => round($request->total_all_komisi,2),
								'fp_edit'			=> 'UNALLOWED',
								'fp_idtt'			=> $cari_tt[0]->tt_idform
								]);

			

			$cari_potid = DB::table('pembayaran_outlet')
		     			->max('pot_id');

		     if($cari_potid == null){
		     	$cari_potid = 1;
		     }else{
		     	$cari_potid+=1;
		     }
		     

			$save_pot = DB::table('pembayaran_outlet')
						  ->insert([
						  	'pot_id' 	 				=> $cari_potid,
						  	'pot_faktur' 				=> $request->nofaktur,
						  	'pot_status' 				=> 'Released',
						  	'pot_kode_outlet'			=> $request->selectOutlet,
						  	'pot_keterangan'			=> $request->note,
						  	'pot_total_tarif'			=> round($request->total_tarif,2),
							'pot_total_komisi_outlet'	=> round($request->total_komisi_outlet,2),
							'pot_total_komisi_tambah'	=> round($request->total_komisi_tambahan,2),
							'pot_total_komisi'			=> round($request->total_all_komisi,2),
						  	'pot_tgl'					=> Carbon::parse($tgl[0])->format('Y-m-d'),
						  	'pot_tgl_kembali'			=> Carbon::parse($tgl[1])->format('Y-m-d'),
						  	'updated_at'				=> Carbon::now(),
						  	'created_at'				=> Carbon::now()
						  ]);
			$pot_dt = 0;
			// dd($request->no_resi);
			for ($i=0; $i < count($request->chck); $i++) { 
				if ($request->chck[$i] == 'on') {
					$potd_id = DB::table('pembayaran_outlet_dt')
		     			->max('potd_id');

				     if($potd_id == null){
				     	$potd_id = 1;
				     }else{
				     	$potd_id+=1;
				     }

					$save_potdt = DB::table('pembayaran_outlet_dt')
									->insert([
										'potd_id'				=> $potd_id,
										'potd_potid'			=> $cari_potid,
										'potd_potdetail'		=> $pot_dt+1,
										'potd_pod'				=> $request->no_resi[$i],
										'potd_tgl'				=> Carbon::now(),
										'potd_tarif_resi'		=> $request->tarif[$i],
										'potd_komisi'			=> $request->komisi[$i],
										'potd_komisi_tambahan'	=> $request->komisi_tambahan[$i],
										'potd_komisi_total'		=> $request->total_komisi[$i],
										'updated_at'			=> Carbon::now(),
						  				'created_at'			=> Carbon::now()


									]);
					$pot_dt += 1;
				}
			}


			return response()->json(['id'=>$request->nofaktur]);
			
		}

		public function update_outlet(request $request){

			dd($request->all());
			$cari_nota  = DB::table('faktur_pembelian')
							->where('fp_idfaktur',$request->id)
							->first();
			$cari_pot  = DB::table('pembayaran_outlet')
							->where('pot_faktur',$cari_nota->fp_nofaktur)
							->first();
			$request->total_tarif = filter_var($request->total_tarif, FILTER_SANITIZE_NUMBER_FLOAT);
			$request->total_tarif = $request->total_tarif/100;

			$request->total_komisi_outlet = filter_var($request->total_komisi_outlet, FILTER_SANITIZE_NUMBER_FLOAT);
			$request->total_komisi_outlet = $request->total_komisi_outlet/100;

			$request->total_komisi_tambahan = filter_var($request->total_komisi_tambahan, FILTER_SANITIZE_NUMBER_FLOAT);
			$request->total_komisi_tambahan = $request->total_komisi_tambahan/100;

			$request->total_all_komisi = filter_var($request->total_all_komisi, FILTER_SANITIZE_NUMBER_FLOAT);
			$request->total_all_komisi = $request->total_all_komisi/100;

			$tgl = explode('-',$request->rangepicker);
			$tgl[0] = str_replace('/', '-', $tgl[0]);
			$tgl[1] = str_replace('/', '-', $tgl[1]);
			$tgl[0] = str_replace(' ', '', $tgl[0]);
			$tgl[1] = str_replace(' ', '', $tgl[1]);

			$update_pot = DB::table('faktur_pembelian')
							->where('fp_nofaktur',$cari_nota->fp_nofaktur)
							->update([
							  	'fp_keterangan'			=> $request->note,
							  	'fp_netto'				=> round($request->total_all_komisi,2),
								'fp_sisapelunasan'  	=> round($request->total_all_komisi,2),
								'fp_pending_status'  	=> 'APPROVED',
							  	'updated_at'			=> Carbon::now()
							]);

			$update_pot = DB::table('pembayaran_outlet')
							->where('pot_faktur',$cari_nota->fp_nofaktur)
							->update([
							  	'pot_kode_outlet'			=> $request->selectOutlet,
							  	'pot_keterangan'			=> $request->note,
							  	'pot_total_tarif'			=> round($request->total_tarif,2),
							  	'pot_total_komisi_outlet'	=> round($request->total_komisi_outlet,2),
							  	'pot_total_komisi_tambah'	=> round($request->total_komisi_tambahan,2),
							  	'pot_total_komisi'			=> round($request->total_all_komisi,2),
							  	'pot_tgl'					=> Carbon::parse($tgl[0])->format('Y-m-d'),
							  	'pot_tgl_kembali'			=> Carbon::parse($tgl[1])->format('Y-m-d'),
							  	'updated_at'				=> Carbon::now()
							]);
			$delete_potd = DB::table('pembayaran_outlet_dt')
							 ->where('potd_potid',$cari_pot->pot_id)
							 ->delete();

			$pot_dt = 0;
			for ($i=0; $i < count($request->chck); $i++) { 
				if ($request->chck[$i] == 'on') {
					$potd_id = DB::table('pembayaran_outlet_dt')
		     			->max('potd_id');

				     if($potd_id == null){
				     	$potd_id = 1;
				     }else{
				     	$potd_id+=1;
				     }
				    
					$save_potdt = DB::table('pembayaran_outlet_dt')
									->insert([
										'potd_id'				=> $potd_id,
										'potd_potid'			=> $cari_pot->pot_id,
										'potd_potdetail'		=> $pot_dt+1,
										'potd_pod'				=> $request->no_resi[$i],
										'potd_tgl'				=> $request->tgl[$i],
										'potd_tarif_resi'		=> $request->tarif[$i],
										'potd_komisi'			=> $request->komisi[$i],
										'potd_komisi_tambahan'	=> $request->komisi_tambahan[$i],
										'potd_komisi_total'		=> $request->total_komisi[$i],
										'updated_at'			=> Carbon::now(),
						  				'created_at'			=> Carbon::now()


									]);
					$pot_dt += 1;
				}
			}

			$status = DB::table('faktur_pembelian')
						->where('fp_nofaktur',$cari_nota->fp_nofaktur)
						->first();

			return response()->json(['status'=>$status->fp_pending_status]);
		}

		public function getpembayaransubcon(){

			$date = Carbon::now()->format('d/m/Y');

			$agen = DB::table('agen')
					  ->get();

			$akun = DB::table('master_persentase')
					  ->get();

			$subcon = DB::table('kontrak_subcon')
					  ->join('subcon','kode','=','ks_nama')
					  ->get();
			$akun_biaya = DB::table('akun')
					  ->get();
			$kota   = DB::table('kota')
					->get();

			return view('purchase/fatkur_pembelian/formSubcon',compact('date','kota','subcon','akun_biaya','akun'));
		}

		public function cari_subcon(request $request){
			
			$data = DB::select("SELECT res1.* from 
									   (SELECT kontrak_subcon.*,kontrak_subcon_dt.*,subcon.* 
									   from kontrak_subcon 
									   inner join kontrak_subcon_dt
									   on ks_id = ksd_ks_id
									   inner join subcon 
									   on ks_nama = kode) as res1
									   where res1.ksd_asal = '$request->asal'
									   and res1.ksd_tujuan = '$request->tujuan'
									   and res1.ks_cabang = '001'");

			if ($data != null) {
				return Response()->json([
								 'status'=>1,
								 'data'=>$data
							   ]);
			}else{
				return Response()->json([
								 'status'=>0
							   ]);
			}
			
		}

		public function cari_kontrak(request $request){
			// dd($request);
			$subcon_dt = DB::SELECT("SELECT kontrak_subcon.*,kontrak_subcon_dt.*, asal.nama as asal ,asal.id as id_asal,
						 				tujuan.nama as tujuan, tujuan.id as id_tujuan,
						 				angkutan.kode as kode_angkutan, angkutan.nama as angkutan
									    from kontrak_subcon 
									    inner join kontrak_subcon_dt
									    on ksd_ks_id = ks_id
									    inner join 
									    (SELECT nama,id from kota) as asal
									    on asal.id = ksd_asal
									    inner join 
							 	 	    (SELECT nama,id from kota) as tujuan
								 	    on tujuan.id = ksd_tujuan
								 	    inner join
								 	    (SELECT kode,nama from tipe_angkutan) as angkutan
								 	    on angkutan.kode  = ksd_angkutan
								 	    where ks_id = '$request->id'
								 	    and kontrak_subcon_dt.ksd_asal = '$request->asal'
									    and kontrak_subcon_dt.ksd_tujuan = '$request->tujuan'");

			return view('purchase/fatkur_pembelian/tabelModalSubcon',compact('subcon_dt'));

		}

		public function pilih_kontrak(request $request){

		$kontrak = DB::table('kontrak_subcon_dt')
					 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
					 ->join('tipe_angkutan','kode','=','ksd_angkutan')
					 ->where('ksd_id',$request->id)
					 ->orderBy('ksd_ks_dt','ASC')
					 ->get();

		$asal = DB::table('kontrak_subcon_dt')
					 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
					 ->join('kota','id','=','ksd_asal')
					 ->select('nama as asal')
					 ->where('ksd_id',$request->id)
					 ->orderBy('ksd_ks_dt','ASC')
					 ->get();

		$tujuan = DB::table('kontrak_subcon_dt')
					 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
					 ->join('kota','id','=','ksd_tujuan')
					 ->select('nama as tujuan')
					 ->where('ksd_id',$request->id)
					 ->orderBy('ksd_ks_dt','ASC')
					 ->get();


		$fix=[];
		for ($i=0; $i < count($kontrak); $i++) { 
			$fix[$i]['ksd_id'] = $kontrak[$i]->ksd_ks_id;
			$fix[$i]['ksd_dt'] = $kontrak[$i]->ksd_ks_dt;
			$fix[$i]['ksd_nota'] = $kontrak[$i]->ks_nota;
			$fix[$i]['ksd_harga'] = number_format($kontrak[$i]->ksd_harga,2,',','.'	); 
			$fix[$i]['ksd_harga2'] = $kontrak[$i]->ksd_harga; 
			$fix[$i]['ksd_jenis_tarif'] = $kontrak[$i]->ksd_jenis_tarif;
			$fix[$i]['ksd_asal'] = $asal[$i]->asal;
			$fix[$i]['ksd_tujuan'] = $tujuan[$i]->tujuan;
			$fix[$i]['ksd_angkutan'] = $kontrak[$i]->nama;
			$fix[$i]['ksd_id_angkutan'] = $kontrak[$i]->kode;
		}
			return Response()->json([
								'subcon_dt' => $fix
							   ]);
		}

	public function subcon_save(request $request){
		// dd($request->all());
		$count = 0;
		if ($request->id!='') {
			$count+=1;
		}
		if ($request->dt!='') {
			$count+=1;
		}
		if ($request->tempo!='') {
			$count+=1;
		}
		if (isset($request->resi_subcon)) {
			$count+=1;
		}
		// return $count;
		if($count == 4){
				$tgl = Carbon::now();
		      	
		      	$cari_subcon = DB::table('kontrak_subcon_dt')
		      				   ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
		      				   ->where('ksd_ks_id',$request->id)
		      				   ->where('ksd_ks_dt',$request->dt)
		      				   ->first();

		      for ($i=0; $i < count($request->resi_subcon); $i++) { 
		      	 $cari_resi[$i] = DB::table('delivery_order')
		      				   ->where('nomor',$request->resi_subcon[$i])
		      				   ->get();
		      }
		     
		      // return $cari_resi;

		      $cari_nota = DB::table('faktur_pembelian')
		      				 ->where('fp_nofaktur',$request->nofaktur)
		      				 ->get();


		      if ($request->ts == 'KILOGRAM') {
		      	for ($i=0; $i < count($request->kg); $i++) { 
		      		$stats[$i] 	   = $request->kg[$i];
		      		$harga[$i]     = $request->harga_tarif[$i];
		      		$hrg_resi[$i]  = $request->harga_resi[$i];
		      	}
		      	
		      }else{
		      	for ($i=0; $i < count($request->trip); $i++) { 
		      		$stats[$i] 	   = $request->kg[$i];
		      		$harga[$i]     = $request->harga_tarif[$i];
		      		$hrg_resi[$i]  = $request->harga_resi[$i];
		      	}
		      }

		      if ($cari_nota == null) {
		      	$year =Carbon::now()->format('y'); 
				$month =Carbon::now()->format('m'); 
		      	$idfaktur = DB::table('form_tt')->where('tt_idcabang' , '001')
											   ->where('tt_noform','LIKE','%'.'SC-0'.'%')
											   ->max('tt_noform');
					//	dd($nosppid);
						if(isset($idfaktur)) {
							$explode  = explode("/", $idfaktur);
							$idfaktur = $explode[2];
							$idfaktur = filter_var($idfaktur, FILTER_SANITIZE_NUMBER_INT);
							$idfaktur = str_replace('-', '', $idfaktur) ;
							$string = (int)$idfaktur + 1;
							$idfaktur = str_pad($string, 3, '0', STR_PAD_LEFT);
						}

						else {
							$idfaktur = '001';
						}

				$nota = 'TT' . $month . $year . '/' . '001' . '/SC-' .  $idfaktur;

				 $id = DB::table('form_tt')
							->max('tt_idform');
					 if($id == null){
					 	$id=1;
					 }else{
					 	$id+=1;
					 }

				$cari_persen =DB::table('master_persentase')
									->where('kode',$request->persen_subcon)
									->first();

				$harga = array_sum($harga);
				$hrg_resi = array_sum($hrg_resi);
				$persen = $cari_persen->persen/100;
				$jml_persen = $hrg_resi * $persen;

				if ($harga > $jml_persen) {
					$status = 'PENDING';
				}else{
					$status = 'APPROVED';
				}
				$status;
		      	$save = DB::table('form_tt')
					        			->insert([
					        				'tt_idform'		 	 => $id,
					        				'tt_tgl'   			 => $tgl,
					        				'tt_idagen' 	 	 => $cari_subcon->ks_nama,
					        				'tt_totalterima'	 => $harga,
					        				'created_at'		 => Carbon::now(),
					        				'updated_at'	 	 => Carbon::now(),
					        				'tt_kwitansi'	 	 => 'ADA',
					        				'tt_suratperan'	 	 => 'ADA',
			        						'tt_tglkembali'	 	 => Carbon::now(),
					        				'tt_suratjalanasli'	 => 'ADA',
					        				'tt_faktur'			 => 'ADA',
					        				'tt_noform'			 => $nota,
					        				'tt_nofp'			 => $request->nofaktur,
					        				'tt_idcabang'		 => '001'
					        			]);

					$cari_tt = DB::table('form_tt')
				    			 ->where('tt_nofp',$request->nofaktur)
				    			 ->first();


				    $cari_id = DB::table('faktur_pembelian')
				     			->max('fp_idfaktur');
				    	
				     if($cari_id == null){
				     	$cari_id = 1;
				     }else{
				     	$cari_id+=1;
				     }



					
				    $request->tempo = str_replace('/', '-', $request->tempo);
					fakturpembelian::create([
										'fp_idfaktur'		=> $cari_id,
										'fp_nofaktur'		=> $request->nofaktur,
										'fp_tgl'			=> Carbon::parse($tgl)->format('Y-m-d'),
										'fp_jenisbayar' 	=> 9,
										'fp_comp'			=> '001',
										'fp_noinvoice'		=> $request->invoice,
										'created_at'		=> Carbon::now(),
										'fp_pending_status' => $status,
										'fp_status'			=> 'Released',
										'fp_keterangan'		=> $request->keterangan_subcon,
										'fp_edit'			=> 'UNALLOWED',
										'fp_supplier'		=> $cari_subcon->ks_nama,
										'fp_sisapelunasan'	=> $harga,
										'fp_netto'			=> $harga,
										'fp_jatuhtempo'		=> Carbon::parse($request->tempo)->format('Y-m-d'),
										'fp_idtt'			=> $cari_tt->tt_idform
										]);

					

					$cari_id_subcon = DB::table('pembayaran_subcon')
										->max('pb_id');
					if ($cari_id_subcon == null) {
						$cari_id_subcon = 1;
					}else{
						$cari_id_subcon += 1;
					}

					$request->nota = str_replace(' ', '', $request->nota);
		
					
					$save_subcon = DB::table('pembayaran_subcon')
									    ->insert([
									     	'pb_id' 			 => $cari_id_subcon,
									     	'pb_faktur' 		 =>$request->nofaktur,
									     	'pb_status'			 => 'Released',
									     	'pb_kode_subcon'	 => $cari_subcon->ks_nama,
									     	'pb_id_kontrak'		 => $request->id,
									     	'pb_id_persen'		 => $request->persen_subcon,
									     	'pb_dt_kontrak'		 => $request->id,
									     	'pb_jenis_kendaraan' => $cari_subcon->ksd_angkutan,
									     	'pb_ref'			 => $request->nota,
									     	'pb_asal'			 => $cari_subcon->ksd_asal,
									     	'pb_tujuan'			 => $cari_subcon->ksd_tujuan,
									     	'created_at'		 => Carbon::now(),
					        				'updated_at'	 	 => Carbon::now()
					        				// 'pb_total_biaya'	 => $harga
									     ]);

					for ($i=0; $i < count($request->resi_subcon); $i++) { 

						$cari_dt_subcon = DB::table('pembayaran_subcon_dt')
										->max('pbd_id');
						if ($cari_dt_subcon == null) {
							$cari_dt_subcon = 1;
						}else{
							$cari_dt_subcon += 1;
						}

						$save_subcon_dt = DB::table('pembayaran_subcon_dt')
									     ->insert([
									     	'pbd_id' => $cari_dt_subcon,
									     	'pbd_pb_id' => $cari_id_subcon,
									     	'pbd_pb_dt' => $i+1,
									     	'pbd_resi' => $request->resi_subcon[$i],
									     	'pbd_berat' => $stats[$i],
									     	'pbd_tarif_resi' => $cari_resi[$i][0]->tarif_dasar,
									     	'pbd_tarif_harga' => $request->harga_tarif[$i],
									     	'pbd_keterangan' => $request->ket_subcon[$i],
									     	'created_at'		 => Carbon::now(),
					        				'updated_at'	 	 => Carbon::now()
									     ]);
					}
		      }else{
		      	return 'Data Sudah ADA';
		      }
	  	return Response()->json(['status' => 1]);

	  }else{
	  	return Response()->json(['status' => 2]);
	  }
	}

	public function subcon_update(request $request){
		// dd($request->all());	
		$count = 0;
		if ($request->id!='') {
			$count+=1;
		}
		if ($request->dt!='') {
			$count+=1;
		}
		if ($request->tempo!='') {
			$count+=1;
		}
		if (isset($request->resi_subcon)) {
			$count+=1;
		}

		if($count == 4){
				// $tgl = Carbon::now();
		      	
		      	$cari_subcon = DB::table('kontrak_subcon_dt')
		      				   ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
		      				   ->where('ksd_ks_id',$request->id)
		      				   ->where('ksd_ks_dt',$request->dt)
		      				   ->first();

		      for ($i=0; $i < count($request->resi_subcon); $i++) { 
		      	 $cari_resi[$i] = DB::table('delivery_order')
		      				   ->where('nomor',$request->resi_subcon[$i])
		      				   ->get();
		      }
		     
		      // return $cari_resi;

		      if ($request->tarif_subcon == 'KILOGRAM') {
		      	// return 'asd';
		      	for ($i=0; $i < count($request->kg); $i++) { 
		      		$stats[$i] 	   = $request->kg[$i];
		      		$harga1[$i]     = $request->harga_tarif[$i];
		      		$hrg_resi1[$i]  = $request->harga_resi[$i];
		      	}
		      	
		      }else{
		      	for ($i=0; $i < count($request->trip); $i++) { 
		      		$stats[$i] 	   = $request->kg[$i];
		      		$harga1[$i]     = $request->harga_tarif[$i];
		      		$hrg_resi1[$i]  = $request->harga_resi[$i];
		      	}
		      }
		      // return $hrg_resi;
		      $cari_persen =DB::table('master_persentase')
									->where('kode',$request->persen)
									->first();

				$harga = array_sum($harga1);
				$hrg_resi = array_sum($hrg_resi1);
				$persen = $cari_persen->persen/100;
				$jml_persen = $hrg_resi * $persen;

				if ($harga > $jml_persen) {
					$status = 'PENDING';
				}else{
					$status = 'APPROVED';
				}
				// return $status;
		      $cari_nota = DB::table('faktur_pembelian')
		      				 ->join('pembayaran_subcon','pb_faktur','=','fp_nofaktur')
		      				 ->where('fp_nofaktur',$request->nofaktur)
		      				 ->first();




					$cari_tt = DB::table('form_tt')
				    			 ->where('tt_nofp',$request->nofaktur)
				    			 ->first();


				    $cari_id = DB::table('faktur_pembelian')
				     			->max('fp_idfaktur');
				    	
				     if($cari_id == null){
				     	$cari_id = 1;
				     }else{
				     	$cari_id+=1;
				     }
				     $request->tempo = str_replace('/', '-', $request->tempo);
				     $tempo = Carbon::parse($request->tempo)->format('Y-m-d');
					fakturpembelian::where('fp_nofaktur',$request->nofaktur)
										->update([
											'fp_jatuhtempo' => $tempo,
											'fp_netto' => $harga,
											'fp_pending_status' => $status,
											'fp_sisapelunasan' => $harga,
									    	'fp_keterangan' => $request->ket

										]);

					


					$save_subcon = DB::table('pembayaran_subcon')
										->where('pb_faktur',$request->nofaktur)
									    ->update([
									    	'pb_keterangan' => $request->ket,
									    	'pb_id_persen'	=> $request->persen
									     ]);

						$delete = DB::table('pembayaran_subcon_dt')
								->where('pbd_pb_id','=',$cari_nota->pb_id)
								->delete();


					$cari_pbd = DB::table('pembayaran_subcon')
								  ->where('pb_faktur',$request->nofaktur)
								  ->get();

					for ($i=0; $i < count($request->resi_subcon); $i++) { 

						$cari_dt_subcon = DB::table('pembayaran_subcon_dt')
										->max('pbd_id');
						if ($cari_dt_subcon == null) {
							$cari_dt_subcon = 1;
						}else{
							$cari_dt_subcon += 1;
						}

						$save_subcon_dt = DB::table('pembayaran_subcon_dt')
									     ->insert([
									     	'pbd_id'		 => $cari_dt_subcon,
									     	'pbd_pb_id' 	 => $cari_pbd[0]->pb_id,
									     	'pbd_pb_dt' 	 => $i+1,
									     	'pbd_resi' 		 => $request->resi_subcon[$i],
									     	'pbd_berat' 	 => $stats[$i],
									     	'pbd_tarif_resi' => (float)$hrg_resi1[$i],
									     	'pbd_tarif_harga'=> (float)$harga1[$i],
									     	'pbd_keterangan' => $request->ket_subcon[$i],
									     	'created_at'	 => Carbon::now(),
					        				'updated_at'     => Carbon::now()
									     ]);
					}
	  	return Response()->json(['status' => 1]);

	  }else{
	  	return Response()->json(['status' => 2]);
	  }

	}

	public function cari_kontrak_subcon($id){

		$kontrak = DB::table('kontrak_subcon_dt')
					 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
					 ->join('tipe_angkutan','kode','=','ksd_angkutan')
					 ->where('ks_nama',$id)
					 ->orderBy('ksd_ks_dt','ASC')
					 ->get();

		$asal = DB::table('kontrak_subcon_dt')
					 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
					 ->join('kota','id','=','ksd_asal')
					 ->select('nama as asal')
					 ->where('ks_nama',$id)
					 ->orderBy('ksd_ks_dt','ASC')
					 ->get();

		$tujuan = DB::table('kontrak_subcon_dt')
					 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
					 ->join('kota','id','=','ksd_tujuan')
					 ->select('nama as tujuan')
					 ->where('ks_nama',$id)
					 ->orderBy('ksd_ks_dt','ASC')
					 ->get();

		// $fix=[][];
		for ($i=0; $i < count($kontrak); $i++) { 
			$fix[$i]['ksd_nota'] = $kontrak[$i]->ks_nota;
			$fix[$i]['ksd_id'] = $kontrak[$i]->ksd_id;
			$fix[$i]['ksd_harga'] = $kontrak[$i]->ksd_harga;
			$fix[$i]['ksd_jenis_tarif'] = $kontrak[$i]->ksd_jenis_tarif;
			$fix[$i]['ksd_asal'] = $asal[$i]->asal;
			$fix[$i]['ksd_tujuan'] = $tujuan[$i]->tujuan;
			$fix[$i]['ksd_angkutan'] = $kontrak[$i]->nama;
			$fix[$i]['ksd_id_angkutan'] = $kontrak[$i]->kode;
		}
			return view('purchase/fatkur_pembelian/tabelModalSubcon',compact('fix'));
	}

	public function cari_kontrak_subcon1($id){
		$kontrak = DB::table('kontrak_subcon_dt')
					 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
					 ->join('tipe_angkutan','kode','=','ksd_angkutan')
					 ->where('ks_nama',$id)
					 ->orderBy('ksd_ks_dt','ASC')
					 ->get();

		$asal = DB::table('kontrak_subcon_dt')
					 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
					 ->join('kota','id','=','ksd_asal')
					 ->select('nama as asal')
					 ->where('ks_nama',$id)
					 ->orderBy('ksd_ks_dt','ASC')
					 ->get();

		$tujuan = DB::table('kontrak_subcon_dt')
					 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
					 ->join('kota','id','=','ksd_tujuan')
					 ->select('nama as tujuan')
					 ->where('ks_nama',$id)
					 ->orderBy('ksd_ks_dt','ASC')
					 ->get();


		// $fix=[][];
		for ($i=0; $i < count($kontrak); $i++) { 
			$fix[$i]['ksd_id'] = $kontrak[$i]->ksd_id;
			$fix[$i]['ksd_nota'] = $kontrak[$i]->ks_nota;
			$fix[$i]['ksd_harga'] = $kontrak[$i]->ksd_harga;
			$fix[$i]['ksd_jenis_tarif'] = $kontrak[$i]->ksd_jenis_tarif;
			$fix[$i]['ksd_asal'] = $asal[$i]->asal;
			$fix[$i]['ksd_tujuan'] = $tujuan[$i]->tujuan;
			$fix[$i]['ksd_angkutan'] = $kontrak[$i]->nama;
			$fix[$i]['ksd_id_angkutan'] = $kontrak[$i]->kode;
		}
			return view('purchase/fatkur_pembelian/tabelModalSubcon',compact('fix'));
		
	}


	public function rubahVen(request $request)
	{
		// dd($request->all());

		if ($request->val == 'AGEN') {
			$data = DB::table('agen')
					  ->where('kode_cabang',$request->cabang)
					  ->where('kategori','AGEN')
					  ->orWhere('kategori','AGEN DAN OUTLET')
					  ->get();
		}else{
			$data = DB::table('vendor')
					  ->get();
		}
			$flag = $request->vendor;
// return 'asd';
		return view('purchase/fatkur_pembelian/dropdownBiayaPenerus',compact('data','flag'));
	}



public function cari_do_subcon(request $request)
{
	// dd($request->all());
	$cari_do = DB::table('delivery_order')
				 ->where('jenis','KARGO')
				 ->where('kode_subcon',$request->sc)
				 ->where('kode_cabang',$request->cabang)
				 ->get();
	$asal = DB::table('delivery_order')
				 ->join('kota','id','=','id_kota_asal')
				 ->where('jenis','KARGO')
				 ->where('kode_subcon',$request->sc)
				 ->where('kode_cabang',$request->cabang)
				 ->get();

	$tujuan = DB::table('delivery_order')
				 ->join('kota','id','=','id_kota_tujuan')
				 ->where('jenis','KARGO')
				 ->where('kode_subcon',$request->sc)
				 ->where('kode_cabang',$request->cabang)
				 ->get();

	$angkutan = DB::table('delivery_order')
				 ->join('tipe_angkutan','kode','=','tipe_kendaraan')
				 ->where('jenis','KARGO')
				 ->where('kode_subcon',$request->sc)
				 ->where('kode_cabang',$request->cabang)
				 ->get();

	for ($i=0; $i < count($cari_do); $i++) { 
			$fix[$i]['d_nomor'] = $cari_do[$i]->nomor;
			$fix[$i]['d_total_net'] = $cari_do[$i]->total_net;
			$fix[$i]['d_tanggal'] = $cari_do[$i]->tanggal;
			$fix[$i]['d_jenis_tarif'] = $cari_do[$i]->jenis;
			$fix[$i]['d_asal'] = $asal[$i]->nama;
			$fix[$i]['d_tujuan'] = $tujuan[$i]->nama;
			$fix[$i]['d_angkutan'] = $angkutan[$i]->nama;
			$fix[$i]['ksd_id_angkutan'] = $angkutan[$i]->kode;
	}
	return view('purchase.fatkur_pembelian.tabelSubcon',compact('fix'));
}

}



?>