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


class form_tanda_terima_penjualan_controller extends Controller
{
    public function index()
    {
    	return view('sales.form_tanda_terima.index_tt_penjualan');
    }

    public function create()
    {
    	$customer = DB::table('customer')
    				 ->get();
		$cabang = DB::table('cabang')
					->get();
		$nextDay = carbon::now()->subDays(-7)->format('d/m/Y');

    	return view('sales.form_tanda_terima.create_tt_penjualan',compact('customer','cabang','nextDay'));
    }

    public function nota(Request $req)
    {
    	$bulan = Carbon::parse(str_replace('/', '-', $req->tanggal))->format('m');
	    $tahun = Carbon::parse(str_replace('/', '-', $req->tanggal))->format('y');

	    $cari_nota = DB::select("SELECT  substring(max(ft_nota),12) as id from form_tt_penjualan
	                                    WHERE ft_kode_cabang = '$req->cabang'
	                                    AND to_char(created_at,'MM') = '$bulan'
	                                    AND to_char(created_at,'YY') = '$tahun'");

	    $index = (integer)$cari_nota[0]->id + 1;
	    $index = str_pad($index, 3, '0', STR_PAD_LEFT);

		
		$nota = 'TT' . $bulan . $tahun . '/' . $req->cabang . '/' .$index;

    	return Response::json(['nota'=>$nota]);
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

			$cari_nota = DB::table('form_tt_penjualan')
						   ->where('ft_nota',$req->nomor)
						   ->first();
			if ($cari_nota != null) {

				if ($cari_nota->updated_by == $user) {
					return 'Data Sudah Ada';
				}else{
					$bulan = Carbon::parse(str_replace('/', '-', $req->tgl))->format('m');
				    $tahun = Carbon::parse(str_replace('/', '-', $req->tgl))->format('y');

				    $cari_nota = DB::select("SELECT  substring(max(ft_nota),12) as id from form_tt_penjualan
	                                    WHERE ft_kode_cabang = '$req->cabang'
	                                    AND to_char(created_at,'MM') = '$bulan'
	                                    AND to_char(created_at,'YY') = '$tahun'");

				    $index = (integer)$cari_nota[0]->id + 1;
				    $index = str_pad($index, 3, '0', STR_PAD_LEFT);

					
					$nota = 'TT' . $bulan . $tahun . '/' . $req->cabang . '/' .$index;
				}
			}elseif ($cari_nota == null) {
				$nota = $req->nota;
			}
			$id = DB::table('form_tt_penjualan')
					->max('ft_id')+1;

			$save = DB::table('form_tt_penjualan')
						->insert([
							'ft_id' 			=> $id,
							'ft_tanggal' 		=> carbon::parse(str_replace('/','-',$req->tanggal))->format('Y-m-d'),
							'ft_tanggal_terima'	=> carbon::parse(str_replace('/','-',$req->tanggal))->format('Y-m-d'),
							'ft_lainlain' 		=> $req->lain,
							'ft_jatuh_tempo' 	=> carbon::parse(str_replace('/','-',$req->jatuh_tempo))->format('Y-m-d'),
							'created_at' 		=> carbon::now(),
							'updated_at' 		=> carbon::now(),
							'ft_kwitansi' 		=> $req->kwitansi,
							'ft_suratperan' 	=> $req->surat_peranan,
							'ft_suratjalanasli' => $req->surat_jalan,
							'ft_nota' 			=> $req->nomor,
							'ft_kode_cabang'	=> $req->cabang,
							'ft_customer' 		=> $req->customer,
							'ft_faktur' 		=> $req->faktur_pajak,
							'created_by' 		=> Auth::user()->m_name,
							'updated_by' 		=> Auth::user()->m_name,
						]);

			$total = 0;
			for ($i=0; $i < count($req->invoice); $i++) { 
				$invoice = DB::table('invoice')
							 ->where('i_nomor',$req->invoice[$i])
							 ->first();

				$save = DB::table('form_tt_penjualan_d')
						->insert([
							'ftd_id' 				=> $id,
							'ftd_detail' 			=> $i+1,
							'ftd_tanggal_invoice' 	=> $invoice->i_tanggal,
							'ftd_invoice' 			=> $req->invoice[$i],
							'ftd_total_invoice' 	=> $invoice->i_total_tagihan,
							'ftd_status' 			=> 'APPROVED',
							'ftd_keterangan'		=> $req->catatan[$i],
							'created_at' 			=> carbon::now(),
							'updated_at' 			=> carbon::now(),
						]);
				$total += $invoice->i_total_tagihan;
				$update = DB::table('invoice')
						->where('i_nomor',$req->invoice[$i])
						->update([
							'i_tanda_terima'			=> $req->nomor,
							'i_tanggal_tanda_terima'	=> carbon::parse(str_replace('/','-',$req->tanggal))->format('Y-m-d'),
							'i_jatuh_tempo_tt'			=> carbon::parse(str_replace('/','-',$req->jatuh_tempo))->format('Y-m-d'),
						]);
			}
			$save = DB::table('form_tt_penjualan')
						->where('ft_id',$id)
						->update([
							'ft_total' 		=> $total,
						]);

			return Response::json(['status'=>1]);

   		});
    }

