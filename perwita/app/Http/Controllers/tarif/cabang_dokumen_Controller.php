<?php

namespace App\Http\Controllers\tarif;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;

class cabang_dokumen_Controller extends Controller
{
    public function table_data () {
<<<<<<< HEAD
        $sql = "    SELECT t.id_provinsi_cabdokumen,p.nama provinsi,t.kode_detail,t.acc_penjualan,t.csf_penjualan,t.kode_sama,t.kode, t.id_kota_asal,k.kode_kota, k.nama asal,
=======
        $sql = "    SELECT t.crud,t.id_provinsi_cabdokumen,p.nama provinsi,t.kode_detail,t.acc_penjualan,t.csf_penjualan,t.kode_sama,t.kode, t.id_kota_asal,k.kode_kota, k.nama asal,
>>>>>>> 91850290b399df749d2a5d574c336ac378babc9d
        t.id_kota_tujuan,
        kk.nama tujuan, t.harga, t.jenis, t.waktu, t.tipe  
                    FROM tarif_cabang_dokumen t
                    LEFT JOIN kota k ON k.id=t.id_kota_asal 
                    LEFT JOIN kota kk ON kk.id=t.id_kota_tujuan 
                    LEFT JOIN provinsi p ON p.id=t.id_provinsi_cabdokumen
                    ORDER BY t.kode_detail DESC ";
        
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
       
                    foreach ($data as $key) {
                        // add new button
        
                        if ($kodecabang = Auth::user()->m_level == 'ADMINISTRATOR'  ) {
                            if ($data[$i]['id_provinsi_cabdokumen'] == null || $data[$i]['id_provinsi_cabdokumen'] == '') {
                                $data[$i]['button'] =' <div class="btn-group">
                                                            <button type="button" id="'.$data[$i]['id_kota_asal'].'" data-tujuan="'.$data[$i]['id_kota_tujuan'].'" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>

                                                        <button type="button" disabled="" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button> 
                                                            
                                                            <button type="button" id="'.$data[$i]['id_kota_asal'].'" name="'.$data[$i]['id_kota_tujuan'].'" data-asal="'.$data[$i]['asal'].'" data-tujuan="'.$data[$i]['tujuan'].'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button>                                    
                                                        </div> ';
                                $i++;
                                }
                                else{
<<<<<<< HEAD
                                $data[$i]['button'] =' <div class="btn-group">
=======
                                 if ($data[$i]['crud'] == 'E') {

                                            $data[$i]['button'] =' <div class="btn-group">
                                                            <button type="button" id="'.$data[$i]['id_kota_asal'].'" data-tujuan="'.$data[$i]['id_kota_tujuan'].'" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                                           
                                                            <button type="button" disabled="" id="'.$data[$i]['kode_sama'].'" name="'.$data[$i]['kode_sama'].'"  data-asal="'.$data[$i]['asal'].'" data-prov="'.$data[$i]['provinsi'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button> 

                                                             <button type="button" disabled="" id="'.$data[$i]['id_kota_asal'].'" name="'.$data[$i]['id_kota_tujuan'].'" data-asal="'.$data[$i]['asal'].'" data-tujuan="'.$data[$i]['tujuan'].'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button>                                     
                                                        </div> ';
                                            $i++;
                                            
                                        }else if(($data[$i]['crud'] == 'N')){
                                                $data[$i]['button'] =' <div class="btn-group">
>>>>>>> 91850290b399df749d2a5d574c336ac378babc9d
                                                            <button type="button" id="'.$data[$i]['id_kota_asal'].'" data-tujuan="'.$data[$i]['id_kota_tujuan'].'" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                                           
                                                            <button type="button" id="'.$data[$i]['kode_sama'].'" name="'.$data[$i]['kode_sama'].'"  data-asal="'.$data[$i]['asal'].'" data-prov="'.$data[$i]['provinsi'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button> 

                                                             <button type="button" id="'.$data[$i]['id_kota_asal'].'" name="'.$data[$i]['id_kota_tujuan'].'" data-asal="'.$data[$i]['asal'].'" data-tujuan="'.$data[$i]['tujuan'].'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button>                                     
                                                        </div> ';
                                $i++;
<<<<<<< HEAD
=======
                                        }
>>>>>>> 91850290b399df749d2a5d574c336ac378babc9d
                            }
                        }else{
                             if ($data[$i]['id_provinsi_cabdokumen'] == null || $data[$i]['id_provinsi_cabdokumen'] == '') {
                                    $data[$i]['button'] =' <div class="btn-group">
                                                            <button type="button" disabled="" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>

                                                            <button type="button" disabled="" data-asal="'.$data[$i]['asal'].'" data-tujuan="'.$data[$i]['tujuan'].'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button>                                    
                                                        </div> ';
                                $i++;
                                }
                                else{
                                $data[$i]['button'] =' <div class="btn-group">
                                                            <button type="button" disabled="" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                                           
                                                            <button type="button" disabled="" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button> 

                                                            <button type="button" disabled="" data-toggle="tooltip" title="Delete" style="color:white;" class="btn btn-purple btn-xs btndelete" ><i class="glyphicon glyphicon-trash"></i></button>                                   
                                                        </div> ';
                                $i++;
                            }
                        }
                        
                }
                
        


        // maksudku ngene
        
    
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        // dd($request);
        $asal = $request->asal;
        $tujuan = $request->tujuan;
        return $data = DB::table('tarif_cabang_dokumen')->where('id_kota_asal', $asal)->where('id_kota_tujuan','=',$tujuan)->orderBy('kode_detail','ASC')->get();

        
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        // dd($request);
        $simpan='';
        $crud = $request->crud;
        $kode_sama = DB::table('tarif_cabang_dokumen')->select('kode_sama')->max('kode_sama');    
        if ($kode_sama == '') {
            $kode_sama = 1;
        }else{
            $kode_sama += 1;
        }
        $kode_utama = DB::table('tarif_cabang_dokumen')->select('kode_detail')->max('kode_detail');    
        if ($kode_utama == '') {
            $kode_utama = 1;
        }else{
            $kode_utama += 1;
        }
         $kode_detail = DB::table('tarif_cabang_dokumen')->select('kode_detail')->max('kode_detail');
         $datadetail = DB::table('tarif_cabang_dokumen')->select('kode_detail')->get();  
               $datadetailcount = count($datadetail);
         for ($i=0; $i <count($datadetail) ; $i++) {  
            if ($datadetail == null) {
                $datadetailcount;
            }else{
                $kode_detailtambah1 = $datadetail[$i]->kode_detail;
            }
            $kode_detailtambah1+1;  
         }
        if ($kode_detail == '') {
            $kode_detail = 1;
        }else{
            $kode_detail += 1;
        }


        if ($kode_utama < 10000 ) {
            $kode_utama = '0000'.$kode_utama;
        }
        $kodekota = $request->kodekota;
        $kodecabang = Auth::user()->kode_cabang;


        $prov = $request->cb_provinsi_tujuan;
        $sel_prov = DB::table('kota')->select('id','nama')->orWhere('id_provinsi','=',$prov)->get();
        
        $id_provinsi_loop = '';
        for ($for=0; $for <count($sel_prov) ; $for++) { 
             $id_provinsi_loop = $id_provinsi_loop.' '.$sel_prov[$for]->id;
        }
             $id_provinsi_loop =explode(' ', $id_provinsi_loop);
              json_encode($id_provinsi_loop); 
              // dd($request);
     if ($request->cb_kota_tujuan == '' ) {  
      for ($save=1; $save <count($id_provinsi_loop) ; $save++) {
        // return $id_provinsi_loop;
        $check = DB::table('tarif_cabang_dokumen')->where('id_kota_asal','=',$request->cb_kota_asal)->where('id_kota_tujuan','=',$id_provinsi_loop[$save])->get();     
       $cek = count($check); 
         if ($cek > 1) {
           
            $hasil_cek = 'Data Sudah ada di database !';
            $result['hasil_cek']=$hasil_cek;
            return json_encode($result);
            
         }else {

          if ($crud =='N') {

              if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;            
                }
                        $regular = array(
                        'kode_sama' =>$kode_sama,
                        'kode_detail'=>$kode_detail,
                        'kode'=>$kode_reguler,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $id_provinsi_loop[$save],
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'REGULER',
                        'harga' => $request->harga_regular,
                        'waktu' => $request->waktu_regular,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );
            
             if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode_express = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode_express = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;            
                }

            $express = array(
                        'kode_sama' => $kode_sama,
                        'kode_detail'=>$kode_detail,
                        'kode'=>$kode_express,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $id_provinsi_loop[$save],
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'EXPRESS',
                        'harga' => $request->harga_express,
                        'waktu' => $request->waktu_express,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );

            if ($request->harga_outlet != null) {

               if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode_outlet = $kodekota.'/'.'D'.'O'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode_outlet = $kodekota.'/'.'D'.'O'.$kodecabang.$kode_utama;            
                }

                     $outlet = array(
                        'kode_sama' => $kode_sama,
                        'kode_detail'=>$kode_detail,
                        'kode'=>$kode_outlet,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $id_provinsi_loop[$save],
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'OUTLET',
                        'harga' => $request->harga_outlet,
                        'waktu' => null,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );
                $simpan = DB::table('tarif_cabang_dokumen')->insert($outlet);
                }else{

                }

            $simpan = DB::table('tarif_cabang_dokumen')->insert($regular);
            $simpan = DB::table('tarif_cabang_dokumen')->insert($express);
        }
      }
  }
    }else{
        $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;            
        $kot1 = $request->cb_kota_asal;
        $kot2 = $request->cb_kota_tujuan;
        $cek_sendiri = DB::table('tarif_cabang_dokumen')->where('id_kota_asal','=',$kot1)->where('id_kota_tujuan','=',$kot2)->get();      
        $ngecek = count($cek_sendiri);
<<<<<<< HEAD
        if ($ngecek > 1) {
            $hasil_cek = 'Data Sudah ada di database !';
            $result['hasil_cek']=$hasil_cek;
            return json_encode($result);
        }else{
=======
        
>>>>>>> 91850290b399df749d2a5d574c336ac378babc9d
         if ($crud == 'N') {
            if ($ngecek > 1) {
                        $hasil_cek = 'Data Sudah ada di database !';
                        $result['hasil_cek']=$hasil_cek;
                        return json_encode($result);
                    }else{
                    $regular = array(
                        'kode_sama' => $kode_sama,
                        'kode_detail'=>$kode_detail,
                        'kode'=>$kode_reguler,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'REGULER',
                        'harga' => $request->harga_regular,
                        'waktu' => $request->waktu_regular,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'crud'=>$crud,
                    );

                if ($datadetailcount == 0) {
                    $kode_detail += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode_express = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama; 
                }
                else if ($kode_detailtambah1 == $kode_detailtambah1) {
                    $kode_detail += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode_express = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;    
                }
                $express = array(
                        'kode_sama' => $kode_sama,
                        'kode_detail'=>$kode_detail,
                        'kode'=>$kode_express,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'EXPRESS',
                        'harga' => $request->harga_express,
                        'waktu' => $request->waktu_express,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'crud'=>$crud,
                    );
                if ($datadetailcount == 0) {
                    $kode_detail += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode_outlet = $kodekota.'/'.'D'.'O'.$kodecabang.$kode_utama; 
                }
                else if ($kode_detailtambah1 == $kode_detailtambah1) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode_outlet = $kodekota.'/'.'D'.'O'.$kodecabang.$kode_utama; 
                }
                if ($request->harga_outlet != null) {
                     $outlet = array(
                        'kode_sama' => $kode_sama,
                        'kode_detail'=>$kode_detail,
                        'kode'=>$kode_outlet,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'OUTLET',
                        'harga' => $request->harga_outlet,
                        'waktu' => null,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'crud'=>$crud,
                    );
                $simpan = DB::table('tarif_cabang_dokumen')->insert($outlet);
                }else{

                }
               
            $simpan = DB::table('tarif_cabang_dokumen')->insert($regular);
            $simpan = DB::table('tarif_cabang_dokumen')->insert($express);
            
          }  
        }else if ($crud == 'E') {
            // dd($request);   
                
                $id_reguler_edit = $request->id_reguler_edit;
                $id_express_edit = $request->id_express_edit;
                $id_outlet_edit = $request->id_outlet_edit;
                $integer_reg =  (int)$id_reguler_edit;
                $integer_exp =  (int)$id_express_edit;
                $integer_out =  (int)$id_outlet_edit;
                
                
                if ($integer_reg < 10000) {
                    $integer_reg = '0000'.$integer_reg; 
                }
                if ($integer_exp < 10000) {
                    $integer_exp = '0000'.$integer_exp; 
                }
                if ($integer_out < 10000) {
                    $integer_out = '0000'.$integer_out; 
                }
                
                if ($kodekota == '') {
                    $kode_reguler_edit = $request->id_reguler;
                }else{   
                    $kode_reguler_edit = $kodekota.'/'.'D'.'R'.$kodecabang.$integer_reg;
                }


                // return $kode_reguler_edit;
                if ($kodekota == '') {
                    $kode_express_edit = $request->id_express;
                }else{   
                    $kode_express_edit = $kodekota.'/'.'D'.'E'.$kodecabang.$integer_exp;
                }


                if ($kodekota == '') {
                    $kode_reguler_edit = $request->id_outlet;
                }else{   
                    $kode_outlet_edit = $kodekota.'/'.'D'.'O'.$kodecabang.$integer_out;
                }

                $regular = array(
                        'kode_sama' => $request->ed_kode_old,
                        'kode_detail'=>$request->id_reguler_edit,
                        'kode'=>$kode_reguler_edit,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'jenis' => 'REGULER',
                        'kode_cabang' => $request->ed_cabang,      
                        'harga' => $request->harga_regular,
                        'waktu' => $request->waktu_regular,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'crud'=>$crud,
                   );
                   if ($request->id_reguler_edit < 10000) {
                    $request->id_reguler_edit = '0000'.$integer_exp; 
                }
                // return $regular;
                $express = array(
                        'kode_sama' => $request->ed_kode_old,
                        'kode_detail'=>$request->id_express_edit,
                        'kode'=>$kode_express_edit,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang, 
                        'jenis' => 'EXPRESS',
                        'harga' => $request->harga_express,
                        'waktu' => $request->waktu_express,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'crud'=>$crud,
                    );
               
                   
                if ($request->harga_outlet != null) {
                     if ($request->id_reguler_edit < 10000) {
                    $request->id_reguler_edit = '0000'.$integer_out; 
                }
                $outlet = array(
                        'kode_sama' => $request->ed_kode_old,
                        'kode_detail'=>$request->id_outlet_edit,
                        'kode'=>$kode_outlet_edit,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'OUTLET',
                        'harga' => $request->harga_outlet,
                        'waktu' => null,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'crud'=>$crud,
                    );
            $simpan = DB::table('tarif_cabang_dokumen')->where('kode', $request->id_outlet)->update($outlet);

            }

            $simpan = DB::table('tarif_cabang_dokumen')->where('kode', $request->id_reguler)->update($regular);
            $simpan = DB::table('tarif_cabang_dokumen')->where('kode', $request->id_express)->update($express);
        }
     }
