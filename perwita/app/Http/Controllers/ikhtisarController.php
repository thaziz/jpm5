<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use PDF;
use App\tb_coa;
use App\tb_jurnal;
use App\patty_cash;
use DB;
use Response;
Use Carbon\Carbon;
use Session;
use Mail;
use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;
// use Datatables;


class ikhtisarController extends Controller
{
	public function index(){

		$data = DB::table('ikhtisar_kas')
				  ->join('cabang','kode','=','ik_comp')
				  ->get();

		return view('purchase.ikhtisar_kas.indexIkhtisar',compact('data'));
	}

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
	public function create(){

		$second = Carbon::now()->format('d/m/Y');
	        // $start = $first->subMonths(1)->startOfMonth();
		$first = Carbon::now();
	    $start = $first->subDays(30)->startOfDay()->format('d/m/Y');

		$cabang = DB::table('cabang')
				  ->where('kode','001')
				  ->first();

		$id = DB::table('ikhtisar_kas')
	    		->where('ik_comp','001')
	    		->max('ik_nota');

	    $year  = Carbon::now()->format('Y'); 
		$month = Carbon::now()->format('m');  	
		$now   = Carbon::now()->format('d-m-Y');

		if(isset($id)) {

			$explode = explode("/", $id);
		    $id = $explode[2];
			$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
			$string = (int)$id + 1;
			$id = str_pad($string, 3, '0', STR_PAD_LEFT);

		}

		else {
			$id = '001';
		}

		$akun_kas = DB::table('d_akun')
				  ->where('id_parrent',1001)
				  ->get();

		$ik = 'RB' . $month . $year . '/'. '001' . '/' .  $id;





		return view('purchase.ikhtisar_kas.createIkhtisar',compact('cabang','start','second','ik'));
	}

