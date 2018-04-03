<?php

namespace App\Http\Controllers\sales;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use carbon\carbon;
use DB;
class invoice_pembetulan_controller extends Controller
{
   public function index()
 	{
 		$cabang = auth::user()->kode_cabang;
        if (Auth::user()->m_level == 'ADMINISTRATOR' || Auth::user()->m_level == 'SUPERVISOR') {
            $data = DB::table('invoice_pembetulan')
                      ->join('customer','kode','=','ip_kode_customer')
                      ->get();
        }else{
            $data = DB::table('invoice_pembetulan')
                      ->join('customer','kode','=','ip_kode_customer')
                      ->where('ip_kode_cabang',$cabang)
                      ->get();
        }
        $kota = DB::table('kota')
                  ->get();
        return view('sales.invoice_pembetulan.index',compact('data'));
 	}

 	public function invoice_pembetulan_create()
 	{
 		$customer = DB::table('customer')
                      ->get();

        $cabang   = DB::table('cabang')
                      ->get();
        $tgl      = Carbon::now()->format('d/m/Y');
        $tgl1     = Carbon::now()->subDays(30)->format('d/m/Y');

        $pajak    = DB::table('pajak')
                      ->get();

        return view('sales.invoice_pembetulan.invoice_pembetulan_create',compact('customer','cabang','tgl','tgl1','pajak'));
 	}

 	public function cari_invoice(request $request)
 	{
 		$data = DB::table('invoice')
 				  ->join('customer','kode','=','ip_kode_customer')
	              ->where('i_kode_cabang',$request->cabang)
	              ->get();

         return view('sales.invoice_pembetulan.invoice_pembetulan_create',compact('data'))
    	
 	}
}
