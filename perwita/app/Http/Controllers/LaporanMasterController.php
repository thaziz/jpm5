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
								

	//LAPORAN DELIVERY ORDER SEMUA 

	public function deliveryorder_total(){

		$data =DB::table('delivery_order as do')
				->select('do.*','ka.id as kaid','kt.id as ktid','ka.nama as asal','kt.nama as tujuan','kc.nama as kecamatan')
				->leftjoin('kota as ka','do.id_kota_asal','=','ka.id')
				->leftjoin('kota as kt','do.id_kota_tujuan','=','kt.id')
				->leftjoin('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
				->get();

		 $array_bulan = ['1','2','3','4','5','6','7','8','9','10','11','12'];
		 $tahun = carbon::now();
		 $tahun =  $tahun->year;

		for ($i=0; $i <count($array_bulan) ; $i++) { 
			$dat[$i] =DB::table('delivery_order as do')
				->select('do.*','ka.id as kaid','kt.id as ktid','ka.nama as asal','kt.nama as tujuan','kc.nama as kecamatan')
				->leftjoin('kota as ka','do.id_kota_asal','=','ka.id')
				->leftjoin('kota as kt','do.id_kota_tujuan','=','kt.id')
				->leftjoin('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
				->whereMonth('tanggal','=',$array_bulan[$i])
				->whereYear('tanggal','=',$tahun)
				->where('pendapatan','=','PAKET')
				->where('status','=','DELIVERED OK')
				->get();
			$dat1[$i] =DB::table('delivery_order as do')
				->select('do.*','ka.id as kaid','kt.id as ktid','ka.nama as asal','kt.nama as tujuan','kc.nama as kecamatan')
				->leftjoin('kota as ka','do.id_kota_asal','=','ka.id')
				->leftjoin('kota as kt','do.id_kota_tujuan','=','kt.id')
				->leftjoin('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
				->whereMonth('tanggal','=',$array_bulan[$i])
				->whereYear('tanggal','=',$tahun)
				->where('pendapatan','=','KORAN')
				->where('status','=','DELIVERED OK')
				->get();
			$dat2[$i] =DB::table('delivery_order as do')
				->select('do.*','ka.id as kaid','kt.id as ktid','ka.nama as asal','kt.nama as tujuan','kc.nama as kecamatan')
				->leftjoin('kota as ka','do.id_kota_asal','=','ka.id')
				->leftjoin('kota as kt','do.id_kota_tujuan','=','kt.id')
				->leftjoin('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
				->whereMonth('tanggal','=',$array_bulan[$i])
				->whereYear('tanggal','=',$tahun)
				->where('nomor','like','%KGO%')
				->where('status','=','DELIVERED OK')
				->get();
		}
		// return $dat1;
		// return $tahun;
		for ($i=0; $i < count(isset($dat)); $i++) { 
			// return $dat;
			for ($a=0; $a < count(isset($dat[$i])); $a++) { 

				$paket = [	$data0 = count($dat[0]),
							$data1 = count($dat[1]),
							$data2 = count($dat[2]),
							$data3 = count($dat[3]),
							$data4 = count($dat[4]),
							$data5 = count($dat[5]),
							$data6 = count($dat[6]),
							$data7 = count($dat[7]),
							$data8 = count($dat[8]),
							$data9 = count($dat[9]),
							$data10 = count($dat[10]),
							$data11 = count($dat[11])
							];	
			}
		}

		for ($i=0; $i < count(isset($dat1)); $i++) { 
			// return $dat;
			for ($a=0; $a < count(isset($dat1[$i])); $a++) { 

				$koran = [	$data0 = count($dat1[0]),
							$data1 = count($dat1[1]),
							$data2 = count($dat1[2]),
							$data3 = count($dat1[3]),
							$data4 = count($dat1[4]),
							$data5 = count($dat1[5]),
							$data6 = count($dat1[6]),
							$data7 = count($dat1[7]),
							$data8 = count($dat1[8]),
							$data9 = count($dat1[9]),
							$data10 = count($dat1[10]),
							$data11 = count($dat1[11])
							];	
			}
		}

		for ($i=0; $i < count(isset($dat2)); $i++) { 
			// return $dat;
			for ($a=0; $a < count(isset($dat2[$i])); $a++) { 

				$kargo = [	$data0 = count($dat2[0]),
							$data1 = count($dat2[1]),
							$data2 = count($dat2[2]),
							$data3 = count($dat2[3]),
							$data4 = count($dat2[4]),
							$data5 = count($dat2[5]),
							$data6 = count($dat2[6]),
							$data7 = count($dat2[7]),
							$data8 = count($dat2[8]),
							$data9 = count($dat2[9]),
							$data10 = count($dat2[10]),
							$data11 = count($dat2[11])
							];	
			}
		}
		// return $dat2;
		// return [$paket,$koran,$kargo];
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$kota1 = DB::select("SELECT id, nama as asal from kota");
		return view('purchase/master/master_penjualan/laporan/lap_deliveryorder_total',compact('data','kota','kota1','paket','koran','kargo'));
	}
	public function carideliveryorder_total(Request $request){
		$awal = $request->a;
		$akir = $request->b;

		$data =DB::table('delivery_order as do')
				->select('do.*','ka.id as kaid','kt.id as ktid','ka.nama as asal','kt.nama as tujuan','kc.nama as kecamatan')
				->join('kota as ka','do.id_kota_asal','=','ka.id')
				->join('kota as kt','do.id_kota_tujuan','=','kt.id')
				->join('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
				->where('nomor','like','%PAK%')
				->where('pendapatan','=','PAKET')
				->where('tanggal','>=',$awal)
				->where('tanggal','<=',$akir)
				->get();

		$data1 =DB::table('delivery_order as do')
				->select('do.*','ka.id as kaid','kt.id as ktid','ka.nama as asal','kt.nama as tujuan','kc.nama as kecamatan')
				->join('kota as ka','do.id_kota_asal','=','ka.id')
				->join('kota as kt','do.id_kota_tujuan','=','kt.id')
				->join('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
				->where('nomor','like','%PAK%')
				->where('pendapatan','=','KORAN')
				->where('tanggal','>=',$awal)
				->where('tanggal','<=',$akir)
				->get();

		$data2 =DB::table('delivery_order as do')
				->select('do.*','ka.id as kaid','kt.id as ktid','ka.nama as asal','kt.nama as tujuan','kc.nama as kecamatan')
				->join('kota as ka','do.id_kota_asal','=','ka.id')
				->join('kota as kt','do.id_kota_tujuan','=','kt.id')
				->join('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
				->where('nomor','like','%PAK%')
				->where('pendapatan','=','KARGO')
				->where('tanggal','>=',$awal)
				->where('tanggal','<=',$akir)
				->get();

        return response()->json(['paket'=>count($data),'koran'=>count($data1),'kargo'=>count($data2)]);
	}

	//END OF


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

		//DATA DOKUMEN PER BULAN

		 $array_bulan = ['1','2','3','4','5','6','7','8','9','10','11','12'];
		 $tahun = carbon::now();
		 $tahun =  $tahun->year;
		
		// return $array_bulan;
		for ($i=0; $i <count($array_bulan) ; $i++) { 
			$dat[$i] =DB::table('delivery_order')
				->where('nomor','like','%PAK%')
				->where('type_kiriman','=','DOKUMEN')
				->whereMonth('tanggal','=',$array_bulan[$i])
				->whereYear('tanggal','=',$tahun)
				->get();
			$dat1[$i] =DB::table('delivery_order')
				->where('nomor','like','%PAK%')
				->where('type_kiriman','=','KILOGRAM')
				->whereMonth('tanggal','=',$array_bulan[$i])
				->whereYear('tanggal','=',$tahun)
				->get();
			$dat2[$i] =DB::table('delivery_order')
				->where('nomor','like','%PAK%')
				->where('type_kiriman','=','KOLI')
				->whereMonth('tanggal','=',$array_bulan[$i])
				->whereYear('tanggal','=',$tahun)
				->get();
			$dat3[$i] =DB::table('delivery_order')
				->where('nomor','like','%PAK%')
				->where('type_kiriman','=','SEPEDA')
				->whereMonth('tanggal','=',$array_bulan[$i])
				->whereYear('tanggal','=',$tahun)
				->get();
		}
		// return $dat;

		for ($i=0; $i < count(isset($dat)); $i++) { 
			for ($a=0; $a < count(isset($dat[$i])); $a++) { 
				
				if (isset($dat[0][$a])) {
				 	$jan = count($dat[0]);
				}else{
					$jan = 0;
				}

				if (isset($dat[1][$a])) {
				 	$feb = count($dat[1]);
				}else{
					$feb = 0;
				}

				if (isset($dat[2][$a])) {
				 	$mar = count($dat[2]);
				}else{
					$mar = 0;
				}

				if (isset($dat[3][$a])) {
				 	$apr = count($dat[3]);
				}else{
					$apr = 0;
				}

				if (isset($dat[4][$a])) {
				 	$may = count($dat[4]);
				}else{
					$may = 0;
				}

				if (isset($dat[5][$a])) {
				 	$jun = count($dat[5]);
				}else{
					$jun = 0;
				}

				if (isset($dat[6][$a])) {
				 	$jul = count($dat[6]);
				}else{
					$jul = 0;
				}

				if (isset($dat[7][$a])) {
				 	$aug = count($dat[7]);
				}else{
					$aug = 0;
				}

				if (isset($dat[8][$a])) {
				 	$sep = count($dat[8]);
				}else{
					$sep = 0;
				}

				if (isset($dat[9][$a])) {
				 	$okt = count($dat[9]);
				}else{
					$okt = 0;
				}

				if (isset($dat[10][$a])) {
				 	$nov = count($dat[10]);
				}else{
					$nov = 0;
				}

				if (isset($dat[11][$a])) {
				 	$dec = count($dat[11]);
				}else{
					$dec = 0;
				}
			}
		}
		// return $apr;
		
		// return $dat1;
		for ($i=0; $i < count(isset($dat1)); $i++) { 
			for ($a=0; $a < count(isset($dat1[$i])); $a++) { 
				
				if (isset($dat1[0][$a])) {
				 	$jan1 = count($dat1[0]);
				}else{
					$jan1 = 0;
				}

				if (isset($dat1[1][$a])) {
				 	$feb1 = count($dat1[1]);
				}else{
					$feb1 = 0;
				}

				if (isset($dat1[2][$a])) {
				 	$mar1 = count($dat1[2]);
				}else{
					$mar1 = 0;
				}

				if (isset($dat1[3][$a])) {
				 	$apr1 = count($dat1[3]);
				}else{
					$apr1 = 0;
				}

				if (isset($dat1[4][$a])) {
				 	$may1 = count($dat1[4]);
				}else{
					$may1 = 0;
				}

				if (isset($dat1[5][$a])) {
				 	$jun1 = count($dat1[5]);
				}else{
					$jun1 = 0;
				}

				if (isset($dat1[6][$a])) {
				 	$jul1 = count($dat1[6]);
				}else{
					$jul1 = 0;
				}

				if (isset($dat1[7][$a])) {
				 	$aug1 = count($dat1[7]);
				}else{
					$aug1 = 0;
				}

				if (isset($dat1[8][$a])) {
				 	$sep1 = count($dat1[8]);
				}else{
					$sep1 = 0;
				}

				if (isset($dat1[9][$a])) {
				 	$okt1 = count($dat1[9]);
				}else{
					$okt1 = 0;
				}

				if (isset($dat1[10][$a])) {
				 	$nov1 = count($dat1[10]);
				}else{
					$nov1 = 0;
				}

				if (isset($dat1[11][$a])) {
				 	$dec1 = count($dat1[11]);
				}else{
					$dec1 = 0;
				}
			}
		}
		// return $dat2;
		for ($i=0; $i < count(isset($dat2)); $i++) { 
			for ($a=0; $a < count(isset($dat2[$i])); $a++) { 
				
				if (isset($dat2[0][$a])) {
				 	$jan2 = count($dat2[0]);
				}else{
					$jan2 = 0;
				}

				if (isset($dat2[1][$a])) {
				 	$feb2 = count($dat2[1]);
				}else{
					$feb2 = 0;
				}

				if (isset($dat2[2][$a])) {
				 	$mar2 = count($dat2[2]);
				}else{
					$mar2 = 0;
				}

				if (isset($dat2[3][$a])) {
				 	$apr2 = count($dat2[3]);
				}else{
					$apr2 = 0;
				}

				if (isset($dat2[4][$a])) {
				 	$may2 = count($dat2[4]);
				}else{
					$may2 = 0;
				}

				if (isset($dat2[5][$a])) {
				 	$jun2 = count($dat2[5]);
				}else{
					$jun2 = 0;
				}

				if (isset($dat2[6][$a])) {
				 	$jul2 = count($dat2[6]);
				}else{
					$jul2 = 0;
				}

				if (isset($dat2[7][$a])) {
				 	$aug2 = count($dat2[7]);
				}else{
					$aug2 = 0;
				}

				if (isset($dat2[8][$a])) {
				 	$sep2 = count($dat2[8]);
				}else{
					$sep2 = 0;
				}

				if (isset($dat2[9][$a])) {
				 	$okt2 = count($dat2[9]);
				}else{
					$okt2 = 0;
				}

				if (isset($dat2[10][$a])) {
				 	$nov2 = count($dat2[10]);
				}else{
					$nov2 = 0;
				}

				if (isset($dat2[11][$a])) {
				 	$dec2 = count($dat2[11]);
				}else{
					$dec2 = 0;
				}
			}
		}


		for ($i=0; $i < count(isset($dat3)); $i++) { 
			for ($a=0; $a < count(isset($dat3[$i])); $a++) { 
				
				if (isset($dat3[0][$a])) {
				 	$jan3 = count($dat3[0]);
				}else{
					$jan3 = 0;
				}

				if (isset($dat3[1][$a])) {
				 	$feb3 = count($dat3[1]);
				}else{
					$feb3 = 0;
				}

				if (isset($dat3[2][$a])) {
				 	$mar3 = count($dat3[2]);
				}else{
					$mar3 = 0;
				}

				if (isset($dat3[3][$a])) {
				 	$apr3 = count($dat3[3]);
				}else{
					$apr3 = 0;
				}

				if (isset($dat3[4][$a])) {
				 	$may3 = count($dat3[4]);
				}else{
					$may3 = 0;
				}

				if (isset($dat3[5][$a])) {
				 	$jun3 = count($dat3[5]);
				}else{
					$jun3 = 0;
				}

				if (isset($dat3[6][$a])) {
				 	$jul3 = count($dat3[6]);
				}else{
					$jul3 = 0;
				}

				if (isset($dat3[7][$a])) {
				 	$aug3 = count($dat3[7]);
				}else{
					$aug3 = 0;
				}

				if (isset($dat3[8][$a])) {
				 	$sep3 = count($dat3[8]);
				}else{
					$sep3 = 0;
				}

				if (isset($dat3[9][$a])) {
				 	$okt3 = count($dat3[9]);
				}else{
					$okt3 = 0;
				}

				if (isset($dat3[10][$a])) {
				 	$nov3 = count($dat3[10]);
				}else{
					$nov3 = 0;
				}

				if (isset($dat3[11][$a])) {
				 	$dec3 = count($dat3[11]);
				}else{
					$dec3 = 0;
				}
			}
		}

		$arraybulan_dokumen  = [$jan,$feb,$mar,$apr,$may,$jun,$jul,$aug,$sep,$okt,$nov,$dec];
		$arraybulan_kilogram = [$jan1,$feb1,$mar1,$apr1,$may1,$jun1,$jul1,$aug1,$sep1,$okt1,$nov1,$dec1];
		$arraybulan_koli     = [$jan2,$feb2,$mar2,$apr2,$may2,$jun2,$jul2,$aug2,$sep2,$okt2,$nov2,$dec2];
		$arraybulan_sepeda   = [$jan3,$feb3,$mar3,$apr3,$may3,$jun3,$jul3,$aug3,$sep3,$okt3,$nov3,$dec3];
		// return $arraybulan_dokumen;
		//END OF

		//DATA KILOGRAM PER BULAN

		

		$ket = DB::table('tarif_cabang_sepeda')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$kota1 = DB::select("SELECT id, nama as asal from kota");
		return view('purchase/master/master_penjualan/laporan/lap_deliveryorder_paket',compact('data','kota','kota1','ket','count_get_data','arraybulan_dokumen','arraybulan_kilogram','arraybulan_koli','arraybulan_sepeda'));
	}
	public function cari_paket(Request $request){
		$awal = $request->a;
		$akir = $request->b;
		$data =DB::table('delivery_order as do')
				->select('do.*','ka.id as kaid','kt.id as ktid','ka.nama as asal','kt.nama as tujuan','kc.nama as kecamatan')
				->join('kota as ka','do.id_kota_asal','=','ka.id')
				->join('kota as kt','do.id_kota_tujuan','=','kt.id')
				->join('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
				->where('nomor','like','%PAK%')
				->where('type_kiriman','=','DOKUMEN')
				->where('tanggal','>=',$awal)
				->where('tanggal','<=',$akir)
				->get();

		$data1 =DB::table('delivery_order as do')
				->select('do.*','ka.id as kaid','kt.id as ktid','ka.nama as asal','kt.nama as tujuan','kc.nama as kecamatan')
				->join('kota as ka','do.id_kota_asal','=','ka.id')
				->join('kota as kt','do.id_kota_tujuan','=','kt.id')
				->join('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
				->where('nomor','like','%PAK%')
				->where('type_kiriman','=','KILOGRAM')
				->where('tanggal','>=',$awal)
				->where('tanggal','<=',$akir)
				->get();

		$data2 =DB::table('delivery_order as do')
				->select('do.*','ka.id as kaid','kt.id as ktid','ka.nama as asal','kt.nama as tujuan','kc.nama as kecamatan')
				->join('kota as ka','do.id_kota_asal','=','ka.id')
				->join('kota as kt','do.id_kota_tujuan','=','kt.id')
				->join('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
				->where('nomor','like','%PAK%')
				->where('type_kiriman','=','KOLI')
				->where('tanggal','>=',$awal)
				->where('tanggal','<=',$akir)
				->get();

		$data3 =DB::table('delivery_order as do')
				->select('do.*','ka.id as kaid','kt.id as ktid','ka.nama as asal','kt.nama as tujuan','kc.nama as kecamatan')
				->join('kota as ka','do.id_kota_asal','=','ka.id')
				->join('kota as kt','do.id_kota_tujuan','=','kt.id')
				->join('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
				->where('nomor','like','%PAK%')
				->where('type_kiriman','=','SEPEDA')
				->where('tanggal','>=',$awal)
				->where('tanggal','<=',$akir)
				->get();

		
        return response()->json(['dokumen'=>count($data),'kilogram'=>count($data1),'koli'=>count($data2),'sepeda'=>count($data3)]);


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

		$array_bulan = ['1','2','3','4','5','6','7','8','9','10','11','12'];
		$tahun = carbon::now();
		$tahun =  $tahun->year;

		for ($i=0; $i <count($array_bulan) ; $i++) { 
			$dat[$i] =	DB::table('invoice')
						->select('i_tanggal','i_total')
						->whereMonth('i_tanggal','=',$array_bulan[$i])
						->whereYear('i_tanggal','=',$tahun)
						->get();
			$dat1[$i] =  DB::table('invoice')
						->whereMonth('i_tanggal','=',$array_bulan[$i])
						->whereYear('i_tanggal','=',$tahun)
						->get();
		}
		// return $dat;
		// $pushdata = [];
		// return $dat[3][0]->i_total;
		// return $dat
		for ($i=0; $i < count($dat); $i++) { 
			if ($dat[$i] != null) {
				for ($a=0; $a < count($dat[$i]); $a++) { 
					$anjay[$i][$a] = $dat[$i][$a]->i_total;
				}
			}else{
				$anjay[$i] = 0;
			}
		}
		// return $anjay;

		for ($i=0; $i < count($anjay); $i++) { 
			if ($anjay[$i] != 0) {
				for ($a=0; $a < count($anjay[$i]); $a++) { 
					$fix[$i] = array_sum($anjay[$i]);
				}
			}else{
				$fix[$i] = 0;
			}
		}

		// return ($gg[0]+$gg[1]+$gg[2]+$gg[3]+$gg[4]+$gg[5]+$gg[6]+$gg[7]);
		// return $i;
		return $fix;
		
		// return $invoice;
		$ket = DB::table('tarif_cabang_sepeda')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$cus = DB::table('customer')->get();
		$kota1 = DB::select("SELECT id, nama as asal from kota");
		return view('purchase/master/master_penjualan/laporan/lap_invoice',compact('data','kota','kota1','ket','cus','invoice'));
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
		$data = DB::table('kwitansi')->get();
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

	public function dopo(){
		return view('/delivery_order');
	}
								

   }
?>