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
    public function ganti_jt(Request $req)
    {
    	$agen 	  = DB::select("SELECT kode, nama,syarat_kredit from agen order by kode");

		$vendor   = DB::select("SELECT kode, nama,syarat_kredit from vendor order by kode "); 

		$subcon   = DB::select("SELECT kode, nama,syarat_kredit from subcon order by kode "); 

		$supplier = DB::select("SELECT no_supplier as kode, nama_supplier as nama,syarat_kredit from supplier where status = 'SETUJU' and active = 'AKTIF' order by no_supplier");

		$all = array_merge($agen,$vendor,$subcon,$supplier);
		$cus;
		for ($i=0; $i < count($all); $i++) { 
			if ($all[$i]->kode == $req->supplier) {
				$cus = $all[$i];
			}
		}
	    $jt = $cus->syarat_kredit;
	    if ($jt == null) {
	    	$jt = 0;
	    }
	    $tgl = str_replace('/', '-' ,$req->tanggal);
	    $tgl = Carbon::parse($tgl)->format('Y-m-d');
	    $tgl = Carbon::parse($tgl)->subDays(-$jt)->format('d/m/Y');

	    return response()->json([
	                         'jt' =>$jt,
	                         'tgl'=>$tgl
	                       ]);
    }
    public function save(Request $req)
    {
   		return DB::transaction(function() use ($req) {  
   			$user = Auth::user()->m_name;
   			if (Auth::user()->m_name == null) {
				return response()->json([
					'status'=>1,
					'message'=>'Nama User Anda Belum Ada, Silahkan Hubungi Pihak Terkait'
				]);
			}

			$cari_nota = DB::table('form_tt')
						   ->where('tt_noform',$req->nomor)
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
							'tt_supplier' 		=> $req->supplier,
							'tt_faktur' 		=> $req->faktur_pajak,
							'tt_lampiran_po' 	=> $req->lampiran_po,
							'created_by' 		=> Auth::user()->m_name,
							'updated_by' 		=> Auth::user()->m_name,
						]);



			for ($i=0; $i < count($req->invoice); $i++) { 
				$save = DB::table('form_tt_d')
						->insert([
							'ttd_id' 		=> $id,
							'ttd_detail' 	=> $i+1,
							'ttd_invoice' 	=> $req->invoice[$i],
							'ttd_nominal' 	=> filter_var($req->nominal[$i],FILTER_SANITIZE_NUMBER_INT),
							'ttd_tanggal' 	=> carbon::parse(str_replace('/','-',$req->tanggal_detil[$i]))->format('Y-m-d'),
						]);
			}

			return Response::json(['status'=>1]);

   		});
    }

    public function edit($id)
    {
    	if (Auth::user()->punyaAkses('Form Tanda Terima Pembelian','ubah')) {
    		$data = DB::table('form_tt')
    				  ->where('tt_idform',$id)
    				  ->first();

	 		$detail = DB::table('form_tt_d')
					  ->where('ttd_id',$id)
					  ->get();


			$agen 	  = DB::select("SELECT kode, nama from agen order by kode");

			$vendor   = DB::select("SELECT kode, nama from vendor order by kode "); 

			$subcon   = DB::select("SELECT kode, nama from subcon order by kode "); 

			$supplier = DB::select("SELECT no_supplier as kode, nama_supplier as nama from supplier where status = 'SETUJU' and active = 'AKTIF' order by no_supplier");

			$all = array_merge($agen,$vendor,$subcon,$supplier);

			$cabang = DB::table('cabang')
						->get();

			$nextDay = carbon::now()->subDays(-7)->format('d/m/Y');

			return view('purchase.form_tt.edit_tt',compact('data','detail','all','cabang'));
    	}else{
    		return redirect()->back();
    	}
    }

    public function update(Request $req)
    {
    	return DB::transaction(function() use ($req) {  

			$cari_nota = DB::table('form_tt')
						   ->where('tt_noform',$req->nomor)
						   ->first();
			$total = 0;
			for ($i=0; $i < count($req->nominal); $i++) { 
				$total += filter_var($req->nominal[$i],FILTER_SANITIZE_NUMBER_INT);
			}

			$save = DB::table('form_tt')
						->where('tt_noform',$req->nomor)
						->update([
							'tt_tgl' 			=> carbon::parse(str_replace('/','-',$req->tanggal))->format('Y-m-d'),
							'tt_lainlain' 		=> $req->lain,
							'tt_tglkembali' 	=> carbon::parse(str_replace('/','-',$req->tanggal_kembali))->format('Y-m-d'),
							'tt_totalterima' 	=> $total,
							'updated_at' 		=> carbon::now(),
							'tt_kwitansi' 		=> $req->kwitansi,
							'tt_suratperan' 	=> $req->surat_peranan,
							'tt_suratjalanasli' => $req->surat_jalan,
							'tt_noform' 		=> $req->nomor,
							'tt_idcabang' 		=> $req->cabang,
							'tt_nofp' 			=> $req->nomor,
							'tt_supplier' 		=> $req->supplier,
							'tt_lampiran_po' 	=> $req->lampiran_po,
							'tt_faktur' 		=> $req->faktur_pajak,
							'updated_by' 		=> Auth::user()->m_name,
						]);

			$delete = DB::table('form_tt_d')
						->where('ttd_id',$cari_nota->tt_idform)
						->delete();

			for ($i=0; $i < count($req->invoice); $i++) { 
				$save = DB::table('form_tt_d')
						->insert([
							'ttd_id' 		=> $cari_nota->tt_idform,
							'ttd_detail' 	=> $i+1,
							'ttd_invoice' 	=> $req->invoice[$i],
							'ttd_nominal' 	=> filter_var($req->nominal[$i],FILTER_SANITIZE_NUMBER_INT),
							'ttd_tanggal' 	=> carbon::parse(str_replace('/','-',$req->tanggal_detil[$i]))->format('Y-m-d'),
						]);
			}

			return Response::json(['status'=>1]);

   		});
    }

    public function hapus_tt_pembelian(Request $req)
    {
		$data = DB::table('form_tt')
    			  ->where('tt_idform',$req->id)
    			  ->delete();
    	return Response::json(['status'=>1]);
    }
    public function datatable()
    {
    	if (Auth::user()->punyaAkses('Form Tanda Terima Pembelian','all')) {
			$data = DB::table('form_tt')
				  ->orderBy('tt_idform','ASC')
				  ->get();
		}else{
			$cabang = Auth::user()->kode_cabang;

			$data = DB::table('form_tt')
				  ->where('tt_idcabang',$cabang)
				  ->orderBy('tt_idform','ASC')
				  ->get();
		}
		dd($data);
        $data = collect($data);
        // return $data;
        return Datatables::of($data)
                        ->addColumn('aksi', function ($data) {
                            $a = '';
                            if(Auth::user()->punyaAkses('Form Tanda Terima Pembelian','ubah')){
                              $a = '<a title="Edit" class="btn btn-xs btn-success" href='.url('form_tanda_terima_pembelian/edit').'/'.$data->tt_idform.'>
                          			<i class="fa fa-arrow-right" aria-hidden="true"></i></a> ';
                            }else{
                              $a = '';
                            }

                            $c = '';
                            if(Auth::user()->punyaAkses('Form Tanda Terima Pembelian','hapus')){
                              $c = '<a title="Hapus" class="btn btn-xs btn-danger" onclick="hapus(\''.$data->tt_idform.'\')">
	                               <i class="fa fa-trash" aria-hidden="true"></i>
	                               </a>';
                            }else{
                              $c = '';
                            }
                            return '<div class="btn-group">'.$a . $c.'</div>' ;
                                   
                        })
                    
                        ->addColumn('cabang', function ($data) {
                          $kota = DB::table('cabang')
                                    ->get();

                          for ($i=0; $i < count($kota); $i++) { 
                            if ($data->tt_idcabang == $kota[$i]->kode) {
                                return $kota[$i]->nama;
                            }
                          }
                        })
                        ->addColumn('tagihan', function ($data) {
                          return number_format($data->tt_totalterima,2,',','.'  ); 
                        })
                        ->addColumn('print', function ($data) {
                           return $a = '<input type="hidden" class="id_print" value="'.$data->tt_idform.'">
                            <a title="Print" class="" onclick="printing(\''.$data->tt_idform.'\')" >
                            <i class="fa fa-print" aria-hidden="true">&nbsp; Print</i>
                            </a>';
                        })
                        ->addIndexColumn()
                        ->make(true);
    }
}
