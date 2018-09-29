<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;
use PDF;
use App\masterItemPurchase;
use App\masterSupplierPurchase;
use App\master_cabang;
use App\masterJenisItemPurchase;
use App\spp_purchase;
use App\sppdt_purchase;
use App\spptb_purchase;
use App\master_department;
use App\co_purchase;
use App\co_purchasedt;
use App\co_purchasetb;
use App\masterGudangPurchase;
use App\purchase_orderr;
use App\purchase_orderdt;
use App\stock_mutation;
use App\stock_gudang;
use App\penerimaan_barang;
use App\penerimaan_barangdt;
use App\fakturpembelian;
use App\fakturpembeliandt;
use App\biaya_penerus;
use App\biaya_penerus_dt;
use App\master_note;
use App\tb_master_pajak;
use App\d_jurnal;
use App\d_jurnal_dt;
use DB;
use Response;
Use Carbon\Carbon;
use Session;
use Mail;
use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;
use Auth;

 	public function getdatapenerusedit(){

		$pajak = DB::table("pajak")
						->get();
		$data = DB::table('akun')
					  ->get();

		$agen = DB::table('agen')
						  ->where('kategori','AGEN')
						  ->orWhere('kategori','AGEN DAN OUTLET')
						  ->get();
		$vendor = DB::table('vendor')
						  ->get();
		return view('purchase/fatkur_pembelian/editTableBiaya',compact('data','date','agen','vendor','akun_biaya','now'));
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
		public function cari_do(request $request){

		
	        $results = array();
	        $queries = DB::table('delivery_order')
	        	->leftjoin('biaya_penerus_dt','nomor','=','bpd_pod')
	            ->where('nomor', 'like', '%'.strtoupper($request->term).'%')
	            ->where('bpd_pod',null)
	            ->take(10)->get();

	        $validate = DB::table('biaya_penerus_dt')
				            ->where('bpd_pod', 'like', '%'.strtoupper($request->term).'%')
				            ->take(10)->get();

	        if ($queries == null){
	        	if ($validate != null) {
	            	$results[] = [ 'id' => null, 'label' => 'Data Telah Ada Di Database'];
	        	}else{
	            	$results[] = [ 'id' => null, 'label' => 'Tidak ditemukan data terkait'];
	        	}
	        } else {

	            foreach ($queries as $query)
	            {
	                $results[] = [ 'id' => $query->nomor,
					                'label' => $query->nomor,
					                'validator'=>$query->bpd_pod,
					                'harga'=>$query->total_net
					              ];
	            }
	        }

	        return Response::json($results);


		}


		public function carimaster(request $request){

			if ($request->vendor == 'AGEN') {


				$persen = DB::table('master_persentase')
	        			->where('kode_akun','LIKE','%'.'5319'.'%')
	        			->where('cabang',$request->cabang)
	        			->get();

	        	if ($persen == null) {

	        		$persen = DB::table('master_persentase')
	        			->where('kode_akun',5314)
	        			->where('cabang','GLOBAL')
	        			->get();
	        	}

			}else{


				$persen = DB::table('master_persentase')
	        			->where('kode_akun','LIKE','%'.'5315'.'%')
	        			->where('cabang',$request->cabang)
	        			->get();

	        	if ($persen == null) {
	        		$persen = DB::table('master_persentase')
	        			->where('kode_akun',5315)
	        			->where('cabang','GLOBAL')
	        			->get();
	        	}
			}
	        

	        return Response::json([
	        				'persen'=>$persen
	        				]);


		}

		public function autocomplete_biaya_penerus($i){

	        $data = DB::table('delivery_order')
	        			->where('nomor','=',strtoupper($i))
	        			->first();

	       if($data != null){
	       	
	       	return Response::json([
	       					'status'=>'1',
	        				'data'=>$data
	        				]);
	       }else{
	       	return Response::json([
	       					'status'=>'0',
	        				'data'=>'data tidak ada'
	        				]);
	       }
		}

		public function nota_tt(request $req)
		{	
			if (!isset($req->nofaktur)) {
				$data = DB::table('form_tt')
						  ->join('form_tt_d','ttd_id','=','tt_idform')
						  ->where('tt_supplier',$req->agen_vendor)
						  ->where('tt_idcabang',$req->cabang)
						  ->where('ttd_faktur',null)
						  ->get();
			}else{
				$data = DB::table('form_tt')
						  ->join('form_tt_d','ttd_id','=','tt_idform')
						  ->where('tt_supplier',$req->agen_vendor)
						  ->where('tt_idcabang',$req->cabang)
						  ->where('ttd_faktur',null)
						  ->orWhere('ttd_faktur',$req->nofaktur)
						  ->get();
			}
			

		    return view('purchase.pembayaran_vendor.table_tt',compact('data'));
		}

		public function save_agen(request $request){
			// dd($request->all());
   			return DB::transaction(function() use ($request) {  

				$cari_fp = DB::table('faktur_pembelian')
							 ->where('fp_nofaktur',$request->nofaktur)
							 ->first();
				$tgl         = str_replace('/', '-', $request->tgl_biaya_head);		 
				$tgl 		 = Carbon::parse($tgl)->format('Y-m-d');
				$jt          = str_replace('/', '-', $request->jatuh_tempo);		 
				$jt 		 = Carbon::parse($jt)->format('Y-m-d');

				if ($request->vendor == "AGEN") {
					$cari_persen = DB::table('agen')
					 					 ->where('kode',$request->nama_kontak2)
					 					 ->first();
					$komisi = $cari_persen->komisi_agen;
					$biaya_paket = '5314';
				}else{
				 	$cari_persen = DB::table('vendor')
				 					 ->where('kode',$request->nama_kontak2)
				 					 ->first();
					$komisi = $cari_persen->komisi_vendor;
					$biaya_paket = '5315';
				}

				$status=[];

				for ($i=0; $i < count($request->do_harga); $i++) 
				{
				    $persentase = $komisi/100; 
				    $harga_fix  = round($request->do_harga[$i])*$persentase;

					if($request->bayar_biaya[$i] <= $harga_fix){
						$status[$i] = 'APPROVED';
					}else{
						$status[$i] = 'PENDING';
					}
				}

				if(in_array('PENDING', $status)){
				 	$pending_status='PENDING';
				}else{
				 	$pending_status='APPROVED';
				}

				if ($cari_fp == null) {

					$id = DB::table('faktur_pembelian')
							 ->max('fp_idfaktur');

					if ($id == null) {
						$id = 1;
					}else{
						$id+=1;
					}

					$akun_hutang = DB::table('d_akun')
										  ->where('id_akun','like',substr($cari_persen->acc_hutang,0,4).'%')
										  ->where('kode_cabang',$request->cabang)
										  ->first();
					if ($akun_hutang == null) {
						return response()->json(['status'=>2,'pesan'=>'Cabang Ini Tidak Memiliki Hutang Pihak Ketiga']);
					}


					$total_biaya =  array_sum($request->bayar_biaya);
					$count 		 = count($request->no_do);

					$fp_jumlah   = filter_var($request->total_kotor_penerus,FILTER_SANITIZE_NUMBER_FLOAT)/100;
					$fp_dpp      	  = filter_var($request->total_dpp_penerus,FILTER_SANITIZE_NUMBER_FLOAT)/100;
					$fp_ppn      	  = filter_var($request->ppn_penerus,FILTER_SANITIZE_NUMBER_FLOAT)/100;
					$fp_pph      	  = filter_var($request->pph_penerus,FILTER_SANITIZE_NUMBER_FLOAT)/100;
					$fp_netto 		  = filter_var($request->total_netto,FILTER_SANITIZE_NUMBER_FLOAT)/100;
					if ($request->jenis_pph_penerus == '') {
						$fp_jenispph = 0;
					}else{
						$fp_jenispph = $request->jenis_pph_penerus;
					}

					if ($request->persen_pph_penerus == '') {
						$fp_nilaipph = 0;
					}else{
						$fp_nilaipph = $request->persen_pph_penerus;
					}

					$save_data = DB::table('faktur_pembelian')
								   ->insert([
								   	  'fp_idfaktur'   		=> $id,
									  'fp_nofaktur'   		=> $request->nofaktur,
									  'fp_tgl'        		=> $tgl,
									  'fp_keterangan' 		=> $request->Keterangan_biaya,
									  'fp_noinvoice'  		=> $request->Invoice_biaya,
									  'fp_jatuhtempo' 		=> $jt,
									  'updated_at'    		=> carbon::now(),
									  'fp_jumlah'     		=> $fp_jumlah,
									  'fp_netto' 	  		=> $fp_netto,
									  'fp_comp'  	  		=> $request->cabang,
									  'fp_pending_status'	=> $pending_status,
									  'fp_status'  			=> 'Released',  
									  'fp_jenisbayar' 		=> '6',
									  'fp_edit'  			=> 'ALLOWED',
									  'fp_sisapelunasan' 	=> $fp_netto,
									  'fp_supplier'  		=> $request->nama_kontak2,
									  'fp_acchutang'  		=> $akun_hutang->id_akun,
									  'fp_dpp'		  		=> $fp_dpp,
									  'fp_jenisppn'  		=> $request->jenis_ppn_penerus,
									  'fp_inputppn'  		=> $request->persen_ppn_penerus,
									  'fp_ppn'		  		=> $fp_ppn,
									  'fp_jenispph'	  		=> $fp_jenispph,
									  'fp_nilaipph'	  		=> $fp_nilaipph,
									  'fp_pph'		  		=> $fp_pph,
									  'updated_by'  		=> Auth::user()->m_name,
								   ]);	
					$id_faktur_pajak = DB::table("fakturpajakmasukan")->max('fpm_id')+1;
					$faktur_pajak = DB::table('fakturpajakmasukan')
									  ->insert([
									  	'fpm_id'		=> $id_faktur_pajak,
									  	'fpm_nota'		=> $request->faktur_pajak_penerus,
									  	'fpm_tgl'		=> carbon::parse($request->tanggal_pajak_penerus)->format('Y-m-d'),
									  	'fpm_masapajak'	=> carbon::parse($request->tanggal_pajak_penerus)->format('Y-m-d'),
									  	'fpm_dpp'		=> $fp_dpp,
									  	'fpm_hasilppn'	=> $fp_ppn,
									  	'fpm_inputppn'	=> $fp_ppn,
									  	'fpm_netto'		=> $fp_netto+$fp_pph,
									  	'fpm_idfaktur'	=> $id,
									  	'updated_at'    => carbon::now(),
									  ]);

					$id_bp = DB::table('biaya_penerus')
							 ->max('bp_id');

					if ($id_bp == null) {
						$id_bp = 1;
					}else{
						$id_bp+=1;
					}

					$save_data1 = DB::table('biaya_penerus')
									->insert([
									  'bp_id' 			 => $id_bp,
									  'bp_faktur' 		 => $request->nofaktur,
									  'bp_tipe_vendor' 	 => $request->vendor,
									  'bp_kode_vendor' 	 => $request->nama_kontak2,
									  'bp_keterangan' 	 => $request->Keterangan_biaya,
									  'bp_invoice'		 => $request->Invoice_biaya,
									  'bp_status'		 => $pending_status,
									  'updated_at' 		 => carbon::now(),
									  'bp_total_penerus' => $total_biaya,
									  'bp_akun_agen'	 => $akun_hutang->id_akun,
									]);

					

					for ($i=0; $i < count($request->no_do); $i++) { 

						$id_bpd = DB::table('biaya_penerus_dt')
							 ->max('bpd_id');

						if ($id_bpd == null) {
							$id_bpd = 1;
						}else{
							$id_bpd+=1;
						}
						$cari_do = DB::table("delivery_order")
									 ->where("nomor",$request->no_do[$i])
									 ->first();

						$akun_biaya = DB::table('d_akun')
										  ->where('id_akun','like',substr($biaya_paket,0,4).'%')
										  ->where('kode_cabang',$cari_do->kode_cabang)
										  ->first();
						if ($akun_biaya == null) {
							return response()->json(['status'=>2,'pesan'=>'Cabang Ini Tidak Memiliki Biaya AGEN/VENDOR']);
						}
						$save_dt = DB::table('biaya_penerus_dt')
									->insert([
										  'bpd_id'  		=> $id_bpd,
										  'bpd_bpid' 		=> $id_bp,
										  'bpd_bpdetail'	=> $i+1,
										  'bpd_pod' 		=> $request->no_do[$i],
										  'bpd_tgl'  		=> $cari_do->tanggal,
										  'bpd_akun_biaya'  => $akun_biaya->id_akun,
										  'bpd_debit' 	   	=> $request->DEBET_biaya[$i],
										  'bpd_memo'  	  	=> $request->ket_biaya[$i],
										  'bpd_akun_hutang' => $akun_hutang->id_akun,
										  'created_at'      => carbon::now(), 
										  'updated_at' 	   	=> carbon::now(),
										  'bpd_status' 	    => $status[$i],
										  'bpd_nominal'	    => $request->bayar_biaya[$i],
										  'bpd_tarif_resi'  => $request->do_harga[$i]
									]);
					}	

					$tt = DB::table('form_tt_d')
								->where('ttd_detail',$request->dt_tt)
								->where('ttd_id',$request->id_tt)
								->where('ttd_invoice',$request->invoice_tt)
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

					// //JURNAL
					$id_jurnal=d_jurnal::max('jr_id')+1;
					// dd($id_jurnal);
					$jenis_bayar = DB::table('jenisbayar')
									 ->where('idjenisbayar',6)
									 ->first();
					if ($pending_status == "APPROVED") {

						$bank = 'MM';
            			$km =  get_id_jurnal($bank, $request->cabang);
						$save_jurnal = d_jurnal::create(['jr_id'=> $id_jurnal,
												'jr_year'   => carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y'),
												'jr_date' 	=> carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y-m-d'),
												'jr_detail' => $jenis_bayar->jenisbayar,
												'jr_ref'  	=> $request->nofaktur,
												'jr_note'  	=> 'BIAYA PANERUS HUTANG AGEN '. strtoupper($request->Keterangan_biaya),
												'jr_insert' => carbon::now(),
												'jr_update' => carbon::now(),
												'jr_no'		=> $km,
												]);
					}
					


					$akun 	  = [];
					$akun_val = [];
					// HUTANG
					array_push($akun,$akun_hutang->id_akun);
					array_push($akun_val, $fp_netto);
					// BIAYA
					for ($i=0; $i < count($jurnal); $i++) { 

						$id_akun = DB::table('d_akun')
										  ->where('id_akun','like',substr($biaya_paket,0,4).'%')
										  ->where('kode_cabang',$jurnal[$i]['asal'])
										  ->first();

						if ($id_akun == null) {
							return response()->json(['status'=>0]);
						}

						$kurang = $fp_ppn/$fp_jumlah * $jurnal[$i]['harga'];

						$jurnal[$i]['harga'] -= $kurang;
						array_push($akun, $id_akun->id_akun);
						array_push($akun_val, $jurnal[$i]['harga']);
					}

					// PPN
					if ($fp_ppn != 0) {

						$akun_ppn = DB::table('d_akun')
										 ->where('id_akun','like','2302%')
										 ->where('kode_cabang',$request->cabang)
										 ->first();
						array_push($akun, $akun_ppn->id_akun);
						array_push($akun_val, $fp_ppn);
					}
					// PPH
					if ($fp_pph != 0) {

						$pajak = DB::table('pajak')
										 ->where('id',$request->jenis_pph_penerus)
										 ->first();

						$akun_pph = DB::table('d_akun')
										 ->where('id_akun','like','%'.substr($pajak->acc1, 0,4))
										 ->where('kode_cabang',$request->cabang)
										 ->first();

						array_push($akun, $akun_pph->id_akun);
						array_push($akun_val, $fp_pph);
					}

					$data_akun = [];
					for ($i=0; $i < count($akun); $i++) { 

						$cari_coa = DB::table('d_akun')
										  ->where('id_akun',$akun[$i])
										  ->first();

						if (substr($akun[$i],0, 4)==2102) {
							
							if ($cari_coa->akun_dka == 'D') {
								$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
								$data_akun[$i]['jrdt_detailid']	= $i+1;
								$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
								$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
								$data_akun[$i]['jrdt_statusdk'] = 'D';
								$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
							}else{
								$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
								$data_akun[$i]['jrdt_detailid']	= $i+1;
								$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
								$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
								$data_akun[$i]['jrdt_statusdk'] = 'K';
								$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
							}
						}else if (substr($akun[$i],0, 4)==2302) {

							if ($cari_coa->akun_dka == 'D') {
								$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
								$data_akun[$i]['jrdt_detailid']	= $i+1;
								$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
								$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
								$data_akun[$i]['jrdt_statusdk'] = 'D';
								$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
							}else{
								$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
								$data_akun[$i]['jrdt_detailid']	= $i+1;
								$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
								$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
								$data_akun[$i]['jrdt_statusdk'] = 'K';
								$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
							}
						}else if (substr($akun[$i],0, 4)==5314) {
							if ($cari_coa->akun_dka == 'D') {
								$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
								$data_akun[$i]['jrdt_detailid']	= $i+1;
								$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
								$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
								$data_akun[$i]['jrdt_statusdk'] = 'D';
								$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
							}else{
								$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
								$data_akun[$i]['jrdt_detailid']	= $i+1;
								$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
								$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
								$data_akun[$i]['jrdt_statusdk'] = 'K';
								$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
							}
						}else{
							if ($cari_coa->akun_dka == 'D') {
								$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
								$data_akun[$i]['jrdt_detailid']	= $i+1;
								$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
								$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
								$data_akun[$i]['jrdt_statusdk'] = 'D';
								$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
							}else{
								$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
								$data_akun[$i]['jrdt_detailid']	= $i+1;
								$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
								$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
								$data_akun[$i]['jrdt_statusdk'] = 'K';
								$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
							}
						}
					}

					if ($pending_status == 'APPROVED') {
						$jurnal_dt = d_jurnal_dt::insert($data_akun);
					}

					$lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();
					$check = check_jurnal(strtoupper($request->nofaktur));

					if ($check == 0) {
						DB::rollBack();
						return response()->json(['status' => 'gagal','info'=>'Jurnal Tidak Balance Gagal Simpan']);
					}
					return response()->json(['status'=>1,'sp'=>$pending_status,'id'=>$id]);
				}else{
					return response()->json(['status'=>2,'pesan'=>'DATA SUDAH ADA']);
				}
				
			});
		}
		public function edit($id){
			if (Auth::user()->punyaAKses('Faktur Pembelian','ubah')) {
			$cari_fp = DB::table('faktur_pembelian')
						 ->where('fp_idfaktur',$id)
						 ->first();
			$pajak = DB::table("pajak")
						->get();

			$faktur_pajak = DB::table('fakturpajakmasukan')
							  ->where('fpm_idfaktur',$id)
							  ->first();


			if ($cari_fp->fp_jenisbayar == 6) {
				$data = DB::table('akun')
					  ->get();

				$agen = DB::table('agen')
						  ->where('kategori','AGEN')
						  ->orWhere('kategori','AGEN DAN OUTLET')
						  ->get();
				$vendor = DB::table('vendor')
						  ->get();
				if (Auth::user()->punyaAKses('Biaya Penerus Hutang','all')) {
					$akun   = DB::table('d_akun')
							->get();
				}else{
					$akun   = DB::table('d_akun')
							->where('kode_cabang',Auth::user()->kode_cabang)
							->get();
				}

				$bp = DB::table('biaya_penerus')
						  ->join('faktur_pembelian','fp_nofaktur','=','bp_faktur')
						  ->where('bp_faktur',$cari_fp->fp_nofaktur)
						  ->first();

				$date = Carbon::parse($bp->fp_tgl)->format('d/m/Y');

				$bpd = DB::table('biaya_penerus_dt')
						  ->join('delivery_order','bpd_pod','=','nomor')
						  ->where('bpd_bpid',$bp->bp_id)
						  ->get();

				$bulan = Carbon::now()->format('m');
			    $tahun = Carbon::now()->format('y');

			    $cari_nota = DB::select("SELECT  substring(max(tt_noform),12) as id from form_tt
			                                    WHERE tt_idcabang = '$bp->fp_comp'
			                                    AND to_char(created_at,'MM') = '$bulan'
			                                    AND to_char(created_at,'YY') = '$tahun'");
			    $index = (integer)$cari_nota[0]->id + 1;
			    $index = str_pad($index, 3, '0', STR_PAD_LEFT);
			    $nota = 'TT' . $bulan . $tahun .'/'.$bp->fp_comp.'/'. $index;

				$form_tt = DB::table('form_tt')
							 ->where('tt_nofp',$cari_fp->fp_nofaktur)
							 ->first();

				// dd()
				$cabang = DB::table("cabang")
							->get();
				
				$jt = Carbon::now()->subDays(-30)->format('d/m/Y');

				$fpg = DB::select("SELECT fpg_nofpg as nomor, fpg_agen as agen,fpgb_nominal as total_um,fpgdt_sisapelunasanumfp as sisa_um, d_uangmuka.*
					   from fpg inner join fpg_cekbank on fpgb_idfpg = idfpg
					   inner join fpg_dt on fpgdt_idfpg = idfpg
					   inner join d_uangmuka on um_nomorbukti = fpgdt_nofaktur
					   where fpgb_posting = 'DONE'
					   and fpg_agen = '$bp->fp_supplier'");


				$bk  = DB::select("SELECT bkk_nota as nomor,bkk_supplier as agen,bkkd_total as total_um,bkkd_sisaum as sisa_um, d_uangmuka.*
								   from bukti_kas_keluar inner join bukti_kas_keluar_detail on bkkd_bkk_id = bkk_id
								   inner join d_uangmuka on um_nomorbukti = bkkd_ref
								   where bkk_supplier = '$bp->fp_supplier'");

				$data = [];
				
				// return dd($req->all());
				$trans = array_merge($fpg,$bk);

				$um = DB::table('uangmukapembelian_fp')
						->join('uangmukapembeliandt_fp','umfpdt_idumfp','=','umfp_id')
						->where('umfp_nofaktur',$bp->fp_nofaktur)
						->get();

				for ($i=0; $i < count($um); $i++) { 
					for ($a=0; $a < count($trans); $a++) { 
						if ($trans[$a]->nomor == $um[$i]->umfpdt_transaksibank and $trans[$a]->um_nomorbukti == $um[$i]->umfpdt_notaum) {
							$um[$i]->bkkd_sisa_um = $trans[$a]->sisa_um;
						}
					}
				}

				$tt = DB::table('form_tt_d')
						->join('form_tt','tt_idform','=','ttd_id')
						->where('ttd_faktur',$bp->fp_nofaktur)
						->first();

				// return $um;
				// if ($bp->bp_tipe_vendor == "AGEN") {
					return view('purchase/fatkur_pembelian/edit_biaya_penerus',compact('data','date','agen','vendor','now','jt','akun','bp','bpd','cari_fp','cabang','form_tt','id','nota','um','tt','pajak','faktur_pajak'));
				// }else{
				// 	return view('purchase/pembayaran_vendor/edit_vendor',compact('data','date','agen','vendor','now','jt','akun','bp','bpd','cari_fp','cabang','form_tt','id','nota','um','tt'));
				// }

			} elseif ($cari_fp->fp_jenisbayar == 7){


				$agen = DB::table('agen')
						  ->where('kategori','OUTLET')
						  ->orWhere('kategori','AGEN DAN OUTLET')
						  ->get();

				$data = DB::table('faktur_pembelian')
		        		  ->join('pembayaran_outlet','fp_nofaktur','=','pot_faktur')
		        		  ->join('agen','kode','=','fp_supplier')
		        		  ->where('fp_nofaktur',$cari_fp->fp_nofaktur)
		        		  ->first();

				$date = Carbon::parse($data->fp_tgl)->format('d/m/Y');
		        		
		        $cabang  = DB::table('cabang')
		        			 ->get();
		        $data_dt = DB::table('pembayaran_outlet_dt')
		        		  ->join('pembayaran_outlet','potd_potid','=','pot_id')
		        		  ->join('delivery_order','nomor','=','potd_pod')
		       				 ->where('potd_potid',$data->pot_id)
		       				 ->orderBy('pot_tgl','ASC')
		       				 ->get();

				$akun_biaya = DB::table('akun_biaya')
						  ->get();
				$exp = explode('-',$data_dt[0]->pot_tgl);
				$first = Carbon::createFromDate($exp[0], $exp[1], $exp[2]);
		        $second = Carbon::now()->format('d/m/Y');
		        $start = $first->subDays(30)->startOfDay()->format('d/m/Y');
		        $jt = Carbon::now()->subDays(-30)->format('d/m/Y');

		        


		       	$valid_cetak = DB::table('form_tt')
		       					 ->where('tt_nofp',$data->fp_nofaktur)
		       					 ->first();
		       	$bulan = Carbon::now()->format('m');
			    $tahun = Carbon::now()->format('y');

			    $cari_nota = DB::select("SELECT  substring(max(tt_noform),12) as id from form_tt
			                                    WHERE tt_idcabang = '$data->fp_comp'
			                                    AND to_char(created_at,'MM') = '$bulan'
			                                    AND to_char(created_at,'YY') = '$tahun'");
			    $index = (integer)$cari_nota[0]->id + 1;
			    $index = str_pad($index, 3, '0', STR_PAD_LEFT);
			    $nota = 'TT' . $bulan . $tahun .'/'.$data->fp_comp.'/'. $index;


		       	$fpg = DB::select("SELECT fpg_nofpg as nomor, fpg_agen as agen,fpgb_nominal as total_um,fpgdt_sisapelunasanumfp as sisa_um, d_uangmuka.*
					   from fpg inner join fpg_cekbank on fpgb_idfpg = idfpg
					   inner join fpg_dt on fpgdt_idfpg = idfpg
					   inner join d_uangmuka on um_nomorbukti = fpgdt_nofaktur
					   where fpgb_posting = 'DONE'
					   and fpg_agen = '$data->fp_supplier'");


				$bk  = DB::select("SELECT bkk_nota as nomor,bkk_supplier as agen,bkkd_total as total_um,bkkd_sisaum as sisa_um, d_uangmuka.*
								   from bukti_kas_keluar inner join bukti_kas_keluar_detail on bkkd_bkk_id = bkk_id
								   inner join d_uangmuka on um_nomorbukti = bkkd_ref
								   where bkk_supplier = '$data->fp_supplier'");

				
				// return dd($req->all());
				$trans = array_merge($fpg,$bk);

				$um = DB::table('uangmukapembelian_fp')
						->join('uangmukapembeliandt_fp','umfpdt_idumfp','=','umfp_id')
						->where('umfp_nofaktur',$data->fp_nofaktur)
						->get();

				for ($i=0; $i < count($um); $i++) { 
					for ($a=0; $a < count($trans); $a++) { 
						if ($trans[$a]->nomor == $um[$i]->umfpdt_transaksibank and $trans[$a]->um_nomorbukti == $um[$i]->umfpdt_notaum) {
							$um[$i]->bkkd_sisa_um 	= $trans[$a]->sisa_um;
						}
					}
				}

				$tt = DB::table('form_tt_d')
						->join('form_tt','tt_idform','=','ttd_id')
						->where('ttd_faktur',$data->fp_nofaktur)
						->first();

			return view('purchase/fatkur_pembelian/editOutlet',compact('date','agen','akun_biaya','second','start','jt','data','data_dt','valid_cetak','id','cabang','um','nota','tt'));

			}elseif ($cari_fp->fp_jenisbayar == 9){
				$date = Carbon::now()->format('d/m/Y');

				$agen = DB::table('agen')
						  ->get();

				$akun = DB::table('master_persentase')
						  ->get();

				$subcon = DB::table('subcon')
						  ->get();
				$akun_biaya = DB::table('d_akun')
						  ->where('id_akun','like','5'.'%')
						  ->get();
				$kota   = DB::table('kota')
						->get();

				$data = DB::table('faktur_pembelian')
						  ->join('pembayaran_subcon','fp_nofaktur','=','pb_faktur')
						  ->where('fp_idfaktur',$id)
						  ->first();


				$data_dt = DB::table('pembayaran_subcon_dt')
						  ->join('pembayaran_subcon','pbd_pb_id','=','pb_id')
						  ->where('pb_faktur',$cari_fp->fp_nofaktur)
						  ->get();

				$valid_cetak = DB::table('form_tt')
		       					 ->where('tt_nofp',$data->fp_nofaktur)
		       					 ->first();

		       	$cabang = DB::table('cabang')
		       				->get();

		       	$bulan = Carbon::now()->format('m');
			    $tahun = Carbon::now()->format('y');

			    $cari_nota = DB::select("SELECT  substring(max(tt_noform),12) as id from form_tt
			                                    WHERE tt_idcabang = '$data->fp_comp'
			                                    AND to_char(created_at,'MM') = '$bulan'
			                                    AND to_char(created_at,'YY') = '$tahun'");
			    $index = (integer)$cari_nota[0]->id + 1;
			    $index = str_pad($index, 3, '0', STR_PAD_LEFT);
			    $nota = 'TT' . $bulan . $tahun .'/'.$data->fp_comp.'/'. $index;


		       	$fpg = DB::select("SELECT fpg_nofpg as nomor, fpg_agen as agen,fpgb_nominal as total_um,fpgdt_sisapelunasanumfp as sisa_um, d_uangmuka.*
					   from fpg inner join fpg_cekbank on fpgb_idfpg = idfpg
					   inner join fpg_dt on fpgdt_idfpg = idfpg
					   inner join d_uangmuka on um_nomorbukti = fpgdt_nofaktur
					   where fpgb_posting = 'DONE'
					   and fpg_agen = '$data->fp_supplier'");


				$bk  = DB::select("SELECT bkk_nota as nomor,bkk_supplier as agen,bkkd_total as total_um,bkkd_sisaum as sisa_um, d_uangmuka.*
								   from bukti_kas_keluar inner join bukti_kas_keluar_detail on bkkd_bkk_id = bkk_id
								   inner join d_uangmuka on um_nomorbukti = bkkd_ref
								   where bkk_supplier = '$data->fp_supplier'");

				
				// return dd($req->all());
				$trans = array_merge($fpg,$bk);

				$um = DB::table('uangmukapembelian_fp')
						->join('uangmukapembeliandt_fp','umfpdt_idumfp','=','umfp_id')
						->where('umfp_nofaktur',$data->fp_nofaktur)
						->get();

				for ($i=0; $i < count($um); $i++) { 
					for ($a=0; $a < count($trans); $a++) { 
						if ($trans[$a]->nomor == $um[$i]->umfpdt_transaksibank and $trans[$a]->um_nomorbukti == $um[$i]->umfpdt_notaum) {
							$um[$i]->bkkd_sisa_um 	= $trans[$a]->sisa_um;
						}
					}
				}

				$tt = DB::table('form_tt_d')
						->join('form_tt','tt_idform','=','ttd_id')
						->where('ttd_faktur',$data->fp_nofaktur)
						->first();
				return view('purchase/fatkur_pembelian/editsubcon',compact('date','kota','subcon','akun_biaya','akun','valid_cetak','data','data_dt','cabang','um','nota','id','tt','pajak','faktur_pajak'));
			}



			}else{
				return redirect()->back();
			}
			
		 	
		}


		public function hapus_biaya($id){
		 	$cari = DB::table('faktur_pembelian')
		 				->where('fp_idfaktur',$id)
		 				->first();

		 	$bkk = DB::table('bukti_kas_keluar_detail')
		 			 ->join('bukti_kas_keluar','bkk_id','=','bkkd_bkk_id')
		 			 ->select('bkk_nota as nota')
		 			 ->where('bkkd_ref',$cari->fp_nofaktur)
		 			 ->get();

		 	$fpg = DB::table('fpg_dt')
		 			 ->join('fpg','idfpg','=','fpgdt_idfpg')
		 			 ->select('fpg_nofpg as nota')
		 			 ->where('fpgdt_nofaktur',$cari->fp_nofaktur)
		 			 ->get();	 

		 	$all = array_merge($bkk,$fpg);

		 	$text = '';

		 	for ($i=0; $i < count($all); $i++) { 
		 		$text.=$all[$i]->nota.' ';
		 	}

		 	if ($all != null) {
		 		return response()->json(['status'=>3,'pesan'=>'Data Telah Dibiayai di '.$text]);
		 	}
		 	$delete_jurnal = DB::table('d_jurnal')
							   ->where('jr_ref',$cari->fp_nofaktur)
							   ->delete();


			$um = DB::table('uangmukapembelian_fp')
				->join('uangmukapembeliandt_fp','umfpdt_idumfp','=','umfp_id')
				->where('umfp_nofaktur',$cari->fp_nofaktur)
				->get();

			for ($i=0; $i < count($um); $i++) { 	

				$cari_fp = DB::table('faktur_pembelian')
							 ->where('fp_nofaktur',$cari->fp_nofaktur)
							 ->first();

				$update_fp = DB::table('faktur_pembelian')
							   ->where('fp_nofaktur',$cari->fp_nofaktur)
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
							 ->where('fp_nofaktur',$cari->fp_nofaktur)
							 ->first();

			}


			$hapus_um = DB::table('uangmukapembelian_fp')
					 	->where('umfp_nofaktur',$cari->fp_nofaktur)
					    ->delete();

			if ($cari->fp_jenisbayar == 6) {

				$delete = DB::table('biaya_penerus')
		 				->where('bp_faktur',$cari->fp_nofaktur)
		 				->delete();

		 		
			}elseif ($cari->fp_jenisbayar == 7){
				$pot = DB::table('pembayaran_outlet')
		 				->where('pot_faktur',$cari->fp_nofaktur)
		 				->first();

		 		$delete = DB::table('pembayaran_outlet_dt')
		 				->where('potd_potid',$pot->pot_id)
		 				->delete();

		 		$pot = DB::table('pembayaran_outlet')
		 				->where('pot_faktur',$cari->fp_nofaktur)
		 				->delete();
			}elseif ($cari->fp_jenisbayar == 9){
				$pot = DB::table('pembayaran_subcon')
		 				->where('pb_faktur',$cari->fp_nofaktur)
		 				->first();

		 		$delete = DB::table('pembayaran_subcon_dt')
		 				->where('pbd_pb_id',$pot->pb_id)
		 				->delete();

		 		$pot = DB::table('pembayaran_subcon')
		 				->where('pb_faktur',$cari->fp_nofaktur)
		 				->first();
			}
			$tt = DB::table('form_tt_d')
					  ->where('ttd_faktur',$cari->fp_nofaktur)
					  ->update([
					  	'ttd_faktur'=>null
					  ]);


		 	$delete = DB::table('faktur_pembelian')
		 				->where('fp_idfaktur',$id)
		 				->delete();
		 	return response()->json(['status'=>1]);
		}

		public function update_agen(request $request){

			return DB::transaction(function() use ($request) {  
				$cari_fp = DB::table('faktur_pembelian')
							 ->where('fp_nofaktur',$request->nofaktur)
							 ->first();

				$tgl         = str_replace('/', '-', $request->tgl_biaya_head);		 
				$tgl 		 = Carbon::parse($tgl)->format('Y-m-d');
				$jt         = str_replace('/', '-', $request->jatuh_tempo);		 
				$jt 		 = Carbon::parse($jt)->format('Y-m-d');
				$total_biaya = array_sum($request->bayar_biaya);

				if ($request->vendor == "AGEN") {
					$cari_persen = DB::table('agen')
					 					 ->where('kode',$request->nama_kontak2)
					 					 ->first();
					$komisi = $cari_persen->komisi_agen;
					$biaya_paket = '5314';
				}else{
				 	$cari_persen = DB::table('vendor')
				 					 ->where('kode',$request->nama_kontak2)
				 					 ->first();
					$komisi = $cari_persen->komisi_vendor;
					$biaya_paket = '5315';
				}

				$status=[];

				for ($i=0; $i < count($request->do_harga); $i++) 
				{
				    $persentase = $komisi/100; 
				    $harga_fix  = round($request->do_harga[$i])*$persentase;

					if($request->bayar_biaya[$i] <= $harga_fix){
						$status[$i] = 'APPROVED';
					}else{
						$status[$i] = 'PENDING';
					}
				}

				if(in_array('PENDING', $status)){
				 	$pending_status='PENDING';
				}else{
				 	$pending_status='APPROVED';
				}

				if ($cari_fp != null) {

					$um = DB::table('uangmukapembelian_fp')
							->where('umfp_nofaktur',$request->nofaktur)
							->first();

					

					$total_biaya =  array_sum($request->bayar_biaya);

					if ($um !=null) {
						$total_biaya -=$um->umfp_totalbiaya ;
					}

					$akun_hutang = DB::table('d_akun')
										  ->where('id_akun','like',substr($cari_persen->acc_hutang,0,4).'%')
										  ->where('kode_cabang',$request->cabang)
										  ->first();


					if ($akun_hutang == null) {
						return response()->json(['status'=>2,'pesan'=>'Cabang Ini Tidak Memiliki Hutang Pihak Ketiga']);
					}


					
					$count 		 = count($request->no_do);

					$total_biaya =  array_sum($request->bayar_biaya);
					$count 		 = count($request->no_do);

					$fp_jumlah   = filter_var($request->total_kotor_penerus,FILTER_SANITIZE_NUMBER_FLOAT)/100;
					$fp_dpp      	  = filter_var($request->total_dpp_penerus,FILTER_SANITIZE_NUMBER_FLOAT)/100;
					$fp_ppn      	  = filter_var($request->ppn_penerus,FILTER_SANITIZE_NUMBER_FLOAT)/100;
					$fp_pph      	  = filter_var($request->pph_penerus,FILTER_SANITIZE_NUMBER_FLOAT)/100;
					$fp_netto 		  = filter_var($request->total_netto,FILTER_SANITIZE_NUMBER_FLOAT)/100;
					if ($request->persen_pph_penerus == '') {
						$fp_nilaipph = 0;
					}else{
						$fp_nilaipph = $request->persen_pph_penerus;
					}
					if ($request->jenis_pph_penerus == '') {
						$fp_jenispph = 0;
					}else{
						$fp_jenispph = $request->jenis_pph_penerus;
					}
					$save_data = DB::table('faktur_pembelian')
								   ->where('fp_nofaktur',$request->nofaktur)
								   ->update([
									  'fp_tgl'        		=> $tgl,
									  'fp_keterangan' 		=> $request->Keterangan_biaya,
									  'fp_noinvoice'  		=> $request->Invoice_biaya,
									  'fp_jatuhtempo' 		=> $jt,
									  'created_at'    		=> carbon::now(),
									  'updated_at'    		=> carbon::now(),
									  'fp_jumlah'     		=> $fp_jumlah,
									  'fp_netto' 	  		=> $fp_netto,
									  'fp_comp'  	  		=> $request->cabang,
									  'fp_pending_status'	=> $pending_status,
									  'fp_status'  			=> 'Released',  
									  'fp_jenisbayar' 		=> '6',
									  'fp_edit'  			=> 'ALLOWED',
									  'fp_sisapelunasan' 	=> $fp_netto,
									  'fp_supplier'  		=> $request->nama_kontak2,
									  'fp_acchutang'  		=> $akun_hutang->id_akun,
									  'fp_dpp'		  		=> $fp_dpp,
									  'fp_jenisppn'  		=> $request->jenis_ppn_penerus,
									  'fp_inputppn'  		=> $request->persen_ppn_penerus,
									  'fp_ppn'		  		=> $fp_ppn,
									  'fp_jenispph'	  		=> $fp_jenispph,
									  'fp_nilaipph'	  		=> $fp_nilaipph,
									  'fp_pph'		  		=> $fp_pph,
									  'created_by'  		=> Auth::user()->m_name,
									  'updated_by'  		=> Auth::user()->m_name,
								   ]);	
					$faktur_pajak = DB::table('fakturpajakmasukan')
									  ->where('fpm_idfaktur',$cari_fp->fp_idfaktur)
									  ->update([
									  	'fpm_nota'		=> $request->faktur_pajak_penerus,
									  	'fpm_tgl'		=> carbon::parse($request->tanggal_pajak_penerus)->format('Y-m-d'),
									  	'fpm_masapajak'	=> carbon::parse($request->tanggal_pajak_penerus)->format('Y-m-d'),
									  	'fpm_dpp'		=> $fp_dpp,
									  	'fpm_hasilppn'	=> $fp_ppn,
									  	'fpm_inputppn'	=> $fp_ppn,
									  	'fpm_netto'		=> $fp_netto+$fp_pph,
									  	'created_at'    => carbon::now(),
									  	'updated_at'    => carbon::now(),
									  ]);

				
					$save_data1 = DB::table('biaya_penerus')
									->where('bp_faktur',$request->nofaktur)
									->update([
									  'bp_faktur' 		 => $request->nofaktur,
									  'bp_tipe_vendor' 	 => $request->vendor,
									  'bp_kode_vendor' 	 => $request->nama_kontak2,
									  'bp_keterangan' 	 => $request->Keterangan_biaya,
									  'bp_invoice'		 => $request->Invoice_biaya,
									  'bp_status'		 => $pending_status,
									  'updated_at' 		 => carbon::now(),
									  'created_at' 		 => carbon::now(),
									  'bp_total_penerus' => $total_biaya,
									  'bp_akun_agen'	 => $akun_hutang->id_akun,
									]);

					$cari_bp = DB::table("biaya_penerus")
									 ->where("bp_faktur",$request->nofaktur)
									 ->first();

					$delete_bpd = DB::table('biaya_penerus_dt')
									->where('bpd_bpid',$cari_bp->bp_id)
									->delete();

					for ($i=0; $i < count($request->no_do); $i++) { 
						
					
						$cari_do = DB::table("delivery_order")
									 ->where("nomor",$request->no_do[$i])
									 ->first();

						$id_bpd = DB::table('biaya_penerus_dt')
								   ->max('bpd_id');

						if ($id_bpd == null) {
							$id_bpd = 1;
						}else{
							$id_bpd +=1;
						}

						$akun_biaya = DB::table('d_akun')
										  ->where('id_akun','like',substr($biaya_paket,0,4).'%')
										  ->where('kode_cabang',$cari_do->kode_cabang)
										  ->first();
						if ($akun_biaya == null) {
							return response()->json(['status'=>2,'pesan'=>'Cabang Ini Tidak Memiliki Biaya AGEN/VENDOR']);
						}

						// dd($akun_biaya);
						$save_dt = DB::table('biaya_penerus_dt')
									 ->insert([
										  'bpd_id' 			=> $id_bpd,
										  'bpd_bpid' 		=> $cari_bp->bp_id,
										  'bpd_bpdetail'	=> $i+1,
										  'bpd_pod' 		=> $request->no_do[$i],
										  'bpd_tgl'  		=> $cari_do->tanggal,
										  'bpd_akun_biaya'  => $akun_biaya->id_akun,
										  'bpd_debit' 	   	=> $request->DEBET_biaya[$i],
										  'bpd_memo'  	  	=> $request->ket_biaya[$i],
										  'bpd_akun_hutang' => $akun_hutang->id_akun,
										  'created_at'      => carbon::now(), 
										  'updated_at' 	   	=> carbon::now(),
										  'bpd_status' 	    => $status[$i],
										  'bpd_nominal'	    => $request->bayar_biaya[$i],
										  'bpd_tarif_resi'  => $request->do_harga[$i]
									 ]);

					}	

					$tt_upd = DB::table('form_tt_d')
					  ->where('ttd_faktur',$request->nofaktur)
					  ->update([
					  	'ttd_faktur'=>null
					  ]);

					$tt = DB::table('form_tt_d')
								->where('ttd_detail',$request->dt_tt)
								->where('ttd_id',$request->id_tt)
								->where('ttd_invoice',$request->invoice_tt)
								->update([
									'ttd_faktur' => $request->nofaktur,
								]);
					// JURNAL
					

					$cari_dt=DB::table('biaya_penerus_dt')		
						 ->join('delivery_order','bpd_pod','=','nomor')
						 ->where('bpd_bpid','=',$cari_bp->bp_id)
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
							   ->where('jr_ref',$request->nofaktur)
							   ->delete();

					$id_jurnal=d_jurnal::max('jr_id')+1;
					$jenis_bayar = DB::table('jenisbayar')
									 ->where('idjenisbayar',6)
									 ->first();


					if ($pending_status == "APPROVED") {

						$bank = 'MM';
            			$km =  get_id_jurnal($bank, $request->cabang);
						$save_jurnal = d_jurnal::create(['jr_id'=> $id_jurnal,
												'jr_year'   => carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y'),
												'jr_date' 	=> carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y-m-d'),
												'jr_detail' => $jenis_bayar->jenisbayar,
												'jr_ref'  	=> $request->nofaktur,
												'jr_note'  	=> 'BIAYA PENERUS HUTANG ' . strtoupper($request->Keterangan_biaya),
												'jr_insert' => carbon::now(),
												'jr_update' => carbon::now(),
												'jr_no'		=> $km,
												]);
					}
					


					$akun 	  = [];
					$akun_val = [];
					// HUTANG
					array_push($akun,$akun_hutang->id_akun);
					array_push($akun_val, $fp_netto);
					// BIAYA
					for ($i=0; $i < count($jurnal); $i++) { 

						$id_akun = DB::table('d_akun')
										  ->where('id_akun','like',substr($biaya_paket,0,4).'%')
										  ->where('kode_cabang',$jurnal[$i]['asal'])
										  ->first();

						if ($id_akun == null) {
							return response()->json(['status'=>0]);
						}

						$kurang = $fp_ppn/$fp_jumlah * $jurnal[$i]['harga'];

						$jurnal[$i]['harga'] -= $kurang;
						array_push($akun, $id_akun->id_akun);
						array_push($akun_val, $jurnal[$i]['harga']);
					}

					// PPN
					if ($fp_ppn != 0) {

						$akun_ppn = DB::table('d_akun')
										 ->where('id_akun','like','2302%')
										 ->where('kode_cabang',$request->cabang)
										 ->first();
						array_push($akun, $akun_ppn->id_akun);
						array_push($akun_val, $fp_ppn);
					}
					// PPH
					if ($fp_pph != 0) {

						$pajak = DB::table('pajak')
										 ->where('id',$request->jenis_pph_penerus)
										 ->first();

						$akun_pph = DB::table('d_akun')
										 ->where('id_akun','like',substr($pajak->acc1, 0,4).'%')
										 ->where('kode_cabang',$request->cabang)
										 ->first();
						if ($akun_pph == null) {
							DB::rollBack();
							return Response::json(['status'=>0,'pesan'=>'Cabang Ini Tidak Punya Akun '.$pajak->nama]);
						}
						array_push($akun, $akun_pph->id_akun);
						array_push($akun_val, $fp_pph);
					}

					$data_akun = [];
					for ($i=0; $i < count($akun); $i++) { 

						$cari_coa = DB::table('d_akun')
										  ->where('id_akun',$akun[$i])
										  ->first();

						if (substr($akun[$i],0, 4)==2102) {
							
							if ($cari_coa->akun_dka == 'D') {
								$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
								$data_akun[$i]['jrdt_detailid']	= $i+1;
								$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
								$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
								$data_akun[$i]['jrdt_statusdk'] = 'D';
								$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
							}else{
								$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
								$data_akun[$i]['jrdt_detailid']	= $i+1;
								$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
								$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
								$data_akun[$i]['jrdt_statusdk'] = 'K';
								$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
							}
						}else if (substr($akun[$i],0, 4)==2302) {

							if ($cari_coa->akun_dka == 'D') {
								$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
								$data_akun[$i]['jrdt_detailid']	= $i+1;
								$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
								$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
								$data_akun[$i]['jrdt_statusdk'] = 'D';
								$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
							}else{
								$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
								$data_akun[$i]['jrdt_detailid']	= $i+1;
								$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
								$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
								$data_akun[$i]['jrdt_statusdk'] = 'K';
								$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
							}
						}else if (substr($akun[$i],0, 4)==5314) {
							if ($cari_coa->akun_dka == 'D') {
								$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
								$data_akun[$i]['jrdt_detailid']	= $i+1;
								$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
								$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
								$data_akun[$i]['jrdt_statusdk'] = 'D';
								$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
							}else{
								$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
								$data_akun[$i]['jrdt_detailid']	= $i+1;
								$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
								$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
								$data_akun[$i]['jrdt_statusdk'] = 'K';
								$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
							}
						}else{
							if ($cari_coa->akun_dka == 'D') {
								$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
								$data_akun[$i]['jrdt_detailid']	= $i+1;
								$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
								$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
								$data_akun[$i]['jrdt_statusdk'] = 'D';
								$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
							}else{
								$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
								$data_akun[$i]['jrdt_detailid']	= $i+1;
								$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
								$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
								$data_akun[$i]['jrdt_statusdk'] = 'K';
								$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
							}
						}
					}

					if ($pending_status == 'APPROVED') {
						$jurnal_dt = d_jurnal_dt::insert($data_akun);
					}

					$lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();
					$check = check_jurnal(strtoupper($request->nofaktur));

					if ($check == 0) {
						DB::rollBack();
						return response()->json(['status' => 'gagal','info'=>'Jurnal Tidak Balance Gagal Simpan']);
					}
					return response()->json(['status'=>1,'sp'=>$pending_status]);
				}else{
					return response()->json(['status'=>2,'pesan'=>'DATA SUDAH ADA']);
				}
				
			});
		}
		public function getdatapenerusedit(){

			$data = DB::table('akun')
					  ->get();
			$date = Carbon::now()->format('d/m/Y');

			$agen = DB::table('agen')
					  ->where()
					  ->get();
			$vendor = DB::table('vendor')
					  ->where()
					  ->get();
			$akun_biaya = DB::table('akun_biaya')
					  ->get();
		
			return view('purchase/fatkur_pembelian/editTableBiaya',compact('data','date','agen','vendor','akun_biaya','now'));
		}
/////////////////////////////////////////////////////////////////////////////////////////////////
		public function getpembayaranoutlet(){



			$date = Carbon::now()->format('d/m/Y');

			$agen = DB::table('agen')
					  ->where('kategori','OUTLET')
					  ->orWhere('kategori','AGEN DAN OUTLET')
					  ->get();
			$pajak = DB::table("pajak")
						->get();
			$akun_biaya = DB::table('akun_biaya')
					  ->get();
			$first = Carbon::now();
	        $second = Carbon::now()->format('d/m/Y');
	        // $start = $first->subMonths(1)->startOfMonth();
	        $start = $first->subDays(30)->startOfDay()->format('d/m/Y');
	        $jt = Carbon::now()->subDays(-30)->format('d/m/Y');



			return view('purchase/fatkur_pembelian/PembayaranOutlet',compact('date','agen','akun_biaya','second','start','jt','pajak'));
		}
		public function cari_outlet(request $request){
			// dd($request->all());
		

		$tgl = explode('-',$request->reportrange);
		$tgl = str_replace(' ', '', $tgl);
		for ($i=0; $i < count($tgl); $i++) { 
			$tgl[$i] = str_replace('/', '-', $tgl[$i]);
			$tgl[$i] = Carbon::parse($tgl[$i])->format('Y-m-d');
		}

		if(isset($tgl)){

			$list = DB::select("SELECT nomor,potd_pod,tanggal,nama_pengirim,nama_penerima,total_net,asal.nama as asal,asal.id as id_asal,
			 							tujuan.nama as tujuan,tujuan.id as id_tujuan,status,agen.nama as nama_agen,tarif_dasar,biaya_komisi,
			 							delivery_order.kode_cabang 
					 					FROM delivery_order
										LEFT JOIN agen on agen.kode = kode_outlet
										LEFT JOIN 
										(SELECT id,nama FROM kota) as asal on id_kota_asal = asal.id
										LEFT JOIN 
										(SELECT id,nama FROM kota) as tujuan on id_kota_tujuan = tujuan.id
										LEFT JOIN
										pembayaran_outlet_dt on potd_pod = nomor
										WHERE delivery_order.tanggal >= '$tgl[0]'
										AND delivery_order.tanggal <= '$tgl[1]'
										AND delivery_order.kode_outlet = '$request->selectOutlet'
										-- AND delivery_order.kode_cabang = '$request->cabang'
										order by tanggal desc");
			

			$persen = DB::table('agen')
			 			 ->where('kode',$request->selectOutlet)
			 			 ->first();
			
			$data = array();
	        foreach ($list as $r) {
	            $data[] = (array) $r;
	        }
	 
	        foreach ($data as $i => $key) {
	            
	            $data[$i]['komisi']	= (float)$data[$i]['total_net']*(float)($persen->komisi/100);
	            $data[$i]['total_komisi']	= ((float)$data[$i]['total_net']*(float)($persen->komisi/100))+$data[$i]['biaya_komisi'];
	          
	        }
	        return view('purchase/fatkur_pembelian/detailpembayaranoutlet',compact('data'));
    	}
    

        
		}

		public function cari_outlet1(request $request){
		
		 // dd($request->all());

		$id = $request->id;
		$tgl = explode('-',$request->reportrange);

		for ($i=0; $i < count($tgl); $i++) { 
			$tgl[$i] = str_replace('/', '-', $tgl[$i]);
			$tgl[$i] = Carbon::parse($tgl[$i])->format('Y-m-d');
		}

		$id = DB::table('faktur_pembelian')
				->join('pembayaran_outlet','pot_faktur','=','fp_nofaktur')
				->where('fp_idfaktur',$id)
				->first();
		// return $tgl;
		if(isset($tgl[1])){

			$list = DB::select("SELECT potd_pod,potd_potid,potd_pod,agen.kode_cabang,nomor,tanggal,nama_pengirim,nama_penerima,asal.nama as asal,asal.id as id_asal,
			 							tujuan.nama as tujuan,tujuan.id as id_tujuan,status,agen.nama as nama_agen,tarif_dasar,biaya_komisi,total_net
					 					FROM delivery_order
										LEFT JOIN agen on agen.kode = kode_outlet
										LEFT JOIN 
										(SELECT id,nama FROM kota) as asal on id_kota_asal = asal.id
										LEFT JOIN 
										(SELECT id,nama FROM kota) as tujuan on id_kota_tujuan = tujuan.id
										LEFT JOIN
										pembayaran_outlet_dt on potd_pod = nomor
										WHERE delivery_order.tanggal >= '$tgl[0]'
										AND delivery_order.tanggal <= '$tgl[1]'
										AND delivery_order.kode_outlet = '$request->selectOutlet'
										order by tanggal desc");


			$persen = DB::table('agen')
			 			 ->where('kode',$request->selectOutlet)
			 			 ->first();
				
			$data = array();
	        foreach ($list as $r) {
	            $data[] = (array) $r;
	        }
	        foreach ($data as $i => $key) {
	            
	            $data[$i]['komisi']	= round($data[$i]['total_net']*($persen->komisi/100),2);
	            $data[$i]['total_komisi']	= ((float)$data[$i]['total_net']*(float)($persen->komisi/100))+$data[$i]['biaya_komisi'];
	          
	        }
	        return view('purchase/fatkur_pembelian/detailTableOutlet',compact('data','id'));
    	}
    

        
		}


		public function notaoutlet(request $request){
			// dd($request->all());	
			$year =Carbon::now()->format('y'); 
			$month =Carbon::now()->format('m'); 
			$mon =Carbon::now(); 

			$idfaktur =   fakturpembelian::where('fp_comp' , $request->cab)
											->where('fp_jenisbayar','7')
											// ->where('created_at','>=',$mon)
											->max('fp_nofaktur');
		//	dd($nosppid);
			if(isset($idfaktur)) {
				$explode  = explode("/", $idfaktur);
				$idfaktur = $explode[2];
				$idfaktur = filter_var($idfaktur, FILTER_SANITIZE_NUMBER_INT);
				$idfaktur = str_replace('-', '', $idfaktur) ;
				$string = (int)$idfaktur + 1;
				$idfaktur = str_pad($string, 3, '0', STR_PAD_LEFT);
			}

			else {
				$idfaktur = '001';
			}

			$nota = 'FB' . $month . $year . '/' . $request->cab . '/O-' .  $idfaktur;
			/*dd($data['nofp']);*/

			return response()->json(['nota' => $nota]);

		}


		public function notapenerusagen(request $request){
			$year =Carbon::now()->format('y'); 
			$month =Carbon::now()->format('m'); 

			 $idfaktur =   fakturpembelian::where('fp_comp' , $request->cab)
											->where('fp_jenisbayar','6')
											->max('fp_nofaktur');
		//	dd($nosppid);
			// return $idfaktur;
			if(isset($idfaktur)) {
				$explode  = explode("/", $idfaktur);
				$idfaktur = $explode[2];
				$idfaktur = filter_var($idfaktur, FILTER_SANITIZE_NUMBER_INT);
				$idfaktur = str_replace('-', '', $idfaktur) ;
				$string = (int)$idfaktur + 1;
				$idfaktur = str_pad($string, 3, '0', STR_PAD_LEFT);
			}

			else {
				$idfaktur = '001';
			}

			$nota = 'FB' . $month . $year . '/' . $request->cab . '/P-' .  $idfaktur;
			/*dd($data['nofp']);*/

			return response()->json(['nota' => $nota]);
			
		}

		public function ganti_nota(request $request)
		{
			$year =Carbon::now()->format('y'); 
			$month =Carbon::now()->format('m'); 

			if ($request->flag == 'P') {
				$idfaktur =   fakturpembelian::where('fp_comp' , $request->cabang)
											->where('fp_jenisbayar','6')
											->max('fp_nofaktur');
			}elseif ($request->flag == 'O') {
				$idfaktur =   fakturpembelian::where('fp_comp' , $request->cabang)
											->where('fp_jenisbayar','7')
											->max('fp_nofaktur');
			}elseif ($request->flag == 'SC') {
				$idfaktur =   fakturpembelian::where('fp_comp' , $request->cabang)
											->where('fp_jenisbayar','9')
											->max('fp_nofaktur');
			}
			
		//	dd($nosppid);
			// return $idfaktur;
			if(isset($idfaktur)) {
				$explode  = explode("/", $idfaktur);
				$idfaktur = $explode[2];
				$idfaktur = filter_var($idfaktur, FILTER_SANITIZE_NUMBER_INT);
				$idfaktur = str_replace('-', '', $idfaktur) ;
				$string = (int)$idfaktur + 1;
				$idfaktur = str_pad($string, 3, '0', STR_PAD_LEFT);
			}

			else {
				$idfaktur = '001';
			}

			$nota = 'FB' . $month . $year . '/' . $request->cabang . '/'.$request->flag.'-' .  $idfaktur;
			/*dd($data['nofp']);*/

			return response()->json(['nota' => $nota]);
		}
		public function notasubcon(request $request){
			$year =Carbon::now()->format('y'); 
			$month =Carbon::now()->format('m'); 

			 $idfaktur =   fakturpembelian::where('fp_comp' , $request->cab)
											->where('fp_nofaktur','LIKE','%'.'SC-0'.'%')
											->max('fp_nofaktur');
		//	dd($nosppid);
			if(isset($idfaktur)) {
				$explode  = explode("/", $idfaktur);
				$idfaktur = $explode[2];
				$idfaktur = filter_var($idfaktur, FILTER_SANITIZE_NUMBER_INT);
				$idfaktur = str_replace('-', '', $idfaktur) ;
				$string = (int)$idfaktur + 1;
				$idfaktur = str_pad($string, 3, '0', STR_PAD_LEFT);
			}

			else {
				$idfaktur = '001';
			}

			$nota = 'FB' . $month . $year . '/' . $request->cab . '/SC-' .  $idfaktur;
			/*dd($data['nofp']);*/

			return response()->json(['nota' => $nota]);
		}

		public function detailbiayapenerus($id){
			$cari_agen 	 = DB::table('faktur_pembelian')
						 ->where('fp_idfaktur',$id)
						 ->first();

			if ($cari_agen->fp_jenisbayar == 6) {
				$cari 	 = DB::table('faktur_pembelian')
						 ->join('biaya_penerus','bp_faktur','=','fp_nofaktur')
						 ->where('fp_idfaktur',$id)
						 ->get();
				if($cari[0]->bp_tipe_vendor == 'AGEN'){
						$cari_fp 	 = DB::table('faktur_pembelian')
									 ->join('biaya_penerus','bp_faktur','=','fp_nofaktur')
									 ->join('agen','bp_kode_vendor','=','kode')
									 ->where('fp_idfaktur',$id)
									 ->get();
					}else{
						$cari_fp 	 = DB::table('faktur_pembelian')
									 ->join('biaya_penerus','bp_faktur','=','fp_nofaktur')
									 ->join('vendor','bp_kode_vendor','=','kode')
									 ->where('fp_idfaktur',$id)
									 ->get();
					}

					$cari_bpd 	 = DB::table('biaya_penerus_dt')
								 ->join('delivery_order','nomor','=','bpd_pod')
								 ->join('kota','id_kota_asal','=','id')
								 ->where('bpd_bpid',$cari_fp[0]->bp_id)
								 ->orderBy('bpd_bpdetail')
								 ->get();

					$kota_tujuan = DB::table('biaya_penerus_dt')
								 ->join('delivery_order','nomor','=','bpd_pod')
								 ->join('kota','id_kota_tujuan','=','id')
								 ->where('bpd_bpid',$cari_fp[0]->bp_id)
								 ->orderBy('bpd_bpdetail')
								 ->get();

					// return $cari_bpd;
				
					$pdf = PDF::loadView('purchase/fatkur_pembelian/detailBiayaPenerus',compact('cari_fp','cari_bpd','kota_tujuan'))
								->setPaper('a4','potrait');
					return $pdf->stream('detail-biaya-penerus-'.$cari_fp[0]->fp_nofaktur.'.pdf');
			}elseif ($cari_agen->fp_jenisbayar == 7) {
				$cari_fp 	 = DB::table('faktur_pembelian')
									 ->join('pembayaran_outlet','pot_faktur','=','fp_nofaktur')
									 ->join('agen','pot_kode_outlet','=','kode')
									 ->where('fp_idfaktur',$id)
									 ->get();

				$cari_bpd 	 = DB::table('pembayaran_outlet_dt')
								 ->join('delivery_order','nomor','=','potd_pod')
								 ->join('kota','id_kota_asal','=','id')
								 ->where('potd_potid',$cari_fp[0]->pot_id)
								 ->orderBy('potd_potdetail')
								 ->get();

				$kota_tujuan = DB::table('pembayaran_outlet_dt')
								 ->join('delivery_order','nomor','=','potd_pod')
								 ->join('kota','id_kota_tujuan','=','id')
								 ->where('potd_potid',$cari_fp[0]->pot_id)
								 ->orderBy('potd_potdetail')
								 ->get();

				$pdf = PDF::loadView('purchase/fatkur_pembelian/detailBiayaPenerus',compact('cari_fp','cari_bpd','kota_tujuan'))
								->setPaper('a4','potrait');
				return $pdf->stream('detail-biaya-penerus-'.$cari_fp[0]->fp_nofaktur.'.pdf');
				
			}elseif ($cari_agen->fp_jenisbayar == 9) {

				$cari_fp 	 = DB::table('faktur_pembelian')
									 ->join('pembayaran_subcon','pb_faktur','=','fp_nofaktur')
									 ->join('subcon','pb_kode_subcon','=','kode')
									 ->where('fp_idfaktur',$id)
									 ->get();

				$cari_bpd 	 = DB::table('pembayaran_subcon_dt')
								 ->join('delivery_order','nomor','=','pbd_resi')
								 ->join('kota','id_kota_asal','=','id')
								 ->where('pbd_pb_id',$cari_fp[0]->pb_id)
								 ->orderBy('pbd_pb_dt')
								 ->get();

				$kota_tujuan = DB::table('pembayaran_subcon_dt')
								 ->join('delivery_order','nomor','=','pbd_resi')
								 ->join('kota','id_kota_tujuan','=','id')
								 ->where('pbd_pb_id',$cari_fp[0]->pb_id)
								 ->orderBy('pbd_pb_dt')
								 ->get();

				$pdf = PDF::loadView('purchase/fatkur_pembelian/detailBiayaPenerus',compact('cari_fp','cari_bpd','kota_tujuan'))
								->setPaper('a4','potrait');
				return $pdf->stream('detail-biaya-penerus-'.$cari_fp[0]->fp_nofaktur.'.pdf');
			}
					
		}

		public function buktibiayapenerus(request $request){


			$cari_fp	= DB::table('faktur_pembelian')			
						 ->join('cabang','kode','=','fp_comp')
						 ->join('biaya_penerus','bp_faktur','=','fp_nofaktur')
						 ->join('agen','bp_kode_vendor','=','agen.kode')
						 ->where('fp_nofaktur','=',$request->id)
						 ->get();

			$cari_bpd 	 = DB::table('biaya_penerus_dt')
						 ->join('delivery_order','nomor','=','bpd_pod')
						 ->join('kota','id_kota_asal','=','id')
						 ->where('bpd_bpid',$cari_fp[0]->bp_id)
						 ->orderBy('bpd_bpdetail')
						 ->get();

		    $cari_asal   = DB::table('biaya_penerus_dt')
						 ->join('delivery_order','nomor','=','bpd_pod')
						 ->select('id_kota_asal')
						 ->where('bpd_bpid',$cari_fp[0]->bp_id)
						 ->orderBy('bpd_bpdetail')
						 ->get();

			for ($i=0; $i < count($cari_asal); $i++) { 

				$cari_asal_2[$i] = $cari_asal[$i]->id_kota_asal; 
			}
			if (isset($cari_asal_2)) {
			    $unik_asal = array_unique($cari_asal_2);

			    for ($i=0; $i < count($unik_asal); $i++) { 
					for ($a=0; $a < count($cari_bpd); $a++) { 
						if($cari_bpd[$a]->id_kota_asal==$unik_asal[$i]){
							${$unik_asal[$i]}[$a] = $cari_bpd[$a]->bpd_nominal;
						}
					}
				}

				for ($i=0; $i < count($unik_asal); $i++) { 
					${'total'.$unik_asal[$i]} = array_sum(${$unik_asal[$i]});
				}
				
				for ($i=0; $i < count($unik_asal); $i++) { 
					 $harga_array[$i] = ${'total'.$unik_asal[$i]};
				}
				for ($i=0; $i < count($harga_array); $i++) { 
					 $harga_array[$i] = round($harga_array[$i]);
				}
				// return $harga_array;
				$total_harga=array_sum($harga_array);

				$terbilang = $this->terbilang($total_harga,$style=3);

				if(count($harga_array)<10){
					$td = 10-count($harga_array);
					for ($i=0; $i < $td; $i++) {  
						if(!isset($harga_array[$i])){
							$harga_array[$i] = ' ';
						}
					}
				}
			}
			return view('purchase/fatkur_pembelian/buktiBiayaPenerus',compact('cari_fp','harga_array','total_harga','terbilang'));
		}

		public function cari_note(request $request){
		$term = $request->term;

		$results = array();
	       $queries = DB::table('master_note')
	            ->where('mn_keterangan', 'like', '%'.$term.'%')
	            ->take(10)->get();

	        if ($queries == null){
	            $results[] = [ 'id' => null, 'label' => 'Tidak ditemukan data terkait'];
	        } else {

	            foreach ($queries as $query)
	            {
	                $results[] = [ 'id' => $query->mn_keterangan, 'label' => $query->mn_keterangan];
	            }
	        }

	        return Response::json($results);
		}

		public function save_outlet(request $request){
   		return DB::transaction(function() use ($request) {  
			
			$year =Carbon::now()->format('Y'); 
			$month =Carbon::now()->format('m'); 

			$request->total_tarif = filter_var($request->total_tarif, FILTER_SANITIZE_NUMBER_FLOAT);
			$request->total_tarif = $request->total_tarif/100;

			$request->total_komisi_outlet = filter_var($request->total_komisi_outlet, FILTER_SANITIZE_NUMBER_FLOAT);
			$request->total_komisi_outlet = $request->total_komisi_outlet/100;

			$request->total_komisi_tambahan = filter_var($request->total_komisi_tambahan, FILTER_SANITIZE_NUMBER_FLOAT);
			$request->total_komisi_tambahan = $request->total_komisi_tambahan/100;

			$request->total_all_komisi = filter_var($request->total_all_komisi, FILTER_SANITIZE_NUMBER_FLOAT);
			$request->total_all_komisi = $request->total_all_komisi/100;

			$tgl = explode('-',$request->rangepicker);
			$tgl[0] = str_replace('/', '-', $tgl[0]);
			$tgl[1] = str_replace('/', '-', $tgl[1]);
			$tgl[0] = str_replace(' ', '', $tgl[0]);
			$tgl[1] = str_replace(' ', '', $tgl[1]);
			
			$cari_id = DB::table('faktur_pembelian')
		     			->max('fp_idfaktur');

		     $id = DB::table('form_tt')
					->max('tt_idform');
			 if($id == null){
			 	$id=1;
			 }else{
			 	$id+=1;
			 }



			 if($cari_id == null){
			 	$cari_id=1;
			 }else{
			 	$cari_id+=1;
			 }
			$akun_hutang = DB::table('agen')
							 ->where('kode',$request->selectOutlet)
							 ->first();

			$akun_hutang = substr($akun_hutang->acc_hutang,0, 4);

			$cari = DB::table('d_akun')->where('id_akun','like',$akun_hutang.'%')->where('kode_cabang',$request->cabang)->first();

			$akun_hutang = $cari->id_akun;
		   	
			$save = DB::table('faktur_pembelian')->insert([
								'fp_idfaktur'		=> $cari_id,
								'fp_nofaktur'		=> $request->nofaktur,
								'fp_tgl'			=> Carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y-m-d'),
								'fp_jenisbayar' 	=> 7,
								'fp_comp'			=> $request->cabang,
								'created_at'		=> Carbon::now(),
								'fp_keterangan'		=> $request->note,
								'fp_status'			=> 'Released',
								'fp_pending_status'	=> 'APPROVED',
								'fp_supplier'		=> $request->selectOutlet,
								'fp_netto'			=> round($request->total_all_komisi,2),
								'fp_sisapelunasan'  => round($request->total_all_komisi,2),
								'fp_edit'			=> 'UNALLOWED',
								'fp_jatuhtempo'		=> carbon::parse(str_replace('/', '-', $request->jatuh_tempo_outlet))->format('Y-m-d'),
								'fp_acchutang'      => $akun_hutang,
								'created_by'  		=> Auth::user()->m_name,
								'updated_by'  		=> Auth::user()->m_name,
								]);

			

			$cari_potid = DB::table('pembayaran_outlet')
		     			->max('pot_id');

		     if($cari_potid == null){
		     	$cari_potid = 1;
		     }else{
		     	$cari_potid+=1;
		     }
		     

			$save_pot = DB::table('pembayaran_outlet')
						  ->insert([
						  	'pot_id' 	 				=> $cari_potid,
						  	'pot_faktur' 				=> $request->nofaktur,
						  	'pot_status' 				=> 'Released',
						  	'pot_kode_outlet'			=> $request->selectOutlet,
						  	'pot_keterangan'			=> $request->note,
						  	'pot_total_tarif'			=> round($request->total_tarif,2),
							'pot_total_komisi_outlet'	=> round($request->total_komisi_outlet,2),
							'pot_total_komisi_tambah'	=> round($request->total_komisi_tambahan,2),
							'pot_total_komisi'			=> round($request->total_all_komisi,2),
						  	'pot_tgl'					=> Carbon::parse($tgl[0])->format('Y-m-d'),
						  	'pot_tgl_kembali'			=> Carbon::parse($tgl[1])->format('Y-m-d'),
						  	'updated_at'				=> Carbon::now(),
						  	'created_at'				=> Carbon::now()
						  ]);
			$pot_dt = 0;
			// dd($request->no_resi);
			for ($i=0; $i < count($request->chck); $i++) { 
				if ($request->chck[$i] == 'on') {
					$potd_id = DB::table('pembayaran_outlet_dt')
		     			->max('potd_id');

				     if($potd_id == null){
				     	$potd_id = 1;
				     }else{
				     	$potd_id+=1;
				     }

				     $pod = DB::table('delivery_order')
				     		  ->where('nomor',$request->no_resi[$i])
				     		  ->first();

					$save_potdt = DB::table('pembayaran_outlet_dt')
									->insert([
										'potd_id'				=> $potd_id,
										'potd_potid'			=> $cari_potid,
										'potd_potdetail'		=> $pot_dt+1,
										'potd_pod'				=> $request->no_resi[$i],
										'potd_tgl'				=> $pod->tanggal,
										'potd_tarif_resi'		=> $request->tarif[$i],
										'potd_komisi'			=> $request->komisi[$i],
										'potd_komisi_tambahan'	=> $request->komisi_tambahan[$i],
										'potd_komisi_total'		=> $request->total_komisi[$i],
										'updated_at'			=> Carbon::now(),
						  				'created_at'			=> Carbon::now()


									]);
					$pot_dt += 1;
				}
			}

			$tt = DB::table('form_tt_d')
								->where('ttd_detail',$request->dt_tt)
								->where('ttd_id',$request->id_tt)
								->where('ttd_invoice',$request->invoice_tt)
								->update([
									'ttd_faktur' => $request->nofaktur,
								]);

			// //JURNAL



			$cari_dt=DB::table('pembayaran_outlet_dt')		
						 ->join('delivery_order','potd_pod','=','nomor')
						 ->where('potd_potid','=',$cari_potid)
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
							${$unik_asal[$i]}[$a] = $cari_dt[$a]->potd_komisi_total;
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
			$jenis_bayar = DB::table('jenisbayar')
							 ->where('idjenisbayar',7)
							 ->first();

			$save_jurnal = d_jurnal::create(['jr_id'		=> $id_jurnal,
												'jr_year'   => carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y'),
												'jr_date' 	=> carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y-m-d'),
												'jr_detail' => $jenis_bayar->jenisbayar,
												'jr_ref'  	=> $request->nofaktur,
												'jr_note'  	=> 'PEMBAYARAN OUTLET '.strtoupper($request->note),
												'jr_insert' => carbon::now(),
												'jr_update' => carbon::now(),

												]);


			$akun 	  = [];
			$akun_val = [];

			array_push($akun, $akun_hutang);
			array_push($akun_val, $request->total_all_komisi);

			for ($i=0; $i < count($jurnal); $i++) { 

				$id_akun = DB::table('d_akun')
								  ->where('id_akun','like','5317' . '%')
								  ->where('kode_cabang',$jurnal[$i]['asal'])
								  ->first();

				if ($id_akun == null) {
					$id_akun = DB::table('d_akun')
								  ->where('id_akun','like','5317%')
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
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->note);
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'K';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->note);
					}
				}else if (substr($akun[$i],0, 1)>2) {

					if ($cari_coa->akun_dka == 'D') {
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'D';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->note);
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'K';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->note);
					}
				}
			}

			$jurnal_dt = d_jurnal_dt::insert($data_akun);
			$lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();
			// dd($lihat);

			return response()->json(['id'=>$cari_id]);
		});
		}

		public function update_outlet(request $request){
   		return DB::transaction(function() use ($request) {  

			// dd($request->all());
			$cari_nota  = DB::table('faktur_pembelian')
							->where('fp_idfaktur',$request->id)
							->first();
			$cari_pot  = DB::table('pembayaran_outlet')
							->where('pot_faktur',$cari_nota->fp_nofaktur)
							->first();
			$request->total_tarif = filter_var($request->total_tarif, FILTER_SANITIZE_NUMBER_FLOAT)/100;

			$request->total_komisi_outlet = filter_var($request->total_komisi_outlet, FILTER_SANITIZE_NUMBER_FLOAT)/100;

			$request->total_komisi_tambahan = filter_var($request->total_komisi_tambahan, FILTER_SANITIZE_NUMBER_FLOAT)/100;

			$request->total_all_komisi = filter_var($request->total_all_komisi, FILTER_SANITIZE_NUMBER_FLOAT)/100;

			$tgl = explode('-',$request->rangepicker);
			$tgl[0] = str_replace('/', '-', $tgl[0]);
			$tgl[1] = str_replace('/', '-', $tgl[1]);
			$tgl[0] = str_replace(' ', '', $tgl[0]);
			$tgl[1] = str_replace(' ', '', $tgl[1]);

			$akun_hutang = DB::table('agen')
							 ->where('kode',$request->selectOutlet)
							 ->first();

			$akun_hutang = substr($akun_hutang->acc_hutang,0, 4);

			$cari = DB::table('d_akun')->where('id_akun','like',$akun_hutang.'%')->where('kode_cabang',$request->cabang)->first();

			$akun_hutang = $cari->id_akun;


			$update_pot = DB::table('faktur_pembelian')
							->where('fp_nofaktur',$cari_nota->fp_nofaktur)
							->update([
							  	'fp_idfaktur'		=> $request->id,
								'fp_nofaktur'		=> $request->nofaktur,
								'fp_tgl'			=> Carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y-m-d'),
								'fp_jenisbayar' 	=> 7,
								'fp_comp'			=> $request->cabang,
								'updated_at'		=> Carbon::now(),
								'fp_keterangan'		=> $request->note,
								'fp_status'			=> 'Released',
								'fp_pending_status'	=> 'APPROVED',
								'fp_supplier'		=> $request->selectOutlet,
								'fp_netto'			=> round($request->total_all_komisi,2),
								'fp_sisapelunasan'  => round($request->total_all_komisi,2),
								'fp_edit'			=> 'UNALLOWED',
								'fp_jatuhtempo'		=> carbon::parse(str_replace('/', '-', $request->jatuh_tempo_outlet))->format('Y-m-d'),
							
								'fp_acchutang'      => $akun_hutang,
								'updated_by'  		=> Auth::user()->m_name,
							]);

			$update_pot = DB::table('pembayaran_outlet')
							->where('pot_faktur',$cari_nota->fp_nofaktur)
							->update([
							  	'pot_kode_outlet'			=> $request->selectOutlet,
							  	'pot_keterangan'			=> $request->note,
							  	'pot_total_tarif'			=> round($request->total_tarif,2),
							  	'pot_total_komisi_outlet'	=> round($request->total_komisi_outlet,2),
							  	'pot_total_komisi_tambah'	=> round($request->total_komisi_tambahan,2),
							  	'pot_total_komisi'			=> round($request->total_all_komisi,2),
							  	'pot_tgl'					=> Carbon::parse($tgl[0])->format('Y-m-d'),
							  	'pot_tgl_kembali'			=> Carbon::parse($tgl[1])->format('Y-m-d'),
							  	'updated_at'				=> Carbon::now(),
							]);
			$delete_potd = DB::table('pembayaran_outlet_dt')
							 ->where('potd_potid',$cari_pot->pot_id)
							 ->delete();

			$pot_dt = 0;
			for ($i=0; $i < count($request->chck); $i++) { 
				if ($request->chck[$i] == 'on') {
					$potd_id = DB::table('pembayaran_outlet_dt')
		     			->max('potd_id');

				     if($potd_id == null){
				     	$potd_id = 1;
				     }else{
				     	$potd_id+=1;
				     }
				    
					$save_potdt = DB::table('pembayaran_outlet_dt')
									->insert([
										'potd_id'				=> $potd_id,
										'potd_potid'			=> $cari_pot->pot_id,
										'potd_potdetail'		=> $pot_dt+1,
										'potd_pod'				=> $request->no_resi[$i],
										'potd_tgl'				=> $request->tgl[$i],
										'potd_tarif_resi'		=> $request->tarif[$i],
										'potd_komisi'			=> $request->komisi[$i],
										'potd_komisi_tambahan'	=> $request->komisi_tambahan[$i],
										'potd_komisi_total'		=> $request->total_komisi[$i],
										'updated_at'			=> Carbon::now(),
						  				'created_at'			=> Carbon::now()


									]);
					$pot_dt += 1;
				}
			}
			$tt_upd = DB::table('form_tt_d')
					  ->where('ttd_faktur',$request->nofaktur)
					  ->update([
					  	'ttd_faktur'=>null
					  ]);

			$tt = DB::table('form_tt_d')
						->where('ttd_detail',$request->dt_tt)
						->where('ttd_id',$request->id_tt)
						->where('ttd_invoice',$request->invoice_tt)
						->update([
							'ttd_faktur' => $request->nofaktur,
						]);

			$status = DB::table('faktur_pembelian')
						->where('fp_nofaktur',$cari_nota->fp_nofaktur)
						->first();


			// //JURNAL



			$cari_dt=DB::table('pembayaran_outlet_dt')		
						 ->join('delivery_order','potd_pod','=','nomor')
						 ->where('potd_potid','=',$cari_pot->pot_id)
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
							${$unik_asal[$i]}[$a] = $cari_dt[$a]->potd_komisi_total;
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
							   ->where('jr_ref',$request->nofaktur)
							   ->delete();
			$id_jurnal=d_jurnal::max('jr_id')+1;
			$jenis_bayar = DB::table('jenisbayar')
							 ->where('idjenisbayar',7)
							 ->first();

			$save_jurnal = d_jurnal::create(['jr_id'		=> $id_jurnal,
												'jr_year'   => carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y'),
												'jr_date' 	=> carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y-m-d'),
												'jr_detail' => $jenis_bayar->jenisbayar,
												'jr_ref'  	=> $request->nofaktur,
												'jr_note'  	=> 'PEMBAYARAN OUTLET '.strtoupper($request->note),
												'jr_insert' => carbon::now(),
												'jr_update' => carbon::now(),
												]);


			$akun 	  = [];
			$akun_val = [];

			array_push($akun, $akun_hutang);
			array_push($akun_val, $request->total_all_komisi);

			for ($i=0; $i < count($jurnal); $i++) { 

				$id_akun = DB::table('d_akun')
								  ->where('id_akun','like','5317' . '%')
								  ->where('kode_cabang',$jurnal[$i]['asal'])
								  ->first();

				if ($id_akun == null) {
					$id_akun = DB::table('d_akun')
								  ->where('id_akun','like','5317%')
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
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->note);
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'K';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->note);
					}
				}else if (substr($akun[$i],0, 1)>2) {

					if ($cari_coa->akun_dka == 'D') {
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'D';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->note);
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= filter_var($akun_val[$i],FILTER_SANITIZE_NUMBER_INT);
						$data_akun[$i]['jrdt_statusdk'] = 'K';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->note);
					}
				}
			}

			$jurnal_dt = d_jurnal_dt::insert($data_akun);
			$lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();
			// dd($lihat);


			return response()->json(['status'=>$status->fp_pending_status]);
		});
		}

		public function getpembayaransubcon(){

			$date = Carbon::now()->format('d/m/Y');

			$agen = DB::table('agen')
					  ->get();

			$akun = DB::table('master_persentase')
					  ->get();

			$pajak = DB::table("pajak")
						->get();
			$subcon = DB::table('subcon')
					  ->get();
			$akun_biaya = DB::table('d_akun')
					  ->where('id_akun','like','5'.'%')
					  ->get();
			$kota   = DB::table('kota')
					->get();

			return view('purchase/fatkur_pembelian/formSubcon',compact('date','kota','subcon','akun_biaya','akun','pajak'));
		}

		public function cari_subcon(request $request){
			
			$data = DB::select("SELECT res1.* from 
									   (SELECT kontrak_subcon.*,kontrak_subcon_dt.*,subcon.* 
									   from kontrak_subcon 
									   inner join kontrak_subcon_dt
									   on ks_id = ksd_ks_id
									   inner join subcon 
									   on ks_nama = kode) as res1
									   where res1.ksd_asal = '$request->asal'
									   and res1.ksd_tujuan = '$request->tujuan'
									   and res1.ks_cabang = '001'");

			if ($data != null) {
				return Response()->json([
								 'status'=>1,
								 'data'=>$data
							   ]);
			}else{
				return Response()->json([
								 'status'=>0
							   ]);
			}
			
		}

		public function cari_kontrak(request $request){
			// dd($request);
			$subcon_dt = DB::SELECT("SELECT kontrak_subcon.*,kontrak_subcon_dt.*, asal.nama as asal ,asal.id as id_asal,
						 				tujuan.nama as tujuan, tujuan.id as id_tujuan,
						 				angkutan.kode as kode_angkutan, angkutan.nama as angkutan
									    from kontrak_subcon 
									    inner join kontrak_subcon_dt
									    on ksd_ks_id = ks_id
									    inner join 
									    (SELECT nama,id from kota) as asal
									    on asal.id = ksd_asal
									    inner join 
							 	 	    (SELECT nama,id from kota) as tujuan
								 	    on tujuan.id = ksd_tujuan
								 	    inner join
								 	    (SELECT kode,nama from tipe_angkutan) as angkutan
								 	    on angkutan.kode  = ksd_angkutan
								 	    where ks_id = '$request->id'
								 	    and kontrak_subcon_dt.ksd_asal = '$request->asal'
									    and kontrak_subcon_dt.ksd_tujuan = '$request->tujuan'");

			return view('purchase/fatkur_pembelian/tabelModalSubcon',compact('subcon_dt'));

		}

	public function pilih_kontrak(request $request){

		$kontrak = DB::table('kontrak_subcon_dt')
					 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
					 ->join('tipe_angkutan','kode','=','ksd_angkutan')
					 ->where('ksd_id',$request->id)
					 ->orderBy('ksd_ks_dt','ASC')
					 ->get();
		$jenis_tarif = DB::table('jenis_tarif')
						 ->get();
		for ($i=0; $i < count($jenis_tarif); $i++) { 
			for ($a=0; $a < count($kontrak); $a++) { 
				if ($jenis_tarif[$i]->jt_id == $kontrak[$a]->ksd_jenis_tarif) {
					$kontrak[$a]->jenis_tarif = $jenis_tarif[$i]->jt_nama_tarif;
				}
			}
		}
		$asal = DB::table('kontrak_subcon_dt')
					 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
					 ->join('kota','id','=','ksd_asal')
					 ->select('nama as asal','ksd_asal')
					 ->where('ksd_id',$request->id)
					 ->orderBy('ksd_ks_dt','ASC')
					 ->get();

		$tujuan = DB::table('kontrak_subcon_dt')
					 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
					 ->join('kota','id','=','ksd_tujuan')
					 ->select('nama as tujuan','ksd_tujuan')
					 ->where('ksd_id',$request->id)
					 ->orderBy('ksd_ks_dt','ASC')
					 ->get();


		$fix=[];
		for ($i=0; $i < count($kontrak); $i++) { 
			$fix[$i]['ksd_id'] = $kontrak[$i]->ksd_id;
			$fix[$i]['ks_nama'] = $kontrak[$i]->ks_nama;
			$fix[$i]['ksd_dt'] = $kontrak[$i]->ksd_ks_dt;
			$fix[$i]['ksd_nota'] = $kontrak[$i]->ks_nota;
			$fix[$i]['ksd_harga'] = number_format($kontrak[$i]->ksd_harga,2,',','.'	); 
			$fix[$i]['ksd_harga2'] = $kontrak[$i]->ksd_harga; 
			$fix[$i]['ksd_jenis_tarif'] = $kontrak[$i]->ksd_jenis_tarif;
			$fix[$i]['jenis_tarif'] = $kontrak[$i]->jenis_tarif;
			$fix[$i]['ksd_asal'] = $asal[$i]->asal;
			$fix[$i]['ksd_tujuan'] = $tujuan[$i]->tujuan;
			$fix[$i]['no_asal'] = $asal[$i]->ksd_asal;
			$fix[$i]['no_tujuan'] = $tujuan[$i]->ksd_tujuan;
			$fix[$i]['ksd_angkutan'] = $kontrak[$i]->nama;
			$fix[$i]['ksd_id_angkutan'] = $kontrak[$i]->kode;
		}
			return Response()->json([
								'subcon_dt' => $fix
							   ]);
	}

	public function pilih_kontrak_all(request $request)
	{
		
		$kontrak = DB::table('kontrak_subcon_dt')
				 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
				 ->join('tipe_angkutan','kode','=','ksd_angkutan')
				 ->where('ksd_id',$request->d_ksd_id)
				 ->orderBy('ksd_ks_dt','ASC')
				 ->get();

		$jenis_tarif = DB::table('jenis_tarif')
						 ->get();
		for ($i=0; $i < count($jenis_tarif); $i++) { 
			for ($a=0; $a < count($kontrak); $a++) { 
				if ($jenis_tarif[$i]->jt_id == $kontrak[$a]->ksd_jenis_tarif) {
					$kontrak[$a]->jenis_tarif = $jenis_tarif[$i]->jt_nama_tarif;
				}
			}
		}

		$asal = DB::table('kontrak_subcon_dt')
					 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
					 ->join('kota','id','=','ksd_asal')
					 ->select('nama as asal','ksd_asal')
					 ->where('ksd_id',$request->d_ksd_id)
					 ->orderBy('ksd_ks_dt','ASC')
					 ->get();

		$tujuan = DB::table('kontrak_subcon_dt')
					 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
					 ->join('kota','id','=','ksd_tujuan')
					 ->select('nama as tujuan','ksd_tujuan')
					 ->where('ksd_id',$request->d_ksd_id)
					 ->orderBy('ksd_ks_dt','ASC')
					 ->get();


		$do     = DB::table('delivery_order')
					->where('nomor',$request->d_resi_subcon)
					->first();
		if ($do == null) {
			return response()->json(['status'=>0,'pesan'=>'Nomor Do Untuk Faktur Ini Telah Dihapus Harap Menghubungi Pihak Terkait']);
		}

		$jenis_tarif = DB::table('jenis_tarif')
						 ->get();

		$kota = DB::table('kota')
			  ->get();

		$tipe_angkutan = DB::table('tipe_angkutan')
			  ->get();

		for ($i=0; $i < count($jenis_tarif); $i++) { 

			if ((integer)$do->jenis_tarif == $jenis_tarif[$i]->jt_id) {
				$do->nama_tarif = $jenis_tarif[$i]->jt_nama_tarif;
			}
		}


		for ($i=0; $i < count($kota); $i++) { 

			if ((integer)$do->id_kota_asal == $kota[$i]->id ) {
				$do->nama_asal = $kota[$i]->nama;
			}

			if ((integer)$do->id_kota_tujuan == $kota[$i]->id ) {
				$do->nama_tujuan = $kota[$i]->nama;
			}

		}

		for ($i=0; $i < count($tipe_angkutan); $i++) { 
			if ((integer)$do->kode_tipe_angkutan == $tipe_angkutan[$i]->kode) {
				$do->nama_angkutan = $tipe_angkutan[$i]->nama;
			}
		}

		$do->tanggal = carbon::parse($do->tanggal)->format('d/m/Y');


		$fix=[];
		for ($i=0; $i < count($kontrak); $i++) { 
			$fix[$i]['ksd_id'] = $kontrak[$i]->ksd_id;
			$fix[$i]['ks_nama'] = $kontrak[$i]->ks_nama;
			$fix[$i]['ksd_dt'] = $kontrak[$i]->ksd_ks_dt;
			$fix[$i]['ksd_nota'] = $kontrak[$i]->ks_nota;
			$fix[$i]['ksd_harga'] = number_format($kontrak[$i]->ksd_harga,2,',','.'	); 
			$fix[$i]['ksd_harga2'] = $kontrak[$i]->ksd_harga; 
			$fix[$i]['ksd_jenis_tarif'] = $kontrak[$i]->ksd_jenis_tarif;
			$fix[$i]['ksd_asal'] = $asal[$i]->asal;
			$fix[$i]['jenis_tarif'] = $kontrak[$i]->jenis_tarif;
			$fix[$i]['ksd_tujuan'] = $tujuan[$i]->tujuan;
			$fix[$i]['no_asal'] = $asal[$i]->ksd_asal;
			$fix[$i]['no_tujuan'] = $tujuan[$i]->ksd_tujuan;
			$fix[$i]['ksd_angkutan'] = $kontrak[$i]->nama;
			$fix[$i]['ksd_id_angkutan'] = $kontrak[$i]->kode;
		}
			return Response()->json([
								'kontrak' => $fix,
								'do' => $do,
							   ]);
	}

	public function subcon_save(request $request){

   		return DB::transaction(function() use ($request) {  
	
			$valid = DB::table('faktur_pembelian')
						 ->where('fp_nofaktur',$request->nofaktur)
						 ->first();

		
			$nota = $request->nofaktur;



			$tgl_biaya_head = carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y-m-d');

			$total_subcon = filter_var($request->total_subcon, FILTER_SANITIZE_NUMBER_FLOAT)/100;


			$cari_id = DB::table('faktur_pembelian')
						 ->max('fp_idfaktur')+1;

			$acc_hutang = DB::table('subcon')
							->where('kode',$request->nama_subcon)
							->first();
			
			$hutang = substr($acc_hutang->acc_code,0, 4);

			$akun_hutang = DB::table('d_akun')
								  ->where('id_akun','like',$hutang . '%')
								  ->where('kode_cabang',$request->cabang)
								  ->first();

			$fp_jumlah   = filter_var($request->total_kotor_subcon,FILTER_SANITIZE_NUMBER_FLOAT)/100;
			$fp_dpp      	  = filter_var($request->total_dpp_subcon,FILTER_SANITIZE_NUMBER_FLOAT)/100;
			$fp_ppn      	  = filter_var($request->ppn_subcon,FILTER_SANITIZE_NUMBER_FLOAT)/100;
			$fp_pph      	  = filter_var($request->pph_subcon,FILTER_SANITIZE_NUMBER_FLOAT)/100;
			$fp_netto 		  = filter_var($request->total_netto,FILTER_SANITIZE_NUMBER_FLOAT)/100;
			if ($request->jenis_pph_subcon == '') {
				$fp_jenispph = 0;
			}else{
				$fp_jenispph = $request->jenis_pph_subcon;
			}

			if ($request->persen_pph_subcon == '') {
				$fp_nilaipph = 0;
			}else{
				$fp_nilaipph = $request->persen_pph_subcon;
			}



			$save = DB::table('faktur_pembelian')->insert([
						'fp_idfaktur'		=> $cari_id,
						'fp_nofaktur'		=> $nota,
						'fp_tgl'			=> $tgl_biaya_head,
						'fp_jenisbayar' 	=> 9,
						'fp_comp'			=> $request->cabang,
						'created_at'		=> Carbon::now(),
						'updated_at'		=> Carbon::now(),
						'fp_keterangan'		=> strtoupper($request->keterangan_subcon),
						'fp_status'			=> 'Released',
						'fp_noinvoice'		=> $request->invoice_subcon,
						'fp_pending_status'	=> 'PENDING',
						'fp_supplier'		=> $request->nama_subcon,
						'fp_netto'			=> $total_subcon,
						'fp_sisapelunasan'  => $total_subcon,
						'fp_edit'			=> 'UNALLOWED',
						'fp_jatuhtempo'		=> carbon::parse(str_replace('/', '-', $request->tempo_subcon))->format('Y-m-d'),
						'fp_acchutang'		=> $akun_hutang->id_akun,
						'created_by'  		=> Auth::user()->m_name,
						'updated_by'  		=> Auth::user()->m_name,
						'fp_jumlah'     	=> $fp_jumlah,
						'fp_netto' 	  		=> $fp_netto,
						'fp_sisapelunasan' 	=> $fp_netto,
						'fp_nilaipph'	  	=> $fp_nilaipph,
						'fp_dpp'		  	=> $fp_dpp,
						'fp_jenisppn'  		=> $request->jenis_ppn_subcon,
						'fp_inputppn'  		=> $request->persen_ppn_subcon,
						'fp_ppn'		  	=> $fp_ppn,
						'fp_jenispph'	  	=> $fp_jenispph,
						'fp_nilaipph'	  	=> $request->persen_pph_subcon,
						'fp_pph'		  	=> $fp_pph,
					]);

			$id_faktur_pajak = DB::table("fakturpajakmasukan")->max('fpm_id')+1;
			$faktur_pajak = DB::table('fakturpajakmasukan')
							  ->insert([
							  	'fpm_id'		=> $id_faktur_pajak,
							  	'fpm_nota'		=> $request->faktur_pajak_penerus,
							  	'fpm_tgl'		=> carbon::parse($request->tanggal_pajak_penerus)->format('Y-m-d'),
							  	'fpm_masapajak'	=> carbon::parse($request->tanggal_pajak_penerus)->format('Y-m-d'),
							  	'fpm_dpp'		=> $fp_dpp,
							  	'fpm_hasilppn'	=> $fp_ppn,
							  	'fpm_inputppn'	=> $fp_ppn,
							  	'fpm_netto'		=> $fp_netto+$fp_pph,
							  	'fpm_idfaktur'	=> $cari_id,
							  	'created_at'    => carbon::now(),
							  	'updated_at'    => carbon::now(),
							  ]);

			$id_pb = DB::table('pembayaran_subcon')
					 ->max('pb_id');

			if ($id_pb == null) {
				$id_pb = 1;
			}else{
				$id_pb += 1;
			}

			$save = DB::table('pembayaran_subcon')->insert([
						  'pb_id'  			  => $id_pb,
						  'pb_faktur'  		  => $request->nofaktur,
						  'pb_status'  		  => 'Released',
						  'pb_kode_subcon'    => $request->nama_subcon,
						  'pb_keterangan' 	  => strtoupper($request->keterangan_subcon),
						  'updated_at' 		  => Carbon::now(),
						  'created_at' 	      => Carbon::now(),
						  'pb_acc'	      	  => $akun_hutang->id_akun,
						  'pb_csf'	 		  => $akun_hutang->id_akun,
					]);

			$pending = [];

			for ($i=0; $i < count($request->d_resi_subcon); $i++) { 
				$id_pbd = DB::table('pembayaran_subcon_dt')
					 ->max('pbd_id');

				if ($id_pbd == null) {
					$id_pbd = 1;
				}else{
					$id_pbd += 1;
				}

				$cari_do = DB::table('delivery_order')
							 ->where('nomor',$request->d_resi_subcon[$i])
							 ->first();

				$persen = DB::table('subcon')
							->where('kode',$request->nama_subcon)
							->first()->persen;

				$hasil_persen = ($persen/100)*$cari_do->total_net;
				if ($request->d_harga_subcon[$i] > $hasil_persen) {
					$pending[$i] = 'PENDING';
				}else{
					$pending[$i] = 'APPROVED';
				}

				$save = DB::table('pembayaran_subcon_dt')->insert([
							  'pbd_id'   		 => $id_pbd,
							  'pbd_pb_id'   	 => $id_pb,
							  'pbd_ksd_id'   	 => $request->d_ksd_id[$i],
							  'pbd_pb_dt'   	 => $i+1,
							  'pbd_resi'  	 	 => $request->d_resi_subcon[$i],
							  'pbd_jumlah'    	 => $request->d_jumlah_subcon[$i],
							  'pbd_tarif_resi' 	 => $cari_do->total_net,
							  'pbd_keterangan' 	 => $request->d_memo_subcon[$i],
							  'updated_at'     	 => Carbon::now(),
							  'created_at'     	 => Carbon::now(),
							  'pbd_tarif_harga'  => $request->d_harga_subcon[$i],
							  'pbd_acc'	      	 => $request->d_akun[$i],
						  	  'pbd_csf'	 		 => $request->d_akun[$i],
						  	  'pbd_status'		 => $pending[$i],
				]);

				$updt = DB::table('delivery_order')
						  ->where('nomor',$request->d_resi_subcon[$i])
						  ->update([
						  	'status_do'=>'Approved'
						  ]);
			}

			$tt = DB::table('form_tt_d')
								->where('ttd_detail',$request->dt_tt)
								->where('ttd_id',$request->id_tt)
								->where('ttd_invoice',$request->invoice_tt)
								->update([
									'ttd_faktur' => $request->nofaktur,
								]);

			if (in_array('PENDING', $pending)) {
				$status = 'PENDING';
			}else{
				$status = 'APPROVED';
			}

			$save = DB::table('faktur_pembelian')
					  ->where('fp_nofaktur',$nota)
					  ->update([
						'fp_pending_status'		=> $status,
					  ]);

			$cari_dt=DB::table('pembayaran_subcon_dt')		
						 ->join('delivery_order','pbd_resi','=','nomor')
						 ->where('pbd_pb_id','=',$id_pb)
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
							${$unik_asal[$i]}[$a] = $cari_dt[$a]->pbd_tarif_harga;
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
			// //JURNAL

			$delete_jurnal = DB::table('d_jurnal')
							   ->where('jr_ref',$request->nofaktur)
							   ->delete();

			$id_jurnal=d_jurnal::max('jr_id')+1;
			// dd($id_jurnal);
			$jenis_bayar = DB::table('jenisbayar')
							 ->where('idjenisbayar',9)
							 ->first();

			if ($status == "APPROVED") {
				$save_jurnal = d_jurnal::create(['jr_id'	=> $id_jurnal,
												'jr_year'   => carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y'),
												'jr_date' 	=> carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y-m-d'),
												'jr_detail' => $jenis_bayar->jenisbayar,
												'jr_ref'  	=> $request->nofaktur,
												'jr_note'  	=> 'BIAYA SUBCON '.strtoupper($request->keterangan_subcon),
												'jr_insert' => carbon::now(),
												'jr_update' => carbon::now(),
												]);
			}

 
			$akun 	  = [];
			$akun_val = [];
			array_push($akun, $akun_hutang->id_akun);
			array_push($akun_val, $fp_netto);
			for ($i=0; $i < count($jurnal); $i++) { 

				$id_akun = DB::table('d_akun')
								  ->where('id_akun','like','5210' . '%')
								  ->where('kode_cabang',$jurnal[$i]['asal'])
								  ->first();

				if ($id_akun == null) {
					DB::rollBack();
					return response::json(['status'=>0,'pesan'=>'Cabang ini Tidak Mempunyai akun Biaya Subcon']);
				}

				$kurang = $fp_ppn/$fp_jumlah * $jurnal[$i]['harga'];

				$jurnal[$i]['harga'] -= $kurang;
				array_push($akun, $id_akun->id_akun);
				array_push($akun_val, $jurnal[$i]['harga']);
			}



			// PPN
			if ($fp_ppn != 0) {

				$akun_ppn = DB::table('d_akun')
								 ->where('id_akun','like','2302%')
								 ->where('kode_cabang',$request->cabang)
								 ->first();
				array_push($akun, $akun_ppn->id_akun);
				array_push($akun_val, $fp_ppn);
			}
			// PPH
			if ($fp_pph != 0) {

				$pajak = DB::table('pajak')
								 ->where('id',$request->jenis_pph_subcon)
								 ->first();

				$akun_pph = DB::table('d_akun')
								 ->where('id_akun','like',substr($pajak->acc1, 0,4).'%')
								 ->where('kode_cabang',$request->cabang)
								 ->first();

				array_push($akun, $akun_pph->id_akun);
				array_push($akun_val, $fp_pph);
			}

			$data_akun = [];
			for ($i=0; $i < count($akun); $i++) { 

				$cari_coa = DB::table('d_akun')
								  ->where('id_akun',$akun[$i])
								  ->first();

				if (substr($akun[$i],0, 4)==2102) {
					
					if ($cari_coa->akun_dka == 'D') {
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
						$data_akun[$i]['jrdt_statusdk'] = 'D';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
						$data_akun[$i]['jrdt_statusdk'] = 'K';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
					}
				}else if (substr($akun[$i],0, 4)==2302) {

					if ($cari_coa->akun_dka == 'D') {
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
						$data_akun[$i]['jrdt_statusdk'] = 'D';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
						$data_akun[$i]['jrdt_statusdk'] = 'K';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
					}
				}else if (substr($akun[$i],0, 4)==5314) {
					if ($cari_coa->akun_dka == 'D') {
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
						$data_akun[$i]['jrdt_statusdk'] = 'D';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan_subcon);
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
						$data_akun[$i]['jrdt_statusdk'] = 'K';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan_subcon);
					}
				}else{
					if ($cari_coa->akun_dka == 'D') {
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
						$data_akun[$i]['jrdt_statusdk'] = 'D';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan_subcon);
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
						$data_akun[$i]['jrdt_statusdk'] = 'K';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan_subcon);
					}
				}
			}

			if ($status == 'APPROVED') {
				$jurnal_dt = d_jurnal_dt::insert($data_akun);
			}

			$lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();
			$check = check_jurnal(strtoupper($request->nofaktur));

			if ($check == 0) {
				DB::rollBack();
				return response()->json(['status' => 0,'pesan'=>'Jurnal Tidak Balance Gagal Simpan']);
			}

			$lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();

  			return Response()->json(['status' => 1,'id'=>$cari_id]);
		});
	}

	public function subcon_update(request $request){
		return DB::transaction(function() use ($request) {  
   			// dd($request->all());
			$tgl_biaya_head = carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y-m-d');

			$total_subcon = filter_var($request->total_subcon, FILTER_SANITIZE_NUMBER_FLOAT)/100;
			
			

			$valid = DB::table('faktur_pembelian')
						 ->where('fp_nofaktur',$request->nofaktur)
						 ->first();

			$cari_do = DB::table('pembayaran_subcon')
						 ->join('pembayaran_subcon_dt','pb_id','=','pbd_pb_id')
						 ->where('pb_faktur',$request->nofaktur)
						 ->get();

			for ($i=0; $i < count($cari_do); $i++) { 
				$updt = DB::table('delivery_order')
						  ->where('nomor',$cari_do[$i]->pbd_resi)
						  ->update([
						  	'status_do'=>'Released'
						  ]);
			}



			$acc_hutang = DB::table('subcon')
							->where('kode',$request->nama_subcon)
							->first();
			
			$hutang = substr($acc_hutang->acc_code,0, 4);

			$akun_hutang = DB::table('d_akun')
								  ->where('id_akun','like',$hutang . '%')
								  ->where('kode_cabang',$request->cabang)
								  ->first();

			$fp_jumlah   = filter_var($request->total_kotor_subcon,FILTER_SANITIZE_NUMBER_FLOAT)/100;
			$fp_dpp      	  = filter_var($request->total_dpp_subcon,FILTER_SANITIZE_NUMBER_FLOAT)/100;
			$fp_ppn      	  = filter_var($request->ppn_subcon,FILTER_SANITIZE_NUMBER_FLOAT)/100;
			$fp_pph      	  = filter_var($request->pph_subcon,FILTER_SANITIZE_NUMBER_FLOAT)/100;
			$fp_netto 		  = filter_var($request->total_netto,FILTER_SANITIZE_NUMBER_FLOAT)/100;
			if ($request->jenis_pph_subcon == '') {
				$fp_jenispph = 0;
			}else{
				$fp_jenispph = $request->jenis_pph_subcon;
			}

			if ($request->persen_pph_subcon == '') {
				$fp_nilaipph = 0;
			}else{
				$fp_nilaipph = $request->persen_pph_subcon;
			}

			$save = DB::table('faktur_pembelian')
						->where('fp_nofaktur',$request->nofaktur)
						->update([
						'fp_tgl'			=> $tgl_biaya_head,
						'fp_jenisbayar' 	=> 9,
						'fp_comp'			=> $request->cabang,
						'updated_at'		=> Carbon::now(),
						'fp_keterangan'		=> strtoupper($request->keterangan_subcon),
						'fp_status'			=> 'Released',
						'fp_noinvoice'		=> $request->invoice_subcon,
						'fp_pending_status'	=> 'PENDING',
						'fp_supplier'		=> $request->nama_subcon,
						'fp_netto'			=> $total_subcon,
						'fp_sisapelunasan'  => $total_subcon,
						'fp_edit'			=> 'UNALLOWED',
						'fp_jatuhtempo'		=> carbon::parse(str_replace('/', '-', $request->tempo_subcon))->format('Y-m-d'),
						'fp_acchutang'		=> $akun_hutang->id_akun,
						'updated_by'  		=> Auth::user()->m_name,
						'fp_jumlah'     	=> $fp_jumlah,
						'fp_netto' 	  		=> $fp_netto,
						'fp_sisapelunasan' 	=> $fp_netto,
						'fp_nilaipph'	  	=> $fp_nilaipph,
						'fp_dpp'		  	=> $fp_dpp,
						'fp_jenisppn'  		=> $request->jenis_ppn_subcon,
						'fp_inputppn'  		=> $request->persen_ppn_subcon,
						'fp_ppn'		  	=> $fp_ppn,
						'fp_jenispph'	  	=> $fp_jenispph,
						'fp_nilaipph'	  	=> $request->persen_pph_subcon,
						'fp_pph'		  	=> $fp_pph,
					]);

			$faktur_pajak = DB::table('fakturpajakmasukan')
							  ->where('fpm_idfaktur',$valid->fp_idfaktur)
							  ->update([
							  	'fpm_nota'		=> $request->faktur_pajak_penerus,
							  	'fpm_tgl'		=> carbon::parse($request->tanggal_pajak_penerus)->format('Y-m-d'),
							  	'fpm_masapajak'	=> carbon::parse($request->tanggal_pajak_penerus)->format('Y-m-d'),
							  	'fpm_dpp'		=> $fp_dpp,
							  	'fpm_hasilppn'	=> $fp_ppn,
							  	'fpm_inputppn'	=> $fp_ppn,
							  	'fpm_netto'		=> $fp_netto+$fp_pph,
							  	'created_at'    => carbon::now(),
							  	'updated_at'    => carbon::now(),
							  ]);
			$save = DB::table('pembayaran_subcon')
						->where('pb_faktur',$request->nofaktur)
						->update([
						  'pb_faktur'  		  => $request->nofaktur,
						  'pb_status'  		  => 'Released',
						  'pb_kode_subcon'    => $request->nama_subcon,
						  'pb_keterangan' 	  => strtoupper($request->keterangan_subcon),
						  'updated_at' 		  => Carbon::now(),
						  'pb_acc'	      	  => $akun_hutang->id_akun,
						  'pb_csf'	 		  => $akun_hutang->id_akun,
					]);

			$pending = [];
			$pbd_id = DB::table('pembayaran_subcon')
						->where('pb_faktur',$request->nofaktur)
						->first();

			$delete = DB::table('pembayaran_subcon_dt')->where('pbd_pb_id',$pbd_id->pb_id)->delete();

			for ($i=0; $i < count($request->d_resi_subcon); $i++) { 
				$id_pbd = DB::table('pembayaran_subcon_dt')
					 ->max('pbd_id');

				if ($id_pbd == null) {
					$id_pbd = 1;
				}else{
					$id_pbd += 1;
				}

				$cari_do = DB::table('delivery_order')
							 ->where('nomor',$request->d_resi_subcon[$i])
							 ->first();

				$persen = DB::table('subcon')
							->where('kode',$request->nama_subcon)
							->first()->persen;

				$hasil_persen = ($persen/100)*$cari_do->total_net;
				if ($request->d_harga_subcon[$i] > $hasil_persen) {
					$pending[$i] = 'PENDING';
				}else{
					$pending[$i] = 'APPROVED';
				}

				$save = DB::table('pembayaran_subcon_dt')->insert([
							  'pbd_id'   		 => $id_pbd,
							  'pbd_pb_id'   	 => $pbd_id->pb_id,
							  'pbd_ksd_id'   	 => $request->d_ksd_id[$i],
							  'pbd_pb_dt'   	 => $i+1,
							  'pbd_resi'  	 	 => $request->d_resi_subcon[$i],
							  'pbd_jumlah'    	 => $request->d_jumlah_subcon[$i],
							  'pbd_tarif_resi' 	 => $cari_do->total_net,
							  'pbd_keterangan' 	 => $request->d_memo_subcon[$i],
							  'updated_at'     	 => Carbon::now(),
							  'created_at'     	 => Carbon::now(),
							  'pbd_tarif_harga'  => $request->d_harga_subcon[$i],
							  'pbd_acc'	      	 => $request->d_akun[$i],
						  	  'pbd_csf'	 		 => $request->d_akun[$i],
						  	  'pbd_status'		 => $pending[$i],
				]);

				$updt = DB::table('delivery_order')
						  ->where('nomor',$request->d_resi_subcon[$i])
						  ->update([
						  	'status_do'=>'Approved'
						  ]);
			}

			$tt_upd = DB::table('form_tt_d')
					  ->where('ttd_faktur',$request->nofaktur)
					  ->update([
					  	'ttd_faktur'=>null
					  ]);

			$tt = DB::table('form_tt_d')
						->where('ttd_detail',$request->dt_tt)
						->where('ttd_id',$request->id_tt)
						->where('ttd_invoice',$request->invoice_tt)
						->update([
							'ttd_faktur' => $request->nofaktur,
						]);
			if (in_array('PENDING', $pending)) {
				$status = 'PENDING';
			}else{
				$status = 'APPROVED';
			}

			$save = DB::table('faktur_pembelian')
					  ->where('fp_nofaktur',$request->nofaktur)
					  ->update([
						'fp_pending_status'		=> $status,
					  ]);


			$cari_dt=DB::table('pembayaran_subcon_dt')		
					 ->join('delivery_order','pbd_resi','=','nomor')
					 ->where('pbd_pb_id','=',$pbd_id->pb_id)
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
							${$unik_asal[$i]}[$a] = $cari_dt[$a]->pbd_tarif_harga;
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
			// dd($jurnal);

			// //JURNAL

			$delete_jurnal = DB::table('d_jurnal')
							   ->where('jr_ref',$request->nofaktur)
							   ->delete();

			$id_jurnal=d_jurnal::max('jr_id')+1;
			// dd($id_jurnal);
			$jenis_bayar = DB::table('jenisbayar')
							 ->where('idjenisbayar',9)
							 ->first();

			if ($status == "APPROVED") {
				$save_jurnal = d_jurnal::create(['jr_id'	=> $id_jurnal,
												'jr_year'   => carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y'),
												'jr_date' 	=> carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y-m-d'),
												'jr_detail' => $jenis_bayar->jenisbayar,
												'jr_ref'  	=> $request->nofaktur,
												'jr_note'  	=> 'BIAYA SUBCON '.strtoupper($request->keterangan_subcon),
												'jr_insert' => carbon::now(),
												'jr_update' => carbon::now(),
												]);
			}

 
			$akun 	  = [];
			$akun_val = [];
			array_push($akun, $akun_hutang->id_akun);
			array_push($akun_val, $fp_netto);
			for ($i=0; $i < count($jurnal); $i++) { 

				$id_akun = DB::table('d_akun')
								  ->where('id_akun','like','5210' . '%')
								  ->where('kode_cabang',$jurnal[$i]['asal'])
								  ->first();

				if ($id_akun == null) {
					DB::rollBack();
					return response::json(['status'=>0,'pesan'=>'Cabang ini Tidak Mempunyai akun Biaya Subcon']);
				}

				$kurang = $fp_ppn/$fp_jumlah * $jurnal[$i]['harga'];

				$jurnal[$i]['harga'] -= $kurang;
				array_push($akun, $id_akun->id_akun);
				array_push($akun_val, $jurnal[$i]['harga']);
			}



			// PPN
			if ($fp_ppn != 0) {

				$akun_ppn = DB::table('d_akun')
								 ->where('id_akun','like','2302%')
								 ->where('kode_cabang',$request->cabang)
								 ->first();
				array_push($akun, $akun_ppn->id_akun);
				array_push($akun_val, $fp_ppn);
			}
			// PPH
			if ($fp_pph != 0) {

				$pajak = DB::table('pajak')
								 ->where('id',$request->jenis_pph_subcon)
								 ->first();

				$akun_pph = DB::table('d_akun')
								 ->where('id_akun','like',substr($pajak->acc1, 0,4).'%')
								 ->where('kode_cabang',$request->cabang)
								 ->first();

				array_push($akun, $akun_pph->id_akun);
				array_push($akun_val, $fp_pph);
			}

			$data_akun = [];
			for ($i=0; $i < count($akun); $i++) { 

				$cari_coa = DB::table('d_akun')
								  ->where('id_akun',$akun[$i])
								  ->first();

				if (substr($akun[$i],0, 4)==2102) {
					
					if ($cari_coa->akun_dka == 'D') {
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
						$data_akun[$i]['jrdt_statusdk'] = 'D';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
						$data_akun[$i]['jrdt_statusdk'] = 'K';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
					}
				}else if (substr($akun[$i],0, 4)==2302) {

					if ($cari_coa->akun_dka == 'D') {
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
						$data_akun[$i]['jrdt_statusdk'] = 'D';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
						$data_akun[$i]['jrdt_statusdk'] = 'K';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->Keterangan_biaya);
					}
				}else if (substr($akun[$i],0, 4)==5314) {
					if ($cari_coa->akun_dka == 'D') {
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
						$data_akun[$i]['jrdt_statusdk'] = 'D';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan_subcon);
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
						$data_akun[$i]['jrdt_statusdk'] = 'K';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan_subcon);
					}
				}else{
					if ($cari_coa->akun_dka == 'D') {
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
						$data_akun[$i]['jrdt_statusdk'] = 'D';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan_subcon);
					}else{
						$data_akun[$i]['jrdt_jurnal'] 	= $id_jurnal;
						$data_akun[$i]['jrdt_detailid']	= $i+1;
						$data_akun[$i]['jrdt_acc'] 	 	= $akun[$i];
						$data_akun[$i]['jrdt_value'] 	= $akun_val[$i];
						$data_akun[$i]['jrdt_statusdk'] = 'K';
						$data_akun[$i]['jrdt_detail']   = $cari_coa->nama_akun . ' ' . strtoupper($request->keterangan_subcon);
					}
				}
			}

			if ($status == 'APPROVED') {
				$jurnal_dt = d_jurnal_dt::insert($data_akun);
			}

			$lihat = DB::table('d_jurnal_dt')->where('jrdt_jurnal',$id_jurnal)->get();
			$check = check_jurnal(strtoupper($request->nofaktur));

			if ($check == 0) {
				DB::rollBack();
				return response()->json(['status' => 0,'pesan'=>'Jurnal Tidak Balance Gagal Simpan']);
			}

  			return Response()->json(['status' => 1]);
		});
	}

	public function cari_kontrak_subcon(request $request){

		$kontrak = DB::table('kontrak_subcon_dt')
					 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
					 ->join('tipe_angkutan','kode','=','ksd_angkutan')
					 ->where('ks_nama',$request->selectOutlet)
					 ->orderBy('ksd_ks_dt','ASC')
					 ->get();

		$asal = DB::table('kontrak_subcon_dt')
					 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
					 ->join('kota','id','=','ksd_asal')
					 ->select('nama as asal')
					 ->where('ks_nama',$request->selectOutlet)
					 ->orderBy('ksd_ks_dt','ASC')
					 ->get();

		$tujuan = DB::table('kontrak_subcon_dt')
					 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
					 ->join('kota','id','=','ksd_tujuan')
					 ->select('nama as tujuan')
					 ->where('ks_nama',$request->selectOutlet)
					 ->orderBy('ksd_ks_dt','ASC')
					 ->get();

		$jenis_bayar = DB::table('jenis_tarif')
					 ->get();

		for ($i=0; $i < count($kontrak); $i++) { 
			for ($a=0; $a < count($jenis_bayar); $a++) { 
				if ($kontrak[$i]->ksd_jenis_tarif == $jenis_bayar[$a]->jt_id ) {
					$kontrak[$i]->nama_tarif = $jenis_bayar[$a]->jt_nama_tarif;
				}
			}
		}

		// $fix=[][];
		for ($i=0; $i < count($kontrak); $i++) { 
			$fix[$i]['ksd_nota'] = $kontrak[$i]->ks_nota;
			$fix[$i]['ksd_id'] = $kontrak[$i]->ksd_id;
			$fix[$i]['ksd_harga'] = $kontrak[$i]->ksd_harga;
			$fix[$i]['ksd_jenis_tarif'] = $kontrak[$i]->ksd_jenis_tarif;
			$fix[$i]['ksd_asal'] = $asal[$i]->asal;
			$fix[$i]['ksd_tujuan'] = $tujuan[$i]->tujuan;
			$fix[$i]['ksd_angkutan'] = $kontrak[$i]->nama;
			$fix[$i]['ksd_id_angkutan'] = $kontrak[$i]->kode;
			$fix[$i]['jenis_tarif'] = $kontrak[$i]->nama_tarif;
		}
			return view('purchase/fatkur_pembelian/tabelModalSubcon',compact('fix'));
	}

	public function cari_kontrak_subcon1(request $request){
		$kontrak = DB::table('kontrak_subcon_dt')
					 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
					 ->join('tipe_angkutan','kode','=','ksd_angkutan')
					 ->where('ks_nama',$id)
					 ->orderBy('ksd_ks_dt','ASC')
					 ->get();

		$asal = DB::table('kontrak_subcon_dt')
					 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
					 ->join('kota','id','=','ksd_asal')
					 ->select('nama as asal')
					 ->where('ks_nama',$id)
					 ->orderBy('ksd_ks_dt','ASC')
					 ->get();

		$tujuan = DB::table('kontrak_subcon_dt')
					 ->join('kontrak_subcon','ks_id','=','ksd_ks_id')
					 ->join('kota','id','=','ksd_tujuan')
					 ->select('nama as tujuan')
					 ->where('ks_nama',$id)
					 ->orderBy('ksd_ks_dt','ASC')
					 ->get();


		// $fix=[][];
		for ($i=0; $i < count($kontrak); $i++) { 
			$fix[$i]['ksd_id'] = $kontrak[$i]->ksd_id;
			$fix[$i]['ksd_nota'] = $kontrak[$i]->ks_nota;
			$fix[$i]['ksd_harga'] = $kontrak[$i]->ksd_harga;
			$fix[$i]['ksd_jenis_tarif'] = $kontrak[$i]->ksd_jenis_tarif;
			$fix[$i]['ksd_asal'] = $asal[$i]->asal;
			$fix[$i]['ksd_tujuan'] = $tujuan[$i]->tujuan;
			$fix[$i]['ksd_angkutan'] = $kontrak[$i]->nama;
			$fix[$i]['ksd_id_angkutan'] = $kontrak[$i]->kode;
		}
			return view('purchase/fatkur_pembelian/tabelModalSubcon',compact('fix'));
		
	}


	public function rubahVen(request $request)
	{
		// dd($request->all());
		if (isset($request->agen)) {
			$agen = $request->agen;
			$acc  = $request->acc;
			$flag1 = 'E';
		}else{
			$agen = '0';
			$flag1 = 'C';
		}
		if ($request->val == 'AGEN') {
			$data = DB::table('agen')
					  ->where('kode_cabang',$request->cabang)
					  ->where('kategori','AGEN')
					  ->orWhere('kategori','AGEN DAN OUTLET')
					  ->get();
		}else{
			$data = DB::table('vendor')
					  ->get();
		}
			$flag = $request->vendor;
// return 'asd';
		return view('purchase/fatkur_pembelian/dropdownBiayaPenerus',compact('data','flag','agen','acc','flag1'));
	}



