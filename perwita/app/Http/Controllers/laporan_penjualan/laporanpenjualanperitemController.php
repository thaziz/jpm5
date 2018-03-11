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

class laporanpenjualanperitemController extends Controller {

    public function index(){

       $sql = "    SELECT d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total
                    FROM delivery_order d
                    LEFT JOIN kota k ON k.id=d.id_kota_asal
                    LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan ORDER BY d.tanggal DESC LIMIT 1000";

        $data =  DB::select($sql);

        return view('laporan_sales.penjualan_per_item.index',compact('data'));        
    }

   }