<?php

namespace App\Http\Controllers\laporan_pembelian;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class mutasi_hutang_Controller  extends Controller
{
  public function index()
  {
  	

      return view('purchase/laporan_analisa_pembelian/lap_mutasi_hutang/lap_mutasi_hutang');
  }


}