public function cari_do_subcon(request $request)
{
	if (isset($request->array_do)) {
		$data = DB::table('delivery_order')
			  ->leftjoin('pembayaran_subcon_dt','pbd_resi','=','nomor')
			  ->where('status_kendaraan','SUB')
			  ->where('kode_subcon',$request->selectOutlet)
			  ->where('kode_cabang',$request->cabang)
			  ->whereNotIN('nomor',$request->array_do)
			  ->where('pbd_resi',null)
			  ->get();
	}else{
		$data = DB::table('delivery_order')
			  ->leftjoin('pembayaran_subcon_dt','pbd_resi','=','nomor')
			  ->where('status_kendaraan','SUB')
			  ->where('kode_subcon',$request->selectOutlet)
			  ->where('kode_cabang',$request->cabang)
			  ->where('pbd_resi',null)
			  ->get();
	}
	

	$jenis_tarif = DB::table('jenis_tarif')
					 ->get();
					 
	$kota = DB::table('kota')
			  ->get();

	$tipe_angkutan = DB::table('tipe_angkutan')
			  ->get();

	for ($i=0; $i < count($data); $i++) { 

		for ($a=0; $a < count($kota); $a++) { 
			if ($kota[$a]->id == $data[$i]->id_kota_asal) {
				$data[$i]->nama_asal = $kota[$a]->nama;
			}
			if ($kota[$a]->id == $data[$i]->id_kota_tujuan) {
				$data[$i]->nama_tujuan = $kota[$a]->nama;
			}
		}

		for ($b=0; $b < count($tipe_angkutan); $b++) { 
			if ((integer)$data[$i]->kode_tipe_angkutan == $tipe_angkutan[$b]->kode) {
				$data[$i]->nama_angkutan = $tipe_angkutan[$b]->nama;
			}
		}

		for ($c=0; $c < count($jenis_tarif); $c++) { 
			if ((integer)$data[$i]->jenis_tarif == $jenis_tarif[$c]->jt_id) {
				$data[$i]->nama_tarif = $jenis_tarif[$c]->jt_nama_tarif;
			}
		}
	}

	return view('purchase.fatkur_pembelian.tabelSubcon',compact('data'));
}