    public function edit($id)
    {
    	if (Auth::user()->punyaAkses('Form Tanda Terima Penjualan','ubah')) {
    		$data = DB::table('form_tt_penjualan')
    				  ->where('ft_id',$id)
    				  ->first();

	 		$detail = DB::table('form_tt_penjualan_d')
					  ->where('ftd_id',$id)
					  ->get();


			$customer = DB::table('customer')
    				 ->get();
			$cabang = DB::table('cabang')
						->get();
			$nextDay = carbon::now()->subDays(-7)->format('d/m/Y');


			return view('sales.form_tanda_terima.edit_tt_penjualan',compact('data','detail','customer','cabang','id'));
    	}else{
    		return redirect()->back();
    	}
    }

    public function update(Request $req)
    {
    	return DB::transaction(function() use ($req) {  

			$cari_nota = DB::table('form_tt_penjualan')
						   ->where('ft_nota',$req->nomor)
						   ->first();
			$total = 0;
			$save = DB::table('form_tt_penjualan')
						->where('ft_nota',$req->nomor)
						->update([
							'ft_tanggal_terima' => carbon::parse(str_replace('/','-',$req->tanggal))->format('Y-m-d'),
							'ft_lainlain' 		=> $req->lain,
							'ft_jatuh_tempo' 	=> carbon::parse(str_replace('/','-',$req->jatuh_tempo))->format('Y-m-d'),
							'created_at' 		=> carbon::now(),
							'updated_at' 		=> carbon::now(),
							'ft_kwitansi' 		=> $req->kwitansi,
							'ft_suratperan' 	=> $req->surat_peranan,
							'ft_suratjalanasli' => $req->surat_jalan,
							'ft_nota' 			=> $req->nomor,
							'ft_kode_cabang'	=> $req->cabang,
							'ft_customer' 		=> $req->customer,
							'ft_faktur' 		=> $req->faktur_pajak,
							'created_by' 		=> Auth::user()->m_name,
							'updated_by' 		=> Auth::user()->m_name,
						]);



			$delete = DB::table('form_tt_penjualan_d')
						->where('ftd_id',$cari_nota->ft_id)
						->delete();

			$total = 0;
			for ($i=0; $i < count($req->invoice); $i++) { 
				$invoice = DB::table('invoice')
							 ->where('i_nomor',$req->invoice[$i])
							 ->first();
				if ($req->revisi[$i] == 'off') {
					$detail = array('ftd_id' 				=> $cari_nota->ft_id,
								'ftd_detail' 			=> $i+1,
								'ftd_tanggal_invoice' 	=> $invoice->i_tanggal,
								'ftd_invoice' 			=> $req->invoice[$i],
								'ftd_total_invoice' 	=> $invoice->i_total_tagihan,
								'ftd_status' 			=> 'CANCEL',
								'ftd_keterangan'		=> $req->catatan[$i],
								'created_at' 			=> carbon::now(),
								'updated_at' 			=> carbon::now(),
								);
				}else{
					$detail = array('ftd_id' 				=> $cari_nota->ft_id,
								'ftd_detail' 			=> $i+1,
								'ftd_tanggal_invoice' 	=> $invoice->i_tanggal,
								'ftd_invoice' 			=> $req->invoice[$i],
								'ftd_total_invoice' 	=> $invoice->i_total_tagihan,
								'ftd_status' 			=> 'APPROVED',
								'ftd_keterangan'		=> $req->catatan[$i],
								'created_at' 			=> carbon::now(),
								'updated_at' 			=> carbon::now(),
								);
				}
				

				$save = DB::table('form_tt_penjualan_d')
						->insert($detail);

				$total += $invoice->i_total_tagihan;
				if ($req->revisi[$i] == 'off') {
					$upd = array('i_tanda_terima'			=> null,
								 'i_tanggal_tanda_terima'	=> null,
								 'i_jatuh_tempo_tt'			=> null);
				}else{
					$upd = array('i_tanda_terima'			=> $req->nomor,
								 'i_tanggal_tanda_terima'	=> carbon::parse(str_replace('/','-',$req->tanggal))->format('Y-m-d'),
								 'i_jatuh_tempo_tt'			=> carbon::parse(str_replace('/','-',$req->jatuh_tempo))->format('Y-m-d'));
				}

				$update = DB::table('invoice')
						->where('i_nomor',$req->invoice[$i])
						->update($upd);
			}

			$save = DB::table('form_tt_penjualan')
						->where('ft_id',$cari_nota->ft_id)
						->update([
							'ft_total' 		=> $total,
						]);

			return Response::json(['status'=>1]);

   		});
    }
    public function ganti_jt(Request $req)
    {
    	$cus = DB::table('customer')
             ->where('kode',$req->customer)
             ->first();
	    $jt = $cus->syarat_kredit;
	    $tgl = str_replace('/', '-' ,$req->tanggal);
	    $tgl = Carbon::parse($tgl)->format('Y-m-d');

	    $tgl = Carbon::parse($tgl)->subDays(-$jt)->format('d/m/Y');

	    return response()->json([
	                         'jt' =>$jt,
	                         'tgl'=>$tgl
	                       ]);
    }
    public function cari_invoice(Request $req)
    {
    	$data = DB::table('invoice')
    			  ->where('i_kode_customer',$req->customer)
    			  ->where('i_tanda_terima',null)
    			  ->where('i_kode_cabang',$req->cabang)
    			  ->get();


    	$data1 = DB::table('invoice')
    			  ->join('form_tt_penjualan_d','i_nomor','=','ftd_invoice')
    			  ->where('ftd_id',$req->id)
    			  ->get();

    	$data = array_merge($data,$data1);

    	$temp = $data;

    	for ($i=0; $i < count($req->array_simpan); $i++) { 
    		for ($a=0; $a < count($temp); $a++) { 
    			if ($temp[$a]->i_nomor == $req->array_simpan[$i]) {
    				unset($data[$a]);
    			}
    		}
    	}

    	$data = array_values($data);
    	return view('sales.form_tanda_terima.table_tt',compact('data'));
    }

