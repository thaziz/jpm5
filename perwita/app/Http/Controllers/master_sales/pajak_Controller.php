<?php

namespace App\Http\Controllers\master_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class pajak_Controller extends Controller
{
    public function table_data () {
        $list = DB::table('pajak')->get();
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
        $data = DB::table('pajak')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $simpan='';
        $nomor = DB::table('pajak')->max('id');
       if ($nomor == '' ) {
         $nomor=1;
       }
       else{
          $nomor+=1;
       }
        $crud = $request->crud;
        $data = array(
                 'kode' => strtoupper($request->ed_kode),
                'id' => ($nomor),
                'nama' => strtoupper($request->ed_nama),
                'nilai' => strtoupper($request->ed_nilai),
                'keterangan' => strtoupper($request->ed_keterangan),
                'acc1' => strtoupper($request->ed_acc1),
                'acc2' => strtoupper($request->ed_acc2),
                'cash1' => strtoupper($request->ed_cash1),
                'cash2' => strtoupper($request->ed_cash2),
                'subcon1' => strtoupper($request->ed_subcon1),
                'subcon2' => strtoupper($request->ed_subcon2),
            );
        
        if ($crud == 'N') {
            $simpan = DB::table('pajak')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('pajak')->where('kode', $request->ed_kode_old)->update($data);
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
        $hapus = DB::table('pajak')->where('kode' ,'=', $id)->delete();
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
         $data = DB::table('d_akun')->where(function($or){
                                    $or->orWhere('id_akun','like','%230%')
                                        ->orWhere('id_akun','like','%2399%')
                                        ->orWhere('id_akun','like','%2499%')
                                        ->orWhere('id_akun','like','%2599%')
                                       ->orWhere('id_akun','like','%250%')
                                       ->orWhere('id_akun','like','%240%');
        })->get();
         $data2 = DB::table('subcon')->get();
        return view('master_sales.pajak.index',compact('data','data2'));
    }

}
