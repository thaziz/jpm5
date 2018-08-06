<?php

namespace App\Http\Controllers\master_sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use PDF;
use App\master_akun;
use App\d_jurnal;
use App\d_jurnal_dt;
use Carbon\Carbon;
use Auth;
use Yajra\Datatables\Datatables;
// use Intervention\Image\ImageManagerStatic as Image;
use File;
use Storage;

class nomor_seri_pajak_controller extends Controller
{
    public function index()
    {
        return view('master_sales.nomor_seri_pajak.index');
    }

    public function datatable_nomor_seri_pajak()
    {
    	if (Auth::user()->punyaAkses('Nomor Seri Pajak','all')) {
            $data = DB::table('nomor_seri_pajak')
                      ->get();
        }else{
            $cabang = auth::user()->kode_cabang;
            $data = DB::table('nomor_seri_pajak')
                      ->get();
        }

        $data = collect($data);

        // return $data;
        return Datatables::of($data)
                        ->addColumn('aksi', function ($data) {
                            $a = '';
                            $b = '';
                            $c = '';

                            if(Auth::user()->punyaAkses('Nomor Seri Pajak','ubah')){
                                $a = '<button type="button" onclick="edit(\''.$data->nsp_id.'\')" data-toggle="tooltip" title="Edit" class="btn btn-success btn-xs btnedit"><i class="fa fa-pencil"></i></button>';
                            }else{
                              $a = '';
                            }

                            if(Auth::user()->punyaAkses('Nomor Seri Pajak','hapus')){
                                $c = '<button type="button" onclick="hapus(\''.$data->nsp_id.'\')" class="btn btn-xs btn-danger btnhapus"><i class="fa fa-trash"></i></button>';
                            }else{
                              $c = '';
                            }

                            return '<div class="btn-group">'.$a.$c .'</div>' ;
                                   
                        })->addColumn('download', function ($data) {
                          	return '<button onclick="download_pdf(\''.$data->nsp_id.'\')" type="button" class="simpan_pdf btn btn-primary"><i class="fa fa-download"></i></button>';
                        })->addColumn('aktif', function ($data) {
                        	if ($data->nsp_aktif == true) {
                          		return '<input type="checkbox" onchange="cek(\''.$data->nsp_id.'\',this)" checked class="check form-control">';
                        	}else{
                          		return '<input type="checkbox"  onchange="cek(\''.$data->nsp_id.'\',this)" class="check form-control">';
                        	}
                        })
                        ->addIndexColumn()
                        ->make(true);

    }
    public function save_pajak_invoice(Request $req)
    {
    	$file = $req->file('files');
    	if ($req->id_old == '') {
    		$req->id_old = 0;
    	}
        $data = DB::table('nomor_seri_pajak')
				  ->where('nsp_id',$req->id_old)
				  ->first();
		if ($data != null) {

			$id = $req->id_old;
        	if ($file != null) {
        		unlink(storage_path('app/'.$data->nsp_pdf));  
	        	$filename = 'nomor_seri_pajak/faktur_pajak_'.$id.'.'.$file->getClientOriginalExtension();
	        	Storage::put($filename,file_get_contents($req->file('files')));
	      	}else{
	      		$filename = $data->nsp_pdf;
	      	}
        	$save = DB::table('nomor_seri_pajak')
        				->where('nsp_id',$id)
                  		->update([
                  			'nsp_tanggal'	 => carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
                  			'nsp_nomor_pajak'=> $req->nomor_pajak,
                  			'nsp_pdf' 		 => $filename,
                  			'updated_at'	 => carbon::now(),
                  			'updated_by'	 => Auth::user()->m_name,
                  		]);
	        return response()->json(['status'=>2]);
		}else{

        	$id = DB::table('nomor_seri_pajak')->max('nsp_id')+1;
        	if ($file != null) {
	        	$filename = 'nomor_seri_pajak/faktur_pajak_'.$id.'.'.$file->getClientOriginalExtension();
	        	Storage::put($filename,file_get_contents($req->file('files')));
	      	}

	      	$save = DB::table('nomor_seri_pajak')
	                  		->insert([
	                  			'nsp_id'		 => $id,
	                  			'nsp_tanggal'	 => carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
	                  			'nsp_nomor_pajak'=> $req->nomor_pajak,
	                  			'nsp_pdf' 		 => $filename,
	                  			'created_at'	 => carbon::now(),
	                  			'updated_at'	 => carbon::now(),
	                  			'created_by'	 => Auth::user()->m_name,
	                  			'updated_by'	 => Auth::user()->m_name,
	                  			'nsp_aktif' 	 => true
	                  		]);

			return response()->json(['status'=>1]);
		}

      	
    }

    public function cari_faktur_pajak(request $req)
    {
        $data = DB::table('nomor_seri_pajak')
                  ->where('nsp_id',$req->nomor)
                  ->first();
        return response()->json(['data'=>$data,'img'=>$data->nsp_pdf]);
    }

    public function cari_id_pajak(request $req)
    {
        $data = DB::table('nomor_seri_pajak')
                  ->where('nsp_id',$req->id)
                  ->first();
        $tanggal = carbon::parse($data->nsp_tanggal)->format('d/m/Y');
        return response()->json(['data'=>$data,'tanggal'=>$tanggal]);
    }

    public function hapus_faktur_pajak(Request $req)
    {
    	$data = DB::table('nomor_seri_pajak')
                  ->where('nsp_id',$req->id)
                  ->first();
        unlink(storage_path('app/'.$data->nsp_pdf));  

        $data = DB::table('nomor_seri_pajak')
                  ->where('nsp_id',$req->id)
                  ->delete();
		return response()->json(['status'=>1]);
    }

    public function cek_nomor_pajak(Request $req)
    {
    	$save = DB::table('nomor_seri_pajak')
					->where('nsp_id',$req->id)
	          		->update([
	          			'nsp_aktif' => $req->check
	          		]);
		return response()->json(['status'=>1]);
    }
}
