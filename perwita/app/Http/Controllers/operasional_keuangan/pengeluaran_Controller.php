<?php

namespace App\Http\Controllers\operasional_keuangan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use PDF;


class pengeluaran_Controller extends Controller
{
    public function table_data_detail (Request $request) {
        $nomor = strtoupper($request->input('nomor'));
        $sql = "    SELECT pd.*,a.nama akun_debet FROM pengeluaran_d pd
                    LEFT JOIN akun a ON a.kode=pd.kode_akun_debet  WHERE pd.nomor='$nomor' ";

        $list = DB::select($sql);
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['id'].'" name="'.$data[$i]['akun_debet'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['id'].'" name="'.$data[$i]['akun_debet'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data_detail (Request $request) {
        $id =$request->input('id');
        $data = DB::table('pengeluaran_d')->where('id', $id)->first();
        echo json_encode($data);
    }

    public function jumlah_data_detail (Request $request) {
        $nomor =$request->input('nomor');
        $sql = "SELECT COUNT(id) jumlah FROM pengeluaran_d  WHERE nomor='$nomor' ";
        $data = DB::select($sql);
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $simpan='';
        $crud = $request->crud_h;
        $nomor_old = strtoupper($request->ed_nomor_old);
        $kota_asal = $request->cb_kota_asal;
        $data = array(
                    'nomor' => strtoupper($request->ed_nomor),
                    'tanggal' => $request->ed_tanggal,
                    'kode_akun' => $request->cb_akun,
                    'keterangan' => strtoupper($request->ed_keterangan),
                    'total' => filter_var($request->ed_total, FILTER_SANITIZE_NUMBER_INT),
                );
        
        if ($crud == 'N' and $nomor_old =='') {
            $simpan = DB::table('pengeluaran')->insert($data);
        } else {
            $simpan = DB::table('pengeluaran')->where('nomor', $nomor_old)->update($data);
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

    public function save_data_detail (Request $request) {
        $simpan='';
        $crud = $request->crud;
        $data = array(
                'nomor' => strtoupper($request->ed_nomor_d),
                'kode_akun_kredit' => $request->cb_akun_debet,
                'kode_akun_debet' => $request->ed_kode_akun_kredit,
                'jumlah' => filter_var($request->ed_jumlah, FILTER_SANITIZE_NUMBER_INT),
                'memo' => strtoupper($request->ed_memo),
            );

        if ($crud == 'N') {
            $simpan = DB::table('pengeluaran_d')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('pengeluaran_d')->where('id', $request->ed_id)->update($data);
        }
        $nomor = strtoupper($request->ed_nomor_d);
        $total = DB::select("SELECT  SUM(jumlah) total FROM pengeluaran_d WHERE nomor='$nomor' ");
        if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
            $result['total']=$total;
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
        $nomor = strtoupper($request->nomor);
        $hapus = DB::table('pengeluaran_d')->where('id' ,'=', $id)->delete();
        $jml_detail = DB::select("SELECT COUNT(id) jumlah FROM pengeluaran_d WHERE nomor='$nomor' ");
        $total = DB::select("SELECT  SUM(jumlah) total FROM pengeluaran_d WHERE nomor='$nomor' ");
        if($hapus == TRUE){
            $result['error']='';
            $result['result']=1;
            $result['jml_detail']=$jml_detail;
            $result['total']=$total;
        }else{
            $result['error']=$hapus;
            $result['result']=0;
        }
        echo json_encode($result);
    }

    public function hapus_data($nomor=null){
        DB::beginTransaction();
        DB::table('pengeluaran_d')->where('nomor' ,'=', $nomor)->delete();
        DB::table('pengeluaran')->where('nomor' ,'=', $nomor)->delete();
        DB::commit();
        return redirect('keuangan/pengeluaran');
    }


    public function index(){
        $sql = " SELECT p.*, a.nama akun_kredit FROM pengeluaran p,akun a where p.kode_akun=a.kode ";
        $data =  DB::select($sql);
        return view('operasional_keuangan.pengeluaran.index',compact('data'));
    }

    public function form($nomor=null){
        $akun = DB::select(" SELECT kode,nama FROM akun ");
        $akun_kas_bank = DB::select(" SELECT kode,nama FROM akun WHERE jenis='KAS' or jenis='BANK' ");
        $outlet = DB::select(" SELECT kode,nama FROM agen WHERE kode<>'NON OUTLET' ");
        if ($nomor != null) {
            $data = DB::table('pengeluaran')->where('nomor', $nomor)->first();
            $jml_detail = collect(\DB::select(" SELECT COUNT(id) jumlah FROM pengeluaran_d WHERE nomor='$nomor' "))->first();
        }else{
            $data = null;
            $jml_detail = 0;
        }
        return view('operasional_keuangan.pengeluaran.form',compact('akun','akun_kas_bank', 'outlet', 'data', 'jml_detail' ));
    }
    
    

    
    
    public function cetak_nota($nomor=null) {
        $sql= " SELECT d.*,k.nama asal, kk.nama tujuan, (d.panjang * d.lebar * d.tinggi) dimensi FROM pengeluaran d
                LEFT JOIN kota k ON k.id=d.id_kota_asal
                LEFT JOIN kota kk ON kk.id=d.id_kota_tujuan
                WHERE nomor='$nomor' ";
        $nota =  collect(\DB::select($sql))->first();
        $pdf = PDF::loadView('sales.do.nota',compact('nota'))->setPaper('a4', 'potrait');
    	return $pdf->stream();
    }

    public function cari_customer(Request $request){
        $id =$request->input('kode_customer');
        $data = DB::table('customer')->where('kode', $id)->first();
        return json_encode($data);
    }
}
