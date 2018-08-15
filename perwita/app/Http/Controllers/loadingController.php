<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use carbon\carbon;
use DB;
use App\biaya_penerus_kas;
use App\biaya_penerus_kas_detail;
use App\d_jurnal;
use App\d_jurnal_dt;
use Yajra\Datatables\Datatables;

class loadingController extends Controller
{	
	public function index(){
		// aaddcc
		$cabang = DB::table('cabang')
                  ->get();
		
		return view('purchase/kas/index_loading',compact('data','cabang'));
	}
	public function append_table(request $req)
	{
		$cab = $req->cabang;
		return view('purchase.kas.table_loading',compact('cab'));
	}

	public function datatable_bk(request $req)
	{
		$nama_cabang = DB::table("cabang")
						 ->where('kode',$req->cabang)
						 ->first();

		if ($nama_cabang != null) {
			$cabang = 'and bpk_comp = '."'$req->cabang'";
		}else{
			$cabang = '';
		}


		if (Auth::user()->punyaAkses('Biaya Penerus Kas','all')) {
			$sql = "SELECT * FROM biaya_penerus_kas  join cabang on kode = bpk_comp where bpk_nota != '0' and bpk_jenis_biaya = 'LOADING' $cabang";
			$data = DB::select($sql);
		}else{
			$cabang = Auth::user()->kode_cabang;
			$data = DB::table('biaya_penerus_kas')
				  ->join('cabang','kode','=','bpk_comp')
				  ->where('kode',$cabang)
				  ->where('bpk_jenis_biaya','LOADING')
				  ->orderBy('bpk_id','ASC')
				  ->get();
		}
        $data = collect($data);
        // return $data;
        return Datatables::of($data)
                        ->addColumn('aksi', function ($data) {
                            $a = '';
                            if($data->bpk_status == 'Released' or Auth::user()->punyaAkses('Biaya Penerus Kas','ubah')){
                                if(cek_periode(carbon::parse($data->bpk_tanggal)->format('m'),carbon::parse($data->bpk_tanggal)->format('Y') ) != 0){
							$a = '<a class="fa asw fa-pencil" align="center" href="'.route('editkas', ['id' => $data->bpk_id] ).'" title="edit"> Edit</a><br>';
                                }
                            }else{
                              $a = '';
                            }

                            $c = '';
                            if($data->bpk_status == 'Released' or Auth::user()->punyaAkses('Biaya Penerus Kas','hapus')){
                                if(cek_periode(carbon::parse($data->bpk_tanggal)->format('m'),carbon::parse($data->bpk_tanggal)->format('Y') ) != 0){
                                  $c = '<a class="fa fa-trash asw" align="center" onclick="hapus(\''.$data->bpk_id.'\')" title="hapus"> Hapus</a>';
                                }
                            }else{
                              $c = '';
                            }
                            return $a . $c  ;
                                   
                        })
                    
                        ->addColumn('cabang', function ($data) {
                          $kota = DB::table('cabang')
                                    ->get();

                          for ($i=0; $i < count($kota); $i++) { 
                            if ($data->bpk_comp == $kota[$i]->kode) {
                                return $kota[$i]->nama;
                            }
                          }
                        })
                        ->addColumn('tagihan', function ($data) {
                          return number_format(round($data->bpk_tarif_penerus,0),2,',','.'  ); 
                        })
                        ->addColumn('print', function ($data) {
                           return $a = ' <a class="fa asw fa-print" align="center"  title="edit" href="'.route('detailkas', ['id' => $data->bpk_id]).'"> detail</a><br>
										<a class="fa asw fa-print" align="center"  title="print" href="'.route('buktikas', ['id' => $data->bpk_id]).'"> Bukti Kas</a>';
                        })
                        ->addIndexColumn()
                        ->make(true);
	}

