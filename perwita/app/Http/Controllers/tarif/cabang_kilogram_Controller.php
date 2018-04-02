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
        $sql = "    SELECT t.crud,t.id_provinsi_cabkilogram,t.kode_detail_kilo,t.kode_sama_kilo,t.kode, t.id_kota_asal, k.nama asal,t.id_kota_tujuan, kk.nama tujuan, t.harga, t.jenis, t.waktu, t.keterangan ,p.nama provinsi 
                    FROM tarif_cabang_kilogram t
                    LEFT JOIN kota k ON k.id=t.id_kota_asal 
                    LEFT JOIN kota kk ON kk.id=t.id_kota_tujuan 
                    LEFT JOIN provinsi p ON p.id=t.id_provinsi_cabkilogram
                    ORDER BY t.kode_detail_kilo DESC ";
        
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
       foreach ($data as $key) {
                        // add new button
        
                        if ($kodecabang = Auth::user()->m_level == 'ADMINISTRATOR'  ) {
                            if ($data[$i]['id_provinsi_cabkilogram'] == null || $data[$i]['id_provinsi_cabkilogram'] == '') {
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
                                                           
                                                            <button type="button" disabled="" id="'.$data[$i]['kode_sama_kilo'].'" name="'.$data[$i]['kode_sama_kilo'].'"  data-asal="'.$data[$i]['asal'].'" data-prov="'.$data[$i]['provinsi'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button> 

                                                             <button type="button" id="'.$data[$i]['id_kota_asal'].'" name="'.$data[$i]['id_kota_tujuan'].'" data-asal="'.$data[$i]['asal'].'" data-tujuan="'.$data[$i]['tujuan'].'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button>                                     
                                                        </div> ';
                                            $i++;
                                            
                                        }else if(($data[$i]['crud'] == 'N')){
                                                $data[$i]['button'] =' <div class="btn-group">
                                                            <button type="button" id="'.$data[$i]['id_kota_asal'].'" data-tujuan="'.$data[$i]['id_kota_tujuan'].'" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                                           
                                                            <button type="button" id="'.$data[$i]['kode_sama_kilo'].'" name="'.$data[$i]['kode_sama_kilo'].'"  data-asal="'.$data[$i]['asal'].'" data-prov="'.$data[$i]['provinsi'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button> 

                                                             <button type="button" id="'.$data[$i]['id_kota_asal'].'" name="'.$data[$i]['id_kota_tujuan'].'" data-asal="'.$data[$i]['asal'].'" data-tujuan="'.$data[$i]['tujuan'].'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button>                                     
                                                        </div> ';
                                $i++;
                                        }
                                
                            }
                        }else{
                             if ($data[$i]['id_provinsi_cabkilogram'] == null || $data[$i]['id_provinsi_cabkilogram'] == '') {
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
        // return $data;
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $asal = $request->asal;
        $tujuan = $request->tujuan;
         $sql = "    SELECT t.kode_cabang,k.kode_kota,t.crud,t.id_provinsi_cabkilogram,t.kode_detail_kilo,t.kode_sama_kilo,t.kode,t.acc_penjualan,t.csf_penjualan, t.id_kota_asal, k.nama asal,t.id_kota_tujuan, kk.nama tujuan, t.harga, t.jenis, t.waktu, t.keterangan ,p.nama provinsi 
                    FROM tarif_cabang_kilogram t
                    LEFT JOIN kota k ON k.id=t.id_kota_asal 
                    LEFT JOIN kota kk ON kk.id=t.id_kota_tujuan 
                    LEFT JOIN provinsi p ON p.id=t.id_provinsi_cabkilogram
                    where t.id_kota_asal = '$asal' AND t.id_kota_tujuan = '$tujuan'
                    ORDER BY t.kode_detail_kilo ASC ";
        
        $data = DB::select(DB::raw($sql));
        // $data = DB::table('tarif_cabang_kilogram')->where('id_kota_asal', $asal)->where('id_kota_tujuan','=',$tujuan)->orderBy('kode_detail_kilo','ASC')->get();
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
            // return $id_provinsi_loop;    
          $check = DB::table('tarif_cabang_kilogram')->where('id_kota_asal','=',$request->cb_kota_asal)->Where('id_kota_tujuan','=',$id_provinsi_loop[$save])->get();     
        /*return */$cek = count($check); 
         if ($cek > 0) {
            $hasil_cek = 'Data Sudah ada di database !';
            $result['hasil_cek']=$hasil_cek;
            return json_encode($result);
            
         }else{ 
             //GEGE 
            if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;            
                }

             $kertas_reguler = array(
                                'kode' => $kode_reguler,
                                'kode_sama_kilo' => $kode_sama,
                                'kode_detail_kilo' => $kode_detail,
                                'keterangan' => 'Tarif Kertas / Kg',
                                'harga' => $request->tarifkertas_reguler,
                                'id_kota_tujuan' => $id_provinsi_loop[$save],
                                'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                                'crud'=>$crud,
                                //BAWAH SAMA SEMUA
                                'waktu' => $request->waktu_regular,
                                'jenis' => 'REGULER',
                                'id_kota_asal' => $request->cb_kota_asal,
                                'id_provinsi_cabkilogram' => $request->cb_provinsi_tujuan,
                                'kode_cabang' => $request->cb_cabang,
                                'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                                'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                                'crud'=>strtoupper($crud),
                                // 'id_provinsi_cabkilogram'=>
                            );

                if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;            
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
                    'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_provinsi_cabkilogram' => $request->cb_provinsi_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

               if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;            
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
                    'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_provinsi_cabkilogram' => $request->cb_provinsi_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

               if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;            
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
                    'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_provinsi_cabkilogram' => $request->cb_provinsi_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

                 if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;            
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
                    'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_provinsi_cabkilogram' => $request->cb_provinsi_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

            //----------------------------------- EXPRESSSS ----------------------------------//

            if ($datadetailcount != 0) {
                $kode_detail += 1;
                 $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;            
                }

                $kertas_express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kertas / Kg',
                    'harga' => $request->tarifkertas_express,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

                if ($datadetailcount != 0) {
                $kode_detail += 1;
                 $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;            
                }

                 $tarif0_10express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 10 Kg',
                    'harga' => $request->tarif0kg_express,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

                  if ($datadetailcount != 0) {
                $kode_detail += 1;
                $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;            
                }

              $tarif10_20express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 10 Kg',
                    'harga' => $request->tarif10kg_express,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

                if ($datadetailcount != 0) {
                $kode_detail += 1;
                $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;            
                }

                $tarif20express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 20 Kg',
                    'harga' => $request->tarif20kg_express,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'crud'=>strtoupper($crud),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );

                if ($datadetailcount != 0) {
                $kode_detail += 1;
                 $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;            
                }

               $tarifkgsel20kg_express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 20 Kg',
                    'harga' => $request->tarifkgsel_express,
                    'id_kota_tujuan' => $id_provinsi_loop[$save],
                    //BAWAH SAMA SEMUA
                    'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );
                    // end GEGE
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
     }
    }else{
    if ($crud == 'N') {
        $kode_utama = $kode_utama+1;
        $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);         
        $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;
        $kot1 = $request->cb_kota_asal;
        $kot2 = $request->cb_kota_tujuan;
        $cek_sendiri = DB::table('tarif_cabang_kilogram')->where('id_kota_asal','=',$kot1)->where('id_kota_tujuan','=',$kot2)->get();      
        $ngecek = count($cek_sendiri);
        if ($ngecek > 1) {
            $hasil_cek = 'Data Sudah ada di database !';
            $result['hasil_cek']=$hasil_cek;
            return json_encode($result);
        }else{
            //------------------------------------ REGULER ----------------------------------------//
               $kertas_reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kertas / Kg',
                    'harga' => $request->tarifkertas_reguler,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

               if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;            
                }
             
               
               $tarif0_10reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 10 Kg',
                    'harga' => $request->tarif0kg_reguler,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

               if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;            
                }
               
               $tarif10_20reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 10 Kg',
                    'harga' => $request->tarif10kg_reguler,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );   

              if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;            
                }
               
               $tarif20reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 20 Kg',
                    'harga' => $request->tarif20kg_reguler,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );
               if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_reguler = $kodekota.'/'.'KG'.'R'.$kodecabang.$kode_utama;            
                }
               
               $tarifkgsel20kg_reguler = array(
                    'kode' => $kode_reguler,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 20 Kg',
                    'harga' => $request->tarifkgsel_reguler,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                );
               // return $kode_reguler;
                //-------------------------------- EXPRESS --------------------------------------//
               if ($datadetailcount != 0) {
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail += 1;
                     $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;            
                }
                // return $kode_express;

                $kertas_express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kertas / Kg',
                    'harga' => $request->tarifkertas_express,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

              if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;

                }
                else if ($datadetailcount == 0 ) {
                    $kode_detail += 1;
                    $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;
                }
                // return $kode_utama;   
               
               $tarif0_10express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 10 Kg',
                    'harga' => $request->tarif0kg_express,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );

              if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;

                }
                else if ($datadetailcount == 0 ) {
                    $kode_detail += 1;
                    $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;
                }
               
               $tarif10_20express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 10 Kg',
                    'harga' => $request->tarif10kg_express,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );   

               if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;

                }
                else if ($datadetailcount == 0 ) {
                    $kode_detail += 1;
                    $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;
                }
               
               $tarif20express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif <= 20 Kg',
                    'harga' => $request->tarif20kg_express,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                );
               if ($datadetailcount == 0) {
                    $kode_detail += 1;
                    $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;

                }
                else if ($datadetailcount == 0 ) {
                    $kode_detail += 1;
                    $kode_utama = $kode_utama+1;
$kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode_express = $kodekota.'/'.'KG'.'E'.$kodecabang.$kode_utama;
                }
               
               $tarifkgsel20kg_express = array(
                    'kode' => $kode_express,
                    'kode_sama_kilo' => $kode_sama,
                    'kode_detail_kilo' => $kode_detail,
                    'keterangan' => 'Tarif Kg selanjutnya <= 20 Kg',
                    'harga' => $request->tarifkgsel_express,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
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
        }
            elseif ($crud == 'E') {
                // dd($request);
                $kodekota = $request->kodekota;

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
        
                $prov = DB::table('kota')->select('id','id_provinsi')->where('id',$request->cb_kota_tujuan)->get();
                $prov = $prov[0]->id_provinsi;

                $integer_kode0 = $integer_kode0;
                $integer_kode0 = str_pad($integer_kode0, 5,'0',STR_PAD_LEFT);
                $kode0_edit = $kodekota.'/'.'KG'.'R'.$kodecabang.$integer_kode0; 

                $integer_kode1 = $integer_kode1;
                $integer_kode1 = str_pad($integer_kode1, 5,'0',STR_PAD_LEFT);
                $kode1_edit = $kodekota.'/'.'KG'.'R'.$kodecabang.$integer_kode1;
                
                $integer_kode2 = $integer_kode2;
                $integer_kode2 = str_pad($integer_kode2, 5,'0',STR_PAD_LEFT);   
                $kode2_edit = $kodekota.'/'.'KG'.'R'.$kodecabang.$integer_kode2;
                
                $integer_kode3 = $integer_kode3;
                $integer_kode3 = str_pad($integer_kode3, 5,'0',STR_PAD_LEFT); 
                $kode3_edit = $kodekota.'/'.'KG'.'R'.$kodecabang.$integer_kode3;
                
                $integer_kode4 = $integer_kode4;
                $integer_kode4 = str_pad($integer_kode4, 5,'0',STR_PAD_LEFT);  
                $kode4_edit = $kodekota.'/'.'KG'.'R'.$kodecabang.$integer_kode4;
                
                $integer_kode5 = $integer_kode5;
                $integer_kode5 = str_pad($integer_kode5, 5,'0',STR_PAD_LEFT);  
                $kode5_edit = $kodekota.'/'.'KG'.'E'.$kodecabang.$integer_kode5;
                
                $integer_kode6= $integer_kode6;
                $integer_kode6 = str_pad($integer_kode6, 5,'0',STR_PAD_LEFT);    
                $kode6_edit = $kodekota.'/'.'KG'.'E'.$kodecabang.$integer_kode6;
                
                $integer_kode7 = $integer_kode7;
                $integer_kode7 = str_pad($integer_kode7, 5,'0',STR_PAD_LEFT);   
                $kode7_edit = $kodekota.'/'.'KG'.'E'.$kodecabang.$integer_kode7;
                
                $integer_kode8 = $integer_kode8;
                $integer_kode8 = str_pad($integer_kode8, 5,'0',STR_PAD_LEFT);  
                $kode8_edit = $kodekota.'/'.'KG'.'E'.$kodecabang.$integer_kode8;
                
                $integer_kode9 = $integer_kode9;
                $integer_kode9 = str_pad($integer_kode9, 5,'0',STR_PAD_LEFT);   
                $kode9_edit = $kodekota.'/'.'KG'.'E'.$kodecabang.$integer_kode9;



            $kertas_reguler = array(
                    'kode' => $kode0_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode0,
                    'keterangan' => 'Tarif Kertas / Kg',
                    'harga' => $request->tarifkertas_reguler,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                    'id_provinsi_cabkilogram'=>$prov,

                );
               $tarif0_10reguler = array(
                    'kode' => $kode1_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode1,
                    'keterangan' => 'Tarif <= 10 Kg',
                    'harga' => $request->tarif0kg_reguler,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                    'id_provinsi_cabkilogram'=>$prov,
                );    
               $tarif10_20reguler = array(
                    'kode' => $kode2_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode2,
                    'keterangan' => 'Tarif Kg selanjutnya <= 10 Kg',
                    'harga' => $request->tarif0kg_reguler,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                    'id_provinsi_cabkilogram'=>$prov,
                );    
               $tarif20reguler = array(
                    'kode' => $kode3_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode3,
                    'keterangan' => 'Tarif <= 20 Kg',
                    'harga' => $request->tarif20kg_reguler,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                    'id_provinsi_cabkilogram'=>$prov,
                );
               $tarifkgselreguler = array(
                    'kode' => $kode4_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode4,
                    'keterangan' => 'Tarif Kg selanjutnya <= 20 Kg',
                    'harga' => $request->tarifkgsel_reguler,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_regular,
                    'jenis' => 'REGULER',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                    'id_provinsi_cabkilogram'=>$prov,
                );
               //----------------------------------- EXPRESS --------------------------------------------------//
                $kertas_express = array(
                    'kode' => $kode5_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode5,
                    'keterangan' => 'Tarif Kertas / Kg',
                    'harga' => $request->tarifkertas_express,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                    'id_provinsi_cabkilogram'=>$prov,
                );
               $tarif0_10express = array(
                    'kode' => $kode6_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode6,
                    'keterangan' => 'Tarif <= 10 Kg',
                    'harga' => $request->tarif0kg_express,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                    'id_provinsi_cabkilogram'=>$prov,
                );
               $tarif10_20express = array(
                    'kode' => $kode7_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode7,
                    'keterangan' => 'Tarif Kg selanjutnya <= 10 Kg',
                    'harga' => $request->tarif10kg_express,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                    'id_provinsi_cabkilogram'=>$prov,
                );   
               $tarif20express = array(
                    'kode' => $kode8_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode8,
                    'keterangan' => 'Tarif <= 20 Kg',
                    'harga' => $request->tarif20kg_express,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                    'id_provinsi_cabkilogram'=>$prov,
                );
               $tarifkgselexpress = array(
                    'kode' => $kode9_edit,
                    'kode_sama_kilo' => $request->kode_sama_kilo,
                    'kode_detail_kilo' => $request->kode9,
                    'keterangan' => 'Tarif Kg selanjutnya <= 20 Kg',
                    'harga' => $request->tarifkgsel_express,
                    //BAWAH SAMA SEMUA
                    'crud'=>$crud,
                    'waktu' => $request->waktu_express,
                    'jenis' => 'EXPRESS',
                    'id_kota_asal' => $request->cb_kota_asal,
                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                    'kode_cabang' => $request->cb_cabang,
                    'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                    'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
                    'crud'=>strtoupper($crud),
                    'id_provinsi_cabkilogram'=>$prov,
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
        $hapus = DB::table('tarif_cabang_kilogram')->where('kode_sama_kilo' ,'=', $id)->where('crud','!=','E')->delete();
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
        $hapus = DB::table('tarif_cabang_kilogram')->where('id_kota_asal' ,'=', $asal)->where('id_kota_tujuan','=',$tujuan)->delete();
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
