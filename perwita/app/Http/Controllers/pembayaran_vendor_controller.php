<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Response;
use Auth;
use DB;
Use Carbon\Carbon;

class pembayaran_vendor_controller extends Controller
{
    public function index($value='')
    {
    	$date = Carbon::now()->format('d/m/Y');

	
		$akun = DB::table('master_persentase')
				  ->get();

		$vendor = DB::table('vendor')
					->get();	

		$kota   = DB::table('kota')
				->get();

		$tanggal = carbon::now()->format('d/m/Y');

		return view('purchase/pembayaran_vendor/create_vendor',compact('date','kota','vendor','akun','tanggal'));
    }
}