<<<<<<< HEAD
    }
=======
    
>>>>>>> 91850290b399df749d2a5d574c336ac378babc9d
     
        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            $result['error']='error';
            $result['result']=0;
        }
        $result['crud']=$crud;
        echo json_encode($result);
    
    }
    public function hapus_data (Request $request) {
        $hapus='';
        $id=$request->id;
        $hapus = DB::table('tarif_cabang_dokumen')->where('kode_sama' ,'=', $id)->where('crud','!=','E')->delete();
        if($hapus == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            $result['error']=$hapus;
            $result['result']=0;
        }
        echo json_encode($result);
    }
    public function hapus_data_perkota (Request $request) {
        // dd($request);
        $hapus='';
        $asal=$request->id;
        $tujuan=$request->name;
        $hapus = DB::table('tarif_cabang_dokumen')->where('id_kota_asal' ,'=', $asal)->where('id_kota_tujuan','=',$tujuan)->where('crud','!=','E')->delete();
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
        $cabang_default = DB::select(DB::raw(" SELECT kode,nama FROM cabang ORDER BY kode ASC "));
        $prov = DB::select(DB::raw("SELECT p.id,k.id_provinsi,p.nama FROM kota as k left join  provinsi as p on p.id =k.id_provinsi group by p.id,k.id_provinsi order by p.id"));

        $accpenjualan = DB::select(DB::raw(" SELECT id_akun,nama_akun FROM d_akun ORDER BY id_akun ASC "));
        $csfpenjualan = DB::select(DB::raw(" SELECT id_akun,nama_akun FROM d_akun ORDER BY id_akun ASC "));
        

        return view('tarif.cabang_dokumen.index',compact('kota','cabang_default','accpenjualan','csfpenjualan','prov'));
    }

}
