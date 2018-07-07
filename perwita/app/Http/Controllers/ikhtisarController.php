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
use Auth;
use App\d_jurnal;
use App\d_jurnal_dt;
// use Datatables;


class ikhtisarController extends Controller
{
	public function index(){
		$cabang = Auth::user()->kode_cabang;
		if (Auth::user()->punyaAkses('Ikhtisar Kas','all')) {
			$data = DB::table('ikhtisar_kas')
				  ->join('cabang','kode','=','ik_comp')
				  ->get();
		}else{
			$data = DB::table('ikhtisar_kas')
				  ->join('cabang','kode','=','ik_comp')
				  ->where('ik_comp',$cabang)
				  ->get();
		}
		

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
				  ->get();






		return view('purchase.ikhtisar_kas.createIkhtisar',compact('cabang','start','second','ik'));
	}

	public function tes(request $req)
	{
		return DB::transaction(function() use ($req) {  
			// BIAYA PENERUS KAS SYNCHONIZE PATTY CASH DAN JURNAL
			$bpk = DB::table('biaya_penerus_kas')
					 ->select('bpk_nota','bpk_comp','created_by','bpk_tanggal','bpk_kode_akun','bpk_acc_biaya','bpk_keterangan','bpk_tarif_penerus')
					 ->orderBy('bpk_id','ASC')
					 ->get();

			$comp = DB::table('biaya_penerus_kas')
					 ->join('biaya_penerus_kas_detail','bpkd_bpk_id','=','bpk_id')
					 ->select('bpkd_kode_cabang_awal','bpk_nota')
					 ->orderBy('bpk_id','ASC')
					 ->get();

			$detail = DB::table('biaya_penerus_kas')
					 ->join('biaya_penerus_kas_detail','bpkd_bpk_id','=','bpk_id')
					 ->orderBy('bpk_id','ASC')
					 ->get();
			
			$comp = array_map("unserialize", array_unique( array_map( 'serialize', $comp ) ));
			$bpk = array_map("unserialize", array_unique( array_map( 'serialize', $bpk ) ));
			$comp = array_values($comp);
			$bpk = array_values($bpk);
			$filter_comp = [];
			for ($i=0; $i < count($bpk); $i++) { 
				for ($a=0; $a < count($comp); $a++) { 
					if ($bpk[$i]->bpk_nota == $comp[$a]->bpk_nota) {
						$filter_comp[$bpk[$i]->bpk_nota][$a] = $comp[$a]->bpkd_kode_cabang_awal;
						
					}
				}
				$filter_comp[$bpk[$i]->bpk_nota] = array_map("unserialize", array_unique( array_map( 'serialize', $filter_comp[$bpk[$i]->bpk_nota] ) ));
				$filter_comp[$bpk[$i]->bpk_nota] = array_values($filter_comp[$bpk[$i]->bpk_nota]);
				
			}
			
			for ($i=0; $i < count($bpk); $i++) { 
				$delete = DB::table('patty_cash')
						   ->where('pc_no_trans',$bpk[$i]->bpk_nota)
						   ->delete();

				$delete_jurnal = DB::table('d_jurnal')
							   ->where('jr_ref',$bpk[$i]->bpk_nota)
							   ->delete();
				// //JURNAL
				$id_jurnal=d_jurnal::max('jr_id')+1;

				$jenis_bayar = DB::table('jenisbayar')
								 ->where('idjenisbayar',10)
								 ->first();

				$jurnal_save = d_jurnal::create(['jr_id'=> $id_jurnal,
											'jr_year'   => carbon::parse($bpk[$i]->bpk_tanggal)->format('Y'),
											'jr_date' 	=> carbon::parse($bpk[$i]->bpk_tanggal)->format('Y-m-d'),
											'jr_detail' => $jenis_bayar->jenisbayar,
											'jr_ref'  	=> $bpk[$i]->bpk_nota,
											'jr_note'  	=> 'BIAYA PENERUS KAS',
											'jr_insert' => carbon::now(),
											'jr_update' => carbon::now(),
											]);

				$cari_coa = DB::table('d_akun')
									  ->where('id_akun','like',substr($bpk[$i]->bpk_kode_akun,0, 4).'%')
									  ->where('kode_cabang',$bpk[$i]->bpk_comp)
									  ->first();
					
				if ($cari_coa->akun_dka == 'D') {
					$data_akun[0]['jrdt_jurnal'] 	= $id_jurnal;
					$data_akun[0]['jrdt_detailid']	= 1;
					$data_akun[0]['jrdt_acc'] 	 	= $cari_coa->id_akun;
					$data_akun[0]['jrdt_value'] 	= -$bpk[$i]->bpk_tarif_penerus;
					$data_akun[0]['jrdt_statusdk'] = 'K';
				}else{
					$data_akun[0]['jrdt_jurnal'] 	= $id_jurnal;
					$data_akun[0]['jrdt_detailid']	= 1;
					$data_akun[0]['jrdt_acc'] 	 	= $cari_coa->id_akun;
					$data_akun[0]['jrdt_value'] 	= -$bpk[$i]->bpk_tarif_penerus;
					$data_akun[0]['jrdt_statusdk'] = 'D';
				}
				
				$jurnal_dt = d_jurnal_dt::insert($data_akun);

				$lihat_jurnal = DB::table('d_jurnal_dt')
								->where('jrdt_jurnal',$id_jurnal)
								->get();

				for ($a=0; $a < count($filter_comp[$bpk[$i]->bpk_nota]); $a++) { 
					$harga = 0;


					for ($b=0; $b < count($detail); $b++) { 
						if ($filter_comp[$bpk[$i]->bpk_nota][$a] == $detail[$b]->bpkd_kode_cabang_awal and
							$bpk[$i]->bpk_nota == $detail[$b]->bpk_nota) {
							$harga+=$detail[$b]->bpkd_tarif_penerus;
						}
					}

					

					$cari_id_pc = DB::table('patty_cash')
								 ->max('pc_id')+1;
					$cari_akun = DB::table('d_akun')
								   ->where('id_akun','like',substr($bpk[$i]->bpk_acc_biaya,0, 4).'%')
								   ->where('kode_cabang',$filter_comp[$bpk[$i]->bpk_nota][$a])
								   ->first();
					$save_patty = DB::table('patty_cash')
						   ->insert([
						   		'pc_id'			  => $cari_id_pc,
						   		'pc_tgl'		  => Carbon::now(),
						   		'pc_ref'	 	  => 10,
						   		'pc_akun' 		  => $cari_akun->id_akun,
						   		'pc_akun_kas' 	  => $bpk[$i]->bpk_acc_biaya,
						   		'pc_keterangan'	  => $bpk[$i]->bpk_keterangan,
						   		'pc_asal_comp' 	  => $filter_comp[$bpk[$i]->bpk_nota][$a],
						   		'pc_comp'  	  	  => $bpk[$i]->bpk_comp,
						   		'pc_edit'  	  	  => 'UNALLOWED',
						   		'pc_reim'  	  	  => 'UNRELEASED',
						   		'pc_debet'  	  => 0,
						   		'pc_user'    	  => $bpk[$i]->created_by,
						   		'pc_no_trans'  	  => $bpk[$i]->bpk_nota,
						   		'pc_kredit'  	  => $harga,
						   		'created_at'	  => Carbon::now(),
					        	'updated_at' 	  => Carbon::now()
					]);


					$cari_coa = DB::table('d_akun')
									  ->where('id_akun','like',$cari_akun->id_akun)
									  ->first();
					$dt = DB::table('d_jurnal_dt')
									->where('jrdt_jurnal',$id_jurnal)
									->max('jrdt_detailid')+1;
					if ($cari_coa->akun_dka == 'D') {
						$data_akun[0]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[0]['jrdt_detailid']	= $dt;
						$data_akun[0]['jrdt_acc'] 	 	= $cari_coa->id_akun;
						$data_akun[0]['jrdt_value'] 	= -$harga;
						$data_akun[0]['jrdt_statusdk'] = 'K';
					}else{
						$data_akun[0]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[0]['jrdt_detailid']	= $dt;
						$data_akun[0]['jrdt_acc'] 	 	= $cari_coa->id_akun;
						$data_akun[0]['jrdt_value'] 	= -$harga;
						$data_akun[0]['jrdt_statusdk'] = 'D';
					}
					
					$jurnal_dt = d_jurnal_dt::insert($data_akun);

					$lihat_jurnal = DB::table('d_jurnal_dt')
									->where('jrdt_jurnal',$id_jurnal)
									->get();

				}
			}
			// $cari = DB::table('patty_cash')->get();
			// dd($bpk);
			
			// $bulan= [];
			// $tahun= [];
			// $cab= [];
			// for ($i=0; $i < count($bkk); $i++) { 
			// 	$bulan[$i] = carbon::parse($bkk[$i]->bkk_tgl)->format('m');
			//     $tahun[$i] = carbon::parse($bkk[$i]->bkk_tgl)->format('y');
			//     $cab[$i] = $bkk[$i]->bkk_comp;
			// }
			// $bulan = array_unique($bulan);
			// $tahun = array_unique($tahun);
			// $bulan = array_values($bulan);
			// $tahun = array_values($tahun);
			// $cab   = array_unique($cab);
			// $cab   = array_values($cab);


			// for ($i=0; $i < count($tahun); $i++) { 
			// 	for ($a=0; $a < count($bulan); $a++) { 
			// 		for ($d=0; $d < count($cab); $d++) { 
			// 			$index = 1;
			// 			for ($c=0; $c < count($bkk); $c++) { 
			// 				$bln = carbon::parse($bkk[$c]->bkk_tgl)->format('m');
			// 				$thn = carbon::parse($bkk[$c]->bkk_tgl)->format('y');
			//     			$cabang = $bkk[$c]->bkk_comp;

			// 				if ($thn == $tahun[$i] and $bln == $bulan[$a] and $cabang == $cab[$d]) {
			// 					$index = str_pad($index, 3, '0', STR_PAD_LEFT);
			// 					$nota = 'BKK' . $bln  . $thn. '/' . $cabang . '/' .$index;
			// 					$update = DB::table('bukti_kas_keluar')
			// 								->where('bkk_id',$bkk[$c]->bkk_id)
			// 								->update(['bkk_nota'=>$nota]);


			// 					$index++;
			// 				}
			// 			}
			// 		}
			// 	}
			// }
		});

	}

