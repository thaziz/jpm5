<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input, Redirect, Session;
use App\Http\Requests;
use App\stock_mutation;
use App\masterItemPurchase;
use DB;
Use Carbon\Carbon;




class StockMutController extends Controller
{
    public function index()
    {
        //dd('dafg');


        $data = DB::table('stock_mutation')
            ->join('masteritem', 'stock_mutation.sm_item', '=', 'masteritem.kode_item')
            ->join('stock_mutcat', 'stock_mutation.sm_mutcat', '=', 'stock_mutcat.smc_id')
            ->select('stock_mutation.*', 'masteritem.nama_masteritem', 'stock_mutcat.keterangan')
            ->get();


        return view('stock_mutasi.index', array('dataku' => $data));
    }
}
