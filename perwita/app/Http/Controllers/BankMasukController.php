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

class BankMasukController extends Controller
{

	public function bankmasuk(){
		$cabang = session::get('cabang');
		if(Auth::user()->punyaAkses('Bank Masuk','all')) {
			$data['bankmasuk'] = DB::select("select * from bank_masuk, cabang where bm_cabangasal = kode and bm_status = 'DITRANSFER' order by bm_id desc");
			$data['belumdiproses'] = DB::table("bank_masuk")->where('bm_status' , '=' , 'DITRANSFER')->count();
			$data['sudahdiproses'] = DB::table("bank_masuk")->where('bm_status' , '=' , 'DITERIMA')->count();
		}
		else {
			$data['bankmasuk'] = DB::select("select * from bank_masuk, cabang where bm_cabangasal = $cabang and bm_status = 'DITRANSFER' order by bm_id desc");
			$data['belumdiproses'] = DB::table("bank_masuk")->where([['bm_status' , '=' , 'DITRANSFER'],['bm_cabangasal' , '=' , '$cabang']])->count();
			$data['sudahdiproses'] = DB::table("bank_masuk")->where([['bm_status' , '=' , 'DITERIMA'],['bm_cabangasal' , '=' , '$cabang']])->count();
		}
		
	

		return view('purchase/bankmasuk/index', compact('data'));
	}

}
