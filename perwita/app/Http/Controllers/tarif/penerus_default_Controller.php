<?php

namespace App\Http\Controllers\tarif;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Carbon\carbon;
use Auth;

class penerus_default_Controller extends Controller
{
    public function table_data () {

        $cabang = Auth::user()->kode_cabang;
      if (Auth::user()->punyaAkses('Tarif Penerus Default','all')) {
        $list = DB::table('tarif_penerus_default')->select('tarif_penerus_default.*','cabang.nama as cabang')->join('cabang','cabang.kode','=','tarif_penerus_default.cabang_default')->get();
        }else{
            $list = DB::table('tarif_penerus_default')->select('tarif_penerus_default.*','cabang.nama as cabang')->join('cabang','cabang.kode','=','tarif_penerus_default.cabang_default')->where('cabang_default',$cabang)->get();
        }


        // return $list;
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button

            $div_1  =   '<div class="btn-group">';
                                  if (Auth::user()->punyaAkses('Tarif Penerus Default','ubah')) {
                                  $div_2  = '<button type="button" id="'.$data[$i]['id'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>';
                                  }else{
                                    $div_2 = '';
                                  }
                                  if (Auth::user()->punyaAkses('Tarif Penerus Default','hapus')) {
                                  $div_3  = '<button type="button" id="'.$data[$i]['id'].'" name="'.$data[$i]['id'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>';
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
        $data = DB::table('tarif_penerus_default')->where('id', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        // dd($request);   
        $simpan='';
        $crud = $request->crud;
        if ($request->cb_keterangan == null ) {
            $request->cb_keterangan = ' - ';
        }

        if ($crud == 'N') {
            $data = array(
                'jenis' => $request->cb_jenis,
                'keterangan' => $request->cb_keterangan,
                'tipe_kiriman' => $request->cb_tipe_kiriman,
                'harga' => filter_var($request->ed_harga, FILTER_SANITIZE_NUMBER_INT),
                'id_zona_foreign' => $request->id_zona_foreign,
                'cabang_default' => $request->ed_cabang,
                'create_at' => Carbon::now(),
                'create_by' => auth::user()->m_name,
            );
            $simpan = DB::table('tarif_penerus_default')->insert($data);
        }elseif ($crud == 'E') {
            $data = array(
                'jenis' => $request->cb_jenis,
                'keterangan' => $request->cb_keterangan,
                'tipe_kiriman' => $request->cb_tipe_kiriman,
                'harga' => filter_var($request->ed_harga, FILTER_SANITIZE_NUMBER_INT),
                'id_zona_foreign' => $request->id_zona_foreign,
                'cabang_default' => $request->ed_cabang,
                'update_at' => Carbon::now(),
                'update_by' => auth::user()->m_name,
            );
            $simpan = DB::table('tarif_penerus_default')->where('id', $request->ed_id)->update($data);
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
        $hapus = DB::table('tarif_penerus_default')->where('id' ,'=', $id)->delete();
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
        // return'a';
        $kota = DB::select(DB::raw(" SELECT id,nama FROM kota ORDER BY nama ASC "));
        $zona = DB::select(DB::raw(" SELECT * FROM zona ORDER BY nama ASC "));
        $cabang_default = DB::select(DB::raw(" SELECT kode,nama FROM cabang ORDER BY kode ASC "));
        return view('tarif.penerus_default.index',compact('kota','zona','cabang_default'));
    }

}
