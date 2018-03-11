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
				 ->join('master_jenis_biaya','mjb_id','=','jenis_biaya')
				 ->orderBy('kode','asc')
				 ->get();
		$akun = DB::table('d_akun')
				  ->where('id_parrent',5)
				  ->get();
		$cabang = DB::table('cabang')
				  ->get();

		$jenis_bayar = DB::table('master_jenis_biaya')
				  ->get();
		return view('master_biaya.indexpresentase',compact('data','akun','cabang','jenis_bayar'));
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

		$id = DB::table('master_persentase')
				->max('kode');

		if ($id != null ) {
			$id += 1;
		}else{
			$id = 1;
		}

		$request->persentase = round($request->persentase,2);
		$save = DB::table('master_persentase')
				  ->insert([
				  		'kode'		=>	$id,
				  		'nama'		=>  strtoupper($request->biaya),
				  		'persen'	=>  $request->persen,
				  		'cabang'	=>  $request->cabang,
				  		'kode_akun' =>  $request->akun,
				  		'keterangan'=>  strtoupper($request->ket),
				  		'jenis_biaya'=>  $request->jb
				  	]);
	}

	public function hapus(request $request){
		$hapus = DB::table('master_persentase')
				   ->where('kode',$request->id)
				   ->delete();
		$status = 1;
		return Redirect::back()->with('status');
	}
	public function dropdown(request $request){
		if ($request->id == 'GLOBAL') {
			$data = DB::table('d_akun')
				  ->where('id_parrent',5)
				  ->get();
		}else{
			$data = DB::table('d_akun')
				  ->where('kode_cabang',$request->id)
				  ->where('id_parrent','LIKE','%'.'5'.'%')
				  ->whereRaw('LENGTH(id_parrent) > ?', [1])
				  ->get();
		}

		


		return view('master_biaya/dropdown',compact('data'));
	}
	public function update(request $request){
		// dd($request);
		$update = DB::table('master_persentase')
					->where('kode',$request->kode)
					->update([
						'nama'		=>  strtoupper($request->biaya),
				  		'persen'	=>  $request->persen,
				  		'cabang'	=>  $request->cabang,
				  		'kode_akun' =>  $request->akun,
				  		'keterangan'=>  strtoupper($request->ket),
				  		'jenis_biaya'=>  $request->jb

					]);
	}
	

}

?>