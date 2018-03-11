<?php

namespace App\Http\Controllers\sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class surat_jalan_trayek_Controller extends Controller
{
    public function table_data_detail (Request $request) {
        $nomor = strtoupper($request->input('nomor'));
        $sql = "    SELECT sjd.*,d.tanggal,id_kota_tujuan, k.nama tujuan, d.alamat_penerima,d.type_kiriman FROM surat_jalan_trayek_d sjd,delivery_order d
                    LEFT JOIN kota k ON k.id=d.id_kota_tujuan  
                    WHERE  d.nomor=sjd.nomor_do AND sjd.nomor_surat_jalan_trayek='$nomor'  ";
        $list = DB::select(DB::raw($sql));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['id'].'" name="'.$data[$i]['nomor_do'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('kode');
        $data = DB::table('surat_jalan_trayek')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function get_data_detail (Request $request) {
        $id =$request->input('id');
        $data = DB::table('surat_jalan_trayek_d')->where('id', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $simpan='';
        $crud = $request->crud_h;
        $nomor_old = $request->ed_nomor_old;
        $data = array(
                'nomor' => strtoupper($request->ed_nomor),
                'tanggal' => strtoupper($request->ed_tanggal),
                'nama_rute' => strtoupper($request->ed_nama_rute),
                'keterangan' => strtoupper($request->ed_keterangan),
                'kode_cabang' => strtoupper($request->ed_cabang),
                'kode_rute' => strtoupper($request->ed_kode_rute),
                'id_kendaraan' => strtoupper($request->cb_nopol),
                'nopol' => strtoupper($request->ed_nopol),
                'sopir' => strtoupper($request->ed_sopir),
            );

        if ($crud == 'N' and $nomor_old =='') {
            //auto number
            if ($data['nomor'] ==''){
                $tanggal = strtoupper($request->ed_tanggal);
                $kode_cabang = strtoupper($request->ed_cabang);
                $tanggal = date_create($tanggal);
                $tanggal = date_format($tanggal,'ym');
                $sql = "	SELECT CAST(MAX(SUBSTRING (nomor FROM '....$')) AS INTEGER) + 1 nomor
                            FROM surat_jalan_trayek WHERE to_char(tanggal, 'YYMM')='$tanggal' AND kode_cabang='$kode_cabang' ";
                $list = collect(\DB::select($sql))->first();
                if ($list->nomor == ''){
                    //$data['nomor']='SJT-'.$kode_cabang.'-'.$tanggal.'-00001';
                    $data['nomor']='SJT'.$kode_cabang.$tanggal.'00001';
                } else{
                    $kode  = substr_replace('00000',$list->nomor,-strlen($list->nomor)); 
                    $data['nomor']='SJT'.$kode_cabang.$tanggal.$kode;
                }
            }
            // end auto number

           $simpan = DB::table('surat_jalan_trayek')->insert($data);

        } else {
            $simpan = DB::table('surat_jalan_trayek')->where('nomor', $nomor_old)->update($data);
        }
        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
            $result['nomor']=$data['nomor'];
        }else{
            $result['error']=$data;
            $result['result']=0;
        }
        $result['crud']=$crud;
        echo json_encode($result);
    }

    public function hapus_data($nomor_surat_jalan_trayek=null){
        DB::beginTransaction();
        DB::table('surat_jalan_trayek_d')->where('kode_surat_jalan_trayek' ,'=', $nomor_surat_jalan_trayek)->delete();
        DB::table('surat_jalan_trayek')->where('kode' ,'=', $nomor_surat_jalan_trayek)->delete();
        DB::commit();
        return redirect('sales/surat_jalan_trayek');
    }

    public function save_data_detail (Request $request) {
        $simpan='';
        $nomor = strtoupper($request->nomor);
        $hitung = count($request->nomor_do);
        for ($i=0; $i < $hitung; $i++) {
            $data = array(
                'nomor_surat_jalan_trayek' => $nomor,
                'nomor_do' => strtoupper($request->nomor_do[$i]),
            );
            $simpan = DB::table('surat_jalan_trayek_d')->insert($data);
            //DB::table('surat_jalan_trayek_d')->insert($data);
        } 
        $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM surat_jalan_trayek_d WHERE nomor_surat_jalan_trayek='$nomor' "))->first();
        $result['error']='';
        $result['result']=1;
        $result['jml_detail']=$jml_detail->jumlah;
        echo json_encode($result);
    }

    public function hapus_data_detail (Request $request) {
        $hapus='';
        $id=$request->id;
        $hapus = DB::table('surat_jalan_trayek_d')->where('id' ,'=', $id)->delete();
        $nomor = strtoupper($request->nomor);
        $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM surat_jalan_trayek_d WHERE nomor_surat_jalan_trayek='$nomor' "))->first();
        if($hapus == TRUE){
            $result['error']='';
            $result['result']=1;
            $result['jml_detail']=$jml_detail->jumlah;
        }else{
            $result['error']=$hapus;
            $result['result']=0;
        }
        echo json_encode($result);
    }

    public function index(){
        $sql = "    SELECT sj.*,c.nama cabang FROM surat_jalan_trayek sj
                    LEFT JOIN cabang c ON c.kode=sj.kode_cabang ";
        $data =  DB::select($sql);
        return view('sales.surat_jalan_trayek.index',compact('data'));
    }

    public function form($nomor=null){
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $rute = DB::select(" SELECT kode,nama FROM rute ORDER BY nama ASC ");
        $kendaraan = DB::select(" SELECT id,nopol FROM kendaraan ORDER BY nopol ASC ");
        if ($nomor != null) {
            $data = DB::table('surat_jalan_trayek')->where('nomor', $nomor)->first();
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM surat_jalan_trayek_d WHERE nomor_surat_jalan_trayek ='$nomor' "))->first();
        }else{
            $data = null;
            $jml_detail = 0;
        }
        return view('sales.surat_jalan_trayek.form',compact('kota','data','cabang','jml_detail','rute','kendaraan' ));
    }

    
    
    public function tampil_do(Request $request){
        $id = $request->rute;
        $kode_cabang=$request->kode_cabang;
        $rute = DB::table('rute_d')->where('kode_rute', $id)->select('id_kota');
        $jml_kota = $rute->count();
        $rute = $rute->get();
        $id_kota=1;
        $sql1='';
        $i=0;
        $union_all ="  UNION ALL ";
        foreach ($rute as $data) {
            $id_kota = $data->id_kota;
            $sql = "    SELECT d.nomor, d.tanggal, d.nama_pengirim, d.nama_penerima, k.nama asal, kk.nama tujuan, d.status, d.total_net,d.total
                        FROM delivery_order d
                        LEFT JOIN kota k ON k.id=d.id_kota_asal
                        LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
                        WHERE NOT EXISTS (SELECT * FROM surat_jalan_trayek_d sjd WHERE d.nomor=sjd.nomor_do )
                        AND d.id_kota_tujuan='$id_kota' AND d.kode_cabang='$kode_cabang' " ;
            $i++;
            if ($i==$jml_kota) {
                $union_all ="";
            }
            $sql1 =$sql1.$sql.$union_all ;
        }
        //dd($sql1);
        $list = DB::select(DB::raw($sql1));
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = '<input type="checkbox"  id="'.$data[$i]['nomor'].'" class="btnpilih" >';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function cetak_nota($nomor=null) {
        $head =collect(\DB::select("    SELECT c.nama nama_cabang,sj.nomor,sj.tanggal,sj.kode_rute FROM surat_jalan_trayek sj
                                        LEFT JOIN cabang c ON c.kode=sj.kode_cabang  WHERE sj.nomor='$nomor' "))->first();
        $detail =DB::select("   SELECT * FROM surat_jalan_trayek_d d, delivery_order o
                                WHERE o.nomor=d.nomor_do  AND d.nomor_surat_jalan_trayek='$nomor' ");
    
        $rute = DB::select("    SELECT * FROM rute h,rute_d d
                                        WHERE h.kode=d.kode_rute  AND h.kode='$head->kode_rute' ");
        //dd($rute);
        return view('sales.surat_jalan_trayek.print',compact('head','detail','rute'));
    }


}
