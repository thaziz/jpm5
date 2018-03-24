<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;
use Yajra\Datatables\Datatables;


class nota_debet_kredit_Controller extends Controller
{
    public function table_data () {
        //$cabang = strtoupper($request->input('kode_cabang'));
		$cabang = Auth::user()->kode_cabang;
        $data = DB::table('cn_dn_penjualan')
                  ->where('cd_kode_cabang',$cabang)
                  ->get();

        $data = collect($data);

        return Datatables::of($data)
                        ->addColumn('tombol', function ($data) {
                             return    '<div class="btn-group">
                                        <button type="button" onclick="hapus('.$data->cd_nomor.')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                        <button type="button" onclick="edit('.$data->cd_nomor.')" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></button>
                                        </div>';
                            })
                        ->make(true);
  
    }

    public function create()
    {
        $customer = DB::table('customer')
                            ->get();

        $cabang = DB::table('cabang')
                    ->get();
        $pajak = DB::table('pajak')
                    ->get();

        return view('sales.nota_debet_kredit.create_cn_dn', compact('customer','cabang','pajak'));
    }
    public function index(){
        $cabang = DB::select(DB::raw(" SELECT * FROM cabang"));
        return view('sales.nota_debet_kredit.index', compact('cabang'));
    }

}
