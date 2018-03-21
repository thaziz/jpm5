<?php

namespace App\Http\Controllers\tarif;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;

class cabang_dokumen_Controller extends Controller
{
    public function table_data () {
        $sql = "    SELECT t.kode_detail,t.acc_penjualan,t.csf_penjualan,t.kode_sama,t.kode, t.id_kota_asal,k.kode_kota, k.nama asal,t.id_kota_tujuan, kk.nama tujuan, t.harga, t.jenis, t.waktu, t.tipe  
                    FROM tarif_cabang_dokumen t
                    LEFT JOIN kota k ON k.id=t.id_kota_asal 
                    LEFT JOIN kota kk ON kk.id=t.id_kota_tujuan 
                    ORDER BY t.kode_detail DESC ";
        
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['kode_sama'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['kode_sama'].'" name="'.$data[$i]['kode_sama'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        
        $id =$request->input('id');
        $data = DB::table('tarif_cabang_dokumen')->where('kode_sama', $id)->orderBy('kode_detail','ASC')->get();

        
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        // dd($request);
        $simpan='';
        $crud = $request->crud;
        $kode_sama = DB::table('tarif_cabang_dokumen')->select('kode_sama')->max('kode_sama');    
        if ($kode_sama == '') {
            $kode_sama = 1;
        }else{
            $kode_sama += 1;
        }
        $kode_utama = DB::table('tarif_cabang_dokumen')->select('kode_sama')->max('kode_sama');    
        if ($kode_utama == '') {
            $kode_utama = 1;
        }else{
            $kode_utama += 1;
        }
         $kode_detail = DB::table('tarif_cabang_dokumen')->select('kode_detail')->max('kode_detail');
         $datadetail = DB::table('tarif_cabang_dokumen')->select('kode_detail')->get();  
               $datadetailcount = count($datadetail);
         for ($i=0; $i <count($datadetail) ; $i++) {  
            if ($datadetail == null) {
                $datadetailcount;
            }else{
                $kode_detailtambah1 = $datadetail[$i]->kode_detail;
            }
            $kode_detailtambah1+1;  
         }
        if ($kode_detail == '') {
            $kode_detail = 1;
        }else{
            $kode_detail += 1;
        }
        if ($kode_utama < 10000 ) {
            $kode_utama = '0000'.$kode_utama;
        }
        $kodekota = $request->kodekota;
        $kodecabang = Auth::user()->kode_cabang;

        $kode_reguler = $kodekota.'/'.'D'.'R'.$kodecabang.$kode_utama;
        $kode_express = $kodekota.'/'.'D'.'E'.$kodecabang.$kode_utama;
        $kode_outlet = $kodekota.'/'.'D'.'O'.$kodecabang.$kode_utama;

        
        if ($crud == 'N') {

            $regular = array(
                'kode_sama' => $kode_sama,
                'kode_detail'=>$kode_detail,
                'kode'=>$kode_reguler,
                'id_kota_asal' => $request->cb_kota_asal,
                'id_kota_tujuan' => $request->cb_kota_tujuan,
                'kode_cabang' => $request->ed_cabang,
                'jenis' => 'REGULER',
                'harga' => $request->harga_regular,
                'waktu' => $request->waktu_regular,
                'acc_penjualan'=>$request->ed_acc_penjualan,
                'csf_penjualan'=>$request->ed_csf_penjualan,
            );
                if ($datadetailcount == 0) {
                    $kode_detail += 1;
                }
                else if ($kode_detailtambah1 == $kode_detailtambah1) {
                    $kode_detail += 1;
                }
                $express = array(
                        'kode_sama' => $kode_sama,
                        'kode_detail'=>$kode_detail,
                        'kode'=>$kode_express,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'EXPRESS',
                        'harga' => $request->harga_express,
                        'waktu' => $request->waktu_express,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                    );
                if ($datadetailcount == 0) {
                    $kode_detail += 1;
                }
                else if ($kode_detailtambah1 == $kode_detailtambah1) {
                    $kode_detail += 1;
                }
                if ($request->harga_outlet != null) {
                     $outlet = array(
                        'kode_sama' => $kode_sama,
                        'kode_detail'=>$kode_detail,
                        'kode'=>$kode_outlet,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'OUTLET',
                        'harga' => $request->harga_outlet,
                        'waktu' => null,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                    );
                $simpan = DB::table('tarif_cabang_dokumen')->insert($outlet);
                }else{

                }
               
            $simpan = DB::table('tarif_cabang_dokumen')->insert($regular);
            $simpan = DB::table('tarif_cabang_dokumen')->insert($express);
            

        }elseif ($crud == 'E') {

                $regular = array(
                        'kode_sama' => $request->ed_kode_old,
                        // 'kode_detail'=>$request->id_kode_detail,
                        'kode'=>$request->id_reguler,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'jenis' => 'REGULER',
                        'kode_cabang' => $request->ed_cabang,      
                        'harga' => $request->harga_regular,
                        'waktu' => $request->waktu_regular,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                   );
                   
                // return $regular;
                $express = array(
                        'kode_sama' => $request->ed_kode_old,
                        // 'kode_detail'=>$request->id_kode_detail,
                        'kode'=>$request->id_express,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang, 
                        'jenis' => 'EXPRESS',
                        'harga' => $request->harga_express,
                        'waktu' => $request->waktu_express,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                    );
               

                $outlet = array(
                        'kode_sama' => $request->ed_kode_old,
                        // 'kode_detail'=>$request->id_kode_detail,
                        'kode'=>$request->id_outlet,
                        'id_kota_asal' => $request->cb_kota_asal,
                        'id_kota_tujuan' => $request->cb_kota_tujuan,
                        'kode_cabang' => $request->ed_cabang,
                        'jenis' => 'OUTLET',
                        'harga' => $request->harga_outlet,
                        'waktu' => null,
                        'acc_penjualan'=>$request->ed_acc_penjualan,
                        'csf_penjualan'=>$request->ed_csf_penjualan,
                    );

            $simpan = DB::table('tarif_cabang_dokumen')->where('kode', $request->id_reguler)->update($regular);
            $simpan = DB::table('tarif_cabang_dokumen')->where('kode', $request->id_express)->update($express);
            $simpan = DB::table('tarif_cabang_dokumen')->where('kode', $request->id_outlet)->update($outlet);
        }
        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            $result['error']='error';
            $result['result']=0;
        }
        $result['crud']=$crud;
        echo json_encode($result);
    }
    public function hapus_data (Request $request) {
        $hapus='';
        $id=$request->id;
        $hapus = DB::table('tarif_cabang_dokumen')->where('kode_sama' ,'=', $id)->delete();
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
        

        return view('tarif.cabang_dokumen.index',compact('kota','cabang_default','accpenjualan','csfpenjualan'));
    }

}
