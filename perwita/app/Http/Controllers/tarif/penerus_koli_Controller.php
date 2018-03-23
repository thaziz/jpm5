<?php

namespace App\Http\Controllers\tarif;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;

class penerus_koli_Controller  extends Controller
{
    public function table_data () {
        $list = DB::table('tarif_penerus_koli')
        ->select(
            'provinsi.nama as provinsi_nama',
            'provinsi.id as provinsi_id',

            'kota.id as kota_id',
            'kota.nama as kota_nama',

            'kecamatan.id as kecamatan_id',
            'kecamatan.nama as kecamatan_nama',

            'id_increment_koli',
            
            'tarif_10express_koli','tarif_10reguler_koli',
            'tarif_20express_koli','tarif_20reguler_koli',
            'tarif_30express_koli','tarif_30reguler_koli',
            'tarif_>30express_koli','tarif_>30reguler_koli',

            'id_tarif_koli','type_koli')


        ->join('provinsi','tarif_penerus_koli.id_provinsi_koli','=','provinsi.id')

        ->join('kota','tarif_penerus_koli.id_kota_koli','=','kota.id')
        
        ->join('kecamatan','tarif_penerus_koli.id_kecamatan_koli','=','kecamatan.id')

        ->get();
        // return $list;
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['id_increment_koli'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['id_increment_koli'].'" name="'.$data[$i]['id_increment_koli'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        // dd($request);
        $id =$request->input('id');
        $data = DB::table('tarif_penerus_koli')->where('id_increment_koli','=', $id)->get();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        // dd($request);

        $id_incremet = DB::table('tarif_penerus_koli')->select('id_increment_koli')->max('id_increment_koli');    
        if ($id_incremet == '') {
            $id_incremet = 1;
        }else{
            $id_incremet += 1;
        }

        $kode_id = DB::table('tarif_penerus_koli')->select('id_increment_koli')->max('id_increment_koli');    
        if ($kode_id == '') {
            $kode_id = 1;
        }else{
            $kode_id += 1;
        }

        if ($kode_id < 10000 ) {
            $kode_id = '0000'.$kode_id;
        }
        
        $kode_kota = $request->kode_kota;
        $kode_cabang = Auth::user()->kode_cabang;

        $kodeutama = $kode_kota.'/'.$kode_cabang.'/'.$kode_id;
        // return $kodeutama;
        $simpan='';
        $crud = $request->crud;

         
          
        if ($crud == 'N') {

           $data = array(
                'id_tarif_koli' => $kodeutama,
                'id_provinsi_koli'=> $request->ed_provinsi,
                'id_kota_koli' =>$request->ed_kota,
                'id_kecamatan_koli'=>$request->ed_kecamatan,
                
                'tarif_10reguler_koli'=>$request->ed_10_reguler,
                'tarif_10express_koli'=>$request->ed_10_express,

                'tarif_20reguler_koli'=>$request->ed_20_reguler,
                'tarif_20express_koli'=>$request->ed_20_express,

                'tarif_30reguler_koli'=>$request->ed_30_reguler,
                'tarif_30express_koli'=>$request->ed_30_express,

                'tarif_>30reguler_koli'=>$request->ed_lebih_30_reguler,
                'tarif_>30express_koli'=>$request->ed_lebih_30_express,

                'type_koli' =>$request->ed_tipe,

                'id_increment_koli'=>$id_incremet,

            );
           
            $simpan = DB::table('tarif_penerus_koli')->insert($data);
        }elseif ($crud == 'E') {
            $kode_sama = $request->ed_kode_old;
            if ($kode_sama < 10000 ) {
            $kode_sama = '0000'.$kode_sama;
            }
            $kodeedit = $kode_kota.'/'.$kode_cabang.'/'.$kode_sama;

             $data = array(
                'id_increment_koli' => $kodeedit,
                'id_provinsi_koli'=> $request->ed_provinsi,
                'id_kota_koli' =>$request->ed_kota,
                'id_kecamatan_koli'=>$request->ed_kecamatan,
                'tarif_10reguler_koli'=>$request->ed_10reguler,
                'tarif_10express_koli'=>$request->ed_10express,
                'tarif_20express_koli'=>$request->ed_20express,
                'tarif_20reguler_koli'=>$request->ed_20reguler,
                'type_koli' =>$request->ed_tipe,
                'id_increment_koli'=>$request->ed_kode_old,

            );
            $simpan = DB::table('tarif_penerus_koli')->where('id_increment_koli', $request->ed_kode)->update($data);
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
        $hapus = DB::table('tarif_penerus_koli')->where('id_increment_koli' ,'=', $id)->delete();
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
        $provinsi = DB::select(DB::raw("SELECT id,nama FROM provinsi ORDER BY nama ASC"));
        
        $kota = DB::select(DB::raw(" SELECT id,nama FROM kota ORDER BY nama ASC "));
        $kecamatan = DB::select(DB::raw(" SELECT id,nama,id_kota FROM kecamatan ORDER BY nama ASC "));
         // $kotakota = $this->get_kota();
        return view('tarif.penerus_koli.index',compact('provinsi','kota','kecamatan'));
    }


    public function get_kota(Request $request){
        $req_kota = $request->kota; 
        $provinsi = DB::select(DB::raw("SELECT id,nama FROM provinsi ORDER BY nama ASC"));
        $kota1 = DB::select(DB::raw(" SELECT id,nama,id_provinsi,kode_kota FROM kota WHERE id_provinsi = $req_kota ORDER BY nama ASC "));
        return $kota1;
    }
    public function get_kec(Request $request){
        // dd($request);
        $req_kec = $request->kecamatan; 
        $kecamatan = DB::select(DB::raw(" SELECT id,nama,id_kota FROM kecamatan WHERE id_kota = $req_kec ORDER BY nama ASC "));
        return $kecamatan;
    }

}
