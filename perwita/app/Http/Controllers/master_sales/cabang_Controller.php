<?php

namespace App\Http\Controllers\master_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;

class cabang_Controller extends Controller
{
    public function table_data () {
        $sql = "    SELECT a.kode, a. nama, k.nama kota, a.alamat, a.telpon, a.fax FROM cabang a
                    LEFT JOIN kota k ON k.id=a.id_kota  ";
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $div_1  =   '<div class="btn-group">';
                              if (Auth::user()->punyaAkses('Cabang','ubah')) {
                              $div_2  = '<button type="button" id="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" >'.'<i class="fa fa-pencil"></i></button>';
                              }else{
                                $div_2 = '';
                              }
                              if (Auth::user()->punyaAkses('Cabang','hapus')) {
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
        $data = DB::table('cabang')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $simpan='';
        $crud = $request->crud;
        $data = array(
                'kode' => strtoupper($request->ed_kode),
                'nama' => strtoupper($request->ed_nama),
                'id_kota' => strtoupper($request->cb_kota),
                'alamat' => strtoupper($request->ed_alamat),
                'telpon' => strtoupper($request->ed_telpon),
                'fax' => strtoupper($request->ed_fax),
            );
        
        if ($crud == 'N') {
            $simpan = DB::table('cabang')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('cabang')->where('kode', $request->ed_kode_old)->update($data);
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
        $hapus = DB::table('cabang')->where('kode' ,'=', $id)->delete();
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
        $kota = DB::select(DB::raw(" SELECT id,nama FROM kota ORDER BY nama ASC "));
        return view('master_sales.cabang.index',compact('kota'));
    }

}
