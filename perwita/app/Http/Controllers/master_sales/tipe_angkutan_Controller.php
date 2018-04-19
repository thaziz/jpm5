<?php

namespace App\Http\Controllers\master_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
USE Auth;


class tipe_angkutan_Controller extends Controller
{
    public function table_data () {
        $list = DB::table('tipe_angkutan')->leftJoin('master_bbm','bahan_bakar','=','mb_id')->get();
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            $div_1  =   '<div class="btn-group">';
                              if (Auth::user()->punyaAkses('Tipe Angkutan','ubah')) {
                              $div_2  = '<button type="button" id="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" >'.'<i class="fa fa-pencil"></i></button>';
                              }else{
                                $div_2 = '';
                              }
                              if (Auth::user()->punyaAkses('Tipe Angkutan','hapus')) {
                              $div_3  = '<button type="button" id="'.$data[$i]['kode'].'" name="'.$data[$i]['nama'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" >'.
                                        '<i class="fa fa-trash"></i></button>';
                              }else{
                                $div_3 = '';
                              }
                              $div_4   = '</div>';
            $all_div = $div_1 . $div_2 . $div_3 . $div_4;

            $data[$i]['button'] = $all_div;

            $i++;

        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('id');
        $data = DB::table('tipe_angkutan')->where('kode', $id)->first();
        echo json_encode($data);
    }


    public function save_data (Request $request) {
        $simpan='';
        $crud = $request->crud;
         $data = array(
                  'kode' => strtoupper($request['ed_kode']),
                  'nama' => strtoupper($request->ed_nama),
                  'bahan_bakar' => strtoupper($request->bbm),
                  'bbm_per_liter' => strtoupper($request->km),
            );
        
        if ($crud == 'N') {
            $simpan = DB::table('tipe_angkutan')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('tipe_angkutan')->where('kode', $request->ed_kode_old)->update($data);
        }
        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            $result['error']=$data;
            $result['result']=0;
        }
        $result['crud']=$crud;
        echo json_encode($result);
    }

    public function hapus_data (Request $request) {
        $hapus='';
        $id=$request->id;
        $hapus = DB::table('tipe_angkutan')->where('kode' ,'=', $id)->delete();
        if($hapus == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            $result['error']=$hapus;
            $result['result']=0;
        }
        echo json_encode($result);
    }

    public function index(){
        $bbm = DB::select(DB::raw(" SELECT * FROM master_bbm "));
        return view('master_sales.tipe_angkutan.index', compact('bbm'));
    }

}