	public function cari_patty(request $request){

		// dd($request->all());
		if (isset($request->rangepicker)) {

			$tgl = explode('-',$request->rangepicker);
					$tgl[0] = str_replace('/', '-', $tgl[0]);
					$tgl[1] = str_replace('/', '-', $tgl[1]);
					$tgl[0] = str_replace(' ', '', $tgl[0]);
					$tgl[1] = str_replace(' ', '', $tgl[1]);
					$start  = Carbon::parse($tgl[0])->format('Y-m-d');
					$end    = Carbon::parse($tgl[1])->format('Y-m-d');



			$patty = DB::table('patty_cash')
							->join('jenisbayar','idjenisbayar','=','pc_ref')
							->join('d_akun','id_akun','=','pc_akun_kas')
							->where('pc_tgl','>=',$start)
							->where('pc_tgl','<=',$end)
							->orderBy('pc_no_trans','ASC')
							->take(5000)
							->get();
			$nomor = DB::table('patty_cash')
							->join('jenisbayar','idjenisbayar','=','pc_ref')
							->select('pc_no_trans')
							// ->where('pc_tgl','>=',$start)
							// ->where('pc_tgl','<=',$end)
							->orderBy('pc_no_trans','ASC')
							->take(5000)
							->get();

			$cari = array_map("unserialize", array_unique( array_map( 'serialize', $nomor ) ));
			$cari = array_values($cari);
			$tes=[];
			for ($i=0; $i < count($cari); $i++) { 
				$tes[$i] = $cari[$i];
			}
			$cari = DB::table('patty_cash')
							->join('jenisbayar','idjenisbayar','=','pc_ref')
							->leftjoin('ikhtisar_kas_detail','pc_id','=','ikd_pc_id')
							->join('d_akun','id_akun','=','pc_akun_kas')
							->where('ikd_pc_id','=',null)
							->where('pc_comp','=',$request->cabang)
							->take(5000)
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
							->where('pc_comp','=',$request->cabang)
							->take(5000)
							->get();

			$akun = DB::table('d_akun')
						  ->get();
		return view('purchase.ikhtisar_kas.table_ikhtisar',compact('cari','akun'));

		}
	}
	public function simpan(request $request){
			// dd($request->all());

		for ($i=0; $i < count($request->checker); $i++) { 
			$check_in[$i] = $request->checker[$i];
		}
		$datacomp = $request->cabang;

		$datakun = DB::select("select * from d_akun where id_akun LIKE '1001%' and  kode_cabang = '$datacomp'");
		if(count($datakun) == 0){
				return Response()->json(['status' => 3, 'message' => 'Data Akun KAS untuk cabang '. $datacomp.'']);
		}
		else {
				$acchutang = $datakun[0]->id_akun;
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
					$debet[$i] = (int)$cari_id[$i][0]->pc_kredit;
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
								   		'ik_comp'		=> $request->cabang,
								   		'ik_total'		=> $debet,
								   		'ik_pelunasan'	=> $debet,
								   		'ik_edit'		=> 'UNALLOWED',
								   		'ik_status'		=> 'RELEASED',
								   		'created_at'	=> Carbon::now(),
								   		'updated_at'	=> Carbon::now(),
								   		'ik_akunhutang' => $acchutang,
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
								   		'ikd_nominal'  	=> $cari_id[$i][0]->pc_kredit,
								   		'ikd_keterangan'=> $cari_id[$i][0]->pc_keterangan,
								   		'ikd_acc_hutang'=> $cari_id[$i][0]->pc_akun,
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
			if (Auth::user()->punyaAkses('Approve Ikhtisar','ubah')) {
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

		public function nota(request $req)
		{
			$bulan = Carbon::now()->format('m');
		    $tahun = Carbon::now()->format('y');

		    $cari_nota = DB::select("SELECT  substring(max(ik_nota),12) as id from ikhtisar_kas
		                                    WHERE ik_comp = '$req->cabang'
		                                    AND to_char(created_at,'MM') = '$bulan'
		                                    AND to_char(created_at,'YY') = '$tahun'");

		    $index = (integer)$cari_nota[0]->id + 1;
		    $index = str_pad($index, 3, '0', STR_PAD_LEFT);

			
			$nota = 'RB' . $bulan . $tahun . '/' . $req->cabang . '/' .$index;

			return response()->json(['nota'=>$nota]);		
		}

		

}