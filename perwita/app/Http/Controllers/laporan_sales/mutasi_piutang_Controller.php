<?php

namespace App\Http\Controllers\laporan_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class mutasi_piutang_Controller extends Controller
{
  public function index()
  {
  	

      return view('purchase/master/master_penjualan/laporan/lap_mutasipiutang');
  }


}
