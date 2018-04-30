<?php

namespace App\Http\Controllers\master_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;


class satuan_Controller extends Controller
{
    public function cek_hak_akses() {
        $level = Auth::user()->m_level;
        $data = DB::table('hak_akses')->where('level', $level)->where('menu', 'Satuan')->first();
        $hak_akses['aktif'] = $data->aktif;
        $hak_akses['tambah'] = $data->tambah;
        $hak_akses['ubah'] = $data->ubah;
        $hak_akses['hapus'] = $data->hapus;
        $hak_akses['cabang'] = $data->cabang;
        $hak_akses['print'] = $data->print;
        $hak_akses['all'] = $data->all;
        return ($hak_akses);
    }
    
    public function __construct() {
        $this->middleware('auth');
    }

    public function table_data () {

        $list = DB::table('satuan')->get();
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button


            // $data[$i]['button'] = ' <div class="btn-group">
            //                             <button type="button" id="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
            //                             <button type="button" id="'.$data[$i]['kode'].'" name="'.$data[$i]['nama'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
            //                         </div> ';
            // $i++;

            $div_1  =   '<div class="btn-group">';
                                  if (Auth::user()->punyaAkses('Satuan','ubah')) {
                                  $div_2  = '<button type="button" id="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>';
                                  }else{
                                    $div_2 = '';
                                  }
                                  if (Auth::user()->punyaAkses('Satuan','hapus')) {
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

    public function get_data (Request $request) {
        $id =$request->input('id');
        $data = DB::table('satuan')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $hak_akses = $this->cek_hak_akses();
        $simpan='';
        $crud = $request->crud;
        $data = array(
                'kode' => strtoupper($request->ed_kode),
                'nama' => strtoupper($request->ed_nama),
                'isi' => strtoupper($request->ed_isi),
            );

        if ($crud == 'N' ) {
            $simpan = DB::table('satuan')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('satuan')->where('kode', $request->ed_kode_old)->update($data);
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
        if (Auth::user()->punyaAkses('Satuan','hapus')) {
            $hapus = DB::table('satuan')->where('kode' ,'=', $id)->delete();
        }
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
        $hak_akses = $this->cek_hak_akses();
        if ($hak_akses['aktif'] == FALSE) {
            return redirect('halaman_kosong');
        }else{
            return view('master_sales.satuan.index');
        }
    }

}
