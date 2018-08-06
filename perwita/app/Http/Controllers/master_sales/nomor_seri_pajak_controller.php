<?php

namespace App\Http\Controllers\master_sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use PDF;
use App\master_akun;
use App\d_jurnal;
use App\d_jurnal_dt;
use Carbon\Carbon;
use Auth;
use Yajra\Datatables\Datatables;
// use Intervention\Image\ImageManagerStatic as Image;
use File;
use Storage;

class nomor_seri_pajak_controller extends Controller
{
    public function index()
    {
        return view('master_sales.nomor_seri_pajak.index');
    }

    public function datatable_nomor_seri_pajak()
    {
    	if (Auth::user()->punyaAkses('Nomor Seri Pajak','all')) {
            $data = DB::table('invoice')
                      ->join('customer','kode','=','i_kode_customer')
                      ->get();
        }else{
            $cabang = auth::user()->kode_cabang;
            $data = DB::table('invoice')
                      ->join('customer','kode','=','i_kode_customer')
                      ->where('i_kode_cabang',$cabang)
                      ->get();
        }

        $data = collect($data);

        // return $data;
        return Datatables::of($data)
                        ->addColumn('aksi', function ($data) {
                            $a = '';
                            $b = '';
                            $c = '';

                            if($data->i_statusprint == 'Released' or Auth::user()->punyaAkses('Nomor Seri Pajak','ubah')){
                                if(cek_periode(carbon::parse($data->i_tanggal)->format('m'),carbon::parse($data->i_tanggal)->format('Y') ) != 0){
                                  $a = '<button type="button" onclick="edit(\''.$data->i_nomor.'\')" data-toggle="tooltip" title="Edit" class="btn btn-success btn-xs btnedit"><i class="fa fa-pencil"></i></button>';
                                }
                            }else{
                              $a = '';
                            }

                            if($data->i_statusprint == 'Released' or Auth::user()->punyaAkses('Nomor Seri Pajak','hapus')){
                                if(cek_periode(carbon::parse($data->i_tanggal)->format('m'),carbon::parse($data->i_tanggal)->format('Y') ) != 0){
                                  $c = '<button type="button" onclick="hapus(\''.$data->i_nomor.'\')" class="btn btn-xs btn-danger btnhapus"><i class="fa fa-trash"></i></button>';
                                }
                            }else{
                              $c = '';
                            }


       
                            return '<div class="btn-group">'.$a.$c .'</div>' ;
                                   
                        })->addColumn('download', function ($data) {
                          $kota = DB::table('customer')
                                    ->get();

                          for ($i=0; $i < count($kota); $i++) { 
                            if ($data->i_kode_customer == $kota[$i]->kode) {
                                return $kota[$i]->nama;
                            }
                          }
                        })->addIndexColumn()
                        ->make(true);

    }
}
