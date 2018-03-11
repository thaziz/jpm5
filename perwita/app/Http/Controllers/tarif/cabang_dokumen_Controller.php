<?php

namespace App\Http\Controllers\tarif;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class cabang_dokumen_Controller extends Controller
{
    public function table_data () {
        $sql = "    SELECT t.kode, t.id_kota_asal, k.nama asal,t.id_kota_tujuan, kk.nama tujuan, t.harga, t.jenis, t.waktu, t.tipe  
                    FROM tarif_cabang_dokumen t
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
                                        <button type="button" id="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['kode'].'" name="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('id');
        $data = DB::table('tarif_cabang_dokumen')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $simpan='';
        $crud = $request->crud;
        $data = array(
                'kode' => strtoupper($request->ed_kode),
                'id_kota_asal' => $request->cb_kota_asal,
                'id_kota_tujuan' => $request->cb_kota_tujuan,
                'kode_cabang' => $request->cb_cabang,
                'jenis' => $request->cb_jenis,
                'harga' => filter_var($request->ed_harga, FILTER_SANITIZE_NUMBER_INT),
                'waktu' => filter_var($request->ed_waktu, FILTER_SANITIZE_NUMBER_INT),
                'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
            );
        if ($crud == 'N') {
            //auto number
            if ($data['kode'] ==''){
                $kode_cabang = strtoupper($request->cb_cabang);
                $sql = "	SELECT CAST(MAX(SUBSTRING (kode FROM '....$')) AS INTEGER) + 1 nomor FROM tarif_cabang_dokumen";
                $list = collect(\DB::select($sql))->first();
                if ($list->nomor == ''){
                    $data['kode']='00001';
                } else{
                    $kode  = substr_replace('00000',$list->nomor,-strlen($list->nomor)); 
                    $data['kode']=$kode;
                }
            }
            // end auto number
            $simpan = DB::table('tarif_cabang_dokumen')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('tarif_cabang_dokumen')->where('kode', $request->ed_kode_old)->update($data);
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
        $hapus = DB::table('tarif_cabang_dokumen')->where('kode' ,'=', $id)->delete();
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
        $kota = DB::select(DB::raw(" SELECT id,nama FROM kota ORDER BY nama ASC "));
        $cabang = DB::select(DB::raw(" SELECT kode,nama FROM cabang ORDER BY nama ASC "));
        $akun= DB::select(DB::raw(" SELECT id_akun,nama_akun FROM d_akun ORDER BY id_akun ASC "));
        return view('tarif.cabang_dokumen.index',compact('kota','cabang','akun'));
    }

}
