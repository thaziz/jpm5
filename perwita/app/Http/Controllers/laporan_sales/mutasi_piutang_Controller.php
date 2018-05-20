<?php

namespace App\Http\Controllers\laporan_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class mutasi_piutang_Controller extends Controller
{
    public function table_data () {
        $list = DB::table('mutasi_piutang')->get();
        $data = array();
        foreach ($list as $r) {
            $data[] = (array) $r;
        }
        $i=0;
        foreach ($data as $key) {
            // add new button
            $data[$i]['button'] = ' <div class="btn-group">
                                        <button type="button" id="'.$data[$i]['kode'].'" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" id="'.$data[$i]['kode'].'" name="'.$data[$i]['nama'].'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div> ';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax);
    }

    public function get_data (Request $request) {
        $id =$request->input('id');
        $data = DB::table('mutasi_piutang')->where('kode', $id)->first();
        echo json_encode($data);
    }

    public function save_data (Request $request) {
        $simpan='';
        $crud = $request->crud;
        $data = array(
                'kode' => strtoupper($request->ed_kode),
                'nama' => strtoupper($request->ed_nama),
                'keterangan' => strtoupper($request->ed_keterangan),
            );
        
        if ($crud == 'N') {
            $simpan = DB::table('mutasi_piutang')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('mutasi_piutang')->where('kode', $request->ed_kode_old)->update($data);
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
        $hapus = DB::table('mutasi_piutang')->where('kode' ,'=', $id)->delete();
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
        $customer = DB::select(" SELECT kode,nama FROM customer ORDER BY nama ASC ");
        return view('laporan_sales.mutasi_piutang.index',compact('customer'));
    }

    public function tampil_mutasi_piutang(Request $request) {
        $mulai = $request->mulai;
        $sampai = $request->sampai;
        $customer = $request->customer;
        $sql = "    SELECT c.kode,c.nama,
                    (select COALESCE(SUM(total_tagihan),0) FROM invoice i WHERE i.kode_customer=c.kode AND i.tanggal < '$mulai' ) saldo_awal,
                    (select COALESCE(SUM(total_tagihan),0) FROM invoice i WHERE i.kode_customer=c.kode AND i.tanggal BETWEEN '$mulai' AND '$sampai' ) debet,
                    (select COALESCE(SUM(d.jumlah),0) FROM penerimaan_penjualan p,penerimaan_penjualan_d d
                    WHERE p.nomor=d.nomor_penerimaan_penjualan AND p.kode_customer=c.kode AND p.tanggal BETWEEN '$mulai' AND '$sampai' ) kredit
                    FROM customer c order by nama ";

        $list = DB::select(DB::raw($sql));
        $tabel_data = ' <table id="table_data_riwayat_invoice" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>Customer</td>
                                <td style="width:10%">Saldo Awal</td>
                                <td style="width:10%">Tambah</td>
                                <td style="width:10%">Kurang</td>
                                <td style="width:10%">Saldo Akhir</td>
                            </tr>
                        </thead>
                        <tbody>
                        ';
        foreach ($list as $row) {
            $tabel_data = $tabel_data.' <tr>
                                            <td>'.$row->nama.'</td>    
                                            <td style="text-align:right">'.number_format($row->saldo_awal, 0, ",", ".").' </td>
                                            <td style="text-align:right">'.number_format($row->debet, 0, ",", ".").' </td>
                                            <td style="text-align:right">'.number_format($row->kredit, 0, ",", ".").' </td>
                                            <td style="text-align:right">'.number_format($row->saldo_awal + $row->debet - $row->kredit, 0, ",", ".").' </td>
                                        </tr>';
        };        
        $tabel_data = $tabel_data.'</tbody> </table>';                    
        $result['html']=$tabel_data;
        // $result['invoice']=DB::table('invoice')->where('nomor', $nomor)->first();
        // $result['penerimaan_penjualan_d']=DB::table('penerimaan_penjualan_d')->where('id', $request->id)->first();
        echo json_encode($result);
    }

}
