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


class LaporanPurchaseController extends Controller
{
	private function setPdf($view,$data,$pdfName,$kertas = 'potrait')
	{
		$pdf = PDF::loadView($view,$data)->setPaper('a4', $kertas);

		return $pdf->download($pdfName);
	}


	// Master Item
	public function reportmasteritem()
	{
		return view('purchase/laporan/masteritem', [
			"masterItem" => $this->masterItemData()
		]);
	}

	public function masterItemViewReport(Request $request)
	{
		view()->share("masterItem", $this->masterItemData());

		if ($request->has('download')) {
			return $this->setPdf(
				"purchase/laporan/pdf/masterItem",
				"masterItem.pdf"
			);
		}

		return view("purchase/laporan/pdf/masterItem");
	}


	// Master Group Item
	public function reportmastergroupitem()
	{
		return view('purchase/laporan/mastergroupitem', [
			"masterItemGroup" => $this->masterGroupItemData()
		]);
	}

	public function masterItemGroupViewReport(Request $request)
	{
		view()->share("masterItemGroup", $this->masterGroupItemData());

		if ($request->has('download')) {
			return $this->setPdf(
				"purchase/laporan/pdf/masterItemGroup",
				"masterItemGroup.pdf"
			);
		}

		return view("purchase/laporan/pdf/masterItemGroup");
	}


	// Master Department
	public function reportmasterdepartment()
	{
		return view('purchase/laporan/masterdepartment', [
			"masterDepartment" => $this->masterDepartmentData()
		]);
	}

	public function masterDepartmentViewReport(Request $request)
	{
		view()->share("masterDepartment", $this->masterDepartmentData());

		if ($request->has('download')) {
			return $this->setPdf(
				"purchase/laporan/pdf/masterDepartment",
				"masterDepartment.pdf"
			);
		}

		return view("purchase/laporan/pdf/masterDepartment");
	}


	// Master Gudang
	public function reportmastergudang()
	{
		return view('purchase/laporan/mastergudang', [
			"masterGudang" => $this->masterGudangData()
		]);
	}

	public function masterGudangViewReport(Request $request)
	{
		view()->share("masterGudang", $this->masterGudangData());

		if ($request->has('download')) {
			return $this->setPdf(
				"purchase/laporan/pdf/masterGudang",
				"masterDepartment.pdf"
			);
		}

		return view("purchase/laporan/pdf/masterGudang");
	}


	// Master Supplier
	public function reportmastersupplier()
	{
		return view('purchase/laporan/mastersupplier', [
			"masterSupplier" => $this->masterSupplierData()
		]);
	}

	public function masterSupplierViewReport(Request $request)
	{
		view()->share("masterSupplier", $this->masterSupplierData());

		if ($request->has('download')) {
			return $this->setPdf(
				"purchase/laporan/pdf/masterSupplier",
				"masterSupplier.pdf"
			);
		}

		return view("purchase/laporan/pdf/masterSupplier");
	}



	public function reportspp() {

				 $cari=DB::table('spp')			
					 ->join('cabang','kode','=','spp_cabang')
					 ->get();

		 return view('purchase/laporan/spp',compact('cari'));
	}
	public function tablespp(request $request){

		// dd($request);
			$data=[];
		for ($i=0; $i < count($request->asw); $i++) { 
			$data1 = DB::table('spp')
				  ->leftjoin('spp_totalbiaya','spptb_idspp','=','spp_id')
				  ->join('cabang','kode','=','spp_cabang')
				  ->where('spp_nospp','=',$request->asw[$i])
				  ->get();
		$data[$i] = $data1[0];
		}






		$po = DB::table('spp_totalbiaya')
					->where('spptb_poid' ,'!=', null)
					->get();




		$bulan1 = Carbon::parse($request->tgl1)->format('d/F/Y');
		$bulan2 = Carbon::parse($request->tgl2)->format('d/F/Y');
		$tgl1   =$request->tgl1;
		$tgl2   =$request->tgl2;
		
			view()->share([
						   'bulan1'=>$bulan1,
						   'bulan2'=>$bulan2,
						   'tgl1'=>$request->tgl1,
						   'tgl2'=>$request->tgl2,
						   'data'=>$data,
						   'po'=>$po
						]);
		if ($request->has('download')) {
			$bulan1 = Carbon::parse($tgl1)->format('d/F/Y');
		    $bulan2 = Carbon::parse($tgl2)->format('d/F/Y');
			
			for ($i=0; $i < count($request->data); $i++) { 
			$data1 = DB::table('spp')
				  ->leftjoin('spp_totalbiaya','spptb_idspp','=','spp_id')
				  ->join('cabang','kode','=','spp_cabang')
				  ->where('spp_nospp','=',$request->data[$i]['spp_nospp'])
				  ->get();
				$data[$i] = $data1[0];
			}
		// return $data;

			// return $data[0]->nama;
			$pdf = PDF::loadView('purchase/laporan/tabelSpp2',compact('bulan1','bulan2','tgl1','tgl2','data','po'))->setPaper('a4','potrait');
			return $pdf->download('tabel'.$tgl1.'.pdf');
		}

		return view('purchase/laporan/tableSpp');
	}



