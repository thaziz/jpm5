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
	// START OF DOKUMEN
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
			DB::select("SELECT tarif_cabang_dokumen.*,acc.nama_akun as acc_pen,csf.nama_akun csf_pen,res.id as id_asal,res1.id as id_tujuan, res.asal,res1.tujuan 
							from tarif_cabang_dokumen 
							join (SELECT id, nama as asal from kota) as res
							on id_kota_asal = res.id
							join (SELECT id, nama as tujuan from kota) as res1
							on id_kota_tujuan = res1.id
							join d_akun as acc  on acc.id_akun=tarif_cabang_dokumen.acc_penjualan 
							join d_akun as csf  on csf.id_akun=tarif_cabang_dokumen.csf_penjualan 
							where kode = '$dat[$i]'
							order by tarif_cabang_dokumen.kode_detail ASC"); 
        }
        // dd ($dat1);
		return view('purchase/master/master_penjualan/pdf/pdf_tarifdokumen',compact('dat1'));
		
	}
	// END OF DOKUMEN
	// START OF KOLI
	public function tarif_cabang_koli(){

		$data = DB::select("SELECT tarif_cabang_koli.*,res.id as id_asal,res1.id as id_tujuan, res.asal,res1.tujuan 
							from tarif_cabang_koli
							join (SELECT id, nama as asal from kota) as res
							on id_kota_asal = res.id
							join (SELECT id, nama as tujuan from kota) as res1
							on id_kota_tujuan = res1.id");
		$ket = DB::table('tarif_cabang_koli')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$kota1 = DB::select("SELECT id, nama as asal from kota");

		return view('purchase/master/master_penjualan/laporan/tarifCabangKoli',compact('data','kota','kota1','ket'));
	}
	public function reportcabangkoli(Request $request){
		
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
			DB::select("SELECT tarif_cabang_koli.*,acc.nama_akun as acc_pen,csf.nama_akun csf_pen,res.id as id_asal,res1.id as id_tujuan, res.asal,res1.tujuan 
							from tarif_cabang_koli
							join (SELECT id, nama as asal from kota) as res
							on id_kota_asal = res.id
							join (SELECT id, nama as tujuan from kota) as res1
							on id_kota_tujuan = res1.id
							join d_akun as acc  on acc.id_akun=tarif_cabang_koli.acc_penjualan 
							join d_akun as csf  on csf.id_akun=tarif_cabang_koli.csf_penjualan 
							where kode = '$dat[$i]'
							order by tarif_cabang_koli.kode_detail_koli ASC");
        }
        // dd ($dat1);
		return view('purchase/master/master_penjualan/pdf/pdf_tarifkoli',compact('dat1'));
		
	}
	// END OF KOLI
	// START OF KARGO
	public function tarif_cabang_kargo(){

		$data = DB::select("SELECT tarif_cabang_kargo.*,t.nama as angkutan,s.nama as satuan,jt.jt_nama_tarif as jenis_tarif,res.id as id_asal,res1.id as id_tujuan, res.asal,res1.tujuan 
							from tarif_cabang_kargo
							join (SELECT id, nama as asal from kota) as res
							on id_kota_asal = res.id
							join (SELECT id, nama as tujuan from kota) as res1
							on id_kota_tujuan = res1.id
							join tipe_angkutan as t on t.kode=tarif_cabang_kargo.kode_angkutan
							join satuan as s on s.kode=tarif_cabang_kargo.kode_satuan
							join jenis_tarif as jt on jt.jt_id=tarif_cabang_kargo.jenis
							order by tarif_cabang_kargo.kode_detail_kargo ASC ");

		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$kota1 = DB::select("SELECT id, nama as asal from kota");
		$ang = DB::table('tipe_angkutan')->get();
		$sat = DB::table('satuan')->get();
		$jt = DB::table('jenis_tarif')->get();

		return view('purchase/master/master_penjualan/laporan/tarifCabangKargo',compact('data','kota','kota1','ang','sat','jt'));
	}
	public function reportcabangkargo(Request $request){
		
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
			 DB::select("SELECT tarif_cabang_kargo.*,acc.nama_akun as acc_pen,csf.nama_akun csf_pen,t.nama as angkutan,s.nama as satuan,jt.jt_nama_tarif as jenis_tarif,res.id as id_asal,res1.id as id_tujuan, res.asal,res1.tujuan 
							from tarif_cabang_kargo
							join (SELECT id, nama as asal from kota) as res
							on id_kota_asal = res.id
							join (SELECT id, nama as tujuan from kota) as res1
							on id_kota_tujuan = res1.id
							join tipe_angkutan as t on t.kode=tarif_cabang_kargo.kode_angkutan
							join satuan as s on s.kode=tarif_cabang_kargo.kode_satuan
							join jenis_tarif as jt on jt.jt_id=tarif_cabang_kargo.jenis
							join d_akun as acc  on acc.id_akun=tarif_cabang_kargo.acc_penjualan 
							join d_akun as csf  on csf.id_akun=tarif_cabang_kargo.csf_penjualan 
							where tarif_cabang_kargo.kode = '$dat[$i]'
							order by tarif_cabang_kargo.kode_detail_kargo ASC ");
        }
        // dd ($dat1);
		return view('purchase/master/master_penjualan/pdf/pdf_tarifkargo',compact('dat1'));
		
	}
	// END OF KARGO
	//START OF KILOGRAM
	public function tarif_cabang_kilogram(){

		$data = DB::select("SELECT kilo.*,res.id as id_asal,res1.id as id_tujuan, res.asal,res1.tujuan 
							from tarif_cabang_kilogram kilo
							join (SELECT id, nama as asal from kota) as res
							on id_kota_asal = res.id
							join (SELECT id, nama as tujuan from kota) as res1
							on id_kota_tujuan = res1.id");
		$ket = DB::table('tarif_cabang_kilogram')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$kota1 = DB::select("SELECT id, nama as asal from kota");

		return view('purchase/master/master_penjualan/laporan/tarifCabangkilogram',compact('data','kota','kota1','ket'));
	}
	public function reportcabangkilogram(Request $request){
		
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
			DB::select("SELECT kilo.*,acc.nama_akun as acc_pen,csf.nama_akun csf_pen,res.id as id_asal,res1.id as id_tujuan, res.asal,res1.tujuan 
							from tarif_cabang_kilogram kilo
							join (SELECT id, nama as asal from kota) as res
							on id_kota_asal = res.id
							join (SELECT id, nama as tujuan from kota) as res1
							on id_kota_tujuan = res1.id
							join d_akun as acc on acc.id_akun=kilo.acc_penjualan 
							join d_akun as csf on csf.id_akun=kilo.csf_penjualan 
							where kode = '$dat[$i]'
							order by kilo.kode_detail_kilo ASC");
        }
        // dd ($dat1);
		return view('purchase/master/master_penjualan/pdf/pdf_tarifkilogram',compact('dat1'));
		
	}
	// END OF KILOGRAM
	// START OF SEPEDA
	public function tarif_cabang_sepeda(){

		$data = DB::select("SELECT spd.*,res.id as id_asal,res1.id as id_tujuan, res.asal,res1.tujuan 
							from tarif_cabang_sepeda spd
							join (SELECT id, nama as asal from kota) as res
							on id_kota_asal = res.id
							join (SELECT id, nama as tujuan from kota) as res1
							on id_kota_tujuan = res1.id");
		$ket = DB::table('tarif_cabang_sepeda')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$kota1 = DB::select("SELECT id, nama as asal from kota");

		return view('purchase/master/master_penjualan/laporan/tarifCabangsepeda',compact('data','kota','kota1','ket'));
	}
	public function reportcabangsepeda(Request $request){
		
		$data = $request->a;	
   		// dd($data[0]);
   		$dat = '';
		for ($save=0; $save <count($data) ; $save++) { 
			$dat = $dat.','.$data[$save];

		}
		$dat =explode(',', $dat); 
		json_encode($dat);
        for ($i=1; $i <count($dat); $i++) { 
		
		$dat1[$i] = DB::select("SELECT spd.*,acc.nama_akun as acc_pen,csf.nama_akun csf_pen,res.id as id_asal,res1.id as id_tujuan, res.asal,res1.tujuan 
							from tarif_cabang_sepeda spd
							join (SELECT id, nama as asal from kota) as res
							on id_kota_asal = res.id
							join (SELECT id, nama as tujuan from kota) as res1
							on id_kota_tujuan = res1.id
							join d_akun as acc on acc.id_akun=spd.acc_penjualan 
							join d_akun as csf on csf.id_akun=spd.csf_penjualan 
							where kode = '$dat[$i]'
							");
			}
        // dd($dat1);
		return view('purchase/master/master_penjualan/pdf/pdf_tarifsepeda',compact('dat1'));
		
	}
	// END OF SEPEDA



//START DELIVERY ORDER LAPORAN PAKET(DO)

	public function deliveryorder(){
		$data =DB::table('delivery_order as do')
						->select('do.*','ka.id as kaid','kt.id as ktid','ka.nama as asal','kt.nama as tujuan','kc.nama as kecamatan')
						->join('kota as ka','do.id_kota_asal','=','ka.id')
						->join('kota as kt','do.id_kota_tujuan','=','kt.id')
						->join('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
						->where('nomor','like','%PAK%')
						->get();
		$ket = DB::table('tarif_cabang_sepeda')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$kota1 = DB::select("SELECT id, nama as asal from kota");
		return view('purchase/master/master_penjualan/laporan/lap_deliveryorder_paket',compact('data','kota','kota1','ket'));
	}
	public function reportdeliveryorder(Request $request){
		// return 'a';
		$data = $request->a;	
   		// dd($data[0]);
   		$dat = '';
		for ($save=0; $save <count($data) ; $save++) { 
			$dat = $dat.','.$data[$save];

		}
		$dat =explode(',', $dat); 
		json_encode($dat);
        for ($i=1; $i <count($dat); $i++) { 
		
		$dat1[$i] = DB::table('delivery_order as do')
						->select('do.*','ka.id as kaid','kt.id as ktid','ka.nama as asal','kt.nama as tujuan','kc.nama as kecamatan')
						->join('kota as ka','do.id_kota_asal','=','ka.id')
						->join('kota as kt','do.id_kota_tujuan','=','kt.id')
						->join('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
						->where('nomor','=',$dat[$i])
						->get();
			}
        // dd($dat1);
		return view('purchase/master/master_penjualan/pdf/pdf_deliveryorder_paket',compact('dat1'));
		
	}
// END OF DELIVERY ORDER LAPORAN PAKET(DO)
   
   //START DELIVERY ORDER LAPORAN KARGO(DO)

	public function deliveryorder_kargo(){
		$data =DB::table('delivery_order as do')
						->select('do.*','ka.id as kaid','kt.id as ktid','ka.nama as asal','kt.nama as tujuan','kc.nama as kecamatan')
						->join('kota as ka','do.id_kota_asal','=','ka.id')
						->join('kota as kt','do.id_kota_tujuan','=','kt.id')
						->join('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
						->where('nomor','like','%KGO%')
						->get();
		$ket = DB::table('tarif_cabang_sepeda')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$kota1 = DB::select("SELECT id, nama as asal from kota");
		return view('purchase/master/master_penjualan/laporan/lap_deliveryorder_kargo',compact('data','kota','kota1','ket'));
	}
	public function reportdeliveryorder_kargo(Request $request){
		// return 'a';
		$data = $request->a;	
   		// dd($data[0]);
   		$dat = '';
		for ($save=0; $save <count($data) ; $save++) { 
			$dat = $dat.','.$data[$save];

		}
		$dat =explode(',', $dat); 
		json_encode($dat);
        for ($i=1; $i <count($dat); $i++) { 
		
		$dat1[$i] = DB::table('delivery_order as do')
						->select('do.*','ka.id as kaid','kt.id as ktid','ka.nama as asal','kt.nama as tujuan','kc.nama as kecamatan')
						->join('kota as ka','do.id_kota_asal','=','ka.id')
						->join('kota as kt','do.id_kota_tujuan','=','kt.id')
						->join('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
						->where('nomor','=',$dat[$i])
						->get();
			}
        // dd($dat1);
		return view('purchase/master/master_penjualan/pdf/pdf_deliveryorder_kargo',compact('dat1'));
		
	}
// END OF DELIVERY ORDER LAPORAN KARGO(DO)

	//START DELIVERY ORDER LAPORAN KORAN(DO)

	public function deliveryorder_koran(){
		// return 'a';
		$data =DB::table('delivery_order as do')
						->select('do.*','dk.*')
						->join('delivery_orderd as dk','do.nomor','=','dk.dd_nomor')
						->where('do.nomor','like','%KTS%')
						->get();
		$ket = DB::table('tarif_cabang_sepeda')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$sat = DB::table('satuan')->get();
		$kota1 = DB::select("SELECT id, nama as asal from kota");
		return view('purchase/master/master_penjualan/laporan/lap_deliveryorder_koran',compact('data','kota','kota1','ket','sat'));
	}
	public function reportdeliveryorder_koran(Request $request){
		// return 'a';
		$data = $request->a;	
   		// dd($data[0]);
   		$dat = '';
		for ($save=0; $save <count($data) ; $save++) { 
			$dat = $dat.','.$data[$save];

		}
		$dat =explode(',', $dat); 
		json_encode($dat);
        for ($i=1; $i <count($dat); $i++) { 
		
		$dat1[$i] = DB::table('delivery_order as do')
						->select('do.*','dk.*')
						->join('delivery_orderd as dk','do.nomor','=','dk.dd_nomor')
						->where('nomor','=',$dat[$i])
						->get();
			}
        // dd($dat1);
		return view('purchase/master/master_penjualan/pdf/pdf_deliveryorder_koran',compact('dat1'));
		
	}
// END OF DELIVERY ORDER LAPORAN KORAN(DO)

   // START INVOICE

	public function invoice(){
		// return 'a';
		$data = DB::table('invoice')->get();
		$ket = DB::table('tarif_cabang_sepeda')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$cus = DB::table('customer')->get();
		$kota1 = DB::select("SELECT id, nama as asal from kota");
		return view('purchase/master/master_penjualan/laporan/lap_invoice',compact('data','kota','kota1','ket','cus'));
	}
		public function reportinvoice(Request $request){
		// return 'a';
		$data = $request->a;	
   		// dd($data[0]);
   		$dat = '';
		for ($save=0; $save <count($data) ; $save++) { 
			$dat = $dat.','.$data[$save];

		}
		$dat =explode(',', $dat); 
		json_encode($dat);
        for ($i=1; $i <count($dat); $i++) { 
		
		$dat1[$i] = DB::table('invoice')->get();
			}
        // dd($dat1);
		return view('purchase/master/master_penjualan/pdf/pdf_invoice',compact('dat1'));
		
	}


	// END OF INVOICE

	//START KWITANSI

		public function kwitansi(){
		// return 'a';
		$data = DB::table('kwitansi')->join('customer','customer.kode','=','kwitansi.k_kode_customer')->get();
		$ket = DB::table('tarif_cabang_sepeda')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$cus = DB::table('customer')->get();
		$kota1 = DB::select("SELECT id, nama as asal from kota");
		return view('purchase/master/master_penjualan/laporan/lap_kwitansi',compact('data','kota','kota1','ket','cus'));
	}
		public function reportkwitansi(Request $request){
		// return 'a';
		$data = $request->a;	
   		// dd($data[0]);
   		$dat = '';
		for ($save=0; $save <count($data) ; $save++) { 
			$dat = $dat.','.$data[$save];

		}
		$dat =explode(',', $dat); 
		json_encode($dat);
        for ($i=1; $i <count($dat); $i++) { 
		
		$dat1[$i] = DB::table('kwitansi')->join('customer','customer.kode','=','kwitansi.k_kode_customer')->get();
			}
        // dd($dat1);
		return view('purchase/master/master_penjualan/pdf/pdf_kwitansi',compact('dat1'));
		
	}

	// END OF KWITANSI

//========================== GARIS KERJAS MABRO ===================================//
   }
?>