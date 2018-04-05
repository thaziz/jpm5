<?php

namespace App\Http\Controllers\wilayah;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class kecamatan_Controller extends Controller
{
    public function table_data () {
        $list = DB::select(DB::raw(" SELECT k.id,k.nama,p.nama kota FROM kecamatan k LEFT JOIN kota p ON p.id=k.id_kota "));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['id'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['id'].'" name="'.$data[$i]['nama'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('id');
        $data = DB::table('kecamatan')->where('id', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        // dd($request);
        $simpan='';
        $crud = $request->crud;
        $data = array(
                'id' => $request->id,
                'id_kota' => $request->kota,
                'nama' => $request->kecamatan,
            );
        // return $data;
        if ($crud == 'N') {
            $simpan = DB::table('kecamatan')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('kecamatan')->where('id', $request->id_old)->update($data);
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
        $hapus = DB::table('kecamatan')->where('id' ,'=', $id)->delete();
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
        // return 'a';
        $kota = DB::select(DB::raw(" SELECT id,nama FROM kota p ORDER BY nama ASC "));
        return view('wilayah.kecamatan.index',compact('kota'));
    }

}