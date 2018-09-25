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
			$data['bankmasuk'] = DB::select("select * from bank_masuk where bm_cabangtujuan = '$cabang' and bm_status = 'DITRANSFER' or bm_status = 'DITERIMA'  order by bm_id desc");
			$data['belumdiproses'] = DB::table("bank_masuk")->where([['bm_status' , '=' , 'DITRANSFER'],['bm_cabangasal' , '=' , '$cabang']])->count();
			$data['sudahdiproses'] = DB::table("bank_masuk")->where([['bm_status' , '=' , 'DITERIMA'],['bm_cabangasal' , '=' , '$cabang']])->count();
		}
		
		

		return view('purchase/bankmasuk/index', compact('data'));
	}


	public function create(){
		$data['cabang'] = DB::select("select * from cabang");		
		$data['bank'] = DB::select("select * from masterbank");
		return view('purchase/bankmasuk/create' , compact('data'));
	}

	public function getdata(Request $request){
			$ref = $request->ref;
			$data['bank'] = DB::select("select * from bank_masuk where bm_id = '$ref'");

			return json_encode($data);
	}

	public function saveterima(Request $request){

		return DB::transaction(function() use ($request){  
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


		$databm = DB::select("select * from bank_masuk where bm_id = '$id'");
		$idfpgb = $databm[0]->bm_idfpgb;

		$datafpg = DB::select("select * from fpg, fpg_cekbank where fpgb_idfpg = idfpg and fpgb_id = '$idfpgb'");
		$keterangan = $datafpg[0]->fpg_keterangan;

		if($dkaasal == 'D'){ //banktujuan
			$jurnaldt[0]['id_akun'] = $banktujuan;
			$jurnaldt[0]['subtotal'] = $nominal;
			$jurnaldt[0]['dk'] = 'D';
			$jurnaldt[0]['detail'] = $keterangan;
		}
		else {
			$jurnaldt[0]['id_akun'] = $banktujuan;
			$jurnaldt[0]['subtotal'] = '-' . $nominal;
			$jurnaldt[0]['dk'] = 'K';
			$jurnaldt[0]['detail'] = $keterangan;
		}

		if($dkaasal == 'K'){//bankasal
			$jurnaldt[1]['id_akun'] = $bankasal;
			$jurnaldt[1]['subtotal'] = $nominal;
			$jurnaldt[1]['dk'] = 'D';
			$jurnaldt[1]['detail'] = $keterangan;
		}
		else {
			$jurnaldt[1]['id_akun'] = $bankasal;
			$jurnaldt[1]['subtotal'] = '-' . $nominal;
			$jurnaldt[1]['dk'] = 'K';
			$jurnaldt[1]['detail'] = $keterangan;
		}

		

		$lastidjurnald = DB::table('d_jurnal')->max('jr_id'); 
		if(isset($lastidjurnald)) {
			$idjurnald = $lastidjurnald;
			$idjurnald = (int)$idjurnald + 1;
		}
		else {
			$idjurnald = 1;
		}


		$cabang = $request->cabangtujuan;
		$databank = DB::select("select * from masterbank where mb_kode = '$banktujuan'");
		$kodebankd = $databank[0]->mb_id;
		//JREF
		$jr_no = get_id_jurnal('BM' , $kodebankd, $cabang , $tgl);

		$ref = explode("-", $jr_no);


		if($kodebankd < 10){
			$kodebankd = '0' . $kodebankd;
		}	
		else {
			$kodebankd = $kodebankd;
		}

		$kode = $ref[0] . $kodebankd;
		$jr_ref = $kode . '-' . $ref[1];
		//ENDHRREF

		$cabang = $request->cabangtujuan;
		$notabm = getnotabm($cabang , $tgl , $kodebankd);
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
        $jurnal->jr_note = $keterangan;
        $jurnal->jr_no = $jr_no;
        $jurnal->save();





    $key = 1;
	for($j = 0; $j < count($jurnaldt); $j++){
	
		$jurnaldts = new d_jurnal_dt();
		$jurnaldts->jrdt_jurnal = $idjurnald;
		$jurnaldts->jrdt_detailid = $key;
		$jurnaldts->jrdt_acc = $jurnaldt[$j]['id_akun'];
		$jurnaldts->jrdt_value = $jurnaldt[$j]['subtotal'];
		$jurnaldts->jrdt_statusdk = $jurnaldt[$j]['dk'];
		$jurnaldts->jrdt_detail = $jurnaldt[$j]['detail'];
		$jurnaldts->save();
		$key++;
	}	


		 $cekjurnal = check_jurnal($notabm);
        if($cekjurnal == 0){
          $dataInfo =  $dataInfo=['status'=>'gagal','info'=>'Data Jurnal Tidak Balance :('];
        DB::rollback();
                          
        }
        elseif($cekjurnal == 1) {
          $dataInfo =  $dataInfo=['status'=>'sukses','info'=>'Data Jurnal Balance :)'];
                  
        } 
         // $dataInfo =  $dataInfo=['status'=>'sukses','info'=>'Data Jurnal Balance :)'];


			return json_encode($dataInfo);
	});
	}
}
