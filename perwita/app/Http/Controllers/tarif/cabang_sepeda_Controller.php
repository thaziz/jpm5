<?php

namespace App\Http\Controllers\tarif;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;

class cabang_sepeda_Controller extends Controller
{
    public function table_data () {
        $sql = "    SELECT t.kode_sama_sepeda,t.id_provinsi_cabsepeda,p.nama provinsi,t.kode_detail_sepeda,t.acc_penjualan,t.csf_penjualan,t.kode_sama_sepeda,t.kode, t.id_kota_asal,k.kode_kota, k.nama asal,
        t.id_kota_tujuan,

        
        
        kk.nama tujuan, t.harga, t.jenis, t.waktu
                    FROM tarif_cabang_sepeda t
                    LEFT JOIN kota k ON k.id=t.id_kota_asal 
                    LEFT JOIN kota kk ON kk.id=t.id_kota_tujuan 
                    LEFT JOIN provinsi p ON p.id=t.id_provinsi_cabsepeda
                    ORDER BY t.kode_detail_sepeda DESC ";
        
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
      
                    foreach ($data as $key) {
                        // add new button
        
                        if ($kodecabang = Auth::user()->m_level == 'ADMINISTRATOR'  ) {
                            if ($data[$i]['id_provinsi_cabsepeda'] == null || $data[$i]['id_provinsi_cabsepeda'] == '') {
                                $data[$i]['button'] =' <div class="btn-group">
                                                            <button type="button" id="'.$data[$i]['id_kota_asal'].'" data-tujuan="'.$data[$i]['id_kota_tujuan'].'" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                                             
                                                                <button type="button" disabled="" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button> 

                                                            <button type="button" id="'.$data[$i]['id_kota_asal'].'" name="'.$data[$i]['id_kota_tujuan'].'" data-asal="'.$data[$i]['asal'].'" data-tujuan="'.$data[$i]['tujuan'].'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button>                                    
                                                        </div> ';
                                $i++;
                                }
                                else{
                                $data[$i]['button'] =' <div class="btn-group">
                                                            <button type="button" id="'.$data[$i]['id_kota_asal'].'" data-tujuan="'.$data[$i]['id_kota_tujuan'].'" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                                           
                                                            <button type="button" id="'.$data[$i]['kode_sama_sepeda'].'" name="'.$data[$i]['kode_sama_sepeda'].'"  data-asal="'.$data[$i]['asal'].'" data-prov="'.$data[$i]['provinsi'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button> 

                                                             <button type="button" id="'.$data[$i]['id_kota_asal'].'" name="'.$data[$i]['id_kota_tujuan'].'" data-asal="'.$data[$i]['asal'].'" data-tujuan="'.$data[$i]['tujuan'].'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button>                                     
                                                        </div> ';
                                $i++;
                            }
                        }else{
                             if ($data[$i]['id_provinsi_cabsepeda'] == null || $data[$i]['id_provinsi_cabsepeda'] == '') {
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
        return $data = DB::table('tarif_cabang_sepeda')->where('id_kota_asal', $asal)->where('id_kota_tujuan','=',$tujuan)->orderBy('kode_detail_sepeda','ASC')->get();

        
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        // dd($request);
        $simpan='';
        $crud = $request->crud;
        $kode_sama_sepeda = DB::table('tarif_cabang_sepeda')->select('kode_sama_sepeda')->max('kode_sama_sepeda');    
        if ($kode_sama_sepeda == '') {
            $kode_sama_sepeda = 1;
        }else{
            $kode_sama_sepeda += 1;
        }
        $kode_utama = DB::table('tarif_cabang_sepeda')->select('kode_detail_sepeda')->max('kode_detail_sepeda');    
        if ($kode_utama == '') {
            $kode_utama = 1;
        }else{
            $kode_utama += 1;
        }
         $kode_detail_sepeda = DB::table('tarif_cabang_sepeda')->select('kode_detail_sepeda')->max('kode_detail_sepeda');
         $datadetail = DB::table('tarif_cabang_sepeda')->select('kode_detail_sepeda')->get();  
               $datadetailcount = count($datadetail);
         for ($i=0; $i <count($datadetail) ; $i++) {  
            if ($datadetail == null) {
                $datadetailcount;
            }else{
                $kode_detail_sepedatambah1 = $datadetail[$i]->kode_detail_sepeda;
            }
            $kode_detail_sepedatambah1+1;  
         }
        if ($kode_detail_sepeda == '') {
            $kode_detail_sepeda = 1;
        }else{
            $kode_detail_sepeda += 1;
        }


        if ($kode_utama < 10000 ) {
            $kode_utama = '0000'.$kode_utama;
        }
        $kodekota = $request->kodekota;
        $kodecabang = Auth::user()->kode_cabang;


        $prov = $request->cb_provinsi_tujuan;
        $sel_prov = DB::table('kota')->select('id','nama')->where('id_provinsi','=',$prov)->get();
        
        $id_provinsi_loop = '';
        for ($for=0; $for <count($sel_prov) ; $for++) { 
             $id_provinsi_loop = $id_provinsi_loop.' '.$sel_prov[$for]->id;
        }
             $id_provinsi_loop =explode(' ', $id_provinsi_loop);
              json_encode($id_provinsi_loop); 
     
        
     if ($request->cb_kota_tujuan == '' ) {  
        
      for ($save=1; $save <count($id_provinsi_loop) ; $save++) {
         
          if ($crud =='N') {

              if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;            
                }
                        $pancal = array(
                        'kode_sama_sepeda' =>$kode_sama_sepeda,
                        'kode_detail_sepeda'=>$kode_detail_sepeda,
                        'kode'=>$kode,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $id_provinsi_loop[$save],
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'sepeda_pancal',
                        'harga' => $request->sepeda_pancal,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabsepeda'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );
            
             if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;            
                }

            $matik = array(
                        'kode_sama_sepeda' => $kode_sama_sepeda,
                        'kode_detail_sepeda'=>$kode_detail_sepeda,
                        'kode'=>$kode,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $id_provinsi_loop[$save],
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'bebek_matik',
                        'harga' => $request->bebek_matik,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabsepeda'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );

           

               if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode = $kodekota.'/'.'D'.'O'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode = $kodekota.'/'.'D'.'O'.$kodecabang.$kode_utama;            
                }

                     $sport = array(
                        'kode_sama_sepeda' => $kode_sama_sepeda,
                        'kode_detail_sepeda'=>$kode_detail_sepeda,
                        'kode'=>$kode,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $id_provinsi_loop[$save],
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'laki_sport',
                        'harga' => $request->laki_sport,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabsepeda'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );

                if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode = $kodekota.'/'.'D'.'O'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode = $kodekota.'/'.'D'.'O'.$kodecabang.$kode_utama;            
                }

                     $moge = array(
                        'kode_sama_sepeda' => $kode_sama_sepeda,
                        'kode_detail_sepeda'=>$kode_detail_sepeda,
                        'kode'=>$kode,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $id_provinsi_loop[$save],
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'moge',
                        'harga' => $request->moge,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabsepeda'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );
                  
                  

            $simpan = DB::table('tarif_cabang_sepeda')->insert($pancal);
            $simpan = DB::table('tarif_cabang_sepeda')->insert($matik);
            $simpan = DB::table('tarif_cabang_sepeda')->insert($sport);
            $simpan = DB::table('tarif_cabang_sepeda')->insert($moge);
        }
      }
    }else{
        $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;            
                     
                  

         if ($crud == 'N') {

                    if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;            
                }
                        $pancal = array(
                        'kode_sama_sepeda' =>$kode_sama_sepeda,
                        'kode_detail_sepeda'=>$kode_detail_sepeda,
                        'kode'=>$kode,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'sepeda_pancal',
                        'harga' => $request->sepeda_pancal,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        // 'id_provinsi_cabsepeda'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );
            
             if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;            
                }

            $matik = array(
                        'kode_sama_sepeda' => $kode_sama_sepeda,
                        'kode_detail_sepeda'=>$kode_detail_sepeda,
                        'kode'=>$kode,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'bebek_matik',
                        'harga' => $request->bebek_matik,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        // 'id_provinsi_cabsepeda'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );

           

               if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode = $kodekota.'/'.'D'.'O'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode = $kodekota.'/'.'D'.'O'.$kodecabang.$kode_utama;            
                }

                     $sport = array(
                        'kode_sama_sepeda' => $kode_sama_sepeda,
                        'kode_detail_sepeda'=>$kode_detail_sepeda,
                        'kode'=>$kode,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'laki_sport',
                        'harga' => $request->laki_sport,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabsepeda'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );

                if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode = $kodekota.'/'.'D'.'O'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode = $kodekota.'/'.'D'.'O'.$kodecabang.$kode_utama;            
                }

                     $moge = array(
                        'kode_sama_sepeda' => $kode_sama_sepeda,
                        'kode_detail_sepeda'=>$kode_detail_sepeda,
                        'kode'=>$kode,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'moge',
                        'harga' => $request->moge,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'id_provinsi_cabsepeda'=>$request->cb_provinsi_tujuan,
                        'crud'=>$crud,
                    );
                  
                  

            $simpan = DB::table('tarif_cabang_sepeda')->insert($pancal);
            $simpan = DB::table('tarif_cabang_sepeda')->insert($matik);
            $simpan = DB::table('tarif_cabang_sepeda')->insert($sport);
            $simpan = DB::table('tarif_cabang_sepeda')->insert($moge);
            

        }elseif ($crud == 'E') {
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
                        'kode_sama_sepeda' => $request->ed_kode_old,
                        'kode_detail_sepeda'=>$request->id_reguler_edit,
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
                        'kode_sama_sepeda' => $request->ed_kode_old,
                        'kode_detail_sepeda'=>$request->id_express_edit,
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
                        'kode_sama_sepeda' => $request->ed_kode_old,
                        'kode_detail_sepeda'=>$request->id_outlet_edit,
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
            $simpan = DB::table('tarif_cabang_sepeda')->where('kode', $request->id_outlet)->update($outlet);

            }

            $simpan = DB::table('tarif_cabang_sepeda')->where('kode', $request->id_reguler)->update($regular);
            $simpan = DB::table('tarif_cabang_sepeda')->where('kode', $request->id_express)->update($express);
        }
    }
     
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
        $hapus = DB::table('tarif_cabang_sepeda')->where('kode_sama_sepeda' ,'=', $id)->where('crud','!=','E')->delete();
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
        $hapus = DB::table('tarif_cabang_sepeda')->where('id_kota_asal' ,'=', $asal)->where('id_kota_tujuan','=',$tujuan)->where('crud','!=','E')->delete();
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
        

        return view('tarif.cabang_sepeda.index',compact('kota','cabang_default','accpenjualan','csfpenjualan','prov'));
    }

}
