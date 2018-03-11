<?php

namespace App\Http\Controllers\setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class pengguna_Controller extends Controller
{
    public function table_data () {
        $sql = "SELECT d_mem.*,c.nama cabang FROM d_mem
                LEFT JOIN cabang c ON d_mem.kode_cabang=c.kode ";
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['m_id'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['m_id'].'" name="'.$data[$i]['m_username'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('id');
        $data = DB::table('d_mem')->where('m_id', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $simpan='';
        $crud = $request->crud;
        $data = array(
                'm_id' => $request->ed_nama,
                'm_username' => $request->ed_nama,    
                'm_passwd' => sha1(md5('passwordAllah') + $request->ed_kata_sandi),
                'm_level' => strtoupper($request->cb_level),
                'kode_cabang' => strtoupper($request->cb_cabang),
            );

        if ($crud == 'N') {
            $simpan = DB::table('d_mem')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('d_mem')->where('m_id', $request->ed_nama_old)->update($data);
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
        $hapus = DB::table('d_mem')->where('m_id' ,'=', $id)->delete();
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
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $level = DB::select(" SELECT DISTINCT level from hak_akses  ORDER BY level ASC ");
        return view('setting.pengguna.index',compact('cabang','level'));

    }

}
