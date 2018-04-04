<?php

namespace App\Http\Controllers\master_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class biaya_Controller  extends Controller
{
    
    public function edit (Request $request) {
        $id =$request->input('id');
        $simpan='';
        $crud = $request->crud;

        $data = DB::table('biaya')->where('b_kode', $id)->first();
        echo json_encode($data);
    }

    public function save (Request $request) {
        // dd($request);
        $simpan='';
        $crud = $request->crud;

        
        if ($request->checkbox1 == 'on') {
            $request->checkbox1 = 'TRUE';
        }elseif($request->checkbox1 == null){
            $request->checkbox1 = 'FALSE';
        }
        $data = array(
                'b_kode' => strtoupper($request->ed_kode),
                'b_nama' => strtoupper($request->ed_nama),
                'b_debet_kredit' => strtoupper($request->ed_dk),
                'b_acc_hutang' => strtoupper($request->ed_acc),
                'b_csf_hutang' => strtoupper($request->ed_csf),
                'b_default' => strtoupper($request->checkbox1),
            );
        
        if ($crud == 'N') {
            $simpan = DB::table('biaya')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('biaya')->where('b_kode', $request->ed_kode_old)->update($data);
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
    public function update (Request $request) {
        // dd($request);
        $simpan='';
        $crud = $request->crud;

        // return $request->ed_kode_old;
        if ($request->checkbox1 == 'on') {
            $request->checkbox1 = 'TRUE';
        }elseif($request->checkbox1 == null){
            $request->checkbox1 = 'FALSE';
        }
        $data = array(
                'b_kode' => strtoupper($request->ed_kode),
                'b_nama' => strtoupper($request->ed_nama),
                'b_debet_kredit' => strtoupper($request->ed_dk),
                'b_acc_hutang' => strtoupper($request->ed_acc),
                'b_csf_hutang' => strtoupper($request->ed_csf),
                'b_default' => strtoupper($request->checkbox1),
            );
        
        if ($crud == 'E') {
            $simpan = DB::table('biaya')->where('b_kode', $request->ed_kode_old)->update($data);
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

    public function hapus (Request $request) {
        $hapus='';
        $id=$request->id;
        $hapus = DB::table('biaya')->where('b_kode' ,'=', $id)->delete();
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
        $data = DB::table('biaya')->get();
        $acc = DB::table('d_akun')->get();
        $csf = DB::table('d_akun')->get();
        return view('master_sales.biaya.index',compact('data','acc','csf'));
    }

}