public function biaya_penerus_um(request $req)
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

	return view('purchase.fatkur_pembelian.biaya_penerus_um_modal',compact('data'));
}




public function pilih_um(request $req)
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
	
	// return $data;
	$data = array_merge($fpg,$bk);

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

	for ($i=0; $i < count($data); $i++) { 
		if ($data[$i]->nomor == $req->nomor_trans and $data[$i]->um_nomorbukti == $req->nomor_um) {
			$head = $data[$i];
		}
	}
	// return $req->nomor_um;
	return response()->json(['data'=>$head]);
}


public function append_um(request $req)
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
	
	// return $data;
	$data = array_merge($fpg,$bk);

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

	for ($i=0; $i < count($data); $i++) { 
		if ($data[$i]->nomor == $req->nota) {
			$head = $data[$i];
		}
	}
	return response()->json(['data'=>$head]);
}

public function save_bp_um(request $req)
{
   	return DB::transaction(function() use ($req) {  
		// dd($req->all());
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
						'umfp_totalbiaya'	=> filter_var($req->bp_total_um, FILTER_SANITIZE_NUMBER_INT)/100,
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
						 	'fp_uangmuka' => $cari_fp->fp_uangmuka + filter_var($req->bp_total_um, FILTER_SANITIZE_NUMBER_INT)/100,
						 	'fp_sisapelunasan'=> $cari_fp->fp_sisapelunasan - filter_var($req->bp_total_um, FILTER_SANITIZE_NUMBER_INT)/100
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
			for ($i=0; $i < count($req->bp_total_um); $i++) { 
				$sum[$i] = filter_var($req->bp_total_um, FILTER_SANITIZE_NUMBER_INT)/100;
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


public function outlet_um(request $req)
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
					if ($data[$a]->nomor == $um[$i]->umfpdt_transaksibank and $data[$a]->um_nomorbukti == $um[$i]->umfpdt_notaum) {
						$data[$i]->sisa_um += $um[$a]->umfpdt_dibayar;
					}
				}
			}
		}
		
	}
	return view('purchase.fatkur_pembelian.outlet_um_modal',compact('data'));
}