    public function create_loading()
    {
    	$year  = Carbon::now()->format('Y'); 
		$month = Carbon::now()->format('m');  	
		$now   = Carbon::now()->format('d/m/Y');
		$cabang = DB::table('cabang')
					->get();
		$angkutan = DB::table('tipe_angkutan')
					->get();
		$akun_persen     = DB::table('master_persentase')
					  ->where('cabang','GLOBAL')
					  ->get();

		$akun_paket  = DB::table('master_persentase')
					  ->where('cabang','GLOBAL')
					  ->where('jenis_biaya',1)
					  ->get();

		$akun_kargo  = DB::table('master_persentase')
					  ->where('cabang','GLOBAL')
					  ->where('jenis_biaya',5)
					  ->get();

		return view('purchase/kas/create_loading',compact('now','akun','akun_persen','cabang','angkutan','akun_kargo','akun_paket'));
    }

    public function cariresi(request $request)
    {	

		$biaya_bbm 	  = filter_var($request->data[7]['value'], FILTER_SANITIZE_NUMBER_INT);
		$biaya_dll 	  = filter_var($request->data[6]['value'], FILTER_SANITIZE_NUMBER_INT);
		$data     	  = [];
		$tujuan       = [];
		$total_tarif  = 0;
		$penerus      = [];
		$total_penerus= 0;
		$tipe_data    = $request->head[2]['value'];
		$cabang 	  = $request->head[4]['value'];
		$resi 		  = [];
		$now 		  = Carbon::now()->format('Y-m-d');

		for ($i=0; $i < count($request->resi_array); $i++) { 
			$cari_resi = DB::table('delivery_order')
						   ->leftjoin('biaya_penerus_kas_detail','bpkd_no_resi','=','nomor')
						   ->whereIn('nomor',$request->resi_array)
						   ->where('jenis_tarif',9)
						   ->orderBy('nomor','ASC')
						   ->get();

		}

		// return $cari_resi;
		for ($i=0; $i < count($cari_resi); $i++) {
			$resi[$i] = $cari_resi[$i]->nomor;
			if ($cari_resi[$i]->bpkd_no_resi != null) {
				unset($resi[$i]);
			}
		}
		// return $resi;
		$resi = array_unique($resi);
		$resi = array_values($resi);
		
		for ($i=0 ; $i < count($resi); $i++) { 

			$cari = DB::table('delivery_order')
				  ->join('kota','id','=','id_kota_asal')
				  ->where('nomor',$resi[$i])
				  ->get();

			$cari1 = DB::table('delivery_order')
				  ->select('nama','id')
				  ->join('kota','id','=','id_kota_asal')
				  ->where('nomor',$resi[$i])
				  ->get();

		   	$data[$i]   = $cari;
		   	$tujuan[$i] = $cari1;
		}

		//Menjumlah tarif resi
		$data = array_filter($data);
		$data = array_values($data);
		$tujuan = array_filter($tujuan);
		$tujuan = array_values($tujuan);

		if (count($data) != 0) {

		//menghitung tarif penerus
			for ($i=0; $i < count($data); $i++) { 
				$hasil = $data[$i][0]->total_net;
				$penerus[$i]=(float)$hasil;
			}
		
			$total_penerus =array_sum($penerus);
			$total_penerus =round($total_penerus,2);
			$total_tarif   =round($total_penerus,2);
			return view('purchase/kas/tabelBiayakas',compact('data','tujuan','total_tarif','kas_surabaya','penerus','total_penerus','tipe_data'));
	
		}else{
			return response()->json(['status' => 0]);
		}
    }

