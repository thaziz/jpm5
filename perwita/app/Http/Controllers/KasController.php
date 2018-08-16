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
use App\biaya_penerus_kas;
use App\biaya_penerus_kas_detail;
use App\tb_master_pajak;
use App\tb_coa;
use App\tb_jurnal;
use App\master_akun;
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
use Yajra\Datatables\Datatables;

class KasController extends Controller
{
	public function index(){
		// aaddcc
		$cabang = DB::table('cabang')
                  ->get();
		
		return view('purchase/kas/index',compact('data','cabang'));
	}
	public function append_table(request $req)
	{
		$cab = $req->cabang;
		return view('purchase.kas.table_kas',compact('cab'));
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
			$sql = "SELECT * FROM biaya_penerus_kas  join cabang on kode = bpk_comp where bpk_nota != '0' and bpk_jenis_biaya != 'LOADING' $cabang";
			$data = DB::select($sql);
		}else{
			$cabang = Auth::user()->kode_cabang;
			$data = DB::table('biaya_penerus_kas')
				  ->join('cabang','kode','=','bpk_comp')
				  ->where('kode',$cabang)
				  ->where('bpk_jenis_biaya','!=','LOADING')
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
					  ->orWhere('jenis_biaya',6)
					  ->get();
		return view('purchase/kas/createkas',compact('now','akun','akun_persen','cabang','angkutan','akun_kargo','akun_paket'));
	}
	public function getbbm($id){
		// $id = (string)$id;
		 $angkutan = DB::table('tipe_angkutan')
					// ->select('bbm_per_liter','tipe_angkutan.kode')
					->join('master_bbm','bahan_bakar','=','master_bbm.mb_id')
					->where('kode','=',$id)
					->orderBy('kode','ASC')
				  	->get();
		return response()->json(['angkutan'=>$angkutan]);
	}
	public function cari_resi(Request $request){

		$now = carbon::now()->format('Y-m-d');
		if ($request->data[2]['value'] == 'PAKET') {

			$cari_persen = DB::table('master_persentase')
				  ->join('jenis_bbm','jenis_bbm','=','jb_id')
	    		  ->where('jenis_bbm',$request->data[3]['value'])
	    		  ->where('cabang',$request->head[4]['value'])
	    		  ->first();

		    if ($cari_persen == null) {

		    	$cari_persen = DB::table('master_persentase')
				  	  ->join('jenis_bbm','jenis_bbm','=','jb_id')
		    		  ->where('jenis_bbm',$request->data[3]['value'])
		    		  ->where('cabang','GLOBAL')
		    		  ->first();

		    }
		    
		}else{

			$cari_persen = DB::table('master_persentase')
	    		  ->where('jenis_bbm',$request->data[4]['value'])
	    		  ->where('cabang',$request->head[4]['value'])
	    		  ->first();

		    if ($cari_persen == null) {
		    	$cari_persen = DB::table('master_persentase')
		    		  ->where('jenis_bbm',$request->data[4]['value'])
		    		  ->where('cabang','GLOBAL')
		    		  ->first();
		    	// dd($cari_persen);
		    }

		}
		
		// return dd($cari_persen);

	    
		$total_bbm 	  = filter_var($request->data[8]['value'], FILTER_SANITIZE_NUMBER_INT)/100;
		$data     	  = [];
		$tujuan       = [];
		$total_tarif  = 0;
		$penerus      = [];
		$total_penerus= 0;
		$tipe_data    = $request->head[2]['value'];
		$jenis_biaya  = $cari_persen->jenis_bbm;
		$cabang 	  = $request->head[4]['value'];
		$resi 		  = [];
		$now 		  = Carbon::now()->format('Y-m-d');

		for ($i=0; $i < count($request->resi_array); $i++) {
			if ($jenis_biaya == '3') {
				$cari_resi = DB::table('delivery_order')
							   ->where('pendapatan',$request->jenis_pembiayaan)
							   ->where('jenis_pengiriman','SHUTTLE')
							   ->whereIn('nomor',$request->resi_array)
							   ->orderBy('nomor','ASC')
							   ->get();
				$cari_loading = DB::table('delivery_order')
							   ->where('pendapatan',$request->jenis_pembiayaan)
							   ->whereIn('nomor',$request->resi_array)
							   ->where('jenis_tarif',9)
							   ->orderBy('nomor','ASC')
							   ->get();
				$cari_resi1 = DB::table('delivery_order')
							   ->select('bpkd_no_resi')
							   ->join('biaya_penerus_kas_detail','bpkd_no_resi','=','nomor')
							   ->where('pendapatan',$cari_persen->jenis_pendapatan)
							   ->whereIn('nomor',$request->resi_array)
							   ->groupBy('bpkd_no_resi')
							   ->orderBy('bpkd_no_resi','ASC')
							   ->get();
			}else{
				$cari_resi = DB::table('delivery_order')
							   // ->where('pendapatan',$cari_persen->jenis_pendapatan)
							   ->whereIn('nomor',$request->resi_array)
							   ->orderBy('nomor','ASC')
							   ->get();


				$cari_shuttle = DB::table('delivery_order')
							   ->where('pendapatan',$request->jenis_pembiayaan)
							   ->where('jenis_pengiriman','SHUTTLE')
							   ->whereIn('nomor',$request->resi_array)
							   ->orderBy('nomor','ASC')
							   ->get();
				$cari_loading = DB::table('delivery_order')
							   ->where('pendapatan',$request->jenis_pembiayaan)
							   ->whereIn('nomor',$request->resi_array)
							   ->where('jenis_tarif',9)
							   ->orderBy('nomor','ASC')
							   ->get();
				$cari_resi1 = DB::table('delivery_order')
							   ->select('bpkd_no_resi')
							   ->join('biaya_penerus_kas_detail','bpkd_no_resi','=','nomor')
							   ->where('pendapatan',$cari_persen->jenis_pendapatan)
							   ->whereIn('nomor',$request->resi_array)
							   ->groupBy('bpkd_no_resi')
							   ->orderBy('bpkd_no_resi','ASC')
							   ->get();
			}
		}

		for ($i=0; $i < count($cari_resi); $i++) { 
			$resi[$i] = $cari_resi[$i]->nomor;
			for ($b=0; $b < count($cari_resi1); $b++) { 
				if ($cari_resi1[$b]->bpkd_no_resi == $cari_resi[$i]->nomor) {
					if ($jenis_biaya == '3') {
						// shuttle
						$tarif_shuttle = $cari_resi[$i]->total_net;

						$cari_resi_shuttle = DB::table('biaya_penerus_kas_detail')
											   ->join('biaya_penerus_kas','bpk_id','=','bpkd_bpk_id')
											   ->where('bpkd_no_resi',$cari_resi[$i]->nomor)
											   ->where('bpk_jenis_bbm',$jenis_biaya)
											   ->get();
						$terbayar = [];
						for ($a=0; $a < count($cari_resi_shuttle); $a++) { 
							$terbayar[$a] = $cari_resi_shuttle[$a]->bpkd_tarif_penerus;
						}
						$terbayar = array_sum($terbayar);
						if ($terbayar > $tarif_shuttle) {
							// unset($resi[$i]);
						}

					}elseif ($jenis_biaya == '4' or $jenis_biaya == '7'){
						// lintas  dan penyebrangan
						$cari_resi_lintas = DB::table('biaya_penerus_kas_detail')
											   ->join('biaya_penerus_kas','bpk_id','=','bpkd_bpk_id')
											   ->where('bpkd_no_resi',$cari_resi[$i]->nomor)
											   ->where('biaya_penerus_kas_detail.bpk_comp',$cabang)
											   ->get();

						if ($cari_resi_lintas != null) {
							// unset($resi[$i]);
						}

					}else{
						// unset($resi[$i]);
					}
				}					
			}
		}
		// return $resi;
		$resi = array_unique($resi);
		$resi = array_values($resi);
		for ($i=0; $i < count($resi); $i++) { 
			for ($a=0; $a < count($cari_loading); $a++) { 
				if ($cari_loading[$a]->nomor == $resi[$i]) {
					unset($resi[$i]);
				}
			}
		}

		if ($jenis_biaya == '3') {
			for ($i=0; $i < count($resi); $i++) { 
				for ($a=0; $a < count($cari_shuttle); $a++) { 
					if ($cari_shuttle[$a]->nomor == $resi[$i]) {
						unset($resi[$i]);
					}
				}
			}
		}
		

		$resi = array_values($resi);
		if ($jenis_biaya == '3') {
			for ($i=0; $i < count($resi); $i++) { 
				for ($a=0; $a < count($cari_resi); $a++) { 
					if ($cari_resi[$a]->nomor == $resi[$i]) {
						if (  $now <= $cari_resi[$a]->awal_shutle or $now >= $cari_resi[$a]->akhir_shutle ) {
							unset($resi[$i]);
						}
					}
				}
			}
		}
		$resi = array_values($resi);


		for ($i=0 ; $i < count($resi); $i++) { 

			$cari = DB::table('delivery_order')
				  ->join('kota','id','=','id_kota_asal')
				  ->where('nomor',$resi[$i])
				  ->get();

			$cari1 = DB::table('delivery_order')
				  ->select('nama','id')
				  ->join('kota','id','=','id_kota_tujuan')
				  ->where('nomor',$resi[$i])
				  ->get();

		   	$data[$i]   = $cari;
		   	$tujuan[$i] = $cari1;
		}
		$tidak_ada_akun = [];
		//Menjumlah tarif resi
		$data = array_filter($data);
		$data = array_values($data);
		$tujuan = array_filter($tujuan);
		$tujuan = array_values($tujuan);
		$temp_data = $data;
		for ($i=0; $i < count($temp_data); $i++) { 
			$akun = DB::table('d_akun')
					  ->where('id_akun','like',substr($cari_persen->kode_akun, 0,4).'%')
					  ->where('kode_cabang',$temp_data[$i][0]->kode_cabang)
					  ->first();
			if ($akun == null) {
				unset($data[$i]);
				array_push($tidak_ada_akun, $temp_data[$i][0]->kode_cabang);
			}
		}
		$data = array_filter($data);
		$data = array_values($data);
		if (count($data) != 0) {
			for ($i=0; $i < count($data); $i++) { 
				$total_tarif+=$data[$i][0]->total_net;
			}
		 //Menjumlah bbm dan biaya lain-lain
			$kas_surabaya = $total_bbm;

		//menghitung tarif penerus
			for ($i=0; $i < count($data); $i++) { 
				$hasil=($kas_surabaya/$total_tarif)*$data[$i][0]->total_net;
				$penerus[$i]=$hasil;
			}
		
			$total_penerus =array_sum($penerus);
			$total_penerus =$total_penerus;
			return view('purchase/kas/tabelBiayakas',compact('data','tujuan','total_tarif','kas_surabaya','penerus','total_penerus','tipe_data',compact('tidak_ada_akun')));
	
		}else{
			if (count($tidak_ada_akun) != 0) {
				$array = implode(', ', $tidak_ada_akun);
				return response()->json(['status' => 0,'pesan'=>"Terdapat Data Yang Tidak Memiliki Akun Biaya Untuk Kode Akun ".$array]);
			}else{
				return response()->json(['status' => 0,'pesan'=>"Data Tidak Ada"]);
			}
		}
	}
	public function save_penerus(request $request){
		return DB::transaction(function() use ($request) {  
		 // dd($request->all());

		if ($request->jenis_pembiayaan == 'PAKET') {

			$cari_persen = DB::table('master_persentase')
	    		  ->where('jenis_bbm',$request->pembiayaan_paket)
	    		  ->where('cabang',$request->cabang)
	    		  ->first();



		    if ($cari_persen == null) {

		    	$cari_persen = DB::table('master_persentase')
		    		  ->where('jenis_bbm',$request->pembiayaan_paket)
		    		  ->where('cabang','GLOBAL')
		    		  ->first();

		    }
		    
		}else{

			$cari_persen = DB::table('master_persentase')
	    		  ->where('jenis_bbm',$request->pembiayaan_cargo)
	    		  ->where('cabang',$request->cabang)
	    		  ->first();

		    if ($cari_persen == null) {
		    	$cari_persen = DB::table('master_persentase')
		    		  ->where('jenis_bbm',$request->pembiayaan_cargo)
		    		  ->where('cabang','GLOBAL')
		    		  ->first();

		    }

		}

	    $akun_biaya = $cari_persen->kode_akun;


	    $request->biaya_dll = filter_var($request->biaya_dll, FILTER_SANITIZE_NUMBER_INT);
	    $request->total_bbm = filter_var($request->total_bbm, FILTER_SANITIZE_NUMBER_INT)/100;
	    
	    $terbayar   = [];
	    $pembayaran = [];
	    $bayar 		= [];
	    $sisa 		= [];
		if ($cari_persen->jenis_bbm == '3') {



			for ($i=0; $i < count($request->no_resi); $i++) { 


				$cari_do[$i] = DB::table('delivery_order')
								 ->where('nomor',$request->no_resi[$i])
								 ->get();

				$cari_bpkd[$i] = DB::table('biaya_penerus_kas')
								 ->join('biaya_penerus_kas_detail','bpkd_bpk_id','=','bpk_id')
								 ->where('bpkd_no_resi',$request->no_resi[$i])
								 ->get();

				for ($a=0; $a < count($cari_bpkd[$i]); $a++) { 
					$bayar[$a] = $cari_bpkd[$i][$a]->bpkd_tarif_penerus;
				}

				$terbayar[$i]   = array_sum($bayar);
				$pembayaran[$i] = $cari_do[$i][0]->total_net;

				$sisa[$i] 		= $pembayaran[$i] - $terbayar[$i];
			}

			$terbayar = array_sum($terbayar);
			// dd($sisa);

			$sisa = array_sum($sisa);
			$fix  = array_sum($request->penerus)+$terbayar;

		}else{

			for ($i=0; $i < count($request->no_resi); $i++) { 

				$cari_do[$i] = DB::table('delivery_order')
								 ->where('nomor',$request->no_resi[$i])
								 ->get();

				$pembayaran[$i] = $cari_do[$i][0]->total_net;

			}
			
			$sisa = array_sum($pembayaran);
			$fix  = array_sum($request->penerus);
		}

		// return $fix;
		$fix_tarif_penerus = array_sum($request->penerus);
		$persen = $cari_persen->persen/100;
		$total_tarif = $request->total_tarif*$persen;
		$sisa  = $sisa * $persen;
		// return $sisa;

		if($fix <= $total_tarif){
			$pending_status = 'APPROVED';
		}else{
			$pending_status = 'PENDING';
		}

		if ($pending_status == "PENDING") {

		  return response()->json(['status' => '2','minimal' => $sisa]);
		}
	   	// dd($total_tarif);

		if($request->jenis_pembiayaan=='PAKET'){
			$pembiayaan = $request->pembiayaan_paket;
		}else{
			$pembiayaan = $request->pembiayaan_cargo;
		}
		
		$id = DB::table('biaya_penerus_kas')
				->max('bpk_id');
		if($id != null){
			$id+=1;
		}else{
			$id=1;
		}

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
				$bulan = Carbon::parse(str_replace('/', '-', $request->tN))->format('m');
			    $tahun = Carbon::parse(str_replace('/', '-', $request->tN))->format('y');

			    $cari_nota = DB::select("SELECT  substring(max(bpk_nota),12) as id from biaya_penerus_kas
			                                    WHERE bpk_comp = '$request->cabang'
			                                    AND to_char(bpk_tanggal,'MM') = '$bulan'
			                                    AND to_char(bpk_tanggal,'YY') = '$tahun'
			                                    ");
			    $index = (integer)$cari_nota[0]->id + 1;
			    $index = str_pad($index, 3, '0', STR_PAD_LEFT);

				

				$nota = 'BK' . $bulan . $tahun . '/' . $request->cabang . '/' .$index;
			}
		}elseif ($cari_nota == null) {
			$nota = $request->no_trans;
		}
	 
	    $total_penerus_float = array_sum($request->penerus);

		$nomor=$id;
		biaya_penerus_kas::create([
		  	'bpk_id'      	  	 => $id,
		  	'bpk_nota'  	  	 => $nota,
		  	'bpk_jenis_biaya' 	 => $request->jenis_pembiayaan,
		  	'bpk_pembiayaan'  	 => $pembiayaan,
		  	'bpk_total_tarif' 	 => round($request->total_tarif,2),
		  	'bpk_tanggal'     	 => Carbon::parse(str_replace('/', '-', $request->tN))->format('Y-m-d'),
		  	'bpk_nopol'		  	 => strtoupper($request->nopol),
		  	'bpk_status'	  	 => 'Released',
		  	'bpk_status_pending' => $pending_status,	
		  	'bpk_kode_akun'		 => $request->nama_kas,
		  	'bpk_sopir'		 	 => strtoupper($request->nama_sopir),
		  	'bpk_keterangan'	 => strtoupper($request->note),
		  	'bpk_tipe_angkutan'  => $request->jenis_kendaraan,		
		  	'created_at'		 => Carbon::now(),
		  	'bpk_comp'	 		 => $request->cabang,
		  	'bpk_tarif_penerus'	 => $total_penerus_float,
		  	'bpk_edit'	 		 => 'UNALLOWED',
		  	'bpk_biaya_lain'	 => $request->biaya_dll,
		  	'bpk_jarak'	 		 => $request->km,
		  	'bpk_harga_bbm'	     => $request->total_bbm,
			'bpk_jenis_bbm'      => $cari_persen->jenis_bbm,
			'bpk_acc_biaya'      => $cari_persen->kode_akun,
		  	'created_by'		 => Auth::user()->m_name,
		  	'updated_by'		 => Auth::user()->m_name,
		  ]);

		for ($i=0; $i < count($request->no_resi); $i++) { 


			$dt = DB::table('biaya_penerus_kas_detail')
					->max('bpkd_id');

			if($dt != null){
				$dt+=1;
			}else{
				$dt=1;
			}
			
			if ($cari_persen->jenis_bbm == '3') {
				
					
					biaya_penerus_kas_detail::create([
				  		'bpkd_id'				=> $dt,
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
						'bpk_jenis_bbm'			=> $cari_persen->jenis_bbm,
						'bpkd_pembiayaan'		=> $request->tarif[$i]

				 	 ]);
				

			}else{

				biaya_penerus_kas_detail::create([
			  		'bpkd_id'				=> $dt,
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
					'bpkd_pembiayaan'		=> $request->tarif[$i]

			  ]);
			}
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
				 $jurnal[$i]['harga'] = $harga_array[$i];
				 $jurnal[$i]['asal'] = $unik_asal[$i];

			}

			// IKI MAS JURNAL.E HARGA MBEK ASALE
			
			// //JURNAL
			$id_jurnal=d_jurnal::max('jr_id')+1;
			$jenis_bayar = DB::table('jenisbayar')
							 ->where('idjenisbayar',10)
							 ->first();
			$bank = 'KK'.$request->akun_bank;

            $km =  get_id_jurnal($bank, $request->cb_cabang);

			$jurnal_save = d_jurnal::create(['jr_id'		=> $id_jurnal,
										'jr_year'   => carbon::parse(str_replace('/', '-', $request->tN))->format('Y'),
										'jr_date' 	=> carbon::parse(str_replace('/', '-', $request->tN))->format('Y-m-d'),
										'jr_detail' => $jenis_bayar->jenisbayar,
										'jr_ref'  	=> $nota,
										'jr_note'  	=> 'BIAYA PENERUS KAS '.strtoupper($request->note),
										'jr_insert' => carbon::now(),
										'jr_update' => carbon::now(),
										'jr_no'		=> $km,

										]);

			//IKI TOTAL KABEH HARGANE
			$total_harga=array_sum($harga_array);

			$cari_akun = substr($cari_persen->kode_akun, 0,4);



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
					return response()->json(['status'=>'3','data'=>'Terdapat Resi Yang Tidak Memiliki Akun Biaya']);
				}

				$cari_id_pc = DB::table('patty_cash')
							 ->max('pc_id')+1;


				$save_patty = DB::table('patty_cash')
					   ->insert([
					   		'pc_id'			  => $cari_id_pc,
					   		'pc_tgl'		  => Carbon::parse(str_replace('/', '-', $request->tN))->format('Y-m-d'),
					   		'pc_ref'	 	  => 10,
					   		'pc_akun' 		  => $acc->id_akun,
					   		'pc_akun_kas' 	  => $request->nama_kas,
					   		'pc_keterangan'	  => $request->note,
					   		'pc_asal_comp' 	  => $jurnal[$i]['asal'],
					   		'pc_comp'  	  	  => $request->cabang,
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
			// dd($lihat_jurnal);
		  			

		  if ($pending_status == "APPROVED") {

		  	return response()->json(['status' => '1','id'=>$cari_id[0]->bpk_id]);
		  }else{
		  	
		  	return response()->json(['status' => '2','minimal' => $sisa,'id'=>$cari_id[0]->bpk_id]);
		  }


		  });
	}
	public function edit(request $request){
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
					  ->where('jenis_biaya',1)
					  ->get();

		$akun_kargo  = DB::table('master_persentase')
					  ->where('cabang','GLOBAL')
					  ->where('jenis_biaya',5)
					  ->where('cabang','GLOBAL')
					  ->get();

		$data = DB::table('biaya_penerus_kas')
				  ->where('bpk_id',$request->id)
				  ->first();


		$data_dt = DB::table('biaya_penerus_kas_detail')
				  ->where('bpkd_bpk_id',$request->id)
				  ->get();

		$akun_kas = DB::table('d_akun')
    			  ->where('id_akun','like','1001'.'%')
    			  ->where('kode_cabang',$data->bpk_comp)
    			  ->get();
		$id = $request->id;
		for ($i=0; $i < count($data_dt); $i++) { 
			$resi[$i] = $data_dt[$i]->bpkd_no_resi;
		}
		$resi = implode(" ", $resi);
		return view('purchase/kas/editkas',compact('now','akun','akun_persen','cabang','angkutan','akun_kargo','akun_paket','data','data_dt','id','akun_kas','resi'));
		
	}
	public function update_penerus(request $request){
		return DB::transaction(function() use ($request) {  
		 // dd($request->all());

		// $delete = DB::table('biaya_penerus_kas')
		// 			->where('bpk_id',$request->id)
		// 			->delete();
		$delete1 = DB::table('biaya_penerus_kas_detail')
					->where('bpkd_bpk_id',$request->id)
					->delete();

		if ($request->jenis_pembiayaan == 'PAKET') {

			$cari_persen = DB::table('master_persentase')
	    		  ->where('jenis_bbm',$request->pembiayaan_paket)
	    		  ->where('cabang',$request->cabang)
	    		  ->first();



		    if ($cari_persen == null) {

		    	$cari_persen = DB::table('master_persentase')
		    		  ->where('jenis_bbm',$request->pembiayaan_paket)
		    		  ->where('cabang','GLOBAL')
		    		  ->first();

		    }
		    
		}else{

			$cari_persen = DB::table('master_persentase')
	    		  ->where('jenis_bbm',$request->pembiayaan_cargo)
	    		  ->where('cabang',$request->cabang)
	    		  ->first();

		    if ($cari_persen == null) {
		    	$cari_persen = DB::table('master_persentase')
		    		  ->where('jenis_bbm',$request->pembiayaan_cargo)
		    		  ->where('cabang','GLOBAL')
		    		  ->first();

		    }

		}

	    $akun_biaya = $cari_persen->kode_akun;


	    $request->biaya_dll = filter_var($request->biaya_dll, FILTER_SANITIZE_NUMBER_FLOAT);
	    $request->total_bbm = filter_var($request->total_bbm, FILTER_SANITIZE_NUMBER_FLOAT);
	    
	    $terbayar   = [];
	    $pembayaran = [];
	    $bayar 		= [];
	    $sisa 		= [];
		if ($cari_persen->jenis_bbm == '3') {



			for ($i=0; $i < count($request->no_resi); $i++) { 


				$cari_do[$i] = DB::table('delivery_order')
								 ->where('nomor',$request->no_resi[$i])
								 ->get();

				$cari_bpkd[$i] = DB::table('biaya_penerus_kas')
								 ->join('biaya_penerus_kas_detail','bpkd_bpk_id','=','bpk_id')
								 ->where('bpkd_no_resi',$request->no_resi[$i])
								 ->get();

				for ($a=0; $a < count($cari_bpkd[$i]); $a++) { 
					$bayar[$a] = $cari_bpkd[$i][$a]->bpkd_tarif_penerus;
				}

				$terbayar[$i]   = array_sum($bayar);
				$pembayaran[$i] = $cari_do[$i][0]->total_net;

				$sisa[$i] 		= $pembayaran[$i] - $terbayar[$i];
			}
			$terbayar = array_sum($terbayar);
			// dd($sisa);

			$sisa = array_sum($sisa);
			$fix  = array_sum($request->penerus)+$terbayar;

		}else{

			for ($i=0; $i < count($request->no_resi); $i++) { 

				$cari_do[$i] = DB::table('delivery_order')
								 ->where('nomor',$request->no_resi[$i])
								 ->get();

				$pembayaran[$i] = $cari_do[$i][0]->total_net;

			}
			
			$sisa = array_sum($pembayaran);
			$fix  = array_sum($request->penerus);
		}

		// return $fix;
		$fix_tarif_penerus = array_sum($request->penerus);
		$persen = $cari_persen->persen/100;
		$total_tarif = $request->total_tarif*$persen;
		$sisa  = $sisa * $persen;
		// return $sisa;

		if($fix <= $total_tarif){
			$pending_status = 'APPROVED';
		}else{
			$pending_status = 'PENDING';
		}


		if ($pending_status == "PENDING") {

		  return response()->json(['status' => '2','minimal' => $sisa]);
		}

	   	// dd($total_tarif);

		if($request->jenis_pembiayaan=='PAKET'){
			$pembiayaan = $request->pembiayaan_paket;
		}else{
			$pembiayaan = $request->pembiayaan_cargo;
		}
		
		$id = DB::table('biaya_penerus_kas')
				->max('bpk_id');
		if($id != null){
			$id+=1;
		}else{
			$id=1;
		}


	    $isset =  DB::table('biaya_penerus_kas')
	    		  ->select('bpk_nota')
	    		  ->get();

	    $ada_data = 0;
	    for ($i=0; $i < count($isset); $i++) { 
	    	if($isset[$i]->bpk_nota == $request->no_trans){
	    		$ada_data = 1;
	    	}
	    }
	    $total_penerus_float = array_sum($request->penerus);
	    $request->biaya_dll = filter_var($request->biaya_dll, FILTER_SANITIZE_NUMBER_INT);
	    $request->total_bbm = filter_var($request->total_bbm, FILTER_SANITIZE_NUMBER_INT)/100;
		$nomor=$id;
		biaya_penerus_kas::where('bpk_id',$request->id)->update([
		  	'bpk_nota'  	  	 => $request->no_trans,
		  	'bpk_jenis_biaya' 	 => $request->jenis_pembiayaan,
		  	'bpk_pembiayaan'  	 => $pembiayaan,
		  	'bpk_total_tarif' 	 => round($request->total_tarif,2),
		  	'bpk_tanggal'     	 => Carbon::parse(str_replace('/', '-', $request->tN))->format('Y-m-d'),
		  	'bpk_nopol'		  	 => strtoupper($request->nopol),
		  	'bpk_status'	  	 => 'Released',
		  	'bpk_status_pending' => $pending_status,	
		  	'bpk_kode_akun'		 => $request->nama_kas,
		  	'bpk_sopir'		 	 => strtoupper($request->nama_sopir),
		  	'bpk_keterangan'	 => strtoupper($request->note),
		  	'bpk_tipe_angkutan'  => $request->jenis_kendaraan,		
		  	'created_at'		 => Carbon::now(),
		  	'bpk_comp'	 		 => $request->cabang,
		  	'bpk_tarif_penerus'	 => $total_penerus_float,
		  	'bpk_edit'	 		 => 'UNALLOWED',
		  	'bpk_biaya_lain'	 => $request->biaya_dll,
		  	'bpk_jarak'	 		 => $request->km,
		  	'bpk_harga_bbm'	     => $request->total_bbm,
			'bpk_jenis_bbm'      => $cari_persen->jenis_bbm,
			'bpk_acc_biaya'      => $cari_persen->kode_akun,
		  	'created_by'		 => Auth::user()->m_name,
		  	'updated_by'		 => Auth::user()->m_name,
		  ]);



		for ($i=0; $i < count($request->no_resi); $i++) { 


			$dt = DB::table('biaya_penerus_kas_detail')
					->max('bpkd_id');

			if($dt != null){
				$dt+=1;
			}else{
				$dt=1;
			}
			
			if ($cari_persen->jenis_bbm == '3') {
				
					
				biaya_penerus_kas_detail::create([
			  		'bpkd_id'				=> $dt,
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
					'bpk_jenis_bbm'			=> $cari_persen->jenis_bbm,
					'bpkd_pembiayaan'		=> $request->tarif[$i]

			 	 ]);
				

			}else{

				biaya_penerus_kas_detail::create([
			  		'bpkd_id'				=> $dt,
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
					'bpkd_pembiayaan'		=> $request->tarif[$i]

			  ]);
			}
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
				 $jurnal[$i]['harga'] = $harga_array[$i];
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


			$bank = 'KK'.$request->akun_bank;
            $km =  get_id_jurnal($bank, $request->cb_cabang);
			$jurnal_save = d_jurnal::create(['jr_id'=> $id_jurnal,
										'jr_year'   => carbon::parse(str_replace('/', '-', $request->tN))->format('Y'),
										'jr_date' 	=> carbon::parse(str_replace('/', '-', $request->tN))->format('Y-m-d'),
										'jr_detail' => $jenis_bayar->jenisbayar,
										'jr_ref'  	=> $request->no_trans,
										'jr_note'  	=> 'BIAYA PENERUS KAS '.strtoupper($request->note),
										'jr_insert' => carbon::now(),
										'jr_update' => carbon::now(),
										'jr_no'		=> $km,
										]);

			//IKI TOTAL KABEH HARGANE
			$total_harga=array_sum($harga_array);

			$cari_akun = substr($cari_persen->kode_akun, 0,4);



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
					   		'pc_tgl'		  => Carbon::parse(str_replace('/', '-', $request->tN))->format('Y-m-d'),
					   		'pc_ref'	 	  => 10,
					   		'pc_akun' 		  => $acc->id_akun,
					   		'pc_akun_kas' 	  => $request->nama_kas,
					   		'pc_keterangan'	  => $request->note,
					   		'pc_asal_comp' 	  => $jurnal[$i]['asal'],
					   		'pc_comp'  	  	  => $request->cabang,
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
		  			

		  if ($pending_status == "APPROVED") {

		  	return response()->json(['status' => '1','id'=>$cari_id[0]->bpk_id]);
		  }else{
		  	
		  	return response()->json(['status' => '2','minimal' => $sisa,'id'=>$cari_id[0]->bpk_id]);
		  }


		});
	}

	public function hapus($id){
		$cari = DB::table('biaya_penerus_kas')
					->where('bpk_id',$id)
					->first();

		$delete_jurnal = DB::table('d_jurnal')
							   ->where('jr_ref',$cari->bpk_nota)
							   ->delete();
							   
		$delete = DB::table('biaya_penerus_kas')
					->where('bpk_id',$id)
					->delete();
		$delete1 = DB::table('biaya_penerus_kas_detail')
					->where('bpkd_bpk_id',$id)
					->delete();
	}
	public function buktikas(request $request){
		// dd($request);
		
		$cari_id = DB::table('biaya_penerus_kas')
		  			   ->where('bpk_id','=',$request->id)
		  			   ->get();

		$cari=DB::table('biaya_penerus_kas')			
					 ->join('cabang','kode','=','bpk_comp')
					 ->where('bpk_id','=',$request->id)
					 ->get();

		$cari_akun=DB::table('master_persentase')			
					 ->join('biaya_penerus_kas','bpk_pembiayaan','=','kode')
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
			$akun_biaya = [];
			for ($i=0; $i < count($unik_asal); $i++) { 
				$temp = DB::table('d_akun')
						  ->where("id_akun",'like',substr($cari_id[0]->bpk_acc_biaya,0,4).'%')
						  ->where('kode_cabang',$unik_asal[$i])
						  ->first();
				array_push($akun_biaya,$temp->id_akun);
			}
			for ($i=0; $i < count($unik_asal); $i++) { 
				${'total'.$unik_asal[$i]} = array_sum(${$unik_asal[$i]});
			}
			// $harga_array = [];
			for ($i=0; $i < count($unik_asal); $i++) { 
				 $harga_array[$i] = ${'total'.$unik_asal[$i]};
			}
			for ($i=0; $i < count($harga_array); $i++) { 
				 $harga_array[$i] = round($harga_array[$i]);
			}
			$total_harga=round($cari_id[0]->bpk_tarif_penerus);

			$terbilang = $this->terbilang(round($total_harga),$style=3);

			if(count($harga_array)<10){
				$td = 10-count($harga_array);
				for ($i=0; $i < $td; $i++) {  
					if(!isset($harga_array[$i])){
						$harga_array[$i] = ' ';
					}
				}
			}
		}
		return view('purchase/kas/buktikas',compact('cari','harga_array','total_harga','terbilang','cari_akun','akun_biaya'));

	}