    public function append_invoice(Request $req)
    {
    	// dd($req->all());
    	$data = DB::table('invoice')
    			  ->whereIn('i_nomor',$req->array_invoice)
    			  ->get();
    	

    	return Response::json(['data'=>$data]);
    }
    public function hapus_tt_penjualan(Request $req)
    {
    	$data = DB::table('form_tt_penjualan_d')
    			  ->where('ftd_id',$req->id)
    			  ->get();
    	for ($i=0; $i < count($data); $i++) { 
			$invoice = DB::table('invoice')
						 ->where('i_nomor',$data[$i]->ftd_invoice)
						 ->first();

			$upd = array('i_tanda_terima'			=> null,
						 'i_tanggal_tanda_terima'	=> null,
						 'i_jatuh_tempo_tt'			=> null

						);
	
			$update = DB::table('invoice')
					->where('i_nomor',$data[$i]->ftd_invoice)
					->update($upd);
		}

		$data = DB::table('form_tt_penjualan')
    			  ->where('ft_id',$req->id)
    			  ->delete();
    	return Response::json(['status'=>1]);
    }




    public function printing($id)
    {
    	return view('sales.form_tanda_terima.print_tt');
    }

    
    public function datatable()
    {
    	if (Auth::user()->punyaAkses('Form Tanda Terima Penjualan','all')) {
			$data = DB::table('form_tt_penjualan')
				  ->join('customer','kode','=','ft_customer')
				  ->orderBy('ft_id','ASC')
				  ->get();
		}else{
			$cabang = Auth::user()->kode_cabang;
			$data = DB::table('form_tt_penjualan')
				  ->join('customer','kode','=','ft_customer')
				  ->where('ft_kode_cabang',$cabang)
				  ->orderBy('ft_id','ASC')
				  ->get();
		}

        $data = collect($data);
        // return $data;
        return Datatables::of($data)
                        ->addColumn('aksi', function ($data) {
                            $a = '';
                            if(Auth::user()->punyaAkses('Form Tanda Terima Penjualan','ubah')){
                              $a = '<a title="Edit" class="btn btn-xs btn-success" href='.url('sales/form_tanda_terima_penjualan/edit').'/'.$data->ft_id.'>
                          			<i class="fa fa-arrow-right" aria-hidden="true"></i></a> ';
                            }else{
                              $a = '';
                            }

                            $c = '';
                            if(Auth::user()->punyaAkses('Form Tanda Terima Penjualan','hapus')){
                              $c = '<a title="Hapus" class="btn btn-xs btn-danger" onclick="hapus(\''.$data->ft_id.'\')">
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
                            if ($data->ft_kode_cabang == $kota[$i]->kode) {
                                return $kota[$i]->nama;
                            }
                          }
                        })
                        ->addColumn('tanggal_buat', function ($data) {
                          return carbon::parse($data->created_at)->format('Y-m-d');
                        })
                        ->addColumn('tagihan', function ($data) {
                          return number_format($data->ft_total,2,',','.'  ); 
                        })
                        ->addColumn('print', function ($data) {
                           return $a = '<input type="hidden" class="id_print" value="'.$data->ft_id.'">
                            <a title="Print" class="" onclick="printing(\''.$data->ft_id.'\')" >
                            <i class="fa fa-print" aria-hidden="true">&nbsp; Print</i>
                            </a>';
                        })
                        ->addIndexColumn()
                        ->make(true);
    }

}
