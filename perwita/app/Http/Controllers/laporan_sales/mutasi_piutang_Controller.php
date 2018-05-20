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
     return $cus = DB::select("SELECT i_kode_customer,sum(i_sisa_akhir) FROM invoice group by i_kode_customer ");
      
      for ($i=0; $i <$cus ; $i++) { 
          
      }

      return view('purchase/master/master_penjualan/laporan/lap_mutasipiutang');
  }


}
