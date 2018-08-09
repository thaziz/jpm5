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

class BonSementaraController extends Controller
{
	public function index(){


		$data['bonsem'] = DB::select("select * from bonsem_pengajuan, cabang where bp_cabang = kode order by bp_id desc");
		
		$data['bank'] = DB::select("select * from masterbank");

		return view('purchase/bonsementara/indexcabang', compact('data'));
	}

	public function create(){
		$data['cabang'] = DB::select("select * from cabang");


		return view('purchase/bonsementara/createcabang' , compact('data'));	
	}

	public function getnota(Request $request){
		$cabang = $request->comp;
		$bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('y');

      
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
	
		$bp->save();

		return json_encode('sukses');
		});		
	}

	public function terimauang(Request $request){
			$idbonsem = $request->idbonsem;
			$kodebank = $request->bankcabang;
			$updatepb = bonsempengajuan::find($idbonsem);
			$updatepb->bp_terima = 'DONE';
			$updatepb->save();



			$datajurnal = [];
		    $totalhutang = 0;
		    $datajurnal[0]['idakun'] = $request->bankcabang;
		    $datajurnal[0]['subtotal'] =

			return 'sukses';

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
			if($request->bp_setujuadmin == 'TIDAK SETUJU') {
				$updatepb->status_pusat = "TIDAK DISETUJUI PUSAT"; 
			}
			else {
				$updatepb->status_pusat = 'DITERIMA PUSAT';
			}
			
			$updatepb->time_setujuadmin = $date;
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
			
			if($request->bp_setujukeu == 'TIDAK SETUJU') {
				$updatepb->status_pusat = "TIDAK DISETUJUI MENKEU"; 
			}
			else {
				$updatepb->status_pusat = 'DISETUJUI MENKEU';
			}
			$updatepb->bp_pelunasan = $nominal;

			$updatepb->time_setujukeu = $date;
			$updatepb->save();

			return json_encode('sukses');
		});
	}

	public function indexpusat(){
			$data['adminbelumdiproses'] = DB::table("bonsem_pengajuan")->whereNull('bp_setujuadmin')->where('bp_setujukacab' , '=' , 'SETUJU')->count();
			$data['mankeubelumproses'] = DB::table("bonsem_pengajuan")->whereNull('bp_setujukeu')->where('bp_setujukacab' , '=' , 'SETUJU')->count();
			$data['pencairan'] = DB::table("bonsem_pengajuan")->where('status_pusat' , '=' , 'PENCAIRAN')->count();
			$data['selesai'] = DB::table("bonsem_pengajuan")->where('status_pusat' , '=' , 'SELESAI')->count();

		$data['pb'] = DB::select("select * from bonsem_pengajuan, cabang where bp_setujukacab = 'SETUJU' and bp_cabang = kode order by bp_id desc");

		return view('purchase/bonsementara/indexpusat' , compact('data'));
	}

	

}
