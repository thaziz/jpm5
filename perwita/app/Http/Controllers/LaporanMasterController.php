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
														
//❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤ LAPORAN OPERASIONAL PENJUALAN ❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤
								

	// START OF DOKUMEN
	public function tarif_cabang_dokumen(){

		$data = DB::select("SELECT tarif_cabang_dokumen.*,res.id as id_asal,res1.id as id_tujuan, res.asal,res1.tujuan 
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
		
		$dat1[$i] = DB::table('invoice')->where('i_nomor','=',$dat[$i])->get();
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
		
		$dat1[$i] = DB::table('kwitansi')->join('customer','customer.kode','=','kwitansi.k_kode_customer')->where('k_nomor','=',$dat[$i])->get();
			}
        // dd($dat1);
		return view('purchase/master/master_penjualan/pdf/pdf_kwitansi',compact('dat1'));
		
	}

	// END OF KWITANSI

	//START invoice_lain

		public function invoice_lain(){
		// return 'a';
		$data = DB::table('invoice_lain')->join('customer','customer.kode','=','invoice_lain.kode_customer')->get();
		$ket = DB::table('tarif_cabang_sepeda')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$cus = DB::table('customer')->get();
		$kota1 = DB::select("SELECT id, nama as asal from kota");
		return view('purchase/master/master_penjualan/laporan/lap_invoice_lain',compact('data','kota','kota1','ket','cus'));
	}
		public function reportinvoice_lain(Request $request){
		// return 'a';
		// dd($request);
		$data = $request->a;	
   		// dd($data[0]);
   		$dat = [];
		for ($save=0; $save <count($data) ; $save++) { 
			// $dat = $dat.','.$data[$save];
			array_push($dat,$data[$save]);
		}
		json_encode($dat);
        for ($i=0; $i <count($dat); $i++) { 
				$dat1[$i] =  DB::table('invoice_lain')->join('customer','customer.kode','=','invoice_lain.kode_customer')->where('nomor','=',$dat[$i])->get();
		}
			// return $dat1;
        // dd($dat1);
		return view('purchase/master/master_penjualan/pdf/pdf_invoice_lain',compact('dat1'));
		
	}

	// END OF invoice_lain

	//START CNDN

		public function cndn(){
		// return 'a';
		$data = DB::table('cn_dn_penjualan')->join('cn_dn_penjualan_d','cn_dn_penjualan_d.cdd_nomor_invoice','=','cn_dn_penjualan.cd_nomor')->join('customer','cn_dn_penjualan.cd_customer','=','customer.kode')->get();
		$ket = DB::table('tarif_cabang_sepeda')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$cus = DB::table('customer')->get();
		$kota1 = DB::select("SELECT id, nama as asal from kota");
		return view('purchase/master/master_penjualan/laporan/lap_CNDN',compact('data','kota','kota1','ket','cus'));
	}
		public function reportcndn(Request $request){
		// return 'a';
		$data = $request->a;	
		// dd($request);
   		// dd($data[0]);
   		$dat = [];
		for ($save=0; $save <count($data) ; $save++) { 
			array_push($dat, $data[$save]);
		}
		json_encode($dat);
        for ($i=0; $i <count($dat); $i++) { 
		
		$dat1[$i] = DB::table('cn_dn_penjualan')->join('invoice','invoice.i_nomor','=','cn_dn_penjualan.cd_invoice')->where('cd_nomor','=',$dat[$i])->get();
			}
        // dd($dat1);	
		return view('purchase/master/master_penjualan/pdf/pdf_cndn',compact('dat1'));
		
	}

	// END OF CNDN

	//START uangmuka

		public function uangmuka(){
		// return 'a';
		$data = DB::table('uang_muka_penjualan')->join('customer','customer.kode','=','uang_muka_penjualan.kode_customer')->get();
		$cus = DB::table('customer')->get();
		return view('purchase/master/master_penjualan/laporan/lap_uang_muka',compact('data','kota','kota1','ket','cus'));
		}
		public function reportuangmuka(Request $request){
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
		
		$dat1[$i] = DB::table('uang_muka_penjualan')->join('customer','customer.kode','=','uang_muka_penjualan.kode_customer')->get();
			}
        // dd($dat1);
		return view('purchase/master/master_penjualan/pdf/pdf_uang_muka',compact('dat1'));
		
	}

	// END OF uangmuka

	//START posting_bayar

		public function posting_bayar(){
		// return 'a';
		$data = DB::table('posting_pembayaran')->get();
		$ket = DB::table('tarif_cabang_sepeda')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$cus = DB::table('customer')->get();
		$kota1 = DB::select("SELECT id, nama as asal from kota");
		return view('purchase/master/master_penjualan/laporan/lap_posting_bayar',compact('data','kota','kota1','ket','cus'));
	}
		public function reportposting_bayar(Request $request){
		$data = $request->a;	
   		$dat = '';
		for ($save=0; $save <count($data) ; $save++) { 
			$dat = $dat.','.$data[$save];

		}
		$dat =explode(',', $dat); 
		json_encode($dat);
        for ($i=1; $i <count($dat); $i++) { 
		
		$dat1[$i] = DB::table('posting_pembayaran')->get();
			}
		return view('purchase/master/master_penjualan/pdf/pdf_posting_bayar',compact('dat1'));
		
	}

	// END OF posting_bayar




//❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤ END OFLAPORAN OPERASIONAL PENJUALAN ❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤//





//★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
								//★★★★★★★★★★★★★★★ GARIS KERJAS MABRO ★★★★★★★★★★★★★★★★★★//
//★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★





													
//➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥ LAPORAN MASTER BERSAMA ➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥//

							
		//LAPORAN BERSAMA
		public function lap_bersama(){
			return view('purchase/master_bersama/lap_laporan_utama');
		}
		//END OF

		//LAPORAN PAJAK 
		public function lap_pajak(){
			$data = DB::table('pajak')->get();
			return view('purchase/master_bersama/lap_pajak/lap_pajak',compact('data'));
		}	
		public function report_pajak(Request $request){
			$data = $request->a;	
		   		$dat = [];
					for ($save=0; $save <count($data) ; $save++) { 
						array_push($dat,$data[$save]);
					} 
				json_encode($dat);
	        for ($i=0; $i <count($dat); $i++) { 
			$dat1[$i] = DB::table('pajak')->where('kode','=',$dat[$i])->get();
			}
			// dd($dat1);
		return view('purchase/master_bersama/lap_pajak/report_pajak',compact('dat1'));
		}

		//END OF 


		//LAPORAN PROVINSI 
		public function lap_provinsi(){
			$data = DB::table('provinsi')->get();
			return view('purchase/master_bersama/lap_provinsi/lap_provinsi',compact('data'));
		}	
		public function report_provinsi(Request $request){
			$data = $request->a;	
		   		$dat = [];
					for ($save=0; $save <count($data) ; $save++) { 
						array_push($dat,$data[$save]);
					} 
				json_encode($dat);
	        for ($i=0; $i <count($dat); $i++) { 
			$dat1[$i] = DB::table('provinsi')->where('id','=',$dat[$i])->get();
			}
			// dd($dat1);
		return view('purchase/master_bersama/lap_provinsi/report_provinsi',compact('dat1'));
		}
		//END OF


		//LAPORAN KOTA 
		public function lap_kota(){
			$array = DB::table('kota')->select('kota.*','provinsi.nama as prov')->join('provinsi','provinsi.id','=','kota.id_provinsi')->get();
			return view('purchase/master_bersama/lap_kota/lap_kota',compact('array'));
		}	
		public function report_kota(Request $request){
			$data = $request->a;	
		   		$dat = [];
					for ($save=0; $save <count($data) ; $save++) { 
						array_push($dat,$data[$save]);
					} 
				json_encode($dat);
	        for ($i=0; $i <count($dat); $i++) { 
			$dat1[$i] = DB::table('kota')->select('kota.*','provinsi.nama as prov')->join('provinsi','provinsi.id','=','kota.id_provinsi')->where('kota.id','=',$dat[$i])->get();
			}
			// dd($dat1);
		return view('purchase/master_bersama/lap_kota/report_kota',compact('dat1'));
		}
		//END OF


		//LAPORAN KECAMATAN 
		public function lap_kecamatan(){
			$data = DB::table('kecamatan')->select('kota.nama as kota','kecamatan.*')->join('kota','kota.id','=','kecamatan.id_kota')->get();
			return view('purchase/master_bersama/lap_kecamatan/lap_kecamatan',compact('data'));
		}	
		public function report_kecamatan(Request $request){
			$data = $request->a;	
		   		$dat = [];
					for ($save=0; $save <count($data) ; $save++) { 
						array_push($dat,$data[$save]);
					} 
				json_encode($dat);
	        for ($i=0; $i <count($dat); $i++) { 
			$dat1[$i] = DB::table('kecamatan')->select('kota.nama as kota','kecamatan.*')->join('kota','kota.id','=','kecamatan.id_kota')->where('kecamatan.id','=',$dat[$i])->get();
			}
			// dd($dat1);
		return view('purchase/master_bersama/lap_kecamatan/report_kecamatan',compact('dat1'));
		}
		//END OF


		//LAPORAN CABANG 
		public function lap_cabang(){
			$data = DB::table('cabang')->select('kota.nama as kota','cabang.*')->join('kota','kota.id','=','cabang.id_kota')->get();
			return view('purchase/master_bersama/lap_cabang/lap_cabang',compact('data'));
		}	
		public function report_cabang(Request $request){
			$data = $request->a;	
		   		$dat = [];
					for ($save=0; $save <count($data) ; $save++) { 
						array_push($dat,$data[$save]);
					} 
				json_encode($dat);
	        for ($i=0; $i <count($dat); $i++) { 
			$dat1[$i] = DB::table('cabang')->select('kota.nama as kota','cabang.*')->join('kota','kota.id','=','cabang.id_kota')->where('cabang.kode','=',$dat[$i])->get();
			}
			// dd($dat1);
		return view('purchase/master_bersama/lap_cabang/report_cabang',compact('dat1'));
		}
		//END OF


		//LAPORAN TIPE ANGKUTAN 
		public function lap_tipeangkutan(){
			$data = DB::table('tipe_angkutan')->get();
			return view('purchase/master_bersama/lap_tipeangkutan/lap_tipeangkutan',compact('data'));
		}	
		public function report_tipeangkutan(Request $request){
			$data = $request->a;	
		   		$dat = [];
					for ($save=0; $save <count($data) ; $save++) { 
						array_push($dat,$data[$save]);
					} 
				json_encode($dat);
	        for ($i=0; $i <count($dat); $i++) { 
			  $dat1[$i] = DB::table('tipe_angkutan')->where('kode','=',$dat[$i])->get();
			}
		return view('purchase/master_bersama/lap_tipeangkutan/report_tipeangkutan',compact('dat1'));
		}
		//END OF


		//LAPORAN TIPE KENDARAAN 
		public function lap_kendaraan(){
			$data = DB::table('kendaraan')->get();
			return view('purchase/master_bersama/lap_kendaraan/lap_kendaraan',compact('data'));
		}	
		public function report_kendaraan(Request $request){
			$data = $request->a;	
		   		$dat = [];
					for ($save=0; $save <count($data) ; $save++) { 
						array_push($dat,$data[$save]);
					} 
				json_encode($dat);
	        for ($i=0; $i <count($dat); $i++) { 
			  $dat1[$i] = DB::table('kendaraan')->where('id','=',$dat[$i])->get();
			}
		return view('purchase/master_bersama/lap_kendaraan/report_kendaraan',compact('dat1'));
		}
		//END OF



								
//➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥ END OF LAPORAN MASTER BERSAMA ➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥//



//➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥ LAPORAN MASTER DO ➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥//


		//LAPORAN SEMUA DO 
		public function lap_semuado(){
			return view('purchase/master_do/lap_semuado',compact('data'));
		}	
		//END OF



		//LAPORAN AGEN 
		public function lap_agen(){
			$data = DB::table('agen')->get();
			return view('purchase/master_do/lap_agen/lap_agen',compact('data'));
		}	
		public function report_agen(Request $request){
			$data = $request->a;	
		   		$dat = [];
					for ($save=0; $save <count($data) ; $save++) { 
						array_push($dat,$data[$save]);
					} 
				json_encode($dat);
	        for ($i=0; $i <count($dat); $i++) { 
			  $dat1[$i] = DB::table('agen')->where('kode','=',$dat[$i])->get();
			}
		return view('purchase/master_do/lap_agen/report_agen',compact('dat1'));
		}
		//END OF



		//LAPORAN BIAYA 
		public function lap_biaya(){
			$data = DB::table('biaya')->get();
			return view('purchase/master_do/lap_biaya/lap_biaya',compact('data'));
		}	
		public function report_biaya(Request $request){
			$data = $request->a;	
		   		$dat = [];
					for ($save=0; $save <count($data) ; $save++) { 
						array_push($dat,$data[$save]);
					} 
				json_encode($dat);
	        for ($i=0; $i <count($dat); $i++) { 
			  $dat1[$i] = DB::table('biaya')->where('b_kode','=',$dat[$i])->get();
			}
			// dd($dat1);
		return view('purchase/master_do/lap_biaya/report_biaya',compact('dat1'));
		}
		//END OF



		//LAPORAN DSIKON 
		public function lap_diskon(){
			$data = DB::table('diskon')->get();
			return view('purchase/master_do/lap_diskon/lap_diskon',compact('data'));
		}	
		public function report_diskon(Request $request){
			$data = $request->a;	
		   		$dat = [];
					for ($save=0; $save <count($data) ; $save++) { 
						array_push($dat,$data[$save]);
					} 
				json_encode($dat);
	        for ($i=0; $i <count($dat); $i++) { 
			  $dat1[$i] = DB::table('diskon')->where('b_kode','=',$dat[$i])->get();
			}
			// dd($dat1);
		return view('purchase/master_do/lap_diskon/report_diskon',compact('dat1'));
		}
		//END OF


		//LAPORAN GROUP CUSTOMER 
		public function lap_grupcustomer(){
			$data = DB::table('group_customer')->get();
			return view('purchase/master_do/lap_grupcustomer/lap_grupcustomer',compact('data'));
		}	
		public function report_grupcustomer(Request $request){
			$data = $request->a;	
		   		$dat = [];
					for ($save=0; $save <count($data) ; $save++) { 
						array_push($dat,$data[$save]);
					} 
				json_encode($dat);
	        for ($i=0; $i <count($dat); $i++) { 
			  $dat1[$i] = DB::table('group_customer')->where('group_id','=',$dat[$i])->get();
			}
			// dd($dat1);
		return view('purchase/master_do/lap_grupcustomer/report_grupcustomer',compact('dat1'));
		}
		//END OF


		//LAPORAN GROUP ITEM 
		public function lap_grupitem(){
			$data = DB::table('grup_item')->get();
			return view('purchase/master_do/lap_grupitem/lap_grupitem',compact('data'));
		}	
		public function report_grupitem(Request $request){
			$data = $request->a;	
		   		$dat = [];
					for ($save=0; $save <count($data) ; $save++) { 
						array_push($dat,$data[$save]);
					} 
				json_encode($dat);
	        for ($i=0; $i <count($dat); $i++) { 
			  $dat1[$i] = DB::table('grup_item')->where('kode','=',$dat[$i])->get();
			}
			// dd($dat1);
		return view('purchase/master_do/lap_grupitem/report_grupitem',compact('dat1'));
		}
		//END OF

		//LAPORAN ITEM 
		public function lap_item(){
			$data = DB::select('SELECT i.kode, i.nama, i.harga, i.keterangan, gi.nama grup_item, s.nama satuan 
                    FROM item i
                    LEFT JOIN satuan s ON s.kode=i.kode_satuan 
                    LEFT JOIN grup_item gi ON gi.kode=i.kode_grup_item');
			return view('purchase/master_do/lap_item/lap_item',compact('data'));
		}	
		public function report_item(Request $request){
			$data = $request->a;	
		   		$dat = [];
					for ($save=0; $save <count($data) ; $save++) { 
						array_push($dat,$data[$save]);
					} 
				json_encode($dat);
	        for ($i=0; $i <count($dat); $i++) { 
			  $dat1[$i] = DB::select("SELECT i.kode, i.nama, i.harga, i.keterangan, gi.nama grup_item, s.nama satuan 
                    FROM item i
                    LEFT JOIN satuan s ON s.kode=i.kode_satuan 
                    LEFT JOIN grup_item gi ON gi.kode=i.kode_grup_item
                    WHERE i.kode = '$dat[$i]'
                		");
			}
			// dd($dat1);
		return view('purchase/master_do/lap_item/report_item',compact('dat1'));
		}
		//END OF
		

		//LAPORAN RUTE 
		public function lap_rute(){
			$data = DB::table('rute')->get();
			return view('purchase/master_do/lap_rute/lap_rute',compact('data'));
		}	
		public function report_rute(Request $request){
			$data = $request->a;	
		   		$dat = [];
					for ($save=0; $save <count($data) ; $save++) { 
						array_push($dat,$data[$save]);
					} 
				json_encode($dat);
	        for ($i=0; $i <count($dat); $i++) { 
			  $dat1[$i] = DB::table('rute')->where('kode','=',$dat[$i])->get();
			}
			// dd($dat1);
		return view('purchase/master_do/lap_rute/report_rute',compact('dat1'));
		}
		//END OF


		//LAPORAN SATUAN 
		public function lap_satuan(){
			$data = DB::table('satuan')->get();
			return view('purchase/master_do/lap_satuan/lap_satuan',compact('data'));
		}	
		public function report_satuan(Request $request){
			$data = $request->a;	
		   		$dat = [];
					for ($save=0; $save <count($data) ; $save++) { 
						array_push($dat,$data[$save]);
					} 
				json_encode($dat);
	        for ($i=0; $i <count($dat); $i++) { 
			  $dat1[$i] = DB::table('satuan')->where('kode','=',$dat[$i])->get();
			}
			// dd($dat1);
		return view('purchase/master_do/lap_satuan/report_satuan',compact('dat1'));
		}
		//END OF


		//LAPORAN SUBCON 
		public function lap_subcon(){
			$data = DB::table('subcon')->get();
			return view('purchase/master_do/lap_subcon/lap_subcon',compact('data'));
		}	
		public function report_subcon(Request $request){
			$data = $request->a;	
		   		$dat = [];
					for ($save=0; $save <count($data) ; $save++) { 
						array_push($dat,$data[$save]);
					} 
				json_encode($dat);
	        for ($i=0; $i <count($dat); $i++) { 
			  $dat1[$i] = DB::table('subcon')->where('kode','=',$dat[$i])->get();
			}
			// dd($dat1);
		return view('purchase/master_do/lap_subcon/report_subcon',compact('dat1'));
		}
		//END OF


		//LAPORAN SUBCON 
		public function lap_vendor(){
			$data = DB::select("SELECT a.kode, a.nama, a.alamat, k.nama kota, a.telpon, a.status FROM vendor a
                    LEFT JOIN kota k ON k.id=a.id_kota ");
			return view('purchase/master_do/lap_vendor/lap_vendor',compact('data'));
		}	
		public function report_vendor(Request $request){
			$data = $request->a;	
		   		$dat = [];
					for ($save=0; $save <count($data) ; $save++) { 
						array_push($dat,$data[$save]);
					} 
				json_encode($dat);
	        for ($i=0; $i <count($dat); $i++) { 
			  $dat1[$i] = DB::select("SELECT a.kode, a.nama, a.alamat, k.nama kota, a.telpon, a.status FROM vendor a
                    LEFT JOIN kota k ON k.id=a.id_kota 
                    WHERE a.kode = '$dat[$i]'");
			}
			// dd($dat1);
		return view('purchase/master_do/lap_vendor/report_vendor',compact('dat1'));
		}
		//END OF


		//LAPORAN ZONA 
		public function lap_zona(){
			$data = DB::table('zona')->get();
			return view('purchase/master_do/lap_zona/lap_zona',compact('data'));
		}	
		public function report_zona(Request $request){
			$data = $request->a;	
		   		$dat = [];
					for ($save=0; $save <count($data) ; $save++) { 
						array_push($dat,$data[$save]);
					} 
				json_encode($dat);
	        for ($i=0; $i <count($dat); $i++) { 
			  $dat1[$i] = DB::table('zona')->where('id_zona','=',$dat[$i])->get();
			}
			// dd($dat1);
		return view('purchase/master_do/lap_zona/report_zona',compact('dat1'));
		}
		//END OF
		
//➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥ END OF LAPORAN MASTER DO ➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥➥//


							

   }
?>