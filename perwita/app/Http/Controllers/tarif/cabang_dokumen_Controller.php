<?php

namespace App\Http\Controllers\tarif;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;
use carbon\carbon;

class cabang_dokumen_Controller extends Controller
{
    public function table_data () {
      $cabang = Auth::user()->kode_cabang;
      if (Auth::user()->punyaAkses('Tarif Cabang Dokumen','all')) {
         $sql = " SELECT t.crud,t.id_provinsi_cabdokumen,p.nama provinsi,t.kode_detail,t.acc_penjualan,t.csf_penjualan,t.kode_sama,t.kode, t.id_kota_asal,k.kode_kota, k.nama asal,
        t.id_kota_tujuan,
        kk.nama tujuan, t.harga, t.jenis, t.waktu, t.tipe  
                    FROM tarif_cabang_dokumen t
                    LEFT JOIN kota k ON k.id=t.id_kota_asal 
                    LEFT JOIN kota kk ON kk.id=t.id_kota_tujuan 
                    LEFT JOIN provinsi p ON p.id=t.id_provinsi_cabdokumen
                    ORDER BY t.kode_detail DESC ";
      }else{
         $sql = " SELECT t.crud,t.id_provinsi_cabdokumen,p.nama provinsi,t.kode_detail,t.acc_penjualan,t.csf_penjualan,t.kode_sama,t.kode, t.id_kota_asal,k.kode_kota, k.nama asal,
        t.id_kota_tujuan,
        kk.nama tujuan, t.harga, t.jenis, t.waktu, t.tipe  
                    FROM tarif_cabang_dokumen t
                    LEFT JOIN kota k ON k.id=t.id_kota_asal 
                    LEFT JOIN kota kk ON kk.id=t.id_kota_tujuan 
                    LEFT JOIN provinsi p ON p.id=t.id_provinsi_cabdokumen
                    where t.kode_cabang = '$cabang'
                    ORDER BY t.kode_detail DESC ";
      }
       
        
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
       
                    foreach ($data as $key) {
                        // add new button
if ($data[$i]['id_provinsi_cabdokumen'] == null || $data[$i]['id_provinsi_cabdokumen'] == '') {

                                $div_1  =   '<div class="btn-group">';
                                  if (Auth::user()->punyaAkses('Tarif Cabang Dokumen','ubah')) {
                                  $div_2  = '<button type="button" id="'.$data[$i]['id_kota_asal'].'" data-tujuan="'.$data[$i]['id_kota_tujuan'].'" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" >'.'<i class="glyphicon glyphicon-pencil"></i></button>';
                                  }else{
                                    $div_2 = '';
                                  }
                                  if (Auth::user()->punyaAkses('Tarif Cabang Dokumen','hapus')) {
                                  $div_3  = '<button type="button" disabled="" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>'.'<button type="button" id="'.$data[$i]['id_kota_asal'].'" name="'.$data[$i]['id_kota_tujuan'].'" data-asal="'.$data[$i]['asal'].'" data-tujuan="'.$data[$i]['tujuan'].'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button>';
                                  }else{
                                    $div_3 = '';
                                  }
                                  $div_4   = '</div>';
                                $all_div = $div_1 . $div_2 . $div_3 . $div_4;

                                $data[$i]['button'] = $all_div;
                               
                                $i++;

}else{

    if ($data[$i]['crud'] == 'E') {

                                     $div_1  =   '<div class="btn-group">';
                                      if (Auth::user()->punyaAkses('Tarif Cabang Dokumen','ubah')) {
                                      $div_2  = '<button type="button" id="'.$data[$i]['id_kota_asal'].'" data-tujuan="'.$data[$i]['id_kota_tujuan'].'" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>';
                                      }else{
                                        $div_2 = '';
                                      }
                                      if (Auth::user()->punyaAkses('Tarif Cabang Dokumen','hapus')) {
                                      $div_3  = '<button type="button" disabled="" id="'.$data[$i]['kode_sama'].'" name="'.$data[$i]['kode_sama'].'"  data-asal="'.$data[$i]['asal'].'" data-prov="'.$data[$i]['provinsi'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>'.'<button type="button" id="'.$data[$i]['id_kota_asal'].'" name="'.$data[$i]['id_kota_tujuan'].'" data-asal="'.$data[$i]['asal'].'" data-tujuan="'.$data[$i]['tujuan'].'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button>';
                                      }else{
                                        $div_3 = '';
                                      }
                                      $div_4   = '</div>';
                                    $all_div = $div_1 . $div_2 . $div_3 . $div_4;

                                    $data[$i]['button'] = $all_div;
                                   
                                    $i++;

    }else if(($data[$i]['crud'] == 'N')){

                                        $div_1  =   '<div class="btn-group">';
                                          if (Auth::user()->punyaAkses('Tarif Cabang Dokumen','ubah')) {
                                          $div_2  = ' <button type="button" id="'.$data[$i]['id_kota_asal'].'" data-tujuan="'.$data[$i]['id_kota_tujuan'].'" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>';
                                          }else{
                                            $div_2 = '';
                                          }
                                          if (Auth::user()->punyaAkses('Tarif Cabang Dokumen','hapus')) {
                                          $div_3  = '<button type="button" id="'.$data[$i]['kode_sama'].'" name="'.$data[$i]['kode_sama'].'"  data-asal="'.$data[$i]['asal'].'" data-prov="'.$data[$i]['provinsi'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>'.'<button type="button" id="'.$data[$i]['id_kota_asal'].'" name="'.$data[$i]['id_kota_tujuan'].'" data-asal="'.$data[$i]['asal'].'" data-tujuan="'.$data[$i]['tujuan'].'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button>';
                                          }else{
                                            $div_3 = '';
                                          }
                                          $div_4   = '</div>';
                                        $all_div = $div_1 . $div_2 . $div_3 . $div_4;

                                        $data[$i]['button'] = $all_div;
                                       
                                        $i++;


    }

}

}
                        
                
        


        // maksudku ngene
        
    
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        // dd($request->all());
        $asal = $request->asal;
        $tujuan = $request->tujuan;
        $sql = " SELECT t.kode_cabang,t.crud,t.id_provinsi_cabdokumen,p.nama provinsi,t.kode_detail,t.acc_penjualan,t.csf_penjualan,t.kode_sama,t.kode, t.id_kota_asal,k.kode_kota, k.nama asal,
        t.id_kota_tujuan,
        kk.nama tujuan, t.harga, t.jenis, t.waktu, t.tipe  
                    FROM tarif_cabang_dokumen t
                    LEFT JOIN kota k ON k.id=t.id_kota_asal 
                    LEFT JOIN kota kk ON kk.id=t.id_kota_tujuan 
                    LEFT JOIN provinsi p ON p.id=t.id_provinsi_cabdokumen
                    where t.id_kota_asal = '$asal' AND t.id_kota_tujuan = '$tujuan'
                    ORDER BY t.kode_detail ASC ";
        
        $data = DB::select(DB::raw($sql));
        // $data = DB::table('tarif_cabang_dokumen')->where('id_kota_asal', $asal)->where('id_kota_tujuan','=',$tujuan)->orderBy('kode_detail','ASC')->get();

        
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        // dd($request->all());
        
        $simpan='';
        if ($request->cb_provinsi_tujuan != null or '') {
            $cari = DB::table('kota')  
                  ->where('id_provinsi',$request->cb_provinsi_tujuan)
                  ->get();
        }else{
            $provinsi = DB::table('kota')->where('id','=',$request->cb_kota_tujuan)->get(); 
        }


        $crud = $request->crud;
        

        $kodekota = $request->kodekota;
        $kodecabang = Auth::user()->kode_cabang;

        $array_harga = [];
        $array_jenis = ['REGULER','EXPRESS','OUTLET'];
        $array_waktu = [];
        $array_nota  = ['DR','DE','DO'];
        $array_note  = [];

        if ($request->harga_outlet == '' or null) {
            $request->harga_outlet = 0;
        }

        array_push($array_harga, $request->harga_regular);
        array_push($array_harga, $request->harga_express);
        array_push($array_harga, $request->harga_outlet);

        array_push($array_waktu, $request->waktu_regular);
        array_push($array_waktu, $request->waktu_express);
        array_push($array_waktu, $request->waktu_outlet);

        $cari_kode_sama = DB::table('tarif_cabang_dokumen')
                            ->max('kode_sama');
        if ($cari_kode_sama == null) {
            $cari_kode_sama = 1;
        }else{
            $cari_kode_sama += 1;
        }
      

       


        // return $array_harga;

        if ($crud  == 'N') {
            if ($request->cb_provinsi_tujuan != null or '') {
                   for ($i=0; $i < count($cari); $i++) { 
                    $cari_old0[$i] = DB::table('tarif_cabang_dokumen')
                              ->where('id_kota_asal',$request->cb_kota_asal)
                              ->where('id_kota_tujuan',$cari[$i]->id)
                              ->where('kode_cabang',$request->ed_cabang)
                              ->where('jenis','REGULER')
                              ->get();

                    $cari_old1[$i] = DB::table('tarif_cabang_dokumen')
                              ->where('id_kota_asal',$request->cb_kota_asal)
                              ->where('id_kota_tujuan',$cari[$i]->id)
                              ->where('kode_cabang',$request->ed_cabang)
                              ->where('jenis','EXPRESS')
                              ->get();

                    $cari_old2[$i] = DB::table('tarif_cabang_dokumen')
                              ->where('id_kota_asal',$request->cb_kota_asal)
                              ->where('id_kota_tujuan',$cari[$i]->id)
                              ->where('kode_cabang',$request->ed_cabang)
                              ->where('jenis','OUTLET')
                              ->get();
                    }

                    $cari_nota0 = DB::select("SELECT  substring(max(kode),10) as id from tarif_cabang_dokumen
                                                WHERE kode_cabang = '$request->ed_cabang'
                                                and jenis = 'REGULER'");

                    $cari_nota1 = DB::select("SELECT  substring(max(kode),10) as id from tarif_cabang_dokumen
                                                        WHERE kode_cabang = '$request->ed_cabang'
                                                        and jenis = 'EXPRESS'");

                    $cari_nota2 = DB::select("SELECT  substring(max(kode),10) as id from tarif_cabang_dokumen
                                                        WHERE kode_cabang = '$request->ed_cabang'
                                                        and jenis = 'OUTLET'");
                    $id1 = (integer)$cari_nota0[0]->id+1;
                    $id2 = (integer)$cari_nota1[0]->id+1;
                    $id3 = (integer)$cari_nota2[0]->id+1;
                    
                    for ($i=0; $i < count($cari); $i++) { 
                        for ($a=0; $a < count($array_harga); $a++) { 
                            
                            $index = $id1;
                            $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                            $nota0[$i] = $kodekota . '/' .  'DR' .$request->ed_cabang .  $index;

                            
                            $index = $id2;
                            $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                            $nota1[$i] = $kodekota . '/' . 'DE' .$request->ed_cabang .  $index;

                           
                            $index = $id3;
                            $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                            $nota2[$i] = $kodekota . '/' . 'DO' .$request->ed_cabang .  $index;
                            
                        }
                        $id1++;
                        $id2++;
                        $id3++;
                    }
                    $array_note = [$nota0,$nota1,$nota2];
            }else{

                    $cari_nota0 = DB::select("SELECT  max(substring(kode,10)) as id from tarif_cabang_dokumen
                                                        WHERE kode_cabang = '$request->ed_cabang'
                                                        and jenis = 'REGULER'");
                    // return $cari_nota0;
                    $cari_nota1 = DB::select("SELECT  max(substring(kode,10)) as id from tarif_cabang_dokumen
                                                        WHERE kode_cabang = '$request->ed_cabang'
                                                        and jenis = 'EXPRESS'");

                    $cari_nota2 = DB::select("SELECT  max(substring(kode,10)) as id from tarif_cabang_dokumen
                                                        WHERE kode_cabang = '$request->ed_cabang'
                                                        and jenis = 'OUTLET'");
                    $id1 = (integer)$cari_nota0[0]->id+1;
                    $id2 = (integer)$cari_nota1[0]->id+1;
                    $id3 = (integer)$cari_nota2[0]->id+1;

                    // return$array_harga;

                    // return $id1;

                     
                            
                        for ($a=0; $a < count($array_harga); $a++) { 
                            
                            $index = $id1;
                            $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                            $nota0 = $kodekota . '/' .  'DR' .$request->ed_cabang .  $index;

                            
                            $index = $id2;
                            $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                            $nota1 = $kodekota . '/' . 'DE' .$request->ed_cabang .  $index;

                           
                            $index = $id3;
                            $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                            $nota2 = $kodekota . '/' . 'DO' .$request->ed_cabang .  $index;
                            
                        }
                        $id1++;
                        $id2++;
                        $id3++;
                    
                        // return $id3;

                    $array_note = [$nota0,$nota1,$nota2];

                    // return $array_note;
                     $cari_old0 = DB::table('tarif_cabang_dokumen')
                              ->where('id_kota_asal',$request->cb_kota_asal)
                              ->where('id_kota_tujuan',$request->cb_kota_tujuan)
                              ->where('kode_cabang',$request->ed_cabang)
                              ->where('jenis','REGULER')
                              ->get();

                    $cari_old1 = DB::table('tarif_cabang_dokumen')
                              ->where('id_kota_asal',$request->cb_kota_asal)
                              ->where('id_kota_tujuan',$request->cb_kota_tujuan)
                              ->where('kode_cabang',$request->ed_cabang)
                              ->where('jenis','EXPRESS')
                              ->get();

                    $cari_old2 = DB::table('tarif_cabang_dokumen')
                              ->where('id_kota_asal',$request->cb_kota_asal)
                              ->where('id_kota_tujuan',$request->cb_kota_tujuan)
                              ->where('kode_cabang',$request->ed_cabang)
                              ->where('jenis','OUTLET')
                              ->get();
            }
            // return $cari_old0;


            if ($request->cb_provinsi_tujuan != null or '') {
                for ($i=0; $i < count($cari); $i++) { 

                    
                    for ($a=0; $a < count($array_harga); $a++) { 
                        $kode_detail = DB::table('tarif_cabang_dokumen')
                                ->max('kode_detail');
                        if ($kode_detail == null) {
                            $kode_detail = 1;
                        }else{
                            $kode_detail += 1;
                        }

                        
                        if (isset(${'cari_old'.$a}[$i][0])) {
                            if ($array_harga[$a] != '') {
                                if (${'cari_old'.$a}[$i][0]->id_kota_asal != $request->cb_kota_asal and
                                    ${'cari_old'.$a}[$i][0]->id_kota_tujuan != $cari[$i]->id and
                                    ${'cari_old'.$a}[$i][0]->kode_cabang != $request->ed_cabang ) {

                                        $data = DB::table('tarif_cabang_dokumen')
                                        ->insert([
                                                'kode_sama' => $cari_kode_sama,
                                                'kode_detail'=>$kode_detail,
                                                'kode'=>$array_note[$a][$i],
                                                'id_kota_asal' => $request->cb_kota_asal,
                                                'id_kota_tujuan' => $cari[$i]->id,
                                                'kode_cabang' => $request->ed_cabang,
                                                'jenis' => $array_jenis[$a],
                                                'harga' => $array_harga[$a],
                                                'waktu' => $array_waktu[$a],
                                                'acc_penjualan'=>$request->ed_acc_penjualan,
                                                'csf_penjualan'=>$request->ed_csf_penjualan,
                                                'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                                                'crud'=>$crud,
                                      ]);
                                }else{
                                    if (${'cari_old'.$a}[$i][0]->crud != 'E') {
                                        $data = DB::table('tarif_cabang_dokumen')
                                        ->where('kode',${'cari_old'.$a}[$i][0]->kode)
                                        ->update([
                                                'harga' => $array_harga[$a],
                                                'waktu' => $array_waktu[$a],
                                                'acc_penjualan'=>$request->ed_acc_penjualan,
                                                'csf_penjualan'=>$request->ed_csf_penjualan,
                                                'crud'=>'N',
                                        ]);
                                    }
                                        
                                }
                                
                            }
                        }else{
                            // return 'asd';
                            if ($array_harga[$a] != '') {
                                // return $array_harga[$a];
                                $data = DB::table('tarif_cabang_dokumen')
                                ->insert([
                                        'kode_sama' => $cari_kode_sama,
                                        'kode_detail'=>$kode_detail,
                                        'kode'=>$array_note[$a][$i],
                                        'id_kota_asal' => $request->cb_kota_asal,
                                        'id_kota_tujuan' => $cari[$i]->id,
                                        'kode_cabang' => $request->ed_cabang,
                                        'jenis' => $array_jenis[$a],
                                        'harga' => $array_harga[$a],
                                        'waktu' => $array_waktu[$a],
                                        'acc_penjualan'=>$request->ed_acc_penjualan,
                                        'csf_penjualan'=>$request->ed_csf_penjualan,
                                        'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                                        'crud'=>$crud,
                                ]);
                            }
                        }
                        
                    }

                }
            }else{
                 if ($crud =='N') {
                    for ($j=0; $j < count($array_harga); $j++) {
                    
                        $gege[$j] = ${'cari_old'.$j};
                    
                    }

                    // return $gege;
                    for ($k=0; $k <count($gege) ; $k++) { 
                        
                    if (isset($gege[$k][0]->id_kota_asal) != $request->cb_kota_asal &&
                        isset($gege[$k][0]->id_kota_tujuan) !=$request->cb_kota_tujuan &&
                        isset($gege[$k][0]->kode_cabang) != $request->ed_cabang) {
                        
                        // return $array_jenis;
                        $kode_detail = DB::table('tarif_cabang_dokumen')
                                ->max('kode_detail');
                        if ($kode_detail == null) {
                            $kode_detail = 1;
                        }else{
                            $kode_detail += 1;
                        }
                        // return $provinsi[0]->id;
                        // return count($array_note);
                        // return $array_jenis;
                        $a = "";
                        
                            // return $array_note;

                            $data = DB::table('tarif_cabang_dokumen')
                                ->insert([
                                        'kode_sama' => $cari_kode_sama,
                                        'kode_detail'=>$kode_detail,
                                        'kode'=>$array_note[$k],
                                        'id_kota_asal' => $request->cb_kota_asal,
                                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                                        'kode_cabang' => $request->ed_cabang,
                                        'jenis' => $array_jenis[$k],
                                        'harga' => $array_harga[$k],
                                        'waktu' => $array_waktu[$k],
                                        'acc_penjualan'=>$request->ed_acc_penjualan,
                                        'csf_penjualan'=>$request->ed_csf_penjualan,
                                        'id_provinsi_cabdokumen'=>$provinsi[0]->id_provinsi,
                                        'crud'=>$crud,
                                ]);
                          
                         
                        
                    }else{
                        // return 'b';
                        
                        if ($gege[$k][0]->crud != 'E') {
                                        $data = DB::table('tarif_cabang_dokumen')
                                        ->where('kode',$gege[$k][0]->kode)
                                        ->update([
                                                'harga' => $array_harga[$k],
                                                'waktu' => $array_waktu[$k],
                                                'acc_penjualan'=>$request->ed_acc_penjualan,
                                                'csf_penjualan'=>$request->ed_csf_penjualan,
                                                'crud'=>'N',
                                                'id_provinsi_cabdokumen'=>$provinsi[0]->id_provinsi,
                                        ]);
                                    }

                                           
                    }
                  }  
                
                }
            }

            if($data == TRUE){
            $result['error']='';
            $result['result']=1;
            }else{
                $result['error']=$data;
                $result['result']=0;
            }
            $result['crud']=$crud;
            echo json_encode($result);

        }else if($crud == 'E'){
            $cari_reguler = DB::select("SELECT  substring(kode,10) as id from tarif_cabang_dokumen
                                                WHERE kode = '$request->id_reguler'");
            $cari_express = DB::select("SELECT  substring(kode,10) as id from tarif_cabang_dokumen
                                                WHERE kode = '$request->id_express'");
            $cari_outlet  = DB::select("SELECT  substring(kode,10) as id from tarif_cabang_dokumen
                                                WHERE kode = '$request->id_outlet'");

            
            $index = (integer)$cari_reguler[0]->id;
            $index = str_pad($index, 5, '0', STR_PAD_LEFT);
            $nota  = $kodekota . '/' . 'DR' .$request->ed_cabang .  $index;

            $index = (integer)$cari_express[0]->id;
            $index = str_pad($index, 5, '0', STR_PAD_LEFT);
            $nota1 = $kodekota . '/' . 'DE' .$request->ed_cabang .  $index;

            if ($cari_outlet != null) {
                 $index = (integer)$cari_outlet[0]->id;
                 $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                 $nota2 = $kodekota . '/' . 'DO' .$request->ed_cabang .  $index;

                 if ($nota2 != $request->id_outlet) {
                 $update_outlet = DB::table('tarif_cabang_dokumen')
                                ->where('kode',$request->id_outlet)
                                ->update([
                                    'kode'=>$nota2,
                                    'id_kota_asal' => $request->cb_kota_asal,
                                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                                    'kode_cabang' => $request->ed_cabang,
                                    'harga' => $request->harga_outlet,
                                    'waktu' => $request->waktu_outlet,
                                    'acc_penjualan'=>$request->ed_acc_penjualan,
                                    'csf_penjualan'=>$request->ed_csf_penjualan,
                                    'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                                    'crud'=>$crud,
                                ]);
                }else{
                     $update_outlet = DB::table('tarif_cabang_dokumen')
                                    ->where('kode',$request->id_outlet)
                                    ->update([
                                        'id_kota_asal' => $request->cb_kota_asal,
                                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                                        'kode_cabang' => $request->ed_cabang,
                                        'harga' => $request->harga_outlet,
                                        'waktu' => $request->waktu_outlet,
                                        'acc_penjualan'=>$request->ed_acc_penjualan,
                                        'csf_penjualan'=>$request->ed_csf_penjualan,
                                        'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                                        'crud'=>$crud,
                                    ]);
                }
            }
           
            
            if ($nota != $request->id_reguler) {
                $update_reguler = DB::table('tarif_cabang_dokumen')
                                ->where('kode',$request->id_reguler)
                                ->update([
                                    'kode'=>$nota,
                                    'id_kota_asal' => $request->cb_kota_asal,
                                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                                    'kode_cabang' => $request->ed_cabang,
                                    'harga' => $request->harga_regular,
                                    'waktu' => $request->waktu_regular,
                                    'acc_penjualan'=>$request->ed_acc_penjualan,
                                    'csf_penjualan'=>$request->ed_csf_penjualan,
                                    'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                                    'crud'=>$crud,
                                ]);
            }else{
                $update_reguler = DB::table('tarif_cabang_dokumen')
                                ->where('kode',$request->id_reguler)
                                ->update([
                                    'id_kota_asal' => $request->cb_kota_asal,
                                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                                    'kode_cabang' => $request->ed_cabang,
                                    'harga' => $request->harga_regular,
                                    'waktu' => $request->waktu_regular,
                                    'acc_penjualan'=>$request->ed_acc_penjualan,
                                    'csf_penjualan'=>$request->ed_csf_penjualan,
                                    'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                                    'crud'=>$crud,
                                ]);
            }
            if ($nota1 != $request->id_express) {
                $update_express = DB::table('tarif_cabang_dokumen')
                                ->where('kode',$request->id_express)
                                ->update([
                                    'kode'=>$nota1,
                                    'id_kota_asal' => $request->cb_kota_asal,
                                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                                    'kode_cabang' => $request->ed_cabang,
                                    'harga' => $request->harga_express,
                                    'waktu' => $request->waktu_express,
                                    'acc_penjualan'=>$request->ed_acc_penjualan,
                                    'csf_penjualan'=>$request->ed_csf_penjualan,
                                    'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                                    'crud'=>$crud,
                                ]);
            }else{
                $update_express = DB::table('tarif_cabang_dokumen')
                                ->where('kode',$request->id_express)
                                ->update([
                                    'id_kota_asal' => $request->cb_kota_asal,
                                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                                    'kode_cabang' => $request->ed_cabang,
                                    'harga' => $request->harga_express,
                                    'waktu' => $request->waktu_express,
                                    'acc_penjualan'=>$request->ed_acc_penjualan,
                                    'csf_penjualan'=>$request->ed_csf_penjualan,
                                    'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                                    'crud'=>$crud,
                                ]);
            }

            
            
           

            echo json_encode('sukses');


        }
        
    
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
        $hapus = DB::table('tarif_cabang_dokumen')->where('id_kota_asal' ,'=', $asal)->where('id_kota_tujuan','=',$tujuan)->delete();
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
