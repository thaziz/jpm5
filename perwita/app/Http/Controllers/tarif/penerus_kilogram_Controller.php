<?php

namespace App\Http\Controllers\tarif;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;

class penerus_kilogram_Controller  extends Controller
{
    public function table_data () {
        $list = DB::table('tarif_penerus_kilogram')
        ->select(
            'provinsi.nama as provinsi_nama',
            'provinsi.id as provinsi_id',

            'kota.id as kota_id',
            'kota.nama as kota_nama',

            'kecamatan.id as kecamatan_id',
            'kecamatan.nama as kecamatan_nama',

            'zo_10r.harga_zona as 10reguler',
            'zo_10x.harga_zona as 10express',
            'zo_20r.harga_zona as 20reguler',
            'zo_20x.harga_zona as 20express',


            'id_tarif_kilogram','tarif_10express_kilo','tarif_10reguler_kilo','tarif_20express_kilo','tarif_20reguler_kilo','id_increment_kilogram','type_kilo')


        ->join('provinsi','tarif_penerus_kilogram.id_provinsi_kilo','=','provinsi.id')

        ->join('kota','tarif_penerus_kilogram.id_kota_kilo','=','kota.id')
        
        ->join('kecamatan','tarif_penerus_kilogram.id_kecamatan_kilo','=','kecamatan.id')

        ->join('zona as zo_10r','zo_10r.id_zona','=','tarif_penerus_kilogram.tarif_10reguler_kilo')

        ->join('zona as zo_10x','zo_10x.id_zona','=','tarif_penerus_kilogram.tarif_10express_kilo')

        ->join('zona as zo_20r','zo_20r.id_zona','=','tarif_penerus_kilogram.tarif_20reguler_kilo')

        ->join('zona as zo_20x','zo_20x.id_zona','=','tarif_penerus_kilogram.tarif_20express_kilo')

        ->get();
        // return $list;
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
             $div_1  =   '<div class="btn-group">';
                                  if (Auth::user()->punyaAkses('Tarif Penerus Kilogram','ubah')) {
                                  $div_2  = '<button type="button" id="'.$data[$i]['id_tarif_kilogram'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>';
                                  }else{
                                    $div_2 = '';
                                  }
                                  if (Auth::user()->punyaAkses('Tarif Penerus Kilogram','hapus')) {
                                  $div_3  = '<button type="button" id="'.$data[$i]['id_tarif_kilogram'].'" name="'.$data[$i]['id_tarif_kilogram'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>';
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
        // dd($request);
        $id =$request->input('id');
        $data = DB::table('tarif_penerus_kilogram')
        ->select(
            'provinsi.nama as provinsi_nama',
            'provinsi.id as provinsi_id',

            'kota.id as kota_id',
            'kota.nama as kota_nama',
            'kota.kode_kota as kota_kode',
            
            'kecamatan.id as kecamatan_id',
            'kecamatan.nama as kecamatan_nama',

            'zo_10r.harga_zona as 10reguler',
            'zo_10x.harga_zona as 10express',
            'zo_20r.harga_zona as 20reguler',
            'zo_20x.harga_zona as 20express',


            'id_tarif_kilogram','tarif_10express_kilo','tarif_10reguler_kilo','tarif_20express_kilo','tarif_20reguler_kilo','id_increment_kilogram','type_kilo')


        ->join('provinsi','tarif_penerus_kilogram.id_provinsi_kilo','=','provinsi.id')

        ->join('kota','tarif_penerus_kilogram.id_kota_kilo','=','kota.id')
        
        ->join('kecamatan','tarif_penerus_kilogram.id_kecamatan_kilo','=','kecamatan.id')

        ->join('zona as zo_10r','zo_10r.id_zona','=','tarif_penerus_kilogram.tarif_10reguler_kilo')

        ->join('zona as zo_10x','zo_10x.id_zona','=','tarif_penerus_kilogram.tarif_10express_kilo')

        ->join('zona as zo_20r','zo_20r.id_zona','=','tarif_penerus_kilogram.tarif_20reguler_kilo')

        ->join('zona as zo_20x','zo_20x.id_zona','=','tarif_penerus_kilogram.tarif_20express_kilo')
        ->where('id_tarif_kilogram','=', $id)
        ->get();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        // dd($request);

        $id_incremet = DB::table('tarif_penerus_kilogram')->select('id_increment_kilogram')->max('id_increment_kilogram');    
        if ($id_incremet == '') {
            $id_incremet = 1;
        }else{
            $id_incremet += 1;
        }

        $kode_id = DB::table('tarif_penerus_kilogram')->select('id_increment_kilogram')->max('id_increment_kilogram');    
       
         $kode_id = $kode_id+1;
            $kode_id = str_pad($kode_id, 5,'0',STR_PAD_LEFT);
        
        $kode_kota = $request->kode_kota;
        $kode_cabang = Auth::user()->kode_cabang;

        $kodeutama = $kode_kota.'/'.$kode_cabang.'/'.$kode_id;
        // return $kodeutama;
        $simpan='';
        $crud = $request->crud;

         
          
        if ($crud == 'N') {

           $data = array(
                'id_tarif_kilogram' => $kodeutama,
                'id_provinsi_kilo'=> $request->ed_provinsi,
                'id_kota_kilo' =>$request->ed_kota,
                'id_kecamatan_kilo'=>$request->ed_kecamatan,
                'tarif_10reguler_kilo'=>$request->ed_10reguler,
                'tarif_10express_kilo'=>$request->ed_10express,
                'tarif_20express_kilo'=>$request->ed_20express,
                'tarif_20reguler_kilo'=>$request->ed_20reguler,
                'type_kilo' =>$request->ed_tipe,
                'id_increment_kilogram'=>$id_incremet,

            );

            $simpan = DB::table('tarif_penerus_kilogram')->insert($data);
        }elseif ($crud == 'E') {
            $kode_sama = $request->ed_kode_old;
            $kode_sama = str_pad($kode_sama, 5,'0',STR_PAD_LEFT);
            $kodeedit = $kode_kota.'/'.$kode_cabang.'/'.$kode_sama;

             $data = array(
                'id_tarif_kilogram' => $kodeedit,
                'id_provinsi_kilo'=> $request->ed_provinsi,
                'id_kota_kilo' =>$request->ed_kota,
                'id_kecamatan_kilo'=>$request->ed_kecamatan,
                'tarif_10reguler_kilo'=>$request->ed_10reguler,
                'tarif_10express_kilo'=>$request->ed_10express,
                'tarif_20express_kilo'=>$request->ed_20express,
                'tarif_20reguler_kilo'=>$request->ed_20reguler,
                'type_kilo' =>$request->ed_tipe,
                'id_increment_kilogram'=>$request->ed_kode_old,

            );
            $simpan = DB::table('tarif_penerus_kilogram')->where('id_tarif_kilogram', $request->ed_kode)->update($data);
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
        $hapus = DB::table('tarif_penerus_kilogram')->where('id_tarif_kilogram' ,'=', $id)->delete();
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
        $zona = DB::select(DB::raw(" SELECT id_zona,nama nama_zona,harga_zona FROM zona  "));

         // $kotakota = $this->get_kota();
        return view('tarif.penerus_kilogram.index',compact('provinsi','kota','kecamatan','zona'));
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
