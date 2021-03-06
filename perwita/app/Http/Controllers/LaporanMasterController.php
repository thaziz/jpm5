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
use Yajra\Datatables\Datatables;    
use Excel;
class LaporanMasterController extends Controller
{

	//laporan master penghbung
		public function tarif_cabang_master(){
			return view('purchase/master_tarif/lap_mastertarif',compact('data','kota','kota1'));
		}
	//end of
														
//❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤ LAPORAN OPERASIONAL PENJUALAN ❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤
								

	//LAPORAN DELIVERY ORDER SEMUA 
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

													//=====PENERUS======\\

	// START OF DOKUMEN
	public function tarif_penerus_dokumen(){

		$data = DB::select("SELECT tarif_penerus_dokumen.*,res.id as id_asal,res1.id as id_tujuan, res.asal,res3.kecamatan,res1.tujuan,res4.harga_reg,res5.harga_ex
							from tarif_penerus_dokumen 
							left join (SELECT id, nama as asal from provinsi) as res
							on id_provinsi = res.id
							left join (SELECT id, nama as tujuan from kota) as res1
							on id_kota = res1.id
							left join (SeLECT id,nama as kecamatan from kecamatan) as res3
							on id_kecamatan = res3.id
							left join (SeLECT id_zona as id_reg,harga_zona as harga_reg,nama as nama_reg from zona ) as res4
							on tarif_reguler = res4.id_reg
							left join (select id_zona as id_ex ,harga_zona as harga_ex,nama as nama_ex from zona) as res5
							on tarif_express = res5.id_ex
							");

		$kota = DB::select("SELECT id, nama as kota from kota");
		$provinsi = DB::select("SELECT id, nama as provinsi from provinsi");
		$kecamatan = DB::select("SELECT id, nama as kecamatan from kecamatan");

		return view('purchase/master/master_penjualan/laporan/tarifPenerusDokumen',compact('data','kota','provinsi','kecamatan'));
	}
	public function reportpenerusdokumen(Request $request){
		
		$data = $request->a;	
   		$dat = '';
		for ($save=0; $save <count($data) ; $save++) { 
			$dat = $dat.','.$data[$save];

		}
		$dat =explode(',', $dat); 
		json_encode($dat);
        for ($i=1; $i <count($dat) ; $i++) { 
			$dat1[$i] =
			$data = DB::select("SELECT tarif_penerus_dokumen.*,res.id as id_asal,res1.id as id_tujuan, res.asal,res3.kecamatan,res1.tujuan,res4.harga_reg,res5.harga_ex
							from tarif_penerus_dokumen 
							left join (SELECT id, nama as asal from provinsi) as res
							on id_provinsi = res.id
							left join (SELECT id, nama as tujuan from kota) as res1
							on id_kota = res1.id
							left join (SeLECT id,nama as kecamatan from kecamatan) as res3
							on id_kecamatan = res3.id
							left join (SeLECT id_zona as id_reg,harga_zona as harga_reg,nama as nama_reg from zona ) as res4
							on tarif_reguler = res4.id_reg
							left join (select id_zona as id_ex ,harga_zona as harga_ex,nama as nama_ex from zona) as res5
							on tarif_express = res5.id_ex
							where tarif_penerus_dokumen.id_tarif_dokumen = '$dat[$i]' 
							");
        }
        // dd ($dat1);
		return view('purchase/master/master_penjualan/pdf/pdf_penerusdokumen',compact('dat1'));
		
	}
	// END OF DOKUMEN

	// START OF KILOGRAM
	public function tarif_penerus_kilogram(){

		$data = DB::select("SELECT tarif_penerus_kilogram.*,res.id as id_asal,res1.id as id_tujuan, res.asal,res3.kecamatan,res1.tujuan,res4.harga_10reg,res5.harga_10ex,res6.harga_20reg,res7.harga_20ex
							from tarif_penerus_kilogram 
							left join (SELECT id, nama as asal from provinsi) as res
							on id_provinsi_kilo = res.id
							left join (SELECT id, nama as tujuan from kota) as res1
							on id_kota_kilo = res1.id
							left join (SeLECT id,nama as kecamatan from kecamatan) as res3
							on id_kecamatan_kilo = res3.id
							left join (SeLECT id_zona as id_10reg,harga_zona as harga_10reg,nama as nama_reg from zona ) as res4
							on tarif_10reguler_kilo = res4.id_10reg
							left join (select id_zona as id_10ex ,harga_zona as harga_10ex,nama as nama_ex from zona) as res5
							on tarif_10express_kilo = res5.id_10ex
							left join (select id_zona as id_20reg ,harga_zona as harga_20reg,nama as nama_ex from zona) as res6
							on tarif_20reguler_kilo = res6.id_20reg
							left join (select id_zona as id_20ex ,harga_zona as harga_20ex,nama as nama_ex from zona) as res7
							on tarif_20express_kilo = res7.id_20ex
							");

		$kota = DB::select("SELECT id, nama as kota from kota");
		$provinsi = DB::select("SELECT id, nama as provinsi from provinsi");
		$kecamatan = DB::select("SELECT id, nama as kecamatan from kecamatan");

		return view('purchase/master/master_penjualan/laporan/tarifPenerusKilogram',compact('data','kota','provinsi','kecamatan'));
	}
	public function reportpeneruskilogram(Request $request){
		
		$data = $request->a;	
   		$dat = '';
		for ($save=0; $save <count($data) ; $save++) { 
			$dat = $dat.','.$data[$save];

		}
		$dat =explode(',', $dat); 
		json_encode($dat);
        for ($i=1; $i <count($dat) ; $i++) { 
			$dat1[$i] =
			DB::select("SELECT tarif_penerus_kilogram.*,res.id as id_asal,res1.id as id_tujuan, res.asal,res3.kecamatan,res1.tujuan,res4.harga_10reg,res5.harga_10ex,res6.harga_20reg,res7.harga_20ex
							from tarif_penerus_kilogram 
							left join (SELECT id, nama as asal from provinsi) as res
							on id_provinsi_kilo = res.id
							left join (SELECT id, nama as tujuan from kota) as res1
							on id_kota_kilo = res1.id
							left join (SeLECT id,nama as kecamatan from kecamatan) as res3
							on id_kecamatan_kilo = res3.id
							left join (SeLECT id_zona as id_10reg,harga_zona as harga_10reg,nama as nama_reg from zona ) as res4
							on tarif_10reguler_kilo = res4.id_10reg
							left join (select id_zona as id_10ex ,harga_zona as harga_10ex,nama as nama_ex from zona) as res5
							on tarif_10express_kilo = res5.id_10ex
							left join (select id_zona as id_20reg ,harga_zona as harga_20reg,nama as nama_ex from zona) as res6
							on tarif_20reguler_kilo = res6.id_20reg
							left join (select id_zona as id_20ex ,harga_zona as harga_20ex,nama as nama_ex from zona) as res7
							on tarif_20express_kilo = res7.id_20ex
							where id_tarif_kilogram = '$dat[$i]'
							order by tarif_penerus_kilogram.id_increment_kilogram ASC"); 
        }
        // dd ($dat1);
		return view('purchase/master/master_penjualan/pdf/pdf_peneruskilogram',compact('dat1'));
		
	}
	// END OF KILOGRAM

	// START OF koli
	public function tarif_penerus_koli(){

		$data = DB::table('tarif_penerus_koli as tk')
					->select('tk.*','z1.harga_zona as h1','z2.harga_zona as h2','z3.harga_zona as h3','z4.harga_zona as h4','z5.harga_zona as h5','z6.harga_zona as h6','z7.harga_zona as h7','z8.harga_zona as h8','provinsi.nama as prov','kota.nama as kot','kecamatan.nama as kec')
					->leftjoin('zona as z1','tk.tarif_10reguler_koli','=','z1.id_zona')
					->leftjoin('zona as z2','tk.tarif_10express_koli','=','z2.id_zona')
					->leftjoin('zona as z3','tk.tarif_20reguler_koli','=','z3.id_zona')
					->leftjoin('zona as z4','tk.tarif_20express_koli','=','z4.id_zona')
					->leftjoin('zona as z5','tk.tarif_30reguler_koli','=','z5.id_zona')
					->leftjoin('zona as z6','tk.tarif_30express_koli','=','z6.id_zona')
					->leftjoin('zona as z7','tk.tarif_>30reguler_koli','=','z7.id_zona')
					->leftjoin('zona as z8','tk.tarif_>30express_koli','=','z8.id_zona')
					->leftjoin('provinsi','provinsi.id','=','tk.id_provinsi_koli')
					->leftjoin('kota','kota.id','=','tk.id_kota_koli')
					->leftjoin('kecamatan','kecamatan.id','=','tk.id_kecamatan_koli')
					->get();	

		$kota = DB::select("SELECT id, nama as kota from kota");
		$provinsi = DB::select("SELECT id, nama as provinsi from provinsi");
		$kecamatan = DB::select("SELECT id, nama as kecamatan from kecamatan");

		return view('purchase/master/master_penjualan/laporan/tarifPenerusKoli',compact('data','kota','provinsi','kecamatan'));
	}
	public function reportpeneruskoli(Request $request){
		
		$data = $request->a;	
   		$dat = '';
		for ($save=0; $save <count($data) ; $save++) { 
			$dat = $dat.','.$data[$save];

		}
		$dat =explode(',', $dat); 
		json_encode($dat);
        for ($i=1; $i <count($dat) ; $i++) { 
			$dat1[$i] =
			DB::table('tarif_penerus_koli as tk')
					->select('tk.*','z1.harga_zona as h1','z2.harga_zona as h2','z3.harga_zona as h3','z4.harga_zona as h4','z5.harga_zona as h5','z6.harga_zona as h6','z7.harga_zona as h7','z8.harga_zona as h8','provinsi.nama as prov','kota.nama as kot','kecamatan.nama as kec')
					->leftjoin('zona as z1','tk.tarif_10reguler_koli','=','z1.id_zona')
					->leftjoin('zona as z2','tk.tarif_10express_koli','=','z2.id_zona')
					->leftjoin('zona as z3','tk.tarif_20reguler_koli','=','z3.id_zona')
					->leftjoin('zona as z4','tk.tarif_20express_koli','=','z4.id_zona')
					->leftjoin('zona as z5','tk.tarif_30reguler_koli','=','z5.id_zona')
					->leftjoin('zona as z6','tk.tarif_30express_koli','=','z6.id_zona')
					->leftjoin('zona as z7','tk.tarif_>30reguler_koli','=','z7.id_zona')
					->leftjoin('zona as z8','tk.tarif_>30express_koli','=','z8.id_zona')
					->leftjoin('provinsi','provinsi.id','=','tk.id_provinsi_koli')
					->leftjoin('kota','kota.id','=','tk.id_kota_koli')
					->leftjoin('kecamatan','kecamatan.id','=','tk.id_kecamatan_koli')
					->where('tk.id_tarif_koli','=',$dat[$i])
					->get();
        }
        // dd ($dat1);
		return view('purchase/master/master_penjualan/pdf/pdf_peneruskoli',compact('dat1'));
		
	}
	// END OF koli

	// START OF SEPEDA
	public function tarif_penerus_sepeda(){

		$data = DB::table('tarif_penerus_sepeda as tk')
					->select('tk.*','z1.harga_zona as h1','z2.harga_zona as h2','z3.harga_zona as h3','z4.harga_zona as h4','provinsi.nama as prov','kota.nama as kot','kecamatan.nama as kec')
					->leftjoin('zona as z1','tk.sepeda','=','z1.id_zona')
					->leftjoin('zona as z2','tk.matik','=','z2.id_zona')
					->leftjoin('zona as z3','tk.sport','=','z3.id_zona')
					->leftjoin('zona as z4','tk.moge','=','z4.id_zona')
					->leftjoin('provinsi','provinsi.id','=','tk.id_provinsi_sepeda')
					->leftjoin('kota','kota.id','=','tk.id_kota_sepeda')
					->leftjoin('kecamatan','kecamatan.id','=','tk.id_kecamatan_sepeda')
					->get();	


		$kota = DB::select("SELECT id, nama as kota from kota");
		$provinsi = DB::select("SELECT id, nama as provinsi from provinsi");
		$kecamatan = DB::select("SELECT id, nama as kecamatan from kecamatan");

		return view('purchase/master/master_penjualan/laporan/tarifPenerusSepeda',compact('data','kota','provinsi','kecamatan'));
	}
	public function reportpenerussepeda(Request $request){
		
		$data = $request->a;	
   		$dat = '';
		for ($save=0; $save <count($data) ; $save++) { 
			$dat = $dat.','.$data[$save];

		}
		$dat =explode(',', $dat); 
		json_encode($dat);
        for ($i=1; $i <count($dat) ; $i++) { 
			$dat1[$i] =
			DB::table('tarif_penerus_sepeda as tk')
					->select('tk.*','z1.harga_zona as h1','z2.harga_zona as h2','z3.harga_zona as h3','z4.harga_zona as h4','provinsi.nama as prov','kota.nama as kot','kecamatan.nama as kec')
					->leftjoin('zona as z1','tk.sepeda','=','z1.id_zona')
					->leftjoin('zona as z2','tk.matik','=','z2.id_zona')
					->leftjoin('zona as z3','tk.sport','=','z3.id_zona')
					->leftjoin('zona as z4','tk.moge','=','z4.id_zona')
					->leftjoin('provinsi','provinsi.id','=','tk.id_provinsi_sepeda')
					->leftjoin('kota','kota.id','=','tk.id_kota_sepeda')
					->leftjoin('kecamatan','kecamatan.id','=','tk.id_kecamatan_sepeda')
					->where('id_tarif_sepeda','=',$dat[$i])
					->get();	
        }
        // dd ($dat1);
		return view('purchase/master/master_penjualan/pdf/pdf_penerussepeda',compact('dat1'));
		
	}
	// END OF SEPEDA

	// START OF DEFAULT
	public function tarif_penerus_default(){

		$data = DB::table('tarif_penerus_default as tk')
					->select('tk.*','z1.harga_zona as h1')
					->leftjoin('zona as z1','tk.id_zona_foreign','=','z1.id_zona')
					->get();	

		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$kota1 = DB::select("SELECT id, nama as asal from kota");

		return view('purchase/master/master_penjualan/laporan/tarifPenerusdefault',compact('data','kota','kota1'));
	}
	public function reportpenerusdefault(Request $request){
		
		$data = $request->a;	
   		$dat = '';
		for ($save=0; $save <count($data) ; $save++) { 
			$dat = $dat.','.$data[$save];

		}
		$dat =explode(',', $dat); 
		json_encode($dat);
        for ($i=1; $i <count($dat) ; $i++) { 
			$dat1[$i] =
			DB::table('tarif_penerus_default as tk')
					->select('tk.*','z1.harga_zona as h1')
					->leftjoin('zona as z1','tk.id_zona_foreign','=','z1.id_zona')
					->where('id','=',$dat[$i])
					->get();        
				}
        // dd ($dat1);
		return view('purchase/master/master_penjualan/pdf/pdf_penerusdefault',compact('dat1'));
		
	}
	// END OF DEFAULT




//==================================================== LAPORAN TARIF BERAKIR ========================================================//


//LAPORAN PENJUALAN

	public function laporan_penjualan(){

		$data =DB::table('delivery_order as do')
				->select('do.*','ka.id as kaid','kt.id as ktid','ka.nama as asal','kt.nama as tujuan','kc.nama as kecamatan')
				->leftjoin('kota as ka','do.id_kota_asal','=','ka.id')
				->leftjoin('kota as kt','do.id_kota_tujuan','=','kt.id')
				->leftjoin('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
				->leftjoin('invoice_d','invoice_d.id_nomor_do','=','do.nomor')
				->where('do.status','=','DELIVERED OK')
				->get();
		

		 $array_bulan = ['1','2','3','4','5','6','7','8','9','10','11','12'];
		 $tahun = carbon::now();
		 $tahun =  $tahun->year;

		for ($i=0; $i <count($array_bulan) ; $i++) { 
			$dat[$i] =DB::table('delivery_order as do')
				->select('do.total_net','do.tanggal','do.pendapatan','do.status','do.nomor')
				->whereMonth('tanggal','=',$array_bulan[$i])
				->whereYear('tanggal','=',$tahun)
				->where('do.status','=','DELIVERED OK')
				->join('invoice_d','invoice_d.id_nomor_do','=','do.nomor')
				->get();
			
		}
		// return $dat;
		// return $tahun;
		for ($i=0; $i <count($dat) ; $i++) { 
			if ($dat[$i] != null) {
				for ($j=0; $j <count($dat[$i]); $j++) {
					$hitung[$i][$j] = $dat[$i][$j]->total_net;
				}
			}else{
				$hitung[$i] = 0;
			}
		}
		// return $hitung;
		for ($i=0; $i <count($hitung) ; $i++) {
			if ($hitung[$i] != null) {
				for ($j=0; $j <count($hitung[$i]) ; $j++) {
					$penjualan[$i] = array_sum($hitung[$i]);
				}
			}else{
					$penjualan[$i] = 0;
			}
			
		}
		// return $penjualan;
		// return [$paket,$koran,$kargo];
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$kota1 = DB::select("SELECT id, nama as asal from kota");
		return view('purchase/master/master_penjualan/laporan/lap_penjualan',compact('data','kota','kota1','paket','koran','penjualan'));
	}

//END OF

	public function deliveryorder_total(){
		
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$kota1 = DB::select("SELECT id, nama as asal from kota");
		$cabang = DB::table('cabang')->get();
		$customer = DB::table('customer')->get();
		return view('purchase/master/master_penjualan/laporan/lap_deliveryorder_total',compact('customer','data','kota','cabang','kota1','paket','koran','kargo'));
	}

	public function deliveryorder_total_data(Request $request){
		$nomor = strtoupper($request->input('nomor'));
        $authe = Auth::user()->kode_cabang; 
        if (Auth::user()->punyaAkses('Delivery Order','all')) {
        $sql = "SELECT d.pendapatan,d.total_dpp,d.total_vendo,d.status as status,cc.nama as cab,d.total_net,d.type_kiriman,d.jenis_pengiriman,d.pendapatan,c.nama as cus,d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total
                    FROM delivery_order d
                    LEFT JOIN kota k ON k.id=d.id_kota_asal
                    LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
                    LEFT JOIN customer c on d.kode_customer = c.kode 
                    LEFT JOIN cabang cc on d.kode_cabang = cc.kode 
                    -- LEFT JOIN kecamatan kc on d.kecamatan = cc.kode 
                    ";
        }
        else{
        $sql = "SELECT d.pendapatan,d.total_dpp,d.total_vendo,d.status as status,cc.nama as cab,d.total_net,d.type_kiriman,d.jenis_pengiriman,c.nama as cus,d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total
                    FROM delivery_order d
                    LEFT JOIN kota k ON k.id=d.id_kota_asal
                    LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
                    LEFT JOIN customer c on d.kode_customer = c.kode 
                    LEFT JOIN cabang cc on d.kode_cabang = cc.kode 
                    -- LEFT JOIN kecamatan kc on d.kecamatan = cc.kode 
                    and kode_cabang = '$authe'
                     ";
        }

        $list = DB::select($sql);
        // return $data;
        $data = collect($list);

        
        return Datatables::of($data)->make(true);
	}
	public function carideliveryorder_total(Request $request){
		// dd($request->all());
		//asal
		if ($request->asal != '') {
			$asal_fil = (int)$request->asal;
			$asal = ' AND d.id_kota_asal = '.$asal_fil.'';
		}else{
			$asal = '';
		}
		//tujuan
		if ($request->tujuan != '') {
			$tujuan = " AND d.id_kota_tujuan = '".(int)$request->tujuan."' ";
		}else{
			$tujuan = '';
		}
		//cabang
		if ($request->cabang != '') {
			$cabang = " AND d.kode_cabang = '".$request->cabang."' ";
		}else{
			$cabang ='';
		}
		//tipe
		if ($request->tipe != '') {
			$tipe = " AND d.type_kiriman = '".$request->tipe."' ";
		}else{
			$tipe ='';
		}
		//status
		if ($request->status != '' || $request->status != null) {
			$status = " AND d.status = '".$request->status."' ";
		}else{
			$status = '';
		}
		//pendapatan
		if ($request->pendapatan != '' || $request->pendapatan != null) {
			$pendapatan = " AND d.pendapatan = '".$request->pendapatan."' ";
		}else{
			$pendapatan = '';
		}
		//jenis
		if ($request->jenis != '' || $request->jenis != null) {
			$jenis = " AND d.jenis_pengiriman = '".$request->jenis."' ";
		}else{
			$jenis = '';
		}
		//customer
		if ($request->customer != '' || $request->customer != null) {
			$customer = " AND d.kode_customer = '".$request->customer."' ";
		}else{
			$customer = '';
		}
		
		$min = $request->min;
		$max = $request->max;

		$data  = DB::select("SELECT d.kode_customer,d.pendapatan,d.total_dpp,d.total_vendo,cc.nama as cab,d.total_net,d.type_kiriman,d.jenis_pengiriman,c.nama as cus,d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total 
			FROM delivery_order as d 
			LEFT JOIN kota k ON k.id=d.id_kota_asal
            LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
            join customer c on d.kode_customer = c.kode 
            join cabang cc on d.kode_cabang = cc.kode 

			WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' ".$cabang." ".$asal." ".$tujuan." ".$pendapatan." ".$jenis."  ".$tipe." ".$status." ".$customer." ");
        $data = collect($data);

        // return $data;
        return Datatables::of($data)->make(true);
	}
	public function reportdeliveryorder_total(Request $request){
		// dd($request->all());
		if ($request->asal != '') {
			$asal_fil = (int)$request->asal;
			$asal = ' AND d.id_kota_asal = '.$asal_fil.'';
		}else{
			$asal = '';
		}
		//tujuan
		if ($request->tujuan != '') {
			$tujuan = " AND d.id_kota_tujuan = '".(int)$request->tujuan."' ";
		}else{
			$tujuan = '';
		}
		//cabang
		if ($request->cabang != '') {
			$cabang = " AND d.kode_cabang = '".$request->cabang."' ";
		}else{
			$cabang ='';
		}
		//tipe
		if ($request->tipe != '') {
			$tipe = " AND d.type_kiriman = '".$request->tipe."' ";
		}else{
			$tipe ='';
		}
		//status
		if ($request->status != '' || $request->status != null) {
			$status = " AND d.status = '".$request->status."' ";
		}else{
			$status = '';
		}
		//pendapatan
		if ($request->pendapatan != '' || $request->pendapatan != null) {
			$pendapatan = " AND d.pendapatan = '".$request->pendapatan."' ";
		}else{
			$pendapatan = '';
		}
		//jenis
		if ($request->jenis != '' || $request->jenis != null) {
			$jenis = " AND d.jenis_pengiriman = '".$request->jenis."' ";
		}else{
			$jenis = '';
		}
		//customer
		if ($request->customer != '' || $request->customer != null) {
			$customer = " AND d.kode_customer = '".$request->customer."' ";
		}else{
			$customer = '';
		}
		
		$min = $request->min;
		$max = $request->max;

		$dat1  = DB::select("SELECT d.kode_customer,d.pendapatan,d.total_dpp,d.total_vendo,cc.nama as cab,d.total_net,d.type_kiriman,d.jenis_pengiriman,c.nama as cus,d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total 
			FROM delivery_order as d 
			LEFT JOIN kota k ON k.id=d.id_kota_asal
            LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
            join customer c on d.kode_customer = c.kode 
            join cabang cc on d.kode_cabang = cc.kode 

			WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' ".$cabang." ".$asal." ".$tujuan." ".$pendapatan." ".$jenis."  ".$tipe." ".$status." ".$customer." ");

        foreach($dat1 as $key => $value){
			   	if ($dat1[$key] == null) {
			   	}else{
			   		$total_perhitungan[$key] = $dat1[$key]->total_net;
			   	}
		   	}
        $total_perhitungan = array_sum($total_perhitungan);

        // dd($total_net);

		// for
		return view('purchase/master/master_penjualan/pdf/pdf_deliveryorder_total',compact('dat1','total_perhitungan'));
		
	}
	public function exceldeliveryorder_total(Request $request){
	if ($request->asal != '') {
			$asal_fil = (int)$request->asal;
			$asal = ' AND d.id_kota_asal = '.$asal_fil.'';
		}else{
			$asal = '';
		}
		//tujuan
		if ($request->tujuan != '') {
			$tujuan = " AND d.id_kota_tujuan = '".(int)$request->tujuan."' ";
		}else{
			$tujuan = '';
		}
		//cabang
		if ($request->cabang != '') {
			$cabang = " AND d.kode_cabang = '".$request->cabang."' ";
		}else{
			$cabang ='';
		}
		//tipe
		if ($request->tipe != '') {
			$tipe = " AND d.type_kiriman = '".$request->tipe."' ";
		}else{
			$tipe ='';
		}
		//staus
		
		if ($request->status != '' || $request->status != null) {
			$status = " AND d.status = '".$request->status."' ";
		}else{
			$status = '';
		}
		
		$min = $request->min;
		$max = $request->max;

		$data  = DB::select("SELECT d.total_dpp,d.total_vendo,cc.nama as cab,d.total_net,d.type_kiriman,d.jenis_pengiriman,c.nama as cus,d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total ,cc.nama as cabang
			FROM delivery_order as d 
			LEFT JOIN kota k ON k.id=d.id_kota_asal
            LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
            join customer c on d.kode_customer = c.kode 
            join cabang cc on d.kode_cabang = cc.kode 

			WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' ".$cabang." ".$asal." ".$tujuan." ".$tipe." ".$status." ");

        

			$myFile= Excel::create("filename", function($excel) use($data) {
		    $excel->setTitle('title');
		    $excel->sheet('sheet 1', function($sheet) use($data) {
		   	$sheetArray = array();
		   	$sheetArray[] = array('No DO','Tanggal','Pengirim','Penerima','Kota Asal','Kota Tujuan','Tipe','Status','Cabang','Tarif Keseluruhan');

		   	foreach ($data as $index => $row) {
				
					$sheetArray[] = array(
		   							$row->nomor 
		   							,$row->tanggal 
									,$row->nama_pengirim 
									,$row->nama_penerima 
									,$row->asal 
									,$row->tujuan 
									,$row->type_kiriman 
									,$row->status 
									,$row->cabang 
									,number_format($row->total_net,0,',','.') 
					);
				
		   	}
		  
		    
		    $sheet->fromArray($sheetArray);
		    
		   });
		});
		$date = carbon::now();
		$beda = $date->year.$date->hour.$date->second.$date->second;
		$myFile = $myFile->string('xlsx'); //change xlsx for the format you want, default is xls
		$response =  array(
		   'name' => "LaporanDo".$beda, //no extention needed
		   'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($myFile) //mime type of used format
		);
		return response()->json($response);
		

	}
	public function ajaxcarideliveryorder_total(Request $request)
    {	
		$min = $request->min;
		$max = $request->max;
		$asal =$request->asal;
		$tujuan=$request->tujuan;
		$cabang=$request->cabang;
		$tipe=$request->tipe;
		$status=$request->status;
		$jenis=$request->jenis;
		$pendapatan=$request->pendapatan;
		$customer=$request->customer;
        return view('purchase/master/master_penjualan/laporan/ajax_pencarian',compact('min','max','asal','tujuan','cabang','tipe','status','pendapatan','jenis','customer'));
    }
	
    	//laporan master detail delivery order total
    	
    		public function ajaxcarideliveryorder_total_masterdetail(Request $request)
    		{
    		// dd($request->all());
    		if ($request->asal != '') {
			$asal_fil = (int)$request->asal;
			$asal = ' AND d.id_kota_asal = '.$asal_fil.'';
			}else{
				$asal = '';
			}
			//tujuan
			if ($request->tujuan != '') {
				$tujuan = " AND d.id_kota_tujuan = '".(int)$request->tujuan."' ";
			}else{
				$tujuan = '';
			}
			//cabang
			if ($request->cabang != '') {
				$cabang = " AND d.kode_cabang = '".$request->cabang."' ";
			}else{
				$cabang ='';
			}
			//tipe
			if ($request->tipe != '') {
				$tipe = " AND d.type_kiriman = '".$request->tipe."' ";
			}else{
				$tipe ='';
			}
			
			if ($request->status != '' || $request->status != null) {
				$status = " AND d.status = '".$request->status."' ";
			}else{
				$status = '';
			}
			
			if ($request->pendapatan != '' || $request->pendapatan != null) {
				$pendapatan = " AND d.pendapatan = '".$request->pendapatan."' ";
			}else{
				$pendapatan = '';
			}

			if ($request->jenis != '' || $request->jenis != null) {
				$jenis = " AND d.jenis_pengiriman = '".$request->jenis."' ";
			}else{
				$jenis = '';
			}
			
			if ($request->customer != '' || $request->customer != null) {
			$customer = " AND d.kode_customer = '".$request->customer."' ";
			}else{
				$customer = '';
			}
				
			$min = $request->min;
			$max = $request->max;
			

			$data  = DB::select("SELECT d.kode_customer,d.pendapatan,d.total_dpp,d.total_vendo,cc.nama as cab,d.total_net,d.type_kiriman,d.jenis_pengiriman,c.nama as cus,d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total,d.deskripsi	 
				FROM delivery_order as d 
				LEFT JOIN kota k ON k.id=d.id_kota_asal
	            LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
	            join customer c on d.kode_customer = c.kode 
	            join cabang cc on d.kode_cabang = cc.kode 

				WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' ".$cabang." ".$asal." ".$tujuan." ".$pendapatan." ".$jenis."  ".$tipe." ".$status." ".$customer." ");
			$cek =	DB::select("SELECT d.kode_customer 
				FROM delivery_order as d 
				LEFT JOIN kota k ON k.id=d.id_kota_asal
	            LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
	            join customer c on d.kode_customer = c.kode 
	            join cabang cc on d.kode_cabang = cc.kode 

				WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' ".$cabang." ".$asal." ".$tujuan." ".$pendapatan." ".$jenis."  ".$tipe." ".$status." ".$customer." group by d.kode_customer");
			for ($i=0; $i <count($cek) ; $i++) { 
				$customer_foreach[$i] = DB::table('customer')->where('kode','=',$cek[$i]->kode_customer)->get(); 
			}
			for ($i=0; $i <count($data) ; $i++) { 
				$total[$i] = $data[$i]->total_net;
			}
			$total = array_sum($total);

			// return $customer_foreach;
    				return view('purchase/master/master_penjualan/laporan/do_total/rekap_master_detail/ajax_lap_masterdetail',compact('total','data','customer_foreach','min','max','asal','tujuan','cabang','tipe','status','pendapatan','jenis'));
    		}


    		public function ajaxcarideliveryorder_non_customer(Request $request )
			{
				// dd($request->all());
    		if ($request->asal != '') {
			$asal_fil = (int)$request->asal;
			$asal = ' AND d.id_kota_asal = '.$asal_fil.'';
			}else{
				$asal = '';
			}
			//tujuan
			if ($request->tujuan != '') {
				$tujuan = " AND d.id_kota_tujuan = '".(int)$request->tujuan."' ";
			}else{
				$tujuan = '';
			}
			//cabang
			if ($request->cabang != '') {
				$cabang = " AND d.kode_cabang = '".$request->cabang."' ";
			}else{
				$cabang ='';
			}
			//tipe
			if ($request->tipe != '') {
				$tipe = " AND d.type_kiriman = '".$request->tipe."' ";
			}else{
				$tipe ='';
			}
			
			if ($request->status != '' || $request->status != null) {
				$status = " AND d.status = '".$request->status."' ";
			}else{
				$status = '';
			}
			
			if ($request->pendapatan != '' || $request->pendapatan != null) {
				$pendapatan = " AND d.pendapatan = '".$request->pendapatan."' ";
			}else{
				$pendapatan = '';
			}

			if ($request->jenis != '' || $request->jenis != null) {
				$jenis = " AND d.jenis_pengiriman = '".$request->jenis."' ";
			}else{
				$jenis = '';
			}
			
			if ($request->customer != '' || $request->customer != null) {
			$customer = " AND d.kode_customer = '".$request->customer."' ";
			}else{
				$customer = '';
			}
				
			$min = $request->min;
			$max = $request->max;
			

			$data  = DB::select("SELECT d.kode_customer,d.pendapatan,d.total_dpp,d.diskon,d.total_vendo,cc.nama as cab,d.total_net,d.type_kiriman,d.jenis_pengiriman,c.nama as cus,d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total,d.deskripsi	 
				FROM delivery_order as d 
				JOIN kota k ON k.id=d.id_kota_asal
	            JOIN kota kk ON kk.id=d.id_kota_tujuan
	            join customer c on d.kode_customer = c.kode 
	            join cabang cc on d.kode_cabang = cc.kode 

				WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' AND kode_customer = 'CS-008/00230' ".$cabang." ".$asal." ".$tujuan." ".$pendapatan." ".$jenis."  ".$tipe." ".$status." ".$customer." ");
			
			$cek =	DB::select("SELECT d.kode_customer 
				FROM delivery_order as d 
				LEFT JOIN kota k ON k.id=d.id_kota_asal
	            LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
	            join customer c on d.kode_customer = c.kode 
	            join cabang cc on d.kode_cabang = cc.kode 

				WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' AND kode_customer = 'CS-008/00230' ".$cabang." ".$asal." ".$tujuan." ".$pendapatan." ".$jenis."  ".$tipe." ".$status." ".$customer." group by d.kode_customer");
			for ($i=0; $i <count($cek) ; $i++) { 
				$customer_foreach[$i] = DB::table('customer')->where('kode','=',$cek[$i]->kode_customer)->get(); 
			}
			// for ($i=0; $i <count($data) ; $i++) { 
			// 	$total[$i] = $data[$i]->total_net;
			// 	$total_netto[$i] = $data[$i]->total;
			// 	$total_diskon[$i] = $data[$i]->diskon;
			// 	$do[$i] = $data[$i]->nomor;
			// }
			// $total = array_sum($total);
			// $total_netto = array_sum($total_netto);
			// $total_diskon = array_sum($total_diskon);
			// $do = array_sum($do);

			if ($data == null) {
   				return response()->json(['data'=>'0']); 
   			}else{
   				for ($i=0; $i <count($data) ; $i++) { 
	   					$dat[$i] = $data[$i]->total_net;
	   			}
	   			for ($i=0; $i <count($data) ; $i++) { 
	   					$dat1[$i] = $data[$i]->total;
	   			}
	   			for ($i=0; $i <count($data) ; $i++) { 
	   					$dat2[$i] = $data[$i]->diskon;
	   			}
	   			for ($i=0; $i <count($data) ; $i++) { 
	   					$dat3[$i] = $data[$i]->nomor;
	   			}
	   			
	   			$total =  array_sum($dat1);

	   			$total_net = array_sum($dat);
	   			
	   			$total_diskon = array_sum($dat2);

	   			$do = count($dat3);
   			}




			// return $customer_foreach;
    				return view('purchase/master/master_penjualan/laporan/do_total/rekap_non_customer/ajax_lap_nonrekapcustomer',compact('total','data','customer_foreach','min','max','asal','tujuan','cabang','tipe','status','pendapatan','jenis','total_net','total_netto','total_diskon','do'));
			}

			public function ajaxcarideliveryorder_belum_delivered_ok(Request $request )
			{
				// dd($request->all());
    		if ($request->asal != '') {
			$asal_fil = (int)$request->asal;
			$asal = ' AND d.id_kota_asal = '.$asal_fil.'';
			}else{
				$asal = '';
			}
			//tujuan
			if ($request->tujuan != '') {
				$tujuan = " AND d.id_kota_tujuan = '".(int)$request->tujuan."' ";
			}else{
				$tujuan = '';
			}
			//cabang
			if ($request->cabang != '') {
				$cabang = " AND d.kode_cabang = '".$request->cabang."' ";
			}else{
				$cabang ='';
			}
			//tipe
			if ($request->tipe != '') {
				$tipe = " AND d.type_kiriman = '".$request->tipe."' ";
			}else{
				$tipe ='';
			}
			
			if ($request->status != '' || $request->status != null) {
				$status = " AND d.status = '".$request->status."' ";
			}else{
				$status = '';
			}
			
			if ($request->pendapatan != '' || $request->pendapatan != null) {
				$pendapatan = " AND d.pendapatan = '".$request->pendapatan."' ";
			}else{
				$pendapatan = '';
			}

			if ($request->jenis != '' || $request->jenis != null) {
				$jenis = " AND d.jenis_pengiriman = '".$request->jenis."' ";
			}else{
				$jenis = '';
			}
			
			if ($request->customer != '' || $request->customer != null) {
			$customer = " AND d.kode_customer = '".$request->customer."' ";
			}else{
				$customer = '';
			}
				
			$min = $request->min;
			$max = $request->max;
			

			$data_awal  = DB::select("SELECT c.nama as nama,kode_customer, sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net  from delivery_order d
			   	join customer c on d.kode_customer = c.kode
      
				WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' AND status != 'DELIVERED oktober' ".$cabang." ".$asal." ".$tujuan." ".$pendapatan." ".$jenis."  ".$tipe." ".$status." ".$customer." 
				group by d.kode_customer,c.kode
				order by d.kode_customer");

			   		
			   			if ($data_awal == null) {
			   				return response()->json(['data'=>'0']); 
			   			}else{
			   				for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat[$i] = $data_awal[$i]->total_net;
				   			}
				   			for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat1[$i] = $data_awal[$i]->total;
				   			}
				   			for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat2[$i] = $data_awal[$i]->diskon;
				   			}
				   			for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat3[$i] = $data_awal[$i]->do;
				   			}
				   			
				   			$total =  array_sum($dat1);

				   			$total_net = array_sum($dat);
				   			
				   			$diskon = array_sum($dat2);

				   			$do = array_sum($dat3);
			   			}




			// return $data_awal;
    				return view('purchase/master/master_penjualan/laporan/do_total/rekap_belum_delivered_ok/ajax_lap_rekap_belum_delivered_ok',compact('total','data','customer_foreach','min','max','asal','tujuan','cabang','tipe','status','pendapatan','data_awal','total_net','total_netto','diskon','do'));
			}

    
    		public function ajaxcarideliveryorder_total_rekapbulan(Request $request)
    		{
    		if ($request->asal != '') {
			$asal_fil = (int)$request->asal;
			$asal = ' AND id_kota_asal = '.$asal_fil.'';
			}else{
				$asal = '';
			}
			//tujuan
			if ($request->tujuan != '') {
				$tujuan = " AND id_kota_tujuan = '".(int)$request->tujuan."' ";
			}else{
				$tujuan = '';
			}
			//cabang
			if ($request->cabang != '') {
				$cabang = " where kode_cabang = '".$request->cabang."' ";
			}else{
				$cabang ='';
			}
			//tipe
			if ($request->tipe != '') {
				$tipe = " AND type_kiriman = '".$request->tipe."' ";
			}else{
				$tipe ='';
			}
			
			if ($request->status != '' || $request->status != null) {
				$status = " AND status = '".$request->status."' ";
			}else{
				$status = '';
			}
			
			if ($request->pendapatan != '' || $request->pendapatan != null) {
				$pendapatan = " AND pendapatan = '".$request->pendapatan."' ";
			}else{
				$pendapatan = '';
			}

			if ($request->jenis != '' || $request->jenis != null) {
				$jenis = " AND jenis_pengiriman = '".$request->jenis."' ";
			}else{
				$jenis = '';
			}
			
			if ($request->customer != '' || $request->customer != null) {
			$customer = " AND kode_customer = '".$request->customer."' ";
			}else{
				$customer = '';
			}
				
			$min = $request->min;
			$max = $request->max;
			
			
		
				$a = DB::select("SELECT cu.kode as customer,cu.nama as nama_cus,
											(select sum(total_net) from delivery_order 
											join customer on kode_customer = kode 
											where EXTRACT(MONTH FROM tanggal) = 1
											and kode_customer = cu.kode
											group by kode) as januari,
											(select sum(total_net) from delivery_order 
											join customer on kode_customer = kode 
											where EXTRACT(MONTH FROM tanggal) = 2
											and kode_customer = cu.kode
											group by kode) as februari,
											(select sum(total_net) from delivery_order 
											join customer on kode_customer = kode 
											where EXTRACT(MONTH FROM tanggal) = 3
											and kode_customer = cu.kode
											group by kode) as maret,
											(select sum(total_net) from delivery_order 
											join customer on kode_customer = kode 
											where EXTRACT(MONTH FROM tanggal) = 4
											and kode_customer = cu.kode
											group by kode) as april,
											(select sum(total_net) from delivery_order 
											join customer on kode_customer = kode 
											where EXTRACT(MONTH FROM tanggal) = 5
											and kode_customer = cu.kode
											group by kode) as mei,
											(select sum(total_net) from delivery_order 
											join customer on kode_customer = kode 
											where EXTRACT(MONTH FROM tanggal) = 6
											and kode_customer = cu.kode
											group by kode) as juni,
											(select sum(total_net) from delivery_order 
											join customer on kode_customer = kode 
											where EXTRACT(MONTH FROM tanggal) = 7
											and kode_customer = cu.kode
											group by kode) as juli,
											(select sum(total_net) from delivery_order 
											join customer on kode_customer = kode 
											where EXTRACT(MONTH FROM tanggal) = 8
											and kode_customer = cu.kode
											group by kode) as agustus,
											(select sum(total_net) from delivery_order 
											join customer on kode_customer = kode 
											where EXTRACT(MONTH FROM tanggal) = 9
											and kode_customer = cu.kode
											group by kode) as september,
											(select sum(total_net) from delivery_order 
											join customer on kode_customer = kode 
											where EXTRACT(MONTH FROM tanggal) = 10
											and kode_customer = cu.kode
											group by kode) as oktober,
											(select sum(total_net) from delivery_order 
											join customer on kode_customer = kode 
											where EXTRACT(MONTH FROM tanggal) = 11
											and kode_customer = cu.kode
											group by kode) as november,
											(select sum(total_net) from delivery_order 
											join customer on kode_customer = kode 
											where EXTRACT(MONTH FROM tanggal) = 12
											and kode_customer = cu.kode
											group by kode) as desember
										from delivery_order
										join customer cu on kode_customer = kode 
										group by cu.kode
										order by cu.kode asc");


					

			// return $a;
			// return count($cek);
			if ($request->customer != null) {
				$cust = DB::table('customer')->select('kode','nama')->where('kode','=',$request->customer)->groupBy('kode')->orderBy('kode','ASC')->get();
				
			}else{
				$cust = DB::table('customer')->select('kode','nama')->groupBy('kode')->orderBy('kode','ASC')->get();
			}
			
			// return $cust;
			
			
			
			
    			return view('purchase/master/master_penjualan/laporan/do_total/rekap_bulanan/ajax_lap_rekapbulanan',compact('a','cust','gg'));
    		}
    		
    	//cari entry

    		public function ajaxcarideliveryorder_total_entry(Request $request)
    		{
    			// dd($request->all());
    		if ($request->asal != '') {
			$asal_fil = (int)$request->asal;
			$asal = ' AND d.id_kota_asal = '.$asal_fil.'';
			}else{
				$asal = '';
			}
			//tujuan
			if ($request->tujuan != '') {
				$tujuan = " AND d.id_kota_tujuan = '".(int)$request->tujuan."' ";
			}else{
				$tujuan = '';
			}
			//cabang
			if ($request->cabang != '') {
				$cabang = " AND d.kode_cabang = '".$request->cabang."' ";
			}else{
				$cabang ='';
			}
			//tipe
			if ($request->tipe != '') {
				$tipe = " AND d.type_kiriman = '".$request->tipe."' ";
			}else{
				$tipe ='';
			}
			
			if ($request->status != '' || $request->status != null) {
				$status = " AND d.status = '".$request->status."' ";
			}else{
				$status = '';
			}
			
			if ($request->pendapatan != '' || $request->pendapatan != null) {
				$pendapatan = " AND d.pendapatan = '".$request->pendapatan."' ";
			}else{
				$pendapatan = '';
			}

			if ($request->jenis != '' || $request->jenis != null) {
				$jenis = " AND d.jenis_pengiriman = '".$request->jenis."' ";
			}else{
				$jenis = '';
			}
			
			if ($request->customer != '' || $request->customer != null) {
			$customer = " AND d.kode_customer = '".$request->customer."' ";
			}else{
				$customer = '';
			}
				
			$min = $request->min;
			$max = $request->max;
			

			$data  = DB::select("SELECT 
				count(d.nomor) as total,sum(d.total_net), d.kode_cabang,cc.nama

				FROM delivery_order as d 
				LEFT JOIN kota k ON k.id=d.id_kota_asal
	            LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
	            join customer c on d.kode_customer = c.kode 
	            join cabang cc on d.kode_cabang = cc.kode 

				WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' ".$cabang." ".$asal." ".$tujuan." ".$pendapatan." ".$jenis."  ".$tipe." ".$status." ".$customer." 

				group by d.kode_cabang,cc.nama
				order by d.kode_cabang ASC
			");
			if ($data == null) {

				return 'DATA TIDAK ADA! (DEV MODE)';
			}else{
				for ($i=0; $i <count($data) ; $i++) { 
				  $hit[$i] = $data[$i]->sum;
				  $hit_tot[$i] = $data[$i]->total;
				}
			}
			
			$tot = array_sum($hit);
			$tot_hit = array_sum($hit_tot);
			// return $tot;
			// return $data;
			
   				return view('purchase/master/master_penjualan/laporan/do_total/rekap_entry/ajax_lap_entry',compact('tot','tot_hit','total','data','customer_foreach','min','max','asal','tujuan','cabang','tipe','status','pendapatan','jenis'));
    		}




    	//ajax cari detail nopol
    		public function ajaxcarideliveryorder_total_detailnopol(Request $request)
    		{
    		if ($request->asal != '') {
			$asal_fil = (int)$request->asal;
			$asal = ' AND d.id_kota_asal = '.$asal_fil.'';
			}else{
				$asal = '';
			}
			//tujuan
			if ($request->tujuan != '') {
				$tujuan = " AND d.id_kota_tujuan = '".(int)$request->tujuan."' ";
			}else{
				$tujuan = '';
			}
			//cabang
			if ($request->cabang != '') {
				$cabang = " AND d.kode_cabang = '".$request->cabang."' ";
			}else{
				$cabang ='';
			}
			//tipe
			if ($request->tipe != '') {
				$tipe = " AND d.type_kiriman = '".$request->tipe."' ";
			}else{
				$tipe ='';
			}
			
			if ($request->status != '' || $request->status != null) {
				$status = " AND d.status = '".$request->status."' ";
			}else{
				$status = '';
			}
			
			if ($request->pendapatan != '' || $request->pendapatan != null) {
				$pendapatan = " AND d.pendapatan = '".$request->pendapatan."' ";
			}else{
				$pendapatan = '';
			}

			if ($request->jenis != '' || $request->jenis != null) {
				$jenis = " AND d.jenis_pengiriman = '".$request->jenis."' ";
			}else{
				$jenis = '';
			}
			
			if ($request->customer != '' || $request->customer != null) {
			$customer = " AND d.kode_customer = '".$request->customer."' ";
			}else{
				$customer = '';
			}
				
			$min = $request->min;
			$max = $request->max;
			
			

			$data  = DB::select("SELECT d.jumlah,d.kode_satuan,d.nopol,d.kode_customer,d.pendapatan,d.total_dpp,d.total_vendo,cc.nama as cab,d.total_net,d.type_kiriman,d.jenis_pengiriman,c.nama as cus,d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total,d.deskripsi	 
				FROM delivery_order as d 
				LEFT JOIN kota k ON k.id=d.id_kota_asal
	            LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
	            join customer c on d.kode_customer = c.kode 
	            join cabang cc on d.kode_cabang = cc.kode 
	            -- left join delivery_orderd dd on dd.dd_nomor = d.nomor 
				WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' ".$cabang." ".$asal." ".$tujuan." ".$pendapatan." ".$jenis."  ".$tipe." ".$status." ".$customer." ");
			// return $data[0]->nopol;
			for ($i=0; $i <count($data) ; $i++) { 
				 
				$nopol[$i] = DB::select("SELECT nopol from delivery_order where nopol = '".$data[$i]->nopol."' ");

			}
			// return $nopol;
    		return view('purchase/master/master_penjualan/laporan/do_total/detail_nopol/ajax_lap_nopol',compact('data','nopol'));
    		}
    	//endd 

    		//ajax cari detail mopbil
    		public function ajaxcarideliveryorder_total_detailmobil(Request $request)
    		{
    		if ($request->asal != '') {
			$asal_fil = (int)$request->asal;
			$asal = ' AND d.id_kota_asal = '.$asal_fil.'';
			}else{
				$asal = '';
			}
			//tujuan
			if ($request->tujuan != '') {
				$tujuan = " AND d.id_kota_tujuan = '".(int)$request->tujuan."' ";
			}else{
				$tujuan = '';
			}
			//cabang
			if ($request->cabang != '') {
				$cabang = " AND d.kode_cabang = '".$request->cabang."' ";
			}else{
				$cabang ='';
			}
			//tipe
			if ($request->tipe != '') {
				$tipe = " AND d.type_kiriman = '".$request->tipe."' ";
			}else{
				$tipe ='';
			}
			
			if ($request->status != '' || $request->status != null) {
				$status = " AND d.status = '".$request->status."' ";
			}else{
				$status = '';
			}
			
			if ($request->pendapatan != '' || $request->pendapatan != null) {
				$pendapatan = " AND d.pendapatan = '".$request->pendapatan."' ";
			}else{
				$pendapatan = '';
			}

			if ($request->jenis != '' || $request->jenis != null) {
				$jenis = " AND d.jenis_pengiriman = '".$request->jenis."' ";
			}else{
				$jenis = '';
			}
			
			if ($request->customer != '' || $request->customer != null) {
			$customer = " AND d.kode_customer = '".$request->customer."' ";
			}else{
				$customer = '';
			}
				
			$min = $request->min;
			$max = $request->max;
			
			

			$data  = DB::select("SELECT d.jumlah,d.kode_satuan,kn.merk,kn.nopol as knnop,kn.jenis_bak,d.id_kendaraan,d.kode_customer,d.pendapatan,d.total_dpp,d.total_vendo,cc.nama as cab,d.total_net,d.type_kiriman,d.jenis_pengiriman,c.nama as cus,d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total,d.deskripsi	 
				FROM delivery_order as d 
				LEFT JOIN kota k ON k.id=d.id_kota_asal
	            LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
	            join customer c on d.kode_customer = c.kode 
	            join cabang cc on d.kode_cabang = cc.kode 
	            left join kendaraan kn on d.id_kendaraan = kn.id 
	            -- left join delivery_orderd dd on dd.dd_nomor = d.nomor 
				WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' ".$cabang." ".$asal." ".$tujuan." ".$pendapatan." ".$jenis."  ".$tipe." ".$status." ".$customer." ");
			// return $data[0]->nopol;
			for ($i=0; $i <count($data) ; $i++) { 
				 
				$mobil[$i] = DB::select("SELECT id,merk,nopol,jenis_bak from kendaraan where id = '".$data[$i]->id_kendaraan."' ");

			}
			// return $mobil;
    		return view('purchase/master/master_penjualan/laporan/do_total/detail_mobil/ajax_lap_mobil',compact('data','mobil'));
    		}
    	//endd 

    		//laporan master detail delivery order total
    	
    		public function ajaxcarideliveryorder_total_detailsales(Request $request)
    		{
    		// dd($request->all());
    		if ($request->asal != '') {
			$asal_fil = (int)$request->asal;
			$asal = ' AND d.id_kota_asal = '.$asal_fil.'';
			}else{
				$asal = '';
			}
			//tujuan
			if ($request->tujuan != '') {
				$tujuan = " AND d.id_kota_tujuan = '".(int)$request->tujuan."' ";
			}else{
				$tujuan = '';
			}
			//cabang
			if ($request->cabang != '') {
				$cabang = " AND d.kode_cabang = '".$request->cabang."' ";
			}else{
				$cabang ='';
			}
			//tipe
			if ($request->tipe != '') {
				$tipe = " AND d.type_kiriman = '".$request->tipe."' ";
			}else{
				$tipe ='';
			}
			
			if ($request->status != '' || $request->status != null) {
				$status = " AND d.status = '".$request->status."' ";
			}else{
				$status = '';
			}
			
			if ($request->pendapatan != '' || $request->pendapatan != null) {
				$pendapatan = " AND d.pendapatan = '".$request->pendapatan."' ";
			}else{
				$pendapatan = '';
			}

			if ($request->jenis != '' || $request->jenis != null) {
				$jenis = " AND d.jenis_pengiriman = '".$request->jenis."' ";
			}else{
				$jenis = '';
			}
			
			if ($request->customer != '' || $request->customer != null) {
			$customer = " AND d.kode_customer = '".$request->customer."' ";
			}else{
				$customer = '';
			}
				
			$min = $request->min;
			$max = $request->max;
			

			$data  = DB::select("SELECT d.jumlah,d.kode_satuan,d.kode_marketing,d.kode_customer,d.pendapatan,d.total_dpp,d.total_vendo,cc.nama as cab,d.total_net,d.type_kiriman,d.jenis_pengiriman,c.nama as cus,d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total,d.deskripsi	 
				FROM delivery_order as d 
				LEFT JOIN kota k ON k.id=d.id_kota_asal
	            LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
	            join customer c on d.kode_customer = c.kode 
	            join cabang cc on d.kode_cabang = cc.kode 

				WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' ".$cabang." ".$asal." ".$tujuan." ".$pendapatan." ".$jenis."  ".$tipe." ".$status." ".$customer." ");
			$cek =	DB::select("SELECT d.kode_marketing 
				FROM delivery_order as d 
				LEFT JOIN kota k ON k.id=d.id_kota_asal
	            LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
	            join customer c on d.kode_customer = c.kode 
	            join cabang cc on d.kode_cabang = cc.kode 

				WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' ".$cabang." ".$asal." ".$tujuan." ".$pendapatan." ".$jenis."  ".$tipe." ".$status." ".$customer." group by d.kode_marketing");
			for ($i=0; $i <count($cek) ; $i++) { 
				$marketing[$i] = DB::table('marketing')->where('kode','=',$cek[$i]->kode_marketing)->get(); 
			}
			for ($i=0; $i <count($data) ; $i++) { 
				$total[$i] = $data[$i]->total_net;
			}
			$total = array_sum($total);

			// return $customer_foreach;
    				return view('purchase/master/master_penjualan/laporan/do_total/detail_sales/ajax_lap_detailsales',compact('total','data','marketing','min','max','asal','tujuan','cabang','tipe','status','pendapatan','jenis'));
    		}

    	//end off

//START DELIVERY ORDER LAPORAN PAKET(DO)

	public function deliveryorder(){
		$data =DB::table('delivery_order as do')
				->select('do.*','ka.id as kaid','kt.id as ktid','ka.nama as asal','kt.nama as tujuan','kc.nama as kecamatan')
				->join('kota as ka','do.id_kota_asal','=','ka.id')
				->join('kota as kt','do.id_kota_tujuan','=','kt.id')
				->join('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
				->where('pendapatan','=','PAKET')
				->take(1000)
				->get();

		$ket = DB::table('tarif_cabang_sepeda')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$kota1 = DB::select("SELECT id, nama as asal from kota");
		$cabang = DB::select("SELECT kode, nama from cabang");
		return view('purchase/master/master_penjualan/laporan/lap_deliveryorder_paket',compact('cabang','data','kota','kota1','ket','count_get_data','arraybulan_dokumen','arraybulan_kilogram','arraybulan_koli','arraybulan_sepeda'));
	}
	public function cari_paket(Request $request){
		// dd($request->all());
		$awal = $request->a;
		$akir = $request->b;
		$cabang = $request->c;
		if ($cabang == '') {
			$data =DB::table('delivery_order as do')
					->where('pendapatan','=','PAKET')
					->where('type_kiriman','=','DOKUMEN')
					->where('tanggal','>=',$awal)
					->where('tanggal','<=',$akir)
					->get();

			$data1 =DB::table('delivery_order as do')
					->where('pendapatan','=','PAKET')
					->where('type_kiriman','=','KILOGRAM')
					->where('tanggal','>=',$awal)
					->where('tanggal','<=',$akir)
					->get();

			$data2 =DB::table('delivery_order as do')
					->where('pendapatan','=','PAKET')
					->where('type_kiriman','=','KOLI')
					->where('tanggal','>=',$awal)
					->where('tanggal','<=',$akir)
					->get();

			$data3 =DB::table('delivery_order as do')
					->where('pendapatan','=','PAKET')
					->where('type_kiriman','=','SEPEDA')
					->where('tanggal','>=',$awal)
					->where('tanggal','<=',$akir)
					->get();
		}else{
			$data =DB::table('delivery_order as do')
					->where('pendapatan','=','PAKET')
					->where('type_kiriman','=','DOKUMEN')
					->where('tanggal','>=',$awal)
					->where('tanggal','<=',$akir)
					->where('kode_cabang','=',$cabang)
					->get();

			$data1 =DB::table('delivery_order as do')
					->where('pendapatan','=','PAKET')
					->where('type_kiriman','=','KILOGRAM')
					->where('tanggal','>=',$awal)
					->where('tanggal','<=',$akir)
					->where('kode_cabang','=',$cabang)
					->get();

			$data2 =DB::table('delivery_order as do')
					->where('pendapatan','=','PAKET')
					->where('type_kiriman','=','KOLI')
					->where('tanggal','>=',$awal)
					->where('tanggal','<=',$akir)
					->where('kode_cabang','=',$cabang)
					->get();

			$data3 =DB::table('delivery_order as do')
					->where('pendapatan','=','PAKET')
					->where('type_kiriman','=','SEPEDA')
					->where('tanggal','>=',$awal)
					->where('tanggal','<=',$akir)
					->where('kode_cabang','=',$cabang)
					->get();
		}
		// return $data;
		if ($data != null) {
			for ($i=0; $i <count($data) ; $i++) { 
				$dat[$i] = $data[$i]->total_net; 		
			}
			$data = array_sum($dat);
		}else{
			$data = 0;
		}	
		if ($data1 != null) {
			for ($i=0; $i <count($data1) ; $i++) { 
				$dat1[$i] = $data1[$i]->total_net; 		
			}
			$data1 = array_sum($dat1);
		}else{
			$data1 = 0;
		}
		if ($data2 != null) {
			for ($i=0; $i <count($data2) ; $i++) { 
				$dat2[$i] = $data2[$i]->total_net; 		
			}
			$data2 = array_sum($dat2);
		}else{
			$data2 = 0;
		}
		if ($data3 != null) {
			for ($i=0; $i <count($data3) ; $i++) { 
				$dat3[$i] = $data3[$i]->total_net; 		
			}
			$data3 = array_sum($dat3);
		}else{
			$data3 = 0;
		}	
		// return $data;
			
		if ($data != null || $data1 != null || $data2 != null || $data3 != null) {
        	return response()->json(['dokumen'=>$data,'kilogram'=>$data1,'koli'=>$data2,'sepeda'=>$data3,'awal'=> $awal,'akir' => $akir]);			
		}else{
			return response()->json(['response'=>'Data Tidak Ditemukan','awal'=> $awal,'akir' => $akir]);
		}		


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
						->leftjoin('kota as ka','do.id_kota_asal','=','ka.id')
						->leftjoin('kota as kt','do.id_kota_tujuan','=','kt.id')
						->leftjoin('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
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
						->leftjoin('kota as ka','do.id_kota_asal','=','ka.id')
						->leftjoin('kota as kt','do.id_kota_tujuan','=','kt.id')
						->leftjoin('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
						->where('nomor','like','%KGO%')
						->get();

		$array_bulan = ['1','2','3','4','5','6','7','8','9','10','11','12'];
		$date = carbon::now();
		$tahun = $date->year;
		
		for ($i=0; $i <count($array_bulan) ; $i++) { 
			 $dat[$i] = DB::table('delivery_order')
				 		->select('total_net','tanggal','pendapatan')
				 		->where('pendapatan','=','KARGO')
				 		->whereMonth('tanggal','=',$array_bulan[$i])
				 		->whereYear('tanggal','=',$tahun)
				 		->get();
		}	
		
		for ($i=0; $i <count($dat) ; $i++) { 
			if ($dat[$i] != null) {
				for ($j=0; $j <count($dat[$i]); $j++) {
					$hitung[$i][$j] = $dat[$i][$j]->total_net;
				}
			}else{
				$hitung[$i] = 0;
			}
		}

		for ($i=0; $i <count($hitung) ; $i++) {
			if ($hitung[$i] != null) {
				for ($j=0; $j <count($hitung[$i]) ; $j++) {
					$kargo[$i] = array_sum($hitung[$i]);
				}
			}else{
					$kargo[$i] = 0;
			}
			
		}

		$ket = DB::table('tarif_cabang_sepeda')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$kota1 = DB::select("SELECT id, nama as asal from kota");
		return view('purchase/master/master_penjualan/laporan/lap_deliveryorder_kargo',compact('data','kota','kota1','ket','kargo'));
	}

	public function carideliveryorder_kargo(Request $request){
		// dd($request->all());
		$awal = $request->a;
		$akir = $request->b;
		$data =DB::table('delivery_order as do')
				->where('pendapatan','=','KARGO')
				->where('tanggal','>=',$awal)
				->where('tanggal','<=',$akir)
				->get();

		for ($i=0; $i <count($data); $i++) { 
			$dat[$i] = $data[$i]->total_net;

			$array = array_sum($dat);

		}
		// return $array;
				
		
		
		if ($data != null) {
        	return  response()->json(['data'=>$array,'awal'=> $awal,'akir' => $akir]);
		}else{
			return response()->json(['response'=>'Data Tidak Ditemukan !','awal'=> $awal,'akir' => $akir]);
		}

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
						->leftjoin('delivery_orderd as dk','do.nomor','=','dk.dd_nomor')
						->where('do.pendapatan','like','KORAN')
						->get();

		$array_bulan = ['1','2','3','4','5','6','7','8','9','10','11','12'];
		$date = carbon::now();
		$tahun = $date->year;
		// return $array_bulan;
		for ($i=0; $i <count($array_bulan) ; $i++) { 
			$dat[$i] = DB::table('delivery_order')
					->select('tanggal','total_net','pendapatan')
					->whereMonth('tanggal','=',$array_bulan[$i])
					->whereYear('tanggal','=',$tahun)
					->where('pendapatan','=','KORAN')
					->get();
		}		

		for ($i=0; $i <count($dat) ; $i++) { 
			if ($dat[$i] != null) {
				for ($j=0; $j <count($dat[$i]); $j++) {
					$hitung[$i][$j] = $dat[$i][$j]->total_net;
				}
			}else{
				$hitung[$i] = 0;
			}
		}

		for ($i=0; $i <count($hitung) ; $i++) {
			if ($hitung[$i] != null) {
				for ($j=0; $j <count($hitung[$i]) ; $j++) {
					$koran[$i] = array_sum($hitung[$i]);
				}
			}else{
					$koran[$i] = 0;
			}	
		}

		// return $koran;


		$ket = DB::table('tarif_cabang_sepeda')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$sat = DB::table('satuan')->get();
		$kota1 = DB::select("SELECT id, nama as asal from kota");
		return view('purchase/master/master_penjualan/laporan/lap_deliveryorder_koran',compact('data','kota','kota1','ket','sat','koran'));
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
	public function cari_deliveryorder_koran(Request $request){
		$awal = $request->a;
		$akir = $request->b;
		$data =DB::table('delivery_order as do')
				->where('pendapatan','=','KORAN')
				->where('tanggal','>=',$awal)
				->where('tanggal','<=',$akir)
				->get();

		for ($i=0; $i <count($data); $i++) { 
			$dat[$i] = $data[$i]->total_net;

			$array = array_sum($dat);

		}
		// return $array;
				
		
		
		if ($data != null) {
        	return  response()->json(['data'=>$array,'awal'=> $awal,'akir' => $akir]);
		}else{
			return response()->json(['response'=>'Data Tidak Ditemukan !','awal'=> $awal,'akir' => $akir]);
		}
	}
// END OF DELIVERY ORDER LAPORAN KORAN(DO)

   // START INVOICE

	public function invoice(){
		// return 'a';

		$data = DB::table('invoice')->get();
		// return $data;
		$array_bulan = ['1','2','3','4','5','6','7','8','9','10','11','12'];
		$tahun = carbon::now();
		$tahun =  $tahun->year;

		for ($i=0; $i <count($array_bulan) ; $i++) { 
			$dat[$i] =	DB::table('invoice')
						->select('i_tanggal','i_total')
						->whereMonth('i_tanggal','=',$array_bulan[$i])
						->whereYear('i_tanggal','=',$tahun)
						->get();
		}
		
		for ($i=0; $i < count($dat); $i++) { 
			if ($dat[$i] != null) {
				for ($a=0; $a < count($dat[$i]); $a++) { 
					$anjay[$i][$a] = $dat[$i][$a]->i_total;
				}
			}else{
				$anjay[$i] = 0;
			}
		}
		

		for ($i=0; $i < count($anjay); $i++) { 
			if ($anjay[$i] != 0) {
				for ($a=0; $a < count($anjay[$i]); $a++) { 
					$invoice[$i] = array_sum($anjay[$i]);
				}
			}else{
				$invoice[$i] = 0;
			}
		}
		// return $invoice;
		$cust = DB::table('invoice')
						->select('i_kode_customer','customer.nama as cus')
						->join('customer','customer.kode','=','invoice.i_kode_customer')
						->get();

		// return $cust;
		$ket = DB::table('tarif_cabang_sepeda')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$cus = DB::table('customer')->get();
		$cabang = DB::table('cabang')->get();
		$kota1 = DB::select("SELECT id, nama as asal from kota");

		return view('purchase/master/master_penjualan/laporan/lap_invoice',compact('cabang','data','kota','kota1','ket','cus','invoice','cust'));
	}

	public function carireport_invoice(Request $request){
		$awal = $request->awal;
		$akir = $request->akir;
		$customer = $request->customer;


		if ($request->customer != '' || $request->customer != null) {
			$customer_invoice = " AND i_kode_customer = '".$request->customer."' ";
		}else{
			$customer_invoice = '';
		}
		if ($request->akun != '' || $request->akun != null) {
			$akun_invoice = " AND i_acc_piutang = '".$request->akun."' ";
		}else{
			$akun_invoice = '';
		}
		if ($request->cabang != '' || $request->cabang != null) {
			$cabang_invoice = " AND i_kode_cabang = '".$request->cabang."' ";
		}else{
			$cabang_invoice = '';
		}


		$data = DB::select("SELECT * from invoice
							where i_tanggal >= '$awal' AND i_tanggal  <= '$akir' $customer_invoice $cabang_invoice");
		// return $data;
		$cust = DB::select("SELECT invoice.i_kode_customer,customer.nama as cus from invoice
							left join customer on customer.kode = invoice.i_kode_customer
							where i_tanggal >= '$awal' AND i_tanggal  <= '$akir' $customer_invoice $cabang_invoice
							group by i_kode_customer,customer.nama");
		// return $cust;
		
			

		// $cabang   = $request->cabang;

		// if ($customer != '') {
		// 	$customer = 'and i_kode_customer = '."'$customer'";
		// }else{
		// 	$customer = '';
		// }


		// if ($cabang != '') {
		// 	$cabang = 'and i_kode_cabang = '."'$cabang'";
		// }else{
		// 	$cabang = '';
		// }

		// $sql1 = "SELECT * FROM invoice where i_nomor != '0' and i_tanggal >= '$awal' and i_tanggal <= '$akir' $customer";


		// $sql2 = "SELECT i_kode_customer, customer.nama as cus FROM invoice 
		// 		 join customer on customer.kode = invoice.i_kode_customer 
		// 		 where i_nomor != '0' $customer $cabang
		// 		 group by i_kode_customer,customer.nama";

		// $data = DB::select($sql1);
		// $cust = DB::select($sql2);




		$ket = DB::table('tarif_cabang_sepeda')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$cus = DB::table('customer')->get();
		$kota1 = DB::select("SELECT id, nama as asal from kota");
		return view('purchase/master/master_penjualan/pdf/pdf_invoice',compact('data','cust','ket','kota','cus','kota1'));
		
		}



	public function carientry_invoice(Request $request)
	{
		
			// dd($request->all());
			$awal = $request->awal;
			$akir = $request->akir;

			if ($request->customer != '') {
				$customer = " AND i.id_kode_customer = '".$request->customer."' ";
			}else{
				$customer = '';
			}
			//tujuan
			if ($request->cabang != '') {
				$cabang = " AND i.id_kode_cabang = '".$request->cabang."' ";
			}else{
				$cabang = '';
			}
	
			$data = DB::select("SELECT i.i_kode_cabang,count(i.i_nomor) as total_nomor,sum(i.i_total_tagihan) as total_tagihan ,sum(i.i_diskon1) as diskon
				,sum(i.i_netto) as netto,sum(i.i_total) as dpp,sum(i.i_ppnrp) as ppn
				FROM invoice i 
				WHERE i_tanggal >= '".$awal."' AND i_tanggal <= '".$akir."'  ".$cabang."  ".$customer." 

				group by i.i_kode_cabang order by i_kode_cabang");
			// return $data;
			//cabang
		 return view('purchase/master/master_penjualan/laporan/invoice/entry/lap_entryinvoice',compact('cabang','data','kota','kota1','ket','cus','invoice','cust'));
			


	}

	public function reportinvoice(Request $request){
		
		// dd($request->all());
		$awal = $request->awal;
		$akir = $request->akir;
		$customer = $request->customer;
		if ($customer != '') {
			$data = DB::table('invoice')
				->where('i_tanggal','>=',$awal)
				->where('i_tanggal','<=',$akir)
				->where('i_kode_customer','=',$customer)
				->get();
			$cust = DB::table('invoice')->select('i_kode_customer','customer.nama as cus')->join('customer','customer.kode','=','invoice.i_kode_customer')->where('i_kode_customer','=',$customer)->groupBy('i_kode_customer','customer.nama')->get();
		}else{
			$data = DB::table('invoice')
				->where('i_tanggal','>=',$awal)
				->where('i_tanggal','<=',$akir)
				->get();
			$cust = DB::table('invoice')->select('i_kode_customer','customer.nama as cus')->join('customer','customer.kode','=','invoice.i_kode_customer')->groupBy('i_kode_customer','customer.nama')->get();
		}
				
		$ket = DB::table('tarif_cabang_sepeda')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$cus = DB::table('customer')->get();
		$kota1 = DB::select("SELECT id, nama as asal from kota");

		return view('purchase/master/master_penjualan/pdf/pdf_invoice',compact('data','cust','ket','kota','cus','kota1'));
		
		}
		public function excelinvoice(Request $request){
		$awal = $request->awal;
		$akir = $request->akir;
		$customer = $request->customer;
		if ($customer != '') {
			$data = DB::table('invoice')
				->where('i_tanggal','>=',$awal)
				->where('i_tanggal','<=',$akir)
				->where('i_kode_customer','=',$customer)
				->get();
			$cust = DB::table('invoice')->select('i_kode_customer','customer.nama as cus')->join('customer','customer.kode','=','invoice.i_kode_customer')->where('i_kode_customer','=',$customer)->groupBy('i_kode_customer','customer.nama')->get();
		}else{
			$data = DB::table('invoice')
				->where('i_tanggal','>=',$awal)
				->where('i_tanggal','<=',$akir)
				->get();
			$cust = DB::table('invoice')->select('i_kode_customer','customer.nama as cus')->join('customer','customer.kode','=','invoice.i_kode_customer')->groupBy('i_kode_customer','customer.nama')->get();
		}

		for ($i=0; $i <count($data) ; $i++) { 
			$data0[$i] = $data[$i]->i_total;
			$data1[$i] = $data[$i]->i_diskon1;
			$data2[$i] = $data[$i]->i_diskon2;
			$data3[$i] = $data[$i]->i_ppnrp;
			$data4[$i] = $data[$i]->i_pajak_lain;
			$data5[$i] = $data[$i]->i_netto;
			$data6[$i] = $data[$i]->i_netto_detail;
			$data7[$i] = $data[$i]->i_total_tagihan;
		}
		$total_0 = array_sum($data0);
		$total_1 = array_sum($data1);
		$total_2 = array_sum($data2);
		$total_3 = array_sum($data3);
		$total_4 = array_sum($data4);
		$total_5 = array_sum($data5);
		$total_6 = array_sum($data6);
		$total_7 = array_sum($data7);
		// return $data2;
		$ket = DB::table('tarif_cabang_sepeda')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$cus = DB::table('customer')->get();
		$kota1 = DB::select("SELECT id, nama as asal from kota");

		$date =  date('B'.'s'.'H');

				   			Excel::create('Invoice'.$date, function($excel) use ($data,$cust,$ket,$kota,$cus,$kota1,$total_0,$total_1,$total_2,$total_3,$total_4,$total_5,$total_6,$total_7){

								    $excel->sheet('New sheet', function($sheet) use ($data,$cust,$ket,$kota,$cus,$kota1,$total_0,$total_1,$total_2,$total_3,$total_4,$total_5,$total_6,$total_7) {
								        $sheet->loadView('purchase/master/master_penjualan/excel/excel_invoice')
								        ->with('data',$data)
								        ->with('cust',$cust)
								        ->with('ket',$ket)
								        ->with('kota',$kota)
								        ->with('cus',$cus)
								        ->with('kota1',$kota1)
								        ->with('total_0',$total_0)
								        ->with('total_1',$total_1)
								        ->with('total_2',$total_2)
								        ->with('total_3',$total_3)
								        ->with('total_4',$total_4)
								        ->with('total_5',$total_5)
								        ->with('total_6',$total_6)
								        ->with('total_7',$total_7);
								    });

								})->download('csv');
		}

		public function cari_lap_invoice(Request $request){

		$awal = $request->a;
		$akir = $request->b;
		$cabang = $request->c;
		$customer = $request->d;
		if ($cabang == null && $customer == null) {
			$data = DB::table('invoice')
				->select('i_tanggal','i_kode_cabang','i_total_tagihan')
				->where('i_tanggal','>=',$awal)
				->where('i_tanggal','<=',$akir)
				->get();

		
			for ($i=0; $i <count($data); $i++) { 
				$dat[$i] = $data[$i]->i_total_tagihan;

				$array = array_sum($dat);

			}
			// return $array;
		}elseif ($cabang != null && $customer != null) {
			return 'a';
			$data = DB::table('invoice')
				->select('i_tanggal','i_kode_cabang','i_total_tagihan','i_kode_customer')
				->where('i_tanggal','>=',$awal)
				->where('i_tanggal','<=',$akir)
				->where('i_kode_cabang','<=',$cabang)
				->where('i_kode_customer','<=',$customer)
				->get();

			for ($i=0; $i <count($data); $i++) { 
				$dat[$i] = $data[$i]->i_total_tagihan;

				$array = array_sum($dat);

			}
		}elseif($cabang == null && $customer != null) {
			// return 'b';
			$data = DB::table('invoice')
				->select('i_tanggal','i_kode_cabang','i_total_tagihan','i_kode_customer')
				->where('i_tanggal','>=',$awal)
				->where('i_tanggal','<=',$akir)
				->where('i_kode_customer','=',$customer)
				->get();

		
			for ($i=0; $i <count($data); $i++) { 
				$dat[$i] = $data[$i]->i_total_tagihan;

				$array = array_sum($dat);

			}
			// return $array;
		}elseif ($cabang != null && $customer == null) {
			// return 'c';
			$data = DB::table('invoice')
				->select('i_tanggal','i_kode_cabang','i_total_tagihan','i_kode_customer')
				->where('i_tanggal','>=',$awal)
				->where('i_tanggal','<=',$akir)
				->where('i_kode_cabang','=',$cabang)
				->get();

		
			for ($i=0; $i <count($data); $i++) { 
				$dat[$i] = $data[$i]->i_total_tagihan;

				$array = array_sum($dat);

			}
		}
		if ($data != null) {
        	return  response()->json(['data'=>$array,'awal'=> $awal,'akir' => $akir]);
		}else{
			return response()->json(['response'=>'Data Tidak Ditemukan !','awal'=> $awal,'akir' => $akir]);
		}

	}

		




	// END OF INVOICE

	


	//START KWITANSI

	public function kwitansi(){
		// return 'a';
		$data = DB::table('kwitansi')->get();
		$customer = DB::table('customer')->get();
		$cabang = DB::table('cabang')->get();
		$ket = DB::table('tarif_cabang_sepeda')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$cus = DB::table('customer')->get();
		$kota1 = DB::select("SELECT id, nama as asal from kota");
		return view('purchase/master/master_penjualan/laporan/lap_kwitansi',compact('data','kota','kota1','ket','cus','customer','cabang'));
	}

	public function FunctionName($value='')
	{
		# code...
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
			$data = DB::table('d_disc_cabang')->select('d_disc_cabang.*','cabang.nama as cabang')->join('cabang','cabang.kode','=','d_disc_cabang.dc_cabang')->get();
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
			  $dat1[$i] = DB::table('d_disc_cabang')->select('d_disc_cabang.*','cabang.nama as cabang')->join('cabang','cabang.kode','=','d_disc_cabang.dc_cabang')->where('dc_id','=',$dat[$i])->get();
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

	public function dopo(){
		return view('/delivery_order');
	}

	
	//KARTU PIUTANG 

   public function kartupiutang(){
   		
   		
   		$ds = DB::table('kwitansi')
   			->select('k_create_by','k_nomor','k_kode_customer','k_tanggal','k_keterangan','k_netto','nomor')
   			->join('posting_pembayaran_d','posting_pembayaran_d.nomor_penerimaan_penjualan','=','kwitansi.k_nomor')
   			->join('posting_pembayaran','posting_pembayaran.nomor','=','posting_pembayaran_d.nomor_posting_pembayaran')->get();
   		$customer = DB::table('customer')->orderBy('kode','ASC')->get();
   		if (Auth::user()->punyaAkses('Laporan Penjualan','cabang')) {
   			$cabang = DB::table('cabang')->orderBy('kode','ASC')->get();
   		}else{
   			$cabang = DB::table('cabang')
   						->where('kode',Auth::user()->kode_cabang)
   						->orderBy('kode','ASC')->get();
   		}

   		if (Auth::user()->punyaAkses('Laporan Penjualan','cabang')) {
   			$piutang = DB::table('d_akun')
   						->where(function ($query) {
			                $query->Where('id_akun','like','13%');
			    		})
			    		->orderBy('id_akun','ASC')
   						->get();
   		}else{
   			$piutang = DB::table('d_akun')
   						->where(function ($query) {
			                $query->Where('id_akun','like','13%');
			                $query->Where('kode_cabang',Auth::user()->kode_cabang);
			    		})
			    		->orderBy('id_akun','ASC')
   						->get();
   		}

   		

   		return view('purchase/master/master_penjualan/laporan/lap_piutang/lap_piutang',compact('data','data_i','data_p','customer','cabang','piutang'));
   }
   public function cari_kartupiutang(Request $request){

   		$cabangr = $request->cabang;
   		$minr = $request->min;
   		$maxr = $request->max;
   		$akunr = $request->akun;
   		$customerr = $request->customer;
   		$jenis = $request->jenis;


   		if ($cabangr == '0' or $cabangr == 'Semua Cabang') {
   			$cabangr = 'Semua Cabang';
   		}else{
   			$cabangr = DB::table('cabang')
		   					->where('kode',$cabangr)
		   					->first();
   		}

   		if ($customerr == '0' or $customerr == 'Semua Customer') {
   			$customerr = 'Semua Customer';
   		}else{
   			$customerr = DB::table('customer')
		   					->where('kode',$customerr)
		   					->first();
   		}

   		if ($akunr == '0' or $akunr == 'Semua Akun') {
   			$akunr = 'Semua Akun Piutang';
   		}else{
   			$akunr = DB::table('d_akun')
   					->where('id_akun',$akunr)
   					->first();
   		}

   		$cabangs = DB::table('cabang')
   					->where('kode',$request->cabang)
   					->first();

   		$customers = DB::table('customer')
   					->where('kode',$request->customer)
   					->first();

   		$akuns = DB::table('d_akun')
   					->where('id_akun',$request->akun)
   					->first();


   		if ($customers != null) {
   			$customer_select = "and i_kode_customer = '$customers->kode'";
   		}else{
   			$customer_select = '';
   		}

   		if ($akuns != null) {
   			$akun_piutang = "and i_acc_piutang = '$akuns->id_akun'";
   		}else{
   			$akun_piutang = "";
   		}

   		if ($cabangs != null) {
   			$cabang_select = "and i_kode_cabang = '$cabangs->kode'";
   		}else{
   			$cabang_select = "";
   		}
   		/////////////////////////////////////////////////////////////////////////////
  		if ($jenis == 'hirarki') {
  			$cabang = DB::table('cabang')
						->join('invoice','i_kode_cabang','=','kode')
						->selectRaw('sum(i_total_tagihan),cabang.nama as nama,
						(SELECT sum(i_total_tagihan - i_sisa_pelunasan - i_kredit) as kredit),
						(SELECT sum(i_total_tagihan+i_debet) as debet),i_kode_cabang')
						->where('i_tanggal','>=',$request->min)
						->where('i_tanggal','<=',$request->max)
						->whereRaw("i_nomor != '0' $akun_piutang $customer_select $cabang_select")
						->groupBy('i_kode_cabang','nama')
						->orderBy('i_kode_cabang','ASC')
						->get();

			for ($z=0; $z < count($cabang); $z++) { 
				$cabang_satuan = $cabang[$z]->i_kode_cabang;
				$akun[$z] = DB::table('invoice')
							  ->join('d_akun','id_akun','=','i_acc_piutang')
							  ->selectRaw('sum(i_total_tagihan),d_akun.nama_akun as nama,
							  (SELECT sum(i_total_tagihan - i_sisa_pelunasan - i_kredit) as kredit),
							  (SELECT sum(i_total_tagihan+i_debet) as debet),id_akun')
							  ->where('i_tanggal','>=',$request->min)
							  ->where('i_tanggal','<=',$request->max)
							  ->whereRaw("i_kode_cabang = '$cabang_satuan' $akun_piutang")
							  ->groupBy('i_acc_piutang','id_akun')
							  ->orderBy('i_acc_piutang','ASC')
							  ->get();

				for ($i=0; $i < count($akun[$z]); $i++) { 
					$customer[$z][$i] = DB::table('invoice')
										  ->join('customer','kode','=','i_kode_customer')
										  ->selectRaw('sum(i_total_tagihan),customer.nama as nama,
										  (SELECT sum(i_total_tagihan - i_sisa_pelunasan - i_kredit) as kredit),
										  (SELECT sum(i_total_tagihan+i_debet) as debet),i_kode_customer')
										  ->where('i_acc_piutang',$akun[$z][$i]->id_akun)
										  ->where('i_kode_cabang',$cabang[$z]->i_kode_cabang)
										  ->where('i_tanggal','>=',$request->min)
										  ->where('i_tanggal','<=',$request->max)
										  ->whereRaw("i_kode_cabang != '0' $customer_select")
										  ->groupBy('i_kode_customer','nama')
										  ->orderBy('i_kode_customer','ASC')
										  ->get();

					for ($a=0; $a < count($customer[$z][$i]); $a++) { 
						$invoice[$z][$i][$a] = DB::table('invoice')
				   								  ->selectRaw('i_total_tagihan,
				   								  (SELECT sum(i_total_tagihan - i_sisa_pelunasan - i_kredit) as kredit),
				   								  (SELECT sum(i_total_tagihan+i_debet) as debet),i_kode_cabang,i_keterangan,i_nomor')
												  ->where('i_kode_cabang',$cabang[$z]->i_kode_cabang)
				   								  ->where('i_kode_customer',$customer[$z][$i][$a]->i_kode_customer)
										  		  ->where('i_acc_piutang',$akun[$z][$i]->id_akun)
				   								  ->where('i_tanggal','>=',$request->min)
												  ->where('i_tanggal','<=',$request->max)
				   								  ->groupBy('i_nomor')
				   								  ->orderBy('i_nomor','ASC')
				   								  ->get();
					}

				}
			}
  		}else if ($jenis == 'customer') {
  			$customer = DB::table('invoice')
						  ->join('customer','kode','=','i_kode_customer')
						  ->selectRaw('sum(i_total_tagihan),customer.nama as nama,
						  (SELECT sum(i_total_tagihan - i_sisa_pelunasan - i_kredit) as kredit),
						  (SELECT sum(i_total_tagihan+i_debet) as debet),i_kode_customer')
						  ->where('i_tanggal','>=',$request->min)
						  ->where('i_tanggal','<=',$request->max)
						  ->whereRaw("i_nomor != '0' $customer_select $akun_piutang $cabang_select")
						  ->groupBy('i_kode_customer','nama')
						  ->orderBy('i_kode_customer','ASC')
						  ->get();
  		}else if ($jenis == 'invoice'){
  			$invoice = DB::table('invoice')
						  ->selectRaw('i_total_tagihan,
						  (SELECT sum(i_total_tagihan - i_sisa_pelunasan - i_kredit) as kredit),
						  (SELECT sum(i_total_tagihan+i_debet) as debet),i_kode_cabang,i_keterangan,i_nomor')
						  ->where('i_tanggal','>=',$request->min)
					  	  ->where('i_tanggal','<=',$request->max)
		  			      ->whereRaw("i_nomor != '0' $customer_select $akun_piutang $cabang_select")
						  ->groupBy('i_nomor')
						  ->orderBy('i_nomor','ASC')
						  ->get();
  		}else if ($jenis == 'akun'){
  			$akun = DB::table('invoice')
					  ->join('d_akun','id_akun','=','i_acc_piutang')
					  ->selectRaw('sum(i_total_tagihan),d_akun.nama_akun as nama,
					  (SELECT sum(i_total_tagihan - i_sisa_pelunasan - i_kredit) as kredit),
					  (SELECT sum(i_total_tagihan+i_debet) as debet),id_akun')
					  ->where('i_tanggal','>=',$request->min)
					  ->where('i_tanggal','<=',$request->max)
	  			      ->whereRaw("i_nomor != '0' $customer_select $akun_piutang $cabang_select")
					  ->groupBy('i_acc_piutang','id_akun')
					  ->orderBy('i_acc_piutang','ASC')
					  ->get();
  		}
		


		$customer1 = DB::table('customer')->orderBy('kode','ASC')->get();
   		if (Auth::user()->punyaAkses('Laporan Penjualan','cabang')) {
   			$cabang1 = DB::table('cabang')->orderBy('kode','ASC')->get();
   		}else{
   			$cabang1 = DB::table('cabang')
   						->where('kode',Auth::user()->kode_cabang)
   						->orderBy('kode','ASC')->get();
   		}

   		if (Auth::user()->punyaAkses('Laporan Penjualan','cabang')) {
   			$piutang1 = DB::table('d_akun')
   						->where(function ($query) {
			                $query->Where('id_akun','like','13%');
			    		})
			    		->orderBy('id_akun','ASC')
   						->get();
   		}else{
   			$piutang1 = DB::table('d_akun')
   						->where(function ($query) {
			                $query->Where('id_akun','like','13%');
			                $query->Where('kode_cabang',Auth::user()->kode_cabang);
			    		})
			    		->orderBy('id_akun','ASC')
   						->get();
   		}
   		return view('purchase/master/master_penjualan/laporan/lap_piutang/ajax_lap_piutang',compact('cabang','customer','invoice','akun','cabangr','akunr','minr','maxr','customerr','jenis','customer1','cabang1','piutang1'));
   }

   public function cari_kartupiutang_detail_customer(Request $request)
   {
   		return 'detail kartu detail customer';
   }

   public function cari_kartupiutang_akun(Request $request)
   {
   		$awal = substr($request->min,-2);
   		$akir = substr($request->max,-2);
   		//invoice
   		if ($request->customer != '' || $request->customer != null) {
			$customer_invoice = " AND i_kode_customer = '".$request->customer."' ";
		}else{
			$customer_invoice = '';
		}
		if ($request->akun != '' || $request->akun != null) {
			$akun_invoice = " AND i_acc_piutang = '".$request->akun."' ";
		}else{
			$akun_invoice = '';
		}
		if ($request->cabang != '' || $request->cabang != null) {
			$cabang_invoice = " AND i_kode_cabang = '".$request->cabang."' ";
		}else{
			$cabang_invoice = '';
		}
		//end
		//Kwitansi
		if ($request->customer != '' || $request->customer != null) {
			$customer_kwitansi = " AND k_kode_customer = '".$request->customer."' ";
		}else{
			$customer_kwitansi = '';
		}
		if ($request->akun != '' || $request->akun != null) {
			$akun_kwitansi = " AND kwitansi_d.kd_kode_akun_acc = '".$request->akun."' ";
		}else{
			$akun_kwitansi = '';
		}
		if ($request->cabang != '' || $request->cabang != null) {
			$cabang_kwitansi = " AND k_kode_cabang = '".$request->cabang."' ";
		}else{
			$cabang_kwitansi = '';
		}
		//end
		//posting pemaaran
		if ($request->customer != '' || $request->customer != null) {
			$customer_postingbayar = " AND posting_pembayaran_d.kode_customer = '".$request->customer."' ";
		}else{
			$customer_postingbayar = '';
		}
		if ($request->akun != '' || $request->akun != null) {
			$akun_postingbayar = " AND posting_pembayaran_d.kode_acc = '".$request->akun."' ";
		}else{
			$akun_postingbayar = '';
		}
		if ($request->cabang != '' || $request->cabang != null) {
			$cabang_postingbayar = " AND posting_pembayaran.kode_cabang = '".$request->cabang."' ";
		}else{
			$cabang_postingbayar = '';
		}
		//end


		$data_invoice = DB::select("SELECT i_acc_piutang as akun,sum(i_debet) as debet,sum(i_kredit) as kredit,sum(i_total_tagihan) as saldo_awal
		 								from invoice 
										where date_part('month',i_tanggal) >= '$awal' 
  										and date_part('month',i_tanggal) <= '$akir' 
		 								$customer_invoice $akun_invoice $cabang_invoice
		 								group by i_acc_piutang");

		$data_kwitansi = DB::select("SELECT 'K' as flag,kwitansi_d.kd_kode_akun_acc FROM kwitansi 
   										join kwitansi_d on kwitansi.k_nomor = kwitansi_d.kd_k_nomor
   										where date_part('month',k_tanggal) >= '$awal' 
   										and date_part('month',k_tanggal) <= '$akir'
   										$customer_kwitansi $akun_kwitansi $cabang_kwitansi
   										group by kd_kode_akun_acc");
   		
   		
   		$data_postingbayar = DB::select("SELECT 'K' as flag,kode_acc FROM kwitansi 
   										join posting_pembayaran_d on posting_pembayaran_d.nomor_penerimaan_penjualan = kwitansi.k_nomor
   										join posting_pembayaran on posting_pembayaran.nomor = posting_pembayaran_d.nomor_posting_pembayaran
   										where date_part('month',k_tanggal) >= '$awal' 
   										and date_part('month',k_tanggal) <= '$akir'
   										$customer_postingbayar $akun_postingbayar $cabang_postingbayar
   										");

   		return [$data_invoice,$data_kwitansi,$data_postingbayar];

		return view('purchase/master/master_penjualan/laporan/lap_piutang/ajax_lap_piutang_akun',compact('data_invoice'));
   }


   public function rekap_customer(){
   		$cabang = DB::table('cabang')->get();
   		return view('purchase/master/master_penjualan/laporan/do_total/rekap_customer/lap_rekapcustomer',compact('cabang'));
   }
   public function cari_rekapcustomer(Request $request){
   	// dd($request->all());
   		if ($request->asal != '') {
			$asal_fil = (int)$request->asal;
			$asal = ' AND d.id_kota_asal = '.$asal_fil.'';
		}else{
			$asal = '';
		}
		//tujuan
		if ($request->tujuan != '') {
			$tujuan = " AND d.id_kota_tujuan = '".(int)$request->tujuan."' ";
		}else{
			$tujuan = '';
		}
		//cabang
		if ($request->cabang != '') {
			$cabang = " AND d.kode_cabang = '".$request->cabang."' ";
		}else{
			$cabang ='';
		}
		//tipe
		if ($request->tipe != '') {
			$tipe = " AND d.type_kiriman = '".$request->tipe."' ";
		}else{
			$tipe ='';
		}
		//status
		if ($request->status != '' || $request->status != null) {
			$status = " AND d.status = '".$request->status."' ";
		}else{
			$status = '';
		}
		//pendapatan
		if ($request->pendapatan != '' || $request->pendapatan != null) {
			$pendapatan = " AND d.pendapatan = '".$request->pendapatan."' ";
		}else{
			$pendapatan = '';
		}
		//jenis
		if ($request->jenis != '' || $request->jenis != null) {
			$jenis = " AND d.jenis_pengiriman = '".$request->jenis."' ";
		}else{
			$jenis = '';
		}
		//customer
		if ($request->customer != '' || $request->customer != null) {
			$customer = " AND d.kode_customer = '".$request->customer."' ";
		}else{
			$customer = '';
		}
		
		$min = $request->min;
		$max = $request->max;
   		$laporan = $request->laporan;

		

 
   		if ($laporan == 'rekap') {
   			// return 'a';
   			$data_awal  = DB::select("SELECT c.nama as nama,kode_customer, sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net  from delivery_order d
			   	join customer c on d.kode_customer = c.kode
      
				WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' ".$cabang." ".$asal." ".$tujuan." ".$pendapatan." ".$jenis."  ".$tipe." ".$status." ".$customer." 
				group by d.kode_customer,c.kode
				order by d.kode_customer");

			   		
			   			if ($data_awal == null) {
			   				return response()->json(['data'=>'0']); 
			   			}else{
			   				for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat[$i] = $data_awal[$i]->total_net;
				   			}
				   			for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat1[$i] = $data_awal[$i]->total;
				   			}
				   			for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat2[$i] = $data_awal[$i]->diskon;
				   			}
				   			for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat3[$i] = $data_awal[$i]->do;
				   			}
				   			
				   			$total =  array_sum($dat1);

				   			$total_net = array_sum($dat);
				   			
				   			$diskon = array_sum($dat2);

				   			$do = array_sum($dat3);
			   			}
			   	
   		}else{
   			// return 'U';
   			$data_awal  = DB::select("SELECT c.nama as nama,kode_customer, sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net  from delivery_order d
				 join customer c on d.kode_customer = c.kode
      
				WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' ".$cabang." ".$asal." ".$tujuan." ".$pendapatan." ".$jenis."  ".$tipe." ".$status." ".$customer." 
				group by d.kode_customer,c.kode
				order by d.kode_customer");

				   			
	   			$cust = DB::select("SELECT kode_customer from delivery_order d 
	   				WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' and type_kiriman = 'DOKUMEN' 
	   				group by d.kode_customer
	   				order by d.kode_customer");	

	   			$doc = DB::select("SELECT kode_customer,sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net from delivery_order d 
	   				WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' and type_kiriman = 'DOKUMEN' 
	   				group by d.kode_customer
	   				order by d.kode_customer");	
		   			// return $doc;

	   			$kilo = DB::select("SELECT kode_customer,sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net from delivery_order d 
	   				WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' and type_kiriman = 'KILOGRAM' 
	   				group by d.kode_customer
	   				order by d.kode_customer");	

	   			$koli = DB::select("SELECT kode_customer,sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net from delivery_order d 
	   				WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' and type_kiriman = 'KOLI' 
	   				group by d.kode_customer
	   				order by d.kode_customer");	

	   			$sepeda = DB::select("SELECT kode_customer,sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net from delivery_order d 
	   				WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' and type_kiriman = 'SEPEDA' 
	   				group by d.kode_customer
	   				order by d.kode_customer");	

	   			$kargo = DB::select("SELECT kode_customer,sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net from delivery_order d 
	   				WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' and type_kiriman = 'KARGO' 
	   				group by d.kode_customer
	   				order by d.kode_customer");	

	   			$koran = DB::select("SELECT kode_customer,sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net from delivery_order d 
	   				WHERE tanggal >= '".$min."' AND tanggal <= '".$max."' and type_kiriman = 'KORAN' 
	   				group by d.kode_customer
	   				order by d.kode_customer");	

	   			if ($data_awal == null) {
	   				return response()->json(['data'=>'0']); 
	   			}else{
	   				for ($i=0; $i <count($data_awal) ; $i++) { 
		   					$dat[$i] = $data_awal[$i]->total_net;
		   			}
		   			for ($i=0; $i <count($data_awal) ; $i++) { 
		   					$dat1[$i] = $data_awal[$i]->total;
		   			}
		   			for ($i=0; $i <count($data_awal) ; $i++) { 
		   					$dat2[$i] = $data_awal[$i]->diskon;
		   			}
		   			for ($i=0; $i <count($data_awal) ; $i++) { 
		   					$dat3[$i] = $data_awal[$i]->do;
		   			}
		   			
		   			$total =  array_sum($dat1);

		   			$total_net = array_sum($dat);
		   			
		   			$diskon = array_sum($dat2);

		   			$do = array_sum($dat3);
	   			}		   		
   		}

   		return view('purchase/master/master_penjualan/laporan/do_total/rekap_customer/ajax_lap_rekapcustomer',compact('data_awal','total','total_net','diskon','do','laporan','doc','cust','kilo','koli','sepeda','koran','kargo'));
   }
   public function report_rekapcustomer(Request $request){
   		$cabang = $request->cabang;
   		$view = $request->view;
   		$awal = $request->min;
   		$akir = $request->max;

   		if ($view == 'rekap') {
			   		if ($awal == $awal && $akir == $akir && $cabang == null || '' && $view == $view) {
			   				$data_awal = DB::select("SELECT c.nama as nama,kode_customer, sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net  from delivery_order d
			   				join customer c on d.kode_customer = c.kode
			   				where tanggal>='$awal'
			   				and tanggal<='$akir'
			                group by d.kode_customer,c.kode
			                order by d.kode_customer");	
			   			if ($data_awal == null) {
			   				return response()->json(['data'=>'0']); 
			   			}else{
			   				for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat[$i] = $data_awal[$i]->total_net;
				   			}
				   			for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat1[$i] = $data_awal[$i]->total;
				   			}
				   			for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat2[$i] = $data_awal[$i]->diskon;
				   			}
				   			for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat3[$i] = $data_awal[$i]->do;
				   			}
				   			
				   			$total =  array_sum($dat);

				   			$total_net = array_sum($dat1);
				   			
				   			$diskon = array_sum($dat2);

				   			$do = array_sum($dat3);
			   			}
			   			$date =  date('B'.'s'.'H');

				   			Excel::create('Kartuhutang'.$date, function($excel) use ($data_awal,$total_net,$total,$diskon,$do){

								    $excel->sheet('New sheet', function($sheet) use ($data_awal,$total_net,$total,$diskon,$do) {
								        $sheet->loadView('purchase/master/master_penjualan/laporan/do_total/excel/excel_lap_rekapcustomer')
								        ->with('data_awal',$data_awal)
								        ->with('total_net',$total_net)
								        ->with('total',$total)
								        ->with('diskon',$diskon)
								        ->with('do',$do);
								    });

								})->download('csv');
			   		}
			   		elseif ($awal == $awal && $akir == $akir && $cabang == $cabang && $view == $view) {

			   			 $data_awal = DB::select("SELECT c.nama as nama,kode_customer, sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net  from delivery_order d
			   				join customer c on d.kode_customer = c.kode
			   				where kode_cabang = '$cabang'
			   				and tanggal>='$awal'
			   				and tanggal<='$akir'
			                group by d.kode_customer,c.kode
			                order by d.kode_customer");	
			   			if ($data_awal == null) {
			   				return response()->json(['data'=>'0']); 
			   			}else{
			   				for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat[$i] = $data_awal[$i]->total_net;
				   			}
				   			for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat1[$i] = $data_awal[$i]->total;
				   			}
				   			for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat2[$i] = $data_awal[$i]->diskon;
				   			}
				   			for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat3[$i] = $data_awal[$i]->do;
				   			}
				   			
				   			$total =  array_sum($dat);

				   			$total_net = array_sum($dat1);
				   			
				   			$diskon = array_sum($dat2);

				   			$do = array_sum($dat3);
			   			}
			   			
			   		}
			   		$date =  date('B'.'s'.'H');

				   			Excel::create('Kartuhutang'.$date, function($excel) use ($data_awal,$total_net,$total,$diskon,$do){

								    $excel->sheet('New sheet', function($sheet) use ($data_awal,$total_net,$total,$diskon,$do) {
								        $sheet->loadView('purchase/master/master_penjualan/laporan/do_total/excel/excel_lap_rekapcustomer')
								        ->with('data_awal',$data_awal)
								        ->with('total_net',$total_net)
								        ->with('total',$total)
								        ->with('diskon',$diskon)
								        ->with('do',$do);
								    });

								})->download('csv');
   		}else{
   			// return 'U';
		   			if ($awal == $awal && $akir == $akir && $cabang == null || '' && $view == $view) {
   					// return 'A';

				   				$data_awal = DB::select("SELECT c.nama as nama,kode_customer, sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net  from delivery_order d
				   				join customer c on d.kode_customer = c.kode
				   				where tanggal>='$awal'
				   				and tanggal<='$akir'
				                group by d.kode_customer,c.kode
				                order by d.kode_customer");	
				   			if ($data_awal == null) {
				   				return response()->json(['data'=>'0']); 
				   			}else{
				   				for ($i=0; $i <count($data_awal) ; $i++) { 
					   					$dat[$i] = $data_awal[$i]->total_net;
					   			}
					   			for ($i=0; $i <count($data_awal) ; $i++) { 
					   					$dat1[$i] = $data_awal[$i]->total;
					   			}
					   			for ($i=0; $i <count($data_awal) ; $i++) { 
					   					$dat2[$i] = $data_awal[$i]->diskon;
					   			}
					   			for ($i=0; $i <count($data_awal) ; $i++) { 
					   					$dat3[$i] = $data_awal[$i]->do;
					   			}
					   			
					   			$total =  array_sum($dat);

					   			$total_net = array_sum($dat1);
					   			
					   			$diskon = array_sum($dat2);

					   			$do = array_sum($dat3);
				   			}
				   			$date =  date('B'.'s'.'H');

				   			Excel::create('Kartuhutang'.$date, function($excel) use ($data_awal,$total_net,$total,$diskon,$do){

								    $excel->sheet('New sheet', function($sheet) use ($data_awal,$total_net,$total,$diskon,$do) {
								        $sheet->loadView('purchase/master/master_penjualan/laporan/do_total/excel/excel_lap_rekapcustomer')
								        ->with('data_awal',$data_awal)
								        ->with('total_net',$total_net)
								        ->with('total',$total)
								        ->with('diskon',$diskon)
								        ->with('do',$do);
								    });

								})->download('csv');
				   		}
				   		elseif ($awal == $awal && $akir == $akir && $cabang == $cabang && $view == $view) {
   			// return 'B';

				   			$data_awal = DB::select("SELECT c.nama as nama,kode_customer, sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net  from delivery_order d
				   				join customer c on d.kode_customer = c.kode
				   				where kode_cabang = '$cabang'
				   				and tanggal>='$awal'
				   				and tanggal<='$akir'
				                group by d.kode_customer,c.kode
				                order by d.kode_customer");	
				   			
				   		
				   			/*return*/ $doc = DB::select("SELECT kode_customer,sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net from delivery_order d 
				   				where kode_cabang = '$cabang'
				   				and tanggal>='$awal'
				   				and tanggal<='$akir'
				   				and type_kiriman = 'DOKUMEN'
				   				group by d.kode_customer
				   				order by d.kode_customer");	
					   			// return $doc;

				   			$kilo = DB::select("SELECT kode_customer,sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net from delivery_order d 
				   				where kode_cabang = '$cabang'
				   				and tanggal>='$awal'
				   				and tanggal<='$akir'
				   				and type_kiriman = 'KILOGRAM'
				   				group by d.kode_customer
				   				order by d.kode_customer");	

				   			$koli = DB::select("SELECT kode_customer,sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net from delivery_order d 
				   				where kode_cabang = '$cabang'
				   				and tanggal>='$awal'
				   				and tanggal<='$akir'
				   				and type_kiriman = 'KOLI'
				   				group by d.kode_customer
				   				order by d.kode_customer");	

				   			$sepeda = DB::select("SELECT kode_customer,sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net from delivery_order d 
				   				where kode_cabang = '$cabang'
				   				and tanggal>='$awal'
				   				and tanggal<='$akir'
				   				and type_kiriman = 'SEPEDA'
				   				group by d.kode_customer
				   				order by d.kode_customer");	

				   			$kargo = DB::select("SELECT kode_customer,sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net from delivery_order d 
				   				where kode_cabang = '$cabang'
				   				and tanggal>='$awal'
				   				and tanggal<='$akir'
				   				and type_kiriman = 'KARGO'
				   				group by d.kode_customer
				   				order by d.kode_customer");	

				   			$koran = DB::select("SELECT kode_customer,sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net from delivery_order d 
				   				where kode_cabang = '$cabang'
				   				and tanggal>='$awal'
				   				and tanggal<='$akir'
				   				and type_kiriman = 'KORAN'
				   				group by d.kode_customer
				   				order by d.kode_customer");	



				   			// return [$data_awal,$doc,$kilo,$koli,$sepeda,$kargo,$koran];

				   			if ($data_awal == null) {
				   				return response()->json(['data'=>'0']); 
				   			}else{
				   				for ($i=0; $i <count($data_awal) ; $i++) { 
					   					$dat[$i] = $data_awal[$i]->total_net;
					   			}
					   			for ($i=0; $i <count($data_awal) ; $i++) { 
					   					$dat1[$i] = $data_awal[$i]->total;
					   			}
					   			for ($i=0; $i <count($data_awal) ; $i++) { 
					   					$dat2[$i] = $data_awal[$i]->diskon;
					   			}
					   			for ($i=0; $i <count($data_awal) ; $i++) { 
					   					$dat3[$i] = $data_awal[$i]->do;
					   			}
					   			
					   			$total =  array_sum($dat);

					   			$total_net = array_sum($dat1);
					   			
					   			$diskon = array_sum($dat2);

					   			$do = array_sum($dat3);
				   			}
				   			
				   		}
			   			$date =  date('B'.'s'.'H');

				   		$date =  date('B'.'s'.'H');

			   			Excel::create('Kartuhutang'.$date, function($excel) use ($data_awal,$total_net,$total,$diskon,$do,$doc,$kilo,$koli,$sepeda,$kargo,$koran){

							    $excel->sheet('New sheet', function($sheet) use ($data_awal,$total_net,$total,$diskon,$do,$doc,$kilo,$koli,$sepeda,$kargo,$koran) {
							        $sheet->loadView('purchase/master/master_penjualan/laporan/do_total/excel/excel_detail_lap_rekapcustomer')
							        ->with('data_awal',$data_awal)
							        ->with('total_net',$total_net)
							        ->with('total',$total)
							        ->with('diskon',$diskon)
							        ->with('do',$do)
							        ->with('doc',$doc)
							        ->with('kilo',$kilo)
							        ->with('koli',$koli)
							        ->with('sepeda',$sepeda)
							        ->with('kargo',$kargo)
							        ->with('koran',$koran);
							    });

							})->download('csv');
						
   		}
   		// return $total_net;
		 
   }
   //END OF

   public function reportpdf_rekapcustomer(Request $request){
   		$cabang = $request->cabang;
   		$view = $request->view;
   		$awal = $request->min;
   		$akir = $request->max;

   		if ($view == 'rekap') {
			   		if ($awal == $awal && $akir == $akir && $cabang == null || '' && $view == $view) {
			   				$data_awal = DB::select("SELECT c.nama as nama,kode_customer, sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net  from delivery_order d
			   				join customer c on d.kode_customer = c.kode
			   				where tanggal>='$awal'
			   				and tanggal<='$akir'
			                group by d.kode_customer,c.kode
			                order by d.kode_customer");	
			   			if ($data_awal == null) {
			   				return response()->json(['data'=>'0']); 
			   			}else{
			   				for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat[$i] = $data_awal[$i]->total_net;
				   			}
				   			for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat1[$i] = $data_awal[$i]->total;
				   			}
				   			for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat2[$i] = $data_awal[$i]->diskon;
				   			}
				   			for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat3[$i] = $data_awal[$i]->do;
				   			}
				   			
				   			$total =  array_sum($dat);

				   			$total_net = array_sum($dat1);
				   			
				   			$diskon = array_sum($dat2);

				   			$do = array_sum($dat3);
			   			}
			   		}
			   		elseif ($awal == $awal && $akir == $akir && $cabang == $cabang && $view == $view) {

			   			 $data_awal = DB::select("SELECT c.nama as nama,kode_customer, sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net  from delivery_order d
			   				join customer c on d.kode_customer = c.kode
			   				where kode_cabang = '$cabang'
			   				and tanggal>='$awal'
			   				and tanggal<='$akir'
			                group by d.kode_customer,c.kode
			                order by d.kode_customer");	
			   			if ($data_awal == null) {
			   				return response()->json(['data'=>'0']); 
			   			}else{
			   				for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat[$i] = $data_awal[$i]->total_net;
				   			}
				   			for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat1[$i] = $data_awal[$i]->total;
				   			}
				   			for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat2[$i] = $data_awal[$i]->diskon;
				   			}
				   			for ($i=0; $i <count($data_awal) ; $i++) { 
				   					$dat3[$i] = $data_awal[$i]->do;
				   			}
				   			
				   			$total =  array_sum($dat);

				   			$total_net = array_sum($dat1);
				   			
				   			$diskon = array_sum($dat2);

				   			$do = array_sum($dat3);
			   			}
			   			
			   		}
			   		$date =  date('B'.'s'.'H');
		 	
				 	$pdf = PDF::loadView('purchase/master/master_penjualan/laporan/do_total/pdf/pdf_lap_rekapcustomer',compact('data_awal','total_net','total','diskon','do'))->setPaper('a4','potrait'); 
					return $pdf->stream('rekap_customer'.$date.'.pdf');
   		}else{
   			// return 'U';
		   			if ($awal == $awal && $akir == $akir && $cabang == null || '' && $view == $view) {
   					// return 'A';

				   				$data_awal = DB::select("SELECT c.nama as nama,kode_customer, sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net  from delivery_order d
				   				join customer c on d.kode_customer = c.kode
				   				where tanggal>='$awal'
				   				and tanggal<='$akir'
				                group by d.kode_customer,c.kode
				                order by d.kode_customer");	
				   			if ($data_awal == null) {
				   				return response()->json(['data'=>'0']); 
				   			}else{
				   				for ($i=0; $i <count($data_awal) ; $i++) { 
					   					$dat[$i] = $data_awal[$i]->total_net;
					   			}
					   			for ($i=0; $i <count($data_awal) ; $i++) { 
					   					$dat1[$i] = $data_awal[$i]->total;
					   			}
					   			for ($i=0; $i <count($data_awal) ; $i++) { 
					   					$dat2[$i] = $data_awal[$i]->diskon;
					   			}
					   			for ($i=0; $i <count($data_awal) ; $i++) { 
					   					$dat3[$i] = $data_awal[$i]->do;
					   			}
					   			
					   			$total =  array_sum($dat);

					   			$total_net = array_sum($dat1);
					   			
					   			$diskon = array_sum($dat2);

					   			$do = array_sum($dat3);
				   			}
				   		}
				   		elseif ($awal == $awal && $akir == $akir && $cabang == $cabang && $view == $view) {
   			// return 'B';

				   			$data_awal = DB::select("SELECT c.nama as nama,kode_customer, sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net  from delivery_order d
				   				join customer c on d.kode_customer = c.kode
				   				where kode_cabang = '$cabang'
				   				and tanggal>='$awal'
				   				and tanggal<='$akir'
				                group by d.kode_customer,c.kode
				                order by d.kode_customer");	
				   			
				   			$cust = DB::select("SELECT kode_customer from delivery_order d 
				   				where kode_cabang = '$cabang'
				   				and tanggal>='$awal'
				   				and tanggal<='$akir'
				   				and type_kiriman = 'DOKUMEN'
				   				group by d.kode_customer
				   				order by d.kode_customer");	

				   			$doc = DB::select("SELECT kode_customer,sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net from delivery_order d 
				   				where kode_cabang = '$cabang'
				   				and tanggal>='$awal'
				   				and tanggal<='$akir'
				   				and type_kiriman = 'DOKUMEN'
				   				group by d.kode_customer
				   				order by d.kode_customer");	
					   			// return $doc;

				   			$kilo = DB::select("SELECT kode_customer,sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net from delivery_order d 
				   				where kode_cabang = '$cabang'
				   				and tanggal>='$awal'
				   				and tanggal<='$akir'
				   				and type_kiriman = 'KILOGRAM'
				   				group by d.kode_customer
				   				order by d.kode_customer");	

				   			$koli = DB::select("SELECT kode_customer,sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net from delivery_order d 
				   				where kode_cabang = '$cabang'
				   				and tanggal>='$awal'
				   				and tanggal<='$akir'
				   				and type_kiriman = 'KOLI'
				   				group by d.kode_customer
				   				order by d.kode_customer");	

				   			$sepeda = DB::select("SELECT kode_customer,sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net from delivery_order d 
				   				where kode_cabang = '$cabang'
				   				and tanggal>='$awal'
				   				and tanggal<='$akir'
				   				and type_kiriman = 'SEPEDA'
				   				group by d.kode_customer
				   				order by d.kode_customer");	

				   			$kargo = DB::select("SELECT kode_customer,sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net from delivery_order d 
				   				where kode_cabang = '$cabang'
				   				and tanggal>='$awal'
				   				and tanggal<='$akir'
				   				and type_kiriman = 'KARGO'
				   				group by d.kode_customer
				   				order by d.kode_customer");	

				   			$koran = DB::select("SELECT kode_customer,sum(d.total) as total,sum(d.diskon) as diskon ,count(d.nomor) as do,sum(d.total_net) as total_net from delivery_order d 
				   				where kode_cabang = '$cabang'
				   				and tanggal>='$awal'
				   				and tanggal<='$akir'
				   				and type_kiriman = 'KORAN'
				   				group by d.kode_customer
				   				order by d.kode_customer");	



				   			// return [$data_awal,$doc,$kilo,$koli,$sepeda,$kargo,$koran];

				   			if ($data_awal == null) {
				   				return response()->json(['data'=>'0']); 
				   			}else{
				   				for ($i=0; $i <count($data_awal) ; $i++) { 
					   					$dat[$i] = $data_awal[$i]->total_net;
					   			}
					   			for ($i=0; $i <count($data_awal) ; $i++) { 
					   					$dat1[$i] = $data_awal[$i]->total;
					   			}
					   			for ($i=0; $i <count($data_awal) ; $i++) { 
					   					$dat2[$i] = $data_awal[$i]->diskon;
					   			}
					   			for ($i=0; $i <count($data_awal) ; $i++) { 
					   					$dat3[$i] = $data_awal[$i]->do;
					   			}
					   			
					   			$total =  array_sum($dat);

					   			$total_net = array_sum($dat1);
					   			
					   			$diskon = array_sum($dat2);

					   			$do = array_sum($dat3);
				   			}
				   			
				   		}
			   			$date =  date('B'.'s'.'H');

				   		return view('purchase/master/master_penjualan/laporan/do_total/pdf/pdf_detail_lap_rekapcustomer',compact('data_awal','total_net','total','diskon','do','doc','koli','kilo','kargo','koran','sepeda')); 
						
   		}
   }
			   	public function reportpdf_kartupiutang(Request $request){
			   		return view('purchase/master/master_penjualan/laporan/do_total/pdf/pdf_detail_lap_rekapcustomer',compact('data_awal','total_net','total','diskon','do','doc','koli','kilo','kargo','koran','sepeda'));
			   }
			   public function reportexcel_kartupiutang(Request $request){
			   	
			   		return 'b';
			   }

   


   public function testtest()
   {
   		$curl = curl_init();

   		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPGET, 1);
		curl_setopt($curl, CURLOPT_URL, 'https://api.rajaongkir.com/starter/cost' );
		curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2 );
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		    "key: 0113b4ac84f7f9f40c548a7b4d04ac3f"
		  ));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}

   }




   //======================================== LAPORAN INVOICE ===================================================//
   //cari_invoice_belum_tt
   public function cari_invoice_belum_tt(Request $request)
   {
   	$awal = $request->awal;
	$akir = $request->akir;
	//invoice
	if ($request->customer != '' || $request->customer != null) {
		$customer_invoice = " AND i_kode_customer = '".$request->customer."' ";
	}else{
		$customer_invoice = '';
	}
	if ($request->cabang != '' || $request->cabang != null) {
		$cabang_invoice = " AND i_kode_cabang = '".$request->cabang."' ";
	}else{
		$cabang_invoice = '';
	}
	//end

	$customer = DB::select("SELECT i_kode_customer,nama from invoice inner join customer on customer.kode = invoice.i_kode_customer  where i_tanggal > '$awal' and i_tanggal < '$akir' and i_tanggal_tanda_terima is null $customer_invoice $cabang_invoice ");
	// return $customer;
	$data = DB::select("SELECT * from invoice where i_tanggal > '$awal' and i_tanggal < '$akir' and i_tanggal_tanda_terima is null $customer_invoice $cabang_invoice ");
	// return $data;
	for ($i=0; $i <count($data) ; $i++) { 
		# code...
	}

	return view('purchase/master/master_penjualan/laporan/invoice/invoice_belum_tt/invoice_belum_ttinvoice',compact('data','customer'));
   }

   //cari_invoice_sudah_tt
   public function cari_invoice_sudah_tt(Request $request)
   {
   	$awal = $request->awal;
	$akir = $request->akir;
	//invoice
	if ($request->customer != '' || $request->customer != null) {
		$customer_invoice = " AND i_kode_customer = '".$request->customer."' ";
	}else{
		$customer_invoice = '';
	}
	if ($request->cabang != '' || $request->cabang != null) {
		$cabang_invoice = " AND i_kode_cabang = '".$request->cabang."' ";
	}else{
		$cabang_invoice = '';
	}
	//end

	$customer = DB::select("SELECT i_kode_customer,nama from invoice inner join customer on customer.kode = invoice.i_kode_customer  where i_tanggal > '$awal' and i_tanggal < '$akir' and i_tanggal_tanda_terima is null $customer_invoice $cabang_invoice ");
	// return $customer;
	$dt = DB::select("SELECT * from invoice where i_tanggal > '$awal' and i_tanggal < '$akir' and i_tanggal_tanda_terima is not null $customer_invoice $cabang_invoice ");
	// return $dt;
	return view('purchase/master/master_penjualan/laporan/invoice/invoice_sudah_tt/invoice_sudah_ttinvoice',compact('dt','customer'));
   }

 

   //cari_jarak_invoice_dengan_tt
   public function cari_jarak_invoice_dengan_tt(Request $request)
   {
   	$awal = $request->awal;
	$akir = $request->akir;
	//invoice
	if ($request->customer != '' || $request->customer != null) {
		$customer_invoice = " AND i_kode_customer = '".$request->customer."' ";
	}else{
		$customer_invoice = '';
	}
	if ($request->cabang != '' || $request->cabang != null) {
		$cabang_invoice = " AND i_kode_cabang = '".$request->cabang."' ";
	}else{
		$cabang_invoice = '';
	}
	//end

	$customer = DB::select("SELECT i_kode_customer,nama from invoice inner join customer on customer.kode = invoice.i_kode_customer  where i_tanggal > '$awal' and i_tanggal < '$akir' and i_tanggal_tanda_terima is not null $customer_invoice $cabang_invoice ");
	// return $customer;
	$data = DB::select("SELECT *,

   (DATE_PART('day', i_tanggal_tanda_terima::date) - DATE_PART('day', i_tanggal::date)) as TGL,
   (DATE_PART('month', i_tanggal_tanda_terima::date) - DATE_PART('month', i_tanggal::date)) as BLN,
   (DATE_PART('year', i_tanggal_tanda_terima::date) - DATE_PART('year', i_tanggal::date)) as YR

	from invoice where i_tanggal > '$awal' and i_tanggal < '$akir' and i_tanggal_tanda_terima is not null $customer_invoice $cabang_invoice");
	// return $data;		
	return view('purchase/master/master_penjualan/laporan/invoice/jarak_invoice_tt/jarak_invoice_tt',compact('data','customer'));
   
   }

   //========================================= END OF ===========================================================//


   //========================================= KWITANSI ===========================================================//

   //cari_ajaxkwitansi
   public function cari_ajaxkwitansi(Request $request)
   {
   	$awal = $request->awal;
	$akir = $request->akir;
	//invoice
	if ($request->customer != '' || $request->customer != null) {
		$customer_kwitansi = " AND k_kode_customer = '".$request->customer."' ";
	}else{
		$customer_kwitansi = '';
	}
	if ($request->cabang != '' || $request->cabang != null) {
		$cabang_kwitansi = " AND k_kode_cabang = '".$request->cabang."' ";
	}else{
		$cabang_kwitansi = '';
	}
	//end

	$data = DB::select("SELECT * from kwitansi where k_tanggal > '$awal' and k_tanggal < '$akir' $customer_kwitansi $cabang_kwitansi");
	// return $data;		
	return view('purchase/master/master_penjualan/laporan/lap_kwitansi/kwitansi/lap_kwitansi',compact('data','customer'));
   }


   //cari_ajaxkwitansi_belum_posting
   public function cari_ajaxkwitansi_belum_posting(Request $request)
   {
   	$awal = $request->awal;
	$akir = $request->akir;
	//invoice
	if ($request->customer != '' || $request->customer != null) {
		$customer_kwitansi = " AND k_kode_customer = '".$request->customer."' ";
	}else{
		$customer_kwitansi = '';
	}
	if ($request->cabang != '' || $request->cabang != null) {
		$cabang_kwitansi = " AND k_kode_cabang = '".$request->cabang."' ";
	}else{
		$cabang_kwitansi = '';
	}
	//end

	$data = DB::select("SELECT * from kwitansi where k_tanggal > '$awal' and k_tanggal < '$akir' and k_nomor_posting is null $customer_kwitansi $cabang_kwitansi");
	// return $data;		
	return view('purchase/master/master_penjualan/laporan/lap_kwitansi/kwitansi_belum_posting/lap_kwitansi_belum_posting',compact('data','customer'));
   }

   //cari_ajaxkwitansi_sudah_posting
   public function cari_ajaxkwitansi_sudah_posting(Request $request)
   {
   	$awal = $request->awal;
	$akir = $request->akir;
	//invoice
	if ($request->customer != '' || $request->customer != null) {
		$customer_kwitansi = " AND k_kode_customer = '".$request->customer."' ";
	}else{
		$customer_kwitansi = '';
	}
	if ($request->cabang != '' || $request->cabang != null) {
		$cabang_kwitansi = " AND k_kode_cabang = '".$request->cabang."' ";
	}else{
		$cabang_kwitansi = '';
	}
	//end

	$data = DB::select("SELECT * from kwitansi where k_tanggal > '$awal' and k_tanggal < '$akir' and k_nomor_posting is not null $customer_kwitansi $cabang_kwitansi");
	// return $data;		
	return view('purchase/master/master_penjualan/laporan/lap_kwitansi/kwitansi_sudah_posting/lap_kwitansi_sudah_posting',compact('data','customer'));
   }




   //========================================= END OF ===========================================================//


   }

?>