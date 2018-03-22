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
        $sql = "    SELECT t.kode_detail_koli,t.kode_sama_koli,t.kode, t.id_kota_asal, k.nama asal,t.id_kota_tujuan, kk.nama tujuan, t.harga, t.jenis, t.waktu, t.keterangan  
                    FROM tarif_cabang_koli t
                    LEFT JOIN kota k ON k.id=t.id_kota_asal 
                    LEFT JOIN kota kk ON kk.id=t.id_kota_tujuan 
                    ORDER BY t.kode_detail_koli DESC ";
        
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['id_kota_asal'].'" data-tujuan="'.$data[$i]['id_kota_tujuan'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['kode_sama_koli'].'" name="'.$data[$i]['kode_sama_koli'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
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

        if ($kode_utama < 10000 ) {
            $kode_utama = '0000'.$kode_utama;
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
                'kode_cabang' => $request->cb_cabang,
                'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
            );

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
                'kode_cabang' => $request->cb_cabang,
                'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
            );

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
                'kode_cabang' => $request->cb_cabang,
                'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
            );

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
                'kode_cabang' => $request->cb_cabang,
                'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
            );
        //---------------------------------- EXPRESS -----------------------------------//

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
                'kode_cabang' => $request->cb_cabang,
                'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
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
                'kode_cabang' => $request->cb_cabang,
                'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
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
                'kode_cabang' => $request->cb_cabang,
                'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
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
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->ed_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->ed_csf_penjualan),
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
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );

               if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;

                }
                else if ($kode_detailtambah1 == $kode_detailtambah1 ) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;
                }
                // return $kode_utama;   
               
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
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );

               if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;

                }
                else if ($kode_detailtambah1 == $kode_detailtambah1 ) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;
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
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );   

               if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;

                }
                else if ($kode_detailtambah1 == $kode_detailtambah1 ) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;
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
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );

            //end auto number REGULAR

            // AUTO NUMBER EXPRESS
               if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;

                }
                else if ($kode_detailtambah1 == $kode_detailtambah1 ) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;
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
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );

               if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;

                }
                else if ($kode_detailtambah1 == $kode_detailtambah1 ) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;
                }
                // return $kode_utama;   
               
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
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );

               if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;

                }
                else if ($kode_detailtambah1 == $kode_detailtambah1 ) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;
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
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );   

               if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;

                }
                else if ($kode_detailtambah1 == $kode_detailtambah1 ) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;
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
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
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
            $kertas_reguler = array(
                    'kode' => $request->id0,
                    'kode_sama_koli' => $request->kode_sama_koli,
                    'kode_detail_koli' => $request->kode0,
                    'keterangan' => 'Tarif koli < 10 Kg',
                    'harga' => $request->tarifkertas_reguler,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );

               if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;

                }
                else if ($kode_detailtambah1 == $kode_detailtambah1 ) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;
                }
                // return $kode_utama;   
               
               $tarif0_10reguler = array(
                    'kode' => $request->id1,
                    'kode_sama_koli' => $request->kode_sama_koli,
                    'kode_detail_koli' => $request->kode1,
                    'keterangan' => 'Tarif koli < 30 Kg',
                    'harga' => $request->tarif0kg_reguler,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );

               if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;

                }
                else if ($kode_detailtambah1 == $kode_detailtambah1 ) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;
                }
               
               $tarif10_20reguler = array(
                    'kode' => $request->id2,
                    'kode_sama_koli' => $request->kode_sama_koli,
                    'kode_detail_koli' => $request->kode2,
                    'keterangan' => 'Tarif koli < 30 Kg',
                    'harga' => $request->tarif0kg_reguler,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );   

               if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;

                }
                else if ($kode_detailtambah1 == $kode_detailtambah1 ) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;
                }
               
               $tarif20reguler = array(
                    'kode' => $request->id3,
                    'kode_sama_koli' => $request->kode_sama_koli,
                    'kode_detail_koli' => $request->kode3,
                    'keterangan' => 'Tarif koli > 30 Kg',
                    'harga' => $request->tarif20kg_reguler,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );

            //end auto number REGULAR

            // AUTO NUMBER EXPRESS
               if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;

                }
                else if ($kode_detailtambah1 == $kode_detailtambah1 ) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;
                }

                $kertas_express = array(
                    'kode' => $request->id4,
                    'kode_sama_koli' => $request->kode_sama_koli,
                    'kode_detail_koli' => $request->kode4,
                    'keterangan' => 'Tarif koli < 10 Kg',
                    'harga' => $request->tarifkertas_express,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );

               if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;

                }
                else if ($kode_detailtambah1 == $kode_detailtambah1 ) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;
                }
                // return $kode_utama;   
               
               $tarif0_10express = array(
                    'kode' => $request->id5,
                    'kode_sama_koli' => $request->kode_sama_koli,
                    'kode_detail_koli' => $request->kode5,
                    'keterangan' => 'Tarif koli < 20 Kg',
                    'harga' => $request->tarif0kg_express,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );
               // dd($tarif0_10express);

               if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;

                }
                else if ($kode_detailtambah1 == $kode_detailtambah1 ) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;
                }
               
               $tarif10_20express = array(
                    'kode' => $request->id6,
                    'kode_sama_koli' => $request->kode_sama_koli,
                    'kode_detail_koli' => $request->kode6,
                    'keterangan' => 'Tarif koli < 30 Kg',
                    'harga' => $request->tarif10kg_express,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );   

               if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;

                }
                else if ($kode_detailtambah1 == $kode_detailtambah1 ) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;
                }
               
               $tarif20express = array(
                    'kode' => $request->id7,
                    'kode_sama_koli' => $request->kode_sama_koli,
                    'kode_detail_koli' => $request->kode7,
                    'keterangan' => 'Tarif koli > 30 Kg',
                    'harga' => $request->tarif20kg_express,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
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
        $hapus = DB::table('tarif_cabang_koli')->where('kode_sama_koli' ,'=', $id)->delete();
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
