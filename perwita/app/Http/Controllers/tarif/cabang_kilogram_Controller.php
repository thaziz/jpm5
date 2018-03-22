<?php

namespace App\Http\Controllers\tarif;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;

class cabang_kilogram_Controller extends Controller
{
    public function table_data () {
        $sql = "    SELECT t.kode_detail_kilo,t.kode_sama_kilo,t.kode, t.id_kota_asal, k.nama asal,t.id_kota_tujuan, kk.nama tujuan, t.harga, t.jenis, t.waktu, t.keterangan  
                    FROM tarif_cabang_kilogram t
                    LEFT JOIN kota k ON k.id=t.id_kota_asal 
                    LEFT JOIN kota kk ON kk.id=t.id_kota_tujuan 
                    ORDER BY t.kode_detail_kilo DESC ";
        
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
                                        <button type="button" id="'.$data[$i]['kode_detail_kilo'].'" name="'.$data[$i]['kode_detail_kilo'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        // return $data;
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $asal = $request->asal;
        $tujuan = $request->tujuan;
        $data = DB::table('tarif_cabang_kilogram')->where('id_kota_asal', $asal)->where('id_kota_tujuan','=',$tujuan)->orderBy('kode_detail_kilo','ASC')->get();
        echo json_encode([$data]);
            }

    public function save_data (Request $request) {
        // dd($request);    
        $simpan='';
        $crud = $request->crud;

        $kode_sama = DB::table('tarif_cabang_kilogram')->select('kode_sama_kilo')->max('kode_sama_kilo');    
        if ($kode_sama == '') {
            $kode_sama = 1;
        }else{
            $kode_sama += 1;
        }

        // KODE UTAMA
        $kode_utama = DB::table('tarif_cabang_kilogram')->select('kode_detail_kilo')->max('kode_detail_kilo');
          $datadetail = DB::table('tarif_cabang_kilogram')->select('kode_detail_kilo')->get();  
               $datadetailcount = count($datadetail);
         for ($i=0; $i <count($datadetail) ; $i++) {  
            if ($datadetail == null) {
                $datadetailcount;
            }else{
              $kode_detailtambahutama = $datadetail[$i]->kode_detail_kilo;
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
        $kode_detail = DB::table('tarif_cabang_kilogram')->select('kode_detail_kilo')->max('kode_detail_kilo');
        if ($kode_detail == '') {
            $kode_detail = 1;
        }else{
            $kode_detail += 1;
        }
          $datadetail = DB::table('tarif_cabang_kilogram')->select('kode_detail_kilo','keterangan')->get();  
               $datadetailcount = count($datadetail);
         for ($i=0; $i <count($datadetail) ; $i++) {  
            if ($datadetail == null) {
                $datadetailcount;
            }else{
                $kode_detailtambah1 = $datadetail[$i]->kode_detail_kilo;

            }
            $kode_detailtambah1+1;  
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
        $cekdata = DB::table('tarif_cabang_kilogram')->select('kode')->get();
        $kodekota = $request->kodekota;
         
    if ($request->cb_kota_tujuan == '') {
         for ($save=1; $save <count($id_provinsi_loop) ; $save++) {
            
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
                                'kode_sama_kilo' => $kode_sama,
                                'kode_detail_kilo' => $kode_detail,
                                'keterangan' => 'Tarif Kertas / Kg',
                                'harga' => $request->tarifkertas_reguler,
                                'id_kota_tujuan' => $id_provinsi_loop[$save],
                                //BAWAH SAMA SEMUA
                                'waktu' => $request->waktu_regular,
                                'jenis' => 'REGULER',
                                'id_kota_asal' => $request->cb_kota_asal,
                                'id_provinsi_cabkilogram' => $request->cb_provinsi_tujuan,
                                'kode_cabang' => $request->cb_cabang,
                                'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                                'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
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
                // return $kode_utama;   
               
               $tarif0_10reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 10 Kg',
                    'harga' => $request->tarif0kg_reguler,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_provinsi_cabkilogram' => $request->cb_provinsi_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
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
                // return $kode_utama;   
               
               $tarif10_20reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 10 Kg',
                    'harga' => $request->tarif10kg_reguler,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_provinsi_cabkilogram' => $request->cb_provinsi_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
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
                // return $kode_utama;   
               
                 $tarif20reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 20 Kg',
                    'harga' => $request->tarif20kg_reguler,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_provinsi_cabkilogram' => $request->cb_provinsi_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
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
                // return $kode_utama;   
               
              $tarifkgsel20kg_reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 20 Kg',
                    'harga' => $request->tarifkgsel_reguler,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_provinsi_cabkilogram' => $request->cb_provinsi_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );

            //----------------------------------- EXPRESSSS ----------------------------------//

            if ($datadetailcount != 0) {
                $kode_detail += 1;
                 if ($kode_utama < 10000 ) {
                    $kode_utama = '0000'.($kode_utama+1);
                    }
                $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;            
                }

                $kertas_express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kertas / Kg',
                    'harga' => $request->tarifkertas_express,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );

                if ($datadetailcount != 0) {
                $kode_detail += 1;
                 if ($kode_utama < 10000 ) {
                    $kode_utama = '0000'.($kode_utama+1);
                    }
                $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;            
                }

                 $tarif0_10express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 10 Kg',
                    'harga' => $request->tarif0kg_express,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );

                  if ($datadetailcount != 0) {
                $kode_detail += 1;
                 if ($kode_utama < 10000 ) {
                    $kode_utama = '0000'.($kode_utama+1);
                    }
                $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;            
                }

              $tarif10_20express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 10 Kg',
                    'harga' => $request->tarif10kg_express,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );

                if ($datadetailcount != 0) {
                $kode_detail += 1;
                 if ($kode_utama < 10000 ) {
                    $kode_utama = '0000'.($kode_utama+1);
                    }
                $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;            
                }

                $tarif20express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 20 Kg',
                    'harga' => $request->tarif20kg_express,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );

                if ($datadetailcount != 0) {
                $kode_detail += 1;
                 if ($kode_utama < 10000 ) {
                    $kode_utama = '0000'.($kode_utama+1);
                    }
                $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                        }
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;            
                }

               $tarifkgsel20kg_express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 20 Kg',
                    'harga' => $request->tarifkgsel_express,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );
                    