public function subcon_um(request $req)
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
	
	return view('purchase.fatkur_pembelian.subcon_um_modal',compact('data'));
}

public function update_bp_um(request $req)
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
						'umfp_totalbiaya'	=> filter_var($req->bp_total_um, FILTER_SANITIZE_NUMBER_INT)/100,
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
						 	'fp_uangmuka' => $cari_fp->fp_uangmuka + filter_var($req->bp_total_um, FILTER_SANITIZE_NUMBER_INT)/100,
						 	'fp_sisapelunasan'=> $cari_fp->fp_sisapelunasan - filter_var($req->bp_total_um, FILTER_SANITIZE_NUMBER_INT)/100
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
			for ($i=0; $i < count($req->bp_total_um); $i++) { 
				$sum[$i] = filter_var($req->bp_total_um, FILTER_SANITIZE_NUMBER_INT)/100;
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


public function jurnal(request $req)
	{
		$bkk = DB::table('faktur_pembelian')	
				 ->where('fp_idfaktur',$req->id)
				 ->first();
		$data= DB::table('d_jurnal')
				 ->join('d_jurnal_dt','jrdt_jurnal','=','jr_id')
				 ->join('d_akun','jrdt_acc','=','id_akun')
				 ->where('jr_ref',$bkk->fp_nofaktur)
				 ->where('jr_detail','!=','UANG MUKA PEMBELIAN FP')
				 ->get();


		$d = [];
		$k = [];
		for ($i=0; $i < count($data); $i++) { 
			if ($data[$i]->jrdt_value < 0) {
				$data[$i]->jrdt_value *= -1;
			}
		}

		for ($i=0; $i < count($data); $i++) { 
			if ($data[$i]->jrdt_statusdk == 'D') {
				$d[$i] = $data[$i]->jrdt_value;
			}elseif ($data[$i]->jrdt_statusdk == 'K') {
				$k[$i] = $data[$i]->jrdt_value;
			}
		}
		$d = array_values($d);
		$k = array_values($k);

		$d = array_sum($d);
		$k = array_sum($k);

		return view('purchase.buktikaskeluar.jurnal',compact('data','d','k'));
	}


public function jurnal_um(request $req)
	{
		$bkk = DB::table('faktur_pembelian')	
				 ->where('fp_idfaktur',$req->id)
				 ->first();
		$data= DB::table('d_jurnal')
				 ->join('d_jurnal_dt','jrdt_jurnal','=','jr_id')
				 ->join('d_akun','jrdt_acc','=','id_akun')
				 ->where('jr_ref',$bkk->fp_nofaktur)
				 ->where('jr_detail','=','UANG MUKA PEMBELIAN FP')
				 ->get();


		$d = [];
		$k = [];
		for ($i=0; $i < count($data); $i++) { 
			if ($data[$i]->jrdt_value < 0) {
				$data[$i]->jrdt_value *= -1;
			}
		}

		for ($i=0; $i < count($data); $i++) { 
			if ($data[$i]->jrdt_statusdk == 'D') {
				$d[$i] = $data[$i]->jrdt_value;
			}elseif ($data[$i]->jrdt_statusdk == 'K') {
				$k[$i] = $data[$i]->jrdt_value;
			}
		}
		$d = array_values($d);
		$k = array_values($k);

		$d = array_sum($d);
		$k = array_sum($k);

		return view('purchase.buktikaskeluar.jurnal',compact('data','d','k'));
	}

}



?>