<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use redirect;
use App\d_uangmuka;
use Carbon\carbon;
use App\Http\Controllers\Controller;
use Session;
use Auth;
use Yajra\Datatables\Datatables;
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
		$cabang = session::get('cabang');
		if(Auth::user()->punyaAkses('Uang Muka','all')){
			$data = DB::table('d_uangmuka')->orderBy('um_id', 'DESC')
				->get();
		}
		else {
			$data = DB::table('d_uangmuka')->where('um_comp' , $cabang)->orderBy('um_id', 'DESC')
				->get();
		}
		return view('uangmuka.index',compact('data'));
	}

	public function table(Request $request) {
		  $data='';		  
  		  $tgl='';
  		  $nomor='';
  		  $tgl1=date('Y-m-d',strtotime($request->tanggal1));
  		  $tgl2=date('Y-m-d',strtotime($request->tanggal2));
  		
  		  if($request->tanggal1!='' && $request->tanggal2!=''){  		  	
  		  	$tgl="and um_tgl >= '$tgl1' AND um_tgl <= '$tgl2'";
  		  }  		    		  
  		  if($request->nomor!=''){
  		  	$nomor="and um_nomorbukti=UPPER('$request->nomor')";
  		  }
  		  
		 $cabang = session::get('cabang');
		
		$data='';
		if(Auth::user()->punyaAkses('Uang Muka','all')){
			$data = DB::select("select *, 'no' as no from d_uangmuka  where um_id is not null $tgl $nomor order by um_id desc");

		}
		else {
			$data = DB::select("select *,'no' as no from d_uangmuka where um_comp='$cabang' $tgl $nomor order by um_id desc");
		}
		
		$data=collect($data);


			return DataTables::of($data)		
           ->editColumn('um_jumlah', function ($data) { 
                return '<o style="float: left;">Rp.</o> <o style="float: right;">'.number_format($data->um_jumlah,2,',','.').'</o>';                
            })
           ->editColumn('um_tgl', function ($data) { 
                return date('d-m-Y', strtotime($data->um_tgl));                
            })           
           ->addColumn('action', function ($data) {                 
				$action='';

            	    if(Auth::user()->punyaAkses('Uang Muka','ubah')){
                          $action.='<a                           
                          href='.url('uangmuka/edituangmuka/'.$data->um_id.'').'>
                          <i class="btn btn-primary fa fa-cog "></i></a>';
                    }
                    if(Auth::user()->punyaAkses('Uang Muka','hapus')){
                          $action.='<a                           
                          href='.url('uangmuka/hapusuangmuka/'.$data->um_id.'').'>
                          <i class="btn btn-danger fa fa-trash "></i></a>';
                    }
                    if(Auth::user()->punyaAkses('Uang Muka','print')){
                           $action.='<a href='.url('uangmuka/print_uangmuka/'.$data->um_id.'').'>
                           <i class="btn btn-info fa fa-print "></i></a>';
                    }

				return $action;


            })
            
			->make(true);	

	}

	public function ajax(Request $request){
		
		$utama = $request->an;
		
		if ($utama == 'supplier') {
			$data = DB::table('supplier')->select('no_supplier','nama_supplier')->where([['status' , '=' , 'SETUJU'],['active' , '=', 'AKTIF']])->get();
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


	public function getnota(Request $request){
	  $cabang = $request->cabang;
		
	     
      $bulan = Carbon::now()->format('m');
      $tahun = Carbon::now()->format('y');
   		
    	
		$um = DB::select("SELECT * from d_uangmuka where um_comp = '$request->comp' and to_char(um_tgl, 'MM') = '$bulan' and to_char(um_tgl, 'YY') = '$tahun' order by um_id desc limit 1");

	
		if(count($um) > 0) {
		
			$explode = explode("/", $um[0]->um_nomorbukti);
			$idnota = $explode[2];
		

			$idnota = (int)$idnota + 1;
			$data['idum'] = str_pad($idnota, 4, '0', STR_PAD_LEFT);
			
		}

		else {
	
			$data['idum'] = '0001';
		}

		$datainfo = ['status' => 'sukses' , 'data' => $data['idum']];

		return json_encode($datainfo);
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

		$a = DB::table('supplier')->Select('no_supplier','nama_supplier')->where([['status' , '=' , 'SETUJU'],['active' , '=', 'AKTIF']]);	
		$b = DB::table('agen')->select('kode','nama');
		$c = DB::table('subcon')->select('kode','nama');
		$cabang = DB::select("select * from cabang");
		/*$data['cabang'] = DB::select("select * from cabang");*/
		$data = $a->union($b)->union($c)->get();

	    $sup = $request->suppliering;

		$lel = DB::table('supplier')->select('no_supplier','nama_supplier')->where([['status' , '=' , 'SETUJU'],['active' , '=', 'AKTIF']])->get();
		return view('uangmuka.create',compact('data','no_bukti', 'cabang'));
	}
	public function store(Request $request){

	$request->jumlah= str_replace("Rp.",'',$request->jumlah);
	$request->jumlah= str_replace(".",'',$request->jumlah);


	$comp = $request->cabang;
	$datakun2 = DB::select("select * from d_akun where id_akun LIKE '1405%' and kode_cabang = '$comp'");
	
	if(count($datakun2) == 0){
		$dataInfo=['status'=>'gagal','info'=>'Akun UM Pembelian Untuk Cabang '.$comp.' Tersedia'];
		DB::rollback();
		return json_encode($dataInfo);		
	}
	else {
		$dataakunitem = $datakun2[0]->id_akun;
	}

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
	$simpan->um_comp=$request->cabang;
	$simpan->um_sisapelunasan=$request->jumlah;
	$simpan->um_akunhutang = $dataakunitem;
	$simpan->created_by = $request->username;
	$simpan->updated_by = $request->username;
	$simpan->save();

	return json_encode('sukses');

	}
	public function edit($um_id){

		$semua = d_uangmuka::select('um_tgl','um_supplier','no_supplier','nama_supplier','a.kode as kode_a','a.nama as nama_a','b.kode as kode_b','b.nama as nama_b','um_nomorbukti','um_keterangan','um_jumlah','um_alamat','um_id')->leftjoin('supplier','no_supplier','=','um_supplier')->leftjoin('agen AS a','a.kode','=','um_supplier')->leftjoin('subcon AS b','b.kode','=','um_supplier')->findOrfail($um_id);
		
		$a = DB::table('supplier')->Select('no_supplier','nama_supplier');	
		$b = DB::table('agen')->select('kode','nama');
		$c = DB::table('subcon')->select('kode','nama');
		$cabang = DB::select("select * from cabang");
		$data = $a->union($b)->union($c)->get();


		return view('uangmuka.edit',compact('data','semua','selectop','cabang'));
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
		/*return view('uangmuka.print_uangmuka',compact('data','a','b','c1','c2','c3','c4','d','e','f','g','h','i','j','k','l','terbilang'));*/

		return json_encode('sukses');
	}
}