	public function reportpo() {

		 $cari=DB::table('pembelian_order')			
					 ->join('pembelian_orderdt','podt_idpo','=','po_id')
					 ->join('spp','spp_id','=','podt_idspp')
					 ->join('cabang','kode','=','spp_cabang')
					 ->get();

		 return view('purchase/laporan/po',compact('cari'));
	}
    public function tablepo(Request $request){

    	$data=[];
    	$data1=[];
		for ($i=0; $i < count($request->asw); $i++) { 
			$cari=DB::table('pembelian_order')			
					 ->join('pembelian_orderdt','podt_idpo','=','po_id')
					 ->join('spp','spp_id','=','podt_idspp')
					 ->join('cabang','kode','=','spp_cabang')
					 ->join('supplier','idsup','=','po_supplier')
					 ->where('po_no','=',$request->asw[$i])
					 ->get();
		   
		$data[$i] = $cari[0];
		// $data1[$i] = $cariDT[0];
		}


			// return $data;
		
		$bulan1 = Carbon::parse($request->tgl1)->format('d/F/Y');
		$bulan2 = Carbon::parse($request->tgl2)->format('d/F/Y');
		$tgl1   =$request->tgl1;
		$tgl2   =$request->tgl2;
		
			view()->share([
						   'bulan1'=>$bulan1,
						   'bulan2'=>$bulan2,
						   'tgl1'=>$request->tgl1,
						   'tgl2'=>$request->tgl2,
						   'data'=>$data
						]);
		if ($request->has('download')) {
			$bulan1 = Carbon::parse($tgl1)->format('d/F/Y');
		    $bulan2 = Carbon::parse($tgl2)->format('d/F/Y');
			
			for ($i=0; $i < count($request->data); $i++) { 
			$cari=DB::table('pembelian_order')			
					 ->join('pembelian_orderdt','podt_idpo','=','po_id')
					 ->join('spp','spp_id','=','podt_idspp')
					 ->join('cabang','kode','=','spp_cabang')
					 ->join('supplier','idsup','=','po_supplier')
					 ->where('po_no','=',$request->data[$i]['po_no'])
					 ->get();
		   
		$data[$i] = $cari[0];
			}
		// return $data;

			// return $data[0]->nama;
			$pdf = PDF::loadView('purchase/laporan/tablePO2',compact('bulan1','bulan2','tgl1','tgl2','data'))->setPaper('a4','potrait');
			return $pdf->download('tabel'.$tgl1.'.pdf');
		}

		return view('purchase/laporan/tablePO1');
    }


	public function reportfakturpembelian() {
		 return view('purchase/laporan/fakturpembelian');
	}

	public function reportbayarkas() {
		 return view('purchase/laporan/bayarkas');
	}

	public function reportbayarbank() {
		 return view('purchase/laporan/bayarbank');
	}

	public function reportmutasihutang() {
		 return view('purchase/laporan/mutasihutang');
	}

	public function reportkartuhutang() {
		 return view('purchase/laporan/kartuhutang');
	}

	public function reportfakturpelunasan() {
		 return view('purchase/laporan/historisfaktur');
	}

	public function reportanalisausiahutang() {
		 return view('purchase/laporan/analisausiahutang');
	}

	public function reportfakturpajakmasukan() {
		 return view('purchase/laporan/fakturpajakmasukan');
	}

	public function historisuangmukapembelian() {
		 return view('purchase/laporan/historisuangmukapembelian');
	}

