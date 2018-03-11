<?php

namespace App\Http\Controllers\master_keuangan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class kelompok_akun_Controller extends Controller
{
    public function table_data () {
        $list = DB::table('kelompok_akun')->get();
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['kode'].'" name="'.$data[$i]['nama'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('id');
        $data = DB::table('kelompok_akun')->where('kode', $id)->first();
        echo json_encode($data);
    }

    
    
    
    public function save_data (Request $request) {
        $simpan='';
        $laba='';
        $crud = $request->crud;
        $laba=0;
        $laba_rugi = strtoupper($request->cb_posisi_di_rugi_laba);
        if ($laba_rugi =='PENDAPATAN') {
            $laba=0;
        }elseif($laba_rugi =='BIAYA'){
            $laba=1;
        }elseif($laba_rugi =='NONE'){
            $laba=3;
        }
        $data = array(
                'kode' => strtoupper($request->ed_kode),
                'nama' => strtoupper($request->ed_nama),
                'posisi_di_buku_besar' => strtoupper($request->cb_posisi_di_buku_besar),
                'posisi_di_rugi_laba' => strtoupper($request->cb_posisi_di_rugi_laba),
                'laba' => $laba,
            );
        
        
        if ($crud == 'N') {
            $simpan = DB::table('kelompok_akun')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('kelompok_akun')->where('kode', $request->ed_kode_old)->update($data);
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
        $hapus = DB::table('kelompok_akun')->where('kode' ,'=', $id)->delete();
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
        return view('master_keuangan.kelompok_akun.index');
    }

}
