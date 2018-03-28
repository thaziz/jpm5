<?php

namespace App\Http\Controllers\master_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class grup_customer_Controller extends Controller
{
    public function table_data () {
        $list = DB::table('group_customer')->get();
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['group_id'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['group_id'].'" name="'.$data[$i]['group_nama'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('id');
        $data = DB::table('group_customer')->where('group_id', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $simpan='';
        $crud = $request->crud;
        $data = array(
                'group_id' => strtoupper($request->ed_kode),
                'group_nama' => strtoupper($request->ed_nama),
                'group_alamat' => strtoupper($request->ed_alamat),
                'group_folder' => strtoupper($request->ed_folder),
                'group_person' => strtoupper($request->ed_person),
            );
        
        if ($crud == 'N') {
            $simpan = DB::table('group_customer')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('group_customer')->where('group_id', $request->ed_kode_old)->update($data);
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
        $hapus = DB::table('group_customer')->where('group_id' ,'=', $id)->delete();
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
        //$kota = DB::select(DB::raw(" SELECT id,nama FROM kota ORDER BY nama ASC "));
        return view('master_sales.grup_customer.index');
    }

}