	public function cari_patty(request $request){

		if (isset($request->rangepicker)) {

			$tgl = explode('-',$request->rangepicker);
					$tgl[0] = str_replace('/', '-', $tgl[0]);
					$tgl[1] = str_replace('/', '-', $tgl[1]);
					$tgl[0] = str_replace(' ', '', $tgl[0]);
					$tgl[1] = str_replace(' ', '', $tgl[1]);
					$start  = Carbon::parse($tgl[0])->format('Y-m-d');
					$end    = Carbon::parse($tgl[1])->format('Y-m-d');



			$cari = DB::table('patty_cash')
							->join('jenisbayar','idjenisbayar','=','pc_ref')
							->join('d_akun','id_akun','=','pc_akun_kas')
							->leftjoin('ikhtisar_kas_detail','pc_id','=','ikd_pc_id')
							->where('pc_tgl','>=',$start)
							->where('ikd_pc_id','=',null)
							->where('pc_tgl','<=',$end)
							->take(1000)
							->get();
			$akun = DB::table('d_akun')
						  ->get();
		return view('purchase.ikhtisar_kas.table_ikhtisar',compact('cari','akun'));

		}else{
			$cari = DB::table('patty_cash')
							->join('jenisbayar','idjenisbayar','=','pc_ref')
							->leftjoin('ikhtisar_kas_detail','pc_id','=','ikd_pc_id')
							->join('d_akun','id_akun','=','pc_akun_kas')
							->where('ikd_pc_id','=',null)
							->take(1000)
							->get();

			$akun = DB::table('d_akun')
						  ->get();
		return view('purchase.ikhtisar_kas.table_ikhtisar',compact('cari','akun'));

		}
	}
	public function simpan(request $request){
			// dd($request);

		for ($i=0; $i < count($request->checker); $i++) { 
			$check_in[$i] = $request->checker[$i];
		}

		// return $check_in;
			$tgl = explode('-',$request->rangepicker);
					$tgl[0] = str_replace('/', '-', $tgl[0]);
					$tgl[1] = str_replace('/', '-', $tgl[1]);
					$tgl[0] = str_replace(' ', '', $tgl[0]);
					$tgl[1] = str_replace(' ', '', $tgl[1]);
					$start  = Carbon::parse($tgl[0])->format('Y-m-d');
					$end    = Carbon::parse($tgl[1])->format('Y-m-d');

			if (in_array('on', $check_in)) {

				$id = DB::table('ikhtisar_kas')
						->max('ik_id');


				if ($id != null) {
					$id += 1;
				}else{
					$id = 1;
				}
				for ($i=0; $i < count($request->checker); $i++) { 
					if ($request->checker[$i] == 'on') {
						$cari_id[$i] = DB::table('patty_cash')
									 ->where('pc_id',$request->id[$i])
									 ->get();
					}
				}

				$cari_id = array_values($cari_id);
				// return $cari_id;

				for ($i=0; $i < count($cari_id); $i++) { 
					$debet[$i] = (int)$cari_id[$i][0]->pc_debet;
				}
				$debet = array_sum($debet);
				// return $request->checker;

				$save_ikhtisar = DB::table('ikhtisar_kas')
								   ->insert([
								   		'ik_id'   		=> $id,
								   		'ik_nota' 		=> $request->ik,
								   		'ik_tgl_awal'  	=> $start,
								   		'ik_tgl_akhir' 	=> $end,
								   		'ik_keterangan' => $request->Keterangan,
								   		'ik_comp'		=> '001',
								   		'ik_total'		=> $debet,
								   		'ik_pelunasan'	=> $debet,
								   		'ik_edit'		=> 'UNALLOWED',
								   		'ik_status'		=> 'RELEASED',
								   		'created_at'	=> Carbon::now(),
								   		'updated_at'	=> Carbon::now()
								]);
				for ($i=0; $i < count($cari_id); $i++) { 

						$ikd = DB::table('ikhtisar_kas_detail')
						->max('ikd_id');


						if ($ikd != null) {
							$ikd += 1;
						}else{
							$ikd = 1;
						}

						$save_ikhtisar = DB::table('ikhtisar_kas_detail')
								   ->insert([
								   		'ikd_id'   		=> $ikd,
								   		'ikd_ik_id'   	=> $id,
								   		'ikd_pc_id'   	=> $cari_id[$i][0]->pc_id,
								   		'ikd_ik_dt'   	=> $i+1,
								   		'ikd_ref' 		=> $cari_id[$i][0]->pc_no_trans,
								   		'ikd_akun' 		=> $cari_id[$i][0]->pc_akun,
								   		'ikd_nominal'  	=> $cari_id[$i][0]->pc_debet,
								   		'ikd_keterangan'=> $cari_id[$i][0]->pc_keterangan,
								   		'created_at'	=> Carbon::now(),
								   		'updated_at'	=> Carbon::now()
								]);

						$update = DB::table('patty_cash')
									->where('pc_id',$request->id[$i])
								    ->update([
								   		'pc_reim'       => 'RELEASED',
								   		'updated_at'	=> Carbon::now()
									]);

						$cari_bp = DB::table('patty_cash')
								->where('pc_id',(int)$request->id[$i])
								->first();
					
						if($cari_bp->pc_ref == 10){
							// return 'asd';
							$updt_bk = DB::table('biaya_penerus_kas')
									 ->where('bpk_nota',$cari_bp->pc_no_trans)
									 ->update([
									 	'bpk_status'    => 'Approved',
									   	'updated_at'	=> Carbon::now()
									 ]);
						}

					
				}
				return Response()->json(['status' => 1]);
								   
			}else{
				return Response()->json(['status' => 2]);
			}

		}

		public function edit($id){

			$data = DB::table('ikhtisar_kas')
					  ->where('ik_id',$id)
					  ->join('cabang','kode','=','ik_comp')
					  ->first();

			$start = Carbon::parse($data->ik_tgl_awal)->format('d/m/Y');
			$end = Carbon::parse($data->ik_tgl_akhir)->format('d/m/Y');

			$data_dt = DB::table('ikhtisar_kas_detail')
					   ->join('patty_cash','ikd_pc_id','=','pc_id')
					   ->where('ikd_ik_id',$id)
					   ->get();
			$akun = DB::table('d_akun')
						  ->get();
			
			return view('purchase.ikhtisar_kas.edit_ikhtisar',compact('akun','data','start','end','id','data_dt'));
			
		}

