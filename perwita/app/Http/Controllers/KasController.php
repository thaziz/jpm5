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
use App\biaya_penerus_kas;
use App\biaya_penerus_kas_detail;
use App\tb_master_pajak;
use App\tb_coa;
use App\tb_jurnal;
use App\master_akun;
use App\d_jurnal;
use App\d_jurnal_dt;
use DB;
use Response;
Use Carbon\Carbon;
use Session;
use Mail;
use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;

class KasController extends Controller
{
	public function index(){
		 $data = DB::table('biaya_penerus_kas')
				->join('cabang','kode','=','bpk_comp')
				->get();
		for ($i=0; $i < count($data); $i++) { 
			$data[$i]->bpk_tanggal = Carbon::parse($data[$i]->bpk_tanggal)->format('d/m/Y');
		}
		return view('purchase/kas/index',compact('data'));
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

	    $id = DB::table('biaya_penerus_kas')
	    		->where('bpk_comp','001')
	    		->max('bpk_nota');

	    $year  = Carbon::now()->format('Y'); 
		$month = Carbon::now()->format('m');  	
		$now   = Carbon::now()->format('d-m-Y');
		
	   	if(isset($id)) {

			$explode = explode("/", $id);
		    $id = $explode[3];
			$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
			$string = (int)$id + 1;
			$id = str_pad($string, 3, '0', STR_PAD_LEFT);

		}

		else {
			$id = '001';
		}

		$kk = 'KK' . $month . $year . '/' .'SURABAYA'. '/' . '001' . '/' .  $id;

		$akun = DB::table('d_akun')
				  ->where('id_parrent',1001)
				  ->get();

		$akun_biaya_cargo1 = DB::table('master_persentase')
				  ->where('kode_akun','LIKE','%'.'5205'.'%')
				  ->orderBy('kode','ASC')
				  ->get();
		$akun_biaya_cargo2 = DB::table('master_persentase')
				  ->where('kode_akun','LIKE','%'.'5405'.'%')
				  ->orderBy('kode','ASC')
				  ->get();
		$akun_biaya_paket = DB::table('master_persentase')
				  ->where('kode_akun','LIKE','%'.'53'.'%')
				  ->orderBy('kode_akun','ASC')
				  ->get();
		$angkutan = DB::table('tipe_angkutan')
				  ->get();

		$akun_biaya_cargo = array_merge($akun_biaya_cargo1,$akun_biaya_cargo2);

		$satu = count($akun_biaya_cargo1);
		$dua  = count($akun_biaya_cargo2);
		$count = $satu+$dua;



		return view('purchase/kas/createkas',compact('kk','now','akun','akun_biaya_cargo','akun_biaya_paket','angkutan'));
	}
	public function getbbm($id){
		// $id = (string)$id;
		return $angkutan = DB::table('tipe_angkutan')
					// ->select('bbm_per_liter','tipe_angkutan.kode')
					->join('master_bbm','bahan_bakar','=','master_bbm.mb_id')
					->where('kode','=',$id)
					->orderBy('kode','ASC')
				  	->get();
		return response()->json(['angkutan'=>$angkutan]);
	}
	public function cari_resi(Request $request){
		// dd($request);
		$cari_persen = DB::table('master_persentase')
	    		  ->where('kode',$request->pembiayaan_paket)
	    		  ->where('cabang','001')
	    		  ->get();
	    if ($cari_persen == null) {
	    	$cari_persen = DB::table('master_persentase')
	    		  ->where('kode',$request->pembiayaan_paket)
	    		  ->where('cabang','GLOBAL')
	    		  ->get();
	    }
	    
		$biaya_bbm 	  = filter_var($request->total_bbm, FILTER_SANITIZE_NUMBER_INT);
		$biaya_dll 	  = filter_var($request->biaya_dll, FILTER_SANITIZE_NUMBER_INT);
		$resi      	  = explode(' ', $request->resi);
		$resi	  	  = array_unique($resi);
		$resi	  	  = array_values($resi);
		$data     	  = [];
		$tujuan       = [];
		$total_tarif  = 0;
		$penerus      = [];
		$total_penerus= 0;
		$tipe_data    = $request->tipe_data;

		for ($i=0 ; $i < count($resi); $i++) { 

			$bpk = DB::table('biaya_penerus_kas_detail')
				  ->join('biaya_penerus_kas','bpk_id','=','bpkd_bpk_id')
				  ->join('master_persentase','bpk_pembiayaan','=','kode')
				  ->where('bpkd_no_resi',$resi[$i])
				  ->get();


		   	$bpk_dt[$i]   = $bpk;
		}

			

		for ($i=0; $i < count($bpk_dt); $i++) { 
			if($bpk_dt[$i]!=null){
				if($bpk_dt[$i][0]->jenis_biaya == "4" ){
					
				} elseif ($bpk_dt[$i][0]->jenis_biaya == '2') {

					for ($a=0; $a < count($bpk_dt[$i]); $a++) { 
						$comp[$a] = (float)$bpk_dt[$i][$a]->bpk_tarif_penerus;
					}

					if (in_array('001',$comp)) {
						unset($resi[$i]);
					}

				}else{
					unset($resi[$i]);
				}
			}
		}
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
			for ($i=0; $i < count($data); $i++) { 
				$total_tarif+=$data[$i][0]->tarif_dasar;
			}
			$total_tarif = round($total_tarif,2);
		 //Menjumlah bbm dan biaya lain-lain
			$kas_surabaya = $biaya_bbm + $biaya_dll;

		//menghitung tarif penerus
			for ($i=0; $i < count($data); $i++) { 
				$hasil=($kas_surabaya/$total_tarif)*$data[$i][0]->tarif_dasar;
				$penerus[$i]=round($hasil,2);
			}
		
			$total_penerus =array_sum($penerus);
			$total_penerus =round($total_penerus,2);

			return view('purchase/kas/tabelBiayakas',compact('data','tujuan','total_tarif','kas_surabaya','penerus','total_penerus','tipe_data'));
	
		}else{
			return response()->json(['status' => 0]);
		}
		
		
	}
	public function save_penerus(request $request){
		return DB::transaction(function() use ($request) {  
		 
		// dd($request->pembiayaan_paket);
		$cari_persen = DB::table('master_persentase')
	    		  ->where('kode',$request->pembiayaan_paket)
	    		  ->where('cabang','001')
	    		  ->get();
	   	
	    if ($cari_persen == null) {
	    	$cari_persen = DB::table('master_persentase')
	    		  ->where('kode',$request->pembiayaan_paket)
	    		  ->where('cabang','GLOBAL')
	    		  ->get();
	    }

	    $akun_biaya = $cari_persen[0]->kode_akun;
	    // akun Biaya
	   	$akun_biaya;


	    $request->biaya_dll = filter_var($request->biaya_dll, FILTER_SANITIZE_NUMBER_FLOAT);
	    $request->total_bbm = filter_var($request->total_bbm, FILTER_SANITIZE_NUMBER_FLOAT);
	    

		if ($cari_persen[0]->jenis_biaya == '4') {
			for ($i=0; $i < count($request->no_resi); $i++) { 
				$bpk = DB::table('biaya_penerus_kas_detail')
							->where('bpkd_no_resi',$request->no_resi[$i])
							->get();
				$bpk_dt[$i] = $bpk;
			}
			for ($i=0; $i < count($bpk_dt); $i++) { 
				for ($a=0; $a < count($bpk_dt[$i]); $a++) { 
					$jml[$a] = $bpk_dt[$i][$a]->bpkd_tarif_penerus;
				}
				if (isset($jml)) {
					$jml_dt[$i] = array_sum($jml);
				}
				
			}
			if (isset($jml_dt)) {
				$fix = array_sum($jml_dt);
			}else{
				$fix = 0;
			}
	
			$tot_pen = array_sum($request->penerus);
			$fix = $fix + $tot_pen;

		}else{
			$fix = array_sum($request->penerus);
		}


		$fix_tarif_penerus = array_sum($request->penerus);
		$persen = $cari_persen[0]->persen/100;
		$total_tarif = $request->total_tarif*$persen;

		if($fix <= $total_tarif){
			$pending_status = 'APPROVED';
		}else{
			$pending_status = 'PENDING';
		}


		if($request->jenis_pembiayaan=='PAKET'){
			$pembiayaan = $request->pembiayaan_paket;
		}else{
			$pembiayaan = $request->pembiayaan_cargo;
		}
		
		$id = DB::table('biaya_penerus_kas')
				->max('bpk_id');
		if($id != null){
			$id+=1;
		}else{
			$id=1;
		}


	    $isset =  DB::table('biaya_penerus_kas')
	    		  ->select('bpk_nota')
	    		  ->get();

	    $ada_data = 0;
	    for ($i=0; $i < count($isset); $i++) { 
	    	if($isset[$i]->bpk_nota == $request->no_trans){
	    		$ada_data = 1;
	    	}
	    }
	    $total_penerus_float = array_sum($request->penerus);

        if($ada_data == 0){
		$nomor=$id;
		biaya_penerus_kas::create([
		  	'bpk_id'      	  	 => $id,
		  	'bpk_nota'  	  	 => $request->no_trans,
		  	'bpk_jenis_biaya' 	 => $request->jenis_pembiayaan,
		  	'bpk_pembiayaan'  	 => $pembiayaan,
		  	'bpk_total_tarif' 	 => round($request->total_tarif,2),
		  	'bpk_tanggal'     	 => Carbon::parse($request->tN)->format('Y-m-d'),
		  	'bpk_nopol'		  	 => strtoupper($request->nopol),
		  	'bpk_status'	  	 => 'Released',
		  	'bpk_status_pending' => $pending_status,	
		  	'bpk_kode_akun'		 => $request->kode_kas,
		  	'bpk_sopir'		 	 => strtoupper($request->nama_sopir),
		  	'bpk_keterangan'	 => $request->note,
		  	'bpk_tipe_angkutan'  => $request->jenis_kendaraan,		
		  	'created_at'		 => Carbon::now(),
		  	'bpk_comp'	 		 => '001',
		  	'bpk_tarif_penerus'	 => round($total_penerus_float,2),
		  	'bpk_edit'	 		 => 'UNALLOWED',
		  	'bpk_biaya_lain'	 => round($request->biaya_dll,2),
		  	'bpk_jarak'	 		 => $request->km,
		  	'bpk_harga_bbm'	     => round($request->total_bbm,2),

		  ]);

		}else{

			return response()->json(['status' => '0']);
		}

		for ($i=0; $i < count($request->no_resi); $i++) { 


			$dt = DB::table('biaya_penerus_kas_detail')
					->max('bpkd_id');

			if($dt != null){
				$dt+=1;
			}else{
				$dt=1;
			}
			
			if ($cari_persen[0]->jenis_biaya == '4') {
				
					
					biaya_penerus_kas_detail::create([
				  		'bpkd_id'				=> $dt,
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
						'bpkd_tarif_penerus'	=> round($request->penerus[$i],2),
						'created_at'			=> Carbon::now(),
						'bpk_comp'				=> '001',
						'bpkd_pembiayaan'		=> $request->tarif[$i]

				 	 ]);
				

			}else{

				biaya_penerus_kas_detail::create([
			  		'bpkd_id'				=> $dt,
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
					'bpkd_tarif_penerus'	=> round($request->penerus[$i],2),
					'created_at'			=> Carbon::now(),
					'bpk_comp'				=> '001',
					'bpkd_pembiayaan'		=> $request->tarif[$i]

			  ]);
			}
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
						   		'pc_tgl'		  => Carbon::now(),
						   		'pc_ref'	 	  => 10,
						   		'pc_akun' 		  => $cari_persen[0]->kode_akun,
						   		'pc_akun_kas' 	  => $request->kode_kas,
						   		'pc_keterangan'	  => $request->note,
						   		'pc_comp'  	  	  => '001',
						   		'pc_edit'  	  	  => 'UNALLOWED',
						   		'pc_reim'  	  	  => 'UNRELEASED',
						   		'pc_debet'  	  => round($total_penerus_float,2),
						   		'pc_no_trans'  	  => $request->no_trans,
						   		'pc_kredit'  	  => round($total_penerus_float,2),
						   		'created_at'	  => Carbon::now(),
					        	'updated_at' 	  => Carbon::now()
					]);

		// JURNAL
		$cari_id = DB::table('biaya_penerus_kas')
		  			   ->where('bpk_id','=',$id)
		  			   ->get();

		$cari=DB::table('biaya_penerus_kas')			
					 ->join('cabang','kode','=','bpk_comp')
					 ->where('bpk_id','=',$id)
					 ->get();
		$cari_dt=DB::table('biaya_penerus_kas_detail')		
					 ->where('bpkd_bpk_id','=',$id)
					 ->get();
	    $cari_asal=DB::table('biaya_penerus_kas_detail')
	    			 ->select('bpkd_kode_cabang_awal')			
					 ->where('bpkd_bpk_id','=',$id)
					 ->get();

		for ($i=0; $i < count($cari_asal); $i++) { 

			$cari_asal_2[$i] = $cari_asal[$i]->bpkd_kode_cabang_awal; 
		}
		if (isset($cari_asal_2)) {
		    $unik_asal = array_unique($cari_asal_2);
		    $unik_asal = array_values($unik_asal);

		    // return $unik_asal;
		    for ($i=0; $i < count($unik_asal); $i++) { 
				for ($a=0; $a < count($cari_dt); $a++) { 
					if($cari_dt[$a]->bpkd_kode_cabang_awal==$unik_asal[$i]){
						${$unik_asal[$i]}[$a] = $cari_dt[$a]->bpkd_tarif_penerus;
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

			// IKI MAS JURNAL.E HARGA MBEK ASALE
			 // return $jurnal;
			//
			//IKI TOTAL KABEH HARGANE
			$total_harga=array_sum($harga_array);


				$id_akun=[];
		foreach  ($jurnal as $index => $value) {
            $id_akun[$index]['kode_cabang'] = $value['asal'];
            $id_akun[$index]['total']      = $value['harga'];
           }
		$dataJurnal=$this->groupJurnal($id_akun);
		//dd($request->all());
		/*dd($dataJurnal);*/
		$indexakun=0;		
		$totalKas = str_replace(['Rp', '\\', ',', ' '], '', $request->total);
       // $totalKas = str_replace(',', '.', $request->total);
        //dd($totalKas);
$cabang='001';
 $akunKas=master_akun::
                  select('id_akun','nama_akun')
                  ->where('id_akun','like', ''.$request->kode_kas.'%')                                    
                  ->where('kode_cabang',$cabang)
                  ->orderBy('id_akun')
                  ->first();                  
             
        if(count($akunKas)!=0){
        $akun[$indexakun]['id_akun']=$akunKas->id_akun;
        $akun[$indexakun]['value']= -round($totalKas,2);
        $akun[$indexakun]['dk']='K';
        $indexakun++;      
        }
        else{
            $dataInfo=['status'=>'gagal','info'=>'Akun Kas Untuk Cabang Belum Tersedia'];
            DB::rollback();
            return json_encode($dataInfo);

        }       

		foreach ($dataJurnal as  $Nilaijurnal) { 
		       $akunBiaya=master_akun::
		                  select('id_akun','nama_akun')                  
		                  ->where('id_akun','like', ''.$akun_biaya.'%')  
		                  ->where('kode_cabang',$Nilaijurnal['kode_cabang'])
		                  ->orderBy('id_akun')
		                  ->first();  

		        if(count($akunBiaya)!=0){
		        $akun[$indexakun]['id_akun']=$akunBiaya->id_akun;
		        $akun[$indexakun]['value']=-$Nilaijurnal['total'];
		        $akun[$indexakun]['dk']='D';
		        $indexakun++;      
		        }
		        else{        	
		            $dataInfo=['status'=>'gagal','info'=>'Akun Biaya Untuk Cabang Belum Tersedia'];
		            DB::rollback();
		            return json_encode($dataInfo);

		        }       
		}



		}
		  			

		  if ($pending_status == "APPROVED") {
		  	$id_jurnal=d_jurnal::max('jr_id')+1;
                foreach ($akun as $key => $data) {   
                        $id_jrdt=$key;
                        $jurnal_dt[$key]['jrdt_jurnal']=$id_jurnal;
                        $jurnal_dt[$key]['jrdt_detailid']=$id_jrdt+1;
                        $jurnal_dt[$key]['jrdt_acc']=$data['id_akun'];
                        $jurnal_dt[$key]['jrdt_value']=$data['value'];
                        $jurnal_dt[$key]['jrdt_statusdk']=$data['dk'];
                }
            d_jurnal::create([
                        'jr_id'=>$id_jurnal,
                        'jr_year'=> date('Y'),
                        'jr_date'=> date('Y-m-d'),
                        'jr_detail'=> 'BIAYA PENERUS',
                        'jr_ref'=> $request->nofaktur,
                        'jr_note'=> 'BIAYA PENERUS',
                        ]);
            d_jurnal_dt::insert($jurnal_dt);


		  	return response()->json(['status' => '1','id'=>$cari_id[0]->bpk_id]);
		  }else{
		  	
		  	return response()->json(['status' => '2','minimal' => $total_tarif,'id'=>$cari_id[0]->bpk_id]);
		  }


		  });
	}
	public function edit(request $request){
	    $year  = Carbon::now()->format('Y'); 
		$month = Carbon::now()->format('m');  	
		$now   = Carbon::now()->format('d-m-Y');
		
	   

		$akun = DB::table('d_akun')
				  ->where('id_parrent',1001)
				  ->get();

		$akun_biaya_cargo1 = DB::table('master_persentase')
				  ->where('kode_akun','LIKE','%'.'5205'.'%')
				  ->orderBy('kode','ASC')
				  ->get();
		$akun_biaya_cargo2 = DB::table('master_persentase')
				  ->where('kode_akun','LIKE','%'.'5405'.'%')
				  ->orderBy('kode','ASC')
				  ->get();
		$akun_biaya_paket = DB::table('master_persentase')
				  ->where('kode_akun','LIKE','%'.'5305'.'%')
				  ->orderBy('kode_akun','ASC')
				  ->get();
		$angkutan = DB::table('tipe_angkutan')
				  ->get();

		$akun_biaya_cargo = array_merge($akun_biaya_cargo1,$akun_biaya_cargo2);

		$satu = count($akun_biaya_cargo1);
		$dua  = count($akun_biaya_cargo2);
		$count = $satu+$dua;
		$data = DB::table('biaya_penerus_kas')
				->where('bpk_id',$request->id)
				->get();
		$data_dt = DB::table('biaya_penerus_kas_detail')
				->where('bpkd_bpk_id',$request->id)
				->get();
		$data[0]->bpk_tanggal = Carbon::parse($data[0]->bpk_tanggal)->format('d/m/Y');

		$string_resi='';
		for ($i=0; $i < count($data_dt); $i++) { 
			$string_resi[$i] = (string)$data_dt[$i]->bpkd_no_resi;
		}
		$id_edit = $request->id;
		return view('purchase/kas/editkas',compact('id_edit','data','akun','akun_biaya_cargo','akun_biaya_cargo','akun_biaya_paket','angkutan','string_resi'));
	}
	public function update_penerus(request $request){
		// dd($request);
		$tgl = str_replace('/', '-', $request->tN);
		$tgl = Carbon::parse($tgl)->format('Y-m-d');

		$cari_persen = DB::table('master_persentase')
	    		  ->where('kode',$request->pembiayaan_paket)
	    		  ->where('cabang','001')
	    		  ->get();
	    if ($cari_persen == null) {
	    	$cari_persen = DB::table('master_persentase')
	    		  ->where('kode',$request->pembiayaan_paket)
	    		  ->where('cabang','GLOBAL')
	    		  ->get();
	    }
	    $request->biaya_dll = filter_var($request->biaya_dll, FILTER_SANITIZE_NUMBER_FLOAT);
	    $request->total_bbm = filter_var($request->total_bbm, FILTER_SANITIZE_NUMBER_FLOAT);
	    

		if ($cari_persen[0]->jenis_biaya == '4') {
			for ($i=0; $i < count($request->no_resi); $i++) { 
				$bpk = DB::table('biaya_penerus_kas_detail')
							->where('bpkd_no_resi',$request->no_resi[$i])
							->get();
				$bpk_dt[$i] = $bpk;
			}
			for ($i=0; $i < count($bpk_dt); $i++) { 
				for ($a=0; $a < count($bpk_dt[$i]); $a++) { 
					$jml[$a] = $bpk_dt[$i][$a]->bpkd_tarif_penerus;
				}
				if (isset($jml)) {
					$jml_dt[$i] = array_sum($jml);
				}
				
			}
			if (isset($jml_dt)) {
				$fix = array_sum($jml_dt);
			}else{
				$fix = 0;
			}
	
			$tot_pen = array_sum($request->penerus);
			$fix = $fix + $tot_pen;

		}else{
			$fix = array_sum($request->penerus);
		}
		$fix_tarif_penerus = array_sum($request->penerus);
		
		$persen = $cari_persen[0]->persen/100;
		$total_tarif = $request->total_tarif*$persen;

		if($fix <= $total_tarif){
			$pending_status = 'APPROVED';
		}else{
			$pending_status = 'PENDING';
		}

		if($request->jenis_pembiayaan=='PAKET'){
			$pembiayaan = $request->pembiayaan_paket;
		}else{
			$pembiayaan = $request->pembiayaan_cargo;
		}

		$id = DB::table('biaya_penerus_kas')
				->max('bpk_id');
		if($id != null){
			$id+=1;
		}else{
			$id=1;
		}
		$total_penerus_float = array_sum($request->penerus);
		// return $asd = round($request->total_bbm);

		biaya_penerus_kas::where('bpk_id',$request->id)->update([
		  	'bpk_id'      	  	 => $request->id,
		  	'bpk_nota'  	  	 => $request->no_trans,
		  	'bpk_jenis_biaya' 	 => $request->jenis_pembiayaan,
		  	'bpk_pembiayaan'  	 => $pembiayaan,
		  	'bpk_total_tarif' 	 => $request->total_tarif,
		  	'bpk_tanggal'     	 => $tgl,
		  	'bpk_nopol'		  	 => strtoupper($request->nopol),
		  	'bpk_status'	  	 => 'Released',
		  	'bpk_status_pending' => $pending_status,	
		  	'bpk_kode_akun'		 => $request->kode_kas,
		  	'bpk_sopir'		 	 => strtoupper($request->nama_sopir),
		  	'bpk_keterangan'	 => $request->note,
		  	'bpk_tipe_angkutan'  => $request->jenis_kendaraan,		
		  	'updated_at'		 => Carbon::now(),
		  	'bpk_comp'	 		 => '001',
		  	'bpk_tarif_penerus'	 => round($total_penerus_float,2),
		  	'bpk_edit'	 		 => 'UNALLOWED',
		  	'bpk_biaya_lain'	 => round($request->biaya_dll,2),
		  	'bpk_jarak'	 		 => $request->km,
		  	'bpk_harga_bbm'	     => round($request->total_bbm,2),
		  ]);
		$delete = DB::table('biaya_penerus_kas_detail')
					->where('bpkd_bpk_id',$request->id)
					->delete();

		
		 	for ($i=0; $i < count($request->no_resi); $i++) { 

				$dt = DB::table('biaya_penerus_kas_detail')
					->max('bpkd_id');
				if($dt != null){
					$dt+=1;
				}else{
					$dt=1;
				}

				biaya_penerus_kas_detail::create([
			  		'bpkd_id'				=> $dt,
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
					'bpkd_tarif_penerus'	=> round($request->penerus[$i],2),
					'updated_at'			=> Carbon::now(),
					'bpk_comp'				=> '001'

			  	]);
			}


		$cari_id = DB::table('biaya_penerus_kas')
		  			 ->where('bpk_id','=',$request->id)
		  			 ->get();

		$cari=DB::table('biaya_penerus_kas')			
					 ->join('cabang','kode','=','bpk_comp')
					 ->where('bpk_id','=',$request->id)
					 ->get();
		$cari_dt=DB::table('biaya_penerus_kas_detail')		
					 ->where('bpkd_bpk_id','=',$request->id)
					 ->get();
	    $cari_asal=DB::table('biaya_penerus_kas_detail')
	    			 ->select('bpkd_kode_cabang_awal')			
					 ->where('bpkd_bpk_id','=',$request->id)
					 ->get();

		for ($i=0; $i < count($cari_asal); $i++) { 

			$cari_asal_2[$i] = $cari_asal[$i]->bpkd_kode_cabang_awal; 
		}
		if (isset($cari_asal_2)) {
		    $unik_asal = array_unique($cari_asal_2);
		    $unik_asal = array_values($unik_asal);

		    // return $unik_asal;
		    for ($i=0; $i < count($unik_asal); $i++) { 
				for ($a=0; $a < count($cari_dt); $a++) { 
					if($cari_dt[$a]->bpkd_kode_cabang_awal==$unik_asal[$i]){
						${$unik_asal[$i]}[$a] = $cari_dt[$a]->bpkd_tarif_penerus;
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
			// IKI MAS JURNAL.E HARGA MBEK ASALE
			 // return $jurnal;
			//
			//IKI TOTAL KABEH HARGANE
			$total_harga=array_sum($harga_array);



		  if ($pending_status == "APPROVED") {
		  	return response()->json(['status' => '1']);
		  }else{
		  	return response()->json(['status' => '2','minimal' => $total_tarif]);
		 }

	}

	public function hapus($id){
		$delete = DB::table('biaya_penerus_kas')
					->where('bpk_id',$id)
					->delete();
		$delete1 = DB::table('biaya_penerus_kas_detail')
					->where('bpkd_bpk_id',$id)
					->delete();
	}
	public function buktikas(request $request){
		// dd($request);
		
		$cari_id = DB::table('biaya_penerus_kas')
		  			   ->where('bpk_id','=',$request->id)
		  			   ->get();

		$cari=DB::table('biaya_penerus_kas')			
					 ->join('cabang','kode','=','bpk_comp')
					 ->where('bpk_id','=',$request->id)
					 ->get();

		$cari_akun=DB::table('master_persentase')			
					 ->join('biaya_penerus_kas','bpk_pembiayaan','=','kode')
					 ->where('bpk_id','=',$request->id)
					 ->get();
		$cari_dt=DB::table('biaya_penerus_kas_detail')		
					 ->where('bpkd_bpk_id','=',$request->id)
					 ->get();
	    $cari_asal=DB::table('biaya_penerus_kas_detail')
	    			 ->select('bpkd_kode_cabang_awal')			
					 ->where('bpkd_bpk_id','=',$request->id)
					 ->get();

		for ($i=0; $i < count($cari_asal); $i++) { 

			$cari_asal_2[$i] = $cari_asal[$i]->bpkd_kode_cabang_awal; 
		}
		if (isset($cari_asal_2)) {
		    $unik_asal = array_unique($cari_asal_2);
		    $unik_asal = array_values($unik_asal);

		    // return $unik_asal;
		    for ($i=0; $i < count($unik_asal); $i++) { 
				for ($a=0; $a < count($cari_dt); $a++) { 
					if($cari_dt[$a]->bpkd_kode_cabang_awal==$unik_asal[$i]){
						${$unik_asal[$i]}[$a] = $cari_dt[$a]->bpkd_tarif_penerus;
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
		return view('purchase/kas/buktikas',compact('cari','harga_array','total_harga','terbilang','cari_akun'));

	}

	public function detailkas(request $request){
		$cari_id = DB::table('biaya_penerus_kas')
		  			   ->where('bpk_id','=',$request->id)
		  			   ->get();

		$cari     = DB::table('biaya_penerus_kas')			
					 ->join('cabang','kode','=','bpk_comp')
					 ->where('bpk_id','=',$request->id)
					 ->get();
		$cari_dt  = DB::table('biaya_penerus_kas_detail')	
					 ->join('kota','id','=','bpkd_asal')
					 ->where('bpkd_bpk_id','=',$request->id)
					 ->get();
	    $cari_asal=DB::table('biaya_penerus_kas_detail')
	    			 ->select('bpkd_kode_cabang_awal')			
					 ->where('bpkd_bpk_id','=',$request->id)
					 ->get();
		$tujuan   =DB::table('biaya_penerus_kas_detail')		
					 ->join('kota','id','=','bpkd_tujuan')
					 ->where('bpkd_bpk_id','=',$request->id)
					 ->orderBy('bpkd_bpk_dt','ASC')
					 ->get();

		$tgl = Carbon::parse($cari[0]->bpk_tanggal)->format('d/m/Y');

		for ($i=0; $i < count($cari_asal); $i++) { 

			$cari_asal_2[$i] = $cari_asal[$i]->bpkd_kode_cabang_awal; 
		}
		if (isset($cari_asal_2)) {
		    $unik_asal = array_unique($cari_asal_2);
		    $unik_asal = array_values($unik_asal);

		    // return $unik_asal;
		    for ($i=0; $i < count($unik_asal); $i++) { 
				for ($a=0; $a < count($cari_dt); $a++) { 
					if($cari_dt[$a]->bpkd_kode_cabang_awal==$unik_asal[$i]){
						${$unik_asal[$i]}[$a] = $cari_dt[$a]->bpkd_tarif_penerus;
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
				 $harga_array[$i] = round($harga_array[$i]);
			}
			// return $harga_array;
			$total_harga=array_sum($harga_array);
			// return $total_harga;
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

		$pdf = PDF::loadView('purchase/kas/detailkas',compact('cari','cari_dt','harga_array','total_harga','terbilang','tgl','tujuan'))
					->setPaper('a4','potrait');
			return $pdf->stream('detail-biaya-penerus-'.$cari[0]->bpk_nota.'.pdf');

	}


	public function carinopol(request $request){
			$request->term = strtoupper($request->term);
		
	        $results = array();
	        $queries = DB::table('kendaraan')
			            ->where('nopol', 'like', '%'.$request->term.'%')
			            ->take(10)->get();

	        if ($queries == null){
	            $results[] = [ 'id' => null, 'label' => 'Tidak ditemukan data terkait'];
	        } else {

	            foreach ($queries as $query)
	            {
	                $results[] = [ 'id' => $query->nopol, 'label' => $query->nopol,'validator'=>$query->nopol];
	            }
	        }

	        return Response::json($results);


		}

	public function cariresiedit(request $request){
			$cari_persen = DB::table('master_persentase')
	    		  ->where('kode',$request->pembiayaan_paket)
	    		  ->where('cabang','001')
	    		  ->get();
	    if ($cari_persen == null) {
	    	$cari_persen = DB::table('master_persentase')
	    		  ->where('kode',$request->pembiayaan_paket)
	    		  ->where('cabang','GLOBAL')
	    		  ->get();
	    }
	    
		$biaya_bbm 	  = filter_var($request->total_bbm, FILTER_SANITIZE_NUMBER_INT);
		$biaya_dll 	  = filter_var($request->biaya_dll, FILTER_SANITIZE_NUMBER_INT);
		$resi      	  = explode(' ', $request->resi);
		$resi	  	  = array_unique($resi);
		$resi	  	  = array_values($resi);
		$data     	  = [];
		$tujuan       = [];
		$total_tarif  = 0;
		$penerus      = [];
		$total_penerus= 0;
		$tipe_data    = $request->tipe_data;

		for ($i=0 ; $i < count($resi); $i++) { 

		    $bpk = DB::table('biaya_penerus_kas_detail')
				  ->join('biaya_penerus_kas','bpk_id','=','bpkd_bpk_id')
				  ->join('master_persentase','bpk_pembiayaan','=','kode')
				  ->where('bpkd_no_resi',$resi[$i])
				  ->get();


		   	$bpk_dt[$i]   = $bpk;
		}

		// return $bpk_dt;
			

		for ($i=0; $i < count($bpk_dt); $i++) { 
			if($bpk_dt[$i]!=null){
				if($bpk_dt[$i][0]->bpkd_bpk_id == $request->id){
					
				} elseif ($bpk_dt[$i][0]->jenis_biaya == '4') {

					
				}else if($bpk_dt[$i][0]->jenis_biaya == '5'){
					for ($a=0; $a < count($bpk_dt[$i]); $a++) { 
						$comp[$a] = (float)$bpk_dt[$i][$a]->bpk_tarif_penerus;
					}

					if (in_array('001',$comp)) {
						unset($resi[$i]);
					}
				}else{
					unset($resi[$i]);
				}
			}
		}
		$resi = array_values($resi);
		// return $resi;
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
			for ($i=0; $i < count($data); $i++) { 
				$total_tarif+=$data[$i][0]->tarif_dasar;
			}
			$total_tarif = round($total_tarif,2);
		 //Menjumlah bbm dan biaya lain-lain
			$kas_surabaya = $biaya_bbm + $biaya_dll;

		//menghitung tarif penerus
			for ($i=0; $i < count($data); $i++) { 
				$hasil=($kas_surabaya/$total_tarif)*$data[$i][0]->tarif_dasar;
				$penerus[$i]=round($hasil,2);
			}
		
			$total_penerus =array_sum($penerus);
			$total_penerus =round($total_penerus,2);

			return view('purchase/kas/tabelBiayakas',compact('data','tujuan','total_tarif','kas_surabaya','penerus','total_penerus','tipe_data'));
	
		}else{
			return response()->json(['status' => 0]);
		}
	}

	public function groupJurnal($data) {        
        
        $groups = array();
        $key = 0;
        
        foreach ($data as $item) {       
        $key = $item['kode_cabang']; 	
            if (!array_key_exists($key, $groups)) {                         
                $groups[$key] = array(                  
                    'kode_cabang' => $item['kode_cabang'],                    
                    'total' => $item['total'],
                );                   
            } else {                
                    $groups[$key]['total'] = $groups[$key]['total'] + $item['total'];   
                    
            }
            $key++;
        }                
        return $groups;
    }
}

?>