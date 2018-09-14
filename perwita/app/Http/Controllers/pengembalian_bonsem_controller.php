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
use Yajra\Datatables\Datatables;
use App\d_jurnal;
use App\d_jurnal_dt;
use Exception;
class pengembalian_bonsem_controller extends Controller
{
    public function index()
    {
    	$cabang = DB::table('cabang')
					->get();
    	return view('purchase.pengembalian_bonsem.index_pengembalian_bonsem',compact('cabang'));
    }


    public function datatable_pengembalian(request $req)
	{

		if ($req->flag == 'global') {
			$req->nota = '0';
		}else{
			$req->tanggal_awal = '0';
			$req->tanggal_akhir = '0';
			$req->jenis_biaya = '0';
		}

		$nama_cabang = DB::table("cabang")
						 ->where('kode',$req->cabang)
						 ->first();

		if ($nama_cabang != null) {
			$cabang = 'and bp_cabang = '."'$req->cabang'";
		}else{
			$cabang = '';
		}


		if ($req->tanggal_awal != '0') {
			$tgl_awal = carbon::parse($req->tanggal_awal)->format('Y-m-d');
			$tanggal_awal = 'and bp_tgl >= '."'$tgl_awal'";
		}else{
			$tanggal_awal = '';
		}

		if ($req->tanggal_akhir != '0') {
			$tgl_akhir = carbon::parse($req->tanggal_akhir)->format('Y-m-d');
			$tanggal_akhir = 'and bp_tgl <= '."'$tgl_akhir'";
		}else{
			$tanggal_akhir = '';
		}

		if ($req->nota != '0') {
			if (Auth::user()->punyaAkses('Pengembalian Bonsem','all')) {
				$data = DB::table('bonsem_pengajuan')
						  ->where('bp_terima','DONE')
						  ->where('bp_status_pengembalian','=','Released')
						  ->where('bp_sisapemakaian','!=',0)
						  ->get();
			}else{
				$cabang = Auth::user()->kode_cabang;
				$data = DB::table('bonsem_pengajuan')
						  ->where('bp_cabang',$cabang)
						  ->where('bp_terima','DONE')
						  ->where('bp_status_pengembalian','=','Released')
						  ->where('bp_sisapemakaian','!=',0)
						  ->get();
			}
		}else{
			if (Auth::user()->punyaAkses('Pengembalian Bonsem','all')) {

				$sql = "SELECT * FROM bonsem_pengajuan where bp_nota != '0' $cabang $tanggal_awal $tanggal_akhir ";

				$data = DB::select($sql);
			}else{
				$cabang = Auth::user()->kode_cabang;
				$sql = "SELECT * FROM bonsem_pengajuan where bp_nota != '0' and bp_cabang = '$cabang' $tanggal_awal $tanggal_akhir";
				$data = DB::select($sql);
			}
		}
        $data = collect($data);
        // return $data;
        return Datatables::of($data)
            ->addColumn('aksi', function ($data) {
                $a = '';
            	if ($data->bp_status_pengembalian == 'Released' or Auth::user()->punyaAkses('Pengembalian Bonsem','ubah')) {
            		if(cek_periode(carbon::parse($data->bp_tgl)->format('m'),carbon::parse($data->bp_tgl)->format('Y') ) != 0){
                      $a = '<a title="Edit" class="btn btn-xs btn-warning" href='.url('pengembalian_bonsem/edit').'/'.$data->bp_id.'>
                  			<i class="fa fa-arrow-right" aria-hidden="true"></i></a> ';
                    }
                }else{
                  	if ($data->bp_status_pengembalian == 'Released') {
                		if(cek_periode(carbon::parse($data->bp_tgl)->format('m'),carbon::parse($data->bp_tgl)->format('Y') ) != 0){
                          $a = '<a title="Edit" class="btn btn-xs btn-warning" href='.url('pengembalian_bonsem/edit').'/'.$data->bp_id.'>
                      			<i class="fa fa-arrow-right" aria-hidden="true"></i></a> ';
                        }
                	}
                }

                $c = '';
            	if ($data->bp_status_pengembalian == 'Released' or Auth::user()->punyaAkses('Pengembalian Bonsem','hapus')) {
                    if(cek_periode(carbon::parse($data->bp_tgl)->format('m'),carbon::parse($data->bp_tgl)->format('Y') ) != 0){
                      $c = '<a title="Hapus" class="btn btn-xs btn-danger" onclick="hapus(\''.$data->bp_id.'\')">
                           <i class="fa fa-trash" aria-hidden="true"></i>
                           </a>';
                    }
                }else{
                  	if ($data->bp_status_pengembalian == 'Released') {
                        if(cek_periode(carbon::parse($data->bp_tgl)->format('m'),carbon::parse($data->bp_tgl)->format('Y') ) != 0){
                          $c = '<a title="Hapus" class="btn btn-xs btn-danger" onclick="hapus(\''.$data->bp_id.'\')">
                               <i class="fa fa-trash" aria-hidden="true"></i>
                               </a>';
                        }
                	}
                }

                $d = '<a class="btn btn-xs btn-success" onclick="lihat_jurnal(\''.$data->bp_id.'\')" title="lihat jurnal"><i class="fa fa-eye"></i></a>';

                return '<div class="btn-group">' .$a . $c .$d.'</div>' ;
                       

                       
            })
        
            ->addColumn('cabang', function ($data) {
              $kota = DB::table('cabang')
                        ->get();

              for ($i=0; $i < count($kota); $i++) { 
                if ($data->bp_cabang == $kota[$i]->kode) {
                    return $kota[$i]->nama;
                }
              }
            })
            ->addColumn('status', function ($data) {
              if ($data->bp_status_pengembalian == 'APPROVED') {
                return '<label class="label label-success">APPROVED</label>';
              }else{
                return '<label class="label label-warning">Released</label>';
              }
            })
            ->addColumn('tagihan', function ($data) {
              return number_format($data->bp_sisapemakaian,2,',','.'  ); 
            })
            ->addColumn('print', function ($data) {
               return $a = '<input type="hidden" class="id_print" value="'.$data->bp_id.'">
                <a title="Print" class="" onclick="printing(\''.$data->bp_id.'\')" >
                <i class="fa fa-print" aria-hidden="true">&nbsp; Print</i>
                </a>';
            })
            ->addIndexColumn()
            ->make(true);
	}
}