		public function update(request $request){
			// dd($request);

			for ($i=0; $i < count($request->id_ikd); $i++) { 
				if ($request->checker[$i] == 'off') {
					$del = DB::table('ikhtisar_kas_detail')
						 ->where('ikd_ik_id',(int)$request->id_ik[$i])
						 ->where('ikd_ik_dt',(int)$request->id_ikd[$i])
						 ->delete();

					$update = DB::table('patty_cash')
									->where('pc_id',(int)$request->id_pc[$i])
								    ->update([
								   		'pc_reim'       => 'UNRELEASED',
								   		'updated_at'	=> Carbon::now()
									]);

					$cari_bp = DB::table('patty_cash')
								->where('pc_id',(int)$request->id_pc[$i])
								->first();
					
					if($cari_bp->pc_ref == 10){
						$updt_bk = DB::table('biaya_penerus')
								 ->where('bpk_nota',$cari_bp->pc_no_trans)
								 ->update([
								 	'bpk_status'    => 'Released',
								   	'updated_at'	=> Carbon::now()
								 ]);
					}

			
					

				}

				$val[$i] = $request->checker[$i];
				
			}

			if ($request->checked == 'on') {
				$status = 'APPROVED';
			}else{
				$status = 'RELEASED';
			}
			
			if (isset($harga)) {
				$harga = array_sum($harga);
			}

			$cari = DB::table('ikhtisar_kas_detail')
					  ->where('ikd_ik_id',$request->id_ik[0])
					  ->get();
			$sum = [];
			for ($i=0; $i < count($cari); $i++) { 
				$sum[$i] = $cari[$i]->ikd_nominal;
			}

			if ($sum != null) {
				$harga = array_sum($sum);
			}else{
				$harga = 0;
			}
			

			$updt = DB::table('ikhtisar_kas')
						 ->where('ik_nota',$request->ik)
					   	 ->update([
					   	 	'ik_status' 	=> $status,
					   	 	'ik_keterangan' => $request->Keterangan,
					   	 	'ik_total' => $harga
					   	 ]);
			// return $val;		   	 
			if (in_array('on', $val)) {
				return Response()->json(['status'=>1]);
			}else{
				$updt = DB::table('ikhtisar_kas')
						 ->where('ik_nota',$request->ik)
					   	 ->delete();

				return Response()->json(['status'=>2]);
				

			}
		}

		public function hapus($id){

			$cari = DB::table('ikhtisar_kas_detail')
					  ->where('ikd_ik_id',$id)
					  ->get();

			for ($i=0; $i < count($cari); $i++) { 

				$update = DB::table('patty_cash')
									->where('pc_id',$cari[$i]->ikd_pc_id)
								    ->update([
								   		'pc_reim'       => 'UNRELEASED',
								   		'updated_at'	=> Carbon::now()
									]);
				$cari_bp = DB::table('patty_cash')
								->where('pc_id',(int)$cari[$i]->ikd_pc_id)
								->first();
					
					if($cari_bp->pc_ref == 10){
						$updt_bk = DB::table('biaya_penerus_kas')
								 ->where('bpk_nota',$cari_bp->pc_no_trans)
								 ->update([
								 	'bpk_status'    => 'Released',
								   	'updated_at'	=> Carbon::now()
								 ]);
					}
			}

			$del = DB::table('ikhtisar_kas_detail')
						 ->where('ikd_ik_id',(int)$id)
						 ->delete();
			$del1 = DB::table('ikhtisar_kas')
						 ->where('ik_id',(int)$id)
						 ->delete();
		}

		public function cetak($id){
			$data = DB::table('ikhtisar_kas')
					  ->join('cabang','kode','=','ik_comp')
					  ->where('ik_id',$id)
					  ->first();

			$start = Carbon::parse($data->ik_tgl_awal)->format('d/m/Y');
			$end = Carbon::parse($data->ik_tgl_akhir)->format('d/m/Y');

			$data_dt = DB::table('ikhtisar_kas_detail')
					   ->join('patty_cash','ikd_pc_id','=','pc_id')
					   ->where('ikd_ik_id',$id)
					   ->get();


			$terbilang = $this->terbilang($data->ik_total,$style=3);

			return view('purchase.ikhtisar_kas.outputIkhtisar',compact('terbilang','data','start','end','id','data_dt'));

		}

		

}