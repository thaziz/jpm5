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
use App\masterbank;
use App\purchase_orderr;
use App\purchase_orderdt;
use App\stock_mutation;
use App\stock_gudang;
use App\penerimaan_barang;
use App\penerimaan_barangdt;
use App\fakturpembelian;
use App\fakturpembeliandt;
use App\tb_master_pajak;
use App\tb_coa;
use App\jenisbayar;
use App\tb_jurnal;
use App\tandaterima;
use App\formfpg;
use App\formfpg_dt;
use App\formfpg_bank;
use App\masterbank_dt;
use App\v_hutang;
use App\ikhtisar_kas;
use App\barang_terima;
use App\bukti_bank_keluar;
use App\bukti_bank_keluar_dt;
use App\bukti_bank_keluar_biaya;
use App\master_akun;
Use App\d_jurnal;
use App\cndn;
use App\cndn_dt;
Use App\d_jurnal_dt;
use App\fakturpajakmasukan;
use App\uangmukapembelian_fp;
use App\uangmukapembeliandt_fp;
use DB;
Use Carbon\Carbon;
use Session;
use Mail;
use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;
use Auth;
use App\bonsempengajuan;
use Yajra\Datatables\Datatables;

class BonSementaraController extends Controller
{
	public function index(){
		$cabang = session::get('cabang');
		if(Auth::user()->punyaAkses('Bon Sementara Cabang','all') || Auth::user()->punyaAkses('Bon Sementara Kabang','all') ){
			$data['bonsem'] = DB::select("select * from bonsem_pengajuan, cabang where bp_cabang = kode order by bp_id desc");
		}
		else {
			$data['bonsem'] = DB::select("select * from bonsem_pengajuan, cabang where bp_cabang = '$cabang' and bp_cabang = kode order by bp_id desc");
		}
		
		
		/*$data['bank'] = DB::select("select * from masterbank where mb_cabangbank = '$cabang'");*/

		return view('purchase/bonsementara/indexcabang', compact('data'));
	}

