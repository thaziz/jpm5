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

        $cabang = Auth::user()->kode_cabang;
      if (Auth::user()->punyaAkses('Tarif Cabang Sepeda','all')) {
          $sql = "    SELECT c.nama as cabang,t.crud,t.kode_sama_sepeda,t.id_provinsi_cabsepeda,p.nama provinsi,t.kode_detail_sepeda,t.acc_penjualan,t.csf_penjualan,t.kode_sama_sepeda,t.kode, t.id_kota_asal,k.kode_kota, k.nama asal,
        t.id_kota_tujuan,kk.nama tujuan, t.harga, t.jenis, t.waktu
                    FROM tarif_cabang_sepeda t
                    LEFT JOIN kota k ON k.id=t.id_kota_asal 
                    LEFT JOIN kota kk ON kk.id=t.id_kota_tujuan 
                    left join cabang c on c.kode = t.kode_cabang
                    LEFT JOIN provinsi p ON p.id=t.id_provinsi_cabsepeda
                    ORDER BY t.kode_detail_sepeda DESC ";
      }else{
          $sql = "    SELECT c.nama as cabang,t.crud,t.kode_sama_sepeda,t.id_provinsi_cabsepeda,p.nama provinsi,t.kode_detail_sepeda,t.acc_penjualan,t.csf_penjualan,t.kode_sama_sepeda,t.kode, t.id_kota_asal,k.kode_kota, k.nama asal,
        t.id_kota_tujuan,kk.nama tujuan, t.harga, t.jenis, t.waktu
                    FROM tarif_cabang_sepeda t
                    LEFT JOIN kota k ON k.id=t.id_kota_asal 
                    LEFT JOIN kota kk ON kk.id=t.id_kota_tujuan 
                    left join cabang c on c.kode = t.kode_cabang
                    LEFT JOIN provinsi p ON p.id=t.id_provinsi_cabsepeda
                    where t.kode_cabang = '$cabang'
                    ORDER BY t.kode_detail_sepeda DESC ";
      }

       


        
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
      
                    foreach ($data as $key) {
                        // add new button
        
                            if ($data[$i]['id_provinsi_cabsepeda'] == null || $data[$i]['id_provinsi_cabsepeda'] == '') {

                                $div_1  =   '<div class="btn-group">';
                                  if (Auth::user()->punyaAkses('Tarif Cabang Sepeda','ubah')) {
                                  $div_2  = '<button type="button" id="'.$data[$i]['id_kota_asal'].'" data-tujuan="'.$data[$i]['id_kota_tujuan'].'" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>';
                                  }else{
                                    $div_2 = '';
                                  }
                                  if (Auth::user()->punyaAkses('Tarif Cabang Sepeda','hapus')) {
                                  $div_3  = '<button type="button" disabled="" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button> 

                                                            <button type="button" id="'.$data[$i]['id_kota_asal'].'" name="'.$data[$i]['id_provinsi_cabsepeda'].'" data-asal="'.$data[$i]['asal'].'" data-tujuan="'.$data[$i]['tujuan'].'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button>';
                                  }else{
                                    $div_3 = '';
                                  }
                                  $div_4   = '</div>';
                                $all_div = $div_1 . $div_2 . $div_3 . $div_4;

                                $data[$i]['button'] = $all_div;
                               
                                $i++;
                                
                               
                                }
                                else{
                                    if ($data[$i]['crud'] == 'E') {

                                         $div_1  =   '<div class="btn-group">';
                                          if (Auth::user()->punyaAkses('Tarif Cabang Sepeda','ubah')) {
                                          $div_2  = '<button type="button" id="'.$data[$i]['id_kota_asal'].'" data-tujuan="'.$data[$i]['id_kota_tujuan'].'" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>';
                                          }else{
                                            $div_2 = '';
                                          }
                                          if (Auth::user()->punyaAkses('Tarif Cabang Sepeda','hapus')) {
                                          $div_3  = '<button type="button" disabled="" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button> 

                                          <button type="button" id="'.$data[$i]['id_kota_asal'].'" name="'.$data[$i]['id_provinsi_cabsepeda'].'" data-asal="'.$data[$i]['asal'].'" data-tujuan="'.$data[$i]['tujuan'].'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button>';
                                                          
                                          }else{
                                            $div_3 = '';
                                          }
                                          $div_4   = '</div>';
                                        $all_div = $div_1 . $div_2 . $div_3 . $div_4;

                                        $data[$i]['button'] = $all_div;
                                       
                                        $i++;
                                       
                                    }else if ($data[$i]['crud'] == 'N') {

                                         $div_1  =   '<div class="btn-group">';
                                          if (Auth::user()->punyaAkses('Tarif Cabang Sepeda','ubah')) {
                                          $div_2  = '<button type="button" id="'.$data[$i]['id_kota_asal'].'" data-tujuan="'.$data[$i]['id_kota_tujuan'].'" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>';
                                          }else{
                                            $div_2 = '';
                                          }
                                          if (Auth::user()->punyaAkses('Tarif Cabang Sepeda','hapus')) {
                                          $div_3  = '<button type="button" id="'.$data[$i]['id_kota_asal'].'" name="'.$data[$i]['id_provinsi_cabsepeda'].'"  data-asal="'.$data[$i]['asal'].'" data-prov="'.$data[$i]['provinsi'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button> 

                                                             <button type="button" id="'.$data[$i]['id_kota_asal'].'" name="'.$data[$i]['id_kota_tujuan'].'" data-asal="'.$data[$i]['asal'].'" data-tujuan="'.$data[$i]['tujuan'].'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button> ';
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
        // dd($request);
        $asal = $request->asal;
        $tujuan = $request->tujuan;
        $sql = "    SELECT t.kode_cabang,t.crud,t.kode_sama_sepeda,t.id_provinsi_cabsepeda,k.kode_kota,p.nama provinsi,t.kode_detail_sepeda,t.acc_penjualan,t.csf_penjualan,t.kode_sama_sepeda,t.kode, t.id_kota_asal,k.kode_kota, k.nama asal,
        t.id_kota_tujuan,

        kk.nama tujuan, t.harga, t.jenis, t.waktu
                    FROM tarif_cabang_sepeda t
                    LEFT JOIN kota k ON k.id=t.id_kota_asal 
                    LEFT JOIN kota kk ON kk.id=t.id_kota_tujuan 
                    LEFT JOIN provinsi p ON p.id=t.id_provinsi_cabsepeda
                    where t.id_kota_asal = '$asal' AND t.id_kota_tujuan = '$tujuan'
                    ORDER BY t.kode_detail_sepeda ASC ";
        
        $data = DB::select(DB::raw($sql));
        // return $data = DB::table('tarif_cabang_sepeda')->where('id_kota_asal', $asal)->where('id_kota_tujuan','=',$tujuan)->orderBy('kode_detail_sepeda','ASC')->get();

        
        echo json_encode($data);
    }

  public function save_data (Request $request) {
        // dd($request);
        $simpan='';
        $provinsi = DB::table('kota')->where('id','=',$request->cb_kota_tujuan)->get(); 
        $crud = $request->crud;
        $kode_sama_sepeda = DB::table('tarif_cabang_sepeda')->select('kode_sama_sepeda')->max('kode_sama_sepeda');    
        if ($kode_sama_sepeda == '') {
            $kode_sama_sepeda = 1;
        }else{
            $kode_sama_sepeda += 1;
        }
        $kode_utama = DB::table('tarif_cabang_sepeda')->select('kode_detail_sepeda')->max('kode_detail_sepeda');    
        
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
     
     if ($request->cb_provinsi_tujuan != null or '') {
        $cari = DB::table('kota')  
              ->where('id_provinsi',$request->cb_provinsi_tujuan)
              ->get();
      }else{
          $provinsi = DB::table('kota')->where('id','=',$request->cb_kota_tujuan)->get(); 
      }

     if ($request->cb_kota_tujuan == '' ) {  
      for ($save=1; $save <count($id_provinsi_loop) ; $save++) {
                
        $s = DB::table('tarif_cabang_sepeda')
                ->where('id_kota_asal',$request->cb_kota_asal)
                ->where('id_kota_tujuan',$id_provinsi_loop[$save])
                ->where('kode_cabang',$request->ed_cabang)
                ->get();
        $cek = count($s);

      if ($cek > 0 ) {
        $array_jenis = ['moge','laki_sport','bebek_matik','sepeda_pancal'];
        $array_harga = [$request->sepeda_pancal,$request->bebek_matik,$request->laki_sport,$request->moge];
        // return $cari;

          for ($i=0; $i < count($cari); $i++) { 
            for ($o=0; $o <count($cari[$i]) ; $o++) { 
              // return $cari[$i]->id;
                    $cari_old[$i] = DB::table('tarif_cabang_sepeda')
                              ->where('id_kota_asal',$request->cb_kota_asal)
                              ->where('id_kota_tujuan',$cari[$i]->id)
                              ->where('kode_cabang',$request->ed_cabang)
                              // ->where('jenis','REGULER') 
                              ->orderBy('kode','ASC')
                              ->get();
              }
            }
            // return $cari_old;
            $cari_nota0 = DB::select("SELECT  substring(max(kode),10) as id from tarif_cabang_sepeda
                                                WHERE kode_cabang = '$request->ed_cabang'");
            $id1 = (integer)$cari_nota0[0]->id+1;

             for ($a=0; $a < count($array_jenis); $a++) { 
                            
                            $index = $id1;
                            $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                            $array_note = $kodekota . '/' .  'SPD' .$request->ed_cabang .  $index;
                            
              }
              $id1++;

              // return $nota0;
              // return $array_note;
             for ($i=0; $i <count($cari) ; $i++) { 
              for ($a=0; $a <count($array_jenis) ; $a++) { 
                // return $cari_old[$i][$a]->kode;

                if (isset($cari_old[$i][$a])) {
                  // return $cari_old[$i][$a]->kode;
                  // return $cari_old[$i][$a]->id_kota_tujuan;
                  if (isset($cari_old[$i][$a]->id_kota_asal) != $request->cb_kota_asal and
                      isset($cari_old[$i][$a]->id_kota_tujuan )!= $cari[$i]->id and
                      isset($cari_old[$i][$a]->kode_cabang) != $request->ed_cabang ) {

                        $simpan = DB::table('tarif_cabang_sepeda')
                            ->insert([
                                    'kode_sama_sepeda' => $kode_sama_sepeda,
                                    'kode_detail_sepeda'=>$kode_detail_sepeda,
                                    'kode'=>$array_note[$a][$i],
                                    'id_kota_asal' => $request->cb_kota_asal,
                                    'id_kota_tujuan' => $cari[$i][$a]->id_kota_tujuan,
                                    'kode_cabang' => $request->ed_cabang,
                                    'jenis' => $array_jenis[$a],
                                    'harga' => $array_harga[$a],
                                    'waktu' => $request->waktu,
                                    'acc_penjualan'=>$request->ed_acc_penjualan,
                                    'csf_penjualan'=>$request->ed_csf_penjualan,
                                    'id_provinsi_cabsepeda'=>$request->cb_provinsi_tujuan,
                                    'crud'=>$crud,
                          ]);

                  }else{
                    // return $cari_old[$i][$a]->kode;
                    // // return 'a';
                    //   return $cari_old;
                    if ($cari_old[$i][$a]->crud != 'E') {
                      // return 'a';
                                $simpan = DB::table('tarif_cabang_sepeda')
                                ->where('kode',$cari_old[$i][$a]->kode)
                                ->orderBy('kode_detail_sepeda','asc')
                                ->update([
                                        'harga' => $array_harga[$a],
                                        'waktu' => $request->waktu,
                                        'acc_penjualan'=>$request->ed_acc_penjualan,
                                        'csf_penjualan'=>$request->ed_csf_penjualan,
                                        'crud'=>'N',
                                ]);
                            }
                  }
                }else{
                  return 'b';
                }
              }
             }

      }else{


          if ($crud =='N') {

              if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;            
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
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){ 
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;            
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
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;            
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
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;            
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
}

    }else{
        $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;            
                     
                  

         if ($crud == 'N') {

                    if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;            
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
                        'id_provinsi_cabsepeda'=>$provinsi[0]->id_provinsi,
                        'crud'=>$crud,
                    );
            
             if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;            
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
                        'id_provinsi_cabsepeda'=>$provinsi[0]->id_provinsi,
                        'crud'=>$crud,
                    );

           

               if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;            
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
                        'id_provinsi_cabsepeda'=>$provinsi[0]->id_provinsi,
                        'crud'=>$crud,
                    );

                if ($datadetailcount != 0) {
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;   

                }else if ($datadetailcount == 0){
                    $kode_detail_sepeda += 1;
                     $kode_utama = $kode_utama+1;
                     $kode_utama = str_pad($kode_utama, 5,'0',STR_PAD_LEFT);
                    $kode = $kodekota.'/'.'SPD'.''.$kodecabang.$kode_utama;            
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
                        'id_provinsi_cabsepeda'=>$provinsi[0]->id_provinsi,
                        'crud'=>$crud,
                    );
                  
                  

            $simpan = DB::table('tarif_cabang_sepeda')->insert($pancal);
            $simpan = DB::table('tarif_cabang_sepeda')->insert($matik);
            $simpan = DB::table('tarif_cabang_sepeda')->insert($sport);
            $simpan = DB::table('tarif_cabang_sepeda')->insert($moge);
            

        }elseif ($crud == 'E') {
            // dd($request);    
                
                $id_sepeda_edit = $request->id_sepeda_edit;
                $id_matik_edit = $request->id_matik_edit;
                $id_sport_edit = $request->id_sport_edit;
                $id_moge_edit = $request->id_moge_edit;
                $integer_reg =  (int)$id_sepeda_edit;
                $integer_exp =  (int)$id_matik_edit;
                $integer_out =  (int)$id_moge_edit;
                $integer_sport =  (int)$id_sport_edit;
                
                
                $integer_reg = $integer_reg;
                $integer_reg = str_pad($integer_reg, 5,'0',STR_PAD_LEFT);
                $integer_exp = $integer_exp;
                $integer_exp = str_pad($integer_exp, 5,'0',STR_PAD_LEFT);
                $integer_out = $integer_out;
                $integer_out = str_pad($integer_out, 5,'0',STR_PAD_LEFT);
                $integer_sport = $integer_sport;
                $integer_sport = str_pad($integer_sport, 5,'0',STR_PAD_LEFT);
                 
                $kode_reguler_edit = $kodekota.'/'.'SPD'.''.$kodecabang.$integer_reg; 
                $kode_express_edit = $kodekota.'/'.'SPD'.''.$kodecabang.$integer_exp;  
                $kode_outlet_edit = $kodekota.'/'.'SPD'.''.$kodecabang.$integer_out; 
                $kode_sport_edit = $kodekota.'/'.'SPD'.''.$kodecabang.$integer_sport;
                // return $kode_reguler_edit;
                // return $kode_express_edit;
                // return $kode_outlet_edit;
                // return $kode_reguler_edit;
                $prov = DB::table('kota')->select('id','id_provinsi')->where('id',$request->cb_kota_tujuan)->get();
                $prov = $prov[0]->id_provinsi;

                $sepedah = array(
                        'kode_sama_sepeda' => $request->ed_kode_old,
                        'kode_detail_sepeda'=>$request->id_sepeda_edit,
                        'kode'=>$kode_reguler_edit,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'jenis' => 'sepeda_pancal',
                        'kode_cabang' => $request->ed_cabang,      
                        'harga' => $request->sepeda_pancal,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'crud'=>$crud,
                        'id_provinsi_cabsepeda'=>$provinsi[0]->id_provinsi,
                   );
                   
                // return $regular;
                $matik = array(
                        'kode_sama_sepeda' => $request->ed_kode_old,
                        'kode_detail_sepeda'=>$request->id_matik_edit,
                        'kode'=>$kode_express_edit,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang, 
                        'jenis' => 'bebek_matik',
                        'harga' => $request->bebek_matik,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'crud'=>$crud,
                        'id_provinsi_cabsepeda'=>$provinsi[0]->id_provinsi,
                    );
                     $sport = array(
                        'kode_sama_sepeda' => $kode_sama_sepeda,
                        'kode_detail_sepeda'=>$request->id_sport_edit,
                        'kode'=>$kode_sport_edit,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'laki_sport',
                        'harga' => $request->laki_sport,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'crud'=>$crud,
                        'id_provinsi_cabsepeda'=>$provinsi[0]->id_provinsi,
                    );
                        // return $request->moge; 
                if ($request->moge != null || $request->moge != '') {
                    $moge = array(
                        'kode_sama_sepeda' => $request->ed_kode_old,
                        'kode_detail_sepeda'=>$request->id_moge_edit,
                        'kode'=>$kode_outlet_edit,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'moge',
                        'harga' => $request->moge,
                        'waktu' => $request->waktu,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                        'crud'=>$crud,
                        'id_provinsi_cabsepeda'=>$provinsi[0]->id_provinsi,
                    );
            $simpan = DB::table('tarif_cabang_sepeda')->where('kode', $request->id_moge)->update($moge);
            }else if($request->moge == null || $request->moge == ''){ 
                
            }

            $simpan = DB::table('tarif_cabang_sepeda')->where('kode', $request->id_matik)->update($matik);
            $simpan = DB::table('tarif_cabang_sepeda')->where('kode', $request->id_sepeda)->update($sepedah);
            $simpan = DB::table('tarif_cabang_sepeda')->where('kode', $request->id_sport)->update($sport);
        }
    }
     
        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            $result['error']='ERROR BOS ! ';
            $result['result']=0;
        }
        $result['crud']=$crud;
        echo json_encode($result);
    
    }

    public function hapus_data (Request $request) {
        $hapus='';
        $asal=$request->id;
        $tujuan=$request->name;
        $hapus = DB::table('tarif_cabang_sepeda')->where('id_kota_asal' ,'=', $asal)->where('id_provinsi_cabsepeda','=',$tujuan)->where('crud','!=','E')->delete();
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
        $hapus = DB::table('tarif_cabang_sepeda')->where('id_kota_asal' ,'=', $asal)->where('id_kota_tujuan','=',$tujuan)->delete();
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
