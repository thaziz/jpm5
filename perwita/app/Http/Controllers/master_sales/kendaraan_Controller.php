<?php

namespace App\Http\Controllers\master_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class kendaraan_Controller extends Controller
{
    public function table_data_detail (Request $request) {
        $kendaraan = strtoupper($request->input('kode'));
        $sql = "   SELECT * FROM kendaraan_d WHERE kode_kendaraan='$kendaraan'  ";
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['id'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['id'].'" name="'.$data[$i]['kota'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('kode');
        $data = DB::table('kendaraan')->where('kode', $id)->first();
        echo json_encode($data);
    }
    
    public function get_data_detail (Request $request) {
        $id =$request->input('id');
        $data = DB::table('kendaraan_d')->where('id', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $simpan='';
        $id = $request->ed_id;
        $crud = $request->crud_h;
        $data = array(
                'nopol' => strtoupper($request->ed_nopol),
                'divisi' => strtoupper($request->cb_divisi),
                'status' => strtoupper($request->cb_status),
                'kode' => strtoupper($request->ed_kode),
                'merk' => strtoupper($request->ed_merk),
                'tipe_angkutan' => strtoupper($request->cb_tipe_angkutan),
                'no_rangka' => strtoupper($request->ed_no_rangka),
                'no_mesin' => strtoupper($request->ed_no_mesin),
                'jenis_bak' => strtoupper($request->ed_jenis_bak),
                'p' => filter_var($request->ed_panjang, FILTER_SANITIZE_NUMBER_INT),
                'l' => filter_var($request->ed_lebar, FILTER_SANITIZE_NUMBER_INT),
                't' => filter_var($request->ed_tinggi, FILTER_SANITIZE_NUMBER_INT),
                //'volume' => filter_var($request->ed_volume, FILTER_SANITIZE_NUMBER_INT),
                'tahun' => filter_var($request->ed_tahun_pembuatan, FILTER_SANITIZE_NUMBER_INT),
                'seri_unit' => strtoupper($request->ed_seri_unit),
                'warna_kabin' => strtoupper($request->ed_warna_kabin),
                'no_bpkb' => strtoupper($request->ed_no_bpkb),
                'tgl_bpkb' => strtoupper($request->ed_tgl_bpkb),
                'no_kir' => strtoupper($request->ed_no_kir),
                'tgl_kir' => strtoupper($request->ed_tgl_kir),
                'tgl_pajak' => strtoupper($request->ed_tgl_pajak_tahunan),
                'tgl_stnk' => strtoupper($request->ed_tgl_pajak_5_tahunan),
                'gps' => strtoupper($request->ed_gps),
                'posisi_bpkb' => strtoupper($request->ed_posisi_bpkb),
                'ket_bpkb' => strtoupper($request->ed_ket_bpkb),
                'asuransi' => strtoupper($request->ed_asuransi),
                'harga' => filter_var($request->ed_harga_perolehan, FILTER_SANITIZE_NUMBER_INT),
                'tgl_perolehan' => strtoupper($request->ed_tgl_perolehan),
                'keterangan' => strtoupper($request->ed_keterangan),
                'kode_cabang' => strtoupper($request->cb_cabang),
            );
        
        if ($crud == 'N') {
            $simpan = DB::table('kendaraan')->insert($data);
        } else {
            $simpan = DB::table('kendaraan')->where('id', $id)->update($data);
        }
        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
        }else{
            $result['error']=$simpan;
            $result['result']=0;
        }
        $result['crud']=$crud;
        echo json_encode($result);
    }

    public function hapus_data($id=null){
        DB::beginTransaction();
        DB::table('kendaraan')->where('id' ,'=', $id)->delete();
        DB::commit();
        return redirect('master_sales/kendaraan');
    }
    
    public function index(){
        $sql = "    SELECT k.id,k.nopol,t.nama tipe_angkutan,k.gps,k.kode_cabang, c.nama nama_cabang, k.status FROM kendaraan k
                    LEFT JOIN cabang c ON c.kode=k.kode_cabang
                    LEFT JOIN tipe_angkutan t ON t.kode=k.tipe_angkutan  ";
        $data =  DB::select($sql);
        return view('master_sales.kendaraan.index',compact('data'));
    }
    
    public function form($id=null){
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $tipe_angkutan =DB::select("SELECT kode,nama FROM tipe_angkutan");
        $subcon =DB::select("SELECT kode,nama FROM tipe_angkutan");
        if ($id != null) {
            $data = DB::table('kendaraan')->where('id', $id)->first();
        }else{
            $data = null;
        }
        return view('master_sales.kendaraan.form',compact('kota','data','cabang','tipe_angkutan','subcon' ));
    }

}
