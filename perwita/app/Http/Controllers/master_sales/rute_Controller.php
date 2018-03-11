<?php

namespace App\Http\Controllers\master_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class rute_Controller extends Controller
{
    public function table_data_detail (Request $request) {
        $rute = strtoupper($request->input('kode'));
        $sql = "   SELECT * FROM rute_d WHERE kode_rute='$rute'  ";
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['id'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['id'].'" name="'.$data[$i]['kota'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('kode');
        $data = DB::table('rute')->where('kode', $id)->first();
        echo json_encode($data);
    }
    
    public function get_data_detail (Request $request) {
        $id =$request->input('id');
        $data = DB::table('rute_d')->where('id', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $simpan='';
        $crud = $request->crud_h;
        $kode_old = $request->ed_kode_old;
        $data = array(
                'kode' => strtoupper($request->ed_kode),
                'nama' => strtoupper($request->ed_nama),
                'keterangan' => strtoupper($request->ed_keterangan),
                'kode_cabang' => strtoupper($request->cb_cabang),
            );
        
        if ($crud == 'N' and $kode_old =='') {
            $simpan = DB::table('rute')->insert($data);
            
        } else {
            $simpan = DB::table('rute')->where('kode', $kode_old)->update($data);
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

    public function hapus_data($kode_rute=null){
        DB::beginTransaction();
        DB::table('rute_d')->where('kode_rute' ,'=', $kode_rute)->delete();
        DB::table('rute')->where('kode' ,'=', $kode_rute)->delete();
        DB::commit();
        return redirect('master_sales/rute');
    }
    
    public function save_data_detail (Request $request) {
        $simpan='';
        $crud = $request->crud;
        $data = array(
                'kode_rute' => strtoupper($request->ed_kode_rute),
                'id_kota' => strtoupper($request->cb_kota),
                'kota' => strtoupper($request->ed_kota),
            );
        if ($crud == 'N') {
            $simpan = DB::table('rute_d')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('rute_d')->where('id', $request->ed_id)->update($data);
        }
        $kode_rute = strtoupper($request->ed_kode_rute);
        //$jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM rute_d WHERE kode_rute='$kode_rute' "))->first();
        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
          //  $result['jml_detail']=$jml_detail->jumlah;
        }else{
            $result['error']=$data;
            $result['result']=0;
            
        }
        $result['crud']=$crud;
        echo json_encode($result);
    }
    
    public function hapus_data_detail (Request $request) {
        $hapus='';
        $id=$request->id;
        $hapus = DB::table('rute_d')->where('id' ,'=', $id)->delete();
        $kode_rute = strtoupper($request->ed_kode_rute);
        $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM rute_d WHERE kode_rute='$kode_rute' "))->first();
        if($hapus == TRUE){
            $result['error']='';
            $result['result']=1;
            $result['jml_detail']=$jml_detail->jumlah;
        }else{
            $result['error']=$hapus;
            $result['result']=0;
        }
        echo json_encode($result);
    }

    public function index(){
        $sql = "    SELECT r.*,c.nama cabang FROM rute r
                    LEFT JOIN cabang c ON c.kode=r.kode_cabang ";
        $rute =  DB::select($sql);
        return view('master_sales.rute.index',compact('rute'));
    }
    
    public function form($kode=null){
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        if ($kode != null) {
            $data = DB::table('rute')->where('kode', $kode)->first();
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM rute_d WHERE kode_rute='$kode' "))->first();
        }else{
            $data = null;
            $jml_detail = 0;
        }
        return view('master_sales.rute.form',compact('kota','data','cabang','jml_detail' ));
    }

}
