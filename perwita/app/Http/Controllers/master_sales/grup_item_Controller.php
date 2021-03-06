<?php

namespace App\Http\Controllers\master_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;
use carbon\carbon;

class grup_item_Controller extends Controller
{
    public function table_data () {
        $list = DB::table('grup_item')->get();
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
             $div_1  =   '<div class="btn-group">';
                                  if (Auth::user()->punyaAkses('Group Item','ubah')) {
                                  $div_2  = '<button type="button" id="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>';
                                  }else{
                                    $div_2 = '';
                                  }
                                  if (Auth::user()->punyaAkses('Group Item','hapus')) {
                                  $div_3  = '<button type="button" id="'.$data[$i]['kode'].'" name="'.$data[$i]['nama'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>';
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

    public function get_data (Request $request) 
    {
        $id =$request->input('id');
        $data = DB::table('grup_item')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) 
    {
        $simpan='';
        $crud = $request->crud;
        
        
        if ($crud == 'N') {
            $data = array(
                'kode' => strtoupper($request->ed_kode),
                'nama' => strtoupper($request->ed_nama),
                'keterangan' => strtoupper($request->ed_keterangan),
                'acc_piutang' => strtoupper($request->acc_piutang),
                'csf_piutang' => strtoupper($request->csf_piutang),
                'create_at' => carbon::now(),
                'update_at' => carbon::now(),
                'create_by' => Auth::user()->m_username,
                'update_by' => Auth::user()->m_username,
            );
            $simpan = DB::table('grup_item')->insert($data);
        }elseif ($crud == 'E') {
            $data = array(
                'kode' => strtoupper($request->ed_kode),
                'nama' => strtoupper($request->ed_nama),
                'keterangan' => strtoupper($request->ed_keterangan),
                'acc_piutang' => strtoupper($request->acc_piutang),
                'csf_piutang' => strtoupper($request->csf_piutang),
                'update_at' => carbon::now(),
                'update_by' => Auth::user()->m_username,
            );
            $simpan = DB::table('grup_item')->where('kode', $request->ed_kode_old)->update($data);
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
        $hapus = DB::table('grup_item')->where('kode' ,'=', $id)->delete();
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
       $akun  = DB::table('d_akun')
                   ->where('id_akun','like','13'.'%')
                   ->get();
        return view('master_sales.grup_item.index',compact('akun'));
    }

}
