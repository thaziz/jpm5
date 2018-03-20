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
        $sql = "    SELECT t.kode_sama_kilo,t.kode, t.id_kota_asal, k.nama asal,t.id_kota_tujuan, kk.nama tujuan, t.harga, t.jenis, t.waktu, t.keterangan  
                    FROM tarif_cabang_kilogram t
                    LEFT JOIN kota k ON k.id=t.id_kota_asal 
                    LEFT JOIN kota kk ON kk.id=t.id_kota_tujuan 
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
                                        <button type="button" id="'.$data[$i]['kode_sama_kilo'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['kode_sama_kilo'].'" name="'.$data[$i]['kode_sama_kilo'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        // return $data;
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        // dd($request);
        $id =$request->input('id');
        // dd($aa);


        $data = DB::table('tarif_cabang_kilogram')->where('kode_sama_kilo', $id)->get();



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

        if ($kode_utama < 10000 ) {
            $kode_utama = '0000'.$kode_utama;
        }
        // return $kode_utama;
        //end
        //KODE 
        $kode_detail = DB::table('tarif_cabang_kilogram')->select('kode_detail_kilo')->max('kode_detail_kilo');
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
        

      $cekdata = DB::table('tarif_cabang_kilogram')->select('kode')->get();
            
        // return $cekdata;

      

        $kodekota = $request->kodekota;

        $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;
        $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;
        // return $kode_reguler;
        
        if ($crud == 'N') {
            //auto number
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
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 10',
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
                else if ($kode_detailtambah1 == $kode_detailtambah1 ) {
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
                else if ($kode_detailtambah1 == $kode_detailtambah1 ) {
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
                else if ($kode_detailtambah1 == $kode_detailtambah1 ) {
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

            // END AUTO EXPRESS
            //simpan DATA REGULER
            $simpan = DB::table('tarif_cabang_kilogram')->insert($kertas_reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif0_10reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif10_20reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif20reguler);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarifkgsel20kg_reguler);

            //SIMPAN DATA EXPRESS
            $simpan = DB::table('tarif_cabang_kilogram')->insert($kertas_express);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif0_10express);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif10_20express);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarif20express);
            $simpan = DB::table('tarif_cabang_kilogram')->insert($tarifkgsel20kg_express);

        }elseif ($crud == 'E') {
            $kertas_reguler = array(
                    'kode' => $request->id0,
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
               
               $tarifkgselreguler = array(
                    'kode' => $request->id4,
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
                    'kode' => $request->id5,
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
                    'kode' => $request->id6,
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
                    'kode' => $request->id7,
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
                    'kode' => $request->id8,
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
               
               $tarifkgselexpress = array(
                    'kode' => $request->id9,
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
        return view('tarif.cabang_kilogram.index',compact('kota','cabang','akun'));
    }

}
