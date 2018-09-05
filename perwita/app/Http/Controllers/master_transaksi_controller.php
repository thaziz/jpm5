<?php

namespace App\Http\Controllers;

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

class master_transaksi_controller extends Controller
{
    public function index()
    {
    	$akun = DB::table('d_akun')
    			  ->select('main_id')
    			  ->groupBy('main_id')
    			  ->orderBy('main_id','ASC')
    			  ->get();
    	return view('master_sales.master_transaksi.index_master_transaksi',compact('akun'));
    }

    public function datatable_transaksi()
    {
    	if (Auth::user()->punyaAkses('Master Transaksi Akun','all')) {
            $data = DB::table('master_transaksi')
                      ->get();
        }

        $data = collect($data);

        // return $data;
        return Datatables::of($data)
                        ->addColumn('aksi', function ($data) {
                            $a = '';
                            $b = '';
                            $c = '';

                            if(Auth::user()->punyaAkses('Master Transaksi Akun','ubah')){
                                $c = '<button type="button" onclick="ubah(\''.$data->mt_id.'\')" class="btn btn-xs btn-warning btnhapus"><i class="fa fa-pencil"></i></button>';
                            }else{
                              $c = '';
                            }

                            return '<div class="btn-group">'.$a.$c .'</div>' ;
                                   
                        })
                        ->addIndexColumn()
                        ->make(true);

    }
    public function save(Request $req)
    {
    	DB::BeginTransaction();
    	try{
    		$id = DB::table('master_transaksi')->max('mt_id')+1;
    		$save = DB::table('master_transaksi')
    				  ->insert([
    				  	'mt_id' 	 => $id,
    				  	'mt_nama' 	 => strtoupper($req->nama),
    				  	'mt_id_akun' => $req->akun,
    				  	'created_at' => carbon::now(),
    				  	'updated_at' => carbon::now(),
    				  	'created_by' => Auth::user()->m_name,
    				  	'updated_by' => Auth::user()->m_name,
    				  ]);
    		DB::commit();
    		return response()->json(['status'=>1]);
    	}catch(Exception $er){
            dd($er);
    		DB::rollBack();
    	}
    }

    public function edit(Request $req)
    {
        $akun = DB::table('master_transaksi')
                  ->where('mt_id',$req->id)
                  ->first();
        return response()->json(['data'=>$akun]);
    }
}
