<?php

namespace App\Http\Controllers\wilayah;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;

class provinsi_Controller extends Controller
{

    public function table_data () {
        $list = DB::table('provinsi')->get();
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $div_1  =   '<div class="btn-group">';
                              if (Auth::user()->punyaAkses('Provinsi','ubah')) {
                              $div_2  = '<button type="button" id="'.$data[$i]['id'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" >'.'<i class="fa fa-pencil"></i></button>';
                              }else{
                                $div_2 = '';
                              }
                              if (Auth::user()->punyaAkses('Provinsi','hapus')) {
                              $div_3  = '<button type="button" id="'.$data[$i]['id'].'" name="'.$data[$i]['nama'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" >'.
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
        $data = DB::table('provinsi')->where('id', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $simpan='';
        //$request = strtoupper($request) ;
        $crud = $request->crud;
        $data = array(
                        'id' => $request->id,
                        'nama' => $request->provinsi,
                    );
        if ($crud == 'N') {
            $simpan = DB::table('provinsi')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('provinsi')->where('id', $request->id_old)->update($data);
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
        $hapus = DB::table('provinsi')->where('id' ,'=', $id)->delete();
        if($hapus == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            $result['error']=$hapus;
            $result['result']=0;
        }
        echo json_encode($result);
    }

}
