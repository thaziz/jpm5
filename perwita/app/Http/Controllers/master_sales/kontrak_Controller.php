<?php

namespace App\Http\Controllers\master_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class kontrak_Controller extends Controller
{
    public function table_data_detail (Request $request) {
        $nomor = strtoupper($request->input('nomor'));
        $sql = "    SELECT d.id, d.id_kota_asal, k.nama asal,d.id_kota_tujuan, kk.nama tujuan, d.harga, d.jenis, d.keterangan, s.nama satuan,
                    d.jenis_tarif,d.kode_angkutan 
                    FROM kontrak_d d
                    LEFT JOIN kota k ON k.id=id_kota_asal 
                    LEFT JOIN satuan s ON s.kode=d.kode_satuan
                    LEFT JOIN kota kk ON kk.id=id_kota_tujuan WHERE d.nomor_kontrak='$nomor' ";
        $list = DB::select(DB::raw($sql));
        //dd($list);
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['id'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['id'].'" name="'.$data[$i]['id'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('nomor');
        $data = DB::table('kontrak')->where('nomor', $id)->first();
        echo json_encode($data);
    }
    
    public function get_data_detail (Request $request) {
        $id =$request->input('id');
        $data = DB::table('kontrak_d')
                ->where([
                            ['id', '=', $id],
                            ['nomor_kontrak', '=', $request->nomor_kontrak],
                        ])
                ->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $simpan='';
        $crud = $request->crud_h;
        $nomor = $request->ed_nomor;
        $nomor_old = $request->ed_nomor_old;
        $data = array(
                'nomor' => strtoupper($request->ed_nomor),
                'tanggal' => strtoupper($request->ed_tanggal),
                'mulai' => strtoupper($request->ed_mulai),
                'akhir' => strtoupper($request->ed_akhir),
                'kode_customer' => strtoupper($request->ed_customer),
                'keterangan' => strtoupper($request->ed_keterangan),
                'kode_cabang' => strtoupper($request->ed_cabang),
                'aktif' => $request->ck_aktif,
            );
        
        if ($crud == 'N' and $nomor_old =='') {
            //auto number
            if ($data['nomor'] ==''){
                $tanggal = strtoupper($request->ed_tanggal);
                $kode_cabang = strtoupper($request->ed_cabang);
                $tanggal = date_create($tanggal);
                $tanggal = date_format($tanggal,'ym');
                $sql = "	SELECT CAST(MAX(SUBSTRING (nomor FROM '....$')) AS INTEGER) + 1 nomor
                            FROM kontrak WHERE to_char(tanggal, 'YYMM')='$tanggal' AND kode_cabang='$kode_cabang'
                            AND nomor LIKE '%KNK".$kode_cabang.$tanggal."%' ";
                $list = collect(\DB::select($sql))->first();
                if ($list->nomor == ''){
                    //$data['nomor']='SJT-'.$kode_cabang.'-'.$tanggal.'-00001';
                    $data['nomor']='KNK'.$kode_cabang.$tanggal.'00001';
                } else{
                    $kode  = substr_replace('00000',$list->nomor,-strlen($list->nomor)); 
                    $data['nomor']='KNK'.$kode_cabang.$tanggal.$kode;
                }
            }
            // end auto number
            $simpan = DB::table('kontrak')->insert($data);
            
        } else {
            $simpan = DB::table('kontrak')->where('nomor', $nomor_old)->update($data);
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

    public function hapus_data($nomor_kontrak=null){
        DB::beginTransaction();
        DB::table('kontrak_d')->where('nomor_kontrak' ,'=', $nomor_kontrak)->delete();
        DB::table('kontrak')->where('nomor' ,'=', $nomor_kontrak)->delete();
        DB::commit();
        return redirect('master_sales/kontrak');
    }
    
    public function save_data_detail (Request $request) {
        $simpan='';
        $crud = $request->crud;
        $id_old=filter_var($request->ed_id_old, FILTER_SANITIZE_NUMBER_INT);
		if($request->cb_kota_asal == ''){
			$kota_asal = NULL;
		}else{
			$kota_asal = $request->cb_kota_asal;
		}
		if($request->cb_kota_tujuan == ''){
			$kota_tujuan = NULL;
		}else{
			$kota_tujuan = $request->cb_kota_tujuan;
		}

        $data = array(
                'nomor_kontrak' => strtoupper($request->ed_nomor_kontrak),
                'id_kota_asal' => $request->cb_kota_asal,
                'id_kota_tujuan' => $request->cb_kota_tujuan,
                'jenis' => $request->cb_jenis,
                'type_tarif' => $request->cb_type_tarif,
                'keterangan' => strtoupper($request->ed_keterangan_d),
                'harga' => filter_var($request->ed_harga, FILTER_SANITIZE_NUMBER_INT),
                'kode_satuan' => strtoupper($request->cb_satuan),
                'kode_angkutan' => strtoupper($request->cb_tipe_angkutan),
                'jenis_tarif' => strtoupper($request->cb_jenis_tarif),
                'acc_penjualan' => strtoupper($request->cb_acc_penjualan),
                'csf_penjualan' => strtoupper($request->cb_csf_penjualan),
            );
        if ($crud == 'N') {
			$id= collect(\DB::select(" SELECT COALESCE(MAX(id),0)+1 id FROM kontrak_d WHERE nomor_kontrak='$request->ed_nomor_kontrak' "))->first();
			$id= $id->id;
			$data['id'] = $id;
			$data['kode'] = strtoupper($request->ed_nomor_kontrak).'-'.$id;
            $simpan = DB::table('kontrak_d')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('kontrak_d')
                        ->where([
                                    ['id', '=', $id_old],
                                    ['nomor_kontrak', '=', $request->ed_nomor_kontrak],
                                ])
                        ->update($data);
        }
        $nomor_kontrak = strtoupper($request->ed_nomor_kontrak);
        $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM kontrak_d WHERE nomor_kontrak='$nomor_kontrak' "))->first();
        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
            $result['jml_detail']=$jml_detail->jumlah;
        }else{
            $result['error']=$data;
            $result['result']=0;
        }
        $result['crud']=$crud;
        echo json_encode($result);
    }
    
    public function hapus_data_detail (Request $request) {
        $hapus='';
        $id=$request->id;
        $hapus = DB::table('kontrak_d')
                    ->where([
                                ['id', '=', $id],
                                ['nomor_kontrak', '=', $request->nomor_kontrak],
                            ])
                    ->delete();
        $nomor_kontrak = strtoupper($request->ed_nomor_kontrak);
        $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM kontrak_d WHERE nomor_kontrak='$nomor_kontrak' "))->first();
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
        $sql = "    SELECT k.*,c.nama FROM kontrak k
                    LEFT JOIN customer c ON c.kode=k.kode_customer ";
        $data =  DB::select($sql);
        return view('master_sales.kontrak.index',compact('data'));
    }
    
    public function form($nomor=null){
        $kota = DB::select(" SELECT id,nama FROM kota ORDER BY nama ASC ");
        $cabang = DB::select(" SELECT kode,nama FROM cabang ORDER BY nama ASC ");
        $customer = DB::select(" SELECT kode,nama FROM customer ORDER BY nama ASC ");
        $satuan = DB::select(" SELECT kode,nama,isi FROM satuan ORDER BY nama ASC ");
        $akun = DB::select(" SELECT id_akun,nama_akun FROM d_akun ORDER BY id_akun ASC");
        $tipe_angkutan = DB::select(" SELECT kode,nama FROM tipe_angkutan ORDER BY nama ASC ");
        if ($nomor != null) {
            $data = DB::table('kontrak')->where('nomor', $nomor)->first();
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM kontrak_d WHERE nomor_kontrak='$nomor' "))->first();
        }else{
            $data = null;
            $jml_detail = 0;
        }
        return view('master_sales.kontrak.form',compact('kota','customer','data','cabang','jml_detail','satuan','tipe_angkutan','akun' ));
    }

}
