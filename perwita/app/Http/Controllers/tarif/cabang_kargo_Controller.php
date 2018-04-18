<?php

namespace App\Http\Controllers\tarif;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;
use Carbon\carbon;
class cabang_kargo_Controller extends Controller
{
    public function table_data () {
        $sql = "    SELECT t.kode_provinsi,jj.jt_nama_tarif tarifnama,k.kode_kota,t.kode,p.nama provinsi, t.kode_detail_kargo,t.id_kota_asal, k.nama asal,t.id_kota_tujuan, kk.nama tujuan, t.harga, t.jenis, t.waktu, t.kode_angkutan, a.nama AS angkutan 
                    FROM tarif_cabang_kargo t
                    LEFT JOIN kota k ON k.id=t.id_kota_asal 
                    LEFT JOIN kota kk ON kk.id=t.id_kota_tujuan 
                    LEFT JOIN tipe_angkutan a ON a.kode=t.kode_angkutan
                    LEFT JOIN jenis_tarif jj ON jj.jt_id=t.jenis
                    LEFT JOIN provinsi p ON p.id=t.kode_provinsi
                    ORDER BY  t.kode_detail_kargo DEsC";
        
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['id_kota_asal'].'" name="'.$data[$i]['kode_provinsi'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                        <button type="button" id="'.$data[$i]['id_kota_asal'].'" name="'.$data[$i]['id_kota_tujuan'].'" data-asal="'.$data[$i]['asal'].'" data-tujuan="'.$data[$i]['tujuan'].'" data-toggle="tooltip" style="color:white;" title="Delete" class="btn btn-purple btn-xs btndelete_perkota" ><i class="glyphicon glyphicon-trash"></i></button> 

                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('id');
         $sql = "    SELECT t.*,p.id as prov,t.kode_cabang,t.kode_angkutan,k.kode_kota,t.kode, t.kode_detail_kargo,t.id_kota_asal, k.nama asal,t.id_kota_tujuan, kk.nama tujuan, t.harga, t.jenis, t.waktu, t.kode_angkutan, a.nama AS angkutan 
                    FROM tarif_cabang_kargo t
                    LEFT JOIN kota k ON k.id=t.id_kota_asal 
                    LEFT JOIN kota kk ON kk.id=t.id_kota_tujuan 
                    LEFT JOIN angkutan a ON a.kode=t.kode_angkutan
                    LEFT JOIN provinsi p ON p.id=t.kode_provinsi
                    LEFT JOIN jenis_tarif jj ON jj.jt_id=t.jenis
                    where t.kode = '$id'
                    ORDER BY  t.kode_detail_kargo DEsC";
        
        $data = DB::select(DB::raw($sql));
        // $data = DB::table('tarif_cabang_kargo')->where('kode', $id)->first();
        echo json_encode($data);
    }

     public function save_data (Request $request) {
        // dd($request->all());
        $simpan='';
        if ($request->cb_provinsi_tujuan != '') {
             $cari = DB::table('kota')  
                  ->where('id_provinsi',$request->cb_provinsi_tujuan)
                  ->get();
        }else{

        }
        
        // return $cari;
        $crud = $request->crud;
        

        $kodekota = $request->kodekota;
        $kodecabang = Auth::user()->kode_cabang;

        $array_harga = [];
        $array_waktu = [];
        $array_nota  = ['KGO'];
        $array_note  = [];

        if ($request->harga_outlet == '' or null) {
            $request->harga_outlet = 0;
        }

        array_push($array_harga, $request->ed_harga);
        array_push($array_waktu, $request->ed_waktu);


        // return $array_waktu;
       


        // return $array_harga;

        if ($crud  == 'N') {
            if ($request->cb_provinsi_tujuan != '') {
                for ($i=0; $i < count($cari); $i++) { 
                    $cari_old0[$i] = DB::table('tarif_cabang_kargo')
                              ->where('id_kota_asal',$request->cb_kota_asal)
                              ->where('id_kota_tujuan',$cari[$i]->id)
                              ->where('kode_cabang',$request->ed_cabang)
                              ->where('jenis',$request->cb_jenis)
                              ->where('kode_angkutan',$request->cb_angkutan)
                              ->get();
                }
                // return $cari_old1;
                $cari_nota0 = DB::select("SELECT  substring(max(kode),11) as id from tarif_cabang_kargo
                                                    WHERE kode_cabang = '$request->ed_cabang' 
                                                    and jenis = $request->cb_jenis");
                // return $cari_nota2;
                $id0 = (integer)$cari_nota0[0]->id+1;   

                 
                    for ($i=0; $i < count($cari); $i++) { 
                        for ($a=0; $a < count($array_harga); $a++) { 
                            
                            $index = $id0;
                            $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                            $nota0[$i] = $kodekota . '/' .  'KGO' .$request->ed_cabang .  $index;
                            
                        }
                        $id0++;
                       
                    }
                $array_note = [$nota0]; 
                 
            }else{
                $cari_kode = DB::table('tarif_cabang_kargo')
                              ->where('id_kota_asal',$request->cb_kota_asal)
                              ->where('id_kota_tujuan',$request->cb_kota_tujuan)
                              ->where('kode_cabang',$request->ed_cabang)
                              ->where('kode_angkutan',$request->cb_angkutan)
                              ->get();
            }
            
            if ($request->cb_provinsi_tujuan != '') {
            for ($i=0; $i < count($cari); $i++) { 
                for ($a=0; $a < count($array_harga); $a++) { 
                    $kode_detail = DB::table('tarif_cabang_kargo')
                            ->max('kode_detail_kargo');
                    if ($kode_detail == null) {
                        $kode_detail = 1;
                    }else{
                        $kode_detail += 1;
                    }
                            if (isset(${'cari_old'.$a}[$i][0]->id_kota_asal) != $request->cb_kota_asal and
                                isset(${'cari_old'.$a}[$i][0]->id_kota_tujuan) != $cari[$i]->id and
                                isset(${'cari_old'.$a}[$i][0]->kode_cabang) != $request->ed_cabang and
                                isset(${'cari_old'.$a}[$i][0]->kode_angkutan) != $request->cb_angkutan ) {

                                    $data = DB::table('tarif_cabang_kargo')
                                    ->insert([
                                            'kode_detail_kargo'=>$kode_detail,
                                            'kode'=>$array_note[$a][$i],
                                            'id_kota_asal' => $request->cb_kota_asal,
                                            'id_kota_tujuan' => $cari[$i]->id,
                                            'kode_cabang' => $request->ed_cabang,
                                            'jenis' => $request->cb_jenis,
                                            'harga' => $array_harga[$a],
                                            'waktu' => $array_waktu[$a],
                                            'acc_penjualan'=>$request->ed_acc_penjualan,
                                            'csf_penjualan'=>$request->ed_csf_penjualan,
                                            'kode_provinsi'=>$request->cb_provinsi_tujuan,
                                            'crud'=>$crud,
                                            'create_at'=>carbon::now(),
                                            'create_by'=>Auth::user()->m_username,
                                            'kode_satuan' => $request->satuan,
                                            'kode_angkutan' => $request->cb_angkutan,

                                  ]);
                            }else{
                                // if (${'cari_old'.$a}[$i][0]->crud != 'E') {
                                //     $data = DB::table('tarif_cabang_kargo')
                                //     ->where('kode',${'cari_old'.$a}[$i][0]->kode)
                                //     ->update([
                                //             'kode_cabang' => $request->ed_cabang,
                                //             'jenis' => $request->cb_jenis,
                                //             'harga' => $array_harga[$a],
                                //             'waktu' => $array_waktu[$a],
                                //             'acc_penjualan'=>$request->ed_acc_penjualan,
                                //             'csf_penjualan'=>$request->ed_csf_penjualan,
                                //             'crud'=>'N',
                                //     ]);
                                // }
                                $data = FALSE;
                                $crud = 'Data Tersebut Telah Ada';
                                $result['crud']=$crud;
                                echo json_encode($result);
                                    
                            }
                        }
                }

            }else{
                    if (isset($cari_kode[0]->id_kota_asal) != $request->cb_kota_asal  and
                        isset($cari_kode[0]->id_kota_tujuan) != $request->cb_kota_tujuan and
                        isset($cari_kode[0]->kode_cabang) != $request->ed_cabang and 
                        isset($cari_kode[0]->kode_angkutan) != $request->cb_angkutan) {

                        $kode_detailis = DB::table('tarif_cabang_kargo')
                            ->max('kode_detail_kargo');
                                if ($kode_detailis == null) {
                                    $kode_detailis = 1;
                                }else{
                                    $kode_detailis += 1;
                                }
                        
                        $index = $kode_detailis;
                        $index = str_pad($index, 5, '0', STR_PAD_LEFT);
                        $kodeutama = $kodekota . '/' .  'KGO' .$request->ed_cabang  .  $index;
                        $provinsi = DB::table('kota')->where('id','=',$request->cb_kota_tujuan)->get();

                        if ($crud == 'N') {
                            $simpan = array(
                                'kode' => $kodeutama,
                                'id_kota_asal' => $request->cb_kota_asal,
                                'id_kota_tujuan' => $request->cb_kota_tujuan,
                                'jenis' => $request->cb_jenis,
                                'kode_satuan' => $request->satuan,
                                'kode_angkutan' => $request->cb_angkutan,
                                'kode_detail_kargo' => $kode_detailis,
                                'harga' => filter_var($request->ed_harga, FILTER_SANITIZE_NUMBER_INT),
                                'waktu' => filter_var($request->ed_waktu, FILTER_SANITIZE_NUMBER_INT),
                                'acc_penjualan' => $request->ed_acc_penjualan,
                                'csf_penjualan'=>$request->ed_csf_penjualan,
                                'create_at'=>carbon::now(),
                                'kode_provinsi'=>$provinsi[0]->id_provinsi,
                                'create_by'=>Auth::user()->m_username,
                                'kode_cabang'=>$request->ed_cabang,
                                'crud'=>'N',
                            );
                            $data = DB::table('tarif_cabang_kargo')->insert($simpan);
                        }
                    }else{

                        // return $request->cb_angkutan;
                        // if ($crud == 'N') {
                        //     $simpan = array(
                        //         'jenis' => $request->cb_jenis,
                        //         'kode_satuan' => $request->satuan,
                        //         'kode_angkutan' => $request->cb_angkutan,
                        //         'harga' => filter_var($request->ed_harga, FILTER_SANITIZE_NUMBER_INT),
                        //         'waktu' => filter_var($request->ed_waktu, FILTER_SANITIZE_NUMBER_INT),
                        //         'acc_penjualan' => $request->ed_acc_penjualan,
                        //         'csf_penjualan'=>$request->ed_csf_penjualan,
                        //  );
                        // $data = DB::table('tarif_cabang_kargo')->where('kode','=',$cari_kode[0]->kode)->update($simpan);
                        // }
                        // $data = FALSE;
                        // $crud = 'Data Tersebut Telah Ada';
                        //         $result['crud']=$crud;
                        //         echo json_encode($result);
                        $data = FALSE;
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
                                            
                       $provinsi = DB::table('kota')->where('id','=',$request->cb_kota_tujuan)->get();
                       
                       $simpan = array(
                                'kode' => $request->ed_kode_lama,
                                'id_kota_asal' => $request->cb_kota_asal,
                                'id_kota_tujuan' => $request->cb_kota_tujuan,
                                'jenis' => $request->cb_jenis,
                                'kode_satuan' => $request->satuan,
                                'kode_angkutan' => $request->cb_angkutan,
                                'kode_detail_kargo' => $request->ed_kode_old,
                                'harga' => filter_var($request->ed_harga, FILTER_SANITIZE_NUMBER_INT),
                                'waktu' => filter_var($request->ed_waktu, FILTER_SANITIZE_NUMBER_INT),
                                'acc_penjualan' => $request->ed_acc_penjualan,
                                'csf_penjualan'=>$request->ed_csf_penjualan,
                                'update_at'=>carbon::now(),
                                'kode_provinsi'=>$provinsi[0]->id_provinsi,
                                'update_by'=>Auth::user()->m_username,
                                'kode_cabang'=>$request->ed_cabang,
                                'crud'=>'E',
                            );
                            $data = DB::table('tarif_cabang_kargo')->where('kode','=',$request->ed_kode_lama)->update($simpan);


             if($data == TRUE){
            $result['error']='';
            $result['result']=1;
            }else{
                $result['error']=$data;
                $result['result']=0;
            }
            $result['crud']=$crud;
            echo json_encode($result);
        }

        
    
    }

    public function hapus_data (Request $request) {
        // dd($request->all());
        $hapus='';
        $asal=$request->id;
        $tujuan=$request->name;
        $hapus = DB::table('tarif_cabang_kargo')->where('kode_provinsi','=',$tujuan)->where('crud','!=','E')->delete();
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
        $hapus = DB::table('tarif_cabang_kargo')->where('id_kota_asal' ,'=', $asal)->where('id_kota_tujuan','=',$tujuan)->delete();
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
        $angkutan = DB::select(DB::raw(" SELECT kode,nama FROM tipe_angkutan ORDER BY nama ASC "));
        $satuan = DB::select(DB::raw(" SELECT kode,nama FROM satuan ORDER BY nama ASC "));
        $jenis_tarif = DB::table('jenis_tarif')
                         ->where('jt_group',1)
                         ->orWhere('jt_group',3)
                         ->get();
         $prov = DB::select(DB::raw("SELECT p.id,k.id_provinsi,p.nama FROM kota as k left join  provinsi as p on p.id =k.id_provinsi group by p.id,k.id_provinsi order by p.id"));
        $cabang_default = DB::select(DB::raw(" SELECT kode,nama FROM cabang ORDER BY kode ASC "));

        $accpenjualan = DB::select(DB::raw(" SELECT id_akun,nama_akun FROM d_akun ORDER BY id_akun ASC "));
        $csfpenjualan = DB::select(DB::raw(" SELECT id_akun,nama_akun FROM d_akun ORDER BY id_akun ASC "));
        return view('tarif.cabang_kargo.index',compact('kota','angkutan','jenis_tarif','satuan','accpenjualan','csfpenjualan','prov','cabang_default'));
    }

}
