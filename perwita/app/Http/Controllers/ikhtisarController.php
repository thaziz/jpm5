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
use Exception;
use Yajra\Datatables\Datatables;


class ikhtisarController extends Controller
{
	public function index(){
		$cabang = DB::table('cabang')
                  ->get();
	
		

		return view('purchase.ikhtisar_kas.indexIkhtisar',compact('cabang'));
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

	public function append_table(request $req)
	{
		$cab = $req->cabang;
		return view('purchase.ikhtisar_kas.tabel_ik',compact('cab'));
	}

	public function datatable_ikhtisar(Request $req)
    {	
    	$nama_cabang = DB::table("cabang")
						 ->where('kode',$req->cabang)
						 ->first();

		if ($nama_cabang != null) {
			$cabang = 'and ik_comp = '."'$req->cabang'";
		}else{
			$cabang = '';
		}


		if (Auth::user()->punyaAkses('Biaya Penerus Kas','all')) {
			$sql = "SELECT * FROM ikhtisar_kas  join cabang on kode = ik_comp where ik_nota != '0' $cabang";
			$data = DB::select($sql);
		}else{
			$cabang = Auth::user()->kode_cabang;
			$data = DB::table('ikhtisar_kas')
                      ->join('cabang','kode','=','ik_comp')
                      ->where('ik_comp',$cabang)
                      ->get();
		}

        $data = collect($data);

        // return $data;
        return Datatables::of($data)
            ->addColumn('aksi', function ($data) {
            	$a = '';
                if(Auth::user()->punyaAkses('Ikhtisar Kas','ubah') or $data->ik_edit == 'ALLOWED'){
                	if ($data->ik_status == 'RELEASED' or Auth::user()->kode_cabang == '000') {
                		if(cek_periode(carbon::parse($data->created_at)->format('m'),carbon::parse($data->created_at)->format('Y') ) != 0){
	                      $a = '<a title="Edit" class="btn btn-success" href='.url('ikhtisar_kas/edit').'/'.$data->ik_id.'><i class="fa fa-arrow-right" aria-hidden="true"></i></a>';
	                    }
                	}
                }

                

                $c = '<a title="Hapus" class="btn btn-danger">
	                              <i class="fa fa-stop" aria-hidden="true"></i></a>';
                if(Auth::user()->punyaAkses('Ikhtisar Kas','hapus')){
                	if ($data->ik_status == 'RELEASED'  or Auth::user()->kode_cabang == '000') {
                		if(cek_periode(carbon::parse($data->created_at)->format('m'),carbon::parse($data->created_at)->format('Y') ) != 0){
	                      $c = '<a title="Hapus" class="btn btn-danger" onclick="hapus(\''.$data->ik_id.'\')">
	                              <i class="fa fa-trash" aria-hidden="true"></i></a>';
	                    }
                	}
                    
                }
                return '<div class="btn-group">'. $a.$c .'</div>' ;
                       
            })->addColumn('print', function ($data) {

                if(Auth::user()->punyaAkses('Ikhtisar Kas','print')){
                   return $b = '<a title="Print" class="" href='.url('ikhtisar_kas/print').'/'.$data->ik_id.'>
                          <i class="fa fa-print" aria-hidden="true">&nbsp; Print</i>';
                }else{
                  return $b = '-';
                }
            })->addColumn('tanggal', function ($data) {

                return carbon::parse($data->created_at)->format('d/m/Y');
            })->addColumn('editing', function ($data) {

                if(Auth::user()->punyaAkses('Ikhtisar Kas','ubah')){
                	if ($data->ik_edit == 'UNALLOWED') {
	                	return '<input type="checkbox" class="editing" checked>';
	                }else{
	                	return '<input type="checkbox" class="editing" >';
	                }
                }else{
                	return '-';
                }

                
            })
            ->addIndexColumn()
            ->make(true);

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

	// public function tes(request $req)
	// {
	// 	return DB::transaction(function() use ($req) {  
	// 		$data = DB::table('biaya_penerus_kas')
	// 				  ->get();

	// 		for ($i=0; $i < count($data); $i++) { 
				
	// 		}
	// 	});

	// }

	public function cari_patty(request $request){
		if (isset($request->rangepicker)) {

			$tgl = explode('-',$request->rangepicker);
			$tgl[0] = str_replace('/', '-', $tgl[0]);
			$tgl[1] = str_replace('/', '-', $tgl[1]);
			$tgl[0] = str_replace(' ', '', $tgl[0]);
			$tgl[1] = str_replace(' ', '', $tgl[1]);
			$start  = Carbon::parse($tgl[0])->format('Y-m-d');
			$end    = Carbon::parse($tgl[1])->format('Y-m-d');
			$jenis = $request->jenis_ik_;
			if ($jenis == 'BONSEM') {
				$bkk = DB::table('bukti_kas_keluar')
						->select('bkk_nota as nota','bkk_tgl as tanggal','bkk_akun_kas as akun_kas','bkk_keterangan as keterangan','created_by as user','bkk_total as nominal')
						->where('bkk_comp',$request->cabang)
						->where('bkk_tgl','>=',$start)
						->where('bkk_tgl','<=',$end)
						->where('bkk_status','RELEASED')
						->take(5000)
						->orderBy('bkk_tgl','DESC')
						->get();
				$cari = $bkk;
				for ($i=0; $i < count($bkk); $i++) { 
					$bkkd = DB::table('patty_cash')
							  ->join('bukti_kas_keluar','bkk_nota','=','pc_no_trans')
							  ->where('bkk_comp',$request->cabang)
							  ->where('pc_akun','like','1002'.'%')
							  ->where('bkk_nota',$bkk[$i]->nota)
							  ->get();
					if ($bkkd == null) {
						unset($cari[$i]);
					}

				}
				$cari = array_values($cari);
				$akun = DB::table('d_akun')
						  ->get();
			}else{
				$bkk = DB::table('bukti_kas_keluar')
						->select('bkk_nota as nota','bkk_tgl as tanggal','bkk_akun_kas as akun_kas','bkk_keterangan as keterangan','created_by as user','bkk_total as nominal')
						->where('bkk_comp',$request->cabang)
						->where('bkk_tgl','>=',$start)
						->where('bkk_tgl','<=',$end)
						->where('bkk_status','RELEASED')
						->take(5000)
						->orderBy('bkk_tgl','DESC')
						->get();
				$temp_bkk = $bkk;
				for ($i=0; $i < count($temp_bkk); $i++) { 
					$cari_bkk = DB::table('bukti_kas_keluar')
								  ->where('bkk_nota',$temp_bkk[$i]->nota)
								  ->first();
					$bkkd = DB::table('bukti_kas_keluar_detail')
							  ->where('bkkd_bkk_id',$cari_bkk->bkk_id)
							  ->get();
					for ($a=0; $a < count($bkkd); $a++) { 
						if (substr($bkkd[$a]->bkkd_akun, 0,4) == '1002') {
							unset($bkk[$i]);
						}
					}
				}
				$bkk = array_values($bkk);
				$bpk = DB::table('biaya_penerus_kas')
						->select('bpk_nota as nota','bpk_tanggal as tanggal','bpk_kode_akun as akun_kas','bpk_keterangan as keterangan','created_by as user','bpk_tarif_penerus as nominal')
						->where('bpk_comp',$request->cabang)
						->where('bpk_tanggal','>=',$start)
						->where('bpk_tanggal','<=',$end)
						->where('bpk_status','Released')
						->take(5000)
						->orderBy('bpk_tanggal','DESC')
						->get();
				$cari = array_merge($bkk,$bpk);		
				$det_bkk = [];
				$det_bpk = [];

				for ($i=0; $i < count($bkk); $i++) { 
					try{
						$cari_bkk = DB::table('bukti_kas_keluar')
									  ->where('bkk_nota',$bkk[$i]->nota)
									  ->first();
						$bkkd = DB::table('bukti_kas_keluar_detail')
								  ->where('bkkd_bkk_id',$cari_bkk->bkk_id)
								  ->get();
						for ($a=0; $a < count($bkkd); $a++) { 
							$det_bkk[$i][$a] = $bkkd[$a]->bkkd_akun;
						}
						$det_bkk[$i] = array_unique($det_bkk[$i]);
						$det_bkk[$i] = array_values($det_bkk[$i]);
					}catch(Exception $error){
						return response()->json(['status'=>3,'message'=>'Terdapat Masalah Terhadap Nota '.$bkk[$i]->nota]);
					}
					
				}

				for ($i=0; $i < count($bpk); $i++) { 
					try{
						$cari_bpk = DB::table('biaya_penerus_kas')
									  ->where('bpk_nota',$bpk[$i]->nota)
									  ->first();
						$bpkd = DB::table('biaya_penerus_kas_detail')
								  ->where('bpkd_bpk_id',$cari_bpk->bpk_id)
								  ->get();
						for ($a=0; $a < count($bpkd); $a++) { 
							$temp = DB::table('d_akun')
								  ->where("id_akun",'like',substr($cari_bpk->bpk_acc_biaya,0,4).'%')
								  ->where('kode_cabang',$bpkd[$a]->bpkd_kode_cabang_awal)
								  ->first();
							if ($temp == null) {
								return Response()->json(['status' => 3, 'message' => 'Biaya '.substr($cari_bpk->bpk_acc_biaya,0,4).' Tidak Tersedia Untuk Cabang '.$bpkd[$a]->bpkd_kode_cabang_awal].' NOTA:('.$cari_bpk->bpk_nota.')');
							}
							$det_bpk[$i][$a] = $temp->id_akun;
						}

						$det_bpk[$i] = array_unique($det_bpk[$i]);
						$det_bpk[$i] = array_values($det_bpk[$i]);
					}catch(Exception $error){
						return response()->json(['status'=>3,'message'=>'Terdapat Masalah Terhadap Nota '.$bpk[$i]->nota]);
					}
				}


				$detail = array_merge($det_bkk,$det_bpk);
				$akun = DB::table('d_akun')
							  ->get();

			}

		return view('purchase.ikhtisar_kas.table_ikhtisar',compact('cari','akun','detail','jenis'));

		}else{
			$jenis = $request->jenis_ik_;
			if ($jenis == 'BONSEM') {
				$bkk = DB::table('bukti_kas_keluar')
						->select('bkk_nota as nota','bkk_tgl as tanggal','bkk_akun_kas as akun_kas','bkk_keterangan as keterangan','created_by as user','bkk_total as nominal')
						->where('bkk_comp',$request->cabang)
						->where('bkk_status','RELEASED')
						->take(5000)
						->orderBy('bkk_tgl','DESC')
						->get();
				$cari = $bkk;
				for ($i=0; $i < count($bkk); $i++) { 
					$bkkd = DB::table('patty_cash')
							  ->join('bukti_kas_keluar','bkk_nota','=','pc_no_trans')
							  ->where('bkk_comp',$request->cabang)
							  ->where('pc_akun','like','1002'.'%')
							  ->where('bkk_nota',$bkk[$i]->nota)
							  ->get();
					if ($bkkd == null) {
						unset($cari[$i]);
					}

				}
				$cari = array_values($cari);
				$akun = DB::table('d_akun')
						  ->get();
			}else{
				$bkk = DB::table('bukti_kas_keluar')
						->select('bkk_nota as nota','bkk_tgl as tanggal','bkk_akun_kas as akun_kas','bkk_keterangan as keterangan','created_by as user','bkk_total as nominal')
						->where('bkk_comp',$request->cabang)
						->where('bkk_status','RELEASED')
						->take(5000)
						->orderBy('bkk_tgl','DESC')
						->get();
				$temp_bkk = $bkk;
				for ($i=0; $i < count($temp_bkk); $i++) { 
					$cari_bkk = DB::table('bukti_kas_keluar')
								  ->where('bkk_nota',$temp_bkk[$i]->nota)
								  ->first();
					$bkkd = DB::table('bukti_kas_keluar_detail')
							  ->where('bkkd_bkk_id',$cari_bkk->bkk_id)
							  ->get();
					for ($a=0; $a < count($bkkd); $a++) { 
						if (substr($bkkd[$a]->bkkd_akun, 0,4) == '1002') {
							unset($bkk[$i]);
						}
					}
				}
				$bkk = array_values($bkk);
				$bpk = DB::table('biaya_penerus_kas')
						->select('bpk_nota as nota','bpk_tanggal as tanggal','bpk_kode_akun as akun_kas','bpk_keterangan as keterangan','created_by as user','bpk_tarif_penerus as nominal')
						->where('bpk_comp',$request->cabang)
						->where('bpk_status','Released')
						->take(5000)
						->orderBy('bpk_tanggal','DESC')
						->get();
				$cari = array_merge($bkk,$bpk);		
				$det_bkk = [];
				$det_bpk = [];

				for ($i=0; $i < count($bkk); $i++) { 

					$cari_bkk = DB::table('bukti_kas_keluar')
								  ->where('bkk_nota',$bkk[$i]->nota)
								  ->first();
					$bkkd = DB::table('bukti_kas_keluar_detail')
							  ->where('bkkd_bkk_id',$cari_bkk->bkk_id)
							  ->get();
					for ($a=0; $a < count($bkkd); $a++) { 
						$det_bkk[$i][$a] = $bkkd[$a]->bkkd_akun;
					}
					$det_bkk[$i] = array_unique($det_bkk[$i]);
					$det_bkk[$i] = array_values($det_bkk[$i]);
				}

				for ($i=0; $i < count($bpk); $i++) { 

					$cari_bpk = DB::table('biaya_penerus_kas')
								  ->where('bpk_nota',$bpk[$i]->nota)
								  ->first();
					$bpkd = DB::table('biaya_penerus_kas_detail')
							  ->where('bpkd_bpk_id',$cari_bpk->bpk_id)
							  ->get();
					for ($a=0; $a < count($bpkd); $a++) { 
						$temp = DB::table('d_akun')
							  ->where("id_akun",'like',substr($cari_bpk->bpk_acc_biaya,0,4).'%')
							  ->where('kode_cabang',$bpkd[$a]->bpkd_kode_cabang_awal)
							  ->first();
						if ($temp == null) {
							return Response()->json(['status' => 3, 'message' => 'Biaya '.substr($cari_bpk->bpk_acc_biaya,0,4).' Tidak Tersedia Untuk Cabang '.$bpkd[$a]->bpkd_kode_cabang_awal].' NOTA:('.$cari_bpk->bpk_nota.')');
						}
						$det_bpk[$i][$a] = $temp->id_akun;
					}

					$det_bpk[$i] = array_unique($det_bpk[$i]);
					$det_bpk[$i] = array_values($det_bpk[$i]);
				}


				$detail = array_merge($det_bkk,$det_bpk);
				$akun = DB::table('d_akun')
							  ->get();

			}
		return view('purchase.ikhtisar_kas.table_ikhtisar',compact('cari','akun'));

		}
	}
	public function simpan(request $request){

   		return DB::transaction(function() use ($request) {  
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
					
					// return $cari_id;

				
					// return $request->checker;
					$user = Auth::user()->m_name;

					if (Auth::user()->m_name == null) {
						return response()->json([
							'status'=>1,
							'message'=>'Nama User Anda Belum Ada, Silahkan Hubungi Pihak Terkait'
						]);
					}

				    $cari_nota = DB::table('bukti_kas_keluar')
								   ->where('bkk_nota',$request->no_trans)
								   ->first();
					if ($cari_nota != null) {
						if ($cari_nota->updated_by == $user) {
							return 'Data Sudah Ada';
						}else{
							$bulan = Carbon::parse(str_replace('/', '-', $req->tanggal))->format('m');
						    $tahun = Carbon::parse(str_replace('/', '-', $req->tanggal))->format('y');

						    $cari_nota = DB::select("SELECT  substring(max(ik_nota),12) as id from ikhtisar_kas
						                                    WHERE ik_comp = '$req->cabang'
						                                    AND to_char(ik_tanggal,'MM') = '$bulan'
						                                    AND to_char(ik_tanggal,'YY') = '$tahun'
						                                    ");

						    $index = (integer)$cari_nota[0]->id + 1;
						    $index = str_pad($index, 3, '0', STR_PAD_LEFT);

							$nota = 'IK' . $bulan . $tahun . '/' . $req->cabang . '/' .$index;

						}
					}elseif ($cari_nota == null) {
						$nota = $request->ik;
					}
					$debet = 0;
					for ($i=0; $i < count($request->checker); $i++) { 
						if ($request->checker[$i] == 'on') {
							$debet += $request->nominal[$i];
						}
		 			}

					$save_ikhtisar = DB::table('ikhtisar_kas')
									   ->insert([
									   		'ik_id'   		=> $id,
									   		'ik_nota' 		=> $nota,
									   		'ik_tgl_awal'  	=> $start,
									   		'ik_tgl_akhir' 	=> $end,
									   		'ik_keterangan' => $request->Keterangan,
									   		'ik_comp'		=> $request->cabang,
									   		'ik_total'		=> $debet,
									   		'ik_pelunasan'	=> $debet,
									   		'ik_jenis'  	=> $request->jenis_ik_,
									   		'ik_edit'		=> 'UNALLOWED',
									   		'ik_status'		=> 'RELEASED',
									   		'created_at'	=> Carbon::now(),
									   		'updated_at'	=> Carbon::now(),
									   		'ik_tanggal'	=> Carbon::parse(str_replace('/','-',$request->tanggal))->format('Y-m-d'),
									   		'ik_akunhutang' => $acchutang,
									   		'created_by'	=> Auth::user()->m_name,
									   		'updated_by'	=> Auth::user()->m_name
									]);


					for ($i=0; $i < count($request->checker); $i++) { 

						$ikd = DB::table('ikhtisar_kas_detail')
								->max('ikd_id')+1;

						if ($request->checker[$i] == 'on') {
							$bkk = DB::table('bukti_kas_keluar')
									->where('bkk_nota',$request->id[$i])
									->first();

							if ($bkk != null) {

								$save_ikhtisar = DB::table('ikhtisar_kas_detail')
								   ->insert([
								   		'ikd_id'   		=> $ikd,
								   		'ikd_ik_id'   	=> $id,
								   		'ikd_pc_id'   	=> 0,
								   		'ikd_ik_dt'   	=> $i+1,
								   		'ikd_ref' 		=> $bkk->bkk_nota,
								   		'ikd_akun' 		=> $bkk->bkk_akun_kas,
								   		'ikd_nominal'  	=> round($bkk->bkk_total),
								   		'ikd_keterangan'=> $bkk->bkk_keterangan,
								   		'ikd_acc_hutang'=> $bkk->bkk_akun_kas,
								   		'created_at'	=> Carbon::now(),
								   		'updated_at'	=> Carbon::now(),
								]);

								$updt_bk = DB::table('bukti_kas_keluar')
										 ->where('bkk_nota',$bkk->bkk_nota)
										 ->update([
										 	'bkk_status'    => 'APPROVED',
										   	'updated_at'	=> Carbon::now(),
										   	'updated_by'	=> Auth::user()->m_name,
										 ]);
								
							}else{
								$bpk = DB::table('biaya_penerus_kas')
									->where('bpk_nota',$request->id[$i])
									->first();

								$save_ikhtisar = DB::table('ikhtisar_kas_detail')
								   ->insert([
								   		'ikd_id'   		=> $ikd,
								   		'ikd_ik_id'   	=> $id,
								   		'ikd_pc_id'   	=> 0,
								   		'ikd_ik_dt'   	=> $i+1,
								   		'ikd_ref' 		=> $bpk->bpk_nota,
								   		'ikd_akun' 		=> $bpk->bpk_kode_akun,
								   		'ikd_nominal'  	=> $bpk->bpk_tarif_penerus,
								   		'ikd_keterangan'=> $bpk->bpk_keterangan,
								   		'ikd_acc_hutang'=> $bpk->bpk_kode_akun,
								   		'created_at'	=> Carbon::now(),
								   		'updated_at'	=> Carbon::now(),
								]);

								$updt_bk = DB::table('biaya_penerus_kas')
										 ->where('bpk_nota',$bpk->bpk_nota)
										 ->update([
										 	'bpk_status'    => 'Approved',
										   	'updated_at'	=> Carbon::now(),
										   	'updated_by'	=> Auth::user()->m_name,
										 ]);
							}
						}
					}

					return Response()->json(['status' => 1]);
									   
				}else{
					return Response()->json(['status' => 2]);
				}
			});

		}

		public function edit($id){
			if (Auth::user()->punyaAkses('Approve Ikhtisar','ubah')) {
				$data = DB::table('ikhtisar_kas')
						  ->where('ik_id',$id)
						  ->join('cabang','kode','=','ik_comp')
						  ->first();

				$start = Carbon::parse($data->ik_tgl_awal)->format('Y-m-d');
				$end = Carbon::parse($data->ik_tgl_akhir)->format('Y-m-d');

				// $data_dt = DB::table('ikhtisar_kas_detail')
				// 		   ->join('patty_cash','ikd_pc_id','=','pc_id')
				// 		   ->where('ikd_ik_id',$id)
				// 		   ->get();

				$bkk = DB::table('ikhtisar_kas_detail')
					->join('bukti_kas_keluar','ikd_ref','=','bkk_nota')
					->select('bkk_nota as nota','bkk_tgl as tanggal','bkk_akun_kas as akun_kas','bkk_keterangan as keterangan','created_by as user','bkk_total as nominal','ikd_ik_dt','ikd_ik_id')
					->where('ikd_ik_id',$id)
					->orderBy('bkk_tgl','DESC')
					->get();

				$bkk = array_map("unserialize", array_unique(array_map("serialize", $bkk)));

				$bpk = DB::table('ikhtisar_kas_detail')
						->join('biaya_penerus_kas','ikd_ref','=','bpk_nota')
						->select('bpk_nota as nota','bpk_tanggal as tanggal','bpk_kode_akun as akun_kas','bpk_keterangan as keterangan','created_by as user','bpk_tarif_penerus as nominal','ikd_ik_dt','ikd_ik_id')
						->where('ikd_ik_id',$id)
						->take(5000)
						->orderBy('bpk_tanggal','DESC')
						->get();

				$bpk = array_map("unserialize", array_unique(array_map("serialize", $bpk)));

				$data_dt = array_merge($bkk,$bpk);	
				for ($i=0; $i < count($data_dt); $i++) { 
					$data_dt[$i]->check = 'YA';
				}

				if ($data->ik_jenis == 'BONSEM') {
					$bkk = DB::table('bukti_kas_keluar')
							->select('bkk_nota as nota','bkk_tgl as tanggal','bkk_akun_kas as akun_kas','bkk_keterangan as keterangan','created_by as user','bkk_total as nominal')
							->where('bkk_comp',$data->ik_comp)
							->where('bkk_tgl','>=',$start)
							->where('bkk_tgl','<=',$end)
							->where('bkk_status','RELEASED')
							->take(5000)
							->orderBy('bkk_tgl','DESC')
							->get();
					$cari = $bkk;
					for ($i=0; $i < count($bkk); $i++) { 
						$bkkd = DB::table('patty_cash')
								  ->join('bukti_kas_keluar','bkk_nota','=','pc_no_trans')
								  ->where('bkk_comp',$data->ik_comp)
								  ->where('pc_akun','like','1002'.'%')
								  ->where('bkk_nota',$bkk[$i]->nota)
								  ->get();
						if ($bkkd == null) {
							unset($cari[$i]);
						}

					}
					$cari = array_values($cari);
					$cari = array_merge($data_dt,$bkk);	


					for ($i=0; $i < count($cari); $i++) { 

						$cari_bkk = DB::table('bukti_kas_keluar')
									  ->where('bkk_nota',$cari[$i]->nota)
									  ->first();
						if ($cari_bkk != null) {
							$bkkd = DB::table('bukti_kas_keluar_detail')
								  ->where('bkkd_bkk_id',$cari_bkk->bkk_id)
								  ->get();
							for ($a=0; $a < count($bkkd); $a++) { 
								$det_bkk[$i][$a] = $bkkd[$a]->bkkd_akun;
							}
							$det_bkk[$i] = array_unique($det_bkk[$i]);
							$det_bkk[$i] = array_values($det_bkk[$i]);
						}
					}
					
				$detail = $det_bkk;
					$akun = DB::table('d_akun')
							  ->get();
				}else{
					$bkk = DB::table('bukti_kas_keluar')
							->select('bkk_nota as nota','bkk_tgl as tanggal','bkk_akun_kas as akun_kas','bkk_keterangan as keterangan','created_by as user','bkk_total as nominal')
							->where('bkk_comp',$data->ik_comp)
							->where('bkk_tgl','>=',$start)
							->where('bkk_tgl','<=',$end)
							->where('bkk_status','RELEASED')
							->take(5000)
							->orderBy('bkk_tgl','DESC')
							->get();
					$temp_bkk = $bkk;
					for ($i=0; $i < count($temp_bkk); $i++) { 
						$cari_bkk = DB::table('bukti_kas_keluar')
									  ->where('bkk_nota',$temp_bkk[$i]->nota)
									  ->first();
						$bkkd = DB::table('bukti_kas_keluar_detail')
								  ->where('bkkd_bkk_id',$cari_bkk->bkk_id)
								  ->get();
						for ($a=0; $a < count($bkkd); $a++) { 
							if (substr($bkkd[$a]->bkkd_akun, 0,4) == '1002') {
								unset($bkk[$i]);
							}
						}
					}
					$bkk = array_values($bkk);
					$bpk = DB::table('biaya_penerus_kas')
							->select('bpk_nota as nota','bpk_tanggal as tanggal','bpk_kode_akun as akun_kas','bpk_keterangan as keterangan','created_by as user','bpk_tarif_penerus as nominal')
							->where('bpk_comp',$data->ik_comp)
							->where('bpk_tanggal','>=',$start)
							->where('bpk_tanggal','<=',$end)
							->where('bpk_status','Released')
							->take(5000)
							->orderBy('bpk_tanggal','DESC')
							->get();
					$cari = array_merge($data_dt,$bkk,$bpk);	
					$det_bkk = [];
					$det_bpk = [];

					for ($i=0; $i < count($cari); $i++) { 

						$cari_bkk = DB::table('bukti_kas_keluar')
									  ->where('bkk_nota',$cari[$i]->nota)
									  ->first();
						if ($cari_bkk != null) {
							$bkkd = DB::table('bukti_kas_keluar_detail')
								  ->where('bkkd_bkk_id',$cari_bkk->bkk_id)
								  ->get();
							for ($a=0; $a < count($bkkd); $a++) { 
								$det_bkk[$i][$a] = $bkkd[$a]->bkkd_akun;
							}
							$det_bkk[$i] = array_unique($det_bkk[$i]);
							$det_bkk[$i] = array_values($det_bkk[$i]);
						}else{
							$cari_bpk = DB::table('biaya_penerus_kas')
									  ->where('bpk_nota',$cari[$i]->nota)
									  ->first();
							$bpkd = DB::table('biaya_penerus_kas_detail')
									  ->where('bpkd_bpk_id',$cari_bpk->bpk_id)
									  ->get();
							for ($a=0; $a < count($bpkd); $a++) { 
								$temp = DB::table('d_akun')
									  ->where("id_akun",'like',substr($cari_bpk->bpk_acc_biaya,0,4).'%')
									  ->where('kode_cabang',$bpkd[$a]->bpkd_kode_cabang_awal)
									  ->first();
								if ($temp == null) {
									return Response()->json(['status' => 3, 'message' => 'Biaya '.substr($cari_bpk->bpk_acc_biaya,0,4).' Tidak Tersedia Untuk Cabang '.$bpkd[$a]->bpkd_kode_cabang_awal]);
								}
								$det_bpk[$i][$a] = $temp->id_akun;
							}

							$det_bpk[$i] = array_unique($det_bpk[$i]);
							$det_bpk[$i] = array_values($det_bpk[$i]);
						}
						
					}
					$detail = array_merge($det_bkk,$det_bpk);
					$akun = DB::table('d_akun')
								  ->get();

				}
				
				$akun = DB::table('d_akun')
					   		->get();
				return view('purchase.ikhtisar_kas.edit_ikhtisar',compact('akun','data','start','end','id','detail','cari'));
			}
			
		}

		public function update(request $request){
	   		return DB::transaction(function() use ($request) {  
	   			$val = [];
	   			$del = DB::table('ikhtisar_kas_detail')
						 ->where('ikd_ik_id',$request->id_ik)
						 ->delete();
	   			// dd($del);
				for ($i=0; $i < count($request->id); $i++) { 
					if ($request->checker[$i] == 'off') {

						$bkk = DB::table('bukti_kas_keluar')
									->where('bkk_nota',$request->id[$i])
									->first();

						if ($bkk != null) {

							$updt_bk = DB::table('bukti_kas_keluar')
									 ->where('bkk_nota',$bkk->bkk_nota)
									 ->update([
									 	'bkk_status'    => 'RELEASED',
									   	'updated_at'	=> Carbon::now(),
										'updated_by'	=> Auth::user()->m_name,
									 ]);
							
						}else{
							$bpk = DB::table('biaya_penerus_kas')
								->where('bpk_nota',$request->id[$i])
								->first();
							// if ($bpk->bpk_nota == 'BPK0818/009/011') {
							// 	dd($request->checker[$i]);
							// }
							$updt_bk = DB::table('biaya_penerus_kas')
									 ->where('bpk_nota',$bpk->bpk_nota)
									 ->update([
									 	'bpk_status'    => 'Released',
									   	'updated_at'	=> Carbon::now(),
										'updated_by'	=> Auth::user()->m_name,
									 ]);
						}
					}elseif ($request->checker[$i] == 'on'){

						$ikd = DB::table('ikhtisar_kas_detail')
								->max('ikd_id')+1;

						$bkk = DB::table('bukti_kas_keluar')
								->where('bkk_nota',$request->id[$i])
								->first();

						if ($bkk != null) {

							$save_ikhtisar = DB::table('ikhtisar_kas_detail')
							   ->insert([
							   		'ikd_id'   		=> $ikd,
							   		'ikd_ik_id'   	=> $request->id_ik,
							   		'ikd_pc_id'   	=> 0,
							   		'ikd_ik_dt'   	=> $i+1,
							   		'ikd_ref' 		=> $bkk->bkk_nota,
							   		'ikd_akun' 		=> $bkk->bkk_akun_kas,
							   		'ikd_nominal'  	=> round($bkk->bkk_total),
							   		'ikd_keterangan'=> $bkk->bkk_keterangan,
							   		'ikd_acc_hutang'=> $bkk->bkk_akun_kas,
							   		'created_at'	=> Carbon::now(),
							   		'updated_at'	=> Carbon::now(),
							]);

							$updt_bk = DB::table('bukti_kas_keluar')
									 ->where('bkk_nota',$bkk->bkk_nota)
									 ->update([
									 	'bkk_status'    => 'APPROVED',
									   	'updated_at'	=> Carbon::now(),
									   	'updated_by'	=> Auth::user()->m_name,
									 ]);
							
						}else{

							$bpk = DB::table('biaya_penerus_kas')
								->where('bpk_nota',$request->id[$i])
								->first();

							$save_ikhtisar = DB::table('ikhtisar_kas_detail')
							   ->insert([
							   		'ikd_id'   		=> $ikd,
							   		'ikd_ik_id'   	=> $request->id_ik,
							   		'ikd_pc_id'   	=> 0,
							   		'ikd_ik_dt'   	=> $i+1,
							   		'ikd_ref' 		=> $bpk->bpk_nota,
							   		'ikd_akun' 		=> $bpk->bpk_kode_akun,
							   		'ikd_nominal'  	=> $bpk->bpk_tarif_penerus,
							   		'ikd_keterangan'=> $bpk->bpk_keterangan,
							   		'ikd_acc_hutang'=> $bpk->bpk_kode_akun,
							   		'created_at'	=> Carbon::now(),
							   		'updated_at'	=> Carbon::now(),
							]);

							$updt_bk = DB::table('biaya_penerus_kas')
									 ->where('bpk_nota',$bpk->bpk_nota)
									 ->update([
									 	'bpk_status'    => 'Approved',
									   	'updated_at'	=> Carbon::now(),
									   	'updated_by'	=> Auth::user()->m_name,
									 ]);

							

						}
					}

					array_push($val, $request->checker[$i]);
				}
				// $del = DB::table('ikhtisar_kas_detail')
				// 		 ->where('ikd_ik_id',$request->id_ik)
				// 		 ->get();
	   			// dd($del);

				if ($request->checked == 'on') {
					$status = 'APPROVED';
				}else{
					$status = 'RELEASED';
				}
				
				$debet = 0;
				for ($i=0; $i < count($request->checker); $i++) { 
					if ($request->checker[$i] == 'on') {
						$debet += $request->nominal[$i];
					}
	 			}

				$updt_bk = DB::table('biaya_penerus_kas')
									 ->where('bpk_status','Approved')
									 ->get();
				$updt = DB::table('ikhtisar_kas')
							 ->where('ik_nota',$request->ik)
						   	 ->update([
						   	 	'ik_status' 	=> $status,
						   	 	'ik_keterangan' => $request->Keterangan,
						   	 	'ik_total' 		=> $debet,
						   	 	'ik_pelunasan'	=> $debet,
						   		'updated_by'	=> Auth::user()->m_name,
								'updated_at'	=> Carbon::now(),
						   	 ]);
				// return $val;		   	 
				if (in_array('on', $val)) {
					return Response()->json(['status'=>1]);
				}else{
					$updt = DB::table('ikhtisar_kas')
							 ->where('ik_nota',$request->ik)
						   	 ->delete();

					return Response()->json(['status'=>1]);
					

				}
			});
		}

		public function hapus($id){

			$cari = DB::table('ikhtisar_kas_detail')
					  ->where('ikd_ik_id',$id)
					  ->get();
			$head = DB::table('ikhtisar_kas')
						 ->where('ik_id',(int)$id)
						 ->first();
			if ($head->ik_pelunasan != $head->ik_total) {
				return response()->json(['status'=>1,'pesan'=>'Data Sudah Ditarik FPG']);
			}
			for ($i=0; $i < count($cari); $i++) { 

				$bkk = DB::table('bukti_kas_keluar')
								->where('bkk_nota',$cari[$i]->ikd_ref)
								->first();

				if ($bkk != null) {

					$updt_bk = DB::table('bukti_kas_keluar')
							 ->where('bkk_nota',$bkk->bkk_nota)
							 ->update([
							 	'bkk_status'    => 'RELEASED',
							   	'updated_at'	=> Carbon::now(),
								'updated_by'	=> Auth::user()->m_name,
							 ]);
					
				}else{
						$bpk = DB::table('biaya_penerus_kas')
								->where('bpk_nota',$cari[$i]->ikd_ref)
								->first();

					if ($bpk != null) {
						$updt_bk = DB::table('biaya_penerus_kas')
								 ->where('bpk_nota',$bpk->bpk_nota)
								 ->update([
								 	'bpk_status'    => 'Released',
								   	'updated_at'	=> Carbon::now(),
									'updated_by'	=> Auth::user()->m_name,
								 ]);
					}
					
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

			$nomor = DB::table('ikhtisar_kas_detail')
					->where('ikd_ik_id',$id)
					->get();

			$bpks = DB::table('ikhtisar_kas_detail')
					->join('biaya_penerus_kas','ikd_ref','=','bpk_nota')
					->where('ikd_ik_id',$id)
					->orderBy('ikd_id','ikd_ik_dt','ASC')
					->get();
			$bkks = DB::table('ikhtisar_kas_detail')
					->join('bukti_kas_keluar','ikd_ref','=','bkk_nota')
					->where('ikd_ik_id',$id)
					->orderBy('ikd_id','ikd_ik_dt','ASC')
					->get();

			$bkk = [];

			for ($i=0; $i < count($bkks); $i++) { 

				$bkk[$i] = DB::table('bukti_kas_keluar')
						 ->join('bukti_kas_keluar_detail','bkkd_bkk_id','=','bkk_id')
						 ->select('bkkd_keterangan as keterangan','bkkd_total as total','bkk_tgl as tanggal','bkkd_akun as akun','bkk_nota as nota')
						 ->where('bkk_nota',$bkks[$i]->bkk_nota)
						 ->get();


			}

			$asal = [];

			for ($i=0; $i < count($bpks); $i++) { 

				$bpk[$i] = DB::table('biaya_penerus_kas')
						 ->join('biaya_penerus_kas_detail','bpkd_bpk_id','=','bpk_id')
						 ->select('bpk_keterangan as keterangan','bpkd_tarif_penerus as total','bpk_tanggal as tanggal','bpkd_kode_cabang_awal as cabang','bpk_acc_biaya as akun','bpk_nota as nota')
						 ->where('bpk_nota',$bpks[$i]->bpk_nota)
						 ->get();


				$asal[$i] = DB::table('biaya_penerus_kas')
						 ->join('biaya_penerus_kas_detail','bpkd_bpk_id','=','bpk_id')
						 ->select('bpkd_kode_cabang_awal as cabang')
						 ->where('bpk_nota',$bpks[$i]->bpk_nota)
						 ->groupBy('bpkd_kode_cabang_awal')
						 ->get();
				for ($a=0; $a < count($asal[$i]); $a++) { 
					$temp = DB::table('d_akun')
						  ->where("id_akun",'like',substr($bpks[$i]->bpk_acc_biaya,0,4).'%')
						  ->where('kode_cabang',$asal[$i][$a]->cabang)
						  ->first();
					$asal[$i][$a]->total = 0;
					$asal[$i][$a]->akun = $temp->id_akun;
					$asal[$i][$a]->nota = $bpk[$i][0]->nota;
					$asal[$i][$a]->tanggal = $bpk[$i][0]->tanggal;
					$asal[$i][$a]->keterangan = $bpk[$i][0]->keterangan;

					for ($z=0; $z < count($bpk[$i]); $z++) { 
						if ($bpk[$i][$z]->cabang == $asal[$i][$a]->cabang) {
							$asal[$i][$a]->total += $bpk[$i][$z]->total;
						}
					}
					$bpk[$i][$a]->akun = $temp->id_akun;
				}
			}


			$data_dt = array_merge($bkk,$asal);	
			$terbilang = $this->terbilang($data->ik_total,$style=3);

			return view('purchase.ikhtisar_kas.outputIkhtisar',compact('terbilang','data','start','end','id','data_dt','nomor'));

		}

		public function nota(request $req)
		{
			$bulan = Carbon::parse(str_replace('/', '-', $req->tanggal))->format('m');
		    $tahun = Carbon::parse(str_replace('/', '-', $req->tanggal))->format('y');

		    $cari_nota = DB::select("SELECT  substring(max(ik_nota),12) as id from ikhtisar_kas
		                                    WHERE ik_comp = '$req->cabang'
		                                    AND to_char(ik_tanggal,'MM') = '$bulan'
		                                    AND to_char(ik_tanggal,'YY') = '$tahun'
		                                    ");

		    $index = (integer)$cari_nota[0]->id + 1;
		    $index = str_pad($index, 3, '0', STR_PAD_LEFT);

			
			$nota = 'IK' . $bulan . $tahun . '/' . $req->cabang . '/' .$index;

			return response()->json(['nota'=>$nota]);		
		}

		

}