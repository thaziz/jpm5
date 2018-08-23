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
use App\bank_masuk;

class BankMasukController extends Controller
{

	public function bankmasuk(){
		$cabang = session::get('cabang');
		if(Auth::user()->punyaAkses('Bank Masuk','all')) {
			$data['bankmasuk'] = DB::select("select * from bank_masuk where  bm_status = 'DITRANSFER' or bm_status = 'DITERIMA' order by bm_id desc");
			$data['belumdiproses'] = DB::table("bank_masuk")->where('bm_status' , '=' , 'DITRANSFER')->count();
			$data['sudahdiproses'] = DB::table("bank_masuk")->where('bm_status' , '=' , 'DITERIMA')->count();
		}
		else {
			$data['bankmasuk'] = DB::select("select * from bank_masuk, masterbank where bm_cabangasal = $cabang and bm_status = 'DITRANSFER' or bm_status = 'DITERIMA' and bm_bankasal = mb_kode or bm_banktujuan = mb_kode order by bm_id desc");
			$data['belumdiproses'] = DB::table("bank_masuk")->where([['bm_status' , '=' , 'DITRANSFER'],['bm_cabangasal' , '=' , '$cabang']])->count();
			$data['sudahdiproses'] = DB::table("bank_masuk")->where([['bm_status' , '=' , 'DITERIMA'],['bm_cabangasal' , '=' , '$cabang']])->count();
		}
		
		

		return view('purchase/bankmasuk/index', compact('data'));
	}

	public function getdata(Request $request){
			$ref = $request->ref;
			$data['bank'] = DB::select("select * from bank_masuk where bm_id = '$ref'");

			return json_encode($data);
	}

	public function saveterima(Request $request){
		$id = $request->id;
		$nominal = str_replace(",", "", $request->nominal);
		$tgl = $request->tgl;

		
		$update = DB::table('bank_masuk')
				->where('bm_id' , $id)
				->update([
					'bm_tglterima' => $tgl,
					'bm_status' => 'DITERIMA',
				]);

		$bankasal = $request->bankasal;
		$dkaasal2 = DB::select("select * from d_akun where id_akun = '$bankasal'");
		$dkaasal = $dkaasal2[0]->akun_dka;
		$jurnaldt = []; 

		$banktujuan = $request->banktujuan;
		$dkatujuan2 = DB::select("select * from d_akun where id_akun = '$banktujuan'");
		$dkatujuan = $dkatujuan2[0]->akun_dka;


		if($dkaasal == 'K'){//bankasal
			$jurnaldt[1]['id_akun'] = $bankasal;
			$jurnaldt[1]['subtotal'] = $nominal;
			$jurnaldt[1]['dk'] = 'K';
			$jurnaldt[1]['detail'] = '';
		}
		else {
			$jurnaldt[1]['id_akun'] = $bankasal;
			$jurnaldt[1]['subtotal'] = '-' . $nominal;
			$jurnaldt[1]['dk'] = 'K';
			$jurnaldt[1]['detail'] = '';
		}

		if($dkaasal == 'D'){ //banktujuan
			$jurnaldt[0]['id_akun'] = $banktujuan;
			$jurnaldt[0]['subtotal'] = $nominal;
			$jurnaldt[0]['dk'] = 'D';
			$jurnaldt[0]['detail'] = '';
		}
		else {
			$jurnaldt[0]['id_akun'] = $banktujuan;
			$jurnaldt[0]['subtotal'] = '-' . $nominal;
			$jurnaldt[0]['dk'] = 'D';
			$jurnaldt[0]['detail'] = '';
		}

		$lastidjurnald = DB::table('d_jurnal')->max('jr_id'); 
		if(isset($lastidjurnald)) {
			$idjurnald = $lastidjurnald;
			$idjurnald = (int)$idjurnald + 1;
		}
		else {
			$idjurnald = 1;
		}


		$cabang = $request->cabangasal;

		//JREF
		$jr_no = get_id_jurnal('BM' , $cabang);

		$ref = explode("-", $jr_no);

		$databank = DB::select("select * from masterbank where mb_kode = '$bankasal'");
		$kodebankd = $databank[0]->mb_id;

	

		if($kodebankd < 10){
			$kodebankd = '0' . $kodebankd;
		}	
		else {
			$kodebankd = $kodebankd;
		}

		$kode = $ref[0] . $kodebankd;
		$jr_ref = $kode . '-' . $ref[1];
		//ENDHRREF

		$cabang = $request->cabangasal;
		$notabm = getnotabm($cabang);
		$refbm = explode("-", $notabm);

		$kodebankd = $databank[0]->mb_id;
		if($kodebankd < 10){
			$kodebankd = '0' . $kodebankd;
		}	
		else {
			$kodebankd = $kodebankd;
		}

		$kode = $refbm[0] . $kodebankd;
		$notabm = $kode . '-' . $refbm[1];

		$update = DB::table('bank_masuk')
				->where('bm_id' , $id)
				->update([
					'bm_nota' => $notabm,
					
				]);

		$year = date('Y');	
		$date = date('Y-m-d');
		$jurnal = new d_jurnal();
		$jurnal->jr_id = $idjurnald;
        $jurnal->jr_year = date('Y');
        $jurnal->jr_date = date('Y-m-d');
        $jurnal->jr_detail = 'BUKTI BANK MASUK';
        $jurnal->jr_ref = $notabm;
        $jurnal->jr_note = '';
        $jurnal->jr_no = $jr_no;
        $jurnal->save();




    $key = 1;
	for($j = 0; $j < count($jurnaldt); $j++){
			$lastidjurnaldt = DB::table('d_jurnal')->max('jr_id'); 
		if(isset($lastidjurnaldt)) {
			$idjurnaldt = $lastidjurnaldt;
			$idjurnaldt = (int)$idjurnaldt + 1;
		}
		else {
			$idjurnaldt = 1;
		}

		$jurnaldt = new d_jurnal_dt();
		$jurnaldt->jrdt_jurnal = $idjurnald;
		$jurnaldt->jrdt_detailid = $key;
		$jurnaldt->jrdt_acc = $jurnaldt[$j]['id_akun'];
		$jurnaldt->jrdt_value = $jurnaldt[$j]['subtotal'];
		$jurnaldt->jrdt_statusdk = $jurnaldt[$j]['dk'];
		$jurnaldt->jrdt_detail = $jurnaldt[$j]['detail'];
		$jurnaldt->save();
		$key++;
	}

	return json_encode('ok');
	}
}