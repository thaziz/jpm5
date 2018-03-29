<?php

namespace App\Http\Controllers\tarif;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;

class cabang_koli_Controller extends Controller
{
    public function table_data () {
        $sql = "    SELECT t.crud,t.id_provinsi_cabkoli,p.nama provinsi,t.kode_detail_koli,t.kode_sama_koli,t.kode, t.id_kota_asal, k.nama asal,t.id_kota_tujuan, kk.nama tujuan, t.harga, t.jenis, t.waktu, t.keterangan  
                    FROM tarif_cabang_koli t
                    LEFT JOIN kota k ON k.id=t.id_kota_asal 
                    LEFT JOIN kota kk ON kk.id=t.id_kota_tujuan 
                    LEFT JOIN provinsi p ON p.id=t.id_provinsi_cabkoli
                    ORDER BY t.kode_detail_koli DESC ";
        
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
       
                    foreach ($data as $key) {
                        // add new button
        
                        if ($kodecabang = Auth::user()->m_level == 'ADMINISTRATOR'  ) {
                            if ($data[$i]['id_provinsi_cabkoli'] == null || $data[$i]['id_provinsi_cabkoli'] == '') {
                                $data[$i]['button'] =' <div class="btn-group">
                                                            <button type="button" id="'.$data[$i]['id_kota_asal'].'" data-tujuan="'.$data[$i]['id_kota_tujuan'].'" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>

                                                        <button type="button" disabled="" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button> 
                                                            
                                                            <button type="button" id="'.$data[$i]['id_kota_asal'].'" name="'.$data[$i]['id_kota_tujuan'].'" data-asal="'.$data[$i]['asal'].'" data-tujuan="'.$data[$i]['tujuan'].'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button>                                    
                                                        </div> ';
                                $i++;
                                }
                                else{
                                        if ($data[$i]['crud'] == 'E') {

                                            $data[$i]['button'] =' <div class="btn-group">
                                                            <button type="button" id="'.$data[$i]['id_kota_asal'].'" data-tujuan="'.$data[$i]['id_kota_tujuan'].'" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                                           
                                                            <button type="button" disabled="" id="'.$data[$i]['kode_sama_koli'].'" name="'.$data[$i]['kode_sama_koli'].'"  data-asal="'.$data[$i]['asal'].'" data-prov="'.$data[$i]['provinsi'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button> 

                                                             <button type="button" disabled="" id="'.$data[$i]['id_kota_asal'].'" name="'.$data[$i]['id_kota_tujuan'].'" data-asal="'.$data[$i]['asal'].'" data-tujuan="'.$data[$i]['tujuan'].'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button>                                     
                                                        </div> ';
                                            $i++;
                                            
                                        }else if(($data[$i]['crud'] == 'N')){
                                                $data[$i]['button'] =' <div class="btn-group">
                                                            <button type="button" id="'.$data[$i]['id_kota_asal'].'" data-tujuan="'.$data[$i]['id_kota_tujuan'].'" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                                           
                                                            <button type="button" id="'.$data[$i]['kode_sama_koli'].'" name="'.$data[$i]['kode_sama_koli'].'"  data-asal="'.$data[$i]['asal'].'" data-prov="'.$data[$i]['provinsi'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button> 

                                                             <button type="button" id="'.$data[$i]['id_kota_asal'].'" name="'.$data[$i]['id_kota_tujuan'].'" data-asal="'.$data[$i]['asal'].'" data-tujuan="'.$data[$i]['tujuan'].'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button>                                     
                                                        </div> ';
                                $i++;
                                        }
                                
                            }
                        }else{
                             if ($data[$i]['id_provinsi_cabkoli'] == null || $data[$i]['id_provinsi_cabkoli'] == '') {
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
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $asal = $request->asal;
        $tujuan = $request->tujuan;
        $data = DB::table('tarif_cabang_koli')->where('id_kota_asal', $asal)->where('id_kota_tujuan','=',$tujuan)->orderBy('kode_detail_koli','ASC')->get();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        // dd($request);
        $simpan='';
        $crud = $request->crud;

       $kode_sama = DB::table('tarif_cabang_koli')->select('kode_sama_koli')->max('kode_sama_koli');    
        if ($kode_sama == '') {
            $kode_sama = 1;
        }else{
            $kode_sama += 1;
        }
    
        $kode_utama = DB::table('tarif_cabang_koli')->select('kode_detail_koli')->max('kode_detail_koli');
          $datadetail = DB::table('tarif_cabang_koli')->select('kode_detail_koli')->get();  
               $datadetailcount = count($datadetail);
         for ($i=0; $i <count($datadetail) ; $i++) {  
            if ($datadetail == null) {
                $datadetailcount;
            }else{
              $kode_detailtambahutama = $datadetail[$i]->kode_detail_koli;
            }
            $kode_detailtambahutama+1;  
         }
        if ($kode_utama == '') {
            $kode_utama = 1;
        }else{
            $kode_utama += 1;
        }
        
        $kode_detail = DB::table('tarif_cabang_koli')->select('kode_detail_koli')->max('kode_detail_koli');
        $datadetail = DB::table('tarif_cabang_koli')->select('kode_detail_koli','keterangan')->get();  
        $datadetailcount = count($datadetail);
         for ($i=0; $i <count($datadetail) ; $i++) {  
            if ($datadetail == null) {
                $datadetailcount;
            }else{
                $kode_detailtambah1 = $datadetail[$i]->kode_detail_koli;
            }
            $kode_detailtambah1+1;  
         }

        if ($kode_detail == '') {
            $kode_detail = 1;
        }else{
            $kode_detail += 1;
        }
        
        $prov = $request->cb_provinsi_tujuan;
        $sel_prov = DB::table('kota')->select('id','nama')->where('id_provinsi','=',$prov)->get();
        $id_provinsi_loop = '';
        for ($for=0; $for <count($sel_prov) ; $for++) { 
             $id_provinsi_loop = $id_provinsi_loop.' '.$sel_prov[$for]->id;
        }
            $id_provinsi_loop =explode(' ', $id_provinsi_loop);
            json_encode($id_provinsi_loop); 

        $kodecabang = Auth::user()->kode_cabang ;
        $cekdata = DB::table('tarif_cabang_koli')->select('kode')->get();
        $kodekota = $request->kodekota;

        // dd($request);

        if ($request->cb_kota_tujuan == '') {
         for ($save=1; $save <count($id_provinsi_loop) ; $save++) {
           //----------------------------- REGULER ---------------------------------------//
            if ($crud == 'N') {
                 

             if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KO'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    // return $kode_utama;

                    $kode_reguler = $kodekota.'/'.'KO'.'R'.$kodecabang.$kode_utama;            
                }

             $kertas_reguler = array(
                'kode' => $kode_reguler,
                'kode_sama_koli' => $kode_sama,
                'kode_detail_koli' => $kode_detail,
                'keterangan' => 'Tarif Koli < 10 Kg',
                'harga' => $request->tarifkertas_reguler,
                'id_kota_tujuan' => $id_provinsi_loop[$save],
                //BAWAH SAMA SEMUA
                'waktu' => $request->waktu_regular,
                'jenis' => 'REGULER',
                'id_kota_asal' => $request->cb_kota_asal,
                'id_provinsi_cabkoli' => $request->cb_provinsi_tujuan,
                'kode_cabang' => $request->ed_cabang,
                'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                'crud' => $crud,
            );

             if ($datadetailcount != 0) {
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KO'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KO'.'R'.$kodecabang.$kode_utama;            
                }

             
           $tarif0_10reguler = array(
                'kode' => $kode_reguler,
                'kode_sama_koli' => $kode_sama,
                'kode_detail_koli' => $kode_detail,
                'keterangan' => 'Tarif Koli < 20 Kg',
                'harga' => $request->tarif0kg_reguler,
                'id_kota_tujuan' => $id_provinsi_loop[$save],
                //BAWAH SAMA SEMUA
                'waktu' => $request->waktu_regular,
                'jenis' => 'REGULER',
                'id_kota_asal' => $request->cb_kota_asal,
                'id_provinsi_cabkoli' => $request->cb_provinsi_tujuan,
                'kode_cabang' => $request->ed_cabang,
                'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                'crud' => $crud,
            );

           if ($datadetailcount != 0) {
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KO'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KO'.'R'.$kodecabang.$kode_utama;            
                }

             
           $tarif10_20reguler = array(
                'kode' => $kode_reguler,
                'kode_sama_koli' => $kode_sama,
                'kode_detail_koli' => $kode_detail,
                'keterangan' => 'Tarif Koli < 30 Kg',
                'harga' => $request->tarif10kg_reguler,
                'id_kota_tujuan' => $id_provinsi_loop[$save],
                //BAWAH SAMA SEMUA
                'waktu' => $request->waktu_regular,
                'jenis' => 'REGULER',
                'id_kota_asal' => $request->cb_kota_asal,
                'id_provinsi_cabkoli' => $request->cb_provinsi_tujuan,
                'kode_cabang' => $request->ed_cabang,
                'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                'crud' => $crud,
            );

           if ($datadetailcount != 0) {
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KO'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KO'.'R'.$kodecabang.$kode_utama;            
                }

         $tarif20reguler = array(
                'kode' => $kode_reguler,
                'kode_sama_koli' => $kode_sama,
                'kode_detail_koli' => $kode_detail,
                'keterangan' => 'Tarif Koli > 30 Kg',
                'harga' => $request->tarif20kg_reguler,
                'id_kota_tujuan' => $id_provinsi_loop[$save],
                //BAWAH SAMA SEMUA
                'waktu' => $request->waktu_regular,
                'jenis' => 'REGULER',
                'id_kota_asal' => $request->cb_kota_asal,
                'id_provinsi_cabkoli' => $request->cb_provinsi_tujuan,
                'kode_cabang' => $request->ed_cabang,
                'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                'crud' => $crud,
            );
        //---------------------------------- EXPRESS -----------------------------------//

         if ($datadetailcount != 0) {
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KO'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KO'.'E'.$kodecabang.$kode_utama;            
                }

          $kertas_express = array(
                'kode' => $kode_express,
                'kode_sama_koli' => $kode_sama,
                'kode_detail_koli' => $kode_detail,
                'keterangan' => 'Tarif Koli < 10 Kg',
                'harga' => $request->tarifkertas_express,
                'id_kota_tujuan' => $id_provinsi_loop[$save],
                //BAWAH SAMA SEMUA
                'waktu' => $request->waktu_express,
                'jenis' => 'EXPRESS',
                'id_kota_asal' => $request->cb_kota_asal,
                'id_provinsi_cabkoli' => $request->cb_provinsi_tujuan,
                'kode_cabang' => $request->ed_cabang,
                'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                'crud' => $crud,
            );

           if ($datadetailcount != 0) {
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KO'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KO'.'E'.$kodecabang.$kode_utama;            
                }
     
           $tarif0_10express = array(
                'kode' => $kode_express,
                'kode_sama_koli' => $kode_sama,
                'kode_detail_koli' => $kode_detail,
                'keterangan' => 'Tarif Koli < 20 Kg',
                'harga' => $request->tarif0kg_express,
                'id_kota_tujuan' => $id_provinsi_loop[$save],
                //BAWAH SAMA SEMUA
                'waktu' => $request->waktu_express,
                'jenis' => 'EXPRESS',
                'id_kota_asal' => $request->cb_kota_asal,
                'id_provinsi_cabkoli' => $request->cb_provinsi_tujuan,
                'kode_cabang' => $request->ed_cabang,
                'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                'crud' => $crud,
            );

           if ($datadetailcount != 0) {
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KO'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KO'.'E'.$kodecabang.$kode_utama;            
                }
        $tarif10_20express = array(
                'kode' => $kode_express,
                'kode_sama_koli' => $kode_sama,
                'kode_detail_koli' => $kode_detail,
                'keterangan' => 'Tarif Koli < 30 Kg',
                'harga' => $request->tarif10kg_express,
                'id_kota_tujuan' => $id_provinsi_loop[$save],
                //BAWAH SAMA SEMUA
                'waktu' => $request->waktu_express,
                'jenis' => 'EXPRESS',
                'id_kota_asal' => $request->cb_kota_asal,
                'id_provinsi_cabkoli' => $request->cb_provinsi_tujuan,
                'kode_cabang' => $request->ed_cabang,
                'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                'crud' => $crud,
            );

            if ($datadetailcount != 0) {
                     $kode_utama = $kode_utama+1;
                        $kode_detail += 1;
                         $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                        $kode_express = $kodekota.'/'.'KO'.'E'.$kodecabang.$kode_utama;   

                    }else if ($datadetailcount == 0){
                     
                        $kode_detail += 1;
                         $kode_utama = $kode_utama+1;
                         $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                        $kode_express = $kodekota.'/'.'KO'.'E'.$kodecabang.$kode_utama;            
                    }
           $tarif20express = array(
                    'kode' => $kode_express,
                    'kode_sama_koli' => $kode_sama,
                    'kode_detail_koli' => $kode_detail,
                    'keterangan' => 'Tarif Koli > 30 Kg',
                    'harga' => $request->tarif20kg_express,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_provinsi_cabkoli' => $request->cb_provinsi_tujuan,
                    'kode_cabang' => $request->ed_cabang,
                    'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                    'crud' => $crud,
                );

        

        //-------------------------------- SAVE REGULER --------------------------------//
        $simpan = DB::table('tarif_cabang_koli')->insert($kertas_reguler);
        $simpan = DB::table('tarif_cabang_koli')->insert($tarif0_10reguler);
        $simpan = DB::table('tarif_cabang_koli')->insert($tarif10_20reguler);
        $simpan = DB::table('tarif_cabang_koli')->insert($tarif20reguler);
        //-------------------------------- SAVE EXPRESS --------------------------------//
        $simpan = DB::table('tarif_cabang_koli')->insert($kertas_express);
        $simpan = DB::table('tarif_cabang_koli')->insert($tarif0_10express);
        $simpan = DB::table('tarif_cabang_koli')->insert($tarif10_20express);
        $simpan = DB::table('tarif_cabang_koli')->insert($tarif20express);


         }
        }
       }else{

               if ($crud == 'N') {
              
              //auto number

                if ($datadetailcount != 0) {
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KO'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KO'.'R'.$kodecabang.$kode_utama;            
                }

               $kertas_reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_koli' => $kode_sama,
                    'kode_detail_koli' => $kode_detail,
                    'keterangan' => 'Tarif Koli < 10 Kg',
                    'harga' => $request->tarifkertas_reguler,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->ed_cabang,
                    'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                    'crud' => $crud,
                );

               if ($datadetailcount != 0) {
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KO'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KO'.'R'.$kodecabang.$kode_utama;            
                } 
               
               $tarif0_10reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_koli' => $kode_sama,
                    'kode_detail_koli' => $kode_detail,
                    'keterangan' => 'Tarif Koli < 20 Kg',
                    'harga' => $request->tarif0kg_reguler,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->ed_cabang,
                    'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                    'crud' => $crud,
                );

               if ($datadetailcount != 0) {
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KO'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KO'.'R'.$kodecabang.$kode_utama;            
                }
               
               $tarif10_20reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_koli' => $kode_sama,
                    'kode_detail_koli' => $kode_detail,
                    'keterangan' => 'Tarif Koli < 30 Kg',
                    'harga' => $request->tarif10kg_reguler,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->ed_cabang,
                    'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                    'crud' => $crud,
                );   

               if ($datadetailcount != 0) {
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KO'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KO'.'R'.$kodecabang.$kode_utama;            
                }
               $tarif20reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_koli' => $kode_sama,
                    'kode_detail_koli' => $kode_detail,
                    'keterangan' => 'Tarif Koli > 30 Kg',
                    'harga' => $request->tarif20kg_reguler,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->ed_cabang,
                    'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                    'crud' => $crud,
                );

            //end auto number REGULAR

            // AUTO NUMBER EXPRESS
              if ($datadetailcount != 0) {
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KO'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KO'.'E'.$kodecabang.$kode_utama;            
                }

                $kertas_express = array(
                    'kode' => $kode_express,
                    'kode_sama_koli' => $kode_sama,
                    'kode_detail_koli' => $kode_detail,
                    'keterangan' => 'Tarif Koli < 10 Kg',
                    'harga' => $request->tarifkertas_express,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->ed_cabang,
                    'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                    'crud' => $crud,
                );

               if ($datadetailcount != 0) {
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KO'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KO'.'E'.$kodecabang.$kode_utama;            
                } 
               
               $tarif0_10express = array(
                    'kode' => $kode_express,
                    'kode_sama_koli' => $kode_sama,
                    'kode_detail_koli' => $kode_detail,
                    'keterangan' => 'Tarif Koli < 20 Kg',
                    'harga' => $request->tarif0kg_express,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->ed_cabang,
                    'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                    'crud' => $crud,
                );

               if ($datadetailcount != 0) {
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KO'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KO'.'E'.$kodecabang.$kode_utama;            
                }
               
               $tarif10_20express = array(
                    'kode' => $kode_express,
                    'kode_sama_koli' => $kode_sama,
                    'kode_detail_koli' => $kode_detail,
                    'keterangan' => 'Tarif Koli < 30 Kg',
                    'harga' => $request->tarif10kg_express,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->ed_cabang,
                    'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                    'crud' => $crud,
                );   

               if ($datadetailcount != 0) {
                     $kode_utama = $kode_utama+1;
                    $kode_detail += 1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KO'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KO'.'E'.$kodecabang.$kode_utama;              
                }
               
               $tarif20express = array(
                    'kode' => $kode_express,
                    'kode_sama_koli' => $kode_sama,
                    'kode_detail_koli' => $kode_detail,
                    'keterangan' => 'Tarif Koli > 30 Kg',
                    'harga' => $request->tarif20kg_express,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->ed_cabang,
                    'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                    'crud' => $crud,
                );
            // END AUTO EXPRESS
            //simpan DATA REGULER
            $simpan = DB::table('tarif_cabang_koli')->insert($kertas_reguler);
            $simpan = DB::table('tarif_cabang_koli')->insert($tarif0_10reguler);
            $simpan = DB::table('tarif_cabang_koli')->insert($tarif10_20reguler);
            $simpan = DB::table('tarif_cabang_koli')->insert($tarif20reguler);
            //SIMPAN DATA EXPRESS
            $simpan = DB::table('tarif_cabang_koli')->insert($kertas_express);
            $simpan = DB::table('tarif_cabang_koli')->insert($tarif0_10express);
            $simpan = DB::table('tarif_cabang_koli')->insert($tarif10_20express);
            $simpan = DB::table('tarif_cabang_koli')->insert($tarif20express);
        }elseif ($crud == 'E') {


            // dd($request);

            $kode0 = $request->kode0; 
            $kode1 = $request->kode1; 
            $kode2 = $request->kode2; 
            $kode3 = $request->kode3; 
            $kode4 = $request->kode4; 
            $kode5 = $request->kode5; 
            $kode6 = $request->kode6; 
            $kode7 = $request->kode7;  

            $integer_kode0 =  (int)$kode0;
            $integer_kode1 =  (int)$kode1;
            $integer_kode2 =  (int)$kode2;
            $integer_kode3 =  (int)$kode3;
            $integer_kode4 =  (int)$kode4;
            $integer_kode5 =  (int)$kode5;
            $integer_kode6 =  (int)$kode6;
            $integer_kode7 =  (int)$kode7;

                $integer_kode0 = $integer_kode0;
                $integer_kode0 = str_pad($integer_kode0, 5,'0',STR_PAD_LEFT);
                if ($kodekota == '') {
                    $kode0_edit = $request->id0;
                }else{   
                    $kode0_edit = $kodekota.'/'.'KO'.'R'.$kodecabang.$integer_kode0;
                }

            $kertas_reguler = array(
                    'kode' => $kode0_edit,
                    'kode_sama_koli' => $request->kode_sama_koli,
                    'kode_detail_koli' => $request->kode0,
                    'keterangan' => 'Tarif koli < 10 Kg',
                    'harga' => $request->tarifkertas_reguler,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->ed_cabang,
                    'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                    'crud' => $crud,
                );

                $integer_kode1 = $integer_kode1;
                $integer_kode1 = str_pad($integer_kode1, 5,'0',STR_PAD_LEFT);
                if ($kodekota == '') {
                    $kode1_edit = $request->id1;
                }else{   
                    $kode1_edit = $kodekota.'/'.'KO'.'R'.$kodecabang.$integer_kode1;
                } 
               
               $tarif0_10reguler = array(
                    'kode' => $kode1_edit,
                    'kode_sama_koli' => $request->kode_sama_koli,
                    'kode_detail_koli' => $request->kode1,
                    'keterangan' => 'Tarif koli < 30 Kg',
                    'harga' => $request->tarif0kg_reguler,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->ed_cabang,
                    'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                    'crud' => $crud,
                );

               
                $integer_kode2 = $integer_kode2;
                $integer_kode2 = str_pad($integer_kode2, 5,'0',STR_PAD_LEFT);
                if ($kodekota == '') {
                    $kode2_edit = $request->id2;
                }else{   
                    $kode2_edit = $kodekota.'/'.'KO'.'R'.$kodecabang.$integer_kode2;
                }
               
               $tarif10_20reguler = array(
                    'kode' => $kode2_edit,
                    'kode_sama_koli' => $request->kode_sama_koli,
                    'kode_detail_koli' => $request->kode2,
                    'keterangan' => 'Tarif koli < 30 Kg',
                    'harga' => $request->tarif0kg_reguler,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->ed_cabang,
                    'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                    'crud' => $crud,
                );   

               $integer_kode3 = $integer_kode3;
                $integer_kode3 = str_pad($integer_kode3, 5,'0',STR_PAD_LEFT);
                if ($kodekota == '') {
                    $kode3_edit = $request->id3;
                }else{   
                    $kode3_edit = $kodekota.'/'.'KO'.'R'.$kodecabang.$integer_kode3;
                }
               
               
               $tarif20reguler = array(
                    'kode' => $kode3_edit,
                    'kode_sama_koli' => $request->kode_sama_koli,
                    'kode_detail_koli' => $request->kode3,
                    'keterangan' => 'Tarif koli > 30 Kg',
                    'harga' => $request->tarif20kg_reguler,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->ed_cabang,
                    'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                    'crud' => $crud,
                );

            //end auto number REGULAR

            // AUTO NUMBER EXPRESS
               $integer_kode4 = $integer_kode4;
                $integer_kode4 = str_pad($integer_kode4, 5,'0',STR_PAD_LEFT);
                if ($kodekota == '') {
                    $kode4_edit = $request->id4;
                }else{   
                    $kode4_edit = $kodekota.'/'.'KO'.'E'.$kodecabang.$integer_kode4;
                }

                $kertas_express = array(
                    'kode' => $kode4_edit,
                    'kode_sama_koli' => $request->kode_sama_koli,
                    'kode_detail_koli' => $request->kode4,
                    'keterangan' => 'Tarif koli < 10 Kg',
                    'harga' => $request->tarifkertas_express,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->ed_cabang,
                    'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                    'crud' => $crud,
                );

               $integer_kode5 = $integer_kode5;
                $integer_kode5 = str_pad($integer_kode5, 5,'0',STR_PAD_LEFT);
                if ($kodekota == '') {
                    $kode5_edit = $request->id5;
                }else{   
                    $kode5_edit = $kodekota.'/'.'KO'.'E'.$kodecabang.$integer_kode5;
                }
  
               
               $tarif0_10express = array(
                    'kode' => $kode5_edit,
                    'kode_sama_koli' => $request->kode_sama_koli,
                    'kode_detail_koli' => $request->kode5,
                    'keterangan' => 'Tarif koli < 20 Kg',
                    'harga' => $request->tarif0kg_express,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->ed_cabang,
                    'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                    'crud' => $crud,
                );
               // dd($tarif0_10express);

               $integer_kode6 = $integer_kode6;
                $integer_kode6 = str_pad($integer_kode6, 5,'0',STR_PAD_LEFT); 
                if ($kodekota == '') {
                    $kode6_edit = $request->id6;
                }else{   
                    $kode6_edit = $kodekota.'/'.'KO'.'E'.$kodecabang.$integer_kode6;
                }
               
               $tarif10_20express = array(
                    'kode' => $kode6_edit,
                    'kode_sama_koli' => $request->kode_sama_koli,
                    'kode_detail_koli' => $request->kode6,
                    'keterangan' => 'Tarif koli < 30 Kg',
                    'harga' => $request->tarif10kg_express,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->ed_cabang,
                    'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                    'crud' => $crud,
                );   

               $integer_kode7 = $integer_kode7;
                $integer_kode7 = str_pad($integer_kode7, 5,'0',STR_PAD_LEFT);
                if ($kodekota == '') {
                    $kode7_edit = $request->id7;
                }else{   
                    $kode7_edit = $kodekota.'/'.'KO'.'E'.$kodecabang.$integer_kode7;
                }
               
               $tarif20express = array(
                    'kode' => $kode7_edit,
                    'kode_sama_koli' => $request->kode_sama_koli,
                    'kode_detail_koli' => $request->kode7,
                    'keterangan' => 'Tarif koli > 30 Kg',
                    'harga' => $request->tarif20kg_express,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->ed_cabang,
                    'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
                    'crud' => $crud,
                );
            $simpan = DB::table('tarif_cabang_koli')->where('kode', $request->id0)->update($kertas_reguler);
            $simpan = DB::table('tarif_cabang_koli')->where('kode', $request->id1)->update($tarif0_10reguler);
            $simpan = DB::table('tarif_cabang_koli')->where('kode', $request->id2)->update($tarif10_20reguler);
            $simpan = DB::table('tarif_cabang_koli')->where('kode', $request->id3)->update($tarif20reguler);
            $simpan = DB::table('tarif_cabang_koli')->where('kode', $request->id4)->update($kertas_express);
            $simpan = DB::table('tarif_cabang_koli')->where('kode', $request->id5)->update($tarif0_10express);
            $simpan = DB::table('tarif_cabang_koli')->where('kode', $request->id6)->update($tarif10_20express);
            $simpan = DB::table('tarif_cabang_koli')->where('kode', $request->id7)->update($tarif20express);
        }

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
        $hapus = DB::table('tarif_cabang_koli')->where('kode_sama_koli' ,'=', $id)->where('crud','!=','E')->delete();
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
        $hapus = DB::table('tarif_cabang_koli')->where('id_kota_asal' ,'=', $asal)->where('id_kota_tujuan','=',$tujuan)->where('crud','!=','E')->delete();
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

        $accpenjualan = DB::select(DB::raw(" SELECT id_akun,nama_akun FROM d_akun ORDER BY id_akun ASC "));
        $csfpenjualan = DB::select(DB::raw(" SELECT id_akun,nama_akun FROM d_akun ORDER BY id_akun ASC "));
        $prov = DB::select(DB::raw("SELECT p.id,k.id_provinsi,p.nama FROM kota as k left join  provinsi as p on p.id =k.id_provinsi group by p.id,k.id_provinsi order by p.id"));
        return view('tarif.cabang_koli.index',compact('kota','cabang_default','accpenjualan','csfpenjualan','prov'));
    }

}