              // END OF EXPRESS //

            //--------------------------------- SAVE REGULER --------------------------------------//   
            $simpan = DB::table('tarif_cabang_kilogram')->insert($kertas_reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif0_10reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif10_20reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif20reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarifkgsel20kg_reguler);
            //---------------------------------- SAVE EXPRESS --------------------------------------//
            $simpan = DB::table('tarif_cabang_kilogram')->insert($kertas_express);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif0_10express);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif10_20express);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif20express);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarifkgsel20kg_express);
         }
    }else{
    if ($crud == 'N') {
            //------------------------------------ REGULER ----------------------------------------//
               $kertas_reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kertas / Kg',

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
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 10 Kg',
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
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 10 Kg',
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
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 20 Kg',
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
               
               $tarifkgsel20kg_reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 20 Kg',
                    'harga' => $request->tarifkgsel_reguler,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );
                //-------------------------------- EXPRESS --------------------------------------//
               if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;

                }
                else if ($datadetailcount == 0 ) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;
                }

                $kertas_express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kertas / Kg',
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
                else if ($datadetailcount == 0 ) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;
                }
                // return $kode_utama;   
               
               $tarif0_10express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 10 Kg',
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
                else if ($datadetailcount == 0 ) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;
                }
               
               $tarif10_20express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 10 Kg',
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
                else if ($datadetailcount == 0 ) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;
                }
               
               $tarif20express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 20 Kg',
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
               if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;

                }
                else if ($datadetailcount == 0 ) {
                    $kode_detail += 1;
                    if ($kode_utama < 10000 ) {
                        $kode_utama = '0000'.($kode_utama+1);
                    }
                    $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;
                }
               
               $tarifkgsel20kg_express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 20 Kg',
                    'harga' => $request->tarifkgsel_express,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );

            //------------------------------------------- REGULER -------------------------------------------------/
            $simpan = DB::table('tarif_cabang_kilogram')->insert($kertas_reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif0_10reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif10_20reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif20reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarifkgsel20kg_reguler);
            //------------------------------------------- EXPRESS -------------------------------------------------/
            $simpan = DB::table('tarif_cabang_kilogram')->insert($kertas_express);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif0_10express);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif10_20express);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif20express);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarifkgsel20kg_express);

            }
            elseif ($crud == 'E') {
                $kode0 = $request->kode0; 
                $kode1 = $request->kode1; 
                $kode2 = $request->kode2; 
                $kode3 = $request->kode3; 
                $kode4 = $request->kode4; 
                $kode5 = $request->kode5; 
                $kode6 = $request->kode6; 
                $kode7 = $request->kode7; 
                $kode8 = $request->kode8; 
                $kode9 = $request->kode9; 

                $integer_kode0 =  (int)$kode0;
                $integer_kode1 =  (int)$kode1;
                $integer_kode2 =  (int)$kode2;
                $integer_kode3 =  (int)$kode3;
                $integer_kode4 =  (int)$kode4;
                $integer_kode5 =  (int)$kode5;
                $integer_kode6 =  (int)$kode6;
                $integer_kode7 =  (int)$kode7;
                $integer_kode8 =  (int)$kode8;
                $integer_kode9 =  (int)$kode9;
  

                if ($integer_kode0 < 10000) {
                    $integer_kode0 = '0000'.$integer_kode0; 
                }
                if ($kodekota == '') {
                    $kode0_edit = $request->id0;
                }else{   
                    $kode0_edit = $kodekota.'/'.'D'.'R'.$kodecabang.$integer_kode0;
                } 

            $kertas_reguler = array(
                    'kode' => $kode0_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode0,
                    'keterangan' => 'Tarif Kertas / Kg',
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

                if ($integer_kode1 < 10000) {
                    $integer_kode1 = '0000'.$integer_kode1; 
                } 
                if ($kodekota == '') {
                    $kode1_edit = $request->id1;
                }else{   
                    $kode1_edit = $kodekota.'/'.'D'.'R'.$kodecabang.$integer_kode1;
                } 
               
               $tarif0_10reguler = array(
                    'kode' => $kode1_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode1,
                    'keterangan' => 'Tarif <= 10 Kg',
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

                if ($integer_kode2 < 10000) {
                    $integer_kode2 = '0000'.$integer_kode2; 
                } 
                if ($kodekota == '') {
                    $kode2_edit = $request->id2;
                }else{   
                    $kode2_edit = $kodekota.'/'.'D'.'R'.$kodecabang.$integer_kode2;
                }
               
               $tarif10_20reguler = array(
                    'kode' => $kode2_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode2,
                    'keterangan' => 'Tarif Kg selanjutnya  <= 10 Kg',
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

                if ($integer_kode3 < 10000) {
                    $integer_kode3 = '0000'.$integer_kode3; 
                } 
                if ($kodekota == '') {
                    $kode3_edit = $request->id3;
                }else{   
                    $kode3_edit = $kodekota.'/'.'D'.'R'.$kodecabang.$integer_kode3;
                }
               
               $tarif20reguler = array(
                    'kode' => $kode3_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode3,
                    'keterangan' => 'Tarif <= 20 Kg',
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

               if ($integer_kode4 < 10000) {
                    $integer_kode4 = '0000'.$integer_kode4; 
                } 
                if ($kodekota == '') {
                    $kode4_edit = $request->id4;
                }else{   
                    $kode4_edit = $kodekota.'/'.'D'.'R'.$kodecabang.$integer_kode4;
                }
               
               $tarifkgselreguler = array(
                    'kode' => $kode4_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode4,
                    'keterangan' => 'Tarif Kg selanjutnya <= 20 Kg',
                    'harga' => $request->tarifkgsel_reguler,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );
               //----------------------------------- EXPRESS --------------------------------------------------//
                if ($integer_kode5 < 10000) {
                    $integer_kode5 = '0000'.$integer_kode5; 
                } 
                if ($kodekota == '') {
                    $kode5_edit = $request->id5;
                }else{   
                    $kode5_edit = $kodekota.'/'.'D'.'R'.$kodecabang.$integer_kode5;
                }

                $kertas_express = array(
                    'kode' => $kode5_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode5,
                    'keterangan' => 'Tarif Kertas / Kg',
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

                if ($integer_kode6 < 10000) {
                    $integer_kode6 = '0000'.$integer_kode6; 
                } 
                if ($kodekota == '') {
                    $kode6_edit = $request->id6;
                }else{   
                    $kode6_edit = $kodekota.'/'.'D'.'R'.$kodecabang.$integer_kode6;
                }  
               
               $tarif0_10express = array(
                    'kode' => $kode6_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode6,
                    'keterangan' => 'Tarif  <= 10 Kg',
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

               if ($integer_kode7 < 10000) {
                    $integer_kode7 = '0000'.$integer_kode7; 
                } 
                if ($kodekota == '') {
                    $kode7_edit = $request->id7;
                }else{   
                    $kode7_edit = $kodekota.'/'.'D'.'R'.$kodecabang.$integer_kode7;
                }
               
               $tarif10_20express = array(
                    'kode' => $kode7_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode7,
                    'keterangan' => 'Tarif Kg selanjutnya  <= 10 Kg',
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

               if ($integer_kode8 < 10000) {
                    $integer_kode8 = '0000'.$integer_kode8; 
                } 
                if ($kodekota == '') {
                    $kode8_edit = $request->id8;
                }else{   
                    $kode8_edit = $kodekota.'/'.'D'.'R'.$kodecabang.$integer_kode8;
                }
               
               $tarif20express = array(
                    'kode' => $kode8_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode8,
                    'keterangan' => 'Tarif <= 20 Kg',
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
               if ($integer_kode9 < 10000) {
                    $integer_kode9 = '0000'.$integer_kode9; 
                } 
                if ($kodekota == '') {
                    $kode9_edit = $request->id9;
                }else{   
                    $kode9_edit = $kodekota.'/'.'D'.'R'.$kodecabang.$integer_kode9;
                }
               
               $tarifkgselexpress = array(
                    'kode' => $kode9_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode9,
                    'keterangan' => 'Tarif Kg selanjutnya <= 20 Kg',
                    'harga' => $request->tarifkgsel_express,
                    //BAWAH SAMA SEMUA
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );

            $simpan = DB::table('tarif_cabang_kilogram')->where('kode', $request->id0)->update($kertas_reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->where('kode', $request->id1)->update($tarif0_10reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->where('kode', $request->id2)->update($tarif10_20reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->where('kode', $request->id3)->update($tarif20reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->where('kode', $request->id4)->update($tarifkgselreguler);

            $simpan = DB::table('tarif_cabang_kilogram')->where('kode', $request->id5)->update($kertas_express);
            $simpan = DB::table('tarif_cabang_kilogram')->where('kode', $request->id6)->update($tarif0_10express);
            $simpan = DB::table('tarif_cabang_kilogram')->where('kode', $request->id7)->update($tarif10_20express);
            $simpan = DB::table('tarif_cabang_kilogram')->where('kode', $request->id8)->update($tarif20express);

            $simpan = DB::table('tarif_cabang_kilogram')->where('kode', $request->id9)->update($tarifkgselexpress);
        }
        }
        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            $result['error']='eror';
            $result['result']=0;
        }
        $result['crud']=$crud;
        echo json_encode($result);
    }

    public function hapus_data (Request $request) {
        $hapus='';
        $id=$request->id;
        $hapus = DB::table('tarif_cabang_kilogram')->where('kode_sama_kilo' ,'=', $id)->delete();
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
        $cabang = DB::select(DB::raw(" SELECT kode,nama FROM cabang ORDER BY nama ASC "));
        $akun= DB::select(DB::raw(" SELECT id_akun,nama_akun FROM d_akun ORDER BY id_akun ASC "));
        $prov = DB::select(DB::raw("SELECT p.id,k.id_provinsi,p.nama FROM kota as k left join  provinsi as p on p.id =k.id_provinsi group by p.id,k.id_provinsi order by p.id"));
        return view('tarif.cabang_kilogram.index',compact('kota','cabang','akun','prov'));
    }

}
