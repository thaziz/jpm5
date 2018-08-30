<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Response;
use Auth;
use DB;
Use Carbon\Carbon;
use App\d_jurnal;
use App\d_jurnal_dt;
class pembayaran_vendor_controller extends Controller
{
    public function index($value='')
    {
    	$date = Carbon::now()->format('d/m/Y');

	
		$akun = DB::table('master_persentase')
				  ->get();

		$vendor = DB::table('vendor')
					->get();	

		$kota   = DB::table('kota')
				->get();

		$tanggal = carbon::now()->format('d/m/Y');

		return view('purchase/pembayaran_vendor/create_vendor',compact('date','kota','vendor','akun','tanggal'));
    }

    public function cari_do_vendor(request $req)
    {	
    	$valid = [];
    	for ($i=0; $i < count($req->array_simpan); $i++) { 
    		$valid[$i] = $req->array_simpan[$i];
    	}
    	$data = DB::table("delivery_order")
    			  ->leftjoin('biaya_penerus_dt','nomor','=','bpd_pod')
    			  ->where('kode_cabang',$req->cabang)
    			  ->where('id_tarif_vendor',$req->nama_vendor)
    			  ->where('bpd_pod',null)
    			  ->whereNotIn('nomor',$valid)
    			  ->get();



		return view('purchase/pembayaran_vendor/tabel_do_vendor',compact('data'));

    }

    public function cari_do_vendor_edit(request $req)
    {	
    	// dd($req->all());
    	for ($i=0; $i < count($req->array_simpan); $i++) { 
    		$valid[$i] = $req->array_simpan[$i];
    	}
    	$data = DB::table("delivery_order")
    			  ->leftjoin('biaya_penerus_dt','nomor','=','bpd_pod')
    			  ->where('kode_cabang',$req->cabang)
    			  ->where('id_tarif_vendor',$req->nama_vendor)
    			  ->where('bpd_pod',null)
    			  ->get();

    	$data1 = DB::table("delivery_order")
    			  ->leftjoin('biaya_penerus_dt','nomor','=','bpd_pod')
    			  ->where('bpd_bpid',$req->id)
    			  ->get();

    	$temp = array_merge($data,$data1);
    	$temp1 = array_merge($data,$data1);

    	for ($i=0; $i < count($temp1); $i++) { 
    		for ($a=0; $a < count($req->array_simpan); $a++) { 
    			if ($req->array_simpan[$a] == $temp1[$i]->nomor) {
    				unset($temp[$i]);
    			}
    		}
    	}
    	$data = $temp;

		return view('purchase/pembayaran_vendor/tabel_do_vendor',compact('data'));

    }

    public function append_vendor(request $req)
    {
    	// dd($req->all());

    	$data = DB::table('delivery_order')
    			  ->whereIn('nomor',$req->nomor_vendor)
    			  ->get();
    	return Response::json(['data'=>$data]);
    }

