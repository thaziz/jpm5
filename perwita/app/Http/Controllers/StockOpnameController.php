<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\tb_coa;
use App\tb_jurnal;
use App\patty_cash;
use DB;
use Response;
Use Carbon\Carbon;
use Session;
use Mail;
use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;

class StockOpnameController extends Controller
{
    public function detailstockopname() {

        $kodeCabang = Session::get('cabang');
        $namacabang = DB::select(" SELECT nama FROM cabang WHERE kode = '$kodeCabang' ");
        //dd($namacabang);
        $cabang = null;
        $gudang = null;

         
        $mastergudang = DB::select(DB::raw(" SELECT mg_id,mg_namagudang,mg_cabang FROM mastergudang 
                                            WHERE mg_cabang = '$kodeCabang' ORDER BY mg_namagudang ASC "));

        $data = DB::table('stock_opname')
                  ->join('mastergudang','mg_id','=','so_gudang')
                  ->get();

        $detail = DB::table('stock_opname_dt')
            ->join('stock_opname', 'stock_opname_dt.sod_so_id', '=', 'stock_opname.so_id')
            ->join('masteritem', 'masteritem.kode_item', '=', 'stock_opname_dt.sod_item')
            ->select('stock_opname_dt.*', 'stock_opname.*', 'masteritem.*')
            ->get();



        if ($kodeCabang == '000'){
            $gudang  = DB::table('mastergudang')
                ->get();

            $cabang = DB::table('cabang')
                ->get();
        } else {
            $gudang = DB::table('mastergudang')
                ->select('*')
                ->where('mg_cabang', '=', $kodeCabang)
                ->get();
        }

        $now = Carbon::now()->format('F');

        $id = DB::table('stock_opname')
            ->where('so_comp','000')
            ->max('so_nota');

        $year  = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        $now   = Carbon::now()->format('d/m/Y');

        if(isset($id)) {

            $explode = explode("/", $id);
            $id = $explode[2];
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            $string = (int)$id + 1;
            $id = str_pad($string, 3, '0', STR_PAD_LEFT);

        }

        else {
            $id = '001';
        }


        $first = Carbon::now();
        $second = Carbon::now()->format('d/m/Y');
        $start = $first->subDays(30)->startOfDay()->format('d/m/Y');

        $pb  = 'SO-' . $month . $year . '/'. '000' . '/' .  $id;
        return view('purchase/stock_opname/detail',
            compact('cabang','now','pb', 'gudang','kodeCabang','namacabang','mastergudang','tgl','detail','data'));
    }
}
