<?php

namespace App\Http\Controllers\master_sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Carbon\Carbon;
use Auth;
use Yajra\Datatables\Datatables;

class master_akun_controller extends Controller
{
    public function index()
    {
    	$akun = DB::table('d_akun')->get();
    	return view('master_sales.master_akun.index',compact('akun'));
    }
    public function datatable_akun($value='')
    {
    	$data = DB::table('master_akun_fitur')
    			  ->where('maf_group','1')
                  ->orderBy('maf_id','ASC')
                  ->get();
        
        	
        $data = collect($data);
        // return $data;
        return Datatables::of($data)
                        ->addColumn('aksi', function ($data) {
                          return  '<div class="btn-group">'.
                                   '<button type="button" onclick="edit(this)" class="btn btn-info btn-lg" title="edit">'.
                                   '<label class="fa fa-pencil-alt"></label></button>'.
                                   '<button type="button" onclick="hapus(this)" class="btn btn-danger btn-lg" title="hapus">'.
                                   '<label class="fa fa-trash"></label></button>'.
                                  '</div>';
                        })
                        ->addColumn('none', function ($data) {
                            return '-';
                        })
                        ->make(true);
    }

    public function datatable_item($value='')
    {
    	$data = DB::table('master_akun_fitur')
    			  ->where('maf_group','2')
                  ->orderBy('maf_id','ASC')
                  ->get();
        
        	
        $data = collect($data);
        // return $data;
        return Datatables::of($data)
                        ->addColumn('aksi', function ($data) {
                          return  '<div class="btn-group">'.
                                   '<button type="button" onclick="edit(this)" class="btn btn-info btn-lg" title="edit">'.
                                   '<label class="fa fa-pencil-alt"></label></button>'.
                                   '<button type="button" onclick="hapus(this)" class="btn btn-danger btn-lg" title="hapus">'.
                                   '<label class="fa fa-trash"></label></button>'.
                                  '</div>';
                        })
                        ->addColumn('none', function ($data) {
                            return '-';
                        })
                        ->make(true);
    }
}
