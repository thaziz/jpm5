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
use App\tb_coa;
use App\tb_jurnal;
use DB;
use Response;
Use Carbon\Carbon;
use Session;
use Mail;
use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;
use Auth;

class BiayaPenerusController extends Controller
{
	public function getdatapenerus(){
		
			$data = DB::table('akun')
					  ->get();
			$date = Carbon::now()->format('d/m/Y');

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
						->get();
			}

			$valid = DB::table('form_tt')
					   ->leftjoin('faktur_pembelian','fp_idtt','=','tt_idform')
					   // ->where('fp_nofaktur','=',null)
					   ->get();

			for ($i=0; $i < count($valid); $i++) { 
				if ($valid[$i]->fp_nofaktur == null) {
					$valid = DB::table('form_tt')
					   ->where('tt_idform','=',$valid[$i]->tt_idform)
					   ->delete();
				}
			}
			
			$jt = Carbon::now()->subDays(-30)->format('d/m/Y');
			return view('purchase/fatkur_pembelian/form_biaya_penerus',compact('data','date','agen','vendor','now','jt','akun'));
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
		public function cari_do(request $request){

		
	        $results = array();
	        $queries = DB::table('delivery_order')
	        	->leftjoin('biaya_penerus_dt','nomor','=','bpd_pod')
	            ->where('nomor', 'like', '%'.strtoupper($request->term).'%')
	            ->where('bpd_pod',null)
	            ->take(10)->get();

	        if ($queries == null){
	            $results[] = [ 'id' => null, 'label' => 'Tidak ditemukan data terkait'];
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
	        			->where('kode_akun',5319)
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

		public function nota_tt(request $request)
		{
			$bulan = Carbon::now()->format('m');
		    $tahun = Carbon::now()->format('y');

		    $cari_nota = DB::select("SELECT  substring(max(tt_noform),12) as id from form_tt
		                                    WHERE tt_idcabang = '$request->cabang'
		                                    AND to_char(created_at,'MM') = '$bulan'
		                                    AND to_char(created_at,'YY') = '$tahun'");
		    $index = (integer)$cari_nota[0]->id + 1;
		    $index = str_pad($index, 3, '0', STR_PAD_LEFT);
		    $nota = 'TT' . $bulan . $tahun .'/'.$request->cabang.'/'. $index;

		    return response()->json(['nota'=>$nota]);
		}

		public function save_agen(request $request){
			// dd($request->all());
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
				}else{
				 	$cari_persen = DB::table('vendor')
				 					 ->where('kode',$request->nama_kontak2)
				 					 ->first();
					$komisi = $cari_persen->komisi_vendor;
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

					$total_biaya =  array_sum($request->bayar_biaya);
					$count 		 = count($request->no_do);
					$save_data = DB::table('faktur_pembelian')
								   ->insert([
								   	  'fp_idfaktur'   		=> $id,
									  'fp_nofaktur'   		=> $request->nofaktur,
									  'fp_tgl'        		=> $tgl,
									  'fp_keterangan' 		=> $request->Keterangan_biaya,
									  'fp_noinvoice'  		=> $request->Invoice_biaya,
									  'fp_jatuhtempo' 		=> $jt,
									  'created_at'    		=> carbon::now(),
									  'updated_at'    		=> carbon::now(),
									  'fp_jumlah'     		=> $count,
									  'fp_netto' 	  		=> $total_biaya,
									  'fp_comp'  	  		=> $request->cabang,
									  'fp_pending_status'	=> $pending_status,
									  'fp_status'  			=> 'Released',  
									  'fp_jenisbayar' 		=> '6',
									  'fp_edit'  			=> 'ALLOWED',
									  'fp_sisapelunasan' 	=> $total_biaya,
									  'fp_supplier'  		=> $request->nama_kontak2,
									  'fp_acchutang'  		=> $request->acc_penjualan_penerus,
									  'created_by'  		=> Auth::user()->m_username,
									  'updated_by'  		=> Auth::user()->m_username,
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
									  'created_at' 		 => carbon::now(),
									  'bp_total_penerus' => $total_biaya,
									  'bp_akun_agen'	 => $request->acc_penjualan_penerus,
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

						$save_dt = DB::table('biaya_penerus_dt')
									 ->insert([
										  'bpd_id'  		=> $id_bpd,
										  'bpd_bpid' 		=> $id_bp,
										  'bpd_bpdetail'	=> $i+1,
										  'bpd_pod' 		=> $request->no_do[$i],
										  'bpd_tgl'  		=> $cari_do->tanggal,
										  'bpd_akun_biaya'  => $request->kode_biaya[$i],
										  'bpd_debit' 	   	=> $request->DEBET_biaya[$i],
										  'bpd_memo'  	  	=> $request->ket_biaya[$i],
										  'bpd_akun_hutang' => $request->acc_penjualan_penerus,
										  'created_at'      => carbon::now(), 
										  'updated_at' 	   	=> carbon::now(),
										  'bpd_status' 	    => $status[$i],
										  'bpd_nominal'	    => $request->bayar_biaya[$i],
										  'bpd_tarif_resi'  => $request->do_harga[$i]
									 ]);
					}	

					return response()->json(['status'=>1,'sp'=>$pending_status,'id'=>$id]);
				}else{
					return response()->json(['status'=>2,'alert'=>'DATA SUDAH ADA']);
				}
				
			});
		}
		public function edit($id){
			if (Auth::user()->punyaAKses('Faktur Pembelian','ubah')) {





			$cari_fp = DB::table('faktur_pembelian')
						 ->where('fp_idfaktur',$id)
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
				$cabang = DB::table("cabang")
							->get();
				
				$jt = Carbon::now()->subDays(-30)->format('d/m/Y');

				$fpg = DB::select("SELECT fpg_nofpg as nomor, fpg_agen as agen,fpgb_nominal as total_um,fpgdt_sisapelunasanumfp as sisa_um, d_uangmuka.*
					   from fpg inner join fpg_cekbank on fpgb_idfpg = idfpg
					   inner join fpg_dt on fpgdt_idfpg = idfpg
					   inner join d_uangmuka on um_supplier = fpg_agen
					   where fpgb_posting = 'DONE'
					   and fpg_agen = '$bp->fp_supplier'");


				$bk  = DB::select("SELECT bkk_nota as nomor,bkk_supplier as agen,bkkd_total as total_um,bkkd_sisaum as sisa_um, d_uangmuka.*
								   from bukti_kas_keluar inner join bukti_kas_keluar_detail on bkkd_bkk_id = bkk_id
								   inner join d_uangmuka on um_supplier = bkk_supplier
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
				// return $um;
				return view('purchase/fatkur_pembelian/edit_biaya_penerus',compact('data','date','agen','vendor','now','jt','akun','bp','bpd','cari_fp','cabang','form_tt','id','nota','um'));

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
					   inner join d_uangmuka on um_supplier = fpg_agen
					   where fpgb_posting = 'DONE'
					   and fpg_agen = '$data->fp_supplier'");


				$bk  = DB::select("SELECT bkk_nota as nomor,bkk_supplier as agen,bkkd_total as total_um,bkkd_sisaum as sisa_um, d_uangmuka.*
								   from bukti_kas_keluar inner join bukti_kas_keluar_detail on bkkd_bkk_id = bkk_id
								   inner join d_uangmuka on um_supplier = bkk_supplier
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

			return view('purchase/fatkur_pembelian/editOutlet',compact('date','agen','akun_biaya','second','start','jt','data','data_dt','valid_cetak','id','cabang','um','nota'));

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
					   inner join d_uangmuka on um_supplier = fpg_agen
					   where fpgb_posting = 'DONE'
					   and fpg_agen = '$data->fp_supplier'");


				$bk  = DB::select("SELECT bkk_nota as nomor,bkk_supplier as agen,bkkd_total as total_um,bkkd_sisaum as sisa_um, d_uangmuka.*
								   from bukti_kas_keluar inner join bukti_kas_keluar_detail on bkkd_bkk_id = bkk_id
								   inner join d_uangmuka on um_supplier = bkk_supplier
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
				return view('purchase/fatkur_pembelian/editsubcon',compact('date','kota','subcon','akun_biaya','akun','valid_cetak','data','data_dt','cabang','um','nota'));
			}



			}else{
				return redirect()->back();
			}
			
		 	
		}


		public function hapus_biaya($id){
		 	$cari = DB::table('faktur_pembelian')
		 				->where('fp_idfaktur',$id)
		 				->first();

		 	$delete = DB::table('form_tt')
		 				->where('tt_nofp',$cari->fp_nofaktur)
		 				->delete();

		 	$delete = DB::table('faktur_pembelian')
		 				->where('fp_idfaktur',$id)
		 				->delete();
		 	return response()->json(['status'=>1]);
		}

		public function update_agen(request $request){

			return DB::transaction(function() use ($request) {  
				// dd($request->all());
		
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
				}else{
				 	$cari_persen = DB::table('vendor')
				 					 ->where('kode',$request->nama_kontak2)
				 					 ->first();
					$komisi = $cari_persen->komisi_vendor;
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
					$count 		 = count($request->no_do);
					$save_data = DB::table('faktur_pembelian')
								   ->where('fp_nofaktur',$request->nofaktur)
								   ->update([
									  'fp_nofaktur'   		=> $request->nofaktur,
									  'fp_tgl'        		=> $tgl,
									  'fp_keterangan' 		=> $request->Keterangan_biaya,
									  'fp_noinvoice'  		=> $request->Invoice_biaya,
									  'fp_jatuhtempo' 		=> $jt,
									  'updated_at'    		=> carbon::now(),
									  'fp_jumlah'     		=> $count,
									  'fp_netto' 	  		=> $total_biaya,
									  'fp_comp'  	  		=> $request->cabang,
									  'fp_pending_status'	=> $pending_status,
									  'fp_status'  			=> 'Released',  
									  'fp_jenisbayar' 		=> '6',
									  'fp_edit'  			=> 'ALLOWED',
									  'fp_sisapelunasan' 	=> $total_biaya,
									  'fp_supplier'  		=> $request->nama_kontak2,
									  'fp_acchutang'  		=> $request->acc_penjualan_penerus,
									  'updated_by'  		=> Auth::user()->m_username,
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
									  'bp_akun_agen'	 => $request->acc_penjualan_penerus,
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

						$save_dt = DB::table('biaya_penerus_dt')
									 ->insert([
										  'bpd_id' 			=> $id_bpd,
										  'bpd_bpid' 		=> $cari_bp->bp_id,
										  'bpd_bpdetail'	=> $i+1,
										  'bpd_pod' 		=> $request->no_do[$i],
										  'bpd_tgl'  		=> $cari_do->tanggal,
										  'bpd_akun_biaya'  => $request->kode_biaya[$i],
										  'bpd_debit' 	   	=> $request->DEBET_biaya[$i],
										  'bpd_memo'  	  	=> $request->ket_biaya[$i],
										  'bpd_akun_hutang' => $request->acc_penjualan_penerus,
										  'created_at'      => carbon::now(), 
										  'updated_at' 	   	=> carbon::now(),
										  'bpd_status' 	    => $status[$i],
										  'bpd_nominal'	    => $request->bayar_biaya[$i],
										  'bpd_tarif_resi'  => $request->do_harga[$i]
									 ]);
					}	

					return response()->json(['status'=>1,'sp'=>$pending_status]);
				}else{
					return response()->json(['status'=>2,'alert'=>'Gagal Mengedit Data']);
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

			$akun_biaya = DB::table('akun_biaya')
					  ->get();
			$first = Carbon::now();
	        $second = Carbon::now()->format('d/m/Y');
	        // $start = $first->subMonths(1)->startOfMonth();
	        $start = $first->subDays(30)->startOfDay()->format('d/m/Y');
	        $jt = Carbon::now()->subDays(-30)->format('d/m/Y');



			return view('purchase/fatkur_pembelian/PembayaranOutlet',compact('date','agen','akun_biaya','second','start','jt'));
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

			$nota = 'FP' . $month . $year . '/' . $request->cab . '/O-' .  $idfaktur;
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

			$nota = 'FP' . $month . $year . '/' . $request->cab . '/P-' .  $idfaktur;
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

			$nota = 'FP' . $month . $year . '/' . $request->cab . '/SC-' .  $idfaktur;
			/*dd($data['nofp']);*/

			return response()->json(['nota' => $nota]);
		}
		
		public function simpan_tt(request $request){

			// dd($request->all());
		
			 
			 $total = filter_var($request->total_diterima, FILTER_SANITIZE_NUMBER_INT);
			 $total = $total/100;

			 $tgl         = str_replace('/', '-', $request->tgl_tt);		 
			 $tgl 		  = Carbon::parse($tgl)->format('Y-m-d');
			 
			 $tgl_kembali         = str_replace('/', '-', $request->tgl_kembali);		 
			 $tgl_kembali 		  = Carbon::parse($tgl_kembali)->format('Y-m-d');
			
		      	if($request->kwitansi == 'on')	{
		      		$kwitansi = 'ADA';
		      	}else{
		      		$kwitansi = 'TIDAK ADA';
		      	}
		      	if($request->faktur_pajak == 'on')	{
		      		$Faktur = 'ada';
		      	}else{
		      		$Faktur = 'TIDAK ADA';
		      	}
		      	if($request->surat_peranan == 'on')	{
		      		$Peranan = 'ada';
		      	}else{
		      		$Peranan = 'TIDAK ADA';
		      	}
		      	if($request->surat_jalan == 'on')	{
		      		$Jalan = 'ada';
		      	}else{
		      		$Jalan = 'TIDAK ADA';
		      	}

		      	$valid_notafp =DB::table('form_tt')
		      					 ->where('tt_noform',$request->nota_tt)
		      					 ->first();

		      	if($valid_notafp == null){
		      		$id = DB::table('form_tt')
							->max('tt_idform');
					 if($id == null){
					 	$id=1;
					 }else{
					 	$id+=1;
					 }

			        $save = DB::table('form_tt')
			        			->insert([
			        				'tt_idform'		 	 => $id,
			        				'tt_tgl'   			 => $tgl,
			        				'tt_lainlain'		 => $request->lainlain_penerus,
			        				'tt_tglkembali' 	 => $tgl_kembali,
			        				'tt_totalterima'	 => round($total,2),
			        				'created_at'		 => Carbon::now(),
			        				'updated_at'	 	 => Carbon::now(),
			        				'tt_kwitansi'	 	 => strtoupper($kwitansi),
			        				'tt_suratperan'	 	 => strtoupper($Peranan),
			        				'tt_suratjalanasli'	 => strtoupper($Jalan),
			        				'tt_faktur'			 => strtoupper($Faktur),
			        				'tt_noform'			 => $request->nota_tt,
			        				'tt_nofp'			 => $request->nofaktur,
			        				'tt_idagen'			 => $request->supplier_tt,
			        				'tt_idcabang'		 => $request->cabang
			        			]);
			        return response()->json(['status' => '1','id'=>$id,'no'=>$request->nota_tt]);
			    }else{
			    	$save = DB::table('form_tt')
			    				->where('tt_noform',$request->nota_tt)
			        			->update([
			        				'tt_tgl'   			 => $tgl,
			        				'tt_lainlain'		 => $request->lainlain_penerus,
			        				'tt_tglkembali' 	 => $tgl_kembali,
			        				'tt_totalterima'	 => round($total,2),
			        				'created_at'		 => Carbon::now(),
			        				'updated_at'	 	 => Carbon::now(),
			        				'tt_kwitansi'	 	 => strtoupper($kwitansi),
			        				'tt_suratperan'	 	 => strtoupper($Peranan),
			        				'tt_suratjalanasli'	 => strtoupper($Jalan),
			        				'tt_faktur'			 => strtoupper($Faktur),
			        				'tt_noform'			 => $request->nota_tt,
			        				'tt_nofp'			 => $request->nofaktur,
			        				'tt_idagen'			 => $request->supplier_tt,
			        				'tt_idcabang'		 => $request->cabang
			        			]);
			        $id = DB::table('form_tt')
			        		->where('tt_noform',$request->nota_tt)
			        		->first()->tt_idform;

			    	return response()->json(['status' => '0','id'=>$id,'no'=>$request->nota_tt]);
			    }

		}




		public function simpan_tt_subcon(request $request){
		
	

			 $total = filter_var($request->total_terima, FILTER_SANITIZE_NUMBER_INT);
			 $total = $total/100;
			
		      	if($request->Kwitansi == 'on')	{
		      		$kwitansi = 'ADA';
		      	}else{
		      		$kwitansi = 'tidak ada';
		      	}
		      	if($request->Faktur == 'on')	{
		      		$Faktur = 'ada';
		      	}else{
		      		$Faktur = 'tidak ada';
		      	}
		      	if($request->Peranan == 'on')	{
		      		$Peranan = 'ada';
		      	}else{
		      		$Peranan = 'tidak ada';
		      	}
		      	if($request->Jalan == 'on')	{
		      		$Jalan = 'ada';
		      	}else{
		      		$Jalan = 'tidak ada';
		      	}

		      	$valid_notafp =DB::table('form_tt')
		      					 ->where('tt_nofp',$request->nota)
		      					 ->first();

	
			    	$save = DB::table('form_tt')
			    				->where('tt_noform',$request->no_tt)
			        			->update([
			        				'tt_tgl'   			 => $request->modal_tanggal,
			        				'tt_idagen' 	 	 => $request->supplier,
			        				'tt_lainlain'		 => $request->modal_lain,
			        				'tt_tglkembali' 	 => $request->tgl_terima,
			        				'tt_totalterima'	 => round($total,2),
			        				'updated_at'	 	 => Carbon::now(),
			        				'tt_kwitansi'	 	 => strtoupper($kwitansi),
			        				'tt_suratperan'	 	 => strtoupper($Peranan),
			        				'tt_suratjalanasli'	 => strtoupper($Jalan),
			        				'tt_faktur'			 => strtoupper($Faktur),
			        				'tt_noform'			 => $request->no_tt,
			        				'tt_nofp'			 => $request->nota,
			        				'tt_idcabang'		 =>'001'
			        			]);
			    	return response()->json(['status' => '0']);
			    

		}
		public function cetak_tt($id){
			$id =str_replace('-', '/', $id);

			$cari_tt = DB::table('form_tt')
						   ->where('tt_noform',$id)
						   ->first();
			$cari_tipe = DB::table('faktur_pembelian')
						   ->where('fp_nofaktur',$cari_tt->tt_nofp)
						   ->get();

			if ($cari_tipe[0]->fp_jenisbayar == 6) {
			    $nota = $id;
				$data = DB::table('form_tt')
						  ->join('biaya_penerus','bp_faktur','=','tt_nofp')
						  ->join('faktur_pembelian','fp_nofaktur','=','tt_nofp')
						  ->join('agen','bp_kode_vendor','=','kode')
						  ->where('tt_noform',$nota)
						  ->get();
				if(isset($data)){
					$terbilang = $this->terbilang($data[0]->tt_totalterima,$style=3);	
				}
			    $tgl = Carbon::parse($data[0]->tt_tglkembali)->format('D');
			    if($tgl == 'Sun'){
			    	$tgl = 'Minggu';
			    }else if($tgl == 'Mon'){
			    	$tgl = 'Senin';
			    
				}else if($tgl == 'Tue'){
			    	$tgl = 'Selasa';
			    
				}else if($tgl == 'Wed'){
			    	$tgl = 'Rabu';
			    
				}else if($tgl == 'Thu'){
			    	$tgl = 'Kamis';
			    }else if($tgl == 'Fri'){
			    	$tgl = 'Jumat';
				}else if($tgl == 'Sat'){
			    	$tgl = 'Sabtu';
				}
				
				return view('purchase/fatkur_pembelian/cetaktt',compact('nota','data','tgl','terbilang','cari_tipe'));
			}else if($cari_tipe[0]->fp_jenisbayar == 7){

				$nota = $id;
				$data = DB::table('form_tt')
						  ->join('pembayaran_outlet','pot_faktur','=','tt_nofp')
						  ->join('faktur_pembelian','fp_nofaktur','=','tt_nofp')
						  ->join('agen','pot_kode_outlet','=','kode')
						  ->where('tt_noform',$nota)
						  ->get();

				if(isset($data)){
					$terbilang = $this->terbilang($data[0]->tt_totalterima,$style=3);	
				}

			    $tgl = Carbon::parse($data[0]->tt_tglkembali)->format('D');
			    if($tgl == 'Sun'){
			    	$tgl = 'Minggu';
			    }else if($tgl == 'Mon'){
			    	$tgl = 'Senin';
			    
				}else if($tgl == 'Tue'){
			    	$tgl = 'Selasa';
			    
				}else if($tgl == 'Wed'){
			    	$tgl = 'Rabu';
			    
				}else if($tgl == 'Thu'){
			    	$tgl = 'Kamis';
			    }else if($tgl == 'Fri'){
			    	$tgl = 'Jumat';
				}else if($tgl == 'Sat'){
			    	$tgl = 'Sabtu';
				}
				
				return view('purchase/fatkur_pembelian/cetaktt',compact('nota','data','tgl','terbilang','cari_tipe'));
			}else if($cari_tipe[0]->fp_jenisbayar == 9){

				$nota = $id;
				$data = DB::table('form_tt')
						  ->join('pembayaran_subcon','pb_faktur','=','tt_nofp')
						  ->join('faktur_pembelian','fp_nofaktur','=','tt_nofp')
						  ->join('subcon','kode','=','pb_kode_subcon')
						  ->where('tt_noform',$nota)
						  ->get();

				if(isset($data)){
					$terbilang = $this->terbilang($data[0]->tt_totalterima,$style=3);	
				}

			    $tgl = Carbon::parse($data[0]->tt_tglkembali)->format('D');
			    if($tgl == 'Sun'){
			    	$tgl = 'Minggu';
			    }else if($tgl == 'Mon'){
			    	$tgl = 'Senin';
			    
				}else if($tgl == 'Tue'){
			    	$tgl = 'Selasa';
			    
				}else if($tgl == 'Wed'){
			    	$tgl = 'Rabu';
			    
				}else if($tgl == 'Thu'){
			    	$tgl = 'Kamis';
			    }else if($tgl == 'Fri'){
			    	$tgl = 'Jumat';
				}else if($tgl == 'Sat'){
			    	$tgl = 'Sabtu';
				}
				
				return view('purchase/fatkur_pembelian/cetaktt',compact('nota','data','tgl','terbilang','cari_tipe'));
			}
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
			// dd($request);	
			// "selectOutlet" => "A012"
	  //     "rangepicker" => "02/08/2017 - 01/02/2018"
	  //     "note" => "Biaya untuk outlet wisnu"
	  //     "nofaktur" => "FP0218/001/O-003"
	  //     "tgl" => "01-February-2018"
	  //     "chck" => array:25 [▶]
	  //     "no_resi" => array:25 [▶]
	  //     "komisi" => array:25 [▶]
	  //     "biaya_komisi" => array:25 [▶]
	  //     "total_komisi" => array:25 [▶]
	  //     "total_tarif" => "Rp 44.700,00"
	  //     "total_komisi_outlet" => "Rp 4.470,00"
	  //     "total_komisi_tambahan" => "Rp 0,00"
	  //     "total_all_komisi" => "Rp 4.470,00"
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
			$akun_hutang = $akun_hutang->acc_hutang;
			
		   	
		    $cari_tt = DB::table('form_tt')
		    			 ->where('tt_nofp',$request->nofaktur)
		    			 ->get();

			$save = DB::table('faktur_pembelian')->insert([
								'fp_idfaktur'		=> $cari_id,
								'fp_nofaktur'		=> $request->nofaktur,
								'fp_tgl'			=> Carbon::parse($tgl[0])->format('Y-m-d'),
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
								'fp_idtt'			=> $cari_tt[0]->tt_idform,
								'created_by'  		=> Auth::user()->m_username,
								'updated_by'  		=> Auth::user()->m_username,
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


			return response()->json(['id'=>$cari_id]);
			
		}

		public function update_outlet(request $request){

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

			$update_pot = DB::table('faktur_pembelian')
							->where('fp_nofaktur',$cari_nota->fp_nofaktur)
							->update([
							  	'fp_keterangan'			=> $request->note,
							  	'fp_netto'				=> round($request->total_all_komisi,2),
								'fp_sisapelunasan'  	=> round($request->total_all_komisi,2),
								'fp_pending_status'  	=> 'APPROVED',
							  	'updated_at'			=> Carbon::now(),
							  	'updated_by'  			=> Auth::user()->m_username,
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

			$status = DB::table('faktur_pembelian')
						->where('fp_nofaktur',$cari_nota->fp_nofaktur)
						->first();

			return response()->json(['status'=>$status->fp_pending_status]);
		}

		public function getpembayaransubcon(){

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

			return view('purchase/fatkur_pembelian/formSubcon',compact('date','kota','subcon','akun_biaya','akun'));
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
   			// dd($request->all());
			$tgl_biaya_head = carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y-m-d');

			$total_subcon = filter_var($request->total_subcon, FILTER_SANITIZE_NUMBER_FLOAT)/100;

			$cari_tt = DB::table('form_tt')
						 ->where('tt_nofp',$request->nofaktur)
						 ->first();
			$cari_id = DB::table('faktur_pembelian')
						 ->max('fp_idfaktur');

			if ($cari_id == null) {
				$cari_id = 1;
			}else{
				$cari_id += 1;
			}
			$valid = DB::table('faktur_pembelian')
						 ->where('fp_nofaktur',$request->nofaktur)
						 ->first();

			if ($valid == null) {
				$acc_hutang = DB::table('subcon')
								->where('kode',$request->nama_subcon)
								->first();

				$save = DB::table('faktur_pembelian')->insert([
							'fp_idfaktur'		=> $cari_id,
							'fp_nofaktur'		=> $request->nofaktur,
							'fp_tgl'			=> $tgl_biaya_head,
							'fp_jenisbayar' 	=> 9,
							'fp_comp'			=> $request->cabang,
							'created_at'		=> Carbon::now(),
							'updated_at'		=> Carbon::now(),
							'fp_keterangan'		=> $request->keterangan_subcon,
							'fp_status'			=> 'Released',
							'fp_noinvoice'		=> $request->invoice_subcon,
							'fp_pending_status'	=> 'PENDING',
							'fp_supplier'		=> $request->nama_subcon,
							'fp_netto'			=> $total_subcon,
							'fp_sisapelunasan'  => $total_subcon,
							'fp_edit'			=> 'UNALLOWED',
							'fp_jatuhtempo'		=> carbon::parse(str_replace('/', '-', $request->tempo_subcon))->format('Y-m-d'),
							'fp_idtt'			=> $cari_tt->tt_idform,
							'fp_acchutang'		=> $acc_hutang->acc_code,
							'created_by'  		=> Auth::user()->m_username,
							'updated_by'  		=> Auth::user()->m_username,
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
							  'pb_keterangan' 	  => $request->keterangan_subcon,
							  'updated_at' 		  => Carbon::now(),
							  'created_at' 	      => Carbon::now(),
							  'pb_acc'	      	  => $acc_hutang->acc_code,
							  'pb_csf'	 		  => $acc_hutang->csf_code,
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
				}

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


	  			return Response()->json(['status' => 1,'id'=>$cari_id]);
			}else{

				$year =Carbon::now()->format('y'); 
				$month =Carbon::now()->format('m'); 

				 $idfaktur =   fakturpembelian::where('fp_comp' , $request->cabang)
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

				$nota = 'FP' . $month . $year . '/' . $request->cabang . '/SC-' .  $idfaktur;

				$acc_hutang = DB::table('subcon')
								->where('kode',$request->nama_subcon)
								->first();

				$save = DB::table('faktur_pembelian')->insert([
							'fp_idfaktur'		=> $cari_id,
							'fp_nofaktur'		=> $nota,
							'fp_tgl'			=> $tgl_biaya_head,
							'fp_jenisbayar' 	=> 9,
							'fp_comp'			=> $request->cabang,
							'created_at'		=> Carbon::now(),
							'updated_at'		=> Carbon::now(),
							'fp_keterangan'		=> $request->keterangan_subcon,
							'fp_status'			=> 'Released',
							'fp_noinvoice'		=> $request->invoice_subcon,
							'fp_pending_status'	=> 'PENDING',
							'fp_supplier'		=> $request->nama_subcon,
							'fp_netto'			=> $total_subcon,
							'fp_sisapelunasan'  => $total_subcon,
							'fp_edit'			=> 'UNALLOWED',
							'fp_jatuhtempo'		=> carbon::parse(str_replace('/', '-', $request->tempo_subcon))->format('Y-m-d'),
							'fp_idtt'			=> $cari_tt->tt_idform,
							'fp_acchutang'		=> $acc_hutang->acc_code,
							'created_by'  		=> Auth::user()->m_username,
							'updated_by'  		=> Auth::user()->m_username,
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
							  'pb_faktur'  		  => $nota,
							  'pb_status'  		  => 'Released',
							  'pb_kode_subcon'    => $request->nama_subcon,
							  'pb_keterangan' 	  => $request->keterangan_subcon,
							  'updated_at' 		  => Carbon::now(),
							  'created_at' 	      => Carbon::now(),
							  'pb_acc'	      	  => $acc_hutang->acc_code,
							  'pb_csf'	 		  => $acc_hutang->csf_code,
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
				}

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


	  			return Response()->json(['status' => 2,'nota'=>$nota,'id'=>$cari_id]);
			}
		});
	}

	public function subcon_update(request $request){
		return DB::transaction(function() use ($request) {  
   			// dd($request->all());
			$tgl_biaya_head = carbon::parse(str_replace('/', '-', $request->tgl_biaya_head))->format('Y-m-d');

			$total_subcon = filter_var($request->total_subcon, FILTER_SANITIZE_NUMBER_FLOAT)/100;

			$cari_tt = DB::table('form_tt')
						 ->where('tt_nofp',$request->nofaktur)
						 ->first();
			$cari_id = DB::table('faktur_pembelian')
						 ->max('fp_idfaktur');

			if ($cari_id == null) {
				$cari_id = 1;
			}else{
				$cari_id += 1;
			}


			$valid = DB::table('faktur_pembelian')
						 ->where('fp_nofaktur',$request->nofaktur)
						 ->first();

				$acc_hutang = DB::table('subcon')
								->where('kode',$request->nama_subcon)
								->first();

				$save = DB::table('faktur_pembelian')
							->where('fp_nofaktur',$request->nofaktur)
							->update([
							'fp_nofaktur'		=> $request->nofaktur,
							'fp_tgl'			=> $tgl_biaya_head,
							'fp_jenisbayar' 	=> 9,
							'fp_comp'			=> $request->cabang,
							'created_at'		=> Carbon::now(),
							'updated_at'		=> Carbon::now(),
							'fp_keterangan'		=> $request->keterangan_subcon,
							'fp_status'			=> 'Released',
							'fp_noinvoice'		=> $request->invoice_subcon,
							'fp_pending_status'	=> 'PENDING',
							'fp_supplier'		=> $request->nama_subcon,
							'fp_netto'			=> $total_subcon,
							'fp_sisapelunasan'  => $total_subcon,
							'fp_edit'			=> 'UNALLOWED',
							'fp_jatuhtempo'		=> carbon::parse(str_replace('/', '-', $request->tempo_subcon))->format('Y-m-d'),
							'fp_idtt'			=> $cari_tt->tt_idform,
							'fp_acchutang'		=> $acc_hutang->acc_code,
							'created_by'  		=> Auth::user()->m_username,
							'updated_by'  		=> Auth::user()->m_username,
						]);

			

				$save = DB::table('pembayaran_subcon')
							->where('pb_faktur',$request->nofaktur)
							->update([
							  'pb_faktur'  		  => $request->nofaktur,
							  'pb_status'  		  => 'Released',
							  'pb_kode_subcon'    => $request->nama_subcon,
							  'pb_keterangan' 	  => $request->keterangan_subcon,
							  'updated_at' 		  => Carbon::now(),
							  'pb_acc'	      	  => $acc_hutang->acc_code,
							  'pb_csf'	 		  => $acc_hutang->csf_code,
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
				}

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
					   inner join d_uangmuka on um_supplier = fpg_agen
					   where fpgb_posting = 'DONE'
					   and fpg_agen = '$req->sup'");


	$bk  = DB::select("SELECT bkk_nota as nomor,bkk_supplier as agen,bkkd_total as total_um,bkkd_sisaum as sisa_um, d_uangmuka.*
					   from bukti_kas_keluar inner join bukti_kas_keluar_detail on bkkd_bkk_id = bkk_id
					   inner join d_uangmuka on um_supplier = bkk_supplier
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

	return view('purchase.fatkur_pembelian.biaya_penerus_um_modal',compact('data'));
}
public function pilih_um(request $req)
{
	$fpg = DB::select("SELECT fpg_nofpg as nomor, fpg_agen as agen,fpgb_nominal as total_um,fpgdt_sisapelunasanumfp as sisa_um, d_uangmuka.*
					   from fpg inner join fpg_cekbank on fpgb_idfpg = idfpg
					   inner join fpg_dt on fpgdt_idfpg = idfpg
					   inner join d_uangmuka on um_supplier = fpg_agen
					   where fpgb_posting = 'DONE'
					   and fpg_agen = '$req->sup'");


	$bk  = DB::select("SELECT bkk_nota as nomor,bkk_supplier as agen,bkkd_total as total_um,bkkd_sisaum as sisa_um, d_uangmuka.*
					   from bukti_kas_keluar inner join bukti_kas_keluar_detail on bkkd_bkk_id = bkk_id
					   inner join d_uangmuka on um_supplier = bkk_supplier
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
					if ($data[$a]->nomor == $um[$i]->umfpdt_transaksibank and $data[$a]->um_nomorbukti == $um[$i]->umfpdt_notaum) {
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


public function append_um(request $req)
{
	$fpg = DB::select("SELECT fpg_nofpg as nomor, fpg_agen as agen,fpgb_nominal as total_um,fpgdt_sisapelunasanumfp as sisa_um, d_uangmuka.*
					   from fpg inner join fpg_cekbank on fpgb_idfpg = idfpg
					   inner join fpg_dt on fpgdt_idfpg = idfpg
					   inner join d_uangmuka on um_supplier = fpg_agen
					   where fpgb_posting = 'DONE'
					   and fpg_agen = '$req->sup'");


	$bk  = DB::select("SELECT bkk_nota as nomor,bkk_supplier as agen,bkkd_total as total_um,bkkd_sisaum as sisa_um, d_uangmuka.*
					   from bukti_kas_keluar inner join bukti_kas_keluar_detail on bkkd_bkk_id = bkk_id
					   inner join d_uangmuka on um_supplier = bkk_supplier
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
					if ($data[$a]->nomor == $um[$i]->umfpdt_transaksibank and $data[$a]->um_nomorbukti == $um[$i]->umfpdt_notaum) {
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
				}

				$save_dt = DB::table('uangmukapembeliandt_fp')
							  ->insert([
							  	'umfpdt_id' 		   => $dt,
								'umfpdt_transaksibank' => $req->tb_transaksi_um[$i],
								'umfpdt_tgl' 		   => $um->um_tgl,
								'umfpdt_jumlahum'  	   => $um->um_jumlah,
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

			return response()->json(['status'=>1]);
		}
	});
}


public function outlet_um(request $req)
{
	$fpg = DB::select("SELECT fpg_nofpg as nomor, fpg_agen as agen,fpgb_nominal as total_um,fpgdt_sisapelunasanumfp as sisa_um, d_uangmuka.*
					   from fpg inner join fpg_cekbank on fpgb_idfpg = idfpg
					   inner join fpg_dt on fpgdt_idfpg = idfpg
					   inner join d_uangmuka on um_supplier = fpg_agen
					   where fpgb_posting = 'DONE'
					   and fpg_agen = '$req->sup'");


	$bk  = DB::select("SELECT bkk_nota as nomor,bkk_supplier as agen,bkkd_total as total_um,bkkd_sisaum as sisa_um, d_uangmuka.*
					   from bukti_kas_keluar inner join bukti_kas_keluar_detail on bkkd_bkk_id = bkk_id
					   inner join d_uangmuka on um_supplier = bkk_supplier
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
					   inner join d_uangmuka on um_supplier = fpg_agen
					   where fpgb_posting = 'DONE'
					   and fpg_agen = '$req->sup'");


	$bk  = DB::select("SELECT bkk_nota as nomor,bkk_supplier as agen,bkkd_total as total_um,bkkd_sisaum as sisa_um, d_uangmuka.*
					   from bukti_kas_keluar inner join bukti_kas_keluar_detail on bkkd_bkk_id = bkk_id
					   inner join d_uangmuka on um_supplier = bkk_supplier
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
				}

				$save_dt = DB::table('uangmukapembeliandt_fp')
							  ->insert([
							  	'umfpdt_id' 		   => $dt,
								'umfpdt_transaksibank' => $req->tb_transaksi_um[$i],
								'umfpdt_tgl' 		   => $um->um_tgl,
								'umfpdt_jumlahum'  	   => $um->um_jumlah,
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

			return response()->json(['status'=>1]);
		}
	});
}

}



?>