	public function detailkas(request $request){
		$cari_id = DB::table('biaya_penerus_kas')
		  			   ->where('bpk_id','=',$request->id)
		  			   ->get();

		$cari     = DB::table('biaya_penerus_kas')			
					 ->join('cabang','kode','=','bpk_comp')
					 ->where('bpk_id','=',$request->id)
					 ->get();
		$cari_dt  = DB::table('biaya_penerus_kas_detail')	
					 ->join('kota','id','=','bpkd_asal')
					 ->where('bpkd_bpk_id','=',$request->id)
					 ->get();
	    $cari_asal=DB::table('biaya_penerus_kas_detail')
	    			 ->select('bpkd_kode_cabang_awal')			
					 ->where('bpkd_bpk_id','=',$request->id)
					 ->get();
		$tujuan   =DB::table('biaya_penerus_kas_detail')		
					 ->join('kota','id','=','bpkd_tujuan')
					 ->where('bpkd_bpk_id','=',$request->id)
					 ->orderBy('bpkd_bpk_dt','ASC')
					 ->get();

		$tgl = Carbon::parse($cari[0]->bpk_tanggal)->format('d/m/Y');

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
				 $harga_array[$i] = round($harga_array[$i]);
			}
			// return $harga_array;
			$total_harga=array_sum($harga_array);
			// return $total_harga;
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