    public function save_loading(request $request)
    {
    	// dd($request->all());
		return DB::transaction(function() use ($request) {  

	    	$id = DB::table('biaya_penerus_kas')
					->max('bpk_id');
			if($id != null){
				$id+=1;
			}else{
				$id=1;
			}

		 	$cari_data = DB::table('biaya_penerus_kas')
					->where('bpk_nota',$request->no_trans)
					->first();


			$cari_akun = DB::table('d_akun')
					  ->where('id_akun','like','5299'.'%')
					  ->where('kode_cabang',$request->cabang)
					  ->first();
			if ($cari_akun == null) {
				return response()->json(['status'=>3,'data'=>'Akun Biaya Untuk Cabang Ini Tidak Tersedia']);
			}

	        if($cari_data == 0){
				biaya_penerus_kas::create([
				  	'bpk_id'      	  	 => $id,
				  	'bpk_nota'  	  	 => $request->no_trans,
				  	'bpk_jenis_biaya' 	 => $request->jenis_pembiayaan,
				  	'bpk_pembiayaan'  	 => $request->pembiayaan,
				  	'bpk_total_tarif' 	 => round($request->total_tarif,2),
				  	'bpk_tanggal'     	 => Carbon::parse(str_replace('/', '-', $request->tN))->format('Y-m-d'),
				  	'bpk_nopol'		  	 => strtoupper($request->nopol),
				  	'bpk_status'	  	 => 'Released',
				  	'bpk_status_pending' => 'APPROVED',	
				  	'bpk_kode_akun'		 => $request->nama_kas,
				  	'bpk_sopir'		 	 => strtoupper($request->nama_sopir),
				  	'bpk_keterangan'	 => strtoupper($request->note),
				  	'bpk_tipe_angkutan'  => $request->jenis_kendaraan,		
				  	'created_at'		 => Carbon::now(),
				  	'bpk_comp'	 		 => $request->cabang,
				  	'bpk_tarif_penerus'	 => $request->total_penerus,
				  	'bpk_edit'	 		 => 'UNALLOWED',
				  	'bpk_biaya_lain'	 => 0,
				  	'bpk_jarak'	 		 => 0,
				  	'bpk_harga_bbm'	     => 0,
					'bpk_jenis_bbm'      => 0,
					'bpk_acc_biaya'      => $cari_akun->id_akun,
				  	'created_by'		 => Auth::user()->m_name,
				  	'updated_by'		 => Auth::user()->m_name,
				]);

			}else{
				return response()->json(['status'=>0]);
			}



			for ($i=0; $i < count($request->no_resi); $i++) { 

				$id_bpkd = DB::table('biaya_penerus_kas_detail')
					->max('bpkd_id');

				if($id_bpkd != null){
					$id_bpkd+=1;
				}else{
					$id_bpkd=1;
				}
			
				
					
				biaya_penerus_kas_detail::create([
			  		'bpkd_id'				=> $id_bpkd,
					'bpkd_bpk_id'	  	 	=> $id,
					'bpkd_bpk_dt'			=> $i+1,
					'bpkd_no_resi'			=> $request->no_resi[$i],
					'bpkd_kode_cabang_awal'	=> $request->comp[$i],
					'bpkd_tanggal'  		=> $request->tanggal[$i],
					'bpkd_pengirim'	 		=> $request->pengirim[$i],
					'bpkd_penerima'			=> $request->penerima[$i],
					'bpkd_asal'				=> $request->asal[$i],
					'bpkd_tujuan'			=> $request->tujuan[$i],
					'bpkd_status_resi'		=> $request->status[$i],
					'bpkd_tarif'			=> $request->tarif[$i],
					'bpkd_tarif_penerus'	=> $request->penerus[$i],
					'created_at'			=> Carbon::now(),
					'bpk_comp'				=> $request->cabang,
					'bpkd_pembiayaan'		=> 0

				]);
				
			}
			

			$cari_id_pc = DB::table('patty_cash')
						 ->max('pc_id');

			if ($cari_id_pc == null) {
				$cari_id_pc = 1;
			}else{
				$cari_id_pc += 1;
			}


		
			// JURNAL
			$cari_id = DB::table('biaya_penerus_kas')
			  			   ->where('bpk_id','=',$id)
			  			   ->get();

			$cari=DB::table('biaya_penerus_kas')			
						 ->join('cabang','kode','=','bpk_comp')
						 ->where('bpk_id','=',$id)
						 ->get();
			$cari_dt=DB::table('biaya_penerus_kas_detail')		
						 ->where('bpkd_bpk_id','=',$id)
						 ->get();
		    $cari_asal=DB::table('biaya_penerus_kas_detail')
		    			 ->select('bpkd_kode_cabang_awal')			
						 ->where('bpkd_bpk_id','=',$id)
						 ->get();

			for ($i=0; $i < count($cari_asal); $i++) { 

				$cari_asal_2[$i] = $cari_asal[$i]->bpkd_kode_cabang_awal; 
			}

			if (isset($cari_asal_2)) {
			    $unik_asal = array_unique($cari_asal_2);
			    $unik_asal = array_values($unik_asal);

			    // return $unik_asal;
			    for ($i=0; $i < count($unik_asal); $i++) { 
					for ($a=0; $a < count($cari_dt); $a++) { 
						if($cari_dt[$a]->bpkd_kode_cabang_awal==$unik_asal[$i]){
							${$unik_asal[$i]}[$a] = $cari_dt[$a]->bpkd_tarif_penerus;
						}
					}
				}

				for ($i=0; $i < count($unik_asal); $i++) { 
					${'total'.$unik_asal[$i]} = array_sum(${$unik_asal[$i]});
				}
				// $harga_array = [];
				for ($i=0; $i < count($unik_asal); $i++) { 
					 $harga_array[$i] = ${'total'.$unik_asal[$i]};
				}
				for ($i=0; $i < count($harga_array); $i++) { 
					 $jurnal[$i]['harga'] = round($harga_array[$i],2);
					 $jurnal[$i]['asal'] = $unik_asal[$i];

				}

				// IKI MAS JURNAL.E HARGA MBEK ASALE
				
				// //JURNAL
				$id_jurnal=d_jurnal::max('jr_id')+1;
				$jenis_bayar = DB::table('jenisbayar')
								 ->where('idjenisbayar',10)
								 ->first();

				$jurnal_save = d_jurnal::create(['jr_id'		=> $id_jurnal,
											'jr_year'   => carbon::parse(str_replace('/', '-', $request->tN))->format('Y'),
											'jr_date' 	=> carbon::parse(str_replace('/', '-', $request->tN))->format('Y-m-d'),
											'jr_detail' => $jenis_bayar->jenisbayar,
											'jr_ref'  	=> $request->no_trans,
											'jr_note'  	=> 'BIAYA PENERUS KAS LOADING/UNLOADING '.strtoupper($request->note),
											'jr_insert' => carbon::now(),
											'jr_update' => carbon::now(),
											]);

				//IKI TOTAL KABEH HARGANE
				$total_harga=array_sum($harga_array);

				$cari_akun = substr($cari_akun->id_akun, 0,4);



				$akun 	  = [];
				$akun_val = [];
				$jumlah   = [];

				array_push($akun, $request->nama_kas);
				array_push($akun_val, $total_harga);
				for ($i=0; $i < count($jurnal); $i++) { 
					$acc = DB::table('d_akun')
							 ->where('id_akun','like',$cari_akun .'%')
							 ->where('kode_cabang',$jurnal[$i]['asal'])
							 ->first();

					if ($acc == null) {
						return response()->json(['status'=>3,'data'=>'Terdapat Resi Yang Tidak Memiliki Akun Biaya']);
					}

					$cari_id_pc = DB::table('patty_cash')
								 ->max('pc_id')+1;


					$save_patty = DB::table('patty_cash')
						   ->insert([
						   		'pc_id'			  => $cari_id_pc,
						   		'pc_tgl'		  => carbon::parse(str_replace('/', '-', $request->tN))->format('Y-m-d'),
						   		'pc_ref'	 	  => 10,
						   		'pc_akun' 		  => $acc->id_akun,
						   		'pc_akun_kas' 	  => $request->nama_kas,
						   		'pc_keterangan'	  => $request->note,
						   		'pc_asal_comp' 	  => $jurnal[$i]['asal'],
						   		'pc_comp' 		  => $request->cabang,
						   		'pc_edit'  	  	  => 'UNALLOWED',
						   		'pc_reim'  	  	  => 'UNRELEASED',
						   		'pc_debet'  	  => 0,
						   		'pc_no_trans'  	  => $request->no_trans,
						   		'pc_kredit'  	  => $jurnal[$i]['harga'],
						   		'pc_user'    	  => Auth::user()->m_name,
						   		'created_at'	  => Carbon::now(),
					        	'updated_at' 	  => Carbon::now()
					]);
					array_push($akun, $acc->id_akun);
					array_push($akun_val, $jurnal[$i]['harga']);
				}

				// dd($akun_val);


				for ($i=0; $i < count($akun); $i++) { 

					$cari_coa = DB::table('d_akun')
									  ->where('id_akun','like',$akun[$i].'%')
									  ->first();


					if (substr($akun[$i],0, 1)==1) {
						
						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= -$akun_val[$i];
							$data_akun[$i]['jrdt_statusdk'] = 'K';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun.' '. strtoupper($request->note);
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= -$akun_val[$i];
							$data_akun[$i]['jrdt_statusdk'] = 'D';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun.' '. strtoupper($request->note);
						}
					}else if (substr($akun[$i],0, 1)>1) {

						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
							$data_akun[$i]['jrdt_statusdk'] = 'D';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun.' '. strtoupper($request->note);
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
							$data_akun[$i]['jrdt_statusdk'] = 'K';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun.' '. strtoupper($request->note);
						}
					}
				}
				$jurnal_dt = d_jurnal_dt::insert($data_akun);

				$lihat_jurnal = DB::table('d_jurnal_dt')
							->where('jrdt_jurnal',$id_jurnal)
							->get();


			}

			// dd($lihat_jurnal);

			return response()->json(['status'=>1,'id'=>$id]);

		});
    }

    public function edit_loading(request $request)
    {
    	$year  = Carbon::now()->format('Y'); 
		$month = Carbon::now()->format('m');  	
		$now   = Carbon::now()->format('d-m-Y');
		$cabang = DB::table('cabang')
					->get();
		$angkutan = DB::table('tipe_angkutan')
					->get();
		$akun_persen     = DB::table('master_persentase')
					  ->where('cabang','GLOBAL')
					  ->get();

		$akun_paket  = DB::table('master_persentase')
					  ->where('cabang','GLOBAL')
					  ->where('jenis_biaya',1)
					  ->get();

		$akun_kargo  = DB::table('master_persentase')
					  ->where('cabang','GLOBAL')
					  ->where('jenis_biaya',5)
					  ->get();

		$data = DB::table('biaya_penerus_kas')
				  ->where('bpk_id',$request->id)
				  ->first();

		$data_dt = DB::table('biaya_penerus_kas_detail')
				  ->where('bpkd_bpk_id',$request->id)
				  ->get();

		$akun_kas = DB::table('d_akun')
    			  ->where('id_akun','like','1003'.'%')
    			  ->where('kode_cabang',$data->bpk_comp)
    			  ->get();
		$id = $request->id;
		for ($i=0; $i < count($data_dt); $i++) { 
			$resi[$i] = $data_dt[$i]->bpkd_no_resi;
		}
		$resi = implode(" ", $resi);

		return view('purchase/kas/edit_loading',compact('now','akun','akun_persen','cabang','angkutan','akun_kargo','akun_paket','data','data_dt','id','akun_kas','resi'));
    }

    public function cariresiedit(request $request)
    {	
	    
		$biaya_bbm 	  = filter_var($request->data[7]['value'], FILTER_SANITIZE_NUMBER_INT);
		$biaya_dll 	  = filter_var($request->data[6]['value'], FILTER_SANITIZE_NUMBER_INT);
		$data     	  = [];
		$tujuan       = [];
		$total_tarif  = 0;
		$penerus      = [];
		$total_penerus= 0;
		$tipe_data    = $request->head[2]['value'];
		$cabang 	  = $request->head[4]['value'];
		$resi 		  = [];
		$now 		  = Carbon::now()->format('Y-m-d');

		for ($i=0; $i < count($request->resi_array); $i++) { 

			$cari_resi = DB::table('delivery_order')
						   ->leftjoin('biaya_penerus_kas_detail','bpkd_no_resi','=','nomor')
						   ->whereIn('nomor',$request->resi_array)
						   ->where('jenis_tarif',9)
						   ->orderBy('nomor','ASC')
						   ->get();

			$cari_resi2 = DB::table('biaya_penerus_kas_detail')
						   	->where('bpkd_bpk_id',$request->id)
						   ->get();
		}

		// return $cari_resi;
		for ($i=0; $i < count($cari_resi); $i++) {
			$resi[$i] = $cari_resi[$i]->nomor;
			if ($cari_resi[$i]->bpkd_no_resi != null) {
				unset($resi[$i]);
			}
		}
		// return $resi;
		$resi = array_unique($resi);
		$resi = array_values($resi);
		

		for ($i=0; $i < count($cari_resi2); $i++) { 
			for ($a=0; $a < count($cari_resi); $a++) { 
				if ($cari_resi[$a]->nomor == $cari_resi2[$i]->bpkd_no_resi) {
					array_push($resi, $cari_resi[$a]->nomor);
				}
			}
		}


		for ($i=0 ; $i < count($resi); $i++) { 

			$cari = DB::table('delivery_order')
				  ->join('kota','id','=','id_kota_asal')
				  ->where('nomor',$resi[$i])
				  ->get();

			$cari1 = DB::table('delivery_order')
				  ->select('nama','id')
				  ->join('kota','id','=','id_kota_asal')
				  ->where('nomor',$resi[$i])
				  ->get();


		   	$data[$i]   = $cari;
		   	$tujuan[$i] = $cari1;
		}



		//Menjumlah tarif resi
		$data = array_filter($data);
		$data = array_values($data);
		$tujuan = array_filter($tujuan);
		$tujuan = array_values($tujuan);

		if (count($data) != 0) {

		//menghitung tarif penerus
			for ($i=0; $i < count($data); $i++) { 
				$hasil = $data[$i][0]->total_net;
				$penerus[$i]=(float)$hasil;
			}
		
			$total_penerus =array_sum($penerus);
			$total_penerus =round($total_penerus,2);
			$total_tarif   =round($total_penerus,2);
			return view('purchase/kas/tabelBiayakas',compact('data','tujuan','total_tarif','kas_surabaya','penerus','total_penerus','tipe_data'));
	
		}else{
			return response()->json(['status' => 0]);
		}
    }

    public function update_loading(request $request)
    {
		return DB::transaction(function() use ($request) {  

		 	$cari_data = DB::table('biaya_penerus_kas')
					->where('bpk_nota',$request->no_trans)
					->first();


			$cari_akun = DB::table('d_akun')
					  ->where('id_akun','like','5299'.'%')
					  ->where('kode_cabang',$request->cabang)
					  ->first();

			if ($cari_akun == null) {
				return response()->json(['status'=>3,'data'=>'Akun Biaya Untuk Cabang Ini Tidak Tersedia']);
			}

				biaya_penerus_kas::where('bpk_nota',$request->no_trans)->update([
				  	'bpk_nota'  	  	 => $request->no_trans,
				  	'bpk_jenis_biaya' 	 => $request->jenis_pembiayaan,
				  	'bpk_pembiayaan'  	 => $request->pembiayaan,
				  	'bpk_total_tarif' 	 => round($request->total_tarif,2),
				  	'bpk_tanggal'     	 => Carbon::parse($request->tN)->format('Y-m-d'),
				  	'bpk_nopol'		  	 => strtoupper($request->nopol),
				  	'bpk_status'	  	 => 'Released',
				  	'bpk_status_pending' => 'APPROVED',	
				  	'bpk_kode_akun'		 => $request->nama_kas,
				  	'bpk_sopir'		 	 => strtoupper($request->nama_sopir),
				  	'bpk_keterangan'	 => strtoupper($request->note),
				  	'bpk_tipe_angkutan'  => $request->jenis_kendaraan,		
				  	'updated_at'		 => Carbon::now(),
				  	'bpk_comp'	 		 => $request->cabang,
				  	'bpk_tarif_penerus'	 => $request->total_penerus,
				  	'bpk_edit'	 		 => 'UNALLOWED',
				  	'bpk_biaya_lain'	 => 0,
				  	'bpk_jarak'	 		 => 0,
				  	'bpk_harga_bbm'	     => 0,
					'bpk_jenis_bbm'      => 0,
					'bpk_acc_biaya'      => $cari_akun->id_akun,
				  	'updated_by'		 => Auth::user()->m_name,
				]);

		

			biaya_penerus_kas_detail::where('bpkd_bpk_id',$request->id)->delete();

			for ($i=0; $i < count($request->no_resi); $i++) { 

				$id_bpkd = DB::table('biaya_penerus_kas_detail')
					->max('bpkd_id');

				if($id_bpkd != null){
					$id_bpkd+=1;
				}else{
					$id_bpkd=1;
				}
			
				
					
				biaya_penerus_kas_detail::create([
			  		'bpkd_id'				=> $id_bpkd,
					'bpkd_bpk_id'	  	 	=> $request->id,
					'bpkd_bpk_dt'			=> $i+1,
					'bpkd_no_resi'			=> $request->no_resi[$i],
					'bpkd_kode_cabang_awal'	=> $request->comp[$i],
					'bpkd_tanggal'  		=> $request->tanggal[$i],
					'bpkd_pengirim'	 		=> $request->pengirim[$i],
					'bpkd_penerima'			=> $request->penerima[$i],
					'bpkd_asal'				=> $request->asal[$i],
					'bpkd_tujuan'			=> $request->tujuan[$i],
					'bpkd_status_resi'		=> $request->status[$i],
					'bpkd_tarif'			=> $request->tarif[$i],
					'bpkd_tarif_penerus'	=> $request->penerus[$i],
					'created_at'			=> Carbon::now(),
					'bpk_comp'				=> $request->cabang,
					'bpkd_pembiayaan'		=> 0

				]);
				
			}
			

			// JURNAL
			$cari_id = DB::table('biaya_penerus_kas')
			  			   ->where('bpk_id','=',$request->id)
			  			   ->get();

			$cari=DB::table('biaya_penerus_kas')			
						 ->join('cabang','kode','=','bpk_comp')
						 ->where('bpk_id','=',$request->id)
						 ->get();
			$cari_dt=DB::table('biaya_penerus_kas_detail')		
						 ->where('bpkd_bpk_id','=',$request->id)
						 ->get();
		    $cari_asal=DB::table('biaya_penerus_kas_detail')
		    			 ->select('bpkd_kode_cabang_awal')			
						 ->where('bpkd_bpk_id','=',$request->id)
						 ->get();

			for ($i=0; $i < count($cari_asal); $i++) { 

				$cari_asal_2[$i] = $cari_asal[$i]->bpkd_kode_cabang_awal; 
			}




			if (isset($cari_asal_2)) {
			    $unik_asal = array_unique($cari_asal_2);
			    $unik_asal = array_values($unik_asal);

			    // return $unik_asal;
			    for ($i=0; $i < count($unik_asal); $i++) { 
					for ($a=0; $a < count($cari_dt); $a++) { 
						if($cari_dt[$a]->bpkd_kode_cabang_awal==$unik_asal[$i]){
							${$unik_asal[$i]}[$a] = $cari_dt[$a]->bpkd_tarif_penerus;
						}
					}
				}

				for ($i=0; $i < count($unik_asal); $i++) { 
					${'total'.$unik_asal[$i]} = array_sum(${$unik_asal[$i]});
				}
				// $harga_array = [];
				for ($i=0; $i < count($unik_asal); $i++) { 
					 $harga_array[$i] = ${'total'.$unik_asal[$i]};
				}
				for ($i=0; $i < count($harga_array); $i++) { 
					 $jurnal[$i]['harga'] = round($harga_array[$i],2);
					 $jurnal[$i]['asal'] = $unik_asal[$i];

				}

				// IKI MAS JURNAL.E HARGA MBEK ASALE
				$delete_jurnal = DB::table('d_jurnal')
								   ->where('jr_ref',$request->no_trans)
								   ->delete();
				// //JURNAL
				$id_jurnal=d_jurnal::max('jr_id')+1;
				$jenis_bayar = DB::table('jenisbayar')
								 ->where('idjenisbayar',10)
								 ->first();

				$jurnal_save = d_jurnal::create(['jr_id'=> $id_jurnal,
											'jr_year'   => carbon::parse(str_replace('/', '-', $request->tN))->format('Y'),
											'jr_date' 	=> carbon::parse(str_replace('/', '-', $request->tN))->format('Y-m-d'),
											'jr_detail' => $jenis_bayar->jenisbayar,
											'jr_ref'  	=> $request->no_trans,
											'jr_note'  	=> 'BIAYA PENERUS KAS '.strtoupper($request->note),
											'jr_insert' => carbon::now(),
											'jr_update' => carbon::now(),
											]);

				//IKI TOTAL KABEH HARGANE
				$total_harga=array_sum($harga_array);

				$cari_akun = substr($cari_akun->id_akun, 0,4);



				$akun 	  = [];
				$akun_val = [];
				$jumlah   = [];

				$delete = DB::table('patty_cash')
						   ->where('pc_no_trans',$request->no_trans)
						   ->delete();

				array_push($akun, $request->nama_kas);
				array_push($akun_val, $total_harga);
				for ($i=0; $i < count($jurnal); $i++) { 
					$acc = DB::table('d_akun')
							 ->where('id_akun','like',$cari_akun .'%')
							 ->where('kode_cabang',$jurnal[$i]['asal'])
							 ->first();

					if ($acc == null) {
						return response()->json(['status'=>3,'data'=>'Terdapat Resi Yang Tidak Memiliki Akun Biaya']);
					}


					$cari_id_pc = DB::table('patty_cash')
								 ->max('pc_id')+1;


					$save_patty = DB::table('patty_cash')
						   ->insert([
						   		'pc_id'			  => $cari_id_pc,
						   		'pc_tgl'		  => carbon::parse(str_replace('/', '-', $request->tN))->format('Y-m-d'),
						   		'pc_ref'	 	  => 10,
						   		'pc_akun' 		  => $acc->id_akun,
						   		'pc_akun_kas' 	  => $request->nama_kas,
						   		'pc_keterangan'	  => $request->note,
						   		'pc_asal_comp' 	  => $jurnal[$i]['asal'],
						   		'pc_comp' 		  => $request->cabang,
						   		'pc_edit'  	  	  => 'UNALLOWED',
						   		'pc_reim'  	  	  => 'UNRELEASED',
						   		'pc_debet'  	  => 0,
						   		'pc_user'    	  => Auth::user()->m_name,
						   		'pc_no_trans'  	  => $request->no_trans,
						   		'pc_kredit'  	  => $jurnal[$i]['harga'],
						   		'created_at'	  => Carbon::now(),
					        	'updated_at' 	  => Carbon::now()
					]);

					array_push($akun, $acc->id_akun);
					array_push($akun_val, $jurnal[$i]['harga']);
				}

				// dd($akun_val);


				for ($i=0; $i < count($akun); $i++) { 

					$cari_coa = DB::table('d_akun')
									  ->where('id_akun','like',$akun[$i].'%')
									  ->first();


					if (substr($akun[$i],0, 1)==1) {
						
						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= -$akun_val[$i];
							$data_akun[$i]['jrdt_statusdk'] = 'K';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun.' '. strtoupper($request->note);
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= -$akun_val[$i];
							$data_akun[$i]['jrdt_statusdk'] = 'D';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun.' '. strtoupper($request->note);
						}
					}else if (substr($akun[$i],0, 1)>1) {

						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= -$akun_val[$i];
							$data_akun[$i]['jrdt_statusdk'] = 'D';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun.' '. strtoupper($request->note);
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $cari_coa->id_akun;
							$data_akun[$i]['jrdt_value'] 	= -$akun_val[$i];
							$data_akun[$i]['jrdt_statusdk'] = 'K';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun.' '. strtoupper($request->note);
						}
					}
				}




				$jurnal_dt = d_jurnal_dt::insert($data_akun);

				$lihat_jurnal = DB::table('d_jurnal_dt')
							->where('jrdt_jurnal',$id_jurnal)
							->get();


			}

			return response()->json(['status'=>1,'id'=>$request->id]);

		});
    }

}