	public function table(Request $request){		  
  		  $tgl='';  		  
  		  $nomor='';  		  
  		  $tgl1=date('Y-m-d',strtotime($request->tanggal1));
  		  $tgl2=date('Y-m-d',strtotime($request->tanggal2));
  		  
  		  if($request->tanggal1!='' && $request->tanggal2!=''){  		  	
  		  	$tgl="and bp_tgl >= '$tgl1' AND bp_tgl <= '$tgl2'";
  		  }
  		  
  		  if($request->nomor!=''){
  		  	$nomor="and bp_nota='$request->nomor'";
  		  }  		  
		 $cabang = session::get('cabang');
		 $data='';


		if(Auth::user()->punyaAkses('Bon Sementara Cabang','all') || Auth::user()->punyaAkses('Bon Sementara Kabang','all') ){
			$data= DB::select("select *,'no' as no from bonsem_pengajuan, cabang where bp_cabang = kode  $tgl $nomor  order by bp_id desc");
		}
		else {
			$data= DB::select("select *,'no' as no from bonsem_pengajuan, cabang where bp_cabang = '$cabang' and bp_cabang = kode $tgl $nomor order by bp_id desc");
		}
		$dataFpg=collect($data);


		return 
			DataTables::of($dataFpg)->
			editColumn('bp_tgl', function ($dataFpg) {            
            	return date('d-m-Y',strtotime($dataFpg->bp_tgl));
            })
            ->editColumn('bp_nominal', function ($dataFpg) { 
                return number_format($dataFpg->bp_nominal, 2);                
            })->editColumn('bp_nominalkacab', function ($dataFpg) { 
                if($dataFpg->bp_nominalkacab == null){
                    return '<span class="label label-info"> BELUM DI PROSES </span>';
                 }else{
                    return number_format($dataFpg->bp_nominalkeu ,2);
                 }

            })
            ->editColumn('status_pusat', function ($dataFpg) { 
                return '<span class="label label-success"> '.$dataFpg->status_pusat.'</span>';
            })   
            ->editColumn('status_pusat', function ($dataFpg) { 
                return '<span class="label label-success"> '.$dataFpg->status_pusat.'</span>';
            })     
            ->addColumn('proseskacab', function ($dataFpg) { 
               	if(Auth::user()->PunyaAkses('Bon Sementara Kabang','aktif')){
                     return '<button type="button" class="btn btn-sm btn-primary" onclick="kacab('.$dataFpg->bp_id.')" data-toggle="modal" data-target="#myModal2">  PROSES KACAB </button>';
                }

            })     
            ->editColumn('bp_statusend', function ($dataFpg) {               
				if(Auth::user()->PunyaAkses('Bon Sementara Kabang','aktif')){
                    if($dataFpg->bp_statusend == 'CAIR') {
                         return '<button class="btn btn-sm btn-danger" onclick="uangterima('.$dataFpg->bp_id.')" data-toggle="modal" data-target="#modaluangterima"> <i class="fa fa-money"> </i> Terima Uang ? </button>';
                    }
                 }

            })     
            ->editColumn('bp_setujukacab', function ($dataFpg) {  
            	$bp_setujukacab='';             
				if(Auth::user()->PunyaAkses('Bon Sementara Cabang','aktif')){
                    if($dataFpg->bp_setujukacab != 'SETUJU'){
                       $bp_setujukacab.= '<button class="btn btn-warning btn-sm" onclick="editform('.$dataFpg->bp_id.')" data-toggle="modal" data-target="#myModaledit"> <i class="fa fa-pencil"> </i>  </button>
                            <button class="btn btn-danger btn-sm" onclick="hapusData('.$dataFpg->bp_id.')"> <i class="fa fa-trash"> </i> </button>';
                    }else{
                        if($dataFpg->status_pusat == 'UANG DI TERIMA'){
                         $bp_setujukacab.= '<button onclick="lihatjurnal('.$dataFpg->bp_nota or null.',"BON SEMENTARA")" class=" btn btn-xs btn-primary"> <i class="fa fa-eye"> </i> Jurnal </button>';
                    	}
                    }

                }
                return $bp_setujukacab;
            })    



 



  


            ->addColumn('action', function ($dataFpg) {            	
            	$html='';
            	   
            	$html.='<a class="btn btn-success btn-sm" 
            			href='.url('bonsementarapusat/printdata/'.$dataFpg->bp_id.'').'>
            	 <i class="fa fa-print"> </i> Cetak  </a>';
            	return $html;           
            })
			->make(true);	

		    


                          

                             

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

	public function create(){
		$data['cabang'] = DB::select("select * from cabang");


		return view('purchase/bonsementara/createcabang' , compact('data'));	
	}

	public function printdata($id){
		$data['bonsem'] = DB::select("select * from bonsem_pengajuan where bp_id = '$id'");
		$data['terbilang'] = $this->terbilang($data['bonsem'][0]->bp_nominalkeu);
		return view('purchase/bonsementara/print_bon_sementara' , compact('data'));
	}

	public function getnota(Request $request){
		$cabang = $request->comp;
		$tgl = $request->tgl;
		$bulan = Carbon::parse($tgl)->format('m');
        $tahun = Carbon::parse($tgl)->format('y');

      
		//return $mon;
		$idbp = DB::select("select * from bonsem_pengajuan where bp_cabang = '$cabang'  and to_char(bp_tgl, 'MM') = '$bulan' and to_char(bp_tgl, 'YY') = '$tahun' order by bp_id desc limit 1");

	//	$idspp =   spp_purchase::where('spp_cabang' , $request->comp)->max('spp_id');
		if(count($idbp) != 0) {
		
			$explode = explode("/", $idbp[0]->bp_nota);
			$idspp = $explode[2];
			
			$string = (int)$idspp + 1;
			$data['idspp'] = str_pad($string, 4, '0', STR_PAD_LEFT);
		}

		else {
		
			$data['idspp'] = '0001';
		}

		$data['nota'] =  'BS' . $bulan . $tahun . '/' . $cabang . '/' .  $data['idspp'];
		$datacabang = DB::select("select * from cabang where kode = '$cabang'");
		
		$data['namacabang'] = $datacabang[0]->nama;


		return json_encode($data);
	}


	public function savecabang(Request $request){
		return DB::transaction(function() use ($request) { 
			$cabang = $request->cabang;
		$nota = $request->nonota;
		$keperluan = $request->keperluan;
		$bagian = $request->bagian;
		$tgl = $request->tgl;
		$nominal = str_replace(",", "", $request->nominal);


		/*return $cabang;*/
		$bp = new bonsempengajuan();

		$dataid = DB::select("select max(bp_id) as bp_id from bonsem_pengajuan");

		if(count($dataid) == 0){
			$id = 1;
		}
		else {
			$id = (int)$dataid[0]->bp_id + 1;
		}

		$db = DB::select("select * from d_akun where id_akun LIKE '1002%' and kode_cabang = '$cabang'");
		$idakun = $db[0]->id_akun;


		$databonsem = DB::select("select * from bonsem_pengajuan where bp_nota = '$nota'");
			if(count($databonsem) != 0){
					$explode = explode("/", $databonsem[0]->bp_nota);
					$idbonsem = $explode[2];
				
					$idbonsem = (int)$idbonsem + 1;
					$akhirbonsem = str_pad($idbonsem, 4, '0', STR_PAD_LEFT);
					$nobonsem = $explode[0] .'/' . $explode[1] . '/'  . $akhirbonsem;
			}
			else {
				$nobonsem = $nota;
			}

		
		$bp->bp_id = $id;
		$bp->bp_cabang = $cabang;
		$bp->bp_nominal = $nominal;
		$bp->bp_keperluan = strtoupper($keperluan);
		$bp->bp_bagian = strtoupper($bagian);
		$bp->bp_tgl = $tgl;
		$bp->bp_nota = $nobonsem;
		$bp->status_pusat = 'DITERBITKAN';
		$bp->created_by = $request->username;
		$bp->updated_by = $request->username;
		$bp->bp_akunhutang = $idakun;
		$bp->bp_pencairan = 0.00;
	
		$bp->save();

		return json_encode('sukses');
		});		
	}

	public function jurnalumum(Request $request){
		$id = $request->nota;
		$detail = $request->detail;
		$data['jurnal'] = collect(\DB::select("SELECT id_akun,nama_akun,jd.jrdt_value,jd.jrdt_statusdk as dk, jrdt_detail
                        FROM d_akun a join d_jurnal_dt jd
                        on a.id_akun=jd.jrdt_acc and jd.jrdt_jurnal in 
                        (select j.jr_id from d_jurnal j where jr_ref='$id' and jr_detail = '$detail')")); 
		$data['countjurnal'] = count($data['jurnal']);
 		return json_encode($data);
	}

	public function terimauang(Request $request){
			return DB::transaction(function() use ($request) { 

			$idbonsem = $request->idbonsem;
			$kodebank = $request->bankcabang;
			$updatepb = bonsempengajuan::find($idbonsem);
			$updatepb->bp_terima = 'DONE';
			$updatepb->status_pusat = 'UANG DI TERIMA';
			$updatepb->save();

			

			
			$nominalkeu = str_replace(",", "", $request->nominalkeu);
			$datapb = DB::select("select * from bonsem_pengajuan where bp_id = '$idbonsem'");

			$datajurnal = [];
		    $totalhutang = 0;
		    $cabangpb = $datapb[0]->bp_cabang;

		    $akunbank = $request->bankcabang;
		    $dataakunbank = DB::select("select * from d_akun where id_akun LIKE '1001%' and kode_cabang = '$cabangpb'");
		    $bankdka = $dataakunbank[0]->akun_dka;
		    $akunkaskecil = $dataakunbank[0]->id_akun;

		    if($bankdka == 'D'){
		    	$datajurnal[0]['idakun'] = $akunkaskecil;
			    $datajurnal[0]['subtotal'] = $nominalkeu;
			    $datajurnal[0]['dk'] = 'D';
			    $datajurnal[0]['detail'] = $datapb[0]->bp_keperluan;
		    }
		    else {
		    	$datajurnal[0]['idakun'] = $akunkaskecil;
			    $datajurnal[0]['subtotal'] = '-' . $nominalkeu;
			    $datajurnal[0]['dk'] = 'D';
			    $datajurnal[0]['detail'] = $datapb[0]->bp_keperluan;
		    }

		    $bonsemcabang = $datapb[0]->bp_akunhutang;
		    $dataakunhutang = DB::select("select * from d_akun where id_akun = '$bonsemcabang'");
		    $hutangdka = $dataakunhutang[0]->akun_dka;
		    	
		    if($hutangdka == 'K'){
			    $datajurnal[1]['idakun'] = $datapb[0]->bp_akunhutang;
			    $datajurnal[1]['subtotal'] = $nominalkeu;
			    $datajurnal[1]['dk'] = 'K';
			    $datajurnal[1]['detail'] = $datapb[0]->bp_keperluan;
		    }
		    else {
		    	$datajurnal[1]['idakun'] = $datapb[0]->bp_akunhutang;
			    $datajurnal[1]['subtotal'] = '-' . $nominalkeu;
			    $datajurnal[1]['dk'] = 'K';
			    $datajurnal[1]['detail'] = $datapb[0]->bp_keperluan;
		    }


		
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
	        $jurnal->jr_detail = 'BON SEMENTARA';
	        $jurnal->jr_ref = $datapb[0]->bp_nota;
	        $jurnal->jr_note = $datapb[0]->bp_keperluan;
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
    			$jurnaldt->jrdt_acc = $datajurnal[$j]['idakun'];
    			$jurnaldt->jrdt_value = $datajurnal[$j]['subtotal'];
    			$jurnaldt->jrdt_statusdk = $datajurnal[$j]['dk'];
    			$jurnaldt->jrdt_detail = $datajurnal[$j]['detail'];
    			$jurnaldt->save();
    			$key++;
    		} 
    		return json_encode('sukses');
    	});
			
	}

	public function setujukacab(Request $request){
		return DB::transaction(function() use ($request) { 
			$idpb = $request->idpb;

			$data['pb']= DB::select("select * from bonsem_pengajuan, cabang where bp_id = '$idpb' and bp_cabang = kode");
			$cabang = $data['pb'][0]->bp_cabang;

			$akuncabang = DB::select("select * from d_akun where id_akun LIKE '1001%' and kode_cabang = '$cabang'");
			$idakun = $akuncabang[0]->id_akun;

			$month = date('m');
			
			$data['kaskecil'] = DB::select("select * from d_akun_saldo where id_akun = '$idakun' and bulan = '$month'");

			return json_encode($data);
		});
	}

	public function setujukeu(Request $request){
		return DB::transaction(function() use ($request) { 
			$idpb = $request->idpb;

			$data['pb']= DB::select("select * from bonsem_pengajuan, cabang where bp_id = '$idpb' and bp_cabang = kode");
			$cabang = $data['pb'][0]->bp_cabang;

			$akuncabang = DB::select("select * from d_akun where id_akun LIKE '1001%' and kode_cabang = '$cabang'");
			$idakun = $akuncabang[0]->id_akun;

			$month = date('m');
			
			$data['kaskecil'] = DB::select("select * from d_akun_saldo where id_akun = '$idakun' and bulan = '$month'");


			return json_encode($data);
		});
	}

	public function updatecabang(Request $request){
		return DB::transaction(function() use ($request) {
			$id = $request->idpb;

			$nominal = str_replace(",", "", $request->nominal);
			$date = date("Y-m-d");
			$updatepb = bonsempengajuan::find($id);
			$updatepb->bp_nominal = $nominal;
			$updatepb->bp_bagian = $request->bagian;
			$updatepb->bp_keperluan = $request->keperluan;
			$updatepb->bp_tgl = $request->tgl;
			$updatepb->updated_by = $request->username;
			$updatepb->save();
			
			return json_encode('sukses');
		});
	}


	public function hapuscabang($id){

		DB::delete("DELETE FROM bonsem_pengajuan where bp_id = '$id'");
		return 'sukses';
	}

	public function updatekacab(Request $request){
		return DB::transaction(function() use ($request) {
			$id = $request->idpb;
			$nominal = str_replace(",", "", $request->nominal);
			$date = date("Y-m-d");
			$updatepb = bonsempengajuan::find($id);
			$updatepb->bp_nominalkacab = $nominal;
			$updatepb->bp_setujukacab = $request->statuskacab;
			$updatepb->bp_keterangankacab = $request->keterangankacab;
			$updatepb->time_setujukacab = $date;
			if($request->statuskacab == 'TIDAK SETUJU') {
				$updatepb->status_pusat = "TIDAK DISETUJUI KACAB"; 
			}
			else {
				$updatepb->status_pusat = 'DISETUJUI KACAB';
			}

			$updatepb->save();

			return json_encode('sukses');
		});
	}

	public function updateadmin(Request $request){
		return DB::transaction(function() use ($request) {
			$id = $request->idpb;

			$nominal = str_replace(",", "", $request->nominal);
			$date = date("Y-m-d");
			$updatepb = bonsempengajuan::find($id);
			$updatepb->bp_nominaladmin = $nominal;
			$updatepb->bp_setujuadmin = $request->statuskacab;
			$updatepb->time_setujukacab = $date;
			if($request->statuskacab == 'TIDAK SETUJU') {
				$updatepb->status_pusat = "TIDAK DISETUJUI PUSAT"; 
			}
			else {
				$updatepb->status_pusat = 'DITERIMA PUSAT';
			}
			
			$updatepb->time_setujuadmin = $date;
			$updatepb->bp_keteranganadmin = $request->keteranganadmin;
			$updatepb->save();

			return json_encode('sukses');
		});		
	}

	public function updatekeu(Request $request){
		return DB::transaction(function() use ($request) {
			$id = $request->idpb;

			$nominal = str_replace(",", "", $request->nominal);
			$date = date("Y-m-d");
			$updatepb = bonsempengajuan::find($id);
			$updatepb->bp_nominalkeu = $nominal;
			$updatepb->bp_setujukeu = $request->statuskacab;
			//$updatepb->status_pusat = 'DISETUJUI MENKEU';
			
			if($request->statuskacab == 'TIDAK SETUJU') {
				$updatepb->status_pusat = "TIDAK DISETUJUI MENKEU"; 
			}
			else {
				$updatepb->status_pusat = 'DISETUJUI MENKEU';
			}
			$updatepb->bp_pelunasan = $nominal;
			$updatepb->bp_sisapemakaian = $nominal;
			$updatepb->time_setujukeu = $date;
			$updatepb->save();


			$nominalkeu =  str_replace(',', '', $request->nominalkeu);
			$now = Date("Y-m-d");
			if(floatval($nominalkeu) < 10000000.00){

				$tiga = 3;
				$temp = 1;
				for($i = 0;$i < $tiga; $i++){
					$tigahari = date('Y-m-d', strtotime($now . " +  {$temp} days"));
					
					$day = date('D' , strtotime($tigahari));
					
					if($day != 'Sun'){
						
					}
					else {
						$tiga = $tiga + 1;
					}

					$temp++;
				}
			}
			else if(floatval($nominalkeu) > 10000000.00){
				$tiga = 7;
				$temp = 1;
				for($i = 0;$i < $tiga; $i++){
					$tigahari = date('Y-m-d', strtotime($now . " +  {$temp} days"));
					
					$day = date('D' , strtotime($tigahari));
					
					if($day != 'Sun'){
						
					}
					else {
						$tiga = $tiga + 1;
					}

					$temp++;
				}

			}

			$updatepb = bonsempengajuan::find($id);
			$updatepb->bp_jatuhtempo = $tigahari;
			$updatepb->bp_keteranganpusat = $request->keteranganpusat;
			$updatepb->save();
			return json_encode('sukses');
		});
	}

	public function indexpusat(){
			$data['adminbelumdiproses'] = DB::table("bonsem_pengajuan")->whereNull('bp_setujuadmin')->where('bp_setujukacab' , '=' , 'SETUJU')->count();
			$data['mankeubelumproses'] = DB::table("bonsem_pengajuan")->whereNull('bp_setujukeu')->where('bp_setujukacab' , '=' , 'SETUJU')->count();
			$data['pencairan'] = DB::table("bonsem_pengajuan")->where('status_pusat' , '=' , 'PENCAIRAN')->count();
			$data['selesai'] = DB::table("bonsem_pengajuan")->where('status_pusat' , '=' , 'SELESAI')->count();

		/*$data['pb'] = DB::select("select * from bonsem_pengajuan, cabang where bp_setujukacab = 'SETUJU' and bp_cabang = kode order by bp_id desc");*/

		return view('purchase/bonsementara/indexpusat' , compact('data'));
	}

	public function indexpusattable(Request $request){		  
  		  $tgl='';  		  
  		  $nomor='';  		  
  		  $tgl1=date('Y-m-d',strtotime($request->tanggal1));
  		  $tgl2=date('Y-m-d',strtotime($request->tanggal2));
  		  
  		  if($request->tanggal1!='' && $request->tanggal2!=''){  		  	
  		  	$tgl="and bp_tgl >= '$tgl1' AND bp_tgl <= '$tgl2'";
  		  }
  		  
  		  if($request->nomor!=''){
  		  	$nomor="and bp_nota='$request->nomor'";
  		  }  		  
		 $cabang = session::get('cabang');
		 $data='';

		$data=DB::select("select *,'no' as no from bonsem_pengajuan, cabang where bp_setujukacab = 'SETUJU' and bp_cabang = kode $tgl $nomor order by bp_id desc");

		$dataFpg=collect($data);
		return 
			DataTables::of($dataFpg)->
			editColumn('bp_tgl', function ($dataFpg) {            
            	return date('d-m-Y',strtotime($dataFpg->bp_tgl));
            })
            ->editColumn('bp_nominalkacab', function ($dataFpg) { 
                return number_format($dataFpg->bp_nominalkacab, 2);                       
            })->editColumn('bp_nominaladmin', function ($dataFpg) { 
            	$bp_nominaladmin='';
               	if($dataFpg->bp_nominaladmin == null){
                       $bp_nominaladmin.='<span class="label label-info"> BELUM DI PROSES </span>';
                }else{
                	   $bp_nominaladmin.=number_format($dataFpg->bp_nominaladmin, 2);
                }
                return $bp_nominaladmin;                

            })
            ->editColumn('bp_nominalkeu', function ($dataFpg) { 
            	$bp_nominalkeu='';
                if($dataFpg->bp_nominalkeu == null){
                    $bp_nominalkeu.='<span class="label label-info"> BELUM DI PROSES </span>';
                }else{
                    $bp_nominalkeu.=number_format($dataFpg->bp_nominalkeu, 2);                
                }

            })   
            ->editColumn('status_pusat', function ($dataFpg) { 
                return '<span class="label label-info"> '.$dataFpg->status_pusat.'</span>';
            })     
            ->addColumn('prosesmodal', function ($dataFpg) { 
            	$prosesmodal='';
               	if(Auth::user()->PunyaAkses('Bon Sementara Pusat','aktif')){
                 	$prosesmodal.='<button type="button" class="btn btn-sm btn-primary" onclick="setujuadmin('.$dataFpg->bp_id.')" data-toggle="modal" data-target="#myModal2">  ADMIN PUSAT  </button>';
                }

                if(Auth::user()->PunyaAkses('Bon Sementara Menkeu','aktif')){
                    if($dataFpg->bp_setujuadmin == 'SETUJU'){
                        $prosesmodal.='<button type="button" class="btn btn-sm btn-primary" onclick="setujukeu('.$dataFpg->bp_id.')" data-toggle="modal" data-target="#myModalMenkeu">  MANAGER KEUANGAN  </button>';
                    }
                }


            })     
            ->addColumn('action', function ($dataFpg) {            	
             return '<a class="btn btn-success btn-sm"
             href='.url('bonsementarapusat/printdata/'.$dataFpg->bp_id.'').'><i class="fa fa-print"> </i> Cetak  </a>';
            })
			->make(true);	


                       
                           
                          
                      

		
	}

	public function indexpusatnotif(){
			$data['adminbelumdiproses'] = DB::table("bonsem_pengajuan")->whereNull('bp_setujuadmin')->where('bp_setujukacab' , '=' , 'SETUJU')->count();
			$data['mankeubelumproses'] = DB::table("bonsem_pengajuan")->whereNull('bp_setujukeu')->where('bp_setujukacab' , '=' , 'SETUJU')->count();
			$data['pencairan'] = DB::table("bonsem_pengajuan")->where('status_pusat' , '=' , 'PENCAIRAN')->count();
			$data['selesai'] = DB::table("bonsem_pengajuan")->where('status_pusat' , '=' , 'SELESAI')->count();

		$data['pb'] = DB::select("select * from bonsem_pengajuan, cabang where bp_setujukacab = 'SETUJU' and bp_cabang = kode order by bp_id desc");

		return view('purchase/bonsementara/indexpusat' , compact('data'));
	}


	

	

}
