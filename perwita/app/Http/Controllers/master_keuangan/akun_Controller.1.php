<?php

namespace App\Http\Controllers\master_keuangan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class akun_Controller extends Controller
{
    public function table_data () {
        $list = DB::table('akun')->orderBy('kode', 'ASC')->get();
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        $jml_spasi= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $kode='';
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['kode'].'" name="'.$data[$i]['nama'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
//            if ($kode == $list->kode) {
//                
//            }
            $data[$i]['abc'] = '  ';
//            $kode=$list->kode;
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('id');
        $data = DB::table('akun')->where('kode', $id)->first();
        echo json_encode($data);
    }

    
    
    
    public function save_data (Request $request) {
        $simpan='';
        $crud = $request->crud;
        $data = array(
                'kode' => strtoupper($request->ed_kode),
                'nama' => strtoupper($request->ed_nama),
                'jenis' => strtoupper($request->cb_jenis),
            );
        
        
        if ($crud == 'N') {
            $simpan = DB::table('akun')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('akun')->where('kode', $request->ed_kode_old)->update($data);
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
        $hapus = DB::table('akun')->where('kode' ,'=', $id)->delete();
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
        $sql = " SELECT * FROM akun ";
        $data =  DB::select($sql);
        return view('master_keuangan.akun.index',compact('data'));
    }

}
