<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use PDF;
use DB;
use Auth;

class laporanOmsetController extends Controller
{
														
//❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤ LAPORAN OPERASIONAL PENJUALAN ❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤
					


	//INDEX 
	public function index(){
		return view('purchase/omset_diagram/diagram_index',compact('data','kota','kota1','paket','koran','penjualan'));
	}



	public function diagram_penjualan(){
		 $tahun = carbon::now();
		 $sre = substr($tahun,0, 10);
		 $year =  $tahun->year;
		 $date =  $tahun->day;

		 $dat =DB::table('delivery_order as do')
				->select('do.*','ka.id as kaid','kt.id as ktid','ka.nama as asal','kt.nama as tujuan','kc.nama as kecamatan')
				->leftjoin('kota as ka','do.id_kota_asal','=','ka.id')
				->leftjoin('kota as kt','do.id_kota_tujuan','=','kt.id')
				->leftjoin('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
				->whereDate('tanggal','=',$sre)
				->where('pendapatan','=','PAKET')
				->get();
		$dat1 =DB::table('delivery_order as do')
			->select('do.*','ka.id as kaid','kt.id as ktid','ka.nama as asal','kt.nama as tujuan','kc.nama as kecamatan')
			->leftjoin('kota as ka','do.id_kota_asal','=','ka.id')
			->leftjoin('kota as kt','do.id_kota_tujuan','=','kt.id')
			->leftjoin('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
			->whereDate('tanggal','=',$sre)
			->where('pendapatan','=','KORAN')
			->get();
		$dat2 =DB::table('delivery_order as do')
			->select('do.*','ka.id as kaid','kt.id as ktid','ka.nama as asal','kt.nama as tujuan','kc.nama as kecamatan')
			->leftjoin('kota as ka','do.id_kota_asal','=','ka.id')
			->leftjoin('kota as kt','do.id_kota_tujuan','=','kt.id')
			->leftjoin('kecamatan as kc','do.id_kecamatan_tujuan','=','kc.id')
			->whereDate('tanggal','=',$sre)
			->where('pendapatan','=','KARGO')
			->get();

		if ($dat == null) {
			$paket = 0;
		}else{
		for ($i=0; $i <count($dat) ; $i++) { 
			$hit[$i] =  $dat[$i]->total;
		}
		$paket = array_sum($hit);
		}

//b
		if ($dat1 == null) {
			$koran = 0;
		}else{
			for ($i=0; $i <count($dat1) ; $i++) { 
			$hit1[$i] =  $dat1[$i]->total_net;
		}
			$koran = array_sum($hit1);
		}
		
//b
		if ($dat2 == null) {
			$kargo = 0;
		}else{
		for ($i=0; $i <count($dat2) ; $i++) { 
			$hit2[$i] =  $dat2[$i]->total_net;
		}
		$kargo = array_sum($hit2);
		}
		
		$cabang = DB::table('cabang')->get();
		return view('purchase/omset_diagram/laporan_diagram_dototal/lap_deliveryorder_total',compact('paket','koran','kargo','cabang'));
	}
	public function caridiagram_penjualan(Request $request){
		$awal = $request->a;
		$akir = $request->b;
		$cabang = $request->c;

		if ($cabang == '' or null) {
			$data =DB::table('delivery_order as do')
				->where('pendapatan','=','PAKET')
				->where('tanggal','>=',$awal)
				->where('tanggal','<=',$akir)
				->get();

		$data1 =DB::table('delivery_order as do')
				->where('pendapatan','=','KORAN')
				->where('tanggal','>=',$awal)
				->where('tanggal','<=',$akir)
				->get();

		$data2 =DB::table('delivery_order as do')
				->where('pendapatan','=','KARGO')
				->where('tanggal','>=',$awal)
				->where('tanggal','<=',$akir)
				->get();
		}else{
			$data =DB::table('delivery_order as do')
				->where('pendapatan','=','PAKET')
				->where('kode_cabang','=',$cabang)
				->where('tanggal','>=',$awal)
				->where('tanggal','<=',$akir)
				->get();

			$data1 =DB::table('delivery_order as do')
				->where('pendapatan','=','KORAN')
				->where('kode_cabang','=',$cabang)
				->where('tanggal','>=',$awal)
				->where('tanggal','<=',$akir)
				->get();

			$data2 =DB::table('delivery_order as do')
				->where('pendapatan','=','KARGO')
				->where('kode_cabang','=',$cabang)
				->where('tanggal','>=',$awal)
				->where('tanggal','<=',$akir)
				->get();
		}
		// return $data2;
		if ($data == null) {
			$data = 0;
		}else{
			for ($i=0; $i <count($data) ; $i++) { 
			$hit[$i] =  $data[$i]->total;
		}
			$data = array_sum($hit);
		}
		//batas
		if ($data1 == null) {
			$data1 = 0;
		}else{
			for ($i=0; $i <count($data1) ; $i++) { 
			$hit1[$i] =  $data1[$i]->total_net;
		}
			$data1 = array_sum($hit1);
		}
		//batas
		if ($data2 == null) {
			$data2 = 0;
		}else{
			for ($i=0; $i <count($data2) ; $i++) { 
			$hit2[$i] =  $data2[$i]->total_net;
		}
			$data2 = array_sum($hit2);
		}
		// return $data1[0]->total_net;
		if ($data == null && $data1 == null && $data2 == null) {
			return response()->json(['hasil'=>'0','a'=>$awal,'b'=>$akir]);
		}else{
       		return response()->json(['paket'=>$data,'koran'=>$data1,'kargo'=>$data2,'a'=>$awal,'b'=>$akir]);
		}
	}
	//END OF
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

		if ($data != null || $data1 != null || $data2 != null || $data3 != null) {
        	return response()->json(['dokumen'=>count($data),'kilogram'=>count($data1),'koli'=>count($data2),'sepeda'=>count($data3),'awal'=> $awal,'akir' => $akir]);			
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

	public function diagram_dokargo(){
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
		return view('purchase/omset_diagram/laporan_diagram_dokargo/lap_diagram_dokargo',compact('data','kota','kota1','ket','kargo'));
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

		
		$ket = DB::table('tarif_cabang_sepeda')->select('keterangan')->groupBy('keterangan')->get();
		$kota = DB::select("SELECT id, nama as tujuan from kota");
		$cus = DB::table('customer')->get();
		$kota1 = DB::select("SELECT id, nama as asal from kota");
		return view('purchase/master/master_penjualan/laporan/lap_invoice',compact('data','kota','kota1','ket','cus','invoice'));
	}

		public function cari_lap_invoice(Request $request){

		$awal = $request->a;
		$akir = $request->b;
		$data = DB::table('invoice')
				->where('i_tanggal','>=',$awal)
				->where('i_tanggal','<=',$akir)
				->get();

		
		for ($i=0; $i <count($data); $i++) { 
			$dat[$i] = $data[$i]->i_total;

			$array = array_sum($dat);

		}
				
		
		
		if ($data != null) {
        	return  response()->json(['data'=>$array,'awal'=> $awal,'akir' => $akir]);
		}else{
			return response()->json(['response'=>'Data Tidak Ditemukan !','awal'=> $awal,'akir' => $akir]);
		}

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

	// END OF posting_bayar




//❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤ END OFLAPORAN OPERASIONAL PENJUALAN ❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤//


	}
?>