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
        $sql = "    SELECT t.crud,t.kode_sama_sepeda,t.id_provinsi_cabsepeda,p.nama provinsi,t.kode_detail_sepeda,t.acc_penjualan,t.csf_penjualan,t.kode_sama_sepeda,t.kode, t.id_kota_asal,k.kode_kota, k.nama asal,
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
                                    if ($data[$i]['crud'] == 'E') {
                                        $data[$i]['button'] =' <div class="btn-group">
                                                            <button type="button" id="'.$data[$i]['id_kota_asal'].'" data-tujuan="'.$data[$i]['id_kota_tujuan'].'" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                                           
                                                            
                                                            <button type="button" disabled="" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button> 

                                                            <button type="button" disabled="" data-toggle="tooltip" title="Delete" style="color:white;" class="btn btn-purple btn-xs btndelete" ><i class="glyphicon glyphicon-trash"></i></button>                                   
                                                        </div ';
                                $i++;
                                    }else if ($data[$i]['crud'] == 'N') {
                                        $data[$i]['button'] =' <div class="btn-group">
                                                            <button type="button" id="'.$data[$i]['id_kota_asal'].'" data-tujuan="'.$data[$i]['id_kota_tujuan'].'" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                                           
                                                            <button type="button" id="'.$data[$i]['kode_sama_sepeda'].'" name="'.$data[$i]['kode_sama_sepeda'].'"  data-asal="'.$data[$i]['asal'].'" data-prov="'.$data[$i]['provinsi'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button> 

                                                             <button type="button" id="'.$data[$i]['id_kota_asal'].'" name="'.$data[$i]['id_kota_tujuan'].'" data-asal="'.$data[$i]['asal'].'" data-tujuan="'.$data[$i]['tujuan'].'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button>                                     
                                                        </div> ';
                                $i++;
                                    }
                                
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
        $sql = "    SELECT t.crud,t.kode_sama_sepeda,t.id_provinsi_cabsepeda,k.kode_kota,p.nama provinsi,t.kode_detail_sepeda,t.acc_penjualan,t.csf_penjualan,t.kode_sama_sepeda,t.kode, t.id_kota_asal,k.kode_kota, k.nama asal,
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
        // dd($request->all());
        $simpan='';
        $cari = DB::table('kota')  
                  ->where('id_provinsi',$request->cb_provinsi_tujuan)
                  ->get();
        // return $cari;
        $crud = $request->crud;
        

        $kodekota = $request->kodekota;
        $kodecabang = Auth::user()->kode_cabang;

        $array_harga = [];
        $array_jenis = ['sepeda_pancal','bebek_matik','laki_sport','moge'];
        $array_waktu = [];
        $array_nota  = ['SPD'];
        $array_note  = [];

        if ($request->harga_outlet == '' or null) {
            $request->harga_outlet = 0;
        }

        array_push($array_harga, $request->sepeda_pancal);
        array_push($array_harga, $request->bebek_matik);
        array_push($array_harga, $request->laki_sport);
        array_push($array_harga, $request->moge);

        array_push($array_waktu, $request->waktu);
        array_push($array_waktu, $request->waktu);
        array_push($array_waktu, $request->waktu);
        array_push($array_waktu, $request->waktu);

        $cari_kode_sama = DB::table('tarif_cabang_sepeda')
                            ->max('kode_sama_sepeda');
        if ($cari_kode_sama == null) {
            $cari_kode_sama = 1;
        }else{
            $cari_kode_sama += 1;
        }
        // return $array_waktu;
       


        // return $array_harga;

        if ($crud  == 'N') {

            for ($i=0; $i < count($cari); $i++) { 
                $cari_old0[$i] = DB::table('tarif_cabang_sepeda')
                          ->where('id_kota_asal',$request->cb_kota_asal)
                          ->where('id_kota_tujuan',$cari[$i]->id)
                          ->where('kode_cabang',$request->ed_cabang)
                          ->where('jenis','sepeda_pancal')
                          ->get();

                $cari_old1[$i] = DB::table('tarif_cabang_sepeda')
                          ->where('id_kota_asal',$request->cb_kota_asal)
                          ->where('id_kota_tujuan',$cari[$i]->id)
                          ->where('kode_cabang',$request->ed_cabang)
                          ->where('jenis','bebek_matik')
                          ->get();

                $cari_old2[$i] = DB::table('tarif_cabang_sepeda')
                          ->where('id_kota_asal',$request->cb_kota_asal)
                          ->where('id_kota_tujuan',$cari[$i]->id)
                          ->where('kode_cabang',$request->ed_cabang)
                          ->where('jenis','laki_sport')
                          ->get();

                $cari_old3[$i] = DB::table('tarif_cabang_sepeda')
                          ->where('id_kota_asal',$request->cb_kota_asal)
                          ->where('id_kota_tujuan',$cari[$i]->id)
                          ->where('kode_cabang',$request->ed_cabang)
                          ->where('jenis','moge')
                          ->get();
            }
            // return $cari_old1;
            $cari_nota0 = DB::select("SELECT  substring(max(kode),11) as id from tarif_cabang_sepeda
                                                WHERE kode_cabang = '$request->ed_cabang' 
                                                and jenis = 'sepeda_pancal'");
            $cari_nota1 = DB::select("SELECT  substring(max(kode),11) as id from tarif_cabang_sepeda
                                                WHERE kode_cabang = '$request->ed_cabang'
                                                and jenis = 'bebek_matik'");
            $cari_nota2 = DB::select("SELECT  substring(max(kode),11) as id from tarif_cabang_sepeda
                                                WHERE kode_cabang = '$request->ed_cabang'
                                                and jenis = 'laki_sport'");
            $cari_nota3 = DB::select("SELECT  substring(max(kode),11) as id from tarif_cabang_sepeda
                                                WHERE kode_cabang = '$request->ed_cabang'
                                                and jenis = 'moge'");
            // return $cari_nota2;
            $id0 = (integer)$cari_nota0[0]->id+1;
            $id1 = (integer)$cari_nota1[0]->id+1;
            $id2 = (integer)$cari_nota2[0]->id+1;
            $id3 = (integer)$cari_nota3[0]->id+1;

            // return [$id0,$id1,$id2,$id3];
            // return $request->ed_cabang;
            for ($i=0; $i < count($cari); $i++) { 
                for ($a=0; $a < count($array_harga); $a++) { 
                    
                    $index = $id0;
                    $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                    $nota0[$i] = $kodekota . '/' .  'SPD' .$request->ed_cabang .  $index;

                    $index = $id1;
                    $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                    $nota1[$i] = $kodekota . '/' .  'MTK' .$request->ed_cabang .  $index;

                    $index = $id2;
                    $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                    $nota2[$i] = $kodekota . '/' .  'SPT' .$request->ed_cabang .  $index;

                    $index = $id3;
                    $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                    $nota3[$i] = $kodekota . '/' .  'MGE' .$request->ed_cabang .  $index;
                    
                }
                $id0++;
                $id1++;
                $id2++;
                $id3++;
               
            }
            $array_note = [$nota0,$nota1,$nota2,$nota3];
            // return $array_note;

            for ($i=0; $i < count($cari); $i++) { 

                
                for ($a=0; $a < count($array_harga); $a++) { 
                    $kode_detail = DB::table('tarif_cabang_sepeda')
                            ->max('kode_detail_sepeda');
                    if ($kode_detail == null) {
                        $kode_detail = 1;
                    }else{
                        $kode_detail += 1;
                    }
                    // return $array_waktu;
                    // return $cari_old1;
                    // return ${'cari_old'.$a}[$i][0];

                        
                            if (isset(${'cari_old'.$a}[$i][0]->id_kota_asal) != $request->cb_kota_asal and
                                isset(${'cari_old'.$a}[$i][0]->id_kota_tujuan) != $cari[$i]->id and
                                isset(${'cari_old'.$a}[$i][0]->kode_cabang) != $request->ed_cabang ) {

                                    $data = DB::table('tarif_cabang_sepeda')
                                    ->insert([
                                            'kode_sama_sepeda' => $cari_kode_sama,
                                            'kode_detail_sepeda'=>$kode_detail,
                                            'kode'=>$array_note[$a][$i],
                                            'id_kota_asal' => $request->cb_kota_asal,
                                            'id_kota_tujuan' => $cari[$i]->id,
                                            'kode_cabang' => $request->ed_cabang,
                                            'jenis' => $array_jenis[$a],
                                            'harga' => $array_harga[$a],
                                            'waktu' => $array_waktu[$a],
                                            'acc_penjualan'=>$request->ed_acc_penjualan,
                                            'csf_penjualan'=>$request->ed_csf_penjualan,
                                            'id_provinsi_cabsepeda'=>$request->cb_provinsi_tujuan,
                                            'crud'=>$crud,
                                  ]);
                            }else{
                                if (${'cari_old'.$a}[$i][0]->crud != 'E') {
                                    $data = DB::table('tarif_cabang_sepeda')
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

            }
            return response()->json(['status'=>1]);
        }else if($crud == 'E'){
          
            
           

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
                        'id_provinsi_cabsepeda'=>$prov,
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
                        'id_provinsi_cabsepeda'=>$prov,
                    );
                     $sport = array(
                        'kode_sama_sepeda' => $request->ed_kode_old,
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
                        'id_provinsi_cabsepeda'=>$prov,
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
                        'id_provinsi_cabsepeda'=>$prov,
                    );
            $simpan = DB::table('tarif_cabang_sepeda')->where('kode', $request->id_moge)->update($moge);
            }else if($request->moge == null || $request->moge == ''){ 
                
            }

            $simpan = DB::table('tarif_cabang_sepeda')->where('kode', $request->id_matik)->update($matik);
            $simpan = DB::table('tarif_cabang_sepeda')->where('kode', $request->id_sepeda)->update($sepedah);
            $simpan = DB::table('tarif_cabang_sepeda')->where('kode', $request->id_sport)->update($sport);
            echo json_encode('sukses');


        }
        
    
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
