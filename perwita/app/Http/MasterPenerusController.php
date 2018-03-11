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
use App\tb_master_pajak;
use App\tb_coa;
use App\tb_jurnal;
use DB;
use Redirect;
use Response;
Use Carbon\Carbon;
use Session;
use Mail;
use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;

class MasterPenerusController extends Controller
{
	public function bbm(){
		$data = DB::table('master_bbm')
				 ->orderBy('mb_id','asc')
				 ->get();
		
		return view('master_biaya.indexbbm',compact('data'));
	}
	public function bbm_update($a, $b, $c){
		DB::table('master_bbm')
		  ->where('mb_id','=',$a)
		  ->update([
		  		'mb_nama' => $b,
		  		'mb_harga'=> $c
		  ]);
		 return '1';
	}

	public function presentase(){
		$data = DB::table('master_persentase')
				 ->orderBy('kode','asc')
				 ->get();
		$akun = DB::table('d_akun')
				  ->where('id_parrent',5)
				  ->get();
		$cabang = DB::table('cabang')
				  ->get();
		return view('master_biaya.indexpresentase',compact('data','akun','cabang'));
	}
	public function presentase_update($a, $b, $c){

		DB::table('master_persentase')
		  ->where('kode','=',$a)
		  ->update([
		  		'persen'=> $c
		  ]);
		 return '1';
	}
	public function tambah(request $request){
		// dd($request);
		$save = DB::table('master_persentase')
				  ->insert([
				  		'kode'		=>	strtoupper($request->kode_persen),
				  		'nama'		=>  $request->pembiayaan,
				  		'persen'	=>  $request->persentase,
				  		'cabang'	=>  $request->cabang,
				  		'kode_akun' =>  $request->nama_akun,
				  		'keterangan'=>  strtoupper($request->keterangan)
				  	]);
	}

	public function hapus(request $request){
		return Redirect::back();
	}
	

}

?>