<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\masterItemPurchase;
use App\masterGroupItemPurchase;
use App\master_department;
use App\masterGudangPurchase;
use App\masterSupplierPurchase;
use Carbon\Carbon;
use PDF;
use DB;


class LaporanMasterController extends Controller
{
	public function tarif_cabang_dokumen(){

		$data = DB::select("SELECT tarif_cabang_dokumen.*, res.asal,res1.tujuan 
							from tarif_cabang_dokumen 
							join (SELECT id, nama as asal from kota) as res
							on id_kota_asal = res.id
							join (SELECT id, nama as tujuan from kota) as res1
							on id_kota_tujuan = res1.id");

		$kota = DB::select("SELECT id, nama as tujuan from kota");

		return view('purchase/master/master_penjualan/laporan/tarifCabangDokumen',compact('data','kota'));
	}
	public function tabledokumen(request $request){
		dd($request);

	}

	public function tarif_cabang_koli(){

		$data = DB::select("SELECT tarif_cabang_koli.*, res.asal,res1.tujuan 
							from tarif_cabang_koli
							join (SELECT id, nama as asal from kota) as res
							on id_kota_asal = res.id
							join (SELECT id, nama as tujuan from kota) as res1
							on id_kota_tujuan = res1.id");

		$kota = DB::select("SELECT id, nama as tujuan from kota");

		return view('purchase/master/master_penjualan/laporan/tarifCabangKoli',compact('data','kota'));
	}

	public function tarif_cabang_kargo(){

		$data = DB::select("SELECT tarif_cabang_kargo.*, res.asal,res1.tujuan 
							from tarif_cabang_kargo
							join (SELECT id, nama as asal from kota) as res
							on id_kota_asal = res.id
							join (SELECT id, nama as tujuan from kota) as res1
							on id_kota_tujuan = res1.id");

		$kota = DB::select("SELECT id, nama as tujuan from kota");

		return view('purchase/master/master_penjualan/laporan/tarifCabangKargo',compact('data','kota'));
	}
}
 ?>