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
use Auth;

class LaporanMasterController extends Controller
{
	public function tarif_cabang_dokumen(){

		/*return*/ $data = DB::select("SELECT tarif_cabang_dokumen.*,res.id as id_asal,res1.id as id_tujuan, res.asal,res1.tujuan 
							from tarif_cabang_dokumen 
							join (SELECT id, nama as asal from kota) as res
							on id_kota_asal = res.id
							join (SELECT id, nama as tujuan from kota) as res1
							on id_kota_tujuan = res1.id
							");

		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$kota1 = DB::select("SELECT id, nama as asal from kota");

		return view('purchase/master/master_penjualan/laporan/tarifCabangDokumen',compact('data','kota','kota1'));
	}
	public function tabledokumen(request $request){
		dd($request);

	}
	public function reportcabangdokumen(Request $request){
		
		// dd($request->all());
		$data = $request->a;	
   		// dd($data[0]);
   		$dat = '';
		for ($save=0; $save <count($data) ; $save++) { 
			$dat = $dat.','.$data[$save];

		}
		$dat =explode(',', $dat); 
		json_encode($dat);
        for ($i=1; $i <count($dat) ; $i++) { 
			$dat1[$i] =
			DB::select("SELECT tarif_cabang_dokumen.*,res.id as id_asal,res1.id as id_tujuan, res.asal,res1.tujuan 
							from tarif_cabang_dokumen 
							join (SELECT id, nama as asal from kota) as res
							on id_kota_asal = res.id
							join (SELECT id, nama as tujuan from kota) as res1
							on id_kota_tujuan = res1.id
							where kode = '$dat[$i]'
							order by tarif_cabang_dokumen.kode_detail ASC"); 
        }
		return view('purchase/master/master_penjualan/pdf/pdf_tarifdokumen',compact('dat1'));
		
	}

	public function tarif_cabang_koli(){

		$data = DB::select("SELECT tarif_cabang_koli.*,res.id as id_asal,res1.id as id_tujuan, res.asal,res1.tujuan 
							from tarif_cabang_koli
							join (SELECT id, nama as asal from kota) as res
							on id_kota_asal = res.id
							join (SELECT id, nama as tujuan from kota) as res1
							on id_kota_tujuan = res1.id");

		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$kota1 = DB::select("SELECT id, nama as asal from kota");

		return view('purchase/master/master_penjualan/laporan/tarifCabangKoli',compact('data','kota','kota1'));
	}

	public function tarif_cabang_kargo(){

		$data = DB::select("SELECT tarif_cabang_kargo.*,res.id as id_asal,res1.id as id_tujuan, res.asal,res1.tujuan 
							from tarif_cabang_kargo
							join (SELECT id, nama as asal from kota) as res
							on id_kota_asal = res.id
							join (SELECT id, nama as tujuan from kota) as res1
							on id_kota_tujuan = res1.id");

		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$kota1 = DB::select("SELECT id, nama as asal from kota");

		return view('purchase/master/master_penjualan/laporan/tarifCabangKargo',compact('data','kota','kota1'));
	}
}
 ?>