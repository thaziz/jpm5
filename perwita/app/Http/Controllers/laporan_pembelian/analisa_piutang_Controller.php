<?php

namespace App\Http\Controllers\laporan_sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class analisa_piutang_Controller extends Controller
{
    public function table_data () {
        $list = DB::table('analisa_piutang')->get();
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
        $data = DB::table('analisa_piutang')->where('kode', $id)->first();
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
            $simpan = DB::table('analisa_piutang')->insert($data);
        }elseif ($crud == 'E') {
            $simpan = DB::table('analisa_piutang')->where('kode', $request->ed_kode_old)->update($data);
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
        $hapus = DB::table('analisa_piutang')->where('kode' ,'=', $id)->delete();
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
        return view('laporan_sales.analisa_piutang.index',compact('customer'));
    }

    public function tampil_analisa_piutang(Request $request) {
        $mulai = $request->mulai;
        $sampai = $request->sampai;
        $customer = $request->customer;
        $sql = "    SELECT i.nomor,i.tanggal,i.jatuh_tempo,i.total_tagihan,
                    (SELECT sum(d.jumlah) FROM penerimaan_penjualan p,penerimaan_penjualan_d d
                    WHERE p.nomor=d.nomor_penerimaan_penjualan AND p.tanggal < '$mulai' AND i.nomor=d.nomor_invoice ) terbayar,
                    total_tagihan-(SELECT sum(d.jumlah) FROM penerimaan_penjualan p,penerimaan_penjualan_d d
                    WHERE p.nomor=d.nomor_penerimaan_penjualan AND p.tanggal < '$mulai' AND i.nomor=d.nomor_invoice ) sisa,
                    '$mulai'-jatuh_tempo usia,
                    CASE WHEN '$mulai'-jatuh_tempo <= 0 THEN 
                        total_tagihan-(SELECT sum(d.jumlah) FROM penerimaan_penjualan p,penerimaan_penjualan_d d
                        WHERE p.nomor=d.nomor_penerimaan_penjualan AND p.tanggal < '$mulai' AND i.nomor=d.nomor_invoice )
                    END blm_jatuh_tempo,
                    CASE WHEN '$mulai'-jatuh_tempo > 0 AND '$mulai'-jatuh_tempo < 31 THEN
                        total_tagihan-(SELECT sum(d.jumlah) FROM penerimaan_penjualan p,penerimaan_penjualan_d d
                        WHERE p.nomor=d.nomor_penerimaan_penjualan AND p.tanggal < '$mulai' AND i.nomor=d.nomor_invoice )
                    END hari_0_30,
                    CASE WHEN '$mulai'-jatuh_tempo > 30 AND '$mulai'-jatuh_tempo < 61 THEN
                        total_tagihan-(SELECT sum(d.jumlah) FROM penerimaan_penjualan p,penerimaan_penjualan_d d
                        WHERE p.nomor=d.nomor_penerimaan_penjualan AND p.tanggal < '$mulai' AND i.nomor=d.nomor_invoice )
                    END hari_31_60,
                    CASE WHEN '$mulai'-jatuh_tempo > 60 AND '$mulai'-jatuh_tempo < 91 THEN
                        total_tagihan-(SELECT sum(d.jumlah) FROM penerimaan_penjualan p,penerimaan_penjualan_d d
                        WHERE p.nomor=d.nomor_penerimaan_penjualan AND p.tanggal < '$mulai' AND i.nomor=d.nomor_invoice )
                    END hari_61_90,
                    CASE WHEN '$mulai'-jatuh_tempo > 90 AND '$mulai'-jatuh_tempo < 111 THEN
                        total_tagihan-(SELECT sum(d.jumlah) FROM penerimaan_penjualan p,penerimaan_penjualan_d d
                        WHERE p.nomor=d.nomor_penerimaan_penjualan AND p.tanggal < '$mulai' AND i.nomor=d.nomor_invoice )
                    END hari_91_120,
                    CASE WHEN '$mulai'-jatuh_tempo > 110 THEN
                        total_tagihan-(SELECT sum(d.jumlah) FROM penerimaan_penjualan p,penerimaan_penjualan_d d
                        WHERE p.nomor=d.nomor_penerimaan_penjualan AND p.tanggal < '$mulai' AND i.nomor=d.nomor_invoice )
                    END hari_diatas_120

                    FROM invoice i WHERE i.tanggal<='$mulai' AND i.kode_customer='$customer' ";

        $list = DB::select(DB::raw($sql));
        $tabel_data = ' <table id="table_data_riwayat_invoice" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td style="width:9%">No Invoice</td>
                                <td style="width:7%">Tanggal</td>
                                <td style="width:7%">Jatuh Tempo</td>
                                <td style="width:7%">Tagihan</td>
                                <td style="width:7%">Terbayar</td>
                                <td style="width:7%">Sisa</td>
                                <td style="width:5%">Usia</td>
                            </tr>
                        </thead>
                        <tbody>
                        ';
        foreach ($list as $row) {
            $tabel_data = $tabel_data.' <tr>
                                            <td>'.$row->nomor.'</td>    
                                            <td>'. $row->tanggal.'</td>
                                            <td>'. $row->jatuh_tempo.'</td>
                                            <td style="text-align:right">'.number_format($row->total_tagihan, 0, ",", ".").' </td>
                                            <td style="text-align:right">'.number_format($row->terbayar, 0, ",", ".").' </td>
                                            <td style="text-align:right">'.number_format($row->sisa, 0, ",", ".").' </td>
                                            <td style="text-align:right">'.number_format($row->usia, 0, ",", ".").' </td>
                                        </tr>';
        };        
        $tabel_data = $tabel_data.'</tbody> </table>';                    
        $result['html']=$tabel_data;
        // $result['invoice']=DB::table('invoice')->where('nomor', $nomor)->first();
        // $result['penerimaan_penjualan_d']=DB::table('penerimaan_penjualan_d')->where('id', $request->id)->first();
        echo json_encode($result);
    }

}
