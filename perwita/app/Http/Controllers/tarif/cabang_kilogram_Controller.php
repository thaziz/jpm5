<?php

namespace App\Http\Controllers\tarif;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;
use carbon\carbon;
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
        // dd($request->all());
        $simpan='';
        $cari = DB::table('kota')  
                  ->where('id_provinsi',$request->cb_provinsi_tujuan)
                  ->get();

        $crud = $request->crud;
        

        $kodekota = $request->kodekota;
        $kodecabang = Auth::user()->kode_cabang;

        $array_harga = [];
        $array_jenis = ['REGULER','EXPRESS'];
        $array_keterangan  = ['Tarif Kertas / Kg','Tarif <= 10 Kg','Tarif Kg selanjutnya <= 10 Kg','Tarif <= 20 Kg','Tarif Kg selanjutnya <= 20 Kg','Tarif Kertas / Kg','Tarif <= 10 Kg','Tarif Kg selanjutnya <= 10 Kg','Tarif <= 20 Kg','Tarif Kg selanjutnya <= 20 Kg'];
        $array_waktu = [];
        $array_nota  = ['KGR','KGE'];
        $array_note  = [];


        if ($request->harga_outlet == '' or null) {
            $request->harga_outlet = 0;
        }

        array_push($array_harga, $request->tarifkertas_reguler);
        array_push($array_harga, $request->tarif0kg_reguler);
        array_push($array_harga, $request->tarif10kg_reguler);
        array_push($array_harga, $request->tarif20kg_reguler);
        array_push($array_harga, $request->tarifkgsel_reguler);

        array_push($array_harga, $request->tarifkertas_express);
        array_push($array_harga, $request->tarif0kg_express);
        array_push($array_harga, $request->tarif10kg_express);
        array_push($array_harga, $request->tarif20kg_express);
        array_push($array_harga, $request->tarifkgsel_express);

        array_push($array_waktu, $request->waktu_regular);
        array_push($array_waktu, $request->waktu_regular);
        array_push($array_waktu, $request->waktu_regular);
        array_push($array_waktu, $request->waktu_regular);
        array_push($array_waktu, $request->waktu_regular);

        array_push($array_waktu, $request->waktu_express);
        array_push($array_waktu, $request->waktu_express);
        array_push($array_waktu, $request->waktu_express);
        array_push($array_waktu, $request->waktu_express);
        array_push($array_waktu, $request->waktu_express);

        $cari_kode_sama = DB::table('tarif_cabang_kilogram')
                            ->max('kode_sama_kilo');
        if ($cari_kode_sama == null) {
            $cari_kode_sama = 1;
        }else{
            $cari_kode_sama += 1;
        }

        


        // return $array_keterangan;

        if ($crud  == 'N') {

            for ($i=0; $i < count($cari); $i++) { 
                $cari_old0[$i] = DB::table('tarif_cabang_kilogram')
                          ->where('id_kota_asal',$request->cb_kota_asal)
                          ->where('id_kota_tujuan',$cari[$i]->id)
                          ->where('kode_cabang',$request->cb_cabang)
                          ->where('jenis','REGULER')
                          ->get();

                $cari_old1[$i] = DB::table('tarif_cabang_kilogram')
                          ->where('id_kota_asal',$request->cb_kota_asal)
                          ->where('id_kota_tujuan',$cari[$i]->id)
                          ->where('kode_cabang',$request->cb_cabang)
                          ->where('jenis','EXPRESS')
                          ->get();
            }

            $cari_nota0 = DB::select("SELECT  substring(max(kode),10) as id from tarif_cabang_kilogram
                                                WHERE kode_cabang = '$request->cb_cabang'
                                                and jenis = 'REGULER'
                                                ");
            // return $cari_nota0;
            $cari_nota1 = DB::select("SELECT  substring(max(kode),10) as id from tarif_cabang_kilogram
                                                WHERE kode_cabang = '$request->cb_cabang'
                                                and jenis = 'EXPRESS'
                                                ");
            $kode_utama = DB::table('tarif_cabang_kilogram')->select('kode_detail_kilo')->max('kode_detail_kilo');
            
            // $id2 = (integer)$cari_nota1[0]->id+1;
            // $id2 = (integer)$cari_nota1[0]->id+1;
            // $id2 = (integer)$cari_nota1[0]->id+1;
            // $id2 = (integer)$cari_nota1[0]->id+1;
            // $id2 = (integer)$cari_nota1[0]->id+1;
            // $id2 = (integer)$cari_nota1[0]->id+1;
            // $id2 = (integer)$cari_nota1[0]->id+1;
            // return $id0;
            // return $cari;
            $b=0;
            $s=[];
            // return $array_harga;
                for ($i=0; $i <count($cari) ; $i++) { 
           
                     for ($a=0; $a < count($array_harga); $a++) { 

                        $bulan = Carbon::now()->format('m');
                         $tahun = Carbon::now()->format('y');
                         $cabang= Auth::user()->kode_cabang;
                         $cari_nota = DB::select("SELECT  substring(max(kode),11) as id from tarif_cabang_kilogram
                                                        WHERE kode_cabang = '$cabang'
                                                        AND jenis='REGULER'");
                        return $index = (integer)$cari_nota[0]->id +;
                         $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                         $nota = 'KGR' . Auth::user()->kode_cabang . $bulan . $tahun . $index;

                         array_push($s, $nota);
                    }    
                }
                return $s;

                // return $kode_utama;
                for ($r=0; $r <count($kode_utama) ; $r++) { 
                 $kode_utama = (int)$kode_utama+1;
                $index = $kode_utama;
                $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                $nota0[$r] = $kodekota . '/' .  $array_nota[0] .$request->cb_cabang .  $index;
            }
            // return $kode_utama;

              
            
            $array_note = [$nota0];
            return $array_note; 
            for ($i=0; $i < count($cari); $i++) { 

                
                for ($a=0; $a < count($array_harga); $a++) { 


                    return [$array_note,$array_jenis,$array_harga,$array_waktu,$array_keterangan];

                    $kode_detail = DB::table('tarif_cabang_kilogram')
                            ->max('kode_detail_kilo');
                    if ($kode_detail == null) {
                        $kode_detail = 1;
                    }else{
                        $kode_detail += 1;
                    }
                    // return $cari[$i]->id;
                    // return $array_note[$a][$i];
                       
                            if (isset(${'cari_old'.$a}[$i][0]->id_kota_asal) != $request->cb_kota_asal and
                                isset(${'cari_old'.$a}[$i][0]->id_kota_tujuan) != $cari[$i]->id and
                                isset(${'cari_old'.$a}[$i][0]->kode_cabang) != $request->cb_cabang ) {

                                    $data = DB::table('tarif_cabang_kilogram')
                                    ->insert([
                                            'kode'=>$array_note[$a][$i],
                                            'kode_sama_kilo' => $cari_kode_sama,
                                            'kode_detail_kilo'=>$kode_detail,
                                            'id_kota_asal' => $request->cb_kota_asal,
                                            'id_kota_tujuan' => $cari[$i]->id,
                                            'kode_cabang' => $request->cb_cabang,
                                            'keterangan' => $array_keterangan[$a],
                                            'jenis' => $array_jenis[$a],
                                            'harga' => $array_harga[$a],
                                            'waktu' => $array_waktu[$a],
                                            'acc_penjualan'=>$request->cb_acc_penjualan,
                                            'csf_penjualan'=>$request->cb_csf_penjualan,
                                            'id_provinsi_cabkilogram'=>$request->cb_provinsi_tujuan,
                                            'crud'=>$crud,
                                  ]);
                                    // return $data;
                            }else{
                                if (isset(${'cari_old'.$a}[$i][0]->crud) != 'E') {
                                    $data = DB::table('tarif_cabang_kilogram')
                                    ->where('kode',isset(${'cari_old'.$a}[$i][0]->kode))
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
            $cari_reguler = DB::select("SELECT  substring(kode,10) as id from tarif_cabang_kilogram
                                                WHERE kode = '$request->id_reguler'");
            $cari_express = DB::select("SELECT  substring(kode,10) as id from tarif_cabang_kilogram
                                                WHERE kode = '$request->id_express'");
            $cari_outlet  = DB::select("SELECT  substring(kode,10) as id from tarif_cabang_kilogram
                                                WHERE kode = '$request->id_outlet'");

            
            $index = (integer)$cari_reguler[0]->id;
            $index = str_pad($index, 5, '0', STR_PAD_LEFT);
            $nota  = $kodekota . '/' . 'DR' .$request->cb_cabang .  $index;

            $index = (integer)$cari_express[0]->id;
            $index = str_pad($index, 5, '0', STR_PAD_LEFT);
            $nota1 = $kodekota . '/' . 'DE' .$request->cb_cabang .  $index;

            if ($cari_outlet != null) {
                 $index = (integer)$cari_outlet[0]->id;
                 $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                 $nota2 = $kodekota . '/' . 'DO' .$request->cb_cabang .  $index;

                 if ($nota2 != $request->id_outlet) {
                 $update_outlet = DB::table('tarif_cabang_kilogram')
                                ->where('kode',$request->id_outlet)
                                ->update([
                                    'kode'=>$nota2,
                                    'id_kota_asal' => $request->cb_kota_asal,
                                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                                    'kode_cabang' => $request->cb_cabang,
                                    'harga' => $request->harga_outlet,
                                    'waktu' => $request->waktu_outlet,
                                    'acc_penjualan'=>$request->ed_acc_penjualan,
                                    'csf_penjualan'=>$request->ed_csf_penjualan,
                                    'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                                    'crud'=>$crud,
                                ]);
                }else{
                     $update_outlet = DB::table('tarif_cabang_kilogram')
                                    ->where('kode',$request->id_outlet)
                                    ->update([
                                        'id_kota_asal' => $request->cb_kota_asal,
                                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                                        'kode_cabang' => $request->cb_cabang,
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
                $update_reguler = DB::table('tarif_cabang_kilogram')
                                ->where('kode',$request->id_reguler)
                                ->update([
                                    'kode'=>$nota,
                                    'id_kota_asal' => $request->cb_kota_asal,
                                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                                    'kode_cabang' => $request->cb_cabang,
                                    'harga' => $request->harga_regular,
                                    'waktu' => $request->waktu_regular,
                                    'acc_penjualan'=>$request->ed_acc_penjualan,
                                    'csf_penjualan'=>$request->ed_csf_penjualan,
                                    'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                                    'crud'=>$crud,
                                ]);
            }else{
                $update_reguler = DB::table('tarif_cabang_kilogram')
                                ->where('kode',$request->id_reguler)
                                ->update([
                                    'id_kota_asal' => $request->cb_kota_asal,
                                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                                    'kode_cabang' => $request->cb_cabang,
                                    'harga' => $request->harga_regular,
                                    'waktu' => $request->waktu_regular,
                                    'acc_penjualan'=>$request->ed_acc_penjualan,
                                    'csf_penjualan'=>$request->ed_csf_penjualan,
                                    'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                                    'crud'=>$crud,
                                ]);
            }
            if ($nota1 != $request->id_express) {
                $update_express = DB::table('tarif_cabang_kilogram')
                                ->where('kode',$request->id_express)
                                ->update([
                                    'kode'=>$nota1,
                                    'id_kota_asal' => $request->cb_kota_asal,
                                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                                    'kode_cabang' => $request->cb_cabang,
                                    'harga' => $request->harga_express,
                                    'waktu' => $request->waktu_express,
                                    'acc_penjualan'=>$request->ed_acc_penjualan,
                                    'csf_penjualan'=>$request->ed_csf_penjualan,
                                    'id_provinsi_cabdokumen'=>$request->cb_provinsi_tujuan,
                                    'crud'=>$crud,
                                ]);
            }else{
                $update_express = DB::table('tarif_cabang_kilogram')
                                ->where('kode',$request->id_express)
                                ->update([
                                    'id_kota_asal' => $request->cb_kota_asal,
                                    'id_kota_tujuan' => $request->cb_kota_tujuan,
                                    'kode_cabang' => $request->cb_cabang,
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