		$pdf = PDF::loadView('purchase/kas/detailkas',compact('cari','cari_dt','harga_array','total_harga','terbilang','tgl','tujuan'))
					->setPaper('a4','potrait');
			return $pdf->stream('detail-biaya-penerus-'.$cari[0]->bpk_nota.'.pdf');

	}


	public function carinopol(request $request){
			$request->term = strtoupper($request->term);
		
	        $results = array();
	        $queries = DB::table('kendaraan')
			            ->where('nopol', 'like', '%'.$request->term.'%')
			            ->take(10)->get();

	        if ($queries == null){
	            $results[] = [ 'id' => null, 'label' => 'Tidak ditemukan data terkait'];
	        } else {

	            foreach ($queries as $query)
	            {
	                $results[] = [ 'id' => $query->nopol, 'label' => $query->nopol,'validator'=>$query->nopol];
	            }
	        }

	        return Response::json($results);


	}

	public function cariresiedit(request $request){
		if ($request->data[2]['value'] == 'PAKET') {

			$cari_persen = DB::table('master_persentase')
	    		  ->where('jenis_bbm',$request->data[3]['value'])
	    		  ->where('cabang',$request->head[4]['value'])
	    		  ->first();

		    if ($cari_persen == null) {
		    	$cari_persen = DB::table('master_persentase')
		    		  ->where('jenis_bbm',$request->data[3]['value'])
		    		  ->where('cabang','GLOBAL')
		    		  ->first();

		    }
		    
		}else{

			$cari_persen = DB::table('master_persentase')
	    		  ->where('jenis_bbm',$request->data[4]['value'])
	    		  ->where('cabang',$request->head[4]['value'])
	    		  ->first();

		    if ($cari_persen == null) {
		    	$cari_persen = DB::table('master_persentase')
		    		  ->where('jenis_bbm',$request->data[4]['value'])
		    		  ->where('cabang','GLOBAL')
		    		  ->first();

		    }

		}
		
		// return dd($cari_persen);

	    
		$total_bbm	  = filter_var($request->data[8]['value'], FILTER_SANITIZE_NUMBER_INT)/100;
		$data     	  = [];
		$tujuan       = [];
		$total_tarif  = 0;
		$penerus      = [];
		$total_penerus= 0;
		$tipe_data    = $request->head[2]['value'];
		$jenis_biaya  = $cari_persen->jenis_bbm;
		$cabang 	  = $request->head[4]['value'];
		$resi 		  = [];
		$now 		  = Carbon::now()->format('Y-m-d');

		for ($i=0; $i < count($request->resi_array); $i++) { 
			if ($jenis_biaya == '3') {
				$cari_resi = DB::table('delivery_order')
							   ->where('pendapatan',$request->jenis_pembiayaan)
							   ->where('jenis_pengiriman','SHUTTLE')
							   ->whereIn('nomor',$request->resi_array)
							   ->orderBy('nomor','ASC')
							   ->get();

				$cari_resi1 = DB::table('delivery_order')
							   ->select('bpkd_no_resi')
							   ->join('biaya_penerus_kas_detail','bpkd_no_resi','=','nomor')
							   ->where('pendapatan',$cari_persen->jenis_pendapatan)
							   ->whereIn('nomor',$request->resi_array)
							   ->groupBy('bpkd_no_resi')
							   ->orderBy('bpkd_no_resi','ASC')
							   ->get();

				$cari_resi1 = DB::table('delivery_order')
							   ->select('bpkd_no_resi')
							   ->join('biaya_penerus_kas_detail','bpkd_no_resi','=','nomor')
							   ->where('pendapatan',$cari_persen->jenis_pendapatan)
							   ->whereIn('nomor',$request->resi_array)
							   ->groupBy('bpkd_no_resi')
							   ->orderBy('bpkd_no_resi','ASC')
							   ->get();

				$cari_loading = DB::table('delivery_order')
							   ->where('pendapatan',$cari_persen->jenis_pendapatan)
							   ->whereIn('nomor',$request->resi_array)
							   ->where('jenis_tarif',9)
							   ->orderBy('nomor','ASC')
							   ->get();

				$cari_resi2 = DB::table('biaya_penerus_kas_detail')
							   	->where('bpkd_bpk_id',$request->id)
							   ->get();
			}else{
				$cari_resi = DB::table('delivery_order')
							   ->where('pendapatan',$cari_persen->jenis_pendapatan)
							   ->whereIn('nomor',$request->resi_array)
							   ->orderBy('nomor','ASC')
							   ->get();
				$cari_resi1 = DB::table('delivery_order')
							   ->select('bpkd_no_resi')
							   ->join('biaya_penerus_kas_detail','bpkd_no_resi','=','nomor')
							   ->where('pendapatan',$cari_persen->jenis_pendapatan)
							   ->whereIn('nomor',$request->resi_array)
							   ->groupBy('bpkd_no_resi')
							   ->orderBy('bpkd_no_resi','ASC')
							   ->get();

				$cari_resi1 = DB::table('delivery_order')
							   ->select('bpkd_no_resi')
							   ->join('biaya_penerus_kas_detail','bpkd_no_resi','=','nomor')
							   ->where('pendapatan',$cari_persen->jenis_pendapatan)
							   ->whereIn('nomor',$request->resi_array)
							   ->groupBy('bpkd_no_resi')
							   ->orderBy('bpkd_no_resi','ASC')
							   ->get();

				$cari_loading = DB::table('delivery_order')
							   ->where('pendapatan',$cari_persen->jenis_pendapatan)
							   ->whereIn('nomor',$request->resi_array)
							   ->where('jenis_tarif',9)
							   ->orderBy('nomor','ASC')
							   ->get();

				$cari_resi2 = DB::table('biaya_penerus_kas_detail')
							   	->where('bpkd_bpk_id',$request->id)
							   ->get();
			}
			
			
		}
		// return $cari_resi2;
		for ($i=0; $i < count($cari_resi); $i++) { 
			$resi[$i] = $cari_resi[$i]->nomor;
			for ($b=0; $b < count($cari_resi1); $b++) { 
				if ($cari_resi1[$b]->bpkd_no_resi == $cari_resi[$i]->nomor) {
					if ($jenis_biaya == '3') {
						// shuttle
						$tarif_shuttle = $cari_resi[$i]->total_net;

						$cari_resi_shuttle = DB::table('biaya_penerus_kas_detail')
											   ->join('biaya_penerus_kas','bpk_id','=','bpkd_bpk_id')
											   ->where('bpkd_no_resi',$cari_resi[$i]->nomor)
											   ->where('bpk_jenis_bbm',$jenis_biaya)
											   ->get();
						$terbayar = [];
						for ($a=0; $a < count($cari_resi_shuttle); $a++) { 
							$terbayar[$a] = $cari_resi_shuttle[$a]->bpkd_tarif_penerus;
						}
						$terbayar = array_sum($terbayar);
						if ($terbayar > $tarif_shuttle) {
							unset($resi[$i]);
						}

					}elseif ($jenis_biaya == '4' or $jenis_biaya == '7'){
						// lintas  dan penyebrangan
						$cari_resi_lintas = DB::table('biaya_penerus_kas_detail')
											   ->join('biaya_penerus_kas','bpk_id','=','bpkd_bpk_id')
											   ->where('bpkd_no_resi',$cari_resi[$i]->nomor)
											   ->where('biaya_penerus_kas_detail.bpk_comp',$cabang)
											   ->get();

						if ($cari_resi_lintas != null) {
							// unset($resi[$i]);
						}

					}else{
						// unset($resi[$i]);
					}
				}					
			}
		}
		// $resi = array_filter($resi);
		$resi = array_values($resi);
		$resi = array_unique($resi);
		// return $resi;
		
		for ($i=0; $i < count($resi); $i++) { 
			for ($a=0; $a < count($cari_shuttle); $a++) { 
				if ($cari_shuttle[$a]->nomor == $resi[$i]) {
					unset($resi[$i]);
				}
			}
		}

		
		$resi = array_unique($resi);
		$resi = array_values($resi);

		for ($i=0; $i < count($resi); $i++) { 
			for ($a=0; $a < count($cari_loading); $a++) { 
				if ($cari_loading[$a]->nomor == $resi[$i]) {
					unset($resi[$i]);
				}
			}
		}
		
		$resi = array_unique($resi);
		$resi = array_values($resi);


		if ($jenis_biaya == '3') {
			for ($i=0; $i < count($resi); $i++) { 
				for ($a=0; $a < count($cari_resi); $a++) { 
					if ($cari_resi[$a]->nomor == $resi[$i]) {
						if (  $now <= $cari_resi[$a]->awal_shutle or $now >= $cari_resi[$a]->akhir_shutle ) {
							unset($resi[$i]);
						}
					}
				}
			}
		}

		for ($i=0; $i < count($cari_resi2); $i++) { 
			for ($a=0; $a < count($cari_resi); $a++) { 
				if ($cari_resi[$a]->nomor == $cari_resi2[$i]->bpkd_no_resi) {
					array_push($resi, $cari_resi[$a]->nomor);
				}
			}
		}
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
		$temp_data = $data;
		$tidak_ada_akun = [];
		for ($i=0; $i < count($temp_data); $i++) { 
			$akun = DB::table('d_akun')
					  ->where('id_akun','like',substr($cari_persen->kode_akun, 0,4).'%')
					  ->where('kode_cabang',$temp_data[$i][0]->kode_cabang)
					  ->first();
			if ($akun == null) {
				unset($data[$i]);
				array_push($tidak_ada_akun, 'TIDAK');
			}
		}
		$data = array_filter($data);
		$data = array_values($data);
		if (count($data) != 0) {
			for ($i=0; $i < count($data); $i++) { 
				$total_tarif+=$data[$i][0]->total_net;
			}
		 //Menjumlah bbm dan biaya lain-lain
			$kas_surabaya = $total_bbm;

		//menghitung tarif penerus
			for ($i=0; $i < count($data); $i++) { 
				$hasil=($kas_surabaya/$total_tarif)*$data[$i][0]->total_net;
				$penerus[$i]=$hasil;
			}
		
			$total_penerus =array_sum($penerus);
			$total_penerus =$total_penerus;
			return view('purchase/kas/tabelBiayakas',compact('data','tujuan','total_tarif','kas_surabaya','penerus','total_penerus','tipe_data'));
	
		}else{
			if (count($tidak_ada_akun) != 0) {
				$array = implode(', ', $tidak_ada_akun);
				return response()->json(['status' => 0,'pesan'=>"Terdapat Data Yang Tidak Memiliki Akun Biaya Untuk Kode Akun ".$array]);
			}else{
				return response()->json(['status' => 0,'pesan'=>"Data Tidak Ada"]);
			}
		}
	}


    public function ganti_nota(request $request)
    {

		// return DB::transaction(function() use ($request) {  
  //   	$data = DB::table('biaya_penerus_kas')
	 //    		  ->orderBy('bpk_id','ASC')
  //   			  ->get();

  //   	$comp1 = DB::table('biaya_penerus_kas')
  //   			  ->select('bpk_comp')
  //   			  ->get();
  //   	$comp = [];
	 //    	for ($i=0; $i < count($comp1); $i++) { 
	 //    		$comp[$i] = $comp1[$i]->bpk_comp;
	 //    	}
	 //    	$comp = array_unique($comp);
	 //    	$comp = array_values($comp);

	 //    	for ($i=0; $i < count($comp); $i++) { 
	 //    		$tahun = [];
	 //    		$tahun1 = DB::table('biaya_penerus_kas')
	 //    				  ->select('bpk_tanggal')
	 //    				  ->where('bpk_comp',$comp[$i])
		//     			  ->get();

		//     	for ($t=0; $t < count($tahun1); $t++) { 
		//     		$tahun[$t] = carbon::parse($tahun1[$t]->bpk_tanggal)->format('Y');
		//     	}
		//     	$tahun = array_unique($tahun);
		//     	$tahun = array_values($tahun);
		//     	for ($a=0; $a < count($tahun); $a++) { 
		//     		$bulan = [];
	 //    			$bulan1 = DB::table('biaya_penerus_kas')
		//     				  ->select('bpk_tanggal')
		//     				  ->where('bpk_comp',$comp[$i])
		//     				  ->whereYear('bpk_tanggal','=',$tahun[$a])
		// 	    			  ->get();
		// 	    	for ($t=0; $t < count($bulan1); $t++) { 
		// 	    		$bulan[$t] = carbon::parse($bulan1[$t]->bpk_tanggal)->format('m');
		// 	    	}

		// 	    	$bulan = array_unique($bulan);
		// 	    	$bulan = array_values($bulan);
		// 	    	for ($b=0; $b < count($bulan); $b++) { 
		// 	    		$index = 0;
		// 	    		for ($c=0; $c < count($data); $c++) { 
		// 	    			if ($data[$c]->bpk_comp == $comp[$i] and 
		// 	    				carbon::parse($data[$c]->bpk_tanggal)->format('Y') == $tahun[$a] and
		// 	    				carbon::parse($data[$c]->bpk_tanggal)->format('m') == $bulan[$b]) {
			    				
		// 					    $index = (integer)$index + 1;
		// 					    $index = str_pad($index, 3, '0', STR_PAD_LEFT);
		// 						$nota = 'BK' . $bulan[$b] . carbon::parse($tahun[$a])->format('y'). '/' . $comp[$i] . '/' .$index;

		// 						$update = DB::table('biaya_penerus_kas')
		// 									->where('bpk_id',$data[$c]->bpk_id)
		// 									->update([
		// 										'bpk_nota'=>$nota
		// 									]);
		// 	    			}
		// 	    		}
		// 	    	}

		//     	}
	 //    	}

	 //    	$data = DB::table('biaya_penerus_kas')
	 //    		  ->orderBy('bpk_id','ASC')
  //   			  ->get();
  //   		// dd($data);
  //   	});
    	// return true;
	    $bulan = Carbon::parse(str_replace('/', '-', $request->tanggal))->format('m');
	    $tahun = Carbon::parse(str_replace('/', '-', $request->tanggal))->format('y');

	    $cari_nota = DB::select("SELECT  substring(max(bpk_nota),12) as id from biaya_penerus_kas
	                                    WHERE bpk_comp = '$request->cabang'
	                                    AND to_char(bpk_tanggal,'MM') = '$bulan'
	                                    AND to_char(bpk_tanggal,'YY') = '$tahun'
	                                    ");
	    $index = (integer)$cari_nota[0]->id + 1;
	    $index = str_pad($index, 3, '0', STR_PAD_LEFT);

		

		$nota = 'BK' . $bulan . $tahun . '/' . $request->cabang . '/' .$index;
		/*dd($data['nofp']);*/

		return response()->json(['nota' => $nota]);
    }
    public function akun_kas(request $request)
    {
    	$data = DB::table('d_akun')
    			  ->where('id_akun','like','1001'.'%')
    			  ->where('kode_cabang',$request->cabang)
    			  ->get();

    	return view('purchase/kas/akun_kas',compact('data'));
    }
    public function nopol(request $request)
    {	
    	if (isset($request->id_nopol)) {
    		$id = $request->id_nopol;
    	}else{
    		$id = 0;
    	}
    	
    	$data = DB::table('kendaraan')
    			   ->where('tipe_angkutan',$request->jenis)
    			   ->where('status','!=','SUB')
    			   ->get();


    	$tipe = DB::table('tipe_angkutan')
    			   ->where('kode',$request->jenis)
    			   ->first();

    	return view('purchase/kas/nopol',compact('data','tipe','id'));

    }

    public function jurnal(request $req)
	{
		$bkk = DB::table('biaya_penerus_kas')	
				 ->where('bpk_id',$req->id)
				 ->first();
		$data= DB::table('d_jurnal')
				 ->join('d_jurnal_dt','jrdt_jurnal','=','jr_id')
				 ->join('d_akun','jrdt_acc','=','id_akun')
				 ->where('jr_ref',$bkk->bpk_nota)
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
		$d = round($d);
		$k = round($k);
		return view('purchase.buktikaskeluar.jurnal',compact('data','d','k'));
	}
}

?>