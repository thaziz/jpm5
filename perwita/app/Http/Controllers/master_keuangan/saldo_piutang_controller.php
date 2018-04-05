<?php

namespace App\Http\Controllers\master_keuangan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

class saldo_piutang_controller extends Controller
{
    public function index(){
    	return view("keuangan.saldo_piutang.index");
    }

    public function add(){
    	$cust = DB::table('customer')->select("kode", "nama", "alamat")->get();
    	return view("keuangan.saldo_piutang.insert")
    		   ->withCust($cust);
    }
}
