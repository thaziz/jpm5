<?php

namespace App\Http\Controllers\laporan_penjualan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\d_comp_coa;
use App\d_comp_trans;
use App\d_mem_comp;
use DB;
use Auth;
use Validator;
use Session;

class laporaninvoiceController extends Controller {

    public function index(){

        $data =DB::table('invoice')->get();

        return view('laporan_sales.penjualan.index',compact('data'));
    }

   }