	public function invoice()
	{
		return view("invoice.index");
	}


	private function getData($table)
	{
		$var = $table::all();

		return $var;
	}


	// Get Data From Master Item Table 
	private function masterItemData()
	{
		$data = $this->getData(new masterItemPurchase);
		$masterItem = [];

		for ($index = 0; $index < count($data); $index++) { 
			$masterItem["kodeItem"][] = $data[$index]["kode_item"];
			$masterItem["namaItem"][] = $data[$index]["nama_masteritem"];
			$masterItem["groupItem"][] = $data[$index]["groupitem"];
			$masterItem["satuanItem"][] = $data[$index]["unitstock"];
			$masterItem["accStock"][] = "Undefined";		//$data[$index]["acc_persediaan"];
			$masterItem["accHpp"][] = "Undefined";		//$data[$index]["acc_hpp"];
		}

		return $masterItem;
	}


	// Get Data From Master Item Group Table 
	private function masterGroupItemData()
	{
		$data = $this->getData(new masterGroupItemPurchase);
		$masterItemGroup = [];

		for ($index = 0; $index < count($data) ; $index++) { 
			$masterItemGroup["kodeGroup"][] = $data[$index]["kode_groupitem"];
			$masterItemGroup["keterangan"][] = $data[$index]["keterangan_groupitem"];
		}

		return $masterItemGroup;
	}


	// Get Data From Master Department Table
	private function masterDepartmentData()
	{
		$data = $this->getData(new master_department);
		$masterDepartment = [];

		for ($index = 0; $index < count($data); $index++) { 
			$masterDepartment["kode"][] = $data[$index]["kode_department"];
			$masterDepartment["dept"][] = $data[$index]["nama_department"];
		}

		return $masterDepartment;
	} 


	// Get Data From Master Gudang Table
	private function masterGudangData()
	{
		$data = $this->getData(new masterGudangPurchase);
		$masterGudang = [];

		for ($index = 0; $index < count($data); $index++) { 
			$masterGudang["nama"][] = $data[$index]["mg_namagudang"];
			$masterGudang["cabang"][] = $data[$index]["mg_cabang"];
			$masterGudang["alamat"][] = $data[$index]["mg_alamat"];
		}

		return $masterGudang;
	}


	// Get Data From Master Gudang Table
	private function masterSupplierData()
	{
		$data = masterSupplierPurchase::where([
			["status", "SETUJU"],
			["active", "AKTIF"]
		])->get();
		$masterSupplier = [];

		for ($index = 0; $index < count($data); $index++) { 
			$kota[] = DB::table("kota")
			->select("nama2", "id_provinsi")
			->where("id", $data[$index]["kota"])
			->get();

			$provinsi[] = DB::table("provinsi")
			->select("nama")
			->where("id", $kota[$index][0]->id_provinsi)
			->get();

			$masterSupplier["kode"][] = $data[$index]["no_supplier"];
			$masterSupplier["nama"][] = $data[$index]["nama_supplier"];
			$masterSupplier["alamat"][] = $data[$index]["alamat"];
			$masterSupplier["kota"][] = $kota[$index][0]->nama2;
			$masterSupplier["provinsi"][] = $provinsi[$index][0]->nama;
			$masterSupplier["kodePos"][] = $data[$index]["kodepos"];
			$masterSupplier["cabang"][] = $data[$index]["idcabang"];
			$masterSupplier["kodePos"][] = $data[$index]["kodepos"];
			$masterSupplier["telp"][] = $data[$index]["telp"];
			$masterSupplier["contPerson"][] = $data[$index]["contact_person"];
			$masterSupplier["kredit"][] = $data[$index]["syarat_kredit"];
			$masterSupplier["plafon"][] = $data[$index]["plafon"];
			$masterSupplier["currency"][] = $data[$index]["currency"];
			$masterSupplier["npwp"][] = $data[$index]["pajak_npwp"];
			$masterSupplier["hutang"][] = $data[$index]["acc_hutang"];
			$masterSupplier["status"][] = $data[$index]["status"];
		}
		
		return $masterSupplier;
	}

	/*
		<a class="btn btn-info" href="{{ route('masterGudang.ViewReport', ['download' => 'pdf']) }}">
                        <i class="fa fa-print" aria-hidden="true"></i> Download PDF 
                    </a> 
	*/
}
