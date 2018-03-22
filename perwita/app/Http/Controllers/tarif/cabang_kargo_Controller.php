<?php

namespace App\Http\Controllers\tarif;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;

class cabang_kargo_Controller extends Controller
{
    public function table_data () {
        $sql = "    SELECT t.kode, t.id_kota_asal, k.nama asal,t.id_kota_tujuan, kk.nama tujuan, t.harga, t.jenis, t.waktu, t.kode_angkutan, a.nama AS angkutan 
                    FROM tarif_cabang_kargo t
                    LEFT JOIN kota k ON k.id=t.id_kota_asal 
                    LEFT JOIN kota kk ON kk.id=t.id_kota_tujuan 
                    LEFT JOIN angkutan a ON a.kode=t.kode_angkutan
                    ORDER BY t.id_kota_asal, t.id_kota_tujuan ";
        
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['kode'].'" name="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('id');
        $data = DB::table('tarif_cabang_kargo')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $simpan='';
        $crud = $request->crud;
          // KODE UTAMA
        $kode_utama = DB::table('tarif_cabang_kargo')->select('kode_detail_kargo')->max('kode_detail_kargo');
          $datadetail = DB::table('tarif_cabang_kargo')->select('kode_detail_kargo')->get();  
               $datadetailcount = count($datadetail);
         for ($i=0; $i <count($datadetail) ; $i++) {  
            if ($datadetail == null) {
                $datadetailcount;
            }else{
              $kode_detailtambahutama = $datadetail[$i]->kode_detail_kargo;
            }
            $kode_detailtambahutama+1;  
         }
        if ($kode_utama == '') {
            $kode_utama = 1;
        }else{
            $kode_utama += 1;
        }
        // return $kode_utama;

        if ($kode_utama < 10000 ) {
            $kode_utama = '0000'.$kode_utama;
        }
        // return $kode_utama;
        //end
        //KODE 
        $kode_detail = DB::table('tarif_cabang_kargo')->select('kode_detail_kargo')->max('kode_detail_kargo');
        
          $datadetail = DB::table('tarif_cabang_kargo')->select('kode_detail_kargo')->get();  
               $datadetailcount = count($datadetail);
         for ($i=0; $i <count($datadetail) ; $i++) {  
            if ($datadetail == null) {
                $datadetailcount;
            }else{
                $kode_detailtambah1 = $datadetail[$i]->kode_detail_kargo;

            }
            $kode_detailtambah1+1;  
         }
         // for ($i=0; $i <$datadetail ; $i++) {  
         //     $datadetail[$i]->keterangan;
             
         //     dd($datadetail);
         // }
        if ($kode_detail == '') {
            $kode_detail = 1;
        }else{
            $kode_detail += 1;
        }
        $kodecabang = Auth::user()->kode_cabang ;
        

      $cekdata = DB::table('tarif_cabang_kargo')->select('kode')->get();
            
        // return $cekdata;

      

        $kodekota = $request->kodekota;

        $jt_kode = DB::table('jenis_tarif')
                     ->where('jt_id',$request->cb_jenis)
                     ->first();
        $kodeutama = $kodekota.'/'.'D'.$jt_kode->jt_kode.$kodecabang.$kode_utama;

        $kodeutama = $kodeutama ;
        if ($crud == 'N') {
            $data = array(
                'kode' => strtoupper($kodeutama),
                'id_kota_asal' => $request->cb_kota_asal,
                'id_kota_tujuan' => $request->cb_kota_tujuan,
                'jenis' => $request->cb_jenis,
                'kode_angkutan' => $request->cb_angkutan,
                'kode_detail_kargo' => $kode_detail,
                'harga' => filter_var($request->ed_harga, FILTER_SANITIZE_NUMBER_INT),
                'waktu' => filter_var($request->ed_waktu, FILTER_SANITIZE_NUMBER_INT),
            );
            $simpan = DB::table('tarif_cabang_kargo')->insert($data);
        }elseif ($crud == 'E') {
            
            if ($kode_detailtambah1 == $kode_detailtambah1 ) {
                    // $kode_detail += 1;
                    if ($request->ed_kode_old < 10000 ) {
                        $kode_utama = '0000'.($request->ed_kode_old);
                    }
                    if ($request->cb_jenis == 'EXPRESS') {
                        $kodeutama = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;
                    }else if ($request->cb_jenis == 'REGULER') {
                        $kodeutama = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;
                    }
                }

            $data = array(
                'kode' => $kodeutama,
                'id_kota_asal' => $request->cb_kota_asal,
                'id_kota_tujuan' => $request->cb_kota_tujuan,
                'jenis' => $request->cb_jenis,
                'kode_angkutan' => $request->cb_angkutan,
                'kode_detail_kargo' => $request->ed_kode_old,
                'harga' => filter_var($request->ed_harga, FILTER_SANITIZE_NUMBER_INT),
                'waktu' => filter_var($request->ed_waktu, FILTER_SANITIZE_NUMBER_INT),
            );
            // dd($request->ed_kode);
            $simpan = DB::table('tarif_cabang_kargo')->where('kode', $request->ed_kode)->update($data);
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
        $hapus = DB::table('tarif_cabang_kargo')->where('kode' ,'=', $id)->delete();
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
        $kota = DB::select(DB::raw(" SELECT id,nama,kode_kota FROM kota ORDER BY nama ASC "));
        $angkutan = DB::select(DB::raw(" SELECT kode,nama FROM tipe_angkutan ORDER BY nama ASC "));
        $jenis_tarif = DB::table('jenis_tarif')
                         ->where('jt_group',1)
                         ->orWhere('jt_group',3)
                         ->get();
        return view('tarif.cabang_kargo.index',compact('kota','angkutan','jenis_tarif'));
    }

}
