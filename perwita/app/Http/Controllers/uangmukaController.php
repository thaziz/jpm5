<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use redirect;
use App\d_uangmuka;
use Carbon\carbon;
use App\Http\Controllers\Controller;
class uangmukaController extends Controller
{
	public function kekata($x) {
    $x = abs($x);
    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
    "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($x <12) {
        $temp = " ". $angka[$x];
    } else if ($x <20) {
        $temp = $this->kekata($x - 10). " belas";
    } else if ($x <100) {
        $temp = $this->kekata($x/10)." puluh". $this->kekata($x % 10);
    } else if ($x <200) {
        $temp = " seratus" . $this->kekata($x - 100);
    } else if ($x <1000) {
        $temp = $this->kekata($x/100) . " ratus" . $this->kekata($x % 100);
    } else if ($x <2000) {
        $temp = " seribu" . $this->kekata($x - 1000);
    } else if ($x <1000000) {
        $temp = $this->kekata($x/1000) . " ribu" . $this->kekata($x % 1000);
    } else if ($x <1000000000) {
        $temp = $this->kekata($x/1000000) . " juta" . $this->kekata($x % 1000000);
    } else if ($x <1000000000000) {
        $temp = $this->kekata($x/1000000000) . " milyar" . $this->kekata(fmod($x,1000000000));
    } else if ($x <1000000000000000) {
        $temp = $this->kekata($x/1000000000000) . " trilyun" . $this->kekata(fmod($x,1000000000000));
    }     
        return $temp;
}
 
 
	public function terbilang($x, $style=4) {
    if($x<0) {
        $hasil = "minus ". trim($this->kekata($x));
    } else {
        $hasil = trim($this->kekata($x));
    }     
    switch ($style) {
        case 1:
            $hasil = strtoupper($hasil);
            break;
        case 2:
            $hasil = strtolower($hasil);
            break;
        case 3:
            $hasil = ucwords($hasil);
            break;
        default:
            $hasil = ucfirst($hasil);
            break;
    }     
    return $hasil;
}

	public function index(){
		$data = DB::table('d_uangmuka')
				->get();
		return view('uangmuka.index',compact('data'));
	}
	public function ajax(Request $request){
		
		$utama = $request->an;
		
		if ($utama == 'supplier') {
			$data = DB::table('supplier')->select('no_supplier','nama_supplier')->get();
			$supli = 'supplier';
		}
		elseif ($utama == 'agen') {
			$data = DB::table('agen As a')->select('a.kode AS no_supplier','a.nama AS nama_supplier')->get();
			$supli = 'agen';
		}
		else{
			$data = DB::table('subcon As b')->select('b.kode AS no_supplier','b.nama AS nama_supplier')->get();
			$supli = 'subcon';
		}
		
		return view('uangmuka.ajax',compact('data','a','supli'));
	}
	public function create(Request $request){
		 


		 $waktu = carbon::now();
		 $year = $waktu->year; 
		 $month = $waktu->month;

		 if($month < 10) {
         $month = '0' . $month;
         }

         //select max dari um_id dari table d_uangmuka
		$maxid = DB::Table('d_uangmuka')->select('um_id')->max('um_id');

		//untuk +1 nilai yang ada,, jika kosong maka maxid = 1 , 
		if ($maxid <= 0 || $maxid <= '') {
			$maxid	= 1;
		}else{
			$maxid += 1;
		}

		//jika kurang dari 100 maka maxid mimiliki 00 didepannya
		if ($maxid < 100) {
			$maxid = '00'.$maxid;
		}

		$no_bukti = 'UM'.'-'.$month.$year.'/'.'C001'.'/'.$maxid;

		$a = DB::table('supplier')->Select('no_supplier','nama_supplier');	
		$b = DB::table('agen')->select('kode','nama');
		$c = DB::table('subcon')->select('kode','nama');

		$data = $a->union($b)->union($c)->get();

	    $sup = $request->suppliering;

		$lel = DB::table('supplier')->select('no_supplier','nama_supplier')->get();
		return view('uangmuka.create',compact('data','no_bukti'));
	}
	public function store(Request $request){

	$request->jumlah= str_replace("Rp.",'',$request->jumlah);
	$request->jumlah= str_replace(".",'',$request->jumlah);

	$anjay = DB::Table('d_uangmuka')->select('um_id')->max('um_id');
	if ($anjay <= 0 || $anjay <= '') {
			$anjay	= 1;
		}else{
			$anjay += 1;
		}

	$simpan = new d_uangmuka;
	$simpan->um_id=$anjay;
	$simpan->um_nomorbukti=$request->nobukti;
	$simpan->um_tgl=$request->tgl;
	$simpan->um_alamat=$request->alamat;
	$simpan->um_keterangan=$request->keterangan;
	$simpan->um_jumlah=$request->jumlah;
	$simpan->um_supplier=$request->supplier;
	$simpan->um_jenissup=$request->jenissub;
	$simpan->um_comp='C001';
	$simpan->um_sisapelunasan=$request->jumlah;
	$simpan->save();

	return redirect('uangmuka');
	}
	public function edit($um_id){

		$semua = d_uangmuka::select('um_tgl','um_supplier','no_supplier','nama_supplier','a.kode as kode_a','a.nama as nama_a','b.kode as kode_b','b.nama as nama_b','um_nomorbukti','um_keterangan','um_jumlah','um_alamat','um_id')->leftjoin('supplier','no_supplier','=','um_supplier')->leftjoin('agen AS a','a.kode','=','um_supplier')->leftjoin('subcon AS b','b.kode','=','um_supplier')->findOrfail($um_id);
		
		$a = DB::table('supplier')->Select('no_supplier','nama_supplier');	
		$b = DB::table('agen')->select('kode','nama');
		$c = DB::table('subcon')->select('kode','nama');

		$data = $a->union($b)->union($c)->get();


		return view('uangmuka.edit',compact('data','semua','selectop'));
	}
	public function hapus ($um_id){
		DB::table('d_uangmuka')->where('um_id',$um_id)->delete();
		return redirect('uangmuka');
	}
	public function update(Request $request,$um_id){

	$request->jumlah= str_replace("Rp.",'',$request->jumlah);
	$request->jumlah= str_replace(".",'',$request->jumlah);

	$update = d_uangmuka::findOrfail($um_id);
	$update->um_id=$request->um_id;
	$update->um_nomorbukti=$request->nobukti;
	$update->um_tgl=$request->tgl;
	$update->um_alamat=$request->alamat;
	$update->um_keterangan=$request->keterangan;
	$update->um_jumlah=$request->jumlah;
	$update->um_supplier=$request->supplier;
	$update->save();

	return redirect('uangmuka');
	}
	public function cetak ($um_id){
		$data = d_uangmuka::select('um_tgl','um_supplier','no_supplier','nama_supplier','a.kode as kode_a','a.nama as nama_a','b.kode as kode_b','b.nama as nama_b','um_nomorbukti','um_keterangan','um_jumlah','um_alamat','um_id')->leftjoin('supplier','no_supplier','=','um_supplier')->leftjoin('agen AS a','a.kode','=','um_supplier')->leftjoin('subcon AS b','b.kode','=','um_supplier')->where('um_id',$um_id)->get();

		foreach ($data as $key => $value) {
			$a = $value->um_nomorbukti; 
		}
		foreach ($data as $key => $value) {
			$b = $value->um_tgl;
		}
		foreach ($data as $key => $value) {
			$c2 = strtoupper($value->nama_supplier);
		}
		foreach ($data as $key => $value) {
			$c3 = strtoupper($value->nama_a);
		}
		foreach ($data as $key => $value) {
			$c4 = strtoupper($value->nama_b);
		}
		foreach ($data as $key => $value) {
			$d = strtoupper($value->um_supplier);
		}
		foreach ($data as $key => $value) {
			$e = strtoupper($value->um_alamat);
		}
		foreach ($data as $key => $value) {
			$f = strtoupper($value->um_keterangan);
		}
		foreach ($data as $key => $value) {
			$g = $value->um_jumlah;
		}
		$terbilang = $this->terbilang($g,$style=3);
		return view('uangmuka.print_uangmuka',compact('data','a','b','c1','c2','c3','c4','d','e','f','g','h','i','j','k','l','terbilang'));
	}
}
