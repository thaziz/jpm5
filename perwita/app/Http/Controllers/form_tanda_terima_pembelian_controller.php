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

class form_tanda_terima_pembelian_controller extends Controller
{
    public function index()
    {
    	return view('purchase.form_tt.index_tt');
    }

    public function create()
    {
    	$agen 	  = DB::select("SELECT kode, nama from agen order by kode");

		$vendor   = DB::select("SELECT kode, nama from vendor order by kode "); 

		$subcon   = DB::select("SELECT kode, nama from subcon order by kode "); 

		$supplier = DB::select("SELECT no_supplier as kode, nama_supplier as nama from supplier where status = 'SETUJU' and active = 'AKTIF' order by no_supplier");

		$all = array_merge($agen,$vendor,$subcon,$supplier);

		$cabang = DB::table('cabang')
					->get();

		$nextDay = carbon::now()->subDays(-7)->format('d/m/Y');
    	return view('purchase.form_tt.create_tt',compact('all','cabang','nextDay'));
    }

    public function nota(Request $req)
    {
    	$bulan = Carbon::parse(str_replace('/', '-', $req->tanggal))->format('m');
	    $tahun = Carbon::parse(str_replace('/', '-', $req->tanggal))->format('y');

	    $cari_nota = DB::select("SELECT  substring(max(tt_noform),12) as id from form_tt
	                                    WHERE tt_idcabang = '$req->cabang'
	                                    AND to_char(tt_tgl,'MM') = '$bulan'
	                                    AND to_char(tt_tgl,'YY') = '$tahun'");

	    $index = (integer)$cari_nota[0]->id + 1;
	    $index = str_pad($index, 3, '0', STR_PAD_LEFT);

		
		$nota = 'TT' . $bulan . $tahun . '/' . $req->cabang . '/' .$index;

    	return Response::json(['nota'=>$nota]);
    }
    public function save(Request $req)
    {
   		return DB::transaction(function() use ($req) {  
   			
   			if (Auth::user()->m_name == null) {
				return response()->json([
					'status'=>1,
					'message'=>'Nama User Anda Belum Ada, Silahkan Hubungi Pihak Terkait'
				]);
			}

			$cari_nota = DB::table('bukti_kas_keluar')
						   ->where('bkk_nota',$req->nota)
						   ->first();
						   
			if ($cari_nota != null) {
				if ($cari_nota->updated_by == $user) {
					return 'Data Sudah Ada';
				}else{
					$bulan = Carbon::parse(str_replace('/', '-', $req->tanggal))->format('m');
				    $tahun = Carbon::parse(str_replace('/', '-', $req->tanggal))->format('y');

				    $cari_nota = DB::select("SELECT  substring(max(tt_noform),12) as id from form_tt
				                                    WHERE tt_idcabang = '$req->cabang'
				                                    AND to_char(tt_tgl,'MM') = '$bulan'
				                                    AND to_char(tt_tgl,'YY') = '$tahun'");

				    $index = (integer)$cari_nota[0]->id + 1;
				    $index = str_pad($index, 3, '0', STR_PAD_LEFT);

					
					$nota = 'TT' . $bulan . $tahun . '/' . $req->cabang . '/' .$index;
				}
			}elseif ($cari_nota == null) {
				$nota = $req->nota;
			}
			$id = DB::table('form_tt')
					->max('tt_idform')+1;

			$total = 0;
			for ($i=0; $i < count($req->nominal); $i++) { 
				$total += filter_var($req->nominal[$i],FILTER_SANITIZE_NUMBER_INT);
			}
			dd($req->all());
			$save = DB::table('form_tt')
						->insert([
							'tt_idform' 		=> $id,
							'tt_tgl' 			=> carbon::parse(str_replace('/','-',$req->tanggal))->format('Y-m-d'),
							'tt_lainlain' 		=> $req->lain,
							'tt_tglkembali' 	=> carbon::parse(str_replace('/','-',$req->tanggal_kembali))->format('Y-m-d'),
							'tt_totalterima' 	=> $total,
							'created_at' 		=> carbon::now(),
							'updated_at' 		=> carbon::now(),
							'tt_kwitansi' 		=> $req->kwitansi,
							'tt_suratperan' 	=> $req->surat_peranan,
							'tt_suratjalanasli' => $req->surat_jalan,
							'tt_noform' 		=> $req->nomor,
							'tt_idcabang' 		=> $req->cabang,
							'tt_nofp' 			=> $req->nomor,
							'tt_supplier' 		=> 'asd',
							'tt_faktur' 		=> 'asd',
							'created_by' 		=> Auth::user()->m_name,
							'updated_by' 		=> Auth::user()->m_name,
						]);


   		});
    }
}