    public function save_vendor(request $req)
    {
   		return DB::transaction(function() use ($req) {  

   			// dd($req->all());

   			$akun_hutang = DB::table('d_akun')
							  ->where('id_akun','like','2102' . '%')
							  ->where('kode_cabang',$req->cabang)
							  ->first();
			$id = DB::table('faktur_pembelian')->max('fp_idfaktur')+1;

			$save_data = DB::table('faktur_pembelian')
						   ->insert([
						   	  'fp_idfaktur'   		=> $id,
							  'fp_nofaktur'   		=> $req->nofaktur,
							  'fp_tgl'        		=> carbon::parse(str_replace('/','-',$req->tanggal_vendor))->format('Y-m-d'),
							  'fp_keterangan' 		=> strtoupper($request->Keterangan_biaya),
							  'fp_noinvoice'  		=> $req->no_invoice,
							  'fp_jatuhtempo' 		=> carbon::parse(str_replace('/','-',$req->jatuh_tempo_vendor))->format('Y-m-d'),
							  'created_at'    		=> carbon::now(),
							  'updated_at'    		=> carbon::now(),
							  'fp_jumlah'     		=> filter_var($req->total,FILTER_SANITIZE_NUMBER_INT),
							  'fp_netto' 	  		=> filter_var($req->total,FILTER_SANITIZE_NUMBER_INT),
							  'fp_comp'  	  		=> $req->cabang,
							  'fp_pending_status'	=> 'APPROVED',
							  'fp_status'  			=> 'Released',  
							  'fp_jenisbayar' 		=> '6',
							  'fp_edit'  			=> 'ALLOWED',
							  'fp_sisapelunasan' 	=> filter_var($req->total,FILTER_SANITIZE_NUMBER_INT),
							  'fp_supplier'  		=> $req->nama_vendor,
							  'fp_acchutang'  		=> $akun_hutang->id_akun,
							  'created_by'  		=> Auth::user()->m_name,
							  'updated_by'  		=> Auth::user()->m_name,
						   ]);	
			
			$id_bp = DB::table('biaya_penerus')
							 ->max('bp_id')+1;

			$save_data1 = DB::table('biaya_penerus')
							->insert([
							  'bp_id' 			 => $id_bp,
							  'bp_faktur' 		 => $req->nofaktur,
							  'bp_tipe_vendor' 	 => 'VENDOR',
							  'bp_kode_vendor' 	 => $req->nama_vendor,
							  'bp_keterangan' 	 => $req->Keterangan_biaya,
							  'bp_invoice'		 => $req->no_invoice,
							  'bp_status'		 => 'APPROVED',
							  'updated_at' 		 => carbon::now(),
							  'created_at' 		 => carbon::now(),
							  'bp_total_penerus' => filter_var($req->total,FILTER_SANITIZE_NUMBER_INT),
							  'bp_akun_agen'	 => $akun_hutang->id_akun,
							]);

			for ($i=0; $i < count($req->v_nomor_do); $i++) { 

				$id_bpd = DB::table('biaya_penerus_dt')
					 ->max('bpd_id')+1;

				$cari_do = DB::table("delivery_order")
							 ->where("nomor",$req->v_nomor_do[$i])
							 ->first();

				$akun_biaya = DB::table('d_akun')
								  ->where('id_akun','like','5315' . '%')
								  ->where('kode_cabang',$cari_do->kode_cabang)
								  ->first();

				$save_dt = DB::table('biaya_penerus_dt')
							 ->insert([
								  'bpd_id'  		=> $id_bpd,
								  'bpd_bpid' 		=> $id_bp,
								  'bpd_bpdetail'	=> $i+1,
								  'bpd_pod' 		=> $req->v_nomor_do[$i],
								  'bpd_tgl'  		=> $cari_do->tanggal,
								  'bpd_akun_biaya'  => $akun_biaya->id_akun,
								  'bpd_debit' 	   	=> 'DEBET',
								  'bpd_memo'  	  	=> $req->v_keterangan[$i],
								  'bpd_akun_hutang' => $akun_biaya->id_akun,
								  'created_at'      => carbon::now(), 
								  'updated_at' 	   	=> carbon::now(),
								  'bpd_status' 	    => 'APPROVED',
								  'bpd_nominal'	    => filter_var($req->v_tarif_vendor[$i],FILTER_SANITIZE_NUMBER_INT),
								  'bpd_tarif_resi'  => $cari_do->total_vendo
							]);
			}

			$tt = DB::table('form_tt_d')
								->where('ttd_detail',$req->dt_tt)
								->where('ttd_id',$req->id_tt)
								->where('ttd_invoice',$req->invoice_tt)
								->update([
									'ttd_faktur' => $request->nofaktur,
								]);

			$cari_dt=DB::table('biaya_penerus_dt')		
						 ->join('delivery_order','bpd_pod','=','nomor')
						 ->where('bpd_bpid','=',$id_bp)
						 ->get();


			for ($i=0; $i < count($cari_dt); $i++) { 

				$cari_asal_2[$i] = $cari_dt[$i]->kode_cabang; 
			}
			if (isset($cari_asal_2)) {
			    $unik_asal = array_unique($cari_asal_2);
			    $unik_asal = array_values($unik_asal);

			    // return $unik_asal;
			    for ($i=0; $i < count($unik_asal); $i++) { 
					for ($a=0; $a < count($cari_dt); $a++) { 
						if($cari_dt[$a]->kode_cabang==$unik_asal[$i]){
							${$unik_asal[$i]}[$a] = $cari_dt[$a]->bpd_nominal;
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


			}

			$delete_jurnal = DB::table('d_jurnal')
					   ->where('jr_ref',$req->nofaktur)
					   ->delete();

			$id_jurnal=d_jurnal::max('jr_id')+1;

			$jenis_bayar = DB::table('jenisbayar')
							 ->where('idjenisbayar',6)
							 ->first();


			$save_jurnal = d_jurnal::create(['jr_id'=> $id_jurnal,
									'jr_year'   => carbon::parse(str_replace('/', '-', $req->tanggal_vendor))->format('Y'),
									'jr_date' 	=> carbon::parse(str_replace('/', '-', $req->tanggal_vendor))->format('Y-m-d'),
									'jr_detail' => $jenis_bayar->jenisbayar,
									'jr_ref'  	=> $req->nofaktur,
									'jr_note'  	=> 'BIAYA PENERUS HUTANG '.strtoupper($req->Keterangan_biaya),
									'jr_insert' => carbon::now(),
									'jr_update' => carbon::now(),
									]);
			


			$akun 	  = [];
			$akun_val = [];
			array_push($akun, $akun_hutang->id_akun);
			array_push($akun_val, filter_var($req->total,FILTER_SANITIZE_NUMBER_INT));

			for ($i=0; $i < count($jurnal); $i++) { 

				$id_akun = DB::table('d_akun')
								  ->where('id_akun','like','5315' . '%')
								  ->where('kode_cabang',$jurnal[$i]['asal'])
								  ->first();

				if ($id_akun == null) {
					$id_akun = DB::table('d_akun')
								  ->where('id_akun','like','5315%')
								  ->where('kode_cabang','000')
								  ->first();
				}
				array_push($akun, $id_akun->id_akun);
				array_push($akun_val, $jurnal[$i]['harga']);
			}

			$data_akun = [];
			for ($i=0; $i < count($akun); $i++) { 

				$cari_coa = DB::table('d_akun')
								  ->where('id_akun',$akun[$i])
								  ->first();

				if (substr($akun[$i],0, 1)==2) {
					
					if ($cari_coa->akun_dka == 'D') {
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'D';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($req->Keterangan_biaya);
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'K';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($req->Keterangan_biaya);
					}
				}else if (substr($akun[$i],0, 1)>2) {

					if ($cari_coa->akun_dka == 'D') {
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'K';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($req->Keterangan_biaya);
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'D';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($req->Keterangan_biaya);
					}
				}
			}
			$jurnal_dt = d_jurnal_dt::insert($data_akun);
			
			$lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();
			// dd($lihat);
			return response()->json(['status'=>1,'id'=>$id]);
    	});
    }

    public function vendor_um(request $req)
	{

		$fpg = DB::select("SELECT fpg_nofpg as nomor, fpg_agen as agen,fpgb_nominal as total_um,fpgdt_sisapelunasanumfp as sisa_um, d_uangmuka.*
						   from fpg inner join fpg_cekbank on fpgb_idfpg = idfpg
						   inner join fpg_dt on fpgdt_idfpg = idfpg
						   inner join d_uangmuka on um_nomorbukti = fpgdt_nofaktur
						   where fpgb_posting = 'DONE'
						   and fpg_agen = '$req->sup'");


		$bk  = DB::select("SELECT bkk_nota as nomor,bkk_supplier as agen,bkkd_total as total_um,bkkd_sisaum as sisa_um, d_uangmuka.*
						   from bukti_kas_keluar inner join bukti_kas_keluar_detail on bkkd_bkk_id = bkk_id
						   inner join d_uangmuka on um_nomorbukti = bkkd_ref
						   where bkk_supplier = '$req->sup'");

		$data = [];
		
		// return dd($req->all());
		$data = array_merge($fpg,$bk);
		$data1 = array_merge($fpg,$bk);

		for ($i=0; $i < count($data1); $i++) { 
			for ($a=0; $a < count($req->array_um1); $a++) { 
				if ($data1[$i]->nomor == $req->array_um1[$a] and $data1[$i]->um_nomorbukti == $req->array_um2[$a]) {
					unset($data[$i]);
				}
			}
			
		}
		$data = array_values($data);

		if (isset($req->id)) {
			$um = DB::table('uangmukapembelian_fp')
				->join('uangmukapembeliandt_fp','umfpdt_idumfp','=','umfp_id')
				->where('umfp_nofaktur',$req->id)
				->get();
			if ($um != null) {
				for ($i=0; $i < count($data); $i++) { 
					for ($a=0; $a < count($um); $a++) { 
						if ($data[$i]->nomor == $um[$a]->umfpdt_transaksibank and $data[$i]->um_nomorbukti == $um[$a]->umfpdt_notaum) {
							$data[$i]->sisa_um += $um[$a]->umfpdt_dibayar;
						}
					}
				}
			}
			
		}

		return view('purchase.pembayaran_vendor.vendor_um',compact('data'));
	}


	public function save_vendor_um(request $req)
	{
	   	return DB::transaction(function() use ($req) {  
			$id = DB::table('uangmukapembelian_fp')
					->max('umfp_id')+1;
			
			$pending = DB::table('faktur_pembelian')
						 ->where('fp_nofaktur',$req->nofaktur)
						 ->first();
			if ($pending == null) {
				return response()->json(['status'=>0]);
			}
			if ($pending->fp_pending_status == 'PENDING') {
				return response()->json(['status'=>2]);
			}else{
		
				$save = DB::table('uangmukapembelian_fp')
						  ->insert([
						  	'umfp_id'			=> $id,
							'umfp_totalbiaya'	=> filter_var($req->vendor_total_um, FILTER_SANITIZE_NUMBER_INT)/100,
							'umfp_tgl'    		=> carbon::parse(str_replace('/', '-', $req->tgl_biaya_head))->format('Y-m-d'),
							'umfp_idfp' 		=> $req->idfaktur,
							'updated_by'		=> Auth::user()->m_name,
							'created_by'		=> Auth::user()->m_name,
							'created_at' 		=> carbon::now(),
							'updated_at' 		=> carbon::now(),
							'umfp_keterangan'	=> strtoupper($req->Keterangan_biaya),
							'umfp_nofaktur'		=> $req->nofaktur,
						  ]);

				for ($i=0; $i < count($req->tb_transaksi_um); $i++) { 

					$dt = DB::table('uangmukapembeliandt_fp')
						->max('umfpdt_id')+1;
					
					$um = DB::table('d_uangmuka')
							->where('um_nomorbukti',$req->tb_um_um[$i])
							->first();

					$fpg = DB::table('fpg')
							 ->where('fpg_nofpg',$req->tb_transaksi_um[$i])
							 ->first();

					if($fpg != null){

						$cari_fpgdt = DB::table('fpg_dt')
									->where('fpgdt_nofaktur',$req->tb_um_um[$i])
									->where('fpgdt_idfpg',$fpg->idfpg)
									->first();
						$update_fpgdt = DB::table('fpg_dt')
										->where('fpgdt_nofaktur',$req->tb_um_um[$i])
										->where('fpgdt_idfpg',$fpg->idfpg)
										->update([
											'fpgdt_sisapelunasanumfp' => $cari_fpgdt->fpgdt_sisapelunasanumfp - $req->tb_bayar_um[$i],
										]);

						$flag = $fpg->fpg_flag;

						$jumlah_um = $cari_fpgdt->fpgdt_pelunasan;
					}else{

						$bkk = DB::table('bukti_kas_keluar')
							 ->where('bkk_nota',$req->tb_transaksi_um[$i])
							 ->first();

						$cari_bkkd = DB::table('bukti_kas_keluar_detail')
									->where('bkkd_bkk_id',$bkk->bkk_id)
									->where('bkkd_ref',$req->tb_um_um[$i])
									->first();

						$update_bkkd = DB::table('bukti_kas_keluar_detail')
										->where('bkkd_bkk_id',$bkk->bkk_id)
										->where('bkkd_ref',$req->tb_um_um[$i])
										->update([
											'bkkd_sisaum' => $cari_bkkd->bkkd_sisaum - $req->tb_bayar_um[$i],
										]);

						$flag = $bkk->bkk_flag;
						$jumlah_um = $cari_bkkd->bkkd_total;
					}

					$cari_bkkd = DB::table('bukti_kas_keluar_detail')
									->where('bkkd_bkk_id',$bkk->bkk_id)
									->where('bkkd_ref',$req->tb_um_um[$i])
									->first();
					// dd($cari_bkkd);

					$save_dt = DB::table('uangmukapembeliandt_fp')
								  ->insert([
								  	'umfpdt_id' 		   => $dt,
									'umfpdt_transaksibank' => $req->tb_transaksi_um[$i],
									'umfpdt_tgl' 		   => $um->um_tgl,
									'umfpdt_jumlahum'  	   => $jumlah_um,
									'umfpdt_dibayar'   	   => $req->tb_bayar_um[$i],
									'umfpdt_keterangan'    => $um->um_keterangan,
									'umfpdt_idfp' 		   => $req->idfaktur,
									'umfpdt_idumfp' 	   => $id,
									'umfpdt_notaum'  	   => $um->um_nomorbukti,
									'created_at' 		   => carbon::now(),
									'updated_at' 		   => carbon::now(),
									'umfpdt_acchutang'     => $req->acc_penjualan_penerus,
									'umfpdt_flag'  		   => $flag,
								  ]);
					
				}

				$cari_fp = DB::table('faktur_pembelian')
							 ->where('fp_nofaktur',$req->nofaktur)
							 ->first();

				$update_fp = DB::table('faktur_pembelian')
							 ->where('fp_nofaktur',$req->nofaktur)
							 ->update([
							 	'fp_uangmuka' => $cari_fp->fp_uangmuka + filter_var($req->vendor_total_um, FILTER_SANITIZE_NUMBER_INT)/100,
							 	'fp_sisapelunasan'=> $cari_fp->fp_sisapelunasan - filter_var($req->vendor_total_um, FILTER_SANITIZE_NUMBER_INT)/100
							 ]);

				// JURNAL

				for ($i=0; $i < count($req->tb_um_um); $i++) { 

					$cari_asal_2[$i] = $req->tb_um_um[$i]; 
				}
				if (isset($cari_asal_2)) {
				    $unik_asal = array_unique($cari_asal_2);
				    $unik_asal = array_values($unik_asal);

				    for ($i=0; $i < count($unik_asal); $i++) { 
						for ($a=0; $a < count($req->tb_um_um); $a++) { 
							if($req->tb_um_um[$a] == $unik_asal[$i]){
								${$unik_asal[$i]}[$a] = filter_var($req->tb_bayar_um[$a], FILTER_SANITIZE_NUMBER_INT);
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


				}
				$id_jurnal=d_jurnal::max('jr_id')+1;
				// dd($id_jurnal);
			

				$save_jurnal = d_jurnal::create(['jr_id'		=> $id_jurnal,
													'jr_year'   => carbon::parse(str_replace('/', '-', $req->tgl_biaya_head))->format('Y'),
													'jr_date' 	=> carbon::parse(str_replace('/', '-', $req->tgl_biaya_head))->format('Y-m-d'),
													'jr_detail' => 'UANG MUKA PEMBELIAN FP',
													'jr_ref'  	=> $req->nofaktur,
													'jr_note'  	=> 'UANG MUKA '.strtoupper($req->Keterangan_biaya),
													'jr_insert' => carbon::now(),
													'jr_update' => carbon::now(),
													]);

	 
				$akun 	  = [];
				$akun_val = [];
				for ($i=0; $i < count($jurnal); $i++) { 
					$db = DB::table('d_uangmuka')
							->where('um_nomorbukti',$jurnal[$i]['asal'])
							->first();
					array_push($akun, $db->um_akunhutang);
					array_push($akun_val, $jurnal[$i]['harga']);

				}
				for ($i=0; $i < count($req->vendor_total_um); $i++) { 
					$sum[$i] = filter_var($req->vendor_total_um, FILTER_SANITIZE_NUMBER_INT)/100;
				}
				$sum = array_sum($sum);

				array_push($akun, $cari_fp->fp_acchutang);
				array_push($akun_val, $sum);
				

				$data_akun = [];
				for ($i=0; $i < count($akun); $i++) { 

					$cari_coa = DB::table('d_akun')
									  ->where('id_akun',$akun[$i])
									  ->first();

					if (substr($akun[$i],0, 1)==1) {
						
						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
							$data_akun[$i]['jrdt_statusdk'] = 'K';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($cari_fp->fp_keterangan);
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
							$data_akun[$i]['jrdt_statusdk'] = 'D';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($cari_fp->fp_keterangan);
						}
					}else if (substr($akun[$i],0, 1)>1) {

						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
							$data_akun[$i]['jrdt_statusdk'] = 'K';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($cari_fp->fp_keterangan);
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
							$data_akun[$i]['jrdt_statusdk'] = 'D';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($cari_fp->fp_keterangan);
						}
					}
				}

				$jurnal_dt = d_jurnal_dt::insert($data_akun);

				$lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();
				// dd($lihat);

				return response()->json(['status'=>1]);
			}
		});
	}


	public function update_vendor_um(request $req)
	{
		// dd($req->all());
	   	return DB::transaction(function() use ($req) {  

			$um = DB::table('uangmukapembelian_fp')
					->join('uangmukapembeliandt_fp','umfpdt_idumfp','=','umfp_id')
					->where('umfp_nofaktur',$req->nofaktur)
					->get();

			for ($i=0; $i < count($um); $i++) { 	

				$cari_fp = DB::table('faktur_pembelian')
							 ->where('fp_nofaktur',$req->nofaktur)
							 ->first();

				$update_fp = DB::table('faktur_pembelian')
							   ->where('fp_nofaktur',$req->nofaktur)
							   ->update([
							   	'fp_uangmuka'=>$cari_fp->fp_uangmuka - $um[$i]->umfpdt_dibayar,
							   	'fp_sisapelunasan'=>$cari_fp->fp_sisapelunasan + $um[$i]->umfpdt_dibayar,
							   ]);
				if ($um[$i]->umfpdt_flag == 'bkk') {
					$cari_bkkd = DB::table('bukti_kas_keluar_detail')
							 ->join('bukti_kas_keluar','bkkd_bkk_id','=','bkk_id')
							 ->where('bkk_nota',$um[$i]->umfpdt_transaksibank)
							 ->where('bkkd_ref',$um[$i]->umfpdt_notaum)
							 ->first();

					$update_bkkd = DB::table('bukti_kas_keluar_detail')
							 ->where('bkkd_id',$cari_bkkd->bkkd_id)
							 ->update([
							 	'bkkd_sisaum'=>$cari_bkkd->bkkd_sisaum + $um[$i]->umfpdt_dibayar,
							 ]);

				}else{
					$cari_fgpdt = DB::table('fpg_dt')
							 ->join('fpg','idfpg','=','fpgdt_idfpg')
							 ->where('fpg_nofpg',$um[$i]->umfpdt_transaksibank)
							 ->where('fpgdt_nofaktur',$um[$i]->umfpdt_notaum)
							 ->first();

					$update_bkkd = DB::table('fpg_dt')
							 ->where('fpgdt_id',$cari_fgpdt->fpgdt_id)
							 ->update([
							 	'fpgdt_sisapelunasanumfp'=>$cari_fgpdt->fpgdt_sisapelunasanumfp + $um[$i]->umfpdt_dibayar,
							 ]);

					$cari_fgpdt = DB::table('fpg_dt')
							 ->join('fpg','idfpg','=','fpgdt_idfpg')
							 ->where('fpg_nofpg',$um[$i]->umfpdt_transaksibank)
							 ->where('fpgdt_nofaktur',$um[$i]->umfpdt_notaum)
							 ->first();

				}	
				$cari_fp = DB::table('faktur_pembelian')
							 ->where('fp_nofaktur',$req->nofaktur)
							 ->first();

			}
			$cari_fp = DB::table('faktur_pembelian')
							 ->where('fp_nofaktur',$req->nofaktur)
							 ->first();

			$hapus_um = DB::table('uangmukapembelian_fp')
						 	->where('umfp_nofaktur',$req->nofaktur)
						    ->delete();

			$id = DB::table('uangmukapembelian_fp')
					->max('umfp_id')+1;
			
			$pending = DB::table('faktur_pembelian')
						 ->where('fp_nofaktur',$req->nofaktur)
						 ->first();
			if ($pending == null) {
				return response()->json(['status'=>0]);
			}
			if ($pending->fp_pending_status == 'PENDING') {
				return response()->json(['status'=>2]);
			}else{
				$save = DB::table('uangmukapembelian_fp')
						  ->insert([
						  	'umfp_id'			=> $id,
							'umfp_totalbiaya'	=> filter_var($req->vendor_total_um, FILTER_SANITIZE_NUMBER_INT)/100,
							'umfp_tgl'    		=> carbon::parse(str_replace('/', '-', $req->tgl_biaya_head))->format('Y-m-d'),
							'umfp_idfp' 		=> $req->idfaktur,
							'updated_by'		=> Auth::user()->m_name,
							'created_by'		=> Auth::user()->m_name,
							'created_at' 		=> carbon::now(),
							'updated_at' 		=> carbon::now(),
							'umfp_keterangan'	=> $req->Keterangan_biaya,
							'umfp_nofaktur'		=> $req->nofaktur,
						  ]);

				for ($i=0; $i < count($req->tb_transaksi_um); $i++) { 

					$dt = DB::table('uangmukapembeliandt_fp')
						->max('umfpdt_id')+1;
					
					$um = DB::table('d_uangmuka')
							->where('um_nomorbukti',$req->tb_um_um[$i])
							->first();

					$fpg = DB::table('fpg')
							 ->where('fpg_nofpg',$req->tb_transaksi_um[$i])
							 ->first();

					if($fpg != null){

						$cari_fpgdt = DB::table('fpg_dt')
									->where('fpgdt_nofaktur',$req->tb_um_um[$i])
									->where('fpgdt_idfpg',$fpg->idfpg)
									->first();
						$update_fpgdt = DB::table('fpg_dt')
										->where('fpgdt_nofaktur',$req->tb_um_um[$i])
										->where('fpgdt_idfpg',$fpg->idfpg)
										->update([
											'fpgdt_sisapelunasanumfp' => $cari_fpgdt->fpgdt_sisapelunasanumfp - $req->tb_bayar_um[$i],
										]);

						$flag = $fpg->fpg_flag;

						$jumlah_um = $cari_fpgdt->fpgdt_pelunasan;
					}else{

						$bkk = DB::table('bukti_kas_keluar')
							 ->where('bkk_nota',$req->tb_transaksi_um[$i])
							 ->first();

						$cari_bkkd = DB::table('bukti_kas_keluar_detail')
									->where('bkkd_bkk_id',$bkk->bkk_id)
									->where('bkkd_ref',$req->tb_um_um[$i])
									->first();

						$update_bkkd = DB::table('bukti_kas_keluar_detail')
										->where('bkkd_bkk_id',$bkk->bkk_id)
										->where('bkkd_ref',$req->tb_um_um[$i])
										->update([
											'bkkd_sisaum' => $cari_bkkd->bkkd_sisaum - $req->tb_bayar_um[$i],
										]);

						$flag = $bkk->bkk_flag;
						$jumlah_um = $cari_bkkd->bkkd_total;
					}

					$save_dt = DB::table('uangmukapembeliandt_fp')
								  ->insert([
								  	'umfpdt_id' 		   => $dt,
									'umfpdt_transaksibank' => $req->tb_transaksi_um[$i],
									'umfpdt_tgl' 		   => $um->um_tgl,
									'umfpdt_jumlahum'  	   => $jumlah_um,
									'umfpdt_dibayar'   	   => $req->tb_bayar_um[$i],
									'umfpdt_keterangan'    => $um->um_keterangan,
									'umfpdt_idfp' 		   => $req->idfaktur,
									'umfpdt_idumfp' 	   => $id,
									'umfpdt_notaum'  	   => $um->um_nomorbukti,
									'created_at' 		   => carbon::now(),
									'updated_at' 		   => carbon::now(),
									'umfpdt_acchutang'     => $req->acc_penjualan_penerus,
									'umfpdt_flag'  		   => $flag,
								  ]);
					
				}
				$cari_fp = DB::table('faktur_pembelian')
							 ->where('fp_nofaktur',$req->nofaktur)
							 ->first();

				$update_fp = DB::table('faktur_pembelian')
							 ->where('fp_nofaktur',$req->nofaktur)
							 ->update([
							 	'fp_uangmuka' => $cari_fp->fp_uangmuka + filter_var($req->vendor_total_um, FILTER_SANITIZE_NUMBER_INT)/100,
							 	'fp_sisapelunasan'=> $cari_fp->fp_sisapelunasan - filter_var($req->vendor_total_um, FILTER_SANITIZE_NUMBER_INT)/100
							 ]);

				$cari_fp = DB::table('faktur_pembelian')
							 ->where('fp_nofaktur',$req->nofaktur)
							 ->first();

				// JURNAL
				for ($i=0; $i < count($req->tb_um_um); $i++) { 

					$cari_asal_2[$i] = $req->tb_um_um[$i]; 
				}

				if (isset($cari_asal_2)) {
				    $unik_asal = array_unique($cari_asal_2);
				    $unik_asal = array_values($unik_asal);

				    for ($i=0; $i < count($unik_asal); $i++) { 
						for ($a=0; $a < count($req->tb_um_um); $a++) { 
							if($req->tb_um_um[$a] == $unik_asal[$i]){
								${$unik_asal[$i]}[$a] = (float)$req->tb_bayar_um[$a];
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


				}


				// return $jurnal;


				$delete_jurnal = DB::table('d_jurnal')
								   ->where('jr_ref',$req->nofaktur)
								   ->where('jr_detail','UANG MUKA PEMBELIAN FP')
								   ->delete();

				$id_jurnal=d_jurnal::max('jr_id')+1;
				// dd($id_jurnal);
			

				$save_jurnal = d_jurnal::create(['jr_id'		=> $id_jurnal,
													'jr_year'   => carbon::parse(str_replace('/', '-', $req->tgl_biaya_head))->format('Y'),
													'jr_date' 	=> carbon::parse(str_replace('/', '-', $req->tgl_biaya_head))->format('Y-m-d'),
													'jr_detail' => 'UANG MUKA PEMBELIAN FP',
													'jr_ref'  	=> $req->nofaktur,
													'jr_note'  	=> 'UANG MUKA '.strtoupper($req->Keterangan_biaya),
													'jr_insert' => carbon::now(),
													'jr_update' => carbon::now(),
													]);

	 
				$akun 	  = [];
				$akun_val = [];
				for ($i=0; $i < count($jurnal); $i++) { 
					$db = DB::table('d_uangmuka')
							->where('um_nomorbukti',$jurnal[$i]['asal'])
							->first();
					array_push($akun, $db->um_akunhutang);
					array_push($akun_val, $jurnal[$i]['harga']);

				}
				for ($i=0; $i < count($req->vendor_total_um); $i++) { 
					$sum[$i] = filter_var($req->vendor_total_um, FILTER_SANITIZE_NUMBER_INT)/100;
				}

				$sum = array_sum($sum);

				array_push($akun, $cari_fp->fp_acchutang);
				array_push($akun_val, $sum);
				

				$data_akun = [];
				for ($i=0; $i < count($akun); $i++) { 

					$cari_coa = DB::table('d_akun')
									  ->where('id_akun',$akun[$i])
									  ->first();

					if (substr($akun[$i],0, 1)==1) {
						
						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
							$data_akun[$i]['jrdt_statusdk'] = 'K';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($cari_fp->fp_keterangan);
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= -filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
							$data_akun[$i]['jrdt_statusdk'] = 'D';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($cari_fp->fp_keterangan);
						}
					}else if (substr($akun[$i],0, 1)>1) {

						if ($cari_coa->akun_dka == 'D') {
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
							$data_akun[$i]['jrdt_statusdk'] = 'D';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($cari_fp->fp_keterangan);
						}else{
							$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
							$data_akun[$i]['jrdt_detailid']	= $i+1;
							$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
							$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
							$data_akun[$i]['jrdt_statusdk'] = 'K';
							$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($cari_fp->fp_keterangan);
						}
					}
				}

				$jurnal_dt = d_jurnal_dt::insert($data_akun);

				$lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();
				// dd($lihat);
				return response()->json(['status'=>1]);
			}
		});
	}

	 public function update_vendor(request $req)
    {
   		return DB::transaction(function() use ($req) {  

   			// dd($req->all());

   			$akun_hutang = DB::table('d_akun')
							  ->where('id_akun','like','2102' . '%')
							  ->where('kode_cabang',$req->cabang)
							  ->first();


			$save_data = DB::table('faktur_pembelian')
						   ->where('fp_nofaktur',$req->nofaktur)
						   ->update([
							  'fp_tgl'        		=> carbon::parse(str_replace('/','-',$req->tanggal_vendor))->format('Y-m-d'),
							  'fp_keterangan' 		=> $req->Keterangan_biaya,
							  'fp_noinvoice'  		=> $req->no_invoice,
							  'fp_jatuhtempo' 		=> carbon::parse(str_replace('/','-',$req->jatuh_tempo_vendor))->format('Y-m-d'),
							  'updated_at'    		=> carbon::now(),
							  'fp_jumlah'     		=> filter_var($req->total,FILTER_SANITIZE_NUMBER_INT),
							  'fp_netto' 	  		=> filter_var($req->total,FILTER_SANITIZE_NUMBER_INT),
							  'fp_comp'  	  		=> $req->cabang,
							  'fp_pending_status'	=> 'APPROVED',
							  'fp_status'  			=> 'Released',  
							  'fp_jenisbayar' 		=> '6',
							  'fp_edit'  			=> 'ALLOWED',
							  'fp_sisapelunasan' 	=> filter_var($req->total,FILTER_SANITIZE_NUMBER_INT),
							  'fp_supplier'  		=> $req->nama_vendor,
							  'fp_acchutang'  		=> $akun_hutang->id_akun,
							  'updated_by'  		=> Auth::user()->m_name,
						   ]);	
			
		

			$save_data1 = DB::table('biaya_penerus')
							->where('bp_faktur',$req->nofaktur)
							->update([
							  'bp_tipe_vendor' 	 => 'VENDOR',
							  'bp_kode_vendor' 	 => $req->nama_vendor,
							  'bp_keterangan' 	 => $req->Keterangan_biaya,
							  'bp_invoice'		 => $req->no_invoice,
							  'bp_status'		 => 'APPROVED',
							  'updated_at' 		 => carbon::now(),
							  'bp_total_penerus' => filter_var($req->total,FILTER_SANITIZE_NUMBER_INT),
							  'bp_akun_agen'	 => $akun_hutang->id_akun,
							]);
			$cari_bp = DB::table('biaya_penerus')
						 ->where('bp_faktur',$req->nofaktur)
						 ->first();

			$cari_fp = DB::table('faktur_pembelian')
							 ->where('fp_nofaktur',$req->nofaktur)
							 ->first();
			$delete = DB::table('biaya_penerus_dt')
						->where('bpd_bpid',$cari_bp->bp_id)
						->delete();
			for ($i=0; $i < count($req->v_nomor_do); $i++) { 

				$id_bpd = DB::table('biaya_penerus_dt')
					 		->max('bpd_id')+1;

				$cari_do = DB::table("delivery_order")
							 ->where("nomor",$req->v_nomor_do[$i])
							 ->first();

				$akun_biaya = DB::table('d_akun')
								  ->where('id_akun','like','5315' . '%')
								  ->where('kode_cabang',$cari_do->kode_cabang)
								  ->first();

				$save_dt = DB::table('biaya_penerus_dt')
							 ->insert([
								  'bpd_id'  		=> $id_bpd,
								  'bpd_bpid' 		=> $cari_bp->bp_id,
								  'bpd_bpdetail'	=> $i+1,
								  'bpd_pod' 		=> $req->v_nomor_do[$i],
								  'bpd_tgl'  		=> $cari_do->tanggal,
								  'bpd_akun_biaya'  => $akun_biaya->id_akun,
								  'bpd_debit' 	   	=> 'DEBET',
								  'bpd_memo'  	  	=> $req->v_keterangan[$i],
								  'bpd_akun_hutang' => $akun_biaya->id_akun,
								  'created_at'      => carbon::now(), 
								  'updated_at' 	   	=> carbon::now(),
								  'bpd_status' 	    => 'APPROVED',
								  'bpd_nominal'	    => filter_var($req->v_tarif_vendor[$i],FILTER_SANITIZE_NUMBER_INT),
								  'bpd_tarif_resi'  => $cari_do->total_vendo
							]);
			}


			$tt_upd = DB::table('form_tt_d')
					  ->where('ttd_faktur',$req->nofaktur)
					  ->update([
					  	'ttd_faktur'=>null
					  ]);

			$tt = DB::table('form_tt_d')
						->where('ttd_detail',$req->dt_tt)
						->where('ttd_id',$req->id_tt)
						->where('ttd_invoice',$req->invoice_tt)
						->update([
							'ttd_faktur' => $req->nofaktur,
						]);
			
			$cari_dt=DB::table('biaya_penerus_dt')		
						 ->join('delivery_order','bpd_pod','=','nomor')
						 ->where('bpd_bpid',$cari_bp->bp_id)
						 ->get();


			for ($i=0; $i < count($cari_dt); $i++) { 

				$cari_asal_2[$i] = $cari_dt[$i]->kode_cabang; 
			}
			if (isset($cari_asal_2)) {
			    $unik_asal = array_unique($cari_asal_2);
			    $unik_asal = array_values($unik_asal);

			    // return $unik_asal;
			    for ($i=0; $i < count($unik_asal); $i++) { 
					for ($a=0; $a < count($cari_dt); $a++) { 
						if($cari_dt[$a]->kode_cabang==$unik_asal[$i]){
							${$unik_asal[$i]}[$a] = $cari_dt[$a]->bpd_nominal;
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


			}

			$delete_jurnal = DB::table('d_jurnal')
					   ->where('jr_ref',$req->nofaktur)
					   ->delete();

			$id_jurnal=d_jurnal::max('jr_id')+1;

			$jenis_bayar = DB::table('jenisbayar')
							 ->where('idjenisbayar',6)
							 ->first();


			$save_jurnal = d_jurnal::create(['jr_id'=> $id_jurnal,
									'jr_year'   => carbon::parse(str_replace('/', '-', $req->tanggal_vendor))->format('Y'),
									'jr_date' 	=> carbon::parse(str_replace('/', '-', $req->tanggal_vendor))->format('Y-m-d'),
									'jr_detail' => $jenis_bayar->jenisbayar,
									'jr_ref'  	=> $req->nofaktur,
									'jr_note'  	=> 'BIAYA PENERUS HUTANG '.strtoupper($cari_fp->fp_keterangan),
									'jr_insert' => carbon::now(),
									'jr_update' => carbon::now(),
									]);
			


			$akun 	  = [];
			$akun_val = [];
			array_push($akun, $akun_hutang->id_akun);
			array_push($akun_val, filter_var($req->total,FILTER_SANITIZE_NUMBER_INT));

			for ($i=0; $i < count($jurnal); $i++) { 

				$id_akun = DB::table('d_akun')
								  ->where('id_akun','like','5315' . '%')
								  ->where('kode_cabang',$jurnal[$i]['asal'])
								  ->first();

				if ($id_akun == null) {
					$id_akun = DB::table('d_akun')
								  ->where('id_akun','like','5315%')
								  ->where('kode_cabang','000')
								  ->first();
				}
				array_push($akun, $id_akun->id_akun);
				array_push($akun_val, $jurnal[$i]['harga']);
			}

			$data_akun = [];
			for ($i=0; $i < count($akun); $i++) { 

				$cari_coa = DB::table('d_akun')
								  ->where('id_akun',$akun[$i])
								  ->first();

				if (substr($akun[$i],0, 1)==2) {
					
					if ($cari_coa->akun_dka == 'D') {
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'D';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($req->Keterangan_biaya);
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'K';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($req->Keterangan_biaya);
					}
				}else if (substr($akun[$i],0, 1)>2) {

					if ($cari_coa->akun_dka == 'D') {
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'D';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($req->Keterangan_biaya);
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'K';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($req->Keterangan_biaya);
					}
				}
			}
			$jurnal_dt = d_jurnal_dt::insert($data_akun);
			
			$lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();
			// dd($lihat);
			return response()->json(['status'=>1,'id'=>$cari_bp->bp_id]);
    	});
    }

}



