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
use Illuminate\Support\Facades\Storage;
use Exception;
set_time_limit(60000);

class nomor_seri_pajak_controller extends Controller
{
    public function index()
    {
        $data = DB::table('nomor_seri_pajak')
                      ->where('nsp_aktif',true)
                      ->get();
        $data = count($data);
        return view('master_sales.nomor_seri_pajak.index',compact('data'));
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
                          		// return '<input type="checkbox" onchange="cek(\''.$data->nsp_id.'\',this)" checked class="check form-control">';
                            return '<label class="label label-primary">AKTIF</label>';
                        	}else{
                          		// return '<input type="checkbox"  onchange="cek(\''.$data->nsp_id.'\',this)" class="check form-control">';
                            return '<label class="label label-danger">TERPAKAI</label>';
                        	}
                        })
                        ->addIndexColumn()
                        ->make(true);

    }
    public function save_pajak_invoice(Request $req)
    {
      return DB::transaction(function() use ($req) {  
        $awal  = (integer)$req->nomor_pajak_awal;
        $akhir = (integer)$req->nomor_pajak_akhir;
        $kembar = [];
        if ($awal > $akhir) {
          return response()->json(['status'=>0,'pesan'=>'Range Pajak Awal Tidak Boleh Lebih Besar Dari Range Pajak Akhir']);
        }
        $count = $akhir - $awal;
        if ($count > 5000) {
          return response()->json(['status'=>0,'pesan'=>'Maksimal Data Adalah 5000']);
        }

        for ($i=0; $i < $count; $i++) { 
          $awalan = $awal + $i+1;
          $awalan = str_pad($awalan, 8, '0', STR_PAD_LEFT);
          $nomor_pajak = $req->nomor_pajak_1.'.'.$req->nomor_pajak_2.'.'.$awalan;
          $cek = DB::table('nomor_seri_pajak')
                  ->where('nsp_nomor_pajak',$nomor_pajak)
                  ->first();
          if ($cek == null) {
            $id = DB::table('nomor_seri_pajak')
                  ->max('nsp_id')+1;
            $save = DB::table('nomor_seri_pajak')
                          ->insert([
                            'nsp_id'          => $id,
                            'nsp_tanggal'     => carbon::parse(str_replace('/', '-', $req->tanggal))->format('Y-m-d'),
                            'nsp_nomor_pajak' => $nomor_pajak,
                            'created_at'      => carbon::now(),
                            'updated_at'      => carbon::now(),
                            'created_by'      => Auth::user()->m_name,
                            'updated_by'      => Auth::user()->m_name,
                            'nsp_aktif'       => true
                          ]);
          }else{
            array_push($kembar, $nomor_pajak);
          }
        }

  			return response()->json(['status'=>1,'kembar'=>$kembar]);
  		});
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
