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
    public function createstockopname() {

        $kodeCabang = session::get('cabang');

        $cabang = null;
        $gudang = null;

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
        return view('purchase/stock_opname/create',compact('cabang','now','pb', 'gudang'));
    }
}
